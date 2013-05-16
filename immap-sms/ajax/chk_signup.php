<?php
define('MAIN',realpath('../'));
include MAIN.'/includes/config.php';
include MAIN.'/includes/class.main.php';
$main = new Main();

$email = isset($_REQUEST["email"])?$_REQUEST["email"]:"";
$username = isset($_REQUEST["username"])?$_REQUEST["username"]:"";
$act = isset($_REQUEST["act"])?$_REQUEST["act"]:"";

if($act == "email")
 {
	$sql = "SELECT * FROM `tbl_users` WHERE `email` = '".$email."'";
	//aaaaa
	$num = $main->RunQuerySingle($sql);
	
	if(empty($num))
	 {
	  echo  1;
	 }
	else
	 {
	  echo 0;
	 }
 
 }
 
if($act == "username")
 {
	$sql = "SELECT * FROM `tbl_users` WHERE `username` = '".$username."'";
	//aaaaa
	$num = $main->RunQuerySingle($sql);
	
	if(empty($num))
	 {
	  echo  1;
	 }
	else
	 {
	  echo 0;
	 }
  
 }




?>