<?php
session_start();
require 'includes/config.inc.php';
require 'includes/connect.inc.php';

if ($_SESSION["account_fn_08"] != '1') {
	header("Location: 404.php?alert=danger&permission=invalid");
}

for ($i=0; $i < 3; $i++) { 
	$con->query("UPDATE `level` SET 
		`event_01`= '" . $_POST['event_01'][$i] . "', 
		`unit_01` = '" . $_POST['unit_01'][$i] . "', 
		`event_02`= '" . $_POST['event_02'][$i] . "', 
		`unit_02` = '" . $_POST['unit_02'][$i] . "', 
		`event_03`= '" . $_POST['event_03'][$i] . "', 
		`event_04`= '" . $_POST['event_04'][$i] . "', 
		`event_05`= '" . $_POST['event_05'][$i] . "', 
		`event_06`= '" . $_POST['event_06'][$i] . "', 
		`event_07`= '" . $_POST['event_07'][$i] . "', 
		`unit_03-07`='" . $_POST['unit_03-07'][$i] . "'
		WHERE `level`.`level_id` = '" . ($i+1) . "'");
}

header("Location: page_condition.php?alert=success&status=success");