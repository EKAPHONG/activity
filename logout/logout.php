<?php
require_once '../login/config/config.php';
session_start();

if ($_SESSION["account_username"]) {
	session_destroy();
	header("Location: http://service.eng.rmuti.ac.th/eng-login/logout/?id=$app_id&secret=$secret");
}

else{
	header("Location: ../index.php");
}
?>