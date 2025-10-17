<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
use setasign\Fpdi\Fpdi;
require('FPDFI/Fpdi.php');
require('FPDFI/autoload.php');


class Myfpdf extends  Fpdi
{
 function __construct()
 {
	 parent::__construct();
	 $CI =& get_instance();
 }
}
