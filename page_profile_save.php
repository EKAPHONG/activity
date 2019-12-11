<?php
session_start();
require 'includes/config.inc.php';
require 'includes/connect.inc.php';

$page     = basename($_SERVER['PHP_SELF'], ".php");
$pageName = "ยืนยันข้อมูลส่วนตัว";
$pageDescription = "";

$level_id			=	$_POST["level_id"];
$account_birthday	=	date("Y-m-d", strtotime(str_replace('/', '-', $_POST["account_birthday"])));
$account_address	=	htmlspecialchars($_POST["account_address"], ENT_QUOTES);
$account_mobile		=	htmlspecialchars($_POST["account_mobile"], ENT_QUOTES);
$account_email		=	htmlspecialchars($_POST["account_email"], ENT_QUOTES);
$account_facebook	=	htmlspecialchars($_POST["account_facebook"], ENT_QUOTES);
$account_lineID		=	htmlspecialchars(strtolower($_POST["account_lineID"]), ENT_QUOTES);

$profile			= $con->query("SELECT `account_birthday`, `level_id` FROM `account` WHERE account_username = '" . $_SESSION['account_username'] . "'");
$row_profile		= $profile->fetch();

if (!isset($_SESSION["account_birthday"]) || !isset($_SESSION["level_id"])) {
	$con->query("UPDATE `joins` SET `account_username` = '".$_SESSION["account_username"]."' WHERE `account_id` = '".$_SESSION["account_id"]."'");
}

if (!isset($_SESSION["account_birthday"])) {
	$con->query("UPDATE `account` SET `account_birthday`='$account_birthday' WHERE account_username = '" . $_SESSION['account_username'] . "'");
	$_SESSION["account_birthday"] = $account_birthday;
}

if (!isset($_SESSION["level_id"])) {
	$con->query("UPDATE `account` SET `level_id`='$level_id' WHERE account_username = '" . $_SESSION['account_username'] . "'");
	$_SESSION["level_id"] = $level_id;
}

$con->query("UPDATE `account` SET 
	`account_address`='$account_address',
	`account_email`='$account_email',
	`account_mobile`='$account_mobile',
	`account_facebook`='$account_facebook',
	`account_lineID`='$account_lineID' 
	WHERE account_username = '" . $_SESSION['account_username'] . "'");

header("Location: page_profile.php?alerts=success&msg=complete");