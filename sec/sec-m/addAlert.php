<?php
include('checkSession.php');
?>



<?php
include 'dbconnect.php';
$id = $_REQUEST['id'];
$db = getDB();
$flg = $_REQUEST['flg'];


if (($id!='') && ($flg!='map')){
	$queryData = "select *, x(the_geom) as lng, y(the_geom) as lat from \"incidentEvents\" where id=".$id;
	$result=pg_query($db, $queryData);
	$row = pg_fetch_array($result);
	$date = $row['date'];
	$time = $row['time'];
	$country = $row['country'];
	$location = $row['location'];
	$message = $row['desc'];
	$incidenttype = $row['incidenttype'];
	$lng=$row['lng'];
	$lat=$row['lat'];
} else if (isset($_REQUEST['lng'])){
	$date = $_REQUEST['date'];
	$time = $_REQUEST['time'];
	$country = $_REQUEST['countries'];
	$location = $_REQUEST['location'];
	$message = $_REQUEST['message'];
	$incidenttype = $_REQUEST['incidenttype'];
	$lng=$_REQUEST['lng'];
	$lat=$_REQUEST['lat'];
}

?>

		<div data-role="page" data-add-back-btn="true" id="addalert-page">
			<div data-role="header" id="header">
				<h1>Manage Alert</h1>
			</div><!-- /header -->
			
			
	<div data-role="content">  
		<form class="contact_form" action="saveEvent.php?id=<?php echo $id?>" method="post" name="contact_form">
			<fieldset data-role="fieldcontain">  
				<label for="date">Date:</label>
				<input id="date" name="date" type="date" placeholder="" required <?php if ($date!=''){echo "value='$date'";}?>/>
			</fieldset>
			<fieldset data-role="fieldcontain">  	
	        	<label for="time">Time:</label>
	        	<input id="time" name="time" type="time" required <?php if ($time!=''){echo "value='$time'";}?>/>
			</fieldset>
		    <?php
		        // include 'dbconnect.php';
		        $query = "select code, name from countries where code in ('SYR')";
				$res=pg_query($db, $query);
		    ?>
		    <fieldset data-role="fieldcontain"> 
		    	<label for="country"  class="select">Country:</label>
		        <!-- <input type="text" name= "countries"  list= "countries" placeholder= "Click to select" required /> -->
				<select name="countries" id="countries">
<!-- 				<datalist id= "countries"> -->
						<?php
							while ($row = pg_fetch_array($res)){
								if ($country==$row['code']){
									echo '<option selected value= "'.$row['code'].'">'.$row['name'].'</option>';
								} else {  
									echo '<option value= "'.$row['code'].'">'.$row['name'].'</option>';
								}		
							}
							
						?>
<!-- 				</datalist> -->
				</select>		
		    </fieldset>
		    <fieldset data-role="fieldcontain"> 
		        <label for="location">Location:</label>
		        <input id="location" name="location" type="text"  placeholder="" required <?php if ($location!=''){echo "value='$location'";}?>/>
		   </fieldset>
		   <fieldset data-role="fieldcontain"> 
				<label for="message">Message:</label>
				<textarea id="message" name="message" cols="40" rows="6"  required ><?php if ($message!=''){echo "$message";}?></textarea>
			</fieldset>
			<fieldset data-role="fieldcontain"> 
		    	<label for="incidenttype"  class="select">Incident Type:</label>
				<select name="incidenttype" id="incidenttype">
					<option <?php if ($incidenttype=='Army operation'){echo ' selected ';}?> value='Army operation'>Army operation</option>
					<option <?php if ($incidenttype=='Demonstration'){echo ' selected ';}?> value='Demonstration'>Demonstration</option>
					<option <?php if ($incidenttype=='Human remains find'){echo ' selected ';}?> value='Human remains find'>Human remains find</option>
					<option <?php if ($incidenttype=='IED explosion'){echo ' selected ';}?> value='IED explosion'>IED explosion</option>
					<option <?php if ($incidenttype=='IED find'){echo ' selected ';}?> value='IED find'>IED find</option>
					<option <?php if ($incidenttype=='IED threat'){echo ' selected ';}?> value='IED threat'>IED threat</option>
					<option <?php if ($incidenttype=='Kidnapping'){echo ' selected ';}?> value='Kidnapping'>Kidnapping</option>
					<option <?php if ($incidenttype=='Police operation'){echo ' selected ';}?> value='Police operation'>Police operation</option>
					<option <?php if ($incidenttype=='Rioting'){echo ' selected ';}?> value='Rioting'>Rioting</option>
					<option <?php if ($incidenttype=='Robbery'){echo ' selected ';}?> value='Robbery'>Robbery</option>
					<option <?php if ($incidenttype=='Security Forces operation'){echo ' selected ';}?> value='Security Forces operation'>Security Forces operation</option>
					<option <?php if ($incidenttype=='Shooting'){echo ' selected ';}?> value='Shooting'>Shooting</option>
					<option <?php if ($incidenttype=='Shooting (insurgency)'){echo ' selected ';}?> value='Shooting (insurgency)'>Shooting (insurgency)</option>
					<option <?php if ($incidenttype=='Shooting (political)'){echo ' selected ';}?> value='Shooting (political)'>Shooting (political)</option>
					<option <?php if ($incidenttype=='Vehicle hijacking'){echo ' selected ';}?> value='Vehicle hijacking'>Vehicle hijacking</option>
					<option <?php if ($incidenttype=='Weapons cache find'){echo ' selected ';}?> value='Weapons cache find'>Weapons cache find</option>
					<option <?php if ($incidenttype=='Others'){echo ' selected ';}?> value='Others'>Others</option>
				</select>		
		    </fieldset>
			<ul id="listview" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="a">
				<li><a id="getCoord" href="#"><?php if ((isset($_REQUEST['lng'])) || ($lng!='')){echo "Modify Coordinate";} else {echo "Get Coordinate";} ?></a></li>
			</ul>
		    <fieldset data-role="controlgroup">
			   <input type="checkbox" name="checkbox-2" id="checkbox-2" class="custom" />
			   <label for="checkbox-2">Send SMS</label>
		    </fieldset>
		    <input type="hidden" id="lat" name="lat" value="<?php echo $lat;?>"/>
		    <input type="hidden" id="lng" name="lng" value="<?php echo $lng;?>"/>
		    <input type="hidden" id="id" name="id" value="<?php echo $id;?>"/>
		    <button class="submit" type="submit">Submit Form</button>
		</form>
	</div>

			
	      <div data-role="footer" data-theme="a">
            <div class="ui-bar">
                        
           	 <a href="saveEvent.php?state=del&id=<?php echo $id;?>" data-role="button" data-icon="arrow-u" data-theme="a" style="float:right;">Delete</a> 
           
           </div>
          </div>
          <!-- /Footer --> 

		</div><!-- /page -->



	<script type="text/javascript">

		
		 
	</script>
	
<?php
pg_close($db);
?>
