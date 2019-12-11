<?php
session_start();

require_once('includes/checkLogin.inc.php');

require 'includes/config.inc.php';
require 'includes/connect.inc.php';
require 'includes/dateThai.inc.php';

$check1 = 0;
$check2 = 0;
$check3 = 0;

$page     = basename($_SERVER['PHP_SELF'], ".php");
$pageName = "ตรวจสอบการเข้าร่วมกิจกรรม";
$pageDescription = "";

if (($_SESSION["account_fn_02"] == '1') && isset($_GET["account_id"])) {
	$level		= $con->query("SELECT A.* FROM level A LEFT JOIN account B ON A.level_id = B.level_id WHERE B.account_id = '".$_GET["account_id"]."'");
	$row_level	= $level->fetch();
}
else{
	$level		= $con->query("SELECT * FROM `level` WHERE `level_id` = '".$_SESSION["level_id"]."'");
	$row_level	= $level->fetch();
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
							if (($_SESSION["account_fn_02"] == '1') && isset($_GET["account_id"])) {
								// $level		= $con->query("SELECT A.* FROM level A LEFT JOIN account B ON A.level_id = B.level_id WHERE B.account_id = '".$_GET["account_id"]."'");
								// $row_level	= $level->fetch();
						
								$info		= $con->query("SELECT `account_id`, `account_prefix`, `account_firstname`, `account_lastname`, `account_degree`, `account_faculty`, `level_id`, `account_department` FROM `account` WHERE `account_id` = '".$_GET["account_id"]."'");
								$row_info	= $info->fetch();
						
								if ($row_info) {
									?>
									<div class="callout callout-info">
									<h4><i class="fas fa-info"></i> ข้อมูลนักศึกษา</h4>
									<p>
									ชื่อ-สกุล: <?php echo $row_info["account_prefix"] . " " . $row_info["account_firstname"] . " " . $row_info["account_lastname"] ?><br />
									คณะ: <?php echo $row_info["account_faculty"] . " (" . $row_info["account_department"] . ")" ?>
									</p>
									</div>
									<?php
								}
								else {
									?>
									<div class="alert alert-warning alert-dismissible">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
									<h4><i class="fas fa-exclamation-triangle"></i> ผิดพลาด!</h4>
									ไม่พบรหัสนักศึกษา โปรดตรวจสอบรหัสนักศึกษาอีกครั้ง
									</div>
									<?php
								}
							}
						?>

						<?php
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
										<th width="15%">
											<center>รหัสกิจกรรม</center>
										</th>
										<th>
											<center>ชื่อกิจกรรม</center>
										</th>
										<th width="5%">
											<center>หน่วย</center>
										</th>
										<th width="10%">
											<center>ภาคเรียนที่</center>
										</th>
										<th width="20%">
											<center>การประเมิน</center>
										</th>
									</tr>
									<?php

												$type_id = $row_activity_type['type_id'];

												if (isset($_GET["account_id"]) && $_SESSION["account_fn_07"] == '1') {
													$activity = $con->query("SELECT DISTINCT activity.activity_id, activity.activity_name, activity.activity_unit, activity.activity_term, activity.activity_year, activity.activity_type, joins.account_id, joins.join_status FROM `joins` INNER JOIN activity ON joins.activity_id = activity.activity_id WHERE `activity_type` = $type_id &&  joins.account_id = '". $_GET["account_id"] ."'");
												}

												else {
													$activity = $con->query("SELECT DISTINCT activity.activity_id, activity.activity_name, activity.activity_unit, activity.activity_term, activity.activity_year, activity.activity_type, joins.account_id, joins.join_status FROM `joins` INNER JOIN activity ON joins.activity_id = activity.activity_id WHERE `activity_type` = $type_id && (joins.account_username = '". $_SESSION["account_username"] ."' OR joins.account_id = '". $_SESSION["account_id"] ."')");
												}

												$count = $activity->rowCount();
												if ($count) {
													$unit[$type_id] = 0;
													$value[$type_id] = 0;
													while ($row_activity = $activity->fetch()) {
														?>
									<tr>
										<td width="15%">
											<center><?php echo($row_activity['activity_id']) ?></center>
										</td>
										<td><i class="fas fa-caret-right"></i>
											<?php echo($row_activity['activity_name']) ?></td>
										<td width="5%">
											<center><?php echo($row_activity['activity_unit']) ?></center>
										</td>
										<td width="10%">
											<center>
												<?php echo $row_activity['activity_term'] . " / " . ($row_activity['activity_year']+543) ?>
											</center>
										</td>
										<td width="20%">
											<center>
												<?php echo ($row_activity['join_status'] == "0" ? "<i class='fas fa-minus' style='color: red'></i> รอการอนุมัติ" : "<i class='fas fa-check' style='color: green'></i> อนุมัติแล้ว") ?>
											</center>
										</td>
									</tr>
									<?php
														if ($row_activity['join_status'] != 0) {
															$unit[$type_id] += $row_activity['activity_unit'];
															$value[$type_id]++;
														}

														if ($row_activity['join_status'] == 0) {
															$count--;
														}

														if (strstr($row_activity['activity_name'],"ปฐมนิเทศนักศึกษา") ){ $check1 = 1; }
														if (strstr($row_activity['activity_name'],"ปัจฉิมนิเทศนักศึกษา") ){ $check2 = 1; }
														if (strstr($row_activity['activity_name'],"อบรมพัฒนาคุณธรรมจริยธรรม") ){ $check3 = 1; }
														$count_act[$type_id] = $count;
													}
													?>
									<tr>
										<td colspan="5">
											<center><b>กิจกรรมที่อนุมัติการเข้าร่วม : <?php echo($count) ?>
													กิจกรรม&nbsp;&nbsp;&nbsp;จำนวนหน่วย : <?php echo($unit[$type_id]) ?>
													หน่วย</b></center>
										</td>
									</tr>
									<?php
												}
												else{
													?>
									<tr>
										<td colspan="5">
											<center>ไม่มีข้อมูล</center>
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
					<?php
								}
								?>

					<!-- general form elements disabled -->
					<div class="box box-warning">
						<div class="box-header with-border">
							<h3 class="box-title"><i class="fas fa-poll-h" style="color: orange"></i>
								ผลการเข้าร่วมกิจกรรม</h3>
						</div>
						<!-- information -->
						<center>
							<h4><b>เงื่อนไขการผ่านกิจกรรม</b></h4>
						</center>
						<p align="center">ระดับ: <?php echo($row_level['level_name']) ?></p>
						<!-- /.box-header -->
						<div class="box-body table-responsive no-padding">
							<table class="table">
								<tbody>
									<tr>
										<th>
											<center>ประเภท</center>
										</th>
										<th>
											<center>ได้รับ (หน่วย)</center>
										</th>
										<th>
											<center>ต้องการ (หน่วย)</center>
										</th>
										<th>
											<center>ผลการเข้าร่วม</center>
										</th>
									</tr>

									<?php
												$i = 1;
												$activity_type = $con->query("SELECT * FROM `activity_type`");
												while ($row_activity_type	= $activity_type->fetch()) {
													?>
									<tr>
										<td><?php echo($row_activity_type["type_name"]) ?></td>
										<td>
											<center><?php echo (isset($unit[$i]) ? $unit[$i] : '0') ?></center>
										</td>
										<?php
														if ($row_activity_type["type_id"] == "1") {
															echo "<td><center>" . $row_level["unit_01"] . "</center></td>";
														}
														elseif ($row_activity_type["type_id"] == "2") {
															echo "<td><center>" . $row_level["unit_02"] . "</center></td>";
														}
														elseif ($i == 3) {
															echo "<td rowspan='5' style='vertical-align : middle;text-align:center;'><center>ด้านละไม่น้อยกว่า " . $row_level["event_03"] . " กิจกรรม<br>รวม 5 ด้าน<br>ไม่น้อยกว่า " . $row_level["unit_03-07"] . " หน่วย</center></td>";
														}
														?>
										<td>
											<center>
												<?php
															// ตรวจสอบเงื่อนไข กิจกรรมบังคับ
															if ($i == 1) {
																if ($count_act[1] >= $row_level["event_01"] && $unit[1] >= $row_level["unit_01"] && $check1 != 0 && $check2 != 0 && $check3 != 0) {
																	echo "<font color='Green'><b>ผ่าน</b></font>";
																}
																else{
																	echo "<font color='Red'><b>ยังไม่ผ่าน</b></font>";
																}
															}

															// ตรวจสอบเงื่อนไข กิจกรรมบังคับเลือก
															elseif ($i == 2) {
																if ($count_act[2] >= $row_level["event_02"] && $unit[2] >= $row_level["unit_02"]) {
																	echo "<font color='Green'><b>ผ่าน</b></font>";
																}
																else{
																	echo "<font color='Red'><b>ยังไม่ผ่าน</b></font>";
																}
															}

															// ตรวจสอบเงื่อนไข กิจกรรมเลือกเข้าร่วม
															else {
																if ($count_act[$i] >= $row_level["event_0$i"]) {
																	echo "<font color='Green'><b>ผ่าน</b></font>";
																}
																else{
																	echo "<font color='Red'><b>ยังไม่ผ่าน</b></font>";
																}
															}
															?>
											</center>
										</td>
									</tr>
									<?php
													$i++;
												}
												?>
									<tr>
										<td colspan='5'>
											<i>ต้องเข้าร่วมกิจกรรมปฐมนิเทศ, อบรมพัฒนาคุณธรรมจริยธรรมนักศึกษา
												และปัจฉิมนิเทศ โดยถือเป็นกิจกรรมบังคับ</i><br>
											<b>สรุปผลการเข้าร่วมกิจกรรม:</b><br>
											<?php
														$checkAll = 0;
														if($check1 == 0){
															echo "<font color='Red'><b>ยังไม่ผ่าน เนื่องจากกิจกรรมบังคับของคุณยังไม่ผ่านกิจกรรมปฐมนิเทศ</b></font><br>";
															$checkAll = 1;
														}
														if($check2 == 0){
															echo "<font color='Red'><b>ยังไม่ผ่าน เนื่องจากกิจกรรมบังคับของคุณยังไม่ผ่านกิจกรรมปัจฉิมนิเทศ</b></font><br>";
															$checkAll = 1;
														}
														if($check3 == 0){
															echo "<font color='Red'><b>ยังไม่ผ่าน เนื่องจากกิจกรรมบังคับของคุณยังไม่ผ่านกิจกรรมอบรมพัฒนาคุณธรรมจริยธรรมนักศึกษา</b></font><br>";
															$checkAll = 1;
														}
														if($count_act[1] < $row_level["event_01"] || $unit[1] <= $row_level["unit_01"]){
															echo "<font color='Red'><b>ยังไม่ผ่าน เนื่องจากกิจกรรมบังคับ ต้องเข้าร่วมอย่างน้อย " .$row_level["event_01"]. " กิจกรรม และ มากกว่า " .$row_level["unit_01"]. " หน่วยกิจกรรม</b></font><br>";
															$checkAll = 1;
														}
														if($count_act[2] < $row_level["event_02"] || $unit[2] <= $row_level["unit_02"]){
															echo "<font color='Red'><b>ยังไม่ผ่าน เนื่องจากกิจกรรมบังคับเลือก ต้องเข้าร่วมอย่างน้อย " .$row_level["event_02"]. " กิจกรรม และ มากกว่า " .$row_level["unit_02"]. " หน่วยกิจกรรม</b></font><br>";
															$checkAll = 1;
														}
														if(
															($unit[3]+$unit[4]+$unit[5]+$unit[6]+$unit[7]) < $row_level["unit_03-07"]
															|| $value[3] < $row_level["event_03"]
															|| $value[4] < $row_level["event_04"]
															|| $value[5] < $row_level["event_05"]
															|| $value[6] < $row_level["event_06"]
															|| $value[7] < $row_level["event_07"]
														){
															echo "<font color='Red'><b>ยังไม่ผ่าน เนื่องจากกิจกรรมเลือกเข้าร่วม (PD, HD, AD, MD และ CD) ต้องเข้าร่วมอย่างน้อยด้านละ " .$row_level["event_03"]. " กิจกรรม และ มากกว่า " .$row_level["unit_03-07"]. " หน่วยกิจกรรม</b></font>";
															$checkAll = 1;
														}

														if ($checkAll == 0) {
															echo "<font color='Green'><b>ผ่านกิจกรรมตลอดหลักสูตรที่ศึกษา ติดต่อฝ่ายพัฒนานักศึกษา เพื่อขอใบแสดงผลการเข้าร่วมกิจกรรม</b></font>";
														}
														?>
										</td>
									</tr>
								</tbody>
							</table>
							<!-- /.box-body -->
						</div>
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

</body>

</html>