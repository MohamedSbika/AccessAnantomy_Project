<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Userlog extends CI_Model {
 
   
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
    public function register_log($detail = "") {
        
              
          $user_id = $this->session->userdata("user_id");
          $ip_address = $this->input->ip_address();
          
          
          $data = array(
         
                 'user_id' => $user_id,
                 'detail' => $detail,
                 'ip_address' => $ip_address
                 
          );                        
          
          $return_var_log = $this->db->insert('user_log', $data);                        
          //print $return_var_log;
      
    }
 
}

?>