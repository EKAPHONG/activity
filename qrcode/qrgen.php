<?php 
require_once('qrlib.php');

$param = isset($_REQUEST['oid']) ? $_REQUEST['oid'] : '';

if (isset($param) && (strlen($param) == '24')) {
	ob_start("callback");
	$codeText = 'msg0:' . $param . date(":Y.m.d") . date(":H.i.s");
	$debugLog = ob_get_contents();
	ob_end_clean();
	// QRcode::png($codeText);
	QRcode::png($codeText, $filename, M, 9, 2); 
}

else{
	echo "ผิดพลาด: รูปแบบรหัสระบุตัวตนไม่ถูกต้อง";
}