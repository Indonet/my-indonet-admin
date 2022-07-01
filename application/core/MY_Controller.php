<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class MY_Controller extends ALL_Controller {    
    public function __construct() {
        parent::__construct();    
        if ($this->session->userdata('islogin') != true) echo redirect('auth/logout');  
        $subnet = $this->session->userdata('subnets'); 
        $subnet_array =  explode(',', $subnet); 
        $this->data['data_user_login'] = $this->dashboard_model->get_where_data_row('user', array('id'=>$this->session->userdata('id'))); 
        $this->data_user_login = $this->data['data_user_login']; 
        $this->data_roles = $this->dashboard_model->get_where_data_row('admin_role', array('id'=>$this->data_user_login['role']));  
        $this->data_role = json_decode($this->data_roles['role']);  
        $this->data['data_role'] = $this->data_role;
        $this->data['data_cust_list'] = $this->dashboard_model->get_where_custlist('ax_customer_list', $subnet_array); 
        $this->data['data_subnet_count'] = $this->dashboard_model->get_where_data('subnets', array('status'=>1)); 
        $this->data['data_user_status'] = $this->dashboard_model->get_where_data('user_status', array('status'=>1)); 
        $this->data['date_now'] = date('d'); 
        $this->data['month_now'] = date('m');   
        $this->data['year_now'] = date('Y'); 
        $this->data['month_year_name_now'] = date('M Y');    
    }  
    function get_data_cust_list_ax() {
        $file_name_cust = 'cust_list';
        $date_now = date('d');  
        $year_now =  date('Y');  
        $month_now =  date('m');  
        $d_m_now = $date_now.''.$month_now; 
        $file_name = '/var/www/my.indonet.id/files/data_ax/'.$file_name_cust.'.txt';  
        if(!file_exists($file_name)){    
            $arraySubnets = array(  'S-001','S-002','S-003','S-004','S-005','S-006','S-007','S-008','S-009','S-010','S-011','S-012','S-013','S-014','S-015','S-016',
                                    'S-017','S-018','S-019','S-020','S-021','S-022');  
            $array_acc = array();        
            foreach ($arraySubnets as $key => $value) {            
                $subnet_code = $value; 
                $out = getCustAccListUnderSubnet($subnet_code);  
                if($out){  
                    $array_acc = array_merge($array_acc, $out); 
                }else{
                    redirect('auth/logout');
                } 
            } 
            if($array_acc){
                $fp = fopen('/var/www/my.indonet.id/files/data_ax/'.$file_name_cust.'.txt', 'w');
                fwrite($fp, json_encode($array_acc));
                fclose($fp);
            }  
        }  
        $file_data = file_get_contents($file_name);
        return json_decode($file_data);
    }       
    function get_data_ax_cust($cust_id, $subnet_code) {
        $date_now = date('d');  
        $year_now =  date('Y');  
        $month_now =  date('m');   
        $year_array = array();
        $month_array = array();
        for ($i=2; $i >= 0; $i--) {  
            $fromyear = date("Y", strtotime("-".$i." months"));
            array_push($year_array, $fromyear);
            $frommonth = date("m", strtotime("-".$i." months"));
            array_push($month_array, $frommonth); 
        }  
        $file_name = '/var/www/admin-my.indonet.id/files/data_ax/'.$subnet_code.'/'.$cust_id.'.txt';  
        // if($subnet_code == 'S-003'){
        //     $this->get_renew_data_ax_cust($cust_id, $subnet_code);  
        // }
        if(!file_exists($file_name)){    
            $out = getCustInfoAll($cust_id, $year_now, $month_now, $year_array, $month_array);  
            if($out){ 
                $fp = fopen($file_name, 'w');
                fwrite($fp, json_encode($out));
                fclose($fp); 
                
            }else{
                return false;
            } 
        }    
        $datetime1 = new DateTime();
        $datetime2 = new DateTime(date ("Y-m-d H:i:s", filemtime($file_name)));
        $interval = $datetime1->diff($datetime2);
        // $elapsed = $interval->format('%h hours %i minutes %s seconds');
        // echo date ("Y-m-d H:i:s", filemtime($file_name));
        $diff_hours = $interval->format('%h');
        if($diff_hours > 3){
            $this->get_renew_data_ax_cust($cust_id, $subnet_code);  
        }
        $file_data = file_get_contents($file_name);
        $ym = $year_now.''.$month_now; 
        $file_data = json_decode($file_data); 
        $file_data_array = (array)$file_data; 
        if(!isset($file_data_array['INV_MONTH_TOTAL']->$ym)){ 
            $this->get_renew_data_ax_cust($cust_id, $subnet_code);  
        }else{ 
            return $file_data; 
        }
    }   
    function get_renew_data_ax_cust($cust_id, $subnet_code) { 
        $file_name = '/var/www/admin-my.indonet.id/files/data_ax/'.$subnet_code.'/'.$cust_id.'.txt';  
        unlink($file_name);  
        $date_now = date('d');  
        $year_now =  date('Y');  
        $month_now =  date('m');   
        $year_array = array();
        $month_array = array();
        for ($i=2; $i >= 0; $i--) {  
            $fromyear = date("Y", strtotime("-".$i." months"));
            array_push($year_array, $fromyear);
            $frommonth = date("m", strtotime("-".$i." months"));
            array_push($month_array, $frommonth); 
        }  
        if(!file_exists($file_name)){   
            $out = getCustInfoAll($cust_id, $year_now, $month_now, $year_array, $month_array); 
            if($out){ 
                $fp = fopen($file_name, 'w');
                fwrite($fp, json_encode($out));
                fclose($fp);   
                $file_data = file_get_contents($file_name); 
                return json_decode($file_data);  
            }else{ 
                return false;
            } 
        }else{ 
            $file_data = file_get_contents($file_name); 
            $array =  json_decode($file_data);  
            return $array; 
        }  
    }   
    function encryptPass($password) {
        if (function_exists('password_hash')) {
            return password_hash($password, PASSWORD_DEFAULT);
        } else {
            $salt = $this->genSalt();
            return crypt($password, $salt);
        }
    } 
    function genSalt($saltType = SALTTYPE) {
        $salt = '$1$changeme$'; //default to MD5 
        switch ($saltType) {
            case SALT_BLOWFISH:
                $salt = '$2y$07$' . generateRandomString(20) . '$';
                break;
            case SALT_MD5: default:
                $salt = '$1$' . generateRandomString(8) . '$';
                break;
        }
        return $salt;
    } 
    function access_menu($menu_name){   
        if (in_array($menu_name, $this->data_role)){
            return true;
        }else{ 
            $this->buildResponse('404', 'Not Found'); 
        } 
    }
}

class AUTH_Controller extends ALL_Controller { 
    function checkPostData() {
        if ($this->input->post()) {
            return true;
        } else {
            redirect('error');
        }
    }
    function hash_login($username, $password){ 
        $userData = $this->auth_model->get_where_data_row('user', array('username' => $username));     
        if($userData){
            $isExternal = $userData['is_external']; 
            if($isExternal == 0){
                $hash_pass = $userData['password'];
                if (password_verify($password, $hash_pass)) {
                    return $userData; 
                }
                else {
                    return false;
                } 
            }else{
                $ph = new popHelper();
                $userDetail = $ph->getUserDetail($username);
        
                if ($userDetail === null) {
                    return false;
                }
        
                $popPass = $userDetail[0]['password'];
                $method = mpph::getCryptMethod($popPass);
        
                return ($popPass === mpph::getCryptedPassword($password, $popPass, $method, true));
            }
        }else{
            return false;
        } 
    }
    function get_client_ip() {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    } 
    function set_session_user($user_data){  
        $email = explode("@", $user_data['username']);
        $subnetName = '';
        $arraySession = array(  'islogin' => TRUE, 'userID' => $user_data['username'], 'id' => $user_data['id'], 'custID' => $user_data['CUSTID'],
                                'is_subnet_admin' => $user_data['is_admin'], 'is_master' => $user_data['is_master'], 'is_external' => $user_data['is_external'],
                                'userName' => $email[0], 'userData' => $user_data, 'subnets' => $user_data['subnets']); 
        $this->session->set_userdata($arraySession);  
    }
    function check_ax_login($cust_id, $subnet_code) {
        $date_now = date('d');  
        $year_now =  date('Y');  
        $month_now =  date('m');  
        $d_m_now = $date_now.''.$month_now; 
        $file_name = './files/data_ax/'.$subnet_code.'/'.$cust_id.'-'.$d_m_now.'.txt'; 
        if(!file_exists($file_name)){   
            $out = getCustInfoOnly($cust_id); 
            if($out){ 
                return true;
            }else{
                return false;
            }
        }else{ 
            return true;
        }        
    }  
}

class ALL_Controller extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->model(array('auth_model', 'dashboard_model')); 
        date_default_timezone_set("Asia/Jakarta");   
        include_once('assets/inc/axdb.php');
        include_once('assets/inc/mpph.php');
        include_once('assets/inc/v2/ezapi.php');
        include_once('assets/inc/v2/midapi.php');
    }  
    function buildResponse($code, $message, $data=''){ 
        switch ($code) {
            case 200:
                $status = 'OK';
                $res = true;
                break; 
            default:
                $status = 'NOK'; 
                $res = false;
                break;
        }  
        $generate = array('result'=>$res, 'code'=>$code, 'status'=>$status, 'message'=>$message, 'data'=>$data);    
        $this->output
                    ->set_status_header(200)
                    ->set_content_type('application/json', 'utf-8')
                    ->set_output(json_encode($generate, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
                    ->_display();
        exit;
    }
}