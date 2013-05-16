<?php
include 'dbconnect.php';
session_start(); // must be before any output
$username = $_REQUEST['username'];
$password = $_REQUEST['password'];

$query = "select * from users where username='$username' and password = md5('$password')";

$db = getDB();
$res=pg_query($db, $query);
$rows = pg_num_rows($res);
// while ($row = pg_fetch_object($res)){
	// $arr[] = $row;
// }
// echo $rows;

if ($rows>0){
	$_SESSION['wacthkeeperusername']= $username;
}

pg_close($db);
header("Location: index.php");
?>