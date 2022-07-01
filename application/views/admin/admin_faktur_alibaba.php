<div class="content d-flex flex-column flex-column-fluid body_table" id="kt_content">
    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap"> 
            <div class="d-flex align-items-center flex-wrap mr-2"> 
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Faktur Pajak Customer Alibaba Cloud</h5>  
            </div> 
        </div>
    </div>  
    <div class="d-flex flex-column-fluid ">  
		<div class="container-fluid div_display">  
            <div class="card card-custom gutter-b">
                <div class="card-header flex-wrap py-3">
                    <div class="card-title">
                        <h3 class="card-label">Faktur Pajak List
                        <span class="d-block text-muted pt-2 font-size-sm">Faktur Pajak Customer Alibaba Cloud</span></h3>
                    </div> 
                    <div class="card-toolbar"> 
                        <a href="#" class="btn btn-primary" onclick="add_new_faktur()">
                            <i class="flaticon-file-1"></i>Upload List
                        </a>
                    </div>
                </div>
                <div class="card-body div_list"> 
                    <div class="form-group row col-sm-12"> 
                        <div class=" col-lg-4 col-sm-4 row">
                            <label class="col-form-label text-right col-lg-3 col-sm-3">Periode</label>
                            <div class="col-lg-8 col-md-8 col-sm-8 input-group">
                                <?php $date_now = date('d-m-Y H:i:s');?>
                                <input type="text" class="form-control" id="periode_view" placeholder="Month Year" value="<?=date('F Y', strtotime($date_now))?>" />
                                <div class="input-group-append" style="cursor: pointer; max-height: 39px;">
                                    <span class="input-group-text btn-success " onclick="view_list()">
                                        <i class="la la-check mr-2"></i> View
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class=" col-lg-5 col-sm-5 text-center">
                            <label class="col-form-label"><h4>Data Biliing <span class="periode_name"></span></h4></label>
                        </div>
                        <div class=" col-lg-3 col-sm-3 ">
                            <div class=" col-lg-12 col-sm-12 div_percentage">
                                
                            </div> 
                            <div class=" col-lg-12 col-sm-12 btn_send_all text-right">
                                
                            </div> 
                        </div>
                        
                    </div>
                    <hr>
                    <table class="table table-bordered table-checkable" id="list_faktur_pajak">
                        <thead>
                            <tr>  
                                <th class="text-center">Cust ID</th>
                                <th class="text-center">Cust Name</th> 
                                <th class="text-center">Cust Email</th> 
                                <th class="text-center">Cust Type</th> 
                                <th class="text-center">NPWP</th>
                                <th class="text-center">Billing Amount</th>
                                <th class="text-center">Billing Statement File</th> 
                                <th class="text-center">Faktur Pajak File</th> 
                                <th class="text-center">Action</th> 
                            </tr>
                        </thead> 
                    </table> 
                </div>
            </div> 
        </div> 
    </div>  
</div>      
<a id="btn_upload_fp_alibaba" data-toggle="modal" class="hide" href="#modal_upload_fp_alibaba">open modal</a> 
<div id="modal_upload_fp_alibaba" class="modal fade"  tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content"> 
            <div class="modal-body">    
                <div class="text-center mb-10 mt-5">
                    <h4>Upload Faktur Pajak Customer Alibaba cloud</h4>  
                    <div class="loading_modal hide" style="z-index: 9999; text-align: center; width: 90%; position: absolute;">
                        <img style="margin: 0 auto; margin-top: 20%; width: 200px" src="/assets/themes/me/img/loading.gif">
                    </div>
					<hr> 
                </div>  
                <form id="upload_fp_alibaba" class="upload_fp_alibaba" method="post" name="upload_file" enctype="multipart/form-data" action="#!">
                    <div class="form-group row">
                        <label class="col-form-label text-right col-lg-3 col-sm-3">Periode</label>
                        <div class="col-lg-7 col-md-9 col-sm-7 input-group  ">
                            <input type="text" class="form-control" id="periode_upload" name="periode_upload" readonly="readonly" placeholder="Month Year" /> 
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label text-right col-lg-3 col-sm-3">Customer NPWP</label> 
                        <div class="col-lg-9 col-md-9 col-sm-9 input-group  "> 
                                <input type="file" name="file_to_upload_npwp" id="file_to_upload_npwp"> 
                        </div> 
                    </div> 
                    <div class="form-group row">
                        <label class="col-form-label text-right col-lg-3 col-sm-3">Customer Non NPWP</label> 
                        <div class="col-lg-9 col-md-9 col-sm-9 input-group  "> 
                                <input type="file" name="file_to_upload_non_npwp" id="file_to_upload_non_npwp"> 
                        </div> 
                    </div> 
                    <hr>
                    <div class="form-group row">
                        <div class="col-lg-12 col-md-12 col-sm-12 text-right">  
                            <button class="btn btn-primary mr-2" type="button" onclick="submit_upload()" >Upload Data</button>
                            <button class="btn btn-primary mr-2 hide" type="submit" id="submit_upload_btn" >Upload</button>
                        </div>
                    </div>
                </form>   
            </div>
        </div>
    </div>
</div> 
<script src="<?=base_url()?>assets/themes/me/js/faktur_pajak_alibaba.js"></script>  
<script>  
    $(document).ready(function() {  
        var base_url = "<?=base_url();?>"; 
        view_list();  
        $('#periode_view').datepicker({  
            orientation: "bottom left",  
            format: "MM yyyy",
            startView: "months", 
            minViewMode: "months",
            autoclose: true
        });
        $('#periode_upload').datepicker({  
            orientation: "bottom left",  
            format: "MM yyyy",
            startView: "months", 
            minViewMode: "months",
            autoclose: true
        });
    });   
</script>