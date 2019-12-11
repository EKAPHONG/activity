<?php
session_start();
require 'includes/config.inc.php';
require 'includes/connect.inc.php';

if ($_SESSION["account_fn_03"] != '1') {
	header("Location: 404.php?alert=fail&permission=invalid");
}

$page     = "Staff";
$subPage  = basename($_SERVER['PHP_SELF'], ".php");
$pageName = "เพิ่มข้อมูลกิจกรรม";
$pageDescription = "";

$firstYear = date("Y");
$lastYear = (int)date("Y")-10;

$activity_type = $con->query("SELECT * FROM `activity_type`");
$activity_organizer = $con->query("SELECT * FROM `activity_organizer`");

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
					<li><a href="<?php echo(_MAIN); ?>"><i class="fas fa-home"></i> หน้าหลัก</a></li>
					<li>เจ้าหน้าที่ฝ่ายบริหารกิจกรรม</li>
					<li class="active"><?php echo($pageName); ?></li>
				</ol>
			</section>

			<!-- Main content -->
			<section class="content container-fluid">

				<div class="row">
					<!-- left column -->
					<div class="col-md-10 col-md-offset-1">

						<?php
						if (isset($_GET["activity_id"]) && ($_GET["status"]) == "success") {
							$activity = $con->query("SELECT * FROM `activity` WHERE `activity_id` = '".$_GET["activity_id"]."'");
							$row_activity = $activity->fetch();
							?>
							<div class="alert alert-success alert-dismissible">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<h4><i class="icon fa fa-check"></i> สำเร็จ!</h4>
								เพิ่มกิจกรรม <b><?php echo($row_activity["activity_name"]); ?></b> เรียบร้อยแล้ว
							</div>
							<?php
						}
						?>

						<!-- general form elements disabled -->
						<form action="page_addActivity_save.php" method="POST">
							<div class="box box-warning">
								<div class="box-header with-border">
									<h3 class="box-title">ข้อมูลกิจกรรม</h3>
								</div>
								<!-- /.box-header -->
								<div class="box-body">
									<!-- information -->
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label>รหัสกิจกรรม</label>
												<input type="text" class="form-control uintTextBox" name="activity_id" pattern="[0-9]{1,}" title="โปรดระบุข้อมูลเป็นตัวเลข 0-9 เท่านั้น" minlength="11" maxlength="11" required="" <?php echo "value='" . $row_activity["activity_id"] . "'"; ?>>
											</div>
											<div class="form-group">
												<label>ชื่อกิจกรรม</label>
												<input type="text" class="form-control" name="activity_name" maxlength="200" required="" <?php echo "value='" . $row_activity["activity_name"] . "'"; ?>>
											</div>

											<div class="form-group">
												<label>ประเภท</label>
												<select class="form-control" name="activity_type" required="">
													<option value="">กรุณาเลือก</option>
													<?php
													while ($row_activity_type = $activity_type->fetch()) {
														echo "<option value='" . $row_activity_type["type_id"] . "'>" . $row_activity_type["type_name"] . "</option>";
													}
													?>
												</select>
											</div>

											<div class="form-group">
												<label>กิจกรรมในส่วน</label>
												<select class="form-control" name="activity_organizer" required="">
													<option value="">กรุณาเลือก</option>
													<?php
													while ($row_activity_organizer = $activity_organizer->fetch()) {
														echo "<option value='" . $row_activity_organizer["organizer_id"] . "'>" . $row_activity_organizer["organizer_name"] . "</option>";
													}
													?>
												</select>
											</div>

											<div class="form-group">
												<label>จำนวน (หน่วย)</label>
												<input type="text" class="form-control uintTextBox" name="activity_unit" pattern="[0-9]{1,}" title="โปรดระบุข้อมูลเป็นตัวเลข 0-9 เท่านั้น" minlength="1" maxlength="2" required="">
											</div>

											<div class="form-group">
												<label>ภาคเรียนที่</label>
												<select class="form-control" name="activity_term" required="">
													<option value="1">1</option>
													<option value="2">2</option>
													<option value="3">3</option>
												</select>
											</div>

											<div class="form-group">
												<label>ประจำปีการศึกษา</label>
												<select class="form-control" name="activity_year" required="">
													<?php
													for ($i=$firstYear; $i > $lastYear; $i--) {
														echo '<option value='.$i.'>'.($i+543).'</option>';
													}
													?>
												</select>
											</div>
											<div class="form-group">
												<label>วันที่จัดกิจกรรม</label>
												<div class="input-group form-group date">
													<div class="input-group-addon">
														<i class="far fa-calendar-alt"></i>
													</div>
													<input type="text" class="form-control pull-right" id="datepicker" name="activity_date" required="">
												</div>
											</div>
											<div class="form-group">
												<label>สถานะกิจกรรม</label>
												<select class="form-control" name="activity_status" required="">
													<option value="1" selected="">เปิด</option>
													<option value="0">ปิด</option>
												</select>
												<p class="help-block">สถานะ <b>ปิด</b> หมายถึง ไม่คำนวณหน่วย และไม่แสดงผลกิจกรรมนี้ ในใบแสดงผลการเข้าร่วมกิจกรรม</p>
											</div>
											<center>
												<button type="submit" class="btn btn-success"><i class="fas fa-check-circle"></i> ยืนยัน</button>
												<button type="reset" class="btn btn-danger"><i class="fas fa-trash-alt"></i> ยกเลิก</button>
											</center>
										</div>
									</div>
								</div>
								<!-- /.box-body -->
							</div>
						</form>
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
    			todayBtn: "linked",
    			clearBtn: true,
    			language: "th",
    			thaiyear: true,
    			autoclose: true,
    			todayHighlight: true
    		})
    	})
    </script>
</body>
</html>