<?php
define('MAIN',realpath('../'));
include MAIN.'/includes/config.php';
include MAIN.'/includes/class.main.php';
$main = new Main();

$p_address = isset($_REQUEST["p_address"])?$_REQUEST["p_address"]:"";


$sql = "SELECT * FROM `tbl_user` WHERE `url` = '".$p_address."'";
//aaaaa
$num = mysql_num_rows(mysql_query($sql));

if($num < 1)
 {
  echo  1;
 }
else
 {
  echo 0;
 }


?>