<?php
header('Content-Type: text/html; charset=utf-8');

// Configuration, please do not edit if you do not understand the system.
use EKAPHONG\XML_RPC;
require_once('../login/class/XML_RPC.php');
require_once('../login/config/config.php');
require_once('../includes/connect.inc.php');
$xmlrpc = new XML_RPC();
// End of configuration

$data = $_POST['data'];
list($msg, $oid, $date, $time) = explode(":", $data);

$date	= preg_replace(array("/\./"),'-',$date);

$data	= $xmlrpc->getUserByOid($server, $app_id, $secret, $oid);

$data	= $xmlrpc->ObjectToArray($data);

$account_username	= $data['uid'];
$account_id			= $data['studentId'];
$activity_id		= $_COOKIE['cookie_activity_id'];
$join_date			= $date;

if($con->query("INSERT INTO `joins`(`account_username`, `account_id`, `activity_id`, `join_date`, `join_status`) VALUES ('$account_username','$account_id','$activity_id','$join_date','0')")) {

	$query = $con->query("SELECT a.account_id, a.account_prefix, a.account_firstname, a.account_lastname FROM account a LEFT JOIN joins b ON a.account_id = b.account_id WHERE b.activity_id = '$activity_id' AND b.account_id != '' ORDER BY b.join_id DESC LIMIT 5");

	$resultArray = array();
	while ($result = $query->fetch()) {
		array_push($resultArray,$result);
	}
	echo json_encode($resultArray);
} else {
	echo json_encode(null);
}