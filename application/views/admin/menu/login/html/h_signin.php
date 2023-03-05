<?php if ( ! defined( 'BASEPATH')) exit('No direct script access allowed'); ?>
<?php $this->load->view('admin/menu/login/function/f_signin');?>
<div class="login-box">
    <div class="login-logo">
        <a href="javascript:void(0);"><b>Admin</b>Dashboard</a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Login Untuk Masuk Ke Dashboard</p>
            <form id="sign_in" method="POST">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="username" id="txtUsername"
                        placeholder="Username or Email" required autofocus>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" id="txtPassword" name="password" placeholder="Password"
                        required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row mt-4" id="Capthca">
                    <div class="col-6">
                        <div class="text-left" id="notif">
                            <span >
                                <i class="material-icons text-green">notifications</i>
                                <label> Siapa anda..? </label>
                            </span></br>
                            <small>Bukan Robot kan..? masukan kode..</small>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-6">
                        <?php echo $captcha; ?>
                        <div class="input-group mt-2">
                            <input type="text" id="txtcaptcha" style="text-transform:uppercase" maxlength="6"
                                class="form-control" placeholder="Capthca" required>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                <span class="material-icons"><a href="<?php echo site_url('login')?>">loop</a></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <div class="row mt-4">
                    <div class="col-8">
                        <div class="icheck-primary">
                            <input type="checkbox" id="remember">
                            <label for="remember">
                                Remember Me
                            </label>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-4">
                        <button type="submit" id="btn_sigin" class="btn btn-primary btn-block">Sign In</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
            <div class="social-auth-links text-center mb-3">
                <p>- OR -</p>
            </div>
            <!-- /.social-auth-links -->
            <p class="mb-1">
                <a href="<?php echo site_url('login/forgot')?>">I forgot my password</a>
            </p>
            <p class="mb-0">
                <a href="<?php echo site_url('login/sigup')?>" class="text-center">Register a new membership</a>
            </p>
        </div>
        <!-- /.login-card-body -->
    </div>
</div>

