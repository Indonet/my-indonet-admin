<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends AUTH_Controller { 
    public function index() {
        if ($this->session->userdata('islogin') && $this->session->userdata('is_subnet_admin') == 1) {            
            $this->load->helper('cookie');
            $cookie = $this->input->cookie('ci_cookie_myportal'); // we get the cookie
            $this->input->set_cookie('ci_cookie_myportal', $cookie, '86400');
            redirect('dashboard');
        } else if ($this->session->userdata('islogin') && $this->session->userdata('is_subnet_admin') == 0) {
            redirect('dashboard');
        } else { 
            $memcache = new Memcached;
            $memEnable = $memcache->addServer('localhost', 11211);
            $ip = $_SERVER['REMOTE_ADDR'];
            $expiration = 1800;

            $key = "mp_login_ip_" . $ip;
            if ($memEnable && $cdata = $memcache->get($key)) {
                $login_try = unserialize($cdata);
                $ses_login_try = $login_try;
            } else {
                $ses_login_try = $this->session->userdata('wrongCount');
            }
            if ($ses_login_try == null) {
                $ses_login_try = 0;
            }
            $this->session->set_userdata(array('wrongCount' => $ses_login_try));
            $this->load->view('auth/login');
        }
    }
    
    public function checklogin() {
        $this->checkPostData();
        $post = $this->input->post();
        $username = $post['username'];
        $password = $post['password'];    
        if($username != '' && $password != ''){ 
            $user_data = $this->hash_login($username, $password);   
            $client_ip = $this->get_client_ip();   
            if($user_data){
                $status = $user_data['status'];
                if($status != 0){  
                    $is_admin = $user_data['is_admin'];
                    $cust_id = $user_data['CUSTID'];
                    $subnet_code = $user_data['subnets'];
                    if($is_admin == 1){   
                        $this->set_session_user($user_data); 
                        $res = array('result' => TRUE, 'message' => 'Login success', 'is_admin'=> $user_data['is_admin']); 
                    }else{ 
                        $res = array('result' => TRUE, 'message' => 'Login success', 'is_admin'=> $user_data['is_admin']);
                    }
                }else{
                    $res = array('result' => FALSE, 'message' => 'User inactive');
                }
            }else{ 
                $res = array('result' => FALSE, 'message' => 'Incorrect username or password');
            }
        }else{
            $res = array('result' => FALSE, 'message' => 'Input invalid');
        } 
        echo json_encode($res); 
    }
    public function logout() {
        $this->session->sess_destroy();
        redirect('login');
    }
}