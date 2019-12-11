<?php
date_default_timezone_set("Asia/Bangkok");
session_start();
require 'includes/config.inc.php';
require 'includes/connect.inc.php';
require 'includes/dateThai.inc.php';
$page = basename($_SERVER['PHP_SELF'], ".php");

$activity	= $con->query("SELECT `activity_id`, `activity_date`, `activity_name`, `activity_unit` FROM `activity` WHERE `activity_date` >= '" . date("Y-m-d") . "' ORDER BY `activity_date` ASC LIMIT 0, 10");

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<meta property="og:locale" content="th_TH"/>
	<meta property="og:title" content="ระบบบริหารข้อมูลกิจกรรมนักศึกษา"/>
	<meta property="og:url" content="https://tangtrakul.no-ip.org/activity/"/>
	<meta property="og:site_name" content="TANGTRAKUL.NO-IP.ORG"/>
	<meta property="og:image" content="https://tangtrakul.no-ip.org/activity/images/fb_cover.png"/>

	<title>ระบบบริหารข้อมูลกิจกรรมนักศึกษา | หน้าหลัก</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Load stylesheet -->
	<?php require_once('includes/stylesheet.inc.php'); ?>
	<style type="text/css">
		.center{
			text-align: center;
		}
	</style>
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
			<?php #require_once('includes/carousel.inc.php'); ?>

			<!-- Main content -->
			<section class="content container-fluid">

				<div class="col-md-1"></div>

				<div class="col-md-10">

					<div class="box box-danger">
						<div class="box-header">
							<h3 class="box-title">กิจกรรมเร็ว ๆ นี้</h3>
						</div>
						<!-- /.box-header -->
						<div class="box-body table-responsive no-padding">
							<table class="table table-hover">
								<tbody>
									<tr>
										<th class="center">วันที่</th>
										<th class="center">รหัสกิจกรรม</th>
										<th class="center">กิจกรรม</th>
										<th class="center">หน่วย</th>
									</tr>
									<?php
									while ($row	= $activity->fetch()) {
										echo "<tr>";
										echo "<td class='center'>" . thai_date_thaiyear(strtotime($row["activity_date"])) . "</td>";
										echo "<td>" . $row["activity_id"] . "</td>";
										echo "<td>" . $row["activity_name"] . "</td>";
										echo "<td class='center'>" . $row["activity_unit"] . "</td>";
										echo "</tr>";
									}
									?>
								</tbody>
							</table>
						</div>
						<!-- /.box-body -->
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

</body>
</html>