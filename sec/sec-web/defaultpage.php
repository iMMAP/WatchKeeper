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


<?php

$qry_risk = "select * from risklevelmovestate where country='".$_REQUEST['contry']."'";
$resRisk = pg_query($db, $qry_risk);
?>
<br/>
<!------ Start of panel Group --->
<div id="panelkiri">
	<div id='jqxWidget1'>
		<h3 class="panelHeaderCustom">Current Risk Levels and Movement States</h3>
		<table class="innerTableCustom" cellpadding="2" cellspacing="5" width="100%" style="border-collapse: collapse;">
			<tbody>
				<tr>
		            <td valign="top" width="25%">
		            </td>
		            <td valign="top" width="35%">
		                    <font>Risk Level</font>
		            </td>
		            <td valign="top" width="45%">
		                    <font>Movement State</font>
		            </td>
		        </tr>
		<?php
			while ($rowRisk = pg_fetch_array($resRisk)){
				echo "<tr>
				            <td>
				                    <font>".$rowRisk['location']."</font>
				            </td>
				            <td>
				                    <font>".$rowRisk['risklevel']."</font>
				            </td>
				            <td>
				                    <font>".$rowRisk['movestate']."</font>
				            </td>
				       </tr>";
			}	        
		?>        
		    </tbody>
		</table> 
		<div id="movementExplain"><a id="moreinfo123">more info</a></div> 
	</div>	
	
	<br/>
	<div id='jqxWidget2'>
		<h3 class="panelHeaderCustom"> Current Security Advisories</h3>
		<br/>
		<?php
		$qry_advise = "select * from security_advise where country='".$_REQUEST['contry']."' order by date desc";
		$resAdvise = pg_query($db, $qry_advise);
		$tempObj = array();
				echo "<div class=\"innerTableCustom\">";	
				while ($rowAdvise = pg_fetch_array($resAdvise)){
					$date = new DateTime($rowAdvise['date']);
					$data = "<b>".$rowAdvise['title']."</b> - ".$date->format('d/m/Y')."<br/>";
					$data .= $rowAdvise['background']."</br>";	
					$data .= "Advise : <br/>".$rowAdvise['advise']."";
					$data = nl2br($data);		
					echo "<a id=\"".$rowAdvise['id']."\" data-bpopup='".str_replace('\'', "", $data)."'>".$rowAdvise['title']."</a></br><br/>";

					$tempObj[] = $rowAdvise;
				}
				echo "</div>";
		?>
	
	</div>	
</div>	
	
	
	
	<!-- <hr align=\"center\" noshade=\"\" size=\"7\" width=\"100%\" style=\"margin-top:0px;\" /> -->
<div id="panelkanan">	
	<div id='jqxWidget3'>
		<h3 class="panelHeaderCustom"> Security Alerts Last 24hrs</h3><br/>
		<?php
		// $qry_alert = "select i.id,i.date, i.time, i.country, c.name, i.location, i.desc, i.incidenttype 
		// from \"incidentEvents\" i
		// inner join countries c on i.country=c.code
		// where i.country='".$_REQUEST['contry']."' and ((date::date = now()::date-1 and time::time >= '16:00'::time) or (date::date = now()::date)) 
		// order by date desc, time desc";
		$qry_alert = "select i.id,i.date, i.time, i.country, c.name, i.location, i.desc, i.incidenttype, code1 
		from \"incidentEvents\" i
		inner join countries c on i.country=c.code
		where i.country='".$_REQUEST['contry']."' and to_timestamp(i.date || ' '|| i.time, 'YYYY-MM-DD HH24:MI:SS') >= (now() - interval '24 hour') 
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
    	$("#cprofile").css({"display":"block"});
    	
    	// Create jqxPanel
        var theme = getDemoTheme();
        
        $("#jqxWidget1").jqxPanel({ width: 465, height: 110, theme: theme });
        $("#jqxWidget2").jqxPanel({ width: 465, height: 250, theme: theme });
        $("#jqxWidget3").jqxPanel({ width: 625, height: 380, theme: theme });
<?php
$body = "";
foreach ($tempObj as $key => $rowLink){
	$date = new DateTime($rowLink['date']);		
	$body    .= "<h3 style = \"font-family: trebuchet MS; font-size: 12pt; font-weight:bold; margin-bottom:0px; \">
	<a name=\"".$rowLink['id']."\">".$date->format('d/m/Y')." - ".$rowLink['title']."</a></h3>";
	$body    .= "<p style = \"font-family: trebuchet MS; font-size: 10pt; margin-bottom:0px; margin-top:0px; \">".nl2br(htmlallentities($rowLink['background']))."</p>";
	$body    .= "<p style = \"font-family: trebuchet MS; font-size: 10pt; margin-top:0px;\">Advice : <br>".nl2br(htmlallentities($rowLink['advise']))."</p>";
	// echo "$(\"#".$rowLink['id']."\").jqxTooltip({ content: '".$rowLink['advise']."<br /><b>Year:</b> 2012', position: 'mouse', name: 'movieTooltip', theme: theme });";
	?>
	$("#<?php echo $rowLink['id'];?>").bind("click", function() {
				var self = $(this) //button
        		, content = $('.content'); 
	            $("#popup").bPopup({
	            	onOpen: function() {
		                content.html(self.data('bpopup') || '');
		            },
		            onClose: function() {
		                content.empty();
		            }
	            });
	            return false
    });
    $("#moreinfo123").bind("click", function() {
    	var self = $(this) //button
        		, content = $('.content'); 
	     $('#popup').bPopup({
	            contentContainer:'.content',
	            loadUrl: 'riskleveldef.html' ,
	            onOpen: function() {
		                content.html(self.data('bpopup') || '');
		            },
	            onClose: function() {
		                content.empty();
		            }
	      });    	
	});



	<?php
 
}
// echo $body;
?>        
        
});
</script>

<div id="popup">
        <span class="button b-close"><span>X</span></span>
        <div class="content"></div>

<div>    