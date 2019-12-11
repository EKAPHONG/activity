<?php
session_start();
require 'includes/config.inc.php';
require 'includes/connect.inc.php';
require 'includes/dateThai.inc.php';

if ($_SESSION["account_fn_02"] != '1') {
	header("Location: 404.php?alert=danger&permission=invalid");
}

$page     = basename($_SERVER['PHP_SELF'], ".php");
$pageName = "รายละเอียดการเข้าร่วมกิจกรรม";
$pageDescription = "";

$activity = $con->query("SELECT * FROM `activity` WHERE `activity_id` LIKE '".$_GET["activity_id"]."'");
$row_activity = $activity->fetch();

$joins = $con->query("SELECT joins.account_id, account.account_prefix, account.account_firstname, account.account_lastname, level.level_name, account.account_department, joins.join_status FROM `joins` LEFT JOIN account ON joins.account_id = account.account_id INNER JOIN level ON account.level_id = level.level_id WHERE `activity_id` LIKE '".$_GET["activity_id"]."'");
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo(_TITLE); ?> | <?php echo($pageName); ?></title>
	<!-- Load stylesheet -->
	<?php require_once('includes/stylesheet.inc.php'); ?>
	<!-- DataTables -->
	<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
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
						if (($_GET["activity_id"]) AND ($_GET["status"] == "success")) {
							?>
							<div class="alert alert-success alert-dismissible">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<h4><i class="icon fa fa-check"></i> สำเร็จ!</h4>
								ดำเนินการเรียบร้อยแล้ว
							</div>
							<?php
						}
						?>

						<form action="" method="get">
							<div class="box box-warning">
								<div class="box-header with-border">
									<h3 class="box-title">ข้อมูลกิจกรรม</h3>
								</div>
								<!-- /.box-header -->
								<div class="box-body">
									<!-- information -->
									<div class="row">
										<div class="col-md-4">
											<b>รหัสกิจกรรม : </b><?php echo $row_activity["activity_id"]; ?>
										</div>
										<div class="col-md-8">
											<b>ชื่อกิจกรรม : </b><?php echo $row_activity["activity_name"]; ?>
										</div>
										<div class="col-md-4">
											<b>หน่วยกิจกรรม : </b><?php echo $row_activity["activity_unit"]; ?> หน่วย
										</div>
										<div class="col-md-4">
											<b>วันที่จัดกิจกรรม : </b><?php echo thai_date_thaiyear(strtotime($row_activity["activity_date"])); ?>
										</div>
										<div class="col-md-4">
											<b>ภาคเรียน/ปีการศึกษา : </b><?php echo $row_activity["activity_term"] . "/" . ($row_activity["activity_year"]+543); ?>
										</div>
									</div>
								</div>
								<!-- /.box-body -->
							</div>

							<div class="box box-danger">
								<div class="box-header">
									<h3 class="box-title">รายชื่อผู้เข้าร่วมกิจกรรม</h3>
								</div>
								<!-- /.box-header -->
								<div class="box-body table-responsive">
									<table id="example1" class="table">
										<thead>
											<tr>
												<th style="text-align: center;">รหัสนักศึกษา</th>
												<th style="text-align: center;">ชื่อ-สกุล</th>
												<th style="text-align: center;">ระดับ</th>
												<th style="text-align: center;">สาขาวิชา</th>
												<th style="text-align: center;">สถานะ</th>
											</tr>
										</thead>
										<tbody>
											<?php
											while ($row_joins = $joins->fetch()) {
												?>
												<tr>
													<td style="text-align: right;"><?php echo($row_joins["account_id"]); ?></td>
													<td><?php echo $row_joins["account_prefix"] . $row_joins["account_firstname"] . " " . $row_joins["account_lastname"] ?></td>
													<td style="text-align: center;"><?php echo($row_joins["level_name"]); ?></td>
													<td style="text-align: center;"><?php echo($row_joins["account_department"]); ?></td>
													<td style="text-align: center;"><?php echo($row_joins["join_status"] == 1 ? "<i class='fas fa-check' style='color: green;'></i> อนุมัติแล้ว" : "<i class='fas fa-minus' style='color: red;'></i> รออนุมัติ"); ?></td>
												</tr>
												<?php
											}
											?>
										</tbody>
									</table>
									<a href="page_approve_toggle.php<?php echo '?activity_id=' . $_GET["activity_id"] . '&status=approve'; ?>"><button type="button" class="btn btn-success"><i class="fas fa-check"></i> อนุมัติทั้งหมด</button></a>
									<a href="page_approve_toggle.php<?php echo '?activity_id=' . $_GET["activity_id"] . '&status=cancel'; ?>"><button type="button" class="btn btn-danger"><i class="fas fa-times"></i> ยกเลิกทั้งหมด</button></a>
									<?php
									if ($_SESSION["account_fn_06"] == '1') {
										?>
										<!-- <button type="button" class="btn btn-info pull-right"><i class="fas fa-print"></i> พิมพ์</button> -->
										<?php
									}
									?>
								</div>
								<!-- /.box-body -->
							</div>
							<!-- /.box -->
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

	<!-- Tooltips -->
	<script type="text/javascript">
		$(document).ready(function(){
			$('[data-toggle="tooltip"]').tooltip();   
		});
	</script>

	<!-- DataTables -->
	<script src="bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

	<!-- DataTable -->
	<script>
		$(function () {
			$('#example1').DataTable({
				"order": [[ 0, "desc" ]],
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