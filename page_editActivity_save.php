<?php
session_start();
require 'includes/connect.inc.php';
require 'includes/dateThai.inc.php';

if ($_SESSION["account_fn_03"] != '1') {
	header("Location: 404.php?alert=danger&permission=invalid");
}

$activity_id		=	$_POST["activity_id"];
$activity_name		=	$_POST["activity_name"];
$activity_type		=	$_POST["activity_type"];
$activity_organizer	=	$_POST["activity_organizer"];
$activity_unit		=	$_POST["activity_unit"];
$activity_term		=	$_POST["activity_term"];
$activity_year		=	$_POST["activity_year"];
$activity_date		=	convert_format($_POST["activity_date"]);
// $activity_date		=	date("Y-m-d", strtotime(str_replace('/', '-', $_POST["activity_date"])));
$activity_status	=	$_POST["activity_status"];

if ((substr($activity_date,0,4)) > date("Y")) {
	$date  = substr($_POST["activity_date"],0,2);
	$month = substr($_POST["activity_date"],3,2);
	$year  = substr($_POST["activity_date"],6,4)-1086;
	$activity_date = $year."-".$month."-".$date; 
}

else{
	$date  = substr($_POST["activity_date"],0,2);
	$month = substr($_POST["activity_date"],3,2);
	$year  = substr($_POST["activity_date"],6,4)-543;
	$activity_date = $year."-".$month."-".$date; 
}

echo($activity_date);

$con->query("UPDATE `activity` SET `activity_id`='$activity_id',`activity_name`='$activity_name',`activity_unit`='$activity_unit',`activity_term`='$activity_term',`activity_year`='$activity_year',`activity_date`='$activity_date',`activity_organizer`='$activity_organizer',`activity_type`='$activity_type',`activity_status`='$activity_status' WHERE `activity`.`activity_id` = '$activity_id'");

header("Location: page_editActivity.php?activity_id=$activity_id&status=success");