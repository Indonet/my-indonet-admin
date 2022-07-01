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
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Domain List</h5>  
            </div> 
        </div>
    </div>  
    <div class="d-flex flex-column-fluid ">  
		<div class="container-fluid div_display">  
            <div class="card card-custom gutter-b">
                <div class="card-header flex-wrap py-3">
                    <div class="card-title">
                        <h3 class="card-label">Domain List
                        <span class="d-block text-muted pt-2 font-size-sm">Domain Customer</span></h3>
                    </div> 
                    <div class="card-toolbar"> 
                    </div>
                </div>
                <div class="card-body div_list"> 
                    <table class="table table-bordered table-checkable" id="list_domain">
                        <thead>
                            <tr> 
                                <th class="text-center">Cust Id</th>
                                <th class="text-center">Cust Name</th> 
                                <th class="text-center">Domain Name</th>
                                <th class="text-center">End Date</th>
                                <th class="text-center">Ns Data</th>  
                                <th class="text-center">Auth Code</th>  
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                foreach ($data_domain as $key => $value) {
                                    $end_date = $value['enddate'];
                                    $end_date_array = explode("-",$end_date);
                                    $monthNum  = $end_date_array[1];
                                    $yearNum  = $end_date_array[0];
                                    $monthName = date('F', mktime(0, 0, 0, $monthNum, 10)); // March
                                    $end_date_name = $monthName.' - '.$yearNum;
                                    echo '<tr>';
                                    echo '<td>'.$value['cust_id'].'</td>'; 
                                    echo '<td>'.$value['cust_name'].'</td>';   
                                    echo '<td>'.$value['domain_name'].'</td>';   
                                    echo '<td>'.$end_date_name.'</td>';  
                                    echo '<td>'.$value['ns_data'].'</td>';   
                                    echo '<td>'.$value['authcode'].'</td>';   
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
<script>  
$(document).ready(function() { 
    var base_url = "<?=base_url();?>"; 
    $('#list_domain').DataTable({"order": [[ 3, "desc" ]]}); 
});  
</script>