<?php
use Restserver\Libraries\REST_Controller;

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

//include Rest Controller library
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class SuiviWS extends REST_Controller
{

    public function __construct()
    {
        parent::__construct();

        //load suivi model

        $this->load->model('api/SuiviWS_model', 'suivi');
    }

	public function GetFromMySql_post()
	{
		$dataMezidx = array();log_message('error',"eeeeeeeeeeeeeeeeeeeeeeeee : ");
		$dataMezidx = json_decode($this->post('dataMezidx'), true);

		if ($dataMezidx["Type"] == "select") {
			$respMezidx = $this->suivi->getMezidx($dataMezidx["requete"]);
		}
		//check if the result data exists
		if (!empty($respMezidx)) {
			$this->response($respMezidx, REST_Controller::HTTP_OK);
		} else {
			//set the response and exit
			$this->response(
				[
					'OK' => false,
					'reponse' => 'DB FATAL ERROR.',
				], REST_Controller::HTTP_NOT_FOUND
			);
		}
	}


}
