<?php
define('MAIN',realpath('../'));
include MAIN.'/includes/config.php';
include MAIN.'/includes/class.main.php';
$obj = new Main();


$ouput= "";

$keyword= isset($_REQUEST["keyword"]) ?  $_REQUEST["keyword"] : "";
$msg=isset($_REQUEST["msg"]) ?  $_REQUEST["msg"] : "";
$opr=isset($_REQUEST["opr"]) ?  $_REQUEST["opr"] : "";
if($opr == "0")
{
		$rs= mysql_query("select * from tbl_message  Where keyword = '$keyword' ");
		if(mysql_num_rows($rs) > 0 )
		{
			$row=mysql_fetch_array($rs);
			$ouput= "<textarea name=\"msg\" cols=\"30\" rows=\"6\"  id=\"msg\"  onkeypress=\"return imposeMaxLength(this, 120);\"  onkeyup=\"len_display(this,120)\" class=\"sign_inp\">$row[description]</textarea> ";
		}
		else
		{
			$ouput= "<textarea name=\"msg\" cols=\"30\" rows=\"6\"  id=\"msg\"  onkeypress=\"return imposeMaxLength(this, 120);\"  onkeyup=\"len_display(this,120)\" class=\"sign_inp\"></textarea> ";
		}
	
}	
if($opr == "1")
{		
	$rs= mysql_query("select * from tbl_message  Where keyword = '$keyword' ");
		if(mysql_num_rows($rs) > 0 )
		{
			mysql_query("update tbl_message SET   description = '$msg'  WHERE keyword = '$keyword' ");
			
				//echo "update tbl_message SET    message = '$msg'  WHERE  keyword = '$keyword' ";
			$ouput= "Record Updated..";
		}
		else
		{
			mysql_query("insert into tbl_message (keyword,description )values ('$keyword', '$msg')");
			//echo "insert into tbl_message (keyword,message )values ('$keyword', '$msg')";
			$ouput= "New record inserted..";
			
		}
	
}

 echo $ouput;?>