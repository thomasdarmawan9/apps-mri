<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<meta charset="utf-8" />
<title><?php echo $this->session->userdata('menu_active'); ?> - MRI</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta content="" name="description" />
<meta content="" name="author" />
	<link rel="shortcut icon" type="image/x-icon" href="<?= base_url('inc/image/logo.png')?>" />

	<!--CSS-->
    <link rel="stylesheet" href="<?= base_url(); ?>inc/fontawesome5/web-fonts-with-css/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
   
    <link rel="stylesheet" href="<?= base_url(); ?>inc/mdb/css/mdb.min.css">
	<link rel="stylesheet" href="<?= base_url(); ?>inc/mdb/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>inc/sidebar/style2.css">
	<link rel="stylesheet" href="<?= base_url(); ?>inc/jquery.mCustomScrollbar.min.css">
    <!--<link rel="stylesheet" href="<?= base_url(); ?>inc/bootstrap3/css/bootstrap.min.css">-->
	<link rel="stylesheet" href="<?= base_url(); ?>inc/sweetalert-master/dist/sweetalert.css">
	<link rel="stylesheet" href="<?= base_url(); ?>inc/datatables/datatables.min.css"/>
	
	<link rel="stylesheet" href="<?= base_url(); ?>inc/datatables/RowReorder-1.2.4/css/rowReorder.dataTables.min.css"/>
    <link rel="stylesheet" href="<?= base_url(); ?>inc/datatables/Responsive-2.2.2/css/responsive.dataTables.min.css"/>
	
	<!--JS-->
	<script type="text/javascript" src="<?= base_url();?>inc/jquery/jquery.min.js"></script>
	<script type="text/javascript" src="<?= base_url();?>inc/angular/angular.min.js"></script>
	<script type="text/javascript" src="<?= base_url();?>inc/sweetalert-master/dist/sweetalert.min.js"></script>
	<script type="text/javascript" src="<?= base_url();?>inc/datatables/datatables.min.js"></script>
	
	<script type="text/javascript" src="<?= base_url('inc/datatables/RowReorder-1.2.4/js/dataTables.rowReorder.min.js'); ?>"></script>
	<script type="text/javascript" src="<?= base_url('inc/datatables/Responsive-2.2.2/js/dataTables.responsive.min.js'); ?>"></script>



	
<style>
	.wrapper {display: flex;}
	#sidebar {min-width: 250px;max-width: 250px;height: 90vh;}
	table th, table td {font-size: 1em;}
	#wait{
		position: fixed;
		background-color: #ded9d978;
		top:0;
		left: 0;
		width: 100%;
		height: 100%;
		padding-top: 45vh;
		text-align: center;
		z-index: 1031;
	}
	
	.viewMobile, .card{min-width:300px;}
	h3{position:relative;}

	
</style>

</head>
<body>
<div class="wrapper">

	<div id="wait" style="display: none;">
		<img src="<?= base_url('inc/loading.gif')?>" width="30px"> <span style="color:#333;font-weight: 400;">Loading...</span>
	</div>