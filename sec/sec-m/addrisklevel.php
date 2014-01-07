<?php
include('checkSession.php');
?>

<?php
include 'dbconnect.php';
$id = $_REQUEST['id'];
$db = getDB();

if ($id!=''){
	$queryData = "select * from risklevelmovestate where id=".$id;
	$result=pg_query($db, $queryData);
	$row = pg_fetch_array($result);
	$date = $row['date'];
	$location = $row['location'];
	$country = $row['country'];
	$risklevel = $row['risklevel'];
	$movestate = $row['movestate'];
}

?>

		<div data-role="page" data-add-back-btn="true" id="addalert-page">
			<div data-role="header" id="header">
				<h1>Manage Risk Level and Movement State</h1>
			</div><!-- /header -->
			
			
	<div data-role="content">  
		<form class="contact_form" action="saverisklevel.php?id=<?php echo $id?>" method="post" name="contact_form">
			<fieldset data-role="fieldcontain">  
				<label for="date">Date:</label>
				<input name="date" type="date" placeholder="" required <?php if ($date!=''){echo "value='$date'";}?>/>
			</fieldset>
			<?php
		        // include 'dbconnect.php';
		        $query = "select code, name from countries where code in ('PAK','IRQ','AFG','YEM','JOR','TUR','GEO','MLI','COL')";
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
				<label for="title">Location :</label>
				<input name="location" type="text"  placeholder="" required <?php if ($location!=''){echo "value='$location'";}?>/>
			</fieldset>
		    <fieldset data-role="fieldcontain"> 
				<label for="risklevel">Risk Level:</label>
				<select name="risklevel" id="risklevel">
					<option <?php if ($risklevel=='EXTREME'){echo " selected ";}?> value="EXTREME">EXTREME</option>
					<option <?php if ($risklevel=='HIGH-EXTREME'){echo " selected ";}?> value="HIGH-EXTREME">HIGH-EXTREME</option>
					<option <?php if ($risklevel=='HIGH'){echo " selected ";}?> value="HIGH">HIGH</option>
					<option <?php if ($risklevel=='MODERATE-HIGH'){echo " selected ";}?> value="MODERATE-HIGH">MODERATE-HIGH</option>
					<option <?php if ($risklevel=='MODERATE'){echo " selected ";}?> value="MODERATE">MODERATE</option>
					<option <?php if ($risklevel=='LOW-MODERATE'){echo " selected ";}?> value="LOW-MODERATE">LOW-MODERATE</option>
					<option <?php if ($risklevel=='LOW'){echo " selected ";}?> value="LOW">LOW</option>
				</select>	
			</fieldset>
			<fieldset data-role="fieldcontain"> 
				<label for="movestate">Movement States:</label>
				<select name="movestate" id="movestate">
					<option <?php if ($movestate=='MISSION BLACKOUT'){echo " selected ";}?> value="MISSION BLACKOUT">MISSION BLACKOUT</option>
					<option <?php if ($movestate=='MISSION CRITICAL'){echo " selected ";}?> value="MISSION CRITICAL">MISSION CRITICAL</option><br/>
					<option <?php if ($movestate=='MISSION ESSENTIAL'){echo " selected ";}?> value="MISSION ESSENTIAL">MISSION ESSENTIAL</option><br/>
					<option <?php if ($movestate=='NORMAL'){echo " selected ";}?> value="NORMAL">NORMAL</option>
				</select>				
			</fieldset>
		    <button class="submit" type="submit">Submit Form</button>
		</form>
	</div>
			
	      <div data-role="footer" data-theme="a">
            <div class="ui-bar">
                        
           	 <a href="saverisklevel.php?state=del&id=<?php echo $id;?>" data-role="button" data-icon="arrow-u" data-theme="a" style="float:right;">Delete</a> 
           
           </div>
          </div>
          <!-- /Footer --> 

		</div><!-- /page -->


<?php
pg_close($db);
?>
