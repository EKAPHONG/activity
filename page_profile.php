<?php
session_start();
require 'includes/config.inc.php';
require 'includes/connect.inc.php';
require 'includes/dateThai.inc.php';

$page     = basename($_SERVER['PHP_SELF'], ".php");
$pageName = "ข้อมูลส่วนตัว";
$pageDescription = "";

$profile	= $con->query("SELECT * FROM `account` WHERE account_username = '" . $_SESSION['account_username'] . "'");
$row_profile		= $profile->fetch();

$level		= $con->query("SELECT * FROM `level`");
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
			</section>

			<!-- Main content -->
			<section class="content container-fluid">

				<?php
				if ($_GET["alerts"] == "warning" && $_GET["msg"] == "incomplete") {
					?>
					<div class="alert alert-warning alert-dismissible">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<h4><i class="fas fa-exclamation-triangle"></i> คำเตือน!</h4>
						กรุณายืนยันข้อมูลก่อนเข้าใช้งาน
					</div>
					<?php
				}
				?>

				<?php
				if ($_GET["alerts"] == "success" && $_GET["msg"] == "complete") {
					?>
					<div class="alert alert-success alert-dismissible">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<h4><i class="fas fa-check"></i> สำเร็จ!</h4>
						บันทึกข้อมูลเรียบร้อยแล้ว
					</div>
					<?php
				}
				?>

				<div class="row">
					<!-- left column -->
					<div class="col-md-6">
						<!-- <div class="col-md-10 col-md-offset-1"> -->

							<!-- general form elements disabled -->
							<form action="page_profile_confirm.php" method="POST" role="form">
								<div class="box box-warning">
									<div class="box-header with-border">
										<h3 class="box-title">ข้อมูลประวัติส่วนตัว</h3>
									</div>
									<!-- /.box-header -->
									<div class="box-body">
										<!-- information -->
										<div class="form-group">
											<label>ชื่อ - สกุล</label>
											<input type="text" class="form-control" value="<?php echo $row_profile["account_prefix"] . $row_profile["account_firstname"] . " " . $row_profile["account_lastname"]; ?>" readonly="">
										</div>
										<div class="form-group">
											<label>รหัสนักศึกษา</label>
											<input type="text" class="form-control" value="<?php echo($row_profile["account_id"]); ?>" readonly="">
										</div>
										<div class="form-group">
											<label>ระดับการศึกษา</label>
											<select class="form-control" name="level_id" <?php echo ($row_profile["level_id"] ? 'readonly="" disabled=""' : 'style="color: #000;background-color: #ffff99"'); ?> required="">
												<option value="">กรุณาเลือก</option>
												<?php
												while ($row_level = $level->fetch()) {
													echo "<option value='" . $row_level["level_id"] . "' " . ($row_profile["level_id"] == $row_level["level_id"] ? 'selected=""':'') . ">" . $row_level["level_name"] . "</option>";
												}
												?>
											</select>
										</div>
										<div class="form-group">
											<label>คณะ</label>
											<input type="text" class="form-control" value="<?php echo($row_profile["account_faculty"]); ?>" readonly="">
										</div>
										<div class="form-group">
											<label>สาขาวิชา</label>
											<input type="text" class="form-control" value="<?php echo($row_profile["account_department"]); ?>" readonly="">
										</div>
										<div class="form-group">
											<label>คุณวุฒิการศึกษา</label>
											<input type="text" class="form-control" value="<?php echo($row_profile["account_degree"]); ?>" readonly="">
										</div>
									</div>
									<!-- /.box-body -->
								</div>
							</div>

							<div class="col-md-6">
								<!-- general form elements disabled -->
								<div class="box box-primary">
									<div class="box-header with-border">
										<h3 class="box-title">ข้อมูลติดต่อ</h3>
									</div>
									<!-- /.box-header -->
									<div class="box-body">
										<!-- Date -->
										<div class="form-group">
											<label>วัน/เดือน/ปีเกิด(พ.ศ.)</label>

											<div class="input-group form-group date">
												<div class="input-group-addon">
													<i class="far fa-calendar-alt"></i>
												</div>
												<?php
												if ($row_profile["account_birthday"]) {
													echo "<input type='text' class='form-control pull-right' name='account_birthday' value='" . thai_date_thaiyear(strtotime($row_profile["account_birthday"])) . "' readonly='' required=''>";
												}

												else{
													echo "<input type='text' class='form-control pull-right' id='datepicker' name='account_birthday' style='color: #000;background-color: #ffff99' required=''>";
												}
												?>
												
											</div>
											<!-- /.input group -->
										</div>
										<!-- information -->
										<div class="form-group">
											<label>ที่อยู่</label>
											<input type="text" class="form-control" name="account_address" value="<?php echo($row_profile["account_address"]); ?>" <?php echo(isset($row_profile["account_address"]) ? '':'style="color: #000;background-color: #ffff99"') ?> required="">
										</div>
										<div class="form-group">
											<label>โทรศัพท์</label>
											<input type="tel" class="form-control" name="account_mobile" minlength="9" maxlength="10" value="<?php echo($row_profile["account_mobile"]); ?>" <?php echo(isset($row_profile["account_mobile"]) ? '':'style="color: #000;background-color: #ffff99"') ?> required="">
										</div>
										<div class="form-group">
											<label>อีเมล์</label>
											<input type="email" class="form-control" name="account_email" value="<?php echo($row_profile["account_email"]); ?>" >
										</div>
										<label for="basic-url"><i class="fab fa-facebook" style="color: #3b5998"></i> facebook</label>
										<div class="input-group">
											<span class="input-group-addon" id="basic-addon3" style="background-color: #eee;">facebook.com/</span>
											<input type="text" class="form-control" name="account_facebook" id="basic-url" aria-describedby="basic-addon3" placeholder="rmuti.kkc.ac.th" value="<?php echo($row_profile["account_facebook"]); ?>">
										</div>
										<label for="basic-url" style="margin-top: 15px"><i class="fab fa-line" style="color: #00c300"></i> LINE</label>
										<div class="input-group" style="margin-bottom: 15px">
											<span class="input-group-addon" id="basic-addon3" style="background-color: #eee;">LINE ID :</span>
											<input type="text" class="form-control" name="account_lineID" id="basic-url" aria-describedby="basic-addon3" placeholder="rmuti" value="<?php echo($row_profile["account_lineID"]); ?>" style="text-transform: lowercase;">
										</div>
									</div>
									<!-- /.box-body -->
								</div>
							</div>
						</div>
						<div align="center">
							<button type="submit" class="btn btn-primary"><i class="fas fa-chevron-circle-right"></i> ถัดไป</button>
							<button type="reset" class="btn btn-danger"><i class="fas fa-trash-alt"></i> ยกเลิก</button>
						</div>
					</form>
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
		<!-- <script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script> -->
		<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker-custom.js"></script>
		<script src="bower_components/bootstrap-datepicker/dist/locales/bootstrap-datepicker.th.min.js"></script>

		<!-- Page script -->
		<script>
			$(function () {
    		//Date picker
    		$('#datepicker').datepicker({
    			format: "dd/mm/yyyy",
    			startView: 2,
    			maxViewMode: 2,
    			clearBtn: true,
    			language: "th",
    			thaiyear: true,
    			orientation: "bottom auto",
    			autoclose: true,
    			endDate : new Date()
    		})
    	})
    </script>
  </body>
  </html>