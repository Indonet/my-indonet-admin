<?php
class Dashboard_model extends CI_Model{	
	  function __construct(){
        parent::__construct();     
  	}
    function get_where_data($tabel_name, $where, $orderBy = '', $sort='',$limit = 100000){
        $query = $this->db->get_where($tabel_name, $where);
        if($orderBy != ''){
            $query = $this->db->order_by($orderBy, $sort)->limit($limit)->get_where($tabel_name, $where);
        }
        $result = $query->result_array();
        return $result;
    }
    function get_where_custlist($tabel_name, $where){          
        $this->db->select('*');
        $this->db->where_in('cust_subnet_code', $where); 
        $query = $this->db->get($tabel_name);

        $result = $query->result_array(); // as array
        return $result;  
    }
    function get_all_data($tabel_name){
        $query = $this->db->get($tabel_name); 
        $result = $query->result_array();
        return $result;
    }
    function get_where_data_row($tabel_name, $where, $orderBy='', $sort=''){
        $query = $this->db->get_where($tabel_name, $where);
        if($orderBy != ''){
            $query = $this->db->order_by($orderBy, $sort)->get_where($tabel_name, $where);
        }
        $result = $query->row_array();
        return $result;
    }   
    function get_where_data_limit($tabel_name, $where, $orderBy = '', $sort='',$limit = 10){
        $query = $this->db->get_where($tabel_name, $where);
        if($orderBy != ''){
            $query = $this->db->order_by($orderBy, $sort)->limit($limit)->get_where($tabel_name, $where);
        }
        $result = $query->result_array();
        return $result;
    }
    function update_db($tabel_name, $where, $postData){      
        $this->db->where($where);
        $this->db->update($tabel_name, $postData);
        $result = TRUE;
        return $result; 
    }
    function add_db($tabel_name, $postData){           
        $this->db->insert($tabel_name, $postData);  
        return $this->db->insert_id();
    }
    function get_company_list($searchTerm=""){
        // Fetch users
        $this->db->select('*');
        $this->db->where("cust_name like '%".$searchTerm."%' ");
        $fetched_records = $this->db->get('ax_customer_group');
        $users = $fetched_records->result_array();
   
        // Initialize Array with fetched data
        $data = array();
        foreach($users as $user){
           $data[] = array("id"=>$user['id'], "cust_name"=>$user['cust_name'], 'cust_data'=>$user['cust_data']);
        }
        return $data;
     }
     function get_where_data_payment($periode, $subnet_list){
        $this->db->select("*, ax_customer_list.cust_name as cust_name, ax_customer_list.cust_subnet_name as cust_subnet");
        $this->db->from("inv_payment");
        $this->db->join("ax_customer_list", "ax_customer_list.cust_id = inv_payment.cust_id", "LEFT");   
        $this->db->where("inv_payment.periode", $periode); 
        $this->db->where_in('ax_customer_list.cust_subnet_code', $subnet_list); 
        $result_array = $this->db->get()->result_array(); 
        return $result_array;  
     }
}