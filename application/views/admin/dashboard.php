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
										<?=$this->session->userdata('userID')?>
									<i class="flaticon2-correct text-success icon-md ml-2"></i></a> 
									<div class="d-flex flex-wrap my-2">
										<span href="#" class="text-muted font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-2"> 
											<i class="icon-1x text-dark-50 flaticon-users-1"></i>
										 	Admin Indonet
										</span>  
										<span href="#" class="text-muted font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-2"> 
											<i class="icon-1x text-dark-50 flaticon2-email"></i>
											support@indonet.co.id
										</span> 
										<span href="#" class="text-muted font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-2"> 
											<i class="icon-1x text-dark-50 flaticon2-phone"></i>
											021 73882525
										</span> 
										<span href="#" class="text-muted font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-2"> 
											<i class="icon-1x text-dark-50 flaticon2-location"></i>
											Rempoa Raya No. 11 Ciputat, Tangerang Selatan, Banten - Indonesia (15412)
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
								<i class="icon-2x icon-xl la  la-users"></i>
							</span>
							<div class="d-flex flex-column flex-lg-fill">
								<span class="text-dark-75 font-weight-bolder font-size-sm">Customer List</span>
								<a href="<?=base_url()?>customer_list" class="text-primary font-weight-bolder">View</a>
							</div>
						</div> 
						<div class="d-flex align-items-center flex-lg-fill mr-5 my-1">
							<span class="mr-4">
								<i class="icon-2x icon-xl la la-ticket-alt"></i>
							</span>
							<div class="d-flex flex-column">
								<span class="text-dark-75 font-weight-bolder font-size-sm">Ticketing</span>
								<a href="<?=base_url()?>ticketing" class="text-primary font-weight-bolder">View</a>
							</div>
						</div> 
						<div class="d-flex align-items-center flex-lg-fill mr-5 my-1">
							<span class="mr-4">
								<i class="icon-2x icon-xl la la-file-contract"></i>
							</span>
							<div class="d-flex flex-column">
								<span class="text-dark-75 font-weight-bolder font-size-sm">Reporting</span>
								<a href="<?=base_url()?>reporting" class="text-primary font-weight-bolder">View</a>
							</div>
						</div> 
					</div> 
				</div>
			</div> 
			<div class="row">
				<div class="col-lg-12 col-xl-8 col-md-8"> 
					<div class="card card-custom gutter-b"> 
						<div class="card-header border-0 py-5">
							<h3 class="card-title align-items-start flex-column">
								<span class="card-label font-weight-bolder text-dark">Subnet List</span>
								<span class="text-muted mt-3 font-weight-bold font-size-sm">All Subnets Indonet</span>
							</h3>  
						</div> 
						<div class="card-body pt-0 pb-3"> 
							<div class="">
								<!-- <table class="table table-head-custom table-head-bg table-borderless table-vertical-center" id="myTable"> -->
									
        						<table class="table table-separate table-head-custom" id="tabel_subnet">
									<thead>
										<tr class="text-uppercase"> 
											<th class="text-center">No</th>
											<th class="text-center">Subnet Code</th>
											<th class="text-center">Subnet Name</th>
											<th class="text-center">Total Customer</th>  
										</tr>
									</thead>
									<tbody>
										<?php
											$no = 1;
											foreach ($data_subnet_count as $key => $value) { 
										?>
												<tr>
													<td class="text-center"><?=$no;?></td>
													<td> <?=$value['subnet_code']?></a></td>
													<td> <?=$value['subnet_name']?></a></td>
													<td class="text-right"> <?=number_format($value['subnet_count'], 0, ',', '.')?></a></td>
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
				<div class="col-lg-12 col-xl-4 col-md-4"> 
					<div class="card card-custom card-stretch gutter-b"> 
					<?php 
						$month_now =  date('M Y');    
						$data_user_status_json = json_encode($data_user_status);  
					?>
						<div class="card-header h-auto border-0">
							<div class="card-title py-5">
								<h3 class="card-label">
									<span class="d-block text-dark font-weight-bolder">Customer Status</span>
									<span class="d-block text-muted mt-2 font-size-sm">Count Customer Status</span>
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
							<div class="pt-2" id="chart_billing"></div>
							<div class="row row-paddingless mt-5 mb-10"> 
								<div class="col">
									<div class="d-flex align-items-center mr-2"> 
										<div class="symbol symbol-45 symbol-light-success mr-4 flex-shrink-0">
											<div class="symbol-label">
												<i class="icon-2x la la-user-check text-success"></i>
											</div>
										</div> 
										<div>
											<div class="font-size-h4 text-dark-75 font-weight-bolder"><?=number_format($data_user_status[0]['status_count'], 0, ',', '.')?></div>
											<div class="font-size-sm text-muted font-weight-bold mt-1">Active</div>
										</div> 
									</div>
								</div> 
								<div class="col">
									<div class="d-flex align-items-center mr-2"> 
										<div class="symbol symbol-45 symbol-light-info mr-4 flex-shrink-0">
											<div class="symbol-label">
												<i class="icon-2x la la-user-minus"></i>
											</div>
										</div> 
										<div>
											<div class="font-size-h4 text-dark-75 font-weight-bolder"><?=number_format($data_user_status[1]['status_count'], 0, ',', '.')?></div>
											<div class="font-size-sm text-muted font-weight-bold mt-1">Hold</div>
										</div> 
									</div>
								</div> 
								<div class="col">
									<div class="d-flex align-items-center mr-2"> 
										<div class="symbol symbol-45 symbol-light-danger mr-4 flex-shrink-0">
											<div class="symbol-label">
												<i class="icon-2x la la-user-times text-danger"></i>
											</div>
										</div> 
										<div>
											<div class="font-size-h4 text-dark-75 font-weight-bolder"><?=number_format($data_user_status[2]['status_count'], 0, ',', '.')?></div>
											<div class="font-size-sm text-muted font-weight-bold mt-1">Close</div>
										</div> 
									</div>
								</div> 
							</div>  
						</div> 
					</div> 
				</div>
			</div>  
		</div> 
	</div> 
</div>		 
<script>     
	var table = $('#tabel_subnet'); 
	table.DataTable({
		responsive: true, 
		dom: `<'row'<'col-sm-12'tr>>
		<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`, 
		lengthMenu: [5, 10, 25, 50], 
		pageLength: 10, 
		language: {
			'lengthMenu': 'Display _MENU_',
		},  
	}); 
	var data_user_status = <?=$data_user_status_json?>;   
	var options = {
          series: [{
          name: 'Customer Count',
          data: [parseInt(data_user_status[0]['status_count']), parseInt(data_user_status[1]['status_count']), parseInt(data_user_status[2]['status_count'])],
        }],
		chart: {
			height: 370, 
			type: 'radar',
        }, 
        xaxis: {
          categories: [data_user_status[0]['status_name'], data_user_status[1]['status_name'], data_user_status[2]['status_name']]
        }
	};

	var chart = new ApexCharts(document.querySelector("#chart_billing"), options); 
	chart.render();
</script> 