<div class="content d-flex flex-column flex-column-fluid" id="kt_content"> 
    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap"> 
            <div class="d-flex align-items-center flex-wrap mr-2"> 
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Transaction Info</h5>  
            </div> 
        </div>
    </div> 
    <div class="d-flex flex-column-fluid">  
		<div class="container-fluid">  
            <div class="card card-custom gutter-b">
                <div class="card-header flex-wrap py-3">
                    <div class="card-title">
                        <h3 class="card-label">Transaction List
                        <span class="d-block text-muted pt-2 font-size-sm">your transaction list Indonet</span></h3>
                    </div> 
                </div>
                <div class="card-body"> 
                    <table class="table table-bordered table-checkable" id="kt_datatable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Transaction Date</th>
                                <th>Transaction Description</th>
                                <th>Total</th> 
                            </tr>
                        </thead>
                        <tbody> 
                            <?php
                                $no = 1; 
                                foreach ($trans_list as $key => $value) {  
                                    foreach ($inv_list as $keyInv => $valueInv) {   
                                        if($value->TRANSTYPE == '8'){
                                            $valTransType = 'Customer';
                                            if($value->INVOICE == $valueInv->INVOICEID){
                                                $descTrans = $valueInv->NAME;
                                            }
                                        }else if($value->TRANSTYPE == '15'){
                                            $descTrans = $value->TXT;
                                            $valTransType = 'Payment';
                                        }else if($value->TRANSTYPE == '0'){
                                            $descTrans = 'Saldo Awal';
                                            $valTransType = '';
                                        }else{
                                            $valTransType = '';
                                        } 
                                    } 
                                    $trans_date =  date_create($value->TRANSDATE);
                                    $trans_date = (date_format($trans_date,"d M Y")); 
                                    echo '<tr>';
                                    echo '<td>'.$no.'</td>'; 
                                    echo '<td>'.$trans_date.'</td>'; 
                                    echo '<td>'.$descTrans.'</td>';  
                                    echo '<td style="text-align: right">Rp. '.number_format($value->AMOUNTCUR,0,",",".").'</td>';
                                    echo '</tr>';
                                    $no++;
                                }
                            ?>
                        </tbody>
                    </table> 
                </div>
            </div>
        </div>
    </div>
</div>