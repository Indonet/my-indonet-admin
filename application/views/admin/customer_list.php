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
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Customer List</h5>  
            </div> 
        </div>
    </div>  
    <div class="d-flex flex-column-fluid ">  
		<div class="container-fluid div_display">  
            <div class="card card-custom gutter-b">
                <div class="card-header flex-wrap py-3">
                    <div class="card-title">
                        <h3 class="card-label">Customer List
                        <span class="d-block text-muted pt-2 font-size-sm">our Customer list Indonet</span></h3>
                    </div> 
                </div>
                <div class="card-body div_list"> 
                    <table class="table table-bordered table-checkable" id="listCustomers">
                        <thead>
                            <tr> 
                                <th class="text-center">Account</th>
                                <th class="text-center">Customer Name</th>
                                <th class="text-center">Known as</th>
                                <th class="text-center">Customer Type</th>
                                <th class="text-center">Subnet</th> 
                                <th class="text-center">Status</th> 
                                <th class="text-center">Invoice</th> 
                                <th class="text-center hide">Customer Email</th>
                                <th class="text-center hide">Status Name</th> 
                                <th class="text-center hide">User Id</th> 
                                <th class="text-center hide">Instal Name</th> 
                            </tr>
                        </thead> 
                    </table> 
                </div>
            </div> 
        </div>
        <div id="slide">  
        </div> 
    </div>  
</div>  
<script>  
$(document).ready(function() {
    getDataList();
}); 
function get_cust_detail(cust_id, subnet_code){
	Swal.fire ({
		onBeforeOpen: () => {
			swal.fire({
				html: '<h5>Fetching data<br>Please wait...</h5>',
				showConfirmButton: false,
                allowOutsideClick: false
			});
			Swal.showLoading ()
		}
	}); 
    $.ajax({
        type: "POST",
        url: base_url+"get-customer-info",
        data: { 
            'cust_id':cust_id, 'subnet_code':subnet_code
        },
        cache: false,
        dataType: "html",
        success: function (res) { 
            Swal.close(); 
            $('#slide').html(res);
            $(' #slide').css('transition', '1s');
            $(' #slide').css('right', '0');
        }
    }); 
    
}
function back_to_list(){
    $(' #slide').css('transition', '1s');
    $(' #slide').css('right', '-100%');
    $('.div_display').css('height', 'auto');
}
function getDataList(){
	$('#listCustomers').DataTable( {       
		ajax:{
            "url":  base_url+"get-customer-list",
            "type": "POST"
		},
		"columns": [ 
			{   "data": "cust_id", 
				"render": function(data, type, row, meta){
					if(type === 'display'){
						data = '<a onClick="get_cust_detail(\''+data+'\',\''+row.cust_subnet_code+'\');" href="#!">' + data + '</a>';
					}
					return data;
					}
			},
			{   "data": "cust_name" }, 
			{   "data": "cust_knownas",
				"render": function(data, type, row, meta){
					if(type === 'display'){
						var cust_knownas = '-';
						if (data == null) {
							cust_knownas = " ";
						} else {
							cust_knownas = data;
						} 
						data = cust_knownas;
					}
					return data;
				}
			},
			{   "data": "cust_type" },
			{   "data": "cust_subnet_name" },  
			{   "data": "cust_id",
				"render": function(data, type, row, meta){ 
                    var data_row = '';
                    if(row.cust_status == 0){
                        data_row += '<span class="label label-lg label-success label-pill label-inline mb-2">Active</span><br>';
                    }else if(row.cust_status == 1){ 
                        data_row += '<span class="label label-inline label-warning label-pill label-inline mb-2">Hold</span><br>';
                    }else if(row.cust_status == 2) {
                        data_row = '<span class="label label-inline label-danger font-weight-bold mb-1">Close</span><br>';
                    }
                    if(row.cust_instal_name == 'Alicloud'){
                        data_row += ' <span class="label label-inline label-primary label-pill label-inline mb-2">Alicloud</span> <br>';
                    }    
					return data_row;
				}
			}, 
            {   "data": "cust_id", 
				"render": function(data, type, row, meta){
					if(type === 'display'){
						data = '<a class="btn btn-primary btn-sm" onClick="get_invoce_detail(\''+data+'\',\''+row.cust_subnet_code+'\');" href="#!"><i class="fas icon-nm fa-file-pdf"></i>view</a>';
					}
					return data;
					}
			},
			{   "data": "cust_email" },  
			{   "data": "cust_status_name" },  
            {   "data": "cust_user_id",
                "render": function(data, type, row, meta){
                    if(type === 'display'){
                        var user_id = '-';
                        if (data == null) {
                            user_id = " ";
                        } else {
                            user_id = data;
                        } 
                        data = user_id;
                    }
                    return data;
                }
            }, 
			{   "data": "cust_instal_name" },  
		], 
        "columnDefs": [
            {
                "targets": [ 7,8,9,10 ],
                "visible": false
            },
            {
                "targets": [ 6 ],
                "className": "text-center"
            }
        ],
        "pageLength": 10, 
        "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
        "order": [[0, 'desc']],
        dom: 'lBfrtip',
        buttons: [ 
            {
                text: '<i class="icon far fa-file-excel"></i> Export Excel',
                extend: 'excelHtml5',
                exportOptions: { 
                    columns: [ 0,1,2,3,4,7,8,9,10 ], 
                    // modifier: {
                    //     order: 'current',
                    //     page: 'all',
                    //     selected: null,
                    //     search: 'none' 
                    // },
                },
            }
        ],
	} );
}
function get_invoce_detail(cust_id, subnet_code){ 
    Swal.fire ({
        onBeforeOpen: () => { 
            Swal.showLoading ()
        }
    }); 
    
    setTimeout(function(){   
        var filePath = base_url+'get_inv_pdf?cust_id='+cust_id+'&subnet_code='+subnet_code;
        window.open(filePath, '_blank');
        Swal.close();  
    }, 2000);
}
</script>