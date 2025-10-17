<?php
//defined('BASEPATH') OR exit('No direct script access allowed');
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
     
class Users extends CI_Controller {
 
    public function __construct()
    {
        parent::__construct();        

        $this->load->model('Users_model','users');
        $this->load->model('Users_log','userslog');
    }
 
    public function index()
    {
	      $this->load->helper('url');

        $arr['page'] = 'users';
        $this->load->view('users_view', $arr);   
    }
 
    public function ajax_list()
    {
    
        $list = $this->users->get_datatables();
        $data = array();
        $no = 0;//$_POST['start'];
        foreach ($list as $customers) {

            $row = array();
            $row[] = $customers->login;
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->users->count_all(),
                        "recordsFiltered" => $this->users->count_filtered(),
                        "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }
    
    
    public function ajax_list_logs()
    {
    
        $list = $this->userslog->get_datatables();
        $data = array();
        // $no = $_POST['start'];
        foreach ($list as $customers) {
        
            // $no++;
            $row = array();
            $row[] = $login;
            //$row[] = $no;
            // $row[] = $customers->username;
            // $row[] = $customers->detail;
            // $row[] = $customers->ip_address; 
            // $row[] = $customers->date_time;    
                               
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->userslog->count_all(),
                        "recordsFiltered" => $this->userslog->count_filtered(),
                        "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }
    
    public function add_user($u = "") {  
        
        $arr["id"] = "";
        $arr["username"] = "";
        $arr["firstname"] = "";
        $arr["lastname"] = "";
        $arr["phone"] = "";
        $arr["email"] = "";
        $arr["address"] = "";
        $arr["user_type"] = "";
        $arr["readonly"] = "";
        
        if($u > 0){
        
             $this->db->select('*');
             $this->db->from('users');
             $this->db->Where("id = '$u'");
             $res = $this->db->get()->result_array();
                   
             if(count($res) > 0){    
                  
                  $arr["id"] = $u;
                  $arr["username"] = $res[0]["username"];
                  $arr["firstname"] = $res[0]["firstname"];
                  $arr["lastname"] = $res[0]["lastname"];
                  $arr["phone"] = $res[0]["phone"];
                  $arr["email"] = $res[0]["email"];
                  $arr["address"] = $res[0]["address"];
                  $arr["user_type"] = $res[0]["user_type"];
                  $arr["readonly"] = "readonly";
             
             }             
             
        }       
                
        $arr['page'] = 'ADD USER';
        $this->load->view('add_user', $arr);   
        
    }
    
    public function delete_user() {
    
        $uid = $_POST['desigid'];
        $resd = 0;
        
        if($uid > 0) {
            
            $this->db->where("id = $uid");
            $resd = $this->db->delete('users');
        
        } 
    
        print $resd;
    }
    
    public function user_form_add() {           
    
         $user_id = $_POST["user_id"];    
         $username = $_POST['user_name'];
         
         $this->db->select('*');
         $this->db->from('users');
         $this->db->Where("username = '$username'");
         $res = $this->db->get()->result_array();
               
         if(count($res) > 0 && $user_id == ""){    
            
                   print "user_exists";
                   
         }else{
         
                   $data = array(
                          'username' => $_POST['user_name'],  
                          'firstname' => $_POST['first_name'],
                          'lastname' => $_POST['last_name'],
                          'phone' => $_POST['phone'],
                          'email' => $_POST['email'],
                          'address' => $_POST['address'],
                          'user_type' => $_POST['user_type']           
                   );
                   
                   if($_POST['password'] <> ""){                 
                           $data['password'] = md5($_POST['password']);                        
                   }  
                             
                   if($user_id > 0) 
                   {
                          $this->db->where('id', $user_id);
                          $return_var = $this->db->update('users', $data);
                   } else {
                          //$this->db->set('id', $user_id);
                          $return_var = $this->db->insert('users', $data);
                   }           
                   
                   print $return_var;
                   
         }
         
    }
 
}
?>
