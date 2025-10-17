<?php
include 'PDFMerger.php';

$pdf = new PDFMerger;

$pdf->addPDF('uploads/PdfDocument.pdf', '1, 3, 4')
	->addPDF('uploads/PdfDocument.pdf', '1-2')
	->addPDF('uploads/PdfDocument.pdf', 'all')
	->merge('file', 'uploads/TEST2.pdf');
	
	//REPLACE 'file' WITH 'browser', 'download', 'string', or 'file' for output options
	//You do not need to give a file path for browser, string, or download - just the name.
