<?php
session_start();
require '../includes/connect.inc.php';

// Configuration, please do not edit if you do not understand the system.
use EKAPHONG\XML_RPC;
require_once(__DIR__ . '/class/XML_RPC.php');
require_once(__DIR__ . '/config/config.php');
$xmlrpc = new XML_RPC();
// End of configuration

$msg		= isset($_REQUEST['msg']) ? $_REQUEST['msg'] : '';
$encrypt	= $_REQUEST["encrypt"];
$attribs	= $_REQUEST["attribs"];

if (!isset($attribs)) {
	header("Location: 404.php?alert=fail&permission=invalid");
}

// Check the encryption parameters.
// 0 = Not encrypted
// 1 = Encrypt
if ($encrypt == "1") {
	// Decrypt data received.
	$attribs	= $xmlrpc->getDecrypt($server, $app_id, $secret, $attribs);
}

// Replace [ and ] with empty values.
$attribs	= preg_replace(array("/\[/", "/\]/"),'',$attribs);
// Replace ' (Single Quotes) with " (Double Quotes)
$attribs	= preg_replace("/\'/",'"',$attribs);
// ใช้ฟังก์ชัน json_decode ในการจัดรูปแบบข้อมูล JSON String ที่ได้รับมาเป็นตัวแปรของ PHP
$attribs	= json_decode($attribs, true);

// Extract the data received.
// บัญชีอินเทอร์เน็ต (ตัวอย่าง: ekaphong.ta)
$uid			=	$attribs['uid'];
// ชื่อภาษาอังกฤษ
$cn				=	$attribs['cn'];
// นามสกุลภาษาอังกฤษ
$sn				=	$attribs['sn'];
// หมายเลข uid
$uidNumber		=	$attribs['uidNumber'];
// หมายเลข gid
$gidNumber		=	$attribs['gidNumber'];
// ชื่อภาษาไทย
$firstNameThai	=	$attribs['firstNameThai'];
// นามสกุลภาษาไทย
$lastNameThai	=	$attribs['lastNameThai'];
// รหัสวิทยาเขต h = ขอนแก่น
$campusID		=	$attribs['campusID'];
// เลขประจำตัวประชาชน
$personalId		=	$attribs['personalId'];
// คำนำหน้าชื่อ
$prename		=	$attribs['prename'];
// ID คำนำหน้าชื่อ
$prenameId		=	$attribs['prenameId'];
// ชื่อวิทยาเขต (ตัวอย่าง: Khonkaen)
$campus			=	$attribs['campus'];
// หมายเลขโทรศัพท์
$phoneNumber	=	preg_replace("/\-/",'',$attribs['phoneNumber']);
// รหัสนักศึกษา
$studentId		=	$attribs['studentId'];
// คณะฯ
$faculty		=	preg_replace("/คณะ/",'',$attribs['faculty']);
// สาขาวิชา
$program		=	preg_replace("/สาขาวิชา /",'',$attribs['program']);
// ถ้าเป็นบัญชีอินเทอร์เน็ตของอาจารย์
if ($attribs['title'] == 'Teachers') {
	// สาขาวิชา
	$program	=	preg_replace("/สาขาวิชา/",'',$attribs['department']);
}
// หลักสูตร (ตัวอย่าง: วิศวกรรมศาสตรบัณฑิต)
$curriculum		=	$attribs['curriculum'];
// หลักสูตร (ปี) (ตัวอย่าง: 4)
$regularYear	=	$attribs['regularYear'];
// ID คณะ (ตัวอย่าง: 3300)
$facultyId		=	$attribs['facultyId'];
// ID สาขาวิชา (ตัวอย่าง: 3333012)
$programId		=	$attribs['programId'];
// ID หลักสูตร (ตัวอย่าง: 0206)
$curriculumId	=	$attribs['curriculumId'];
// ลักษณะ (ชื่อ-นามสกุล ภาษาอังกฤษ)
$description	=	$attribs['description'];
// ชื่อที่แสดงผล (ชื่อ-นามสกุล ภาษาอังกฤษ)
$displayName	=	$attribs['displayName'];
// อีเมลมหาวิทยาลัย (ตัวอย่าง: ekaphong.ta@rmuti.ac.th)
$mail			=	$attribs['mail'];
// สถานะบัญชี (ตัวอย่าง: active)
$accountStatus	=	$attribs['accountStatus'];
// ตำแหน่ง (ตัวอย่าง: Student)
$title			=	$attribs['title'];

if ($msg) {
	header("Location: ../phpqrcode/receive.php?uid=$uid");
}

// ตรวจสอบจากในฐานข้อมูล ว่ามีข้อมูลของ Account นี้หรือไม่
$check_username = $con->query("SELECT * FROM `account` WHERE account_username = '$uid'");
$row = $check_username->fetch();

// ถ้ามีอยู่แล้ว ให้อัพเดทข้อมูล
if ($row) {
	$con->query("UPDATE `account` SET 
		`account_username`='$uid',
		`account_firstname`='$firstNameThai',
		`account_lastname`='$lastNameThai',
		`account_degree`='$curriculum',
		`account_faculty`='$faculty',
		`account_department`='$program'
		WHERE account_username = '$uid'");

	$con->query("UPDATE `joins` SET `account_username` = '$uid' WHERE `account_id` = '$studentId'");
}

// ถ้ายังไม่มี ให้เพิ่มเข้าไปใหม่
else{
	$today = date("Y-m-d H:i:s");
	$con->query("INSERT INTO `account`(`account_username`, `account_id`, `account_idno`, `account_prefix`, `account_firstname`, `account_lastname`, `account_email`, `account_mobile`, `account_degree`, `account_faculty`, `account_department`, `account_register`) VALUES ('$uid','$studentId','$personalId','$prename','$firstNameThai','$lastNameThai','$mail','$phoneNumber','$curriculum','$faculty','$program','$today')");

	$con->query("UPDATE `joins` SET `account_username` = '$uid' WHERE `account_id` = '$studentId'");
}

$account		= $con->query("SELECT * FROM `account` WHERE account_username = '$uid'");
$row_account	= $account->fetch();

// เก็บข้อมูลลงใน Session
$_SESSION["account_username"]	=	$row_account["account_username"];
$_SESSION["account_id"]			=	$row_account["account_id"];
$_SESSION["account_idno"]		=	$row_account["account_idno"];
$_SESSION["account_prefix"]		=	$row_account["account_prefix"];
$_SESSION["account_firstname"]	=	$row_account["account_firstname"];
$_SESSION["account_lastname"]	=	$row_account["account_lastname"];
$_SESSION["account_birthday"]	=	$row_account["account_birthday"];
$_SESSION["level_id"]			=	$row_account["level_id"];

$_SESSION["account_fn_01"]		=	$row_account["account_fn_01"];
$_SESSION["account_fn_02"]		=	$row_account["account_fn_02"];
$_SESSION["account_fn_03"]		=	$row_account["account_fn_03"];
$_SESSION["account_fn_04"]		=	$row_account["account_fn_04"];
$_SESSION["account_fn_05"]		=	$row_account["account_fn_05"];
$_SESSION["account_fn_06"]		=	$row_account["account_fn_06"];
$_SESSION["account_fn_07"]		=	$row_account["account_fn_07"];
$_SESSION["account_fn_08"]		=	$row_account["account_fn_08"];
$_SESSION["account_fn_09"]		=	$row_account["account_fn_09"];

$_SESSION["account_type"]		=	$title;

if (isset($_SESSION["account_username"]) AND ($_SESSION["account_type"] != "Students")) {
	header("Location: ../index.php");
}

elseif (isset($_SESSION["account_username"]) AND isset($_SESSION["level_id"]) AND isset($_SESSION["account_birthday"])) {
	header("Location: ../index.php");
}

elseif (isset($_SESSION["account_username"]) AND (!isset($_SESSION["level_id"]) OR !isset($_SESSION["account_birthday"]))) {
	header("Location: ../page_profile.php?alerts=warning&msg=incomplete");
}

else {
	echo "เกิดข้อผิดพลาด โปรดติดต่อผู้ดูแลระบบ";
}