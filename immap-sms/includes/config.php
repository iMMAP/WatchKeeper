<?php
session_start();
ob_start();
if($_SERVER['HTTP_HOST']=="localhost")
{

$connstr = "host=210.56.8.110 port=5433 dbname=securitynews user=postgres password=!MM@P2011";
define("CONNSTR",$connstr);
define('FULL_PATH',"http://localhost:8585/immap-sms/");
//echo "OK";
}

else
{
$connstr = "host=210.56.8.110 port=5433 dbname=securitynews user=postgres password=!MM@P2011";

define("CONNSTR",$connstr);
define('FULL_PATH',"http://210.56.8.110:8585/immap-sms/");
}
define("LIMIT",15);

define("TBLADMIN","sms_admin");
define("TBLGROUP","sms_group");
define("TBLSUBGROUP","sms_subgroup");
define("TBLORG","sms_organization");
define("TBLCON","sms_country");
define("TBLUSER","sms_user");
define("TBLMSG","sms_message");
define("TBLOB","sms_outbound");

//USA Eastern Time Zone
putenv("TZ=US/Eastern");

error_reporting(E_ALL);


?>