<?php
include('checkSession.php');
?>


		<div data-role="page" id="ISA-page">
			<div data-role="header" id="header">
				<h1>iMMAP Security Advisory</h1>
				<a href="index.php">Home</a>
			</div><!-- /header -->
			<?php
		        include 'dbconnect.php';
		        $query = "select id as id, date as tgl, i.country, c.name, i.background, i.advise 
						from security_advise i 
						inner join countries c on i.country=c.code
						order by i.date DESC";
				$db = getDB();
				$res=pg_query($db, $query);
		    ?>
			<div data-role="content">
            <ul data-role="listview" data-inset="true" data-theme="c" data-dividertheme="a">
				<li data-role="list-divider">Security Advise Overview</li>
				<?php
				while ($row = pg_fetch_array($res)){
					echo '<li>';
					echo '<a href="addAdvice.php?id='.$row['id'].'"><h2>'.$row['name'].'</h2>';	
					echo '<p>'.$row['tgl'].'</p>';
					echo '<p>'.$row['title'].'</p>';
					echo '<p>'.$row['background'].'</p>';
					echo '<p>'.$row['advise'].'</p></a>';		
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
             <a href="addAdvice.php" data-role="button" data-icon="star" data-theme="a" style="float:right;">Add</a>             
           	 <a href="" data-role="button" data-icon="arrow-u" data-theme="a" style="float:right;" class="returnTopAction">Return top</a> 
           </div>
          </div>
          <!-- /Footer --> 

		</div><!-- /page -->

