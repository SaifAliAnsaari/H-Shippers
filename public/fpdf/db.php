<?php 
$servername = "localhost";
$username = "hshipper_admin";
$password = "&3@FFh(#A5Oo";
$dbname = "hshipper_db";
$test = $_SERVER['SERVER_NAME'];

if($_SERVER['SERVER_NAME'] == "h-shippers.debug"){
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "h_shippers";
}

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
