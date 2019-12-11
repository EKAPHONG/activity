<?php
session_start();
require 'includes/config.inc.php';
require 'includes/connect.inc.php';
require 'includes/dateThai.inc.php';




if ($_SESSION["account_fn_04"] != '1') {
	header("Location: index.php?alert=fail&permission=invalid");
}

$page     = "Import";
$subPage  = basename($_SERVER['PHP_SELF'], ".php");
$pageName = "นำเข้ารายชื่อผู้เข้าร่วมกิจกรรม";
$pageDescription = "";
$activity_id_no	= $_GET['activity_id'];

$firstYear = date("Y");
$lastYear = (int)date("Y")-10;

if($_GET['term']!=''){
	$term="&& activity_term='".$_GET['term']."'";
}else{
	$term="";
}
if($_GET['year']!=''){
	$year="&& activity_year='".$_GET['year']."'";
}else{
	$year="&& activity_year='".(date("Y"))."'";
}

$activity = $con->query("SELECT activity.*, activity_status.status_name FROM `activity` INNER JOIN activity_status ON activity.activity_status LIKE activity_status.status_id WHERE 1 $term $year ORDER BY `activity_id` DESC");
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
					<!-- <div class="col-md-10 col-md-offset-1"> -->
						<div class="col-md-12">

							<?php
							if (isset($_GET["activity_id"]) && ($_GET["status"]) == "success") {
								$activity_name = $con->query("SELECT `activity_name`, `activity_status` FROM `activity` WHERE `activity_id` = '".$_GET["activity_id"]."'");
								$row_activity_name = $activity_name->fetch();
								?>
								<div class="alert alert-success alert-dismissible">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
									<h4><i class="icon fa fa-check"></i> สำเร็จ!</h4>
									เปลี่ยนสถานะกิจกรรม <b><?php echo($row_activity_name["activity_name"]); ?></b> เรียบร้อยแล้ว
								</div>
								<?php
							}
							?>

							<!-- general form elements disabled -->
							<form action="" method="get">
								<div class="box box-warning">
									<div class="box-header with-border">
										<h3 class="box-title">ค้นหาข้อมูลกิจกรรม</h3>
									</div>
									<!-- /.box-header -->
									<div class="box-body">
										<!-- information -->
										<div class="row">
											<div class="col-md-5">
												<div class="form-group">
													<label>ภาคเรียนที่</label>
													<select class="form-control" name="term">
														<option value="" <?php echo ($_GET["term"] == '' ? 'selected=""':'') ?>>ทั้งหมด</option>
														<option value="1" <?php echo ($_GET["term"] == '1' ? 'selected=""':'') ?>>1</option>
														<option value="2" <?php echo ($_GET["term"] == '2' ? 'selected=""':'') ?>>2</option>
														<option value="3" <?php echo ($_GET["term"] == '3' ? 'selected=""':'') ?>>3</option>
													</select>
												</div>
											</div>
											<div class="col-md-5">
												<div class="form-group">
													<label>ประจำปีการศึกษา</label>
													<select class="form-control" name="year">
														<?php
														for ($i=$firstYear; $i > $lastYear; $i--) {
															echo '<option value='.$i.' '.($_GET["year"] == $i ? 'selected=""':'').'>'.($i+543).'</option>';
														}
														?>
													</select>
												</div>
											</div>
											<div class="col-md-2">
												<button type="submit" class="btn btn-warning btn-block" style="margin-top: 25px"><i class="fas fa-search"></i> ค้นหา</button>
											</div>
										</div>
									</div>
									<!-- /.box-body -->
								</div>
							</form>

							<div class="box box-danger">
								<div class="box-header">
									<h3 class="box-title">รายการข้อมูลกิจกรรม</h3>
								</div>
								<!-- /.box-header -->
								<div class="box-body table-responsive">
									<table id="example1" class="table">
										<thead>
											<tr>
												<th style="text-align: center;" width="12%">รหัสกิจกรรม</th>
												<th style="text-align: center;">ชื่อกิจกรรม</th>
												<th style="text-align: center;" width="5%">หน่วย</th>
												<th style="text-align: center;" width="13%">วันที่จัดกิจกรรม	</th>
												<th style="text-align: center;" width="10%">ภาคเรียน</th>
												<th style="text-align: center;" width="10%">ปีการศึกษา</th>
												<!-- <th style="text-align: center;" width="5%">สถานะ</th> -->
												<th style="text-align: center;" width="10%">ดำเนินการ</th>
											</tr>
										</thead>
										<tbody>
											<?php
											while ($row_activity = $activity->fetch()) {
												?>
												<tr>
													<td style="text-align: right;"><?php echo($row_activity["activity_id"]); ?></td>
													<td><?php echo($row_activity["activity_name"]); ?></td>
													<td style="text-align: center;"><?php echo($row_activity["activity_unit"]); ?></td>
													<td style="text-align: center;"><?php echo thai_date_short(strtotime($row_activity["activity_date"])); ?></td>
													<td style="text-align: center;"><?php echo ($row_activity["activity_term"]); ?></td>
													<td style="text-align: center;"><?php echo ($row_activity["activity_year"]+543) ?></td>
													<!-- <td style="text-align: center;"><a href="page_manageActivity_toggle.php?activity_id=<?php echo($row_activity["activity_id"]); ?>
													&activity_status=<?php echo($row_activity["activity_status"]); ?>
													&term=<?php echo($_GET["term"]); ?>
													&year=<?php echo($_GET["year"]); ?>" data-toggle="tooltip" title="คลิกเพื่อ<?php echo ($row_activity["activity_status"] == '1' ? 'ปิด':'เปิด'); ?>"><?php echo($row_activity["status_name"]) ?></a>
												</td> -->
												<td style="text-align: center;"><a href="page_import2.php?activity_id=<?php echo($row_activity["activity_id"]); ?>"><button type="button" class="btn btn-block btn-warning btn-xs"><i class="fas fa-file-import"></i> นำเข้า</button></a>
												</td>
											</tr>
											<?php
										}
										?>
									</tbody>
								</table>
							</div>
							<!-- /.box-body -->
						</div>
						<!-- /.box -->
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