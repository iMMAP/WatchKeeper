<?php
include 'dbconnect.php';
$db = getDB();

if ($_REQUEST['id']!=''){
	if ($_REQUEST['state']=='del'){	
		$query = "delete from \"incidentEvents\" where id=".$_REQUEST['id'];
	} else {
		if ($_REQUEST['lat']!=''){
			$query = "update \"incidentEvents\" set date='".$_REQUEST['date']."', time='".$_REQUEST['time']."', country='".$_REQUEST['countries']."', incidenttype='".$_REQUEST['incidenttype']."',location='".$_REQUEST['location']."', \"desc\"='".addslashes($_REQUEST['message'])."', the_geom=GeomFromText('POINT(".$_REQUEST['lng']." ".$_REQUEST['lat'].")', 4326) where id=".$_REQUEST['id'];
		} else {
			$query = "update \"incidentEvents\" set date='".$_REQUEST['date']."', time='".$_REQUEST['time']."', country='".$_REQUEST['countries']."', incidenttype='".$_REQUEST['incidenttype']."',location='".$_REQUEST['location']."', \"desc\"='".addslashes($_REQUEST['message'])."' where id=".$_REQUEST['id'];
		}	
	}
} else {
	if ($_REQUEST['lat']!=''){
		$query = "insert into \"incidentEvents\"(date, time, country, incidenttype, location, \"desc\", the_geom) values('".$_REQUEST['date']."','".$_REQUEST['time']."','".$_REQUEST['countries']."','".$_REQUEST['incidenttype']."','".$_REQUEST['location']."','".addslashes($_REQUEST['message'])."', GeomFromText('POINT(".$_REQUEST['lng']." ".$_REQUEST['lat'].")', 4326))";
	} else {
		$query = "insert into \"incidentEvents\"(date, time, country, incidenttype, location, \"desc\") values('".$_REQUEST['date']."','".$_REQUEST['time']."','".$_REQUEST['countries']."','".$_REQUEST['incidenttype']."','".$_REQUEST['location']."','".addslashes($_REQUEST['message'])."')";
	}	
}

if ((isset($_REQUEST['checkbox-2'])) && ($_REQUEST['countries']=='PAK') && ($_REQUEST['state']!='del')){
	$unique_id =  date("YmdHis").rand(1,999999);
	$query .= ";
	insert into sms_outbound(ref_id, msisdn_to, message, user_id, group_id, subgroup_id, unique_id, status, type, date_time)
	select '', cell, '".addslashes($_REQUEST['message'])."', id, 3, 0, '$unique_id', 0, 'm', now() from sms_user where email !='' and country_id = 3 and cell !='00000000000';";
}

$res=pg_query($db, $query);
pg_close($db);	

header("Location: gallery.php");
/* Make sure that code below does not get executed when we redirect. */
exit;
?>