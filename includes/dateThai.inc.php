<?php
$thai_day_arr=array("อาทิตย์","จันทร์","อังคาร","พุธ","พฤหัสบดี","ศุกร์","เสาร์"); 
$thai_month_arr=array( 
  "0"=>"", 
  "1"=>"มกราคม", 
  "2"=>"กุมภาพันธ์", 
  "3"=>"มีนาคม", 
  "4"=>"เมษายน", 
  "5"=>"พฤษภาคม", 
  "6"=>"มิถุนายน",
  "7"=>"กรกฎาคม", 
  "8"=>"สิงหาคม", 
  "9"=>"กันยายน", 
  "10"=>"ตุลาคม", 
  "11"=>"พฤศจิกายน", 
  "12"=>"ธันวาคม"
);
$thai_month_arr_short=array( 
  "0"=>"", 
  "1"=>"ม.ค.", 
  "2"=>"ก.พ.", 
  "3"=>"มี.ค.", 
  "4"=>"เม.ย.", 
  "5"=>"พ.ค.", 
  "6"=>"มิ.ย.",
  "7"=>"ก.ค.", 
  "8"=>"ส.ค.", 
  "9"=>"ก.ย.", 
  "10"=>"ต.ค.", 
  "11"=>"พ.ย.", 
  "12"=>"ธ.ค."
); 
function thai_date_and_time($time){ // 19 ธันวาคม 2556 เวลา 10:10:43
  global $thai_day_arr,$thai_month_arr; 
  $thai_date_return = date("j",$time); 
  $thai_date_return.=" ".$thai_month_arr[date("n",$time)]; 
  $thai_date_return.= " ".(date("Y",$time)+543); 
  $thai_date_return.= " เวลา ".date("H:i:s",$time);
  return $thai_date_return; 
} 
function thai_date_and_time_short($time){ // 19ธ.ค. 2556 10:10:4
  global $thai_day_arr,$thai_month_arr_short; 
  $thai_date_return = date("j",$time); 
  $thai_date_return.="&nbsp;&nbsp;".$thai_month_arr_short[date("n",$time)]; 
  $thai_date_return.= " ".(date("Y",$time)+543); 
  $thai_date_return.= " ".date("H:i:s",$time);
  return $thai_date_return; 
} 
function thai_date_short($time){ // 19ธ.ค. 2556
  global $thai_day_arr,$thai_month_arr_short; 
  $thai_date_return = date("j",$time); 
  $thai_date_return.="&nbsp;&nbsp;".$thai_month_arr_short[date("n",$time)]; 
  $thai_date_return.= " ".(date("Y",$time)+543); 
  return $thai_date_return; 
} 
function thai_date_fullmonth($time){ // 19 ธันวาคม 1994
  global $thai_day_arr,$thai_month_arr;
  $thai_date_return = date("j",$time);
  $thai_date_return.=" ".$thai_month_arr[date("n",$time)];
  $thai_date_return.= " ".(date("Y",$time));
// $thai_date_return.= " ".(date("Y",$time)+543);
  return $thai_date_return; 
}
function thai_date_thaiyear($time){ // 19 ธันวาคม 2556
  global $thai_day_arr,$thai_month_arr; 
  $thai_date_return = date("j",$time); 
  $thai_date_return.=" ".$thai_month_arr[date("n",$time)];
  $thai_date_return.= " ".(date("Y",$time)+543);
  return $thai_date_return; 
}
function convert_format($time){         // 31/12/2537 -> 1994-12-31  ***เพื่อจัดรูปแบบให้เข้ากับฐานข้อมูล***
  $date  = substr($time,0,2);           // ตัดเอาวันที่ เริ่มจากช่องที่ 0 จำนวน ไปทางขวา 2 ช่อง
  $month = substr($time,3,2);           // ตัดเอาเดือนที่ เริ่มจากช่องที่ 3 จำนวน ไปทางขวา 2 ช่อง
  $year  = substr($time,6,4)-543;       // ตัดเอาปี พ.ศ. เริ่มจากช่องที่ 6 จำนวน ไปทางขวา 4 ช่อง แล้วลบออก 543 เพื่อให้เป็นปี ค.ศ.
  $output= $year."-".$month."-".$date;  // นำมาจัดเรียงใหม่ เก็บเข้าตัวแปร $output
  return $output;                       // Return ค่าในตัวแปร $output
}
function revert_pattern($time){         // 2019-01-04 -> 04/01/2562  ***จัดรูปแบบให้แสดงผลได้ถูกต้อง***
  $year  = substr($time,0,4)+543;           // ตัดเอาปี ค.ศ. เริ่มจากช่องที่ 0 จำนวน ไปทางขวา 4 ช่อง แล้วบวกเพิ่ม 543 เพื่อให้เป็นปี พ.ศ.
  $month = substr($time,5,2);           // ตัดเอาเดือนที่ เริ่มจากช่องที่ 6 จำนวน ไปทางขวา 2 ช่อง
  $date  = substr($time,8,2);           // ตัดเอาวันที่ เริ่มจากช่องที่ 9 จำนวน ไปทางขวา 2 ช่อง 
  $output= $date."/".$month."/".$year;  // นำมาจัดเรียงใหม่ เก็บเข้าตัวแปร $output
  return $output;                       // Return ค่าในตัวแปร $output
}
function thai_date_short_number($time){ // 19-12-56
  global $thai_day_arr,$thai_month_arr; 
  $thai_date_return = date("d",$time); 
  $thai_date_return.="-".date("m",$time); 
  $thai_date_return.= "-".substr((date("Y",$time)+543),-2); 
  return $thai_date_return; 
}
function format_activity_id($activity_id){ // 19-12-56
  $output = substr($activity_id,0,2) . "-";
  $output.= substr($activity_id,2,3) . "-";
  $output.= substr($activity_id,5,3) . "-";
  $output.= substr($activity_id,8,3);
  return $output;
}
function thai_to_db($time){ // 19 ธันวาคม 2556
  $thai_date = explode(" ",$time);
  if ($thai_date[1] == 'มกราคม') {
    $thai_date[1] = '01';
  } elseif ($thai_date[1] == 'กุมภาพันธ์') {
    $thai_date[1] = '02';
  } elseif ($thai_date[1] == 'มีนาคม') {
    $thai_date[1] = '03';
  } elseif ($thai_date[1] == 'เมษายน') {
    $thai_date[1] = '04';
  } elseif ($thai_date[1] == 'พฤษภาคม') {
    $thai_date[1] = '05';
  } elseif ($thai_date[1] == 'มิถุนายน') {
    $thai_date[1] = '06';
  } elseif ($thai_date[1] == 'กรกฎาคม') {
    $thai_date[1] = '07';
  } elseif ($thai_date[1] == 'สิงหาคม') {
    $thai_date[1] = '08';
  } elseif ($thai_date[1] == 'กันยายน') {
    $thai_date[1] = '09';
  } elseif ($thai_date[1] == 'ตุลาคม') {
    $thai_date[1] = '10';
  } elseif ($thai_date[1] == 'พฤศจิกายน') {
    $thai_date[1] = '11';
  } else {
    $thai_date[1] = '12';
  }
  $thai_date_return = $thai_date[0] . ' ' . $thai_date[1];
  return $thai_date_return; 
}
?>