<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
/*
| -------------------------------------------------------------------
| EMAIL CONFIG
| -------------------------------------------------------------------
| Konfigurasi email keluar melalui mail server
| */   
$config['protocol'] = 'smtp';
$config['smtp_host'] = "mail.indonet.co.id";
$config['smtp_port'] = "25";
$config['smtp_user']='my.indonet@indonet.co.id'; 
$config['smtp_pass']='myIndonet2021#'; 
$config['charset']='utf-8'; 
$config['newline']="\r\n";
$config['mailtype']="html";
$config['charset']="utf-8";
$config['priority']="0";   