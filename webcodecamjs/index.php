<?php
// Configuration, please do not edit if you do not understand the system.
use EKAPHONG\XML_RPC;
require_once('../login/class/XML_RPC.php');
require_once('../login/config/config.php');
require_once('../includes/connect.inc.php');
$xmlrpc = new XML_RPC();
// End of configuration

$activity_id = $xmlrpc->getDecrypt($server, $app_id, $secret, $_GET["activity_id"]);

$activity = $con->query("SELECT activity_id, activity_name, activity_unit FROM activity WHERE activity_id = '$activity_id'");
$row_activity = $activity->fetch();
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<title>WebCodeCamJS</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet">
	<!-- Google Font -->
	<link href="https://fonts.googleapis.com/css?family=Prompt:300,300i,400,400i,600,600i,700&amp;subset=thai"
		rel="stylesheet">
	<style>
		body {
			font-family: 'Prompt', sans-serif;
		}
	</style>
</head>

<body>
	<div class="container" id="QR-Code">
		<div class="panel panel-info">
			<div class="panel-heading">
				<div class="navbar-form navbar-left">
					<h4>ระบบตรวจรับการลงชื่อเข้าร่วมกิจกรรม</h4>
				</div>
				<div class="navbar-form navbar-right">
					<select class="form-control" id="camera-select"></select>
					<!-- <div class="form-group">
						<input id="image-url" type="text" class="form-control" placeholder="Image url">
						<button title="Decode Image" class="btn btn-default btn-sm" id="decode-img" type="button"
							data-toggle="tooltip"><span class="glyphicon glyphicon-upload"></span></button>
						<button title="Image shoot" class="btn btn-info btn-sm disabled" id="grab-img" type="button"
							data-toggle="tooltip"><span class="glyphicon glyphicon-picture"></span></button>
						<button title="Play" class="btn btn-success btn-sm" id="play" type="button"
							data-toggle="tooltip"><span class="glyphicon glyphicon-play"></span></button>
						<button title="Pause" class="btn btn-warning btn-sm" id="pause" type="button"
							data-toggle="tooltip"><span class="glyphicon glyphicon-pause"></span></button>
						<button title="Stop streams" class="btn btn-danger btn-sm" id="stop" type="button"
							data-toggle="tooltip"><span class="glyphicon glyphicon-stop"></span></button>
					</div> -->
				</div>
			</div>
			<div class="panel-body text-center">
				<div class="col-md-1"></div>
				<div class="col-md-10">
					<div class="alert alert-info" role="alert">
						<b>ข้อมูลกิจกรรม</b>
						<br><b>รหัสกิจกรรม: </b><?php echo($row_activity["activity_id"]); ?>
						<br><b>ชื่อกิจกรรม: </b><?php echo($row_activity["activity_name"]); ?> (<?php echo($row_activity["activity_unit"]); ?> หน่วย)
					</div>
				</div>
				<div class="col-md-1"></div>
				<div class="col-md-6">
					<div class="well" style="position: relative;display: inline-block;">
						<canvas width="500" height="340" id="webcodecam-canvas"></canvas>
						<div class="scanner-laser laser-rightBottom" style="opacity: 0.5;"></div>
						<div class="scanner-laser laser-rightTop" style="opacity: 0.5;"></div>
						<div class="scanner-laser laser-leftBottom" style="opacity: 0.5;"></div>
						<div class="scanner-laser laser-leftTop" style="opacity: 0.5;"></div>
					</div>
					<div class="well" style="width: 70%;">
						<label id="zoom-value" width="100">Zoom: 2</label>
						<input id="zoom" onchange="Page.changeZoom();" type="range" min="10" max="30" value="20">
						<label id="brightness-value" width="100">Brightness: 0</label>
						<input id="brightness" onchange="Page.changeBrightness();" type="range" min="0" max="128"
							value="0">
						<label id="contrast-value" width="100">Contrast: 0</label>
						<input id="contrast" onchange="Page.changeContrast();" type="range" min="0" max="64" value="0">
						<label id="threshold-value" width="100">Threshold: 0</label>
						<input id="threshold" onchange="Page.changeThreshold();" type="range" min="0" max="512"
							value="0">
						<label id="sharpness-value" width="100">Sharpness: off</label>
						<input id="sharpness" onchange="Page.changeSharpness();" type="checkbox">
						<label id="grayscale-value" width="100">grayscale: off</label>
						<input id="grayscale" onchange="Page.changeGrayscale();" type="checkbox">
						<br>
						<label id="flipVertical-value" width="100">Flip Vertical: off</label>
						<input id="flipVertical" onchange="Page.changeVertical();" type="checkbox">
						<label id="flipHorizontal-value" width="100">Flip Horizontal: off</label>
						<input id="flipHorizontal" onchange="Page.changeHorizontal();" type="checkbox">
					</div>
				</div>
				<div class="col-md-6">
					<div class="thumbnail" id="result">
						<div class="well" style="overflow: hidden;">
							<img width="500" height="340" id="scanned-img" src="">
						</div>
						<div class="caption">
							<h3>Scanned result</h3>
							<p id="scanned-QR"></p>
							<table id="student-data" class="table table-striped">
								<tbody>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
		<script type="text/javascript" src="js/filereader.js"></script>
		<!-- Using jquery version: -->

		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/qrcodelib.js"></script>
		<script type="text/javascript" src="js/webcodecamjquery.js"></script>
		<script type="text/javascript" src="js/mainjquery.js"></script>

		<!-- <script type="text/javascript" src="js/qrcodelib.js"></script>
        <script type="text/javascript" src="js/webcodecamjs.js"></script>
        <script type="text/javascript" src="js/main.js"></script> -->
</body>

</html>