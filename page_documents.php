<?php
session_start();
require 'includes/config.inc.php';

$page     = basename($_SERVER['PHP_SELF'], ".php");
$pageName = "เอกสารที่เกี่ยวข้อง";
$pageDescription = "";
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo(_TITLE); ?> | <?php echo($pageName); ?></title>
	<!-- Load stylesheet -->
	<?php require_once('includes/stylesheet.inc.php'); ?>

	<!-- bootstrap datepicker -->
	<link rel="stylesheet" href="bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
	
</head>
<body class="hold-transition skin-red sidebar-mini">
	<div class="wrapper">

		<!-- Main Header -->
		<header class="main-header">

			<!-- Logo -->
			<?php require_once('includes/logo.inc.php'); ?>

			<!-- Header Navbar -->
			<nav class="navbar navbar-static-top" role="navigation">
				<!-- Sidebar toggle button-->
				<a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
					<i class="fas fa-bars"></i>
					<span class="sr-only">Toggle navigation</span>
				</a>
				<!-- Navbar Right Menu -->
				<?php require_once('includes/rightMenu.inc.php'); ?>
				<!-- END Navbar Right Menu -->
			</nav>
		</header>
		<!-- Left side column. contains the logo and sidebar -->
		<?php require_once('includes/sidebar.inc.php'); ?>

		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<section class="content-header">
				<h1>
					<?php echo($pageName); ?>
					<small><?php echo($pageDescription); ?></small>
				</h1>
				<ol class="breadcrumb">
					<li><a href="<?php echo(_MAIN); ?>"><i class="fas fa-tachometer-alt"></i> เมนูหลัก</a></li>
					<li class="active"><?php echo($pageName); ?></li>
				</ol>
			</section>

			<!-- Main content -->
			<section class="content container-fluid">

				<div class="row">
					<!-- left column -->
					<div class="col-md-10 col-md-offset-1">

						<!-- general form elements disabled -->
						<div class="box">
							<div class="box-header">
								<h3 class="box-title">ประกาศ/ข้อบังคับ</h3>
							</div>
							<!-- /.box-header -->
							<div class="box-body no-padding">
								<table class="table">
									<tbody><tr>
										<th style="width: 10px">ที่</th>
										<th>รายการ</th>
									</tr>
									<tr>
										<td>1.</td>
										<td><a href="documents/ประกาศ มทร.อีสาน เรื่อง การเข้าร่วมกิจกรรมพัฒนานักศึกษาของนักศึกษา.pdf" target="_blank">ประกาศ มทร.อีสาน เรื่อง การเข้าร่วมกิจกรรมพัฒนานักศึกษาของนักศึกษาฯ</a></td>
									</tr>
									<tr>
										<td>2.</td>
										<td><a href="documents/ข้อบังคับ มทร.อีสาน ว่าด้วยการศึกษาระดับประกาศนียบัตรวิชาชีพชั้นสูง (ฉบับที่ 2) พ.ศ.2553.pdf" target="_blank">ข้อบังคับ มทร.อีสาน ว่าด้วยการศึกษาระดับประกาศนียบัตรวิชาชีพชั้นสูง (ฉบับที่ 2) พ.ศ.2553</a></td>
									</tr>
									<tr>
										<td>3.</td>
										<td><a href="documents/ข้อบังคับ มทร.อีสาน ว่าด้วยการศึกษาระดับปริญญาตรี (ฉบับที่ 2) พ.ศ.2553.pdf" target="_blank">ข้อบังคับ มทร.อีสาน ว่าด้วยการศึกษาระดับปริญญาตรี (ฉบับที่ 2) พ.ศ.2553</a></td>
									</tr>
								</tbody></table>
							</div>
							<!-- /.box-body -->
						</div>

						<!-- general form elements disabled -->
						<div class="box">
							<div class="box-header">
								<h3 class="box-title">แบบฟอร์ม</h3>
							</div>
							<!-- /.box-header -->
							<div class="box-body no-padding">
								<table class="table">
									<tbody><tr>
										<th style="width: 10px">ที่</th>
										<th>รายการ</th>
									</tr>
									<tr>
										<td>1.</td>
										<td><a href="documents/ใบคำร้องขออนุมัติหน่วยกิจกรรม.pdf" target="_blank">ใบคำร้องขออนุมัติหน่วยกิจกรรม</a></td>
									</tr>
									<tr>
										<td>2.</td>
										<td><a href="documents/ใบคำร้องขอเอกสารผ่านการเข้าร่วมกิจกรรมพัฒนานักศึกษา.pdf" target="_blank">ใบคำร้องขอเอกสารผ่านการเข้าร่วมกิจกรรมพัฒนานักศึกษา</a></td>
									</tr>
								</tbody></table>
							</div>
							<!-- /.box-body -->
						</div>

					</div>
				</div>

			</section>
			<!-- /.content -->
		</div>
		<!-- /.content-wrapper -->

		<!-- Main Footer -->
		<?php require_once('includes/footer.inc.php'); ?>

	</div>
	<!-- ./wrapper -->

	<!-- REQUIRED JS SCRIPTS -->
	<?php require_once('includes/JavaScript.inc.php'); ?>
	<!-- bootstrap datepicker -->
	<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
	<script src="bower_components/bootstrap-datepicker/dist/locales/bootstrap-datepicker.th.min.js"></script>

	<!-- Page script -->
	<script>
		$(function () {
    	//Date picker
    	$('#datepicker').datepicker({
    		autoclose: true,
    		format: 'dd/mm/yyyy',
    		language: 'th'
    	})
    })
</script>
</body>
</html>