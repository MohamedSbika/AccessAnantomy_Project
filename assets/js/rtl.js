/*!
 * Access Anatomy -- RTL runtime pass for inline styles.
 *
 * Loaded only when the active language is right-to-left (see aa_rtl_assets()
 * in application/helpers/aa_rtl_helper.php).
 *
 * Why this exists: ~280 elements across the views carry directional spacing in
 * a style="" attribute. Inline styles beat any stylesheet, so rtl.css cannot
 * reach them; they have to be mirrored on the element itself.
 *
 * Deliberately conservative:
 *   - Only SPACING and ALIGNMENT are mirrored (margin/padding/float/text-align
 *     /border-side/clear). Positional `left` / `right` are NEVER touched --
 *     the figure, calque and zoom layers position anatomical legends with
 *     absolute pixel coordinates computed against the image, and mirroring
 *     those would scatter the labels onto the wrong structures.
 *   - Runs once on server-rendered markup. It does not observe later mutations,
 *     so it never fights the app's own JS that assigns style.left at runtime.
 *   - Skips anything inside a figure/media container, or marked data-no-rtl.
 *   - Marks what it touched so a re-run cannot double-flip.
 */
(function () {
	"use strict";

	if (document.documentElement.getAttribute("dir") !== "rtl") {
		return;
	}

	/* Containers whose inner geometry is meaningful and must not be mirrored. */
	var PROTECTED = [
		"[data-no-rtl]",
		".calque", ".calques", ".figure-zone", ".figure-image", ".zoomove",
		"#element", "canvas", "svg", "map", "[usemap]",
		".legend-layer", ".calque-container", ".zoom-container"
	].join(",");

	var SWAP = {
		"margin-left": "margin-right",
		"margin-right": "margin-left",
		"padding-left": "padding-right",
		"padding-right": "padding-left",
		"border-left": "border-right",
		"border-right": "border-left",
		"border-left-width": "border-right-width",
		"border-right-width": "border-left-width",
		"border-left-color": "border-right-color",
		"border-right-color": "border-left-color",
		"border-left-style": "border-right-style",
		"border-right-style": "border-left-style",
		"border-top-left-radius": "border-top-right-radius",
		"border-top-right-radius": "border-top-left-radius",
		"border-bottom-left-radius": "border-bottom-right-radius",
		"border-bottom-right-radius": "border-bottom-left-radius"
	};

	var KEYWORD_PROPS = { "float": 1, "clear": 1, "text-align": 1 };

	function flipKeyword(v) {
		var t = v.trim().toLowerCase();
		if (t === "left") return "right";
		if (t === "right") return "left";
		return null;
	}

	/* margin/padding shorthand: top right bottom left -> top left bottom right */
	function flipBoxShorthand(value) {
		var parts = value.trim().split(/\s+/);
		if (parts.length !== 4) return null;
		return [parts[0], parts[3], parts[2], parts[1]].join(" ");
	}

	function flipInline(el) {
		var style = el.getAttribute("style");
		if (!style || !style.indexOf) return;

		var out = [];
		var touched = false;

		style.split(";").forEach(function (decl) {
			if (!decl.trim()) return;
			var idx = decl.indexOf(":");
			if (idx === -1) {
				out.push(decl);
				return;
			}
			var prop = decl.slice(0, idx).trim().toLowerCase();
			var value = decl.slice(idx + 1);

			var bang = "";
			var m = value.match(/(\s*!\s*important)\s*$/i);
			if (m) {
				bang = " !important";
				value = value.slice(0, m.index);
			}

			if (SWAP[prop]) {
				out.push(SWAP[prop] + ":" + value + bang);
				touched = true;
				return;
			}
			if (KEYWORD_PROPS[prop]) {
				var k = flipKeyword(value);
				if (k) {
					out.push(prop + ":" + k + bang);
					touched = true;
					return;
				}
			}
			if (prop === "margin" || prop === "padding") {
				var s = flipBoxShorthand(value);
				if (s) {
					out.push(prop + ":" + s + bang);
					touched = true;
					return;
				}
			}
			/* `left`, `right`, `transform`, everything else: left untouched. */
			out.push(decl);
		});

		if (touched) {
			el.setAttribute("style", out.join(";"));
			el.setAttribute("data-rtl-flipped", "");
		}
	}

	function run() {
		var nodes = document.querySelectorAll("[style]");
		for (var i = 0; i < nodes.length; i++) {
			var el = nodes[i];
			if (el.hasAttribute("data-rtl-flipped")) continue;
			if (el.closest && el.closest(PROTECTED)) continue;
			flipInline(el);
		}
	}

	if (document.readyState === "loading") {
		document.addEventListener("DOMContentLoaded", run);
	} else {
		run();
	}
})();
