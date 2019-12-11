<?php
require 'includes/connect.inc.php';
$conn = mysqli_connect("localhost",$username,$password,$database);

// Checkbox
if (isset($_POST["remember_activity_id"])){
	setcookie("remember_activity_id", "checked", time()+60*60*24*30); // 60 sec * 60 min * 24 hours * 30 days
}

else{
	setcookie("remember_activity_id", "", time()+60*60*24*30); // 60 sec * 60 min * 24 hours * 30 days
}

$activity_id	= $_POST["activity_id"];
$account_id		= $_POST["account_id"];
$date			= date("Y-m-d");

if (($activity_id != "") AND ($account_id != "")) {
	$query = "INSERT INTO `joins`(`account_id`, `activity_id`, `join_date`, `join_status`) VALUES ('".$account_id."','".$activity_id."','".$date."','0')";
	$result = mysqli_query($conn, $query);

	if (!empty($result)) {
		header("Location: page_import2.php?activity_id=$activity_id&account_id=$account_id&status=success");
	}
	else{
		header("Location: page_import2.php?activity_id=$activity_id&account_id=$account_id&status=fail");
	}
}

else{
	header("Location: page_import2.php?activity_id=$activity_id&account_id=$account_id&status=fail");
}