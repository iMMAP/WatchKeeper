<?php
define('MAIN',realpath('../../'));
include MAIN.'/includes/config.php';
include MAIN.'/includes/class.admin.php';
$admin = new Admin();

	$id = $_GET['id'];	
    
	 $res = mysql_query("delete from tbl_faq where id = '$id'");
			

	 if($res == 1)
	  {
		echo  1;
	  }
	else
		echo  "Error While deleting FAQ!";

?>