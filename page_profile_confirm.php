<?php
session_start();
require 'includes/config.inc.php';
require 'includes/connect.inc.php';
require 'includes/dateThai.inc.php';

$page     = basename($_SERVER['PHP_SELF'], ".php");
$pageName = "ยืนยันข้อมูลส่วนตัว";
$pageDescription = "";

$level_id			=	$_POST["level_id"];
$account_birthday	=	convert_format($_POST["account_birthday"]);
$account_address	=	$_POST["account_address"];
// $account_mobile		=	$_POST["account_mobile"];
$account_mobile		=	preg_replace(array('/\+66/'),'0',$_POST["account_mobile"]);
$account_email		=	$_POST["account_email"];
$account_facebook	=	explode("&",preg_replace(array('/http:\/\//', '/https:\/\//', '/www.facebook.com\//', '/m.facebook.com\//', '/facebook.com\//', '/\//', '/\\\/'),'',$_POST["account_facebook"]));
$account_lineID		=	strtolower($_POST["account_lineID"]);

$profile			= $con->query("SELECT account.*,level.level_name FROM `account` LEFT JOIN `level` ON  account.level_id = level.level_id WHERE account_username = '" . $_SESSION['account_username'] . "'");
$row_profile		= $profile->fetch();

$level				= $con->query("SELECT * FROM `level` WHERE level_id = '$level_id'");
$row_level			= $level->fetch();
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
					<li><a href="#"><i class="fas fa-tachometer-alt"></i> Level</a></li>
					<li class="active">Here</li>
				</ol>
			</section>

			<!-- Main content -->
			<section class="content container-fluid">

				<?php
				if (!isset($_SESSION["account_birthday"]) && !isset($_SESSION["level_id"])) {
					?>
					<div class="alert alert-warning alert-dismissible">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<h4><i class="fas fa-exclamation-triangle"></i> คำเตือน!</h4>
						รายการที่ไม่สามารถแก้ไขได้ภายหลัง
						<ul>
							<li>ระดับการศึกษา</li>
							<li>วัน/เดือน/ปีเกิด</li>
						</ul>
					</div>
					<?php
				}

				else{
					?>
					<div class="alert alert-warning alert-dismissible">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<h4><i class="fas fa-exclamation-triangle"></i> คำเตือน!</h4>
						โปรดตรวจสอบข้อมูลที่ท่านต้องการแก้ไข และกดยืนยัน
					</div>
					<?php
				}
				?>			

				<div class="row">
					<!-- left column -->
					<div class="col-md-6">
						<!-- <div class="col-md-10 col-md-offset-1"> -->

							<!-- general form elements disabled -->
							<form action="page_profile_save.php" method="post" role="form">
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
											<select class="form-control" name="level_id" readonly="" required="">
												<?php
												if (isset($row_profile["level_id"])) {
													echo "<option value='" . $row_profile["level_id"] . "' selected=''>" . $row_profile["level_name"] . "</option>";
												}
												else{
													echo "<option value='" . $level_id . "' selected=''>" . $row_level["level_name"] . "</option>";
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

											<div class="input-group date">
												<div class="input-group-addon">
													<i class="far fa-calendar-alt"></i>
												</div>
												<?php
												if (isset($row_profile["account_birthday"])) {
													echo "<input type='text' class='form-control pull-right' value='" . thai_date_thaiyear(strtotime($row_profile["account_birthday"])) . "' readonly='' required=''>";
													echo "<input type='hidden' class='form-control pull-right' name='account_birthday' value='" . $row_profile["account_birthday"] . "' readonly='' required=''>";
												}
												else{
													echo "<input type='text' class='form-control pull-right' value='" . thai_date_thaiyear(strtotime($account_birthday)) . "' readonly='' required=''>";
													echo "<input type='hidden' class='form-control pull-right' name='account_birthday' value='" . $account_birthday . "' readonly='' required=''>";
												}												
												?>
												
											</div>
											<!-- /.input group -->
										</div>
										<!-- information -->
										<div class="form-group">
											<label>ที่อยู่</label>
											<input type="text" class="form-control" name="account_address" value="<?php echo($account_address); ?>" readonly="">
										</div>
										<div class="form-group">
											<label>โทรศัพท์</label>
											<input type="tel" class="form-control" name="account_mobile" minlength="9" maxlength="10" value="<?php echo($account_mobile); ?>" readonly="">
										</div>
										<div class="form-group">
											<label>อีเมล์</label>
											<input type="email" class="form-control" name="account_email" value="<?php echo($account_email); ?>" readonly="">
										</div>
										<label for="basic-url"><i class="fab fa-facebook" style="color: #3b5998"></i> facebook</label>
										<div class="input-group">
											<span class="input-group-addon" id="basic-addon3" style="background-color: #eee;">facebook.com/</span>
											<input type="text" class="form-control" name="account_facebook" id="basic-url" aria-describedby="basic-addon3" value="<?php echo($account_facebook[0]); ?>" readonly="">
										</div>
										<label for="basic-url" style="margin-top: 15px"><i class="fab fa-line" style="color: #00c300"></i> LINE</label>
										<div class="input-group" style="margin-bottom: 15px">
											<span class="input-group-addon" id="basic-addon3" style="background-color: #eee;">LINE ID :</span>
											<input type="text" class="form-control" name="account_lineID" id="basic-url" aria-describedby="basic-addon3" value="<?php echo($account_lineID); ?>" style="text-transform: lowercase;" readonly="">
										</div>
									</div>
									<!-- /.box-body -->
								</div>
							</div>
						</div>
						<div align="center">
							<button type="submit" class="btn btn-success"><i class="fas fa-check-circle"></i> ยืนยัน</button>
							<button type="reset" class="btn btn-danger" onclick="goBack()"><i class="fas fa-undo"></i> ย้อนกลับ</button>
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
		<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
		<script src="bower_components/bootstrap-datepicker/dist/locales/bootstrap-datepicker.th.min.js"></script>

		<!-- Page script -->
		<script>
			$(function () {
    		//Date picker
    		$('#datepicker').datepicker({
    			autoclose: true,
    			format: 'dd/mm/yyyy',
    			language: 'th',
    			endDate : new Date()
    		})
    	})
    </script>
</body>
</html>