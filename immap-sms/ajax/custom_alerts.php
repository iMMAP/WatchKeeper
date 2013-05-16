<?php
session_start();
session_start();
define('MAIN',realpath('../'));
include MAIN.'/includes/config.php';
include MAIN.'/includes/class.db.php';
$dbObj =  new DBConnect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DBNAME);
//echo $_SESSION["session_userid"];
$sql ="";
$rsQry = "";
$row = "";
$sid = isset($_POST["sid"])?$_POST["sid"]:"";

//weather alerts script
if($sid == "weather")
{
 
 $zipcode = isset($_POST["zipcode"])?$_POST["zipcode"]:"";
  $rsQry = "select * from tbl_weather_alert where user_id = ".$_SESSION["session_userid"]." and object_id ='24'";
	$row = $dbObj->RunQuerySingle($rsQry);
	
  if(!empty($row))
  {
  	$sql = "update tbl_weather_alert SET zipcode='".$zipcode."',date_time = NOW() WHERE user_id = ".$_SESSION["session_userid"]." and object_id ='24'";
  }
  else
  {
   	$sql ="insert into tbl_weather_alert (user_id,object_id,zipcode,date_time) values ('".$_SESSION["session_userid"]."','24','".$zipcode."',NOW())";

  }
	$result = $dbObj->MySQLQuery($sql);
	echo $result;
}
 // news alert script
if($sid == "news")
{
 $region = isset($_POST["region"])?$_POST["region"]:"";
 $state = isset($_POST["state"])?$_POST["state"]:"";
 $type = isset($_POST["type"])?$_POST["type"]:"";
if($region == "w")
	$state = "";

  $rsQry = "select * from tbl_news_alert where user_id = ".$_SESSION["session_userid"]." and object_id ='17'";
	$row = $dbObj->RunQuerySingle($rsQry);
	
  if(!empty($row))
  {
    	$sql = "update tbl_news_alert SET region='".$region."',state='".$state."', ntype='". $type."',date_time = NOW()
		 WHERE user_id = ".$_SESSION["session_userid"]." and object_id ='17'";
  }
  else
  {
   	$sql ="insert into tbl_news_alert (user_id,object_id,region,state,ntype,date_time) values 
		('".$_SESSION["session_userid"]."','17','".$region."','".$state."','".$type."',NOW())";

  }

	$result = $dbObj->MySQLQuery($sql);
	echo $result;
}

// end news alerts

//basketball alerts script
if($sid == "basket")
{
 
 $team_id = isset($_POST["team_id"])?$_POST["team_id"]:"";
  $rsQry = "select * from tbl_nba_alert where user_id = ".$_SESSION["session_userid"]." and object_id ='21'";
	$row = $dbObj->RunQuerySingle($rsQry);
	
  if(!empty($row))
  {
  	$sql = "update tbl_nba_alert SET team_id='".$team_id."',date_time = NOW() WHERE user_id = ".$_SESSION["session_userid"]." and object_id ='21'";
  }
  else
  {
   	$sql ="insert into tbl_nba_alert (user_id,object_id,team_id,date_time) values ('".$_SESSION["session_userid"]."','21','".$team_id."',NOW())";

  }
	$result = $dbObj->MySQLQuery($sql);
	echo $result;
}
/// end basketball alerts