<!DOCTYPE html> 
<html lang="en">
	<!--begin::Head-->
	<head> 
		<meta charset="utf-8" />
		<title>Sign In | admin-my.indonet.id</title>
		<meta name="description" content="Singin my indonet id" />
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" /> 
        <link rel="canonical" href="https://indonet.co.id/" />    
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />  
		<link href="<?=base_url()?>assets/themes/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" /> 
		<link href="<?=base_url()?>assets/themes/css/style.bundle.css" rel="stylesheet" type="text/css" />    
		<link href="<?=base_url()?>assets/themes/css/pages/login/login-2.css" rel="stylesheet" type="text/css" />   
		<link href="<?=base_url()?>assets/themes/me/css/custom.css" rel="stylesheet" type="text/css" />   
		<link rel="shortcut icon" href="<?=base_url()?>assets/themes/me/img/icon_my.png" />
	</head> 
	<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading"> 
		<div class="d-flex flex-column flex-root"> 
			<div class="login login-2 login-signin-on d-flex flex-column flex-lg-row flex-column-fluid bg-white" id="kt_login"> 
				<div class="login-aside order-2 order-lg-1 d-flex flex-row-auto position-relative overflow-hidden"> 
					<div class="d-flex flex-column-fluid flex-column justify-content-between py-9 px-7 py-lg-13 px-lg-35"> 
						<a href="#" class="text-center pt-2">
							<img src="<?=base_url()?>assets/themes/me/img/logo_my_2.png" class="" alt="" style="width: 300px" />
						</a> 
						<div class="d-flex flex-column-fluid flex-column flex-center"> 
							<div class="login-form login-signin py-11"> 
								<form class="form" novalidate="novalidate" id="login_form" action="#"> 
									<div class="text-center pb-8">
										<h2 class="font-weight-bolder text-dark font-size-h2 font-size-h1-lg">Sign In</h2> 
									</div>  
									<div class="form-group">
										<label class="font-size-h6 font-weight-bolder text-dark">Username</label>
										<input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg border-0" type="text" name="username" autocomplete="off" id="username"/>
										<div class="fv-plugins-message-container hide error_empty_msg"><div data-field="username" data-validator="notEmpty" class="fv-help-block">Username is required</div></div>
									</div> 
									<div class="form-group">
										<div class="d-flex justify-content-between mt-n5">
											<label class="font-size-h6 font-weight-bolder text-dark pt-5">Password</label>
										</div>
										<input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg border-0" type="password" name="password" autocomplete="off" id="password"/>
										<div class="fv-plugins-message-container hide error_empty_msg"><div data-field="password" data-validator="notEmpty" class="fv-help-block">Password is required</div></div>
									</div>  
									<div class="text-center pt-2">
										<button onclick="login()" type="button" class="btn btn-dark font-weight-bolder font-size-h6 px-8 py-4 my-3">Sign In</button>
									</div>
								</form> 
							</div>   
						</div> 
					</div> 
				</div>  
				<div class="content order-1 order-lg-2 d-flex flex-column w-100 pb-0 hide_mobile" style="background-color: #000;" >  
					<div class="content-img d-flex flex-row-fluid bgi-no-repeat bgi-position-y-bottom bgi-position-x-center" 	>
						<!-- style="background-image: url(<?=base_url()?>assets/themes/me/img/cs.png);"> -->
						<img src="<?=base_url()?>assets/themes/me/img/cs.png" style="height: 500px; margin: auto; ">
					</div> 
				</div>
			</div> 
		</div> 
		<script src="<?=base_url()?>assets/themes/plugins/jquery/jquery.min.js"></script> 
		<script src="<?=base_url()?>assets/themes/plugins/sweetalert2/dist/sweetalert2.min.js"></script> 
		<script type="text/javascript">
			var base_url = "<?=base_url()?>";
			__init();
			function __init(){
				if ($(window).width() < 960) {
					$('.hide_mobile').addClass('hide');
				} 
				$('#login_form input').keypress(function (a) {
					if (a.which == 13) { 
						login();
					}
				}); 
			}
			function create_account(){
				Swal.fire({
	                text: "to Create New Account, please contact our Support",
	                icon: "info",
	                buttonsStyling: false,
					confirmButtonText: "Ok",
					customClass: {
						confirmButton: "btn font-weight-bold btn-light-primary"
					}
	            }).then(function() {
					 
				});
			}
			function login(){   
				var username = $('#username').val();
				var password = $('#password').val();
				$('.error_empty_msg').addClass('hide');
				if(username != '' && password != ''){
					Swal.fire ({
						onBeforeOpen: () => { 
							Swal.showLoading ()
						}
					}); 
					$.ajax({
						type: "POST",
						url: base_url+"auth/checklogin",
						data: { 
							'username':username, 'password':password
						},
						cache: false,
						dataType: "json",
						success: function (res) { 
							if(res.result){
								var is_admin = res.is_admin;
								if(is_admin == 1){ 
									Swal.fire({
										title: 'Login Success',
										html: '',
										icon: 'success',
										timer: 2000, 
										buttons: false,
										showConfirmButton: false
									}).then((result) => {
										window.location.href = base_url+'redirect/';
									}) 
								}else{  
									Swal.fire({
										title: 'Login Failed',
										html: 'Customer Login? please re-login in my.indonet.id',
										icon: 'warning'
									}).then((result) => {
										window.location.href = 'https://my.indonet.id';
									})  
								}
							}else{
								Swal.fire(res.message,'','error').then((result) => { 
									// location.reload(); 
								});  
							}
						}
					}); 
				}else{	
					$('.error_empty_msg').removeClass('hide');
				}
			}
			function forgot_password(){
				Swal.fire({
	                text: "to Reset your Password, please contact our Support",
	                icon: "info",
	                buttonsStyling: false,
					confirmButtonText: "Ok",
					customClass: {
						confirmButton: "btn font-weight-bold btn-light-primary"
					}
	            }).then(function() {
					 
				});
			}
		</script> 
	</body>
	<!--end::Body-->
</html>
 