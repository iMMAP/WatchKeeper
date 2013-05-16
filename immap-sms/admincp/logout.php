<?php
define('MAIN',realpath('../'));
include MAIN.'/includes/config.php';
include MAIN.'/includes/class.main.php';
	
check_admin();
 
	if( isset( $_SESSION['session_admin_id'] ) )
	{
		$_SESSION['session_admin_id'] = "";
		unset($_SESSION['session_admin_id']);
	}

    header("Location: index.php");
?>