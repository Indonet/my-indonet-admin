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
<div class="content d-flex flex-column flex-column-fluid body_table" id="kt_content"> 
    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap"> 
            <div class="d-flex align-items-center flex-wrap mr-2"> 
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Vendor Management</h5>  
            </div> 
        </div>
    </div>  
    <div class="d-flex flex-column-fluid ">  
		<div class="container-fluid div_display">  
            <div class="card card-custom gutter-b">
                <div class="card-header flex-wrap py-3">
                    <div class="card-title">
                        <h3 class="card-label">Vendor List
                        <span class="d-block text-muted pt-2 font-size-sm">Vendor Indonet</span></h3>
                    </div> 
                    <div class="card-toolbar"> 
                        <a href="#" class="btn btn-primary" onclick="add_new_vendor()">
                            <i class="flaticon-user-add"></i>New Vendor
                        </a>
                    </div>
                </div>
                <div class="card-body div_list"> 
                    <table class="table table-bordered table-checkable" id="list_vendor">
                        <thead>
                            <tr> 
                                <th class="text-center">Vendor Name</th>
                                <th class="text-center">Customer / Partner Id</th> 
                                <th class="text-center">Contract Desc</th>
                                <th class="text-center">Contract Duration</th> 
                                <th class="text-center">End Date</th>
                                <th class="text-center">Auto Renew</th>  
                                <th class="text-center">Status</th>  
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // print_r($data_vendor);
                                foreach ($data_vendor as $key => $value) {
                                    switch ($value['status']) {
                                        case '1':
                                            $status_name = 'active';
                                            break;
                                        
                                        default:
                                            $status_name = 'inactive'; 
                                            break;
                                    }
                                    switch ($value['contract_renew']) {
                                        case '1':
                                            $renew_name = 'yes';
                                            break;
                                        
                                        default:
                                            $renew_name = 'no'; 
                                            break;
                                    }
                                    echo '<tr>';
                                    echo '<td><a href="#" onclick="view_vendor('.$value['id'].')">'.$value['name'].'</a></td>';
                                    echo '<td>'.$value['cust_partner_id'].'</td>';
                                    echo '<td>'.$value['contract_desc'].'</td>';
                                    echo '<td>'.$value['contract_duration'].'</td>';
                                    echo '<td>'.$value['contract_end'].'</td>';
                                    echo '<td>'.$renew_name.'</td>';
                                    echo '<td>'.$status_name.'</td>';
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
<a id="btn_modal_new_vendor" data-toggle="modal" class="hide" href="#modelNewVendor">open modal</a> 
<div id="modelNewVendor" class="modal fade"  tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content"> 
            <div class="modal-body">    
                <div class="mt-5">
                    <h4>New Vendor List</h4>   
					<hr> 
                </div> 
                <form class="add_new_vendor">
                    <div class="form-group row">
                        <label class="col-form-label text-right col-lg-4 col-sm-12">Vendor Name *</label>
                        <div class="col-lg-8 col-md-8 col-sm-12">
                            <input type="text" class="form-control" id="vendor_name" name="vendor_name">
                        </div>
                    </div>  
                    <div class="form-group row">
                        <label class="col-form-label text-right col-lg-4 col-sm-12">Customer / Partner ID</label>
                        <div class="col-lg-8 col-md-8 col-sm-12">
                            <input type="text" class="form-control" id="cust_partner_id" name="cust_partner_id">
                        </div>
                    </div>  
                    <div class="form-group row">
                        <label class="col-form-label text-right col-lg-4 col-sm-12">Contract Description</label>
                        <div class="col-lg-8 col-md-8 col-sm-12">
                            <textarea class="form-control" rows="2" id="contract_desc" name="contract_desc"></textarea>
                        </div>
                    </div>  
                    <div class="form-group row">
                        <label class="col-form-label text-right col-lg-4 col-sm-12">Contract Duration</label>
                        <div class="col-lg-8 col-md-8 col-sm-12">
                            <input type="text" class="form-control" id="contract_duration" name="contract_duration">
                        </div>
                    </div>  
                    <div class="form-group row">
                        <label class="col-form-label text-right col-lg-4 col-sm-12">Contract Start</label>
                        <div class="col-lg-8 col-md-8 col-sm-12">
                            <input type="text" class="form-control" id="contract_start" name="contract_start">
                            <span class="form-text text-muted">date format:
                            <code>dd/mm/yyyy</code></span>
                        </div>
                    </div>  
                    <div class="form-group row">
                        <label class="col-form-label text-right col-lg-4 col-sm-12">Contract End *</label>
                        <div class="col-lg-8 col-md-8 col-sm-12">
                            <input type="text" class="form-control" id="contract_end" name="contract_end">
                            <span class="form-text text-muted">date format:
                            <code>dd/mm/yyyy</code></span>
                        </div>
                    </div>  
                    <div class="form-group row">
                        <label class="col-form-label text-right col-lg-4 col-sm-12">Auto Renew</label>
                        <div class="col-lg-8 col-md-8 col-sm-12">
                            <div class="radio-inline mt-1">
                                <label class="radio">
                                    <input type="radio" name="auto_renew" value="1"><span></span>Yes
                                </label>
                                <label class="radio">
                                    <input type="radio" name="auto_renew" value="0" checked><span></span>No
                                </label> 
                            </div>
                        </div>
                    </div>  
                    <div class="form-group row">
                        <label class="col-form-label text-right col-lg-4 col-sm-12">Upload File</label>
                        <div class="row col-lg-8 upload_div">
                            <div class="col-lg-10 col-md-10 col-sm-10">  
                                <div class="form-group"> 
                                    <input type="file" name="file_vendor[]"> 
                                </div>
                                <span class="add_file_div"></span>
                                <input id="count_file" value="1" class="hide">  
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-2">   
                                <a class="btn btn-light" onclick="add_file()"><i class="flaticon2-plus icon-sm"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-12 upload_div_val"></div>
                    </div>  
                    <div class="form-group row">
                        <label class="col-form-label text-right col-lg-4 col-sm-12">Vendor Contact</label>
                        <div class="col-lg-8 col-md-8 col-sm-12">
                            <div class="form-group row">
                                <label class="col-form-label text-right col-lg-4 col-sm-12">Contact Name</label>
                                <div class="col-lg-8 col-md-8 col-sm-12">
                                    <input type="text" class="form-control" id="contact_name" name="contact_name">
                                </div>
                            </div>
                            <div class="form-group row">
                            <label class="col-form-label text-right col-lg-4 col-sm-12">Contact Phone</label>
                            <div class="col-lg-8 col-md-8 col-sm-12">
                                <input type="text" class="form-control" id="contact_phone" name="contact_phone">
                            </div>
                            </div>
                            <div class="form-group row">
                            <label class="col-form-label text-right col-lg-4 col-sm-12">Contact Email</label>
                            <div class="col-lg-8 col-md-8 col-sm-12">
                                <input type="text" class="form-control" id="contact_email" name="contact_email">
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label text-right col-lg-4 col-sm-12">Reminder to email</label>
                        <div class="col-lg-8 col-md-8 col-sm-12">
                            <textarea class="form-control" rows="2" id="reminder_to" name="reminder_to"></textarea>
                            <span class="form-text text-muted">This email will be used to receive a notification each time a contract is due date. If you have multiple emails, please use (<code>;</code>) / semicolon to separate emails </span>
                        </div>
                    </div>  
                    <hr>
                    <div class="text-center">
                        <button class="btn btn-success mr-2 font-weight-bolder submit_btn" type="submit"><i class=" flaticon2-check-mark"></i>Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>  
<script>  
    $(document).ready(function() { 
        var base_url = "<?=base_url();?>"; 
        $('#list_vendor').DataTable({"order": [[ 4, "desc" ]]}); 
    });  
    function add_new_vendor(){
        $('#vendor_name').val('');
        $('#cust_partner_id').val('');
        $('#contract_desc').val('');
        $('#contract_duration').val('');
        $('#contract_start').val('');
        $('#contract_end').val('');
        $('#contact_name').val('');
        $('#contact_phone').val('');
        $('#contact_email').val('');
        $('#reminder_to').val('');
        $('.upload_div_val').html('');
        $('.upload_div_val').hide();
        $('.upload_div').show();
        $('#btn_modal_new_vendor').click();
    }
    $("#contract_start").inputmask("99/99/9999", {
        "placeholder": "dd/mm/yyyy",
        autoUnmask: true
    });
    $("#contract_end").inputmask("99/99/9999", {
        "placeholder": "dd/mm/yyyy",
        autoUnmask: true
    });   
    function add_file(){
        var count_file = $('#count_file').val();
        count_file = parseInt(count_file) + 1;
        $('#count_file').val(count_file);
        var rand = Math.floor((Math.random() * 100) + 1);
        var div =   '<div class="form-group file_'+rand+'">'+
                        '<input type="file" name="file_vendor[]"> <a class="btn btn-light" onclick="min_file('+rand+')"><i class="flaticon2-line icon-sm"></i></a>'+
                    '</div>'; 
                 
        $(div).appendTo('.add_file_div');  
    }
    function min_file(rand){
        var count_file = $('#count_file').val();
        count_file = parseInt(count_file) - 1;
        $('#count_file').val(count_file);
        $('.file_'+rand).html('');
    }
    $("form.add_new_vendor").submit(function(e) {
        e.preventDefault();    
        var formData = new FormData(this); 
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
            url: base_url+"submit-vendor",
            type: 'POST',
            enctype: 'multipart/form-data',
            cache: false,
            dataType: "json",
            data: formData,
            success: function (res) { 
                if(res.result){  
                    Swal.fire('','Add new vendor','success').then((result) => { 
                        window.location.href = base_url+'management-vendor';
                    });
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
    function view_vendor(id){ 
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
            url: base_url+"view-vendor",
            type: 'POST', 
            cache: false,
            dataType: "json",
            data: {'id':id},
            success: function (res) {  
                if(res.result){
                    var res_data = res.data;
                    $('#vendor_name').val(res_data.name); 
                    $('#cust_partner_id').val(res_data.cust_partner_id); 
                    $('#contract_desc').val(res_data.contract_desc);  
                    $('#contract_duration').val(res_data.contract_duration);  
                    $('#contract_start').val(res_data.contract_start);  
                    $('#contract_end').val(res_data.contract_end);  
                    $('#contact_name').val(res_data.contact_name_pic);  
                    $('#contact_phone').val(res_data.contact_phone_pic);  
                    $('#contact_email').val(res_data.contact_email_pic);  
                    $('#reminder_to').val(res_data.email_reminder_to);   
                    if(res_data.contract_renew == 1){
                        $("input[name=auto_renew][value=1]").prop('checked', true);   
                    }
                    var document_upload = JSON.parse(res_data.document_upload);
                    var document_val = '';
                    if(document_upload){
                        $.each(document_upload,function(index, value){
                            document_val += '<div class="bg-gray-200 text-dark-50 py-3 px-4 col-sm-12 mb-2"><a href="#" onclick="file_vendor(\''+value.file_name+'\',\''+value.filename_upload+'\')">'+value.file_name+'</a></div>'; 
                        });
                    }else{
                        document_val += '<i>no files uploaded</i>';
                    }
                    $('.upload_div').hide();
                    $('upload_div_val').show();
                    $('.upload_div_val').html(document_val); 
                    $('#btn_modal_new_vendor').click();  
                    $('.submit_btn').hide();
                }
                swal.close(); 
            }, 
        });
    }
    function file_vendor(file_name, filename_upload){
        let link = document.createElement("a");
        link.download = file_name;
        link.href = './files/file_vendor/'+filename_upload;
        link.click(); 
    }
</script>