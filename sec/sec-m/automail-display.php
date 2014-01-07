<?php

function htmlallentities($str){
  $res = '';
  $strlen = strlen($str);
  for($i=0; $i<$strlen; $i++){
    $byte = ord($str[$i]);
    if($byte < 128) // 1-byte char
      $res .= $str[$i];
    elseif($byte < 192); // invalid utf8
    elseif($byte < 224) // 2-byte char
      $res .= '&#'.((63&$byte)*64 + (63&ord($str[++$i]))).';';
    elseif($byte < 240) // 3-byte char
      $res .= '&#'.((15&$byte)*4096 + (63&ord($str[++$i]))*64 + (63&ord($str[++$i]))).';';
    elseif($byte < 248) // 4-byte char
      $res .= '&#'.((15&$byte)*262144 + (63&ord($str[++$i]))*4096 + (63&ord($str[++$i]))*64 + (63&ord($str[++$i]))).';';
  }
  return $res;
}

include 'dbconnect.php';
$db = getDB();

//require_once "lib/mail/Mail.php";  
//include("lib/mail/Mail/mime.php"); 
  
$from    = "watchkeeper@immap.org";  
 
$subject = "DSR"." ".date("d")." ".date("M")." ".date("Y");  

$body    = "<html>
<head>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
<style type=\"text/css\">
	.footer {
    position: absolute;
    bottom: 0;
    width: 644px;
    height: 20px;
    margin: 0 auto;
	}
  </style>
</head>
<body>";

// email header
$body    .= "<h2>
</h2>
<div>&nbsp;</div>
<table cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">
    <tbody>
        <tr>
            <td>
                <div>
                    <H2 style = \"font-family: trebuchet MS; font-size: 14pt; color : #953735; font-weight:bold;\">
                        <strong>iMMAP DSR PAKISTAN - </strong>
                        ".date("d")." ".date("M")." ".date("Y")."<strong></strong>
                    </H2>
                </div>
            </td>
        </tr>
    </tbody>
</table>";


$body    .= "<H2 style = \"font-family: trebuchet MS; font-size: 12pt; color : #953735; font-weight:bold;  margin-bottom:0px;\">
    CURRENT RISK LEVELS &amp; MOVEMENT STATES
</H2>
<hr align=\"center\" noshade=\"\" size=\"7\" width=\"100%\" style=\"margin-top:0px;\" />
<table cellpadding=\"0\" cellspacing=\"0\" width=\"699\" style=\"border-collapse: collapse;\">
    <tbody>
        <tr>
            <td valign=\"top\" width=\"142\" style=\"border-bottom:0.75px solid #808080;\">
            </td>
            <td valign=\"top\" width=\"142\" style=\"border-bottom:0.75px solid #808080;\">
                    <font style = \"font-family: trebuchet MS; font-size: 10pt; color : #953735; font-weight:bold;\">Risk Level</font>
            </td>
            <td valign=\"top\" width=\"416\" style=\"border-bottom:0.75px solid #808080;\">
                    <font style = \"font-family: trebuchet MS; font-size: 10pt; color : #953735; font-weight:bold;\">Movement State</font>
            </td>
        </tr>";
		
		$qry_risk = "select * from risklevelmovestate where country = 'PAK'";
		$resRisk = pg_query($db, $qry_risk);
		while ($rowRisk = pg_fetch_array($resRisk)){
			$body    .= " <tr>
		            <td valign=\"top\" width=\"142\" style=\"border-bottom:0.75px solid #808080;\">
		                    <font style = \"font-family: trebuchet MS; font-size: 10pt; color : #953735; font-weight:bold;\">".$rowRisk['location']."</font>
		            </td>
		            <td valign=\"top\" width=\"142\" style=\"border-bottom:0.75px solid #808080;\">
		                    <font style = \"font-family: trebuchet MS; font-size: 10pt; font-weight:bold;\">".$rowRisk['risklevel']."</font>
		            </td>
		            <td valign=\"top\" width=\"416\" style=\"border-bottom:0.75px solid #808080;\">
		                    <font style = \"font-family: trebuchet MS; font-size: 10pt; font-weight:bold;\">".$rowRisk['movestate']."</font>
		            </td>
		       </tr>";
		}
     $body    .= "</tbody>
</table>";

$qry_alert = "select i.id,i.date, i.time, i.country, c.name, i.location, i.desc 
from \"incidentEvents\" i
inner join countries c on i.country=c.code
where i.country = 'PAK' and to_timestamp(i.date || ' '|| i.time, 'YYYY-MM-DD HH24:MI:SS') >= (now() - interval '24 hour') 
order by date desc, time desc";

$qry_advise = "select * from security_advise where country = 'PAK' order by date desc";
$resAdvise = pg_query($db, $qry_advise);

$body    .= "<h2  style = \"font-family: trebuchet MS; font-size: 12pt; color : #953735; font-weight:bold; margin-bottom:0px;\">
    SECURITY ALERTS LAST 24HRS
</h2>
<hr align=\"center\" noshade=\"\" size=\"7\" width=\"100%\" style=\"margin-top:0px;\" />

<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
    <tbody>";
    	$resAlert=pg_query($db, $qry_alert);
		while ($rowAlert = pg_fetch_array($resAlert)){
			$date = new DateTime($rowAlert['date']);
	        $body    .= "<tr style=\"margin-bottom:5px;margin-top:5px;\">
	            <td valign=\"top\" width=\"25%\" style = \"font-family: trebuchet MS;border-bottom:0.75px solid #808080; font-size: 10pt;\">".$rowAlert['location'].", ".$date->format('d-m-Y')." ".$rowAlert['time']."</td>
	            <td valign=\"top\" width=\"75%\" style = \"font-family: trebuchet MS;border-bottom:0.75px solid #808080; font-size: 10pt;\">".$rowAlert['desc']."</td>
	        </tr>";
		}
		
    $body    .= "</tbody>
</table>";

$body    .= "<h2  style = \"font-family: trebuchet MS; font-size: 12pt; color : #953735; font-weight:bold; margin-bottom:0px; \"  >
    CURRENT SECURITY ADVISORIES
</h2>
<hr align=\"center\" noshade=\"\" size=\"7\" width=\"100%\"  style=\"margin-top:0px;\" />";

    	$resAlert=pg_query($db, $qry_alert);
		$tempObj = array();
		while ($rowAdvise = pg_fetch_array($resAdvise)){
			$date = new DateTime($rowAdvise['date']);	
			$body    .= "<ul>";			
			$body    .= "<li>".$date->format('d/m/Y')." - ".$rowAdvise['title']."</li>";
			$body    .= "</ul>";
			$tempObj[] = $rowAdvise;
		}
		
		
$body    .= "<hr align=\"center\" noshade=\"\" size=\"3\" width=\"100%\" style=\"margin-top:0px;\" />";	
		
		foreach ($tempObj as $key => $rowLink){
			$date = new DateTime($rowLink['date']);	
			// $body    .= "<ul>";			
			$body    .= "<h3 style = \"font-family: trebuchet MS; font-size: 12pt; font-weight:bold; margin-bottom:0px; \">
			<a name=\"".$rowLink['id']."\">".$date->format('d/m/Y')." - ".$rowLink['title']."</a></h3>";
			$body    .= "<p style = \"font-family: trebuchet MS; font-size: 10pt; margin-bottom:0px; margin-top:0px; \">".nl2br(htmlallentities($rowLink['background']))."</p>";
			$body    .= "<p style = \"font-family: trebuchet MS; font-size: 10pt; margin-top:0px;\"><b>Advice</b> : <br>".nl2br(htmlallentities($rowLink['advise']))."</p>";
			// $body    .= "</ul>";
			// echo nl2br(htmlallentities($rowLink['background']))."<br>";
		}		
$body    .= "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"width:100%\">
    <tbody>
    <tr>
	            <td align=\"center\" width=\"100%\" style = \"font-family: trebuchet MS;border-top:1px solid #808080;\">
    
   
    </td></tr>
    </tbody>
</table></body></html>";
  
echo $body;


pg_close($db);	



?>