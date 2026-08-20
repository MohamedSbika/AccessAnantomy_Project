"""
Minimal pure-Python MySQL/MariaDB client -- just enough of the wire protocol to
run the Arabic migration on a box with no pip and no driver installed.

Supports: handshake v10, mysql_native_password auth, COM_QUERY, result sets,
OK/ERR packets, and a DB-API-ish cursor with %s parameter substitution.
Not general purpose -- no prepared statements, no TLS, no compression.
"""

import hashlib
import socket
import struct

# capability flags
LONG_PASSWORD, LONG_FLAG, CONNECT_WITH_DB = 1, 4, 8
PROTOCOL_41, TRANSACTIONS = 512, 8192
SECURE_CONNECTION, PLUGIN_AUTH = 32768, 1 << 19

INT_TYPES = {1, 2, 3, 8, 9, 13, 16}
FLOAT_TYPES = {4, 5, 246}


class MySQLError(Exception):
    pass


def _lenenc_int(buf, i):
    b = buf[i]
    if b < 0xFB:
        return b, i + 1
    if b == 0xFC:
        return struct.unpack_from("<H", buf, i + 1)[0], i + 3
    if b == 0xFD:
        return int.from_bytes(buf[i + 1:i + 4], "little"), i + 4
    if b == 0xFE:
        return struct.unpack_from("<Q", buf, i + 1)[0], i + 9
    return None, i + 1          # 0xFB = NULL


def _lenenc_str(buf, i):
    if buf[i] == 0xFB:
        return None, i + 1
    n, i = _lenenc_int(buf, i)
    return buf[i:i + n], i + n


def _native_password(password, salt):
    if not password:
        return b""
    p = password.encode("utf-8")
    s1 = hashlib.sha1(p).digest()
    s2 = hashlib.sha1(s1).digest()
    s3 = hashlib.sha1(salt + s2).digest()
    return bytes(a ^ b for a, b in zip(s1, s3))


def _escape(v):
    if v is None:
        return "NULL"
    if isinstance(v, bool):
        return "1" if v else "0"
    if isinstance(v, (int, float)):
        return str(v)
    if isinstance(v, (bytes, bytearray)):
        v = v.decode("utf-8", "replace")
    out = []
    for ch in str(v):
        if ch == "\0":   out.append("\\0")
        elif ch == "\n": out.append("\\n")
        elif ch == "\r": out.append("\\r")
        elif ch == "\\": out.append("\\\\")
        elif ch == "'":  out.append("\\'")
        elif ch == '"':  out.append('\\"')
        elif ch == "\x1a": out.append("\\Z")
        else: out.append(ch)
    return "'" + "".join(out) + "'"


class Connection:
    def __init__(self, host, port, user, password, database):
        self.sock = socket.create_connection((host, port), timeout=600)
        self.sock.settimeout(600)
        self._buf = b""
        self._seq = 0
        self._handshake(user, password, database)
        self.query("SET NAMES utf8mb4")
        self.query("SET autocommit=0")

    # ---- packet plumbing
    def _recv(self, n):
        while len(self._buf) < n:
            chunk = self.sock.recv(65536)
            if not chunk:
                raise MySQLError("server closed connection")
            self._buf += chunk
        out, self._buf = self._buf[:n], self._buf[n:]
        return out

    def _read_packet(self):
        head = self._recv(4)
        ln = int.from_bytes(head[:3], "little")
        self._seq = head[3]
        return self._recv(ln)

    def _send_packet(self, payload):
        self._seq = (self._seq + 1) & 0xFF
        self.sock.sendall(len(payload).to_bytes(3, "little")
                          + bytes([self._seq]) + payload)

    @staticmethod
    def _check_err(pkt):
        if pkt[:1] == b"\xff":
            code = struct.unpack_from("<H", pkt, 1)[0]
            msg = pkt[9:].decode("utf-8", "replace")
            raise MySQLError(f"[{code}] {msg}")

    # ---- connect
    def _handshake(self, user, password, database):
        pkt = self._read_packet()
        self._check_err(pkt)
        i = 1
        i = pkt.index(b"\0", i) + 1                 # server version
        i += 4                                       # connection id
        salt = pkt[i:i + 8]; i += 8 + 1
        i += 2 + 1 + 2 + 2                           # caps low, charset, status, caps high
        alen = pkt[i]; i += 1
        i += 10
        if alen:
            extra = max(13, alen - 8)
            salt += pkt[i:i + extra - 1]
            i += extra
        plugin = b"mysql_native_password"
        if i < len(pkt):
            end = pkt.find(b"\0", i)
            plugin = pkt[i:end if end != -1 else len(pkt)]
        if plugin not in (b"mysql_native_password", b""):
            raise MySQLError(f"unsupported auth plugin: {plugin!r}")

        caps = (LONG_PASSWORD | LONG_FLAG | PROTOCOL_41 | TRANSACTIONS
                | SECURE_CONNECTION | PLUGIN_AUTH)
        if database:
            caps |= CONNECT_WITH_DB
        auth = _native_password(password, salt[:20])
        body = struct.pack("<IIB", caps, 16 * 1024 * 1024, 45) + b"\0" * 23
        body += user.encode() + b"\0"
        body += bytes([len(auth)]) + auth
        if database:
            body += database.encode() + b"\0"
        body += b"mysql_native_password\0"
        self._send_packet(body)
        resp = self._read_packet()
        self._check_err(resp)

    # ---- query
    def query(self, sql):
        self._seq = -1 & 0xFF
        self._seq = 0xFF
        self._seq = 0                      # COM_QUERY always restarts at seq 0
        self.sock.sendall(
            (len(sql.encode("utf-8")) + 1).to_bytes(3, "little") + b"\x00"
            + b"\x03" + sql.encode("utf-8"))
        pkt = self._read_packet()
        self._check_err(pkt)
        if pkt[:1] == b"\x00" or pkt[:1] == b"\xfe":
            affected, i = _lenenc_int(pkt, 1)
            return {"rows": [], "affected": affected or 0,
                    "insert_id": _lenenc_int(pkt, i)[0] or 0}
        ncols, _ = _lenenc_int(pkt, 0)
        types = []
        for _ in range(ncols):
            cd = self._read_packet()
            j = 0
            for _f in range(6):        # catalog, schema, table, org_table, name, org_name
                _, j = _lenenc_str(cd, j)
            _, j = _lenenc_int(cd, j)               # length of fixed fields
            j += 2                                   # charset
            j += 4                                   # column length
            types.append(cd[j])
        eof = self._read_packet()
        self._check_err(eof)
        rows = []
        while True:
            rp = self._read_packet()
            if rp[:1] == b"\xfe" and len(rp) < 9:
                break
            self._check_err(rp)
            vals, j = [], 0
            for t in types:
                raw, j = _lenenc_str(rp, j)
                if raw is None:
                    vals.append(None)
                elif t in INT_TYPES:
                    vals.append(int(raw))
                elif t in FLOAT_TYPES:
                    vals.append(float(raw))
                else:
                    vals.append(raw.decode("utf-8", "replace"))
            rows.append(tuple(vals))
        return {"rows": rows, "affected": len(rows), "insert_id": 0}

    def cursor(self):
        return Cursor(self)

    def commit(self):
        self.query("COMMIT")

    def rollback(self):
        self.query("ROLLBACK")

    def close(self):
        try:
            self.sock.close()
        except Exception:
            pass


class Cursor:
    def __init__(self, conn):
        self.conn = conn
        self._rows = []
        self.rowcount = 0
        self.lastrowid = 0

    @staticmethod
    def _render(sql, args):
        if not args:
            return sql
        out, ai = [], 0
        i = 0
        while i < len(sql):
            if sql[i:i + 2] == "%s":
                out.append(_escape(args[ai])); ai += 1; i += 2
            else:
                out.append(sql[i]); i += 1
        if ai != len(args):
            raise MySQLError(f"parameter count mismatch: {ai} placeholders, {len(args)} args")
        return "".join(out)

    def execute(self, sql, args=()):
        res = self.conn.query(self._render(sql, tuple(args or ())))
        self._rows = res["rows"]
        self.rowcount = res["affected"]
        self.lastrowid = res["insert_id"]
        return self.rowcount

    def executemany(self, sql, seq):
        n = 0
        for a in seq:
            n += self.execute(sql, a)
        self.rowcount = n
        return n

    def fetchall(self):
        return self._rows


def connect(host="127.0.0.1", port=3306, user="root", password="", database=""):
    return Connection(host, port, user, password, database)
