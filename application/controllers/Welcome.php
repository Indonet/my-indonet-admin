<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends ALL_Controller { 
    public function __construct() {
        parent::__construct();   
        if ($this->session->userdata('islogin') != true) echo redirect('auth/logout');
    }  
	public function index(){
        $this->data['content'] = 'admin/first_page';
        $this->data['title'] = 'Dashboard';
        $this->data['menu_active'] = 'dashboard';
        $this->load->view('admin/layout', $this->data); 
	}  
    function generated_data(){ 
        $file_name_cust = 'cust_list';
        $date_now = date('d');  
        $year_now =  date('Y');  
        $month_now =  date('m');  
        $d_m_now = $date_now.''.$month_now; 
        $file_name = '/var/www/my.indonet.id/files/data_ax/'.$file_name_cust.'.txt';  
        if(!file_exists($file_name)){   
            $command = "php ".FCPATH."index.php api_ax set_cust_list_ax > /dev/null &"; 
            shell_exec($command);  
            $res = array('result' => TRUE);
        }else{
            $res = array('result' => TRUE);
        } 
        echo json_encode($res);   
    }
    function check_generated_data(){
        $file_name_cust = 'cust_list';
        $date_now = date('d');  
        $year_now =  date('Y');  
        $month_now =  date('m');  
        $d_m_now = $date_now.''.$month_now;
        $file_name = '/var/www/my.indonet.id/files/data_ax/'.$file_name_cust.'.txt';  
        if(!file_exists($file_name)){     
            $res = array('result' => FALSE); 
        }else{  
            $res = array('result' => TRUE);
        }  
        echo json_encode($res);   
    }
    function demo_api(){ 
        $cust_id = '0000007526';
        $subnet_code = 'S-001';
        $type_ax = 'get_file_cust_ax';
        $url_api = 'https://api-my.indonet.id/ax';
        $post = array('type'=>$type_ax, 'cust_id'=>$cust_id, 'subnet_code'=>$subnet_code); 
        $response = $this->curl->simple_post($url_api, $post);
        print_r($response); 
    }
}
