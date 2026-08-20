<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Access Anatomy — language direction helper.
 *
 * Centralises everything the views need to know about the active language's
 * writing direction, so adding another RTL language later is a one-line change
 * to $rtl below rather than another sweep across ~30 view files.
 */

if (!function_exists('aa_lang_code')) {
	/**
	 * Active platform language as a 2-letter uppercase code (FR, EN, AR, ...).
	 */
	function aa_lang_code()
	{
		$CI =& get_instance();
		if (!isset($CI->session)) {
			return 'FR';
		}
		$lang = $CI->session->userdata('site_lang');
		return $lang ? strtoupper($lang) : 'FR';
	}
}

if (!function_exists('aa_is_rtl')) {
	/**
	 * TRUE when the active language is written right-to-left.
	 */
	function aa_is_rtl()
	{
		$rtl = array('AR');
		return in_array(aa_lang_code(), $rtl);
	}
}

if (!function_exists('aa_html_lang')) {
	/**
	 * BCP-47 subtag for the <html lang="..."> attribute.
	 */
	function aa_html_lang()
	{
		$map = array(
			'FR' => 'fr', 'EN' => 'en', 'ES' => 'es', 'RU' => 'ru',
			'TR' => 'tr', 'PT' => 'pt', 'IT' => 'it', 'DE' => 'de',
			'PL' => 'pl', 'JA' => 'ja', 'KO' => 'ko', 'AR' => 'ar',
		);
		$code = aa_lang_code();
		return isset($map[$code]) ? $map[$code] : 'fr';
	}
}

if (!function_exists('aa_html_attrs')) {
	/**
	 * lang + dir attributes for the opening <html> tag.
	 */
	function aa_html_attrs()
	{
		return 'lang="' . aa_html_lang() . '" dir="' . (aa_is_rtl() ? 'rtl' : 'ltr') . '"';
	}
}

if (!function_exists('aa_dir')) {
	/**
	 * 'rtl' or 'ltr' — for use on individual elements.
	 */
	function aa_dir()
	{
		return aa_is_rtl() ? 'rtl' : 'ltr';
	}
}

if (!function_exists('aa_rtl_assets')) {
	/**
	 * RTL override sheet + the inline-style runtime pass.
	 *
	 * Emits nothing at all for LTR languages, so every other language keeps
	 * byte-for-byte the same markup it had before Arabic was added.
	 *
	 * Print this LAST in <head>: the sheet has to come after every other
	 * stylesheet for its overrides to win.
	 */
	function aa_rtl_assets()
	{
		if (!aa_is_rtl()) {
			return '';
		}
		return '<link rel="stylesheet" href="' . HTTP_CSS . 'rtl.css">' . "\n"
			. '<script src="' . HTTP_JS . 'rtl.js" defer></script>';
	}
}

if (!function_exists('aa_rtl_css')) {
	/**
	 * @deprecated kept as an alias so any stray call site keeps working.
	 */
	function aa_rtl_css()
	{
		return aa_rtl_assets();
	}
}
