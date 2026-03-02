#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
╔══════════════════════════════════════════════════════════════════╗
║  SCRIPT 3/3 : RECONSTRUCTION DU DOCUMENT WORD TRADUIT            ║
║  Génère le .docx traduit à partir du JSON enrichi                ║
╚══════════════════════════════════════════════════════════════════╝

Entrée  : fichier JSON (sortie du script 2) + fichier Word original
Sortie  : fichier Word traduit avec styles conservés

Le script reconstruit le document en :
  1. Ouvrant le document Word original (pour conserver toute la mise en page)
  2. Remplaçant le texte de chaque run par la traduction correspondante
  3. Conservant fidèlement : police, taille, couleur, gras, italique,
     souligné, alignement, espacement, retours à la ligne

Usage :
    python step3_rebuild.py translated.json -s document.docx
    python step3_rebuild.py translated.json -s document.docx -o output_EN.docx
"""

import os
import sys
import copy
import json
import argparse
from pathlib import Path
from typing import List

from docx import Document
from docx.shared import Pt, RGBColor
from docx.oxml.ns import qn
from lxml import etree


# ============================================================================
# CLASSE : Reconstructeur de document Word traduit
# ============================================================================

class DocumentReconstructor:
    """
    Reconstruit le document Word traduit en conservant TOUS les styles.

    Stratégie :
    - Ouvre le document Word original (conserve mise en page, en-têtes, etc.)
    - Pour chaque paragraphe, efface les runs existants
    - Recrée les runs avec le texte traduit + styles XML d'origine
    - Le style XML brut (_xml_rpr) est prioritaire pour une fidélité maximale
    """

    def __init__(self, source_path: str):
        self.source_path = source_path
        self.log_lines: List[str] = []

    def _log(self, message: str):
        self.log_lines.append(message)

    def reconstruct(self, structure: List[dict], output_path: str):
        """
        Reconstruit le document traduit.

        Args:
            structure: Liste des éléments (paragraphes + tableaux) du JSON
            output_path: Chemin du fichier .docx de sortie
        """
        self._log(f"Ouverture du document original : {self.source_path}")
        doc = Document(self.source_path)

        body_para_idx = 0
        table_idx = 0

        for item in structure:
            if item["type"] == "paragraph" and item["location"] == "body":
                if body_para_idx < len(doc.paragraphs):
                    paragraph = doc.paragraphs[body_para_idx]
                    self._apply_translation_to_paragraph(paragraph, item)
                body_para_idx += 1

            elif item["type"] == "table":
                if table_idx < len(doc.tables):
                    table = doc.tables[table_idx]
                    self._apply_translation_to_table(table, item)
                table_idx += 1

        doc.save(output_path)
        self._log(f"Document sauvegardé : {output_path}")

    def _apply_translation_to_paragraph(self, paragraph, para_data: dict):
        """Applique les traductions à un paragraphe en conservant les styles."""
        if para_data.get("is_empty", True):
            return

        groups = para_data.get("metadata_groups", [])
        runs = paragraph.runs

        if not groups or not runs:
            return

        # Sauvegarder les styles de chaque run original
        original_run_styles = []
        for run in runs:
            original_run_styles.append(self._capture_run_formatting(run))

        # Effacer tous les runs
        for run in runs:
            run._element.getparent().remove(run._element)

        # Recréer les runs avec texte traduit + styles d'origine
        run_style_idx = 0
        for group in groups:
            # Déterminer le texte à utiliser
            translated = group.get("translated_text", "")
            source = group.get("source_text", "")
            status = group.get("translation_status", "SKIPPED")

            if status == "SUCCESS" and translated:
                text = translated
            elif translated and not translated.startswith("[REF:"):
                text = translated
            elif status in ("REJECTED", "ERROR") and translated.startswith("[REF:"):
                text = translated  # Garde le marqueur [REF: xxx]
            else:
                text = source

            # Déterminer le style à appliquer
            style_to_apply = None

            # Priorité 1 : Style XML brut du JSON (le plus fidèle)
            xml_rpr = group.get("run_style", {}).get("_xml_rpr")
            if xml_rpr:
                style_to_apply = {"_xml_rpr_string": xml_rpr}
            # Priorité 2 : Style capturé du document original
            elif run_style_idx < len(original_run_styles):
                style_to_apply = original_run_styles[run_style_idx]

            # Créer le run
            new_run = paragraph.add_run(text)
            if style_to_apply:
                self._apply_run_formatting(new_run, style_to_apply, group.get("run_style", {}))

            # Avancer l'index des styles
            run_style_idx += group.get("run_count", 1)

    def _apply_translation_to_table(self, table, table_data: dict):
        """Applique les traductions aux cellules d'un tableau."""
        for row_idx, row_data in enumerate(table_data.get("rows", [])):
            if row_idx >= len(table.rows):
                break
            row = table.rows[row_idx]
            for cell_idx, cell_data in enumerate(row_data.get("cells", [])):
                if cell_idx >= len(row.cells):
                    break
                cell = row.cells[cell_idx]
                for cp_idx, cp_data in enumerate(cell_data.get("paragraphs", [])):
                    if cp_idx >= len(cell.paragraphs):
                        break
                    self._apply_translation_to_paragraph(
                        cell.paragraphs[cp_idx], cp_data
                    )

    def _capture_run_formatting(self, run) -> dict:
        """Capture complète du formatage d'un run depuis le document original."""
        fmt = {
            "bold": run.bold,
            "italic": run.italic,
            "underline": run.underline,
            "font_name": run.font.name,
            "font_size": run.font.size,
            "font_color_rgb": None,
            "strike": run.font.strike,
            "superscript": run.font.superscript,
            "subscript": run.font.subscript,
            "highlight_color": run.font.highlight_color,
        }

        if run.font.color and run.font.color.rgb:
            fmt["font_color_rgb"] = str(run.font.color.rgb)

        # Capturer le XML brut
        rpr = run._element.find(qn('w:rPr'))
        if rpr is not None:
            fmt["_xml_rpr_element"] = copy.deepcopy(rpr)

        return fmt

    def _apply_run_formatting(self, run, fmt: dict, json_style: dict = None):
        """
        Applique le formatage à un nouveau run.

        Priorité :
        1. XML brut depuis le JSON (_xml_rpr_string) → parsing depuis string
        2. XML brut depuis le document original (_xml_rpr_element) → copie directe
        3. Fallback via python-docx API avec les valeurs du JSON
        """
        # --- Méthode 1 : XML brut depuis le JSON (string) ---
        xml_str = fmt.get("_xml_rpr_string")
        if xml_str:
            try:
                rpr_element = etree.fromstring(xml_str)
                existing = run._element.find(qn('w:rPr'))
                if existing is not None:
                    run._element.remove(existing)
                run._element.insert(0, rpr_element)
                return
            except Exception:
                pass  # Fallback

        # --- Méthode 2 : XML brut depuis le document original (element) ---
        xml_elem = fmt.get("_xml_rpr_element")
        if xml_elem is not None:
            existing = run._element.find(qn('w:rPr'))
            if existing is not None:
                run._element.remove(existing)
            run._element.insert(0, copy.deepcopy(xml_elem))
            return

        # --- Méthode 3 : Fallback python-docx API ---
        style = json_style or fmt
        if style.get("bold") is not None:
            run.bold = style["bold"]
        if style.get("italic") is not None:
            run.italic = style["italic"]
        if style.get("underline"):
            run.underline = True
        if style.get("font_name"):
            run.font.name = style["font_name"]
        if style.get("font_size"):
            run.font.size = int(style["font_size"])
        if style.get("font_color_rgb"):
            run.font.color.rgb = RGBColor.from_string(style["font_color_rgb"])
        if style.get("strike") is not None:
            run.font.strike = style["strike"]
        if style.get("superscript") is not None:
            run.font.superscript = style["superscript"]
        if style.get("subscript") is not None:
            run.font.subscript = style["subscript"]
        if style.get("highlight_color") is not None:
            run.font.highlight_color = style["highlight_color"]


# ============================================================================
# POINT D'ENTRÉE
# ============================================================================

def main():
    parser = argparse.ArgumentParser(
        description="[ÉTAPE 3/3] Reconstruction du document Word traduit",
        formatter_class=argparse.RawDescriptionHelpFormatter,
        epilog="""
Exemples :
  python step3_rebuild.py translated_EN.json -s document.docx
  python step3_rebuild.py translated_EN.json -s document.docx -o final_EN.docx
        """
    )

    parser.add_argument("input", help="Fichier JSON traduit (sortie du script 2)")
    parser.add_argument("-s", "--source", required=True,
                        help="Fichier Word original (.docx)")
    parser.add_argument("-o", "--output",
                        help="Fichier Word traduit de sortie")

    args = parser.parse_args()

    if not os.path.exists(args.input):
        print(f"❌ Fichier JSON introuvable : {args.input}")
        sys.exit(1)
    if not os.path.exists(args.source):
        print(f"❌ Fichier Word original introuvable : {args.source}")
        sys.exit(1)

    # Charger le JSON
    with open(args.input, "r", encoding="utf-8") as f:
        data = json.load(f)

    target_lang = data.get("_metadata", {}).get("target_language", "EN")
    source_file_name = data.get("_metadata", {}).get("source_file_name", "output")

    # Chemin de sortie
    if args.output:
        output_path = args.output
    else:
        output_path = f"{source_file_name}_{target_lang}.docx"

    print(f"\n{'='*60}")
    print(f"  ÉTAPE 3/3 : RECONSTRUCTION DU DOCUMENT TRADUIT")
    print(f"  JSON source : {args.input}")
    print(f"  Word original : {args.source}")
    print(f"  Langue : {target_lang}")
    print(f"{'='*60}\n")

    # Compter les statuts
    status_counts = {"SUCCESS": 0, "REJECTED": 0, "ERROR": 0, "SKIPPED": 0, "EMPTY": 0}

    def count_statuses(elements):
        for item in elements:
            if item.get("type") == "paragraph":
                for group in item.get("metadata_groups", []):
                    st = group.get("translation_status", "SKIPPED")
                    status_counts[st] = status_counts.get(st, 0) + 1
            elif item.get("type") == "table":
                for row in item.get("rows", []):
                    for cell in row.get("cells", []):
                        for para in cell.get("paragraphs", []):
                            for group in para.get("metadata_groups", []):
                                st = group.get("translation_status", "SKIPPED")
                                status_counts[st] = status_counts.get(st, 0) + 1

    count_statuses(data["structure"])

    print(f"  Métadonnées dans le JSON :")
    print(f"    Traduites (SUCCESS) : {status_counts.get('SUCCESS', 0)}")
    print(f"    Rejetées (REJECTED) : {status_counts.get('REJECTED', 0)}")
    print(f"    Erreurs (ERROR)     : {status_counts.get('ERROR', 0)}")
    print(f"    Ignorées (SKIPPED)  : {status_counts.get('SKIPPED', 0)}")
    print()

    # Reconstruire
    print("  Reconstruction en cours...")
    reconstructor = DocumentReconstructor(args.source)
    reconstructor.reconstruct(data["structure"], output_path)

    errors_count = status_counts.get("REJECTED", 0) + status_counts.get("ERROR", 0)

    print(f"\n  ✅ Document sauvegardé : {output_path}")
    print(f"  ✅ Taille : {os.path.getsize(output_path) / 1024:.1f} Ko")
    if errors_count > 0:
        print(f"\n  ⚠️  {errors_count} métadonnée(s) non traduite(s) marquées [REF: xxx]")
        print(f"  Faites Ctrl+F → [REF: pour les retrouver dans le document.")
    print(f"\n{'='*60}\n")


if __name__ == "__main__":
    main()
