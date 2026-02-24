#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
╔══════════════════════════════════════════════════════════════════╗
║  SCRIPT 2/3 : TRADUCTION DES MÉTADONNÉES                        ║
║  Traduit chaque métadonnée via ChatGPT → JSON enrichi            ║
╚══════════════════════════════════════════════════════════════════╝

Entrée  : fichier JSON (sortie du script 1)
Sortie  : fichier JSON enrichi avec les traductions
          + fichier rapport d'erreurs si anomalies

Usage :
    python step2_translate.py metadata.json -l EN
    python step2_translate.py metadata.json -l ES -o translated.json
"""

import os
import re
import sys
import json
import time
import datetime
import argparse

try:
    from docx import Document
except ImportError:
    pass 

from pathlib import Path
from typing import List, Tuple

try:
    from openai import OpenAI
except ImportError as e:
    print(f"[ERROR] Failed to import openai: {e}", flush=True)
    sys.exit(1)
except Exception as e:
    print(f"[ERROR] Unexpected error importing openai: {e}", flush=True)
    sys.exit(1)


# ============================================================================
# CONFIGURATION
# ============================================================================

API_KEY = "VOTRE_CLE_API_ICI"  # ← Remplacez par votre clé API ChatGPT

MODEL = "gpt-4o"

MAX_RETRIES = 3
RETRY_DELAY = 2
LENGTH_RATIO_MIN = 0.10
API_DELAY = 0.3

SUPPORTED_LANGUAGES = {
    "EN": {
        "name": "English",
        "instruction": "Translate the following French medical text into English."
    },
    "ES": {
        "name": "Spanish (Español)",
        "instruction": "Translate the following French medical text into Spanish (Español)."
    }
}

SYSTEM_PROMPT = """Tu es un moteur de traduction médicale stricte.

RÈGLES ABSOLUES :
1. Tu dois traduire le texte fourni sans résumer, sans reformuler, sans améliorer le style, sans supprimer, sans ajouter.
2. Tu dois traduire 100 % du texte, ligne par ligne, sans omission.
3. Tu dois conserver exactement la structure du texte, y compris les retours à la ligne.
4. La traduction est fidèle, pas adaptative.
5. Le style Sujet-Verbe-Complément (SVC) doit être respecté implicitement.
6. Aucun enrichissement terminologique.
7. Aucun raccourcissement de phrase.
8. Aucun changement d'ordre logique.
9. Aucun tiret entre les mots. Aucune forme stylistique.
10. Si une partie du texte ne peut pas être traduite, tu dois la laisser telle quelle et ajouter immédiatement le tag [UNTRANSLATED].

FORMAT DE RÉPONSE :
- Contenir UNIQUEMENT la traduction.
- Conserver exactement le nombre de lignes.
- Ne contenir aucun commentaire.
- Ne contenir aucune explication.
- Ne pas ajouter de guillemets autour de la traduction.
- Ne pas ajouter de préfixe comme "Translation:" ou "Traduction:".
- Ne pas répéter l'identifiant [ID: ...] dans ta réponse.
"""


# ============================================================================
# CLASSE : Moteur de traduction
# ============================================================================

class TranslationEngine:
    """
    Traduit chaque métadonnée via l'API ChatGPT.
    1 appel API par métadonnée atomique.
    Contrôles post-traduction : longueur, structure, [UNTRANSLATED].
    """

    def __init__(self, api_key: str, target_lang: str):
        try:
            from openai import OpenAI
        except Exception as e:
            print(f"[ERROR] Critical: Failed to import openai module: {e}", flush=True)
            sys.exit(1)

        self.client = OpenAI(api_key=api_key)
        self.target_lang = target_lang
        self.lang_config = SUPPORTED_LANGUAGES[target_lang]
        self.stats = {
            "total": 0,
            "success": 0,
            "rejected": 0,
            "errors": 0,
            "empty": 0,
            "skipped_symbols": 0,
            "api_calls": 0,
            "untranslated_retries": 0,
        }
        self.failed_metadata: List[dict] = []
        self.log_lines: List[str] = []

    def _log(self, level: str, message: str, meta_id: str = ""):
        timestamp = datetime.datetime.now().strftime("%H:%M:%S.%f")[:-3]
        prefix = f"[{timestamp}] [{level}]"
        if meta_id:
            prefix += f" [{meta_id}]"
        self.log_lines.append(f"{prefix} {message}")

    def translate(self, meta_id: str, source_text: str) -> Tuple[str, str]:
        """
        Traduit une métadonnée atomique.
        Returns: (translated_text, status)
            status: SUCCESS, REJECTED, ERROR, EMPTY
        """
        self.stats["total"] += 1

        if not source_text.strip():
            self.stats["empty"] += 1
            self._log("INFO", "Métadonnée vide, ignorée.", meta_id)
            return source_text, "EMPTY"

        # --- Contrôle symboles/ponctuations ---
        # Si le texte ne contient que des symboles, ponctuations ou espaces,
        # on le garde tel quel sans appel API (universel, pas besoin de traduction)
        if self._is_symbol_only(source_text):
            self.stats["skipped_symbols"] += 1
            self._log("INFO",
                f"Symbole/ponctuation détecté, conservé tel quel : '{source_text}'",
                meta_id
            )
            return source_text, "SUCCESS"

        source_lines = source_text.count("\n")
        source_word_count = len(source_text.split())

        for attempt in range(1, MAX_RETRIES + 1):
            try:
                self._log("INFO",
                    f"Tentative {attempt}/{MAX_RETRIES} | "
                    f"Source: {source_word_count} mots, {source_lines} newlines",
                    meta_id
                )

                translated = self._call_api(source_text, meta_id)
                self.stats["api_calls"] += 1

                # --- Nettoyage du tag [ID: ...] renvoyé par erreur ---
                translated = self._clean_response(translated, meta_id)

                # --- Contrôle [UNTRANSLATED] ---
                if "[UNTRANSLATED]" in translated:
                    self.stats["untranslated_retries"] += 1
                    self._log("WARN", "Tag [UNTRANSLATED] détecté, renvoi.", meta_id)
                    if attempt < MAX_RETRIES:
                        time.sleep(RETRY_DELAY)
                        continue
                    else:
                        self.stats["errors"] += 1
                        self._log("ERROR",
                            f"[UNTRANSLATED] persistant après {MAX_RETRIES} tentatives.",
                            meta_id
                        )
                        self.failed_metadata.append({
                            "metadata_id": meta_id,
                            "source_text": source_text,
                            "problem": f"Tag [UNTRANSLATED] persistant après {MAX_RETRIES} tentatives",
                            "status": "ERROR",
                            "last_translation_attempt": translated,
                        })
                        return f"[REF: {meta_id}]", "ERROR"

                # --- Contrôle de longueur (nombre de mots) ---
                translated_word_count = len(translated.split())
                ratio = translated_word_count / source_word_count if source_word_count > 0 else 1
                if ratio < LENGTH_RATIO_MIN:
                    self._log("WARN",
                        f"REJET mots : ratio={ratio:.2f} "
                        f"(source={source_word_count} mots, trad={translated_word_count} mots)",
                        meta_id
                    )
                    if attempt < MAX_RETRIES:
                        time.sleep(RETRY_DELAY)
                        continue
                    else:
                        self.stats["rejected"] += 1
                        self._log("ERROR",
                            f"REJET DÉFINITIF mots après {MAX_RETRIES} tentatives.",
                            meta_id
                        )
                        self.failed_metadata.append({
                            "metadata_id": meta_id,
                            "source_text": source_text,
                            "problem": (
                                f"REJET NOMBRE DE MOTS : ratio={ratio:.2f} "
                                f"(source={source_word_count} mots, traduction={translated_word_count} mots, "
                                f"minimum={LENGTH_RATIO_MIN})"
                            ),
                            "status": "REJECTED",
                            "last_translation_attempt": translated,
                        })
                        return f"[REF: {meta_id}]", "REJECTED"

                # --- Contrôle structurel ---
                translated_lines = translated.count("\n")
                if translated_lines != source_lines:
                    self._log("WARN",
                        f"REJET structure : source={source_lines} \\n, "
                        f"trad={translated_lines} \\n",
                        meta_id
                    )
                    if attempt < MAX_RETRIES:
                        time.sleep(RETRY_DELAY)
                        continue
                    else:
                        self.stats["rejected"] += 1
                        self._log("ERROR",
                            f"REJET DÉFINITIF structure après {MAX_RETRIES} tentatives.",
                            meta_id
                        )
                        self.failed_metadata.append({
                            "metadata_id": meta_id,
                            "source_text": source_text,
                            "problem": (
                                f"REJET STRUCTURE : source={source_lines} retours "
                                f"à la ligne, traduction={translated_lines} retours à la ligne"
                            ),
                            "status": "REJECTED",
                            "last_translation_attempt": translated,
                        })
                        return f"[REF: {meta_id}]", "REJECTED"

                # --- Succès ---
                self.stats["success"] += 1
                self._log("OK",
                    f"Traduction OK | mots: {source_word_count}→{translated_word_count} "
                    f"(ratio={ratio:.2f}) | '{translated[:60]}...'",
                    meta_id
                )
                return translated, "SUCCESS"

            except Exception as e:
                self.stats["api_calls"] += 1
                self._log("ERROR", f"Erreur API tentative {attempt}: {str(e)}", meta_id)
                if attempt < MAX_RETRIES:
                    time.sleep(RETRY_DELAY * attempt)
                else:
                    self.stats["errors"] += 1
                    self.failed_metadata.append({
                        "metadata_id": meta_id,
                        "source_text": source_text,
                        "problem": f"ERREUR API : {str(e)}",
                        "status": "ERROR",
                        "last_translation_attempt": "",
                    })
                    return f"[REF: {meta_id}]", "ERROR"

        return f"[REF: {meta_id}]", "ERROR"

    def _is_symbol_only(self, text: str) -> bool:
        """
        Vérifie si le texte ne contient que des symboles, ponctuations ou espaces.
        Ces caractères sont universels et n'ont pas besoin de traduction.

        Couvre :
        - Ponctuations classiques : . , : ; ! ? - — – ( ) [ ] { } / \\ ' "
        - Symboles spéciaux : ♦ ♣ ♠ ♥ ● ○ ■ □ ▪ ▫ ► ◄ ★ ☆ → ← ↑ ↓ © ® ™
        - Symboles mathématiques : + = < > ± × ÷ % # @ & * ^ ~ | §
        - Espaces et retours à la ligne
        - Chiffres seuls (numéros de page, indices, etc.)
        - Caractères bullet/tirets : • – — ‐ ‑ ‒
        """
        stripped = text.strip()
        if not stripped:
            return True

        for char in stripped:
            if char.isalpha():
                return False

        return True

    def _call_api(self, source_text: str, meta_id: str) -> str:
        """Appel à l'API ChatGPT pour une seule métadonnée."""
        user_prompt = (
            f"{self.lang_config['instruction']}\n\n"
            f"[ID: {meta_id}]\n\n"
            f"{source_text}"
        )

        response = self.client.chat.completions.create(
            model=MODEL,
            temperature=0.1,
            top_p=0.95,
            messages=[
                {"role": "system", "content": SYSTEM_PROMPT},
                {"role": "user", "content": user_prompt}
            ]
        )

        result = response.choices[0].message.content.strip()
        time.sleep(API_DELAY)
        return result

    def _clean_response(self, text: str, meta_id: str) -> str:
        """
        Nettoie la réponse de ChatGPT :
        - Supprime le tag [ID: xxx] si renvoyé par erreur
        - Supprime les préfixes "Translation:", "Traduction:", "Traducción:"
        - Supprime les guillemets englobants
        - Supprime les lignes vides en tête résultant du nettoyage
        """
        # 1) Supprimer le tag [ID: ...] (peut être sur sa propre ligne)
        text = re.sub(r'\[ID:\s*[^\]]*\]\s*', '', text)

        # 2) Supprimer les préfixes courants
        for prefix in ["Translation:", "Traduction:", "Traducción:"]:
            if text.startswith(prefix):
                text = text[len(prefix):]

        # 3) Supprimer les lignes vides en tête (résultant du nettoyage)
        text = text.lstrip('\n')

        # 4) Strip global
        text = text.strip()

        # 5) Retirer guillemets englobants
        if len(text) >= 2:
            if (text[0] == '"' and text[-1] == '"') or \
               (text[0] == "'" and text[-1] == "'"):
                text = text[1:-1]

        return text


# ============================================================================
# FONCTIONS DE TRAITEMENT
# ============================================================================

def collect_translatable_metadata(data: dict) -> List[dict]:
    """Collecte toutes les métadonnées traductibles depuis la structure JSON."""
    items = []

    def _walk(elements):
        for item in elements:
            if item.get("type") == "paragraph":
                for group in item.get("metadata_groups", []):
                    if group.get("is_translatable") and group.get("metadata_id"):
                        items.append({
                            "id": group["metadata_id"],
                            "text": group["source_text"]
                        })
            elif item.get("type") == "table":
                for row in item.get("rows", []):
                    for cell in row.get("cells", []):
                        for para in cell.get("paragraphs", []):
                            for group in para.get("metadata_groups", []):
                                if group.get("is_translatable") and group.get("metadata_id"):
                                    items.append({
                                        "id": group["metadata_id"],
                                        "text": group["source_text"]
                                    })

    _walk(data["structure"])
    return items


def inject_translations(data: dict, translations: dict, statuses: dict) -> dict:
    """
    Injecte les traductions et statuts dans la structure JSON.
    Ajoute translated_text et translation_status à chaque metadata_group.
    """
    def _walk(elements):
        for item in elements:
            if item.get("type") == "paragraph":
                for group in item.get("metadata_groups", []):
                    mid = group.get("metadata_id")
                    if mid and mid in translations:
                        group["translated_text"] = translations[mid]
                        group["translation_status"] = statuses.get(mid, "UNKNOWN")
                    else:
                        group["translated_text"] = group.get("source_text", "")
                        group["translation_status"] = "SKIPPED"
            elif item.get("type") == "table":
                for row in item.get("rows", []):
                    for cell in row.get("cells", []):
                        for para in cell.get("paragraphs", []):
                            for group in para.get("metadata_groups", []):
                                mid = group.get("metadata_id")
                                if mid and mid in translations:
                                    group["translated_text"] = translations[mid]
                                    group["translation_status"] = statuses.get(mid, "UNKNOWN")
                                else:
                                    group["translated_text"] = group.get("source_text", "")
                                    group["translation_status"] = "SKIPPED"

    _walk(data["structure"])
    return data


def generate_error_report(report_path: str, failed: List[dict], source_file: str, target_lang: str):
    """Génère le rapport d'erreurs détaillé pour traitement manuel."""
    with open(report_path, "w", encoding="utf-8") as f:
        f.write("=" * 80 + "\n")
        f.write("  RAPPORT D'ERREURS DE TRADUCTION\n")
        f.write("  Pour traitement manuel\n")
        f.write("=" * 80 + "\n")
        f.write(f"  Date          : {datetime.datetime.now().strftime('%Y-%m-%d %H:%M:%S')}\n")
        f.write(f"  Fichier source: {source_file}\n")
        f.write(f"  Langue cible  : {target_lang} ({SUPPORTED_LANGUAGES[target_lang]['name']})\n")
        f.write(f"  Total erreurs : {len(failed)}\n")
        f.write("=" * 80 + "\n\n")

        f.write("INSTRUCTIONS :\n")
        f.write("-" * 40 + "\n")
        f.write("Dans le fichier Word traduit (script 3), chaque métadonnée\n")
        f.write("non traduite sera remplacée par sa référence :\n")
        f.write("  [REF: NomFichier_XXXX]\n\n")
        f.write("Pour corriger manuellement :\n")
        f.write("  1. Ouvrez le JSON traduit\n")
        f.write("  2. Cherchez les metadata_id listés ci-dessous\n")
        f.write("  3. Remplacez translated_text par votre traduction\n")
        f.write("  4. Changez translation_status en SUCCESS\n")
        f.write("  5. Relancez le script 3 pour reconstruire le Word\n")
        f.write("-" * 40 + "\n\n")

        for i, meta in enumerate(failed, 1):
            f.write(f"{'─' * 80}\n")
            f.write(f"  ANOMALIE {i}/{len(failed)}\n")
            f.write(f"{'─' * 80}\n")
            f.write(f"  Référence  : {meta['metadata_id']}\n")
            f.write(f"  Marqueur   : [REF: {meta['metadata_id']}]\n")
            f.write(f"  Statut     : {meta['status']}\n")
            f.write(f"  Problème   : {meta['problem']}\n\n")
            f.write(f"  CONTENU FRANÇAIS (à traduire manuellement) :\n")
            f.write(f"  {'.' * 40}\n")
            for line in meta["source_text"].splitlines():
                f.write(f"  | {line}\n")
            f.write(f"  {'.' * 40}\n")

            if meta.get("last_translation_attempt"):
                f.write(f"\n  DERNIÈRE TENTATIVE DE TRADUCTION (rejetée) :\n")
                f.write(f"  {'.' * 40}\n")
                for line in meta["last_translation_attempt"].splitlines():
                    f.write(f"  | {line}\n")
                f.write(f"  {'.' * 40}\n")
            f.write("\n\n")

        f.write("=" * 80 + "\n")
        f.write("  FIN DU RAPPORT\n")
        f.write("=" * 80 + "\n")


# ============================================================================
# POINT D'ENTRÉE
# ============================================================================

def main():
    parser = argparse.ArgumentParser(
        description="[ÉTAPE 2/3] Traduction des métadonnées via ChatGPT",
        formatter_class=argparse.RawDescriptionHelpFormatter,
        epilog="""
Exemples :
  python step2_translate.py metadata.json -l EN
  python step2_translate.py metadata.json -l ES -o translated_es.json
  python step2_translate.py metadata.json -l EN --api-key sk-xxx
        """
    )

    parser.add_argument("input", help="Fichier JSON (sortie du script 1)")
    parser.add_argument("-l", "--lang", required=True, choices=["EN", "ES"],
                        help="Langue cible")
    parser.add_argument("-o", "--output", help="Fichier JSON de sortie")
    parser.add_argument("--api-key", help="Clé API ChatGPT")
    parser.add_argument("--log-file", help="Fichier log pour la progression (écriture directe)")

    args = parser.parse_args()

    # Rediriger stdout vers le fichier log si fourni
    # Cela évite les problèmes de pipes PHP sur Windows
    if args.log_file:
        import io
        log_handle = io.open(args.log_file, 'a', encoding='utf-8', buffering=1)  # line-buffered
        sys.stdout = log_handle

    if not os.path.exists(args.input):
        print(f"❌ Fichier introuvable : {args.input}")
        sys.exit(1)

    # Charger le JSON
    with open(args.input, "r", encoding="utf-8") as f:
        data = json.load(f)

    source_file = data.get("_metadata", {}).get("source_file", args.input)
    input_path = Path(args.input).resolve()
    # Supprimer le suffixe _meta ou _metadata pour obtenir le stem de base
    stem_name = input_path.stem
    for suffix in ("_metadata", "_meta"):
        if stem_name.endswith(suffix):
            stem_name = stem_name[:-len(suffix)]
            break
    # Sauvegarder dans le même dossier que le fichier d'entrée
    output_dir = input_path.parent
    output_path = args.output or str(output_dir / f"{stem_name}_translated_{args.lang}.json")
    stem = str(output_dir / stem_name)  # pour le rapport d'erreurs

    # Clé API
    key = args.api_key or API_KEY
    if key == "VOTRE_CLE_API_ICI":
        print("\n⚠️  ERREUR : Vous devez fournir votre clé API ChatGPT.")
        print("   Option 1 : Modifiez API_KEY dans step2_translate.py")
        print("   Option 2 : Utilisez --api-key sk-votre-cle")
        sys.exit(1)

    print(f"\n{'='*60}")
    print(f"  ÉTAPE 2/3 : TRADUCTION VIA CHATGPT ({MODEL})")
    print(f"  Source JSON : {args.input}")
    print(f"  Langue      : FR → {args.lang}")
    print(f"{'='*60}\n")

    # Collecter les métadonnées à traduire
    to_translate = collect_translatable_metadata(data)
    print(f"  Métadonnées à traduire : {len(to_translate)}\n")

    total = len(to_translate)
    print(f"Items to translate: {total}", flush=True)

    if total == 0:
        print("Rien à traduire.", flush=True)
        # On sauvegarde quand même une structure vide/identique
        # Note: The original code does not define `save_translation` or `stats` here.
        #       Assuming this block is for a specific use case not fully present in the provided context.
        #       For now, we'll just exit if nothing to translate.
        # save_translation(data, args.output, {}, stats) # This line is commented out as it would cause an error
        return

    # Signaler 0% immédiatement pour que l'UI réagisse
    print(f"[PROGRESS] 0/{total}", flush=True)
    sys.stdout.flush()

    # Traduire
    engine = TranslationEngine(key, args.lang)
    translations = {}
    statuses = {}

    for i, meta in enumerate(to_translate):
        current = i + 1
        # total = len(to_translate) # total is already defined outside the loop
        progress_pct = current / total * 100
        
        # Standardized progress output for PHP parsing
        print(f"[PROGRESS] {current}/{total}", flush=True)
        sys.stdout.flush()

        translated_text, status = engine.translate(meta["id"], meta["text"])
        translations[meta["id"]] = translated_text
        statuses[meta["id"]] = status

    print(f"\n\n  ✅ Traduction terminée\n")

    # Injecter les traductions dans la structure
    data = inject_translations(data, translations, statuses)

    # Mettre à jour les métadonnées du JSON
    data["_metadata"]["translation_date"] = datetime.datetime.now().isoformat()
    data["_metadata"]["target_language"] = args.lang
    data["_metadata"]["target_language_name"] = SUPPORTED_LANGUAGES[args.lang]["name"]
    data["_metadata"]["model"] = MODEL
    data["_metadata"]["translation_stats"] = engine.stats
    data["_metadata"]["failed_metadata"] = engine.failed_metadata
    data["translation_log"] = engine.log_lines

    # Sauvegarder le JSON traduit
    with open(output_path, "w", encoding="utf-8") as f:
        json.dump(data, f, ensure_ascii=False, indent=2)

    # Rapport d'erreurs
    error_report_path = None
    if engine.failed_metadata:
        timestamp = datetime.datetime.now().strftime("%Y%m%d_%H%M%S")
        error_report_path = f"{stem}_{args.lang}_ERREURS_{timestamp}.txt"
        generate_error_report(error_report_path, engine.failed_metadata, source_file, args.lang)

    # Résumé
    stats = engine.stats
    print(f"{'='*60}")
    print(f"  RÉSUMÉ")
    print(f"{'='*60}")
    print(f"  Métadonnées totales    : {stats['total']}")
    print(f"  Traductions réussies   : {stats['success']}")
    print(f"  Symboles conservés     : {stats['skipped_symbols']}")
    print(f"  Rejetées               : {stats['rejected']}")
    print(f"  Erreurs                : {stats['errors']}")
    print(f"  Vides (ignorées)       : {stats['empty']}")
    print(f"  Appels API             : {stats['api_calls']}")
    print(f"  JSON traduit           : {output_path}")
    if error_report_path:
        print(f"  Rapport erreurs        : {error_report_path}")
        print(f"")
        print(f"  ⚠️  {len(engine.failed_metadata)} métadonnée(s) non traduite(s).")
        print(f"  Vous pouvez corriger manuellement dans le JSON traduit")
        print(f"  puis relancer le script 3.")
    print(f"{'='*60}")
    print(f"\n  → Prochaine étape : python step3_rebuild.py {output_path} -s {source_file}\n")


if __name__ == "__main__":
    main()
