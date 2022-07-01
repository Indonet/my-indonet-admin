<style>
    .invoice-box {
        /* max-width: 800px; */
        margin: auto;
        /* padding: 30px; */
        /* border: 1px solid #eee; */
        /* box-shadow: 0 0 10px rgba(0, 0, 0, 0.15); */
        font-size: 14px;
        line-height: 20px;
        font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        color: #555;
    }

    .invoice-box table {
        width: 100%;
        line-height: inherit;
        text-align: left;
    }

    .invoice-box table td {
        padding: 5px;
        vertical-align: middle;
    }

    .invoice-box table tr td:nth-child(2) {
        text-align: right;
    }

    .invoice-box table tr.top table td {
        padding-bottom: 20px;
    }

    .invoice-box table tr.top table td.title {
        font-size: 45px;
        line-height: 12px;
        color: #333;
    }

    .invoice-box table tr.information table td {
        padding-bottom: 40px;
    }

    .invoice-box table tr.heading td {
        background: #eee;
        border-bottom: 1px solid #ddd;
        font-weight: bold;
    }

    .invoice-box table tr.details td {
        padding-bottom: 20px;
    }

    .invoice-box table tr.item td {
        border-bottom: 1px solid #eee;
    }

    .invoice-box table tr.item.last td {
        border-bottom: none;
    }

    .invoice-box table tr.total td:nth-child(2) {
        border-top: 2px solid #eee;
        font-weight: bold;
    }

    @media only screen and (max-width: 600px) {
        .invoice-box table tr.top table td {
            width: 100%;
            display: block;
            text-align: center;
        }

        .invoice-box table tr.information table td {
            width: 100%;
            display: block;
            text-align: center;
        }
    }
    .total_info { 
        width: 80% !important;
        float: right;
    }
    .total_info tr.header td {
        background: #afb3b2; 
        font-weight: bold;
        text-align: center !important;
        font-size: 14px !important;
        padding-bottom: 0px !important; 
    }
    .total_info tr.details td {
        background: #dae0df;
        border-bottom: 1px solid #ddd;
        font-weight: bold;
        text-align: center !important;
        font-size: 14px !important;
        padding-bottom: 1px !important; 
    }
    
    /** RTL **/
    .invoice-box.rtl {
        direction: rtl;
        font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
    }

    .invoice-box.rtl table {
        text-align: right;
    }

    .invoice-box.rtl table tr td:nth-child(2) {
        text-align: left;
    }
    .indonet-pt{
        font-weight: bold;
        font-size: 17px;
        margin-bottom: 20px;
    }
    .indonet-info{ 
        font-size: 14px;
        line-height: 20px;
    }
    .logo-pt{
        margin-bottom: 30px;
        width: 100%; 
        max-width: 150px
    }
    .info-cust td{    
        font-size: 14px !important; 
        padding-bottom: 1px !important; 
    }
    .info-end{
        border: 1px solid black;
        padding: 20px;
        margin-top: 20px;
    }
</style>
<div class="invoice-box">
    <table>
        <tr class="heading">
            <td>Ringkasan Tagihan</td> 
            <td colspan="2" style="text-align: center;">Total (IDR)</td>
        </tr> 
        <tr class="item">
            <?php
                foreach ($inv_detail_bill as $key => $value) {
                    if($value['TRANSTYPE'] == '95'){         
                        $val_amount = number_format(round($value['AMOUNTMST']),2, '.', ',');  
                        if($val_amount < 0){ 
                            $val_amount = '('.str_replace("-","",$val_amount).')'; 
                        } 
                        echo '<td>Saldo bulan lalu</td>'; 
                        echo '<td style="text-align: right">IDR</td>'; 
                        echo '<td style="text-align: right" class=" width-100">'.$val_amount.'</td>';
                    }
                }
            ?>
        </tr>  
        <tr class="item"> 
            <td  colspan="3">&nbsp;</td> 
        </tr> 
        <?php  
            array_multisort(array_column($inv_detail_bill, 'TRANSDATE'), SORT_ASC, $inv_detail_bill); 
            foreach ($inv_detail_bill as $key => $value) {   
                if($value['TRANSTYPE'] == '15' && $value['NOTPRINT'] != 1){   
                    $val_amount = number_format(round($value['AMOUNTMST']),2, '.', ',');  
                    if($val_amount < 0){ 
                        $val_amount = '('.str_replace("-","",$val_amount).')'; 
                    } 
                    echo "<tr class='item'>";  
                    echo '<td>'.date("d - M - Y",strtotime($value['DOCUMENTDATE'])).' <b>'.$value['TXT'].'</b></td>'; 
                    echo '<td style="text-align: right">IDR</td>'; 
                    echo '<td style="text-align: right"  class=" width-100">'.$val_amount.'</td>';
                    echo "</tr>";  
                }
            }
        ?> 
        <tr class="item"> 
            <td  colspan="3">&nbsp;</td> 
        </tr> 
        <?php  
            $inv_product = array();
            foreach ($inv_detail_bill as $key => $row){
                if($row['TRANSTYPE'] != '95' && $row['TRANSTYPE'] != '15' && $row['NOTPRINT'] != 1){  
                    $wek[$key]  = $row['NAME'];
                    $array_data = array('ACCOUNTNUM' => $row['ACCOUNTNUM'], 'NAME'=>$row['NAME'], 'INVOICEDATE'=>$row['INVOICEDATE'], 'AMOUNTMST'=>$row['AMOUNTMST']);
                    array_push($inv_product, $array_data); 
                }
            }     
            array_multisort($wek, SORT_ASC, $inv_product);  
            $name_product = '';
            $array_inv = array();  
            $ppn_tax = 1.11;  
            foreach ($inv_product as $key => $value) {    
                if($name_product == $value['NAME']){ 
                    $name_product = $value['NAME'];
                    $amount_ori = $value['AMOUNTMST'];
                    $amount = $amount+($amount_ori/$ppn_tax); 
                    $inv_date = $value['INVOICEDATE']; 
                    foreach ($array_inv as $key2 => $value2) {
                        if($value2['name'] == $name_product){
                            unset($array_inv[$key2]); 
                        } 
                    }  
                    $array_save = array('name'=>$name_product, 'amount'=>$amount, 'inv_date'=>$inv_date);
                    array_push($array_inv, $array_save);  
                }else{ 
                    $name_product = $value['NAME'];
                    $amount_ori = $value['AMOUNTMST'];
                    $amount = $amount_ori/$ppn_tax;
                    $inv_date = $value['INVOICEDATE'];
                    $array_save = array('name'=>$name_product, 'amount'=>$amount, 'inv_date'=>$inv_date);
                    array_push($array_inv, $array_save);  
                } 
            }  
            $amount_total = 0; 
            array_multisort(array_column($array_inv, 'inv_date'), SORT_ASC, $array_inv); 
            foreach ($array_inv as $key => $value) {     
                $val_amount = number_format(round($value['amount']),2, '.', ',');  
                if($val_amount < 0){ 
                    $val_amount = '('.str_replace("-","",$val_amount).')'; 
                } 

                echo "<tr class='item'>";  
                echo '<td>'.date("d - M - Y",strtotime($value['inv_date'])).' <b>'.$value['name'].'</b></td>';                             
                echo '<td style="text-align: right">IDR</td>'; 
                echo '<td style="text-align: right"  class=" width-100">'.$val_amount.'</td>';
                echo "</tr>"; 
                $amount_total = $amount_total+$value['amount'];

            }  
            $ppn_val = round($amount_total*11/100);  
            $ppn_val = number_format($ppn_val,2, '.', ',');  
            if($ppn_val < 0){ 
                $ppn_val = '('.str_replace("-","",$ppn_val).')'; 
            } 
            $amount_total = number_format(round($amount_total),2, '.', ',');   
            if($amount_total < 0){ 
                $amount_total = '('.str_replace("-","",$amount_total).')'; 
            } 
            $inv_month_bill = number_format(round($inv_month_bill),2, '.', ',');    
            if($inv_month_bill < 0){ 
                $inv_month_bill = '('.str_replace("-","",$inv_month_bill).')'; 
            } 
            $ppn_text = 'PPN-VAT  (11%)'; 
            echo "<tr class='item'>";  
            echo '<td colspan="3">&nbsp;</td>';                           
            echo "</tr>"; 
            echo "<tr class='item'>";                            
            echo '<td><b>Subtotal (Base Amount Taxable)</b></td>';                             
            echo '<td style="text-align: right">IDR</td>';
            echo '<td style="text-align: right"  class=" width-100">'.$amount_total.'</td>';
            echo "</tr>"; 
            echo "<tr class='item'>";                            
            echo '<td><b>'.$ppn_text.'</b></td>';                             
            echo '<td style="text-align: right">IDR</td>';
            echo '<td style="text-align: right"  class=" width-100">'.$ppn_val.'</td>';
            echo "</tr>"; 
        ?>
        <tr class="heading">
            <td style="text-align: center">Jumlah Tagihan</td> 
            <td>IDR</td>
            <td style="text-align: right"><b><?=$inv_month_bill;?></b></td>
        </tr> 
    </table>
</div>