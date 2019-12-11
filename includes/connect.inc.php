<?php
date_default_timezone_set('Asia/Bangkok');

$servername = "localhost";
#$servername = "tangtrakul.no-ip.org:3306";
$database = "actdb";
$username = "actdb";
$password = "vucm3ltMXs3Y2UZ4";

try {
    $con = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    // set the PDO error mode to exception
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $con->exec ("SET NAMES \"utf8\"");
    }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }