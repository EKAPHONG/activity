<?php
session_start();
require 'includes/config.inc.php';
require 'includes/connect.inc.php';

if ($_SESSION["account_fn_08"] != '1') {
	header("Location: 404.php?alert=danger&permission=invalid");
}

$page 		= "Setting";
$subPage    = basename($_SERVER['PHP_SELF'], ".php");
$pageName	= "กำหนดเงื่อนไขการผ่านกิจกรรม";
$pageDescription = "";


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
	<style type="text/css">
		.center{
			text-align: center;
		}

		td{
			white-space: nowrap;
		}

		input {
			width: 50px;
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
				<ol class="breadcrumb">
					<li><a href="<?php echo(_MAIN); ?>"><i class="fas fa-tachometer-alt"></i> เมนูหลัก</a></li>
					<li class="active"><?php echo($pageName); ?></li>
				</ol>
			</section>

			<!-- Main content -->
			<section class="content container-fluid">

				<?php
				if ($_GET["alert"] == "success" && $_GET["status"] == "success") {
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
					<div class="col-sm-12">

						<!-- general form elements disabled -->
						<div class="box box-warning">
							<form action="page_condition_save.php" method="POST">
								<div class="box-header">
									<h3 class="box-title">จำนวนกิจกรรม และจำนวนหน่วย</h3>
								</div>
								<!-- /.box-header -->
								<div class="box-body table-responsive no-padding">
									<table class="table table-bordered table-hover dataTable">
										<thead>
											<tr role="row">
												<th class="center" rowspan="2">ระดับ</th>
												<th class="center" colspan="2">กิจกรรมบังคับ</th>
												<th class="center" colspan="2">กิจกรรมบังคับเลือก</th>
												<th class="center" colspan="6">กิจกรรมเลือกเข้าร่วม</th>
											</tr>
											<tr role="row">
												<td class="center">กิจกรรม</td>
												<td class="center">หน่วย</td>
												<td class="center">กิจกรรม</td>
												<td class="center">หน่วย</td>
												<td class="center">PD (กิจกรรม)</td>
												<td class="center">HD (กิจกรรม)</td>
												<td class="center">AD (กิจกรรม)</td>
												<td class="center">MD (กิจกรรม)</td>
												<td class="center">CD (กิจกรรม)</td>
												<td class="center">รวม 5 ด้าน ไม่น้อยกว่า (หน่วย)</td>
											</tr>
										</thead>
										<tbody>
											<?php
											while ($row_level = $level->fetch()) {
												?>
												<tr>
													<td><b><?php echo($row_level["level_name"]); ?></b></td>
													<td class="center">
														<input type="text" name="event_01[]" value="<?php echo($row_level["event_01"]); ?>" class="uintTextBox">
													</td>
													<td class="center">
														<input type="text" name="unit_01[]" value="<?php echo($row_level["unit_01"]); ?>" class="uintTextBox">
													</td>
													<td class="center">
														<input type="text" name="event_02[]" value="<?php echo($row_level["event_02"]); ?>" class="uintTextBox">
													</td>
													<td class="center">
														<input type="text" name="unit_02[]" value="<?php echo($row_level["unit_02"]); ?>" class="uintTextBox">
													</td>

													<td class="center">
														<input type="text" name="event_03[]" value="<?php echo($row_level["event_03"]); ?>" class="uintTextBox">
													</td>
													<td class="center">
														<input type="text" name="event_04[]" value="<?php echo($row_level["event_04"]); ?>" class="uintTextBox">
													</td>
													<td class="center">
														<input type="text" name="event_05[]" value="<?php echo($row_level["event_05"]); ?>" class="uintTextBox">
													</td>
													<td class="center">
														<input type="text" name="event_06[]" value="<?php echo($row_level["event_06"]); ?>" class="uintTextBox">
													</td>
													<td class="center">
														<input type="text" name="event_07[]" value="<?php echo($row_level["event_07"]); ?>" class="uintTextBox">
													</td>
													<td class="center">
														<input type="text" name="unit_03-07[]" value="<?php echo($row_level["unit_03-07"]); ?>" class="uintTextBox">
													</td>
												</tr>
												<?php
											}
											?>
										</tbody>
									</table>
								</div>
								<div class="col-sm-12">
									<p style="padding-top: 5px;">หมายเหตุ:</p>
									<li>PD หมายถึง ด้านการส่งเสริม และพัฒนาบุคลิกภาพ</li>
									<li>HD หมายถึง ด้านการส่งเสริม และพัฒนาสุขภาพกาย และสุขภาพจิต</li>
									<li>AD หมายถึง ด้านการส่งเสริม และพัฒนาทักษะทางวิชาการหรือวิชาชีพ</li>
									<li>MD หมายถึง ด้านการส่งเสริม และพัฒนาคุณธรรม จริยธรรม ค่านิยม</li>
									<li>CD หมายถึง ด้านการส่งเสริม และอนุรักษ์ศิลปวัฒนธรรม และสิ่งแวดล้อม</li>
								</div>
								<!-- /.box-body -->
								<div class="box-footer" align="center">
									<button type="submit" class="btn btn-success"><i class="fas fa-save"></i> บันทึก</button>
									<button type="reset" class="btn btn-danger"><i class="fas fa-undo"></i> ย้อนกลับ</button>
								</div>
							</form>
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

	<!-- DataTables -->
	<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

	<!-- page script -->
	<script>
		$(function () {
			$('#example1').DataTable({
				"order": [[ 0, "asc" ]],
				"searching": false,
				"language": {
					"sEmptyTable":     "ไม่มีข้อมูลในตาราง",
					"sInfo":           "แสดง _START_ ถึง _END_ จาก _TOTAL_ แถว",
					"sInfoEmpty":      "แสดง 0 ถึง 0 จาก 0 แถว",
					"sInfoFiltered":   "(กรองข้อมูล _MAX_ ทุกแถว)",
					"sInfoPostFix":    "",
					"sInfoThousands":  ",",
					"sLengthMenu":     "แสดง _MENU_ แถว",
					"sLoadingRecords": "กำลังโหลดข้อมูล...",
					"sProcessing":     "กำลังดำเนินการ...",
					"sSearch":         "ค้นหา: ",
					"sZeroRecords":    "ไม่พบข้อมูล",
					"oPaginate": {
						"sFirst":    "หน้าแรก",
						"sPrevious": "<",
						"sNext":     ">",
						"sLast":     "หน้าสุดท้าย"
					},
					"oAria": {
						"sSortAscending":  ": เปิดใช้งานการเรียงข้อมูลจากน้อยไปมาก",
						"sSortDescending": ": เปิดใช้งานการเรียงข้อมูลจากมากไปน้อย"
					}
				}
			})
		})
	</script>

</body>
</html>