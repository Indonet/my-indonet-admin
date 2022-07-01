<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends ALL_Controller { 
    public function get_data_ax() { 
        $argv = $_SERVER['argv']; 
        $subnet_code = $argv[3]; 
        $cust_id = $argv[4]; 
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
        $file_name = './files/data_ax/'.$subnet_code.'/'.$cust_id.'-'.$d_m_now.'.txt'; 
        if(!file_exists($file_name)){   
            $out = getCustInfoAll($cust_id, $year_now, $month_now, $year_array, $month_array); 
            if($out){
                $fp = fopen('./files/data_ax/'.$subnet_code.'/'.$cust_id.'-'.$d_m_now.'.txt', 'w');
                fwrite($fp, json_encode($out));
                fclose($fp); 
            }else{
                // redirect('auth/logout');
            } 
        }  
        // $file_data = file_get_contents($file_name);
        // return json_decode($file_data); 
    }  
    public function set_cust_list_ax() { 
        $file_name_cust = 'cust_list';
        $date_now = date('d');  
        $year_now =  date('Y');  
        $month_now =  date('m');  
        $d_m_now = $date_now.''.$month_now; 
        $file_name = './files/data_ax/'.$file_name_cust.'-'.$d_m_now.'.txt';  
        if(!file_exists($file_name)){   
            $arraySubnets = array(  'S-001','S-002','S-003','S-004','S-005','S-006','S-007','S-008','S-009','S-010','S-011','S-012','S-013','S-014','S-015','S-016',
                                    'S-017','S-018','S-019','S-020','S-021','S-022');  
            // $arraySubnets = array(  'S-022');      
            $array_acc = array();        
            foreach ($arraySubnets as $key => $value) {            
                $subnet_code = $value; 
                $out = getCustAccListUnderSubnet($subnet_code);  
                $array_acc = array_merge($array_acc, $out);
                echo 'subnet => '.$value."\n";
            } 
            if($array_acc){
                $fp = fopen('./files/data_ax/'.$file_name_cust.'-'.$d_m_now.'.txt', 'w');
                fwrite($fp, json_encode($array_acc));
                fclose($fp);
            } 
        }else{
            echo 'file already exists';
        }
    }   
    function set_cust_info_ax(){
        $file_name_cust = 'cust_list';
        $date_now = date('d');  
        $year_now =  date('Y');  
        $month_now =  date('m');  
        $d_m_now = $date_now.''.$month_now; 
        $file_name = './files/data_ax/'.$file_name_cust.'-'.$d_m_now.'.txt';   
        $file_data = file_get_contents($file_name);
        $cust_list = json_decode($file_data);
        // $subnet_code_view = 'S-001'; // 14756 // Jakarta 
        // $subnet_code_view = 'S-002'; // 420 // Bandung - done
        // $subnet_code_view = 'S-003'; // 537 // Bogor - done
        // $subnet_code_view = 'S-004'; // 20 // Purwakarta - done
        // $subnet_code_view = 'S-005'; // 15 // Tegal - done
        // $subnet_code_view = 'S-006'; // 17 // Pekalongan - done
        // $subnet_code_view = 'S-007'; // 382 // Solo - done
        // $subnet_code_view = 'S-008'; // 740 // Surabaya - done
        // $subnet_code_view = 'S-009'; // 33 // Kediri - done
        $subnet_code_view = 'S-010'; // 189 // Malang
        // $subnet_code_view = 'S-011'; // 39 // Mataram
        // $subnet_code_view = 'S-012'; // 146 // Medan
        // $subnet_code_view = 'S-013'; // 674 // Denpasar
        // $subnet_code_view = 'S-014'; // 63 // Banjarmasin
        // $subnet_code_view = 'S-015'; // 2 // Bontang
        // $subnet_code_view = 'S-016'; // 146 // Balikpapan
        // $subnet_code_view = 'S-017'; // 2148 // Jakarta Kuncit
        // $subnet_code_view = 'S-018'; // 84 // Jakarta Noble Hs
        // $subnet_code_view = 'S-019'; // 3 // Jakarta Ra Residence
        // $subnet_code_view = 'S-020'; // 1523 data // KBPa (Kota Baru Parahyangan)
        // $subnet_code_view = 'S-021'; // 306 // Jakarta Soho Pancoran (SoPan)
        // $subnet_code_view = 'S-022'; // 630 // Neo Soho Podomoro City
        $no = 1;
        echo 'waktu mulai => '.date('Y m d H:i:s')."\n";
        foreach ($cust_list as $key => $value) {
            $cust_id = $value->ACCOUNTNUM;
            $subnet_code = $value->SALESDISTRICTID;
            $subnet_name = $value->DISTRICTNAME ;
            if($subnet_code == $subnet_code_view){
                echo 'no => '.$no.'; cust id => '.$cust_id.'; subnet => '.$subnet_code.'; subnet name => '.$subnet_name."\n";
                $this->get_data_ax_cust_id($cust_id, $subnet_code);
                $no++;
            }
        } 
        echo 'waktu selesai => '.date('Y m d H:i:s')."\n";
    }
    
    function get_data_ax_cust_id($cust_id, $subnet_code) {
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
        $file_name = './files/data_ax/'.$subnet_code.'/'.$cust_id.'-'.$d_m_now.'.txt';  
        if(!file_exists($file_name)){   
            $out = getCustInfoAll($cust_id, $year_now, $month_now, $year_array, $month_array);  
            if($out){
                $fp = fopen('./files/data_ax/'.$subnet_code.'/'.$cust_id.'-'.$d_m_now.'.txt', 'w');
                fwrite($fp, json_encode($out));
                fclose($fp); 
            }
        }else{
            echo 'file exists => '.$cust_id."\n";
        } 
        return;
    }  

    public function test_exec() {
        echo "Proc_text::Index is called at ".$this->rightnow()."<br>";
        $cust_id = '0054984211';
        $command = "php ".FCPATH."index.php api get_data_ax ".$cust_id." > /dev/null &"; 
        shell_exec($command);  
        echo "Proc_text::Index is done at ".$this->rightnow()."<br>";  
    }  
    public function rightnow() {
        $time = microtime(true);
        $micro_time = sprintf("%06d", ($time - floor($time)) * 1000000);
        $date = new DateTime(date('Y-m-d H:i:s.'.$micro_time, $time));
        return $date->format("H:i:s.u");
    }
    public function set_cust_name_report(){  
        $report_data = $this->dashboard_model->get_all_data('report');
        foreach ($report_data as $key => $value) {
            $ID = $value['ID'];
            $CUSTID = $value['CUSTID']; 
            $CUSTNAME = $value['CUST_NAME'];
            $where = array('cust_id'=>$CUSTID);
            $cust_data = $this->dashboard_model->get_where_data_row('ax_customer_list', $where);
            if($cust_data){
                $cust_name = $cust_data['cust_name'];
                $cust_knownas = $cust_data['cust_knownas'];
                $cust_subnet_code = $cust_data['cust_subnet_code'];
                $cust_subnet_name = $cust_data['cust_subnet_name'];
                if($CUSTNAME == ''){
                    $where_update = array('ID'=>$ID);
                    $post_data = array('CUST_NAME'=>$cust_name, 'CUST_KNOWAS'=>$cust_knownas, 'CUST_SUBNET_CODE'=>$cust_subnet_code, 'CUST_SUBNET_NAME'=>$cust_subnet_name);
                    $update = $this->dashboard_model->update_db('report', $where_update, $post_data);
                }
            }else{
                echo 'id '.$ID.' Cust No '.$CUSTID."\n";
            }
        }
    }
    function check_cust_register(){
        // $ax_customer_list = $this->dashboard_model->get_where_data('ax_customer_list', array('cust_status'=>0)); 
        $ax_customer_list = $this->dashboard_model->get_where_data_limit('ax_customer_list', array('cust_reg_portal'=>0), 'id', 'asc', 1000);  
        if($ax_customer_list){ 
            foreach ($ax_customer_list as $key => $value) {
                $cust_data_id = $value['id']; 
                $cust_id = $value['cust_id']; 
                $check_register = $this->dashboard_model->get_where_data('user', array('CUSTID'=>$cust_id));
                if($check_register){ 
                    $update_ax_list = $this->dashboard_model->update_db('ax_customer_list', ['id'=>$cust_data_id], ['cust_reg_portal'=>1]);
                }else{
                    $update_ax_list = $this->dashboard_model->update_db('ax_customer_list', ['id'=>$cust_data_id], ['cust_reg_portal'=>2]);
                }
            }  
        }else{
            echo 'tidak ada data';
        }        
    }
    function test_email(){  
        $this->load->library('email');    
        $this->email->from('noreply@indonet.co.id', 'My Indonet'); 
        $to = 'syarip.hidayatullah@indonet.id'; //diisi dengan alamat tujuan //HARDCODE by Syarip
        $this->email->to($to);  
        $this->email->subject('mail dari myinondet id lagiiiii aja');   
        $message= 'asdasd';
        $this->email->message($message); 
        if ( ! $this->email->send()){   
            echo $this->email->print_debugger();
            return false;
    	}else{
            echo 'SEND EMAIL...';
            return true;
    	}
    }
    function test_email_registrasi(){ 
        $token ='asd';
        $id = 1;
        $cust_name = 'asd1';
        $cust_id = 'asd2';
        $email = 'syarip.hidayatullah@indonet.id';
        $type = 'Registrasi'; 
        $send_email = $this->send_email_customer($id, $type, $email, $token, $cust_id, $cust_name);
        if($send_email){
            echo 'kirim email ke '.$email;
        }
    }
    function reset_send_email(){
        $token_data = $this->dashboard_model->get_where_data('user_token_data', array('status'=>0)); 
        foreach ($token_data as $key => $value) {
            $id = $value['id']; 
            $update = $this->dashboard_model->update_db('user_token_data', ['id'=>$id], ['send_email'=>0]); 
            if($update){
                echo 'id '.$id.' terupdate'."\n";
            }
        } 
    }
    function send_email_registrasi(){ 
        // $token_data = $this->dashboard_model->get_where_data_row('user_token_data', array('send_email'=>0)); 
        // $token_data = $this->dashboard_model->get_where_data('user_token_data', array('send_email'=>0)); 
        // $token_data = $this->dashboard_model->get_where_data_limit('user_token_data', array('send_email'=>0), 'id', 'asc', 50);     
        $token_data = $this->dashboard_model->get_where_data_limit('user_token_data', array('id'=>2693), 'id', 'asc');     
        print_r($token_data); die();
        $count_token = count($token_data);
        $no = 1;    
        if($token_data){
            foreach ($token_data as $key => $value) { 
                $id = $value['id'];
                $token = $value['token'];
                $cust_name = $value['cust_name'];
                $cust_id = $value['cust_id'];
                $email = $value['email'];
                $type = $value['type']; 
                if($email != '' && $email != '-'){
                    $send_email = $this->send_email_customer($id, $type, $email, $token, $cust_id, $cust_name);
                    if($send_email){
                        //update send_email  = 1
                        echo $no.'. id => '.$id.' => update send email '.$email."\n";
                        $this->dashboard_model->update_db('user_token_data', ['id'=>$id], ['send_email'=>1]);
                    }else{

                    }
                }else{ 
                    echo 'email tidak valid custid = '.$cust_id.'; cust name = '.$cust_name.'; cust email = '.$email."\n";
                }
                $no++;
            }
        }else{
            echo 'tidak ada data';
        }
    }
    function send_email_user_fm(){ 
        // $email_data = $this->dashboard_model->get_where_data_row('user_email_fm', array('send_email'=>0)); 
        $email_data = $this->dashboard_model->get_where_data_limit('user_email_fm', array('send_email'=>0), 'id', 'desc');    
        // print_r($email_data);die();    
        if($email_data){
            foreach ($email_data as $key => $value) { 
                $token = '0000';
                $id = $value['id']; 
                $cust_name = $value['name'];
                $cust_id = $value['cust_id'];
                $email = $value['email'];
                $type = 'user_email_fm'; 
                if($email != '' && $email != '-'){
                    $send_email = $this->send_email_customer($id, $type, $email, $token, $cust_id, $cust_name);
                    if($send_email){
                        //update send_email  = 1
                        echo 'update send email '.$email."\n"; 
                    }else{ 
                        echo 'update send email error '.$email."\n"; 
                    }
                }else{ 
                    echo 'email tidak valid custid = '.$cust_id.'; cust name = '.$cust_name.'; cust email = '.$email."\n";
                }
            }
        }else{
            echo 'tidak ada data';
        }
    } 
    function send_email_billing_ralat(){    
        $email_data = $this->dashboard_model->get_where_data_limit('user_email_billing', array('send_email'=>1), 'id', 'asc', 100);
        // print_r($email_data); die(); 
        // $email_data = $this->dashboard_model->get_where_data_limit('user_email_billing', array("id"=>2), 'id', 'desc');   
        if($email_data){
            foreach ($email_data as $key => $value) { 
                $token = '0000';
                $id = $value['id']; 
                $cust_name = $value['name'];
                $cust_id = $value['cust_id'];
                $email = $value['email'];
                $type = 'user_email_billing_ralat'; 
                if($email != '' && $email != '-'){
                    $send_email = $this->send_email_customer($id, $type, $email, $token, $cust_id, $cust_name);
                    if($send_email){
                        //update send_email  = 1
                        echo 'update send email '.$email."\n"; 
                    }else{ 
                        echo 'update send email error '.$email."\n"; 
                    }
                }else{ 
                    echo 'email tidak valid custid = '.$cust_id.'; cust name = '.$cust_name.'; cust email = '.$email."\n";
                }
            }
        }else{
            echo 'tidak ada data';
        }
    }
    function send_email_billing_new(){    
        $email_data = $this->dashboard_model->get_where_data_limit('user_email_billing', array('send_email'=>0), 'id', 'asc', 100);
        // print_r($email_data); die(); 
        // $email_data = $this->dashboard_model->get_where_data_limit('user_email_billing', array("id"=>1), 'id', 'desc');   
        if($email_data){
            foreach ($email_data as $key => $value) { 
                $token = '0000';
                $id = $value['id']; 
                $cust_name = $value['name'];
                $cust_id = $value['cust_id'];
                $email = $value['email'];
                $type = 'user_email_billing_new'; 
                if($email != '' && $email != '-'){
                    $send_email = $this->send_email_customer($id, $type, $email, $token, $cust_id, $cust_name);
                    if($send_email){
                        //update send_email  = 1
                        echo 'update send email '.$email."\n"; 
                    }else{ 
                        echo 'update send email error '.$email."\n"; 
                    }
                }else{ 
                    echo 'email tidak valid custid = '.$cust_id.'; cust name = '.$cust_name.'; cust email = '.$email."\n";
                }
            }
        }else{
            echo 'tidak ada data';
        }
    }
    function send_email_user_invoice(){   
        $email_data = $this->dashboard_model->get_where_data_limit('user_email_invoice', array('send_email'=>0), 'id', 'asc', 200);
        // print_r($email_data); die();
        // $email_data = $this->dashboard_model->get_where_data_limit('user_email_invoice', array("id"=>2), 'id', 'desc');   
        if($email_data){
            foreach ($email_data as $key => $value) { 
                $token = '0000';
                $id = $value['id']; 
                $cust_name = $value['name'];
                $cust_id = $value['cust_id'];
                $email = $value['email'];
                $type = 'user_email_invoice'; 
                if($email != '' && $email != '-'){
                    $send_email = $this->send_email_customer($id, $type, $email, $token, $cust_id, $cust_name);
                    if($send_email){
                        //update send_email  = 1
                        echo 'update send email '.$email."\n"; 
                    }else{ 
                        echo 'update send email error '.$email."\n"; 
                    }
                }else{ 
                    echo 'email tidak valid custid = '.$cust_id.'; cust name = '.$cust_name.'; cust email = '.$email."\n";
                }
            }
        }else{
            echo 'tidak ada data';
        }
    }
    function send_email_customer($id, $type, $email, $token, $cust_id, $cust_name){ 
    	$this->load->library('email'); 	 
        $this->email->clear(TRUE);
        $this->email->from('noreply@indonet.co.id', 'Indonet'); 
        // $to = 'syarip.hidayatullah@indonet.co.id'; //diisi dengan alamat tujuan //HARDCODE by Syarip
        $to = $email;
        switch ($type) {
            case 'Registrasi':
                $this->email->subject('Informasi Akses Portal Indonet');   
                $this->data['token_email'] = $token;
                $this->data['cust_id'] = $cust_id;
                $this->data['cust_email'] = $email;
                $this->data['cust_name'] = $cust_name;
                $message = $this->load->view('email_template/registrasi_upload', $this->data, true); 
                $this->email->attach('/var/www/admin-my.indonet.id/files/attach_email/Cara Akses ke Portal Indonet.pdf');  
                $this->email->to($to);  
                $this->email->message($message); 
                if ( ! $this->email->send()){  
                    echo 'error send email ke '.$email.' => '.$cust_id."\n";
                    // echo $this->email->print_debugger();
                    return false;
                }else{
                    // echo 'SEND EMAIL...';
                    return true;
                }  
                
                break;
            case 'user_email_fm':
                $this->email->subject('Informasi peralihan layanan TV');
                $this->data['cust_id'] = $cust_id;
                $this->data['cust_email'] = $email;
                $this->data['cust_name'] = $cust_name;
                $message = $this->load->view('email_template/user_fm', $this->data, true); 
                $this->email->attach('/var/www/admin-my.indonet.id/files/attach_email/Surat pemberitahuan perubahan layanan IPTV.pdf');  
                $this->email->to($to);  
                $this->email->message($message); 
                if ( ! $this->email->send()){  
                    echo 'error send email ke '.$email.' => '.$cust_id."\n";
                    $this->dashboard_model->update_db('user_email_fm', ['id'=>$id], ['send_email'=>0, 'send_email_date'=>date('Y-m-d H:i:s'), 'send_email_status'=>'email tidak terkirim']);
                    echo $this->email->print_debugger();
                    return false;
                }else{
                    // echo 'SEND EMAIL...';
                    $this->dashboard_model->update_db('user_email_fm', ['id'=>$id], ['send_email'=>1, 'send_email_date'=>date('Y-m-d H:i:s'), 'send_email_status'=>'email terkirim']);
                    return true;
                }   
                break;                
            case 'user_email_billing_ralat':
                $this->email->subject('Ralat - Pemberitahuan perubahan format Tagihan Indonet');
                $this->data['cust_id'] = $cust_id;
                $this->data['cust_email'] = $email;
                $this->data['cust_name'] = $cust_name;
                $message = $this->load->view('email_template/user_billing_ralat', $this->data, true); 
                $this->email->attach('/var/www/admin-my.indonet.id/files/attach_email/Billing Statement contoh perubahan 11012021A.pdf');   
                $this->email->to($to);  
                $this->email->message($message); 
                if ( ! $this->email->send()){  
                    echo 'error send email ke '.$email.' => '.$cust_id."\n";
                    $this->dashboard_model->update_db('user_email_billing', ['id'=>$id], ['send_email'=>0, 'send_email_date'=>date('Y-m-d H:i:s'), 'send_email_status'=>'email tidak terkirim']);
                    // echo $this->email->print_debugger();
                    return true;
                }else{
                    // echo 'SEND EMAIL...';
                    $this->dashboard_model->update_db('user_email_billing', ['id'=>$id], ['send_email'=>2, 'send_email_date'=>date('Y-m-d H:i:s'), 'send_email_status'=>'email terkirim']);
                    return true;
                }   
                break;
            case 'user_email_billing_new':
                $this->email->subject('Pemberitahuan perubahan format Tagihan Indonet');
                $this->data['cust_id'] = $cust_id;
                $this->data['cust_email'] = $email;
                $this->data['cust_name'] = $cust_name;
                $message = $this->load->view('email_template/user_billing', $this->data, true); 
                $this->email->attach('/var/www/admin-my.indonet.id/files/attach_email/Billing Statement contoh perubahan 11012021A.pdf');   
                $this->email->to($to);  
                $this->email->message($message); 
                if ( ! $this->email->send()){  
                    echo 'error send email ke '.$email.' => '.$cust_id."\n";
                    $this->dashboard_model->update_db('user_email_billing', ['id'=>$id], ['send_email'=>0, 'send_email_date'=>date('Y-m-d H:i:s'), 'send_email_status'=>'email tidak terkirim']);
                    // echo $this->email->print_debugger();
                    return true;
                }else{
                    // echo 'SEND EMAIL...';
                    $this->dashboard_model->update_db('user_email_billing', ['id'=>$id], ['send_email'=>2, 'send_email_date'=>date('Y-m-d H:i:s'), 'send_email_status'=>'email terkirim']);
                    return true;
                }   
                break;
            case 'user_email_invoice':
                $this->email->subject('Ralat - Pemberitahuan perubahan format Tagihan Indonet');
                $this->data['cust_id'] = $cust_id;
                $this->data['cust_email'] = $email;
                $this->data['cust_name'] = $cust_name;
                $message = $this->load->view('email_template/user_invoice_ralat', $this->data, true); 
                $this->email->attach('/var/www/admin-my.indonet.id/files/attach_email/Billing Invoice contoh perubahan 11012021A.pdf');   
                $this->email->to($to);  
                $this->email->message($message); 
                if ( ! $this->email->send()){  
                    echo 'error send email ke '.$email.' => '.$cust_id."\n";
                    $this->dashboard_model->update_db('user_email_invoice', ['id'=>$id], ['send_email'=>0, 'send_email_date'=>date('Y-m-d H:i:s'), 'send_email_status'=>'email tidak terkirim']);
                    // echo $this->email->print_debugger();
                    return true;
                }else{
                    // echo 'SEND EMAIL...';
                    $this->dashboard_model->update_db('user_email_invoice', ['id'=>$id], ['send_email'=>2, 'send_email_date'=>date('Y-m-d H:i:s'), 'send_email_status'=>'email terkirim']);
                    return true;
                }   
                break;
            default:
                # code...
                break;
        } 
        
    } 
    public function demo() { 
        $this->data['content'] = 'admin/table_demo'; 
        $this->data['title'] = 'Dashboard';
        $this->data['menu_active'] = 'dashboard';
        $this->load->view('admin/layout', $this->data);  
    } 
    public function demo2() { 
        $subnet = $this->session->userdata('subnets'); 
        $subnet_array =  explode(',', $subnet); 
        $data_cust = $this->dashboard_model->get_where_custlist('ax_customer_list', $subnet_array);  
    }
    public function demo_create_billing_pdf(){
        $argv = $_SERVER['argv']; 
        $asd = $argv[2];
        $file_name = './files/temp/test.txt';
        file_put_contents($file_name, $asd);  
    }
    function demo_sh(){   
        // $asd = exec('sh ./cronjob/create_biiling_pdf.sh 0122'); 

        echo exec('php /var/www/admin-my.indonet.id/index.php Api/create_billing_indonet_pdf 0122 > /dev/null 2>&1 &');


        // echo $asd;
    } 
    public function create_billing_indonet_by_periode_cust_id_pdf(){
        $argv = $_SERVER['argv']; 
        $periode_folder = $argv[2];   
        $periode_bill = $argv[3];   
        $type = 'view_billing_faktur_indonet';
        $url_api = 'https://api-my.indonet.id/billing';
        $post = array('type'=>$type, 'periode'=> $periode_folder); 
        $response = $this->curl->simple_post($url_api, $post);   
        $file_data = json_decode($response, true);  
        foreach ($file_data as $key => $value) {
            $cust_id = $value['cust_id'];   
            $billing_file = $value['billing_file']; 
            $billing_code = $value['billing_code'];
            $faktur_pajak_id = $value['faktur_pajak_id'];
            $faktur_pajak_complete = $value['faktur_pajak_complete'];
            $no_npwp = $value['no_npwp']; 
            $cust_name = $value['cust_name'];
            $cust_email = $value['cust_email'];
            $type = $value['type'];
            $faktur_file = $value['faktur_file'];
            $billing_amount = $value['billing_amount']; 
            $type_api = 'create_billing_indonet_by_periode_cust_id';
            $url_api = 'https://api-my.indonet.id/billing';
            $post = array('type'=>$type_api, 'periode_folder'=>$periode_folder, 'periode_bill'=> $periode_bill, 'cust_id'=> $cust_id, 'billing_file'=>$billing_file, 'billing_code'=>$billing_code); 
            $response = $this->curl->simple_post($url_api, $post);  
            $file_data = json_decode($response, true);     
            if($file_data){          
                $billing_amount = $file_data['inv_total'];
                $cust_email = $file_data['email'];
            }
            $data[] = array(
                'faktur_pajak_id' => $faktur_pajak_id,
                'faktur_pajak_complete' => $faktur_pajak_complete,
                'no_npwp' => $no_npwp,
                'cust_id'  => $cust_id,
                'cust_name'  => $cust_name,
                'cust_email'  => $cust_email,
                'type'  => $type,
                'billing_code'  => $billing_code,
                'billing_file'  => $billing_file,
                'faktur_file'  => $faktur_file,
                'billing_amount'  => $billing_amount
            );    
        }
        $type_api = 'upload_billing_faktur_indonet';
        $url_api = 'https://api-my.indonet.id/billing';
        $post = array('type'=>$type_api, 'periode'=> $periode_folder,'data'=>json_encode($data)); 
        $response = $this->curl->simple_post($url_api, $post); 
        
       //faktur pajak  
        // $this->create_faktur_pajak_indonet_by_periode_cust_id_pdf($periode_folder);
    } 
    function create_faktur_pajak_indonet_by_periode_cust_id_pdf(){ 
        $argv = $_SERVER['argv']; 
        $periode_folder = $argv[2];   
        $type = 'view_billing_faktur_indonet';
        $url_api = 'https://api-my.indonet.id/billing';
        $post = array('type'=>$type, 'periode'=> $periode_folder); 
        $response = $this->curl->simple_post($url_api, $post);   
        $file_data = json_decode($response, true);   
        foreach ($file_data as $key => $value) {
            $cust_id = $value['cust_id'];   
            $billing_file = $value['billing_file']; 
            $billing_code = $value['billing_code'];
            $faktur_pajak_id = $value['faktur_pajak_id'];
            $faktur_pajak_complete = $value['faktur_pajak_complete'];
            $no_npwp = $value['no_npwp']; 
            $cust_name = $value['cust_name'];
            $cust_email = $value['cust_email'];
            $type = $value['type'];
            $faktur_file = $value['faktur_file'];
            $billing_amount = $value['billing_amount']; 
            if($no_npwp != 0){ 
                $type_api = 'create_faktur_pajak_indonet_by_periode_cust_id';
                $url_api = 'https://api-my.indonet.id/billing';
                $post = array('type'=>$type_api, 'periode_folder'=>$periode_folder,  'faktur_file'=>$faktur_file); 
                $response = $this->curl->simple_post($url_api, $post);  
                $file_data = json_decode($response, true);      
            }
        }
    }
    public function send_email_all_billing_indonet(){
        $argv = $_SERVER['argv']; 
        $periode_folder = $argv[2]; 
        $periode = $argv[3];  
        $type = 'view_billing_faktur_indonet';
        $url_api = 'https://api-my.indonet.id/billing';
        $post = array('type'=>$type, 'periode'=> $periode_folder); 
        $response = $this->curl->simple_post($url_api, $post);   
        $file_data = json_decode($response, true);  
        foreach ($file_data as $key => $value) {   
            $cust_id = $value['cust_id'];   
            $cust_name = $value['cust_name'];   
            $billing_file = $value['billing_file']; 
            $billing_code = $value['billing_code'];
            $cust_email = $value['cust_email'];
            $cust_type = $value['type'];
            $faktur_file = $value['faktur_file'];
            $billing_amount = $value['billing_amount']; 
            $no_npwp = $value['no_npwp'];
            $email_array = explode(';',$cust_email); 

            foreach ($email_array as $key2 => $val_email) {
                // $cust_email_send = $val_email; 
                $cust_email_send = 'syarip.hidayatullah@indonet.co.id'; 
                $type = 'send_email_billing_indonet';
                $url_api = 'https://api-my.indonet.id/emails';
                $post = array('type'=>$type, 'periode'=> $periode, 'periode_folder'=> $periode_folder, 'cust_id'=> $cust_id, 'cust_email'=>$cust_email_send,
                              'cust_name'=>$cust_name, 'billing_amount'=>$billing_amount, 'billing_file'=>$billing_file, 'faktur_file'=>$faktur_file,
                              'no_npwp'=>$no_npwp); 
                $response = $this->curl->simple_post($url_api, $post);    
            } 
        }
    }  

    
    public function create_billing_alibaba_by_periode_cust_id_pdf(){
        $argv = $_SERVER['argv']; 
        $periode_folder = $argv[2];   
        $periode_bill = $argv[3];   
        $type = 'view_billing_faktur_alibaba';
        $url_api = 'https://api-my.indonet.id/billing';
        $post = array('type'=>$type, 'periode'=> $periode_folder); 
        $response = $this->curl->simple_post($url_api, $post);   
        $file_data = json_decode($response, true);  
        foreach ($file_data as $key => $value) {
            $cust_id = $value['cust_id'];   
            $billing_file = $value['billing_file']; 
            $billing_code = $value['billing_code'];
            $faktur_pajak_id = $value['faktur_pajak_id'];
            $faktur_pajak_complete = $value['faktur_pajak_complete'];
            $no_npwp = $value['no_npwp']; 
            $cust_name = $value['cust_name'];
            $cust_email = $value['cust_email'];
            $type = $value['type'];
            $faktur_file = $value['faktur_file'];
            $billing_amount = $value['billing_amount']; 
            $type_api = 'create_billing_alibaba_by_periode_cust_id';
            $url_api = 'https://api-my.indonet.id/billing';
            $post = array('type'=>$type_api, 'periode_folder'=>$periode_folder, 'periode_bill'=> $periode_bill, 'cust_id'=> $cust_id, 'billing_file'=>$billing_file, 'billing_code'=>$billing_code); 
            $response = $this->curl->simple_post($url_api, $post);  
            $file_data = json_decode($response, true);     
            if($file_data){          
                $billing_amount = $file_data['inv_total'];
                $cust_email = $file_data['email'];
            }
            $data[] = array(
                'faktur_pajak_id' => $faktur_pajak_id,
                'faktur_pajak_complete' => $faktur_pajak_complete,
                'no_npwp' => $no_npwp,
                'cust_id'  => $cust_id,
                'cust_name'  => $cust_name,
                'cust_email'  => $cust_email,
                'type'  => $type,
                'billing_code'  => $billing_code,
                'billing_file'  => $billing_file,
                'faktur_file'  => $faktur_file,
                'billing_amount'  => $billing_amount
            );    
        }
        $type_api = 'upload_billing_faktur_alibaba';
        $url_api = 'https://api-my.indonet.id/billing';
        $post = array('type'=>$type_api, 'periode'=> $periode_folder,'data'=>json_encode($data)); 
        $response = $this->curl->simple_post($url_api, $post); 
        
       //faktur pajak  
        // $this->create_faktur_pajak_indonet_by_periode_cust_id_pdf($periode_folder);
    } 
    function create_faktur_pajak_alibaba_by_periode_cust_id_pdf(){ 
        $argv = $_SERVER['argv']; 
        $periode_folder = $argv[2];   
        $type = 'view_billing_faktur_alibaba';
        $url_api = 'https://api-my.indonet.id/billing';
        $post = array('type'=>$type, 'periode'=> $periode_folder); 
        $response = $this->curl->simple_post($url_api, $post);   
        $file_data = json_decode($response, true);   
        foreach ($file_data as $key => $value) {
            $cust_id = $value['cust_id'];   
            $billing_file = $value['billing_file']; 
            $billing_code = $value['billing_code'];
            $faktur_pajak_id = $value['faktur_pajak_id'];
            $faktur_pajak_complete = $value['faktur_pajak_complete'];
            $no_npwp = $value['no_npwp']; 
            $cust_name = $value['cust_name'];
            $cust_email = $value['cust_email'];
            $type = $value['type'];
            $faktur_file = $value['faktur_file'];
            $billing_amount = $value['billing_amount']; 
            if($no_npwp != 0){ 
                $type_api = 'create_faktur_pajak_alibaba_by_periode_cust_id';
                $url_api = 'https://api-my.indonet.id/billing';
                $post = array('type'=>$type_api, 'periode_folder'=>$periode_folder,  'faktur_file'=>$faktur_file); 
                $response = $this->curl->simple_post($url_api, $post);  
                $file_data = json_decode($response, true);      
            }
        }
    }
    public function send_email_all_billing_alibaba(){
        $argv = $_SERVER['argv']; 
        $periode_folder = $argv[2]; 
        $periode = $argv[3];  
        $type = 'view_billing_faktur_alibaba';
        $url_api = 'https://api-my.indonet.id/billing';
        $post = array('type'=>$type, 'periode'=> $periode_folder); 
        $response = $this->curl->simple_post($url_api, $post);   
        $file_data = json_decode($response, true);  
        foreach ($file_data as $key => $value) {   
            $cust_id = $value['cust_id'];   
            $cust_name = $value['cust_name'];   
            $billing_file = $value['billing_file']; 
            $billing_code = $value['billing_code'];
            $cust_email = $value['cust_email'];
            $cust_type = $value['type'];
            $faktur_file = $value['faktur_file'];
            $billing_amount = $value['billing_amount']; 
            $no_npwp = $value['no_npwp'];
            $email_array = explode(';',$cust_email); 

            foreach ($email_array as $key2 => $val_email) {
                // $cust_email_send = $val_email; 
                $cust_email_send = 'syarip.hidayatullah@indonet.co.id'; 
                $type = 'send_email_billing_alibaba';
                $url_api = 'https://api-my.indonet.id/emails';
                $post = array('type'=>$type, 'periode'=> $periode, 'periode_folder'=> $periode_folder, 'cust_id'=> $cust_id, 'cust_email'=>$cust_email_send,
                              'cust_name'=>$cust_name, 'billing_amount'=>$billing_amount, 'billing_file'=>$billing_file, 'faktur_file'=>$faktur_file,
                              'no_npwp'=>$no_npwp); 
                $response = $this->curl->simple_post($url_api, $post);    
            } 
        }
    }  
    function send_email_blast_customer(){
        $argv = $_SERVER['argv']; 
        $send_blast_db = $argv[2];  
        $send_blast_type = $argv[3];  
        $email_array = $this->dashboard_model->get_where_data($send_blast_db, ['email !='=>'', 'send_email'=>0]);    
        foreach ($email_array as $key2 => $val_email) { 
            $id = $val_email['id'];
            $cust_id = $val_email['cust_id'];
            $cust_email_send = $val_email['email']; 
            $cust_name = $val_email['email']; 
            // $cust_id = '123456';
            // $cust_email_send = 'syarip.hidayatullah@indonet.co.id';
            // $cust_name =  'syarip.hidayatullah@indonet.co.id';
            $type = $send_blast_type;
            $url_api = 'https://api-my.indonet.id/emails';
            $post = array('type'=>$type, 'cust_id'=> $cust_id, 'cust_email'=>$cust_email_send, 'cust_name'=>$cust_name); 
            $response = $this->curl->simple_post($url_api, $post);  
            if($response){ 
                $this->dashboard_model->update_db($send_blast_db, ['id'=>$id], ['send_email'=>1, 'send_at'=>date("Y-m-d H:i:s")]);
            }else{ 
                $this->dashboard_model->update_db($send_blast_db, ['id'=>$id], ['send_email'=>2, 'note'=>'Email tidak terkirim']);
            }
        } 
        $this->buildResponse(200, 'send success');
    }

    function set_cust_data_faktur_pajak(){
        $argv = $_SERVER['argv']; 
        $periode_num = $argv[2];   
        $list_corporate = $argv[3];   
        $list_retail = $argv[4];   
        $list_personal = $argv[5];   
        $user_id = $argv[6];    
        $url_api = 'https://api-my.indonet.id/ax/set_cust_num_faktur_pajak_db';
        $post = array('periode'=>$periode_num, 'list_corporate'=>$list_corporate, 'list_retail'=>$list_retail, 'list_personal'=>$list_personal, 'user_id'=>$user_id); 
        $response = $this->curl->simple_post($url_api, $post);  
        if($response){
            $this->buildResponse(200, 'send success'); 
        }
    }
    public function create_billing_pdf_by_periode(){
        $argv = $_SERVER['argv'];   
        $periode = $argv[2];    
        $url_api = 'https://api-my.indonet.id/billing/create_billing_pdf_by_periode';
        $post = array('periode'=> $periode); 
        $response = $this->curl->simple_post($url_api, $post);   
        $file_data = json_decode($response, true);  
        // foreach ($file_data as $key => $value) {
        //     $cust_id = $value['cust_id'];   
        //     $billing_file = $value['billing_file']; 
        //     $billing_code = $value['billing_code'];
        //     $faktur_pajak_id = $value['faktur_pajak_id'];
        //     $faktur_pajak_complete = $value['faktur_pajak_complete'];
        //     $no_npwp = $value['no_npwp']; 
        //     $cust_name = $value['cust_name'];
        //     $cust_email = $value['cust_email'];
        //     $type = $value['type'];
        //     $faktur_file = $value['faktur_file'];
        //     $billing_amount = $value['billing_amount']; 
        //     $type_api = 'create_billing_indonet_by_periode_cust_id';
        //     $url_api = 'https://api-my.indonet.id/billing';
        //     $post = array('type'=>$type_api, 'periode_folder'=>$periode_folder, 'periode_bill'=> $periode_bill, 'cust_id'=> $cust_id, 'billing_file'=>$billing_file, 'billing_code'=>$billing_code); 
        //     $response = $this->curl->simple_post($url_api, $post);  
        //     $file_data = json_decode($response, true);     
        //     if($file_data){          
        //         $billing_amount = $file_data['inv_total'];
        //         $cust_email = $file_data['email'];
        //     }
        //     $data[] = array(
        //         'faktur_pajak_id' => $faktur_pajak_id,
        //         'faktur_pajak_complete' => $faktur_pajak_complete,
        //         'no_npwp' => $no_npwp,
        //         'cust_id'  => $cust_id,
        //         'cust_name'  => $cust_name,
        //         'cust_email'  => $cust_email,
        //         'type'  => $type,
        //         'billing_code'  => $billing_code,
        //         'billing_file'  => $billing_file,
        //         'faktur_file'  => $faktur_file,
        //         'billing_amount'  => $billing_amount
        //     );    
        // }
        // $type_api = 'upload_billing_faktur_indonet';
        // $url_api = 'https://api-my.indonet.id/billing';
        // $post = array('type'=>$type_api, 'periode'=> $periode_folder,'data'=>json_encode($data)); 
        // $response = $this->curl->simple_post($url_api, $post); 
        
       //faktur pajak  
        // $this->create_faktur_pajak_indonet_by_periode_cust_id_pdf($periode_folder);
    } 
    function create_billing_pdf_by_periode_new(){
        $argv = $_SERVER['argv'];   
        $periode = $argv[2];    
        $billing_non_alibaba = $argv[3];    
        $billing_alibaba = $argv[4];    
        $billing_non_npwp = $argv[5];    
        $billing_npwp = $argv[6];    
        $alibaba_posting_date = $argv[7];    
        $url_api = 'https://api-my.indonet.id/billing/create_billing_pdf_by_periode_new';
        $post = array(  'periode'=> $periode, 'billing_non_alibaba'=>$billing_non_alibaba, 'billing_alibaba'=>$billing_alibaba, 'billing_non_npwp'=>$billing_non_npwp, 
                        'billing_npwp'=>$billing_npwp, 'alibaba_posting_date'=>$alibaba_posting_date); 
        $response = $this->curl->simple_post($url_api, $post);   
        $file_data = json_decode($response, true);  
    }
    function split_pdf_periode(){
        $argv = $_SERVER['argv'];   
        $periode = $argv[2];    
        $filename = $argv[3];     
        $url_api = 'https://api-my.indonet.id/billing/split_pdf';
        $post = array('periode'=> $periode, 'filename'=>$filename); 
        $response = $this->curl->simple_post($url_api, $post);   
        $file_data = json_decode($response, true);  
    }
    function upload_file_blacklist(){
        $argv = $_SERVER['argv'];   
        $filename = $argv[2];     
        $url_api = 'https://api-my.indonet.id/billing/upload_blacklist';
        $post = array('filename'=>$filename); 
        $response = $this->curl->simple_post($url_api, $post);   
        $file_data = json_decode($response, true);  
    }
    function set_list_pf_periode(){
        $argv = $_SERVER['argv'];   
        $periode = $argv[2];    
        $filename = $argv[3];     
        $url_api = 'https://api-my.indonet.id/billing/set_seri_faktur_pajak';
        $post = array('periode'=> $periode, 'filename'=>$filename); 
        $response = $this->curl->simple_post($url_api, $post);   
        $file_data = json_decode($response, true);   
    }
    function send_billing_pf_periode(){
        $argv = $_SERVER['argv'];      
        $periode = $argv[2];    
        $send_corporate = $argv[3];     
        $send_retail = $argv[4];     
        $send_personal = $argv[5];     
        $send_non_alibaba = $argv[6];     
        $send_alibaba = $argv[7];     
        $send_npwp = $argv[8];     
        $send_non_npwp = $argv[9];    
        $url_api = 'https://api-my.indonet.id/billing/send_email_pf_periode';
        $post = array(  'periode'=> $periode, 'send_corporate'=>$send_corporate, 'send_retail'=>$send_retail, 'send_personal'=>$send_personal,
                        'send_non_alibaba'=>$send_non_alibaba, 'send_alibaba'=>$send_alibaba, 'send_npwp'=>$send_npwp, 'send_non_npwp'=>$send_non_npwp); 
        $response = $this->curl->simple_post($url_api, $post);   
        $file_data = json_decode($response, true);  
    } 
    function send_billing_pf_single(){
        $argv = $_SERVER['argv'];      
        $list_id = $argv[2];        
        $url_api = 'https://api-my.indonet.id/billing/send_email_pf_single';
        $post = array('list_id'=> $list_id); 
        $response = $this->curl->simple_post($url_api, $post);   
        $file_data = json_decode($response, true);  
    } 
}