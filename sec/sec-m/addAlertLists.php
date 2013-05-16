<?php
$limit = $_REQUEST['limit'];
$offset= $_REQUEST['offset'];

$arr = array();
include 'dbconnect.php';
$query = "select id as id, date as tgl, time as time, i.country, c.name, i.location, i.desc from \"incidentEvents\" i
		inner join countries c on i.country=c.code
		order by i.date DESC, i.time DESC limit $limit offset $offset";
$db = getDB();
$res=pg_query($db, $query);
while ($row = pg_fetch_object($res)){
	$arr[] = $row;
}
pg_close($db);
echo json_encode($arr);

?>