#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
╔══════════════════════════════════════════════════════════════════╗
║  SCRIPT 1/3 : EXTRACTION DES MÉTADONNÉES                        ║
║  Découpe un fichier Word en métadonnées atomiques → JSON         ║
╚══════════════════════════════════════════════════════════════════╝

Entrée  : fichier Word (.docx) en français
Sortie  : fichier JSON contenant la structure complète du document
          avec chaque métadonnée (id, texte FR, style détaillé)

Usage :
    python step1_extract.py document.docx
    python step1_extract.py document.docx -o metadata.json
"""

import os
import sys
import json
import datetime
import argparse
from pathlib import Path
from typing import List

from docx import Document
from docx.shared import Pt, RGBColor
from docx.oxml.ns import qn


# ============================================================================
# CLASSE : Extracteur de métadonnées depuis un document Word
# ============================================================================

class MetadataExtractor:
    """
    Extrait les métadonnées atomiques depuis un fichier .docx.

    Règles de découpage :
    - Chaque paragraphe est une unité potentielle.
    - Si un paragraphe contient des runs avec des styles différents,
      chaque groupe de runs avec le même style = une métadonnée séparée.
    - Les paragraphes vides sont conservés pour la reconstruction.
    - Les valeurs de style sont sérialisées en format JSON-compatible
      (les EMU/Pt sont convertis en entiers, les enums en int).
    """

    def __init__(self, file_path: str):
        self.file_path = file_path
        self.file_name = Path(file_path).stem
        self.document = None
        self.counter = 0
        self.log_lines: List[str] = []

    def _log(self, message: str, meta_id: str = ""):
        prefix = f"[{meta_id}] " if meta_id else ""
        self.log_lines.append(f"{prefix}{message}")

    def _generate_id(self) -> str:
        self.counter += 1
        return f"{self.file_name}_{self.counter:04d}"

    # ------------------------------------------------------------------
    # Extraction de style (sérialisable JSON)
    # ------------------------------------------------------------------

    def _extract_run_style(self, run) -> dict:
        """Extrait les propriétés de style d'un run en format JSON-safe."""
        style = {
            "bold": run.bold,
            "italic": run.italic,
            "underline": True if run.underline else False,
            "font_name": None,
            "font_size": None,
            "font_color_rgb": None,
            "strike": run.font.strike,
            "superscript": run.font.superscript,
            "subscript": run.font.subscript,
            "highlight_color": int(run.font.highlight_color) if run.font.highlight_color else None,
        }

        if run.font.name:
            style["font_name"] = run.font.name
        if run.font.size:
            style["font_size"] = int(run.font.size)  # EMU → int pour JSON
        if run.font.color and run.font.color.rgb:
            style["font_color_rgb"] = str(run.font.color.rgb)

        # Capturer le XML brut du rPr pour reconstruction fidèle (script 3)
        rpr = run._element.find(qn('w:rPr'))
        if rpr is not None:
            from lxml import etree
            style["_xml_rpr"] = etree.tostring(rpr, encoding="unicode")
        else:
            style["_xml_rpr"] = None

        return style

    def _extract_paragraph_style(self, paragraph) -> dict:
        """Extrait les propriétés de style d'un paragraphe en format JSON-safe."""
        pstyle = {
            "alignment": int(paragraph.alignment) if paragraph.alignment is not None else None,
            "style_name": paragraph.style.name if paragraph.style else None,
            "space_before": None,
            "space_after": None,
            "line_spacing": None,
            "left_indent": None,
            "right_indent": None,
            "first_line_indent": None,
        }

        pf = paragraph.paragraph_format
        if pf.space_before:
            pstyle["space_before"] = int(pf.space_before)
        if pf.space_after:
            pstyle["space_after"] = int(pf.space_after)
        if pf.line_spacing:
            pstyle["line_spacing"] = float(pf.line_spacing) if isinstance(pf.line_spacing, (int, float)) else int(pf.line_spacing)
        if pf.left_indent:
            pstyle["left_indent"] = int(pf.left_indent)
        if pf.right_indent:
            pstyle["right_indent"] = int(pf.right_indent)
        if pf.first_line_indent:
            pstyle["first_line_indent"] = int(pf.first_line_indent)

        # Capturer le XML brut du pPr pour reconstruction fidèle (script 3)
        ppr = paragraph._element.find(qn('w:pPr'))
        if ppr is not None:
            from lxml import etree
            pstyle["_xml_ppr"] = etree.tostring(ppr, encoding="unicode")
        else:
            pstyle["_xml_ppr"] = None

        return pstyle

    def _styles_are_same(self, style1: dict, style2: dict) -> bool:
        """Vérifie si deux styles de run sont identiques."""
        keys = [
            "bold", "italic", "underline", "font_name",
            "font_size", "font_color_rgb", "strike",
            "superscript", "subscript"
        ]
        return all(style1.get(k) == style2.get(k) for k in keys)

    # ------------------------------------------------------------------
    # Extraction principale
    # ------------------------------------------------------------------

    def extract(self) -> dict:
        """
        Extrait toutes les métadonnées et retourne un dict JSON-sérialisable.
        """
        self._log(f"Ouverture du fichier : {self.file_path}")
        self.document = Document(self.file_path)
        self._log(f"Paragraphes détectés : {len(self.document.paragraphs)}")

        structure = []

        # --- Corps du document ---
        for para_idx, paragraph in enumerate(self.document.paragraphs):
            para_data = self._process_paragraph(paragraph, para_idx, "body")
            structure.append(para_data)

        # --- Tableaux ---
        for table_idx, table in enumerate(self.document.tables):
            table_data = {
                "type": "table",
                "table_index": table_idx,
                "rows": []
            }
            for row_idx, row in enumerate(table.rows):
                row_data = {"cells": []}
                for cell_idx, cell in enumerate(row.cells):
                    cell_data = {"paragraphs": []}
                    for cp_idx, cp in enumerate(cell.paragraphs):
                        cp_data = self._process_paragraph(
                            cp, cp_idx,
                            f"table{table_idx}_r{row_idx}_c{cell_idx}"
                        )
                        cell_data["paragraphs"].append(cp_data)
                    row_data["cells"].append(cell_data)
                table_data["rows"].append(row_data)
            structure.append(table_data)

        self._log(f"Total métadonnées extraites : {self.counter}")

        # Construire le JSON final
        result = {
            "_metadata": {
                "script": "step1_extract.py",
                "version": "2.0.0",
                "source_file": self.file_path,
                "source_file_name": self.file_name,
                "extraction_date": datetime.datetime.now().isoformat(),
                "total_metadata": self.counter,
                "total_paragraphs": len(self.document.paragraphs),
                "total_tables": len(self.document.tables),
            },
            "structure": structure,
            "extraction_log": self.log_lines,
        }

        return result

    def _process_paragraph(self, paragraph, para_idx: int, location: str) -> dict:
        """Traite un paragraphe et le découpe en métadonnées atomiques."""
        para_style = self._extract_paragraph_style(paragraph)
        runs = paragraph.runs

        # Paragraphe vide
        if not runs or all(r.text.strip() == "" for r in runs):
            full_text = paragraph.text
            return {
                "type": "paragraph",
                "location": location,
                "para_index": para_idx,
                "para_style": para_style,
                "is_empty": True,
                "original_text": full_text,
                "metadata_groups": []
            }

        # Grouper les runs par style homogène
        groups = []
        current_group_runs = []
        current_style = None

        for run in runs:
            run_style = self._extract_run_style(run)

            if current_style is None:
                current_style = run_style
                current_group_runs = [run]
            elif self._styles_are_same(current_style, run_style):
                current_group_runs.append(run)
            else:
                groups.append((current_group_runs, current_style))
                current_style = run_style
                current_group_runs = [run]

        if current_group_runs:
            groups.append((current_group_runs, current_style))

        # Créer une métadonnée par groupe
        metadata_groups = []
        for group_runs, group_style in groups:
            text = "".join(r.text for r in group_runs)

            if text.strip() == "":
                metadata_groups.append({
                    "metadata_id": None,
                    "source_text": text,
                    "run_style": group_style,
                    "run_count": len(group_runs),
                    "is_translatable": False
                })
                continue

            meta_id = self._generate_id()
            metadata_groups.append({
                "metadata_id": meta_id,
                "source_text": text,
                "run_style": group_style,
                "run_count": len(group_runs),
                "is_translatable": True
            })
            self._log(
                f"Créée : text='{text[:80]}' | bold={group_style.get('bold')} "
                f"| italic={group_style.get('italic')} | color={group_style.get('font_color_rgb')}",
                meta_id=meta_id
            )

        return {
            "type": "paragraph",
            "location": location,
            "para_index": para_idx,
            "para_style": para_style,
            "is_empty": False,
            "original_text": paragraph.text,
            "metadata_groups": metadata_groups
        }


# ============================================================================
# POINT D'ENTRÉE
# ============================================================================

def main():
    parser = argparse.ArgumentParser(
        description="[ÉTAPE 1/3] Extraction des métadonnées d'un document Word → JSON",
        formatter_class=argparse.RawDescriptionHelpFormatter,
        epilog="""
Exemples :
  python step1_extract.py document.docx
  python step1_extract.py document.docx -o mes_metadata.json
        """
    )

    parser.add_argument("input", help="Fichier Word source (.docx)")
    parser.add_argument("-o", "--output", help="Fichier JSON de sortie (défaut: NomFichier_metadata.json)")

    args = parser.parse_args()

    if not os.path.exists(args.input):
        print(f"❌ Fichier introuvable : {args.input}")
        sys.exit(1)

    # Chemin de sortie
    if args.output:
        output_path = args.output
    else:
        stem = Path(args.input).stem
        output_path = f"{stem}_metadata.json"

    print(f"\n{'='*60}")
    print(f"  ÉTAPE 1/3 : EXTRACTION DES MÉTADONNÉES")
    print(f"  Source : {args.input}")
    print(f"{'='*60}\n")

    # Extraction
    extractor = MetadataExtractor(args.input)
    result = extractor.extract()

    # Sauvegarde JSON
    with open(output_path, "w", encoding="utf-8") as f:
        json.dump(result, f, ensure_ascii=False, indent=2)

    total = result["_metadata"]["total_metadata"]
    print(f"  ✅ {total} métadonnées extraites")
    print(f"  ✅ Fichier JSON : {output_path}")
    print(f"  ✅ Taille : {os.path.getsize(output_path) / 1024:.1f} Ko")
    print(f"\n  → Prochaine étape : python step2_translate.py {output_path} -l EN\n")


if __name__ == "__main__":
    main()
