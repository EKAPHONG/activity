<?php
session_start();
require 'includes/config.inc.php';
require 'includes/connect.inc.php';

if ($_SESSION["account_fn_01"] != '1') {
	header("Location: 404.php?alert=danger&permission=invalid");
}

$page     = basename($_SERVER['PHP_SELF'], ".php");
$pageName = "กำหนดสิทธิ์การเข้าใช้งาน";
$pageDescription = "";

$profile	= $con->query("SELECT * FROM `account` WHERE account_idno = '" . $_GET['account_idno'] . "'");
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
		.center{
			text-align: center;
		}

		.icheckbox_flat-orange.disabled{
			opacity: 0.5;
			background-position: -22px 0 !important;
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
				if ($_GET["alert"] == "success" && $_GET["status"] == "success") {
					?>
					<div class="alert alert-success alert-dismissible col-md-offset-1 col-md-10">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<h4><i class="fas fa-check"></i> สำเร็จ!</h4>
						บันทึกข้อมูลเรียบร้อยแล้ว
					</div>
					<?php
				}
				?>

				<?php
				if (($row_profile["account_id"] != "") AND ($row_profile["account_degree"] != "")) {
					?>
					<div class="alert alert-warning alert-dismissible col-md-offset-1 col-md-10">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<h4><i class="fas fa-exclamation-triangle"></i> คำเตือน!</h4>
						บัญชีผู้ใช้นี้เป็นบัญชีนักศึกษา โปรดกำหนดสิทธิ์ด้วยความระมัดระวัง
					</div>
					<?php
				}
				?>

				<form action="page_editPermissions_save.php" method="POST" role="form">

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
									<div class="form-group col-md-6">
										<label>ชื่อ - สกุล</label>
										<input name="account_idno" type="hidden" class="form-control" value="<?php echo $row_profile["account_idno"]; ?>" readonly="">
										<input type="text" class="form-control" value="<?php echo $row_profile["account_prefix"] . $row_profile["account_firstname"] . " " . $row_profile["account_lastname"]; ?>" readonly="">
									</div>
									<div class="form-group col-md-6">
										<label>คณะ</label>
										<input type="text" class="form-control" value="<?php echo($row_profile["account_faculty"]); ?>" readonly="">
									</div>
								</div>
								<!-- /.box-body -->
							</div>

							<div class="box box-warning">
								<div class="box-header">
									<h3 class="box-title">สิทธิ์การเข้าใช้งาน</h3>
								</div>
								<!-- /.box-header -->
								<div class="box-body">
									<div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
										<div class="row">
											<div class="col-sm-6"></div>
											<div class="col-sm-6"></div>
										</div>
										<div class="row">
											<div class="col-sm-offset-1 col-sm-10">
												<table class="table table-responsive no-padding table-bordered table-hover dataTable">
													<thead>
														<tr role="row">
															<th class="center">ลำดับ</th>
															<th class="center">รายการ</th>
															<th class="center">อนุญาต</th>
															<th class="center">คำอธิบาย</th>
														</tr>
													</thead>
													<tbody>

														<tr>
															<td colspan="5"><b>จัดการข้อมูล</b></td>
														</tr>

														<tr>
															<td class="center"><b>1.</b></td>
															<td>จัดการข้อมูลกิจกรรม</td>
															<td class="center"><input type="checkbox" name="account_fn_03" value="account_fn_03" <?php echo ($row_profile["account_fn_03"] == "1" ? "checked" : ""); ?> class="flat-orange"></td>
															<td>
																<li>เพิ่มข้อมูลกิจกรรม</li>
																<li>แก้ไขข้อมูลกิจกรรม</li>
															</td>
														</tr>

														<tr>
															<td class="center"><b>2.</b></td>
															<td>จัดการข้อมูลนักศึกษา</td>
															<td class="center"><input type="checkbox" name="account_fn_05" value="account_fn_05" <?php echo ($row_profile["account_fn_05"] == "1" ? "checked" : ""); ?> class="flat-orange"></td>
															<td>
																<li>แก้ไขข้อมูลนักศึกษา เช่น<br>
																	ระดับการศึกษา, ที่อยู่, โทรศัพท์
																</li>
															</td>
														</tr>

														<tr>
															<td colspan="5"><b>จัดการผู้เข้าร่วมกิจกรรม</b></td>
														</tr>

														<tr>
															<td class="center"><b>3.</b></td>
															<td>นำเข้ารายชื่อผู้เข้าร่วมกิจกรรม</td>
															<td class="center"><input type="checkbox" name="account_fn_04" value="account_fn_04" <?php echo ($row_profile["account_fn_04"] == "1" ? "checked" : ""); ?> class="flat-orange"></td>
															<td>
																<li>นำเข้ารายชื่อผู้เข้าร่วมกิจกรรม</li>
															</td>
														</tr>

														<tr>
															<td class="center"><b>4.</b></td>
															<td>ลบรายการผู้เข้าร่วมกิจกรรม</td>
															<td class="center"><input type="checkbox" name="account_fn_09" value="account_fn_09" <?php echo ($row_profile["account_fn_09"] == "1" ? "checked" : ""); ?> class="flat-orange"></td>
															<td>
																<li>ลบรายการผู้เข้าร่วมกิจกรรม</li>
															</td>
														</tr>

														<tr>
															<td class="center"><b>5.</b></td>
															<td>อนุมัติหน่วยกิจกรรม</td>
															<td class="center"><input type="checkbox" name="account_fn_02" value="account_fn_02" <?php echo ($row_profile["account_fn_02"] == "1" ? "checked" : ""); ?> class="flat-orange"></td>
															<td>
																<li>อนุมัติ/ยกเลิก รายชื่อผู้เข้าร่วมกิจกรรม</li>
															</td>
														</tr>

														<tr>
															<td colspan="5"><b>พิมพ์/ออกรายงาน</b></td>
														</tr>

														<tr>
															<td class="center"><b>6.</b></td>
															<td>พิมพ์ใบแสดงผลการเข้าร่วมกิจกรรม</td>
															<td class="center"><input type="checkbox" name="account_fn_07" value="account_fn_07" <?php echo ($row_profile["account_fn_07"] == "1" ? "checked" : ""); ?> class="flat-orange"></td>
															<td>
																<li>พิมพ์ใบแสดงผลการเข้าร่วมกิจกรรม</li>
															</td>
														</tr>

														<tr>
															<td class="center"><b>7.</b></td>
															<td>พิมพ์รายชื่อผู้เข้าร่วมกิจกรรม	</td>
															<td class="center"><input type="checkbox" name="account_fn_06" value="account_fn_06" <?php echo ($row_profile["account_fn_06"] == "1" ? "checked" : ""); ?> class="flat-orange"></td>
															<td>
																<li>ออกรายงาน รายชื่อผู้เข้าร่วมกิจกรรม</li>
															</td>
														</tr>

														<tr>
															<td colspan="5"><b>ระบบ</b></td>
														</tr>

														<tr>
															<td class="center"><b>8.</b></td>
															<td>กำหนดเงื่อนไขการผ่านกิจกรรม</td>
															<td class="center"><input type="checkbox" name="account_fn_08" value="account_fn_08" <?php echo ($row_profile["account_fn_08"] == "1" ? "checked" : ""); ?> class="flat-orange"></td>
															<td>
																<li>กำหนดจำนวนกิจกรรม และ/หรือจำนวนหน่วย ในกิจกรรมประเภทต่าง ๆ</li>
															</td>
														</tr>

														<tr>
															<td class="center"><b>9.</b></td>
															<td>จัดการผู้ใช้งานระบบ</td>
															<td class="center">
																<input type="checkbox" name="account_fn_01" value="account_fn_01" <?php 
																echo ($row_profile["account_fn_01"] == "1" ? "checked " : ""); 
																echo ($_GET['account_idno'] == $_SESSION["account_idno"] ? "disabled" : ""); ?> class="flat-orange">
															</td>
															<td>
																<li>สามารถกำหนดสิทธิ์ให้บัญชีผู้ใช้อื่น ๆ ในระบบได้ เช่น<br>
																	กำหนดสิทธิ์ให้บัญชี A สามารถอนุมัติการเข้าร่วมกิจกรรมได้
																</li>
															</td>
														</tr>

													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
								<!-- /.box-body -->
							</div>

						</div>
					</div>
					<div align="center">
						<button type="submit" class="btn btn-success"><i class="fas fa-save"></i> บันทึก</button>
						<button type="reset" class="btn btn-danger" onclick="goBack()"><i class="fas fa-undo"></i> ย้อนกลับ</button>
						<!-- <button type="reset" class="btn btn-danger"><i class="fas fa-trash-alt"></i> ยกเลิก</button> -->
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