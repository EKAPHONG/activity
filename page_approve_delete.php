<?php
session_start();
require 'includes/connect.inc.php';

if ($_SESSION["account_fn_02"] != '1') {
	header("Location: 404.php?alert=danger&permission=invalid");
}

$activity_id	=	$_GET["activity_id"];
$account_id		=	$_GET["account_id"];

if (isset($account_id)) {
	$con->query("DELETE FROM `joins` WHERE `joins`.`account_id` LIKE $account_id AND `joins`.`activity_id` LIKE $activity_id");
	header("Location: page_approveDetail2.php?activity_id=$activity_id&account_id=$account_id&status=success");
}

// elseif ($status == "cancel") {
// 	$con->query("UPDATE `joins` SET `join_status`='0' WHERE `activity_id` LIKE '$activity_id'");
// 	header("Location: page_approveDetail2.php?account_id=$account_id&status=invalid");
// }

else{
	header("Location: page_approveDetail2.php?activity_id=$activity_id&account_id=$account_id&status=invalid");
}