<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['redirect'] = 'welcome';
// view menu
$route['dashboard'] = 'dashboard';
$route['account'] = 'dashboard/account';
$route['customer-list'] = 'dashboard/customer_list';
$route['admin-user-list'] = 'dashboard/admin_user';
$route['send-email-blast-customer-list'] = 'dashboard/send_email_blast_customer_list';
$route['send-email-blast-customer-confirm-1'] = 'emails_blast/send_email_blast_customer_confirm_1';
$route['send-email-blast-customer-confirm-2'] = 'emails_blast/send_email_blast_customer_confirm_2';


$route['faktur-pajak-indonet-list'] = 'dashboard/faktur_pajak_indonet_list';
$route['faktur-pajak-black-list'] = 'dashboard/faktur_pajak_blacklist_list';

$route['faktur-pajak-alibaba-list'] = 'dashboard/faktur_pajak_alibaba_list'; 

//end menu
// customer 
$route['get-customer-list'] = 'customer/get_data_cust_list_ax_json';
$route['get-customer-info'] = 'customer/get_customer_info_page';
$route['get_customer_info_div'] = 'customer/get_customer_info_div';
$route['get-customer-info-by-cust-id'] = 'customer/get_customer_info_by_id';

$route['check-faktur-pajak-indonet'] = 'faktur_pajak/check_fp_indonet';
$route['upload-faktur-pajak-indonet'] = 'faktur_pajak/upload_fp_indonet';
$route['upload-pdf-fakur-pajak'] = 'faktur_pajak/upload_pdf_fp';
$route['upload-excel-fakur-pajak'] = 'faktur_pajak/upload_excel_fp';
$route['send-billing-faktur-pajak'] = 'faktur_pajak/send_email_billing_fp';
$route['send-billing-faktur-pajak-single'] = 'faktur_pajak/send_email_billing_fp_single';
$route['view-billing-mini'] = 'faktur_pajak/view_billing_mini';
$route['view-faktur-mini'] = 'faktur_pajak/view_faktur_mini';
 
$route['view-faktur-pajak-indonet'] = 'faktur_pajak/view_fp_indonet';
$route['create-billing-indonet'] = 'faktur_pajak/create_bill_pdf_indonet';
$route['view-billing-indonet-pdf'] = 'faktur_pajak/get_pdf_billing_indonet';
$route['view-faktur-indonet-pdf'] = 'faktur_pajak/get_pdf_faktur_indonet';
$route['check-count-billing-faktur-indonet-pdf'] = 'faktur_pajak/check_count_billing_faktur_indonet';
$route['send-email-billing-indonet'] = 'faktur_pajak/send_email_billing_indonet';
$route['send-all-billing-indonet'] = 'faktur_pajak/send_all_billing_indonet';
$route['view-log-send-email-all-billing-indonet'] = 'faktur_pajak/logs_send_all_billing_indonet';

$route['check-faktur-pajak'] = 'faktur_pajak/check_faktur_pajak';
$route['set-list-faktur-pajak'] = 'faktur_pajak/set_data_cust_list'; 
$route['view-list-faktur-pajak'] = 'faktur_pajak/view_data_cust_list';
$route['view-list-faktur-pajak-month-now'] = 'faktur_pajak/view_data_cust_list_now';



$route['get-billing-pdf-new'] = 'faktur_pajak/generate_billing_pdf_new';
$route['check-count-faktur-pajak-new'] = 'faktur_pajak/check_count_data_cust_list_new';

$route['check-count-faktur-pajak'] = 'faktur_pajak/check_count_data_cust_list';
$route['get-billing-pdf'] = 'faktur_pajak/generate_billing_pdf';
$route['get-blacklist-data'] = 'faktur_pajak/get_blacklist_data';
$route['save-blacklist-data'] = 'faktur_pajak/save_blacklist_data';
$route['remove-blacklist-data'] = 'faktur_pajak/remove_blacklist_data';
$route['upload-blacklist'] = 'faktur_pajak/upload_blacklist_data';
$route['get-cust-data-billing-id'] = 'faktur_pajak/get_data_list_by_id';



$route['check-faktur-pajak-alibaba'] = 'faktur_pajak/check_fp_alibaba';
$route['upload-faktur-pajak-alibaba'] = 'faktur_pajak/upload_fp_alibaba';

$route['view-faktur-pajak-alibaba'] = 'faktur_pajak/view_fp_alibaba';
$route['create-billing-alibaba'] = 'faktur_pajak/create_bill_pdf_alibaba';
$route['view-billing-alibaba-pdf'] = 'faktur_pajak/get_pdf_billing_alibaba';
$route['view-faktur-alibaba-pdf'] = 'faktur_pajak/get_pdf_faktur_alibaba';
$route['check-count-billing-faktur-alibaba-pdf'] = 'faktur_pajak/check_count_billing_faktur_alibaba';
$route['send-email-billing-alibaba'] = 'faktur_pajak/send_email_billing_alibaba';
$route['send-all-billing-alibaba'] = 'faktur_pajak/send_all_billing_alibaba';
$route['view-log-send-email-all-billing-alibaba'] = 'faktur_pajak/logs_send_all_billing_alibaba';

$route['default_controller'] = 'auth';
$route['login'] = 'auth';
$route['generated_data'] = 'welcome/generated_data'; 
$route['check_generated_data'] = 'welcome/check_generated_data';
$route['create_inv_blesta'] = 'dashboard/create_inv_blesta'; 
$route['check_current_pass'] = 'dashboard/check_current_pass';  
$route['transaction_info'] = 'dashboard/transaction_info';
$route['product_info'] = 'dashboard/product_info';
$route['billing_statement'] = 'dashboard/billing_statement';
$route['report'] = 'dashboard/report';
$route['payment_info'] = 'dashboard/payment_info';
$route['get_inv_view'] = 'dashboard/get_inv_view'; 
$route['get_inv_pdf'] = 'dashboard/get_inv_pdf_new';


$route['admin-payment-list'] = 'dashboard/payment_info';
$route['admin_report'] = 'dashboard/admin_report';
$route['admin_domain'] = 'dashboard/admin_domain';
$route['management-vendor'] = 'dashboard/management_vendor';
$route['submit-vendor'] = 'dashboard/submit_vendor';
$route['view-vendor'] = 'dashboard/view_vendor';
$route['get_company_name'] = 'dashboard/get_company_name';
$route['get_company_name_by_id'] = 'dashboard/get_company_name_by_id';


$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
