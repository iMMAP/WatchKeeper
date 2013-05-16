<?php
include 'dbconnect.php';
$db = getDB();

if ($_REQUEST['id']!=''){
	if ($_REQUEST['state']=='del'){	
		$query = "delete from security_advise where id=".$_REQUEST['id'];
	} else {
		$query = "update security_advise set date='".$_REQUEST['date']."', country='".$_REQUEST['countries']."', background='".addslashes($_REQUEST['background'])."', advise='".addslashes($_REQUEST['advice'])."', title='".$_REQUEST['title']."' where id=".$_REQUEST['id'];
		$queryhist = "insert into security_advisehist(date, country, background, advise, title) values('".$_REQUEST['date']."','".$_REQUEST['countries']."','".addslashes($_REQUEST['background'])."','".addslashes($_REQUEST['advice'])."','".$_REQUEST['title']."')";
		pg_query($db, $queryhist);
	}	
} else {
	$query = "insert into security_advise(date, country, background, advise, title) values('".$_REQUEST['date']."','".$_REQUEST['countries']."','".addslashes($_REQUEST['background'])."','".addslashes($_REQUEST['advice'])."','".$_REQUEST['title']."')";
	$queryhist = "insert into security_advisehist(date, country, background, advise, title) values('".$_REQUEST['date']."','".$_REQUEST['countries']."','".addslashes($_REQUEST['background'])."','".addslashes($_REQUEST['advice'])."','".$_REQUEST['title']."')";
	pg_query($db, $queryhist);
}
$res=pg_query($db, $query);
pg_close($db);	

header("Location: ISA.php");
/* Make sure that code below does not get executed when we redirect. */
exit;
?>