<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Users_model extends CI_Model {
 
    var $table = 'users';
    var $column_order = array('login','Nom','Prenom','Adresse1','CodePostal','Ville','Email', 'Telephone' ,'createdate');
    var $column_search = array('login','Nom','Prenom','Adresse1','CodePostal','Ville','Email', 'Telephone' ,'createdate');
    var $order = array('users_ID' => 'asc'); // default order
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
    private function _get_datatables_query(array $d_arr = NULL)
    {
		$wrclause = ' 1=1 ';
		if($d_arr[0]<> ''){$wrclause = $wrclause." AND Niveau ='".$d_arr[0] ."'";}
		if($d_arr[1]<> ''){$wrclause = $wrclause." AND CodePostal ='".$d_arr[1] ."'";}
		if($d_arr[2]<> ''){$wrclause = $wrclause." AND Ville ='".$d_arr[2]."' ";}
		if($d_arr[3]<> ''){$wrclause = $wrclause." AND Email ='".$d_arr[3]."' ";}
		if($d_arr[4]<> ''){$wrclause = $wrclause." AND Telephone ='".$d_arr[4]."' ";}
		if($d_arr[5]<> ''){$wrclause = $wrclause." AND Nom ='".$d_arr[5]."' ";}
		if($d_arr[6]<> ''){$wrclause = $wrclause." AND Prenom ='".$d_arr[6]."' ";}
		$this->db->from($this->table);
		$this->db->where($wrclause);
        $i = 0;
     
        foreach ($this->column_search as $item) // loop column 
        {
            if($_POST['search']['value']) // if datatable send POST for search
            {
                 
                if($i===0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
 
                if(count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
         
        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
 
    function get_datatables(array $d_arr = NULL)
    {

        $this->_get_datatables_query($d_arr);
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
 
}

?>
