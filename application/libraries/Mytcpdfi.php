<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH."/third_party/tcpdfi/PDFMerger.php";


class Mytcpdfi extends  \PDFMerger\PDFMerger
{
 function __construct()
 {
	 parent::__construct();
	 $CI =& get_instance();
 }
}
