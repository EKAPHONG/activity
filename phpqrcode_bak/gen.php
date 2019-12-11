<?php 
include('qrlib.php');
$param = $_GET['token'];
$account_id = $_GET['account_id'];
ob_start("callback"); 
$codeText = $param . "|" . $account_id; 
$debugLog = ob_get_contents(); 
ob_end_clean(); 
QRcode::png($codeText, false, 'h', 20, 1, false, 0xFFFFFF, 0x000000);
?>