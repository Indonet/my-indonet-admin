<div class="content d-flex flex-column flex-column-fluid" id="kt_content"> 
    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap"> 
            <div class="d-flex align-items-center flex-wrap mr-2"> 
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Blacklist Faktur Pajak</h5>  
            </div>  
        </div>
    </div>   
    <div class="container-fluid">   
        <div class="card card-custom overflow-hidden">
            <div class="card-header"> 
                <div class="card-title">
                    <h3 class="card-label">Billing Faktur Pajak
                    <span class="d-block text-muted pt-2 font-size-sm">Blacklist Faktur Pajak Cust ID</span></h3>
                </div>   
                <div class="card-toolbar"> 
                    <a href="#" class="btn btn-success mr-1" onclick="add_new()">
                        <i class="flaticon2-plus"></i>Add Blacklist
                    </a>   
                    <a href="#" class="btn btn-primary mr-1" onclick="upload_new()">
                        <i class="flaticon-file-1"></i>Upload Blacklist
                    </a>
                </div>
            </div>
            <div class="card-body">  
                <table class="table table-bordered table-checkable" id="list_blacklist">
                    <thead>
                        <tr>  
                            <th class="text-center">Cust ID</th>
                            <th class="text-center">Cust Name</th>  
                            <th class="text-center">Blacklist Type</th>  
                            <th class="text-center">Action</th> 
                        </tr>
                    </thead> 
                </table>  
            </div>
        </div> 
    </div> 
</div>   
<a id="btn_new" data-toggle="modal" class="hide" href="#modal_btn_new">open modal</a> 
<div id="modal_btn_new" class="modal fade"  tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content"> 
            <div class="modal-body">    
                <div class="text-center mb-10 mt-5">
                    <h4>Add Blacklist Billing Faktur Pajak</h4>  
                    <div class="loading_modal hide" style="z-index: 9999; text-align: center; width: 90%; position: absolute;">
                        <img style="margin: 0 auto; margin-top: 20%; width: 200px" src="/assets/themes/me/img/loading.gif">
                    </div>
					<hr> 
                </div>  
                <form id="add_new_form" method="post" name="upload_file" enctype="multipart/form-data" action="#!">
                    <div class="form-group row">
                        <label class="col-form-label text-right col-lg-3 col-sm-3">Cust ID</label>
                        <div class="col-lg-7 col-md-9 col-sm-7 input-group">
                            <input type="text" pattern="/^-?\d+\.?\d*$/" class="form-control" id="cust_id" name="cust_id"  placeholder="Customer ID" onkeypress="return isNumberKey(event)" 
                            onkeyup="check_custid()" /> 
                        </div>
                    </div> 
                    <div class="form-group row">
                        <label class="col-form-label text-right col-lg-3 col-sm-3">Cust Name</label>
                        <div class="col-lg-7 col-md-9 col-sm-7 input-group">
                            <input type="text" class="form-control" disabled id="cust_name" name="cust_name"  placeholder="Customer Name" /> 
                        </div>
                    </div> 
                    <div class="form-group row">
                        <label class="col-form-label text-right col-lg-3 col-sm-3">Blacklist Type</label>
                        <div class="col-lg-7 col-md-9 col-sm-7 input-group">
                            <select class="form-control"  id="blacklist_type" name="blacklist_type" >
                                <option value="Invoice bermaterai">Invoice Materai</option> 
                                <option value="Invoice manual">Invoice Manual</option>  
                                <option value="Invoice Berkwitans">Invoice Kwitansi</option> 
                                <option value="Lain-lain">Lain-lain</option> 
                            </select>
                            <!-- <input type="text" class="form-control" id="blacklist_type" name="blacklist_type"  placeholder="Blacklist Type" />  -->
                        </div>
                    </div> 
                    <hr>
                    <div class="form-group row">
                        <div class="col-lg-12 col-md-12 col-sm-12 text-right">  
                            <button class="btn btn-primary mr-2" type="button" onclick="submit_new()" >Submit</button> 
                        </div>
                    </div>
                </form>   
            </div>
        </div>
    </div>
</div>    
<a id="btn_upload_new" data-toggle="modal" class="hide" href="#modal_btn_upload_new">open modal</a> 
<div id="modal_btn_upload_new" class="modal fade"  tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content"> 
            <div class="modal-body">    
                <div class="text-center mb-10 mt-5">
                    <h4>Upload Blacklist Billing Faktur Pajak</h4>  
                    <div class="loading_modal hide" style="z-index: 9999; text-align: center; width: 90%; position: absolute;">
                        <img style="margin: 0 auto; margin-top: 20%; width: 200px" src="/assets/themes/me/img/loading.gif">
                    </div>
					<hr> 
                </div>   
                <form id="form_upload_blacklist" class="form_upload_blacklist" method="post" name="form_upload_blacklist" enctype="multipart/form-data" action="#!"> 
                    <div class="form-group row">
                        <label class="col-form-label text-right col-lg-3 col-sm-3">Blacklist File</label> 
                        <div class="col-lg-9 col-md-9 col-sm-9 input-group  "> 
                                <input type="file" name="file_upload_blacklist" id="file_upload_blacklist"> 
                        </div> 
                    </div>  
                    <hr>
                    <div class="form-group row">
                        <div class="col-lg-12 col-md-12 col-sm-12 text-right">  
                            <button class="btn btn-primary mr-2" type="submit">Upload Data</button> 
                        </div>
                    </div>
                </form>   
            </div>
        </div>
    </div>
</div>   
<script> 
    get_blacklist();   
    var base_url = "<?=base_url();?>";  
    function get_blacklist(){
        $('#list_blacklist').DataTable().destroy(); 
        $('#list_blacklist').DataTable( {       
            ajax:{
                "url":  base_url+"get-blacklist-data",
                "type": "POST", 
                "data": {}
            },
            "columns": [   
                {   "data": "cust_id" },  
                {   "data": "cust_name" },   
                {   "data": "billing_type" },    
                {   "data": "cust_id",
                    "render": function(data, type, row, meta){
                        if(type === 'display'){
                            data = `<a href="#" placholder="remove" class="mr-1 text-center" onclick="rm_blacklist('`+data+`')"><i class="text-dark-50 flaticon2-trash"></i> </a>`; 
                        } 
                        return data;
                    }
                },                        
            ],  
            "columnDefs": [
                {
                    "targets": [ 0 ],
                    "orderable": false
                }, 
                { className: 'text-center', "targets": [3] },
            ],     
            "pageLength": 10, 
            "order": [[0, 'desc']]
        } ); 
    }
    function add_new(){
        $('#btn_new').click();
    }
    function upload_new(){
        $('#btn_upload_new').click();
    } 
    $("form.form_upload_blacklist").submit(function(e) { 
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
            url: base_url+"upload-blacklist",
            type: 'POST',
            enctype: 'multipart/form-data',
            cache: false,
            dataType: "json",
            data: formData,
            success: function (res) { 
                if(res.result){  
                    Swal.fire('','Upload file BlackList Progress','info').then((result) => {  
                        $('#modal_btn_upload_new').modal('toggle');
                        get_blacklist();
                    });
                }else{
                    Swal.fire('',res.message,'error').then((result) => {  
                        $('#modal_btn_upload_new').modal('toggle');
                        get_blacklist();
                    });
                }
            },
            cache: false,  
            processData: false,
            contentType: false,
        });
    });
    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode;
        if ((charCode < 48 || charCode > 57))
            return false;

        return true;
    }
    function submit_new(){
        var cust_id = $('#cust_id').val();
        var cust_name = $('#cust_name').val();
        var blacklist_type = $('#blacklist_type').val(); 
        if(cust_id != '' && cust_name != ''){
            Swal.fire({
                title: "Are you sure?",
                text: "Blacklist customer id "+cust_id,
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, Blacklist!",
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
                        url: base_url+"save-blacklist-data",
                        type: 'POST', 
                        cache: false,
                        dataType: "json",
                        data: {'cust_id':cust_id, 'blacklist_type':blacklist_type},
                        success: function (res) {   
                            if(res.result){  
                                Swal.fire('',  res.message, 'success').then((result) => { 
                                    location.reload();
                                });  
                            }else{ 
                                Swal.fire('', res.message, 'error').then((result) => { 
                                    location.reload();
                                });   
                            } 
                        },
                        cache: false, 
                    });    

                }else{ 
                    Swal.fire('','Input All Field', 'error').then((result) => { 
                    }); 
                }
            });
        }
    }
    function check_custid(){
        var cust_id = $('#cust_id').val();  
        $('#cust_name').val('');
        if(cust_id != ''){
            if(cust_id.length > 8){ 
                $.ajax({ 
                    url: base_url+"get-customer-info-by-cust-id",
                    type: 'POST', 
                    cache: false,
                    dataType: "json",
                    data: {'cust_id':cust_id},
                    success: function (res) {   
                        if(res.result){  
                            var data = res.data;
                            $('#cust_name').val(data.cust_name);
                        }else{ 
                            $('#cust_name').val('');
                            $('#cust_name').attr("placeholder", "Customer ID tidak terdaftar");
                        } 
                    },
                    cache: false, 
                });        
            }
        }
    }
    function rm_blacklist(cust_id){
        Swal.fire({
            title: "Are you sure?",
            text: "Remove Blacklist customer id "+cust_id,
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, Remove!",
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
                    url: base_url+"remove-blacklist-data",
                    type: 'POST', 
                    cache: false,
                    dataType: "json",
                    data: {'cust_id':cust_id},
                    success: function (res) {   
                        if(res.result){  
                            Swal.fire('',  res.message, 'success').then((result) => { 
                                location.reload();
                            });  
                        }else{ 
                            Swal.fire('', res.message, 'error').then((result) => { 
                                location.reload();
                            });   
                        } 
                    },
                    cache: false, 
                });    

            }else{  
            }
        });

    }
</script>