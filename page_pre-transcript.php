<?php
session_start();
require 'includes/config.inc.php';
require 'includes/connect.inc.php';
require 'includes/dateThai.inc.php';

if ($_SESSION["account_fn_07"] != '1') {
	header("Location: 404.php?alert=fail&permission=invalid");
}

$page     = basename($_SERVER['PHP_SELF'], ".php");
$pageName = "ตรวจสอบข้อมูลก่อนพิมพ์";
$pageDescription = "";

$profile	= $con->query("SELECT * FROM `account` WHERE account_id = '" . $_GET['account_id'] . "'");
$row_profile= $profile->fetch();
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo(_TITLE); ?> | <?php echo($pageName); ?></title>
	<!-- Load stylesheet -->
	<?php require_once('includes/stylesheet.inc.php'); ?>
	<!-- iCheck for checkboxes and radio inputs -->
	<link rel="stylesheet" href="plugins/iCheck/all.css">
	<!-- bootstrap datepicker -->
	<link rel="stylesheet" href="bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
	<style type="text/css">
		.center {
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

				<form action="page_transcript_eng_1.php?account_id=<?php echo($row_profile["account_id"]); ?>"
					method="POST" role="form">

					<div class="row">
						<!-- left column -->
						<div class="col-md-offset-1 col-md-10">

							<!-- general form elements disabled -->

							<div class="box box-warning">
								<div class="box-header with-border">
									<h3 class="box-title">ข้อมูลประวัติส่วนตัว</h3>
								</div>
								<!-- /.box-header -->
								<div class="box-body">
									<!-- information -->
									<div class="form-group col-md-4">
										<img class="img-thumbnail"
											src="http://khonkaen-ess.rmuti.ac.th/RMUTI/Registration/WebForm/GetPicture.aspx?StudentNo=<?php echo($row_profile["account_id"]); ?>">
									</div>
									<div class="form-group col-md-4">
										<label>ชื่อ - สกุล</label>
										<input type="text" class="form-control"
											value="<?php echo $row_profile["account_prefix"] . $row_profile["account_firstname"] . " " . $row_profile["account_lastname"]; ?>"
											readonly="">
									</div>
									<div class="form-group col-md-4">
										<label>รหัสนักศึกษา</label>
										<input type="text" class="form-control"
											value="<?php echo($row_profile["account_id"]); ?>" readonly="">
									</div>
									<div class="form-group col-md-4">
										<label>คุณวุฒิการศึกษา</label>
										<input type="text" class="form-control"
											value="<?php echo($row_profile["account_degree"]); ?>" readonly="">
									</div>
									<div class="form-group col-md-4">
										<label>สาขาวิชา</label>
										<input type="text" class="form-control"
											value="<?php echo($row_profile["account_department"]); ?>" readonly="">
									</div>
									<div class="col-md-4">
										<label>วัน/เดือน/ปีเกิด</label>
										<div class="input-group date">
											<div class="input-group-addon">
												<i class="far fa-calendar-alt"></i>
											</div>
											<?php
											if ($row_profile["account_birthday"]) {
												echo "<input type='text' class='form-control pull-right' value='" . thai_date_thaiyear(strtotime($row_profile["account_birthday"])) . "' autocomplete='off' readonly='' required=''>";
											}

											else{
												echo "<input type='text' class='form-control pull-right datepicker' name='account_birthday' style='color: #000;background-color: #ffff99' autocomplete='off' required=''>";
											}
											?>

										</div>
									</div>
									<div class="form-group col-md-4 mb-1">
										<label>เลขประจําตัวประชาชน</label>
										<input type="text" class="form-control"
											value="<?php echo($row_profile["account_idno"]); ?>" readonly="">
									</div>
									<div class="form-group col-md-4">
										<label>วันที่เข้าศึกษา</label>
										<div class="input-group form-group date">
											<div class="input-group-addon">
												<i class="far fa-calendar-alt"></i>
											</div>
											<input type='text' class='form-control pull-right datepicker' name='date_in'
												style="color: #000;background-color: #ffff99" autocomplete="off"
												required="">
										</div>
									</div>
									<div class="form-group col-md-4">
										<label>วันที่ผ่านกิจกรรม</label>
										<div class="input-group form-group date">
											<div class="input-group-addon">
												<i class="far fa-calendar-alt"></i>
											</div>
											<input type='text' class='form-control pull-right datepicker'
												name='date_out' style="color: #000;background-color: #ffff99"
												autocomplete="off" required="">
										</div>
									</div>
								</div>
								<!-- /.box-body -->
							</div>

							<div class="box box-warning">
								<div class="box-header">
									<h3 class="box-title">ข้อมูลผู้ลงนาม</h3>
								</div>
								<!-- /.box-header -->
								<div class="box-body">
									<div class="form-group col-md-4">
										<label>ชื่อ - สกุล</label>
										<input type="text" class="form-control" name="name_left">
										<label>ตำแหน่ง</label>
										<input type="text" class="form-control" name="title_left"
											value="หัวหน้าแผนกงานพัฒนานักศึกษา"
											placeholder="หัวหน้าแผนกงานพัฒนานักศึกษา">
									</div>

									<div class="form-group col-md-4">
										<label>ชื่อ - สกุล</label>
										<input type="text" class="form-control" name="name_center">
										<label>ตำแหน่ง</label>
										<input type="text" class="form-control" name="title_center"
											value="รองคณบดีฝ่ายพัฒนานักศึกษา" placeholder="รองคณบดีฝ่ายพัฒนานักศึกษา">
									</div>

									<div class="form-group col-md-4">
										<label>ชื่อ - สกุล</label>
										<input type="text" class="form-control" name="name_right">
										<label>ตำแหน่ง</label>
										<input type="text" class="form-control" name="title_right"
											value="คณบดีคณะ<?php echo($row_profile["account_faculty"]); ?>"
											placeholder="คณบดีคณะ<?php echo($row_profile["account_faculty"]); ?>">
									</div>

									<div class="col-sm-12 center">
										<p>หากไม่ระบุชื่อ จะไม่ปรากฏข้อมูลส่วนนั้น ๆ</p>
									</div>
								</div>
								<!-- /.box-body -->
							</div>

						</div>
					</div>
					<div align="center" style="margin-bottom: 50px;">
						<a class="btn btn-info"
							href="page_checkActivity.php?account_id=<?php echo $_GET['account_id']; ?>" target="_blank"
							role="button"><i class="far fa-calendar-check"></i> ตรวจสอบการเข้าร่วมกิจกรรม</a>
						<div class="btn-group">
							<button type="submit" class="btn btn-success"><i class="fas fa-print"></i> สร้างไฟล์ PDF</button>
							<button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
								<span class="caret"></span>
								<span class="sr-only">Toggle Dropdown</span>
							</button>
							<ul class="dropdown-menu" role="menu">
								<li><button type="submit" class="btn btn-link" formaction="page_transcript_eng_1.php?account_id=<?php echo $_GET['account_id']; ?>">1 หน้า</button></li>
								<li><button type="submit" class="btn btn-link" formaction="page_transcript_eng_2.php?account_id=<?php echo $_GET['account_id']; ?>">2 หน้า</button></li>
							</ul>
						</div>
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
	<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker-custom.js"></script>
	<script src="bower_components/bootstrap-datepicker/dist/locales/bootstrap-datepicker.th.min.js"></script>

	<!-- Page script -->
	<script>
		$(function () {
			//Date picker
			$('.datepicker').datepicker({
				format: "dd/mm/yyyy",
				startView: 2,
				maxViewMode: 2,
				todayBtn: "linked",
				clearBtn: true,
				language: "th",
				thaiyear: true,
				autoclose: true,
				todayHighlight: true,
				orientation: "bottom auto",
				endDate: new Date()
			})
		})
	</script>

	<script>
		$(function () {
			//Flat blue color scheme for iCheck
			$('input[type="checkbox"].flat-orange, input[type="radio"].flat-orange').iCheck({
				checkboxClass: 'icheckbox_flat-orange'
			})
		})
	</script>
</body>

</html>