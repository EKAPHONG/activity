<?php
session_start();

if (!isset($_SESSION["account_username"]) || !isset($_SESSION["account_birthday"]) || !isset($_SESSION["level_id"])) {
	header("Location: http://service.eng.rmuti.ac.th/eng-login/login/?id=4&secret=SAMS");
}