<div class="content d-flex flex-column flex-column-fluid" id="kt_content"> 
	<div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
		<div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap"> 
			<div class="d-flex align-items-center flex-wrap mr-2">  
				<h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">Dashboard</h5>   
			</div> 
		</div>
	</div> 
	<div class="d-flex flex-column-fluid"> 
		<div class="container-fluid"> 
			<div class="card card-custom gutter-b">
				<div class="card-body">
					<div class="d-flex">  
						<div class="flex-grow-1"> 
							<div class="d-flex align-items-center justify-content-between flex-wrap">
								<div class="mr-3"> 
									<a href="#" class="d-flex align-items-center text-dark text-hover-primary font-size-h5 font-weight-bold mr-3">
										<?=$data_cust[0]->NAME?>
									<i class="flaticon2-correct text-success icon-md ml-2"></i></a> 
									<div class="d-flex flex-wrap my-2">
										<span href="#" class="text-muted font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-2"> 
											<i class="icon-1x text-dark-50 flaticon-users-1"></i>
										 	<?=$data_cust[0]->KNOWNAS?>
										</span> 
										<span href="#" class="text-muted font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-2"> 
											<i class="icon-1x text-dark-50 flaticon-users"></i>
										 	<?=$data_cust[0]->ACCOUNTNUM?>
										</span> 
										<span href="#" class="text-muted font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-2"> 
											<i class="icon-1x text-dark-50 flaticon2-email"></i>
										 	<?=$data_cust[0]->EMAIL?>
										</span> 
										<span href="#" class="text-muted font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-2"> 
											<i class="icon-1x text-dark-50 flaticon2-phone"></i>
										 	<?=$data_cust[0]->PHONE?>
										</span> 
										<span href="#" class="text-muted font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-2"> 
											<i class="icon-1x text-dark-50 flaticon2-location"></i>
										 	<?=$data_cust[0]->DISTRICTNAME?>
										</span> 
									</div> 
								</div> 
							</div>  
						</div> 
					</div>
					<div class="separator separator-solid my-7"></div> 
					<div class="d-flex align-items-center flex-wrap">  
						<div class="d-flex align-items-center flex-lg-fill mr-5 my-1">
							<span class="mr-4">
								<i class="icon-2x icon-xl la la-money-bill-wave"></i>
							</span>
							<?php 
								if(isset($balance[0]->BALANCEMST)){
									$last_balance = (int)$balance[0]->BALANCEMST;
								}else{
									$last_balance = 0;
								}
							?>
							<div class="d-flex flex-column text-dark-75">
								<span class="font-weight-bolder font-size-sm">Balance</span>
								<span class="font-weight-bolder font-size-h5"> 
								<span class="text-dark-50 font-weight-bold">Rp. </span><?=number_format($last_balance, 0, ',', '.');?></span>
							</div>
						</div>  
						<div class="d-flex align-items-center flex-lg-fill mr-5 my-1">
							<span class="mr-4">
								<i class="icon-2x icon-xl la  la-clipboard-list"></i>
							</span>
							<div class="d-flex flex-column flex-lg-fill">
								<span class="text-dark-75 font-weight-bolder font-size-sm">Products</span>
								<a href="<?=base_url()?>product_info" class="text-primary font-weight-bolder">View</a>
							</div>
						</div> 
						<div class="d-flex align-items-center flex-lg-fill mr-5 my-1">
							<span class="mr-4">
								<i class="icon-2x icon-xl la la-exchange-alt"></i>
							</span>
							<div class="d-flex flex-column">
								<span class="text-dark-75 font-weight-bolder font-size-sm">Transactions</span>
								<a href="<?=base_url()?>transaction_info" class="text-primary font-weight-bolder">View</a>
							</div>
						</div> 
					</div> 
				</div>
			</div> 
			<div class="row">
				<div class="col-xl-8"> 
					<div class="card card-custom gutter-b"> 
						<div class="card-header border-0 py-5">
							<h3 class="card-title align-items-start flex-column">
								<span class="card-label font-weight-bolder text-dark">Products</span>
								<span class="text-muted mt-3 font-weight-bold font-size-sm">All your products Indonet</span>
							</h3> 
						</div> 
						<div class="card-body pt-0 pb-3"> 
							<div class="table-responsive">
								<table class="table table-head-custom table-head-bg table-borderless table-vertical-center">
									<thead>
										<tr class="text-uppercase"> 
											<th class="text-center">No</th>
											<th class="text-center">Products</th>
											<th class="text-center" colspan="2">Total</th> 
											<th class="text-center">Status</th>  
										</tr>
									</thead>
									<tbody>
										<?php
											$no = 1;
											foreach ($prod_list as $key => $value) {
												$status = '';
												if($value->STATUS == 'Active'){
													$status = '<span class="label label-success label-dot mr-2"></span><span class="font-weight-bold text-success">Active</span>';
												}else{
													$status = '<span class="label label-danger label-dot mr-2"></span><span class="font-weight-bold text-danger">Close</span>';
												} 
										?>
												<tr>
													<td class="text-center"><?=$no;?></td>
													<td> <?=$value->INVOICEDESCRIPTION?></a></td>
													<td >Rp.</td>
													<td class="text-right width-80"><?=number_format($value->AMOUNT, 0, ',', '.');?></td>
													<td class="text-center"><?=$status?></td> 
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
					<div class="card card-custom gutter-b"> 
						<div class="card-header border-0 py-5">
							<h3 class="card-title align-items-start flex-column">
								<span class="card-label font-weight-bolder text-dark">Transactions</span>
								<span class="text-muted mt-3 font-weight-bold font-size-sm">All your transactions Indonet</span>
							</h3> 
						</div> 
						<div class="card-body pt-0 pb-3"> 
							<div class="table-responsive">
								<table class="table table-head-custom table-head-bg table-borderless table-vertical-center">
									<thead>
										<tr class="text-uppercase"> 
											<th class="text-center">No</th>
											<th class="text-center">Date</th> 
											<th class="text-center">Description</th>
											<th class="text-center" colspan="2">Total</th> 
										</tr>
									</thead>
									<tbody>
										<?php
											$no = 1; 
                                    		$trans_list = array_slice($trans_list, 0, 5); 
											foreach ($trans_list as $key => $value) { 
												$dateTrans =  date_create($value->TRANSDATE);
												$dateTransMY = (date_format($dateTrans,"Y-m")); 
												$dateLimit = date('Y-m', strtotime(date('Y-m')." -13 month"));
												$valTransType = '';        
												$descTrans = '';
												
												if ($dateTransMY === $dateLimit) { 
													break;
												}
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
										?> 
												<tr>
													<td class="text-center"><?=$no;?></td>
													<td><?=date_format($dateTrans,"d F Y")?></td> 
													<td><?=$descTrans?></a></td> 
													<td>Rp.</td>
													<td class="text-right width-80"><?=number_format($value->AMOUNTCUR, 0, ',', '.');?></td> 
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
				<div class="col-lg-4"> 
					<div class="card card-custom card-stretch gutter-b"> 
					<?php 
						$month_now =  date('M Y');   
						$inv_date_list = array(); 
						$inv_bill_list = array();  
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
					?>
						<div class="card-header h-auto border-0">
							<div class="card-title py-5">
								<h3 class="card-label">
									<span class="d-block text-dark font-weight-bolder">Recent Billing</span>
									<span class="d-block text-muted mt-2 font-size-sm">Billing statement</span>
								</h3>
							</div>
							<div class="card-toolbar">
								<ul class="nav nav-pills nav-pills-sm nav-dark-75" role="tablist">
									<li class="nav-item ">
										<a class="nav-link py-2 px-4 active" data-toggle="tab" href="#kt_charts_widget_2_chart_tab_1">
											<span class="nav-text font-size-sm"><?=$month_now?></span>
										</a>
									</li> 
								</ul>
							</div>
						</div> 
						<div class="card-body"> 
							<p class="text-center font-weight-bolder" style="font-size: 20px;">Rp. <?=number_format($last_balance, 0, ',', '.');?></p>
							<?php 
								$payment_min = 0;
								foreach ($other_data as $key => $value) {
									if($value['code'] == 'payment_min'){
										$payment_min = json_decode($value['data']);
										$payment_min = $payment_min->data;
										break;
									}
								} 
								if($last_balance > 0 && $last_balance >= $payment_min){ ?>
									<div class="pb-5 pay_now_div text-center">
										<p class="font-weight-normal font-size-lg pb-5">Pay Your Bill Online
										<br>With Creditcard, Bank Transfer or Scan QR (QRIS)</p>
										<a href="#" onclick="pay_now()" class="btn btn-danger btn-shadow-hover font-weight-bolder w-100">
											<span style="font-size: 14px;"> PAY NOW </span>
										</a>
									</div>
									<script>
										window.addEventListener('load', function () {
											check_payment();
										})
									</script>
							<?php } ?>
							<div class="pt-2" id="chart_billing"></div>
						</div> 
					</div> 
				</div>
			</div>  
		</div> 
	</div> 
</div>		

<div id="div1"></div>
<a id="btn_modal_pay" data-toggle="modal" class="hide" href="#modalpaynow">open modal</a> 
<div id="modalpaynow" class="modal fade"  tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content"> 
            <div class="modal-body">    
                <div class="text-center mb-10 mt-5">
                    <h4>Select Payment Method</h4>  
                    <div class="loading_modal hide" style="z-index: 9999; text-align: center; width: 90%; position: absolute;">
                        <img style="margin: 0 auto; margin-top: 20%; width: 200px" src="/assets/themes/me/img/loading.gif">
                    </div>
					<hr>
					<div class="mb-10 mt-10">
						<a href="#" class="btn btn-light-primary font-weight-bolder mr-2 type_pay type_1" onclick="set_payment_method(1)">
							<i class="fas fa-credit-card mr-2"></i>Credit card <span class="label label-success ml-2 hide label_pay label_pay_1">✔</span>
						</a>
						<a href="#" class="btn btn-light-primary font-weight-bolder type_pay type_2" onclick="set_payment_method(2)">
							<i class="far fa-building mr-2"></i>Bank transfer <span class="label label-success ml-2 hide label_pay label_pay_2">✔</span>
						</a>
						<br>
						<a href="#" class="btn btn-secondary font-weight-bolder mt-5" style="cursor: no-drop;">
							<i class="fas fa-qrcode"></i>QRIS <span class="label label-success ml-2 hide">✔</span>
						</a>
					</div> 
                </div>
                <br>
                <div class="card"> 
                    <table class="table table-hover"> 
                        <div class="hide">  
                            <input id="tagihan" value="<?=$last_balance?>">
                            <input id="biaya_layanan" value="0">
                            <input id="total_tagihan" value="0">
                            <input id="pay_method" value="0"> 
                            <input id="pay_month" value="<?=$date_now?>"> 
                            <input id="pay_year" value="<?=$year_now?>"> 
                            <input id="cust_id" value="<?=$cust_id?>">  
                        </div>
                        <tbody>                                         
                            <tr> 
                                <td class="text-left" style="width: 300px;">Payment Method</td>
                                <td class="text-right"><span class="pay_type">-</span> </td> 
                            </tr>                                       
                            <tr> 
                                <td class="text-left">Total Bill</td>
                                <td class="text-right"><span class="tagihan_view">Rp. 0,-</span> </td> 
                            </tr>                                   
                            <tr> 
                                <td class="text-left">Admin Fee</td>
                                <td class="text-right"><span class="biaya_layanan">Rp. 0,-</span> </td> 
                            </tr>                                  
                            <tr> 
                                <td class="text-left">Pay Total</td> 
                                <td class="text-right"><span class="total_tagihan">Rp. 0,-</span> </td> 
                            </tr>
                        </tbody>
                    </table> 
                </div>  
                <hr>
                <div class="text-center">
                    <button class="btn btn-success mr-2 btn_pay_now hide font-weight-bolder" onclick="confirm_pay_now()"><i class=" flaticon2-check-mark"></i>Confirm</button>
                    </div>
            </div>
        </div>
    </div>
</div>
<script src="<?=base_url()?>assets/themes/plugins/apexcharts/dist/apexcharts.min.js"></script>			
<script>   
	var last_balance = "<?=$last_balance?>";  
	$('.tagihan_view').html('Rp. '+formatNumber(last_balance)+',-');
	function pay_now(){
		$('#btn_modal_pay').click();
	}
	function confirm_pay_now(){
		$('.loading_modal').removeClass('hide');
        $('.btn_pay_now').addClass('hide'); 
        var tagihan = $('#tagihan').val(); 
        var biaya_layanan = $('#biaya_layanan').val();
        var total_tagihan = $('#total_tagihan').val();
        var pay_method = $('#pay_method').val();
        var pay_month = $('#pay_month').val();
        var pay_year = $('#pay_year').val();
        var cust_id = $('#cust_id').val();
        $.ajax({
            type: "POST",
            url: "<?=base_url()?>create_inv_blesta",
            data: {'cust_id':cust_id, 'month':pay_month, 'year':pay_year, 'tagihan':tagihan, 'biaya_layanan':biaya_layanan, 'total_tagihan':total_tagihan, 'pay_method':pay_method},
            cache: false,
            dataType: "html",
            success: function(res){  
                $('#div1').html(res);   
                setTimeout(function(){ 
                    $('.loading_modal').addClass('hide'); 
                    $('.btn_pay_now').removeClass('hide');
                }, 5000);
            }
        });
	}
	function set_payment_method(type){
		$('.type_pay').addClass('btn-light-primary');
		$('.type_pay').removeClass('btn-primary');
		$('.label_pay').addClass('hide');
		$('.btn_pay_now').addClass('hide');
		$('.pay_type').html('');
		if(type == 1){
			$('.type_1').addClass('btn-primary');
			$('.type_1').removeClass('btn-light-primary'); 
			$('.label_pay_1').removeClass('hide');
			$('.pay_type').html('Credit Card'); 
			$('.btn_pay_now').removeClass('hide');  

            var biaya_layanan = parseInt(last_balance)*0.029+2000;
            biaya_layanan = Math.ceil(biaya_layanan);
            $('.biaya_layanan').html('Rp. '+formatNumber(biaya_layanan)+',-');
            $('#biaya_layanan').val(biaya_layanan);

            var total_tagihan = parseInt(last_balance)+parseInt(biaya_layanan);    
            $('.total_tagihan').html('Rp. '+formatNumber(total_tagihan)+',-');
            $('#total_tagihan').val(total_tagihan);

            $('#pay_method').val(1);  
		}else if(type == 2){
			$('.type_2').addClass('btn-primary');
			$('.type_2').removeClass('btn-light-primary'); 
			$('.label_pay_2').removeClass('hide');
			$('.pay_type').html('Bank Transfer');
			$('.btn_pay_now').removeClass('hide'); 

            var biaya_layanan = 4400;
            $('.biaya_layanan').html('Rp. '+formatNumber(biaya_layanan)+',-');
            $('#biaya_layanan').val(biaya_layanan);

            var total_tagihan = parseInt(last_balance)+parseInt(biaya_layanan);    
            $('.total_tagihan').html('Rp. '+formatNumber(total_tagihan)+',-');
            $('#total_tagihan').val(total_tagihan);

            $('#pay_method').val(2); 
		}
	}

	function check_payment(){
		var URL = window.location.href; 
        var arr_url = URL.split('/');  
        var type_data = arr_url[5]; //"order_check"
        var code_data = arr_url[6];  
        if(type_data != undefined && code_data != undefined){  
            if(code_data != 0){ 
                if(type_data == 'order_check'){
                    var data_mid = arr_url[7];    
                    $('.loading_full').removeClass('hide');
                    $.ajax({
                        type: "POST",
                        url: base_url+"api/check_payment_blesta",
                        data: { 
                            'code_data':code_data, 'data_mid':data_mid
                        },
                        cache: false,
                        dataType: "json",
                        success: function (result) {   
                            if(result.res){  
                                $('.loading_full').addClass('hide');
                                if(result.type == 1){
                                    Swal.fire('Invoice Paid','','success').then((result) => { 
                                        window.location.href = base_url+'customer/account/';
                                    });  
                                }else if(result.type == 2){
                                    Swal.fire('','Please complete your payment, for detail check your mail.','success').then((result) => { 
                                        window.location.href = base_url+'customer/account/';
                                    });  
                                }
                            }else{
                                toast_msg('error', 'Error', result.msg);
                            }
                        }
                    });
                }  
            } 
        }else{    
            $.ajax({
                type: "POST",
                url: base_url+"check_payment_inv",
                data: {  

                },
                cache: false,
                dataType: "json",
                success: function (res) {     
                    if(res.result){
						if(res.status == 2){ 
                            $('.pay_now_div').html('Awaiting Payment, check your mail.');
                        }else if(res.status == 3){ 
                            $('.pay_now_div').html('Payment by '+res.pay_method); 
                        }
                    }
                }
            });
        }   
	} 
    function formatNumber(nStr){
        nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + '.' + '$2'); // changed comma to dot here
        }
        return x1 + x2;
    }

	var inv_date_list = <?=$inv_date_list?>;
	var inv_bill_list = <?=$inv_bill_list?>; 
	var options = {
		chart: {
			type: 'area'
		},
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
			categories: [inv_date_list[0],inv_date_list[1],inv_date_list[2]]
		},
		dataLabels: { 
			formatter: function (val, opt) {  
				return Number((val).toFixed(1)).toLocaleString();
			}
		}
	} 
	var chart = new ApexCharts(document.querySelector("#chart_billing"), options); 
	chart.render();
</script> 