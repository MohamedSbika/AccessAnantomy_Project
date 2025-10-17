<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Users_log extends CI_Model {
 
    var $table = 'user_log as l, users as u';
    var $column_order = array(null, 'u.username', 'l.user_id','l.date_time','l.detail','l.ip_address'); //set column field database for datatable orderable
    var $column_search = array('u.username', 'l.date_time','l.detail','l.ip_address'); //set column field database for datatable searchable 
    var $order = array('l.date_time' => 'desc'); // default order 
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
    private function _get_datatables_query()
    {
         
        $this->db->from($this->table);
        $this->db->where("u.id = l.user_id");
        
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
         
        if(isset($_POST['columns'][0]['search']['value']) and $_POST['columns'][0]['search']['value'] !=''){
            $this->db->like('u.username', $_POST['columns'][0]['search']['value']);
        }
        /*
        if(isset($_POST['columns'][2]['search']['value']) and $_POST['columns'][2]['search']['value'] !=''){
            $this->db->like('model_number', $_POST['columns'][2]['search']['value']);
        } 
        if(isset($_POST['columns'][3]['search']['value']) and $_POST['columns'][3]['search']['value'] !=''){
            $this->db->like('description', $_POST['columns'][3]['search']['value']);
        }
        if(isset($_POST['columns'][4]['search']['value']) and $_POST['columns'][4]['search']['value'] !=''){
            $this->db->like('stock_number', $_POST['columns'][4]['search']['value']);
        }
        if(isset($_POST['columns'][5]['search']['value']) and $_POST['columns'][5]['search']['value'] !=''){
            $this->db->like('alt_part_number', $_POST['columns'][5]['search']['value']);
        } 
        */
         
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
 
    function get_datatables()
    {
        $this->_get_datatables_query();
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
        $this->db->where("u.id = l.user_id");
        return $this->db->count_all_results();
    }
 
}

?>