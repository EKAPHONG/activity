<?php
session_start();
require 'includes/config.inc.php';
require 'includes/connect.inc.php';

if ($_SESSION["account_fn_01"] != '1') {
	header("Location: 404.php?alert=danger&permission=invalid");
}

$account_idno	=	$_POST['account_idno'];

$account_fn_01	=	(!empty($_POST['account_fn_01']) ? '1':'0');
$account_fn_02	=	(!empty($_POST['account_fn_02']) ? '1':'0');
$account_fn_03	=	(!empty($_POST['account_fn_03']) ? '1':'0');
$account_fn_04	=	(!empty($_POST['account_fn_04']) ? '1':'0');
$account_fn_05	=	(!empty($_POST['account_fn_05']) ? '1':'0');
$account_fn_06	=	(!empty($_POST['account_fn_06']) ? '1':'0');
$account_fn_07	=	(!empty($_POST['account_fn_07']) ? '1':'0');
$account_fn_08	=	(!empty($_POST['account_fn_08']) ? '1':'0');
$account_fn_09	=	(!empty($_POST['account_fn_09']) ? '1':'0');

$con->query("UPDATE `account` SET 
	`account_fn_01`='$account_fn_01', 
	`account_fn_02`='$account_fn_02', 
	`account_fn_03`='$account_fn_03', 
	`account_fn_04`='$account_fn_04', 
	`account_fn_05`='$account_fn_05', 
	`account_fn_06`='$account_fn_06', 
	`account_fn_07`='$account_fn_07', 
	`account_fn_08`='$account_fn_08', 
	`account_fn_09`='$account_fn_09' 
	WHERE `account`.`account_idno` = '$account_idno'");

header("Location: page_editPermissions.php?account_idno=$account_idno&alert=success&status=success");