<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		
		<title>BackEnd | Dashboard</title>
		<!-- Favicon-->
		<link rel="shortcut icon" href="<?php echo base_url(); ?>asset/portal/img/fav.png">
		
		<!-- Tell the browser to be responsive to screen width -->
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- Font Awesome -->
		<link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/plugins/fontawesome-free/css/all.min.css">
		<!-- Ionicons -->
		<link href="<?php echo base_url(); ?>asset/admin/dist/css/ionicons.min.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/dist/css/icon.css">
		<!-- Tempusdominus Bbootstrap 4 -->
		<link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
		<!-- iCheck -->
		<link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
		<!-- JQVMap -->
		<link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/plugins/jqvmap/jqvmap.min.css">
		<!-- Theme style -->
		<link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/dist/css/adminlte.min.css">
		<!-- overlayScrollbars -->
		<link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
		<!-- eko-lightbox -->
		<link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/plugins/ekko-lightbox/ekko-lightbox.css">
		<link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css" >
		<!-- Daterange picker -->
		<link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/plugins/daterangepicker/daterangepicker.css">
		<!-- summernote -->
		<link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/plugins/summernote/summernote-bs4.css">
		<!-- DataTables -->
		<link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
		<link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
		<!-- SweetAlert2 -->
		<link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
		<!-- Toastr -->
		<link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/plugins/toastr/toastr.min.css">
		<!-- tools -->
		<link href="<?php echo base_url(); ?>asset/admin/plugins/dropify/css/dropify.min.css" rel="stylesheet"/>
		<link href="<?php echo base_url(); ?>asset/admin/plugins/dropzone/css/dropzone.css" rel="stylesheet">	
		<link href="<?php echo base_url(); ?>asset/admin/plugins/select2/css/select2.min.css" rel="stylesheet">	
		<!-- Pagination  -->
		<link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/plugins/pagination/pagination.css">
		<link rel="stylesheet" href="<?php echo base_url(); ?>asset/admin/plugins/star-rating/starrr.css">

		<!-- js -->
		<script src="<?php echo base_url('asset/admin')?>/plugins/jquery/jquery.js"></script>
			
		<!-- jQuery -->
		<script src="<?php echo base_url(); ?>asset/admin/plugins/jquery/jquery.min.js"></script>
		<!-- jQuery UI 1.11.4 -->
		<script src="<?php echo base_url(); ?>asset/admin/plugins/jquery-ui/jquery-ui.min.js"></script>
		<script src="<?php echo base_url(); ?>asset/admin/plugins/dropzone/js/dropzone.min.js"></script>
		<script src="<?php echo base_url(); ?>asset/admin/plugins/dropify/js/dropify.min.js"></script>
		<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
		
		<!-- End -->
	</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
			<?php echo $_navbar;?>
		<!-- #Top Bar -->
			<?php echo $_sidebar;?> 
		<div class="content-wrapper">
			<?php echo $_content;?>
		</div>
		<?php echo $_footer;?>
	</div>
	
	<script>
	$.widget.bridge('uibutton', $.ui.button)
	</script>
	<!-- Bootstrap 4 -->
	<script src="<?php echo base_url(); ?>asset/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="<?php echo base_url(); ?>asset/admin/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js"></script>
	<!-- ChartJS -->
	<script src="<?php echo base_url(); ?>asset/admin/plugins/chart.js/Chart.min.js"></script>
	<!-- Sparkline -->
	<script src="<?php echo base_url(); ?>asset/admin/plugins/sparklines/sparkline.js"></script>
	<!-- JQVMap -->
	<script src="<?php echo base_url(); ?>asset/admin/plugins/jqvmap/jquery.vmap.min.js"></script>
	<script src="<?php echo base_url(); ?>asset/admin/plugins/jqvmap/maps/jquery.vmap.usa.js"></script> 
	<!-- jQuery Knob Chart -->
	<script src="<?php echo base_url(); ?>asset/admin/plugins/jquery-knob/jquery.knob.min.js"></script>
	<!-- daterangepicker -->
	<script src="<?php echo base_url(); ?>asset/admin/plugins/moment/moment.min.js"></script>
	<script src="<?php echo base_url(); ?>asset/admin/plugins/daterangepicker/daterangepicker.js"></script>
	<!-- Tempusdominus Bootstrap 4 -->
	<script src="<?php echo base_url(); ?>asset/admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
	<!-- Summernote -->
	<script src="<?php echo base_url(); ?>asset/admin/plugins/summernote/summernote-bs4.min.js"></script>
	<!-- overlayScrollbars -->
	<script src="<?php echo base_url(); ?>asset/admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
	<!-- eko light-box -->
	<script src="<?php echo base_url(); ?>asset/admin/plugins/ekko-lightbox/ekko-lightbox.min.js"></script>
	<script src="<?php echo base_url(); ?>asset/admin/plugins/filterizr/jquery.filterizr.min.js"></script>
	<!-- SweetAlert2 -->
	<script src="<?php echo base_url(); ?>asset/admin/plugins/sweetalert2/sweetalert2.min.js"></script>
	<!-- Toastr -->
	<script src="<?php echo base_url(); ?>asset/admin/plugins/toastr/toastr.min.js"></script>
	<!-- J Main -->
	<script src="<?php echo base_url(); ?>asset/admin/dist/js/adminlte.js"></script>
	
	<!-- AdminLTE for demo purposes -->
	<script src="<?php echo base_url(); ?>asset/admin/dist/js/demo.js"></script>
	<!-- Jquery DataTable -->
	<script src="<?php echo base_url('asset/admin')?>/plugins/datatables/jquery.dataTables.min.js"></script>
	<script src="<?php echo base_url('asset/admin')?>/plugins/datatables/jquery.jeditable.js"></script>
	<script src="<?php echo base_url('asset/admin')?>/plugins/datatables/jquery.jeditable.min.js"></script>
	<script src="<?php echo base_url('asset/admin')?>/plugins/datatables/jquery.jeditable.datepicker.js"></script>
	<script src="<?php echo base_url('asset/admin')?>/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
	<script src="<?php echo base_url('asset/admin')?>/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
	<script src="<?php echo base_url('asset/admin')?>/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
	<script src="<?php echo base_url('asset/admin')?>/plugins/select2/js/select2.full.min.js"></script>
	<!-- Jquery Tools -->
	<script src="<?php echo base_url(); ?>asset/admin/plugins/jquery-base64/jquery.base64.min.js"></script>
	<script src="<?php echo base_url(); ?>asset/admin/plugins/jquery-base64/jquery.md5.js"></script>
	<script src="<?php echo base_url(); ?>asset/admin/plugins/jquery-validation/jquery.validate.js"></script>
	<script src="<?php echo base_url(); ?>asset/admin/plugins/globalize/globalize.js"></script>
	<script src="<?php echo base_url(); ?>asset/admin/plugins/pagination/pagination.js"></script>
	<script src="<?php echo base_url(); ?>asset/admin/plugins/pagination/pagination.min.js"></script>
	<script src="<?php echo base_url(); ?>asset/admin/plugins/ckeditor/ckeditor.js"></script>
	<script src="<?php echo base_url(); ?>asset/admin/plugins/star-rating/starrr.js"></script>
</body>
</html>

