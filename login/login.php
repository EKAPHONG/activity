<?php
require_once 'config/config.php';
session_start();

if ($_SESSION["account_username"]) {
	header("Location: ../index.php");
} else {
	session_destroy();
	header("Location: http://service.eng.rmuti.ac.th/eng-login/login/?id=$app_id&secret=$secret");
}