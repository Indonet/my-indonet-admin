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
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Report List</h5>  
            </div> 
        </div>
    </div>  
    <div class="d-flex flex-column-fluid ">  
		<div class="container-fluid div_display">  
            <div class="card card-custom gutter-b">
                <div class="card-header flex-wrap py-3">
                    <div class="card-title">
                        <h3 class="card-label">Report List
                        <span class="d-block text-muted pt-2 font-size-sm">Report Customer</span></h3>
                    </div> 
                    <div class="card-toolbar">
                        <a href="#" class="btn btn-light-primary font-weight-bolder mr-2" onclick="add_new_report()">
                        <i class="la la-folder-plus"></i>New Report </i>
                        </a> 
                    </div>
                </div>
                <div class="card-body div_list"> 
                    <table class="table table-bordered table-checkable" id="list_report">
                        <thead>
                            <tr> 
                                <th class="text-center">Cust Id</th>
                                <th class="text-center">Cust Name</th>
                                <!-- <th class="text-center">Subnet</th> -->
                                <th class="text-center">Report Name</th>
                                <th class="text-center">Report Date</th>
                                <!-- <th class="text-center">Report File Name</th> -->
                                <th class="text-center">Delete</th>  
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                foreach ($data_report as $key => $value) {
                                    $report_date = $value['REPORT_DATE'];
                                    $report_date_array = explode("-",$report_date);
                                    $monthNum  = $report_date_array[1];
                                    $yearNum  = $report_date_array[0];
                                    $monthName = date('F', mktime(0, 0, 0, $monthNum, 10)); // March
                                    $report_date_name = $monthName.' - '.$yearNum;
                                    echo '<tr>';
                                    echo '<td>'.$value['CUSTID'].'</td>'; 
                                    echo '<td>'.$value['CUST_NAME'].'</td>'; 
                                    // echo '<td>'.$value['CUST_SUBNET_NAME'].'</td>'; 
                                    echo '<td><a href="#" onclick="view_report(\''.$value['REPORT_CODE'].'\');" >'.$value['REPORT_NAME'].'</a></td>'; 
                                    echo '<td>'.$report_date_name.'</td>'; 
                                    // echo '<td>'.$value['REPORT_FILE'].'</td>'; 
                                    echo '<td class="text-center">'.
                                            // '<i class="la la-file-pdf" onclick="view_report(\''.$value['REPORT_CODE'].'\');" style="cursor: pointer"></i> '.
                                            '<i class="la la-trash" onclick="remove_report('.$value['REPORT_CODE'].');" style="cursor: pointer"></i> '.
                                          '</td>'; 
                                    echo '</tr>';
                                }
                            ?>
                        </tbody>
                    </table> 
                </div>
            </div> 
        </div>
        <div id="slide">  
        </div> 
    </div>  
</div>   
<a id="btn_modal_new_erport" data-toggle="modal" class="hide" href="#modalNewPort">open modal</a> 
<div id="modalNewPort" class="modal fade"  tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content"> 
            <div class="modal-body">    
                <div class="text-center mb-10 mt-5">
                    <h4>Upload report</h4>  
                    <div class="loading_modal hide" style="z-index: 9999; text-align: center; width: 90%; position: absolute;">
                        <img style="margin: 0 auto; margin-top: 20%; width: 200px" src="/assets/themes/me/img/loading.gif">
                    </div>
					<hr> 
                </div> 
                <div class="form-group row">
                    <label class="col-form-label text-right col-lg-4 col-sm-12">Customer Name</label>
                    <div class="col-lg-8 col-md-8 col-sm-12">
                        <select class="form-control" id="company_data" name="param"> 
                            <?php
                                // foreach ($data_list_customer_group as $key => $value) {
                                //     $company_name = $value['cust_name'];
                                //     echo '<option value="AK">'.$company_name.'</option>';
                                // } 
                            ?>
                        </select>
                    </div>
                </div>  
                <div class="form-group row">
                    <label class="col-form-label text-right col-lg-4 col-sm-12">Customer Data</label>
                    <div class="col-lg-8 col-md-8 col-sm-12">
                        <textarea class="form-control" readonly="readonly" rows="5" id="cust_data"></textarea>
                    </div>
                </div>  
                <hr>
                <div class="text-center">
                    <button class="btn btn-success mr-2 btn_pay_now hide font-weight-bolder" onclick="confirm_pay_now()"><i class=" flaticon2-check-mark"></i>Confirm</button>
                    </div>
            </div>
        </div>
    </div>
</div>
<script src="<?=base_url()?>assets/themes/js/pages/crud/forms/widgets/select2.js"></script>
<script>  
$(document).ready(function() {
    // getDataList();
    var base_url = "<?=base_url();?>"; 
    $('#list_report').DataTable({"order": [[ 3, "desc" ]]});
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
 
</script>