<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faktur_pajak extends MY_Controller { 
    public function check_fp_indonet(){
        $this->access_menu('faktur-pajak-indonet-view');
        $post = $this->input->post(); 
        if($post){
            $periode = $post['periode']; 
            $periode_num = date("Ym", strtotime($periode)); 
            $check_db = $this->dashboard_model->get_where_data_row('billing_faktur_info', ['periode'=>$periode_num, 'type'=>1, 'status'=>1]);  
            if($check_db){   
                if($check_db['status'] == 1){
                    $billing_status = $check_db['billing_status'];
                    $faktur_status = $check_db['faktur_status'];
                    $send_email_all = $check_db['send_email_all'];
                    $send_email_date = date("d F Y - H:i:s", strtotime($check_db['send_email_all_date'])); 
                    $this->buildResponse(200, 'Uploaded', ['billing_status'=>$billing_status, 'faktur_status'=>$faktur_status, 'send_email_all'=>$send_email_all, 
                                        'send_email_date'=>$send_email_date]);      
                }else{ 
                    $this->buildResponse(400, 'File '.$periode.' belum diupload', '[from=api]');   
                }
            }else{
                $this->buildResponse(400, 'File '.$periode.' belum diupload', '[from=db]');   
            }
        }else{
            $this->buildResponse(400, 'Error View');   
        }
    }
    public function upload_fp_indonet() {  
        $this->access_menu('faktur-pajak-indonet-add');
        $post = $this->input->post();  
        if ( isset($_FILES)) { 
            $file1 = $_FILES['file_to_upload_npwp']['tmp_name']; 
            $file2 = $_FILES['file_to_upload_non_npwp']['tmp_name'];  
			$ekstensi_npwp  = explode('.', $_FILES['file_to_upload_npwp']['name']); 
			$ekstensi_non_npwp  = explode('.', $_FILES['file_to_upload_non_npwp']['name']);  
			if (empty($file1) && empty($file2)) {  
                $this->buildResponse(400, 'File Upload not found');
			} else {
                $periode = $post['periode_upload']; 
                if($periode == null){
                    $this->buildResponse(400, 'Input Periode');
                }  
                $periode_num = date("my", strtotime($periode)); 
                $periode_num_folder = date("Ym", strtotime($periode)); 
                $type = 'check_billing_faktur_indonet';
                $url_api = 'https://api-my.indonet.id/billing';
                $post = array('type'=>$type, 'periode'=> $periode_num_folder); 
                $response = $this->curl->simple_post($url_api, $post);  
                $response = json_decode($response,true);    
                if($response){
                    $this->buildResponse(400, 'Billing Periode '.$periode.' sudah diupload');  
                }  
				if (strtolower(end($ekstensi_npwp)) === 'xlsx' && $_FILES["file_to_upload_npwp"]["size"] > 0) {  
                    $file_tmp = $_FILES['file_to_upload_npwp']['tmp_name'];
                    $file_name = $_FILES['file_to_upload_npwp']['name'];
                    $file_size =$_FILES['file_to_upload_npwp']['size'];
                    $file_type=$_FILES['file_to_upload_npwp']['type']; 
                     
                    $objPHPExcel = PHPExcel_IOFactory::load($file_tmp); 
                    $worksheet = $objPHPExcel->getSheet(0); 
                    $type = 'NPWP';
                    $highestRow = $worksheet->getHighestRow(); 
                    $highestColumn = $worksheet->getHighestColumn(); 
                    $count_npwp = 0;
                    for($row=2; $row<=$highestRow; $row++){ 
                        $faktur_pajak_id = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                        $faktur_pajak_complete = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                        $no_faktur_pajak_complete = str_replace('.','',$faktur_pajak_complete);
                        $no_faktur_pajak_complete = str_replace('-','',$no_faktur_pajak_complete); 
                        $no_npwp = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                        $no_npwp_file = str_replace('.','',$no_npwp);
                        $no_npwp_file = str_replace('-','',$no_npwp_file); 
                        $file_name_faktur = $no_faktur_pajak_complete.'-'.$no_npwp_file;
                        $cust_id = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                        $cust_name = $worksheet->getCellByColumnAndRow(5, $row)->getValue();

                        $data[] = array(
                            'faktur_pajak_id' => $faktur_pajak_id,
                            'faktur_pajak_complete' => $faktur_pajak_complete,
                            'no_npwp' => $no_npwp,
                            'cust_id'  => $cust_id,
                            'cust_name'  => $cust_name,
                            'cust_email'  => '0',
                            'type'  => $type,
                            'billing_code'  => 'SO-'.$periode_num.'-'.$cust_id,
                            'billing_file'  => 'SO-'.$periode_num.'-'.$cust_id.'.pdf',
                            'faktur_file'  => $file_name_faktur.'.pdf',
                            'billing_amount'  => 0, 
                            'send_email_date'  => 0,
                        );  
                        $count_npwp++;
                    }   
                }
				if(strtolower(end($ekstensi_non_npwp)) === 'xlsx' && $_FILES["file_to_upload_non_npwp"]["size"] > 0) {  
                    $file_tmp = $_FILES['file_to_upload_non_npwp']['tmp_name'];
                    $file_name = $_FILES['file_to_upload_non_npwp']['name'];
                    $file_size =$_FILES['file_to_upload_non_npwp']['size'];
                    $file_type=$_FILES['file_to_upload_non_npwp']['type']; 
                     
                    $objPHPExcel = PHPExcel_IOFactory::load($file_tmp); 
                    $worksheet = $objPHPExcel->getSheet(0); 
                    $type = 'NON-NPWP';
                    $highestRow = $worksheet->getHighestRow(); 
                    $highestColumn = $worksheet->getHighestColumn(); 
                    for($row=2; $row<=$highestRow; $row++){ 
                        $faktur_pajak_id = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                        $faktur_pajak_complete = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                        $no_npwp = 0; 
                        $cust_id = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                        $cust_name = $worksheet->getCellByColumnAndRow(5, $row)->getValue(); 
                        $data[] = array(
                            'faktur_pajak_id' => $faktur_pajak_id,
                            'faktur_pajak_complete' => $faktur_pajak_complete,
                            'no_npwp' => $no_npwp,
                            'cust_id'  => $cust_id,
                            'cust_name'  => $cust_name,
                            'cust_email'  => '0',
                            'type'  => $type,
                            'billing_code'  => 'SO-'.$periode_num.'-'.$cust_id,
                            'billing_file'  => 'SO-'.$periode_num.'-'.$cust_id.'.pdf',
                            'faktur_file'  => '-',
                            'billing_amount'  => 0, 
                            'send_email_date'  => 0,
                        );  
                    }   
                } 
                if($data != ''){
                    $type = 'upload_billing_faktur_indonet';
                    $url_api = 'https://api-my.indonet.id/billing';
                    $post = array('type'=>$type, 'periode'=> $periode_num_folder,'data'=>json_encode($data)); 
                    $response = $this->curl->simple_post($url_api, $post);    
                    if($response){   
                        $add_db = $this->dashboard_model->add_db('billing_faktur_info', ['periode'=>$periode_num_folder, 'type'=>1, 'created_date'=>date('d-m-Y H:i:s'), 
                                                                'created_by'=>$this->session->userdata('id'), 'count_npwp'=>$count_npwp]);
                        exec('php /var/www/admin-my.indonet.id/index.php Api/create_billing_indonet_by_periode_cust_id_pdf '.$periode_num_folder.' '.$periode_num.' > /dev/null 2>&1 &'); 
                        exec('php /var/www/admin-my.indonet.id/index.php Api/create_faktur_pajak_indonet_by_periode_cust_id_pdf '.$periode_num_folder.' > /dev/null 2>&1 &'); 
                        $this->buildResponse(200, 'Uploaded');      
                    }else{
                        $this->buildResponse(400, 'Error Upload file'); 
                    }  
                }else{
                    $this->buildResponse(400, 'Error Upload file'); 
                }
			}
        } 
    } 
    public function check_count_billing_faktur_indonet(){
        $this->access_menu('faktur-pajak-indonet-view');
        $post = $this->input->post(); 
        if($post){
            $periode = $post['periode']; 
            $periode_num_folder = date("Ym", strtotime($periode)); 
            $check_db = $this->dashboard_model->get_where_data_row('billing_faktur_info', ['periode'=>$periode_num_folder, 'type'=>1, 'status'=>1]);
            if($check_db){
                if($check_db['billing_status'] == 0 || $check_db['faktur_status'] == 0){ 
                    $type = 'check_count_billing_faktur_indonet';
                    $url_api = 'https://api-my.indonet.id/billing';
                    $post = array('type'=>$type, 'periode'=> $periode_num_folder); 
                    $response = $this->curl->simple_post($url_api, $post);  
                    $response = json_decode($response,true);     
                    if($response){
                        $percentage_billing = round($response['count_file_billing'] / $response['count_list'] * 100); 
                        $percentage_faktur = round($response['count_file_faktur'] / $check_db['count_npwp'] * 100); 
                        if($percentage_billing == 100){
                            $update_db = $this->dashboard_model->update_db('billing_faktur_info', ['periode'=>$periode_num_folder,'type'=>1, 'status'=>1], ['billing_status'=>1]);
                        }
                        if($percentage_faktur == 100){
                            $update_db = $this->dashboard_model->update_db('billing_faktur_info', ['periode'=>$periode_num_folder,'type'=>1, 'status'=>1], ['faktur_status'=>1]);
                        }
                        $res = array('percentage_billing'=>$percentage_billing, 'percentage_faktur'=>$percentage_faktur,
                                     'billing_status'=>$check_db['billing_status'], 'faktur_status'=>$check_db['faktur_status'], 
                                     'send_email_all'=>$check_db['send_email_all'],'send_email_all_date'=>$check_db['send_email_all_date']);
                        $this->buildResponse(200, 'Uploaded', $res);      
                    }else{ 
                        $this->buildResponse(400, 'File '.$periode.' belum diupload');   
                    }
                }else{
                    $res = array('percentage_billing'=>100, 'percentage_faktur'=>100,
                                 'billing_status'=>$check_db['billing_status'], 'faktur_status'=>$check_db['faktur_status'], 
                                 'send_email_all'=>$check_db['send_email_all'], 'send_email_all_date'=>$check_db['send_email_all_date']); 
                    $this->buildResponse(200, 'Uploaded', $res);      
                }
            }else{ 
                $this->buildResponse(400, 'File '.$periode.' belum diupload');  
            }
        }else{
            $this->buildResponse(400, 'Error View');   
        } 
    }  
    public function view_fp_indonet(){
        $this->access_menu('faktur-pajak-indonet-view');
        $post = $this->input->post(); 
        if($post){
            $periode = $post['periode'];  
            $periode_num_folder = date("Ym", strtotime($periode)); 
            $type = 'view_billing_faktur_indonet';
            $url_api = 'https://api-my.indonet.id/billing';
            $post = array('type'=>$type, 'periode'=> $periode_num_folder); 
            $response = $this->curl->simple_post($url_api, $post);   
            $response = json_decode($response,true);    
            $data = array('data'=>$response);
            echo json_encode($data);     
        }else{
            $this->buildResponse(400, 'Error View');   
        }
    }  
    public function get_pdf_billing_indonet(){
        $this->access_menu('faktur-pajak-indonet-view');
        $post = $this->input->post(); 
        if($post){ 
            $periode = $post['periode'];  
            $billing_name = $post['billing_name'];  
            $periode_folder = date("Ym", strtotime($periode)); 
            $type = 'get_pdf_billing_indonet';
            $url_api = 'https://api-my.indonet.id/billing';
            $post = array('type'=>$type, 'periode'=> $periode_folder, 'billing_name'=>$billing_name); 
            $response = $this->curl->simple_post($url_api, $post);   
            if($response){ 
                $path = json_decode($response, true);  
                $data = './files/temp/'.$billing_name;
                $url_biiling = './files/temp/'.$billing_name;
                file_put_contents($data, file_get_contents($path)); 
                $this->buildResponse(200, 'View', ['url_billing'=>$url_biiling]);  
            }else{
                $this->buildResponse(400, 'File Not Found');   
            }
        }else{
            $this->buildResponse(400, 'Error View');   
        }
    }  
    public function get_pdf_faktur_indonet(){
        $this->access_menu('faktur-pajak-indonet-view');
        $post = $this->input->post(); 
        if($post){ 
            $periode = $post['periode'];  
            $faktur_name = $post['faktur_name'];  
            $periode_folder = date("Ym", strtotime($periode)); 
            $type = 'get_pdf_faktur_indonet';
            $url_api = 'https://api-my.indonet.id/billing';
            $post = array('type'=>$type, 'periode'=> $periode_folder, 'faktur_name'=>$faktur_name); 
            $response = $this->curl->simple_post($url_api, $post);   
            if($response){ 
                $path = json_decode($response, true);   
                $url_faktur = './files/temp/'.$faktur_name;
                file_put_contents($url_faktur, file_get_contents($path)); 
                $this->buildResponse(200, 'View', ['url_faktur'=>$url_faktur]);  
            }else{
                $this->buildResponse(400, 'File Not Found');   
            }
        }else{
            $this->buildResponse(400, 'Error View');   
        }
    }
    public function send_all_billing_indonet(){
        $this->access_menu('faktur-pajak-indonet-add'); 
        $post = $this->input->post(); 
        if($post){
            $periode = $post['periode_view'];  
            $periode_num = date("my", strtotime($periode)); 
            $periode_num_folder = date("Ym", strtotime($periode)); 
            $check_db = $this->dashboard_model->get_where_data_row('billing_faktur_info', ['periode'=>$periode_num_folder, 'type'=>1, 'status'=>1]);  
            if($check_db['send_email_all']==0){ 
                $update_db = $this->dashboard_model->update_db('billing_faktur_info', ['periode'=>$periode_num_folder,'type'=>1, 'status'=>1], 
                                                                ['send_email_all'=>1, 'send_email_all_date'=>date('d-m-Y H:i:s')]);
                exec('php /var/www/admin-my.indonet.id/index.php Api/send_email_all_billing_indonet '.$periode_num_folder.' '.$periode_num.' > /dev/null 2>&1 &'); 
                $this->buildResponse(200, 'Send All E-mail in progress, view <a href="#" onclick="view_log_send_email_all(\''.$periode.'\')">logs.txt</a>');   
            }else{ 
                $this->buildResponse(400, 'All E-mail was sent on '.$check_db['send_email_all_date']);   
            } 
        }else{ 
            $this->buildResponse(400, 'Error send email');   
        }
    }
    public function send_email_billing_indonet(){
        $this->access_menu('faktur-pajak-indonet-add'); 
        $post = $this->input->post(); 
        if($post){
            $cust_id_post = $post['cust_id'];  
            $periode = $post['periode_view'];  
            $periode_num = date("my", strtotime($periode)); 
            $periode_folder = date("Ym", strtotime($periode)); 
            $check_db = $this->dashboard_model->get_where_data_row('billing_faktur_info', ['periode'=>$periode_folder, 'type'=>1, 'status'=>1]);  
            if($check_db['billing_status'] == 1 && $check_db['faktur_status'] == 1){ 
                $type = 'view_billing_faktur_indonet';
                $url_api = 'https://api-my.indonet.id/billing';
                $post = array('type'=>$type, 'periode'=> $periode_folder); 
                $response = $this->curl->simple_post($url_api, $post);   
                $file_data = json_decode($response, true);   
                foreach ($file_data as $key => $value) {    
                    $cust_id = $value['cust_id'];   
                    if($cust_id_post == $cust_id){
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
                            $post = array('type'=>$type, 'periode'=> $periode_num, 'periode_folder'=> $periode_folder, 'cust_id'=> $cust_id, 'cust_email'=>$cust_email_send,
                                        'cust_name'=>$cust_name, 'billing_amount'=>$billing_amount, 'billing_file'=>$billing_file, 'faktur_file'=>$faktur_file,
                                        'no_npwp'=>$no_npwp); 
                            $response = $this->curl->simple_post($url_api, $post);     
                        } 
                        break;
                    }
                }  
                $this->buildResponse(200, 'Send E-mail to '.$cust_name.' in progress, view <a href="#" onclick="view_log_send_email_all(\''.$periode.'\')">logs.txt</a>');   
            }else{ 
                $this->buildResponse(400, 'Send E-mail Error, Billing atau Faktur belum selesai dibuat');   
            } 
        }else{ 
            $this->buildResponse(400, 'Error send email');   
        } 
    }
    public function logs_send_all_billing_indonet(){
        $this->access_menu('faktur-pajak-indonet-view');
        $post = $this->input->post(); 
        if($post){ 
            $periode_view = $post['periode_view'];   
            $periode_folder = date("Ym", strtotime($periode_view)); 
            $logs_name_file = 'send_email_indonet_logs.txt';
            $type = 'get_logs_send_all_email';
            $url_api = 'https://api-my.indonet.id/emails';
            $post = array('type'=>$type, 'periode'=> $periode_folder, 'logs_name_file'=>$logs_name_file); 
            $response = $this->curl->simple_post($url_api, $post);   
            if($response){ 
                $logs_name = 'log_send_email_indonet_'.$periode_folder.'.txt';
                $path = json_decode($response, true);  
                $url_logs = './files/temp/'.$logs_name; 
                file_put_contents($url_logs, file_get_contents($path)); 
                $this->buildResponse(200, 'View', ['url_logs'=>$url_logs]);  
            }else{
                $this->buildResponse(400, 'File Not Found');   
            }
        }else{
            $this->buildResponse(400, 'Error View');   
        }
    }

    //alibaba
    public function check_fp_alibaba(){
        $this->access_menu('faktur-pajak-alibaba-view');
        $post = $this->input->post(); 
        if($post){
            $periode = $post['periode']; 
            $periode_num = date("Ym", strtotime($periode)); 
            $check_db = $this->dashboard_model->get_where_data_row('billing_faktur_info', ['periode'=>$periode_num, 'type'=>2, 'status'=>1]);  
            if($check_db){   
                if($check_db['status'] == 1){
                    $billing_status = $check_db['billing_status'];
                    $faktur_status = $check_db['faktur_status'];
                    $send_email_all = $check_db['send_email_all'];
                    $send_email_date = date("d F Y - H:i:s", strtotime($check_db['send_email_all_date'])); 
                    $this->buildResponse(200, 'Uploaded', ['billing_status'=>$billing_status, 'faktur_status'=>$faktur_status, 'send_email_all'=>$send_email_all, 
                                        'send_email_date'=>$send_email_date]);      
                }else{ 
                    $this->buildResponse(400, 'File '.$periode.' belum diupload', '[from=api]');   
                }
            }else{
                $this->buildResponse(400, 'File '.$periode.' belum diupload', '[from=db]');   
            }
        }else{
            $this->buildResponse(400, 'Error View');   
        }
    }
    public function upload_fp_alibaba() {  
        $this->access_menu('faktur-pajak-alibaba-add');
        $post = $this->input->post();  
        if ( isset($_FILES)) { 
            $file1 = $_FILES['file_to_upload_npwp']['tmp_name']; 
            $file2 = $_FILES['file_to_upload_non_npwp']['tmp_name'];  
			$ekstensi_npwp  = explode('.', $_FILES['file_to_upload_npwp']['name']); 
			$ekstensi_non_npwp  = explode('.', $_FILES['file_to_upload_non_npwp']['name']);  
			if (empty($file1) && empty($file2)) {  
                $this->buildResponse(400, 'File Upload not found');
			} else {
                $periode = $post['periode_upload']; 
                if($periode == null){
                    $this->buildResponse(400, 'Input Periode');
                }  
                $periode_num = date("my", strtotime($periode)); 
                $periode_num_folder = date("Ym", strtotime($periode)); 
                $type = 'check_billing_faktur_alibaba';
                $url_api = 'https://api-my.indonet.id/billing';
                $post = array('type'=>$type, 'periode'=> $periode_num_folder); 
                $response = $this->curl->simple_post($url_api, $post);  
                $response = json_decode($response,true);    
                if($response){
                    $this->buildResponse(400, 'Billing Periode '.$periode.' sudah diupload');  
                }  
				if (strtolower(end($ekstensi_npwp)) === 'xlsx' && $_FILES["file_to_upload_npwp"]["size"] > 0) {  
                    $file_tmp = $_FILES['file_to_upload_npwp']['tmp_name'];
                    $file_name = $_FILES['file_to_upload_npwp']['name'];
                    $file_size =$_FILES['file_to_upload_npwp']['size'];
                    $file_type=$_FILES['file_to_upload_npwp']['type']; 
                     
                    $objPHPExcel = PHPExcel_IOFactory::load($file_tmp); 
                    $worksheet = $objPHPExcel->getSheet(0); 
                    $type = 'NPWP';
                    $highestRow = $worksheet->getHighestRow(); 
                    $highestColumn = $worksheet->getHighestColumn(); 
                    $count_npwp = 0;
                    for($row=2; $row<=$highestRow; $row++){ 
                        $faktur_pajak_id = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                        $faktur_pajak_complete = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                        $no_faktur_pajak_complete = str_replace('.','',$faktur_pajak_complete);
                        $no_faktur_pajak_complete = str_replace('-','',$no_faktur_pajak_complete); 
                        $no_npwp = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                        $no_npwp_file = str_replace('.','',$no_npwp);
                        $no_npwp_file = str_replace('-','',$no_npwp_file); 
                        $file_name_faktur = $no_faktur_pajak_complete.'-'.$no_npwp_file;
                        $cust_id = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                        $cust_name = $worksheet->getCellByColumnAndRow(5, $row)->getValue();

                        $data[] = array(
                            'faktur_pajak_id' => $faktur_pajak_id,
                            'faktur_pajak_complete' => $faktur_pajak_complete,
                            'no_npwp' => $no_npwp,
                            'cust_id'  => $cust_id,
                            'cust_name'  => $cust_name,
                            'cust_email'  => '0',
                            'type'  => $type,
                            'billing_code'  => 'SO-'.$periode_num.'-'.$cust_id,
                            'billing_file'  => 'SO-'.$periode_num.'-'.$cust_id.'.pdf',
                            'faktur_file'  => $file_name_faktur.'.pdf',
                            'billing_amount'  => 0, 
                            'send_email_date'  => 0,
                        );  
                        $count_npwp++;
                    }   
                }
				if(strtolower(end($ekstensi_non_npwp)) === 'xlsx' && $_FILES["file_to_upload_non_npwp"]["size"] > 0) {  
                    $file_tmp = $_FILES['file_to_upload_non_npwp']['tmp_name'];
                    $file_name = $_FILES['file_to_upload_non_npwp']['name'];
                    $file_size =$_FILES['file_to_upload_non_npwp']['size'];
                    $file_type=$_FILES['file_to_upload_non_npwp']['type']; 
                     
                    $objPHPExcel = PHPExcel_IOFactory::load($file_tmp); 
                    $worksheet = $objPHPExcel->getSheet(0); 
                    $type = 'NON-NPWP';
                    $highestRow = $worksheet->getHighestRow(); 
                    $highestColumn = $worksheet->getHighestColumn(); 
                    for($row=2; $row<=$highestRow; $row++){ 
                        $faktur_pajak_id = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                        $faktur_pajak_complete = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                        $no_npwp = 0; 
                        $cust_id = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                        $cust_name = $worksheet->getCellByColumnAndRow(5, $row)->getValue(); 
                        $data[] = array(
                            'faktur_pajak_id' => $faktur_pajak_id,
                            'faktur_pajak_complete' => $faktur_pajak_complete,
                            'no_npwp' => $no_npwp,
                            'cust_id'  => $cust_id,
                            'cust_name'  => $cust_name,
                            'cust_email'  => '0',
                            'type'  => $type,
                            'billing_code'  => 'SO-'.$periode_num.'-'.$cust_id,
                            'billing_file'  => 'SO-'.$periode_num.'-'.$cust_id.'.pdf',
                            'faktur_file'  => '-',
                            'billing_amount'  => 0, 
                            'send_email_date'  => 0,
                        );  
                    }   
                } 
                if($data != ''){
                    $type = 'upload_billing_faktur_alibaba';
                    $url_api = 'https://api-my.indonet.id/billing';
                    $post = array('type'=>$type, 'periode'=> $periode_num_folder,'data'=>json_encode($data)); 
                    $response = $this->curl->simple_post($url_api, $post);    
                    if($response){   
                        $add_db = $this->dashboard_model->add_db('billing_faktur_info', ['periode'=>$periode_num_folder, 'type'=>2, 
                                                                'created_date'=>date('d-m-Y H:i:s'), 
                                                                'created_by'=>$this->session->userdata('id'), 'count_npwp'=>$count_npwp]);
                        exec('php /var/www/admin-my.indonet.id/index.php Api/create_billing_alibaba_by_periode_cust_id_pdf '.$periode_num_folder.' '.$periode_num.' > /dev/null 2>&1 &'); 
                        exec('php /var/www/admin-my.indonet.id/index.php Api/create_faktur_pajak_alibaba_by_periode_cust_id_pdf '.$periode_num_folder.' > /dev/null 2>&1 &'); 
                        $this->buildResponse(200, 'Uploaded');      
                    }else{
                        $this->buildResponse(400, 'Error Upload file'); 
                    }  
                }else{
                    $this->buildResponse(400, 'Error Upload file'); 
                }
			}
        } 
    }
    public function check_count_billing_faktur_alibaba(){
        $this->access_menu('faktur-pajak-alibaba-view');
        $post = $this->input->post(); 
        if($post){
            $periode = $post['periode']; 
            $periode_num_folder = date("Ym", strtotime($periode)); 
            $check_db = $this->dashboard_model->get_where_data_row('billing_faktur_info', ['periode'=>$periode_num_folder, 'type'=>2, 'status'=>1]);
            if($check_db){
                if($check_db['billing_status'] == 0 || $check_db['faktur_status'] == 0){ 
                    $type = 'check_count_billing_faktur_alibaba';
                    $url_api = 'https://api-my.indonet.id/billing';
                    $post = array('type'=>$type, 'periode'=> $periode_num_folder); 
                    $response = $this->curl->simple_post($url_api, $post);  
                    $response = json_decode($response,true);     
                    if($response){
                        $percentage_billing = round($response['count_file_billing'] / $response['count_list'] * 100); 
                        $percentage_faktur = round($response['count_file_faktur'] / $check_db['count_npwp'] * 100); 
                        if($percentage_billing == 100){
                            $update_db = $this->dashboard_model->update_db('billing_faktur_info', ['periode'=>$periode_num_folder,'type'=>2, 'status'=>1], ['billing_status'=>1]);
                        }
                        if($percentage_faktur == 100){
                            $update_db = $this->dashboard_model->update_db('billing_faktur_info', ['periode'=>$periode_num_folder,'type'=>2, 'status'=>1], ['faktur_status'=>1]);
                        }
                        $res = array('percentage_billing'=>$percentage_billing, 'percentage_faktur'=>$percentage_faktur,
                                     'billing_status'=>$check_db['billing_status'], 'faktur_status'=>$check_db['faktur_status'], 
                                     'send_email_all'=>$check_db['send_email_all'],'send_email_all_date'=>$check_db['send_email_all_date']);
                        $this->buildResponse(200, 'Uploaded', $res);      
                    }else{ 
                        $this->buildResponse(400, 'File '.$periode.' belum diupload');   
                    }
                }else{
                    $res = array('percentage_billing'=>100, 'percentage_faktur'=>100,
                                 'billing_status'=>$check_db['billing_status'], 'faktur_status'=>$check_db['faktur_status'], 
                                 'send_email_all'=>$check_db['send_email_all'], 'send_email_all_date'=>$check_db['send_email_all_date']); 
                    $this->buildResponse(200, 'Uploaded', $res);      
                }
            }else{ 
                $this->buildResponse(400, 'File '.$periode.' belum diupload');  
            }
        }else{
            $this->buildResponse(400, 'Error View');   
        } 
    }  
    public function view_fp_alibaba(){
        $this->access_menu('faktur-pajak-alibaba-view');
        $post = $this->input->post(); 
        if($post){
            $periode = $post['periode'];  
            $periode_num_folder = date("Ym", strtotime($periode)); 
            $type = 'view_billing_faktur_alibaba';
            $url_api = 'https://api-my.indonet.id/billing';
            $post = array('type'=>$type, 'periode'=> $periode_num_folder); 
            $response = $this->curl->simple_post($url_api, $post);   
            $response = json_decode($response,true);    
            $data = array('data'=>$response);
            echo json_encode($data);     
        }else{
            $this->buildResponse(400, 'Error View');   
        }
    }  
    public function get_pdf_billing_alibaba(){
        $this->access_menu('faktur-pajak-alibaba-view');
        $post = $this->input->post(); 
        if($post){ 
            $periode = $post['periode'];  
            $billing_name = $post['billing_name'];  
            $periode_folder = date("Ym", strtotime($periode)); 
            $type = 'get_pdf_billing_alibaba';
            $url_api = 'https://api-my.indonet.id/billing';
            $post = array('type'=>$type, 'periode'=> $periode_folder, 'billing_name'=>$billing_name); 
            $response = $this->curl->simple_post($url_api, $post);   
            if($response){ 
                $path = json_decode($response, true);  
                $data = './files/temp/'.$billing_name;
                $url_biiling = './files/temp/'.$billing_name;
                file_put_contents($data, file_get_contents($path)); 
                $this->buildResponse(200, 'View', ['url_billing'=>$url_biiling]);  
            }else{
                $this->buildResponse(400, 'File Not Found');   
            }
        }else{
            $this->buildResponse(400, 'Error View');   
        }
    }  
    public function get_pdf_faktur_alibaba(){
        $this->access_menu('faktur-pajak-alibaba-view');
        $post = $this->input->post(); 
        if($post){ 
            $periode = $post['periode'];  
            $faktur_name = $post['faktur_name'];  
            $periode_folder = date("Ym", strtotime($periode)); 
            $type = 'get_pdf_faktur_alibaba';
            $url_api = 'https://api-my.indonet.id/billing';
            $post = array('type'=>$type, 'periode'=> $periode_folder, 'faktur_name'=>$faktur_name); 
            $response = $this->curl->simple_post($url_api, $post);   
            if($response){ 
                $path = json_decode($response, true);   
                $url_faktur = './files/temp/'.$faktur_name;
                file_put_contents($url_faktur, file_get_contents($path)); 
                $this->buildResponse(200, 'View', ['url_faktur'=>$url_faktur]);  
            }else{
                $this->buildResponse(400, 'File Not Found');   
            }
        }else{
            $this->buildResponse(400, 'Error View');   
        }
    } 
    public function send_all_billing_alibaba(){
        $this->access_menu('faktur-pajak-indonet-add'); 
        $post = $this->input->post(); 
        if($post){
            $periode = $post['periode_view'];  
            $periode_num = date("my", strtotime($periode)); 
            $periode_num_folder = date("Ym", strtotime($periode)); 
            $check_db = $this->dashboard_model->get_where_data_row('billing_faktur_info', ['periode'=>$periode_num_folder, 'type'=>2, 'status'=>1]);  
            if($check_db['send_email_all']==0){ 
                $update_db = $this->dashboard_model->update_db('billing_faktur_info', ['periode'=>$periode_num_folder, 'type'=>2, 'status'=>1], 
                                                                ['send_email_all'=>1, 'send_email_all_date'=>date('d-m-Y H:i:s')]);
                exec('php /var/www/admin-my.indonet.id/index.php Api/send_email_all_billing_alibaba '.$periode_num_folder.' '.$periode_num.' > /dev/null 2>&1 &'); 
                $this->buildResponse(200, 'Send All E-mail in progress, view <a href="#" onclick="view_log_send_email_all(\''.$periode.'\')">logs.txt</a>');   
            }else{ 
                $this->buildResponse(400, 'All E-mail was sent on '.$check_db['send_email_all_date']);   
            } 
        }else{ 
            $this->buildResponse(400, 'Error send email');   
        }
    }
    public function send_email_billing_alibaba(){
        $this->access_menu('faktur-pajak-indonet-add'); 
        $post = $this->input->post(); 
        if($post){
            $cust_id_post = $post['cust_id'];  
            $periode = $post['periode_view'];  
            $periode_num = date("my", strtotime($periode)); 
            $periode_folder = date("Ym", strtotime($periode)); 
            $check_db = $this->dashboard_model->get_where_data_row('billing_faktur_info', ['periode'=>$periode_folder, 'type'=>2, 'status'=>1]);  
            if($check_db['billing_status'] == 1 && $check_db['faktur_status'] == 1){ 
                $type = 'view_billing_faktur_alibaba';
                $url_api = 'https://api-my.indonet.id/billing';
                $post = array('type'=>$type, 'periode'=> $periode_folder); 
                $response = $this->curl->simple_post($url_api, $post);   
                $file_data = json_decode($response, true);   
                foreach ($file_data as $key => $value) {    
                    $cust_id = $value['cust_id'];   
                    if($cust_id_post == $cust_id){
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
                            $post = array('type'=>$type, 'periode'=> $periode_num, 'periode_folder'=> $periode_folder, 'cust_id'=> $cust_id, 'cust_email'=>$cust_email_send,
                                        'cust_name'=>$cust_name, 'billing_amount'=>$billing_amount, 'billing_file'=>$billing_file, 'faktur_file'=>$faktur_file,
                                        'no_npwp'=>$no_npwp); 
                            $response = $this->curl->simple_post($url_api, $post);     
                        } 
                        break;
                    }
                }  
                $this->buildResponse(200, 'Send E-mail to '.$cust_name.' in progress, view <a href="#" onclick="view_log_send_email_all(\''.$periode.'\')">logs.txt</a>');   
            }else{ 
                $this->buildResponse(400, 'Send E-mail Error, Billing atau Faktur belum selesai dibuat');   
            } 
        }else{ 
            $this->buildResponse(400, 'Error send email');   
        } 
    }
    public function logs_send_all_billing_alibaba(){
        $this->access_menu('faktur-pajak-indonet-view');
        $post = $this->input->post(); 
        if($post){ 
            $periode_view = $post['periode_view'];   
            $periode_folder = date("Ym", strtotime($periode_view)); 
            $logs_name_file = 'send_email_alibaba_logs.txt';
            $type = 'get_logs_send_all_email';
            $url_api = 'https://api-my.indonet.id/emails';
            $post = array('type'=>$type, 'periode'=> $periode_folder, 'logs_name_file'=>$logs_name_file); 
            $response = $this->curl->simple_post($url_api, $post);   
            if($response){ 
                $logs_name = 'log_send_email_alibaba_'.$periode_folder.'.txt';
                $path = json_decode($response, true);  
                $url_logs = './files/temp/'.$logs_name; 
                file_put_contents($url_logs, file_get_contents($path)); 
                $this->buildResponse(200, 'View', ['url_logs'=>$url_logs]);  
            }else{
                $this->buildResponse(400, 'File Not Found');   
            }
        }else{
            $this->buildResponse(400, 'Error View');   
        }
    } 


    public function check_faktur_pajak(){
        $this->access_menu('faktur-pajak-indonet-view');
        $post = $this->input->post(); 
        if($post){
            $periode = $post['periode']; 
            $periode_num = date("Ym", strtotime($periode)); 
            $check_db = $this->dashboard_model->get_where_data_row('billing_faktur_info', ['periode'=>$periode_num, 'type'=>1, 'status'=>1]);  
            if($check_db){   
                if($check_db['status'] == 1){
                    $billing_status = $check_db['billing_status'];
                    $faktur_status = $check_db['faktur_status'];
                    $send_email_all = $check_db['send_email_all'];
                    $send_email_date = date("d F Y - H:i:s", strtotime($check_db['send_email_all_date'])); 
                    $this->buildResponse(200, 'Uploaded', ['billing_status'=>$billing_status, 'faktur_status'=>$faktur_status, 'send_email_all'=>$send_email_all, 
                                        'send_email_date'=>$send_email_date]);      
                }else{ 
                    $this->buildResponse(400, 'File '.$periode.' belum diupload', '[from=api]');   
                }
            }else{
                $this->buildResponse(400, 'File '.$periode.' belum diupload', '[from=db]');   
            }
        }else{
            $this->buildResponse(400, 'Error View');   
        }
    }

    function set_data_cust_list(){ 
        $this->access_menu('faktur-pajak-indonet-add');
        $post = $this->input->post();  
        if($post){   
            $periode = $post['periode']; 
            $list_corporate = $post['list_corporate']; 
            $list_retail = $post['list_retail']; 
            $list_personal = $post['list_personal']; 
            $user_id = $this->session->userdata('id'); 
            $periode_num = date("Ym", strtotime($periode)); 
            // $url_api = 'https://api-my.indonet.id/ax/set_cust_num_faktur_pajak_db';
            // $post = ['periode'=>$periode_num, 'list_corporate'=>$list_corporate, 'list_retail'=>$list_retail, 'list_personal'=>$list_personal, 'user_id'=>$this->session->userdata('id')]; 
            // $response = $this->curl->simple_post($url_api, $post);
            // if($response){   
                exec('php /var/www/admin-my.indonet.id/index.php Api/set_cust_data_faktur_pajak '.$periode_num.' '.$list_corporate.' '.$list_retail.' '.$list_personal.' '.$user_id.' > /dev/null 2>&1 &'); 
                $res = array('result'=>true); 
                $this->buildResponse(200, $res, 'OK'); 
            // }else{ 
            //     $res = array('result'=>false); 
            //     $this->buildResponse(200, $res, 'Error');
            // }
        }else{ 
            $this->buildResponse(400, 'Error Submit');    
        }
    }
    function view_data_cust_list_now(){ 
        $this->access_menu('faktur-pajak-indonet-view');
        $post = $this->input->post(); 
        if($post){
            $periode = $post['periode'];  
            $periode_num = date("Ym", strtotime($periode));  
            $url_api = 'https://api-my.indonet.id/ax/get_cust_data_faktur_pajak_db';
            $post = array('periode'=> $periode_num); 
            $response = $this->curl->simple_post($url_api, $post);   
            $response = json_decode($response,true); 
            if($response){
                $data = array('data'=>$response['data_list']);
                echo json_encode($data);  
            }  
        }else{
            $this->buildResponse(400, 'Error View');   
        }
    }
    function view_data_cust_list(){ 
        $this->access_menu('faktur-pajak-indonet-view');
        $post = $this->input->post(); 
        if($post){
            $periode = $post['periode'];  
            $periode_num = date("Ym", strtotime($periode));  
            $url_api = 'https://api-my.indonet.id/ax/get_cust_data_faktur_pajak';
            $post = array('periode'=> $periode_num); 
            $response = $this->curl->simple_post($url_api, $post);   
            $response = json_decode($response,true); 
            if($response){
                $data = array('data'=>$response['data_list'], 'data_billing'=>$response['data_billing']);
                echo json_encode($data);  
            }  
        }else{
            $this->buildResponse(400, 'Error View');   
        }
    }
    function check_count_data_cust_list(){ 
        $this->access_menu('faktur-pajak-indonet-view');
        $post = $this->input->post(); 
        if($post){
            $periode = $post['periode']; 
            $periode_num = date("Ym", strtotime($periode));  
            $url_api = 'https://api-my.indonet.id/billing/check_count_billing_faktur';
            $post = array('periode'=> $periode_num); 
            $response = $this->curl->simple_post($url_api, $post);  
            $response = json_decode($response,true);     
            if($response){
                if($response['result']){ 
                    $res_data = $response['data'];
                    $res = array('count_cust'=>$res_data['count_cust'], 'count_npwp'=>$res_data['count_npwp'], 'count_non_npwp'=>$res_data['count_non_npwp'],
                                 'count_billing'=>$res_data['count_billing'],'count_faktur'=>$res_data['count_faktur']);
                    $this->buildResponse(200, 'Uploaded', $res);      
                }else{
                    $this->buildResponse(400, 'File '.$periode.' belum diupload');   
                }
            } 
        }else{
            $this->buildResponse(400, 'Error View');   
        } 
    }
    function generate_billing_pdf_new(){
        $this->access_menu('faktur-pajak-indonet-view');
        $post = $this->input->post();  
        if($post){ 
            $periode = $post['periode']; 
            $billing_non_alibaba = $post['billing_non_alibaba']; 
            $billing_alibaba = $post['billing_alibaba']; 
            $billing_non_npwp = $post['billing_non_npwp']; 
            $billing_npwp = $post['billing_npwp']; 
            $alibaba_posting_date = $post['alibaba_posting_date']; 
            if($billing_alibaba == 1){
                if($alibaba_posting_date == ''){
                    $this->buildResponse(400, 'Input Alibaba Posting Date');     
                }
            }
            $periode_num = date("Ym", strtotime($periode));  
             
            exec('php /var/www/admin-my.indonet.id/index.php Api/create_billing_pdf_by_periode_new '.$periode_num.' '.$billing_non_alibaba.' '.$billing_alibaba.' '.$billing_non_npwp.' '.$billing_npwp.' '.$alibaba_posting_date.' > /dev/null 2>&1 &');  
            $this->buildResponse(200, 'Uploaded');     
        }else{
            $this->buildResponse(400, 'Error View');   
        }
    } 
    function check_count_data_cust_list_new(){ 
        $this->access_menu('faktur-pajak-indonet-view');
        $post = $this->input->post(); 
        if($post){
            $periode = $post['periode']; 
            $periode_num = date("Ym", strtotime($periode));  
            $url_api = 'https://api-my.indonet.id/billing/check_count_billing_faktur';
            $post = array('periode'=> $periode_num); 
            $response = $this->curl->simple_post($url_api, $post);  
            $response = json_decode($response,true);     
            if($response){
                if($response['result']){ 
                    $res_data = $response['data'];
                    // $res = array('count_cust'=>$res_data['count_cust'], 'count_npwp'=>$res_data['count_npwp'], 'count_non_npwp'=>$res_data['count_non_npwp'],
                    //              'count_billing'=>$res_data['count_billing'],'count_faktur'=>$res_data['count_faktur'], 
                    //              'alibaba_posting_date'=>$res_data['alibaba_posting_date'], 'billing_status'=>$res_data['billing_status'], 
                    //              'faktur_status'=>$res_data['faktur_status']);
                    $this->buildResponse(200, 'count data', $res_data);      
                }else{
                    $this->buildResponse(400, 'File '.$periode.' belum diupload');   
                }
            } 
        }else{
            $this->buildResponse(400, 'Error View');   
        } 
    }
    function generate_billing_pdf(){
        $this->access_menu('faktur-pajak-indonet-view');
        $post = $this->input->post(); 
        if($post){
            $periode = $post['periode']; 
            $periode_num = date("Ym", strtotime($periode));  
            exec('php /var/www/admin-my.indonet.id/index.php Api/create_billing_pdf_by_periode '.$periode_num.' > /dev/null 2>&1 &');  
            $this->buildResponse(200, 'Uploaded');     
        }else{
            $this->buildResponse(400, 'Error View');   
        }
    }
    function get_blacklist_data(){ 
        $this->access_menu('faktur-pajak-indonet-view');
        $url_api = 'https://api-my.indonet.id/billing/blacklist'; 
        $response = $this->curl->simple_get($url_api);  
        $response = json_decode($response,true); 
        if($response){
            if($response['data_list']){
                $data = array('data'=>$response['data_list']); 
            }else{ 
                $data = array('data'=>[]);
            }
            echo json_encode($data);  
        } 
    }
    function save_blacklist_data(){
        $this->access_menu('faktur-pajak-indonet-view');
        $post = $this->input->post(); 
        if($post){
            $cust_id = $post['cust_id'];
            $billing_type = $post['blacklist_type']; 
            $url_api = 'https://api-my.indonet.id/billing/save_blacklist';
            $post = array('cust_id'=>$cust_id, 'billing_type'=>$billing_type); 
            $response = $this->curl->simple_post($url_api, $post);  
            $res = json_decode($response, true);     
            if($res['result']){ 
                $this->buildResponse(200, 'Add Customer success');  
            }else{
                $this->buildResponse(400, 'Customer ID sudah terdaftar');   
            }     
        }else{
            $this->buildResponse(400, 'Error save');   
        }
    }
    function remove_blacklist_data(){
        $this->access_menu('faktur-pajak-indonet-view');
        $post = $this->input->post(); 
        if($post){
            $cust_id = $post['cust_id']; 
            $url_api = 'https://api-my.indonet.id/billing/remove_blacklist';
            $post = array('cust_id'=>$cust_id); 
            $response = $this->curl->simple_post($url_api, $post);  
            $res = json_decode($response, true);     
            if($res['result']){ 
                $this->buildResponse(200, 'Remove Customer success');  
            }else{
                $this->buildResponse(400, 'Customer ID sudah tidak terdaftar');   
            }     
        }else{
            $this->buildResponse(400, 'Error save');   
        }

    }
    function upload_blacklist_data(){
        $post = $this->input->post();  
        if ( isset($_FILES)) {  
            $files = $_FILES;
            $file1 = $_FILES['file_upload_blacklist']['tmp_name'];  
			$ekstensi_pdf  = explode('.', $files['file_upload_blacklist']['name']);  
			if (empty($file1)) {  
                $this->buildResponse(400, 'File Upload not found');
			} else { 
                if(strtolower(end($ekstensi_pdf)) === 'xlsx' && $files["file_upload_blacklist"]["size"] > 0){ 
                    $_FILES['userfile']['name']= $files['file_upload_blacklist']['name'];
                    $_FILES['userfile']['type']= $files['file_upload_blacklist']['type'];
                    $_FILES['userfile']['tmp_name']= $files['file_upload_blacklist']['tmp_name'];
                    $_FILES['userfile']['error']= $files['file_upload_blacklist']['error'];
                    $_FILES['userfile']['size']= $files['file_upload_blacklist']['size']; 
                    $filename_original =  $files['file_upload_blacklist']['name']; 
                    $filename_code = 'blacklist_'.rand(100,1000); 
                    $this->load->library('upload');  
                    $this->upload->initialize($this->set_upload_options($filename_code, 'temp')); 
                    $this->upload->data();   
                    if ($this->upload->do_upload()){     
                        exec('php /var/www/admin-my.indonet.id/index.php Api/upload_file_blacklist '.$filename_code.' > /dev/null 2>&1 &'); 
                        $this->buildResponse(200, 'Upload file Blacklist', $post);  
                    }else{  
                        $this->buildResponse(400, $this->upload->display_errors()); 
                    } 
                }else{ 
                    $this->buildResponse(400, 'Error Format file'); 
                }
            }
        }else{ 
            $this->buildResponse(400, 'File Upload not found'); 
        }  
    }
    function upload_pdf_fp(){   
        $post = $this->input->post();  
        if ( isset($_FILES)) {  
            $files = $_FILES;
            $file1 = $_FILES['file_pdf_fp']['tmp_name'];  
			$ekstensi_pdf  = explode('.', $files['file_pdf_fp']['name']);  
			if (empty($file1)) {  
                $this->buildResponse(400, 'File Upload not found');
			} else { 
                if(strtolower(end($ekstensi_pdf)) === 'pdf' && $files["file_pdf_fp"]["size"] > 0){
                    $periode = $post['periode_now'];
                    $periode_num = date("Ym", strtotime($periode));  
                    $_FILES['userfile']['name']= $files['file_pdf_fp']['name'];
                    $_FILES['userfile']['type']= $files['file_pdf_fp']['type'];
                    $_FILES['userfile']['tmp_name']= $files['file_pdf_fp']['tmp_name'];
                    $_FILES['userfile']['error']= $files['file_pdf_fp']['error'];
                    $_FILES['userfile']['size']= $files['file_pdf_fp']['size']; 
                    $filename_original =  $files['file_pdf_fp']['name']; 
                    $filename_code = 'faktur_pajak_'.$periode_num.'_'.rand(100,1000); 
                    $this->load->library('upload');  
                    $this->upload->initialize($this->set_upload_options($filename_code, 'temp')); 
                    $this->upload->data();  
                    $filename_upload = $filename_code.'.'.strtolower(end($ekstensi_pdf));     
                    if ($this->upload->do_upload()){     
                        exec('php /var/www/admin-my.indonet.id/index.php Api/split_pdf_periode '.$periode_num.' '.$filename_code.' > /dev/null 2>&1 &'); 
                        $this->buildResponse(200, 'Upload file PDF Faktur Pajak', $post);  
                    }else{  
                        $this->buildResponse(400, $this->upload->display_errors()); 
                    } 
                }else{ 
                    $this->buildResponse(400, 'Error Format file'); 
                }
            }
        }else{ 
            $this->buildResponse(400, 'File Upload not found'); 
        }            
    }
    function upload_list_fp(){   
        $post = $this->input->post();  
        $periode = $post['periode_now'];
        $periode_num = date("Ym", strtotime($periode));   
        if ( isset($_FILES)) {  
            $files = $_FILES;
            $file1 = $_FILES['file_pdf_fp']['tmp_name'];  
			$ekstensi_pdf  = explode('.', $files['file_pdf_fp']['name']);  
			if (empty($file1)) {  
                $this->buildResponse(400, 'File Upload not found');
			} else { 
                if(strtolower(end($ekstensi_pdf)) === 'pdf' && $files["file_pdf_fp"]["size"] > 0){
                    $_FILES['userfile']['name']= $files['file_pdf_fp']['name'];
                    $_FILES['userfile']['type']= $files['file_pdf_fp']['type'];
                    $_FILES['userfile']['tmp_name']= $files['file_pdf_fp']['tmp_name'];
                    $_FILES['userfile']['error']= $files['file_pdf_fp']['error'];
                    $_FILES['userfile']['size']= $files['file_pdf_fp']['size']; 
                    $filename_original =  $files['file_pdf_fp']['name']; 
                    $filename_code = 'faktur_pajak_'.$periode_num.'_'.rand(100,1000); 
                    $this->load->library('upload');  
                    $this->upload->initialize($this->set_upload_options($filename_code, 'temp')); 
                    $this->upload->data();  
                    $filename_upload = $filename_code.'.'.strtolower(end($ekstensi_pdf));     
                    if ($this->upload->do_upload()){     
                        exec('php /var/www/admin-my.indonet.id/index.php Api/split_pdf_periode '.$periode_num.' '.$filename_code.' > /dev/null 2>&1 &'); 
                        $this->buildResponse(200, 'Upload file PDF Faktur Pajak', $post);  
                    }else{  
                        $this->buildResponse(400, $this->upload->display_errors()); 
                    } 
                }else{ 
                    $this->buildResponse(400, 'Error Format file'); 
                }
            }
        }else{ 
            $this->buildResponse(400, 'File Upload not found'); 
        }            
    }
    function upload_excel_fp(){ 
        $post = $this->input->post();  
        $periode = $post['periode_now'];
        $periode_num = date("Ym", strtotime($periode));  
        $url_api = 'https://api-my.indonet.id/billing/check_count_billing_faktur';
        $post = array('periode'=> $periode_num); 
        $response = $this->curl->simple_post($url_api, $post);  
        $response = json_decode($response,true);     
        if($response){
            if($response['result']){ 
                $res_data = $response['data'];
                if($res_data['upload_faktur_pdf_status'] == 0){
                    $this->buildResponse(400, 'File Faktur Pajak PDF belum diupload');  
                }else if($res_data['upload_faktur_pdf_status'] == 2){
                    $this->buildResponse(400, 'File Faktur Pajak PDF belum selesai diproses');  
                }
            }
        } 
        if ( isset($_FILES)) {  
            $files = $_FILES;
            $file1 = $_FILES['file_excel_fp']['tmp_name'];  
			$ext  = explode('.', $files['file_excel_fp']['name']);  
			if (empty($file1)) {  
                $this->buildResponse(400, 'File Upload not found');
			} else { 
                if(strtolower(end($ext)) === 'xlsx' && $files["file_excel_fp"]["size"] > 0){
                    $_FILES['userfile']['name']= $files['file_excel_fp']['name'];
                    $_FILES['userfile']['type']= $files['file_excel_fp']['type'];
                    $_FILES['userfile']['tmp_name']= $files['file_excel_fp']['tmp_name'];
                    $_FILES['userfile']['error']= $files['file_excel_fp']['error'];
                    $_FILES['userfile']['size']= $files['file_excel_fp']['size']; 
                    $filename_original =  $files['file_excel_fp']['name']; 
                    $filename_code = 'faktur_pajak_list_'.$periode_num.'_'.rand(100,1000); 
                    $this->load->library('upload');  
                    $this->upload->initialize($this->set_upload_options($filename_code, 'temp')); 
                    $this->upload->data();  
                    $filename_upload = $filename_code.'.'.strtolower(end($ext));     
                    if ($this->upload->do_upload()){     
                        exec('php /var/www/admin-my.indonet.id/index.php Api/set_list_pf_periode '.$periode_num.' '.$filename_code.' > /dev/null 2>&1 &'); 
                        $this->buildResponse(200, 'Upload file List Excel Faktur Pajak', $post);  
                    }else{  
                        $this->buildResponse(400, $this->upload->display_errors()); 
                    } 
                }else{ 
                    $this->buildResponse(400, 'Error Format file'); 
                }
            }
        }else{ 
            $this->buildResponse(400, 'File Upload not found'); 
        }  
    }
    function send_email_billing_fp(){        
        $this->access_menu('faktur-pajak-indonet-add'); 
        $post = $this->input->post();  
        if($post){  
            $send_corporate = $post['send_corporate'];  
            $send_retail = $post['send_retail'];  
            $send_personal = $post['send_personal'];  
            $send_non_alibaba = $post['send_non_alibaba'];  
            $send_alibaba = $post['send_alibaba'];  
            $send_npwp = $post['send_npwp'];  
            $send_non_npwp = $post['send_non_npwp'];  
            $periode = $post['periode'];  
            $periode_num = date("Ym", strtotime($periode));   
            exec(   'php /var/www/admin-my.indonet.id/index.php Api/send_billing_pf_periode '.$periode_num.' '.$send_corporate.' '.$send_retail.' '.$send_personal.' '.$send_non_alibaba.' '.$send_alibaba.' '.$send_npwp.' '.$send_non_npwp.' > /dev/null 2>&1 &');  
            $this->buildResponse(200, 'Send E-mail in progress...'); 
        }else{ 
            $this->buildResponse(400, 'Error send email');   
        }
    }
    function set_upload_options($file_name, $folder){    
        $config = array();
        $config['file_name'] = $file_name;
        $config['upload_path'] = './files/'.$folder.'/';
        $config['allowed_types'] = '*';
        $config['max_size'] = '0'; // 0 = no file size limit
        $config['max_width']  = '0';
        $config['max_height']  = '0';
        $config['overwrite'] = TRUE;  
        return $config;
    }
    function get_data_list_by_id(){
        $this->access_menu('faktur-pajak-indonet-add'); 
        $post = $this->input->post(); 
        if($post){
            $list_id = $post['list_id'];
            $url_api = 'https://api-my.indonet.id/billing/get_cust_data_by_id';
            $post = array('id'=>$list_id); 
            $response = $this->curl->simple_post($url_api, $post);  
            $res = json_decode($response, true);     
            if($res['result']){ 
                $this->buildResponse(200, 'success', $res['data']);  
            }else{
                $this->buildResponse(400, 'Customer ID sudah tidak terdaftar');   
            }     
        }else{
            $this->buildResponse(400, 'Error get data');   
        }
    }
    function send_email_billing_fp_single(){
        $this->access_menu('faktur-pajak-indonet-add'); 
        $post = $this->input->post();  
        if($post){  
            $list_id = $post['list_id'];    
            exec(   'php /var/www/admin-my.indonet.id/index.php Api/send_billing_pf_single '.$list_id.' > /dev/null 2>&1 &');  
            $this->buildResponse(200, 'Send E-mail in progress...'); 
        }else{ 
            $this->buildResponse(400, 'Error send email');   
        }
    }
    function view_billing_mini(){
        $this->access_menu('faktur-pajak-indonet-view'); 
        $post = $this->input->post();  
        if($post){  
            $cust_id = $post['cust_id'];    
            $periode = $post['periode'];  
            $periode_num = date("Ym", strtotime($periode));    
            $url_api = 'https://api-my.indonet.id/billing/view_billing_mini';
            $post = array('cust_id'=>$cust_id, 'periode'=>$periode_num); 
            $response = $this->curl->simple_post($url_api, $post);  
            $res = json_decode($response, true);     
            if($res['result']){ 
                $data_ax = $res['data'];
                $this->data_inv['data_cust'] = $data_ax[0]; 
                $this->data_inv['inv_detail_bill'] = $data_ax['INV_DETAIL_DATA']; 
                $this->data_inv['inv_month_bill'] = $data_ax['INV_MONTH_TOTAL']; 
                $this->data_inv['virtual_acc_bca'] = $data_ax['VIRTUAL_ACC'][0];  
            }else{
                $this->data_inv['data_cust'] = []; 
            }     
            $this->load->view('admin/billing_view_mini', $this->data_inv);
        }else{ 
            $this->buildResponse(400, 'Error send email');   
        }
    }
    function view_faktur_mini(){
        $this->access_menu('faktur-pajak-indonet-view'); 
        $post = $this->input->post();  
        if($post){  
            $cust_id = $post['cust_id'];    
            $periode = $post['periode'];  
            $periode_num = date("Ym", strtotime($periode));    
            $url_api = 'https://api-my.indonet.id/billing/view_faktur_mini';
            $post = array('cust_id'=>$cust_id, 'periode'=>$periode_num); 
            $response = $this->curl->simple_post($url_api, $post);  
            $res = json_decode($response, true);     
            if($res['result']){ 
                $data_ax = $res['data'];
                $this->data_faktur['url_faktur'] = $data_ax['url'];  
            }else{
                $this->data_faktur['url_faktur'] = ''; 
            }     
            $this->load->view('admin/faktur_view_mini', $this->data_faktur); 
        }else{ 
            $this->buildResponse(400, 'Error send email');   
        }
    } 
}