<?php
session_start();
require 'includes/connect.inc.php';
require 'includes/dateThai.inc.php';

if ($_SESSION["account_fn_03"] != '1') {
	header("Location: 404.php?alert=fail&permission=invalid");
}

$activity_id		=	htmlspecialchars($_POST["activity_id"], ENT_QUOTES);
$activity_name		=	htmlspecialchars($_POST["activity_name"], ENT_QUOTES);
$activity_type		=	htmlspecialchars($_POST["activity_type"], ENT_QUOTES);
$activity_organizer	=	htmlspecialchars($_POST["activity_organizer"], ENT_QUOTES);
$activity_unit		=	htmlspecialchars($_POST["activity_unit"], ENT_QUOTES);
$activity_term		=	htmlspecialchars($_POST["activity_term"], ENT_QUOTES);
$activity_year		=	htmlspecialchars($_POST["activity_year"], ENT_QUOTES);
$activity_date		=	convert_format($_POST["activity_date"]);
$activity_status	=	htmlspecialchars($_POST["activity_status"], ENT_QUOTES);

$query = $con->query("SELECT `activity_id` FROM `activity` WHERE `activity`.`activity_id` = '$activity_id'");
$count = $query->rowCount();

if ($count == 0) {
	$con->query("INSERT INTO `activity`(`activity_id`, `activity_name`, `activity_unit`, `activity_term`, `activity_year`, `activity_date`, `activity_organizer`, `activity_type`, `activity_status`) VALUES ('$activity_id','$activity_name','$activity_unit','$activity_term','$activity_year','$activity_date','$activity_organizer','$activity_type','$activity_status')");
	header("Location: page_addActivity.php?activity_id=$activity_id&status=success");
}

else{
	header("Location: page_addActivity.php?activity_id=$activity_id&status=invalid");
}