<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require 'includes/connect.inc.php';

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

//ฟิลด์ที่จะเอามาแสดงและค้นหา
$columns = array( 
// datatable column index  => database column name
	0 => 'activity_id',		// รหัสกิจกรรม
	1 => 'activity_name',	// ชื่อกิจกรรม
	2 => 'activity_unit',	// จำนวนหน่วยกิจกรรม
	3 => 'activity_date',	// วันที่จัดกิจกรรม
	4 => 'activity_term',	// ภาคเรียนที่
	5 => 'activity_year',	// ปีการศึกษา
	6 => 'activity_status'	// สถานะ เปิด/ปิด กิจกรรม
);

// getting total number records without any search
$sql = "SELECT activity_id, activity_name, activity_unit, activity_date, activity_term, activity_year, activity_status ";
$sql.= "FROM activity";
$query=$con->query($sql);
$totalData = $query->rowCount();
//$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");
//$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql = "SELECT activity_id, activity_name, activity_unit, activity_date, activity_term, activity_year, activity_status ";
$sql.=" FROM activity WHERE 1=1";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
$sql.=" AND ( activity_id LIKE '".$requestData['search']['value']."%' ";
$sql.=" OR activity_name LIKE '".$requestData['search']['value']."%' ";
$sql.=" OR activity_year LIKE '".$requestData['search']['value']."%' )";
}

//$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");
//$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. 

$query=$con->query($sql);
$totalFiltered = $query->rowCount();
$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]." ".$requestData['order'][0]['dir']." LIMIT ".$requestData['start']." ,".$requestData['length']."";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */
//$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get employees");
$query=$con->query($sql);
$data = array();
//while( $row=mysqli_fetch_array($query) ) {  // preparing an array
while( $row=$query->fetch() ) {  // preparing an array
	$nestedData=array(); 

	$nestedData[] = $row["activity_id"];
	$nestedData[] = $row["activity_name"];
	$nestedData[] = $row["activity_unit"];
	$nestedData[] = $row["activity_date"];
	$nestedData[] = $row["activity_term"];
	$nestedData[] = $row["activity_year"];
	$nestedData[] = $row["activity_status"];
	
	$data[] = $nestedData;
}



$json_data = array(
			"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
			"recordsTotal"    => intval( $totalData ),  // total number of records
			"recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
			"data"            => $data   // total data array
		);

echo json_encode($json_data);  // send data as json format

?>