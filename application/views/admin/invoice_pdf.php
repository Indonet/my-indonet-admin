<style>
    @media print {
  body * {
    visibility: hidden;
  }
  #section-to-print, #section-to-print * {
    visibility: visible;
  } 
}
</style>

<link href="<?=base_url()?>assets/themes/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
<link href="<?=base_url()?>assets/themes/plugins/custom/prismjs/prismjs.bundle.css" rel="stylesheet" type="text/css" />
<link href="<?=base_url()?>assets/themes/css/style.bundle.css" rel="stylesheet" type="text/css" />   
<link href="<?=base_url()?>assets/themes/me/css/custom.css" rel="stylesheet" type="text/css" />  
<div id="section-to-print" style="background-color: white;">
    <div class="row justify-content-center py-8 px-8 px-md-0">
        <div class="col-md-11 border-bottom w-100">
            <div class="d-flex justify-content-between flex-column flex-md-row">
                <address>
                    <img src="<?=base_url()?>assets/themes/me/img/indonet-logo.png" class="logo-billing">
                    <br>
                    <br>
                    <strong>PT IndoInternet Tbk</strong><br>
                    <p class="">Rumah Indonet
                        <br> Jl. Rempoa Raya No. 11 
                        <br> Ciputat, Tangerang Selatan, Banten 15412
                        <br> Telp: (021) 73882525  Fax: (021) 73882626
                        <br> N.P.W.P. : 01.673.865.0-058.000  
                        <br> PKP.: 01.673.865.0-058.000
                    </p>
                </address> 
                <span style="margin: 50px;">
                    <h1>Billing Statement</h1>
                </span>
                <!-- <div class="d-flex flex-column align-items-md-end px-0">  
                    <?php //print_r($inv_detail_bill); ?>
                    <address>  
                        <h3 class="font-bold"><?=$data_cust->NAME?></h3>
                        <h4 class="font-bold"><?=$data_cust->KNOWNAS?></h4>
                        <p class=" pt-4">
                            <?php    
                                $dateObj   = DateTime::createFromFormat('!m', $month_bill);
                                $month_name_now = $dateObj->format('F');   
                            ?>
                            <table>
                                <tr>
                                    <td class="width-120">Billing No </td>
                                    <td> : SO-<?php echo $month_now.''.substr($year_bill,2); ?>-<?=$data_cust->ACCOUNTNUM?></td>
                                </tr>
                                <tr><td class="width-100">Customer No </td><td> : <?=$data_cust->ACCOUNTNUM?> </td></tr> 
                                <tr><td class="width-100">&nbsp;</td><td> &nbsp; </td></tr> 
                                <tr>
                                    <td class="width-100 font-weight-bold font-14">Billing</td>
                                    <td class=" font-weight-bold font-14"> :  IDR <?=number_format($inv_month_bill, 0, ',', '.');?> </td>
                                </tr> 
                                <tr><td class="width-100">Invoice Month </td><td> : <?php echo $month_name_now.' '.$year_bill; ?> </td></tr> 
                                <tr><td class="width-100">Due Date  </td><td> : 20 <?php echo $month_name_now.' '. $year_bill; ?></td></tr>  
                            </table>                   
                        </p>
                    </address>
                </div> -->
            </div> 
        </div> 
    </div> 
    <div class="row justify-content-center"> 
        <?php    
            $dateObj   = DateTime::createFromFormat('!m', $month_bill);
            $month_name_now = $dateObj->format('F');   
        ?>
        <div class="col-md-11">
            <div class="d-flex  flex-column flex-md-row"> 
                <div class="d-flex flex-column px-0 col-md-8">   
                    <div class="width-400">  
                        <h3 class="font-bold"><b><?=$data_cust->NAME?></b></h3>
                        <h4 class="font-bold"><?=$data_cust->KNOWNAS?></h4>
                        <h5 class="font-bold"><?=$data_cust->INVOICEADDRESS?></h5>
                    </div>
                </div>
                <div class="d-flex flex-column col-md-2">  
                    <table class="table display_inv text-center">
                        <thead>
                            <tr>
                                <th><b>Due Date</b></th> 
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>  <b>20 <?php echo $month_name_now.' '. $year_bill; ?> </b></td> 
                            </tr> 
                        </tbody>
                    </table> 
                </div>
                <div class="d-flex flex-column col-md-2">
                    <table class="table display_inv text-center">
                        <thead>
                            <tr>
                                <th> <b>Amount Billing </b></th> 
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td> <b>IDR <?=number_format($inv_month_bill, 2, '.', ',');?>  </b></td> 
                            </tr> 
                        </tbody>
                    </table> 
                </div> 
            </div> 
        </div> 
        <div class="col-md-11">
            <div class="d-flex  flex-column flex-md-row"> 
                <div class="d-flex flex-column px-0 col-md-8">  
                    &nbsp;
                </div>
                <div class="d-flex flex-column col-md-4">  
                    <table class="table display_info_inv"> 
                        <tbody>
                            <tr>
                                <td><b>Invoice Month</b></td> 
                                <td><?php echo $month_name_now.' '.$year_bill; ?></td> 
                            </tr>
                            <tr>
                                <td><b>Billing No</b></td> 
                                <td>SO-<?php echo $month_now.''.substr($year_bill,2); ?>-<?=$data_cust->ACCOUNTNUM?></td> 
                            </tr>
                            <tr>
                                <td><b>Customer No</b></td> 
                                <td><?=$data_cust->ACCOUNTNUM?></td> 
                            </tr> 
                        </tbody>
                    </table> 
                </div>  
            </div> 
        </div>
    </div> 
    <div class="row justify-content-center py-8 px-8 py-md-10 px-md-0"> 
        <div class="col-md-10">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="pl-0 font-weight-bold text-muted text-uppercase">Date</th>
                            <th class="text-center font-weight-bold text-muted text-uppercase">Description</th> 
                            <th class="text-center pr-0 font-weight-bold text-muted text-uppercase width-100" colspan="2">Total</th>
                        </tr>
                    </thead>
                    <tbody> 
                        <tr class="font-weight-boldest"> 
                            <?php
                                foreach ($inv_detail_bill as $key => $value) {
                                    if($value->TRANSTYPE == '95'){                             
                                        echo '<td>&nbsp;</td>';
                                        echo '<td>Saldo bulan lalu</td>'; 
                                        echo '<td style="text-align: right">IDR</td>';
                                        echo '<td style="text-align: right" class=" width-100">'.number_format($value->AMOUNTMST,2, '.', ',').'</td>';
                                    }
                                }
                            ?>
                        </tr>
                        <tr> 
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <?php  
                            foreach ($inv_detail_bill as $key => $value) {   
                                if($value->TRANSTYPE == '15' && $value->NOTPRINT != 1){  
                                    echo "<tr class='font-weight-boldest'>";  
                                    echo '<td>'.date("d - M - Y",strtotime($value->PAYMENTDATE)).'</td>';                               
                                    echo '<td>'.$value->TXT.'</td>'; 
                                    echo '<td style="text-align: right">IDR</td>';
                                    echo '<td style="text-align: right"  class=" width-100">'.number_format($value->AMOUNTMST,2, '.', ',').'</td>';
                                    echo "</tr>";  
                                }
                            }
                        ?>
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td> 
                        </tr>
                        <?php 
                            foreach ($inv_detail_bill as $key => $value) {   
                                if($value->TRANSTYPE != '95' && $value->TRANSTYPE != '15' && $value->NOTPRINT != 1){  
                                    echo "<tr class='font-weight-boldest'>";  
                                    echo '<td>'.date("d - M - Y",strtotime($value->INVOICEDATE)).'</td>';                          
                                    echo '<td>'.$value->NAME.'</td>';                             
                                    echo '<td style="text-align: right">IDR</td>';
                                    echo '<td style="text-align: right"  class=" width-100">'.number_format($value->AMOUNTMST,2, '.', ',').'</td>';
                                    echo "</tr>";  
                                }
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div> 
    <div class="row justify-content-center bg-gray-100 py-8 px-8 py-md-10 px-md-0">
        <div class="col-md-10">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>  
                            <th class="font-weight-bold text-right text-muted text-uppercase">TOTAL AMOUNT</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="font-weight-bolder">  
                            <td class="text-danger text-right font-size-h3 font-weight-boldest">IDR <?=number_format($inv_month_bill,2, '.', ',');?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div> 
    <div class="row justify-content-center py-8 px-8 py-md-10 px-md-0 hide">
        <div class="col-md-10">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>  
                            <th class="font-weight-bold text-right text-muted text-uppercase">TOTAL AMOUNT</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="font-weight-bolder">  
                            <td class="text-danger text-right font-size-h3 font-weight-boldest">IDR <?=number_format($inv_month_bill,2, '.', ',');?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div> 
</div>
<div class="row justify-content-center py-8 px-8 py-md-10 px-md-0" style="background-color: white;">
    <div class="col-md-11">
        <div class="d-flex flex-column align-items-md-end px-0 text-right">  
            <button type="button" class="btn btn-primary font-weight-bold float-right" onclick="window.print();">Download Invoice</button>
        </div>
    </div>
</div> 