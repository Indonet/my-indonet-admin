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
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Payment List  <?=date('F Y');?></h5>  
            </div> 
        </div>
    </div>  
    <div class="d-flex flex-column-fluid ">  
		<div class="container-fluid div_display">  
            <div class="card card-custom gutter-b">
                <div class="card-header flex-wrap py-3">
                    <div class="card-title">
                        <h3 class="card-label">Payment List 
                        <span class="d-block text-muted pt-2 font-size-sm">Periode <?=date('F Y');?></span></h3>
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
                                <th class="text-center">Cust Subnet</th> 
                                <th class="text-center">Invoice Amount</th> 
                                <th class="text-center">Payment Amount <br>(Inv + Payment Fee)</th>
                                <th class="text-center">Payment Date</th>
                                <th class="text-center">Payment Type</th>
                                <th class="text-center">Payment Status</th>   
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                foreach ($data_payment as $key => $value) { 
                                    $status = $value['status'];
                                    switch ($status) {
                                        case '1': 
                                            $status_name = 'Created';
                                            $pay_date = '';
                                            break; 
                                        case '2':
                                            $status_name = 'Waiting';
                                            $pay_date = '';
                                            break; 
                                        case '3':
                                            $status_name = 'Paid';
                                            $pay_date = date("d-F-Y  H:is", strtotime($value['payment_date']));
                                            break; 
                                        default:
                                            $status_name = 'Waiting';
                                            $pay_date = '';
                                            break;
                                    }
                                    if($value['payment_date'])
                                    echo '<tr>';
                                    echo '<td>'.$value['cust_id'].'</td>'; 
                                    echo '<td>'.$value['cust_name'].'</td>';   
                                    echo '<td>'.$value['cust_subnet'].'</td>';   
                                    echo '<td class="text-right">Rp. '.number_format($value['billing'],2, '.', ',').'</td>';   
                                    echo '<td class="text-right">Rp. '.number_format($value['payment_total'],2, '.', ',').'</td>';   
                                    echo '<td>'.$pay_date.'</td>';  
                                    echo '<td>'.$value['payment_name'].'</td>';   
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
<script>  
$(document).ready(function() { 
    var base_url = "<?=base_url();?>"; 
    $('#list_domain').DataTable({"order": [[ 5, "desc" ]]}); 
});  
</script>