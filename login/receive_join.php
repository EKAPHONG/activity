<?php
session_start();

require '../includes/connect.inc.php';

// Configuration, please do not edit if you do not understand the system.
use EKAPHONG\XML_RPC;
require_once(__DIR__ . '/class/XML_RPC.php');
require_once(__DIR__ . '/config/config.php');
$xmlrpc = new XML_RPC();
// End of configuration

$encrypt	= $_GET["encrypt"];
$attribs	= $_GET["attribs"];
$msg		= $_GET["msg"];

list($msg, $oid, $date, $time) = explode(":", $msg);

echo '$msg : ' . $msg . "<br>";
echo '$oid : ' . $oid . "<br>";
echo '$date : ' . $date . "<br>";
echo '$time : ' . $time . "<br>";
echo "<hr>";
echo "<br>";

$data	= $xmlrpc->getUserByOid($server, $app_id, $secret, $oid);

// $data	= $xmlrpc->getOid($server, $app_id, $secret, "ekaphong.ta");

print_r($data);

echo "<br>";
echo "<hr>";
echo "<br>";

$data	= $xmlrpc->ObjectToArray($data);

if ($data) {
	print_r($data);
	// var_dump($data);
	echo "<hr>";
	echo "lastModifiedDate : " . $xmlrpc->convertTime($data['lastModifiedDate']) . "<br>";
	echo "expireAt : " . $xmlrpc->convertTime($data['expireAt']) . "<br>";
}
else{
	echo "Error: Object ID is expired.";
}