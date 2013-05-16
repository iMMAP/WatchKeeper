<?php
include('checkSession.php');
?>


		<div data-role="page" id="risklevel-page">
			<div data-role="header" id="header">
				<h1>Risk Level and Movement State</h1>
				<a href="index.php">Home</a>
			</div><!-- /header -->
			<?php
		        include 'dbconnect.php';
		        $query = "select id as id, date as tgl, c.name, i.location, i.risklevel, i.movestate 
						from risklevelmovestate i 
						inner join countries c on i.country=c.code
						order by i.date DESC";
				$db = getDB();
				$res=pg_query($db, $query);
		    ?>
			<div data-role="content">
            <ul data-role="listview" data-inset="true" data-theme="c" data-dividertheme="a">
				<li data-role="list-divider">Risk Level and Movement States Overview</li>
				<?php
				while ($row = pg_fetch_array($res)){
					echo '<li>';
					echo '<a href="addrisklevel.php?id='.$row['id'].'"><h2>'.$row['name'].'</h2>';	
					echo '<p>'.$row['tgl'].'</p>';
					echo '<p>'.$row['location'].'</p>';
					echo '<p>'.$row['risklevel'].'</p>';
					echo '<p>'.$row['movestate'].'</p></a>';		
					echo '</li>';
				}
				pg_close($db);
				?>
			</ul>
                        </div>
			  <div data-role="footer" data-theme="a">
            <div class="ui-bar">
             <!-- <a href="share-dialog.html"  data-role="button" data-icon="star" data-theme="a" data-rel="dialog">Share</a> --> 
             <a href="logout.php" data-role="button" data-icon="plus" data-theme="a" style="float:left;">Logout</a>
             <a href="addrisklevel.php" data-role="button" data-icon="star" data-theme="a" style="float:right;">Add</a>             
           	 <a href="" data-role="button" data-icon="arrow-u" data-theme="a" style="float:right;" class="returnTopAction">Return top</a> 
           </div>
          </div>
          <!-- /Footer --> 

		</div><!-- /page -->

