<div class="card card-custom gutter-b">  
    <div class="card-body d-flex align-items-center justify-content-between flex-wrap py-3"> 
        <div class="d-flex align-items-center mr-2 py-2"> 
            <h3 class="font-weight-bold mb-0 mr-10">Customer id (<?=$data_cust[0]['ACCOUNTNUM']?>)</h3> 
        </div> 
        <div class="card-toolbar">
            <a href="#" class="btn btn-light-primary font-weight-bolder mr-2" onclick="back_to_list()">
                Back to List &nbsp; &nbsp;<i class="ki ki-bold-double-arrow-next "></i>
            </a> 
        </div>
    </div> 
</div> 
<div class="container-fluid">
    <?php
        // print_r($data_cust); 
        $statusCust = '';
        if(isset($data_cust[0]['MK_CUSTSTATUS'])){
            switch ($data_cust[0]['MK_CUSTSTATUS']) {
                case 0:
                    $statusCust = '<span class="label label-inline label-light-success font-weight-bold">Active</span>';
                    break;
                case 1:
                    $statusCust = '<span class="label label-inline label-light-primary font-weight-bold">Hold</span>';
                    break;
                case 2:
                    $statusCust = '<span class="label label-inline label-light-danger font-weight-bold">Close</span>';
                    break; 
            }  
        }
        $ym_now =  date('Ym');   
        $month_name_now =  date('M Y');   
        $inv_date_list = array(); 
        $inv_bill_list = array();   
        $inv_month_total = $data_cust['INV_MONTH_TOTAL'];
        $last_inv_total = $data_cust['INV_MONTH_TOTAL'][$ym_now];
        foreach ($inv_month_total as $key => $value) { 
            $y = substr($key, 0,-2);
            $m = substr($key, -2); 
            $inv_date =  date_create($y.'-'.$m); 
            $inv_date = date_format($inv_date,"M Y"); 
            array_push($inv_date_list, $inv_date); 
            array_push($inv_bill_list, $value); 
        }  
        $inv_date_list = json_encode($inv_date_list); 
        $inv_bill_list = json_encode($inv_bill_list); 
        $json_data_cust = json_encode($data_cust[0]); 
        $json_data_cust_bank = json_encode($data_cust['VIRTUAL_ACC']);  
         
        if(isset($data_cust['BALANCE'][0]['BALANCEMST'])){
            $last_balance = (int)$data_cust['BALANCE'][0]['BALANCEMST'];
        }else{
            $last_balance = 0;
        }

        // if(isset($data_cust['BALANCEMST'])){
        //     $last_balance = (int)$data_cust['BALANCEMST'];
        // }else{
        //     $last_balance = 0;
        // }
        $json_inv_month_total = json_encode($data_cust['INV_MONTH_TOTAL']);
        $json_inv_month_details = json_encode($data_cust['INV_DETAIL_DATA']); 
        $INVOICEADDRESS = '-';
        if(isset($data_cust[0]['INVOICEADDRESS'])){
            $INVOICEADDRESS = $data_cust[0]['INVOICEADDRESS'];
        }
        $INSTALATIONADDRESS = '-';
        if(isset($data_cust[0]['INSTALATIONADDRESS'])){
            $INSTALATIONADDRESS = $data_cust[0]['INSTALATIONADDRESS'];
        }
        $FAKTURPAJAKADDRESS = '-';
        if(isset($data_cust[0]['FAKTURPAJAKADDRESS'])){
            $FAKTURPAJAKADDRESS = $data_cust[0]['FAKTURPAJAKADDRESS'];
        }
    ?> 
    <div class="d-flex flex-row"> 
        <div class="flex-row-auto offcanvas-mobile w-300px w-xl-350px"> 
            <div class="card card-custom"> 
                <div class="card-body pt-15"> 
                    <div class="text-center mb-5">
                        <div class="symbol symbol-60 symbol-circle symbol-xl-90">
                            <div class="symbol-label" style="background-image:url('/assets/themes/me/img/icon_profile.jpg')"></div>
                            <i class="symbol-badge symbol-badge-bottom bg-success"></i>
                        </div>
                        <h4 class="font-weight-bold my-2"><?=$data_cust[0]['NAME']?></h4>
                        <div class="text-muted mb-2"><?=$data_cust[0]['KNOWNAS']?></div>
                        <div href="#" class="text-muted font-weight-bold py-1"> 
                            <?=$statusCust?> 
                        </div> 
                        <div href="#" class="text-muted font-weight-bold py-2 "> 
                            <i class="icon-1x text-dark-50 flaticon2-location"></i>
                            <?=$data_cust[0]['DISTRICTNAME']?>
                        </div>  
                        <div class="card-body d-flex align-items-center flex-wrap"> 
                            <div class="d-flex align-items-center flex-lg-fill mr-5 my-1"> 
                                <div class="d-flex flex-column text-dark-75">
                                    <span class="font-weight-bolder font-size-sm">Invoice</span>
                                    <span class="font-weight-bolder font-size-h5"> 
                                    <span class="text-dark-50 font-weight-bold">Rp. </span><?=number_format($last_inv_total, 0, ',', '.');?></span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center flex-lg-fill mr-5 my-1"> 
                                <div class="d-flex flex-column text-dark-75">
                                    <span class="font-weight-bolder font-size-sm">Balance</span>
                                    <span class="font-weight-bolder font-size-h5"> 
                                    <span class="text-dark-50 font-weight-bold">Rp. </span><?=number_format($last_balance, 0, ',', '.');?></span>
                                </div>
                            </div>
                        </div> 
                    </div>  
                    <hr>
                    <a href="#" class="btn btn-hover-light-primary font-weight-bold py-3 px-6 mb-2 text-center btn-block btn_menu_cust_info btn_personal active"  onclick="personal_info()">Personal info</a>
                    <a href="#" class="btn btn-hover-light-primary font-weight-bold py-3 px-6 mb-2 text-center btn-block btn_menu_cust_info btn_product"  onclick="product_info()">Product info</a>
                    <a href="#" class="btn btn-hover-light-primary font-weight-bold py-3 px-6 mb-2 text-center btn-block btn_menu_cust_info btn_trans"  onclick="trans_info()">Transaction info</a>
                    <a href="#" class="btn btn-hover-light-primary font-weight-bold py-3 px-6 mb-2 text-center btn-block btn_menu_cust_info btn_bill"  onclick="billing_info()">Billing Statement</a>
                </div> 
            </div> 
        </div>   
        <div class="flex-row-fluid ml-lg-8 div_display_cust_info personal_info hide"> 
            <div class="row">
                <div class="col-lg-12">  
                    <div class="card card-custom card-stretch gutter-b"> 
                        <div class="card-header border-0 py-5">
                            <h3 class="card-title font-weight-bolder text-dark">Personal details</h3> 
                        </div> 
                        <div class="tab-pane active" id="contact_view" role="tabpanel">
                            <form class="form">
                                <div class="row">
                                    <div class="col-lg-9 col-xl-6 offset-xl-3">
                                        <h3 class="font-size-h6 mb-5">User Info:</h3>
                                    </div>
                                </div> 
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label text-right">Customer id</label>
                                    <div class="col-lg-9 col-xl-7">
                                        <input class="form-control form-control-lg form-control-solid" readonly type="text" value="<?=$data_cust[0]['ACCOUNTNUM']?>" />
                                    </div>
                                </div> 
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label text-right">Name</label>
                                    <div class="col-lg-9 col-xl-7">
                                        <input class="form-control form-control-lg form-control-solid" readonly type="text" value="<?=$data_cust[0]['NAME']?>" />
                                    </div>
                                </div> 
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label text-right">Knownas</label>
                                    <div class="col-lg-9 col-xl-7">
                                        <input class="form-control form-control-lg form-control-solid" readonly type="text" value="<?=$data_cust[0]['KNOWNAS']?>" />
                                    </div>
                                </div> 
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label text-right">Subnet</label>
                                    <div class="col-lg-9 col-xl-7">
                                        <input class="form-control form-control-lg form-control-solid" readonly type="text" value="<?=$data_cust[0]['DISTRICTNAME']?>" />
                                    </div>
                                </div> 
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label text-right">Register date</label>
                                    <div class="col-lg-9 col-xl-7">
                                        <input class="form-control form-control-lg form-control-solid" readonly type="text" value="<?=$data_cust[0]['MK_REGISTRATIONDATE']?>" />
                                    </div>
                                </div> 
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label text-right">Customer type</label>
                                    <div class="col-lg-9 col-xl-7">
                                        <input class="form-control form-control-lg form-control-solid" readonly type="text" value="<?=$data_cust[0]['TYPECUST']?>" />
                                    </div>
                                </div> 
                                <div class="separator separator-dashed my-10"></div> 
                                <div class="row">
                                    <div class="col-lg-9 col-xl-6 offset-xl-3">
                                        <h3 class="font-size-h6 mb-5">Contact Info:</h3>
                                    </div>
                                </div> 
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label text-right">Phone</label>
                                    <div class="col-lg-9 col-xl-7">
                                        <div class="input-group input-group-lg input-group-solid">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="la la-phone"></i>
                                                </span>
                                            </div>
                                            <input class="form-control form-control-lg form-control-solid" readonly type="text" value="<?=$data_cust[0]['PHONE']?>" />
                                        </div>
                                        <span class="form-text text-muted">We'll never share your email with anyone else.</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label text-right">Email Address</label>
                                    <div class="col-lg-9 col-xl-7">
                                        <div class="input-group input-group-lg input-group-solid">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="la la-at"></i>
                                                </span>
                                            </div>
                                            <input class="form-control form-control-lg form-control-solid" readonly type="text" value="<?=$data_cust[0]['EMAIL']?>" />
                                        </div>
                                    </div>
                                </div> 
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label text-right">Invoice Address</label>
                                    <div class="col-lg-9 col-xl-7">
                                        <div class="input-group input-group-lg input-group-solid">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="la la-home"></i>
                                                </span>
                                            </div>
                                            <textarea class="form-control form-control-lg form-control-solid"  rows="4" readonly><?=$INVOICEADDRESS?></textarea>
                                        </div>
                                    </div>
                                </div>  
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label text-right">Instalation Address</label>
                                    <div class="col-lg-9 col-xl-7">
                                        <div class="input-group input-group-lg input-group-solid">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="la la-home"></i>
                                                </span>
                                            </div>
                                            <textarea class="form-control form-control-lg form-control-solid"  rows="4" readonly><?=$INSTALATIONADDRESS ?></textarea>
                                        </div>
                                    </div>
                                </div> 
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label text-right">Faktur Pajak Address</label>
                                    <div class="col-lg-9 col-xl-7">
                                        <div class="input-group input-group-lg input-group-solid">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="la la-home"></i>
                                                </span>
                                            </div>
                                            <textarea class="form-control form-control-lg form-control-solid"  rows="4" readonly><?=$FAKTURPAJAKADDRESS ?></textarea>
                                        </div>
                                    </div>
                                </div>   
                            </form>
                        </div> 
                    </div> 
                </div> 
            </div>  
        </div>  
        <div class="flex-row-fluid ml-lg-8 div_display_cust_info product_info hide"> 
            <div class="row">
                <div class="col-lg-12">    
                    <div class="card card-custom card-stretch gutter-b"> 
                        <div class="card-header flex-wrap py-3">
                            <div class="card-title">
                                <h3 class="card-label">Products List
                                <span class="d-block text-muted pt-2 font-size-sm">your products list Indonet</span></h3>
                            </div> 
                        </div>
                        <div class="card-body"> 
                            <table class="table table-bordered table-checkable" id="kt_datatable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Product Name</th> 
                                        <th>Total</th> 
                                        <th>Status</th> 
                                    </tr>
                                </thead>
                                <tbody> 
                                    <?php
                                        $no = 1;
                                        foreach ($data_cust['PROD_LIST'] as $key => $value) { 
                                            $status = '';
                                            if($value['STATUS'] == 'Active'){
                                                $status = '<span class="label label-success label-dot mr-2"></span><span class="font-weight-bold text-success">Active</span>';
                                            }else{
                                                $status = '<span class="label label-danger label-dot mr-2"></span><span class="font-weight-bold text-danger">Close</span>';
                                            }
                                            ?>
                                            <tr>
                                                <td><?=$no;?></td>
                                                <td><?=$value['INVOICEDESCRIPTION']?></td>
                                                <td class="text-right"><?="Rp " . number_format($value['AMOUNT'],2,',','.');?></td>
                                                <td><?=$status?></td>
                                            </tr>
                                            <?php 
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
        <div class="flex-row-fluid ml-lg-8 div_display_cust_info trans_info hide"> 
            <div class="row">
                <div class="col-lg-12"> 
                    <div class="card card-custom card-stretch gutter-b">  
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
                                        foreach ($data_cust['TRANS_LIST'] as $key => $value) {  
                                            foreach ($data_cust['INV_LIST'] as $keyInv => $valueInv) {   
                                                if($value['TRANSTYPE'] == '8'){
                                                    $valTransType = 'Customer';
                                                    if($value['INVOICE'] == $valueInv['INVOICEID']){
                                                        $descTrans = $valueInv['NAME'];
                                                    }
                                                }else if($value['TRANSTYPE'] == '15'){
                                                    $descTrans = $value['TXT'];
                                                    $valTransType = 'Payment';
                                                }else if($value['TRANSTYPE'] == '0'){
                                                    $descTrans = 'Saldo Awal';
                                                    $valTransType = '';
                                                }else{
                                                    $valTransType = '';
                                                } 
                                            } 
                                            $trans_date =  date_create($value['TRANSDATE']);
                                            $trans_date = (date_format($trans_date,"d M Y")); 
                                            echo '<tr>';
                                            echo '<td>'.$no.'</td>'; 
                                            echo '<td>'.$trans_date.'</td>'; 
                                            echo '<td>'.$descTrans.'</td>';  
                                            echo '<td style="text-align: right">Rp. '.number_format($value['AMOUNTCUR'],0,",",".").'</td>';
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
        <div class="flex-row-fluid ml-lg-8 div_display_cust_info billing_info hide"> 
            <div class="row">
                <div class="col-lg-12">  
                    <div class="card card-custom card-stretch gutter-b">  
                        <div class="card-header"> 
                            <div class="card-title">
                                <h3 class="card-label">Invoice
                                <span class="d-block text-muted pt-2 font-size-sm">Billing statement Indonet</span></h3>
                            </div>   
                            <div class="card-toolbar">  
                                <div class="btn-group">
                                    <button type="button" class="btn btn-primary font-weight-bolder">
                                        <i class="flaticon-calendar-3"></i> <span class="txt_month"><?=$month_year_name_now?></span>
                                    </button>
                                    <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                                    <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                        <ul class="nav nav-hover flex-column">
                                            <?php 
                                                foreach ($data_cust['INV_MONTH_TOTAL'] as $key => $value) { 
                                                    $y = substr($key, 0,-2);
                                                    $m = substr($key, -2);  
                                                    $inv_m =  date_create($y.'-'.$m); 
                                                    $inv_m = date_format($inv_m,"F Y"); 
                                                    echo    '<li class="nav-item">
                                                                <a href="#" class="nav-link" onclick="get_inv_page(\''.$m.'\',\''.$y.'\',\''.$inv_m.'\')">
                                                                    <i class="flaticon-calendar-3"></i> 
                                                                    <span class="ml-2">'.$inv_m.'</span> 
                                                                </a>
                                                            </li>';
                                                    
                                                }
                                                // echo    '<li class="nav-item">
                                                //             <a href="#" class="nav-link" onclick="get_inv_page(\'04\',\'2022\',\'Apr 2022\')">
                                                //                 <i class="flaticon-calendar-3"></i> 
                                                //                 <span class="ml-2">Apr 2022</span> 
                                                //             </a>
                                                //         </li>';

                                            ?> 
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0 inv_page_div">  

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</div>
<script src="<?=base_url()?>assets/themes/plugins/apexcharts/dist/apexcharts.min.js"></script>	
<script> 
    personal_info();
    function profile_overview(){
        $('.div_display_cust_info').addClass('hide');
        $('.profile_overview').removeClass('hide'); 
        var h = $(".profile_overview").height();
        $('.div_display').css('height', h);

        $('.btn_menu_cust_info').removeClass('active');
        $('.btn_profile_overview').addClass('active');
    }
    function personal_info(){
        $('.div_display_cust_info').addClass('hide');
        $('.personal_info').removeClass('hide');
        var h = $(".personal_info").height();  
        if(h < 800){
            h = 900+'px';
        }
        $('.div_display').css('height', h);

        $('.btn_menu_cust_info').removeClass('active');
        $('.btn_personal').addClass('active');
    }
    function product_info(){
        $('.div_display_cust_info').addClass('hide');
        $('.product_info').removeClass('hide');
        var h = $(".product_info").height();  
        if(h < 800){
            h = 900+'px';
        }
        $('.product_info').css('height', h);  
        $('.btn_menu_cust_info').removeClass('active');
        $('.btn_product').addClass('active'); 
    }
    function trans_info(){
        $('.div_display_cust_info').addClass('hide');
        $('.trans_info').removeClass('hide');
        var h = $(".trans_info").height();  
        if(h < 800){
            h = 900+'px';
        }
        $('.trans_info').css('height', h);

        $('.btn_menu_cust_info').removeClass('active');
        $('.btn_trans').addClass('active'); 
    }
    function billing_info(){
        $('.div_display_cust_info').addClass('hide');
        $('.billing_info').removeClass('hide');

        var inv_m = '<?=$inv_m?>';  
        get_inv_page('','',inv_m);
        $('.btn_menu_cust_info').removeClass('active');
        $('.btn_bill').addClass('active'); 
    }
	var inv_date_list = <?=$inv_date_list?>;
	var inv_bill_list = <?=$inv_bill_list?>; 
	var inv_bill_list = <?=$inv_bill_list?>; 
	var options = {
		chart: {
			type: 'bar',
            height: 300 
		},
        // colors: '#fff',
		series: [{
			name: 'Billing', 
			data: [inv_bill_list[0], inv_bill_list[1], inv_bill_list[2]]
		}],
		yaxis: {
			labels: {
				formatter: function (value) {
					return "Rp. "+Number((value).toFixed(1)).toLocaleString();
				} 

			},
		},
		xaxis: {
			categories: [inv_date_list[0],inv_date_list[1],inv_date_list[2]],
		},
		dataLabels: { 
			formatter: function (val, opt) {  
				return Number((val).toFixed(1)).toLocaleString();
			}
		}
	} 
	var chart = new ApexCharts(document.querySelector("#chart_billing"), options); 
	chart.render(); 

    var json_data_cust = <?=$json_data_cust?>;  
    var json_inv_month_details = <?=$json_inv_month_details?>;
    var json_inv_month_total = <?=$json_inv_month_total?>;
    var json_data_cust_bank = <?=$json_data_cust_bank?>; 
    
    function get_inv_page(month = '', year ='', m_name = ''){ 
        Swal.fire ({
            onBeforeOpen: () => { 
                Swal.showLoading ()
            }
        }); 
        $.ajax({
            type: "POST",
            url: base_url+"get_inv_view",
            data: { 
                'month':month, 'year':year, 'json_data_cust':json_data_cust, 'json_inv_month_total':json_inv_month_total, 
                'json_inv_month_details':json_inv_month_details, 'json_data_cust_bank':json_data_cust_bank
            },
            cache: false,
            dataType: "html",
            success: function (res) {  
                $('.txt_month').html(m_name);
                $('.inv_page_div').html(res); 
                var h = $(".billing_info").height(); 
                $('.div_display').css('height', h);
                Swal.close();
            }
        }); 
    }
</script>