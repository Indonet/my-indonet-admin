<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller { 
    public function index() { 
        $this->access_menu('dashboard');
        $this->data['content'] = 'admin/dashboard'; 
        $this->data['title'] = 'Dashboard';
        $this->data['menu_active'] = 'dashboard';
        $this->load->view('admin/layout', $this->data);  
    } 
    public function customer_list() { 
        $this->access_menu('customer-list');
        $this->data['content'] = 'admin/customer_list';
        $this->data['menu_minize'] = 'aside-minimize';
        $this->data['title'] = 'Customer List';
        $this->data['menu_active'] = 'customer_list';
        $this->load->view('admin/layout', $this->data); 
    }
    public function account() { 
        $this->data['content'] = 'admin/account';
        $this->data['title'] = 'Account';
        $this->data['menu_active'] = 'account';
        $this->load->view('admin/layout', $this->data); 
    }
    public function product_info() { 
        $this->data['content'] = 'customer/prod_info';
        $this->data['title'] = 'Products Info';
        $this->data['menu_active'] = 'prod_info';
        $this->load->view('customer/layout', $this->data); 
    }    
    public function transaction_info() { 
        $this->data['content'] = 'customer/trans_info';
        $this->data['title'] = 'Transactions Info';
        $this->data['menu_active'] = 'trans_info';
        $this->load->view('customer/layout', $this->data); 
    }
    public function billing_statement() { 
        $this->data['content'] = 'customer/billing';
        $this->data['title'] = 'Billing Statement';
        $this->data['menu_active'] = 'billing';
        $this->load->view('customer/layout', $this->data); 
    }
    public function report() { 
        $cust_id = $this->session->userdata('custID');
        $this->data['report_data'] = $this->dashboard_model->get_where_data('report', array('CUSTID'=>$cust_id), 'ID', 'DESC', 24);  
        $this->data['content'] = 'customer/report';
        $this->data['title'] = 'Report';
        $this->data['menu_active'] = 'report';
        $this->load->view('customer/layout', $this->data); 
    }
    public function payment_info() {  
        $periode = date('Y-m').'-01';
        $subnet = $this->session->userdata('subnets'); 
        $subnet_array =  explode(',', $subnet); 
        $this->data['data_payment'] = $this->dashboard_model->get_where_data_payment($periode, $subnet_array);  
        $this->data['content'] = 'admin/payment_list'; 
        $this->data['menu_minize'] = '';
        $this->data['title'] = 'Admin User';
        $this->data['menu_active'] = 'admin-payment-list';
        $this->load->view('admin/layout', $this->data); 
    }
    function admin_user(){
        $this->data['data_list_user_login'] = $this->dashboard_model->get_all_data('user');  
        // $this->data['data_ax_customer_list'] = $this->dashboard_model->get_all_data('ax_customer_list');  
        $this->data['data_ax_customer_list'] = array(); 
        // $this->data['data_list_user_login'] = array(); //debug
        // $this->data['data_list_token'] = $this->dashboard_model->get_where_data('user_token_data', array('status'=>0));   
        $this->data['content'] = 'admin/admin_user';
        // $this->data['menu_minize'] = 'aside-minimize';
        $this->data['menu_minize'] = '';
        $this->data['title'] = 'Admin User';
        $this->data['menu_active'] = 'admin-user-list';
        $this->load->view('admin/layout', $this->data); 
    }
    function faktur_pajak_indonet_list(){
        $this->access_menu('faktur-pajak-indonet-list');
        // $this->data['data_vendor'] = $this->dashboard_model->get_all_data('vendor');  
        $this->data['content'] = 'admin/faktur_pajak_indonet';
        $this->data['menu_minize'] = '';
        $this->data['title'] = 'Admin Faktur Pajak Indonet';
        $this->data['menu_active'] = 'faktur-pajak-indonet';
        $this->load->view('admin/layout', $this->data); 
    }
    function faktur_pajak_indonet_list_old(){
        $this->access_menu('faktur-pajak-indonet-list');
        // $this->data['data_vendor'] = $this->dashboard_model->get_all_data('vendor');  
        $this->data['content'] = 'admin/admin_faktur_pajak';
        $this->data['menu_minize'] = '';
        $this->data['title'] = 'Admin Faktur Pajak Indonet';
        $this->data['menu_active'] = 'faktur-pajak-indonet';
        $this->load->view('admin/layout', $this->data); 
    }
    function faktur_pajak_alibaba_list(){
        $this->access_menu('faktur-pajak-alibaba-list');
        // $this->data['data_vendor'] = $this->dashboard_model->get_all_data('vendor');  
        $this->data['content'] = 'admin/admin_faktur_alibaba';
        $this->data['menu_minize'] = '';
        $this->data['title'] = 'Admin Faktur Pajak Alibaba';
        $this->data['menu_active'] = 'faktur-pajak-alibaba';
        $this->load->view('admin/layout', $this->data); 
    }
    function send_email_blast_customer_list(){
        $this->access_menu('send-email-blast-customer-list');
        $this->data['data_email_blast_1'] = $this->dashboard_model->get_all_data('email_blast_1');  
        $this->data['data_email_blast_2'] = $this->dashboard_model->get_all_data('email_blast_2');  
        $this->data['content'] = 'admin/send_email_blast_customer';
        $this->data['menu_minize'] = '';
        $this->data['title'] = 'Send Email Blast';
        $this->data['menu_active'] = 'send-email-blast-customer-list';
        $this->load->view('admin/layout', $this->data); 
    }
    function faktur_pajak_blacklist_list(){
        $this->access_menu('faktur-pajak-indonet-list');  
        $this->data['content'] = 'admin/blacklist_billing';
        $this->data['menu_minize'] = '';
        $this->data['title'] = 'Admin Blacklist Billing Pajak';
        $this->data['menu_active'] = 'blacklist-billing-pajak';
        $this->load->view('admin/layout', $this->data); 

    } 
    public function get_inv_view() { 
        $year = $this->input->post('year');
        $month = $this->input->post('month');
        $json_data_cust = $this->input->post('json_data_cust');   
        $json_inv_month_details = $this->input->post('json_inv_month_details');   
        $json_inv_month_total = $this->input->post('json_inv_month_total');  
        $json_data_cust_bank = $this->input->post('json_data_cust_bank');   
        if($year == ''){  
            $year = date('Y');  
        }
        if($month == ''){    
            $month = date('m');  
        }
        $ym = $year.''.$month;   
        $this->data['data_cust'] = $json_data_cust; 
        $this->data['inv_detail_bill'] = $json_inv_month_details[$ym]; 
        $this->data['inv_month_bill'] = $json_inv_month_total[$ym];  
        $this->data['virtual_acc_bca'] = $json_data_cust_bank; 
        $this->data['year_bill'] = $year;
        $this->data['month_bill'] = $month;
        // $this->load->view('admin/invoice_view', $this->data); 
        $this->load->view('admin/invoice_view_new', $this->data); 
    }
    function get_inv_pdf(){ 
        $cust_id = $this->input->get('cust_id');
        $subnet_code = $this->input->get('subnet_code'); 
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
        $file_data = file_get_contents($file_name);
        $file_data = (array)json_decode($file_data); 
        $ym = $year_now.''.$month_now; 
        if(!isset($file_data['INV_MONTH_TOTAL']->$ym)){
            $this->get_renew_data_ax_cust($cust_id, $subnet_code); 
        } 
        $this->data['data_cust'] = $file_data[0]; 
        $this->data['inv_detail_bill'] = $file_data['INV_DETAIL_DATA']->$ym; 
        $this->data['inv_month_bill'] = $file_data['INV_MONTH_TOTAL']->$ym; 
        $this->data['year_bill'] = $year_now;
        $this->data['month_bill'] = $month_now;
        $this->load->view('admin/invoice_pdf', $this->data);  
    }
    function get_inv_pdf_new(){ 
        $cust_id = $this->input->get('cust_id');
        $subnet_code = $this->input->get('subnet_code');   
        $url_api = 'https://api-my.indonet.id/ax/get_file_cust_data';
        $post = array('cust_id'=>$cust_id, 'subnet_code'=>$subnet_code); 
        $response = $this->curl->simple_post($url_api, $post);
        $data_cust = json_decode($response,true);   
        $year_now =  date('Y');  
        $month_now =  date('m');   
        $ym = $year_now.''.$month_now;   
        $this->data['data_cust'] = $data_cust[0]; 
        $this->data['inv_detail_bill'] = $data_cust['INV_DETAIL_DATA'][$ym];  
        $this->data['inv_month_bill'] = $data_cust['INV_MONTH_TOTAL'][$ym]; 
        $this->data['year_bill'] = $year_now;
        $this->data['month_bill'] = $month_now;
        $this->data['virtual_acc_bca'] = $data_cust['VIRTUAL_ACC'];  
        $this->load->view('admin/invoice_pdf_new', $this->data);  
    }
    function check_current_pass(){
        $old_pass = $this->input->post('old_pass');  
        $conf_new_pass = $this->input->post('conf_new_pass');   
        $username = $this->session->userdata('userID');
        $userData = $this->auth_model->get_where_data_row('user', array('username' => $username));
        if($userData){
            $user_id = $userData['id'];
            $hash_pass = $userData['password'];
            if (password_verify($old_pass, $hash_pass)) {
                $hash_new_pass = $this->encryptPass($conf_new_pass); 
                $change_pass = $this->dashboard_model->update_db('user', array('id'=>$user_id), array('password'=>$hash_new_pass));
                if($change_pass){
                    $res = array('result' => TRUE);
                }else{
                    $res = array('result' => FALSE);
                }
            }
            else {
                $res = array('result' => FALSE);
            } 
        }
        echo json_encode($res); 
    }
    
    function check_payment_inv(){
        $cust_id = $this->data['cust_id'];
        $date_now = $this->data['date_now'];
        $month_now = $this->data['month_now'];
        $year_now = $this->data['year_now'];
        $balance = (int)$this->data['balance'][0]->BALANCEMST;  
        $periode = $year_now.'-'.$month_now.'-01';
        $where = array( 'cust_id'=>$cust_id, 'periode'=>$periode, 'billing'=>$balance); 
        $check_inv = $this->auth_model->get_where_data_row('inv_payment', $where); 
        if($check_inv){
            $inv_id = $check_inv['id'];
            if($check_inv['status'] == 1){ //process
                $res = array('result'=>true, 'status'=>1, 'msg'=>'Status Process'); 
            }else if($check_inv['status'] == 2){ //waiting for payment 
                $order_id_mid = $check_inv['inv_midtrans_id']; 
                if($order_id_mid){
                    $order_status = getStatusMid($order_id_mid);   
                    if($order_status){
                        $transaction_status = $order_status->transaction_status;  
                        $status_code = $order_status->status_code;  
                        $payment_status = 0;
                        $payment_status_info = '';
                        if($transaction_status == 'expire'){
                            $payment_status = 2; //failed/expire  
                            $postdata = array('id'=>$inv_id, 'status'=>1, 'payment_status'=>1, 'payment_date'=>'', 'inv_midtrans_id'=>'');
                            $update = updateInvPaymentById($postdata);  
                            $res = array('result'=>true, 'status'=>1, 'msg'=>'Payment Expired', 'pay_method'=>$check_inv['payment_name']); 
                        }else if($transaction_status == 'settlement' || $transaction_status == 'capture'){  
                            $transaction_time = $order_status->transaction_time;  
                            $postdata = array('id'=>$inv_id, 'status'=>3, 'payment_status'=>2, 'payment_date'=>$transaction_time, 'inv_midtrans_id'=>$order_id_mid);
                            $update = updateInvPaymentById($postdata);  
                            $res = array('result'=>true, 'status'=>3, 'msg'=>'Paid','pay_method'=>$check_inv['payment_name'], 'pay_date'=>$check_inv['payment_date']); 
                        }else if($transaction_status == 'pending'){ 
                            $payment_status = 1; //pending  
                            $res = array('result'=>true, 'status'=>2, 'msg'=>'Waiting for payment', 'pay_method'=>$check_inv['payment_name']); 
                        }
                    }else{
                        $res = array('result'=>false);
                    } 
                }else{
                    $res = array('result'=>false);
                }
            }else if($check_inv['status'] == 3){ //paid
                $res = array('result'=>true, 'status'=>3, 'msg'=>'Paid','pay_method'=>$check_inv['payment_name'], 'pay_date'=>$check_inv['payment_date']); 
            }
        }else{
            $res = array('result'=>false);
        }
        echo json_encode($res); 
    }
    function create_inv_blesta(){
        $post = $this->input->post();

        $cust_id = $post['cust_id'];
        $month =  $post['month'];
        $year =  $post['year'];
        $tagihan =  $post['tagihan'];
        $biaya_layanan =  $post['biaya_layanan'];
        $total_tagihan =  $post['total_tagihan'];
        $pay_method =  $post['pay_method']; 
        $periode = $year.'-'.$month.'-01'; 

        $enabled_payments = '';
        $payment_name = '';
        if($pay_method == 1){
            $enabled_payments = ['credit_card'];
            $payment_name = 'Credit Card';
        }else if($pay_method == 2){
            $enabled_payments = ["permata_va", "bca_va", "bni_va", "bri_va", "echannel", "other_va"];
            $payment_name = 'Bank Transfer';
        }  
        $where = array( 'cust_id'=>$cust_id, 'periode'=>$periode, 'billing'=>$tagihan, 'payment_method'=>$pay_method, 'payment_admin_fee'=>$biaya_layanan, 
                        'payment_total'=>$total_tagihan, 'status'=>1);
        $data_inv_exs = $this->dashboard_model->get_where_data_row('inv_payment', $where); 
        if($data_inv_exs){
            // echo 'data inv exs';
            $data_user = $this->dashboard_model->get_where_data_row('user', array('id'=>$this->session->userdata('id')));
            $blesta_id = $data_user['blesta_id']; 
            $inv_id = $data_inv_exs[0]['inv_blesta_id']; 
            $inv_payment_id = $data_inv_exs[0]['id'];
            $email = $data_user['username'];
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { 
                $email = $email.'@indo.net.id';
            } 
            $data_mid = array(  'id_blesta'=>$blesta_id, 'email'=>$email, 'fname'=>$data_user['username'], 'lname'=>'indonet', 
                                'inv_blesta_id'=>$inv_id, 'inv_total'=>(int)$total_tagihan, 'enabled_payments'=>$enabled_payments, 'inv_payment_id'=>$inv_payment_id);
            // print_r($data_mid); die(); 
            $midApi = createTransactionMid($data_mid);  
            $data['midApi'] = $midApi;
            $this->load->view('customer/midtrans_snap', $data);
        }else{
            //create new inv;
            // echo 'create new inv exs';
            $data_user = $this->dashboard_model->get_where_data_row('user', array('id'=>$this->session->userdata('id')));
            $blesta_id = $data_user['blesta_id'];  
            $invList = array(array('desc'=>$cust_id.' '.$periode, 'amount'=>$tagihan), array('desc'=>'Admin Fee', 'amount'=>$biaya_layanan));
            $input_inv_blesta = array('id_blesta'=>$blesta_id, 'inv_list'=>$invList);   
            $createInv = createNewInv($input_inv_blesta); 
            if($createInv){
                $inv_id = $createInv;  
                $post_inv = array(  'cust_id'=>$cust_id, 'periode'=>$periode, 'billing'=>$tagihan, 'payment_method'=>$pay_method, 'payment_name'=>$payment_name, 
                                    'payment_admin_fee'=>$biaya_layanan, 'payment_total'=>$total_tagihan, 'inv_blesta_id'=>$inv_id);
                $post = $this->dashboard_model->add_db('inv_payment', $post_inv);
                if($post){   
                    $email = $data_user['username'];
                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { 
                        $email = $email.'@indo.net.id';
                    } 
                    $data_mid = array(  'id_blesta'=>$blesta_id, 'email'=>$email, 'fname'=>$data_user['username'], 'lname'=>'indonet', 
                                        'inv_blesta_id'=>$inv_id, 'inv_total'=>(int)$total_tagihan, 'enabled_payments'=>$enabled_payments, 'inv_payment_id'=>$post);
                    // print_r($data_mid); die();
                    $midApi = createTransactionMid($data_mid);  
                    $data['midApi'] = $midApi;
                    $this->load->view('customer/midtrans_snap', $data);
                }
            }else{
                echo json_encode(array('res'=>false, 'msg'=>'Error create invoice'));
            } 
        }
    }
    function view_pdf_report(){
        $nameFile = $this->input->get('pdfname');
        header('Content-type: application/pdf');
        readfile('/var/www/dev-myportal.indo.net.id/files/report/'.$nameFile);        
    }
    function admin_report(){
        $this->data['data_report'] = $this->dashboard_model->get_where_data_limit('report', array('CUSTID != '=>0), 'REPORT_DATE', 'DESC', 500);  
        $this->data['data_list_customer_group'] = $this->dashboard_model->get_all_data('ax_customer_group');  
        $this->data['content'] = 'admin/admin_report';
        $this->data['menu_minize'] = 'aside-minimize';
        $this->data['title'] = 'Admin Report';
        $this->data['menu_active'] = 'admin_report';
        $this->load->view('admin/layout', $this->data); 
    }
    function get_company_name(){ 
        $searchTerm = $this->input->post('searchTerm'); 
        $response = array();
        if($searchTerm != ''){
            $response = $this->dashboard_model->get_company_list($searchTerm);
        }
        echo json_encode($response);
    }
    function get_company_name_by_id(){ 
        $id = $this->input->post('id'); 
        $response = array();
        if($id != ''){
            $where = array('id'=>$id);
            $response = $this->dashboard_model->get_where_data_row('ax_customer_group', $where);
        }
        echo json_encode($response);
    }
    function admin_domain(){ 
        $this->data['data_domain'] = $this->dashboard_model->get_all_data('domain');  
        $this->data['content'] = 'admin/admin_domain';
        $this->data['menu_minize'] = 'aside-minimize';
        $this->data['title'] = 'Admin Domain';
        $this->data['menu_active'] = 'admin_domain';
        $this->load->view('admin/layout', $this->data); 
    }
    function upload_file_user(){ 
        if ( isset($_FILES)) {

            $file = $_FILES['file_to_upload']['tmp_name'];

			// Medapatkan ekstensi file csv yang akan diimport.
			$ekstensi  = explode('.', $_FILES['file_to_upload']['name']);

			// Tampilkan peringatan jika submit tanpa memilih menambahkan file.
			if (empty($file)) { 
                $this->session->set_flashdata('msg_error','File tidak boleh kosong!');
                redirect('/admin_user');  
			} else {
				// Validasi apakah file yang diupload benar-benar file csv.
				if (strtolower(end($ekstensi)) === 'csv' && $_FILES["file_to_upload"]["size"] > 0) { 
					$i = 0;
					$handle = fopen($file, "r");
					while (($row = fgetcsv($handle, 2048))) {
						$i++;
						if ($i == 1) continue; 
                        $token = sha1(uniqid(rand(), true)) .''. md5(uniqid(rand(), true).''. md5($row[1], true));
						// Data yang akan disimpan ke dalam databse
                        $email_list = $row[1];
                        $email_array = explode(';',$email_list);
                        foreach ($email_array as $key_email => $val_email) { 
                            if($val_email != ''){
                                $postData = [
                                    'token' => $token,
                                    'email' => $val_email,
                                    'cust_id' => $row[2], 
                                    'cust_name' => $row[3], 
                                    'type' => 'Registrasi',
                                    'send_email' => 0,
                                    'created_at' => date('Y-m-d H:i:s')
                                ]; 
                                $check_email = $this->dashboard_model->get_where_data_row('user', array('username'=>$val_email));
                                if(!$check_email){  
                                    $check_email_token = $this->dashboard_model->get_where_data_row('user_token_data', array('email'=>$val_email));
                                    if(!$check_email_token){
                                        $this->dashboard_model->add_db('user_token_data', $postData);
                                    }
                                } 
                            }
                        }
						
					} 
					fclose($handle);
                    $this->session->set_flashdata('msg_success', 'Upload File Selesai.');
					redirect('/admin_user'); 
				} else {
                    $this->session->set_flashdata('msg_error','Format file tidak valid!');
					redirect('/admin_user');  
				}
			}
        }
    }
    function send_email_registrasi(){ 
        $token_data = $this->dashboard_model->get_where_data_row('user_token_data', array('send_email'=>0)); 
        // $token_data = $this->dashboard_model->get_where_data_limit('user_token_data', array('send_email'=>0));     
        print_r($token_data); die();    
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
                        echo 'update send email '.$cust_name."\n";
                        $this->dashboard_model->update_db('user_token_data', ['id'=>$id], ['send_email'=>1]);
                    }else{

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
        $this->email->from('noreply@indonet.co.id', 'My Indonet'); 
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
                break;
            case 'user_email_fm':
                $this->email->subject('perpindahan tv dari FM ke antik ');   
                $this->data['token_email'] = $token;
                $this->data['cust_id'] = $cust_id;
                $this->data['cust_email'] = $email;
                $this->data['cust_name'] = $cust_name;
                $message = $this->load->view('email_template/registrasi_upload', $this->data, true); 
                $this->email->attach('/var/www/admin-my.indonet.id/files/attach_email/Cara Akses ke Portal Indonet.pdf');  
                break;
            
            default:
                # code...
                break;
        } 
        $this->email->to($to);  
        $this->email->message($message); 
        if ( ! $this->email->send()){  
    	    // echo 'error';
            echo $this->email->print_debugger();
            return false;
    	}else{
            // echo 'SEND EMAIL...';
            return true;
    	}  
    }
    
    function upload_file_user_fm(){ 
        if ( isset($_FILES)) {

            $file = $_FILES['file_to_upload']['tmp_name'];

			// Medapatkan ekstensi file csv yang akan diimport.
			$ekstensi  = explode('.', $_FILES['file_to_upload']['name']);

			// Tampilkan peringatan jika submit tanpa memilih menambahkan file.
			if (empty($file)) { 
                $this->session->set_flashdata('msg_error','File tidak boleh kosong!');
                redirect('/admin_user');  
			} else {
				// Validasi apakah file yang diupload benar-benar file csv.
				if (strtolower(end($ekstensi)) === 'csv' && $_FILES["file_to_upload"]["size"] > 0) { 
					$i = 0;
					$handle = fopen($file, "r");
					while (($row = fgetcsv($handle, 2048))) {
						$i++;
						if ($i == 1) continue;  
						// Data yang akan disimpan ke dalam databse
                        $email_list = $row[1];
                        $email_array = explode(';',$email_list);
                        foreach ($email_array as $key_email => $val_email) { 
                            if($val_email != ''){
                                $postData = [ 
                                    'email' => $val_email,
                                    'cust_id' => $row[2], 
                                    'name' => $row[3],  
                                    'send_email' => 0,
                                    'created_at' => date('Y-m-d H:i:s')
                                ];    
                                $this->dashboard_model->add_db('user_email_fm', $postData); 
                            }
                        }
						
					} 
					fclose($handle);
                    $this->session->set_flashdata('msg_success', 'Upload File Selesai.');
					redirect('/admin_user'); 
				} else {
                    $this->session->set_flashdata('msg_error','Format file tidak valid!');
					redirect('/admin_user');  
				}
			}
        }
    } 
    
    function upload_file_user_invoice(){ 
        if ( isset($_FILES)) { 
            $file = $_FILES['file_to_upload']['tmp_name']; 
			// Medapatkan ekstensi file csv yang akan diimport.
			$ekstensi  = explode('.', $_FILES['file_to_upload']['name']);

			// Tampilkan peringatan jika submit tanpa memilih menambahkan file.
			if (empty($file)) { 
                $this->session->set_flashdata('msg_error','File tidak boleh kosong!');
                redirect('/admin_user');  
			} else {
				// Validasi apakah file yang diupload benar-benar file csv.
				if (strtolower(end($ekstensi)) === 'csv' && $_FILES["file_to_upload"]["size"] > 0) { 
					$i = 0;
					$handle = fopen($file, "r");
					while (($row = fgetcsv($handle, 2048))) {
						$i++;
						if ($i == 1) continue;  
						// Data yang akan disimpan ke dalam databse
                        $email_list = $row[1];
                        $email_array = explode(';',$email_list);
                        foreach ($email_array as $key_email => $val_email) { 
                            if($val_email != ''){
                                $postData = [ 
                                    'email' => $val_email,
                                    'cust_id' => $row[2], 
                                    'name' => $row[3],  
                                    'send_email' => 0,
                                    'created_at' => date('Y-m-d H:i:s')
                                ];    
                                $this->dashboard_model->add_db('user_email_invoice', $postData); 
                            }
                        }
						
					} 
					fclose($handle);
                    $this->session->set_flashdata('msg_success', 'Upload File Selesai.');
					redirect('/admin_user'); 
				} else {
                    $this->session->set_flashdata('msg_error','Format file tidak valid!');
					redirect('/admin_user');  
				}
			}
        }
    }
    function upload_file_user_billing(){ 
        if ( isset($_FILES)) { 
            $file = $_FILES['file_to_upload']['tmp_name']; 
			// Medapatkan ekstensi file csv yang akan diimport.
			$ekstensi  = explode('.', $_FILES['file_to_upload']['name']);

			// Tampilkan peringatan jika submit tanpa memilih menambahkan file.
			if (empty($file)) { 
                $this->session->set_flashdata('msg_error','File tidak boleh kosong!');
                redirect('/admin_user');  
			} else {
				// Validasi apakah file yang diupload benar-benar file csv.
				if (strtolower(end($ekstensi)) === 'csv' && $_FILES["file_to_upload"]["size"] > 0) { 
					$i = 0;
					$handle = fopen($file, "r");
					while (($row = fgetcsv($handle, 2048))) {
						$i++;
						if ($i == 1) continue;  
						// Data yang akan disimpan ke dalam databse
                        $email_list = $row[1];
                        $email_array = explode(';',$email_list);
                        foreach ($email_array as $key_email => $val_email) { 
                            if($val_email != ''){
                                $postData = [ 
                                    'email' => $val_email,
                                    'cust_id' => $row[2], 
                                    'name' => $row[3],  
                                    'send_email' => 0,
                                    'created_at' => date('Y-m-d H:i:s')
                                ];    
                                $this->dashboard_model->add_db('user_email_billing', $postData); 
                            }
                        }
						
					} 
					fclose($handle);
                    $this->session->set_flashdata('msg_success', 'Upload File Selesai.');
					redirect('/admin_user'); 
				} else {
                    $this->session->set_flashdata('msg_error','Format file tidak valid!');
					redirect('/admin_user');  
				}
			}
        }
    }
    function testinfo(){ 
    	echo phpinfo();
    } 
    function management_vendor(){
        $this->data['data_vendor'] = $this->dashboard_model->get_all_data('vendor');  
        $this->data['content'] = 'admin/admin_mv';
        $this->data['menu_minize'] = 'aside-minimize';
        $this->data['title'] = 'Admin Management Vendor';
        $this->data['menu_active'] = 'admin_mv';
        $this->load->view('admin/layout', $this->data); 
    }
    function view_vendor(){  
        $id = $this->input->post('id'); 
        if($id){
            $data_vendor = $this->dashboard_model->get_where_data_row('vendor', ['id'=>$id]);
            $this->buildResponse(200, 'view vendor', $data_vendor);
        }
    }
    function submit_vendor(){ 
        $post = $this->input->post();   
        $post_data = array('name'=>$post['vendor_name'], 'cust_partner_id'=>$post['cust_partner_id'], 'contract_duration'=>$post['contract_duration'], 
                           'contract_desc'=>$post['contract_desc'], 'contract_start'=>$post['contract_start'], 'contract_end'=>$post['contract_end'],
                           'contract_renew'=>$post['auto_renew'], 'contact_name_pic'=>$post['contact_name'], 'contact_phone_pic'=>$post['contact_phone'],
                           'contact_email_pic'=>$post['contact_email'], 'email_reminder_to'=>$post['reminder_to'], 'reminder_status'=>1, 
                           'created_by'=> $this->session->userdata('userID'),'created_date'=>date('d-m-Y H:i:s'), 'status'=>1);
        $save = $this->dashboard_model->add_db('vendor', $post_data);
        if($save){ 
            $this->load->library('upload'); 
            $files = $_FILES;    
            $post_data_file = array();
            $params_file = ['file_vendor']; 
            foreach ($params_file as $pf) {   
                for ($i=0; $i < count($files[$pf]['name']); $i++) { 
                    if($files[$pf]['name'][$i] != ''){ 
                        $_FILES['userfile']['name']= $files[$pf]['name'][$i];
                        $_FILES['userfile']['type']= $files[$pf]['type'][$i];
                        $_FILES['userfile']['tmp_name']= $files[$pf]['tmp_name'][$i];
                        $_FILES['userfile']['error']= $files[$pf]['error'][$i];
                        $_FILES['userfile']['size']= $files[$pf]['size'][$i]; 
                        $filename_original =  $files[$pf]['name'][$i];
                        $filename_code = md5(date('dd-mm-yyyy H:i:s').rand(5,10).$filename_original); 
                        $this->upload->initialize($this->set_upload_options($filename_code, $pf)); 
                        $this->upload->data();
                        $ext = pathinfo($filename_original, PATHINFO_EXTENSION); 
                        $filename_upload = $filename_code.'.'.$ext;    
                        if ($this->upload->do_upload()){    
                            $array_upload = array('file_name'=>$filename_original, 'filename_upload'=>$filename_upload, 'upload_date'=>date('d-m-Y H:i:s'), 
                                                  'upload_by'=>$this->session->userdata('userID'));
                            array_push($post_data_file, $array_upload); 
                        }else{  
                            echo $this->upload->display_errors();   
                        } 
                    }
                } 
                $document_upload = json_encode($post_data_file);
                $update_vendor = $this->dashboard_model->update_db('vendor', array('id'=>$save), array('document_upload'=>$document_upload));                 
            }  
            $res = array('result'=>true);
            echo json_encode($res); 
        }
    }
    function set_upload_options($file_name, $folder){    
        $config = array();
        $config['file_name'] = $file_name;
        $config['upload_path'] = './files/'.$folder.'/';
        $config['allowed_types'] = '*';
        $config['max_size'] = '10000'; // 0 = no file size limit
        $config['max_width']  = '0';
        $config['max_height']  = '0';
        $config['overwrite'] = FALSE;  
        return $config;
    }
    function demo_pdf(){ 
        // $cust_id = $this->input->get('cust_id');
        // $subnet_code = $this->input->get('subnet_code'); 
        
        $cust_id = '0000007526';
        $subnet_code = 'S-001';

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
        $file_data = file_get_contents($file_name);
        $file_data = (array)json_decode($file_data); 
        $ym = $year_now.''.$month_now;  
        if(!isset($file_data['INV_MONTH_TOTAL']->$ym)){
            $this->get_renew_data_ax_cust($cust_id, $subnet_code); 
        } 
        $this->data_bill['data_cust'] = $file_data[0]; 
        $this->data_bill['inv_detail_bill'] = $file_data['INV_DETAIL_DATA']->$ym; 
        $this->data_bill['inv_month_bill'] = $file_data['INV_MONTH_TOTAL']->$ym; 
        $this->data_bill['year_bill'] = $year_now;
        $this->data_bill['month_bill'] = $month_now;
        $html = $this->load->view('admin/invoice_pdf_new', $this->data_bill, true);  
        // print_r($html);
	    $this->pdf->save($html,'contoh2.pdf', './files/');
    }
}