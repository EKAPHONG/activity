<?php
session_start();
require 'includes/config.inc.php';
require 'includes/connect.inc.php';

if ($_SESSION["account_fn_05"] != '1') {
	header("Location: index.php?alert=fail&permission=invalid");
}

$page     = basename($_SERVER['PHP_SELF'], ".php");
$pageName = "จัดการข้อมูลนักศึกษา";
$pageDescription = "";

// $keyword = htmlspecialchars($_GET["keyword"], ENT_QUOTES);
// $keywords = htmlspecialchars(explode(" ", $_GET["keyword"], ENT_QUOTES));

$keyword = $_GET["keyword"];
$keywords = explode(" ", $_GET["keyword"]);

if($_GET["department"]!=''){
	$department_key="AND account_department LIKE '".$_GET["department"]."'";
}else{
	$department_key="";
}

$department = $con->query("SELECT `account_department` FROM `account` WHERE `account_department` != '' GROUP BY account_department");
if (isset($keyword)) {
	$student = $con->query("SELECT `account_id`, `account_prefix`, `account_firstname`, `account_lastname`, `account_faculty`, `account_department` FROM `account` WHERE `account_id` != '' AND 
		(`account_id` LIKE '%$keyword%' OR 
		`account_firstname` LIKE '%$keyword%' OR
		`account_lastname` LIKE '%$keyword%' OR
		(`account_firstname` LIKE '%$keywords[0]%' AND `account_lastname` LIKE '%$keywords[1]%'))
		$department_key
		");
	$count = $student->rowCount();
}

if ($count == 1) {
	$resualt = $student->fetch();
	header("Location: page_editStudent.php?account_id=" . $resualt["account_id"] . "");
}
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
						if (!isset($_GET["keyword"])) {
							?>
							<div class="alert alert-info alert-dismissible">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<h4><i class="icon fa fa-info"></i> คำแนะนำ</h4>
								สามารถค้นหาได้จาก รหัสนักศึกษา หรือ ชื่อ สกุล (ไม่ต้องระบุคำนำหน้า)
							</div>
							<?php
						}
						?>

						<!-- general form elements disabled -->
						<form action="" method="get">
							<div class="box box-warning">
								<div class="box-header with-border">
									<h3 class="box-title">ค้นหาข้อมูลนักศึกษา</h3>
								</div>
								<!-- /.box-header -->
								<div class="box-body">
									<!-- information -->
									<div class="row">

										<div class="col-md-6">
											<label>คำค้นหา</label>
											<input type="text" class="form-control" name="keyword" required="" placeholder="รหัสนักศึกษา / ชื่อ สกุล (ไม่ต้องระบุคำนำหน้า)" value="<?php echo($keyword) ?>">
										</div>

										<div class="col-md-4">
											<div class="form-group">
												<label>สาขาวิชา</label>
												<select class="form-control" name="department">
													<option value="" <?php echo ($_GET["department"] == '' ? 'selected=""':'') ?>>ทั้งหมด</option>
													<?php
													while ($row_department = $department->fetch()) {
														echo "<option value='" . $row_department["account_department"] . "' " . ($row_department["account_department"] == $_GET["department"] ? 'selected=""':'') . ">" . $row_department["account_department"] . "</option>";
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

						<?php
						if (isset($keyword)) {
							?>
							<div class="box">
								<div class="box-header">
									<h3 class="box-title">ผลการค้นหา</h3>
								</div>
								<!-- /.box-header -->
								<div class="box-body table-responsive">
									<table id="example1" class="table table-striped">
										<thead>
											<tr>
												<th style="text-align: center;">รหัสนักศึกษา</th>
												<th style="text-align: center;">ชื่อ - สกุล</th>
												<th style="text-align: center;">คณะ</th>
												<th style="text-align: center;">สาขาวิชา</th>
												<th style="text-align: center;" width="10%">ดำเนินการ</th>
											</tr>
										</thead>
										<tbody>
											<?php
											while ($row_student = $student->fetch()) {
												?>
												<tr>
													<td><?php echo($row_student["account_id"]) ?></td>
													<td><?php echo $row_student["account_prefix"] . $row_student["account_firstname"] ." " . $row_student["account_lastname"] ?></td>
													<td><?php echo($row_student["account_faculty"]) ?></td>
													<td><?php echo($row_student["account_department"]) ?></td>
													<td><a href="page_editStudent.php?account_id=<?php echo($row_student["account_id"]) ?>"><button type="button" class="btn btn-block btn-warning btn-xs"><i class="fas fa-edit"></i> แก้ไข</button></a></td>
												</tr>
												<?php
											}
											?>
										</tr>
									</tbody>
								</table>
							</div>
							<!-- /.box-body -->
						</div>
						<!-- /.box -->
						<?php
					}
					?>
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