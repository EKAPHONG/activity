<?php
// Include the main TCPDF library (search for installation path).
require_once('tcpdf.php');
require_once("THSplitLib/segment.php");
require_once('../includes/connect.inc.php');
require_once('../includes/dateThai.inc.php');

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

// $sql  = $con->query("
// 	SELECT joins.activity_id, activity.activity_name, activity.activity_unit, activity.activity_type FROM `joins` 
// 	INNER JOIN activity ON joins.activity_id = activity.activity_id 
// 	WHERE joins.account_id = '" . $_GET['account_id'] . "' ORDER BY activity.activity_type";

$sql1 = $con->query("SELECT joins.activity_id, joins.join_status, activity.activity_name, activity.activity_unit, activity.activity_type FROM `joins`\n"
	. "INNER JOIN activity ON joins.activity_id = activity.activity_id\n"
	. "WHERE joins.account_id = '" . $_GET['account_id'] . "' AND activity.activity_type = '1' AND joins.join_status = '1' ORDER BY activity.activity_type");

$sql2 = $con->query("SELECT joins.activity_id, joins.join_status, activity.activity_name, activity.activity_unit, activity.activity_type FROM `joins`\n"
	. "INNER JOIN activity ON joins.activity_id = activity.activity_id\n"
	. "WHERE joins.account_id = '" . $_GET['account_id'] . "' AND activity.activity_type = '2' AND joins.join_status = '1' ORDER BY activity.activity_type");

$sql3 = $con->query("SELECT joins.activity_id, joins.join_status, activity.activity_name, activity.activity_unit, activity.activity_type FROM `joins`\n"
	. "INNER JOIN activity ON joins.activity_id = activity.activity_id\n"
	. "WHERE joins.account_id = '" . $_GET['account_id'] . "' AND activity.activity_type > '2' AND joins.join_status = '1' ORDER BY activity.activity_type");

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('ใบแสดงผลการเข้าร่วมกิจกรรม');
$pdf->SetSubject('ใบแสดงผลการเข้าร่วมกิจกรรม');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
// $pdf->SetMargins(11.0, PDF_MARGIN_TOP, 11.0);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->SetTopMargin(8);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set default font subsetting mode
$pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
// $pdf->SetFont('dejavusans', '', 14, '', true);

$pdf->SetFont('RIT95_B', 'B', 16, true);
$pdf->SetFont('THSarabun', '', 16, true);

// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage();


// -- set new background ---

// get the current page break margin
$bMargin = $pdf->getBreakMargin();
// get current auto-page-break mode
$auto_page_break = $pdf->getAutoPageBreak();
// disable auto-page-break
$pdf->SetAutoPageBreak(false, 0);
// set alpha to semi-transparency
$pdf->SetAlpha(0.1);
// set bacground image
$img_file = 'images/logo_RMUTI.png';
$pdf->Image($img_file, 67.4, 130, 75, 143, '', '', 'PNG', false, 600, '', false, false, 0);
// restore full opacity
$pdf->SetAlpha(1);
// restore auto-page-break status
$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
// set the starting point for the page content
$pdf->setPageMark();
// Set some content to print

$html = '
<table>
<tr>
<td width="15%" rowspan="4"><img src="images/logo_RMUTI.png" align="left"></td>
<td width="70%" style="font-family: RIT95_B;" align="center" rowspan="2"><h1>มหาวิทยาลัยเทคโนโลยีราชมงคลอีสาน<br>
วิทยาเขตขอนแก่น</h1></td>
<td width="15%" height="25" style="border-bottom-style: solid; border-bottom-width: 1px"></td>
</tr>
<tr>
<td width="15%" style="font-family: THSarabun; border-right-style:solid; border-right-width:1px; border-top-style:solid; border-top-width:1px" align="center" valign="bottom">
&nbsp;<br>
รูปถ่าย</td>
</tr>
<tr>
<td width="70%" style="font-family: THSarabun_B;" align="center">150 ถ.ศรีจันทร์ ต.ในเมือง อ.เมือง จ.ขอนแก่น 40000</td>
<td width="15%" style="font-family: THSarabun; border-right-style:solid; border-right-width:1px" valign="top" align="center">
ขนาด 1 นิ้ว</td>
</tr>
<tr>
<td width="70%" style="font-family: THSarabun_B;" align="center" valign="bottom">
<h2>ใบแสดงผลการเข้าร่วมกิจกรรม<br>คณะ' . $row_profile["account_faculty"] . '</h2>
</td>
<td width="15%" style="font-family: THSarabun_B;" valign="top" align="center">&nbsp;</td>
</tr>
</table>';


$html .= '
<table>
<tr>
<td width="55%">ชื่อ : ' . $row_profile["account_prefix"] . $row_profile["account_firstname"] . " " . $row_profile["account_lastname"] . ' </td>
<td width="45%"></td>
</tr>
<tr>
<td width="55%">รหัสนักศึกษา : ' . $row_profile["account_id"] . '</td>
<td width="45%">เลขประจําตัวประชาชน : ' . $row_profile["account_idno"] . '</td>
</tr>
<tr>
<td width="55%">ชื่อคุณวุฒิ : ' . $row_profile["account_degree"] . '</td>
<td width="45%">วันเกิด : ' . thai_date_thaiyear(strtotime($row_profile["account_birthday"])) . '</td>
</tr>
<tr>
<td width="55%">สาขาวิชา : ' . $row_profile["account_department"] . '</td>
<td width="45%">วันที่ผ่านการเข้าร่วมกิจกรรม : ' . thai_date_thaiyear(strtotime(date("Y-m-d"))) . '</td>
</tr>
<tr>
<td colspan="2"></td>
</tr>
</table>
';

$html .= '
<table border="1" width="100%">
<tr>
<td valign="top">
<table border="0" width="100%">
<tr>
<td align="center" style="font-family: THSarabun_B;" width="25%">รหัสกิจกรรม</td>
<td align="center" style="font-family: THSarabun_B;" width="64%">ชื่อกิจกรรม</td>
<td align="center" style="font-family: THSarabun_B;" width="11%">หน่วย</td>
</tr>
';

while ($row_sql1 = $sql1->fetch()) {
	if ($row_sql1["activity_type"] == '1' && $type_1 == '0') {
		$html .= '<tr>
		<td></td>
		<td align="center" style="font-family: THSarabun_B; font-size: 14;">กิจกรรมบังคับ</td>
		<td></td>
		</tr>';
		$type_1 = 1;
	}
	
	$html .= '
	<tr>
	<td align="center" style="font-size: 14;">' . $row_sql1["activity_id"] . '</td>
	<td style="font-size: 14; word-wrap: break-word;">' . $row_sql1["activity_name"] . '</td>
	<td align="center" style="font-size: 14;">' . $row_sql1["activity_unit"] . '</td>
	</tr>';

	$row_1++;
	$total_1 += $row_sql1["activity_unit"];
} // END OF WHILE

$html .= '
<tr>
<td align="center" style="font-family: THSarabun_B; font-size: 14;" colspan="3">เข้าร่วม : <u> ' . $row_1 . ' </u> กิจกรรม&nbsp;&nbsp;&nbsp;จำนวนหน่วย : <u> ' . $total_1 . ' </u> หน่วย</td>
</tr>
<tr>
<td colspan="3"></td>
</tr>';
		// END OF TYPE 1






while ($row_sql2 = $sql2->fetch()) {
	if ($row_sql2["activity_type"] == '2' && $type_2 == '0') {
		$html .= '<tr>
		<td></td>
		<td align="center" style="font-family: THSarabun_B; font-size: 14;">กิจกรรมบังคับเลือก</td>
		<td></td>
		</tr>';
		$type_2 = 1;
	}
	
	$html .= '
	<tr>
	<td align="center" style="font-size: 14;">' . $row_sql2["activity_id"] . '</td>
	<td style="font-size: 14; word-wrap: break-word;">' . $row_sql2["activity_name"] . '</td>
	<td align="center" style="font-size: 14;">' . $row_sql2["activity_unit"] . '</td>
	</tr>';

	$row_2++;
	$total_2 += $row_sql2["activity_unit"];
} // END OF WHILE

$html .= '
<tr>
<td align="center" style="font-family: THSarabun_B; font-size: 14;" colspan="3">เข้าร่วม : <u> ' . $row_2 . ' </u> กิจกรรม&nbsp;&nbsp;&nbsp;จำนวนหน่วย : <u> ' . $total_2 . ' </u> หน่วย</td>
</tr>
<tr>
<td colspan="3"></td>
</tr>';
		// END OF TYPE 2







$html .= '</table></td>';

$html .= '
<td valign="top">
<table border="0" width="100%">
<tr>
<td align="center" style="font-family: THSarabun_B;" width="25%">รหัสกิจกรรม</td>
<td align="center" style="font-family: THSarabun_B;" width="64%">ชื่อกิจกรรม</td>
<td align="center" style="font-family: THSarabun_B;" width="11%">หน่วย</td>
</tr>
';


while ($row_sql3 = $sql3->fetch()) {
	if ($row_sql3["activity_type"] > '2' && $type_3 == '0') {
		$html .= '<tr>
		<td></td>
		<td align="center" style="font-family: THSarabun_B; font-size: 14;">กิจกรรมเลือกเข้าร่วม</td>
		<td></td>
		</tr>';
		$type_3 = 1;
	}

	$segment = new Segment();

	$words = $segment->get_segment_array($row_sql3["activity_name"]);

	$text = implode("|",$words); // add word bound
	
	$html .= '
	<tr>
	<td align="center" style="font-size: 14;">' . $row_sql3["activity_id"] . '</td>
	<td style="font-size: 14; word-wrap: break-word;">' . $text . '</td>
	<td align="center" style="font-size: 14;">' . $row_sql3["activity_unit"] . '</td>
	</tr>';

	$row_3++;
	$total_3 += $row_sql3["activity_unit"];
	if ($row_3 == 10) {
		$html .= '</table></td>';
		// $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
		// $pdf->Output('example_001.pdf', 'I');
		$html .= '
		</tr>
		</table>
		';
		break;
	}
} // END OF WHILE


$html .= "<table border=\"0\" width=\"100%\">";

$html .= "<tr>";
$html .= "<td align=\"center\" width=\"50%\"></td>";
$html .= "<td align=\"center\" width=\"50%\"></td>";
$html .= "</tr>";


$html .= "<tr>";
$html .= "<td align=\"center\" width=\"50%\"></td>";
$html .= "<td align=\"center\" width=\"50%\"></td>";
$html .= "</tr>";

$html .= "<tr>";
$html .= "<td align=\"center\" width=\"50%\"></td>";
$html .= "<td align=\"center\" width=\"50%\"></td>";
$html .= "</tr>";

$html .= "<td align=\"center\" width=\"50%\"></td>";
$html .= "<td align=\"center\" width=\"50%\">(นายชื่อ นามสกุล)</td>";
$html .= "</tr>";

$html .= "<tr>";
$html .= "<td align=\"center\" width=\"50%\">เอกสารนี้จะสมบูรณ์ก็ต่อเมื่อมีตราประทับของมหาวิทยาลัย</td>";
$html .= "<td align=\"center\" width=\"50%\">คณะ" . $row_profile["account_faculty"] . "</td>";
$html .= "</tr>";

$html .= "<tr>";
$html .= "<td align=\"center\" width=\"50%\"></td>";
$html .= "<td align=\"center\" width=\"50%\">วันที่ออกเอกรสาร</td>";
$html .= "</tr>";

$html .= "</table>";

// $row_sql3 = $sql3->fetch();
// $html .= '
// <tr>
// <td align="center" style="font-size: 14;">' . $row_sql3["activity_id"] . '</td>
// <td style="font-size: 14; word-wrap: break-word;">' . $row_sql3["activity_name"] . '</td>
// <td align="center" style="font-size: 14;">' . $row_sql3["activity_unit"] . '</td>
// </tr>';

// $html .= '
// <tr>
// <td align="center" style="font-family: THSarabun_B; font-size: 14;" colspan="3">เข้าร่วม : <u> ' . $row_3 . ' </u> กิจกรรม&nbsp;&nbsp;&nbsp;จำนวนหน่วย : <u> ' . $total_3 . ' </u> หน่วย</td>
// </tr>
// <tr>
// <td align="center" style="font-family: THSarabun_B; font-size: 14;" colspan="3">รวมตลอดหลักสูตร : <u> ' . ($row_1+$row_2+$row_3) . ' </u> กิจกรรม&nbsp;&nbsp;จำนวนหน่วย : <u> ' . ($total_1+$total_2+$total_3) . ' </u> หน่วย</td>
// </tr>
// <tr>
// <td colspan="3"></td>
// </tr>';
// 		// END OF TYPE 3







// $html .= '</table></td>';

// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage();


// -- set new background ---

// get the current page break margin
$bMargin = $pdf->getBreakMargin();
// get current auto-page-break mode
$auto_page_break = $pdf->getAutoPageBreak();
// disable auto-page-break
$pdf->SetAutoPageBreak(false, 0);
// set alpha to semi-transparency
$pdf->SetAlpha(0.3);
// set bacground image
$img_file = 'images/logo_RMUTI.png';
$pdf->Image($img_file, 67.4, 130, 75, 143, '', '', 'PNG', false, 600, '', false, false, 0);
// restore full opacity
$pdf->SetAlpha(1);
// restore auto-page-break status
$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
// set the starting point for the page content
$pdf->setPageMark();
// Set some content to print


$html2 = "<h1>Hello!</h1>";





$pdf->writeHTMLCell(0, 0, '', '', $html2, 0, 1, 0, true, '', true);

// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('example_001.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>