<?php
// Configuration, please do not edit if you do not understand the system.
use EKAPHONG\XML_RPC;
require_once('../login/class/XML_RPC.php');
require_once('../login/config/config.php');
require_once('../includes/connect.inc.php');
require_once('qrlib.php');
$xmlrpc = new XML_RPC();
// End of configuration

$oid	= isset($_REQUEST['oid']) ? $_REQUEST['oid'] : header("Location: http://service.eng.rmuti.ac.th/eng-login/login/?id=6&secret=SAMS&msg=genQrCode");
if (strlen($oid) != '24') {
	$oid = $xmlrpc->getOid($server, $app_id, $secret, $_REQUEST['uid']);
}
$data	= $xmlrpc->getUserByOid($server, $app_id, $secret, $oid);
$data	= $xmlrpc->ObjectToArray($data);



?>

<!DOCTYPE html>
<html>
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="css/bootstrap.min.css">

	<!-- Font Awesome -->
	<link rel="stylesheet" href="../bower_components/fontawesome-5.4.2/css/all.css">

	<style type="text/css">
		body {
			margin-top: 16px;
		}
	</style>

	<title>Receive QRCode: Success</title>
</head>
<body>

	<div class="container">
		<div class="col-md-4 offset-md-4 text-center" style="margin-bottom: 20px;">
			<?php echo '<img class="img-fluid" src="qrgen.php?oid='.$oid.'" />'; ?>
		</div>

		<div class="alert alert-primary col-md-4 offset-md-4 text-center" role="alert">
			<b><?php echo $data["cn"] . " " . $data["sn"] ?></b><br>
			<?php echo "Date: " . date("Y.m.d") . "&nbsp;&nbsp;Time: " . date("H.i.s") ?>
		</div>

		<div class="col-md-4 offset-md-4" style="padding-right: 0px; padding-left: 0px; padding-bottom: 16px;">
			<form method="POST">
				<input type="hidden" name="uid" value="<?php echo $data["uid"] ?>">
				<button type="submit" class="btn btn-primary btn-lg btn-block"><i class="fas fa-sync-alt"></i> Press to get QR Code</button>
			</form>
		</div>
	</div>

	<!-- Optional JavaScript -->
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<script src="js/jquery-3.3.1.slim.min.js"></script>
	<script src="js/popper.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
</body>
</html>