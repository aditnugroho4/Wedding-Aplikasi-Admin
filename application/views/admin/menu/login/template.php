<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin Dashboard | Log in</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url('asset/admin')?>/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="<?php echo base_url('asset/admin')?>/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url('asset/admin')?>/dist/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

	<script src="<?php echo base_url('asset/admin')?>/plugins/jquery/jquery.js"></script>
    </head>
    <body class="hold-transition login-page">
        <!-- ini tampilan Login -->
        <?php echo $_signin;?>		
    <!-- jQuery -->
    <script src="<?php echo base_url('asset/admin')?>/plugins/jquery/jquery.min.js"></script>    
    <!-- Bootstrap 4 -->
    <script src="<?php echo base_url('asset/admin')?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo base_url('asset/admin')?>/dist/js/adminlte.min.js"></script>
    <!-- jQuery Tools -->
    <script src="<?php echo base_url('asset/admin')?>/plugins/jquery-base64/jquery.base64.min.js"></script>
    <script src="<?php echo base_url(); ?>asset/admin/plugins/jquery-validation/jquery.validate.js"></script>
    </body>
</html>

