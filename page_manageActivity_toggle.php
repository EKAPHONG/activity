<?php
session_start();
require 'includes/connect.inc.php';

if ($_SESSION["account_fn_03"] != '1') {
	header("Location: 404.php?alert=fail&permission=invalid");
}

$activity_id		=	$_GET["activity_id"];
$activity_status	=	$_GET["activity_status"];
$term				=	$_GET["term"];
$year				=	$_GET["year"];

if ($activity_status == "1") {
	$con->query("UPDATE `activity` SET `activity_status` = '0' WHERE `activity`.`activity_id` = '$activity_id'");
}

elseif ($activity_status == "0") {
	$con->query("UPDATE `activity` SET `activity_status` = '1' WHERE `activity`.`activity_id` = '$activity_id'");
}

else{
	header("Location: page_manageActivity.php?activity_id=$activity_id&status=invalid&term=$term&year=$year");
}

header("Location: page_manageActivity.php?activity_id=$activity_id&status=success&term=$term&year=$year");