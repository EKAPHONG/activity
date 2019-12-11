<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'vendor/autoload.php';
require_once 'vendor/THSplitLib/segment.php';
require_once 'includes/connect.inc.php';
require_once 'includes/dateThai.inc.php';

$type_1 = 0;
$type_2 = 0;
$type_3 = 0;

$row_1 = 0;
$row_2 = 0;
$row_3 = 0;

$total_1 = 0;
$total_2 = 0;
$total_3 = 0;

$profile = $con->query("SELECT * FROM `account` WHERE account_id = '" . $_GET['account_id'] . "'");
$row_profile = $profile->fetch();

$sql1 = $con->query("SELECT joins.activity_id, joins.join_status, activity.activity_name, activity.activity_unit, activity.activity_type FROM `joins`\n"
	. "INNER JOIN activity ON joins.activity_id = activity.activity_id\n"
	. "WHERE joins.account_id = '" . $_GET['account_id'] . "' AND activity.activity_type = '1' AND joins.join_status = '1' ORDER BY activity.activity_type");

$sql2 = $con->query("SELECT joins.activity_id, joins.join_status, activity.activity_name, activity.activity_unit, activity.activity_type FROM `joins`\n"
	. "INNER JOIN activity ON joins.activity_id = activity.activity_id\n"
	. "WHERE joins.account_id = '" . $_GET['account_id'] . "' AND activity.activity_type = '2' AND joins.join_status = '1' ORDER BY activity.activity_type");

$sql3 = $con->query("SELECT joins.activity_id, joins.join_status, activity.activity_name, activity.activity_unit, activity.activity_type FROM `joins`\n"
	. "INNER JOIN activity ON joins.activity_id = activity.activity_id\n"
	. "WHERE joins.account_id = '" . $_GET['account_id'] . "' AND activity.activity_type > '2' AND joins.join_status = '1' ORDER BY activity.activity_type");



/* ==================================================================================== */



$mpdf = new \Mpdf\Mpdf();

$defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
$fontDirs = $defaultConfig['fontDir'];

$defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
$fontData = $defaultFontConfig['fontdata'];

$mpdf = new \Mpdf\Mpdf([
    'fontDir' => array_merge($fontDirs, [
        __DIR__ . '/fonts',
    ]),
    'fontdata' => $fontData + [
        'thsarabun' => [
            'R' => 'THSarabunNew.ttf',
            'I' => 'THSarabunNew Italic.ttf',
            'B' => 'THSarabunNew Bold.ttf',
            'BI' => 'THSarabunNew BoldItalic.ttf',
        ]
    ],
    'default_font' => 'thsarabun'
]);

// ปิดการใช้งานตัวตัดคำของ mPDF
$mpdf->useDictionaryLBR = false;

// ปิดการหดตารางอัตโนมัติ
// $mpdf->shrink_tables_to_fit = 1;
$keep_table_proportions = true;

// Cascading Style Sheets (CSS)
$content = "
<style type=\"text/css\">
	.center{
		text-align: center;
	}
	table{
		overflow: hidden;
	}
	td.bold{
		font-weight: bold;
	}
	td.12pt{
		font-size: 12pt;
	}
	td.14pt{
		font-size: 14pt;
	}
	td.15pt{
		font-size: 15pt;
	}
	td.16pt{
		font-size: 16pt;
	}
	td.20pt{
		font-size: 20pt;
	}
	td.22px{
		font-size: 22px;
	}
	td.28px{
		font-size: 28px;
	}
</style>
";

// ส่วนหัวของกระดาษ Logo, ชื่อมหาวิทยาลัย, ช่องติดรูปถ่าย
$content .= "
<table border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">
	<tr>
		<td rowspan=\"5\" width=\"15%\">
		<img border=\"0\" src=\"images/logo_RMUTI.png\" width=\"80\"></td>
		<td class=\"center 28px bold\"><b>มหาวิทยาลัยเทคโนโลยีราชมงคลอีสาน</b></td>
		<td width=\"15%\"></td>
	</tr>
	<tr>
		<td class=\"center 28px bold\"><b>วิทยาเขตขอนแก่น</b></td>
		<td width=\"15%\" style=\"text-align: center; font-size: 16pt; border-right-style: solid; border-right-width: 1px; border-top-style: solid; border-top-width: 1px\" bordercolor=\"#000000\">รูปถ่าย</td>
	</tr>
	<tr>
		<td class=\"center 15pt bold\">150 ถ.ศรีจันทร์ ต.ในเมือง อ.เมือง จ.ขอนแก่น 40000</td>
		<td width=\"15%\" style=\"text-align: center; font-size: 16pt; border-right-style: solid; border-right-width: 1px\" bordercolor=\"#000000\">ขนาด 1 นิ้ว</td>
	</tr>
	<tr>
		<td class=\"center 22px bold\">ใบแสดงผลการเข้าร่วมกิจกรรม</td>
		<td width=\"15%\"></td>
	</tr>
	<tr>
		<td class=\"center 22px bold\">คณะ" . $row_profile["account_faculty"] . "</td>
		<td width=\"15%\"></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
</table>
";

// ส่วน Details แสดงรายละเอียดของนักศึกษา
$content .= "
<table border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">
	<tr>
		<td width=\"15%\" class=\"16pt\">ชื่อ</td>
		<td width=\"43%\" class=\"16pt\">" . $row_profile["account_prefix"] . $row_profile["account_firstname"] . " " . $row_profile["account_lastname"] . "</td>
		<td width=\"25%\" class=\"16pt\">เลขประจำตัวประชาชน</td>
		<td width=\"17%\" class=\"16pt\">" . $row_profile["account_idno"] . "</td>
	</tr>
	<tr>
		<td class=\"16pt\">รหัสนักศึกษา</td>
		<td class=\"16pt\">" . $row_profile["account_id"] . "</td>
		<td class=\"16pt\">วันเกิด</td>
		<td class=\"16pt\">" . thai_date_thaiyear(strtotime($row_profile["account_birthday"])) . "</td>
	</tr>
		<tr>
		<td class=\"16pt\" valign=\"top\">ชื่อคุณวุฒิ</td>
		<td class=\"16pt\">" . $row_profile["account_degree"] . "</td>
		<td class=\"16pt\" valign=\"top\">วันที่เข้าศึกษา</td>
		<td class=\"16pt\" valign=\"top\">" . thai_date_thaiyear(strtotime($row_profile["account_birthday"])) . "</td>
	</tr>
	<tr>
		<td class=\"16pt\">สาขาวิชา</td>
		<td class=\"16pt\">" . $row_profile["account_department"] . "</td>
		<td class=\"16pt\">วันที่ผ่านการเข้าร่วมกิจกรรม</td>
		<td class=\"16pt\">" . thai_date_thaiyear(strtotime(date("Y-m-d"))) . "</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
</table>
";

// ส่วนแสดงรายการกิจกรรม

$content .= "
<table autosize=\"1\" border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">
	<tr>
";

$content .= "
		<td style=\"border-left-style: solid; border-left-width: 1px; border-right-style: none; border-right-width: medium; border-top-style: solid; border-top-width: 1px; border-bottom-style: solid; border-bottom-width: 1px\" valign=\"top\" width=\"50%\" nowrap=\"nowrap\">
			<table autosize=\"1\" border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">
				<tr>
					<td width=\"11%\" align=\"center\" class=\"14pt bold\">รหัสกิจกรรม</td>
					<td width=\"85%\" align=\"center\" class=\"14pt bold\">ชื่อกิจกรรม</td>
					<td width=\"4%\" align=\"center\" class=\"14pt bold\">หน่วย</td>
				</tr>
";

while ($row_sql1 = $sql1->fetch()) {
	$segment = new Segment();
	$result = $segment->get_segment_array($row_sql1["activity_name"]);
	$text = implode("|",$result);

	if ($row_sql1["activity_type"] == '1' && $type_1 == '0') {
		$content .= "
				<tr>
					<td>&nbsp;</td>
					<td align=\"center\" class=\"14pt bold\">กิจกรรมบังคับ</td>
					<td>&nbsp;</td>
				</tr>";
		$type_1 = 1;
	}

	$content .= "
				<tr>
					<td nowrap=\"nowrap\" align=\"center\" class=\"14pt\" valign=\"top\">" . $row_sql1["activity_id"] . "</td>
					<td nowrap=\"nowrap\" class=\"14pt\">" . $text . "</td>
					<td nowrap=\"nowrap\" align=\"center\" class=\"14pt\" valign=\"top\">" . $row_sql1["activity_unit"] . "</td>
				</tr>
	";

	$row_1++;
	$total_1 += $row_sql1["activity_unit"];
}

$content .= "
				<tr>
					<td align=\"center\" class=\"14pt bold\" colspan=\"3\">เข้าร่วม : <u>&nbsp;" . $row_1 . "&nbsp;</u> กิจกรรม&nbsp;&nbsp;&nbsp;จำนวนหน่วย : <u>&nbsp;" . $total_1 . "&nbsp;</u> หน่วย</td>
				</tr>
				<tr>
					<td colspan=\"3\" class=\"14pt\">&nbsp;</td>
				</tr>";
// END OF TYPE 1

while ($row_sql2 = $sql2->fetch()) {
	$segment = new Segment();
	$result = $segment->get_segment_array($row_sql2["activity_name"]);
	$text = implode("|",$result);

	if ($row_sql2["activity_type"] == '2' && $type_2 == '0') {
		$content .= "
				<tr>
					<td>&nbsp;</td>
					<td align=\"center\" class=\"14pt bold\">กิจกรรมบังคับเลือก</td>
					<td>&nbsp;</td>
				</tr>";
		$type_2 = 1;
	}

	$content .= "
				<tr>
					<td nowrap=\"nowrap\" align=\"center\" class=\"14pt\">" . $row_sql2["activity_id"] . "</td>
					<td nowrap=\"nowrap\" class=\"14pt\">" . $text . "</td>
					<td nowrap=\"nowrap\" align=\"center\" class=\"14pt\">" . $row_sql2["activity_unit"] . "</td>
				</tr>
	";

	$row_2++;
	$total_2 += $row_sql2["activity_unit"];
}

$content .= "
				<tr>
					<td align=\"center\" class=\"14pt bold\" colspan=\"3\">เข้าร่วม : <u>&nbsp;" . $row_2 . "&nbsp;</u> กิจกรรม&nbsp;&nbsp;&nbsp;จำนวนหน่วย : <u>&nbsp;" . $total_2 . "&nbsp;</u> หน่วย</td>
				</tr>
				<tr>
					<td colspan=\"3\">&nbsp;</td>
				</tr>
			</table>
		</td>
";
// END OF TYPE 2

// $content .= "
// 		</td>
// ";

$content .= "
		<td style=\"border-style: solid; border-width: 1px\" valign=\"top\" width=\"50%\" nowrap=\"nowrap\">
			<table autosize=\"1\" border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">
				<tr>
					<td width=\"11%\" align=\"center\" class=\"14pt bold\">รหัสกิจกรรม</td>
					<td width=\"85%\" align=\"center\" class=\"14pt bold\">ชื่อกิจกรรม</td>
					<td width=\"4%\" align=\"center\" class=\"14pt bold\">หน่วย</td>
				</tr>
";

while ($row_sql3 = $sql3->fetch()) {
	$segment = new Segment();
	$result = $segment->get_segment_array($row_sql3["activity_name"]);
	$text = implode("|",$result);

	if ($row_sql3["activity_type"] >= '3' && $type_3 == '0') {
		$content .= "
				<tr>
					<td>&nbsp;</td>
					<td align=\"center\" class=\"14pt bold\">กิจกรรมเลือกเข้าร่วม</td>
					<td>&nbsp;</td>
				</tr>";
		$type_3 = '1';
	}

	$content .= "
				<tr>
					<td nowrap=\"nowrap\" align=\"center\" class=\"14pt\" valign=\"top\">" . $row_sql3["activity_id"] . "</td>
					<td nowrap=\"nowrap\" class=\"14pt\"><p>" . $text . "</p></td>
					<td nowrap=\"nowrap\" align=\"center\" class=\"14pt\" valign=\"top\">" . $row_sql3["activity_unit"] . "</td>
				</tr>
	";

	$row_3++;
	$total_3 += $row_sql3["activity_unit"];

	// if ($row_3 == ($row_1+$row_2)-4) {
	if ($row_3 == 12) {
		if (isset($row_sql3)) {
			$content .= "
				<tr>
					<td colspan=\"3\" class=\"14pt\">&nbsp;</td>
				</tr>
				<tr>
					<td colspan=\"3\" class=\"14pt bold\" align=\"center\">( มีต่อ )</td>
				</tr>
				<tr>
					<td colspan=\"3\" class=\"14pt\">&nbsp;</td>
				</tr>";
		}
		

		$content .= "
			</table>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
</table>
		";

		$content .= "
		<table border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">
			<tr>
				<td height=\"50\">&nbsp;</td>
			</tr>
			<tr>
				<td align=\"center\" class=\"14pt bold\" width=\"50%\">เอกสารนี้จะสมบูรณ์ก็ต่อเมื่อมีตราประทับของมหาวิทยาลัย</td>
				<td align=\"center\" class=\"14pt bold\">( นายปริญ นาชัยสิทธิ์ )</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td align=\"center\" class=\"14pt bold\">คณบดีคณะ" . $row_profile["account_faculty"] . "</td>
			</tr>
		</table>
";
		break;
	}
}

// $content .= "
// 				<tr>
// 					<td align=\"center\" class=\"14pt bold\" colspan=\"3\">เข้าร่วม : <u>&nbsp;" . $row_3 . "&nbsp;</u> กิจกรรม&nbsp;&nbsp;&nbsp;จำนวนหน่วย : <u>&nbsp;" . $total_3 . "&nbsp;</u> หน่วย</td>
// 				</tr>
// 				<tr>
// 					<td colspan=\"3\">&nbsp;</td>
// 				</tr>
// 			</table>
// 		</td>
// ";


// $content .= "
// 	</tr>
// </table>
// ";
// END OF TYPE 3

$mpdf->WriteHTML($content);

$mpdf->AddPage();

$content2 = "
<table autosize=\"1\" border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">
	<tr>
";

$content2 .= "
		<td style=\"border-left-style: solid; border-left-width: 1px; border-right-style: none; border-right-width: medium; border-top-style: solid; border-top-width: 1px; border-bottom-style: solid; border-bottom-width: 1px\" valign=\"top\" width=\"50%\" nowrap=\"nowrap\">
			<table autosize=\"1\" border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">
				<tr>
					<td width=\"11%\" align=\"center\" class=\"14pt bold\">รหัสกิจกรรม</td>
					<td width=\"85%\" align=\"center\" class=\"14pt bold\">ชื่อกิจกรรม</td>
					<td width=\"4%\" align=\"center\" class=\"14pt bold\">หน่วย</td>
				</tr>
";

while ($row_sql3 = $sql3->fetch()) {
	$segment = new Segment();
	$result = $segment->get_segment_array($row_sql3["activity_name"]);
	$text = implode("|",$result);

	if ($row_sql3["activity_type"] >= '3' && $type_3 == '1') {
		$content2 .= "
				<tr>
					<td>&nbsp;</td>
					<td align=\"center\" class=\"14pt bold\">กิจกรรมเลือกเข้าร่วม (ต่อ)</td>
					<td>&nbsp;</td>
				</tr>";
		$type_3 = '2';
	}

	$content2 .= "
				<tr>
					<td nowrap=\"nowrap\" align=\"center\" class=\"14pt\" valign=\"top\">" . $row_sql3["activity_id"] . "</td>
					<td nowrap=\"nowrap\" class=\"14pt\">" . $text . "</td>
					<td nowrap=\"nowrap\" align=\"center\" class=\"14pt\" valign=\"top\">" . $row_sql3["activity_unit"] . "</td>
				</tr>
	";

	$row_3++;
	$total_3 += $row_sql3["activity_unit"];
}

$content2 .= "
				<tr>
					<td align=\"center\" class=\"14pt bold\" colspan=\"3\">เข้าร่วม : <u>&nbsp;" . $row_3 . "&nbsp;</u> กิจกรรม&nbsp;&nbsp;&nbsp;จำนวนหน่วย : <u>&nbsp;" . $total_3 . "&nbsp;</u> หน่วย</td>
				</tr>
				<tr>
					<td colspan=\"3\">&nbsp;</td>
				</tr>
			</table>
		</td>
";

$content2 .= "
		<td style=\"border-style: solid; border-width: 1px\" valign=\"top\" width=\"50%\" nowrap=\"nowrap\">
			<table autosize=\"1\" border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\">
				<tr>
					<td width=\"11%\" align=\"center\" class=\"14pt bold\">รหัสกิจกรรม</td>
					<td width=\"85%\" align=\"center\" class=\"14pt bold\">ชื่อกิจกรรม</td>
					<td width=\"4%\" align=\"center\" class=\"14pt bold\">หน่วย</td>
				</tr>
";

$content2 .= "
			</table>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
</table>
";

$mpdf->WriteHTML($content2);
$mpdf->Output();