<?php
session_start();
date_default_timezone_set("Asia/Bangkok");
$page = basename($_SERVER['PHP_SELF'], ".php");
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>ระบบบริหารข้อมูลกิจกรรมนักศึกษา | หน้าหลัก</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Load stylesheet -->
	<?php require_once('includes/stylesheet.inc.php'); ?>
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

			<!-- Main content -->
			<section class="content" align="center">
				<p align="center"><img class="img-responsive" src="images/404.png" width="460"></p>
				<h3><i class="fa fa-warning text-yellow"></i>อุ๊ปส์ ไม่พบหน้า</h3>
				<p>เราไม่พบหน้าเว็บที่คุณต้องการ หรือคุณอาจจะไม่ได้รับอนุญาตให้เข้าใช้งาน</p>
				<p>กลับไปที่ <a href="index.php">หน้าหลัก</a></p>
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

</body>
</html>