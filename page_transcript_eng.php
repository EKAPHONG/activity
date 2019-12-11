<?php
// Require composer autoload
require_once 'vendor/autoload.php';
require_once 'vendor/THSplitLib/segment.php';
require_once 'includes/connect.inc.php';
require_once 'includes/dateThai.inc.php';

$row_1 = 0;
$row_2 = 0;
$row_3_1 = 0;
$row_3_2 = 0;
$row_3_3 = 0;
$row_3_4 = 0;
$row_3_5 = 0;

$total_1 = 0;
$total_2 = 0;
$total_3 = 0;

$today = thai_date_thaiyear(strtotime(date("Y-m-d")));



/* ==================================================================================== */





$profile = $con->query("SELECT * FROM `account` WHERE account_id = '" . $_GET['account_id'] . "'");
$row_profile = $profile->fetch();


$sql1 = $con->query("SELECT joins.activity_id, joins.join_status, activity.activity_name, activity.activity_unit, activity.activity_type FROM `joins`\n"
	. "INNER JOIN activity ON joins.activity_id = activity.activity_id\n"
    . "WHERE joins.account_id = '" . $_GET['account_id'] . "' AND activity.activity_type = '1' AND joins.join_status = '1' ORDER BY activity.activity_id");
    
$sql2 = $con->query("SELECT joins.activity_id, joins.join_status, activity.activity_name, activity.activity_unit, activity.activity_type FROM `joins`\n"
	. "INNER JOIN activity ON joins.activity_id = activity.activity_id\n"
	. "WHERE joins.account_id = '" . $_GET['account_id'] . "' AND activity.activity_type = '2' AND joins.join_status = '1' ORDER BY activity.activity_id");

$sql3_1 = $con->query("SELECT joins.activity_id, joins.join_status, activity.activity_name, activity.activity_unit, activity.activity_type FROM `joins`\n"
	. "INNER JOIN activity ON joins.activity_id = activity.activity_id\n"
    . "WHERE joins.account_id = '" . $_GET['account_id'] . "' AND activity.activity_type = '3' AND joins.join_status = '1' ORDER BY activity.activity_id");

$sql3_2 = $con->query("SELECT joins.activity_id, joins.join_status, activity.activity_name, activity.activity_unit, activity.activity_type FROM `joins`\n"
	. "INNER JOIN activity ON joins.activity_id = activity.activity_id\n"
    . "WHERE joins.account_id = '" . $_GET['account_id'] . "' AND activity.activity_type = '4' AND joins.join_status = '1' ORDER BY activity.activity_id");

$sql3_3 = $con->query("SELECT joins.activity_id, joins.join_status, activity.activity_name, activity.activity_unit, activity.activity_type FROM `joins`\n"
	. "INNER JOIN activity ON joins.activity_id = activity.activity_id\n"
    . "WHERE joins.account_id = '" . $_GET['account_id'] . "' AND activity.activity_type = '5' AND joins.join_status = '1' ORDER BY activity.activity_id");

$sql3_4 = $con->query("SELECT joins.activity_id, joins.join_status, activity.activity_name, activity.activity_unit, activity.activity_type FROM `joins`\n"
	. "INNER JOIN activity ON joins.activity_id = activity.activity_id\n"
    . "WHERE joins.account_id = '" . $_GET['account_id'] . "' AND activity.activity_type = '6' AND joins.join_status = '1' ORDER BY activity.activity_id");

$sql3_5 = $con->query("SELECT joins.activity_id, joins.join_status, activity.activity_name, activity.activity_unit, activity.activity_type FROM `joins`\n"
	. "INNER JOIN activity ON joins.activity_id = activity.activity_id\n"
    . "WHERE joins.account_id = '" . $_GET['account_id'] . "' AND activity.activity_type = '7' AND joins.join_status = '1' ORDER BY activity.activity_id");




/* ==================================================================================== */

if (isset($row_profile["account_birthday"])) {
	$account_birthday	=	thai_date_thaiyear(strtotime($row_profile["account_birthday"]));
}

else {
	$account_birthday	=	thai_date_thaiyear(strtotime(convert_format($_POST["account_birthday"])));
}

$date_in	=	(isset($_POST["date_in"]) ? (thai_date_thaiyear(strtotime(convert_format($_POST["date_in"])))) : '');
$date_out	=	(isset($_POST["date_in"]) ? (thai_date_thaiyear(strtotime(convert_format($_POST["date_out"])))) : '');

$name_left		=	$_POST["name_left"];
$title_left		=	$_POST["title_left"];

$name_center	=	$_POST["name_center"];
$title_center	=	$_POST["title_center"];

$name_right		=	$_POST["name_right"];
$title_right	=	$_POST["title_right"];

/* ==================================================================================== */





$defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
$fontDirs = $defaultConfig['fontDir'];

$defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
$fontData = $defaultFontConfig['fontdata'];

// Create an instance of the class:
$mpdf = new \Mpdf\Mpdf([
    'fontDir' => array_merge($fontDirs, [
        __DIR__ . '/fonts',
    ]),
    'fontdata' => $fontData + [
        'rit' => [
            'R' => 'rit95R.ttf',
        ],
        'ritB' => [
            'B' => 'rit95B.ttf',
        ]
    ],
	'default_font' => 'rit'
]);
    
// Disable Dictionary mPDF
$mpdf->useDictionaryLBR = false;

// Disable Shrink Tables
$mpdf->shrink_tables_to_fit = 0;




/* ==================================================================================== */





$start_html = '
<!DOCTYPE html>
<html>
<head>
    <title>ใบแสดงผลการเข้าร่วมกิจกรรมพัฒนานักศึกษา</title>
    <link rel="stylesheet" type="text/css" href="vendor/transcript.css">
</head>
<body>
';

$head = '
<table width="100%" cellspacing="0">
    <tr>
        <td width="15%">
            <img border="0" src="images/logo_RMUTI.png" width="80">
        </td>
        <td class="text-center">
            <b class="font-20pt">มหาวิทยาลัยเทคโนโลยีราชมงคลอีสาน</b>
            <p class="font-12pt">150 ถนนศรีจันทร์ ตำบลในเมือง อำเภอเมือง จังหวัดขอนแก่น 40000</p>
            <p>&nbsp;</p>
            <b class="font-16pt">วิทยาเขตขอนแก่น</b>
            <p class="font-16pt">ใบแสดงผลการเข้าร่วมกิจกรรมพัฒนานักศึกษา</p>
            <p class="font-16pt">คณะ' . $row_profile["account_faculty"] . '</p>
        </td>
        <td align="right" width="15%">
            <img border="0" src="images/photo.jpg" width="80">
        </td>
    </tr>
</table>
';

$detail = '
<table border="0" width="100%" cellspacing="0" cellpadding="0">
	<tr>
		<td width="60%" class="font-14pt">ชื่อ : ' . $row_profile["account_prefix"] . $row_profile["account_firstname"] . " " . $row_profile["account_lastname"] . '</td>
		<td width="40%" class="font-14pt">เลขประจำตัวประชาชน : ' . $row_profile["account_idno"] . '</td>
	</tr>
	<tr>
		<td class="font-14pt">รหัสนักศึกษา : ' . $row_profile["account_id"] . '</td>
		<td class="font-14pt">วันเกิด : ' . $account_birthday . '</td>
	</tr>
	<tr>
		<td class="font-14pt" valign="top">ชื่อปริญญา : ' . $row_profile["account_degree"] . ' (' . $row_profile["account_department"] . ')</td>
		<td class="font-14pt" valign="top">วันที่เข้าศึกษา : ' . $date_in . '</td>
	</tr>
    <tr>
        <td class="font-14pt">&nbsp;</td>
		<td class="font-14pt">วันที่ผ่านการเข้าร่วมกิจกรรม : ' . $date_out . '</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
</table>
';

$table = '
<table class="line-bb" cellspacing="0" cellpadding="0" width="100%">
    <tr>
        <td class="align-top line-bl" width="50%">';

$table.='
            <table autosize="1" class="border-collapse" width="100%">
                <tr>
                    <td class="font-10pt text-center line-bt line-bb">รหัสกิจกรรม</td>
                    <td class="font-10pt text-center line-bt line-bb">ชื่อกิจกรรม</td>
                    <td class="font-10pt text-center line-bt line-bb">หน่วยกิจกรรม</td>
                    <td class="font-10pt text-center line-bt line-bb">ผลกิจกรรม</td>
                </tr>
';

$table.='
                <tr>
                    <td class="font-10pt" colspan="4"><b>กิจกรรมบังคับ</b></td>
                </tr>
';

while ($row_sql1 = $sql1->fetch()) {
    $segment = new Segment();
    $result = $segment->get_segment_array($row_sql1["activity_name"]);
    $text = implode("|",$result);
    $table.= '
                <tr>
                    <td class="font-10pt text-center align-top">' . format_activity_id($row_sql1["activity_id"]) . '</td>
                    <td class="font-10pt">' . $text . '</td>
                    <td class="font-10pt text-right align-top">' . $row_sql1["activity_unit"] . '</td>
                    <td class="font-10pt text-center align-top">ผ</td>
                </tr>
    ';
    // นับจำนวนกิจกรรม
	$row_1++;
    // นับจำนวนหน่วยกิจกรรม
    $total_1 += $row_sql1["activity_unit"];
}

$table.='
                <tr>
                    <td align="right" class="font-10pt" colspan="4"><b>' . $row_1 . ' กิจกรรม ' . $total_1 . ' หน่วย&nbsp;<b/></td>
                </tr>
                <tr>
                    <td class="font-10pt" colspan="4">&nbsp;</td>
                </tr>
';

$table.='
                <tr>
                    <td class="font-10pt" colspan="4"><b>กิจกรรมบังคับเลือก</b></td>
                </tr>
';

while ($row_sql2 = $sql2->fetch()) {
    $segment = new Segment();
    $result = $segment->get_segment_array($row_sql2["activity_name"]);
    $text = implode("|",$result);
    $table.= '
                <tr>
                    <td class="font-10pt text-center align-top">' . format_activity_id($row_sql2["activity_id"]) . '</td>
                    <td class="font-10pt">' . $text . '</td>
                    <td class="font-10pt text-right align-top">' . $row_sql2["activity_unit"] . '</td>
                    <td class="font-10pt text-center align-top">ผ</td>
                </tr>
    ';
    // นับจำนวนกิจกรรม
	$row_2++;
    // นับจำนวนหน่วยกิจกรรม
    $total_2 += $row_sql2["activity_unit"];
}

$table.='
                <tr>
                    <td align="right" class="font-10pt" colspan="4"><b>' . $row_2 . ' กิจกรรม ' . $total_2 . ' หน่วย&nbsp;<b/></td>
                </tr>
                <tr>
                    <td class="font-10pt" colspan="4">&nbsp;</td>
                </tr>
';

$table.='
                <tr>
                    <td class="font-10pt" colspan="4"><b>กิจกรรมเลือกเข้าร่วม</b></td>
                </tr>
';

$table.='
                <tr>
                    <td class="font-10pt" colspan="4"><b>ด้านการส่งเสริมและพัฒนาบุคลิกภาพ</b></td>
                </tr>
';

while ($row_sql3_1 = $sql3_1->fetch()) {
    $segment = new Segment();
    $result = $segment->get_segment_array($row_sql3_1["activity_name"]);
    $text = implode("|",$result);
    $table.= '
                <tr>
                    <td class="font-10pt text-center align-top">' . format_activity_id($row_sql3_1["activity_id"]) . '</td>
                    <td class="font-10pt">' . $text . '</td>
                    <td class="font-10pt text-center align-top">' . $row_sql3_1["activity_unit"] . '</td>
                    <td class="font-10pt text-center align-top">ผ</td>
                </tr>
    ';
    // นับจำนวนกิจกรรม
	$row_3++;
    // นับจำนวนหน่วยกิจกรรม
    $total_3 += $row_sql3_1["activity_unit"];
}

$table.='
                <tr>
                    <td class="font-10pt" colspan="4">&nbsp;</td>
                </tr>
';

$table.='
                <tr>
                    <td class="font-10pt" colspan="4"><b>ด้านการส่งเสริมและพัฒนาสุขภาพกายและสุขภาพจิต</b></td>
                </tr>
';

while ($row_sql3_2 = $sql3_2->fetch()) {
    $segment = new Segment();
    $result = $segment->get_segment_array($row_sql3_2["activity_name"]);
    $text = implode("|",$result);
    $table.= '
                <tr>
                    <td class="font-10pt text-center align-top">' . format_activity_id($row_sql3_2["activity_id"]) . '</td>
                    <td class="font-10pt">' . $text . '</td>
                    <td class="font-10pt text-center align-top">' . $row_sql3_2["activity_unit"] . '</td>
                    <td class="font-10pt text-center align-top">ผ</td>
                </tr>
    ';
    // นับจำนวนกิจกรรม
	$row_3++;
    // นับจำนวนหน่วยกิจกรรม
    $total_3 += $row_sql3_2["activity_unit"];
}

$table.='
                <tr>
                    <td class="font-10pt" colspan="4">&nbsp;</td>
                </tr>
';


$table.='
            </table>
        </td>
';

$table.='
        <td class="align-top line-bl line-br" width="50%">
            <table autosize="1" class="border-collapse" width="100%">
                <tr>
                    <td class="font-10pt text-center line-bt line-bb">รหัสกิจกรรม</td>
                    <td class="font-10pt text-center line-bt line-bb">ชื่อกิจกรรม</td>
                    <td class="font-10pt text-center line-bt line-bb">หน่วยกิจกรรม</td>
                    <td class="font-10pt text-center line-bt line-bb">ผลกิจกรรม</td>
                </tr>
';

// $table.='
//                 <tr>
//                     <td class="font-10pt" colspan="4"><b>ด้านการส่งเสริมและพัฒนาสุขภาพกายและสุขภาพจิต</b></td>
//                 </tr>
// ';

// while ($row_sql3_2 = $sql3_2->fetch()) {
//     $segment = new Segment();
//     $result = $segment->get_segment_array($row_sql3_2["activity_name"]);
//     $text = implode("|",$result);
//     $table.= '
//                 <tr>
//                     <td class="font-10pt text-center align-top">' . format_activity_id($row_sql3_2["activity_id"]) . '</td>
//                     <td class="font-10pt">' . $text . '</td>
//                     <td class="font-10pt text-center align-top">' . $row_sql3_2["activity_unit"] . '</td>
//                     <td class="font-10pt text-center align-top">ผ</td>
//                 </tr>
//     ';
//     // นับจำนวนกิจกรรม
// 	$row_3++;
//     // นับจำนวนหน่วยกิจกรรม
//     $total_3 += $row_sql3_2["activity_unit"];
// }

// $table.='
//                 <tr>
//                     <td class="font-10pt" colspan="4">&nbsp;</td>
//                 </tr>
// ';

$table.='
                <tr>
                    <td class="font-10pt" colspan="4"><b>ด้านการส่งเสริมและพัฒนาทักษะทางวิชาการหรือวิชาชีพ</b></td>
                </tr>
';

while ($row_sql3_3 = $sql3_3->fetch()) {
    $segment = new Segment();
    $result = $segment->get_segment_array($row_sql3_3["activity_name"]);
    $text = implode("|",$result);
    $table.= '
                <tr>
                    <td class="font-10pt text-center align-top">' . format_activity_id($row_sql3_3["activity_id"]) . '</td>
                    <td class="font-10pt">' . $text . '</td>
                    <td class="font-10pt text-center align-top">' . $row_sql3_3["activity_unit"] . '</td>
                    <td class="font-10pt text-center align-top">ผ</td>
                </tr>
    ';
    // นับจำนวนกิจกรรม
	$row_3++;
    // นับจำนวนหน่วยกิจกรรม
    $total_3 += $row_sql3_3["activity_unit"];
}

$table.='
                <tr>
                    <td class="font-10pt" colspan="4">&nbsp;</td>
                </tr>
';

$table.='
                <tr>
                    <td class="font-10pt" colspan="4"><b>ด้านการส่งเสริมและพัฒนาคุณธรรม จริยธรรม ค่านิยม</b></td>
                </tr>
';

while ($row_sql3_4 = $sql3_4->fetch()) {
    $segment = new Segment();
    $result = $segment->get_segment_array($row_sql3_4["activity_name"]);
    $text = implode("|",$result);
    $table.= '
                <tr>
                    <td class="font-10pt text-center align-top">' . format_activity_id($row_sql3_4["activity_id"]) . '</td>
                    <td class="font-10pt">' . $text . '</td>
                    <td class="font-10pt text-center align-top">' . $row_sql3_4["activity_unit"] . '</td>
                    <td class="font-10pt text-center align-top">ผ</td>
                </tr>
    ';
    // นับจำนวนกิจกรรม
	$row_3++;
    // นับจำนวนหน่วยกิจกรรม
    $total_3 += $row_sql3_4["activity_unit"];
}

$table.='
                <tr>
                    <td class="font-10pt" colspan="4">&nbsp;</td>
                </tr>
';

$table.='
                <tr>
                    <td class="font-10pt" colspan="4"><b>ด้านการส่งเสริมและอนุรักษ์ศิลปวัฒนธรรมและสิ่งแวดล้อม</b></td>
                </tr>
';

while ($row_sql3_5 = $sql3_5->fetch()) {
    $segment = new Segment();
    $result = $segment->get_segment_array($row_sql3_5["activity_name"]);
    $text = implode("|",$result);
    $table.= '
                <tr>
                    <td class="font-10pt text-center align-top">' . format_activity_id($row_sql3_5["activity_id"]) . '</td>
                    <td class="font-10pt">' . $text . '</td>
                    <td class="font-10pt text-center align-top">' . $row_sql3_5["activity_unit"] . '</td>
                    <td class="font-10pt text-center align-top">ผ</td>
                </tr>
    ';
    // นับจำนวนกิจกรรม
	$row_3++;
    // นับจำนวนหน่วยกิจกรรม
    $total_3 += $row_sql3_5["activity_unit"];
}

$table.='
                <tr>
                    <td align="right" class="font-10pt" colspan="4"><b>' . $row_3 . ' กิจกรรม ' . $total_3 . ' หน่วย&nbsp;<b/></td>
                </tr>
                <tr>
                    <td class="font-10pt" colspan="4">&nbsp;</td>
                </tr>
';


$table.='
            </table>
            <table width="100%">
                <tr>
                    <td class="font-12pt">&nbsp;&nbsp;&nbsp;<b>กิจกรรมบังคับ</b></td>
                    <td class="font-12pt text-right"><b>' . $row_1 . '</b></td>
                    <td class="font-12pt"><b> กิจกรรม</b></td>
                    <td class="font-12pt text-center"><b>ผ่าน</b></td>
                    <td class="font-12pt text-right"><b>' . $total_1 . '</b></td>
                    <td class="font-12pt"><b> หน่วย</b></td>
                </tr>
                <tr>
                    <td class="font-12pt">&nbsp;&nbsp;&nbsp;<b>กิจกรรมบังคับเลือก</b></td>
                    <td class="font-12pt text-right"><b>' . $row_2 . '</b></td>
                    <td class="font-12pt"><b> กิจกรรม</b></td>
                    <td class="font-12pt text-center"><b>ผ่าน</b></td>
                    <td class="font-12pt text-right"><b>' . $total_2 . '</b></td>
                    <td class="font-12pt"><b> หน่วย</b></td>
                </tr>
                <tr>
                    <td class="font-12pt">&nbsp;&nbsp;&nbsp;<b>กิจกรรมเลือกเข้าร่วม</b></td>
                    <td class="font-12pt text-right"><b>' . $row_3 . '</b></td>
                    <td class="font-12pt"><b> กิจกรรม</b></td>
                    <td class="font-12pt text-center"><b>ผ่าน</b></td>
                    <td class="font-12pt text-right"><b>' . $total_3 . '</b></td>
                    <td class="font-12pt"><b> หน่วย</b></td>
                </tr>
                <tr>
                    <td class="font-12pt">&nbsp;&nbsp;&nbsp;<b>รวมกิจกรรม</b></td>
                    <td class="font-12pt text-right"><b>' . ($row_1+$row_2+$row_3) . '</b></td>
                    <td class="font-12pt"><b> กิจกรรม</b></td>
                    <td class="font-12pt text-center"><b>ผ่าน</b></td>
                    <td class="font-12pt text-right"><b>' . ($total_1+$total_2+$total_3) . '</b></td>
                    <td class="font-12pt"><b> หน่วย</b></td>
                </tr>
                <tr>
                    <td class="font-10pt" colspan="6">&nbsp;</td>
                </tr>
                <tr>
                    <td class="font-14pt text-center" colspan="6"><b>ผ่านการเข้าร่วมกิจกรรมนักศึกษา</b></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
';


// $table.='
//             </table>
//         </td>
//     </tr>
// </table>
// ';

$footer = '<table width="100%"><br /><tr><td class="font-14pt" style="text-align: left;" width="50%">แผ่นที่ {PAGENO}/{nbpg}</td><td class="font-14pt" style="text-align: right" width="50%">วันที่ออกเอกสาร ' . $today . '</td></tr></table>';














// $table_2 = '
// <table class="line-bb" cellspacing="0" cellpadding="0" width="100%">
//     <tr>
//         <td class="align-top line-bl" width="50%">';

// $table_2.='
//             <table autosize="1" class="border-collapse" width="100%">
//                 <tr>
//                     <td class="font-10pt text-center line-bt line-bb">รหัสกิจกรรม</td>
//                     <td class="font-10pt text-center line-bt line-bb">ชื่อกิจกรรม</td>
//                     <td class="font-10pt text-center line-bt line-bb">หน่วยกิจกรรม</td>
//                     <td class="font-10pt text-center line-bt line-bb">ผลกิจกรรม</td>
//                 </tr>
// ';

// $table_2.='
//                 <tr>
//                     <td class="font-10pt" colspan="4"><b>ด้านการส่งเสริมและพัฒนาคุณธรรม จริยธรรม ค่านิยม</b></td>
//                 </tr>
// ';

// while ($row_sql3_4 = $sql3_4->fetch()) {
//     $segment = new Segment();
//     $result = $segment->get_segment_array($row_sql3_4["activity_name"]);
//     $text = implode("|",$result);
//     $table_2.= '
//                 <tr>
//                     <td class="font-10pt text-center align-top">' . format_activity_id($row_sql3_4["activity_id"]) . '</td>
//                     <td class="font-10pt">' . $text . '</td>
//                     <td class="font-10pt text-center align-top">' . $row_sql3_4["activity_unit"] . '</td>
//                     <td class="font-10pt text-center align-top">ผ</td>
//                 </tr>
//     ';
//     // นับจำนวนกิจกรรม
// 	$row_3++;
//     // นับจำนวนหน่วยกิจกรรม
//     $total_3 += $row_sql3_4["activity_unit"];
// }

// $table_2.='
//                 <tr>
//                     <td class="font-10pt" colspan="4">&nbsp;</td>
//                 </tr>
// ';

// $table_2.='
//                 <tr>
//                     <td class="font-10pt" colspan="4"><b>ด้านการส่งเสริมและอนุรักษ์ศิลปวัฒนธรรมและสิ่งแวดล้อม</b></td>
//                 </tr>
// ';

// while ($row_sql3_5 = $sql3_5->fetch()) {
//     $segment = new Segment();
//     $result = $segment->get_segment_array($row_sql3_5["activity_name"]);
//     $text = implode("|",$result);
//     $table_2.= '
//                 <tr>
//                     <td class="font-10pt text-center align-top">' . format_activity_id($row_sql3_5["activity_id"]) . '</td>
//                     <td class="font-10pt">' . $text . '</td>
//                     <td class="font-10pt text-center align-top">' . $row_sql3_5["activity_unit"] . '</td>
//                     <td class="font-10pt text-center align-top">ผ</td>
//                 </tr>
//     ';
//     // นับจำนวนกิจกรรม
// 	$row_3++;
//     // นับจำนวนหน่วยกิจกรรม
//     $total_3 += $row_sql3_5["activity_unit"];
// }

// $table_2.='
//                 <tr>
//                     <td align="right" class="font-10pt" colspan="4"><b>' . $row_3 . ' กิจกรรม ' . $total_3 . ' หน่วย&nbsp;<b/></td>
//                 </tr>
//                 <tr>
//                     <td class="font-10pt" colspan="4">&nbsp;</td>
//                 </tr>
// ';




/* ==================================================================================== */


$table_2.='
            </table>
        </td>
';

$table_2.='
        <td class="align-top line-bl line-br" width="50%">
            <table autosize="1" class="border-collapse" width="100%">
                <tr>
                    <td class="font-10pt text-center line-bt line-bb">รหัสกิจกรรม</td>
                    <td class="font-10pt text-center line-bt line-bb">ชื่อกิจกรรม</td>
                    <td class="font-10pt text-center line-bt line-bb">หน่วยกิจกรรม</td>
                    <td class="font-10pt text-center line-bt line-bb">ผลกิจกรรม</td>
                </tr>
';

// $table_2.='
//                 <tr>
//                     <td class="font-10pt" colspan="4">&nbsp;</td>
//                 </tr>
// ';


// $table_2.='
//             </table>
//             <table width="100%">
//                 <tr>
//                     <td class="font-12pt">&nbsp;&nbsp;&nbsp;<b>กิจกรรมบังคับ</b></td>
//                     <td class="font-12pt text-right"><b>' . $row_1 . '</b></td>
//                     <td class="font-12pt"><b> กิจกรรม</b></td>
//                     <td class="font-12pt text-center"><b>ผ่าน</b></td>
//                     <td class="font-12pt text-right"><b>' . $total_1 . '</b></td>
//                     <td class="font-12pt"><b> หน่วย</b></td>
//                 </tr>
//                 <tr>
//                     <td class="font-12pt">&nbsp;&nbsp;&nbsp;<b>กิจกรรมบังคับเลือก</b></td>
//                     <td class="font-12pt text-right"><b>' . $row_2 . '</b></td>
//                     <td class="font-12pt"><b> กิจกรรม</b></td>
//                     <td class="font-12pt text-center"><b>ผ่าน</b></td>
//                     <td class="font-12pt text-right"><b>' . $total_2 . '</b></td>
//                     <td class="font-12pt"><b> หน่วย</b></td>
//                 </tr>
//                 <tr>
//                     <td class="font-12pt">&nbsp;&nbsp;&nbsp;<b>กิจกรรมเลือกเข้าร่วม</b></td>
//                     <td class="font-12pt text-right"><b>' . $row_3 . '</b></td>
//                     <td class="font-12pt"><b> กิจกรรม</b></td>
//                     <td class="font-12pt text-center"><b>ผ่าน</b></td>
//                     <td class="font-12pt text-right"><b>' . $total_3 . '</b></td>
//                     <td class="font-12pt"><b> หน่วย</b></td>
//                 </tr>
//                 <tr>
//                     <td class="font-12pt">&nbsp;&nbsp;&nbsp;<b>รวมกิจกรรม</b></td>
//                     <td class="font-12pt text-right"><b>' . ($row_1+$row_2+$row_3) . '</b></td>
//                     <td class="font-12pt"><b> กิจกรรม</b></td>
//                     <td class="font-12pt text-center"><b>ผ่าน</b></td>
//                     <td class="font-12pt text-right"><b>' . ($total_1+$total_2+$total_3) . '</b></td>
//                     <td class="font-12pt"><b> หน่วย</b></td>
//                 </tr>
//                 <tr>
//                     <td class="font-10pt" colspan="6">&nbsp;</td>
//                 </tr>
//                 <tr>
//                     <td class="font-10pt" colspan="6">&nbsp;</td>
//                 </tr>
//                 <tr>
//                     <td class="font-14pt text-center" colspan="6"><b>ผ่านการเข้าร่วมกิจกรรมนักศึกษา</b></td>
//                 </tr>
//             </table>
//         </td>
//     </tr>
// </table>
// ';

$signature = '
<table border="0" width="100%" cellspacing="0" cellpadding="0">
	<tr>
		<td height="40">&nbsp;</td>
	</tr>
	<tr>';
	
	if ($name_left != "") {
        $signature .= '<td align="center" class="font-14pt" width="33.33%">(' . $name_left . ')</td>';
	}
	else{
		$signature .= '<td align="center" class="font-14pt" width="33.33%"></td>';
	}
	
	if ($name_center != "") {
        $signature .= '<td align="center" class="font-14pt" width="33.33%">(' . $name_center . ')</td>';
	}
	else{
		$signature .= '<td align="center" class="font-14pt" width="33.33%"></td>';
	}
	
	if ($name_right != "") {
        $signature .= '<td align="center" class="font-14pt" width="33.33%">(' . $name_right . ')</td>';
	}
	else{
		$signature .= '<td align="center" class="font-14pt" width="33.33%"></td>';
	}
	
$signature .= '
	</tr>
	<tr>';
	
	if ($name_left != "") {
		$signature .= '<td align="center" class="font-14pt" width="33.33%">' . $title_left . '</td>';
	}
	else{
		$signature .= '<td align="center" class="font-14pt" width="33.33%"></td>';
	}
	
	if ($name_center != "") {
		$signature .= '<td align="center" class="font-14pt" width="33.33%">' . $title_center . '</td>';
	}
	else{
		$signature .= '<td align="center" class="font-14pt" width="33.33%"></td>';
	}
	
	if ($name_right != "") {
		$signature .= '<td align="center" class="font-14pt" width="33.33%">' . $title_right . '</td>';
	}
	else{
		$signature .= '<td align="center" class="font-14pt" width="33.33%"></td>';
	}
	
$signature .= '
	</tr>
</table>';

$end_html = "
</body>
</html>";

$mpdf->WriteHTML($start_html);

$mpdf->WriteHTML($head);

$mpdf->WriteHTML($detail);

$mpdf->WriteHTML($table);

// $mpdf->SetHTMLFooter($footer);

// $mpdf->AddPage();

// $mpdf->WriteHTML($table_2);

$mpdf->WriteHTML($signature);

$mpdf->SetHTMLFooter($footer);

$mpdf->WriteHTML($end_html);


// Output a PDF file directly to the browser
$mpdf->Output('transcript_act_' . $_GET['account_id'] . '.pdf', 'I');