<?php if ( ! defined( 'BASEPATH')) exit('No direct script access allowed'); ?>
<?php $this->load->view('portal/menu/login/function/f_login');?>
<!-- Start Banner Area -->
	<section class="banner-area organic-breadcrumb">
		<div class="container">
			<div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
				<div class="col-first">
					<h1>Login/Register</h1>
					<nav class="d-flex align-items-center">
						<a href="<?php echo site_url("home");?>">Home<span class="lnr lnr-arrow-right"></span></a>
						<a href="<?php echo site_url("home/page/");?>portal-menu-login-html-h_login">Login/Register</a>
					</nav>
				</div>
			</div>
		</div>
	</section>
	<!-- End Banner Area -->

	<!--================Login Box Area =================-->
	<section class="login_box_area section_gap">
		<div class="container">
			<div class="row log-area">
				<div class="col-lg-6">
					<div class="login_box_img">
						<img class="img-fluid" src="<?php echo base_url(); ?>asset/portal/img/login.jpg" alt="">
						<div class="hover">
							<h4>Silahkan Registrasi</h4>
							<p>Dengan anda bergabung, temukan kemudahan layanan jasa kami.</p>
							<div class="genric-btn medium primary-btn" id="btn-registrasi">Create an Account</div>
						</div>
					</div>
				</div>
				<div class="col-lg-6" id="frm-login">
					<div class="login_form_inner">
						<h3>Log in to enter</h3>
						<form class="row login_form" id="loginForm">
							<div class="col-md-12 form-group">
								<input type="text" class="form-control" id="txt_email"  placeholder="Username/email" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Username/Email'" required>
							</div>
							<div class="col-md-12 form-group">
								<input type="password" class="form-control" id="txt_password" maxlength="8" placeholder="Password" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Password'" required>
							</div>
							<div class="col-md-12 form-group">
								<div class="creat_account">
									<input type="checkbox" id="f-option2" name="selector">
									<label for="f-option2">Keep me logged in</label>
								</div>
							</div>
							<div class="col-md-12 form-group">
								<button type="submit" value="submit" class="primary-btn">Log In</button>
								<a href="#">Forgot Password?</a>
							</div>
						</form>
					</div>
				</div>
				<div class="col-lg-6" id="frm-register">
					<div class="login_form_inner">
						<h3>Buat Account Untuk Login</h3>
						<form class="row login_form" id="registrasiForm" >
							<div class="col-md-12 form-group">
								<input type="text" class="form-control" id="first_name"  placeholder="Nama Depan" maxlength="50" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Nama Depan'" required>
							</div>
							<div class="col-md-12 form-group">
								<input type="text" class="form-control" id="last_name"  placeholder="Nama Belakang" maxlength="50" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Nama Belakang'" required>
							</div>
							<div class="col-md-12 form-group">
								<input type="email" class="form-control" id="r_email"  placeholder="Email" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Email'" required>
							</div>
							<div class="col-md-12 form-group">
								<input type="password" class="form-control" id="r_password"  placeholder="Buat Password" maxlength="8" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Password'" required>
							</div>
							<div class="col-md-12 form-group">
								<button type="submit" class="primary-btn">Daftar</button>
								<button type="button" id="btn-bck-login" class="primary-btn mt-4">Back to form Login</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="col-lg-12 text-center"id="loading-login" style="display:none;">
				<div class="spinner-grow bg-cyan" style="width: 3rem; height: 3rem;" role="status">
					<span class="sr-only">Loading...</span>
				</div>
					<h1>Loading....</h1>
					<p>Mencoba Bergabung Dengan Kami..</p>
			</div>
		</div>
	</section>
	<!--================End Login Box Area =================-->