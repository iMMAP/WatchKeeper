<?php
include('checkSession.php');
?>


		<div data-role="page" id="gallery-page">
			<div data-role="header" id="header">
				<h1>Security Alerts</h1>
				<a href="index.php">Home</a>
			</div><!-- /header -->
			<?php
		        // include 'dbconnect.php';
		        // $query = "select id as id, date as tgl, time as time, i.country, c.name, i.location, i.desc from \"incidentEvents\" i
					// inner join countries c on i.country=c.code
					// order by i.date DESC, i.time DESC limit 10";
				// $db = getDB();
				// $res=pg_query($db, $query);
		    ?>
			<div data-role="content">
            <ul id="listview" data-role="listview" data-inset="true" data-theme="c" data-dividertheme="a">
				<li data-role="list-divider">Security Alert Overview</li>
				<?php
				// while ($row = pg_fetch_array($res)){
					// echo '<li>';
					// echo '<a href="addAlert.php?id='.$row['id'].'"><h2>'.$row['name'].'</h2>';	
					// echo '<p>'.$row['location'].','.$row['tgl'].' '.$row['time'].'</p>';
					// echo '<p>'.$row['desc'].'</p></a>';		
					// echo '</li>';
				// }
				// pg_close($db);
				?>
				<!-- <li id="loadmore-link"><a href="#">Show More ...</a></li> -->
				<!--<li><a href="#"> <p class="myParagraph">The Capital City of The Country Thailand is Bangkok.</p></a></li>
 				<li><a href="#"> <p class="myParagraph">The Capital City of The Country China is Beijing.</p></a></li>
				<li><a href="#"> <p class="myParagraph">The Capital City of The Country Malaysia is Kuala Lumpur.</p></a></li>
				<li><a href="#"> <p class="myParagraph">The Capital City of The Country India is New Delhi.</p></a></li>
				<li><a href="#"> <p class="myParagraph">The Capital City of The Country Indonesia is Jakarta.</p></a></li> -->
			</ul>
                        </div>
			  <div data-role="footer" data-theme="a">
            <div class="ui-bar">
             <!-- <a href="share-dialog.html"  data-role="button" data-icon="star" data-theme="a" data-rel="dialog">Share</a> --> 
             <a href="logout.php" data-role="button" data-icon="plus" data-theme="a" style="float:left;">Logout</a>
             <a href="addAlert.php" data-role="button" data-icon="star" data-theme="a" style="float:right;">Add</a>             
           	 <a href="" data-role="button" data-icon="arrow-u" data-theme="a" style="float:right;" class="returnTopAction">Return top</a> 
           </div>
          </div>
          <!-- /Footer --> 

		</div><!-- /page -->


<script>
	// console.log($('#listview'));
	getAlertLists($('#listview'), 10, 0);
</script>
