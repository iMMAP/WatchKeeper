<?php
include '../sec-m/dbconnect.php';
$db = getDB();

$date1 = $_REQUEST['from'];
$date2 = $_REQUEST['to'];
$countries = $_REQUEST['countries'];
$incidenttype = $_REQUEST['incidenttype'];

$isAlert = $_REQUEST['sa'];
$isAdvise = $_REQUEST['sd'];
$isRisk = $_REQUEST['rl'];
$arr = array();


// $where = " where (date::date = now()::date-1) and (date::date = now()::date)";
$where = " where 1=1 ";
$whareAdd = '';

if ($date1!=''){
	$where .= " and date >= '".$date1."' and date <= '".$date2."' ";
}
if ($countries!='All'){
	$where .= " and country='".$countries."' ";
}
if ($incidenttype!='All'){
	$whareAdd = " and incidenttype='".$incidenttype."' ";
}

if ($isAlert=='true'){
	$qryAlert = "select i.id,i.date, i.time, i.country, c.name, i.location, i.desc 
	from \"incidentEvents\" i
	inner join countries c on i.country=c.code
	$where $whareAdd
	order by date desc, time desc";
	$resAlert=pg_query($db, $qryAlert);
	while ($rowAlert = pg_fetch_object($resAlert)){
		$arr['alert'][] = $rowAlert; 
	}
}

if ($isAdvise=='true'){
	$qryAdvise = "select * from security_advisehist $where order by date desc";
	$resAdvise=pg_query($db, $qryAdvise);
	while ($rowAdvise = pg_fetch_object($resAdvise)){
		$arr['advise'][] = $rowAdvise; 
	}
}

if ($isRisk=='true'){
	$qryMove = "select * from risklevelmovehist $where  order by date desc";
	$resMove=pg_query($db, $qryMove);
	while ($rowMove = pg_fetch_object($resMove)){
		$arr['movestate'][] = $rowMove; 
	}
}

echo json_encode($arr);

// echo $qryAlert;
pg_close($db);
?>