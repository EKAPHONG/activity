<?php
include '../login/config/config.php';
?>
<aside class="main-sidebar">

	<!-- sidebar: style can be found in sidebar.less -->
	<section class="sidebar">

		<!-- Sidebar user panel (optional) -->
		<div class="user-panel">
			<?php
			if (isset($_SESSION["account_username"])) {
				?>
				<div class="pull-left image">
					<img src="images/student-160x160.png" class="img-circle" alt="User Image">
				</div>
				<div class="pull-left info">
					<p><?php echo $_SESSION["account_firstname"] . " " . $_SESSION["account_lastname"]; ?></p>
					<i class="fas fa-network-wired" style="color: #00cc00"></i> <small><?php echo $_SERVER['REMOTE_ADDR']; ?></small>
				</div>
				<?php
			}
			else{
				?>
				<form action="http://service.eng.rmuti.ac.th/eng-login/login/" method="POST">
					<input type="hidden" name="id" value="<?php echo($app_id); ?>">
					<input type="hidden" name="secret" value="<?php echo($secret); ?>">
					<button type="submit" class="btn btn-block btn-warning btn-lg"><i class="fas fa-sign-in-alt"></i> <span>เข้าสู่ระบบ</span></button>
				</form>
				<?php
			}
			?>
			<!-- Status -->
		</div>

		<!-- Sidebar Menu -->
		<ul class="sidebar-menu" data-widget="tree">
			<li class="header">เมนูหลัก</li>
			<!-- Optionally, you can add icons to the links -->

			<li class="<?php echo ($page == 'index') ? 'active':''; ?>"><a href="index.php"><i class="fas fa-home" style="padding: 0px 2px 0px 0px;"></i> <span>หน้าหลัก</span></a></li>

			<?php
			if (isset($_SESSION["account_username"])) {
				?>
				<li class="<?php echo ($page == 'page_profile') ? 'active':''; ?>"><a href="page_profile.php"><i class="fas fa-user" style="padding: 0px 5px 0px 0px;"></i> <span>ข้อมูลส่วนตัว</span></a></li>
				<?php
			}
			?>

			<li class="<?php echo ($page == 'page_activity') ? 'active':''; ?>"><a href="page_activity.php"><i class="fas fa-folder-open" style="padding: 0px 1.5px 0px 0px;"></i> <span>ข้อมูลกิจกรรม</span></a></li>

			<li class="<?php echo ($page == 'page_qrcode') ? 'active':''; ?>"><a href="qrcode/" target="_blank"><i class="fas fa-qrcode" style="padding: 0px 5px 0px 0px;"></i> <span>สร้าง QR Code</span></a></li>

			<?php
			if (isset($_SESSION["account_username"]) AND ($_SESSION["account_type"] == "Students")) {
				?>
				<li class="<?php echo ($page == 'page_checkActivity') ? 'active':''; ?>"><a href="page_checkActivity.php"><i class="far fa-calendar-check" style="padding: 0px 5px 0px 0px;"></i> <span>ตรวจสอบการเข้าร่วมกิจกรรม</span></a></li>
				<?php
			}
			?>

			<li class="<?php echo ($page == 'page_documents') ? 'active':''; ?>"><a href="page_documents.php"><i class="fas fa-file-alt" style="padding: 0px 5px 0px 0px;"></i> <span>เอกสารที่เกี่ยวข้อง</span></a></li>



			<?php
			if ($_SESSION["account_fn_03"] == '1' OR $_SESSION["account_fn_05"] == '1' OR $_SESSION["account_fn_09"] == '1') {
				?>
				<li class="header">เจ้าหน้าที่ฝ่ายบริหารกิจกรรม</li>

				<?php
				if ($_SESSION["account_fn_03"] == '1') {
					?>
					<li class="treeview <?php echo ($page == 'Staff') ? 'active menu-open':''; ?>">
						<a href="#"><i class="fas fa-edit"></i><span> จัดการข้อมูลกิจกรรม</span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<li class="<?php echo ($subPage == 'page_manageActivity') ? 'active':''; ?>"><a href="page_manageActivity.php"><i class="fas fa-clipboard"></i> ข้อมูลกิจกรรม</a></li>
							<li class="<?php echo ($subPage == 'page_addActivity') ? 'active':''; ?>"><a href="page_addActivity.php"><i class="fas fa-plus"></i> เพิ่มข้อมูลกิจกรรม</a></li>
						</ul>
					</li>
					<?php
				}

				if ($_SESSION["account_fn_05"] == '1') {
					?>
					<li class="<?php echo ($page == 'page_searchStudent') ? 'active':''; ?>"><a href="page_searchStudent.php"><i class="fas fa-edit"></i><span> จัดการข้อมูลนักศึกษา</span></a></li>
					<?php
				}
				?>

				<?php
				if ($_SESSION["account_fn_04"] == '1' OR $_SESSION["account_fn_09"] == '1') {
					?>
					<li class="treeview <?php echo ($page == 'Import') ? 'active menu-open':''; ?>">
						<a href="#"><i class="fas fa-edit"></i><span> จัดการผู้เข้าร่วมกิจกรรม</span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<?php
							if ($_SESSION["account_fn_04"] == '1') {
								?>
								<li class="<?php echo ($subPage == 'page_import') ? 'active':''; ?>"><a href="page_import.php"><i class="fas fa-upload"></i> นำเข้ารายชื่อผู้เข้าร่วมกิจกรรม</a></li>
								<?php
							}
							?>
							<?php
							if ($_SESSION["account_fn_09"] == '1') {
								?>
								<li class="<?php echo ($subPage == 'page_manageParticipants') ? 'active':''; ?>"><a href="page_manageParticipants.php"><i class="fas fa-user-minus"></i> ลบรายการผู้เข้าร่วมกิจกรรม</a></li>
								<?php
							}
							?>
						</ul>
					</li>
					<?php
				}
				?>

				<?php
				if ($_SESSION["account_fn_07"] == '1') {
					?>
					<li class="<?php echo ($page == 'page_searchTranscript') ? 'active':''; ?>"><a href="page_searchTranscript.php"><i class="fas fa-print"></i><span> พิมพ์ใบแสดงผลการเข้าร่วมฯ</span></a></li>
					<?php
				}
			}
			?>



			<?php
			if ($_SESSION["account_fn_02"] == '1') {
				?>
				<li class="header">รองคณบดีฝ่ายพัฒนานักศึกษา</li>

				<li class="<?php echo ($page == 'page_approve') ? 'active':''; ?>"><a href="page_approve.php"><i class="fas fa-clipboard-check" style="padding: 0px 2px 0px 0px;"></i> <span>อนุมัติการเข้าร่วมกิจกรรม</span></a></li>
				<?php
			}
			?>

			<?php
			if (isset($_SESSION["account_username"])) {
				?>
				<li class="header">ระบบ</li>
				<?php
			}
			?>

			<?php
				if ($_SESSION["account_fn_01"] == '1' OR $_SESSION["account_fn_08"] == '1') {
					?>
					<li class="treeview <?php echo ($page == 'Setting') ? 'active menu-open':''; ?>">
						<a href="page_permission.php">
							<i class="fas fa-cog" style="padding: 0px 3.5px 0px 0px;"></i><span> ตั้งค่า</span>
							<span class="pull-right-container">
								<i class="fa fa-angle-left pull-right"></i>
							</span>
						</a>
						<ul class="treeview-menu">
							<?php
							if ($_SESSION["account_fn_08"] == '1') {
								?>
								<li class="<?php echo ($subPage == 'page_condition') ? 'active':''; ?>"><a href="page_condition.php"><i class="fas fa-tasks"></i> กำหนดเงื่อนไขการผ่านกิจกรรม</a></li>
								<?php
							}
							?>
							<?php
							if ($_SESSION["account_fn_01"] == '1') {
								?>
								<li class="<?php echo ($subPage == 'page_permission') ? 'active':''; ?>"><a href="page_permission.php"><i class="fas fa-user-cog"></i> จัดการผู้ใช้งานระบบ</a></li>
								<?php
							}
							?>
						</ul>
					</li>
					<?php
				}
				?>

			<?php
			if (isset($_SESSION["account_username"])) {
				?>
				<li><a href="logout/logout.php"><i class="far fas fa-sign-out-alt" style="padding: 0px 3.5px 0px 0px;"></i> <span>ออกจากระบบ</span></a></li>
				<?php
			}
			?>

		</ul>
		<!-- /.sidebar-menu -->
	</section>
	<!-- /.sidebar -->
</aside>