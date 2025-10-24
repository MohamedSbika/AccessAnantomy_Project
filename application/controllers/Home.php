<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

    

class Home extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 * 	- or -
	 * 		http://example.com/index.php/welcome/index
	 * 	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */

	public function __construct() {

		parent::__construct();
		$this->load->helper('url');
		$this->load->model('QuestionType_model','QuestionType_model');
		$this->load->model('QuestionTypeTest_model','QuestionTypeTest_model');
		$this->load->model('Pages_model','Pages_model');
		$this->setLang();

	}

    public function switchPlatform($encrypted_url) {
        $decrypted_url = base64_decode(urldecode($encrypted_url));

        $typePlatform = $this->getTypePlatform();

        $this->session->set_userdata('typePlatform',!$typePlatform );

        //header(base_url());
        redirect(base_url().$decrypted_url);
    }

    public function getTypePlatform() {

        $typePlatform = $this->session->userdata('typePlatform') ? true : false;

        return $typePlatform ;
    }

    public function listChaptCours($id){
        $this->db->select('* , CAST(SUBSTRING_INDEX(titrechapitre, "-", 1) as SIGNED INTEGER ) AS ord');
        $this->db->from('_chapitre');
        $this->db->Where("IDLivre = '$id' ");
        //$this->db->order_by("NumOrdre" ,"asc");
        $this->db->order_by("ord" ,"asc");
        $listChap = $this->db->get()->result_array();
        return $listChap ;
    }

	/////////||||||*****Accessanatomy PDF*****||||||\\\\\\\\\\\
	///

	public function decoupageWord()
	{
		require_once APPPATH."/third_party/wordToPh/vendor/autoload.php";
		//$this->load->library('MyWorldDoc');

		$docF = str_replace(" ","%20",$docF);
		$objReader= \PhpOffice\PhpWord\IOFactory::createReader('Word2007');
		$document = \PhpOffice\PhpWord\IOFactory::load('Resources/documents/test.docx');
//        $contents=   \PhpOffice\PhpWord\IOFactory::load($docF);

		//$objWriter= \PhpOffice\PhpWord\IOFactory::createWriter($contents,'Word2007');
		//$objWriter->save("new.docx");

		//$contents=$objReader->load("Clavicule.docx");

		$rendername= \PhpOffice\PhpWord\Settings::PDF_RENDERER_TCPDF;

		$renderLibrary="tcpdf";
		$renderLibraryPath=APPPATH."/third_party/wordToPh/".$renderLibrary;
		if(!\PhpOffice\PhpWord\Settings::setPdfRenderer($rendername,$renderLibraryPath)){
			die("Provide Render Library And Path");
		}

		$objWriter= \PhpOffice\PhpWord\IOFactory::createWriter($contents,'PDF');
		$objWriter->save("test.pdf");

	}

	public function convertDoc($docCvrt ,$OutPages,$idCurs,$idResum){

		$this->load->helper('url');
		$this->load->helper('directory');

		$this->load->helper('file');

		$docF       = $docCvrt;
		//print_r($docF);print_r('<br>');
		$docPDF	  	= FCPATH.'PlatFormeConvert/'."Radi88888888.pdf";

		$word 		= new COM("Word.Application") or die ("Could not initialise Object.");

		// set it to 1 to see the MS Word window (the actual opening of the document)
		$word->Visible = 0;
		// recommend to set to 0, disables alerts like "Do you want MS Word to be the default .. etc"
		$word->DisplayAlerts = 0;
		// open the word 2007-2013 document
		$word->Documents->Open($docF);
		//$num_pages = $word->ActiveDocument->ComputeStatistics( 2 );

		// save it as word 2003
		$word->Documents[1]->SaveAs(FCPATH.'PlatFormeConvert/'."testFile.docx", 16);
		// convert word 2007-2013 to PDF
		$word->ActiveDocument->ExportAsFixedFormat($docPDF, 17);

		/////$num_pages = $this->PageCount_DOCX(FCPATH.'PlatFormeConvert/'."testFile.docx");
		if($OutPages != "0"){

			$this->load->library('Mytcpdfi');

			//$OutPages = "uploads/Plateforme TRIAA Habib 2020/Platforme Accessanatomy/Anatomie humaine/A- Livres d'Anatomie/5-Membre supérieur/1-Embryologie/Cours/";
			$pathLi 	= $OutPages ;
			$OutPages 	= UP_PLATFORM.$OutPages ; // "uploads/Plateforme TRIAA Habib 2020/Platforme Accessanatomy/".$OutPages;
			$OutPages 	= utf8_decode($OutPages);

			// iterate through all pages

			$pdf = new \PDFMerger\PDFMerger();
			$pageCount = $pdf->setSourceFile($docPDF,'all');
			//log_message('error', $docF.'***************'.$pageCount);

			for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
				$pdf = new \PDFMerger\PDFMerger();
				$pdf->addPDF($docPDF, $pageNo)
					->merge('file', FCPATH.$OutPages.$pageNo.'.pdf');

				$pathLi  = str_replace("'","&#039;",$pathLi);

				$fp =    fopen(FCPATH.$OutPages.$pageNo.'.pdf',"rb");
				$data =  fread($fp,filesize(FCPATH.$OutPages.$pageNo.'.pdf'));
				fclose($fp);

				$data = chunk_split(base64_encode($data));

				//print_r($data.'<br>');
				if($idCurs > 0){
					$data_P = array(
						'ContentFileCrypt' 	=> $data,
						'ContenuPAge' 		=> $pathLi.$pageNo.'.pdf',
						'numeroPage' 		=> $pageNo,
						'IDCours' 			=> $idCurs
					);
				}
				if($idResum > 0){
					$data_P = array(
						'ContentFileCrypt' 	=> $data,
						'ContenuPAge' 		=> $pathLi.$pageNo.'.pdf',
						'numeroPage' 		=> $pageNo,
						'IDResume' 			=> $idResum
					);
				}
				unlink(FCPATH.$OutPages.$pageNo.'.pdf');
				$this->insert_dd('_page',$data_P);
			}
		}

		// quit the Word process
		//$word->ActiveDocument->Close(false);
		$word->Documents->close(true);
		$word->Quit();
		$word = null;
		unset($word);

		return "testFile.docx";

	}

	public function convertDocHTML($docCvrt ,$OutPages,$idCurs,$idResum){

		$this->load->helper('url');
		$this->load->helper('directory');

		$this->load->helper('file');

		$docF       = $docCvrt;
		//print_r($docF);print_r('<br>');
		$docPDF	  	= FCPATH.'PlatFormeConvert/'."Radi88888888.pdf";

		$word 		= new COM("Word.Application") or die ("Could not initialise Object.");

		// set it to 1 to see the MS Word window (the actual opening of the document)
		$word->Visible = 0;
		// recommend to set to 0, disables alerts like "Do you want MS Word to be the default .. etc"
		$word->DisplayAlerts = 0;
		// open the word 2007-2013 document
		$word->Documents->Open($docF);
		//$num_pages = $word->ActiveDocument->ComputeStatistics( 2 );

		// save it as word 2003
		$word->Documents[1]->SaveAs(FCPATH.'PlatFormeConvert/'."testFile.HTML", 8);
		// convert word 2007-2013 to html
		//$fileEndEnd = FCPATH.'PlatFormeConvert/'."testFile.HTML";
		$content = file_get_contents(FCPATH.'PlatFormeConvert/'."testFile.HTML",true);
		//$content = iconv('UTF-8', 'utf-8//TRANSLIT//IGNORE', utf8_encode($content));
		//$content = mb_convert_encoding($content, 'UTF-8', mb_detect_encoding($content, 'UTF-8', true));
		$content = utf8_encode ( $content );
		$content = iconv( "UTF-8", "UTF-8//TRANSLIT", $content );
		$content = mb_convert_encoding($content, 'HTML-ENTITIES', "UTF-8");

//print_r($content);
//print_r('<br>');
		// quit the Word process
		//$word->ActiveDocument->Close(false);
		$word->Documents->close(true);
		$word->Quit();
		$word = null;
		unset($word);
		unlink(FCPATH.'PlatFormeConvert/'."testFile.HTML");
		return $content;

	}

	private function read_docx($fileDocx = ''){

		$striped_content = '';
		$content = '';

		$zip = zip_open($fileDocx);
		//$zip = zip_open('c:/platforme/Radi7777s.docx');

		if (!$zip || is_numeric($zip)) return false;

		while ($zip_entry = zip_read($zip)) {

			if (zip_entry_open($zip, $zip_entry) == FALSE) continue;

			if (zip_entry_name($zip_entry) != "word/document.xml") continue;

			$content .= zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));

			zip_entry_close($zip_entry);
		}// end while

		zip_close($zip);

		$content = str_replace('</w:r></w:p></w:tc><w:tc>', "<br>", $content);
		$content = str_replace('</w:r></w:p>', "<br>", $content);
		//$striped_content = strip_tags($content);

		$list = explode("<br>", $content);
	//	print_r($list);

		return $list;
	}

	public function index() {

		if( $this->session->userdata('logged_in') ){
			//redirect('dashboard');
			//$this->setParamsAutoFromFloders();
			$arr['listCat'] = $this->getListCategory();

			$arr['page'] = 'page_home';
//			$this->load->view('page_home', $arr);
            $this->load->view($this->getTypePlatform() ? 'v1_page_home' : 'page_home', $arr);
		}else{

			//$this->setParamsAutoFromFloders();
			$arr['listCat'] = $this->getListCategory();

            
			//$arr['page'] = 'login';
			//$this->load->view('login', $arr);
			$arr['page'] = 'page_home';
//			$this->load->view('page_home', $arr);
            $this->load->view($this->getTypePlatform() ? 'v1_page_home' : 'page_home', $arr);
		}
	}
    

	public function user_logs() {

		$this->db->select('*');
		$this->db->from('users');
		$res = $this->db->get()->result_array();

		if(count($res) > 0){
			$arr['users'] = $res;
		}

		$arr['page'] = 'user logs';
		$this->load->view('user_logs', $arr);

	}

	public function concatenate_filepaths ($map, $prefix = '') {
		$return = array();

		foreach ($map as $key => $file) {
			if (is_array($file)) {
				$return = array_merge($return, $this->concatenate_filepaths($file, $prefix . '/' . $key . '/'));
			}
			else {
				$return[] = $prefix . $file;
			}
		}

		return $return;
	}
    public function setParamsAutoFromFloder()
    {
        $arr = array();

        $arr[] = array("id" => '1', "desc" => 'PAGE EN COURS DE CONSTRUCTION');

        echo json_encode($arr);
        exit;
    }
	public function setParamsAutoFromFloders_()
	{
/*
		$this->db->query("delete FROM `_category` WHERE IDCategory > 2 ;");
		$this->db->query("TRUNCATE TABLE `_chapitre`;");
		$this->db->query("TRUNCATE TABLE `_cours`;");
		$this->db->query("TRUNCATE TABLE `_resume`;");
		$this->db->query("TRUNCATE TABLE `_figure`;");
		$this->db->query("TRUNCATE TABLE `_livre`;");
		$this->db->query("TRUNCATE TABLE `_page`;");
		$this->db->query("TRUNCATE TABLE `_publicite`;");
		$this->db->query("TRUNCATE TABLE `_questiontype`;");
		$this->db->query("TRUNCATE TABLE `_theme`;");
*/
		$this->load->helper('directory');
		$path_Dir = './'.UP_PLATFORM ; //'./uploads/Plateforme TRIAA Habib 2020/Platforme Accessanatomy/';
		$map = directory_map($path_Dir);
		$file_paths = $this->concatenate_filepaths($map,'');

		$get_cat_cur 	= '';
		$get_item_cur 	= '';
		$get_liv_cur 	= '';
		$get_chap_cur 	= '';
		$get_TypeCurs_cur 	= '';
		$get_TypeCurs_cur_org 	= '';
		$get_cours_cur 	= '';

		$idcat  = 0;
		$idthem = 0;
		$idLiv  = 0;
		$idChap = 0;
		$idCurs = 0;
		foreach ($file_paths as $onpath)
		{
			$level = 1 ;

			$pieces = explode("\/", $onpath);
			foreach ($pieces as $one)
			{
				if($level==1) { //Categorie

					$estUnDossier = strpos(strtoupper($one),'.');
					if($get_cat_cur == '') {$get_cat_cur= $one;$get_item_cur = '';$idcat=0;}
					if(strcmp($get_cat_cur, $one) !== 0) {$get_cat_cur= $one;$get_item_cur = '';$idcat=0;}
					if($idcat==0 && $estUnDossier ==false){
						$data = array(
							'Libelle' 			=> str_replace("/","",$one),
							'EstActifMenu' 		=> true,
							'EstActifAccueil' 	=> true,
							'OrdreCat' 			=> true,
							'multi_lingue' 		=> $this->session->userdata('site_lang')
						);
						$idcat = $this->insert_dd('_category',$data);
					}
				}

				if($level==2) { //Theme
					if($get_item_cur == '') {$get_item_cur= $one;$get_liv_cur = '';$idthem = 0;}
					if(strcmp($get_item_cur, $one) !== 0) {$get_item_cur= $one;$get_liv_cur = '';$idthem = 0;}
					if($idthem==0){
						$data = array(
							'LibelleTheme' 				=> str_replace("/","",$one),
							'EstActif' 					=> true,
							'OrderTheme' 				=> true,
							'IDCategory' 				=> $idcat
						);
						$idthem= $this->insert_dd('_theme',$data);
					}
				}

				if($level==3) { // livre
					if($get_liv_cur == '') {$get_liv_cur= $one;$get_chap_cur = '';$idLiv  = 0;}
					if(strcmp($get_liv_cur, $one) !== 0) {$get_liv_cur= $one;$get_chap_cur = '';$idLiv  = 0;}
					if($idLiv==0){
						$data = array(
							'Titre' 		=> str_replace("/","",utf8_encode($one)),
							'Description' 	=> '',
							'Couverture' 	=> '',
							'IDTheme' 		=> $idthem
						);
						$idLiv= $this->insert_dd('_livre',$data);
					}
				}

				if($level==4) { // chapitre & publicite & couverture & Description
					if($get_chap_cur == '') {$get_chap_cur= $one;$idChap = 0;}
					if(strcmp($get_chap_cur, $one) !== 0) {$get_chap_cur= $one;$idChap = 0;}
					if($idChap==0){
						$notChap = 0 ;
						$posCouvPNG = strpos(strtoupper($one),'.PNG');
						$posCouvJPG = strpos(strtoupper($one),'.JPG');
						$posDesc = strpos(strtoupper($one),'DESCRIPTION.DOC');
						//$posDesc = strpos(strtoupper($one),'DESCRIPTION.TXT');
						$posVide = strpos(strtoupper($one),'VIDEO.TXT');
						$posDB = strpos(strtoupper($one),'.DB');
						$pathLi  = str_replace("//","/",utf8_encode($onpath));
						$pathLi  = str_replace("\\","",$pathLi);
						$encryptCouverture = HTTP_PLATFORM.str_replace("\\","",$pathLi);
						$encryptCouverture = str_replace(" ","%20",$encryptCouverture);
						$encryptCouverture = str_replace("'","&#039;",$encryptCouverture);

						$pathLi  = substr($pathLi, 1);
						if ($posCouvPNG !== false || $posCouvJPG !== false) {
							$Couverture  = $pathLi;

							$encryptCouverture 		= HTTP_PLATFORM.$onpath;
							$encryptCouverture 		= str_replace(" ","%20",$encryptCouverture);
							//$encryptFigure 		= str_replace("'","&#039;",$encryptFigure);
							$encryptCouverture = utf8_encode ( $encryptCouverture );
							$encryptCouverture = iconv( "UTF-8", "UTF-8//TRANSLIT", $encryptCouverture );
							//print_r($encryptFigure."***********");
							$curr_f1 			= file_get_contents($encryptCouverture);
							$imageData 			= base64_encode($curr_f1);

							$data_l = array('Couverture' => $pathLi , 'encryptCouverture' =>$imageData);$notChap = 1 ;
						}
						if ($posDesc !== false) {
							$Description = $onpath;$notChap = 2 ;
							//$this->load->helper('url');
							$this->load->helper('file');
							$Video 	  = HTTP_PLATFORM.$pathLi;$notChap = 3 ;
							$Video = str_replace(" ","%20",$Video);
/*							//$datasss = file_get_contents($Video);$myfile = fopen($Video, "r");$aa = read_file($Video);
							$myfile = fopen($Video,'r');
							$myCt = '';
							while(!feof($myfile)){
								$myCt= $myCt.fgets($myfile)."<br>" ;
							}
							$data_l = array('Description' => $myCt);
							fclose($myfile);
*/
							$docCvrt = HTTP_PLATFORM.$onpath;//'./uploads/Plateforme TRIAA Habib 2020/Platforme Accessanatomy/';
							$docCvrt 		= str_replace(" ","%20",$docCvrt);
							$descD 	= $this->convertDocHTML($docCvrt,$PathDocc,'',0);//
							$data_l = array('Description' => $descD);
							//print_r("******************************");
						}
						if ($posVide !== false) {
							//$this->load->helper('url');
							$this->load->helper('file');
							$Video 	  = HTTP_PLATFORM.$pathLi;$notChap = 3 ;
							$Video = str_replace(" ","%20",$Video);
							//$datasss = file_get_contents($Video);$myfile = fopen($Video, "r");$aa = read_file($Video);
							$myfile = fopen($Video,'r');
							while(!feof($myfile)){
								//print_r(fgets($myfile)."<br>");
								$data = array(
									'Titre' 		=> $one,
									'URL' 			=> fgets($myfile),
									'TypeMedia' 	=> 'VIDEO',
									'IDLivre' 		=> $idLiv
								);
								$this->insert_dd('_publicite',$data);
							}
							fclose($myfile);
							//print_r("******************************");
						}
						//print_r($posDB.'<br>');
						//if (($posCouv !== false) || ($posDesc !== false) || ($posVide !== false) ){
							if($notChap==0 && $posDB ==false){
								$data = array(
									'TitreChapitre' => str_replace("/","",utf8_encode($one)),
									'NumOrdre' 		=> '1',
									'NbreCours' 	=> '0',
									'NbreQcm' 		=> '0',
									'NbreQroc' 		=> '0',
									'IDLivre' 		=> $idLiv
								);
								$idChap= $this->insert_dd('_chapitre',$data);
							}else{
								if($posDB ==false){
									$this->db->where('IDLivre', $idLiv);
									$this->db->update('_livre', $data_l);
								}

							}
						//}


					}
				}
				if($level==5) {
					if($get_cours_cur == '') {$get_cours_cur= $one;$idCurs = 0;}
					if(strcmp($get_cours_cur, $one) !== 0) {$get_cours_cur= $one;$idCurs = 0;}
					if($idCurs==0){
						$get_TypeCurs_cur 	= strtoupper(str_replace("/","",utf8_encode($one))) ;
						$get_TypeCurs_cur_org 	= str_replace("/","",utf8_encode($one)) ;
						//$typeCurs 			= str_replace("/","",utf8_encode($one)) ;
						//
						if($get_TypeCurs_cur=="COURS" || $get_TypeCurs_cur=="COURSE" )
						{
							$data = array(
								'TitreCours' 	=> '',
								'UrlCours' 		=> '',
								'Tags' 			=> '',
								'IDChapitre' 	=> $idChap
							);
							$idCurs= $this->insert_dd('_cours',$data);
						}
						if($get_TypeCurs_cur=="RESUME")
						{
							$data = array(
								'TitreResume' 	=> '',
								'UrlResume' 	=> '',
								'Tags' 			=> '',
								'IDChapitre' 	=> $idChap
							);
							$idCurs= $this->insert_dd('_resume',$data);
						}
					}
				}
				if($level==6) {
					if($get_TypeCurs_cur=="COURS" || $get_TypeCurs_cur=="COURSE")
					{	//print_r($one.'-'.$idCurs);print_r("***************");
						$typeCurs= str_replace("/","",utf8_encode($one)) ;
						$pathLi  = str_replace("//","/",utf8_encode($onpath));
						$pathLi  = str_replace("\\","",$pathLi);
						$pathLi  = substr($pathLi, 1);

						$posFigPng = strpos(strtoupper($typeCurs),'.PNG');
						$posFigJpg = strpos(strtoupper($typeCurs),'.JPG');
						$posFigDoc = strpos(strtoupper($typeCurs),'.DOC');
						$posDB 	   = strpos(strtoupper($one),'.DB');
						$posPDF	   = strpos(strtoupper($one),'.PDF');
						if ($posFigPng !== false || $posFigJpg !== false) {
							$pathLiFig  = str_replace("'","&#039;",$pathLi);

							$encryptFigure 		= HTTP_PLATFORM.$onpath;
							$encryptFigure 		= str_replace(" ","%20",$encryptFigure);
							//$encryptFigure 		= str_replace("'","&#039;",$encryptFigure);
							$encryptFigure = utf8_encode ( $encryptFigure );
							$encryptFigure = iconv( "UTF-8", "UTF-8//TRANSLIT", $encryptFigure );
							//print_r($encryptFigure."***********");
							$curr_f1 			= file_get_contents($encryptFigure);
							$imageData 			= base64_encode($curr_f1);
							/*
							$pathLi  = str_replace("//","/",utf8_encode($onpath));
							$pathLi  = str_replace("\\","",$pathLi);
							$encryptFigure  = HTTP_PLATFORM.str_replace("\\","",$pathLi);
							$encryptFigure = str_replace(" ","%20",$encryptFigure);
							$encryptFigure = str_replace("'","&#039;",$encryptFigure);
							$imageContent = file_get_contents($encryptFigure);
							$imageData = base64_encode($imageContent);
							*/

							$data = array(
								'TitreFigure' 	=> $typeCurs,
								'UrlFigure' 	=> $pathLiFig,
								'IDCours' 		=> $idCurs ,
								'encryptFigure'	=> $imageData
							);
							$idFig = $this->insert_dd('_figure', $data);
						}


						if($posDB ==false){
							if($posPDF !==false){
								//print_r('---'.$pathLi.'<br>');
								$pathLiPDF  = str_replace("'","&#039;",$pathLi);
								$data_P = array(
									'ContenuPAge' 	=> $pathLiPDF,
									'numeroPage' 	=> '1',
									'IDCours' 		=> $idCurs
								);
								$this->insert_dd('_page',$data_P);
							}
							if ($posFigDoc !== false){

								$docCvrt = utf8_encode ( $onpath );
								$docCvrt = iconv( "UTF-8", "UTF-8//TRANSLIT", $docCvrt );

								$docCvrt = HTTP_PLATFORM.$onpath;//'./uploads/Plateforme TRIAA Habib 2020/Platforme Accessanatomy/';
								$docCvrt 		= str_replace(" ","%20",$docCvrt);

								$PathDocc = strstr($pathLi, '/'.$get_TypeCurs_cur_org, true);
								$PathDocc = $PathDocc."/".$get_TypeCurs_cur_org."/";

								//print_r($PathDocc.'<br>');
								//	$OutPages = "uploads/Plateforme TRIAA Habib 2020/Platforme Accessanatomy/Anatomie humaine/A- Livres d'Anatomie/5-Membre supérieur/1-Embryologie/Cours/";
								$nameFile 	= $this->convertDoc($docCvrt,$PathDocc,$idCurs,0);//
							}

							$data_Chap = array('NbreCours' 	=> '1');
							$this->db->where('IDChapitre', $idChap);
							$this->db->update('_chapitre', $data_Chap);
						}
					}
					if($get_TypeCurs_cur=="RESUME")
					{	//print_r($one.'-'.$idCurs);print_r("***************");
						$typeCurs= str_replace("/","",utf8_encode($one)) ;
						$pathLi  = str_replace("//","/",utf8_encode($onpath));
						$pathLi  = str_replace("\\","",$pathLi);
						$pathLi  = substr($pathLi, 1);

						$posFigPng = strpos(strtoupper($typeCurs),'.PNG');
						$posFigJpg = strpos(strtoupper($typeCurs),'.JPG');
						$posFigDoc = strpos(strtoupper($typeCurs),'.DOC');
						$posDB 	   = strpos(strtoupper($one),'.DB');
						$posPDF	   = strpos(strtoupper($one),'.PDF');
						if ($posFigPng !== false || $posFigJpg !== false) {
							$pathLiFig  = str_replace("'","&#039;",$pathLi);

							$encryptFigure 		= HTTP_PLATFORM.$onpath;
							$encryptFigure 		= str_replace(" ","%20",$encryptFigure);
							//$encryptFigure 		= str_replace("'","&#039;",$encryptFigure);
							$encryptFigure = utf8_encode ( $encryptFigure );
							$encryptFigure = iconv( "UTF-8", "UTF-8//TRANSLIT", $encryptFigure );
							//print_r($encryptFigure."***********");
							$curr_f1 			= file_get_contents($encryptFigure);
							$imageData 			= base64_encode($curr_f1);

							$data = array(
								'TitreFigure' 	=> $typeCurs,
								'UrlFigure' 	=> $pathLiFig,
								'IDResume' 		=> $idCurs ,
								'encryptFigure'	=> $imageData
							);
							$idFig = $this->insert_dd('_figure', $data);
						}

						if($posDB ==false){
							if($posPDF !==false){
								//print_r('---'.$pathLi.'<br>');
								$pathLiPDF  = str_replace("'","&#039;",$pathLi);
								$data_P = array(
									'ContenuPAge' 	=> $pathLiPDF,
									'numeroPage' 	=> '1',
									'IDResume' 		=> $idCurs
								);
								$this->insert_dd('_page',$data_P);
							}
							if ($posFigDoc !== false){
								$docCvrt = HTTP_PLATFORM.$onpath;//'./uploads/Plateforme TRIAA Habib 2020/Platforme Accessanatomy/';
								$docCvrt 		= str_replace(" ","%20",$docCvrt);
								//
								$PathDocc = strstr($pathLi, '/'.$get_TypeCurs_cur_org, true);
								$PathDocc = $PathDocc."/".$get_TypeCurs_cur_org."/";
								//print_r($PathDocc.'<br>'); //$get_TypeCurs_cur_org = le nom de dossier qui existe saous l platforme
								//	$OutPages = "uploads/Plateforme TRIAA Habib 2020/Platforme Accessanatomy/Anatomie humaine/A- Livres d'Anatomie/5-Membre supérieur/1-Embryologie/Cours/";
								$nameFile 	= $this->convertDoc($docCvrt,$PathDocc,0,$idCurs);//
							}

							$data_Chap = array('NbreResume' 	=> '1');
							$this->db->where('IDChapitre', $idChap);
							$this->db->update('_chapitre', $data_Chap);
						}
					}
					if($get_TypeCurs_cur=="QROC" || $get_TypeCurs_cur=="SAQ")
					{
						$pathLi  = str_replace("//","/",utf8_encode($onpath));
						$pathLi  = str_replace("\\","",$pathLi);
						$pathLi  = substr($pathLi, 1);


						$docCvrt = HTTP_PLATFORM.$onpath;//'./uploads/Plateforme TRIAA Habib 2020/Platforme Accessanatomy/';
						$docCvrt 		= str_replace(" ","%20",$docCvrt);
						//print_r($docCvrt.'<br>');
						$nameFile 	= $this->convertDoc($docCvrt,"0",0,0);//
						$list 		= $this->read_docx(FCPATH.'PlatFormeConvert/'.$nameFile);
						//print_r('-'.$extracted_plaintext.'<br>');
						$bdd_dataQ 	= array();$bdd_dataR = '';$is_q = true;
						$is_r 		= false;
						$numQ 		= 1 ;$TitreQroc = '';
						$content 	= str_replace('</w:r></w:p></w:tc><w:tc>', '<br>', $list);
						$content 	= str_replace('</w:r></w:p>', "\r\n", $content);

						$lign = implode("\r\n", $content);
						$lign = strip_tags($lign);

						$numBeg = 1;$numEnd = 2;$quitQuest = false;
						$is_quest = $this->getString("@@@@",$numBeg."-","@@@@".$lign);
						//print_r('**************************'.$is_quest.'----------------------------');
						$TitreQroc		= str_replace("@@@@", "", $is_quest);
						$listTitreQrc 	= explode("\r\n",$TitreQroc);
						if(sizeof($listTitreQrc)>2){$TitreQroc = $listTitreQrc[2];}


						$is_quest 	= $this->getString($numBeg."-",$numEnd."-",$lign);
						while($is_quest != '' && $quitQuest==false){
							$is_quest = $this->getString($numBeg."-",$numEnd."-",$lign);
							if($is_quest==''){
								$is_quest 	= $this->getString($numBeg."-","@@@@",$lign."@@@@");
								$quitQuest 	= true ;
							}

							//print_r('**************************'.$is_quest.'----------------------------');
							//print_r('**************************'.$this->getString($numBeg."-","Réponse",$is_quest).'----------------------------');
							//print_r('**************************'.strstr($is_quest,'Réponse').'----------------------------');
								//$quest 	= $this->getString($numBeg."-","Réponse",$is_quest);Proposition : 1
							$proposition1 = '';$proposition2 = '';
							$questAll 	= $this->getString($numBeg."-",$this->lang->line('params_reponse'),$is_quest);
							if(strpos($questAll,$this->lang->line('params_propos1'))!==false) {

								$quest 			= $this->getString($numBeg."-",$this->lang->line('params_propos1'),(string)$is_quest);
								$proposition1 	= $this->getString($this->lang->line('params_propos1'),$this->lang->line('params_propos2'),(string)$is_quest);
								$proposition2 	= $this->getString($this->lang->line('params_propos2'),$this->lang->line('params_reponse'),(string)$is_quest);
								//print_r('**************************'.(string)$questAll.'----------------------------');
							}else{
								$quest 	= $this->getString($numBeg."-",$this->lang->line('params_reponse'),$is_quest);
							}

								//$resp 	= strstr($is_quest,'Réponse');
								$listResp 	= explode("\r\n",strstr($is_quest,$this->lang->line('params_reponse')));
								$resp 		= '';
								foreach ($listResp as $num =>$onRes)
								{if($num>0){
									if($proposition1==''){$resp = $resp.$onRes.'<br>';}else{$resp = $resp.$onRes.'&#10;';}
								}}

								$listProp1	= explode("\r\n",$proposition1);
								$prop1		= '';
								foreach ($listProp1 as $num =>$onRes)
								{if($num>0){	$prop1 = $prop1.$onRes.'&#10;';}}

								$listProp2	= explode("\r\n",$proposition2);
								$prop2		= '';
								foreach ($listProp2 as $num =>$onRes)
								{if($num>0){	$prop2 = $prop2.$onRes.'&#10;';}}

								$numBeg++;$numEnd++;
								$bdd_dataQ[] = array("id" => $numBeg, "quest" => $quest , "resp"=>$resp , "proposition1"=>$prop1  , "proposition2"=>$prop2 );
						}
						foreach ($bdd_dataQ as $onQ)
						{
							if(strlen(substr($onQ["resp"], 0, 3))==3)
							{ $onQ["resp"] = str_replace("( ","",$onQ["resp"]); }

							$data_QR = array(
								'name' 				=> $onQ["quest"],
								'ResponseQuestion' 	=> $onQ["resp"],
								'type' 				=> 'text',
								'OperationType' 	=> 'QROC',
								'proposition1' 		=> $onQ["proposition1"],
								'proposition2' 		=> $onQ["proposition2"],
								'IDChapitre' 		=> $idChap
							);
							$this->insert_dd('_questiontype',$data_QR);
							$data_Chap = array('NbreQroc' 	=> '1' , 'TitreQroc' => $TitreQroc);
							$this->db->where('IDChapitre', $idChap);
							$this->db->update('_chapitre', $data_Chap);

						}


						//fclose($myfile);
						//print_r("**********************************".'<br>');
					}
					if($get_TypeCurs_cur=="QCM" || $get_TypeCurs_cur=="MCQ")
					{
						$pathLi  = str_replace("//","/",utf8_encode($onpath));
						$pathLi  = str_replace("\\","",$pathLi);
						$pathLi  = substr($pathLi, 1);


						$docCvrt 	= HTTP_PLATFORM.$onpath;//'./uploads/Plateforme TRIAA Habib 2020/Platforme Accessanatomy/';
						$docCvrt 	= str_replace(" ","%20",$docCvrt);
						//print_r($docCvrt.'<br>');
						$nameFile 	= $this->convertDoc($docCvrt,"0",0,0);//
						$list 		= $this->read_docx(FCPATH.'PlatFormeConvert/'.$nameFile);
						//print_r('-'.$extracted_plaintext.'<br>');
						$bdd_dataQ 	= array();$bdd_dataR = '';$is_q = true;
						$is_r 		= false;
						$numQ 		= 1 ;$TitreQroc = '';
						$content 	= str_replace('</w:r></w:p></w:tc><w:tc>', '<br>', $list);
						$content 	= str_replace('</w:r></w:p>', "\r\n", $content);

						$lign = implode("\r\n", $content);
						$lign = strip_tags($lign);

						$numBeg 		= 1;$numEnd = 2;$quitQuest = false;
						$is_quest 		= $this->getString("@@@@",$numBeg."-","@@@@".$lign);
						$TitreQcm		= str_replace("@@@@", "", $is_quest);
						$listTitreQcm 	= explode("\r\n",$TitreQcm);
						if(sizeof($listTitreQcm)>2){$TitreQcm = $listTitreQcm[2];}

						//print_r($listTitreQcm);
						//print_r('**************************'.$TitreQcm.'----------------------------');
						//print_r('**************************'.$is_quest.'----------------------------');
						$is_quest 	= $this->getString($numBeg."-",$numEnd."-",$lign);
						while($is_quest != '' && $quitQuest==false){
							$is_quest = $this->getString($numBeg."-",$numEnd."-",$lign);
							if($is_quest==''){
								$is_quest 	= $this->getString($numBeg."-","@@@@",$lign."@@@@");
								$quitQuest 	= true ;
							}

							//print_r('**************************'.$is_quest.'----------------------------<br>');
							//print_r('**************************'.$this->getString($numBeg."-","A-",$is_quest).'----------------------------<br>');
							//print_r('**************************'.strstr($is_quest,'Réponse').'----------------------------');
							//$quest 	= $this->getString($numBeg."-","Réponse",$is_quest);Proposition : 1

							$quest 			= $this->getString($numBeg."-",":",(string)$is_quest); // question
							$repons_Key		= $this->getString(":","A-",(string)$is_quest); // reponse A;C;E
							$proposQcm   	= $this->getString("A-","@@@@",(string)$is_quest."@@@@"); // propositions
							//print_r('**************************'.$proposition2.'----------------------------<br>');
								// BEGIN ici on traite les reponses !!!!!

							//print_r('**************************');

							//$lign_ = strip_tags($lign_);
							//print_r(strip_tags($proposQcm,'<br>'));
							$listPropos = explode("\r\n",$proposQcm) ;

							$lign_Resp 			= str_replace(" ","-",(string)$repons_Key);
							$lign_Resp 			= str_replace(";","-",(string)$lign_Resp);
							$lign_Resp 			= str_replace(":","-",(string)$lign_Resp);
							$lign_Resp 			= "-".$lign_Resp."-";

							$lign_Props 		= '';
							$lign_Rep			= '';
							foreach ($listPropos as $num => $itemProp) {

								$lign_Props 	= $lign_Props."@||@" .$itemProp ;

								$startPosssss 	= "-".substr($itemProp, 0, 1);
								if (strpos(strtoupper($lign_Resp),strtoupper($startPosssss))!==false) {
									$lign_Rep 	= $lign_Rep."@||@" .$itemProp ;
								}
							}
							$lign_Props 		= "@@@@".$lign_Props."@@@@";
							$lign_Props   		= str_replace("@@@@@||@","",$lign_Props);
							$lign_Props   		= str_replace("@||@@@@@","",$lign_Props);
							//print_r($lign_Resp);


								//print_r('----------------------------<br>');

								// END reponses

							$numBeg++;$numEnd++;

							$bdd_dataQ[] = array("id" => $numBeg, "quest" => $quest , "proposQcm"=>$lign_Props , "resp"=>$lign_Rep , "repons_Key" => $repons_Key );
						}
						foreach ($bdd_dataQ as $onQ)
						{

							$data_QR = array(
								'name' 				=> $onQ["quest"],
								'skill' 			=> $onQ["proposQcm"],
								'ResponseQuestion' 	=> $onQ["resp"],
								'ResponseKey' 		=> str_replace(":","",$onQ["repons_Key"]),
								'type' 				=> 'checkbox',
								'OperationType' 	=> 'QCM',
								'IDChapitre' 		=> $idChap
							);
							$this->insert_dd('_questiontype',$data_QR);
							$data_Chap = array('NbreQcm' 	=> '1' , 'TitreQcm' => $TitreQcm);
							$this->db->where('IDChapitre', $idChap);
							$this->db->update('_chapitre', $data_Chap);

						}
					}
				}

				$level++ ;
			}
		}

		$arr = array();
//		if(sizeof($file_paths) > 0) {

			$arr[] = array("id" => '1', "desc" => '');
//		}else{
//			$arr[] = array("id" => '-1', "desc" => "Aucune données trouvées");
//		}
		echo json_encode($arr);
		exit;
	}
	function getString($start, $end, $str){
		$value = $str;
		$value = strstr($value, $start); //gets all text from needle on
		$value = strstr($value, $end, true);
		return $value;
	}
	public function insert_dd($tablename , $data)
	{
		$this->db->insert($tablename, $data);
		return $this->db->insert_id();
	}

	public function switchLang($lang = "") {

		$this->lang->load('content' , $lang=='' ? 'FR' : $lang) ;
		$this->session->set_userdata('site_lang', $lang);

		if($lang=='FR') {$this->session->set_userdata('site_lang_lib', 'Français');}
		if($lang=='EN') {$this->session->set_userdata('site_lang_lib', 'English');}
		if($lang=='DE'  ) {$this->session->set_userdata('site_lang_lib', 'German');}

		//header(base_url());
		redirect(base_url().$this->lang->line('siteLang').'login');
	}
	public function setLang() {

		$lang = $this->session->userdata('site_lang');

		if($lang=='') {$this->session->set_userdata('site_lang_lib', 'Français');$lang='FR';}
		if($lang=='FR') {$this->session->set_userdata('site_lang_lib', 'Français');$lang='FR';}
		if($lang=='EN') {$this->session->set_userdata('site_lang_lib', 'English');$lang='EN';}
		if($lang=='DE') {$this->session->set_userdata('site_lang_lib', 'German');$lang='DE';}
		$this->session->set_userdata('site_lang', $lang);
		$this->lang->load('content' , $lang=='' ? 'FR' : $lang) ;

	}

	public function login() {

        $this->get_social_links();
        
		if( $this->session->userdata('logged_in') ){
			//redirect('dashboard');
			//$this->setParamsAutoFromFloders();
			$arr['listCat'] = $this->getListCategory();
            //log_message("error", "error1");
            // exit;

            $this->db->select('*');
            $this->db->from('actualites');
            $res = $this->db->get()->result_array();
    
            $arr['listActualites'] 	= $res;
            $arr['page'] = 'login';
//			$this->load->view('page_home', $arr);
            if($this->session->userdata('EstAdmin') ==1) {
                $this->load->view($this->getTypePlatform() ? 'v1_page_home' : 'page_home', $arr);
            }else{
                $this->session->set_userdata('typePlatform',true);
                $this->load->view($this->getTypePlatform() ? 'v1_page_home' : 'v1_page_home', $arr);
            }

        }else{

			//$this->setParamsAutoFromFloders();
			$arr['listCat'] = $this->getListCategory();
            // exit;
          
            $this->db->select('*');
            $this->db->from('actualites');
            $res = $this->db->get()->result_array();
    
            $arr['listActualites'] 	= $res;
            $arr['page'] = 'login';
            
            //log_message("error", json_encode($arr));
            
//			$this->load->view('page_home', $arr);
            $this->load->view($this->getTypePlatform() ? 'v1_page_home' : 'v1_page_home', $arr);
		}

	}

    public function pageCategory($url) {

        $lang = $this->session->userdata('site_lang');
        $json = json_decode(file_get_contents('./assets/urls.json'), true);
        $isValide = false;
        $objetURL = [];

        for ($i = 0; $i < sizeof($json); $i++){
            if($json[$i]['url'] == $url){
                $isValide = true;
                if($json[$i]['id'] == $json[$i][$lang.'_id']){
                    $objetURL = $json[$i];
                }else{
                    for ($j = 0; $j < sizeof($json); $j++) {
                        if($json[$j]['id'] == $json[$i][$lang.'_id']){
                            redirect($lang.'/category/'.$json[$j]['url']);
                        }
                    }
                }
            }
        }     
        
      
        if($isValide == false){
            if($lang == "EN"){
                redirect('EN/category/'.$json[1]['url']);
            }else{
redirect('FR/category/'.$json[0]['url']);
            }
        }

		if( $this->session->userdata('logged_in') ){
			//redirect('dashboard');
			//$this->setParamsAutoFromFloders();
			$arr['listCat'] = $this->getListCategory();
               
            
            $arr['listCat2'] = $this->getListCategoryParametree($objetURL[$lang.'_id']);
            $arr['page'] = 'login';
            
$arr['idCategorySelected'] = $objetURL['id'];
           // print_r($arr['listCat2']);
		
			$this->load->view('page_category', $arr);
		}else{

			//$this->setParamsAutoFromFloders();
			$arr['listCat'] = $this->getListCategory();
            $arr['listCat2'] = $this->getListCategoryParametree($objetURL[$lang.'_id']);
            
            $arr['page'] = 'login';

$arr['idCategorySelected'] = $objetURL['id'];
          //  print_r($arr['listCat2']);
			
			$this->load->view('page_category', $arr);
		}

	}


	public function forgot_password() {

		$arr['page'] = 'forgot password';
		$this->load->view('forgot_password', $arr);

	}

    public function forgot_password_send() {

        //log_message('error', "hi" );

        $arr 		= array();
        $errMsg 	= '';
        $user 		= $_POST["inputEmail"];
        if (trim($user) == "")
        {$errMsg = $errMsg.'- '.$this->lang->line('email').' <br>';}
        if($errMsg==''){

            $this->db->select('*');
            $this->db->from('users');
            $this->db->Where("Email = '$user'");
            $res = $this->db->get()->result_array();
            if(count($res) > 0){

                $char_nums 			= "0123456789";
                $password_num 		= substr(str_shuffle($char_nums), 0, 2);
                $char_special 		= "@#$%&*";
                $password_special 	= substr(str_shuffle($char_special), 0, 1);
                $char_cap 			= "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
                $password_cap 		= substr(str_shuffle($char_cap), 0, 1);
                $chars 				= "abcdefghijklmnopqrstuvwxyz";
                $password_send 		= substr(str_shuffle($chars), 0, 2);
                $password_form 		= $password_send.$password_cap.$password_num.$password_special;
                $password 			= MD5($password_form);
                $data 				= array( 'MotDePasse' => $password );
                $id 				= $res[0]["users_ID"];

                $this->db->where("users_ID = $id");
                $this->db->update('users', $data);

                $config = Array(
                    'mailtype'  => 'html',
                    'charset'   => 'UTF-8'
                );
                $this->load->library('email', $config);
                // $this->load->library('email');

                $mail = $this->email;
                $mail->from('noreply@accessanatomy.com', "Access Anatomy");
                $mail->to($user);
                $mail->subject('Login Details Sent By Access Anatomy');

                $message = "<table width='80%' border='0'>";

                $message .= "<tr><td colspan='2'>".$this->lang->line('mail_insc_1')."<br><br> ";
                $message .= $this->lang->line('mail_insc_8')."<br><br></td></tr>";
                $message .= "<tr><td>".$this->lang->line('mail_insc_4')."</td><td>:  ".$user . " </td></tr>";
                $message .= "<tr><td>".$this->lang->line('mail_insc_5')."</td><td>: ".$password_form. " </td></tr>";

                $message .= "<tr><td colspan='2'><br><br><br>".$this->lang->line('mail_insc_6')."<br> ".$this->lang->line('mail_insc_7')."</td></tr>";

                $message .= "</table>";

                $mail->message($message);

                $sent = $mail->send();

                //This is optional - but good when you're in a testing environment.
                if(isset($sent)){
                    $arr[] = array("id" => '1', "desc" => $this->email->print_debugger());
                }else{
                    $arr[] = array("id" => '-1', "desc" => 'It did not send. <br>'.$this->email->print_debugger());
                }

            }else{$arr[] = array("id" => '-1', "desc" => 'Email not found');}

        }else{$arr[] = array("id" => '-1', "desc" => 'Not valid Email : <br>'.$errMsg);}

        echo json_encode($arr);
        exit;

    }

public function login_process() {
    // === AJOUTEZ LE HEADER JSON ===
header('Access-Control-Allow-Origin: http://localhost');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Content-Type, X-Requested-With');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');    
    // === LOGS DE DEBUG ===
    log_message('debug', '=== DEBUT login_process ===');
    log_message('debug', 'POST data: ' . json_encode($_POST));
    log_message('debug', 'Current Session ID: ' . $this->session->userdata('session_id'));
    
    $user = isset($_POST["email"]) ? $_POST["email"] : '';
    $pass_md = isset($_POST["password"]) ? MD5($_POST["password"]) : '';
    
    log_message('debug', 'Email: ' . $user);
    log_message('debug', 'Pass MD5: ' . $pass_md);
    
    $arr = array();
    $this->db->select('*');
    $this->db->from('users');
    $this->db->where('Email', $user); // SÉCURISÉ
    $this->db->where('MotDePasse', $pass_md); // SÉCURISÉ

    $res = $this->db->get()->result_array();
    
    log_message('debug', 'Résultats trouvés: ' . count($res));

    if(count($res) > 0){
        if($res[0]["Bloque"] == 0){
            $this->load->helper('string');
            $tokenPass = random_string('alnum', 200);
            $data = array('tokenPass' => $tokenPass);
            $log_id = $res[0]["users_ID"];
            $adminLog = $res[0]["EstAdmin"];
            
            $this->db->where("users_ID", $log_id);
            $this->db->update('users', $data);

            // SAVE CURRENT SESSION ID BEFORE SETTING DATA
            $current_session_id = $this->session->userdata('session_id');
            log_message('debug', 'Saving current session ID: ' . $current_session_id);
            
            // SET ALL SESSION DATA
            $this->session->set_userdata('user_id', $res[0]["users_ID"]);
            $this->session->set_userdata('logged_in', ucfirst($user));
            $this->session->set_userdata('logged_in_name', $res[0]["Nom"]);
            $this->session->set_userdata('passTok', $tokenPass);
            $this->session->set_userdata('EstAdmin', $adminLog);
            
            // RESTORE SESSION ID TO PREVENT REGENERATION
            $this->session->set_userdata('session_id', $current_session_id);
            
            log_message('debug', 'Session data set');
            log_message('debug', 'user_id: ' . $this->session->userdata('user_id'));
            log_message('debug', 'EstAdmin: ' . $this->session->userdata('EstAdmin'));
            log_message('debug', 'New Session ID: ' . $this->session->userdata('session_id'));
        }
        $arr[] = array("id" => '1', "desc" => '');
    } else {
        $arr[] = array("id" => '-1', "desc" => $this->lang->line('verif_log'));
    }
    
    log_message('debug', 'Réponse JSON: ' . json_encode($arr));
    echo json_encode($arr);
    exit;
}
   public function compte_process() {

    $errMsg = '';
    $user       = trim($_POST["inputEmail"]);
    $pass       = trim($_POST["inputPassword"]);
    $passCF     = trim($_POST["inputPasswordCF"]);

    $userCF     = trim($_POST["inputEmailCF"]);
    $etablss    = trim($_POST["inputEtab"]);
    $name       = trim($_POST["inputName"]);
    $LastName   = trim($_POST["inputPren"]);
    $adress     = trim($_POST["inputAddress"]);
    $country    = trim($_POST["inputState"]);
    $city       = trim($_POST["inputCity"]);
    $zipCode    = trim($_POST["inputZip"]);
    $Profess    = trim($_POST["inputProfess"]);
    $IdUSR      = trim($_POST["inputIDF"]);
    $checkLegal = isset($_POST["inputLegal"]);

    // Vérifications
    if($user !== $userCF) $errMsg .= '- '.$this->lang->line('email').' <br>';
    if($pass !== $passCF) $errMsg .= '- '.$this->lang->line('passwd').' <br>';
    if(strlen($name)==0) $errMsg .= '- '.$this->lang->line('name').' <br>';
    if(strlen($LastName)==0) $errMsg .= '- '.$this->lang->line('lastname').' <br>';
    if(!$checkLegal) $errMsg .= '- '.$this->lang->line('legal').' <br>';

    if($errMsg != '') {
        echo json_encode([["id"=>'-1', "desc"=>$this->lang->line('mail_msg_ch').'<br>'.$errMsg]]);
        exit;
    }

    // Vérifier si email existe déjà
    $this->db->select('*')->from('users')->where('Email', $user);
    $res = $this->db->get()->result_array();

    if(count($res) > 0){
        echo json_encode([["id"=>'-1', "desc"=>$this->lang->line('mail_msg_exist').'<br>'.$user]]);
        exit;
    }

    // Préparer les données pour insertion
    $this->load->helper('string');

    $tokenPass = bin2hex(random_bytes(20));       // token sécurisé
    $login_    = 'usr'.random_string('numeric',5);

    $data = array(
        'MotDePasse'        => md5($pass),
        'Nom'               => $name,
        'Prenom'            => $LastName,
        'Adresse1'          => $adress ?: '',
        'Email'             => $user,
        'CodePostal'        => $zipCode ?: '',
        'Ville'             => $city ?: '',
        'Telephone'         => '',
        'IDEtablissement'   => $etablss ?: 1,
        'Profession'        => $Profess ?: 'Etudiant',
        'login'             => $login_,
        'Pays'              => $country ?: 'Tunisie',
        'verifie'           => 0,
        'Bloque'            => 0,
        'createdate'        => date('Y-m-d H:i:s'),
        'IdentifiantUSR'    => $IdUSR ?: 'USR'.random_string('numeric',5),
        'tokenPass'         => $tokenPass
    );

    // Insérer dans la table
    if(!$this->db->insert('users', $data)){
        $error = $this->db->error();
        header('Content-Type: application/json'); // forcer JSON
        echo json_encode([["id"=>'-1', "desc"=>"Erreur MySQL: ".$error['message']]]);
        exit;
    }

    // Envoi email
    $config = array('mailtype'=>'html','charset'=>'UTF-8');
    $this->load->library('email', $config);
    $this->email->from('noreply@accessanatomy.com','Access Anatomy');
    $this->email->to($user);
    $this->email->subject('Login Details Sent By Access Anatomy');

    $message = "<p>".$this->lang->line('mail_insc_1')."</p>";
    $message .= "<p>".$this->lang->line('mail_insc_2')."</p>";
    $message .= "<p>".$this->lang->line('mail_insc_3')."</p>";
    $message .= "<p><b>Login:</b> ".$user."<br><b>Password:</b> ".$pass."</p>";
    $message .= "<p>".$this->lang->line('mail_insc_6')."</p>";

    $this->email->message($message);
    $sent = $this->email->send();

    if($sent){
        echo json_encode([["id"=>'1', "desc"=>"Compte créé avec succès."]]);
    }else{
        echo json_encode([["id"=>'-1', "desc"=>"Erreur email: ".$this->email->print_debugger()]]);
    }

    exit;
}


    public function settingFigures($IDChapitre){
        $selectDesc = '*';
//        $this->db->select($selectDesc);
//		$this->db->select('CAST(SUBSTRING_INDEX(titre, ".", 1) as SIGNED INTEGER ) AS ord,id,image,titre,textGauche,textDroite,IDChapitre,pathAudio');
        $this->db->select('CAST(SUBSTRING(titre, LOCATE(".", titre) + 1, LOCATE("-", titre) - LOCATE(".", titre) - 1) AS UNSIGNED) AS first_number,id,image,titre,textGauche,textDroite,IDChapitre,pathAudio');
        $this->db->from('figures');
        $this->db->where("IDChapitre = ".$IDChapitre);
        $this->db->order_by("first_number" ,"ASC");
        $res = $this->db->get()->result_array();
   
        $this->db->select('*');
        $this->db->from('_chapitre ,_livre , _theme');
        $this->db->Where("IDChapitre = '$IDChapitre' AND _chapitre.IDLivre = _livre.IDLivre AND _theme.IDTheme = _livre.IDTheme");
        $resChap = $this->db->get()->result_array();

        $arr['OneBook'] 	= $resChap;
        $arr['page'] 		= 'test';
        $arr['listCat'] 	= $this->getListCategory();
  
        $arr['listFigures'] = $res;
        $arr['IDChapitre'] = $IDChapitre;

        $this->load->view('settingFigures',$arr);
    }

    public function getFigure($idFigure) {
        $query = $this->db->query('SELECT * FROM figures WHERE id ='.$idFigure);
        $res = $query->result();
      
        $textGauche = $res[0]->textGauche;
        $textDroite = $res[0]->textDroite;

        $arrayTextGauche = $this->getArrayOfString($textGauche, "\n");
        $arrayTextDroite = $this->getArrayOfString($textDroite, "\n");

        $IDChapitre  = $res[0]->IDChapitre;
        $this->db->select('*');
        $this->db->from('_chapitre ,_livre , _theme');
        $this->db->Where("IDChapitre = '$IDChapitre' AND _chapitre.IDLivre = _livre.IDLivre AND _theme.IDTheme = _livre.IDTheme");
        $resChap = $this->db->get()->result_array();

        $arr['OneBook'] 	= $resChap;
        $arr['listCat'] 	= $this->getListCategory();
  
        $arr['page'] = 'page_test_Figure';
        $arr['titre'] = $res[0]->titre;
        $arr['textGauche'] = $arrayTextGauche;
        $arr['textDroite'] = $arrayTextDroite;
        $arr['image'] = $res[0]->image;
        $arr['idFigure'] = $idFigure;
       
      	$this->load->view('testFigure', $arr);
		
	}


    public function getListCalqueByChapitres($listIdChapitre) {

        $arrayChapitres = $this->getArrayOfParametresUrl($listIdChapitre);

        if(sizeof($arrayChapitres) === 0){
            $arr['listCat'] = $this->getListCategory();
            $arr['page'] = 'page_home';
//            $this->load->view('page_home', $arr);
            $this->load->view($this->getTypePlatform() ? 'v1_page_home' : 'page_home', $arr);
            return;
        }


        $arrayFigures = [];
        $compteur = 0;
        for($i = 0; $i < sizeof($arrayChapitres); $i++){

            $this->db->select('CAST(SUBSTRING_INDEX(titre, ".", 1) as SIGNED INTEGER ) AS ord,id,image,titre,textGauche,textDroite,IDChapitre,pathAudio');
            $this->db->from('figures');
            $this->db->where("IDChapitre = ".$arrayChapitres[$i]['chapitre']);
            $this->db->order_by("ord" ,"DESC");
            $res = $this->db->get()->result_array();

//            $query = $this->db->query('SELECT * FROM figures WHERE IDChapitre ='.$arrayChapitres[$i]['chapitre'].' ORDER BY titre ASC');
//            $res = $query->result();



            foreach ($res as $figure) {

//				log_message('error',"*******>>>111111111111111111111111111>>>>******");
////				log_message('error',print_r($figure, true));
//				log_message('error',$figure['id']);
//				log_message('error',"*******>>>2222222222222222222222222222>>>>******");
                // Get the text values (ensure these exist to prevent errors)
                $textGauche = isset($figure->textGauche) ? $figure->textGauche : $figure['textGauche'];
                $textDroite = isset($figure->textDroite) ? $figure->textDroite : $figure['textDroite'];

                // Split the text into arrays based on newlines
                $arrayTextGauche = $this->getArrayOfString($textGauche, "\n");
                $arrayTextDroite = $this->getArrayOfString($textDroite, "\n");



                // Add data to the figures array
                $arrayFigures[$compteur] = [
                    'textGauche' => $arrayTextGauche,
                    'textDroite' => $arrayTextDroite,
                    'titre' => isset($figure->titre) ? $figure->titre : $figure['titre'],
                    'image' => isset($figure->image) ? $figure->image : $figure['image'],
                    'pathAudio' => isset($figure->pathAudio) ? $figure->pathAudio : $figure['pathAudio'],
                    'idFigure' => isset($figure->id) ? $figure->id : $figure['id'],
                ];
//				log_message('error',"*******>>>3333333333333333333333333333>>>>******" );
////				log_message('error',$arrayTextGauche );
//				log_message('error',"*******>>>44444444444444444444444444444>>>>******" );
                // Increment the counter
                $compteur++;
            }


//            for($j = 0; $j < sizeof($res); $j++){
//                $textGauche = $res[$j]->textGauche;
//                $textDroite = $res[$j]->textDroite;
//                $arrayTextGauche = $this->getArrayOfString($textGauche, "\n");
//                $arrayTextDroite = $this->getArrayOfString($textDroite, "\n");
//                $arrayFigures[$compteur]['textGauche'] = $arrayTextGauche;
//                $arrayFigures[$compteur]['textDroite'] = $arrayTextDroite;
//                $arrayFigures[$compteur]['titre'] = $res[$j]->titre;
//                $arrayFigures[$compteur]['image'] = $res[$j]->image;
//                $arrayFigures[$compteur]['pathAudio'] = $res[$j]->pathAudio;
//                $arrayFigures[$compteur]['idFigure'] = $res[$j]->id;
//                $compteur++;
//            }

        }

        $IDChapitre  = $arrayChapitres[0]['chapitre'];
        $this->db->select('*');
        $this->db->from('_chapitre ,_livre , _theme');
        $this->db->Where("IDChapitre = '$IDChapitre' AND _chapitre.IDLivre = _livre.IDLivre AND _theme.IDTheme = _livre.IDTheme");
        $resChap = $this->db->get()->result_array();

        $this->session->set_userdata('curs_id', 'curs_'.$IDChapitre);

        $idLivr 			= $resChap[0]["IDLivre"];
        $listChap 			= $this->listChaptCours($idLivr);

        $arr['listChap'] 	= $listChap;
        $arr['OneBook'] 	= $resChap;
        $arr['listCat'] 	= $this->getListCategory();

        $arr['arrayFigures'] = $arrayFigures;
        $arr['page'] = 'listCalqueFigure';
        $arr['idFigure'] = $IDChapitre;

//        $this->load->view('listCalqueFigure', $arr);
        $this->load->view($this->getTypePlatform() ? 'v1_listCalqueFigure' : 'listCalqueFigure', $arr);
    }

    public function getListCalqueByChapitres___org($listIdChapitre) {
        
        $arrayChapitres = $this->getArrayOfParametresUrl($listIdChapitre);
        
        if(sizeof($arrayChapitres) === 0){
            $arr['listCat'] = $this->getListCategory();
            $arr['page'] = 'page_home';
            $this->load->view('page_home', $arr);
            return;
        }
      
        
        $arrayFigures = [];
        $compteur = 0;
        for($i = 0; $i < sizeof($arrayChapitres); $i++){

            $this->db->select('CAST(SUBSTRING_INDEX(titre, ".", 1) as SIGNED INTEGER ) AS ord,id,image,titre,textGauche,textDroite,IDChapitre,pathAudio');
            $this->db->from('figures');
            $this->db->where("IDChapitre = ".$arrayChapitres[$i]['chapitre']);
            $this->db->order_by("ord" ,"DESC");
            $res = $this->db->get()->result();

//            $query = $this->db->query('SELECT * FROM figures WHERE IDChapitre ='.$arrayChapitres[$i]['chapitre'].' ORDER BY titre ASC');
//            $res = $query->result();

            foreach ($res as $figure) {
                // Get the text values (ensure these exist to prevent errors)
                $textGauche = isset($figure->textGauche) ? $figure->textGauche : '';
                $textDroite = isset($figure->textDroite) ? $figure->textDroite : '';

                // Split the text into arrays based on newlines
                $arrayTextGauche = $this->getArrayOfString($textGauche, "\n");
                $arrayTextDroite = $this->getArrayOfString($textDroite, "\n");



                // Add data to the figures array
                $arrayFigures[$compteur] = [
                    'textGauche' => $arrayTextGauche,
                    'textDroite' => $arrayTextDroite,
                    'titre' => isset($figure->titre) ? $figure->titre : '',
                    'image' => isset($figure->image) ? $figure->image : '',
                    'pathAudio' => isset($figure->pathAudio) ? $figure->pathAudio : '',
                    'idFigure' => isset($figure->id) ? $figure->id : '',
                ];

                // Increment the counter
                $compteur++;
            }

//            for($j = 0; $j < sizeof($res); $j++){
//                $textGauche = $res[$j]->textGauche;
//                $textDroite = $res[$j]->textDroite;
//                $arrayTextGauche = $this->getArrayOfString($textGauche, "\n");
//                $arrayTextDroite = $this->getArrayOfString($textDroite, "\n");
//                $arrayFigures[$compteur]['textGauche'] = $arrayTextGauche;
//                $arrayFigures[$compteur]['textDroite'] = $arrayTextDroite;
//                $arrayFigures[$compteur]['titre'] = $res[$j]->titre;
//                $arrayFigures[$compteur]['image'] = $res[$j]->image;
//                $arrayFigures[$compteur]['pathAudio'] = $res[$j]->pathAudio;
//                $arrayFigures[$compteur]['idFigure'] = $res[$j]->id;
//                $compteur++;
//            }
            
        }

        $IDChapitre  = $arrayChapitres[0]['chapitre'];
        $this->db->select('*');
        $this->db->from('_chapitre ,_livre , _theme');
        $this->db->Where("IDChapitre = '$IDChapitre' AND _chapitre.IDLivre = _livre.IDLivre AND _theme.IDTheme = _livre.IDTheme");
        $resChap = $this->db->get()->result_array();

        $arr['OneBook'] 	= $resChap;
        $arr['listCat'] 	= $this->getListCategory();
  
        $arr['arrayFigures'] = $arrayFigures;
        $arr['page'] = 'listCalqueFigure';
        $arr['idFigure'] = $IDChapitre;
       
        $this->load->view('listCalqueFigure', $arr);
	}

    public function getListCalqueByChapitres2($listIdChapitre) {
        
        $arrayChapitres = $this->getArrayOfParametresUrl($listIdChapitre);
        
        if(sizeof($arrayChapitres) === 0){
            $arr['listCat'] = $this->getListCategory();
            $arr['page'] = 'page_home';
            $this->load->view('page_home', $arr);
            return;
        }
      
        
        $arrayFigures = [];
        $compteur = 0;
        for($i = 0; $i < sizeof($arrayChapitres); $i++){
            
            $query = $this->db->query('SELECT * FROM figures WHERE IDChapitre ='.$arrayChapitres[$i]['chapitre'].' ORDER BY titre ASC');
            $res = $query->result();
      
            for($j = 0; $j < sizeof($res); $j++){
                $textGauche = $res[$j]->textGauche;
                $textDroite = $res[$j]->textDroite;
                $arrayTextGauche = $this->getArrayOfString($textGauche, "\n");
                $arrayTextDroite = $this->getArrayOfString($textDroite, "\n");
                $arrayFigures[$compteur]['textGauche'] = $arrayTextGauche;
                $arrayFigures[$compteur]['textDroite'] = $arrayTextDroite;
                $arrayFigures[$compteur]['titre'] = $res[$j]->titre;
                $arrayFigures[$compteur]['image'] = $res[$j]->image;
                $arrayFigures[$compteur]['idFigure'] = $res[$j]->id;
                $compteur++;
            }
            
        }

        $IDChapitre  = $arrayChapitres[0]['chapitre'];
        $this->db->select('*');
        $this->db->from('_chapitre ,_livre , _theme');
        $this->db->Where("IDChapitre = '$IDChapitre' AND _chapitre.IDLivre = _livre.IDLivre AND _theme.IDTheme = _livre.IDTheme");
        $resChap = $this->db->get()->result_array();

        $idLivr 			= $resChap[0]["IDLivre"];
		$listChap 			= $this->listChaptCours($idLivr);

		$arr['listChap'] 	= $listChap;
        $arr['OneBook'] 	= $resChap;
        $arr['listCat'] 	= $this->getListCategory();
  
        $arr['arrayFigures'] = $arrayFigures;
        $arr['page'] = 'listCalqueFigure';
        $arr['idFigure'] = $IDChapitre;
       
        //		$this->load->view('listCalqueFigure', $arr);
		$this->load->view($this->getTypePlatform() ? 'v1_listCalqueFigure' : 'listCalqueFigure', $arr);
	}

    
    public function getListTestByChapitres3($listIdChapitre) {
        
       $arrayChapitres = $this->getArrayOfParametresUrl($listIdChapitre);
        
        if(sizeof($arrayChapitres) === 0){
            $arr['listCat'] = $this->getListCategory();
            $arr['page'] = 'page_home';
            $this->load->view('page_home', $arr);
            return;
        }
      
        
        $arrayFigures = [];
        $compteur = 0;
        for($i = 0; $i < sizeof($arrayChapitres); $i++){
            
            $query = $this->db->query('SELECT * FROM figures WHERE IDChapitre ='.$arrayChapitres[$i]['chapitre'].' ORDER BY titre ASC');
            $res = $query->result();

            for($j = 0; $j < sizeof($res); $j++){
                $textGauche = $res[$j]->textGauche;
                $textDroite = $res[$j]->textDroite;
                $arrayTextGauche = $this->getArrayOfString($textGauche, "\n");
                $arrayTextDroite = $this->getArrayOfString($textDroite, "\n");
                $arrayFigures[$compteur]['textGauche'] = $arrayTextGauche;
                $arrayFigures[$compteur]['textDroite'] = $arrayTextDroite;
                $arrayFigures[$compteur]['titre'] = $res[$j]->titre;
                $arrayFigures[$compteur]['image'] = $res[$j]->image;
                $arrayFigures[$compteur]['idFigure'] = $res[$j]->id;
                $compteur++;
            }
            
        }

        $IDChapitre  = $arrayChapitres[0]['chapitre'];
        $this->db->select('*');
        $this->db->from('_chapitre ,_livre , _theme');
        $this->db->Where("IDChapitre = '$IDChapitre' AND _chapitre.IDLivre = _livre.IDLivre AND _theme.IDTheme = _livre.IDTheme");
        $resChap = $this->db->get()->result_array();

        $arr['OneBook'] 	= $resChap;
        $arr['listCat'] 	= $this->getListCategory();
  
        $arr['arrayFigures'] = $arrayFigures;
        $arr['page'] = 'listTestFigure';
        $arr['idFigure'] = $IDChapitre;
       
        $this->load->view('listTestFigure2', $arr);
	}

    public function getListTestByChapitres4($listIdChapitre) {
        
        $arrayChapitres = $this->getArrayOfParametresUrl($listIdChapitre);
        
        if(sizeof($arrayChapitres) === 0){
            $arr['listCat'] = $this->getListCategory();
            $arr['page'] = 'page_home';
            $this->load->view('page_home', $arr);
            return;
        }
      
        
        $arrayFigures = [];
        $compteur = 0;
        for($i = 0; $i < sizeof($arrayChapitres); $i++){
            
        $query = $this->db->query('SELECT * FROM figures WHERE IDChapitre ='.$arrayChapitres[$i]['chapitre'].' ORDER BY titre ASC');
            $res = $query->result();
      
            for($j = 0; $j < sizeof($res); $j++){
                $textGauche = $res[$j]->textGauche;
                $textDroite = $res[$j]->textDroite;
                $arrayTextGauche = $this->getArrayOfString($textGauche, "\n");
                $arrayTextDroite = $this->getArrayOfString($textDroite, "\n");
                $arrayFigures[$compteur]['textGauche'] = $arrayTextGauche;
                $arrayFigures[$compteur]['textDroite'] = $arrayTextDroite;
                $arrayFigures[$compteur]['titre'] = $res[$j]->titre;
                $arrayFigures[$compteur]['image'] = $res[$j]->image;
                $arrayFigures[$compteur]['idFigure'] = $res[$j]->id;
                $compteur++;
            }
            
        }

        $IDChapitre  = $arrayChapitres[0]['chapitre'];
        $this->db->select('*');
        $this->db->from('_chapitre ,_livre , _theme');
        $this->db->Where("IDChapitre = '$IDChapitre' AND _chapitre.IDLivre = _livre.IDLivre AND _theme.IDTheme = _livre.IDTheme");
        $resChap = $this->db->get()->result_array();

        $arr['OneBook'] 	= $resChap;
        $arr['listCat'] 	= $this->getListCategory();
  
        $arr['arrayFigures'] = $arrayFigures;
        $arr['page'] = 'listTestFigure';
        $arr['idFigure'] = $IDChapitre;
       
        $this->load->view('listTestFigure2', $arr);
	}


    public function getArrayOfParametresUrl($parametresUrl){
        $arrayChapitres = []; 
        $compteur = 0;
        while (strlen($parametresUrl)>0) {

            $posInitial = 0;
            $pos1 = $this->positionString($parametresUrl, ".");
           
            //$textGauche = "";
            $mot = "";
            if($pos1 !== null){
                $mot = substr($parametresUrl, $posInitial, $pos1);
                $parametresUrl = substr($parametresUrl, $pos1 + 1);
            }else{
                $mot = substr($parametresUrl, $posInitial);
                $parametresUrl = "";
            }
            
            
            if(strlen($mot) > 0){
                $arrayChapitres[$compteur]["chapitre"] = $mot;
                $compteur++;
            }

        }

        return $arrayChapitres;

    }

    public function getArrayOfString($textGauche, $motFiltre){

//		log_message('error',"*******>>>111>>>>******".$textGauche);
        $textGauche = $this->deleteDoubleEspace($textGauche);
//        log_message('error',"*******>>>222>>>>******".$textGauche);
        $compteurGlobal = 1;
        $compter = 0;

        $compteur3in1 = 0;
        $arrayTextGauche3in1 = [];

        $arrayTextGauche = [];

        // Check if $textGauche is an array or string
        if (is_array($textGauche)) {
            // Handle the case where $textGauche is an array.
            // You could implode the array to a string if needed, or handle it differently.
            $textGauche = implode(" ", $textGauche); // Convert array to string (space-separated)
        }

        while (strlen($textGauche) > 0) {
            $posInitial = 0;
            $pos1 = $this->positionString($textGauche, $motFiltre);

            $mot = '';

            if ($pos1 !== null) {
                // Extract word before the filter position
                $mot = substr($textGauche, $posInitial, $pos1);
                $textGauche = substr($textGauche, $pos1 + 1);
            } else {
                // No more words found, take the remaining text
                $mot = substr($textGauche, $posInitial);
                $textGauche = ''; // No more text left
            }

            // Remove trailing space
            $mot = rtrim($mot);

            // Remove leading space
            $mot = ltrim($mot);

            if (strlen($mot) > 0) {
                // Add valid word to the array with its number
                $arrayTextGauche3in1[$compteur3in1]["mot"] = $mot;
                $arrayTextGauche3in1[$compteur3in1]["numero"] = $compteurGlobal;
                $compteur3in1++;
                $compteurGlobal++;
            }

            // Once 4 words are collected or no more text is left, store the words in the main array
            if ($compteur3in1 === 4 || (strlen($textGauche) === 0 && $compteur3in1 > 0)) {
                $arrayTextGauche[$compter] = $arrayTextGauche3in1;
                $compter++;
                $compteur3in1 = 0;
                $arrayTextGauche3in1 = []; // Reset temporary array
            }
        }


        return $arrayTextGauche;
    }
    public function getArrayOfString__org($textGauche, $motFiltre){

		//log_message('error',"*******>>>111>>>>******".$textGauche);
        $textGauche = $this->deleteDoubleEspace($textGauche);
//        log_message('error',"*******>>>222>>>>******".$textGauche);
        $compteurGlobal = 1;
        $compter = 0;
        
        $compteur3in1 = 0; 
        $arrayTextGauche3in1 = [];

        $arrayTextGauche = []; 
        while (strlen($textGauche)>0) {

            $posInitial = 0;
            $pos1 = $this->positionString($textGauche, $motFiltre);
           
            //$textGauche = "";
            $mot = "";
            if($pos1 !== null){
                $mot = substr($textGauche, $posInitial, $pos1);
                $textGauche = substr($textGauche, $pos1 + 1);
            }else{
                $mot = substr($textGauche, $posInitial);
                $textGauche = "";
            }
            
            if($mot[strlen($mot)-1] === " " && strlen($mot) > 0){
                $mot = substr($mot, 0, -1);
            }

            if(isset($mot[0]) && $mot[0] === " " && strlen($mot) > 0){
                $mot = substr($mot, 1);
            }

            if(strlen($mot) > 0){
               $arrayTextGauche3in1[$compteur3in1]["mot"] = $mot;
               $arrayTextGauche3in1[$compteur3in1]["numero"] = $compteurGlobal;
               $compteur3in1++;
               $compteurGlobal++;
            }

            if($compteur3in1 === 4 || (strlen($textGauche) === 0 && $compteur3in1 > 0)){
                $arrayTextGauche[$compter] =  $arrayTextGauche3in1;
                $compter++;
                $compteur3in1 = 0;
                $arrayTextGauche3in1 = [];
            }

        }

        return $arrayTextGauche;
    }

    public function positionString($chaine, $find){
        
        $length = strlen($chaine);
        for($i = 0; $i < $length; $i++){
                 if($chaine[$i] === $find){
                     return $i;
                 }
        }

        return null;
    }

    public function deleteDoubleEspace($chaine){
        
        //$chaine = str_replace("\n", " ",$chaine);
        $chaine = str_replace("\r", " ",$chaine);
        $chaine = str_replace("\t", " ",$chaine);
        
        $length = strlen($chaine);
        $newChaine = "";
        $compteur = 0;
        $isPrecedentEspace = false;
        for($i = 0; $i < $length; $i++){
                 if($chaine[$i] === " " && $isPrecedentEspace !== true){
                    $newChaine[$compteur] =  $chaine[$i];
                    $compteur++;
                    $isPrecedentEspace = true;
                 }else if($chaine[$i] !== " "){
                    $newChaine[$compteur] =  $chaine[$i];
                    $compteur++;
                    $isPrecedentEspace = false;
                 }
        }

        return $newChaine;
    }

    public function add_video() {
       
        $lang = $this->session->userdata('site_lang');
        if($lang==''){$lang='FR';}

        $f = $_FILES;

        $file = $f["mFile"];
        
        $IDChapitre = $_POST["IDChapitre"];

        $titre = trim(preg_replace('/\s+/', ' ',$_POST["titre"]));
        $titre = str_replace("  ", " ",$titre);
        $description = trim(preg_replace('/\s+/', ' ',$_POST["description"]));
        $description = str_replace("  ", " ",$description);
        $nb_f	=	sizeof($f);
        //$bin_data_target = base64_encode(file_get_contents( $f["mFile"]["tmp_name"] ));
        $err_desc = '';
        
        //print_r("--------------------------");print_r($f);
        //print_r("--------------------------");print_r($nb_f);
        //		$arr_Res[] = array("id" => '-1', "desc" => $f) ;
        //
        //
        //echo json_encode($arr_Res);
        //exit;

         
                $upload_path = './uploads/';
                $config['upload_path'] = $upload_path;
                //allowed file types. * means all types
                $config['allowed_types'] = 'wmv|mp4|avi|mov';
                //allowed max file size. 0 means unlimited file size
                $config['max_size'] = '0';
                //max file name size
                $config['max_filename'] = '255';
                //whether file name should be encrypted or not
                $config['encrypt_name'] = FALSE;
              
                $this->load->library('upload');
                $this->upload->initialize($config);     
              
                print_r($this->upload);
                if(!$this->upload->do_upload()){
                    print_r( $this->upload->display_errors());
                }
               
                //increment nbrTest
                /*$query = $this->db->query('SELECT Count(*) AS nbr FROM videos WHERE IDChapitre ='.$IDChapitre);
                $res = $query->result();
                $newNbrTest = $res[0]->nbr;

                $nbrTest = ['NbreVideosCours' => $newNbrTest];
                $this->db->where("IDChapitre = '".$IDChapitre."'");
                $this->db->update('_chapitre', $nbrTest);
                //increment nbrTest*/
                
                $arr_Res[] = array("id" => '1', "desc" => "" ) ;
                echo json_encode($arr_Res);
                exit;
         
        $arr_Res[] = array("id" => '0', "desc" => $err_desc) ;
        echo json_encode($arr_Res);
        exit;

    }

    public function delete_figure() {

        $idFigure = $_POST["idFigure"];
        $IDChapitre = $_POST["IDChapitre"];
        
        $this->db->query("delete FROM `figures` WHERE id = ".$idFigure);

        //increment nbrTest
        $query = $this->db->query('SELECT Count(*) AS nbr FROM figures WHERE IDChapitre ='.$IDChapitre);
        $res = $query->result();
        $newNbrTest = $res[0]->nbr;

        $nbrTest = ['NbreTest' => $newNbrTest];
        $this->db->where("IDChapitre = '".$IDChapitre."'");
        $this->db->update('_chapitre', $nbrTest);
        //increment nbrTest
     
        $arr_Res[] = array( "id" => '1', "desc" => "") ;
        echo json_encode($arr_Res);
        exit;
    }

    
    public function add_figure() {

        $lang = $this->session->userdata('site_lang');
        if($lang==''){$lang='FR';}

        $f               	= $_FILES;
        $IDChapitre = $_POST["IDChapitre"];
        $titre = trim(preg_replace('/\s+/', ' ',$_POST["titre"]));
        $titre = str_replace("  ", " ",$titre);
        $textGauche = $_POST["textGauche"];
        $textDroite = $_POST["textDroite"];
        $nb_f	=	sizeof($f);
        //$bin_data_target    = base64_encode(file_get_contents( $f["mFile"]["tmp_name"] ));
        $err_desc = '';
//print_r("--------------------------");print_r($f);
//print_r("--------------------------");print_r($nb_f);
//		$arr_Res[] = array("id" => '-1', "desc" => $f) ;
//
//
//echo json_encode($arr_Res);
//exit;
        foreach($f["mFile"]["name"] as $key=>$p) {

            $file_size  =  $f["mFile"]["size"][$key];
            $file_type  =  $f["mFile"]["type"][$key];
            $file_name  =  $f["mFile"]["name"][$key];
            $file_nameTmp  =  $f["mFile"]["tmp_name"][$key];
            //print_r($file_size);
            if($file_size > 0){

                $dataCouv = 'Couv_'.$listIDlivres[$key]."_".$file_name;//$_FILES['image']['name'];
                $config['image_library'] = 'gd2';
                $config['source_image'] = $file_nameTmp;//$_FILES['image']['tmp_name'];
                $config['create_thumb'] = FALSE;
                $config['maintain_ratio'] = FALSE;
                $config['quality'] = '100%' ;
                $config['master_dim'] = 'auto' ;
                //$config['width'] = 354;
                //$config['height'] = 457;
                $config['new_image'] = FCPATH.'PlatFormeConvert/'.$dataCouv;//'asstes/thumb/' . $data;
                $this->load->library('image_lib', $config);
                $this->image_lib->resize();

                $pathCouv = FCPATH.'PlatFormeConvert/'.$dataCouv ;
                //$bin_data_target    = base64_encode(file_get_contents( $f["mFile"]["tmp_name"][$key] ));
                $bin_data_target    = base64_encode(file_get_contents($pathCouv));
                $data = [ 'IDChapitre' => $IDChapitre, 'image' => $bin_data_target, 'titre' => $titre,  'textGauche' => $textGauche, 'textDroite' => $textDroite];
                $this->insert_dd("figures" , $data); 
       
                //increment nbrTest
                $query = $this->db->query('SELECT Count(*) AS nbr FROM figures WHERE IDChapitre ='.$IDChapitre);
                $res = $query->result();
                $newNbrTest = $res[0]->nbr;

                $nbrTest = ['NbreTest' => $newNbrTest];
                $this->db->where("IDChapitre = '".$IDChapitre."'");
                $this->db->update('_chapitre', $nbrTest);
                //increment nbrTest

                $arr_Res[] = array("id" => '1', "desc" => $err_desc) ;
                echo json_encode($arr_Res);
                exit;
            }
        }

        $arr_Res[] = array("id" => '0', "desc" => $err_desc) ;
        echo json_encode($arr_Res);
        exit;

    }

    public function update_figure() {

        $lang = $this->session->userdata('site_lang');
        if($lang==''){$lang='FR';}

        $f = $_FILES;
        $textGauche = $_POST["textGauche"];
        $textDroite = $_POST["textDroite"];
        $titre = trim(preg_replace('/\s+/', ' ',$_POST["titre"]));

        $idFigure = $_POST["idFigure"];
        
        $isOriginImageSupprimer = $_POST["isOriginImageSupprimer"];
        
        $nb_f	=	sizeof($f);
     
        $err_desc = '';

        foreach($f["mFileUpdate"]["name"] as $key=>$p) {
            $file_size  =  $f["mFileUpdate"]["size"][$key];
            $file_type  =  $f["mFileUpdate"]["type"][$key];
            $file_name  =  $f["mFileUpdate"]["name"][$key];
            $file_nameTmp  =  $f["mFileUpdate"]["tmp_name"][$key];
           
           
            if($file_size > 0){
            
                $dataCouv = 'Couv_'.$listIDlivres[$key]."_".$file_name;//$_FILES['image']['name'];
                $config['image_library'] = 'gd2';
                $config['source_image'] = $file_nameTmp;//$_FILES['image']['tmp_name'];
                $config['create_thumb'] = FALSE;
                $config['maintain_ratio'] = FALSE;
                $config['quality'] = '100%' ;
                $config['master_dim'] = 'auto' ;
                $config['new_image'] = FCPATH.'PlatFormeConvert/'.$dataCouv;//'asstes/thumb/' . $data;
                $this->load->library('image_lib', $config);
                $this->image_lib->resize();

                $pathCouv = FCPATH.'PlatFormeConvert/'.$dataCouv ;
                //$bin_data_target  = base64_encode(file_get_contents( $f["mFile"]["tmp_name"][$key] ));
                $bin_data_target    = base64_encode(file_get_contents($pathCouv));
                $data = [ 'image' => $bin_data_target, 'titre' => $titre,  'textGauche' => $textGauche, 'textDroite' => $textDroite];
                $this->db->where("id = '".$idFigure."'");
                $this->db->update('figures', $data);
       
            }else{

                $data = ['titre' => $titre,  'textGauche' => $textGauche, 'textDroite' => $textDroite];
            
                if($isOriginImageSupprimer == "1"){
                    $data = ['image'=> "", 'titre' => $titre,  'textGauche' => $textGauche, 'textDroite' => $textDroite];
                }

                $this->db->where("id = '".$idFigure."'");
                $this->db->update('figures', $data);
            }
        }

        $arr_Res[] = array("id" => '1', "desc" => $err_desc) ;
        echo json_encode($arr_Res);
        exit;

    }


	public function logout() {

		$lang = $this->session->userdata('site_lang');
		$data = array(
			'tokenPass' => ''
		);
		$log_id = $this->session->userdata('user_id') ;
		$this->db->where("users_ID = '".$log_id."'");
		$this->db->update('users', $data);

		$this->session->sess_destroy();
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
		$this->output->set_header("Pragma: no-cache");

		redirect($lang.'/login', 'refresh');

	}

	public function getLogins() {


		$res = array();
		$this->db->select("Login");
		$this->db->from("users");
		//$this->db->where("Marque = '$id'");

		$res = $this->db->get()->result_array();

		$data = array('status'=>'success', 'tp'=>1, 'msg'=>"Models fetched successfully.", 'result'=>$res);

		header('Access-Control-Allow-Origin: *');
		header("Content-Type: application/json");
		echo json_encode($data);

	}

    /////////||||||*****Accessanatomy*****||||||\\\\\\\\\\\
    public function signUp(){

        $lang = $this->session->userdata('site_lang');
        if($lang==''){$lang='FR';}
        $selectDesc = $lang."_Libelle AS Libelle";
        $this->db->select('* ,'.$selectDesc);
        $this->db->from('_etablissement');
        $this->db->order_by("Libelle" ,"Asc");
        $res = $this->db->get()->result_array();
        $arr['listEtab'] 	= $res;
        $arr['page'] 		= 'pages-sign-up';


        // load from spark tool
        //$this->load->spark('recaptcha-library/1.0.1');
        // load from CI library
        $this->load->library('recaptcha');


        $arr['widget'] 		= $this->recaptcha->getWidget();
        $arr['script'] 		= $this->recaptcha->getScriptTag();
//        $this->load->view('pages-sign-up',$arr);
        $this->load->view($this->getTypePlatform() ? 'v1_pages-sign-up' : 'pages-sign-up', $arr);
    }
    public function resetUp(){
        
        $this->load->view('pages-reset-password');
    }
    public function settingPaltform(){

        $this->db->select('*');
        $this->db->from('users');
//		$this->db->where("");
        $this->db->order_by("Nom" ,"Asc");
        $res = $this->db->get()->result_array();
        $arr['page'] 		= 'settingPaltform';
        $arr['listUsers'] 	= $res;
        $this->load->view('pages-setting',$arr);
    }

    

    public function settingUsers(){

        $lang = $this->session->userdata('site_lang');
        if($lang==''){$lang='FR';}
        $selectDesc = $lang."_Libelle AS Etablissement";
        $this->db->select('usr.* , etbl.'.$selectDesc);
        $this->db->from('users AS usr');
        $this->db->join('_etablissement AS etbl', 'usr.IDEtablissement = etbl.IDEtablissement');
        //$this->db->where("usr.IDEtablissement = etbl.IDEtablissement");
        $this->db->order_by("Nom" ,"Asc");
        $res = $this->db->get()->result_array();
        $arr['listUsers'] 	= $res;
        $arr['page'] 		= 'settingUsers';
        $this->load->view('settingUsers',$arr);
    }

    public function settingUsersEtab(){

        $lang = $this->session->userdata('site_lang');
        if($lang==''){$lang='FR';}
        $selectDesc = $lang."_Libelle AS Etablissement";
        $this->db->select('usr.* , etbl.'.$selectDesc);
        $this->db->from('users AS usr,_etablissement AS etbl');
        $this->db->where("usr.IDEtablissement = etbl.IDEtablissement");
        $this->db->order_by("Nom" ,"Asc");
        $res = $this->db->get()->result_array();
        $arr['listUsers'] 	= $res;
        $arr['page'] 		= 'settingUsersEtab';
        $this->load->view('settingUsersEtab',$arr);
    }
    public function upload_subUsers(){

        $filename_1 = $_FILES["fileUploadSubst"]["name"];
        $ext = pathinfo($filename_1, PATHINFO_EXTENSION); //$filename_2['extension'];


        $allowed = array(
            "application/vnd.ms-excel",
            "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
            "application/zip"
        );

        $allowed_extension = array("xls", "xlsx");

        //'xlsx'  =>
        //array('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/zip', 'application/vnd.ms-excel'),


        if((isset($_FILES['fileUploadSubst']['tmp_name'])) && ($_FILES['fileUploadSubst']['tmp_name'] != ""))
        {

            $file_size_1 = $_FILES['fileUploadSubst']['size'];

            if ( !in_array( $_FILES["fileUploadSubst"]["type"], $allowed ) ) {
                $error["error"] = "fl_1_type";
                print json_encode($error);
                exit;
            }

        }

        $target_path = $this->config->item("upload_path");

        $filename_1 = $_FILES["fileUploadSubst"]["name"];
        $filename_a = rand(1,99999) . $filename_1;

        $filename = $_FILES["fileUploadSubst"]["tmp_name"];//$target_path . $filename_a;
        $ext = pathinfo($filename_1, PATHINFO_EXTENSION); //$filename_2['extension'];

        $this->load->library('Classes/PHPExcel');
        $this->load->library('Classes/PHPExcel/IOFactory');

        if(!in_array($ext, $allowed_extension)){
            $error["error"] = "file_error";
            print json_encode($error);
            unlink($filename);
            exit;
        }

        $objPHPExcel = IOFactory::load($filename);
        //$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

        //Get worksheet dimensions
        $sheet 				= $objPHPExcel->getSheet(0);
        $highestRow 		= $sheet->getHighestRow();
        $highestColumn 		= $sheet->getHighestColumn();

        //Loop through each row of the worksheet in turn
        for ($row = 2; $row <= $highestRow; $row++){
            //  Read a row of data into an array
            //$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
            $set_Name	= $sheet->getCell( 'A'.$row )->getValue();
            $set_Email 	= $sheet->getCell( 'B'.$row )->getValue();
            $set_Mat 	= $sheet->getCell( 'C'.$row )->getValue();
            $set_CIN	= $sheet->getCell( 'D'.$row )->getValue();

            $errMsg = '';
            $user 		= $set_Email;
            $pass_md 	= "";//MD5($_POST["inputPassword"]);

            //$userCF 		= $_POST["inputEmailCF"];
            //$pass_mdCF 		= MD5($_POST["inputPasswordCF"]);
            $pass_mdMail	= $set_Email;

            $etablss 	= 1;
            $name 		= $set_Name;
            $LastName 	= "";
            $adress 	= "";
            $country	= "";
            $city 		= "";
            $zipCode 	= "";
            $Profess 	= "ETUDIANT";
            $IdUSR		= $set_Mat;

            if($errMsg==''){

                $arr 		= array();

                $this->db->select('*');
                $this->db->from('users');

                $this->db->Where("Email = '$user'");

                $res = $this->db->get()->result_array();

                if(count($res) == 0){

                    $this->load->helper('string');
                    $tokenPass 	= '';//random_string('alnum', 200) ;
                    $login_ 	= random_string('alnum', 5) ;
                    $pass_mdMail=$login_;
                    $data = array(
                        'MotDePasse' 		=> MD5($pass_mdMail),
                        'Nom' 				=> $name ,
                        'Prenom' 			=> $LastName ,
                        'Adresse1' 			=> $adress ,
                        'Email' 			=> $user ,
                        'CodePostal' 		=> $zipCode ,
                        'Ville' 			=> $city ,
                        'Telephone' 		=> '' ,
                        'IDEtablissement'	=> $etablss ,
                        'Profession'		=> $Profess ,
                        'login'				=> $login_ ,
                        'Pays' 				=> $country ,
                        'verifie' 			=> false ,
                        'Bloque' 			=> false ,
                        'createdate' 		=> date(DateTime::ISO8601) ,
                        'IdentifiantUSR'	=> $IdUSR ,
                        'tokenPass' 		=> $tokenPass
                    );
                    $this->db->insert('users', $data);

                    $config = Array(
                        'mailtype'  => 'html',
                        'charset'   => 'UTF-8'
                    );
                    $this->load->library('email', $config);
                    // $this->load->library('email');

                    $mail = $this->email;
                    $mail->from('noreply@accessanatomy.com', "Access Anatomy");
                    $mail->to($user);
                    $mail->subject('Login Details Sent By Access Anatomy');

                    $message = "<table width='80%' border='0'>";

                    $message .= "<tr><td colspan='2'>".$this->lang->line('mail_insc_1')."<br><br> ";
                    $message .= $this->lang->line('mail_insc_2')."<br><br></td></tr>";
                    $message .= $this->lang->line('mail_insc_3')."</td></tr>";
                    $message .= "<tr><td>".base_url().$this->lang->line('siteLang').'login'. " <br><br></td></tr>";
                    $message .= "<tr><td>".$this->lang->line('mail_insc_4')."</td><td>:  ".$user . " </td></tr>";
                    $message .= "<tr><td>".$this->lang->line('mail_insc_5')."</td><td>: ".$pass_mdMail. " </td></tr>";

                    $message .= "<tr><td colspan='2'><br><br><br>".$this->lang->line('mail_insc_6')."<br> ".$this->lang->line('mail_insc_7')."</td></tr>";

                    $message .= "</table>";

                    $mail->message($message);


                    $sent = $mail->send();
                    
                    print_r("hi");
                      
                    //This is optional - but good when you're in a testing environment.
                    if(isset($sent)){
                        print_r($this->email->print_debugger());
                        $arr[] = array("id" => '1', "desc" => $this->email->print_debugger());
                    }else{
                        $arr[] = array("id" => '-1', "desc" => 'It did not send. <br>'.$this->email->print_debugger());
                    }

                }else{ $arr[] = array("id" => '-1', "desc" => $this->lang->line('mail_msg_exist').'<br>'.$user); }

            }else{ $arr[] = array("id" => '-1', "desc" => $this->lang->line('mail_msg_ch').'<br>'.$errMsg); }

        }

        $error["error"] = true;
        print json_encode($error);
        exit;


    }
    
    public function settingCurs(){
        $arr['listCat'] 	= $this->getListCategory();
        $arr['page'] 		= 'settingCurs';
        $this->load->view('settingCurs',$arr);
    }

    public function settingActualites(){

        $this->db->select('*');
        $this->db->from('actualites');
        $res = $this->db->get()->result_array();

        $arr['listActualites'] 	= $res;
        $arr['page'] 		= 'settingActualites';
        $this->load->view('settingActualites',$arr);
    
    }

    public function delete_Actualite() {

        $id = $_POST["id"];
        
        $this->db->query("delete FROM `actualites` WHERE id = ".$id);

        //increment nbrTest
       
        $arr_Res[] = array( "id" => '1', "desc" => "") ;
        echo json_encode($arr_Res);
        exit;
    }

    public function add_Actualite() {

        $lang = $this->session->userdata('site_lang');
        if($lang==''){$lang='FR';}
       
        $titleFR = $_POST["FR_title"];
        
        $titleEN = $_POST["EN_title"];
       
        $data = [ 'FR_title' => $titleFR, 'EN_title' => $titleEN];
        $this->insert_dd("actualites" , $data); 
                //increment nbrTest
             
        $arr_Res[] = array("id" => '1', "desc" => "") ;
        echo json_encode($arr_Res);
        exit;
    }

    public function update_Actualite() {

        $lang = $this->session->userdata('site_lang');
        if($lang==''){$lang='FR';}
       
        $id = $_POST["id"];
        
        $titleFR = $_POST["FR_title"];
        
        $titleEN = $_POST["EN_title"];
       
        $data = [ 'FR_title' => $titleFR, 'EN_title' => $titleEN];
        
        $this->db->where("id = '".$id."'");
        $this->db->update('actualites', $data);

        $arr_Res[] = array("id" => '1', "desc" => "") ;
        echo json_encode($arr_Res);
        exit;
    }

    public function settingPlat(){

        $this->db->select('*');
        $this->db->from('_params');
        $res = $this->db->get()->result_array();

        $arr['listParams'] 	= $res;
        $arr['page'] 		= 'settingPlat';
        $this->load->view('settingPlat',$arr);
    
    }

    public function set_valParams(){

        $set_Id 		= $_POST["set_Id"];
        $setTitre 		= $_POST["setTitre"];
        $data 			= array( 'Value_Params' 	=> $setTitre);
        $this->db->where("ID_Params",$set_Id);
        $this->db->update('_params', $data);
        $arr_Res[] 	= array("id" => '1', "desc" => '') ;

        echo json_encode($arr_Res);
        exit;

    }
   
    public function getListCategory()
    {
       
        $lang = $this->session->userdata('site_lang');
        if($lang==''){$lang='FR';}
        $selectDesc = $lang."_Description AS Description";
        $this->db->select('* ,'.$selectDesc);
        $this->db->from('_category');
        $this->db->where("multi_lingue = '$lang' ");
        $this->db->order_by("OrdreCat" ,"Asc");
        $this->db->order_by("Libelle" ,"Asc");
        $res = $this->db->get()->result_array();
        $arr_item = array();
        $output = array();
        foreach ($res as $val)
        {
            $res_item  = $this->listItem($val['IDCategory'],0);
            
            $arr_item = array(
                "Cats" => $val,
                "items" => $res_item
            );
            $output[] = $arr_item;
        }

        //print_r($output);
        return $output;
    }

    public function getListCategoryParametree($idCategorie)
    {
        $lang = $this->session->userdata('site_lang');
        if($lang==''){$lang='FR';}
        $selectDesc = $lang."_Description AS Description";
        $this->db->select('* ,'.$selectDesc);
        $this->db->from('_category');
        $this->db->where("IDCategory = '$idCategorie' ");
        $res = $this->db->get()->result_array();
        $arr_item = array();
        $output = array();
        foreach ($res as $val)
        {
            $res_item  = $this->listItem($val['IDCategory'],0);

            $arr_item = array(
                "Cats" => $val,
                "items" => $res_item
            );
            $output[] = $arr_item;
        }

        //print_r($output);
        return $output;
    }

    public function listItem($cat,$itm){
        $this->db->select('*');
        $this->db->from('_theme');
        $this->db->where("IDCategory = $cat");
        $res = $this->db->get()->result_array();

        $arr_liv = array();
        $output = array();
        foreach ($res as $val)
        {
            $res_liv  = $this->listLivre($val['IDTheme']);

            $arr_liv = array(
                "items" => $val,
                "books" => $res_liv
            );
            $output[] = $arr_liv;
        }

        return $output;
    }
    public  function listLivre($tm)
    {
        $this->db->select('*,CAST(SUBSTRING_INDEX(Titre, "-", 1) as SIGNED INTEGER ) AS ord');
        $this->db->from('_livre');
        $this->db->where("IDTheme = $tm ");
        $this->db->order_by("ord" ,"asc");
        $res = $this->db->get()->result_array();
        return $res;
    }

    public function livreList($cat,$itm)
    {
        // $id equal to IDCat
        $res_item  = $this->listItem($cat,$itm);

        $lang = $this->session->userdata('site_lang');
        if($lang==''){$lang='FR';}
        $selectDesc = $lang."_Description AS Description";
        $this->db->select('* ,'.$selectDesc);
        $this->db->from('_category');
        $this->db->where("IDCategory = $cat");
        $res = $this->db->get()->result_array();

        $arr['OneBook'] 	= $res;
        $arr['ListItem'] 	= $res_item;
        $arr['page'] 		= 'livreList';
        $arr['listCat'] 	= $this->getListCategory();
        $this->load->view('livreList',$arr);
    }

    public function  livre($id)
    {
        $this->session->set_userdata('curs_id', '');

        $this->db->select('*');
        $this->db->from('_livre , _theme');
        $this->db->Where("IDLivre = '$id' AND _theme.IDTheme = _livre.IDTheme");
        $resBook = $this->db->get()->result_array();

        $this->db->select('*');
        $this->db->from('_publicite');
        $this->db->Where("IDLivre = '$id'");
        $resPub = $this->db->get()->result_array();

        $this->db->select('* , CAST(SUBSTRING_INDEX(titrechapitre, "-", 1) as SIGNED INTEGER ) AS ord');
        $this->db->from('_chapitre');
        $this->db->Where("IDLivre = '$id' ");
        //$this->db->order_by("NumOrdre" ,"asc");
        $this->db->order_by("ord" ,"asc");
        $resChap = $this->db->get()->result_array();

        $arr['listChap']    = $resChap;
        $arr['OneBook'] = $resBook;
        $arr['ListPub'] = $resPub;
        $arr['page'] 	= 'livre';
        $arr['listCat'] = $this->getListCategory();
//        $this->load->view('livre',$arr);
        $this->load->view($this->getTypePlatform() ? 'v1_livre' : 'livre', $arr);
    }

    public function  livreDetails($id)
    {

        $this->db->select('*');
        $this->db->from('_livre , _theme');
        $this->db->Where("IDLivre = '$id' AND _theme.IDTheme = _livre.IDTheme");
        $resBook = $this->db->get()->result_array();
        
        $idCategory = $resBook[0]['IDCategory'];
        $this->db->select('*');
        $this->db->from('_category');
        $this->db->Where("IDCategory = '$idCategory' ");
        $category = $this->db->get()->result_array();
       
        if($id === "70" || $id === "71"){
            $category[0]["EstActifQSM"] = 0;
            $category[0]["EstActifQROC"] = 0;
            $category[0]["EstActifResume"] = 0;
            $category[0]["EstActifCalques"] = 1;
            $category[0]["EstActifTest"] = 1;
        }

        //log_message('error', json_encode($category) );

        $this->db->select('* , CAST(SUBSTRING_INDEX(titrechapitre, "-", 1) as SIGNED INTEGER ) AS ord');
        $this->db->from('_chapitre');
        $this->db->Where("IDLivre = '$id' ");
        //$this->db->order_by("NumOrdre" ,"asc");
        $this->db->order_by("ord" ,"asc");
        $resChap = $this->db->get()->result_array();

        $this->db->select('SUM(NbreQcm) AS QcmNBR , SUM(NbreQroc) AS QrocNBR , SUM(NbreTest) AS test');
        $this->db->from('_chapitre');
        $this->db->Where("IDLivre = '$id' ");
        $resNBR = $this->db->get()->result_array();

        $typesVideo = ["cours", "resume"];

        $arr['typesVideo'] = $typesVideo;
        $arr['category'] = $category[0];
        $arr['resNBR'] 		= $resNBR;
        $arr['OneBook']     = $resBook;
        $arr['listChap']    = $resChap;
        $arr['page']        = 'livreDetails';
        $arr['listCat']     = $this->getListCategory();
//        $this->load->view('livreDetails',$arr);
        $this->load->view($this->getTypePlatform() ? 'v1_livre' : 'livreDetails', $arr);
    }

    public function  livreCours($id,$indxSearch='')
    {
        $this->session->set_userdata('curs_id', 'curs_'.$id);

        $this->db->select('*');
        $this->db->from('_chapitre ,_livre , _theme');
        $this->db->Where("IDChapitre = '$id' AND _chapitre.IDLivre = _livre.IDLivre AND _theme.IDTheme = _livre.IDTheme");
        $resChap = $this->db->get()->result_array();

        $this->db->select('*');
        $this->db->from('_cours');
        $this->db->Where("IDChapitre = '$id' LIMIT 1 ");
        $resCurs = $this->db->get()->result_array();
        $idCours = 0;
        if(sizeof($resCurs)>0){ $idCours = $resCurs[0]["IDCours"]; }

        $this->db->select('*');
        $this->db->from('_page');
        $this->db->Where("IDCours = '$idCours' ");
        $listPages = $this->db->get()->result_array();

        $this->db->select('*');
        $this->db->from('_params');
        $this->db->Where("Libelle_Params = 'VisibiliteCours' ");
        $resParams = $this->db->get()->result_array();

        $idLivr 			= $resChap[0]["IDLivre"];
        $listChap 			= $this->listChaptCours($idLivr);

        $arr['listChap'] 	= $listChap;
        $arr['paramsCurs'] 	= $resParams[0]["Value_Params"];
        $arr['indexSearch'] = $indxSearch;
        $arr['OneBook'] 	= $resChap;
        $arr['OneCurs'] 	= $resCurs;
        $arr['ListPage'] 	= $listPages;
        $arr['page'] 		= 'livreCours';
        $arr['listCat'] 	= $this->getListCategory();
        $arr['CursShow'] 	= $this->getCurs($listPages[0]['IDPage']);

        //        if(count($listPages)>0){
//            $this->db->select('encryptFigure,IDFigure,SUBSTRING_INDEX(TitreFigure, ".", 1) as TitreFigure,CAST(SUBSTRING_INDEX(TitreFigure, "-", 1) as SIGNED INTEGER ) AS ord');
//        }else{
//            $this->db->select('encryptFigure,encryptFigure,IDFigure,SUBSTRING_INDEX(TitreFigure, ".", 1) as TitreFigure,CAST(SUBSTRING_INDEX(TitreFigure, "-", 1) as SIGNED INTEGER ) AS ord');
//        }
        if(count($listPages)>0){
            $this->db->select('encryptFigure, IDFigure, SUBSTRING_INDEX(TitreFigure, ".", 1) as TitreFigure, CAST(SUBSTRING(TitreFigure, 4) AS UNSIGNED) as ord');
        } else {
            $this->db->select('encryptFigure, IDFigure, SUBSTRING_INDEX(TitreFigure, ".", 1) as TitreFigure, CAST(SUBSTRING(TitreFigure, 4) AS UNSIGNED) as ord');
        }

        $this->db->from('_figure');
        $this->db->Where("IDCours = '$idCours' ");
        $this->db->order_by('ord', 'ASC');
        $this->db->order_by("IDFigure" ,"asc");
        $this->db->order_by("TitreFigure" ,"asc");
        $listFigures = $this->db->get()->result_array();
        $arr['listFig'] = $listFigures;
        if(count($listPages)>0){
//            $this->load->view('livreCours',$arr);
            $this->load->view($this->getTypePlatform() ? 'v1_livreCours' : 'livreCours', $arr);
        }else{
//            $this->load->view('livreFigure',$arr);
            $this->load->view($this->getTypePlatform() ? 'v1_livreFigure' : 'livreFigure', $arr);
        }

    }

    public function  livreCours_simple($id,$indxSearch='')
    {
        $this->session->set_userdata('curs_id', 'curs_'.$id);

        $this->db->select('*');
        $this->db->from('_chapitre ,_livre , _theme');
        $this->db->Where("IDChapitre = '$id' AND _chapitre.IDLivre = _livre.IDLivre AND _theme.IDTheme = _livre.IDTheme");
        $resChap = $this->db->get()->result_array();

        $this->db->select('*');
        $this->db->from('_cours');
        $this->db->Where("IDChapitre = '$id' LIMIT 1 ");
        $resCurs = $this->db->get()->result_array();
        $idCours = 0;
        if(sizeof($resCurs)>0){ $idCours = $resCurs[0]["IDCours"]; }

        $this->db->select('*');
        $this->db->from('_page');
        $this->db->Where("IDCours = '$idCours' ");
        $listPages = $this->db->get()->result_array();

        $this->db->select('*');
        $this->db->from('_params');
        $this->db->Where("Libelle_Params = 'VisibiliteCours' ");
        $resParams = $this->db->get()->result_array();

        $idLivr 			= $resChap[0]["IDLivre"];
        $listChap 			= $this->listChaptCours($idLivr);

        $arr['listChap'] 	= $listChap;
        $arr['paramsCurs'] 	= $resParams[0]["Value_Params"];
        $arr['indexSearch'] = $indxSearch;
        $arr['OneBook'] 	= $resChap;
        $arr['OneCurs'] 	= $resCurs;
        $arr['ListPage'] 	= $listPages;
        $arr['page'] 		= 'livreCours';
        $arr['listCat'] 	= $this->getListCategory();

        if(count($listPages)>0){
            $this->db->select('encryptFigure,IDFigure,SUBSTRING_INDEX(TitreFigure, ".", 1) as TitreFigure,CAST(SUBSTRING_INDEX(TitreFigure, "-", 1) as SIGNED INTEGER ) AS ord');
        }else{
            $this->db->select('encryptFigure,encryptFigure,IDFigure,SUBSTRING_INDEX(TitreFigure, ".", 1) as TitreFigure,CAST(SUBSTRING_INDEX(TitreFigure, "-", 1) as SIGNED INTEGER ) AS ord');
        }
        
        $this->db->from('_figure');
        $this->db->Where("IDCours = '$idCours' ");
        $this->db->order_by("IDFigure" ,"asc");
        $this->db->order_by("TitreFigure" ,"asc");
        $listFigures = $this->db->get()->result_array();
        $arr['listFig'] = $listFigures;
        if(count($listPages)>0){
//            $this->load->view('livreCours',$arr);
            $this->load->view($this->getTypePlatform() ? 'v1_livreCours' : 'livreCours', $arr);
        }else{
//            $this->load->view('livreFigure',$arr);
            $this->load->view($this->getTypePlatform() ? 'v1_livreFigure' : 'livreFigure', $arr);
        }

    }

    public function  livreResume($id,$indxSearch='')
    {
        $this->session->set_userdata('curs_id', 'curs_'.$id);

        $this->db->select('*');
        $this->db->from('_chapitre ,_livre , _theme');
        $this->db->Where("IDChapitre = '$id' AND _chapitre.IDLivre = _livre.IDLivre AND _theme.IDTheme = _livre.IDTheme");
        $resChap = $this->db->get()->result_array();

        $this->db->select('*');
        $this->db->from('_resume');
        $this->db->Where("IDChapitre = '$id' LIMIT 1 ");
        $resResum = $this->db->get()->result_array();
        $idResum = 0;
        if(sizeof($resResum)>0){ $idResum = $resResum[0]["IDResume"]; }

        $this->db->select('*');
        $this->db->from('_page');
        $this->db->Where("IDResume = '$idResum' ");
        $listPages = $this->db->get()->result_array();

        $this->db->select('*');
        $this->db->from('_params');
        $this->db->Where("Libelle_Params = 'VisibiliteCours' ");
        $resParams = $this->db->get()->result_array();

        $idLivr 			= $resChap[0]["IDLivre"];
        $listChap 			= $this->listChaptCours($idLivr);

        $arr['listChap'] 	= $listChap;
        $arr['paramsCurs'] 	= $resParams[0]["Value_Params"];
        $arr['indexSearch'] = $indxSearch;
        $arr['OneBook'] 	= $resChap;
        $arr['OneCurs'] 	= $resResum;
        $arr['ListPage'] 	= $listPages;
        $arr['page'] 		= 'livreResume';
        $arr['listCat'] 	= $this->getListCategory();

        if(count($listPages)>0){
            $this->db->select('encryptFigure,IDFigure,SUBSTRING_INDEX(TitreFigure, ".", 1) as TitreFigure,CAST(SUBSTRING_INDEX(TitreFigure, "-", 1) as SIGNED INTEGER ) AS ord');
        }else{
            $this->db->select('encryptFigure,IDFigure,SUBSTRING_INDEX(TitreFigure, ".", 1) as TitreFigure,CAST(SUBSTRING_INDEX(TitreFigure, "-", 1) as SIGNED INTEGER ) AS ord');
        }
        $this->db->from('_figure');
        $this->db->Where("IDResume = '$idResum' ");
        $this->db->order_by("TitreFigure" ,"asc");
        
        $listFigures = $this->db->get()->result_array();
        $arr['listFig'] 	= $listFigures;
        $arr['CursShow'] 	= $this->getCurs($listPages[0]['IDPage']);
        if(count($listPages)>0){
            $this->load->view($this->getTypePlatform() ? 'v1_livreResume' : 'livreResume', $arr);
            //$this->load->view('livreResume',$arr);
        }else{
            $this->load->view($this->getTypePlatform() ? 'v1_livreFigure' : 'livreFigure', $arr);
            //$this->load->view('livreFigure',$arr);
        }

    }

    public function  livreQcm($id)
    {
        $this->session->set_userdata('curs_id', 'curs_'.$id);

        $this->db->select('*');
        $this->db->from('_chapitre ,_livre , _theme');
        $this->db->Where("IDChapitre = '$id' AND _chapitre.IDLivre = _livre.IDLivre AND _theme.IDTheme = _livre.IDTheme");
        $resChap = $this->db->get()->result_array();

        $this->db->select('*');
        $this->db->from('_cours');
        $this->db->Where("IDChapitre = '$id' LIMIT 1 ");
        $resResum = $this->db->get()->result_array();
        $idResum = 0;
        if(sizeof($resResum)>0){ $idResum = $resResum[0]["IDCours"]; }

        $this->db->select('*');
        $this->db->from('_page');
        $this->db->Where("IDCours = '$idResum' ");
        $listPages = $this->db->get()->result_array();

//        if(count($listPages)>0){
//            $this->db->select('encryptFigure,IDFigure,SUBSTRING_INDEX(TitreFigure, ".", 1) as TitreFigure,CAST(SUBSTRING_INDEX(TitreFigure, "-", 1) as SIGNED INTEGER ) AS ord');
//        }else{
//            $this->db->select('encryptFigure,encryptFigure,IDFigure,SUBSTRING_INDEX(TitreFigure, ".", 1) as TitreFigure,CAST(SUBSTRING_INDEX(TitreFigure, "-", 1) as SIGNED INTEGER ) AS ord');
//        }
        if(count($listPages)>0){
            $this->db->select('encryptFigure, IDFigure, SUBSTRING_INDEX(TitreFigure, ".", 1) as TitreFigure, CAST(SUBSTRING(TitreFigure, 4) AS UNSIGNED) as ord');
        } else {
            $this->db->select('encryptFigure, IDFigure, SUBSTRING_INDEX(TitreFigure, ".", 1) as TitreFigure, CAST(SUBSTRING(TitreFigure, 4) AS UNSIGNED) as ord');
        }

        $this->db->from('_figure');
        $this->db->Where("IDCours = '$idResum' ");
        $this->db->order_by('ord', 'ASC');
        $this->db->order_by("IDFigure" ,"asc");
        $this->db->order_by("TitreFigure" ,"asc");
        $listFigures = $this->db->get()->result_array();
        $arr['listFig'] = $listFigures;

        $idLivr 			= $resChap[0]["IDLivre"];
        $listChap 			= $this->listChaptCours($idLivr);

        $arr['listChap'] 	= $listChap;
        $arr['OneBook'] 	= $resChap;
        $arr['page'] 		= 'livreQcm';
        $arr['listCat'] 	= $this->getListCategory();
        //$this->load->view('livreQcm',$arr);
        $this->load->view($this->getTypePlatform() ? 'v1_livreQcm' : 'livreQcm', $arr);
    }

    public function  livreQroc($id)
    {
        $this->session->set_userdata('curs_id', 'curs_'.$id);

        $this->db->select('*');
        $this->db->from('_chapitre ,_livre , _theme');
        $this->db->Where("IDChapitre = '$id' AND _chapitre.IDLivre = _livre.IDLivre AND _theme.IDTheme = _livre.IDTheme");
        $resChap = $this->db->get()->result_array();

        $this->db->select('*');
        $this->db->from('_cours');
        $this->db->Where("IDChapitre = '$id' LIMIT 1 ");
        $resResum = $this->db->get()->result_array();
        $idResum = 0;
        if(sizeof($resResum)>0){ $idResum = $resResum[0]["IDCours"]; }

        $this->db->select('*');
        $this->db->from('_page');
        $this->db->Where("IDCours = '$idResum' ");
        $listPages = $this->db->get()->result_array();

        //        if(count($listPages)>0){
//            $this->db->select('encryptFigure,IDFigure,SUBSTRING_INDEX(TitreFigure, ".", 1) as TitreFigure,CAST(SUBSTRING_INDEX(TitreFigure, "-", 1) as SIGNED INTEGER ) AS ord');
//        }else{
//            $this->db->select('encryptFigure,encryptFigure,IDFigure,SUBSTRING_INDEX(TitreFigure, ".", 1) as TitreFigure,CAST(SUBSTRING_INDEX(TitreFigure, "-", 1) as SIGNED INTEGER ) AS ord');
//        }
        if(count($listPages)>0){
            $this->db->select('encryptFigure, IDFigure, SUBSTRING_INDEX(TitreFigure, ".", 1) as TitreFigure, CAST(SUBSTRING(TitreFigure, 4) AS UNSIGNED) as ord');
        } else {
            $this->db->select('encryptFigure, IDFigure, SUBSTRING_INDEX(TitreFigure, ".", 1) as TitreFigure, CAST(SUBSTRING(TitreFigure, 4) AS UNSIGNED) as ord');
        }

        $this->db->from('_figure');
        $this->db->Where("IDCours = '$idResum' ");
        $this->db->order_by('ord', 'ASC');
        $this->db->order_by("IDFigure" ,"asc");
        $this->db->order_by("TitreFigure" ,"asc");
        $listFigures = $this->db->get()->result_array();
        $arr['listFig'] = $listFigures;

        $idLivr 			= $resChap[0]["IDLivre"];
        $listChap 			= $this->listChaptCours($idLivr);

        $arr['listChap'] 	= $listChap;
        $arr['OneBook'] 	= $resChap;
        $arr['page'] 		= 'livreQroc';
        $arr['listCat'] 	= $this->getListCategory();
        //$this->load->view('livreQroc',$arr);
        $this->load->view($this->getTypePlatform() ? 'v1_livreQroc' : 'livreQroc', $arr);
    }
    
    public function  livreQroc_simple($id)
    {
        $this->session->set_userdata('curs_id', 'curs_'.$id);

        $this->db->select('*');
        $this->db->from('_chapitre ,_livre , _theme');
        $this->db->Where("IDChapitre = '$id' AND _chapitre.IDLivre = _livre.IDLivre AND _theme.IDTheme = _livre.IDTheme");
        $resChap = $this->db->get()->result_array();

        $idLivr 			= $resChap[0]["IDLivre"];
        $listChap 			= $this->listChaptCours($idLivr);

        $arr['listChap'] 	= $listChap;
        $arr['OneBook'] 	= $resChap;
        $arr['page'] 		= 'livreQroc';
        $arr['listCat'] 	= $this->getListCategory();
        //$this->load->view('livreQroc',$arr);
        $this->load->view($this->getTypePlatform() ? 'v1_livreQroc' : 'livreQroc', $arr);
    }

    public function listOffers($selOffr){

//		$selOffr			= $_POST["selOffr"];
        $id_ 				= base64_decode($selOffr);

        $this->db->select('*');
        $this->db->from('products');
        $this->db->Where("status",1);
        $resOffers = $this->db->get()->result_array();

        $arr['resOffers'] 	= $resOffers;
        $arr['selOffr'] 	= $id_;
        $arr['listCat'] 	= $this->getListCategory();
        $arr['page'] 		= 'listOffers';
        $this->load->view('listOffers',$arr);

    }

public function cursHTML($id,$indxSearch='')
{
    $id_ = base64_decode($id);

    // Récupération du cours
    $this->db->select('*');
    $this->db->from('_page');
    $this->db->Where("IDPage = '$id_' ");
    $resCurs = $this->db->get()->result_array();

    // Récupération des paramètres
    $this->db->select('*');
    $this->db->from('_params');
    $this->db->Where("Libelle_Params = 'VisibiliteCours' ");
    $resParams = $this->db->get()->result_array();

    // Récupération des produits
    $this->db->select('*');
    $this->db->from('products');
    $this->db->Where("status",1);
    $resOffers = $this->db->get()->result_array();

    // Si un lien existe, on l'utilise
    if (!empty($resCurs[0]["ContentFileUrl"])) {
        $arr['OneCurs'] = base_url() . $resCurs[0]["ContentFileUrl"];
        $arr['isExternalFile'] = true;
    } else {
        // fallback sur l'ancien champ encodé
        $arr['OneCurs'] = $resCurs[0]["ContentFileCrypt"];
        $arr['isExternalFile'] = false;
    }

    $arr['paramsCurs']  = $resParams[0]["Value_Params"];
    $arr['resOffers']   = $resOffers;
    $arr['indexSearch'] = $indxSearch;

    $this->load->view('cursHTML',$arr);
}


    public function figHTML($id)
    {
        $idFig = base64_decode($id);

        $this->db->select('*');
        $this->db->from('_figure');
        $this->db->where("IDFigure ='".$idFig."'");

        $res = $this->db->get()->result_array();

        $arr['OneFig'] 	= $res[0]["encryptFigure"];
        $this->load->view('figHTML',$arr);
    }

    public function getCurs($IDPage)
    {
        $id_ = $IDPage ;///base64_decode($IDPage);
        $this->db->select('*');
        $this->db->from('_page');
        $this->db->Where("IDPage = '$id_' ");
        $resCurs = $this->db->get()->result_array();

        if (isset($resCurs[0]) && strpos(strtoupper($resCurs[0]['ContenuPAge']), strtoupper("PDF")) !== false) {
           // log_message('error', 'eeeeeeeeeeeeee');
            $ContentFileCrypt	= $resCurs[0]['ContentFileCrypt'];

            $ContentFileCrypt	= trim($ContentFileCrypt, " \t\n\r");
            $ContenuPAge		= str_replace(" ","%20",HTTP_PLATFORM.$resCurs[0]['ContenuPAge']);

            $typeResp 		=	 "<input type='hidden' id='cryptFl' value='$ContentFileCrypt'><div style='width: calc(100% - 2px); height: calc(100vh - 80px);overflow: auto; margin: 1px;' ><canvas id='the-canvas' style='width=512px; height=512px; '></canvas></div>";
            $typeResp 		=	 $typeResp."<script>var xxxx = document.getElementById('cryptFl').value;
var pdfData = atob(xxxx);

// Loaded via <script> tag, create shortcut to access PDF.js exports.
var pdfjsLib = window['pdfjs-dist/build/pdf'];

// The workerSrc property shall be specified.
pdfjsLib.GlobalWorkerOptions.workerSrc = '//mozilla.github.io/pdf.js/build/pdf.worker.js';

// Using DocumentInitParameters object to load binary data.
var loadingTask = pdfjsLib.getDocument({data: pdfData});
loadingTask.promise.then(function(pdf) {
  console.log('PDF loaded');
  
  // Fetch the first page
  var pageNumber = 1;
  pdf.getPage(pageNumber).then(function(page) {
    console.log('Page loaded');
    
    var scale = 1.1;
    var viewport = page.getViewport({scale: scale});

    // Prepare canvas using PDF page dimensions
    var canvas = document.getElementById('the-canvas');
    var context = canvas.getContext('2d');
    canvas.height = viewport.height;
    canvas.width = viewport.width;

    // Render PDF page into canvas context
    var renderContext = {
      canvasContext: context,
      viewport: viewport
    };
    var renderTask = page.render(renderContext);
    renderTask.promise.then(function () {
      console.log('Page rendered');
    });
  });
}, function (reason) {
  // PDF loading error
  console.error(reason);
});</script>";
        }else{
            $indexSearch = '';
            $IDPage = base64_encode($id_);
           // log_message('error', $IDPage);
            $pat =  base_url().$this->lang->line('siteLang').'cursHTML/'.$IDPage.'/'.$indexSearch ;
           // log_message('error', $pat);
            $html =	" 
					<iframe name='iframename' id='iframeID' onclick='alert(22222)' style='max-height: 46vw;background-color: white;overflow-y: scroll;height: calc(100vh - 12vh); width: 100%' 
 						src='$pat'>
 					</iframe> ";

            $typeResp = "<div  id='demo' >".$html."</div>";
        }


        //log_message('error', $typeResp);
        return $typeResp ;
    }

    public function ajax_PagesCours_list()
    {

        $data = array();
        $d_arr = array();

        $d_arr[] = $_POST["ic"]; //IDCours
        $d_arr[] = 0; //IDCours
        $indexSearch = $_POST["indexSearch"];
        $list = $this->Pages_model->get_datatables($d_arr);

        foreach ($list as $sort_row) {

            $row 				= array();
            $id 				= $sort_row->IDPage;

            if (strpos(strtoupper($sort_row->ContenuPAge),strtoupper("PDF"))!==false) {
                $ContentFileCrypt	= $sort_row->ContentFileCrypt;

                //$typeResp 		=	 "<iframe name='iframename' id='iframeID' onload='toolbarhid();' src='$ContenuPAge' style='display: block;margin-right: auto;margin-left: auto;  height: 650px;width: 100%;' pr></iframe>";
                //$typeResp 		=	 "<object data='data:application/pdf;base64,$ContentFileCrypt'  style='display: block;margin-right: auto;margin-left: auto;  height: 650px;width: 100%;' type='application/pdf'> PDF Plugin Not Available </object>";
                $ContentFileCrypt	= trim($ContentFileCrypt, " \t\n\r");
                $ContenuPAge		= str_replace(" ","%20",HTTP_PLATFORM.$sort_row->ContenuPAge);

                //$typeResp 		=	 "<iframe name='iframename' id='iframeID' onload='toolbarhid();' src='$ContenuPAge' style='display: block;margin-right: auto;margin-left: auto;  height: 650px;width: 100%;' pr></iframe>";
                //$typeResp 		=	 "<object data='data:application/pdf;base64,$ContentFileCrypt'  style='display: block;margin-right: auto;margin-left: auto;  height: 650px;width: 100%;' type='application/pdf'> PDF Plugin Not Available </object>";

                $typeResp 		=	 "<input type='hidden' id='cryptFl' value='$ContentFileCrypt'><div style='width: calc(100% - 2px); height: calc(100vh - 80px);overflow: auto; margin: 1px;' ><canvas id='the-canvas' style='width=512px; height=512px; '></canvas></div>";
                $typeResp 		=	 $typeResp."<script>var xxxx = document.getElementById('cryptFl').value;
var pdfData = atob(xxxx);

// Loaded via <script> tag, create shortcut to access PDF.js exports.
var pdfjsLib = window['pdfjs-dist/build/pdf'];

// The workerSrc property shall be specified.
pdfjsLib.GlobalWorkerOptions.workerSrc = '//mozilla.github.io/pdf.js/build/pdf.worker.js';

// Using DocumentInitParameters object to load binary data.
var loadingTask = pdfjsLib.getDocument({data: pdfData});
loadingTask.promise.then(function(pdf) {
  console.log('PDF loaded');
  
  // Fetch the first page
  var pageNumber = 1;
  pdf.getPage(pageNumber).then(function(page) {
    console.log('Page loaded');
    
    var scale = 1.1;
    var viewport = page.getViewport({scale: scale});

    // Prepare canvas using PDF page dimensions
    var canvas = document.getElementById('the-canvas');
    var context = canvas.getContext('2d');
    canvas.height = viewport.height;
    canvas.width = viewport.width;

    // Render PDF page into canvas context
    var renderContext = {
      canvasContext: context,
      viewport: viewport
    };
    var renderTask = page.render(renderContext);
    renderTask.promise.then(function () {
      console.log('Page rendered');
    });
  });
}, function (reason) {
  // PDF loading error
  console.error(reason);
});</script>";
            }else{
                $id_ = base64_encode($id);
                $pat =  base_url().$this->lang->line('siteLang').'cursHTML/'.$id_.'/'.$indexSearch ;
                $html =	"<div style='width: calc(100% - 2px); height: calc(100vh - 10vh); overflow: auto; margin: 1px;' ><iframe name='iframename' id='iframeID' style='background-color: white;overflow-y: scroll;height: calc(100vh - 12vh); width: 100%'  src='$pat'></iframe></div>";

                $typeResp = "<div  id='demo' >".$html."</div>";
            }
            $row[] 		= $typeResp;

            $data[] = $row;

        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" 		=> $this->Pages_model->count_filtered($d_arr),
            "recordsFiltered" 	=> $this->Pages_model->count_filtered($d_arr),
            "data" => $data,
        );

           echo json_encode($output);
    }
    
    public function ajax_PagesCours_list_OBJ()
    {


        $data = array();
        $d_arr = array();

        $d_arr[] = $_POST["ic"]; //IDCours
        $d_arr[] = 0; //IDCours

        $list = $this->Pages_model->get_datatables($d_arr);

        foreach ($list as $sort_row) {

            $row 				= array();
            $id 				= $sort_row->IDPage;
            $ContentFileCrypt	= $sort_row->ContentFileCrypt;
            $ContentFileCrypt	= trim($ContentFileCrypt, " \t\n\r");
            $ContenuPAge		= str_replace(" ","%20",HTTP_PLATFORM.$sort_row->ContenuPAge);

            //$typeResp 		=	 "<iframe name='iframename' id='iframeID' onload='toolbarhid();' src='$ContenuPAge' style='display: block;margin-right: auto;margin-left: auto;  height: 650px;width: 100%;' pr></iframe>";
            //$typeResp 		=	 "<object data='data:application/pdf;base64,$ContentFileCrypt'  style='display: block;margin-right: auto;margin-left: auto;  height: 650px;width: 100%;' type='application/pdf'> PDF Plugin Not Available </object>";

            $typeResp 		=	 "<input type='hidden' id='cryptFl' value='$ContentFileCrypt'><div style='width: calc(100% - 2px); height: calc(100vh - 80px);overflow: auto; margin: 1px;' ><canvas id='the-canvas' style='width=512px; height=512px; '></canvas></div>";
            $typeResp 		=	 $typeResp."<script>var xxxx = document.getElementById('cryptFl').value;
var pdfData = atob(xxxx);

// Loaded via <script> tag, create shortcut to access PDF.js exports.
var pdfjsLib = window['pdfjs-dist/build/pdf'];

// The workerSrc property shall be specified.
pdfjsLib.GlobalWorkerOptions.workerSrc = '//mozilla.github.io/pdf.js/build/pdf.worker.js';

// Using DocumentInitParameters object to load binary data.
var loadingTask = pdfjsLib.getDocument({data: pdfData});
loadingTask.promise.then(function(pdf) {
  console.log('PDF loaded');
  
  // Fetch the first page
  var pageNumber = 1;
  pdf.getPage(pageNumber).then(function(page) {
    console.log('Page loaded');
    
    var scale = 1.1;
    var viewport = page.getViewport({scale: scale});

    // Prepare canvas using PDF page dimensions
    var canvas = document.getElementById('the-canvas');
    var context = canvas.getContext('2d');
    canvas.height = viewport.height;
    canvas.width = viewport.width;

    // Render PDF page into canvas context
    var renderContext = {
      canvasContext: context,
      viewport: viewport
    };
    var renderTask = page.render(renderContext);
    renderTask.promise.then(function () {
      console.log('Page rendered');
    });
  });
}, function (reason) {
  // PDF loading error
  console.error(reason);
});</script>";

            $row[] 		= $typeResp;

            $data[] = $row;

        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" 		=> $this->Pages_model->count_filtered($d_arr),
            "recordsFiltered" 	=> $this->Pages_model->count_filtered($d_arr),
            "data" => $data,
        );

        echo json_encode($output);
    }
    public function ajax_PagesCours_list_FRAME()
    {


        $data = array();
        $d_arr = array();

        $d_arr[] = $_POST["ic"]; //IDCours
        $d_arr[] = 0; //IDCours

        $list = $this->Pages_model->get_datatables($d_arr);

        foreach ($list as $sort_row) {

            $row 			= array();
            $id 			= $sort_row->IDPage;
            $ContenuPAge	= HTTP_PLATFORM.$sort_row->ContenuPAge."#toolbar=0&navpanes=0&scrollbar=0&zoom=auto";

            //$typeResp 		=	 "<iframe name='iframename' id='iframeID' onload='toolbarhid();' src='$ContenuPAge' style='display: block;margin-right: auto;margin-left: auto;  height: 650px;width: 100%;' pr></iframe>";
            $typeResp 		=	 "<object data='$ContenuPAge'  style='display: block;margin-right: auto;margin-left: auto;  height: 650px;width: 100%;' type='application/pdf'> PDF Plugin Not Available </object>";

            $row[] 		= $typeResp;

            $data[] = $row;

        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" 		=> $this->Pages_model->count_filtered($d_arr),
            "recordsFiltered" 	=> $this->Pages_model->count_filtered($d_arr),
            "data" => $data,
        );

        echo json_encode($output);
    }

    public function ajax_PagesResume_list()
    {


        $data = array();
        $d_arr = array();

        $d_arr[] = 0; //IDResum
        $d_arr[] = $_POST["ic"]; //IDResum
        $indexSearch = $_POST["indexSearch"];
        $list = $this->Pages_model->get_datatables($d_arr);

        foreach ($list as $sort_row) {

            $row 				= array();
            $id 				= $sort_row->IDPage;

            if (strpos(strtoupper($sort_row->ContenuPAge),strtoupper("PDF"))!==false) {
                $ContentFileCrypt	= $sort_row->ContentFileCrypt;

                //$typeResp 		=	 "<iframe name='iframename' id='iframeID' onload='toolbarhid();' src='$ContenuPAge' style='display: block;margin-right: auto;margin-left: auto;  height: 650px;width: 100%;' pr></iframe>";
                //$typeResp 		=	 "<object data='data:application/pdf;base64,$ContentFileCrypt'  style='display: block;margin-right: auto;margin-left: auto;  height: 650px;width: 100%;' type='application/pdf'> PDF Plugin Not Available </object>";
                $ContentFileCrypt	= trim($ContentFileCrypt, " \t\n\r");
                $ContenuPAge		= str_replace(" ","%20",HTTP_PLATFORM.$sort_row->ContenuPAge);

                //$typeResp 		=	 "<iframe name='iframename' id='iframeID' onload='toolbarhid();' src='$ContenuPAge' style='display: block;margin-right: auto;margin-left: auto;  height: 650px;width: 100%;' pr></iframe>";
                //$typeResp 		=	 "<object data='data:application/pdf;base64,$ContentFileCrypt'  style='display: block;margin-right: auto;margin-left: auto;  height: 650px;width: 100%;' type='application/pdf'> PDF Plugin Not Available </object>";

                $typeResp 		=	 "<input type='hidden' id='cryptFl' value='$ContentFileCrypt'><div style='width: calc(100% - 2px); height: calc(100vh - 80px);overflow: auto; margin: 1px;' ><canvas id='the-canvas' style='width=512px; height=512px; '></canvas></div>";
                $typeResp 		=	 $typeResp."<script>var xxxx = document.getElementById('cryptFl').value;
var pdfData = atob(xxxx);

// Loaded via <script> tag, create shortcut to access PDF.js exports.
var pdfjsLib = window['pdfjs-dist/build/pdf'];

// The workerSrc property shall be specified.
pdfjsLib.GlobalWorkerOptions.workerSrc = '//mozilla.github.io/pdf.js/build/pdf.worker.js';

// Using DocumentInitParameters object to load binary data.
var loadingTask = pdfjsLib.getDocument({data: pdfData});
loadingTask.promise.then(function(pdf) {
  console.log('PDF loaded');
  
  // Fetch the first page
  var pageNumber = 1;
  pdf.getPage(pageNumber).then(function(page) {
    console.log('Page loaded');
    
    var scale = 1.1;
    var viewport = page.getViewport({scale: scale});

    // Prepare canvas using PDF page dimensions
    var canvas = document.getElementById('the-canvas');
    var context = canvas.getContext('2d');
    canvas.height = viewport.height;
    canvas.width = viewport.width;

    // Render PDF page into canvas context
    var renderContext = {
      canvasContext: context,
      viewport: viewport
    };
    var renderTask = page.render(renderContext);
    renderTask.promise.then(function () {
      console.log('Page rendered');
    });
  });
}, function (reason) {
  // PDF loading error
  console.error(reason);
});</script>";
            }else{
                $id_ = base64_encode($id);
                $pat =  base_url().$this->lang->line('siteLang').'cursHTML/'.$id_.'/'.$indexSearch ;
                $html 		=	 "<iframe name='iframename' id='iframeID' style='background-color: white;overflow-y: scroll;height: 35em; width: 100%'  src='$pat'   ></iframe>";

                $typeResp = "<div  id='demo' >".$html."</div>";
            }
            $row[] 		= $typeResp;

            $data[] = $row;

        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" 		=> $this->Pages_model->count_filtered($d_arr),
            "recordsFiltered" 	=> $this->Pages_model->count_filtered($d_arr),
            "data" => $data,
        );

        echo json_encode($output);
    }

    public function ajax_PagesResume_list_FRAME()
    {


        $data = array();
        $d_arr = array();

        $d_arr[] = 0; //IDResum
        $d_arr[] = $_POST["ic"]; //IDResum

        $list = $this->Pages_model->get_datatables($d_arr);

        foreach ($list as $sort_row) {

            $row 			= array();
            $id 			= $sort_row->IDPage;
            $ContenuPAge	= HTTP_PLATFORM.$sort_row->ContenuPAge."#toolbar=0&navpanes=0&scrollbar=0&zoom=auto";

            //$typeResp 		=	 "<iframe name='iframename' id='iframeID' onload='toolbarhid();' src='$ContenuPAge' style='display: block;margin-right: auto;margin-left: auto;  height: 650px;width: 100%;' pr></iframe>";
            $typeResp 		=	 "<object data='$ContenuPAge'  style='display: block;margin-right: auto;margin-left: auto;  height: 650px;width: 100%;' type='application/pdf'> PDF Plugin Not Available </object>";

            $row[] 		= $typeResp;

            $data[] = $row;

        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" 		=> $this->Pages_model->count_filtered($d_arr),
            "recordsFiltered" 	=> $this->Pages_model->count_filtered($d_arr),
            "data" => $data,
        );

        echo json_encode($output);
    }

  public function ajax_QuestionType_list()
	{

		$data = array();
		$d_arr = array();

		$typeQ   = $_POST["typeQ"];
		$idChap  = $_POST["typeC"];

		$d_arr[] = $typeQ;
		$d_arr[] = $idChap;


		$this->db->select('*');
		$this->db->from('_chapitre');
		$this->db->Where("IDChapitre = '$idChap' LIMIT 1 ");
		$resResum = $this->db->get()->result_array();
		if($typeQ=='Qroc'){
			$TitreQ = $resResum[0]["TitreQroc"];
		}else{
			$TitreQ = $resResum[0]["TitreQcm"];
		}

		$list = $this->QuestionType_model->get_datatables($d_arr);

		foreach ($list as $sort_row) {

			$row 	= array();
			$id 	= $sort_row->id;
			$name 	= $sort_row->name;
			$skill	= $sort_row->skill;
			$respo	= $sort_row->ResponseQuestion;
			$proposition1	= $sort_row->proposition1;
			$proposition2	= $sort_row->proposition2;

			$typeCh 	=  "";
			$typeResp 	=  "";

			if($sort_row->type =='text') {

				//$typeCh = $typeCh."<div class='col-12 col-md-6 col-lg-6' id='setResp' style='visibility:visible; '><div class='mb-2'><h3>Réponse</h3></div>	<div style='relative: absolute;height: 0px;'><textarea  name='getInfTXT' id='getInfTXT' class='form-control' rows='7'  readonly style='resize:none;' >$respo</textarea></div> <div style='position: relative;height: 177px;'><button id='bt_resp' class='btn btn-primary' style='height: 100%;width: 100%;' onclick='myFunction()'>Découvrir la réponse</button></div></div></div>" ;

				if($proposition1==''){
					$respo	= str_replace("<br><br>","",$respo);
					$respo	= "<i id='indc' class='align-middle mr-0 fas fa-fw fa-circle'></i>".str_replace("<br>","<br><i id='indc' class='align-middle mr-0 fas fa-fw fa-circle'></i>",$respo);

					$typeCh = "<div class='row' style='background-color: white'> 
    <div id='id_essai' class='col-12 col-md-12 col-lg-12' style='padding-bottom: 20px;'>
        <div class='mb-2'>";

					if (empty($sort_row->schemas_associes)) {
						$typeCh .= "<h3>".$this->lang->line('essaie')."</h3>";
					} else {
						$typeCh .= "
        <h3 style='width: 50%;float: inline-start;text-align: left;'>".$this->lang->line('essaie')."</h3>
        <div style='width: 50%;float: inline-end;text-align: left;'>
            <i class='fas fa-image' style='color: #0d8ddc'></i>&nbsp;&nbsp;
            ".$sort_row->schemas_associes."
        </div>";
					}

					$typeCh .= "</div>	
        <textarea name='setInf-$id' id='setInf-$id' class='form-control' rows='7' style='resize:none;'></textarea> 
        <script>
            const inputZ = document.getElementById('setInf-$id');
            inputZ.focus(); 
        </script>
    </div>
</div>";

					$typeCh =$typeCh."	<input type='hidden' name='setID[]' id='setID[]' value='$id'  />" ;
					$typeCh = $typeCh."<div class='col-12 col-md-12 col-lg-12' id='setResp' style='visibility:visible; '>
						<div class='mb-2'>
							<h3>".$this->lang->line('reponse')."</h3>
						</div>	
						<div style='relative: absolute;height: 0px;'><div style='height: auto;overflow: auto;border: 1px solid #ced4da; text-align: left;padding-left: 0.5em;max-height: 200px;' class='col-12 col-md-12 col-lg-12'>$respo</div></div> <div style='position: relative;height: 12em;' id='bt_resp' ><button id='btn_resp'  class='btn btn-primary' style='height: 100%;width: 100%;' onclick='myFunction()'>".$this->lang->line('decouv_respons')."</button></div></div></div>" ;
				}else{
					$typeCh ="<div class='row'> <div class='col-12 col-md-6 col-lg-6'><div class='mb-2'><h3>".$this->lang->line('proposition1')."</h3></div>	<textarea  name='setInf-$id' id='setInf-$id' class='form-control' rows='5' style='resize:none;' >$proposition1</textarea> </div>" ;
					$typeCh =$typeCh."	<input type='hidden' name='setID[]' id='setID[]' value='$id'  />" ;
					$typeCh = $typeCh."<div class='col-12 col-md-6 col-lg-6' id='setResp' style='visibility:visible; '>
					<div class='mb-2'>
						<h3>".$this->lang->line('proposition2')."</h3>
					</div>	
					<div>
					<textarea  name='setInf-$id' id='setInf-$id' class='form-control' rows='5' style='resize:none;' >$proposition2</textarea></div> </div></div>" ;
					$typeCh = $typeCh."<div class='row'><div class='col-12 col-md-12 col-lg-12' id='setResp' style='visibility:visible; '><div class='mb-2'><h3>".$this->lang->line('reponse')."</h3></div>	<div style='relative: absolute;height: 0px;'><div style='height: 17em;overflow: auto;border: 1px solid #ced4da;' class='col-12 col-md-12 col-lg-12'><textarea  name='setInf-$id' id='setInf-$id' class='form-control' rows='5' style='resize:none;' >$respo</textarea></div></div> <div style='position: relative;height: 17em;' id='bt_resp' ><button  class='btn btn-primary' style='height: 100%;width: 100%;' onclick='myFunction()'>".$this->lang->line('decouv_respons')."</button></div></div></div>" ;

				}


			}

			///////////************QCM*********\\\\\\\\\\
			if($sort_row->type =='checkbox') {

				$typeCh ="<div class='row'><div class='col-12 col-md-12 col-lg-12'>	<input type='hidden' name='setID[]' id='setID[]' value='$id'  />" ;
				$sel = explode("@||@", $skill);
				foreach ($sel as $va) {
					$typeResp = '';
					$typeINDC = '';
					$typeCh = $typeCh." <div style='text-align: left;'> <label class='form-check'  style='text-align: left;margin-bottom: 0rem;width: 100%;' id='setInfLab' >" ;

					if(in_array($va,explode("@||@",$respo))) {
						$typeResp = "setInf-$id";
						//$typeINDC = "<span id='indCT' class='fas fa-circle' style='float:right; color: green ; visibility: hidden'></span>";
						$typeINDC = "<span id='indCT-$id'  style='float:right; color: green ; visibility: hidden ; font-weight: bold ; font-size: 0.8em;'>".$this->lang->line('oui')."</span>";
					}else{
						$typeResp = '';
						//$typeINDC = "<span id='indCT' class='fas fa-circle' style='float:right; color: red ; visibility: hidden'></span>";
						$typeINDC = "<span id='indCT-$id'  style='float:right; color: red ; visibility: hidden ; font-weight: bold ; font-size: 0.8em; '>".$this->lang->line('non')."</span>";
					}
					$typeCh = $typeCh."	<input type='checkbox' name='setInf-$id'  value='$va' style='transform: scale(0.7);' class='form-check-input'/>" ;

					$typeCh = $typeCh." <span class='form-check-label' style='font-size: 0.9em;' id='$typeResp'>$va</span>".$typeINDC."</label>" ;
					$typeCh = $typeCh." </div><hr>" ;

					$typeCh = $typeCh;
				}
				$typeCh = $typeCh." </div></div>" ;
			}
			//$blocStart 	= "<div class='col-sm-6 mb-3 mb-md-0' style='height: 400px;'><div class='card text-center h-100'><div class='card-body d-flex flex-column'>";
			//$blocStart 	= "<div class='lead text-center mb-4' style='height: 400px;'><div class='card text-center'><div class='card-body d-flex flex-column'>";
			$blocEnd 	= "</div>	</div>	</div>";
			if($TitreQ ==''){
				$blocQ 		= "<div class='lead text-center mb-4' style='text-align:center;font-weight: bold;margin-bottom: 0.7rem !important;margin-top: 0.1em; font-size: 1.0em' >".$name."</div><h4 style='display: none' id='titleQ'></h4>";

			}else{
				$blocQ 		= "<div class='lead text-center mb-4' style='display: none'><h4 style='color: green;' id='titleQ'>$TitreQ</h4></div>".'<br>'."<div class='lead text-center mb-4' style='text-align:center;font-weight: bold;margin-bottom: 0.7rem !important;margin-top: 0.1em; font-size: 1.0em'>".$name."</div>";
			}
			if($typeQ=='Qroc'){

				$blocStart 	= "<div class='lead text-center mb-2' ><div class='card text-center' style='margin-bottom: 0.5em;background-color: #f7f7f7;'><div class='card-body d-flex flex-column' style='padding: 0.1rem;'>";

				$blocR 		= $blocStart.$typeCh.$blocEnd;
			}else{
				$blocStart 	= "<div class='lead text-center mb-2' ><div class='card text-center' style='margin-bottom: 0.5em;'><div class='card-body d-flex flex-column'>";

				//	$blocR 		= $blocStart."<div class='mb-4'><h3>Votre réponse</h3></div>".$typeCh."<div class='mb-3'><p class='text-primary'>T-primary c</p><button  class='btn btn-primary' onclick='myFunction()'>Voir solution</button></div>".$blocEnd;
				$blocR = $blocStart . $typeCh . "<div class='mb-1' style='padding-top: 0.2em;'>";

				if (empty($sort_row->schemas_associes)) {
					// Cas sans schemas_associes : centrer horizontalement bouton + texte
					$blocR .= "
        <div class='d-flex justify-content-center align-items-center' style='gap: 15px; flex-wrap: wrap;padding-left: 100px'>
            <button style='height: 30px;width: 100px;' class='btn btn-primary' onclick='myFunction($id)'>"
						. $this->lang->line('voir_respons') .
						"</button>
            <p id='setKeyResp-$id' class='text-primary' 
                style='margin: 0; font-size: .8rem; visibility: hidden;'>
                $sort_row->ResponseKey
            </p>
        </div>";
				} else {
					// Cas avec schemas_associes : structure normale
					$blocR .= "<div class='row' style='margin: 1px 0;'>
        <p style='padding-top: 3px; max-width: 60%; text-align: left; font-size: 0.8rem;'>
            <i class='fas fa-image' style='color: #0d8ddc'></i>&nbsp;&nbsp;$sort_row->schemas_associes
        </p>
        <button style='display: inline; max-width: 20%; height: 30px;' class='btn btn-primary' onclick='myFunction($id)'>"
						. $this->lang->line('voir_respons') .
						"</button>
        <p id='setKeyResp-$id' class='text-primary' 
            style='padding-top: 6px; max-width: 20%; display: inline; visibility: hidden; font-size: .8rem; text-align: left; padding-left: 5px;'>
            $sort_row->ResponseKey
        </p>
    </div>";
				}

				$blocR .= "</div>" . $blocEnd;

			}

			$blocC 		= "";//$blocStart."<div class='mb-4'><h3>Solution</h3></div>".$typeResp.$blocEnd;

			$row[] = "<div class='row py-1' style='background-color: white;box-shadow: 0 4px 6px rgba(0, 0, 0, 0);'>".$blocQ.$blocR.$blocC."</div>";


			$data[] = $row;

		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" 		=> $this->QuestionType_model->count_filtered($d_arr),
			"recordsFiltered" 	=> $this->QuestionType_model->count_filtered($d_arr),
			"data" => $data,
		);

		echo json_encode($output);
	}

    public function suppQuestion(){

        $idQ 		= $_POST["idC"];
        $idChap 	= $_POST["idCh"];
        //$idQ 		= base64_decode($id);
//		print_r($idQ.'----'.$idChap);
//		return false;
        if((strlen($this->session->userdata('passTok'))==200) && ($this->session->userdata('EstAdmin') ==1)) {

            // SUPP _questiontype
            $this->db->query("delete FROM `_questiontype` WHERE id = '$idQ' ;");

            // SUPP CURSE & RESUME & PAGE
            $this->db->select('*');
            $this->db->from('_questiontype');
            $this->db->Where("OperationType","QCM");
            $this->db->Where("IDChapitre",$idChap);
            $res_Ch = $this->db->get()->result_array();
            if(count($res_Ch)==0){
                $data_Chap = array('NbreQcm' 	=> '0' , 'TitreQcm' => '');
                $this->db->where('IDChapitre', $idChap);
                $this->db->update('_chapitre', $data_Chap);
            }

            $arr_Res[] = array("id" => '1', "desc" => '') ;
        }
        else{
            $arr_Res[] = array("id" => '-1', "desc" => $this->lang->line('supp_delErr')) ;
        }

        echo json_encode($arr_Res);
        exit;

    }
    public function ajax_QuestionType_listEdit()
    {

        $data  	 = array();
        $d_arr 	 = array();


        $typeQ   = $_POST["typeQ"];
        $idChap  = $_POST["typeC"];

        $d_arr[] = $typeQ;
        $d_arr[] = $idChap;

        $this->db->select('*');
        $this->db->from('_chapitre');
        $this->db->Where("IDChapitre = '$idChap' LIMIT 1 ");
        $resResum = $this->db->get()->result_array();
        if($typeQ=='Qroc'){
            $TitreQ = $resResum[0]["TitreQroc"];
        }else{
            $TitreQ = $resResum[0]["TitreQcm"];
        }

        $list = $this->QuestionType_model->get_datatables($d_arr);

        if($typeQ=='QCM'){
            $d_arrVid 	 = array(
                'id' 				=> '-1',
                'name' 				=> '',
                'skill' 			=> '',
                'type' 				=> 'checkbox',
                'OperationType' 	=> 'QCM',
                'ResponseQuestion' 	=> '',
                'IDChapitre' 		=> $idChap,
                'ResponseKey' 		=> '',
                'proposition1' 		=> '',
                'proposition2' 		=> '',
                'schemas_associes' 	=> ''
            );
            //print_r($list);
            $list[] = (object)$d_arrVid;
        }


        foreach ($list as $sort_row) {

            $row 	= array();
            $id 	= $sort_row->id;
            $name 	= $sort_row->name;
            $skill	= $sort_row->skill;
            $respo	= $sort_row->ResponseQuestion;
            $proposition1	= $sort_row->proposition1;
            $proposition2	= $sort_row->proposition2;

            $typeCh 	=  "";
            $typeResp 	=  "";

            $blocMod = '';
            $blocModProp = '';
            if($sort_row->type =='text') {

                //$typeCh = $typeCh."<div class='col-12 col-md-6 col-lg-6' id='setResp' style='visibility:visible; '><div class='mb-2'><h3>Réponse</h3></div>	<div style='relative: absolute;height: 0px;'><textarea  name='getInfTXT' id='getInfTXT' class='form-control' rows='7'  readonly style='resize:none;' >$respo</textarea></div> <div style='position: relative;height: 177px;'><button id='bt_resp' class='btn btn-primary' style='height: 100%;width: 100%;' onclick='myFunction()'>Découvrir la réponse</button></div></div></div>" ;

                if($proposition1==''){
                    $respo	= str_replace("<br><br>","",$respo);
                    $respo	= "<i id='indc' class='align-middle mr-0 fas fa-fw fa-circle'></i>".str_replace("<br>","<br><i id='indc' class='align-middle mr-0 fas fa-fw fa-circle'></i>",$respo);

                    $typeCh ="<div class='row' style='background-color: white;'> <div id='id_essai' class='col-12 col-md-6 col-lg-6'><div class='mb-2'><h3>".$this->lang->line('essaie')."</h3></div>	<textarea  name='setInf-$id' id='setInf-$id' class='form-control' rows='5' style='resize:none;' ></textarea> </div>" ;
                    $typeCh =$typeCh."	<input type='hidden' name='setID[]' id='setID[]' value='$id'  />" ;
                    if($this->session->userdata('EstAdmin') ==0){
                        $showBtnQroc = "<button  class='btn btn-primary' style='height: 100%;width: 100%;' onclick='myFunction()'>".$this->lang->line('decouv_respons')."</button>";
                    }else{$showBtnQroc = "";}
                    $typeCh = $typeCh."<div class='col-12 col-md-6 col-lg-6' id='setResp' style='visibility:visible; '><div class='mb-2'><h3>".$this->lang->line('reponse')."</h3></div>	<div style='relative: absolute;height: 0px;'><div style='height: 17em;overflow: auto;border: 1px solid #ced4da; text-align: left;padding-left: 0.5em;' class='col-12 col-md-12 col-lg-12'>$respo</div></div> <div style='position: relative;height: 17em;' id='bt_resp' >$showBtnQroc</div></div></div>" ;
                }else{
                    $typeCh ="<div class='row'> <div class='col-12 col-md-6 col-lg-6'><div class='mb-2'><h3>".$this->lang->line('proposition1')."</h3></div>	<textarea  name='setInf-$id' id='setInf-$id' class='form-control' rows='5' style='resize:none;' >$proposition1</textarea> </div>" ;
                    $typeCh =$typeCh."	<input type='hidden' name='setID[]' id='setID[]' value='$id'  />" ;
                    $typeCh = $typeCh."<div class='col-12 col-md-6 col-lg-6' id='setResp' style='visibility:visible; '><div class='mb-2'><h3>".$this->lang->line('proposition2')."</h3></div>	<div><textarea  name='setInf-$id' id='setInf-$id' class='form-control' rows='5' style='resize:none;' >$proposition2</textarea></div> </div></div>" ;
                    $typeCh = $typeCh."<div class='row'><div class='col-12 col-md-12 col-lg-12' id='setResp' style='visibility:visible; '><div class='mb-2'><h3>".$this->lang->line('reponse')."</h3></div>	<div style='relative: absolute;height: 0px;'><div style='height: 17em;overflow: auto;border: 1px solid #ced4da;' class='col-12 col-md-12 col-lg-12'><textarea  name='setInf-$id' id='setInf-$id' class='form-control' rows='5' style='resize:none;' >$respo</textarea></div></div> <div style='position: relative;height: 17em;' id='bt_resp' ><button  class='btn btn-primary' style='height: 100%;width: 100%;' onclick='myFunction()'>".$this->lang->line('decouv_respons')."</button></div></div></div>" ;

                }

            }

            ///////////************QCM*********\\\\\\\\\\
            if($sort_row->type =='checkbox') {
                $sel = explode("@||@", $skill);

                $typeCh ="<div class='row'>
							<div class='col-12 col-md-12 col-lg-12'>
								<input id='cmp_$id' type='hidden' value='".count($sel)."'/>
								<input type='hidden' name='setID[]' id='setID[]' value='$id'  />" ;
                $cmpRo = 1;
                foreach ($sel as $va) {
                    $typeResp = '';
                    $typeINDC = '';

                    $typeCh = $typeCh." <div> <label class='form-check'  style='text-align: left;margin-bottom: 1rem;' id='setInfLab' >" ;

                    if(in_array($va,explode("@||@",$respo))) {
                        $typeResp = "setInf-$id";
                        $ischecked = 'checked';
                        //$typeINDC = "<span id='indCT' class='fas fa-circle' style='float:right; color: green ; visibility: hidden'></span>";
                        $typeINDC = "<span id='indCT-$id'  style='float:right; color: green ; visibility: hidden ; font-weight: bold ; font-size: 0.99em;'>".$this->lang->line('oui')."</span>";
                    }else{
                        $typeResp = '';
                        $ischecked = '';
                        //$typeINDC = "<span id='indCT' class='fas fa-circle' style='float:right; color: red ; visibility: hidden'></span>";
                        $typeINDC = "<span id='indCT-$id'  style='float:right; color: red ; visibility: hidden ; font-weight: bold ; font-size: 0.99em; '>".$this->lang->line('non')."</span>";
                    }

                    $blocModProp = $blocModProp."<div  id='$id"."_"."$cmpRo' class='row' style='margin-top: 0.5em'>
													<div class='col-xs-7 col-sm-7 col-md-11'>
														<div class='form-group'>
															<label class='form-check' style='text-align: left;margin-bottom: 1rem;' id='setInfLab'>
																<input type='checkbox' id='setChek_".$id."_".$cmpRo."' name='setChek_".$id."[]' $ischecked value='".str_replace("'",'&#39;',$va)."'  class='form-check-input'/>
																<input onkeyup='addCheck(this,$id,$cmpRo)' name='list_Prop[]' type='text' placeholder='Titre de chapitre' value='".str_replace("'",'&#39;',$va)."' class='form-control'/>
																<input name='setChapID' type='hidden' value='".$idChap."'/>
															</label>
														</div>
													</div>" ;
                    $blocModProp = $blocModProp."<div class='col-xs-1 col-sm-1 col-md-1'>
													<button name='$id' class='btn btn-danger list_remove_button' onclick='delChap(".$id.",".$cmpRo.")' type='button' value='$id'>-</button>
													</div>
												</div>" ;
                    $blocModProp = $blocModProp.'';

                    $typeCh = $typeCh."	<input type='checkbox' name='setInf-$id'  value='$va' style='transform: scale(0.7);' class='form-check-input'/>" ;

                    $typeCh = $typeCh." <span class='form-check-label' style='font-size: 1.1em;' id='$typeResp'>$va</span>".$typeINDC."</label>" ;
                    $typeCh = $typeCh." </div><hr>" ;

                    $typeCh = $typeCh;
                    $cmpRo++;
                }

                $typeCh = $typeCh." </div></div>" ;
            }
            //$blocStart 	= "<div class='col-sm-6 mb-3 mb-md-0' style='height: 400px;'><div class='card text-center h-100'><div class='card-body d-flex flex-column'>";
            //$blocStart 	= "<div class='lead text-center mb-4' style='height: 400px;'><div class='card text-center'><div class='card-body d-flex flex-column'>";
            $blocEnd 	= "</div>	</div>	</div>";
            if($TitreQ ==''){
                $blocQ 		= "<div class='lead text-center mb-4' style='font-weight: bold;margin-bottom: 0.7rem !important;margin-top: 0.5em; font-size: 1.4em' >
									<a href='#' data-toggle='modal' data-target='#modal_$id'>
										<i class='fa fa-pencil-alt' style='font-size: 0.8em;' ></i>
									</a>"."<a href='#' onclick='suppQ(".$id.",".$idChap.")' name='".str_replace("'",'&#39;',$name)."' id='quesNam_$id' >
										<i class='fa  fa-trash-alt' style='font-size: 0.8em;' ></i>
									</a>".$name."
								</div><h4 style='display: none' id='titleQ'></h4>";

                //$blocMod	= $blocMod."";
                //$blocMod	= $blocMod."";
            }else{
                $blocQ 		= "<div class='lead text-center mb-4' style='display: none'>
									<h4 style='color: green;' id='titleQ'>$TitreQ</h4>
							   </div>".'<br>'."<div class='lead text-center mb-4' style='font-weight: bold;margin-bottom: 0.7rem !important;margin-top: 0.5em; font-size: 1.4em'>
							   	<a href='#' data-toggle='modal' data-target='#modal_$id'>
							   		<i class='fa fa-pencil-alt' style='font-size: 0.8em;'></i>
							   	</a>"."<a href='#' onclick='suppQ(".$id.",".$idChap.")' name='".str_replace("'",'&#39;',$name)."' id='quesNam_$id' >
										<i class='fa  fa-trash-alt' style='font-size: 0.8em;' ></i>
									</a>".$name."</div>";
            }
            $blocMod	= "<div class='modal fade' id='modal_$id' tabindex='1' style='display: none;' aria-hidden='true'>";
            $blocMod	= $blocMod."<div class='modal-dialog modal-lg' role='document'><div class='modal-content'>";
            $blocMod	= $blocMod."<div class='modal-header'>
										<label class='form-check' style='text-align: left;'>
											<h3>Titre&nbsp;&nbsp;</h3> 
										</label>
										<input type='text' name='questTitle' value='$TitreQ' class='form-control' >
										<input type='hidden' name='questID' value='$id'>
										<div class='col-xs-1 col-sm-1 col-md-1' style='padding-left: 1rem;'>
											<button name='$id' class='btn btn-primary list_add_button' onclick='addRowQ(this)' type='button' value='$id'>+</button>
										</div>
									</div>";
            $blocMod = $blocMod."<div class='card-body'>
										<label class='form-check' style='text-align: left;'>
											<h3>".$this->lang->line('question')."&nbsp;&nbsp;</h3> 
										</label>
										<input type='text' name='questName' value='".str_replace("'",'&#39;',$name)."' class='form-control' ><div class='list_wrapper_$id'>";
            $blocModFoot="<div class='modal-footer'>
							<button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
								<button type='button' class='btn btn-primary' onclick='upd_QuestionQcm($id)' >Save changes</button>
						  </div>";
            $blocMod	= "<form name='pageForm_UpQuestQcm_".$id."' id='pageForm_UpQuestQcm_".$id."' action=''>".$blocMod.$blocModProp."</div></div>".$blocModFoot."</div></div></div></form>";
            $blocQ	= $blocQ.$blocMod;
            if($typeQ=='QCM'){

                $blocStart 	= "<div class='lead text-center mb-2' >
				<div class='card text-center' style='margin-bottom: 0.5em;'>
					<div class='card-body d-flex flex-column'>";

                //	$blocR 		= $blocStart."<div class='mb-4'><h3>Votre réponse</h3></div>".$typeCh."<div class='mb-3'><p class='text-primary'>T-primary c</p><button  class='btn btn-primary' onclick='myFunction()'>Voir solution</button></div>".$blocEnd;
                $blocR = $blocStart.$typeCh.
                    "<div class='mb-1' style='padding-top: 1em; text-align: center;'>
        <div style='display: flex; align-items: center; justify-content: center; gap: 1em;'>
             <p style='margin: 0; padding-top: 3px; max-width: 40%; text-align: left; font-size: 0.8rem;'>
                <i class='fas fa-image' style='color: #0d8ddc'></i> $sort_row->schemas_associes
            </p>
            <button class='btn btn-primary' onclick='myFunction($id)'>".$this->lang->line('voir_respons')."</button>
            <p id='setKeyResp-$id' class='text-primary' style='display: inline; visibility: hidden'>$sort_row->ResponseKey</p>
        </div>
    </div>".$blocEnd;
            }

            $blocC 		= "";//$blocStart."<div class='mb-4'><h3>Solution</h3></div>".$typeResp.$blocEnd;

            $row[] = "<div class='row py-1' style='background-color: white;'>".$blocQ.$blocR.$blocC."</div>";


            $data[] = $row;

        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" 		=> $this->QuestionType_model->count_filtered($d_arr),
            "recordsFiltered" 	=> $this->QuestionType_model->count_filtered($d_arr),
            "data" => $data,

        );

        echo json_encode($output);
    }
    public function upd_QuestionQcm(){

        $IDQest 			= $_POST["questID"];
        $NameQ 				= $_POST["questName"];
        $questTitle 		= $_POST["questTitle"];
        $idChap 			= $_POST["setChapID"];
        $list_Prop 			= array();
        $list_setChek 		= array();

        if(isset($_POST["setChek_".$IDQest]))
        {
            $list_setChek = $_POST["setChek_".$IDQest];
            $ResponseQuestion 	= '@||@';
        }else{
            $ResponseQuestion 	= '';
        }

        if(isset($_POST["list_Prop"]))
        {$list_Prop = $_POST["list_Prop"];}

        $propos 			= '';
        foreach ($list_Prop as $key=>$val){
            $propos = $propos.$val.'@||@';
        }
        if($propos != ''){
            $propos = $propos.'@||@';
            $propos = str_replace('@||@@||@','',$propos);
        }
        $ResponseKey = ' ';
        foreach ($list_setChek as $key=>$val){
            $ResponseQuestion = $ResponseQuestion.$val.'@||@';
            $ResponseKey = $ResponseKey.substr($val, 0, 1)." ; ";
        }
        $ResponseKey = $ResponseKey.";";
        $ResponseKey = str_replace('; ;','',$ResponseKey);

        $data_QR = array(
            'name' 				=> $NameQ,
            'skill' 			=> $propos,
            'ResponseQuestion' 	=> $ResponseQuestion,
            'ResponseKey' 		=> $ResponseKey,//
            'type' 				=> 'checkbox',
            'OperationType' 	=> 'QCM',
            'IDChapitre' 		=> $idChap
        );
        if($IDQest>0){
            $this->db->Where("id",$IDQest);
            $this->db->update('_questiontype',$data_QR);
        }else{
            $this->db->Where("id",$IDQest);
            $this->insert_dd('_questiontype',$data_QR);
        }

        $data_Chap = array('NbreQcm' 	=> '1' , 'TitreQcm' => $questTitle);
        $this->db->where('IDChapitre', $idChap);
        $this->db->update('_chapitre', $data_Chap);

        $desc = '' ;//$newTitre;

        $arr_Res[] = array("id" => '1', "desc" => $desc) ;

        echo json_encode($arr_Res);
        exit;
    }
    public function  livreQcmEdit($id)
    {
        $this->db->select('*');
        $this->db->from('_chapitre ,_livre , _theme');
        $this->db->Where("IDChapitre = '$id' AND _chapitre.IDLivre = _livre.IDLivre AND _theme.IDTheme = _livre.IDTheme");
        $resChap = $this->db->get()->result_array();

        $arr['OneBook'] 	= $resChap;
        $arr['page'] 		= 'livreQcm';
        $arr['listCat'] 	= $this->getListCategory();
        $this->load->view('livreQcmEdit',$arr);
    }
    public function suppQuestionQrc(){

        $idQ 		= $_POST["idC"];
        $idChap 	= $_POST["idCh"];
        //$idQ 		= base64_decode($id);
//		print_r($idQ.'----'.$idChap);
//		return false;
        if((strlen($this->session->userdata('passTok'))==200) && ($this->session->userdata('EstAdmin') ==1)) {

            // SUPP _questiontype
            $this->db->query("delete FROM `_questiontype` WHERE id = '$idQ' ;");

            // SUPP CURSE & RESUME & PAGE
            $this->db->select('*');
            $this->db->from('_questiontype');
            $this->db->Where("OperationType","QROC");
            $this->db->Where("IDChapitre",$idChap);
            $res_Ch = $this->db->get()->result_array();
            if(count($res_Ch)==0){
                $data_Chap = array('NbreQroc' 	=> '0' , 'TitreQroc' => '');
                $this->db->where('IDChapitre', $idChap);
                $this->db->update('_chapitre', $data_Chap);
            }

            $arr_Res[] = array("id" => '1', "desc" => '') ;
        }
        else{
            $arr_Res[] = array("id" => '-1', "desc" => $this->lang->line('supp_delErr')) ;
        }

        echo json_encode($arr_Res);
        exit;

    }
    public function ajax_QROC_listEdit()
    {

        $data  	 = array();
        $d_arr 	 = array();

        $typeQ   = $_POST["typeQ"];
        $idChap  = $_POST["typeC"];
//print_r($typeQ);
//return false ;
        $d_arr[] = $typeQ;
        $d_arr[] = $idChap;

        $this->db->select('*');
        $this->db->from('_chapitre');
        $this->db->Where("IDChapitre = '$idChap' LIMIT 1 ");
        $resResum = $this->db->get()->result_array();
        if($typeQ=='QROC'){
            $TitreQ = $resResum[0]["TitreQroc"];
        }else{
            $TitreQ = $resResum[0]["TitreQcm"];
        }

        $list = $this->QuestionType_model->get_datatables($d_arr);

        if($typeQ=='QROC'){
            $d_arrVid 	 = array(
                'id' 				=> '-1',
                'name' 				=> '',
                'skill' 			=> '',
                'type' 				=> 'text',
                'OperationType' 	=> 'QROC',
                'ResponseQuestion' 	=> '',
                'IDChapitre' 		=> $idChap,
                'ResponseKey' 		=> '',
                'proposition1' 		=> '',
                'proposition2' 		=> ''
            );
            //print_r($list);
            $list[] = (object)$d_arrVid;
        }


        foreach ($list as $sort_row) {

            $row 	= array();
            $id 	= $sort_row->id;
            $name 	= $sort_row->name;
            $skill	= $sort_row->skill;
            $respo	= $sort_row->ResponseQuestion;
            $proposition1	= $sort_row->proposition1;
            $proposition2	= $sort_row->proposition2;

            $typeCh 	=  "";
            $typeResp 	=  "";

            $blocMod = '';
            $blocModProp = "<div class='row' style='background-color: white;'>
 								<div class='col-12 col-md-12 col-lg-12'><div class='mb-2'><h3>Réponse (chaque ligne séparée par ;)</h3></div>
 									<textarea name='setInf-$id' id='setInf-$id' class='form-control' rows='13' style='resize:none;'></textarea>
 								</div> 
							</div>";
            if($sort_row->type =='text') {

                //$typeCh = $typeCh."<div class='col-12 col-md-6 col-lg-6' id='setResp' style='visibility:visible; '><div class='mb-2'><h3>Réponse</h3></div>	<div style='relative: absolute;height: 0px;'><textarea  name='getInfTXT' id='getInfTXT' class='form-control' rows='7'  readonly style='resize:none;' >$respo</textarea></div> <div style='position: relative;height: 177px;'><button id='bt_resp' class='btn btn-primary' style='height: 100%;width: 100%;' onclick='myFunction()'>Découvrir la réponse</button></div></div></div>" ;

                if($proposition1==''){
                    $sel = explode("<br>", $respo);
                }else{$sel = explode("&#10;", $respo);}


                $cmpRo = 1;

                $respAFF = str_replace('<br>','&#10;',$respo);
                $blocModProp = "<div class='row' style='background-color: white;'>
 										<div class='col-12 col-md-12 col-lg-12'>
 											<div class='mb-2'><h3>Propositions I (chaque ligne séparée par ;)</h3></div>
 											<textarea name='setInfP1-$id' id='setInfP1-$id' class='form-control' rows='8' style='resize:none;'>$proposition1</textarea>
 										</div> 
 										<div class='col-12 col-md-12 col-lg-12'>
 											<div class='mb-2'><h3>Propositions II (chaque ligne séparée par ;)</h3></div>
 											<textarea name='setInfP2-$id' id='setInfP2-$id' class='form-control' rows='8' style='resize:none;'>$proposition2</textarea>
 										</div> 
									</div>";
                $blocModProp = $blocModProp."<div class='row' style='background-color: white;'>
 										<div class='col-12 col-md-12 col-lg-12'>
 											<div class='mb-2'><h3>Réponse (chaque ligne séparée par ;)</h3></div>
 											<textarea name='setInf-$id' id='setInf-$id' class='form-control' rows='8' style='resize:none;'>$respAFF</textarea>
 										</div> 
									</div>";

                if($proposition1==''){

                    $respo	= str_replace("<br><br>","",$respo);
                    $respo	= "<i id='indc' class='align-middle mr-0 fas fa-fw fa-circle'></i>".str_replace("<br>","<br><i id='indc' class='align-middle mr-0 fas fa-fw fa-circle'></i>",$respo);

                    $typeCh ="<div class='row' style='background-color: white;'>
 									<div class='col-12 col-md-6 col-lg-6'><div class='mb-2'><h3>".$this->lang->line('essaie')."</h3></div>
 										<textarea  name='setInf-$id' id='setInf-$id' class='form-control' rows='13' style='resize:none;' ></textarea>
 							   </div>" ;
                    $typeCh =$typeCh." <input id='cmp_$id' type='hidden' value='".count($sel)."'/>
 										<input type='hidden' name='setID[]' id='setID[]' value='$id'  />" ;
                    if($this->session->userdata('EstAdmin') ==0){
                        $showBtnQroc = "<button  class='btn btn-primary' style='height: 100%;width: 100%;' onclick='myFunction()'>".$this->lang->line('decouv_respons')."</button>";
                    }else{$showBtnQroc = "";}
                    $typeCh = $typeCh."<div class='col-12 col-md-6 col-lg-6' id='setResp' style='visibility:visible; '><div class='mb-2'><h3>".$this->lang->line('reponse')."</h3></div>	<div style='relative: absolute;height: 0px;'><div style='height: 17em;overflow: auto;border: 1px solid #ced4da; text-align: left;padding-left: 0.5em;' class='col-12 col-md-12 col-lg-12'>$respo</div></div> <div style='position: relative;height: 17em;' id='bt_resp' >$showBtnQroc</div></div></div>" ;
                }else{
                    $typeCh ="<div class='row'> <div class='col-12 col-md-6 col-lg-6'><div class='mb-2'><h3>".$this->lang->line('proposition1')."</h3></div>	<textarea  name='setInf-$id' id='setInf-$id' class='form-control' rows='8' style='resize:none;' >$proposition1</textarea> </div>" ;
                    $typeCh =$typeCh." <input id='cmp_$id' type='hidden' value='".count($sel)."'/>
 										<input type='hidden' name='setID[]' id='setID[]' value='$id'  />" ;
                    $typeCh = $typeCh."<div class='col-12 col-md-6 col-lg-6' id='setResp' style='visibility:visible; '><div class='mb-2'><h3>".$this->lang->line('proposition2')."</h3></div>	<div><textarea  name='setInf-$id' id='setInf-$id' class='form-control' rows='8' style='resize:none;' >$proposition2</textarea></div> </div></div>" ;
                    $typeCh = $typeCh."<div class='row'><div class='col-12 col-md-12 col-lg-12' id='setResp' style='visibility:visible; '><div class='mb-2'><h3>".$this->lang->line('reponse')."</h3></div>	<div style='relative: absolute;height: 0px;'><div style='height: 17em;overflow: auto;border: 1px solid #ced4da;' class='col-12 col-md-12 col-lg-12'><textarea  name='setInf-$id' id='setInf-$id' class='form-control' rows='8' style='resize:none;' >$respo</textarea></div></div> <div style='position: relative;height: 17em;' id='bt_resp' ><button  class='btn btn-primary' style='height: 100%;width: 100%;' onclick='myFunction()'>".$this->lang->line('decouv_respons')."</button></div></div></div>" ;

                }

            }

            //$blocStart 	= "<div class='col-sm-6 mb-3 mb-md-0' style='height: 400px;'><div class='card text-center h-100'><div class='card-body d-flex flex-column'>";
            //$blocStart 	= "<div class='lead text-center mb-4' style='height: 400px;'><div class='card text-center'><div class='card-body d-flex flex-column'>";
            $blocEnd 	= "</div>	</div>	</div>";
            if($TitreQ ==''){
                $blocQ 		= "<div class='lead text-center mb-4' style='font-weight: bold;margin-bottom: 0.7rem !important;margin-top: 0.5em; font-size: 1.4em' >
									<a href='#' data-toggle='modal' data-target='#modal_$id'>
										<i class='fa fa-pencil-alt' style='font-size: 0.8em;' ></i>
									</a>"."<a href='#' onclick='suppQ(".$id.",".$idChap.")' name='".str_replace("'",'&#39;',$name)."' id='quesNam_$id' >
										<i class='fa  fa-trash-alt' style='font-size: 0.8em;' ></i>
									</a>".$name."
								</div><h4 style='display: none' id='titleQ'></h4>";

                //$blocMod	= $blocMod."";
                //$blocMod	= $blocMod."";
            }else{
                $blocQ 		= "<div class='lead text-center mb-4' style='display: none'>
									<h4 style='color: green;' id='titleQ'>$TitreQ</h4>
							   </div>".'<br>'."<div class='lead text-center mb-4' style='font-weight: bold;margin-bottom: 0.7rem !important;margin-top: 0.5em; font-size: 1.4em'>
							   	<a href='#' data-toggle='modal' data-target='#modal_$id'>
							   		<i class='fa fa-pencil-alt' style='font-size: 0.8em;'></i>
							   	</a>"."<a href='#' onclick='suppQ(".$id.",".$idChap.")' name='".str_replace("'",'&#39;',$name)."' id='quesNam_$id' >
										<i class='fa  fa-trash-alt' style='font-size: 0.8em;' ></i>
									</a>".$name."</div>";
            }
            $blocMod	= "<div class='modal fade' id='modal_$id' tabindex='1' style='display: none;' aria-hidden='true'>";
            $blocMod	= $blocMod."<div class='modal-dialog modal-lg' role='document'><div class='modal-content'>";
            $blocMod	= $blocMod."<div class='modal-header'>
										<label class='form-check' style='text-align: left;'>
											<h3>Titre&nbsp;&nbsp;</h3> 
										</label>
										<input type='text' name='questTitle' value='$TitreQ' class='form-control' >
										<input type='hidden' name='questID' value='$id'>
										<input name='setChapID' type='hidden' value='".$idChap."'/>
									</div>";
            $blocMod	= $blocMod."<div class='card-body'>
										<label class='form-check' style='text-align: left;'>
											<h3>".$this->lang->line('question')."&nbsp;&nbsp;</h3> 
										</label>
										<input type='text' name='questName' value='".str_replace("'",'&#39;',$name)."' class='form-control' ><div class='list_wrapper_$id'>";
            $blocModFoot="<div class='modal-footer'>
							<button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
								<button type='button' class='btn btn-primary' onclick='upd_QuestionQroc($id)' >Save changes</button>
						  </div>";
            $blocMod	= "<form name='pageForm_UpQuestQcm_".$id."' id='pageForm_UpQuestQcm_".$id."' action=''>".$blocMod.$blocModProp."</div></div>".$blocModFoot."</div></div></div></form>";
            $blocQ	= $blocQ.$blocMod;
            if($typeQ=='QROC'){

                $blocStart 	= "<div class='lead text-center mb-2' ><div class='card text-center' style='margin-bottom: 0.5em;background-color: #f7f7f7;'><div class='card-body d-flex flex-column' style='padding: 0.1rem;'>";

                $blocR 		= $blocStart.$typeCh.$blocEnd;
            }else{
                $blocStart 	= "<div class='lead text-center mb-2' ><div class='card text-center' style='margin-bottom: 0.5em;'><div class='card-body d-flex flex-column'>";

                //	$blocR 		= $blocStart."<div class='mb-4'><h3>Votre réponse</h3></div>".$typeCh."<div class='mb-3'><p class='text-primary'>T-primary c</p><button  class='btn btn-primary' onclick='myFunction()'>Voir solution</button></div>".$blocEnd;
                $blocR 		= $blocStart.$typeCh."<div class='mb-1' style='padding-top: 1em;'><button style='  display: inline;' class='btn btn-primary' onclick='myFunction()'>".$this->lang->line('voir_respons')."</button><p id='setKeyResp' class='text-primary' style='display: inline; visibility: hidden'>$sort_row->ResponseKey</p></div>".$blocEnd;
            }

            $blocC 		= "";//$blocStart."<div class='mb-4'><h3>Solution</h3></div>".$typeResp.$blocEnd;

            $row[] = "<div class='row py-1' style='background-color: white;'>".$blocQ.$blocR.$blocC."</div>";


            $data[] = $row;

        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" 		=> $this->QuestionType_model->count_filtered($d_arr),
            "recordsFiltered" 	=> $this->QuestionType_model->count_filtered($d_arr),
            "data" => $data,

        );

        echo json_encode($output);
    }

    public function  livreQrocEdit($id)
    {
        $this->db->select('*');
        $this->db->from('_chapitre ,_livre , _theme');
        $this->db->Where("IDChapitre = '$id' AND _chapitre.IDLivre = _livre.IDLivre AND _theme.IDTheme = _livre.IDTheme");
        $resChap = $this->db->get()->result_array();

        $arr['OneBook'] 	= $resChap;
        $arrlivreQroc['page'] 		= 'livreQroc';
        $arr['listCat'] 	= $this->getListCategory();
        $this->load->view('livreQrocEdit',$arr);
    }

    public function upd_QuestionQroc(){

        $IDQest 			= $_POST["questID"];
        $NameQ 				= $_POST["questName"];
        $questTitle 		= $_POST["questTitle"];
        $idChap 			= $_POST["setChapID"];
        $props1 			= $_POST["setInfP1-".$IDQest];
        $props2 			= $_POST["setInfP2-".$IDQest];
        $repons 			= $_POST["setInf-".$IDQest];
//print_r($questTitle);
//return false;
        /*	if(empty($props1)){
                $repons = str_replace(';','; <br>',$repons);
            }else{$repons = str_replace(';',';',$repons);}
    */
        $repons = str_replace(';','; <br>',$repons);
        //$props1 = str_replace(';','; <br>',$props1);
        //$props2 = str_replace(';','; <br>',$props2);

        $data_QR = array(
            'name' 				=> $NameQ,
            'ResponseQuestion' 	=> $repons,
            'type' 				=> 'text',
            'OperationType' 	=> 'QROC',
            'proposition1' 		=> $props1,
            'proposition2' 		=> $props2,
            'ResponseKey' 		=> '',
            'IDChapitre' 		=> $idChap
        );

        if($IDQest>0){
            $this->db->Where("id",$IDQest);
            $this->db->update('_questiontype',$data_QR);
        }else{
            $this->db->Where("id",$IDQest);
            $this->insert_dd('_questiontype',$data_QR);
        }

        $data_Chap = array('NbreQroc' 	=> '1' , 'TitreQroc' => $questTitle);
        $this->db->where('IDChapitre', $idChap);
        $this->db->update('_chapitre', $data_Chap);

        $desc = '' ;//$newTitre;

        $arr_Res[] = array("id" => '1', "desc" => $desc) ;

        echo json_encode($arr_Res);
        exit;
    }

    public function  searchIndex()
    {

        if(isset($_POST["indexSearch"])){
            $indexSearch 			= $_POST["indexSearch"].'';
            $currLang = str_replace('/','',$this->lang->line('siteLang')) ;
            //search in Livre
            $this->db->select(" * ");
            $this->db->from(' _livre');
            $this->db->join('_theme', '_livre.IDTheme = _theme.IDTheme');
            $this->db->join('_category', '_category.IDCategory= _theme.IDCategory');
            $this->db->Where('multi_lingue',$currLang);
            $this->db->like('_livre.indexKeysBook ', $indexSearch );
            $resSearchLiv = $this->db->get()->result_array();

        	$resSearchCh  = array();//$this->db->get()->result_array();

            $this->db->select("_chapitre.*,  _theme.* ,_livre.Titre");
            $this->db->from('_cours');
            $this->db->join('_chapitre', '_chapitre.IDChapitre = _cours.IDChapitre');
            $this->db->join('_livre', '_livre.IDLivre = _chapitre.IDLivre');
            $this->db->join('_theme', '_theme.IDTheme = _livre.IDTheme');
            $this->db->join('_category', '_category.IDCategory= _theme.IDCategory');
            $this->db->Where('multi_lingue',$currLang);
            $this->db->like('_chapitre.indexKeysCurs', $indexSearch );
            $resSearchCurs = $this->db->get()->result_array();

            $this->db->select("_chapitre.* , _theme.* ,_livre.Titre");
            $this->db->from('_resume');
            $this->db->join('_chapitre', '_chapitre.IDChapitre = _resume.IDChapitre');
            $this->db->join('_livre', '_livre.IDLivre = _chapitre.IDLivre');
            $this->db->join('_theme', '_theme.IDTheme = _livre.IDTheme');
            $this->db->join('_category', '_category.IDCategory= _theme.IDCategory');
            $this->db->Where('multi_lingue',$currLang);
            $this->db->like('_chapitre.indexKeysResum', $indexSearch );
            $resSearchResum = $this->db->get()->result_array();

            $this->db->select("_chapitre.* , _questiontype.* , _theme.* ,_livre.Titre ,CONCAT(SUBSTRING(name, 1, 10),'...',SUBSTRING(name, 40, 100),' ?') AS nameQ ");
            $this->db->from('_questiontype');
            $this->db->join('_chapitre', '_chapitre.IDChapitre = _questiontype.IDChapitre');
            $this->db->join('_livre', '_livre.IDLivre = _chapitre.IDLivre');
            $this->db->join('_theme', '_theme.IDTheme = _livre.IDTheme');
            $this->db->join('_category', '_category.IDCategory= _theme.IDCategory');
            $this->db->Where('multi_lingue',$currLang);
            $this->db->Where('OperationType','QCM');
            $this->db->like('_chapitre.indexKeysQcm', $indexSearch );
            $resSearchQcm = $this->db->get()->result_array();

            $this->db->select("_chapitre.* , _questiontype.* , _theme.* ,_livre.Titre ,CONCAT(SUBSTRING(name, 1, 10),'...',SUBSTRING(name, 40, 100)) AS nameQ ");
            $this->db->from('_questiontype');
            $this->db->join('_chapitre', '_chapitre.IDChapitre = _questiontype.IDChapitre');
            $this->db->join('_livre', '_livre.IDLivre = _chapitre.IDLivre');
            $this->db->join('_theme', '_theme.IDTheme = _livre.IDTheme');
            $this->db->join('_category', '_category.IDCategory= _theme.IDCategory');
            $this->db->Where('multi_lingue',$currLang);
            $this->db->Where('OperationType','QROC');
            $this->db->like('_chapitre.indexKeysQroc', $indexSearch );
            $resSearchQroc = $this->db->get()->result_array();

        }else{
            $indexSearch 	= '';
            $resSearchLiv 	= array();
            $resSearchCh 	= array();
            $resSearchCurs 	= array();
            $resSearchResum = array();
            $resSearchQcm 	= array();
            $resSearchQroc 	= array();
        }


        $arr['indexSearch'] 		= $indexSearch;
        $arr['resSearchLiv'] 		= $resSearchLiv;
        $arr['resSearchCh'] 		= $resSearchCh;
        $arr['resSearchCurs'] 		= $resSearchCurs;
        $arr['resSearchResum'] 		= $resSearchResum;
        $arr['resSearchQcm'] 		= $resSearchQcm;
        $arr['resSearchQroc'] 		= $resSearchQroc;
        $arr['page'] 				= 'searchIndex';
        $arr['listCat'] 			= $this->getListCategory();
//		$this->load->view('searchIndex',$arr);
        $this->load->view($this->getTypePlatform() ? 'v1_searchIndex' : 'searchIndex', $arr);
    }
    public function  searchIndexFull()
    {
        if(isset($_POST["indexSearch"])){
            $indexSearch 			= htmlentities($_POST["indexSearch"]);
            $currLang = str_replace('/','',$this->lang->line('siteLang')) ;
            //search in Livre
            $this->db->select(" * , SUBSTRING(Description, (POSITION('$indexSearch' IN Description)), 300) AS descr");
            $this->db->from(' _livre');
            $this->db->join('_theme', '_livre.IDTheme = _theme.IDTheme');
            $this->db->join('_category', '_category.IDCategory= _theme.IDCategory');
            $this->db->Where(" multi_lingue='$currLang' AND _livre.Titre like '%$indexSearch%' or _livre.Description LIKE '%$indexSearch%' ");
            $resSearchLiv = $this->db->get()->result_array();
//
            $this->db->select("*, SUBSTRING(TitreChapitre, (POSITION('$indexSearch' IN TitreChapitre)-100), 300) AS descr");
            $this->db->from(' _chapitre');
            $this->db->join('_livre', '_livre.IDLivre = _chapitre.IDLivre');
            $this->db->join('_theme', '_theme.IDTheme = _livre.IDTheme');
            $this->db->join('_category', '_category.IDCategory= _theme.IDCategory');
            $this->db->Where("multi_lingue='$currLang'  AND TitreChapitre like '%$indexSearch%' ");
            $resSearchCh = $this->db->get()->result_array();

            $this->db->select("_chapitre.*, _page.* , _theme.* ,_livre.Titre, SUBSTRING(_page.ContentFileCrypt, (POSITION('$indexSearch' IN _page.ContentFileCrypt)-100), 300) AS descr");
            $this->db->from('_page');
            $this->db->join('_cours', '_page.IDCours = _cours.IDCours');
            $this->db->join('_chapitre', '_chapitre.IDChapitre = _cours.IDChapitre');
            $this->db->join('_livre', '_livre.IDLivre = _chapitre.IDLivre');
            $this->db->join('_theme', '_theme.IDTheme = _livre.IDTheme');
            $this->db->join('_category', '_category.IDCategory= _theme.IDCategory');
            $this->db->Where("multi_lingue='$currLang'  AND _page.ContentFileCrypt like '%$indexSearch%' ");
            $resSearchCurs = $this->db->get()->result_array();

            $this->db->select("_chapitre.* , _page.* , _theme.* ,_livre.Titre,  SUBSTRING(_page.ContentFileCrypt, (POSITION('$indexSearch' IN _page.ContentFileCrypt)-100), 300) AS descr");
            $this->db->from('_page');
            $this->db->join('_resume', '_page.IDResume = _resume.IDResume');
            $this->db->join('_chapitre', '_chapitre.IDChapitre = _resume.IDChapitre');
            $this->db->join('_livre', '_livre.IDLivre = _chapitre.IDLivre');
            $this->db->join('_theme', '_theme.IDTheme = _livre.IDTheme');
            $this->db->join('_category', '_category.IDCategory= _theme.IDCategory');
            $this->db->Where("multi_lingue='$currLang'  AND _page.ContentFileCrypt like '%$indexSearch%' ");
            $resSearchResum = $this->db->get()->result_array();

            $this->db->select("_chapitre.* , _questiontype.* , _theme.* ,_livre.Titre ,CONCAT(SUBSTRING(name, 1, 10),'...',SUBSTRING(name, 40, 100),' ?') AS nameQ ");
            $this->db->from('_questiontype');
            $this->db->join('_chapitre', '_chapitre.IDChapitre = _questiontype.IDChapitre');
            $this->db->join('_livre', '_livre.IDLivre = _chapitre.IDLivre');
            $this->db->join('_theme', '_theme.IDTheme = _livre.IDTheme');
            $this->db->join('_category', '_category.IDCategory= _theme.IDCategory');
            $this->db->Where("multi_lingue='$currLang' AND OperationType = 'QCM'  AND (name like '%$indexSearch%') ");
            $resSearchQcm = $this->db->get()->result_array();

            $this->db->select("_chapitre.* , _questiontype.* , _theme.* ,_livre.Titre ,CONCAT(SUBSTRING(name, 1, 10),'...',SUBSTRING(name, 40, 100)) AS nameQ ");
            $this->db->from('_questiontype');
            $this->db->join('_chapitre', '_chapitre.IDChapitre = _questiontype.IDChapitre');
            $this->db->join('_livre', '_livre.IDLivre = _chapitre.IDLivre');
            $this->db->join('_theme', '_theme.IDTheme = _livre.IDTheme');
            $this->db->join('_category', '_category.IDCategory= _theme.IDCategory');
            $this->db->Where("multi_lingue='$currLang' AND OperationType = 'QROC'  AND (name like '%$indexSearch%') ");
            $resSearchQroc = $this->db->get()->result_array();

        }else{
            $indexSearch 	= '';
            $resSearchLiv 	= array();
            $resSearchCh 	= array();
            $resSearchCurs 	= array();
            $resSearchResum = array();
            $resSearchQcm 	= array();
            $resSearchQroc 	= array();
        }


        $arr['indexSearch'] 		= $indexSearch;
        $arr['resSearchLiv'] 		= $resSearchLiv;
        $arr['resSearchCh'] 		= $resSearchCh;
        $arr['resSearchCurs'] 		= $resSearchCurs;
        $arr['resSearchResum'] 		= $resSearchResum;
        $arr['resSearchQcm'] 		= $resSearchQcm;
        $arr['resSearchQroc'] 		= $resSearchQroc;
        $arr['page'] 				= 'searchIndex';
        $arr['listCat'] 			= $this->getListCategory();
        $this->load->view('searchIndex',$arr);
    }

    public function ajax_QuestionType_list_old()
    {


        $data = array();
        $d_arr = array();

        $d_arr[] = $_POST["typeQ"];
        $d_arr[] = $_POST["typeC"];

        $list = $this->QuestionType_model->get_datatables($d_arr);

        foreach ($list as $sort_row) {

            $row 	= array();
            $id 	= $sort_row->id;
            $name 	= $sort_row->name;
            $skill	= $sort_row->skill;
            $respo	= $sort_row->ResponseQuestion;

            $typeCh 	=  "";
            $typeResp 	=  "";
            if($sort_row->type =='text') {
                $typeCh ="	<textarea  name='setInf-$id' id='setInf-$id' class='form-control' rows='8' ></textarea>" ;
                $typeCh =$typeCh."	<input type='hidden' name='setID[]' id='setID[]' value='$id'  />" ;

                $typeResp ="	<textarea  name='getInf-$id' id='getInf-$id' class='form-control' rows='8' disabled >$respo</textarea>" ;
            }
            if($sort_row->type =='date') {
                $typeCh ="	<input type='date' name='setInf-$id' id='setInf-$id' class='form-control'  />" ;
                $typeCh =$typeCh."	<input type='hidden' name='setID[]' id='setID[]' value='$id'  />" ;

                $typeResp ="	<input type='date' name='getInf-$id' id='getInf-$id' class='form-control' value='$respo' disabled />" ;
            }
            if($sort_row->type =='time') {
                $typeCh ="	<input type='time' name='setInf-$id' id='setInf-$id' class='form-control'  />" ;
                $typeCh =$typeCh."	<input type='hidden' name='setID[]' id='setID[]' value='$id'  />" ;

                $typeResp ="	<input type='time' name='getInf-$id' id='getInf-$id' class='form-control' value='$respo' disabled  />" ;
            }
            if($sort_row->type =='datetime') {
                $typeCh ="	<input type='datetime-local' name='setInf-$id' id='setInf-$id' class='form-control'  />" ;
                $typeCh =$typeCh."	<input type='hidden' name='setID[]' id='setID[]' value='$id'  />" ;

                $typeResp ="	<input type='datetime-local' name='getInf-$id' id='getInf-$id' class='form-control' value='$respo' disabled  />" ;
            }
            if($sort_row->type =='checkbox') {

                $typeCh ="	<input type='hidden' name='setID[]' id='setID[]' value='$id'  />" ;
                $sel = explode("@||@", $skill);
                foreach ($sel as $va) {

                    $typeCh = $typeCh."<div> <label class='form-check'  style='text-align: left;'>" ;
                    $typeCh = $typeCh."	<input type='checkbox' name='setInf-$id' id='setInf-$id' value='$va' class='form-check-input'/>" ;
                    $typeCh = $typeCh."<span class='form-check-label'>$va</span></label>" ;
                    $typeCh = $typeCh."</div>" ;

                    $typeResp = $typeResp."<div> <label class='form-check'  style='text-align: left;'>" ;
                    $typeResp = $typeResp."	<input type='checkbox' name='getInf-$id' id='getInf-$id' value='$va' " ;

                    if(in_array($va,explode("@||@",$respo))) { $typeResp = $typeResp. "checked";}
                    $typeResp = $typeResp." class='form-check-input' disabled />" ;

                    $typeResp = $typeResp."<span class='form-check-label'>$va</span></label>" ;
                    $typeResp = $typeResp."</div>" ;
                }
            }
            if($sort_row->type =='select') {
                $typeCh ="	<select name='setInf-$id' id='setInf-$id' class='form-select'  />" ;
                $sel = explode("@||@", $skill);
                foreach ($sel as $va) {
                    $typeCh = $typeCh.	"<option value='$va'>$va </option>";
                }
                $typeCh = $typeCh."</select>";

                $typeResp ="	<select name='getInf-$id' id='getInf-$id' class='form-select'  disabled />" ;
                $sel = explode("@||@", $skill);
                foreach ($sel as $va) {
                    $ischek = "";
                    if($respo == $va) { $ischek =  " selected ";}
                    $typeResp = $typeResp.	"<option value='$va' $ischek >$va </option>";
                }
                $typeResp = $typeResp."</select>";

                $typeCh   = $typeCh."	<input type='hidden' name='setID[]' id='setID[]' value='$id'  />" ;
            }

            $blocStart 	= "<div class='col-sm-6 mb-3 mb-md-0' style='height: 400px;'><div class='card text-center h-100'><div class='card-body d-flex flex-column'>";
            $blocEnd 	= "</div>	</div>	</div>";
            $blocQ 		= "<div class='lead text-center mb-4' >".$name."</div>";
            $blocR 		= $blocStart."<div class='mb-4'><h3>Votre réponse</h3></div>".$typeCh."<div class='mt-auto'><a href='#' class='btn btn-lg btn-primary'>Voir solution</a></div>".$blocEnd;

            $blocC 		= $blocStart."<div class='mb-4'><h3>Solution</h3></div>".$typeResp.$blocEnd;
            //$blocC 		= $blocStart."<div class='mb-4'><h3>Solution</h3></div>".$blocEnd;

            $row[] 		= "<div class='row py-4'>".$blocQ.$blocR.$blocC."</div>";

            $data[] = $row;

        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" 		=> $this->QuestionType_model->count_filtered($d_arr),
            "recordsFiltered" 	=> $this->QuestionType_model->count_filtered($d_arr),
            "data" => $data,
        );

        echo json_encode($output);
    }

    public function getURLFig() {

        $this->db->select('*');
        $this->db->from('_params');
        $this->db->Where("Libelle_Params = 'VisibiliteCours' ");
        $resParams = $this->db->get()->result_array();

        $visibFig 	= 5;
        $scrlFig 	= 'yes';
        if($resParams[0]["Value_Params"] < 100){
            $visibFig = 100 - $resParams[0]["Value_Params"] ;
            $scrlFig = 'no';
        }
        $id_  = $_POST["ifFig"];
        $idFig  = $id_;//base64_encode($id_);

        $pat =  base_url().$this->lang->line('siteLang').'figHTML/'.$idFig ;
        //$htmlFig		=	 "<iframe name='iframename' id='iframeID' style='background-color: white;height: 46rem; width: 100%;'  src='$pat'  scrolling='yes'  ></iframe>";
        $htmlFig		=	 "<iframe name='iframename' id='iframeID' style='background-color: white; height: calc(85vh - ".$visibFig."vh); width: 100%;'  src='$pat'  scrolling='".$scrlFig."'  ></iframe>";

        $arr = array();
        $arr[] = array("id" => '1', "desc" => $htmlFig);
        echo json_encode($arr);
        exit;

    }

    public function getURLFig_old() {

        $idFig  = $_POST["ifFig"];
        $this->db->select('*');
        $this->db->from('_figure');
        $this->db->where("IDFigure ='".$idFig."'");

        $res = $this->db->get()->result_array();

        $arr = array();

        //SAVE DATA INTO stel_savclient
        if(sizeof($res) > 0) {

            $arr[] = array("id" => '1', "desc" => $res);
        }else{
            $arr[] = array("id" => '-1', "desc" => "Aucune figure trouvée");
        }
        echo json_encode($arr);
        exit;

    }

    public function setActifUser() {


        $idUS  = $_POST["idUS"];
        $arr 		= array();
        $this->db->select('*');
        $this->db->from('users');
        $this->db->Where("users_ID = '$idUS' ");

        $res = $this->db->get()->result_array();

        if(count($res) > 0){

            if($res[0]["Bloque"] == 0){


                $data = array(
                    'tokenPass' => '',
                    'Bloque' =>1
                );
            }else{
                $this->load->helper('string');
                $tokenPass = random_string('alnum', 200) ;
                $data = array(
                    'tokenPass' => $tokenPass,
                    'Bloque' => 0
                );

            }
            $log_id 	= $res[0]["users_ID"] ;
            $this->db->where("users_ID = '".$log_id."'");
            $this->db->update('users', $data);


            $arr[] = array("id" => '1', "desc" => '');
        }else{$arr[] = array("id" => '-1', "desc" => $this->lang->line('verif_log'));}
        echo json_encode($arr);
        exit;

    }
    public function setActifMenu() {

        $idUS  		= $_POST["idUS"];
        $arr 		= array();
        $this->db->select('*');
        $this->db->from('_category');
        $this->db->Where("IDCategory = '$idUS' ");

        $res = $this->db->get()->result_array();

        if(count($res) > 0){

            if($res[0]["EstActifMenu"] == 0){
                $data = array( 'EstActifMenu' =>1 );
            }else{
                $data = array( 'EstActifMenu' => 0 );
            }
            $log_id 	= $res[0]["IDCategory"] ;
            $this->db->where("IDCategory = '".$log_id."'");
            $this->db->update('_category', $data);


            $arr[] = array("id" => '1', "desc" => '');
        }else{$arr[] = array("id" => '-1', "desc" => $this->lang->line('verif_log'));}
        echo json_encode($arr);
        exit;

    }
    public function setActifAcc() {

        $idUS  		= $_POST["idUS"];
        $arr 		= array();
        $this->db->select('*');
        $this->db->from('_category');
        $this->db->Where("IDCategory = '$idUS' ");

        $res = $this->db->get()->result_array();

        if(count($res) > 0){

            if($res[0]["EstActifAccueil"] == 0){
                $data = array( 'EstActifAccueil' =>1 );
            }else{
                $data = array( 'EstActifAccueil' => 0 );
            }
            $log_id 	= $res[0]["IDCategory"] ;
            $this->db->where("IDCategory = '".$log_id."'");
            $this->db->update('_category', $data);


            $arr[] = array("id" => '1', "desc" => '');
        }else{$arr[] = array("id" => '-1', "desc" => $this->lang->line('verif_log'));}
        echo json_encode($arr);
        exit;

    }

    public function setActifAccGlobal() {

        $idUS  		= $_POST["idUS"];
        $champs  		= $_POST["champs"];
        $arr 		= array();
        $this->db->select('*');
        $this->db->from('_category');
        $this->db->Where("IDCategory = '$idUS' ");

        $res = $this->db->get()->result_array();

        if(count($res) > 0){

            if($res[0][$champs] == 0){
                $data = array( $champs =>1 );
            }else{
                $data = array( $champs => 0 );
            }
            $log_id 	= $res[0]["IDCategory"] ;
            $this->db->where("IDCategory = '".$log_id."'");
            $this->db->update('_category', $data);


            $arr[] = array("id" => '1', "desc" => '');
        }else{$arr[] = array("id" => '-1', "desc" => $this->lang->line('verif_log'));}
        echo json_encode($arr);
        exit;

    }

    public function setOrderCat() {

        $idUS  		= $_POST["idUS"];
        $numOrd  	= $_POST["numOrd"];
        $arr 		= array();
        $this->db->select('*');
        $this->db->from('_category');
        $this->db->Where("IDCategory = '$idUS' ");

        $res = $this->db->get()->result_array();

        if(count($res) > 0){
            $data 		= array( 'OrdreCat' => $numOrd);
            $log_id 	= $res[0]["IDCategory"] ;
            $this->db->where("IDCategory = '".$log_id."'");
            $this->db->update('_category', $data);

            $arr[] = array("id" => '1', "desc" => '');
        }else{$arr[] = array("id" => '-1', "desc" => $this->lang->line('verif_log'));}
        echo json_encode($arr);
        exit;

    }
    public function setUnLvire() {

        $idUS  		= $_POST["idUS"];
        $arr 		= array();
        $this->db->select('*');
        $this->db->from('_theme');
        $this->db->Where("IDTheme = '$idUS' ");

        $res = $this->db->get()->result_array();

        if(count($res) > 0){
            $data 		= array( 'EstUnLivre' => !$res[0]["EstUnLivre"]);
            $log_id 	= $res[0]["IDTheme"] ;
            $this->db->where("IDTheme",$log_id);
            $this->db->update('_theme', $data);
            //print_r($idUS);
            $arr[] = array("id" => '1', "desc" => '');
        }else{$arr[] = array("id" => '-1', "desc" => $this->lang->line('verif_log'));}
        echo json_encode($arr);
        exit;

    }

    public function getItem()

    {

        /*
                $this->db->query("TRUNCATE TABLE `item`;");

                $this->db->select('*');	$this->db->from('_category');$res = $this->db->get()->result_array();
                foreach ($res as $val) {
                    $res_liv = $this->listLivre($val['IDTheme']);
                    $data = array('name' => $val['Libelle'],'id' => $val['IDCategory'],'parent_id' => 0);
                    $this->insert_dd('item' , $data);
                }

        */

        $data = [];

        $parent_key = '0';

        $row = $this->db->query('SELECT id, name from item');



        if($row->num_rows() > 0)

        {
            $data = $this->membersTree($parent_key);
        }else{
            $data=["id"=>"0","name"=>"No Members presnt in list","text"=>"No Members is presnt in list","nodes"=>[]];
        }



        echo json_encode(array_values($data));

    }

    public function membersTree($parent_key)

    {

        $row1 = [];

        $row = $this->db->query('SELECT id, name from item WHERE parent_id="'.$parent_key.'"')->result_array();

        foreach($row as $key => $value)

        {

            $id = $value['id'];

            $row1[$key]['id'] = $value['id'];

            $row1[$key]['name'] = $value['name'];

            $row1[$key]['text'] = $value['name'];

            $row1[$key]['nodes'] = array_values($this->membersTree($value['id']));

        }



        return $row1;

    }

    public function set_ChapCatItem(){

        $newTitre 			= $_POST["titreItem"];
        $OrdreCat 			= $_POST["inputOrdreCat"];
        $EstActifMenu 		= false;
        $EstActifAccueil 	= false;


        if (isset($_POST['EstActifMenu'])) {
            $EstActifMenu 	= true;
        }
        if (isset($_POST['EstActifAccueil'])) {
            $EstActifAccueil = true;
        }
        $err_desc = '' ;
        if($newTitre !=''){
            $langSit = $this->session->userdata('site_lang') ;
            $this->db->select('*');
            $this->db->from('_category');
            $this->db->Where("Libelle",$newTitre);
            $this->db->Where("multi_lingue",$langSit);
            $resC = $this->db->get()->result_array();
            if(count($resC) == 0){
                $dataCat = array(
                    'Libelle' 			=> $newTitre,
                    'OrdreCat' 			=> $OrdreCat,
                    'EstActifMenu' 		=> $EstActifMenu,
                    'EstActifAccueil' 	=> $EstActifAccueil,
                    'multi_lingue' 		=> $langSit
                );
                $idCat = $this->insert_dd('_category', $dataCat);

                $dataTheme = array(
                    'LibelleTheme' 		=> $newTitre,
                    'EstActif' 			=> true,
                    'OrderTheme' 		=> $OrdreCat , // Same As OrderCategory,
                    'IDCategory' 		=> $idCat
                );
                $idItem = $this->insert_dd('_theme', $dataTheme);

                $arr_Res[] = array("id" => '1', "desc" => $err_desc) ;
            }else{$arr_Res[] = array("id" => '-1', "desc" => 'Existe Title') ;}

        }else{
            $arr_Res[] = array("id" => '-1', "desc" => "Empty Title ") ;
        }

        echo json_encode($arr_Res);
        exit;
    }

    public function set_LivItem(){

        //$IDTheme 			= $_POST["itemID"];
        $OrdreCat 			= $_POST["list"];
        //print_r($OrdreCat);
        $desc = '' ;//$newTitre;

        foreach ($OrdreCat as $key=>$val){
            $idTheme = $key ;
            foreach ($val as $titleBook){
                if(trim($titleBook) != ''){
//					print_r($titleBook);
//					print_r('<br>');
                    $this->db->select('*');
                    $this->db->from('_livre');
                    $this->db->Where("Titre",$titleBook);
                    $this->db->Where("IDTheme",$idTheme);
                    $resC = $this->db->get()->result_array();
                    if(count($resC) == 0) {
                        $dataLiv = array(
                            'Titre' => $titleBook,
                            'IDTheme' => $idTheme
                        );
                        $idLiv = $this->insert_dd('_livre', $dataLiv);

                    }
                }
            }

        }
        $arr_Res[] = array("id" => '1', "desc" => $desc) ;


        echo json_encode($arr_Res);
        exit;
    }

    public function set_LivChap(){

        $IDLivr 			= $_POST["bookID"];
        $OrdreChap 			= $_POST["list"];
        //print_r($OrdreCat);
        $desc = '' ;//$newTitre;

        foreach ($OrdreChap as $key=>$titleChap){
            if(trim($titleChap) != ''){

//					print_r($titleBook);
//					print_r('<br>');
                $this->db->select('*');
                $this->db->from('_chapitre');
                $this->db->Where('TitreChapitre',$titleChap);
                $this->db->Where('IDLivre',$IDLivr);
                $resC = $this->db->get()->result_array();
                if(count($resC) == 0) {
                    $dataChap = array(
                        'TitreChapitre' 	=> $titleChap,
                        'IDLivre' 			=> $IDLivr
                    );
                    $idChap = $this->insert_dd('_chapitre', $dataChap);
                }
            }
        }
        $arr_Res[] = array("id" => '1', "desc" => $desc) ;

        echo json_encode($arr_Res);
        exit;
    }

    public function set_LivreBack(){

        $idLiv 		= $_POST["idLivre"];
        $newTitre 	= $_POST["titreLivre"];
        $err_desc = '';

        if($idLiv > 0 && $newTitre !=''){

            $data_l 			= array('Titre' => $newTitre);
            $this->db->where("IDLivre = '".$idLiv."'");
            $this->db->update('_livre', $data_l);

            $arr_Res[] = array("id" => '1', "desc" => $err_desc) ;
        }else{
            $arr_Res[] = array("id" => '-1', "desc" => "Empty Title ") ;
        }

        echo json_encode($arr_Res);
        exit;
    }

    public function upload_Attach_Save(){

        //$send_ID = "'".$_POST["attach_file"]."'";
        $f               	= $_FILES;
        $listIDlivres 		= $_POST["attach_file"];
        $nb_f	=	sizeof($f);
        //$bin_data_target    = base64_encode(file_get_contents( $f["mFile"]["tmp_name"] ));
        $err_desc = '';
//print_r("--------------------------");print_r($f);
//print_r("--------------------------");print_r($nb_f);
//		$arr_Res[] = array("id" => '-1', "desc" => $f) ;
//
//
//echo json_encode($arr_Res);
//exit;
        foreach($f["mFile"]["name"] as $key=>$p) {

            $file_size  =  $f["mFile"]["size"][$key];
            $file_type  =  $f["mFile"]["type"][$key];
            $file_name  =  $f["mFile"]["name"][$key];
            $file_nameTmp  =  $f["mFile"]["tmp_name"][$key];
            //print_r($file_size);
            if($file_size > 0){

                $dataCouv = 'Couv_'.$listIDlivres[$key]."_".$file_name;//$_FILES['image']['name'];
                $config['image_library'] = 'gd2';
                $config['source_image'] = $file_nameTmp;//$_FILES['image']['tmp_name'];
                $config['create_thumb'] = FALSE;
                $config['maintain_ratio'] = FALSE;
                $config['quality'] = '100%' ;
                $config['master_dim'] = 'auto' ;
                $config['width'] = 354;
                $config['height'] = 457;
                $config['new_image'] = FCPATH.'PlatFormeConvert/'.$dataCouv;//'asstes/thumb/' . $data;
                $this->load->library('image_lib', $config);
                $this->image_lib->resize();

                $pathCouv = FCPATH.'PlatFormeConvert/'.$dataCouv ;
                //$bin_data_target    = base64_encode(file_get_contents( $f["mFile"]["tmp_name"][$key] ));
                $bin_data_target    = base64_encode(file_get_contents( $pathCouv));
                $data_l 			= array('encryptCouverture' => $bin_data_target);
                $this->db->where("IDLivre = '".$listIDlivres[$key]."'");
                $this->db->update('_livre', $data_l);

                unlink($pathCouv);

                //$err_desc = $err_desc.' ********** '.$listIDlivres[$key].'<br>';

            }
        }

        $arr_Res[] = array("id" => '1', "desc" => $err_desc) ;
        echo json_encode($arr_Res);
        exit;
    }

    public function upload_Attach_Save_Couverture_Video(){

        //$send_ID = "'".$_POST["attach_file"]."'";
        $f               	= $_FILES;
        $listIDlivres 		= $_POST["attach_file"];
        $nb_f	=	sizeof($f);
        //$bin_data_target    = base64_encode(file_get_contents( $f["mFile"]["tmp_name"] ));
        $err_desc = '';
//print_r("--------------------------");print_r($f);
//print_r("--------------------------");print_r($nb_f);
//		$arr_Res[] = array("id" => '-1', "desc" => $f) ;
//
//
//echo json_encode($arr_Res);
//exit;
        foreach($f["vFile"]["name"] as $key=>$p) {

            $file_size  =  $f["vFile"]["size"][$key];
            $file_type  =  $f["vFile"]["type"][$key];
            $file_name  =  $f["vFile"]["name"][$key];
            $file_nameTmp  =  $f["vFile"]["tmp_name"][$key];
            //print_r($file_size);
            if($file_size > 0){

                $dataCouv = 'Couv_'.$listIDlivres[$key]."_".$file_name;//$_FILES['image']['name'];
                $config['image_library'] = 'gd2';
                $config['source_image'] = $file_nameTmp;//$_FILES['image']['tmp_name'];
                $config['create_thumb'] = FALSE;
                $config['maintain_ratio'] = FALSE;
                $config['quality'] = '100%' ;
                $config['master_dim'] = 'auto' ;
                $config['width'] = 354;
                $config['height'] = 457;
                $config['new_image'] = FCPATH.'PlatFormeConvert/'.$dataCouv;//'asstes/thumb/' . $data;
                $this->load->library('image_lib', $config);
                $this->image_lib->resize();

                $pathCouv = FCPATH.'PlatFormeConvert/'.$dataCouv ;
                //$bin_data_target    = base64_encode(file_get_contents( $f["mFile"]["tmp_name"][$key] ));
                $bin_data_target    = base64_encode(file_get_contents( $pathCouv));
                $data_l 			= array('encryptCouvertureVideo' => $bin_data_target);
                $this->db->where("IDLivre = '".$listIDlivres[$key]."'");
                $this->db->update('_livre', $data_l);

                unlink($pathCouv);

                //$err_desc = $err_desc.' ********** '.$listIDlivres[$key].'<br>';

            }
        }

        $arr_Res[] = array("id" => '1', "desc" => $err_desc) ;
        echo json_encode($arr_Res);
        exit;
    }

    public function upload_Attach_Save_Desc(){

        //$send_ID = "'".$_POST["attach_file"]."'";
        $f               	= $_FILES;
        $listIDlivres 		= $_POST["attach_file"];
        $nb_f	=	sizeof($f);
        //$bin_data_target    = base64_encode(file_get_contents( $f["mFile"]["tmp_name"] ));
        $err_desc = '';

        foreach($f["mFile"]["name"] as $key=>$p) {

            $file_size  =  $f["mFile"]["size"][$key];
            $file_type  =  $f["mFile"]["type"][$key];
            $file_name  =  $f["mFile"]["name"][$key];
            $file_nameTmp  =  $f["mFile"]["tmp_name"][$key];
            //print_r($file_size);
            if($file_size > 0){

                ///////$bin_data_target    = base64_encode(file_get_contents( $f["mFile"]["tmp_name"][$key] ));

                //$content = file_get_contents( $f["mFile"]["tmp_name"][$key] ,true);
                //$content = utf8_encode ( $content );
                //$content = iconv( "UTF-8", "UTF-8//TRANSLIT", $content );
                //$content = mb_convert_encoding($content, 'HTML-ENTITIES', "UTF-8");
                //$descD 	= $this->convertDocHTML($f["mFile"]["tmp_name"][$key],'','',0);//

                $fileDocx = $f["mFile"]["tmp_name"][$key] ;

                require_once APPPATH."/third_party/wordToPh/vendor/autoload.php";
                //$this->load->library('MyWorldDoc');

                $objReader= \PhpOffice\PhpWord\IOFactory::createReader('Word2007');
                $contents=$objReader->load($fileDocx);


                $rendername= \PhpOffice\PhpWord\Settings::PDF_RENDERER_TCPDF;

                $renderLibrary="tcpdf";
                $renderLibraryPath=APPPATH."/third_party/wordToPh/".$renderLibrary;
                if(!\PhpOffice\PhpWord\Settings::setPdfRenderer($rendername,$renderLibraryPath)){
                    die("Provide Render Library And Path");
                }

                $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($contents, 'HTML');
                $objWriter->save(FCPATH.'PlatFormeConvert/'.$listIDlivres[$key]."_Desc.HTML");

                $content = file_get_contents(FCPATH.'PlatFormeConvert/'.$listIDlivres[$key]."_Desc.HTML",true);
                //$content = utf8_encode ( $content );
                //$content = iconv( "UTF-8", "UTF-8//TRANSLIT", $content );
                //$content = mb_convert_encoding($content, 'HTML-ENTITIES', "UTF-8");

                $data_l  = array('Description' => $content);
                $this->db->where("IDLivre = '".$listIDlivres[$key]."'");
                $this->db->update('_livre', $data_l);

                unlink(FCPATH.'PlatFormeConvert/'.$listIDlivres[$key]."_Desc.HTML");

                ///
                //$err_desc = $err_desc.' ********** '.$content.'<br>';

            }
        }



        $arr_Res[] = array("id" => '1', "desc" => $err_desc) ;
        echo json_encode($arr_Res);
        exit;
    }

    public function upload_Attach_Save_Vid(){

        $idLiv 		= $_POST["attach_file"];
        $newVid 	= $_POST["newVid"];
        $err_desc = '';

        if($idLiv > 0 && $newVid !=''){

            $Url = 'https://www.youtube.com/embed/'.$newVid ;
            $data = array(
                'Titre' 		=> '',
                'URL' 			=> $Url,
                'TypeMedia' 	=> 'VIDEO',
                'IDLivre' 		=> $idLiv
            );
            $this->insert_dd('_publicite',$data);
            $arr_Res[] = array("id" => '1', "desc" => $err_desc) ;
        }else{
            $arr_Res[] = array("id" => '-1', "desc" => "Echec lors de l'insertion de l'URL : ".$Url) ;
        }


        echo json_encode($arr_Res);
        exit;
    }

    public function upload_Attach_Save_Fig_old(){

        $f               	= $_FILES;
        $listIDlivres 		= $_POST["attach_file"];
        $nb_f				= sizeof($f);
        $err_desc 			= '';

        foreach($listIDlivres as $key=>$p) {
            $idCh 	= $listIDlivres[$key] ;
            $nbFig = $f[$idCh."_mFileFig"]["size"][0] ;
            if($nbFig>0){
                $idCurs = 0 ;
                $this->db->select('*');
                $this->db->from('_cours');
                $this->db->Where("IDChapitre = '$idCh' ");
                $res = $this->db->get()->result_array();
                if(count($res) > 0){
                    $idCurs = $res[0]["IDCours"] ;
                    //$this->db->query("delete FROM `_figure` WHERE IDCours = '$idCurs' ;");
                }else{
                    $data = array(
                        'TitreCours' 	=> '',
                        'UrlCours' 		=> '',
                        'Tags' 			=> '',
                        'IDChapitre' 	=> $idCh
                    );
                    $idCurs= $this->insert_dd('_cours',$data);

                    $data_Chap = array('NbreCours' 	=> '1' );
                    $this->db->where('IDChapitre', $idCh);
                    $this->db->update('_chapitre', $data_Chap);
                }
                $listNewFig = '';
                foreach($f[$idCh."_mFileFig"]["name"] as $key_3=>$p_3) {
                    //print_r($idCh.' : '.$f[$idCh."_mFileFig"]["name"][$key_3]);
                    //print_r('<br>');
                    $file_size  	=  $f[$idCh."_mFileFig"]["size"][$key_3];
                    $file_type  	=  $f[$idCh."_mFileFig"]["type"][$key_3];
                    $file_name  	=  $f[$idCh."_mFileFig"]["name"][$key_3];
                    $file_nameTmp  	=  $f[$idCh."_mFileFig"]["tmp_name"][$key_3];

                    if($file_size > 0){

                        $dataCouv = 'Couv_'.$idCh."_".$file_name;//$_FILES['image']['name'];
                        $config['image_library'] 	= 'gd2';
                        $config['source_image'] 	= $file_nameTmp;//$_FILES['image']['tmp_name'];
                        $config['create_thumb'] 	= FALSE;
                        $config['maintain_ratio'] 	= FALSE;
                        $config['quality'] 			= '100%' ;
                        $config['master_dim'] 		= 'auto' ;
                        //$config['width'] 			= 500;//1900;
                        //$config['height'] 			= 1000;//3100;
                        $config['new_image'] 		= FCPATH.'PlatFormeConvert/'.$dataCouv;//'asstes/thumb/' . $data;
                        $this->load->library('image_lib', $config);
                        $this->image_lib->clear();
                        $this->image_lib->initialize($config);
                        $this->image_lib->resize();

                        $pathCouv 			= FCPATH.'PlatFormeConvert/'.$dataCouv ;
                        $bin_data_target    = base64_encode(file_get_contents( $pathCouv));

                        $data = array(
                            'TitreFigure' 	=> $file_name,
                            'UrlFigure' 	=> '',
                            'IDCours' 		=> $idCurs ,
                            'encryptFigure'	=> $bin_data_target
                        );
                        $idFig = $this->insert_dd('_figure', $data);
                        $listNewFig = $listNewFig.','.$idFig;
                        unlink($pathCouv);
                    }
                }
                if($idCurs > 0 && $listNewFig!=''){
                    $listNewFig = ','.$listNewFig;
                    $listNewFig = str_replace(",,","",$listNewFig);
                    $listNewFig = '('.$listNewFig.')';
                    $this->db->query("delete FROM `_figure` WHERE IDCours = '$idCurs' AND IDFigure NOT IN ".$listNewFig);
                }
            }

        }

        $arr_Res[] = array("id" => '1', "desc" => $err_desc) ;
        echo json_encode($arr_Res);
        exit;

    }
    public function upload_Attach_Save_Fig(){

        $f               	= $_FILES;
        $listIDlivres 		= $_POST["attach_file"];
        $nb_f				= sizeof($f);
        $err_desc 			= '';

        foreach($listIDlivres as $key=>$p) {
            $idCh 	= $listIDlivres[$key] ;
            $nbFig = $f[$idCh."_mFileFig"]["size"][0] ;
            if($nbFig>0){
                $idCurs = 0 ;
                $this->db->select('*');
                $this->db->from('_cours');
                $this->db->Where("IDChapitre = '$idCh' ");
                $res = $this->db->get()->result_array();
                if(count($res) > 0){
                    $idCurs = $res[0]["IDCours"] ;
                    //$this->db->query("delete FROM `_figure` WHERE IDCours = '$idCurs' ;");
                }else{
                    $data = array(
                        'TitreCours' 	=> '',
                        'UrlCours' 		=> '',
                        'Tags' 			=> '',
                        'IDChapitre' 	=> $idCh
                    );
                    $idCurs= $this->insert_dd('_cours',$data);

                    $data_Chap = array('NbreCours' 	=> '1' );
                    $this->db->where('IDChapitre', $idCh);
                    $this->db->update('_chapitre', $data_Chap);
                }
                $listNewFig = '';
                foreach($f[$idCh."_mFileFig"]["name"] as $key_3=>$p_3) {
                    //print_r($idCh.' : '.$f[$idCh."_mFileFig"]["name"][$key_3]);
                    //print_r('<br>');
                    $file_size  	=  $f[$idCh."_mFileFig"]["size"][$key_3];
                    $file_type  	=  $f[$idCh."_mFileFig"]["type"][$key_3];
                    $file_name  	=  $f[$idCh."_mFileFig"]["name"][$key_3];
                    $file_nameTmp  	=  $f[$idCh."_mFileFig"]["tmp_name"][$key_3];

                    if($file_size > 0){

                        $dataCouv = 'Couv_'.$idCh."_".$file_name;//$_FILES['image']['name'];
                        $config['image_library'] 	= 'gd2';
                        $config['source_image'] 	= $file_nameTmp;//$_FILES['image']['tmp_name'];
                        $config['create_thumb'] 	= FALSE;
                        $config['maintain_ratio'] 	= FALSE;
                        $config['quality'] 			= '100%' ;
                        $config['master_dim'] 		= 'auto' ;
                        //$config['width'] 			= 500;//1900;
                        //$config['height'] 			= 1000;//3100;
                        $config['new_image'] 		= FCPATH.'PlatFormeConvert/'.$dataCouv;//'asstes/thumb/' . $data;
                        $this->load->library('image_lib', $config);
                        $this->image_lib->clear();
                        $this->image_lib->initialize($config);
                        $this->image_lib->resize();

                        $pathCouv 			= FCPATH.'PlatFormeConvert/'.$dataCouv ;
                        $bin_data_target    = base64_encode(file_get_contents( $pathCouv));

                        $data_l = array(
                            'TitreFigure' 	=> $file_name,
                            'UrlFigure' 	=> '',
                            'IDCours' 		=> $idCurs ,
                            'encryptFigure'	=> $bin_data_target
                        );

                        $this->db->select('IDFigure , TitreFigure , IDCours');
                        $this->db->from('_figure');
                        $this->db->Where("TitreFigure",$file_name);
                        $this->db->Where("IDCours",$idCurs);
                        $resF = $this->db->get()->result_array();
                        if(count($resF)>0) {
                            $this->db->where("IDFigure",$resF[0]["IDFigure"]);
                            $this->db->update('_figure', $data_l);
                        }else{
                            $idFig = $this->insert_dd('_figure', $data_l);
                            $listNewFig = $listNewFig.','.$idFig;
                        }
                        unlink($pathCouv);
                    }
                }
                /*
                if($idCurs > 0 && $listNewFig!=''){
                    $listNewFig = ','.$listNewFig;
                    $listNewFig = str_replace(",,","",$listNewFig);
                    $listNewFig = '('.$listNewFig.')';
                    $this->db->query("delete FROM `_figure` WHERE IDCours = '$idCurs' AND IDFigure NOT IN ".$listNewFig);
                }
                */
            }

        }

        $arr_Res[] = array("id" => '1', "desc" => $err_desc) ;
        echo json_encode($arr_Res);
        exit;

    }

    public function upload_Attach_Save_FigResum_old(){

        $f               	= $_FILES;
        $listIDlivres 		= $_POST["attach_fileFigResum"];
        $nb_f				= sizeof($f);
        $err_desc 			= '';

        foreach($listIDlivres as $key=>$p) {

            $idCh 	= $listIDlivres[$key] ;
            $nbFig = $f[$idCh."_mFileFigResum"]["size"][0] ;
            if($nbFig>0){
                $idCurs = 0 ;
                $this->db->select('*');
                $this->db->from('_resume');
                $this->db->Where("IDChapitre = '$idCh' ");
                $res = $this->db->get()->result_array();
                if(count($res) > 0){
                    $idCurs = $res[0]["IDResume"] ;
                    //$this->db->query("delete FROM `_figure` WHERE IDCours = '$idCurs' ;");
                }else{
                    $data = array(
                        'TitreResume' 	=> '',
                        'UrlResume' 	=> '',
                        'Tags' 			=> '',
                        'IDChapitre' 	=> $idCh
                    );
                    $idCurs= $this->insert_dd('_resume',$data);

                    $data_Chap = array('NbreResume' 	=> '1' );
                    $this->db->where('IDChapitre', $idCh);
                    $this->db->update('_chapitre', $data_Chap);
                }
                $listNewFig = '';
                foreach($f[$idCh."_mFileFigResum"]["name"] as $key_3=>$p_3) {
                    //print_r($idCh.' : '.$f[$idCh."_mFileFig"]["name"][$key_3]);
                    //print_r('<br>');
                    $file_size  	=  $f[$idCh."_mFileFigResum"]["size"][$key_3];
                    $file_type  	=  $f[$idCh."_mFileFigResum"]["type"][$key_3];
                    $file_name  	=  $f[$idCh."_mFileFigResum"]["name"][$key_3];
                    $file_nameTmp  	=  $f[$idCh."_mFileFigResum"]["tmp_name"][$key_3];

                    if($file_size > 0){

                        $dataCouv = 'CouvR_'.$idCh."_".$file_name;//$_FILES['image']['name'];
                        $config['image_library'] 	= 'gd2';
                        $config['source_image'] 	= $file_nameTmp;//$_FILES['image']['tmp_name'];
                        $config['create_thumb'] 	= FALSE;
                        $config['maintain_ratio'] 	= FALSE;
                        $config['quality'] 			= '100%' ;
                        $config['master_dim'] 		= 'auto' ;
                        //$config['width'] 			= 500;//1900;
                        //$config['height'] 			= 1000;//3100;
                        $config['new_image'] 		= FCPATH.'PlatFormeConvert/'.$dataCouv;//'asstes/thumb/' . $data;
                        $this->load->library('image_lib', $config);
                        $this->image_lib->clear();
                        $this->image_lib->initialize($config);
                        $this->image_lib->resize();

                        $pathCouv 			= FCPATH.'PlatFormeConvert/'.$dataCouv ;
                        $bin_data_target    = base64_encode(file_get_contents( $pathCouv));

                        $data = array(
                            'TitreFigure' 	=> $file_name,
                            'UrlFigure' 	=> '',
                            'IDResume' 		=> $idCurs ,
                            'encryptFigure'	=> $bin_data_target
                        );
                        $idFig = $this->insert_dd('_figure', $data);
                        $listNewFig = $listNewFig.','.$idFig;
                        unlink($pathCouv);
                    }
                }
                if($idCurs > 0 && $listNewFig!=''){
                    $listNewFig = ','.$listNewFig;
                    $listNewFig = str_replace(",,","",$listNewFig);
                    $listNewFig = '('.$listNewFig.')';
                    $this->db->query("delete FROM `_figure` WHERE IDResume = '$idCurs' AND IDFigure NOT IN ".$listNewFig);
                }
            }



        }

        $arr_Res[] = array("id" => '1', "desc" => $err_desc) ;
        echo json_encode($arr_Res);
        exit;

    }
    public function upload_Attach_Save_FigResum(){

        $f               	= $_FILES;
        $listIDlivres 		= $_POST["attach_fileFigResum"];
        $nb_f				= sizeof($f);
        $err_desc 			= '';

        foreach($listIDlivres as $key=>$p) {

            $idCh 	= $listIDlivres[$key] ;
            $nbFig = $f[$idCh."_mFileFigResum"]["size"][0] ;
            if($nbFig>0){
                $idRsm = 0 ;
                $this->db->select('*');
                $this->db->from('_resume');
                $this->db->Where("IDChapitre = '$idCh' ");
                $res = $this->db->get()->result_array();
                if(count($res) > 0){
                    $idRsm = $res[0]["IDResume"] ;
                    //$this->db->query("delete FROM `_figure` WHERE IDResume = '$idRsm' ;");
                }else{
                    $data = array(
                        'TitreResume' 	=> '',
                        'UrlResume' 	=> '',
                        'Tags' 			=> '',
                        'IDChapitre' 	=> $idCh
                    );
                    $idRsm= $this->insert_dd('_resume',$data);

                    $data_Chap = array('NbreResume' 	=> '1' );
                    $this->db->where('IDChapitre', $idCh);
                    $this->db->update('_chapitre', $data_Chap);
                }
                $listNewFig = '';
                foreach($f[$idCh."_mFileFigResum"]["name"] as $key_3=>$p_3) {
                    //print_r($idCh.' : '.$f[$idCh."_mFileFig"]["name"][$key_3]);
                    //print_r('<br>');
                    $file_size  	=  $f[$idCh."_mFileFigResum"]["size"][$key_3];
                    $file_type  	=  $f[$idCh."_mFileFigResum"]["type"][$key_3];
                    $file_name  	=  $f[$idCh."_mFileFigResum"]["name"][$key_3];
                    $file_nameTmp  	=  $f[$idCh."_mFileFigResum"]["tmp_name"][$key_3];

                    if($file_size > 0){

                        $dataCouv = 'CouvR_'.$idCh."_".$file_name;//$_FILES['image']['name'];
                        $config['image_library'] 	= 'gd2';
                        $config['source_image'] 	= $file_nameTmp;//$_FILES['image']['tmp_name'];
                        $config['create_thumb'] 	= FALSE;
                        $config['maintain_ratio'] 	= FALSE;
                        $config['quality'] 			= '100%' ;
                        $config['master_dim'] 		= 'auto' ;
                        //$config['width'] 			= 500;//1900;
                        //$config['height'] 			= 1000;//3100;
                        $config['new_image'] 		= FCPATH.'PlatFormeConvert/'.$dataCouv;//'asstes/thumb/' . $data;
                        $this->load->library('image_lib', $config);
                        $this->image_lib->clear();
                        $this->image_lib->initialize($config);
                        $this->image_lib->resize();

                        $pathCouv 			= FCPATH.'PlatFormeConvert/'.$dataCouv ;
                        $bin_data_target    = base64_encode(file_get_contents( $pathCouv));

                        $data_l = array(
                            'TitreFigure' 	=> $file_name,
                            'UrlFigure' 	=> '',
                            'IDResume' 		=> $idRsm ,
                            'encryptFigure'	=> $bin_data_target
                        );

                        $this->db->select('IDFigure , TitreFigure , IDResume');
                        $this->db->from('_figure');
                        $this->db->Where("TitreFigure",$file_name);
                        $this->db->Where("IDResume",$idRsm);
                        $resF = $this->db->get()->result_array();
                        if(count($resF)>0) {
                            $this->db->where("IDFigure",$resF[0]["IDFigure"]);
                            $this->db->update('_figure', $data_l);
                        }else{
                            $idFig = $this->insert_dd('_figure', $data_l);
                            $listNewFig = $listNewFig.','.$idFig;
                        }
                        unlink($pathCouv);
                    }
                }
                /*
                if($idRsm > 0 && $listNewFig!=''){
                    $listNewFig = ','.$listNewFig;
                    $listNewFig = str_replace(",,","",$listNewFig);
                    $listNewFig = '('.$listNewFig.')';
                    $this->db->query("delete FROM `_figure` WHERE IDResume = '$idRsm' AND IDFigure NOT IN ".$listNewFig);
                }
                */
            }

        }

        $arr_Res[] = array("id" => '1', "desc" => $err_desc) ;
        echo json_encode($arr_Res);
        exit;

    }

    public function upload_Attach_Save_QCM(){

        //$send_ID = "'".$_POST["attach_file"]."'";
        $f               	= $_FILES;
        $idChapList 		= $_POST["attach_file"];
        $nb_f	=	sizeof($f);
        //$bin_data_target    = base64_encode(file_get_contents( $f["mFile"]["tmp_name"] ));
        $err_desc = '';

        foreach($f["mFileQCM"]["name"] as $key=>$p) {

            $file_size  	=  $f["mFileQCM"]["size"][$key];
            $file_type  	=  $f["mFileQCM"]["type"][$key];
            $file_name  	=  $f["mFileQCM"]["name"][$key];
            $file_nameTmp  	=  $f["mFileQCM"]["tmp_name"][$key];
            $idChap			= $idChapList[$key];
            //print_r($file_size);
            if($file_size > 0){

                $fileDocx 	= $f["mFileQCM"]["tmp_name"][$key] ;

                $list 		= $this->read_docx($fileDocx);
                //print_r($list);
                //print_r('<br>');
                $bdd_dataQ 	= array();$bdd_dataR = '';$is_q = true;
                $is_r 		= false;
                $numQ 		= 1 ;$TitreQroc = '';
                $content 	= str_replace('</w:r></w:p></w:tc><w:tc>', '<br>', $list);
                $content 	= str_replace('</w:r></w:p>', "\r\n", $content);

                $lign = implode("\r\n", $content);
                $lign = strip_tags($lign);

                $numBeg 		= 1;$numEnd = 2;$quitQuest = false;
                $is_quest 		= $this->getString("@@@@",$numBeg."-","@@@@".$lign);
                $TitreQcm		= str_replace("@@@@", "", $is_quest);
                $listTitreQcm 	= explode("\r\n",$TitreQcm);
                if(sizeof($listTitreQcm)>2){$TitreQcm = $listTitreQcm[2];}

                //print_r($listTitreQcm);
                //print_r('**************************'.$TitreQcm.'----------------------------');
                //print_r('**************************'.$is_quest.'----------------------------');
                $is_quest 	= $this->getString($numBeg."-",$numEnd."-",$lign);
                while($is_quest != '' && $quitQuest==false){
                    $is_quest = $this->getString($numBeg."-",$numEnd."-",$lign);
                    if($is_quest==''){
                        $is_quest 	= $this->getString($numBeg."-","@@@@",$lign."@@@@");
                        $quitQuest 	= true ;
                    }

                    //print_r('**************************'.$is_quest.'----------------------------<br>');
                    //print_r('**************************'.$this->getString($numBeg."-","A-",$is_quest).'----------------------------<br>');
                    //print_r('**************************'.strstr($is_quest,'Réponse').'----------------------------');
                    //$quest 	= $this->getString($numBeg."-","Réponse",$is_quest);Proposition : 1

                    $quest 			= $this->getString($numBeg."-",":",(string)$is_quest); // question
                    $repons_Key		= $this->getString(":","A-",(string)$is_quest); // reponse A;C;E
                    $proposQcm   	= $this->getString("A-","@@@@",(string)$is_quest."@@@@"); // propositions
                    //print_r('**************************'.$proposition2.'----------------------------<br>');
                    // BEGIN ici on traite les reponses !!!!!

                    //print_r('**************************');

                    //$lign_ = strip_tags($lign_);
                    //print_r(strip_tags($proposQcm,'<br>'));
                    $listPropos = explode("\r\n",$proposQcm) ;

                    $lign_Resp 			= str_replace(" ","-",(string)$repons_Key);
                    $lign_Resp 			= str_replace(";","-",(string)$lign_Resp);
                    $lign_Resp 			= str_replace(":","-",(string)$lign_Resp);
                    $lign_Resp 			= "-".$lign_Resp."-";

                    $lign_Props 		= '';
                    $lign_Rep			= '';
                    foreach ($listPropos as $num => $itemProp) {

                        $lign_Props 	= $lign_Props."@||@" .$itemProp ;

                        $startPosssss 	= "-".substr($itemProp, 0, 1);
                        if (strpos(strtoupper($lign_Resp),strtoupper($startPosssss))!==false) {
                            $lign_Rep 	= $lign_Rep."@||@" .$itemProp ;
                        }
                    }
                    $lign_Props 		= "@@@@".$lign_Props."@@@@";
                    $lign_Props   		= str_replace("@@@@@||@","",$lign_Props);
                    $lign_Props   		= str_replace("@||@@@@@","",$lign_Props);
                    //print_r($lign_Resp);


                    //print_r('----------------------------<br>');

                    // END reponses

                    $numBeg++;$numEnd++;

                    $bdd_dataQ[] = array("id" => $numBeg, "quest" => $quest , "proposQcm"=>$lign_Props , "resp"=>$lign_Rep , "repons_Key" => $repons_Key );
                }

                $this->db->query("delete FROM `_questiontype` WHERE OperationType ='QCM' AND IDChapitre = '$idChap' ;");
                foreach ($bdd_dataQ as $onQ)
                {

                    $data_QR = array(
                        'name' 				=> $onQ["quest"],
                        'skill' 			=> $onQ["proposQcm"],
                        'ResponseQuestion' 	=> $onQ["resp"],
                        'ResponseKey' 		=> str_replace(":","",$onQ["repons_Key"]),
                        'type' 				=> 'checkbox',
                        'OperationType' 	=> 'QCM',
                        'IDChapitre' 		=> $idChap
                    );
                    $this->insert_dd('_questiontype',$data_QR);
                    $data_Chap = array('NbreQcm' 	=> '1' , 'TitreQcm' => $TitreQcm);
                    $this->db->where('IDChapitre', $idChap);
                    $this->db->update('_chapitre', $data_Chap);

                }

//				unlink(FCPATH.'PlatFormeConvert/'.$listIDlivres[$key]."_Qcm.HTML");

                ///
                //$err_desc = $err_desc.' ********** '.$content.'<br>';

            }
        }

        $arr_Res[] = array("id" => '1', "desc" => $err_desc) ;
        echo json_encode($arr_Res);
        exit;
    }

    public function upload_Attach_Save_QROC(){

        //$send_ID = "'".$_POST["attach_file"]."'";
        $f               	= $_FILES;
        $idChapList 		= $_POST["attach_file"];
        $nb_f	=	sizeof($f);
        //$bin_data_target    = base64_encode(file_get_contents( $f["mFile"]["tmp_name"] ));
        $err_desc = '';

        foreach($f["mFileQCM"]["name"] as $key=>$p) {

            $file_size  	=  $f["mFileQROC"]["size"][$key];
            $file_type  	=  $f["mFileQROC"]["type"][$key];
            $file_name  	=  $f["mFileQROC"]["name"][$key];
            $file_nameTmp  	=  $f["mFileQROC"]["tmp_name"][$key];
            $idChap			= $idChapList[$key];
            //print_r($file_size);
            if($file_size > 0){

                $fileDocx = $f["mFileQROC"]["tmp_name"][$key] ;

                $list 		= $this->read_docx($fileDocx);
                //print_r('-'.$extracted_plaintext.'<br>');
                $bdd_dataQ 	= array();$bdd_dataR = '';$is_q = true;
                $is_r 		= false;
                $numQ 		= 1 ;$TitreQroc = '';
                $content 	= str_replace('</w:r></w:p></w:tc><w:tc>', '<br>', $list);
                $content 	= str_replace('</w:r></w:p>', "\r\n", $content);

                $lign = implode("\r\n", $content);
                $lign = strip_tags($lign);

                $numBeg = 1;$numEnd = 2;$quitQuest = false;
                $is_quest = $this->getString("@@@@",$numBeg."-","@@@@".$lign);
                //print_r('**************************'.$is_quest.'----------------------------');
                $TitreQroc		= str_replace("@@@@", "", $is_quest);
                $listTitreQrc 	= explode("\r\n",$TitreQroc);
                if(sizeof($listTitreQrc)>2){$TitreQroc = $listTitreQrc[2];}


                $is_quest 	= $this->getString($numBeg."-",$numEnd."-",$lign);
                while($is_quest != '' && $quitQuest==false){
                    $is_quest = $this->getString($numBeg."-",$numEnd."-",$lign);
                    if($is_quest==''){
                        $is_quest 	= $this->getString($numBeg."-","@@@@",$lign."@@@@");
                        $quitQuest 	= true ;
                    }

                    //print_r('**************************'.$is_quest.'----------------------------');
                    //print_r('**************************'.$this->getString($numBeg."-","Réponse",$is_quest).'----------------------------');
                    //print_r('**************************'.strstr($is_quest,'Réponse').'----------------------------');
                    //$quest 	= $this->getString($numBeg."-","Réponse",$is_quest);Proposition : 1
                    $proposition1 = '';$proposition2 = '';
                    $questAll 	= $this->getString($numBeg."-",$this->lang->line('params_reponse'),$is_quest);
                    if(strpos($questAll,$this->lang->line('params_propos1'))!==false) {

                        $quest 			= $this->getString($numBeg."-",$this->lang->line('params_propos1'),(string)$is_quest);
                        $proposition1 	= $this->getString($this->lang->line('params_propos1'),$this->lang->line('params_propos2'),(string)$is_quest);
                        $proposition2 	= $this->getString($this->lang->line('params_propos2'),$this->lang->line('params_reponse'),(string)$is_quest);
                        //print_r('**************************'.(string)$questAll.'----------------------------');
                    }else{
                        $quest 	= $this->getString($numBeg."-",$this->lang->line('params_reponse'),$is_quest);
                    }

                    //$resp 	= strstr($is_quest,'Réponse');
                    $listResp 	= explode("\r\n",strstr($is_quest,$this->lang->line('params_reponse')));
                    $resp 		= '';
                    foreach ($listResp as $num =>$onRes)
                    {if($num>0){
                        if($proposition1==''){$resp = $resp.$onRes.'<br>';}else{$resp = $resp.$onRes.'&#10;';}
                    }}

                    $listProp1	= explode("\r\n",$proposition1);
                    $prop1		= '';
                    foreach ($listProp1 as $num =>$onRes)
                    {if($num>0){	$prop1 = $prop1.$onRes.'&#10;';}}

                    $listProp2	= explode("\r\n",$proposition2);
                    $prop2		= '';
                    foreach ($listProp2 as $num =>$onRes)
                    {if($num>0){	$prop2 = $prop2.$onRes.'&#10;';}}

                    $numBeg++;$numEnd++;
                    $bdd_dataQ[] = array("id" => $numBeg, "quest" => $quest , "resp"=>$resp , "proposition1"=>$prop1  , "proposition2"=>$prop2 );
                }
                $this->db->query("delete FROM `_questiontype` WHERE OperationType ='QROC' AND IDChapitre = '$idChap' ;");

                foreach ($bdd_dataQ as $onQ)
                {
                    if(strlen(substr($onQ["resp"], 0, 3))==3)
                    { $onQ["resp"] = str_replace("( ","",$onQ["resp"]); }

                    $data_QR = array(
                        'name' 				=> $onQ["quest"],
                        'ResponseQuestion' 	=> $onQ["resp"],
                        'type' 				=> 'text',
                        'OperationType' 	=> 'QROC',
                        'proposition1' 		=> $onQ["proposition1"],
                        'proposition2' 		=> $onQ["proposition2"],
                        'IDChapitre' 		=> $idChap
                    );
                    $this->insert_dd('_questiontype',$data_QR);
                    $data_Chap = array('NbreQroc' 	=> '1' , 'TitreQroc' => $TitreQroc);
                    $this->db->where('IDChapitre', $idChap);
                    $this->db->update('_chapitre', $data_Chap);

                }

//				unlink(FCPATH.'PlatFormeConvert/'.$listIDlivres[$key]."_Qcm.HTML");

                ///
                //$err_desc = $err_desc.' ********** '.$content.'<br>';

            }
        }

        $arr_Res[] = array("id" => '1', "desc" => $err_desc) ;
        echo json_encode($arr_Res);
        exit;
    }

    public function upload_Attach_Save_Resum(){

        //$send_ID = "'".$_POST["attach_fileResum"]."'";
        $f               	= $_FILES;
        $listChapitres 		= $_POST["attach_fileResum"];
        $nb_f	=	sizeof($f);
        //$bin_data_target    = base64_encode(file_get_contents( $f["mFile"]["tmp_name"] ));
        $err_desc = '';

        foreach($f["mFileResum"]["name"] as $key=>$p) {

            $file_size  =  $f["mFileResum"]["size"][$key];
            $file_type  =  $f["mFileResum"]["type"][$key];
            $file_name  =  $f["mFileResum"]["name"][$key];
            $file_nameTmp  =  $f["mFileResum"]["tmp_name"][$key];
            $idChap			= $listChapitres[$key];
            //print_r($file_size);
            if($file_size > 0){

                ///////$bin_data_target    = base64_encode(file_get_contents( $f["mFile"]["tmp_name"][$key] ));

                //$content = file_get_contents( $f["mFile"]["tmp_name"][$key] ,true);
                //$content = utf8_encode ( $content );
                //$content = iconv( "UTF-8", "UTF-8//TRANSLIT", $content );
                //$content = mb_convert_encoding($content, 'HTML-ENTITIES', "UTF-8");
                //$descD 	= $this->convertDocHTML($f["mFile"]["tmp_name"][$key],'','',0);//

                $fileDocx = $f["mFileResum"]["tmp_name"][$key] ;

                require_once APPPATH."/third_party/wordToPh/vendor/autoload.php";
                //$this->load->library('MyWorldDoc');

                $objReader= \PhpOffice\PhpWord\IOFactory::createReader('Word2007');
                $contents=$objReader->load($fileDocx);


                $rendername= \PhpOffice\PhpWord\Settings::PDF_RENDERER_TCPDF;

                $renderLibrary="tcpdf";
                $renderLibraryPath=APPPATH."/third_party/wordToPh/".$renderLibrary;
                if(!\PhpOffice\PhpWord\Settings::setPdfRenderer($rendername,$renderLibraryPath)){
                    die("Provide Render Library And Path");
                }

                $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($contents, 'HTML');
                $objWriter->save(FCPATH.'PlatFormeConvert/'.$idChap."_Resum.HTML");

                $content = htmlentities(file_get_contents(FCPATH.'PlatFormeConvert/'.$idChap."_Resum.HTML",true));
                //$content = htmlspecialchars_decode($content);
                if($file_size > 0){

                    $this->db->select('*');
                    $this->db->from('_resume');
                    $this->db->Where("IDChapitre = '$idChap' ");
                    $res = $this->db->get()->result_array();
                    if(count($res) > 0){
                        $idCurs = $res[0]["IDResume"] ;
                        $this->db->query("delete FROM `_page` WHERE IDResume = '$idCurs' ;");
                    }else{
                        $data = array(
                            'TitreResume' 	=> '',
                            'UrlResume' 	=> '',
                            'Tags' 			=> '',
                            'IDChapitre' 	=> $idChap
                        );
                        $idCurs= $this->insert_dd('_resume',$data);
                    }
                    $data_P = array(
                        'ContentFileCrypt' 	=> $content,
                        'ContenuPAge' 		=> '1.HTML',
                        'numeroPage' 		=> 1,
                        'IDResume' 			=> $idCurs
                    );

                    $this->insert_dd('_page',$data_P);

                    $data_Chap = array('NbreResume' 	=> '1' );
                    $this->db->where('IDChapitre', $idChap);
                    $this->db->update('_chapitre', $data_Chap);

                    //unlink(FCPATH.$OutPages.$pageNo.'.pdf');
                    /////// END : VERIFY IF THE COURSE ESXIT or not ///////


                }

                unlink(FCPATH.'PlatFormeConvert/'.$idChap."_Resum.HTML");


            }
        }



        $arr_Res[] = array("id" => '1', "desc" => $err_desc) ;
        echo json_encode($arr_Res);
        exit;
    }
    public function upload_Attach_Save_Curs(){

        //$send_ID = "'".$_POST["attach_file"]."'";
        $f               	= $_FILES;
        $listChapitres 		= $_POST["attach_file"];
        $nb_f	=	sizeof($f);
        //$bin_data_target    = base64_encode(file_get_contents( $f["mFile"]["tmp_name"] ));
        $err_desc = '';

        foreach($f["mFile"]["name"] as $key=>$p) {

            $file_size  =  $f["mFile"]["size"][$key];
            $file_type  =  $f["mFile"]["type"][$key];
            $file_name  =  $f["mFile"]["name"][$key];
            $file_nameTmp  =  $f["mFile"]["tmp_name"][$key];
            $idChap			= $listChapitres[$key];
            //print_r($file_size);
            if($file_size > 0){

                ///////$bin_data_target    = base64_encode(file_get_contents( $f["mFile"]["tmp_name"][$key] ));

                //$content = file_get_contents( $f["mFile"]["tmp_name"][$key] ,true);
                //$content = utf8_encode ( $content );
                //$content = iconv( "UTF-8", "UTF-8//TRANSLIT", $content );
                //$content = mb_convert_encoding($content, 'HTML-ENTITIES', "UTF-8");
                //$descD 	= $this->convertDocHTML($f["mFile"]["tmp_name"][$key],'','',0);//

                $fileDocx = $f["mFile"]["tmp_name"][$key] ;

                require_once APPPATH."/third_party/wordToPh/vendor/autoload.php";
                //$this->load->library('MyWorldDoc');

                $objReader= \PhpOffice\PhpWord\IOFactory::createReader('Word2007');
                $contents=$objReader->load($fileDocx);


                $rendername= \PhpOffice\PhpWord\Settings::PDF_RENDERER_TCPDF;

                $renderLibrary="tcpdf";
                $renderLibraryPath=APPPATH."/third_party/wordToPh/".$renderLibrary;
                if(!\PhpOffice\PhpWord\Settings::setPdfRenderer($rendername,$renderLibraryPath)){
                    die("Provide Render Library And Path");
                }

                $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($contents, 'HTML');
                $objWriter->save(FCPATH.'PlatFormeConvert/'.$idChap."_Curs.HTML");

                $content = htmlentities(file_get_contents(FCPATH.'PlatFormeConvert/'.$idChap."_Curs.HTML",true));
                //$content = htmlspecialchars_decode($content);
                if($file_size > 0){

                    $this->db->select('*');
                    $this->db->from('_cours');
                    $this->db->Where("IDChapitre = '$idChap' ");
                    $res = $this->db->get()->result_array();
                    if(count($res) > 0){
                        $idCurs = $res[0]["IDCours"] ;
                        $this->db->query("delete FROM `_page` WHERE IDCours = '$idCurs' ;");
                    }else{
                        $data = array(
                            'TitreCours' 	=> '',
                            'UrlCours' 		=> '',
                            'Tags' 			=> '',
                            'IDChapitre' 	=> $idChap
                        );
                        $idCurs= $this->insert_dd('_cours',$data);
                    }
                    $data_P = array(
                        'ContentFileCrypt' 	=> $content,
                        'ContenuPAge' 		=> '1.HTML',
                        'numeroPage' 		=> 1,
                        'IDCours' 			=> $idCurs
                    );

                    $this->insert_dd('_page',$data_P);

                    $data_Chap = array('NbreCours' 	=> '1' );
                    $this->db->where('IDChapitre', $idChap);
                    $this->db->update('_chapitre', $data_Chap);

                    //unlink(FCPATH.$OutPages.$pageNo.'.pdf');
                    /////// END : VERIFY IF THE COURSE ESXIT or not ///////


                }

                unlink(FCPATH.'PlatFormeConvert/'.$idChap."_Curs.HTML");


            }
        }



        $arr_Res[] = array("id" => '1', "desc" => $err_desc) ;
        echo json_encode($arr_Res);
        exit;
    }
    public function upload_Attach_Save_Curs_PDF(){

        //$send_ID = "'".$_POST["attach_file"]."'";
        $f               	= $_FILES;
        $listChapitres 		= $_POST["attach_file"];
        $nb_f	=	sizeof($f);
        //$bin_data_target    = base64_encode(file_get_contents( $f["mFile"]["tmp_name"] ));
        $err_desc = '';
        //print_r("*******************************");
        //print_r($f);
        //print_r("-------------------------------");

        foreach($f["mFile"]["name"] as $key=>$p) {

            $file_size  	=  $f["mFile"]["size"][$key];
            $file_type  	=  $f["mFile"]["type"][$key];
            $file_name  	=  $f["mFile"]["name"][$key];
            $file_nameTmp  	=  $f["mFile"]["tmp_name"][$key];
            $idChap			= $listChapitres[$key];
            //print_r($file_size);
            if($file_size > 0){

                $fileDocx = $f["mFile"]["tmp_name"][$key] ;

                require_once APPPATH."/third_party/wordToPh/vendor/autoload.php";

                $objReader= \PhpOffice\PhpWord\IOFactory::createReader('Word2007');
                $contents=$objReader->load($fileDocx);

                $rendername= \PhpOffice\PhpWord\Settings::PDF_RENDERER_TCPDF;

                $renderLibrary="tcpdf";
                $renderLibraryPath=APPPATH."/third_party/wordToPh/".$renderLibrary;
                if(!\PhpOffice\PhpWord\Settings::setPdfRenderer($rendername,$renderLibraryPath)){
                    die("Provide Render Library And Path");
                }

                //$objWriter= \PhpOffice\PhpWord\IOFactory::createWriter($contents,'Word2007');
                //$objWriter->save(FCPATH.'PlatFormeConvert/'.$idChap."_Curs.docx");

                //$objReader= \PhpOffice\PhpWord\IOFactory::createReader('Word2007');
                //$contents=$objReader->load(FCPATH.'PlatFormeConvert/'.$idChap."_Curs.docx");

                $objWriter= \PhpOffice\PhpWord\IOFactory::createWriter($contents,'PDF');
                $objWriter->save(FCPATH.'PlatFormeConvert/'.$idChap."_Curs.pdf");

                //unlink(FCPATH.'PlatFormeConvert/'.$idChap."_Curs.docx");

            }
        }

        $arr_Res[] = array("id" => '1', "desc" => $err_desc) ;
        echo json_encode($arr_Res);
        exit;

    }
    public function decoupagePDFCurs()
    {
        $this->load->helper('url');
        $this->load->helper('directory');

        $this->load->helper('file');

        $f              = $_FILES;
        $idChapList 	= $_POST["attach_file"];

        /////// BEGIN : VERIFY IF THE COURSE ESXIT or not ///////
        foreach($f["mFile"]["name"] as $key=>$p) {
            $file_size  	=  $f["mFile"]["size"][$key];
            $idChap			= $idChapList[$key];
            //print_r($file_size);
            if($file_size > 0){

                $this->db->select('*');
                $this->db->from('_cours');
                $this->db->Where("IDChapitre = '$idChap' ");
                $res = $this->db->get()->result_array();
                if(count($res) > 0){
                    $idCurs = $res[0]["IDCours"] ;
                    $this->db->query("delete FROM `_page` WHERE IDCours = '$idCurs' ;");
                }else{
                    $data = array(
                        'TitreCours' 	=> '',
                        'UrlCours' 		=> '',
                        'Tags' 			=> '',
                        'IDChapitre' 	=> $idChap
                    );
                    $idCurs= $this->insert_dd('_cours',$data);
                }
                /////// END : VERIFY IF THE COURSE ESXIT or not ///////

                $this->load->library('Mytcpdfi');
                // iterate through all pages

                $pdf 		= new \PDFMerger\PDFMerger();
                //$docPDF 	= FCPATH.'PlatFormeConvert/'."teddddddddst.pdf" ;
                $OutPages 	= 'PlatFormeConvert/'.$idChap.'_' ;
                $pageCount 	= $pdf->setSourceFile(FCPATH.'PlatFormeConvert/'.$idChap."_Curs.pdf",'all');
                //$pageCount 	= $pdf->setSourceFile(FCPATH.'PlatFormeConvert/'."test.pdf",'all');
                //log_message('error', $docF.'***************'.$pageCount);
                for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                    $pdf = new \PDFMerger\PDFMerger();
                    $pdf->addPDF(FCPATH.'PlatFormeConvert/'.$idChap."_Curs.pdf", $pageNo)
                        ->merge('file', FCPATH.$OutPages.$pageNo.'.pdf');

                    $fp 	=    	fopen(FCPATH.$OutPages.$pageNo.'.pdf',"rb");
                    $data 	=  		fread($fp,filesize(FCPATH.$OutPages.$pageNo.'.pdf'));
                    fclose($fp);

                    $data = chunk_split(base64_encode($data));

                    //print_r($data.'<br>');
                    $data_P = array(
                        'ContentFileCrypt' 	=> $data,
                        'ContenuPAge' 		=> $pageNo.'.pdf',
                        'numeroPage' 		=> $pageNo,
                        'IDCours' 			=> $idCurs
                    );

                    $this->insert_dd('_page',$data_P);

                    $data_Chap = array('NbreCours' 	=> '1' );
                    $this->db->where('IDChapitre', $idChap);
                    $this->db->update('_chapitre', $data_Chap);

                    unlink(FCPATH.$OutPages.$pageNo.'.pdf');

                }

                //unlink(FCPATH.'PlatFormeConvert/'.$idChap."_Curs.pdf");

            }
        }

        $err_desc = '';
        $arr_Res[] = array("id" => '1', "desc" => $err_desc) ;
        echo json_encode($arr_Res);
        exit;

    }

    public function delLiv(){

        // supp livre
        // supp publicite
        // supp chap
        // supp _questiontype
        // supp cours
        //  supp resume
        // supp figure
        // supp pages
        $id 		= $_POST["idL"];
        $id_ = base64_decode($id);
        if((strlen($this->session->userdata('passTok'))==200) && ($this->session->userdata('EstAdmin') ==1)) {

            $this->db->query("delete FROM `_publicite` WHERE IDLivre = '$id_' ;");

            $this->db->select('IDChapitre');
            $this->db->from('_chapitre');
            $this->db->Where("IDLivre = '$id_' ");
            $res = $this->db->get()->result_array();
            if(count($res) > 0){

                foreach ($res as $onechap){
                    $idch = $onechap["IDChapitre"];
                    // SUPP _questiontype
                    $this->db->query("delete FROM `_questiontype` 	WHERE IDChapitre = '$idch' ;");

                    // SUPP CURSE & RESUME & PAGE
                    $this->db->select('IDCours');
                    $this->db->from('_cours');
                    $this->db->Where("IDChapitre = '$idch' ");
                    $res_Curs = $this->db->get()->result_array();
                    foreach ($res_Curs as $oneCurs){
                        $idCrs = $oneCurs["IDCours"];
                        $this->db->query("delete FROM `_page` 	WHERE IDCours = '$idCrs' ;");
                        $this->db->query("delete FROM `_figure` WHERE IDCours = '$idCrs' ;");
                    }
                    $this->db->query("delete FROM `_cours` 		WHERE IDChapitre = '$idch' ;");

                    $this->db->select('IDResume');
                    $this->db->from('_resume');
                    $this->db->Where("IDChapitre = '$idch' ");
                    $res_Resm = $this->db->get()->result_array();
                    foreach ($res_Resm as $oneRsm){
                        $idRsm = $oneRsm["IDResume"];
                        $this->db->query("delete FROM `_page` 	WHERE IDResume = '$idRsm' ;");
                        $this->db->query("delete FROM `_figure` WHERE IDResume = '$idRsm' ;");
                    }
                    $this->db->query("delete FROM `_resume` 	WHERE IDChapitre = '$idch' ;");

                    $this->db->query("delete FROM `_chapitre` 	WHERE IDChapitre = '$idch' ;");
                }
            }
            $this->db->query("delete FROM `_livre` WHERE IDLivre = '$id_' ;");

            $arr_Res[] = array("id" => '1', "desc" => '') ;
        }
        else{
            $arr_Res[] = array("id" => '-1', "desc" => $this->lang->line('supp_delErr')) ;
        }


        echo json_encode($arr_Res);
        exit;

    }
    public function suppCh(){
        $id 		= $_POST["idC"];
        $idch = base64_decode($id);
        if((strlen($this->session->userdata('passTok'))==200) && ($this->session->userdata('EstAdmin') ==1)) {

            // SUPP _questiontype
            $this->db->query("delete FROM `_questiontype` 	WHERE IDChapitre = '$idch' ;");

            // SUPP CURSE & RESUME & PAGE
            $this->db->select('IDCours');
            $this->db->from('_cours');
            $this->db->Where("IDChapitre = '$idch' ");
            $res_Curs = $this->db->get()->result_array();
            foreach ($res_Curs as $oneCurs){
                $idCrs = $oneCurs["IDCours"];
                $this->db->query("delete FROM `_page` 	WHERE IDCours = '$idCrs' ;");
                $this->db->query("delete FROM `_figure` WHERE IDCours = '$idCrs' ;");
            }
            $this->db->query("delete FROM `_cours` 		WHERE IDChapitre = '$idch' ;");

            $this->db->select('IDResume');
            $this->db->from('_resume');
            $this->db->Where("IDChapitre = '$idch' ");
            $res_Resm = $this->db->get()->result_array();
            foreach ($res_Resm as $oneRsm){
                $idRsm = $oneRsm["IDResume"];
                $this->db->query("delete FROM `_page` 	WHERE IDResume = '$idRsm' ;");
                $this->db->query("delete FROM `_figure` WHERE IDResume = '$idRsm' ;");
            }
            $this->db->query("delete FROM `_resume` 	WHERE IDChapitre = '$idch' ;");

            $this->db->query("delete FROM `_chapitre` 	WHERE IDChapitre = '$idch' ;");

            $arr_Res[] = array("id" => '1', "desc" => '') ;
        }
        else{
            $arr_Res[] = array("id" => '-1', "desc" => $this->lang->line('supp_delErr')) ;
        }

        echo json_encode($arr_Res);
        exit;

    }
    public function set_ChapBack(){

        $idChaps 		= $_POST["set_IdCh"];
        $newTitre 	    = $_POST["setTitreChap"];
        $err_desc = '';
        //print_r($idChaps);
        //print_r("************");
        //print_r($newTitre);

        foreach ($newTitre as $key=>$p){

            if($idChaps[$key] > 0 && $newTitre[$key] !=''){

                $data_l   = array('TitreChapitre' => $newTitre[$key]);
                $this->db->where("IDChapitre = '".$idChaps[$key]."'");
                $this->db->update('_chapitre', $data_l);

                $arr_Res[] = array("id" => '1', "desc" => $err_desc) ;
            }
        }

        echo json_encode($arr_Res);
        exit;
    }
    public function set_ItemBack(){

        $idItems 		= $_POST["set_IdItm"];
        $idCats 		= $_POST["set_IdCat"];
        $newTitre 	    = $_POST["setTitreItem"];
        $err_desc = '';

        foreach ($newTitre as $key=>$p){

            if($idItems[$key] > 0 && $newTitre[$key] !=''){

                $data_l   = array('Libelle' => $newTitre[$key]);
                $this->db->where("IDCategory",$idCats[$key]);
                $this->db->update('_category', $data_l);

                $data_I   = array('LibelleTheme' => $newTitre[$key]);
                $this->db->where("IDTheme",$idItems[$key]);
                $this->db->update('_theme', $data_I);

            }
        }
        $arr_Res[] = array("id" => '1', "desc" => $err_desc) ;
        echo json_encode($arr_Res);
        exit;
    }

    public function upload_Attach_Save_QCM_Fig_Ass(){

        //log_message('error',"********************upload_Attach_Save_QCM_Fig_Ass******************");

        //$send_ID = "'".$_POST["attach_file"]."'";
        $f               	= $_FILES;
        $idChapList 		= $_POST["attach_file"];
        $nb_f	=	sizeof($f);
        //$bin_data_target    = base64_encode(file_get_contents( $f["mFile"]["tmp_name"] ));
        $err_desc = '';

        //log_message('error',"********1******".$idChapList);
        //log_message('error',"********2******".$nb_f);

        foreach($f["mFileQCM"]["name"] as $key=>$p) {

            $file_size  	=  $f["mFileQCM_Fig_Ass"]["size"][$key];
            $file_type  	=  $f["mFileQCM_Fig_Ass"]["type"][$key];
            $file_name  	=  $f["mFileQCM_Fig_Ass"]["name"][$key];
            $file_nameTmp  	=  $f["mFileQCM_Fig_Ass"]["tmp_name"][$key];
            $idChap			= $idChapList[$key];
            //print_r($file_size);
            if($file_size > 0){

                $fileDocx 	= $f["mFileQCM_Fig_Ass"]["tmp_name"][$key] ;

                $list 		= $this->read_docx($fileDocx);

                $bdd_dataQ 	= array();$bdd_dataR = '';$is_q = true;
                $is_r 		= false;
                $numQ 		= 1 ;$TitreQroc = '';
                $content 	= str_replace('</w:r></w:p></w:tc><w:tc>', '<br>', $list);
                $content 	= str_replace('</w:r></w:p>', "\r\n", $content);

                $lign = implode("\r\n", $content);
                $lign = strip_tags($lign);

                //log_message('error',$lign);

                // -- Séparer la section QCM seulement
                $start 		= strpos($lign, 'QCM :');
                $end 		= strpos($lign, 'QROC :');
                $qcmText 	= substr($lign, $start, $end - $start);

                //log_message('error', 'Question: '.$start);
                //log_message('error', 'Figures: '.$end);

                // -- Lecture ligne par ligne
                $lines = explode("\n", $qcmText);

                //log_message('error', "*****************$idChap*************************");

                foreach ($lines as $line) {

                    //log_message('error', $line);
                    // On cherche des lignes comme "1- (Fig1)" ou "3- (Fig2 ; Fig3)"
                    if (preg_match('/(\d+)-\s*\((.*?)\)/', $line, $matches)) {
                        $questionNumber = $matches[1]; // 1, 2, 3, etc.
                        $figures = trim($matches[2]);  // Fig1 ou Fig2 ; Fig3

                        // DEBUG pour vérifier
                        //log_message('error', 'Question: '.$questionNumber.' Figures: '.$figures);

                        $data_l   = array('schemas_associes' => $figures);
                        $this->db->where('IDChapitre', $idChap);
                        $this->db->where('OperationType', 'QCM');
                        $this->db->like('name', $questionNumber . '-', 'after'); // IMPORTANT : after pour LIKE 'n-%'
                        $this->db->update('_questiontype', $data_l);
                    }
                }

            }
        }

        $arr_Res[] = array("id" => '1', "desc" => $err_desc) ;
        echo json_encode($arr_Res);
        exit;
    }
    public function upload_Attach_Save_QROC_Fig_Ass()
    {

        //$send_ID = "'".$_POST["attach_file"]."'";
        $f               	= $_FILES;
        $idChapList 		= $_POST["attach_file"];
        $nb_f	=	sizeof($f);
        //$bin_data_target    = base64_encode(file_get_contents( $f["mFile"]["tmp_name"] ));
        $err_desc = '';

//		log_message('error',"********1******".$idChapList[0]);
//		log_message('error',"********2******".$nb_f);

        foreach($f["mFileQROC"]["name"] as $key=>$p) {

            $file_size  	=  $f["mFileQROC_Fig_Ass"]["size"][$key];
            $file_type  	=  $f["mFileQROC_Fig_Ass"]["type"][$key];
            $file_name  	=  $f["mFileQROC_Fig_Ass"]["name"][$key];
            $file_nameTmp  	=  $f["mFileQROC_Fig_Ass"]["tmp_name"][$key];
            $idChap			= $idChapList[$key];
            //print_r($file_size);
            if($file_size > 0){

                $fileDocx 	= $f["mFileQROC_Fig_Ass"]["tmp_name"][$key] ;

                $list 		= $this->read_docx($fileDocx);

                $bdd_dataQ 	= array();$bdd_dataR = '';$is_q = true;
                $is_r 		= false;
                $numQ 		= 1 ;$TitreQroc = '';
                $content 	= str_replace('</w:r></w:p></w:tc><w:tc>', '<br>', $list);
                $content 	= str_replace('</w:r></w:p>', "\r\n", $content);

                $lign = implode("\r\n", $content);
                $lign = strip_tags($lign);

                //log_message('error',$lign);

                // -- Séparer la section QROC seulement
                $start 		= strpos($lign, 'QROC :');
                //$end 		= strpos($lign, 'QROC :');
                $qrocText 	= substr($lign, $start);
                $qrocText   = str_replace('QROC :', '', $qrocText);
                //log_message('error', 'Question: '.$start);
                //log_message('error', 'Figures: '.$qrocText);

                // -- Lecture ligne par ligne
                $lines = explode("\n", $qrocText);

                foreach ($lines as $line) {

                    //log_message('error', $line);
                    // On cherche des lignes comme "1- (Fig1)" ou "3- (Fig2 ; Fig3)"
                    if (preg_match('/(\d+)-\s*\((.*?)\)/', $line, $matches)) {
                        $questionNumber = $matches[1]; // 1, 2, 3, etc.
                        $figures = trim($matches[2]);  // Fig1 ou Fig2 ; Fig3

                        // DEBUG pour vérifier
                        //log_message('error', 'Question: '.$questionNumber.' Figures: '.$figures);

                        $data_l   = array('schemas_associes' => $figures);
                        $this->db->where('IDChapitre', $idChap);
                        $this->db->where('OperationType', 'QROC');
                        $this->db->like('name', $questionNumber . '-', 'after'); // IMPORTANT : after pour LIKE 'n-%'
                        $this->db->update('_questiontype', $data_l);
                    }
                }

            }
        }

        $arr_Res[] = array("id" => '1', "desc" => $err_desc) ;
        echo json_encode($arr_Res);
        exit;
    }
    public function suppQCM_Fig_Ass(){

        $id 		= $_POST["idC"];
        $idch = base64_decode($id);
        if((strlen($this->session->userdata('passTok'))==200) && ($this->session->userdata('EstAdmin') ==1)) {

            $data_l   = array('schemas_associes' => '');
            $this->db->where('IDChapitre', $idch);
            $this->db->where('OperationType', 'QCM');
            $this->db->update('_questiontype', $data_l);

            $arr_Res[] = array("id" => '1', "desc" => '') ;
        }
        else{
            $arr_Res[] = array("id" => '-1', "desc" => $this->lang->line('supp_delErr')) ;
        }

        echo json_encode($arr_Res);
        exit;

    }
    public function suppQROC_Fig_Ass(){

        $id 		= $_POST["idC"];
        $idch = base64_decode($id);
        if((strlen($this->session->userdata('passTok'))==200) && ($this->session->userdata('EstAdmin') ==1)) {

            $data_l   = array('schemas_associes' => '');
            $this->db->where('IDChapitre', $idch);
            $this->db->where('OperationType', 'QROC');
            $this->db->update('_questiontype', $data_l);

            $arr_Res[] = array("id" => '1', "desc" => '') ;
        }
        else{
            $arr_Res[] = array("id" => '-1', "desc" => $this->lang->line('supp_delErr')) ;
        }

        echo json_encode($arr_Res);
        exit;

    }

    public function suppCurs(){

        $id 		= $_POST["idC"];
        $idch = base64_decode($id);
        if((strlen($this->session->userdata('passTok'))==200) && ($this->session->userdata('EstAdmin') ==1)) {

            // SUPP CURSE & PAGE
            $this->db->select('IDCours');
            $this->db->from('_cours');
            $this->db->Where("IDChapitre = '$idch' ");
            $res_Curs = $this->db->get()->result_array();
            foreach ($res_Curs as $oneCurs){
                $idCrs = $oneCurs["IDCours"];
                $this->db->query("delete FROM `_page` 	WHERE IDCours = '$idCrs' ;");
            }
            $this->db->query("delete FROM `_cours` 		WHERE IDChapitre = '$idch' ;");

            $data_l   = array('NbreCours' => 0);
            $this->db->where("IDChapitre = '".$idch."'");
            $this->db->update('_chapitre', $data_l);

            $arr_Res[] = array("id" => '1', "desc" => '') ;
        }
        else{
            $arr_Res[] = array("id" => '-1', "desc" => $this->lang->line('supp_delErr')) ;
        }

        echo json_encode($arr_Res);
        exit;

    }
    public function suppResum(){

        $id 		= $_POST["idC"];
        $idch = base64_decode($id);
        if((strlen($this->session->userdata('passTok'))==200) && ($this->session->userdata('EstAdmin') ==1)) {

            // SUPP RESUME & PAGE
            $this->db->select('IDResume');
            $this->db->from('_resume');
            $this->db->Where("IDChapitre = '$idch' ");
            $res_Resm = $this->db->get()->result_array();
            foreach ($res_Resm as $oneRsm){
                $idRsm = $oneRsm["IDResume"];
                $this->db->query("delete FROM `_page` 	WHERE IDResume = '$idRsm' ;");
            }
            $this->db->query("delete FROM `_resume` 	WHERE IDChapitre = '$idch' ;");

            $data_l   = array('NbreResume' => 0);
            $this->db->where("IDChapitre = '".$idch."'");
            $this->db->update('_chapitre', $data_l);

            $arr_Res[] = array("id" => '1', "desc" => '') ;
        }
        else{
            $arr_Res[] = array("id" => '-1', "desc" => $this->lang->line('supp_delErr')) ;
        }

        echo json_encode($arr_Res);
        exit;

    }
    public function suppQCM(){

        $id 		= $_POST["idC"];
        $idch = base64_decode($id);
        if((strlen($this->session->userdata('passTok'))==200) && ($this->session->userdata('EstAdmin') ==1)) {

            $this->db->query("delete FROM `_questiontype` 	WHERE IDChapitre = '$idch' AND OperationType = 'QCM' ;");

            $data_l   = array('NbreQcm' => 0 , 'TitreQcm' => '' );
            $this->db->where("IDChapitre = '".$idch."'");
            $this->db->update('_chapitre', $data_l);

            $arr_Res[] = array("id" => '1', "desc" => '') ;
        }
        else{
            $arr_Res[] = array("id" => '-1', "desc" => $this->lang->line('supp_delErr')) ;
        }

        echo json_encode($arr_Res);
        exit;

    }
    public function suppQROC(){

        $id 		= $_POST["idC"];
        $idch = base64_decode($id);
        if((strlen($this->session->userdata('passTok'))==200) && ($this->session->userdata('EstAdmin') ==1)) {

            $this->db->query("delete FROM `_questiontype` 	WHERE IDChapitre = '$idch' AND OperationType = 'QROC' ;");

            $data_l   = array('NbreQroc' => 0 , 'TitreQroc' => '' );
            $this->db->where("IDChapitre = '".$idch."'");
            $this->db->update('_chapitre', $data_l);

            $arr_Res[] = array("id" => '1', "desc" => '') ;
        }
        else{
            $arr_Res[] = array("id" => '-1', "desc" => $this->lang->line('supp_delErr')) ;
        }

        echo json_encode($arr_Res);
        exit;

    }
    public function suppFigu(){

        $id 		= $_POST["idC"];
        $idFig 		= base64_decode($id);
        if((strlen($this->session->userdata('passTok'))==200) && ($this->session->userdata('EstAdmin') ==1)) {

            $ChapID = -1;
            $this->db->select('IDCours , IDResume');
            $this->db->from('_figure');
            $this->db->Where("IDFigure",$idFig);
            $res = $this->db->get()->result_array();
            if(count($res) > 0) {
                $idCurs = $res[0]["IDCours"];
                $idResm = $res[0]["IDResume"];
                $this->db->query("delete FROM `_figure` WHERE IDFigure = '$idFig' ;");

                if($idCurs>0){
                    //List des figures
                    $this->db->select('IDCours');
                    $this->db->from('_figure');
                    $this->db->Where("IDCours",$idCurs);
                    $resF = $this->db->get()->result_array();

                    //ID chapitre
                    $this->db->select('IDChapitre');
                    $this->db->from('_cours');
                    $this->db->Where("IDCours",$idCurs);
                    $resCr = $this->db->get()->result_array();
                    if(count($resCr) > 0) {
                        $ChapID 	= $resCr[0]["IDChapitre"] ;
                    }
                    // Liste des pages
                    $this->db->select('IDPage');
                    $this->db->from('_page');
                    $this->db->Where("IDCours",$idCurs);
                    $resP = $this->db->get()->result_array();

                    if(count($resF)== 0 && count($resP)==0 && $ChapID>0) {
                        $data_l   	= array('NbreCours' => 0);
                        $this->db->where("IDChapitre",$ChapID);
                        $this->db->update('_chapitre', $data_l);

                        $this->db->query("delete FROM `_cours` WHERE IDCours = '$idCurs' ;");
                    }
                    //print_r(count($resF)."------".count($resP)."-----".$ChapID);
                }

                if($idResm>0){
                    //List des figures
                    $this->db->select('IDResume');
                    $this->db->from('_figure');
                    $this->db->Where("IDResume",$idResm);
                    $resF = $this->db->get()->result_array();

                    //ID chapitre
                    $this->db->select('IDChapitre');
                    $this->db->from('_resume');
                    $this->db->Where("IDResume",$idResm);
                    $resResm = $this->db->get()->result_array();
                    if(count($resResm) > 0) {
                        $ChapID 	= $resResm[0]["IDChapitre"] ;
                    }
                    // Liste des pages
                    $this->db->select('IDPage');
                    $this->db->from('_page');
                    $this->db->Where("IDResume",$idResm);
                    $resP = $this->db->get()->result_array();

                    if(count($resF)== 0 && count($resP)==0 && $ChapID>0) {
                        $data_l   	= array('NbreResume' => 0);
                        $this->db->where("IDChapitre",$ChapID);
                        $this->db->update('_chapitre', $data_l);

                        $this->db->query("delete FROM `_resume` WHERE IDResume = '$idResm' ;");
                    }
                    //print_r(count($resF)."------".count($resP)."-----".$ChapID);
                }

            }

            $arr_Res[] = array("id" => '1', "desc" => '') ;
        }
        else{
            $arr_Res[] = array("id" => '-1', "desc" => $this->lang->line('supp_delErr')) ;
        }

        echo json_encode($arr_Res);
        exit;

    }
    public function suppAllFigu(){

        $id 		= $_POST["idC"];
        $idCh 		= base64_decode($id);
        if((strlen($this->session->userdata('passTok'))==200) && ($this->session->userdata('EstAdmin') ==1)) {

            $this->db->select('*');
            $this->db->from('_cours');
            $this->db->Where("IDChapitre = '$idCh' ");
            $res = $this->db->get()->result_array();
            if(count($res) > 0){
                $idCurs = $res[0]["IDCours"] ;
                $this->db->query("delete FROM `_figure` WHERE IDCours = '$idCurs' ;");

                // Liste des pages
                $this->db->select('IDPage');
                $this->db->from('_page');
                $this->db->Where("IDCours",$idCurs);
                $resP = $this->db->get()->result_array();
                if(count($resP)==0) {
                    $data_l   	= array('NbreCours' => 0);
                    $this->db->where("IDChapitre",$idCh);
                    $this->db->update('_chapitre', $data_l);
                }
                $arr_Res[] = array("id" => '1', "desc" => '') ;

            }else{
                $arr_Res[] = array("id" => '-1', "desc" => 'Chapter not found') ;
            }

        }
        else{
            $arr_Res[] = array("id" => '-1', "desc" => $this->lang->line('supp_delErr')) ;
        }

        echo json_encode($arr_Res);
        exit;

    }
    public function suppAllFiguRSM(){

        $id 		= $_POST["idC"];
        $idCh 		= base64_decode($id);
        if((strlen($this->session->userdata('passTok'))==200) && ($this->session->userdata('EstAdmin') ==1)) {

            $this->db->select('*');
            $this->db->from('_resume');
            $this->db->Where("IDChapitre = '$idCh' ");
            $res = $this->db->get()->result_array();
            if(count($res) > 0){
                $idRsm = $res[0]["IDResume"] ;
                $this->db->query("delete FROM `_figure` WHERE IDResume = '$idRsm' ;");

                // Liste des pages
                $this->db->select('IDPage');
                $this->db->from('_page');
                $this->db->Where("IDResume",$idRsm);
                $resP = $this->db->get()->result_array();
                if(count($resP)==0) {
                    $data_l   	= array('NbreResume' => 0);
                    $this->db->where("IDChapitre",$idCh);
                    $this->db->update('_chapitre', $data_l);
                }
                $arr_Res[] = array("id" => '1', "desc" => '') ;

            }else{
                $arr_Res[] = array("id" => '-1', "desc" => 'Chapter not found') ;
            }

        }
        else{
            $arr_Res[] = array("id" => '-1', "desc" => $this->lang->line('supp_delErr')) ;
        }

        echo json_encode($arr_Res);
        exit;

    }

    public function set_KeysIndex(){

        $indexKeysCurs 			= $_POST["tit"];
        $idCh 				    = $_POST["idC"];
        $typeKeys 				= $_POST["typeKeys"];
        $desc = '' ;//$newTitre;

        switch ($typeKeys)
        {
            case 'curs' :
                $data_Chap = array('indexKeysCurs' 	=> $indexKeysCurs );
                break;

            case 'resum' :
                $data_Chap = array('indexKeysResum' => $indexKeysCurs );
                break;

            case 'qcm' :
                $data_Chap = array('indexKeysQcm' 	=> $indexKeysCurs );
                break;

            case 'qroc' :
                $data_Chap = array('indexKeysQroc' 	=> $indexKeysCurs );
                break;

            default :
                $desc = 'Empty type index';
                break;
        }

        if($desc == ''){
            $this->db->where('IDChapitre', $idCh);
            $this->db->update('_chapitre', $data_Chap);
            $arr_Res[] = array("id" => '1', "desc" => $desc) ;
        }else{$arr_Res[] = array("id" => '-1', "desc" => $desc) ;}


        echo json_encode($arr_Res);
        exit;
    }
    public function set_KeysIndexBook(){

        $indexKeysBook 			= $_POST["tit"];
        $idB 				    = $_POST["idC"];
        $typeKeys 				= $_POST["typeKeys"];
        $desc = '' ;//$newTitre;

        switch ($typeKeys)
        {
            case 'book' :
                $data_Book = array('indexKeysBook' 	=> $indexKeysBook );
                break;

            default :
                $desc = 'Empty type index';
                break;
        }

        if($desc == ''){
            $this->db->where('IDLivre', $idB);
            $this->db->update('_livre', $data_Book);
            $arr_Res[] = array("id" => '1', "desc" => $desc) ;
        }else{$arr_Res[] = array("id" => '-1', "desc" => $desc) ;}


        echo json_encode($arr_Res);
        exit;
    }

    public function decoupagePDF()
    {

        $this->load->library('Mytcpdfi');

        $pdf = new \PDFMerger\PDFMerger();
        $pdf->addPDF(FCPATH.'PlatFormeConvert/'."teddddddddst.pdf", '1')
            ->merge('file', FCPATH.'PlatFormeConvert/2'.'.pdf');

    }
    public function upload_Attach_Save_Curs_____(){

        //$send_ID = "'".$_POST["attach_file"]."'";
        $f               	= $_FILES;
        $listChapitres 		= $_POST["attach_file"];
        $nb_f	=	sizeof($f);
        //$bin_data_target    = base64_encode(file_get_contents( $f["mFile"]["tmp_name"] ));
        $err_desc = '';
        print_r("*******************************");
        print_r($f);
        print_r("-------------------------------");
        foreach($f["mFile"]["name"] as $key=>$p) {

            $file_size  	=  $f["mFile"]["size"][$key];
            $file_type  	=  $f["mFile"]["type"][$key];
            $file_name  	=  $f["mFile"]["name"][$key];
            $file_nameTmp  	=  $f["mFile"]["tmp_name"][$key];
            $idChap			= $listChapitres[$key];
            //print_r($file_size);
            if($file_size > 0){

                $fileDocx = $f["mFile"]["tmp_name"][$key] ;


                require_once APPPATH."/third_party/wordToPh/vendor/autoload.php";
                //$this->load->library('MyWorldDoc');

                $objReader= \PhpOffice\PhpWord\IOFactory::createReader('Word2007');
                $contents=$objReader->load($fileDocx);

                //$objWriter= \PhpOffice\PhpWord\IOFactory::createWriter($contents,'Word2007');
                //$objWriter->save("new.docx");

                //$contents=$objReader->load("Clavicule.docx");

                $rendername= \PhpOffice\PhpWord\Settings::PDF_RENDERER_TCPDF;

                $renderLibrary="tcpdf";
                $renderLibraryPath=APPPATH."/third_party/wordToPh/".$renderLibrary;
                if(!\PhpOffice\PhpWord\Settings::setPdfRenderer($rendername,$renderLibraryPath)){
                    die("Provide Render Library And Path");
                }

                $objWriter= \PhpOffice\PhpWord\IOFactory::createWriter($contents,'PDF');
                //$objWriter->save("teddddddddst.pdf");
                $objWriter->save(FCPATH.'PlatFormeConvert/'."teddddddddst.pdf");


                /////// BEGIN : VERIFY IF THE COURSE ESXIT or not ///////

                $this->db->select('*');
                $this->db->from('_cours');
                $this->db->Where("IDChapitre = '$idChap' ");
                $res = $this->db->get()->result_array();
                if(count($res) > 0){
                    $idCurs = $res[0]["IDCours"] ;
                    $this->db->query("delete FROM `_page` WHERE IDCours = '$idCurs' ;");
                }else{
                    $data = array(
                        'TitreCours' 	=> '',
                        'UrlCours' 		=> '',
                        'Tags' 			=> '',
                        'IDChapitre' 	=> $idChap
                    );
                    $idCurs= $this->insert_dd('_cours',$data);
                }
                /////// END : VERIFY IF THE COURSE ESXIT or not ///////

                $this->load->library('Mytcpdfi');
                // iterate through all pages

                $pdf 		= new \PDFMerger\PDFMerger();
                //$docPDF 	= FCPATH.'PlatFormeConvert/'."teddddddddst.pdf" ;
                $OutPages 	= 'PlatFormeConvert/' ;
                $pageCount 	= $pdf->setSourceFile(FCPATH.'PlatFormeConvert/'."teddddddddst.pdf",'all');
                //log_message('error', $docF.'***************'.$pageCount);
                for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                    $pdf = new \PDFMerger\PDFMerger();
                    $pdf->addPDF(FCPATH.'PlatFormeConvert/'."teddddddddst.pdf", $pageNo)
                        ->merge('file', FCPATH.$OutPages.$pageNo.'.pdf');

                    $fp 	=    	fopen(FCPATH.$OutPages.$pageNo.'.pdf',"rb");
                    $data 	=  		fread($fp,filesize(FCPATH.$OutPages.$pageNo.'.pdf'));
                    fclose($fp);

                    $data = chunk_split(base64_encode($data));

                    //print_r($data.'<br>');
                    $data_P = array(
                        'ContentFileCrypt' 	=> $data,
                        'ContenuPAge' 		=> $pageNo.'.pdf',
                        'numeroPage' 		=> $pageNo,
                        'IDCours' 			=> $idCurs
                    );

                    $this->insert_dd('_page',$data_P);

                    //unlink(FCPATH.$OutPages.$pageNo.'.pdf');

                }

                unlink(FCPATH.'PlatFormeConvert/'."teddddddddst.pdf");

                //$err_desc = $err_desc.' ********** '.$content.'<br>';

            }
        }

        $arr_Res[] = array("id" => '1', "desc" => $err_desc) ;
        echo json_encode($arr_Res);
        exit;
    }
    public function decoupageWord_test()
    {
        require_once APPPATH."/third_party/wordToPh/vendor/autoload.php";
        //$this->load->library('MyWorldDoc');

        $objReader= \PhpOffice\PhpWord\IOFactory::createReader('Word2007');
        $contents=$objReader->load("Clavicule.docx");

        //$objWriter= \PhpOffice\PhpWord\IOFactory::createWriter($contents,'Word2007');
        //$objWriter->save("new.docx");

        //$contents=$objReader->load("Clavicule.docx");

        $rendername= \PhpOffice\PhpWord\Settings::PDF_RENDERER_TCPDF;

        $renderLibrary="tcpdf";
        $renderLibraryPath=APPPATH."/third_party/wordToPh/".$renderLibrary;
        if(!\PhpOffice\PhpWord\Settings::setPdfRenderer($rendername,$renderLibraryPath)){
            die("Provide Render Library And Path");
        }

        $objWriter= \PhpOffice\PhpWord\IOFactory::createWriter($contents,'PDF');
        $objWriter->save("test.pdf");

    }
    public function  redeclareTCPDF(){
        if (!defined('K_TCPDF_EXTERNAL_CONFIG')) {

            define('K_TCPDF_EXTERNAL_CONFIG', true);

            // DOCUMENT_ROOT fix for IIS Webserver
            if ((!isset($_SERVER['DOCUMENT_ROOT'])) or (empty($_SERVER['DOCUMENT_ROOT']))) {
                if (isset($_SERVER['SCRIPT_FILENAME'])) {
                    $_SERVER['DOCUMENT_ROOT'] = str_replace(
                        '\\',
                        '/',
                        substr($_SERVER['SCRIPT_FILENAME'], 0, 0-strlen($_SERVER['PHP_SELF']))
                    );
                } elseif (isset($_SERVER['PATH_TRANSLATED'])) {
                    $_SERVER['DOCUMENT_ROOT'] = str_replace(
                        '\\',
                        '/',
                        substr(str_replace('\\\\', '\\', $_SERVER['PATH_TRANSLATED']), 0, 0-strlen($_SERVER['PHP_SELF']))
                    );
                } else {
                    // define here your DOCUMENT_ROOT path if the previous fails (e.g. '/var/www')
                    $_SERVER['DOCUMENT_ROOT'] = '/var/www';
                }
            }

            // be sure that the end slash is present
            $_SERVER['DOCUMENT_ROOT'] = str_replace('//', '/', $_SERVER['DOCUMENT_ROOT'].'/');

            /**
             * Installation path of tcpdf with composer.
             */
            $vendorFolders = array(
                dirname(dirname(dirname(__FILE__))) . '/vendor/',
                dirname(dirname(dirname(__FILE__))) . '/../../',
            );
            foreach ($vendorFolders as $vendorFolder) {
                if (file_exists($vendorFolder.'autoload.php')) {
                    $k_path_main = $vendorFolder . 'tecnickcom/tcpdf/';

                    break;
                }
            }

            define('K_PATH_URL_CACHE', K_PATH_URL.'cache/');

        }
    }

    ///*****TEST EVALUATION*********////
    public function evaluatQCM($id,$listDIS,$typeImp)
    {
        $id 		= base64_decode($id);

        $this->db->select('*');
        $this->db->from('_livre , _theme');
        $this->db->Where("IDLivre = '$id' AND _theme.IDTheme = _livre.IDTheme");
        $resBook = $this->db->get()->result_array();

        $idLivr 			= $resBook[0]["IDLivre"];
        $listChap 			= $this->listChaptCours($idLivr);

        $arr['listChap'] 	= $listChap;
        $arr['typeImp'] 	= $typeImp;
        $arr['OneBook'] 	= $resBook;
        $arr['listDIS'] 	= $listDIS;
        $arr['page'] 		= 'evaluatQCM';
        $arr['listCat'] 	= $this->getListCategory();
        //$this->load->view('evaluatQCM',$arr);
        $this->load->view($this->getTypePlatform() ? 'v1_evaluatQCM' : 'evaluatQCM', $arr);
    }

    public function set_testQCMChap(){

        $desc =  '' ;//$newTitre;
        if(!isset($_POST["bookID"]) || !isset($_POST["listIDsTest"]) ){
            $arr_Res[] = array("id" => '-1', "desc" => $this->lang->line('testPopErr')) ;
        }else{
            $IDLivr 			= base64_decode($_POST["bookID"]);
            $OrdreChap 			= $_POST["listIDsTest"];
            $typeImp 			= base64_encode($_POST["typeQCM"]);
            //print_r($OrdreCat);
            //log_message('error' , $OrdreChap);

            $listIDS = "";
            foreach ($OrdreChap as $key=>$titleChap){
                if(trim($titleChap) != ''){
                    $listIDS = $listIDS.";;".$titleChap ;
                    //print_r(base64_decode($titleChap));
                    //print_r('<br>');

                }
            }
            $listIDS = base64_encode($listIDS);
            $arr_Res[] = array("id" => '1', "desc" => "", "typeImp"=> $typeImp ,  "listIDS"=>$listIDS) ;
        }

        echo json_encode($arr_Res);
        exit;
    }

    public function ajax_QuestionTypeTest_list()
    {

        $data = array();
        $d_arr = array();

        $typeQ   	= $_POST["typeQ"];
        $idChap  	= $_POST["typeC"];
        $listDIS  	= $_POST["listDIS"];
        $typeImp  	= base64_decode($_POST["typeImp"]);
        $listDIS	= base64_decode($listDIS);
        $listProp1	= explode(";;",$listDIS);
        $listChaps  = 0 ;
        foreach ($listProp1 as $num =>$onRes)
        {
//			log_message('error', "eeeeeeeeeeeeeee>>>>>".base64_decode($onRes));
//			$number = rand(1, 20);
//			if ($number % 2 == 0) {
//				log_message('error', "PAIR>>>>>".$number);
//			}else{
//				log_message('error', "IMAPIR>>>>>".$number);
//			}
            if(base64_decode($onRes)!=''){$listChaps = $listChaps.','.base64_decode($onRes);}

        }
        /*
        $rowss 	= array();

        $a = range(1,1000);
        array_walk($a,function($v){if($v%2){
            log_message('error', "<<<<<<<<<<<<<<<<<<<<<<<<<<<<".$v,"<br/>");
            $row[]  = $v;
        }});
        //$datas[] = $rowss;
        //$key = array_rand($datas);
        //log_message('error', "<<<<<<<<<<<<<<<<<<<<<<<<<<<<".$key,"<br/>");
        $array = [1,2,3,4,5,6,7,8,9,10];
        for($i = 0; $i < 5; $i++) {
            $key = array_rand($array);
            log_message('error', "AAAAAAAAAAAAAAAAAAAAAAAAAa".$key,"<br/>");
        }
        */
        $d_arr[] = $typeQ;
        $d_arr[] = $listChaps;
        //log_message('error', "AAAAAAAAAAAAAAAAAAAAAAAAAa".base64_decode($onRes),"<br/>");
        $this->db->select('*');
        $this->db->from('_chapitre');
        $this->db->Where("IDChapitre = '$idChap' LIMIT 1 ");
        $resResum = $this->db->get()->result_array();
        if($typeQ=='Qroc'){
            $TitreQ = $resResum[0]["TitreQroc"];
        }else{
            $TitreQ = $resResum[0]["TitreQcm"];
        }
        /*
        $rowssxx 	= array();
        $list = $this->QuestionType_model->get_datatables($d_arr);
        log_message('error', "QQQQQQQQQQQQQQQQQQQQQQQQQQQQQQQQqqqq".count($list),"<br/>");
        $a = range(1,count($list));
        array_walk($a,function($v){if($v%2){
            log_message('error', "RRRRRRRRRRRRRRRRRRRRRRRRRR".$v,"<br/>");
        }});
*/
        $list = $this->QuestionTypeTest_model->get_datatables($d_arr);

        $cmpt 	= 0;
        $i 		= 1;
        $chin 	= ';';
        $evenodd 	= '';
        while($i<count($list) && $cmpt<20) {
            $evenRandomNb 		= rand(0, round((count($list)), 1, PHP_ROUND_HALF_UP))  ;
            if($evenRandomNb % 2 == 0 && ($typeImp == 1 || $typeImp == 3)){
                //log_message("error" , "////////pair//////////////". $evenRandomNb );
                $evenodd = $evenRandomNb;
            }
            if($evenRandomNb % 2 != 0 && ($typeImp == 2 || $typeImp == 3)){
                //log_message("error" , "////////imppair//////////////". $evenRandomNb );
                $evenodd = $evenRandomNb;
            }

            if($evenodd>0){
                if (strpos($chin, ';'.$evenodd.';')===false) {
                    $chin = $chin.$evenodd.';';
                    //log_message('error', "GGGGGGGGG ".$evenRandomNb);
                    $cmpt++;
                }
            }
            $i++;
        }

        //log_message('error', "GGGGGGGGG ".$chin);
        $cmpo = 1 ; $cuntCMP = 1;
        foreach ($list as $sort_row) {

            if (strpos($chin, ';'.$cmpo.';')!==false) {
                //log_message('error', "SSSSSSSSSSSSSS ".$cmpo);
                $row 	= array();
                $id 	= $sort_row->id;
                $name 	= $sort_row->name;
                $skill	= $sort_row->skill;
                $respo	= $sort_row->ResponseQuestion;
                $proposition1	= $sort_row->proposition1;
                $proposition2	= $sort_row->proposition2;

                $oldNBR = substr($name, 0, strpos($name, "-"));
                if(strpos($name, "-")!==false)
                {
                    $name   = str_replace("$oldNBR-","$cuntCMP- ",$name);
                }else{
                    $name   = $cuntCMP."- ".$name;
                }

                $typeCh 	=  "";
                $typeResp 	=  "";

                if($sort_row->type =='text') {

                    //$typeCh = $typeCh."<div class='col-12 col-md-6 col-lg-6' id='setResp' style='visibility:visible; '><div class='mb-2'><h3>Réponse</h3></div>	<div style='relative: absolute;height: 0px;'><textarea  name='getInfTXT' id='getInfTXT' class='form-control' rows='7'  readonly style='resize:none;' >$respo</textarea></div> <div style='position: relative;height: 177px;'><button id='bt_resp' class='btn btn-primary' style='height: 100%;width: 100%;' onclick='myFunction()'>Découvrir la réponse</button></div></div></div>" ;

                    if($proposition1==''){
                        $respo	= str_replace("<br><br>","",$respo);
                        $respo	= "<i id='indc' class='align-middle mr-0 fas fa-fw fa-circle'></i>".str_replace("<br>","<br><i id='indc' class='align-middle mr-0 fas fa-fw fa-circle'></i>",$respo);

                        $typeCh ="<div class='row' style='background-color: white;'> <div class='col-12 col-md-6 col-lg-6'><div class='mb-2'><h3>".$this->lang->line('essaie')."</h3></div>	<textarea  onclick='setFCS($id)'  name='setInf-$id' id='setInf-$id' class='form-control' rows='13' style='resize:none;' >

</textarea> </div>" ;
                        $typeCh =$typeCh."	<input type='hidden' name='setID[]' id='setID[]' value='$id'  />" ;
                        $typeCh = $typeCh."<div class='col-12 col-md-6 col-lg-6' id='setResp' style='visibility:visible; '><div class='mb-2'><h3>".$this->lang->line('reponse')."</h3></div>	<div style='relative: absolute;height: 0px;'><div style='height: 17em;overflow: auto;border: 1px solid #ced4da; text-align: left;padding-left: 0.5em;' class='col-12 col-md-12 col-lg-12'>$respo</div></div> <div style='position: relative;height: 17em;' id='setKeyResp' ><button  class='btn btn-primary' style='height: 100%;width: 100%;' ><i class='fa fa-eye-slash'></i></button></div></div></div>" ;
                    }else{
                        $typeCh ="<div class='row'> <div class='col-12 col-md-6 col-lg-6'><div class='mb-2'><h3>".$this->lang->line('proposition1')."</h3></div>	<textarea  name='setInf-$id' id='setInf-$id' class='form-control' rows='8' style='resize:none;' >$proposition1</textarea> </div>" ;
                        $typeCh =$typeCh."	<input type='hidden' name='setID[]' id='setID[]' value='$id'  />" ;
                        $typeCh = $typeCh."<div class='col-12 col-md-6 col-lg-6' id='setResp' style='visibility:visible; '><div class='mb-2'><h3>".$this->lang->line('proposition2')."</h3></div>	<div><textarea  name='setInf-$id' id='setInf-$id' class='form-control' rows='8' style='resize:none;' >$proposition2</textarea></div> </div></div>" ;
                        $typeCh = $typeCh."<div class='row'><div class='col-12 col-md-12 col-lg-12' id='setResp' style='visibility:visible; '><div class='mb-2'><h3>".$this->lang->line('reponse')."</h3></div>	<div style='relative: absolute;height: 0px;'><div style='height: 17em;overflow: auto;border: 1px solid #ced4da;' class='col-12 col-md-12 col-lg-12'><textarea  name='setInf-$id' id='setInf-$id' class='form-control' rows='8' style='resize:none;' >$respo</textarea></div></div> <div style='position: relative;height: 17em;' id='setKeyResp' ><button  class='btn btn-primary' style='height: 100%;width: 100%;' ><i class='fa fa-eye-slash'></i></button></div></div></div>" ;

                    }


                }

                ///////////************QCM*********\\\\\\\\\\
                if($sort_row->type =='checkbox') {

                    $typeCh ="<div class='row'><div class='col-12 col-md-12 col-lg-12'>	<input type='hidden' name='setID[]' id='setID[]' value='$id'  />" ;
                    $sel = explode("@||@", $skill);
                    foreach ($sel as $va) {
                        $typeResp = '';
                        $typeINDC = '';
                        $typeCh = $typeCh." <div> <label class='form-check'  style='text-align: left;margin-bottom: 0rem;' id='setInfLab' >" ;

                        if(in_array($va,explode("@||@",$respo))) {
                            $typeResp = "setInf";//"setInf-$id";
                            //$typeINDC = "<span id='indCT' class='fas fa-circle' style='float:right; color: green ; visibility: hidden'></span>";
                            $typeINDC = "<span id='indCT'  style='float:right; color: green ; visibility: hidden ; font-weight: bold ; font-size: 0.99em;'>".$this->lang->line('oui')."</span>";
                            $typeCh = $typeCh."	<input type='checkbox' name='setValTEST' id='setValTEST_$id' value='true' data-setTST='true' style='transform: scale(0.7);' class='form-check-input'/>" ;

                        }else{
                            $typeResp = '';
                            //$typeINDC = "<span id='indCT' class='fas fa-circle' style='float:right; color: red ; visibility: hidden'></span>";
                            $typeINDC = "<span id='indCT'  style='float:right; color: red ; visibility: hidden ; font-weight: bold ; font-size: 0.99em; '>".$this->lang->line('non')."</span>";
                            $typeCh = $typeCh."	<input type='checkbox' name='setValTEST' id='setValTEST_$id' value='false' data-setTST='false' style='transform: scale(0.7);' class='form-check-input'/>" ;

                        }

                        $typeCh = $typeCh." <span class='form-check-label' style='font-size: 1.1em;' id='$typeResp'>$va</span>".$typeINDC."</label>" ;
                        $typeCh = $typeCh." </div><hr>" ;

                        $typeCh = $typeCh;
                    }
                    $typeCh = $typeCh." </div></div>" ;
                }
                //$blocStart 	= "<div class='col-sm-6 mb-3 mb-md-0' style='height: 400px;'><div class='card text-center h-100'><div class='card-body d-flex flex-column'>";
                //$blocStart 	= "<div class='lead text-center mb-4' style='height: 400px;'><div class='card text-center'><div class='card-body d-flex flex-column'>";
                $blocEnd 	= "</div>	</div>	</div>";
                if($TitreQ ==''){
                    $blocQ 		= "<div id='quest_' data-quest='$id' class='lead text-center mb-4' style='font-weight: bold;margin-bottom: 0.7rem !important;margin-top: 0.5em; font-size: 1.4em' >".$name."</div><h4 style='display: none' id='titleQ'></h4>";

                }else{
                    $blocQ 		= "<div id='quest_' data-quest='$id' class='lead text-center mb-4' style='display: none'><h4 style='color: green;' id='titleQ'>$TitreQ</h4></div>".'<br>'."<div class='lead text-center mb-4' style='font-weight: bold;margin-bottom: 0.7rem !important;margin-top: 0.5em; font-size: 1.4em'>".$name."</div>";
                }
                if($typeQ=='Qroc'){

                    $blocStart 	= "<div class='lead text-center mb-2' ><div class='card text-center' style='margin-bottom: 0.5em;background-color: #f7f7f7;'><div class='card-body d-flex flex-column' style='padding: 0.1rem;'>";
                    if($cuntCMP==$cmpt) {
                        $blocR =  	$blocStart.$typeCh.$blocEnd."<div class='mb-1' style='text-align: center;padding-top: 1em;'><p id='setKeyResp' class='text-primary' style='display: inline; visibility: hidden'><i style='color: red'>Solution :</i> $sort_row->ResponseKey</p><button  style='display: inline;' class='btn btn-primary' onclick='myFunction($id)'>" . $this->lang->line('voir_respons')  . "</button></div>" . $blocEnd;
                    }else{
                        $blocR = 	$blocStart.$typeCh.$blocEnd;
                    }
                }else{
                    $blocStart 	= "<div class='lead text-center mb-2' ><div class='card text-center' style='margin-bottom: 0.5em;'><div class='card-body d-flex flex-column'>";

                    //	$blocR 		= $blocStart."<div class='mb-4'><h3>Votre réponse</h3></div>".$typeCh."<div class='mb-3'><p class='text-primary'>T-primary c</p><button  class='btn btn-primary' onclick='myFunction()'>Voir solution</button></div>".$blocEnd;
                    if($cuntCMP==$cmpt) {
                        $blocR = $blocStart . $typeCh . "<div class='mb-1' style='padding-top: 1em;'><p id='setKeyResp' class='text-primary' style='display: inline; visibility: hidden'><i style='color: red'>Solution :</i> $sort_row->ResponseKey</p><br><br><button  style='display: inline;' class='btn btn-primary' onclick='myFunction($id)'>" . $this->lang->line('voir_respons')  . "</button></div>" . $blocEnd;
                    }else{
                        $blocR = $blocStart . $typeCh . "<div class='mb-1' style='padding-top: 1em;'><i  style='display: inline;'>"  . "</i><p id='setKeyResp' class='text-primary' style='display: inline; visibility: hidden'><i style='color: red'>Solution :</i> $sort_row->ResponseKey</p></div>" . $blocEnd;
                    }
                }

                $blocC 		= "";//$blocStart."<div class='mb-4'><h3>Solution</h3></div>".$typeResp.$blocEnd;

                $row[] = "<div class='row py-1' style='background-color: white;'>".$blocQ.$blocR.$blocC."</div>";

                $data[] = $row;
                $cuntCMP ++;
            }
            $cmpo++;


        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" 		=> $this->QuestionTypeTest_model->count_filtered($d_arr),
            "recordsFiltered" 	=> $this->QuestionTypeTest_model->count_filtered($d_arr),
            "data" => $data,

        );

        echo json_encode($output);
    }

    public function evaluatQROC($id,$listDIS,$typeImp)
    {
        $id 		= base64_decode($id);

        $this->db->select('*');
        $this->db->from('_livre , _theme');
        $this->db->Where("IDLivre = '$id' AND _theme.IDTheme = _livre.IDTheme");
        $resBook = $this->db->get()->result_array();

        $idLivr 			= $resBook[0]["IDLivre"];
        $listChap 			= $this->listChaptCours($idLivr);

        $arr['listChap'] 	= $listChap;
        $arr['typeImp'] 	= $typeImp;
        $arr['OneBook'] 	= $resBook;
        $arr['listDIS'] 	= $listDIS;
        $arr['page'] 		= 'evaluatQROC';
        $arr['listCat'] 	= $this->getListCategory();
        //$this->load->view('evaluatQROC',$arr);
        $this->load->view($this->getTypePlatform() ? 'v1_evaluatQROC' : 'evaluatQROC', $arr);
    }

    public function set_testFigure(){

        $desc =  '' ;//$newTitre;
        
        if(!isset($_POST["bookID"]) || !isset($_POST["listIDsTest"]) ){
            $arr_Res[] = array("id" => '-1', "desc" => $this->lang->line('testPopErr')) ;
        }else{
            $IDLivr 			= base64_decode($_POST["bookID"]);
            $OrdreChap 			= $_POST["listIDsTest"];
           //print_r($OrdreCat);
            //log_message('error' , $OrdreChap);

            $listIDS = "";
            foreach ($OrdreChap as $key=>$titleChap){
                if(trim($titleChap) != ''){
                    $listIDS = $listIDS.".".$titleChap ;
                    //print_r(base64_decode($titleChap));
                    //print_r('<br>');

                }
            }
            $listIDS = substr($listIDS, 1);
            $arr_Res[] = array("id" => '1', "desc" => "",  "listIDS"=>$listIDS) ;
        }

        echo json_encode($arr_Res);
        exit;
    }

    public function set_testQROCChap(){

        $desc =  '' ;//$newTitre;
        if(!isset($_POST["bookID"]) || !isset($_POST["listIDsTest"]) ){
            $arr_Res[] = array("id" => '-1', "desc" => $this->lang->line('testPopErr')) ;
        }else{
            $IDLivr 			= base64_decode($_POST["bookID"]);
            $OrdreChap 			= $_POST["listIDsTest"];
            $typeImp 			= base64_encode($_POST["typeQCM"]);
            //print_r($OrdreCat);
            //log_message('error' , $OrdreChap);

            $listIDS = "";
            foreach ($OrdreChap as $key=>$titleChap){
                if(trim($titleChap) != ''){
                    $listIDS = $listIDS.";;".$titleChap ;
                    //print_r(base64_decode($titleChap));
                    //print_r('<br>');

                }
            }
            $listIDS = base64_encode($listIDS);
            $arr_Res[] = array("id" => '1', "desc" => "", "typeImp"=> $typeImp ,  "listIDS"=>$listIDS) ;
        }

        echo json_encode($arr_Res);
        exit;
    }
    ///*****END TEST EVALUATION*********////

    public function contactUS(){

        $lang = $this->session->userdata('site_lang');
        if($lang==''){$lang='FR';}

        $arr['page'] 		= 'contactUS';
        $this->load->view('contactUS',$arr);
    }
    public function contactUS_process() {

        $errMsg 		= '';
        $email 			= $_POST["inputEmail"];

        $name 		= $_POST["inputName"];
        $LastName 	= $_POST["inputPren"];
        $cg 		= $_POST["inputCG"];
        $messg		= $_POST["inputMssg"];

        if(strlen(trim($email))==0){ 	$errMsg = $errMsg.'- '.$this->lang->line('email').' <br>';}
        if(strlen(trim($name))==0){ 	$errMsg = $errMsg.'- '.$this->lang->line('name').' <br>';}
        if(strlen(trim($LastName))==0){ $errMsg = $errMsg.'- '.$this->lang->line('lastname').' <br>';}
        if(strlen(trim($cg))==0){ $errMsg = $errMsg.'- '.$this->lang->line('lastname').' <br>';}
        if(strlen(trim($messg))==0){ $errMsg = $errMsg.'- '.$this->lang->line('lastname').' <br>';}

        if($errMsg==''){

//			  if(filter_var($user, FILTER_VALIDATE_EMAIL)){
//				  echo "L'adresse e-mail est valide";
//			  }else{
//				  echo "L'adresse e-mail n'est pas valide";
//			  }

            $arr 		= array();

            $this->db->select('*');
            $this->db->from('_params');
            $this->db->Where("Libelle_Params = 'EmailReception' ");
            $resParamsS = $this->db->get()->result_array();

            $this->db->select('*');
            $this->db->from('_params');
            $this->db->Where("Libelle_Params = 'EmailReception' ");
            $resParamsR = $this->db->get()->result_array();

            if(count($resParamsR) > 0){

                $EmailReception 	= $resParamsR[0]["Value_Params"];
                $EmailSend		 	= $resParamsS[0]["Value_Params"];
                $tilte_OBJ          = "[CONTACT] - ".$cg ;
                $data = array(
                    'name' 				=> $name ,
                    'lastname' 			=> $LastName ,
                    'Email' 			=> $email ,
                    'title' 			=> $tilte_OBJ ,
                    'message' 			=> $messg ,
                    'EmailSend' 		=> $EmailSend ,
                    'EmailReception' 	=> $EmailReception ,
                    'consulte' 			=> false ,
                    "CREATEDDATE"    	=> date('Y-m-d'),
                    "CREATEDHOURS"   	=> date('H:i')
                );
                $this->db->insert('_contacts', $data);

                $config = Array(
                    'mailtype'  => 'html',
                    'charset'   => 'UTF-8'
                );
                $this->load->library('email', $config);
                // $this->load->library('email');

                $mail = $this->email;
                $mail->from($EmailSend, $EmailSend); //$mail->from('noreply@accessanatomy.com', "Accessanatomy");
                $mail->to($EmailReception);
                $mail->cc($email);
                $mail->subject($cg);

                $message = "<table width='80%' border='0'>";

                $message .= "<tr><td>$messg<br><br></td></tr>";

                $message .= "</table>";

                $mail->message($message);

                $sent = $mail->send();

                //This is optional - but good when you're in a testing environment.
                if(isset($sent)){
                    $arr[] = array("id" => '1', "desc" => $this->email->print_debugger());
                }else{
                    $arr[] = array("id" => '-1', "desc" => 'It did not send. <br>'.$this->email->print_debugger());
                }

            }else{ $arr[] = array("id" => '-1', "desc" => "PARAMS NOT FOUND >>> ".'<br>'); }

        }else{ $arr[] = array("id" => '-1', "desc" => $this->lang->line('mail_msg_ch').'<br>'.$errMsg); }

        echo json_encode($arr);
        exit;

    }


    public function contactUS_process2() {

        $errMsg 		= '';
        $email 			= $_POST["inputEmail"];

        $name 		= $_POST["inputName"];
        $messg		= $_POST["inputMssg"];

        if(strlen(trim($email))==0){ 	$errMsg = $errMsg.'- '.$this->lang->line('email').' <br>';}
        if(strlen(trim($name))==0){ 	$errMsg = $errMsg.'- '.$this->lang->line('name').' <br>';}
        if(strlen(trim($messg))==0){ $errMsg = $errMsg.'- '.$this->lang->line('lastname').' <br>';}

        if($errMsg==''){

//			  if(filter_var($user, FILTER_VALIDATE_EMAIL)){
//				  echo "L'adresse e-mail est valide";
//			  }else{
//				  echo "L'adresse e-mail n'est pas valide";
//			  }

            $arr 		= array();

            $this->db->select('*');
            $this->db->from('_params');
            $this->db->Where("Libelle_Params = 'EmailReception' ");
            $resParamsS = $this->db->get()->result_array();

            $this->db->select('*');
            $this->db->from('_params');
            $this->db->Where("Libelle_Params = 'EmailReception' ");
            $resParamsR = $this->db->get()->result_array();

            if(count($resParamsR) > 0){

                $EmailReception 	= $resParamsR[0]["Value_Params"];
                $EmailSend		 	= $resParamsS[0]["Value_Params"];
                $tilte_OBJ          = "[CONTACT]";
                $data = array(
                    'name' 				=> $name ,
                    'Email' 			=> $email ,
                    'title' 			=> $tilte_OBJ ,
                    'message' 			=> $messg ,
                    'EmailSend' 		=> $EmailSend ,
                    'EmailReception' 	=> $EmailReception ,
                    'consulte' 			=> false ,
                    "CREATEDDATE"    	=> date('Y-m-d'),
                    "CREATEDHOURS"   	=> date('H:i')
                );
                $this->db->insert('_contacts', $data);

                $config = Array(
                    'mailtype'  => 'html',
                    'charset'   => 'UTF-8'
                );
                $this->load->library('email', $config);
                // $this->load->library('email');

                $mail = $this->email;
                $mail->from($EmailSend, $EmailSend); //$mail->from('noreply@accessanatomy.com', "Accessanatomy");
                $mail->to($EmailReception);
                $mail->cc($email);
                $mail->subject(' ');

                $message = "<table width='80%' border='0'>";

                $message .= "<tr><td>$messg<br><br></td></tr>";

                $message .= "</table>";

                $mail->message($message);

                $sent = $mail->send();

                //This is optional - but good when you're in a testing environment.
                if(isset($sent)){
                    $arr[] = array("id" => '1', "desc" => $this->email->print_debugger());
                }else{
                    $arr[] = array("id" => '-1', "desc" => 'It did not send. <br>'.$this->email->print_debugger());
                }

            }else{ $arr[] = array("id" => '-1', "desc" => "PARAMS NOT FOUND >>> ".'<br>'); }

        }else{ $arr[] = array("id" => '-1', "desc" => $this->lang->line('mail_msg_ch').'<br>'.$errMsg); }

        echo json_encode($arr);
        exit;

    }

    // Controller method to fetch social media links
    public function get_social_links() {
        // Fetch social media links from the database (instead of hardcoding)
        $this->db->select('Libelle_Params, Value_Params');
        $this->db->from('_params');
        $this->db->like('Libelle_Params', 'social_'); // Get all social media links
        $resParams = $this->db->get()->result_array();

        // Prepare the social links array and set them in session
        $socialLinks = [];
        foreach ($resParams as $row) {
            // Store each social link with the 'Libelle_Params' as the key
            $socialLinks[$row['Libelle_Params']] = $row['Value_Params'];
        }

        // Set session data for social media links
        foreach ($socialLinks as $key => $url) {
            $this->session->set_userdata($key, $url);
        }
    }

    public function get_social_linksJSON() {

//		// Query the database for all parameters where 'Libelle_Params' starts with 'social_'
//		$this->db->select('Libelle_Params, Value_Params'); // Assuming 'Value_Params' holds the URLs
//		$this->db->from('_params');
//		$this->db->like('Libelle_Params', 'social_'); // Select all entries where Libelle_Params starts with 'social_'
//
//		$resParams = $this->db->get()->result_array();
//
//		// Prepare the response
//		$socialLinks = [];
//		foreach ($resParams as $row) {
//			// Store each social link with the 'Libelle_Params' as the key
//			$socialLinks[$row['Libelle_Params']] = $row['Value_Params'];
//		}
//
//		// Return the social media links as JSON
//		echo json_encode($socialLinks);
    }

public function set_LivSousChap()
{
    // Récupération correcte du JSON brut
    $inputJSON = file_get_contents('php://input');
    $data = json_decode($inputJSON, true);

    $IDLivr = $data['bookID'] ?? null;
    $OrdreChap = $data['chapters'] ?? [];

    log_message('debug', 'Chapitres reçus: ' . print_r($OrdreChap, true));

    $arr_Res = [];

    foreach ($OrdreChap as $chap) {
        // Cas 1 : ajout depuis "modal sous chapitre"
        if (isset($chap['idChap'])) {
            $idChap = $chap['idChap'];
        } else {
            // Cas 2 : ajout d’un nouveau chapitre
            $titreChap = trim($chap['titreChap'] ?? '');
            if ($titreChap === '') continue;

            $this->db->select('*')
                     ->from('_chapitre')
                     ->where('TitreChapitre', $titreChap)
                     ->where('IDLivre', $IDLivr);
            $resC = $this->db->get()->result_array();

            if (!empty($resC)) {
                $idChap = $resC[0]['IDChapitre'];
            } else {
                $dataChap = [
                    'TitreChapitre' => $titreChap,
                    'IDLivre' => $IDLivr
                ];
                $idChap = $this->insert_dd('_chapitre', $dataChap);
            }
        }

        if (isset($chap['sousChaps']) && is_array($chap['sousChaps'])) {
            foreach ($chap['sousChaps'] as $sTitre) {
                $sTitre = trim($sTitre);
                if ($sTitre === '') continue;

                $this->db->select('*')
                         ->from('_souschapitre')
                         ->where('TitreSousChapitre', $sTitre)
                         ->where('IDChapitre', $idChap)
                         ->where('IDLivre', $IDLivr);

                $resSC = $this->db->get()->result_array();

                if (empty($resSC)) {
                    $dataSC = [
                        'TitreSousChapitre' => $sTitre,
                        'IDChapitre'        => $idChap,
                        'IDLivre'           => $IDLivr
                    ];
                    $this->insert_dd('_souschapitre', $dataSC);
                }
            }
        }
    }

    $arr_Res[] = [
        "id"   => 1,
        "desc" => "Sous-chapitres ajoutés avec succès"
    ];

    $this->output->set_content_type('application/json');
    echo json_encode($arr_Res);
    exit;
}
public function get_SousChapitres()
{
    $data = json_decode($this->input->raw_input_stream, true);
    $idChap = isset($data['idChap']) ? $data['idChap'] : null;

    if (!$idChap) {
        echo json_encode([
            ['id' => '0', 'desc' => 'IDChapitre manquant']
        ]);
        return;
    }

    // Récupère tous les sous-chapitres du chapitre
    $this->db->select('*');
    $this->db->where('IDChapitre', $idChap);
    $this->db->order_by('IDSousChapitre', 'ASC');
    $query = $this->db->get('_souschapitre');
    $sousChaps = $query->result_array();

    echo json_encode($sousChaps); // ⚠ ici on renvoie juste le tableau pour le JS
}

}