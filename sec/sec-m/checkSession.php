<?php
	session_start(); // must be before any output
	if (!isset($_SESSION['wacthkeeperusername'])) 
		header("Location: login.php");
	// $username = $_SESSION['username'];
?>