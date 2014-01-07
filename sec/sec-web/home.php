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
	<table border="0" cellpadding="1" cellspacing="5">
	<tbody>
		<tr><td><a class="afgLink" href='index.php?m=content&contry=AFG'></a></td><td><span>Afghanistan</span></td></tr>
		<tr><td><a class="pakistanLink" href='index.php?m=content&contry=PAK'></a></td><td><span>Pakistan</span></td></tr>
		<tr><td><a class="iraqLink" href='index.php?m=content&contry=IRQ'></a></td><td><span>Iraq</span></td></tr>
		<tr><td><a class="yemenLink" href='index.php?m=content&contry=YEM'></a></td><td><span>Yemen</span></td></tr>
		<tr><td><a class="jordanLink" href='index.php?m=content&contry=JOR'></a></td><td><span>Jordan</span></td></tr>
		<tr><td><a class="turkeyLink" href='index.php?m=content&contry=TUR'></a></td><td><span>Turkey</span></td></tr>
		<tr><td><a class="georgiaLink" href='index.php?m=content&contry=GEO'></a></td><td><span>Georgia</span></td></tr>
		<tr><td><a class="maliLink" href='index.php?m=content&contry=MLI'></a></td><td><span>Mali</span></td></tr>
		<tr><td><a class="colombiaLink" href='index.php?m=content&contry=COL'></a></td><td><span>Colombia</span></td></tr>
	</tbody>
	</table>
</div>	
	
<div id="panelkiri">
	<div id='jqxWidget2'>
		<h3 class="panelHeaderCustom"> Current Security Advisories</h3>
		<br/>
		<?php
		$qry_advise = "select * from security_advise order by date desc";
		$resAdvise = pg_query($db, $qry_advise);
		$tempObj = array();
				echo "<div class=\"innerTableCustom\">";	
				while ($rowAdvise = pg_fetch_array($resAdvise)){
					$date = new DateTime($rowAdvise['date']);
					$data = "<b>".$rowAdvise['title']."</b> - ".$date->format('d/m/Y')."<br/>";
					$data .= $rowAdvise['background']."</br>";	
					$data .= "Advise : <br/>".$rowAdvise['advise']."";
					$data = nl2br($data);		
					echo "<a id=\"".$rowAdvise['id']."\" data-bpopup='".str_replace('\'', "", $data)."'>".$rowAdvise['country']." - ".$rowAdvise['title']."</a></br><br/>";

					$tempObj[] = $rowAdvise;
				}
				echo "</div>";
		?>
	
	</div>	
</div>		
	
	<!-- <hr align=\"center\" noshade=\"\" size=\"7\" width=\"100%\" style=\"margin-top:0px;\" /> -->
<div id="panelkanan">	
	<!-- <div id='jqxWidget3'>
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
	</div> -->
	
 	<div id='jqxtabs'>
        <ul style='margin-left: 2px;'>
            <li>Map of Security Alerts Last 48hrs</li>
            <li>List of Security Alerts Last 48hrs</li>
        </ul>
        <div>
            <div id="map"></div>
        </div>
        <div>
            <?php
			// $qry_alert = "select i.id,i.date, i.time, i.country, c.name, i.location, i.desc, code1, i.incidenttype 
			// from \"incidentEvents\" i
			// inner join countries c on i.country=c.code
			// where (date::date = now()::date-1 and time::time >= '16:00'::time) or (date::date = now()::date)
			// order by date desc, time desc";
			$qry_alert = "select i.id,i.date, i.time, i.country, c.name, i.location, i.desc, code1, i.incidenttype 
			from \"incidentEvents\" i
			inner join countries c on i.country=c.code
			where to_timestamp(i.date || ' '|| i.time, 'YYYY-MM-DD HH24:MI:SS') >= (now() - interval '48 hour')
			order by date desc, time desc";
			?>
	
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
        </div>
        
        
    </div>	
	
</div>
<!------ End of panel Group --->




 



<script type="text/javascript">
	$(document).ready(function () {
    	// Create jqxPanel
        var theme = getDemoTheme();
        $("#jqxWidget2").jqxPanel({ width: 435, height: 380, theme: theme });
        // $("#jqxWidget3").jqxPanel({ width: 540, height: 380, theme: theme });
        $('#jqxtabs').jqxTabs({ width: 540, height: 380, theme: theme });
        $("#cprofile").css({"display":"none"});
        
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
	


$(function() {
    $.post('json/getIncidentData.php', function(data) {
		$("#map").gmap3({
		  map:{
		    options: {
		      center:[0,0],
		      zoom: 1,
		      mapTypeId: google.maps.MapTypeId.TERRAIN
		    }
		  },
		  marker : {
		  	values : data,
		  	cluster:{
		      radius:27,
		      // This style will be used for clusters with more than 0 markers
		      0: {
		        content: "<div class='cluster cluster-1'>CLUSTER_COUNT</div>",
		        width: 10,
		        height: 10
		      },
		      // This style will be used for clusters with more than 20 markers
		      20: {
		        content: "<div class='cluster cluster-2'>CLUSTER_COUNT</div>",
		        width: 10,
		        height: 10
		      },
		      // This style will be used for clusters with more than 50 markers
		      50: {
		        content: "<div class='cluster cluster-3'>CLUSTER_COUNT</div>",
		        width: 10,
		        height: 10
		      }
		   },
		    options:{
		      draggable: false
		    },
		    events:{
		      mouseover: function(marker, event, context){
		        var map = $(this).gmap3("get"),
		          infowindow = $(this).gmap3({get:{name:"infowindow"}});
		        if (infowindow){
		          infowindow.open(map, marker);
		          infowindow.setContent('<div style="font-size: 7pt; font-weight : 500;">'+context.data+'</div>');
		        } else {
		          $(this).gmap3({
		            infowindow:{
		              anchor:marker,
		              options:{content: '<div style="font-size: 7pt; font-weight : 200;">'+context.data+'</div>', maxWidth: 350}
		            }
		          });
		        }
		      },
		      mouseout: function(){
		        var infowindow = $(this).gmap3({get:{name:"infowindow"}});
		        if (infowindow){
		          infowindow.close();
		        }
		      }
		    }
		  }		
		});
    },'json');
});


</script>


<div id="popup">
        <span class="button b-close"><span>X</span></span>
        <div class="content"></div>

<div>  
