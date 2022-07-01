<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends MY_Controller { 
    function index(){
        echo 'asd';
    }
    function get_data_cust_list_ax_json(){
        $this->access_menu('customer-list');
        $subnet = $this->session->userdata('subnets'); 
        $subnet_array =  explode(',', $subnet); 
        
        $data_cust_list = $this->dashboard_model->get_where_custlist('ax_customer_list', $subnet_array);  
        $data = array('data'=>$data_cust_list);
        echo json_encode($data); 
    }
    function get_customer_info_div(){ 
        $this->access_menu('customer-view');
        $post = $this->input->post();
        $cust_id =  $post['cust_id'];
        $subnet_code = $post['subnet_code'];  
        $this->data['data_cust'] = (array)$this->get_data_ax_cust($cust_id, $subnet_code);
        if(!$this->data['data_cust']){ 
            $this->data['data_cust'] = (array)$this->get_data_ax_cust($cust_id, $subnet_code); 
        } 
        $this->load->view('admin/customer_info', $this->data);  
    }
    function get_customer_info_page(){ 
        $this->access_menu('customer-view'); 
        $post = $this->input->post(); 
        $cust_id =  $post['cust_id']; 
        $subnet_code = $post['subnet_code'];            
        $url_api = 'https://api-my.indonet.id/ax/get_file_cust_data';
        $post = array('cust_id'=>$cust_id, 'subnet_code'=>$subnet_code); 
        $response = $this->curl->simple_post($url_api, $post); 
        $this->data['data_cust'] = json_decode($response,true);    
        $this->load->view('admin/customer_info_detail', $this->data);  
    }
    function get_customer_info_by_id(){
        $this->access_menu('customer-view'); 
        $post = $this->input->post(); 
        $cust_id =  $post['cust_id'];   
        $url_api = 'https://api-my.indonet.id/ax/get_cust_info_db';
        $post = array('cust_id'=>$cust_id); 
        $response = $this->curl->simple_post($url_api, $post);  
        $res = json_decode($response, true);      
        if($res['result']){
            $this->buildResponse(200, 'success', $res['data_cust']); 
        }else{
            $this->buildResponse(400, 'failes'); 
        }
    }
}