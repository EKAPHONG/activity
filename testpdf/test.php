<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once("thsplitlib/segment.php");

$segment = new Segment();

$test_text = "กิจกรรมภาษาไทย หรือ ภาษาไทยกลาง เป็นภาษาราชการและภาษาประจำชาติของประเทศไทย ภาษาไทยเป็นภาษาในกลุ่มภาษาไท ซึ่งเป็นกลุ่มย่อยของตระกูลภาษาไท-กะได สันนิษฐานว่า ภาษาในตระกูลนี้มีถิ่นกำเนิดจากทางตอนใต้ของประเทศจีน และนักภาษาศาสตร์บางส่วนเสนอว่า ภาษาไทยน่าจะมีความเชื่อมโยงกับตระกูลภาษาออสโตร-เอเชียติก ตระกูลภาษาออสโตรนีเซียน และตระกูลภาษาจีน-ทิเบต
ภาษาไทยเป็นภาษาที่มีระดับเสียงของคำแน่นอนหรือวรรณยุกต์เช่นเดียวกับภาษาจีน และออกเสียงแยกคำต่อคำ
ภาษาไทยปรากฏครั้งแรกในพุทธศักราช 1826 โดยพ่อขุนรามคำแหง และปรากฏอย่างสากลและใช้ในงานของราชการ เมื่อวันที่ 31 มีนาคม พุทธศักราช 2476 ด้วยการก่อตั้งสำนักงานราชบัณฑิตยสภาขึ้น และปฏิรูปภาษาไทย พุทธศักราช 2485";
$words = $segment->get_segment_array($test_text);


#print_r($words);
#exit();

$text = implode("|",$words); // add word bound

//custom font
$defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
$fontDirs = $defaultConfig['fontDir'];

$defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
$fontData = $defaultFontConfig['fontdata'];

$mpdf = new \Mpdf\Mpdf([
    'fontDir' => array_merge($fontDirs, [
        __DIR__ . '/fonts',
    ]),
    'fontdata' => $fontData + [
            'sarabun' => [
                'R' => 'THSarabun.ttf',
                'I' => 'THSarabunNew Italic.ttf',
                'B' =>  'THSarabunNew Bold.ttf',
                'useOTL' => 0xFF,
            ]
        ],
]);

//$mpdf = new \Mpdf\Mpdf();
$mpdf->useDictionaryLBR = false;
$mpdf->checkCJK = true;

$content = '

<style>
.container{
    font-family: "sarabun";
    font-size: 12pt;
}
p{
    text-align: justify;
}
h1{
    text-align: center;
}
</style>

<div class="container" style="width: 50%">
<h1>ภาษาไทย</h1>
<p>
'.$text.'
</p>
</div>
';


$mpdf->WriteHTML($content);

$mpdf->Output();
?>