<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SuiviWS_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

	public function getMezidx($req = "")
	{
		$query = $this->db->query($req);
		return array("OK" => true, "reponse" => $query->result());

	}

}
