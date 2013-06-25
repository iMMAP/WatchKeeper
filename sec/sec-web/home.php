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

?>

<br/>
<!------ Start of panel Group --->
<div id="panelkiri">
	<div id="flagmenu"><a class="syriaLink" href='index.php?m=content&contry=SYR'></a>SYR</div>
	<!-- <div id="flagmenu"><a class="pakistanLink" href='index.php?m=content&contry=PAK'></a>PAK</div>
	<div id="flagmenu"><a class="iraqLink" href='index.php?m=content&contry=IRQ'></a>IRQ</div> -->
</div>	
	
	
	
	<!-- <hr align=\"center\" noshade=\"\" size=\"7\" width=\"100%\" style=\"margin-top:0px;\" /> -->
<div id="panelkanan">	
	<div id='jqxWidget3'>
		<h3 class="panelHeaderCustom"> Security Alerts Last 24hrs</h3><br/>
		<?php
		// $qry_alert = "select i.id,i.date, i.time, i.country, c.name, i.location, i.desc, code1, i.incidenttype 
		// from \"incidentEvents\" i
		// inner join countries c on i.country=c.code
		// where (date::date = now()::date-1 and time::time >= '16:00'::time) or (date::date = now()::date)
		// order by date desc, time desc";
		$qry_alert = "select i.id,i.date, i.time, i.country, c.name, i.location, i.desc, code1, i.incidenttype 
		from \"incidentEvents\" i
		inner join countries c on i.country=c.code
		where to_timestamp(i.date || ' '|| i.time, 'YYYY-MM-DD HH24:MI:SS') >= (now() - interval '24 hour')
		order by date desc, time desc";
		?>
		<!-- <table border="0" cellpadding="5" cellspacing="0">
			<tbody> -->
		<div class="innerTableCustom">		
		<?php
				$resAlert=pg_query($db, $qry_alert);
				while ($rowAlert = pg_fetch_array($resAlert)){
					$date = new DateTime($rowAlert['date']);
			        // echo "<tr>
			            // <td>".$rowAlert['location'].", ".$date->format('d-m-Y')." ".$rowAlert['time']."</td>
			            // <td>".$rowAlert['desc']."</td>
			        // </tr>";
			        echo "<div class=\"flag ".strtolower($rowAlert['code1'])."\" ></div><img height=15px src='images/".$rowAlert['incidenttype'].".png'> <b>".$rowAlert['location'].", ".$date->format('d-m-Y')." ".$rowAlert['time']."</b><br/>".$rowAlert['desc']."<br/><br/>";
				}
		?>	
		</div>	
			<!-- </tbody>
		</table> -->
	</div>
</div>
<!------ End of panel Group --->




 



<script type="text/javascript">
	$(document).ready(function () {
    	// Create jqxPanel
        var theme = getDemoTheme();

        $("#jqxWidget3").jqxPanel({ width: 850, height: 380, theme: theme });
        $("#cprofile").css({"display":"none"});
	});
</script>

