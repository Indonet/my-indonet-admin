<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_ax extends ALL_Controller {   
    function check_ax_login() {
        $cust_id = '0000012823';
        $date_now = date('d');  
        $year_now =  date('Y');  
        $month_now =  date('m');  
        $d_m_now = $date_now.''.$month_now; 
        $out = getCustInfoOnly($cust_id); 
        if($out){ 
            echo 'ax connected';
            return true;
        }else{
            echo 'ax disconnected';
            return false;
        }   
    }  
    function demo_post_data_ax_cust_id() { 
        $subnet_code = 'S-001';
        $cust_id = '0021719984';
        $date_now = date('d');  
        $year_now =  date('Y');  
        $month_now =  date('m');  
        $d_m_now = $date_now.''.$month_now;
        $year_array = array();
        $month_array = array();
        for ($i=2; $i >= 0; $i--) {  
            $fromyear = date("Y", strtotime("-".$i." months"));
            array_push($year_array, $fromyear);
            $frommonth = date("m", strtotime("-".$i." months"));
            array_push($month_array, $frommonth); 
        }   
        echo 'waktu mulai => '.date('Y m d H:i:s')."\n";
        $out = getCustInfoAll($cust_id, $year_now, $month_now, $year_array, $month_array);  
        print_r($out); die(); 
        
        // $ax_customer_list = $this->dashboard_model->get_where_data('ax_customer_list', array('cust_id != '=>''));
        // foreach ($ax_customer_list as $key_list => $value_list) {
        //     $list_id = $value_list['id'];
        //     $list_cust_id = $value_list['cust_id']; 
        //     $out = getCustUsernameList($list_cust_id);  
        //     $user_id_array = ''; 
        //     foreach ($out as $key => $value) {
        //         $user_id = $value['USERNAME'];
        //         if($user_id_array == ''){
        //             $user_id_array = $user_id;
        //         }else{ 
        //             $user_id_array = $user_id_array.', '.$user_id;
        //         }
        //     }
        //     $update = $this->dashboard_model->update_db('ax_customer_list', array('id'=>$list_id), array('cust_user_id'=>$user_id_array));
        //     echo 'updadte id => '.$list_id."\n"; 
        //     die();
        // }
        // print_r($ax_customer_list); die();
        // $out = getCustUsernameList($cust_id);
        // $user_id_array = '';
        // foreach ($out as $key => $value) {
        //     $user_id = $value['USERNAME'];
        //     if($user_id_array == ''){
        //         $user_id_array = $user_id;
        //     }else{ 
        //         $user_id_array = $user_id_array.', '.$user_id;
        //     }
        // }
        
        // $out = getCustTrans($cust_id);
        // $out = getInvById($cust_id);
        // print_r($user_id_array); 
        // print_r($out); die(); 
        echo 'waktu selesai => '.date('Y m d H:i:s')."\n";

    } 
    function get_data_cust_list_ax_json(){
        $subnet = $this->session->userdata('subnets'); 
        $subnet_array =  explode(',', $subnet); 
        $data_cust_list = $this->dashboard_model->get_where_custlist('ax_customer_list', $subnet_array); 
        // $data_cust_list = $this->dashboard_model->get_all_data('ax_customer_list');  
        $data = array('data'=>$data_cust_list);
        echo json_encode($data); 
    }
    function get_data_cust_list_ax() {
        $file_name_cust = 'cust_list';
        $date_now = date('d');  
        $year_now =  date('Y');  
        $month_now =  date('m');  
        $d_m_now = $date_now.''.$month_now; 
        $file_name = '/var/www/admin-my.indonet.id/files/data_ax/'.$file_name_cust.'.txt';  
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
        echo $file_data;
    }   
    function set_cust_type(){
        $user_login = $this->dashboard_model->get_where_data('user', ['CUSTID != '=>0]);
        foreach ($user_login as $key => $value) {
            $id = $value['id'];
            $cust_id = $value['CUSTID'];
            $user_details = $this->dashboard_model->get_where_data_row('ax_customer_list', ['cust_id '=>$cust_id]);
            if($user_details){
                $cust_type = $user_details['cust_type'];
                $this->dashboard_model->update_db('user', ['id'=>$id], ['cust_type'=>$cust_type]);
            } 
        }
        echo '<pre>';
        print_r($user_login);
        echo 'asd';
    }
    function set_cust_list_db(){ 
        $url_api = 'https://api-my.indonet.id/ax/renew_cust_list_ax';  
        $response = $this->curl->simple_get($url_api);   
        $res = json_decode($response, true);   
        print_r($res);
    }
}