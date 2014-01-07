<?php
include '../sec-m/dbconnect.php';
session_start(); // must be before any output
$username = $_REQUEST['username'];
$password = $_REQUEST['password'];

$query = "select * from sms_user where email='$username' and password = '$password'";

$db = getDB();
$res=pg_query($db, $query);
$rows = pg_num_rows($res);

if ($rows>0){
	$_SESSION['participantusername']= $username;
}

pg_close($db);
header("Location: index.php");
?>