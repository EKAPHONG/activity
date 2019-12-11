<?php
// Configuration, please do not edit if you do not understand the system.
use EKAPHONG\XML_RPC;
require_once('../login/class/XML_RPC.php');
require_once('../login/config/config.php');
require_once('../includes/connect.inc.php');
$xmlrpc = new XML_RPC();
// End of configuration

$activity_id = $_POST["activity_id"];
setcookie(cookie_activity_id, $activity_id, time() + (86400)); // 86400 = 1 day
$activity_id = $xmlrpc->getEncrypt($server, $app_id, $secret, $activity_id);

header("Location: index.php?activity_id=$activity_id");