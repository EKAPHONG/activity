<?php
session_start();
require_once('spreadsheet-reader/php-excel-reader/excel_reader2.php');
require_once('spreadsheet-reader/SpreadsheetReader.php');
require 'includes/config.inc.php';
require 'includes/connect.inc.php';

$conn = mysqli_connect("localhost",$username,$password,$database);

if ($_SESSION["account_fn_04"] != '1') {
	header("Location: index.php?alert=fail&permission=invalid");
}

$page     = "Import";
$subPage  = basename($_SERVER['PHP_SELF'], ".php");
$pageName = "นำเข้ารายชื่อผู้เข้าร่วมกิจกรรม";
$pageDescription = "";
$activity_id_no	= $_GET['activity_id'];

if (isset($_GET['activity_id'])) {
	$activity		= $con->query("SELECT `activity_id`, `activity_name` FROM `activity` WHERE `activity_id` = '" . $_GET['activity_id'] . "'");
	$row_activity	= $activity->fetch();

	if (empty($row_activity['activity_name'])) {
		$msg_error = 'ไม่พบรหัสกิจกรรม';
	}
}

if (isset($_GET["edit"])) {
	header("location: page_import.php");
}

// เพิ่มด้วยไฟล์
if (isset($_POST["import"]))
{
	$allowedFileType = ['application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];

	if(in_array($_FILES["file"]["type"],$allowedFileType)){

		$targetPath = 'uploads/'.$_FILES['file']['name'];
		move_uploaded_file($_FILES['file']['tmp_name'], $targetPath);

		$Reader = new SpreadsheetReader($targetPath);

		$sheetCount = count($Reader->sheets());
		for($i=0;$i<$sheetCount;$i++)
		{

			$Reader->ChangeSheet($i);

			foreach ($Reader as $Row)
			{

				$account_id = "";
				if(isset($Row[0])) {
					$account_id = mysqli_real_escape_string($conn,$Row[0]);
				}

				$activity_id = $_POST["activity_id_hidden"];
				// $activity_id = "";
				// if(isset($Row[1])) {
				// 	$activity_id = mysqli_real_escape_string($conn,$Row[1]);
				// }

				$join_date = date("Y-m-d");

				if (!empty($account_id) || !empty($activity_id)) {
					$query = "insert into joins(account_id,activity_id,join_date) values('".$account_id."','".$activity_id."','".$join_date."')";
					$result = mysqli_query($conn, $query);

					if (! empty($result)) {
						$type = "alert alert-success alert-dismissible";
						$message_1 = "<h4><i class='icon fa fa-check'></i> สำเร็จ!</h4>";
						$message_2 = "นำเข้าข้อมูลเรียบร้อยแล้ว";
					} else {
						$type = "alert alert-danger alert-dismissible";
						$message_1 = "<h4><i class='icon fa fa-ban'></i> ผิดพลาด!</h4>";
						$message_2 = "พบปัญหาในการนำเข้าข้อมูล";
					}
				}
			}

		}
	}
	else
	{ 
		$type = "alert alert-danger alert-dismissible";
		$message_1 = "<h4><i class='icon fa fa-ban'></i> ผิดพลาด!</h4>";
		$message_2 = "ประเภทไฟล์ไม่ถูกต้อง กรุณาอัพโหลดไฟล์ Excel ที่มีนามสกุล .xls หรือ .xlsx เท่านั้น";
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo(_TITLE); ?> | <?php echo($pageName); ?></title>
	<!-- iCheck for checkboxes and radio inputs -->
	<link rel="stylesheet" href="plugins/iCheck/all.css">
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

						<?php
						if (isset($type)) {
							?>
							<div class="<?php echo($type) ?>">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<?php echo($message_1) ?>
								<?php echo($message_2) ?>
							</div>
							<?php
						}

						if (isset($_GET["activity_id"]) AND isset($_GET["account_id"]) AND isset($_GET["status"])) {
							if ($_GET["status"] == "success") {
								?>
								<div class="alert alert-success alert-dismissible">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
									<h4><i class="icon fa fa-check"></i> สำเร็จ!</h4>
									เพิ่มนักศึกษารหัส : <?php echo ($_GET["account_id"]); ?><br>
									เข้าร่วมกิจกรรม : <?php echo $_GET["activity_id"] . " (" . $row_activity["activity_name"] . ")"; ?> เรียบร้อยแล้ว
								</div>
								<?php
							}
							else{
								?>
								<div class="alert alert-danger alert-dismissible">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
									<h4><i class="icon fa fa-ban"></i> ผิดพลาด!</h4>
									ไม่สามารถเพิ่มรหัสนักศึกษา เข้าร่วมกิจกรรมดังกล่าวได้
								</div>
								<?php
							}
						}
						?>

						<div class="box box-info">
							<div class="box-header with-border">
								<h3 class="box-title">นำเข้าด้วยการกรอกข้อมูล</h3>
							</div>
							<!-- /.box-header -->
							<!-- form start -->
							<form class="form-horizontal" action="page_import_insert.php" method="POST">
								<div class="box-body col-sm-offset-2 col-sm-8">
									<div class="form-group">
										<label class="col-sm-3 control-label">รหัสกิจกรรม</label>
										<div class="col-sm-9">
											<input type="text" class="form-control uintTextBox" name="activity_id" value="<?php echo (isset($_GET['activity_id']) ? "$activity_id_no":"") ?>" readonly required>
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-3 control-label">ชื่อกิจกรรม</label>
										<div class="col-sm-9">
											<input type="text" class="form-control uintTextBox" name="activity_name" value="<?php echo($row_activity['activity_name']) ?>" readonly required>
										</div>
									</div>

									<div class="form-group">
										<label class="col-sm-3 control-label">รหัสนักศึกษา</label>

										<div class="col-sm-9">
											<input type="text" class="form-control" name="account_id" <?php echo(isset($_GET["activity_id"]) ? "autofocus":""); ?> required>
										</div>
									</div>
									<!-- <div class="form-group">
										<div class="col-sm-offset-3 col-sm-6">
											<div class="checkbox">
												<label>
													<input type="checkbox" class="flat-blue" name="remember_activity_id" <?php echo($_COOKIE["remember_activity_id"]); ?>> จดจำรหัสกิจกรรม
												</label>
											</div>
										</div>
									</div> -->
								</div>
								<!-- /.box-body -->
								<div class="box-footer">
									<div class="col-sm-12">
										<center>
											<button type="reset" class="btn btn-danger"><i class="fas fa-times"></i> ยกเลิก</button>
											<button type="submit" class="btn btn-info" name="insert"><i class="fas fa-upload"></i> นำเข้ารายชื่อ</button>
										</center>
									</div>
								</div>
								<!-- /.box-footer -->
							</form>
						</div>


						<div class="box box-warning">
							<div class="box-header with-border">
								<h3 class="box-title">นำเข้าด้วยไฟล์ Excel</h3>
							</div>
							<!-- /.box-header -->
							<div class="box-body">
								<!-- information -->
								<div class="row">

									<div class="col-md-4">
										<div class="form-group">
											<center><h4><b>คำแนะนำ</b></h4></center>
											<ol>
												<li>รหัสนักศึกษาต้องอยู่คอลัมน์ A เท่านั้น</li>
												<li>ควร "เอารายการที่ซ้ำกันออก" ก่อนอัปโหลดไฟล์</li>
												<li>กรอกรหัสกิจกรรม จากนั้นคลิก "ตรวจสอบ"</li>
												<li>ตรวจสอบชื่อกิจกรรม
													<br>- หากถูกต้องให้เลือกไฟล์ Excel แล้วคลิกที่ปุ่ม "นำเข้ารายชื่อ"
													<br>- หากไม่ถูกต้องให้คลิกปุ่ม "แก้ไข" แล้วแก้ไขให้ถูกต้อง
												</ol>
											</div>
										</div>
										<div class="col-md-8">
											<div class="form-group">
												<img src="images/example.gif" width="100%">
											</div>
										</div>

										<div class="col-md-12">
											<hr>
										</div>

										<div class="col-md-12">

											<div class="col-md-4">
												<label>รหัสกิจกรรม</label>
												<form action="" method="GET">
													<div class="input-group">
														<input type="text" class="form-control uintTextBox" name="activity_id" pattern="[0-9]{1,}" title="กรอกตัวเลขเท่านั้น" required <?php echo(isset($row_activity['activity_name']) ? 'value="' . $_GET['activity_id'] . '" readonly':'style="color: #000;background-color: #ffff99"') ?>>
														<span class="input-group-btn">
															<?php
															if (isset($row_activity['activity_name'])) {
																?>
																<button type="submit" class="btn btn-warning" name="edit">แก้ไข</button>
																<?php
															} else {
																?>
																<button type="submit" class="btn btn-warning">ตรวจสอบ</button>
																<?php
															}
															?>
														</span>
													</div>
													<div style="color: red;"><?php echo($msg_error) ?></div>
												</form>
											</div>

											<div class="col-md-8">
												<div class="form-group">
													<label>ชื่อกิจกรรม</label>
													<input type="text" class="form-control" value="<?php echo($row_activity['activity_name']) ?>" disabled required>
												</div>
											</div>

											<div class="col-md-4"></div>
											<div class="col-md-8">
												<div class="form-group">
													<form action="" method="post" name="frmExcelImport" id="frmExcelImport" enctype="multipart/form-data">
														<input type="hidden" class="form-control" name="activity_id_hidden" pattern="[0-9]{1,}" title="กรอกตัวเลขเท่านั้น" value="<?php echo($_GET['activity_id']) ?>" required>
														<label>เลือกไฟล์</label>
														<input type="file" name="file" id="file" accept=".xls,.xlsx" required="">

														<p class="help-block">รองรับไฟล์นามสกุล .xls และ .xlsx เท่านั้น</p>
														<center><button type="submit" class="btn btn-warning" name="import"><i class="fas fa-upload"></i> นำเข้ารายชื่อ</button></center>
													</form>
												</div>
											</div>

										</div>

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

				<script>
					$(function () {
						//Flat blue color scheme for iCheck
						$('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').iCheck({
							checkboxClass: 'icheckbox_flat-blue',
							radioClass   : 'iradio_flat-blue'
						})
					})
				</script>
			</body>
			</html>