<?php
session_start();
require 'includes/connect.inc.php';

if ($_SESSION["account_fn_02"] != '1') {
	header("Location: 404.php?alert=danger&permission=invalid");
}

$activity_id	=	$_GET["activity_id"];
$status			=	$_GET["status"];

if ($status == "approve") {
	$con->query("UPDATE `joins` SET `join_status`='1' WHERE `activity_id` LIKE '$activity_id'");
	header("Location: page_approveDetail.php?activity_id=$activity_id&status=success");
}

elseif ($status == "cancel") {
	$con->query("UPDATE `joins` SET `join_status`='0' WHERE `activity_id` LIKE '$activity_id'");
	header("Location: page_approveDetail.php?activity_id=$activity_id&status=success");
}

else{
	header("Location: page_approveDetail.php?activity_id=$activity_id&status=invalid");
}