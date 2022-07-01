
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
                                <span class="card-label font-weight-bolder text-dark">Data Send Email Alibaba</span> 
                            </h3>  
                            <div class="card-toolbar">
                                <a href="#" class="btn btn-light-primary font-weight-bolder mr-2" onclick="add_upload_email_alibaba_subject_1()">
                                <i class="la la-folder-plus"></i>Upload User</i>
                                </a> 
                            </div>
                        </div>  
                        <div class="card-body div_list"> 
                            <div class="alert alert-custom alert-default" role="alert"> 
                                <i class="flaticon2-bell-alarm-symbol mr-5"></i> 
                                <div class="alert-text"><b>Subject : </b> Informasi Tambahan Terkait Invoice Periode Februari & Maret 2022.</div>
                                <span class="float-right">
                                    <a href="#" class="btn btn-light-success font-weight-bolder mr-2" onclick="send_all_email_blast_1()"> <i class="flaticon-paper-plane-1"></i>Send All Email</i></a>
                                </span>
                            </div>
                                    <table class="table table-bordered table-checkable" id="list_email_blast_1">
                                        <thead>
                                            <tr> 
                                                <th class="text-center">Cust ID</th>
                                                <th class="text-center">Email</th>   
                                                <th class="text-center">Send Date</th> 
                                                <th class="text-center">Send Email</th> 
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                foreach ($data_email_blast_1 as $key => $value) {
                                                    $email = $value['email'];
                                                    $cust_id = $value['cust_id'];
                                                    $send_email = $value['send_email'];
                                                    $send_email_name = '<a href="#" class="btn btn-link-warning font-weight-bold mr-2">Send Now</a>';
                                                    if($send_email == 1){
                                                        $send_email_name = '<i class="icon-md far fa-check-circle"></i> Terkirim';
                                                    }
                                                    $status = $value['status'];
                                                    $status_name = '<i class="icon-md fas fa-minus-circle"></i>';  
                                                    echo '<tr>';
                                                    echo '<td>'.$cust_id.'</td>';    
                                                    echo '<td>'.$email.'</td>';    
                                                    echo '<td class="text-center">'.$value['created_at'].'</td>';    
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
    <div class="d-flex flex-column-fluid"> 
        <div class="container-fluid"> 
            <div class="row">
                <div class="col-lg-12 col-xl-12 col-md-12">     
                    <div class="card card-custom gutter-b"> 
                        <div class="card-header border-0 py-5">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label font-weight-bolder text-dark">Data Send Email Alibaba</span> 
                            </h3>   
                        </div>  
                        <div class="card-body div_list"> 
                            <div class="alert alert-custom alert-default" role="alert"> 
                                <i class="flaticon2-bell-alarm-symbol mr-5"></i> 
                                <div class="alert-text"><b>Subject : </b> Aktifkan MFA untuk akses RAM User Alibaba Cloud.</div>
                                <span class="float-right">
                                    <a href="#" class="btn btn-light-success font-weight-bolder mr-2" onclick="send_all_email_blast_2()"> <i class="flaticon-paper-plane-1"></i>Send All Email</i></a>
                                </span>
                            </div>
                                    <table class="table table-bordered table-checkable" id="list_email_blast_2">
                                        <thead>
                                            <tr> 
                                                <th class="text-center">Cust ID</th>
                                                <th class="text-center">Email</th>   
                                                <th class="text-center">Send Date</th> 
                                                <th class="text-center">Status</th> 
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                foreach ($data_email_blast_2 as $key => $value) {
                                                    $email = $value['email'];
                                                    $cust_id = $value['cust_id'];
                                                    $send_email = $value['send_email'];
                                                    $send_email_name = '<a href="#" class="btn btn-link-warning font-weight-bold mr-2">Send Now</a>';
                                                    if($send_email == 1){
                                                        $send_email_name = '<i class="icon-md far fa-check-circle"></i> Terkirim';
                                                    }
                                                    $status = $value['status'];
                                                    $status_name = '<i class="icon-md fas fa-minus-circle"></i>';  
                                                    echo '<tr>';
                                                    echo '<td>'.$cust_id.'</td>';    
                                                    echo '<td>'.$email.'</td>';    
                                                    echo '<td class="text-center">'.$value['send_at'].'</td>';    
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

<a id="btn_upload_alibaba_subject_1" data-toggle="modal" class="hide" href="#modal_upload_alibaba_subject_1">open modal</a> 
<div id="modal_upload_alibaba_subject_1" class="modal fade"  tabindex="-1" role="dialog" aria-hidden="true">
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
                <form action="<?=base_url()?>emails_blast/upload_file_user_alibaba_subject_1" method="post" name="upload_file" enctype="multipart/form-data">
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
<script>  
    $('#list_email_blast_1').DataTable({ 
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ] 
    });
    $('#list_email_blast_2').DataTable({ 
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ] 
    });
    var base_url = "<?=base_url();?>"; 
    function add_upload_email_alibaba_subject_1(){
        $('#btn_upload_alibaba_subject_1').click();
    } 
    function send_all_email_blast_1(){
        Swal.fire({
            title: "Are you sure?",
            text: "Blast Email to All Customer",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, Send it!",
            cancelButtonText: "No, cancel!",
            reverseButtons: true
        }).then(function(result) {
            if (result.value) {
                Swal.fire ({
                    onBeforeOpen: () => {
                        swal.fire({
                            html: '<h5>Please wait...</h5>',
                            showConfirmButton: false,
                            allowOutsideClick: false
                        });
                        Swal.showLoading ()
                    }
                });
                $.ajax({
                    url: base_url+"send-email-blast-customer-confirm-1",
                    type: 'POST', 
                    cache: false,
                    dataType: "json", 
                    success: function (res) { 
                        if(res.result){  
                            Swal.fire('','Send all email','success').then((result) => {   
                                location.reload();
                            });
                        }else{
                            Swal.fire('',res.message,'error').then((result) => { 
                                location.reload();
                            }); 
                        } 
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            } else if (result.dismiss === "cancel") {
            }
        });
    }
    
    function send_all_email_blast_2(){
        Swal.fire({
            title: "Are you sure?",
            text: "Blast Email to All Customer",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, Send it!",
            cancelButtonText: "No, cancel!",
            reverseButtons: true
        }).then(function(result) {
            if (result.value) {
                Swal.fire ({
                    onBeforeOpen: () => {
                        swal.fire({
                            html: '<h5>Please wait...</h5>',
                            showConfirmButton: false,
                            allowOutsideClick: false
                        });
                        Swal.showLoading ()
                    }
                });
                $.ajax({
                    url: base_url+"send-email-blast-customer-confirm-2",
                    type: 'POST', 
                    cache: false,
                    dataType: "json", 
                    success: function (res) { 
                        if(res.result){  
                            Swal.fire('','Send all email','success').then((result) => {   
                                location.reload();
                            });
                        }else{
                            Swal.fire('',res.message,'error').then((result) => { 
                                location.reload();
                            }); 
                        } 
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            } else if (result.dismiss === "cancel") {
            }
        });
    }
</script>