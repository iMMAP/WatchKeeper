<br/>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>

<div id="panelkiri">
	<div id='jqxWidget1'>
		<h3 class="panelHeaderCustom">Filter</h3>
		
		<div id="contact_form">  
		<!-- <form name="filterForm" action="#">   -->
		  	<!-- <div class="lblCustom"><label for="name" id="name_label">Name</label></div>  
		    <div  class="inputCustom" ><input type="text" name="name" id="name" size="20" value="" /></div>    
		    <div class="lblCustom"><label for="name1" id="name_label1">Name1</label></div>  
		    <div  class="inputCustom" ><input type="text" name="name1" id="name1" size="20" value="" /></div> -->
			
			
			<div class=""><label for="from">From</label></div>  
		    <div class="" ><input type="text" id="from" name="from" /></div> 
		    <div class=""><label for="to">To</label></div>  		    
		    <div class=""><input type="text" id="to" name="to" /></div>   
			
			<div class=""><label for="filter">Filter items</label></div> 
			<div id="filterParent"></div>
			
			<div class=""><label for="countries">Country</label></div> 
			<div class=""><select style="width: 90%" name="countries" id="countries"> 
			<?php
		        // include 'dbconnect.php';
		        $query = "select code, name from countries where code in ('PAK','IRQ','AFG','YEM','JOR','TUR','GEO','MLI','COL')";
				$res=pg_query($db, $query);
		    ?>
		    <?php
		    				echo '<option selected value= "All">All</option>';
							while ($row = pg_fetch_array($res)){
								echo '<option value= "'.$row['code'].'">'.$row['name'].'</option>';	
							}
							
			?>
			</select>
		    </div>
		    
		    <div class=""><label for="incidenttype">Incident Type</label></div> 
			<div class=""><select style="width: 90%" name="incidenttype" id="incidenttype"> 
					<option selected value='All'>All</option>	
					<option value='Army operation'>Army operation</option>
					<option value='Demonstration'>Demonstration</option>
					<option value='Human remains find'>Human remains find</option>
					<option value='IED explosion'>IED explosion</option>
					<option value='IED find'>IED find</option>
					<option value='IED threat'>IED threat</option>
					<option value='Kidnapping'>Kidnapping</option>
					<option value='Police operation'>Police operation</option>
					<option value='Rioting'>Rioting</option>
					<option value='Robbery'>Robbery</option>
					<option value='Security Forces operation'>Security Forces operation</option>
					<option value='Shooting'>Shooting</option>
					<option value='Shooting (insurgency)'>Shooting (insurgency)</option>
					<option value='Shooting (political)'>Shooting (political)</option>
					<option value='Vehicle hijacking'>Vehicle hijacking</option>
					<option value='Weapons cache find'>Weapons cache find</option>
					<option value='Others'>Others</option>				
			</select>
		    </div>
		    	
			<div class="lblCustom"><input type="checkbox" id="cbMovement" name="cbMovement" class="top5"/> &nbsp;Risk levels</div>
			<div class="lblCustom"><input type="checkbox" id="cbAlerts" name="cbAlerts" class="top5" checked="true"/> &nbsp;Security alerts</div>
			<div class="lblCustom"><input type="checkbox" id="cbAdvise" name="cbAdvise" class="top5" /> &nbsp;Security Advice</div>
			 
		    <div  class="inputCustom" ><input type="submit" name="submit" class="" id="submit_btn" value="Filter" onclick="raba()"/></div>  	   
		<!-- </form>  --> 
		</div>
		 
	</div>
</div>


	
<div id="panelkanan">
	<div id='jqxWidget2'>
		<h3 class="panelHeaderCustom">Filter Results</h3>
		<ul id="list" data-role="listmenu">
<?php
	$qry_alert = "select i.id,i.date, i.time, i.country, c.name, i.location, i.desc 
	from \"incidentEvents\" i
	inner join countries c on i.country=c.code
	order by date desc, time desc";

	$resAlert=pg_query($db, $qry_alert);
	echo "<li class=\"innerHeaderTableCustom\">Security Alerts</li>";
	while ($rowAlert = pg_fetch_array($resAlert)){
		$date = new DateTime($rowAlert['date']);
	    echo "<li class=\"innerTableCustom\"><b>".$rowAlert['location'].", ".$date->format('d-m-Y')." ".$rowAlert['time']."</b><br/>".$rowAlert['desc']."</li>";
	}
?>
		</ul>
	</div>
</div>






<script type="text/javascript">
	function raba(){
		var from = $('#from').val();
		var to   = $('#to').val();
		var countries = $('#countries').val();
		var incidenttype = $('#incidenttype').val();
		
		var risklevelCB = $('#cbMovement').is(":checked");
		var securityAlertCB = $('#cbAlerts').is(":checked");
		var securityAdviceCB = $('#cbAdvise').is(":checked");
		
		var root = $(list);
		while( root[0].firstChild ){
		  root[0].removeChild( root[0].firstChild );
		}
			
		var jqxhr = $.ajax( "populateData.php?from="+from+"&to="+to+"&countries="+countries+"&incidenttype="+incidenttype+"&sa="+securityAlertCB+"&rl="+risklevelCB+"&sd="+securityAdviceCB )
			.done(function(data) { 
				var dataJson  = jQuery.parseJSON(data);
				
				if (dataJson.alert){
					root.append("<li class=\"innerHeaderTableCustom jqx-listmenu-item jqx-listmenu-item-ui-darkness jqx-fill-state-normal jqx-fill-state-normal-ui-darkness\">Security Alerts</li>");
					$.each(dataJson.alert,function(index, value){ 
						root.append("<li class=\"innerTableCustom jqx-listmenu-item jqx-listmenu-item-ui-darkness jqx-fill-state-normal jqx-fill-state-normal-ui-darkness\"><b>"+value.location+", "+value.date+" "+value.time+"</b><br/>"+value.desc+"</li>");
					});
				}
				
				if (dataJson.movestate){
					root.append("<li class=\"innerHeaderTableCustom jqx-listmenu-item jqx-listmenu-item-ui-darkness jqx-fill-state-normal jqx-fill-state-normal-ui-darkness\">Risk Levels and Movement States</li>");
					$.each(dataJson.movestate,function(index, value){ 
						root.append("<li class=\"innerTableCustom jqx-listmenu-item jqx-listmenu-item-ui-darkness jqx-fill-state-normal jqx-fill-state-normal-ui-darkness\"><b>"+value.location+", "+value.date+"</b><br/>Risk Level : "+value.risklevel+"<br/>Movement State : "+value.movestate+"</li>");
					});
				}
				
				if (dataJson.advise){
					root.append("<li class=\"innerHeaderTableCustom jqx-listmenu-item jqx-listmenu-item-ui-darkness jqx-fill-state-normal jqx-fill-state-normal-ui-darkness\">Security Advise</li>");
					$.each(dataJson.advise,function(index, value){ 
						root.append("<li class=\"innerTableCustom jqx-listmenu-item jqx-listmenu-item-ui-darkness jqx-fill-state-normal jqx-fill-state-normal-ui-darkness\"><b>"+value.country+", "+value.date+"</b><br/>"+value.title+"<br/>"+value.background+"<br/>"+value.advise+"</li>");
					});
				} 
			})
			.fail(function() { alert("error"); })
			.always(function() {  });
		}
	
	$(document).ready(function () {
		$("#cprofile").css({"display":"none"});
		$('input:checkbox:not([safari])').checkbox();
		$('input[safari]:checkbox').checkbox({cls:'jquery-safari-checkbox'});
		$('input:radio').checkbox();
				
		 $(function() {
			$( "#from" ).datepicker({
				defaultDate: "+1w",
				changeMonth: true,
				numberOfMonths: 3,
				onClose: function( selectedDate ) {
				$( "#to" ).datepicker( "option", "minDate", selectedDate );
				}
			});
			$( "#to" ).datepicker({
				defaultDate: "+1w",
				changeMonth: true,
				numberOfMonths: 3,
				onClose: function( selectedDate ) {
				$( "#from" ).datepicker( "option", "maxDate", selectedDate );
				}
			});
		});
		
    	// Create jqxPanel
        var theme = getDemoTheme();
        $("#jqxWidget1").jqxPanel({ width: 200, height: 430, theme: theme });
        $("#jqxWidget2").jqxPanel({ width: 760, height: 430, theme: theme });
        
        $('#list').jqxListMenu({theme: getDemoTheme(), autoSeparators: false, enableScrolling: false, showHeader: false, width: '760', placeholder: 'Find contact...', roundedCorners: false,showFilter: true, showNavigationArrows: true });
        
        var element = $('#customFilter').detach();
        $('#filterParent').append(element);
        
 });
</script>        
	
