<?php
namespace EKAPHONG;
class XML_RPC {
	public function getEncrypt($server, $app_id, $secret, $plaintext) {
		{
			$request = xmlrpc_encode_request("getEncrypt", array($app_id, $secret, $plaintext));
			$context = stream_context_create(array('http' => array(
				'method' => "POST",
				'header' => "Content-Type: text/xml",
				'content' => $request
			)));
			$file = file_get_contents($server, false, $context);
			$response = xmlrpc_decode($file);
			return $response;
		}
	}

	public function getDecrypt($server, $app_id, $secret, $ciphertext) {
		{
			$request = xmlrpc_encode_request("getDecrypt", array($app_id, $secret, $ciphertext));
			$context = stream_context_create(array('http' => array(
				'method' => "POST",
				'header' => "Content-Type: text/xml",
				'content' => $request
			)));
			$file = file_get_contents($server, false, $context);
			$response = xmlrpc_decode($file);
			return $response;
		}
	}

	public function getUser($server, $app_id, $secret, $uid) {
		{
			$request = xmlrpc_encode_request("getUser", array($app_id, $secret, $uid));
			$context = stream_context_create(array('http' => array(
				'method' => "POST",
				'header' => "Content-Type: text/xml",
				'content' => $request
			)));
			$file = file_get_contents($server, false, $context);
			$response = xmlrpc_decode($file);
			return $response;
		}
	}

	public function getOid($server, $app_id, $secret, $uid) {
		{
			$request = xmlrpc_encode_request("getOid", array($app_id, $secret, $uid));
			$context = stream_context_create(array('http' => array(
				'method' => "POST",
				'header' => "Content-Type: text/xml",
				'content' => $request
			)));
			$file = file_get_contents($server, false, $context);
			$response = xmlrpc_decode($file);
			return $response;
		}
	}

	public function getUserByOid($server, $app_id, $secret, $oid) {
		{
			$request = xmlrpc_encode_request("getUserByOid", array($app_id, $secret, $oid));
			$context = stream_context_create(array('http' => array(
				'method' => "POST",
				'header' => "Content-Type: text/xml",
				'content' => $request
			)));
			$file = file_get_contents($server, false, $context);
			$response = xmlrpc_decode($file);
			return $response;
		}
	}

	public function ObjectToArray($data) {
		{
			$data	= preg_replace('/{\'_id\'\: ObjectId\(\'/',"{'oid': \"",$data);
			$data	= preg_replace('/\'\), \'uid\'/',"\", 'uid'",$data);
			$data	= preg_replace('/datetime\.datetime/',"\"datetime.datetime",$data);
			$data	= preg_replace('/\)/',")\"",$data);
			$data	= preg_replace(array("/\[/", "/\]/"),'',$data);
			$data	= preg_replace("/\'/",'"',$data);
			$data	= json_decode($data, true);
			return $data;
		}
	}

	public function convertTime($time) {
		{
			$temp	= preg_replace(array("/datetime\.datetime\(/", "/\)/"),'',$time);
			$temp	= list($year, $month, $day, $hour, $minute, $second) = explode(", ", $temp);
			if ($month < 10) {
				$month = "0" . $month;
			}
			if ($day < 10) {
				$day = "0" . $day;
			}
			if ($hour < 10) {
				$hour = "0" . $hour;
			}
			if ($minute < 10) {
				$minute = "0" . $minute;
			}
			if ($second < 10) {
				$second = "0" . $second;
			}
			$time	= $year . "-" . $month . "-" . $day . " " . $hour . ":" . $minute . ":" . $second;
			return $time;
		}
	}
}
