<?php
include 'dbconnect.php';
$db = getDB();

if ($_REQUEST['id']!=''){
	if ($_REQUEST['state']=='del'){	
		$query = "delete from risklevelmovestate where id=".$_REQUEST['id'];
	} else {
		$query = "update risklevelmovestate set date='".$_REQUEST['date']."', country='".$_REQUEST['countries']."', location='".$_REQUEST['location']."', risklevel='".$_REQUEST['risklevel']."', movestate='".$_REQUEST['movestate']."' where id=".$_REQUEST['id'];
		$queryHist = "insert into risklevelmovehist(date, country, location, risklevel, movestate) values('".$_REQUEST['date']."','".$_REQUEST['countries']."','".$_REQUEST['location']."','".$_REQUEST['risklevel']."','".$_REQUEST['movestate']."')";
		pg_query($db, $queryHist);
	}		
} else {
	$query = "insert into risklevelmovestate(date, country, location, risklevel, movestate) values('".$_REQUEST['date']."','".$_REQUEST['countries']."','".$_REQUEST['location']."','".$_REQUEST['risklevel']."','".$_REQUEST['movestate']."')";
	$queryHist = "insert into risklevelmovehist(date, country, location, risklevel, movestate) values('".$_REQUEST['date']."','".$_REQUEST['countries']."','".$_REQUEST['location']."','".$_REQUEST['risklevel']."','".$_REQUEST['movestate']."')";
	pg_query($db, $queryHist);
}
$res=pg_query($db, $query);
pg_close($db);	

header("Location: risklevel.php");
/* Make sure that code below does not get executed when we redirect. */
exit;
?>