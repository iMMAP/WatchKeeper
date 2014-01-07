<?php
include '../sec-m/dbconnect.php';
header('Content-type: text/xml');
$db = getDB();

	$qryAlert = "select query_to_xml('select date, \"time\", country, location, \"desc\", id, incidenttype, x(the_geom) as x, y(the_geom) as y from \"incidentEvents\"',true,false,'')";
	
	$resAlert=pg_query($db, $qryAlert);
	while ($rowAlert = pg_fetch_array($resAlert)){
		$arr = $rowAlert['query_to_xml']; 
	}


echo $arr;

// echo $qryAlert;
pg_close($db);
?>