<div class="content d-flex flex-column flex-column-fluid body_table" id="kt_content"> 
    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap"> 
            <div class="d-flex align-items-center flex-wrap mr-2"> 
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Faktur Pajak Customer Indonet</h5>
            </div> 
        </div>
    </div>  
    <div class="d-flex flex-column-fluid ">  
		<div class="container-fluid div_display">  
            <div class="card card-custom gutter-b">
                <div class="card-header flex-wrap py-3">
                    <div class="card-title">
                        <h3 class="card-label">Faktur Pajak List
                        <span class="d-block text-muted pt-2 font-size-sm">Faktur Pajak Customer Indonet</span></h3>
                    </div> 
                    <div class="card-toolbar hide"> 
                        <a href="#" class="btn btn-primary mr-1" onclick="add_new_faktur()">
                            <i class="flaticon-file-1"></i>Upload List Faktur Pajak
                        </a>
                    </div>
                </div>
                <input class="hide" id="month_year_now" value="<?=date('M').' '.date('Y');?>" >
                <input class="hide" id="month_year_select" value="">
                <input class="hide" id="alibaba_posting_date_val" value="">
                <div class="card-body div_list"> 
                    <div class="form-group row col-sm-12"> 
                        <div class=" col-lg-4 col-sm-4 row">
                            <label class="col-form-label text-right col-lg-3 col-sm-3">Periode</label>
                            <div class="col-lg-8 col-md-8 col-sm-8 input-group">
                                <?php $date_now = date('d-m-Y H:i:s');?>
                                <input type="text" class="form-control" id="periode_view" placeholder="Month Year" value="<?=date('M Y', strtotime($date_now))?>" />
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
                        <div class=" col-lg-3 col-sm-3"> 
                            <div class="div_count_data">
                            </div>
                            <div class="example-preview "> 
                                <div class="timeline timeline-2">
                                    <div class="timeline-bar"></div>
                                    <div class="div_progress_bar"></div> 
                                </div>  
                            </div>           
                        </div> 
                    </div>
                    <div class="form-group row col-lg-12">
                        <div class="btn_process_billing hide float-left col-lg-9">
                            <a class="btn btn-success mr-1" data-toggle="modal" href="#modalNewList">
                                <i class="flaticon-file-1"></i>Get Customer List
                            </a>
                            <a class="btn btn-success mr-1" data-toggle="modal" onclick="open_modal_billing_pdf()">
                                <i class="flaticon-file-1"></i>Generate Billing PDF
                            </a>
                            <a class="btn btn-success mr-1" data-toggle="modal" href="#modalNewUploadFp">
                                <i class="flaticon-file-1"></i>Upload List Faktur Pajak
                            </a>
                            <a class="btn btn-success mr-1" data-toggle="modal" href="#modalSendEmail">
                                <i class="flaticon-file-1"></i>Send All Email
                            </a>
                        </div>
                        <div class="float-right text-right col-lg-3">
                            <div class="form-group row justify-content-end">
                                <label class="col-4 col-form-label">Email status</label>
                                <div class="col-8">
                                    <select class="form-control" id="status_email_sent" onchange="filter_send_email(this)">
                                        <option value="">All</option>
                                        <option value="_#01_">Terkirim</option>
                                        <option value="_#02_">Gagal terkirim</option>
                                        <option value="_#03_">Belum dikirim</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <hr>
                    </div> 
                    <div class="table-responsive">
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
                                    <th class="text-center">Info</th> 
                                    <th class="text-center hide">Info email code</th> 
                                    <th class="text-center hide">Non alicloud / Alicloud</th> 
                                    <th class="text-center hide">Sent Email Status</th> 
                                    <th class="text-center hide">Sent Email Date</th> 
                                </tr>
                            </thead> 
                        </table> 
                    </div>
                </div>
            </div> 
        </div> 
    </div>  
</div>      
<a id="btn_upload_fp_indonet" data-toggle="modal" class="hide" href="#modal_upload_fp_indonet">open modal</a> 
<div id="modal_upload_fp_indonet" class="modal fade"  tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content"> 
            <div class="modal-body">    
                <div class="text-center mb-10 mt-5">
                    <h4>Upload Faktur Pajak Indonet</h4>  
                    <div class="loading_modal hide" style="z-index: 9999; text-align: center; width: 90%; position: absolute;">
                        <img style="margin: 0 auto; margin-top: 20%; width: 200px" src="/assets/themes/me/img/loading.gif">
                    </div>
					<hr> 
                </div>  
                <form id="upload_fp_indonet" class="upload_fp_indonet" method="post" name="upload_file" enctype="multipart/form-data" action="#!">
                    <div class="form-group row">
                        <label class="col-form-label text-right col-lg-3 col-sm-3">Periode</label>
                        <div class="col-lg-7 col-md-9 col-sm-7 input-group  ">
                            <input type="text" class="form-control" id="periode_upload" name="periode_upload" readonly="readonly" disabled placeholder="Month Year" /> 
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label text-right col-lg-3 col-sm-3">Customer NPWP</label> 
                        <div class="col-lg-9 col-md-9 col-sm-9 input-group  "> 
                            <input type="file" name="file_to_upload_npwp" id="file_to_upload_npwp"> 
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
<a id="btn_modal_new_list" data-toggle="modal" class="hide" href="#modalNewList">open modal</a> 
<div id="modalNewList" class="modal fade"  tabindex="-1" role="dialog" aria-hidden="true"  data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content"> 
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Get Customer List <span class="periode_view"><?=date('M').' '.date('Y');?></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">     
                <div class="form-group row">
                    <label class="col-3 col-form-label text-right">Customer Type</label>
                    <div class="col-9 col-form-label">
                        <div class="checkbox-inline">
                            <label class="checkbox">
                                <input type="checkbox" name="list_corporate" id="list_corporate">
                                <span></span>Corporate
                            </label>
                            <label class="checkbox">
                                <input type="checkbox" name="list_retail" id="list_retail">
                                <span></span>Retail
                            </label>
                            <label class="checkbox">
                                <input type="checkbox" name="list_personal" id="list_personal">
                                <span></span>Personal
                            </label> 
                        </div> <code class="error_cust_type hide">*Select customer type</code>
                    </div>
                </div> 
                <div class="form-group row">
                    <label class="col-3 col-form-label text-right">Customer Status</label>
                    <div class="col-9 col-form-label">
                        <div class="checkbox-inline"> 
                            <label class="checkbox checkbox-disabled">
                                <input type="checkbox" disabled="disabled" name="status1" checked="checked">
                                <span></span>Active
                            </label>
                            <label class="checkbox checkbox-disabled">
                                <input type="checkbox" disabled="disabled" name="status2" checked="checked">
                                <span></span>Hold
                            </label>
                            <label class="checkbox checkbox-disabled">
                                <input type="checkbox" disabled="disabled" name="status3">
                                <span></span>Close
                            </label>
                        </div> 
                    </div>
                </div> 
                <div class="form-group row">
                    <label class="col-3 col-form-label text-right">Customer Blacklist</label>
                    <div class="col-9 col-form-label">
                        <div class="checkbox-inline"> 
                            <label class="checkbox checkbox-disabled">
                                <input type="checkbox" disabled="disabled" name="status1" checked="checked">
                                <span></span>Active
                            </label>
                        </div> 
                    </div>
                </div> 
                <div class="form-group row"> 
                    <div class="col-12 col-form-label"> 
                        <span class="form-text text-muted">*Proses ambil data dari AX Ini mungkin membutuhkan waktu beberapa saat (kurang lebih 5 menit) </span>
                    </div>
                </div> 
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary font-weight-bold"  onclick="confirm_new()">Confirm</button>
            </div>
        </div>
    </div>
</div>
<a id="btn_modal_new_billing_pdf" data-toggle="modal" class="hide" href="#modalNewBillingPdf">open modal</a> 
<div id="modalNewBillingPdf" class="modal fade"  tabindex="-1" role="dialog" aria-hidden="true"  data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content"> 
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Generate Billing PDF<span class="periode_view"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">     
                <div class="form-group row">
                    <label class="col-3 col-form-label text-right">Customer Type</label>
                    <div class="col-9 col-form-label">
                        <div class="radio-inline">
                            <label class="radio">
                                <input type="radio" name="radios_cust_type" class="cust_type_billing_pdf" value="billing_non_alibaba" id="billing_non_alibaba" onchange="set_get_billing_type()">
                                <span></span>Non Alibaba Cloud 
                            </label>
                            <label class="radio">
                                <input type="radio" name="radios_cust_type" class="cust_type_billing_pdf"  value="billing_alibaba" id="billing_alibaba" onchange="set_get_billing_type()">
                                <span></span>Alibaba Cloud
                            </label> 
                            <div class="col-lg-5 col-md-9 col-sm-12 input-group date alibaba_posting_date"> 
                                <input type="text" class="form-control" id="alibaba_posting_date"  placeholder="Select posting date">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="la la-calendar-check-o"></i>
                                    </span>
                                </div>
                            </div>
                        </div> 
                        <code class="error_cust_type hide">*Select customer type</code>
                    </div>
                </div> 
                <div class="form-group row">
                    <label class="col-3 col-form-label text-right">Pajak Type</label>
                    <div class="col-9 col-form-label">
                        <div class="checkbox-inline">
                            <label class="checkbox">
                                <input type="checkbox" name="billing_non_npwp" id="billing_non_npwp">
                                <span></span>Non NPWP
                            </label>
                            <label class="checkbox">
                                <input type="checkbox" name="billing_npwp" id="billing_npwp">
                                <span></span>NPWP
                            </label> 
                        </div> <code class="error_cust_npwp hide">*Select customer Non NPWP / NPWP</code>
                    </div>
                </div> 
                <div class="form-group row"> 
                    <div class="col-12 col-form-label"> 
                        <span class="form-text text-muted">*Proses pemnbuatan Billing PDF Ini mungkin membutuhkan waktu beberapa saat (kurang lebih 30 menit) </span>
                    </div>
                </div> 
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary font-weight-bold"  onclick="confirm_billing_pdf()">Confirm</button>
            </div>
        </div>
    </div>
</div>
<a id="btn_modal_new_upload_fp" data-toggle="modal" class="hide" href="#modalNewUploadFp">open modal</a> 
<div id="modalNewUploadFp" class="modal fade"  tabindex="-1" role="dialog" aria-hidden="true"  data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content"> 
            <div class="modal-header"> 
                <h5 class="modal-title" id="exampleModalLabel">Upload Faktur Pajak <span class="periode_view"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">      
                <div class="form-group row mb-10"> 
                    <div class="col-lg-6 col-md-6 col-sm-6 text-center"> 
                        <a class="btn btn-danger mr-1" data-toggle="modal" href="#modalUploadPdf">
                            <i class="icon-md far fa-file-pdf"></i> Upload File PDF
                        </a> 
                    </div> 
                    <div class="col-lg-6 col-md-6 col-sm-6 text-center"> 
                        <a class="btn btn-success mr-1" data-toggle="modal" href="#modalUploadExcel">
                            <i class="icon-md far fa-file-excel"></i> Upload File Excel
                        </a> 
                    </div> 
                </div>    
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>  
            </div>
        </div>
    </div>
</div> 
<div id="modalUploadPdf" class="modal fade"  tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content"> 
            <div class="modal-body">    
                <div class="text-center mb-10 mt-5">
                    <h4>Upload PDF Faktur Pajak</h4>   
					<hr> 
                </div>   
                <form class="form_upload_pdf" id="form_upload_pdf">
                    <div class="form-group row">
                        <label class="col-form-label col-lg-3 col-sm-12">Select File</label>
                        <div class="col-lg-9 col-md-9 col-sm-9">  
                                <input type="file" name="file_pdf_fp" id="file_pdf_fp"> 
                                <input type="text" name="periode_now" id="periode_now" class="hide" value="<?=date('M').' '.date('Y');?>"> 
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 text-right">  
                            <button class="btn btn-danger" id="upload_pdf" type="submit">Upload PDF</button>
                        </div>
                    </div>  
                </form>
            </div>
        </div>
    </div>
</div> 
<div id="modalUploadExcel" class="modal fade"  tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content"> 
            <div class="modal-body">    
                <div class="text-center mb-10 mt-5">
                    <h4>Upload List Customer Faktur Pajak</h4>   
					<hr> 
                </div>   
                <form class="form_upload_excel" id="form_upload_excel">
                    <div class="form-group row">
                        <label class="col-form-label col-lg-3 col-sm-12">Select File</label>
                        <div class="col-lg-9 col-md-9 col-sm-9">  
                            <input type="file" name="file_excel_fp" id="file_excel_fp"> 
                            <input type="text" name="periode_now" id="periode_now" class="hide" value="<?=date('M').' '.date('Y');?>"> 
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 text-right">  
                            <button class="btn btn-success" id="upload_excel" type="submit">Upload Excel</button>
                        </div>
                    </div>  
                </form>
            </div>
        </div>
    </div>
</div>   
<div id="modalSendEmail" class="modal fade"  tabindex="-1" role="dialog" aria-hidden="true"  data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content"> 
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Send Email Customer <span class="periode_view"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">     
                <div class="form-group row">
                    <label class="col-3 col-form-label text-right">Customer Type</label>
                    <div class="col-9 col-form-label">
                        <div class="checkbox-inline">
                            <label class="checkbox">
                                <input type="checkbox" name="send_corporate" id="send_corporate">
                                <span></span>Corporate
                            </label>
                            <label class="checkbox">
                                <input type="checkbox" name="send_retail" id="send_retail">
                                <span></span>Retail
                            </label>
                            <label class="checkbox">
                                <input type="checkbox" name="send_personal" id="send_personal">
                                <span></span>Personal
                            </label> 
                        </div> <code class="error_send_cust_type hide">*Select customer type</code>
                    </div>
                </div> 
                <div class="form-group row">
                    <label class="col-3 col-form-label text-right">Customer Type</label>
                    <div class="col-9 col-form-label">
                        
                        <div class="radio-inline">
                            <label class="radio">
                                <input type="radio" name="radios_cust_type" class="cust_type_send_all_email" value="send_non_alibaba" id="send_non_alibaba">
                                <span></span>Non Alibaba Cloud 
                            </label>
                            <label class="radio">
                                <input type="radio" name="radios_cust_type" class="cust_type_send_all_email"  value="send_alibaba" id="send_alibaba">
                                <span></span>Alibaba Cloud
                            </label>  
                        </div>  
                        <code class="error_send_cust_type_2 hide">*Select customer type</code>
                    </div>
                </div> <div class="form-group row">
                    <label class="col-3 col-form-label text-right">Pajak Type</label>
                    <div class="col-9 col-form-label">
                        <div class="checkbox-inline">
                            <label class="checkbox">
                                <input type="checkbox" name="send_non_npwp" id="send_non_npwp">
                                <span></span>Non NPWP
                            </label>
                            <label class="checkbox">
                                <input type="checkbox" name="send_npwp" id="send_npwp">
                                <span></span>NPWP
                            </label> 
                        </div> <code class="error_send_cust_npwp hide">*Select customer Non NPWP / NPWP</code>
                    </div>
                </div>  
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary font-weight-bold"  onclick="confirm_send_email()">Confirm</button>
            </div>
        </div>
    </div>
</div> 
<a id="btn_modal_send_email_single" data-toggle="modal" class="hide" href="#modalSendEmailSingle">open modal</a> 
<div id="modalSendEmailSingle" class="modal fade"  tabindex="-1" role="dialog" aria-hidden="true"  data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content"> 
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><span class="send_text"></span> Email Customer ID : <span class="cust_id_view"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">     
                <div class="form-group row">
                    <label class="col-3 col-form-label text-right">Customer Email</label>
                    <div class="col-9 col-form-label">
                        <textarea class="form-control cust_email_view" disabled="disabled" rows="3"></textarea>
                        <input id="list_id_send_single_email" class="hide">
                        <input id="list_cust_id_send_single_email" class="hide">
                        <input id="list_cust_name_send_single_email" class="hide">
                    </div>
                </div>  
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary font-weight-bold"  onclick="confirm_send_email_single()">Confirm</button>
            </div>
        </div>
    </div>
</div> 
<a id="btn_modal_view_billing" data-toggle="modal" class="hide" href="#modalViewBilling">open modal</a> 
<div id="modalViewBilling" class="modal fade"  tabindex="-1" role="dialog" aria-hidden="true"  data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content"> 
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Data Customer : <span class="cust_id_view"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body view_statement_mini">      
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button> 
            </div>
        </div>
    </div>
</div> 
<a id="btn_modal_view_faktur" data-toggle="modal" class="hide" href="#modalViewFaktur">open modal</a> 
<div id="modalViewFaktur" class="modal fade"  tabindex="-1" role="dialog" aria-hidden="true"  data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content" style="min-height:800px;"> 
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Data Customer : <span class="cust_id_view"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body view_faktur_mini">      
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button> 
            </div>
        </div>
    </div>
</div> 
<script src="<?=base_url()?>assets/themes/me/js/faktur_pajak.js"></script>  
<script>  
    $(document).ready(function() {  
        var base_url = "<?=base_url();?>"; 
        view_list();  
        $('#periode_view').datepicker({  
            orientation: "bottom left",  
            format: "M yyyy",
            startView: "months", 
            minViewMode: "months",
            autoclose: true,
        });
        $('#periode_upload').datepicker({  
            orientation: "bottom left",  
            format: "M yyyy",
            startView: "months", 
            minViewMode: "months",
            autoclose: true
        });
    });   
</script>