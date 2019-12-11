<?php
session_start();
require 'includes/config.inc.php';
require 'includes/connect.inc.php';
require 'includes/dateThai.inc.php';

if ($_SESSION["account_fn_05"] != '1') {
	header("Location: 404.php?alert=danger&permission=invalid");
}

$level_id			=	$_POST["level_id"];
$account_id			=	$_POST["account_id"];
$account_birthday	=	convert_format($_POST["account_birthday"]);
$account_address	=	$_POST["account_address"];
$account_mobile		=	$_POST["account_mobile"];
$account_email		=	$_POST["account_email"];
$account_facebook	=	explode("&",preg_replace(array('/http:\/\//', '/https:\/\//', '/www.facebook.com\//', '/m.facebook.com\//', '/facebook.com\//', '/\//', '/\\\/'),'',$_POST["account_facebook"]));
$account_lineID		=	strtolower($_POST["account_lineID"]);

$con->query("UPDATE `account` SET 
	`level_id`='$level_id',
	`account_birthday`='$account_birthday',
	`account_address`='$account_address',
	`account_email`='$account_email',
	`account_mobile`='$account_mobile',
	`account_facebook`='$account_facebook[0]',
	`account_lineID`='$account_lineID' 
	WHERE account_id = '$account_id'");

header("Location: page_editStudent.php?account_id=$account_id&alerts=success&msg=complete");