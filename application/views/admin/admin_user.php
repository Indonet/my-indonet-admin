<link href="<?=base_url()?>assets/themes/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
<style>
    .body_table {
        position: relative;
        overflow: hidden;
        width: 100%;
        height: 100%;  
    } 
    #slide {
        position: absolute;
        right: -100%;
        width: 100%;
        /* height: 100%;  */
        background: #e6e7f1;
        transition: 1s;
        z-index: 9;
    } 
</style>
<div class="content d-flex flex-column flex-column-fluid" id="kt_content"> 
	<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
		<div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap"> 
			<div class="d-flex align-items-center flex-wrap mr-2">  
				<h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Dashboard</h5>   
			</div> 
		</div>
	</div> 
    <div class="d-flex flex-column-fluid"> 
        <div class="container-fluid"> 
            <div class="row">
                <div class="col-lg-12 col-xl-12 col-md-12">  
                    <div class="card card-custom gutter-b"> 
                        <div class="card-header border-0 py-5">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label font-weight-bolder text-dark">User List Login</span> 
                            </h3>  
                            <div class="card-toolbar">
                                <a href="#" class="btn btn-light-primary font-weight-bolder mr-2" onclick="add_new_user()">
                                <i class="la la-folder-plus"></i>New User Login</i>
                                </a> 
                            </div>
                        </div>  
                        <div class="card-body div_list"> 
                            <table class="table table-bordered table-checkable" id="list_user_login">
                                <thead>
                                    <tr> 
                                        <th class="text-center">Cust ID</th>
                                        <th class="text-center">User Login</th> 
                                        <th class="text-center">Password Type</th>
                                        <th class="text-center">Custpmer Type</th>
                                        <th class="text-center">Blesta ID</th>
                                        <th class="text-center">Status</th>  
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        foreach ($data_list_user_login as $key => $value) {
                                            $cust_id = $value['CUSTID'];
                                            $username = $value['username'];
                                            $is_external = $value['is_external'];
                                            $cust_type = $value['cust_type'];
                                            $type_pass = 'MyIndonet';
                                            if($is_external == 1){
                                                $type_pass = 'LDAP indo.net.id';
                                            }
                                            $is_admin = $value['is_admin'];
                                            $type_user = 'Customer';
                                            if($is_admin == 1){
                                                $type_user = 'Admin / Subnet';
                                            }
                                            $blesta_id = $value['blesta_id'];
                                            $status = $value['status']; 
                                            $status_user = 'Active';
                                            if($status == 0){
                                                $status_user = 'NonActive';
                                            }
                                            echo '<tr>';
                                            echo '<td>'.$cust_id.'</td>';    
                                            echo '<td>'.$username.'</td>';    
                                            echo '<td>'.$type_pass.'</td>';    
                                            echo '<td>'.$cust_type.'</td>';    
                                            echo '<td>'.$blesta_id.'</td>';    
                                            echo '<td>'.$status_user.'</td>';    
                                            echo '</tr>';
                                        }
                                    ?>
                                </tbody>
                            </table> 
                        </div>
                    </div>  

                    
                    <div class="card card-custom gutter-b"> 
                        <div class="card-header border-0 py-5">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label font-weight-bolder text-dark">User ALL Indonet</span> 
                            </h3>   
                        </div>  
                        <div class="card-body div_list"> 
                            <table class="table table-bordered table-checkable" id="list_user_all">
                                <thead>
                                    <tr> 
                                        <th class="text-center">Cust ID</th>
                                        <th class="text-center">Customer Name</th> 
                                        <th class="text-center">Subnet</th>
                                        <th class="text-center">Custpmer Type</th> 
                                        <th class="text-center">Customer Status</th>  
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        foreach ($data_ax_customer_list as $key => $value) {
                                            $cust_id = $value['cust_id'];
                                            $cust_name = $value['cust_name'];
                                            $cust_subnet_name = $value['cust_subnet_name'];
                                            $cust_status_name = $value['cust_status_name'];
                                            $cust_type = $value['cust_type']; 
                                            echo '<tr>';
                                            echo '<td>'.$cust_id.'</td>';    
                                            echo '<td>'.$cust_name.'</td>';    
                                            echo '<td>'.$cust_subnet_name.'</td>';    
                                            echo '<td>'.$cust_type.'</td>';        
                                            echo '<td>'.$cust_status_name.'</td>';  
                                            echo '</tr>';
                                        }
                                    ?>
                                </tbody>
                            </table> 
                        </div>
                    </div>  

                    <div class="card card-custom gutter-b"> 
                        <div class="card-header border-0 py-5">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label font-weight-bolder text-dark">Data User Upload FM</span> 
                            </h3>  
                            <div class="card-toolbar">
                                <a href="#" class="btn btn-light-primary font-weight-bolder mr-2" onclick="add_upload_user_fm()">
                                <i class="la la-folder-plus"></i>Upload User</i>
                                </a> 
                            </div>
                        </div>  
                        <div class="card-body div_list"> 
                                    <table class="table table-bordered table-checkable" id="list_user_upload_fm">
                                        <thead>
                                            <tr> 
                                                <th class="text-center">Cust ID</th>
                                                <th class="text-center">Email</th>   
                                                <th class="text-center">Status</th> 
                                                <th class="text-center">Send Email</th> 
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                // foreach ($data_list_token as $key => $value) {
                                                //     $email = $value['email'];
                                                //     $cust_id = $value['cust_id'];
                                                //     $send_email = $value['send_email'];
                                                //     $send_email_name = '<a href="#" class="btn btn-link-warning font-weight-bold mr-2">Send Now</a>';
                                                //     if($send_email == 1){
                                                //         $send_email_name = '<i class="icon-md far fa-check-circle"></i>';
                                                //     }
                                                //     $status = $value['status'];
                                                //     $status_name = '<i class="icon-md fas fa-minus-circle"></i>';  
                                                //     echo '<tr>';
                                                //     echo '<td>'.$cust_id.'</td>';    
                                                //     echo '<td>'.$email.'</td>';    
                                                //     echo '<td class="text-center">'.$status_name.'</td>';    
                                                //     echo '<td class="text-center">'.$send_email_name.'</td>';     
                                                //     echo '</tr>';
                                                // }
                                            ?>
                                        </tbody>
                                    </table> 
                        </div>   
                    </div>    
                    <div class="card card-custom gutter-b"> 
                        <div class="card-header border-0 py-5">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label font-weight-bolder text-dark">User Upload Register</span> 
                            </h3>  
                            <div class="card-toolbar">
                                <a href="#" class="btn btn-light-primary font-weight-bolder mr-2" onclick="add_upload_user()">
                                <i class="la la-folder-plus"></i>Upload User</i>
                                </a> 
                            </div>
                        </div>  
                        <div class="card-body div_list"> 
                            <table class="table table-bordered table-checkable" id="list_user_upload">
                                <thead>
                                    <tr> 
                                        <th class="text-center">Cust ID</th>
                                        <th class="text-center">Email</th>   
                                        <th class="text-center">Status</th> 
                                        <th class="text-center">Send Email</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $data_list_token = array(); //data demo
                                        foreach ($data_list_token as $key => $value) {
                                            $email = $value['email'];
                                            $cust_id = $value['cust_id'];
                                            $send_email = $value['send_email'];
                                            $send_email_name = '<a href="#" class="btn btn-link-warning font-weight-bold mr-2">Send Now</a>';
                                            if($send_email == 1){
                                                $send_email_name = '<i class="icon-md far fa-check-circle"></i>';
                                            }
                                            $status = $value['status'];
                                            $status_name = '<i class="icon-md fas fa-minus-circle"></i>';  
                                            echo '<tr>';
                                            echo '<td>'.$cust_id.'</td>';    
                                            echo '<td>'.$email.'</td>';    
                                            echo '<td class="text-center">'.$status_name.'</td>';    
                                            echo '<td class="text-center">'.$send_email_name.'</td>';     
                                            echo '</tr>';
                                        }
                                    ?>
                                </tbody>
                            </table> 
                        </div>   
                    </div>   
                    <div class="card card-custom gutter-b"> 
                        <div class="card-header border-0 py-5">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label font-weight-bolder text-dark">User Upload Cust Invoice</span> 
                            </h3>  
                            <div class="card-toolbar">
                                <a href="#" class="btn btn-light-primary font-weight-bolder mr-2" onclick="add_upload_user_invoice()">
                                <i class="la la-folder-plus"></i>Upload User</i>
                                </a> 
                            </div>
                        </div>  
                        <div class="card-body div_list"> 
                            <table class="table table-bordered table-checkable" id="list_user_upload">
                                <thead>
                                    <tr> 
                                        <th class="text-center">Cust ID</th>
                                        <th class="text-center">Email</th>   
                                        <th class="text-center">Status</th> 
                                        <th class="text-center">Send Email</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $data_list_token = array(); //data demo
                                        foreach ($data_list_token as $key => $value) {
                                            $email = $value['email'];
                                            $cust_id = $value['cust_id'];
                                            $send_email = $value['send_email'];
                                            $send_email_name = '<a href="#" class="btn btn-link-warning font-weight-bold mr-2">Send Now</a>';
                                            if($send_email == 1){
                                                $send_email_name = '<i class="icon-md far fa-check-circle"></i>';
                                            }
                                            $status = $value['status'];
                                            $status_name = '<i class="icon-md fas fa-minus-circle"></i>';  
                                            echo '<tr>';
                                            echo '<td>'.$cust_id.'</td>';    
                                            echo '<td>'.$email.'</td>';    
                                            echo '<td class="text-center">'.$status_name.'</td>';    
                                            echo '<td class="text-center">'.$send_email_name.'</td>';     
                                            echo '</tr>';
                                        }
                                    ?>
                                </tbody>
                            </table> 
                        </div>   
                    </div>  
                    <div class="card card-custom gutter-b"> 
                        <div class="card-header border-0 py-5">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label font-weight-bolder text-dark">User Upload Cust Billing</span> 
                            </h3>  
                            <div class="card-toolbar">
                                <a href="#" class="btn btn-light-primary font-weight-bolder mr-2" onclick="add_upload_user_billing()">
                                <i class="la la-folder-plus"></i>Upload User</i>
                                </a> 
                            </div>
                        </div>  
                        <div class="card-body div_list"> 
                            <table class="table table-bordered table-checkable" id="list_user_upload">
                                <thead>
                                    <tr> 
                                        <th class="text-center">Cust ID</th>
                                        <th class="text-center">Email</th>   
                                        <th class="text-center">Status</th> 
                                        <th class="text-center">Send Email</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $data_list_token = array(); //data demo
                                        foreach ($data_list_token as $key => $value) {
                                            $email = $value['email'];
                                            $cust_id = $value['cust_id'];
                                            $send_email = $value['send_email'];
                                            $send_email_name = '<a href="#" class="btn btn-link-warning font-weight-bold mr-2">Send Now</a>';
                                            if($send_email == 1){
                                                $send_email_name = '<i class="icon-md far fa-check-circle"></i>';
                                            }
                                            $status = $value['status'];
                                            $status_name = '<i class="icon-md fas fa-minus-circle"></i>';  
                                            echo '<tr>';
                                            echo '<td>'.$cust_id.'</td>';    
                                            echo '<td>'.$email.'</td>';    
                                            echo '<td class="text-center">'.$status_name.'</td>';    
                                            echo '<td class="text-center">'.$send_email_name.'</td>';     
                                            echo '</tr>';
                                        }
                                    ?>
                                </tbody>
                            </table> 
                        </div>   
                    </div>  
                </div>   
            </div>
        </div>
    </div>   
</div> 
<?php
    if($this->session->flashdata('msg_success')){ 
?>
        <script>
            var msg = "<?=$this->session->flashdata('msg_success')?>";
            toastr.success(msg); 
        </script>
<?php 
    } 
    if($this->session->flashdata('msg_error')){ 
?>
        <script> 
            var msg = "<?=$this->session->flashdata('msg_error')?>";
            toastr.error(msg);
        </script>
<?php 
    }
?>
<a id="btn_upload" data-toggle="modal" class="hide" href="#modal_upload">open modal</a> 
<div id="modal_upload" class="modal fade"  tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content"> 
            <div class="modal-body">    
                <div class="text-center mb-10 mt-5">
                    <h4>Upload User</h4>  
                    <div class="loading_modal hide" style="z-index: 9999; text-align: center; width: 90%; position: absolute;">
                        <img style="margin: 0 auto; margin-top: 20%; width: 200px" src="/assets/themes/me/img/loading.gif">
                    </div>
					<hr> 
                </div>  
                <form action="<?=base_url()?>dashboard/upload_file_user" method="post" name="upload_file" enctype="multipart/form-data">
                    <div class="form-group row">
                        <label class="col-form-label col-lg-3 col-sm-12">Customer Data</label>
                        <div class="col-lg-5 col-md-5 col-sm-5">  
                                <input type="file" name="file_to_upload" id="file_to_upload"> 
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 text-right">  
                            <button class="btn btn-primary mr-2" type="submit">Upload Data</button>
                        </div>
                    </div> 
                </form>   
            </div>
        </div>
    </div>
</div> 
<a id="btn_upload_user_fm" data-toggle="modal" class="hide" href="#modal_upload_fm">open modal</a> 
<div id="modal_upload_fm" class="modal fade"  tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content"> 
            <div class="modal-body">    
                <div class="text-center mb-10 mt-5">
                    <h4>Upload User FM</h4>  
                    <div class="loading_modal hide" style="z-index: 9999; text-align: center; width: 90%; position: absolute;">
                        <img style="margin: 0 auto; margin-top: 20%; width: 200px" src="/assets/themes/me/img/loading.gif">
                    </div>
					<hr> 
                </div>  
                <form action="<?=base_url()?>dashboard/upload_file_user_fm" method="post" name="upload_file" enctype="multipart/form-data">
                    <div class="form-group row">
                        <label class="col-form-label col-lg-3 col-sm-12">Customer Data</label>
                        <div class="col-lg-5 col-md-5 col-sm-5">  
                                <input type="file" name="file_to_upload" id="file_to_upload"> 
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 text-right">  
                            <button class="btn btn-primary mr-2" type="submit">Upload Data</button>
                        </div>
                    </div> 
                </form>   
            </div>
        </div>
    </div>
</div> 
<a id="btn_upload_user_invoice" data-toggle="modal" class="hide" href="#modal_upload_user_invoice">open modal</a> 
<div id="modal_upload_user_invoice" class="modal fade"  tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content"> 
            <div class="modal-body">    
                <div class="text-center mb-10 mt-5">
                    <h4>Upload User Invoice</h4>  
                    <div class="loading_modal hide" style="z-index: 9999; text-align: center; width: 90%; position: absolute;">
                        <img style="margin: 0 auto; margin-top: 20%; width: 200px" src="/assets/themes/me/img/loading.gif">
                    </div>
					<hr> 
                </div>  
                <form action="<?=base_url()?>dashboard/upload_file_user_invoice" method="post" name="upload_file" enctype="multipart/form-data">
                    <div class="form-group row">
                        <label class="col-form-label col-lg-3 col-sm-12">Customer Data</label>
                        <div class="col-lg-5 col-md-5 col-sm-5">  
                                <input type="file" name="file_to_upload" id="file_to_upload"> 
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 text-right">  
                            <button class="btn btn-primary mr-2" type="submit">Upload Data</button>
                        </div>
                    </div> 
                </form>   
            </div>
        </div>
    </div>
</div> 
<a id="btn_upload_user_billing" data-toggle="modal" class="hide" href="#modal_upload_user_billing">open modal</a> 
<div id="modal_upload_user_billing" class="modal fade"  tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content"> 
            <div class="modal-body">    
                <div class="text-center mb-10 mt-5">
                    <h4>Upload User Billing</h4>  
                    <div class="loading_modal hide" style="z-index: 9999; text-align: center; width: 90%; position: absolute;">
                        <img style="margin: 0 auto; margin-top: 20%; width: 200px" src="/assets/themes/me/img/loading.gif">
                    </div>
					<hr> 
                </div>  
                <form action="<?=base_url()?>dashboard/upload_file_user_billing" method="post" name="upload_file" enctype="multipart/form-data">
                    <div class="form-group row">
                        <label class="col-form-label col-lg-3 col-sm-12">Customer Data</label>
                        <div class="col-lg-5 col-md-5 col-sm-5">  
                                <input type="file" name="file_to_upload" id="file_to_upload"> 
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 text-right">  
                            <button class="btn btn-primary mr-2" type="submit">Upload Data</button>
                        </div>
                    </div> 
                </form>   
            </div>
        </div>
    </div>
</div> 
<script src="<?=base_url()?>assets/themes/js/pages/crud/forms/widgets/select2.js"></script>
<script>  
$(document).ready(function() {
    // getDataList();
    var base_url = "<?=base_url();?>"; 
    $('#list_user_login').DataTable({
        "order": [[ 3, "asc" ]], 
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ] 
    });
    $('#list_user_upload').DataTable();
    $('#list_user_upload_fm').DataTable();
    $('#list_user_all').DataTable();
    

    
    $('#company_data').select2({
        placeholder: "Select Company",
        width: '100%',
        ajax: { 
           url: base_url+'get_company_name',
           type: "post",
           dataType: 'json',
           delay: 250,
           data: function (params) {
              return {
                searchTerm: params.term // search term
              };
           },
           processResults: function (data) {
                var results = [];
                $.each(data, function(index, item){
                    results.push({
                        id : item.id,
                        text : item.cust_name,
                    })
                });
                return {
                    results: results
                };
           },
           cache: true
        }
    });
}); 
function view_report(report_code){ 
	Swal.fire ({
		onBeforeOpen: () => {
			swal.fire({
				html: '<h5>Get data<br>Please wait...</h5>',
				showConfirmButton: false,
                allowOutsideClick: false
			});
			Swal.showLoading ()
		}
	}); 
    setTimeout(function(){   
        var filePath = base_url+'dashboard/view_pdf_report?pdfname='+report_code;
        window.open(filePath, '_blank'); 
        Swal.close(); 
    }, 2000);
} 
function add_new_report(){
    $('#btn_modal_new_erport').click();
}
$('select').on('change', function() { 
  $.ajax({
        type: "POST",
        url: base_url+"get_company_name_by_id",
        data: { 
            'id':this.value
        },
        cache: false,
        dataType: "json",
        success: function (res) {    
            if(res){
                var obj = jQuery.parseJSON(res.cust_data); 
                var cust_data_text = '';
                $.each(obj, function(index, item){ 
                    var cust_id = item.cust_id;
                    var cust_knownas = item.cust_knownas;
                    var cust_status_name = item.cust_status_name;
                    cust_data_text += '- Cust Id = '+cust_id+', '+cust_knownas+', '+cust_status_name+'\n';
                });
                    $('#cust_data').text(cust_data_text);
            }
        }
    }); 
});
function add_upload_user(){
    $('#btn_upload').click();
} 
function add_upload_user_fm(){
    $('#btn_upload_user_fm').click();
}
function add_upload_user_invoice(){
    $('#btn_upload_user_invoice').click();
}
function add_upload_user_billing(){
    $('#btn_upload_user_billing').click();
}
</script>