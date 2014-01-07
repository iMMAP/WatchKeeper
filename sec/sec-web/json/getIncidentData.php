<?php

$url = "http://210.56.8.110:8585/sec/sec-web/images/";

include '../../sec-m/dbconnect.php';
$arr = array();

$query = "select i.id,i.date, i.time, i.country, c.name, i.location, i.desc, code1, i.incidenttype, x(i.the_geom) as lng, y(i.the_geom) as lat 
			from \"incidentEvents\" i
			inner join countries c on i.country=c.code
			where the_geom is not null and to_timestamp(i.date || ' '|| i.time, 'YYYY-MM-DD HH24:MI:SS') >= (now() - interval '48 hour')";

$db = getDB();
$res=pg_query($db, $query);
while ($row = pg_fetch_array($res)){
	$arr[] = array(
				'lng' => $row['lng'], 
				'lat' => $row['lat'],
				'data' => $row['location'].", ".$row['date']." - ".$row['time']."<br/>".$row['desc'],
				'options' => array('icon' => $url.$row['incidenttype'].".png") 
			 );
	
}

pg_close($db);

echo json_encode($arr);

?>