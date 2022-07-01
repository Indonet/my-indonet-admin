<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Emails_blast extends MY_Controller { 
    public function index() { 
        $this->access_menu('dashboard');
        $this->data['content'] = 'admin/dashboard'; 
        $this->data['title'] = 'Dashboard';
        $this->data['menu_active'] = 'dashboard';
        $this->load->view('admin/layout', $this->data);  
    } 
    function upload_file_user_alibaba_subject_1(){
        if (isset($_FILES)) { 
            $file = $_FILES['file_to_upload']['tmp_name']; 
			// Medapatkan ekstensi file csv yang akan diimport.
			$ekstensi  = explode('.', $_FILES['file_to_upload']['name']);
			// Tampilkan peringatan jika submit tanpa memilih menambahkan file.
			if (empty($file)) { 
                $this->session->set_flashdata('msg_error','File tidak boleh kosong!');
                redirect('/send-email-blast-customer-list');  
			} else {
				// Validasi apakah file yang diupload benar-benar file csv.
				if (strtolower(end($ekstensi)) === 'xlsx' && $_FILES["file_to_upload"]["size"] > 0) { 

                    $file_tmp = $_FILES['file_to_upload']['tmp_name'];
                    $file_name = $_FILES['file_to_upload']['name'];
                    $file_size =$_FILES['file_to_upload']['size'];
                    $file_type=$_FILES['file_to_upload']['type']; 
                     
                    $objPHPExcel = PHPExcel_IOFactory::load($file_tmp); 
                    $worksheet = $objPHPExcel->getSheet(0);  
                    $highestRow = $worksheet->getHighestRow(); 
                    $highestColumn = $worksheet->getHighestColumn(); 
                    $count_npwp = 0;
                    for($row=4; $row<=$highestRow; $row++){ 
                        $cust_id = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $email_list_1 = $worksheet->getCellByColumnAndRow(2, $row)->getValue(); 
                        $email_array = explode(';',str_replace (",",";",$email_list_1)); 
                        foreach ($email_array as $key_email => $val_email) { 
                            if($val_email != '#N/A'){
                                $postData = [ 
                                    'email' => str_replace ("'","",$val_email),
                                    'cust_id' => $cust_id, 
                                    'name' => str_replace ("'","",$val_email),  
                                    'send_email' => 0,
                                    'created_at' => date('Y-m-d H:i:s')
                                ];    
                                $check_email = $this->dashboard_model->get_where_data_row('email_blast_1', ['email'=>$val_email]);
                                if(!$check_email){
                                    $this->dashboard_model->add_db('email_blast_1', $postData); 
                                }
                            }
                        } 
                        $email_list_2 = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                        $email_array_2 = explode(';',str_replace (",",";",$email_list_2));  
                        foreach ($email_array_2 as $key_email => $val_email) { 
                            if($val_email != '#N/A'){
                                $postData = [ 
                                    'email' =>  str_replace ("'","",$val_email),
                                    'cust_id' => $cust_id, 
                                    'name' => str_replace ("'","",$val_email), 
                                    'send_email' => 0,
                                    'created_at' => date('Y-m-d H:i:s')
                                ];    
                                $check_email = $this->dashboard_model->get_where_data_row('email_blast_1', ['email'=>$val_email]);
                                if(!$check_email){
                                    $this->dashboard_model->add_db('email_blast_1', $postData); 
                                }
                            }
                        }   
                    }  
 
                    $this->session->set_flashdata('msg_success', 'Upload File Selesai.');
					redirect('/send-email-blast-customer-list'); 
				} else {
                    $this->session->set_flashdata('msg_error','Format file tidak valid!');
					redirect('/send-email-blast-customer-list');  
				}
			}
        }
    }
    function send_email_blast_customer_confirm_1(){
        $email_array = $this->dashboard_model->get_where_data('email_blast_1', ['email !='=>'', 'send_email'=>0]);    
        foreach ($email_array as $key2 => $val_email) { 
            $id = $val_email['id'];
            $cust_id = $val_email['cust_id'];
            $cust_email_send = $val_email['email'];
            $type = 'send_email_blast_1';
            $url_api = 'https://api-my.indonet.id/emails';
            $post = array('type'=>$type, 'cust_id'=> $cust_id, 'cust_email'=>$cust_email_send, 'cust_name'=>$cust_email_send); 
            $response = $this->curl->simple_post($url_api, $post);  
            if($response){ 
                $this->dashboard_model->update_db('email_blast_1', ['id'=>$id], ['send_email'=>1]);
            }else{ 
                $this->dashboard_model->update_db('email_blast_1', ['id'=>$id], ['send_email'=>2]);
            }
        } 
        $this->buildResponse(200, 'send success');
    }
    function send_email_blast_customer_confirm_2(){ 
        $send_blast_db = 'email_blast_2';
        $send_blast_type = 'send_email_blast_2';
        exec('php /var/www/admin-my.indonet.id/index.php Api/send_email_blast_customer '.$send_blast_db.' '.$send_blast_type.' > /dev/null 2>&1 &'); 
        $this->buildResponse(200, 'send success'); 
    }

}