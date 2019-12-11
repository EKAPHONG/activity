<?php
session_start();
require 'includes/config.inc.php';
require 'includes/connect.inc.php';
require 'includes/dateThai.inc.php';

$page     = basename($_SERVER['PHP_SELF'], ".php");
$pageName = "ข้อมูลกิจกรรม";
$pageDescription = "";

$firstYear = date("Y");
$lastYear = (int)date("Y")-10;
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo(_TITLE); ?> | <?php echo($pageName); ?></title>
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
						if (!isset($_GET["term"])) {
							?>
							<div class="alert alert-info alert-dismissible">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
								<h4><i class="icon fa fa-info"></i> คำแนะนำ</h4>
								โปรดเลือกภาคเรียน และปีการศึกษา
							</div>
							<?php
						}
						?>

						<!-- general form elements disabled -->
						<form action="page_activity.php" method="get">
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
                        	// echo '<option value='.$i.'>'.($i+543).'</option>';
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

						<?php
						if (isset($_GET["term"])) {
							$activity_type = $con->query("SELECT * FROM `activity_type` ORDER BY `activity_type`.`type_id` ASC");
							while ($row_activity_type = $activity_type->fetch()) {
								if ($row_activity_type['type_id'] == '1') {
									echo "<div class='box box-danger'>";
								}
								elseif ($row_activity_type['type_id'] == '2') {
									echo "<div class='box' style='border-top-color: #D81B60'>";
								}
								else{
									echo "<div class='box box-info'>";
								}
								?>
								<!-- <div class='box box-danger'> -->
									<div class="box-header">
										<h3 class="box-title">
											<?php
											if ($row_activity_type['type_id'] == '1') {
												echo "<i class='fas fa-flag' style='color: #D33724'></i>";
											}
											elseif ($row_activity_type['type_id'] == '2') {
												echo "<i class='fas fa-flag' style='color: #CA195A'></i>";
											}
											else{
												echo "<i class='fas fa-flag' style='color: #00A7D0'></i>";
											}
											?>
											<?php echo($row_activity_type['type_name']); ?></h3>
										</div>
										<div class="box-body table-responsive no-padding">
											<table class="table table-hover">
												<tbody>
													<tr>
														<th><center>รหัสกิจกรรม</center></th>
														<th><center>ชื่อกิจกรรม</center></th>
														<th><center>หน่วย</center></th>
														<th><center>วันที่จัดกิจกรรม</center></th>
													</tr>
													<?php
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

													$type_id = $row_activity_type['type_id'];

													$activity = $con->query("SELECT * FROM `activity` WHERE `activity_type` = $type_id $term $year");
													$count = $activity->rowCount();
													if ($count) {
														while ($row_activity = $activity->fetch()) {
															?>
															<tr>
																<td width="20%"><center><?php echo($row_activity['activity_id']) ?></center></td>
																<td><i class="fas fa-caret-right"></i> <?php echo($row_activity['activity_name']) ?></td>
																<td width="10%"><center><?php echo($row_activity['activity_unit']) ?></center></td>
																<td width="20%"><center><?php echo thai_date_thaiyear(strtotime($row_activity['activity_date'])) ?></center></td>
															</tr>
															<?php
														}
													}
													else{
														?>
														<tr>
															<td colspan="4"><center>ไม่มีข้อมูล</center></td>
														</tr>
														<?php
													}                       
													?>
												</tbody></table>
											</div>
											<!-- /.box-body -->
										</div>
										<?php
            } # END WHILE
          }
          ?>
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

</body>
</html>