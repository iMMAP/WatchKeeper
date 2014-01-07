<?php
include '../sec-m/dbconnect.php';
session_start(); // must be before any output
	if (!isset($_SESSION['participantusername'])) 
		header("Location: login.php");
	
$db = getDB();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>iMMAP Watchkeeper</title>
    <link rel="stylesheet" href="jqwidgets/styles/jqx.base.css" type="text/css" />
    
    <link rel="stylesheet" href="website.css" type="text/css" media="screen" />
    <link href='http://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
    
    
    
    <script type="text/javascript" src="scripts/gettheme.js"></script>
    
    <script type="text/javascript" src="scripts/jquery-1.8.2.min.js"></script>
    <!-- <script type="text/javascript" src="jquery-1.4.2.min.js"></script> -->
    
    <script type="text/javascript" src="jqwidgets/jqxcore.js"></script>
    <script type="text/javascript" src="jqwidgets/jqxscrollbar.js"></script>
    <script type="text/javascript" src="jqwidgets/jqxbuttons.js"></script>
    <script type="text/javascript" src="jqwidgets/jqxpanel.js"></script>
    <script type="text/javascript" src="jqwidgets/jqxtooltip.js"></script>
    <script type="text/javascript" src="jqwidgets/jqxlistmenu.js"></script>
    <script type="text/javascript" src="jquery.tinycarousel.min.js"></script>
    <script type="text/javascript" src="jqwidgets/jqxtabs.js"></script>
    <script type="text/javascript" src="scripts/jquery.bpopup-0.9.0.min.js"></script>
	
    
    <link rel="stylesheet" href="jquery.checkbox.css" />
	<link rel="stylesheet" href="jquery.safari-checkbox.css" />
	<link rel="stylesheet" href="flags.css" />
	<script type="text/javascript" src="jquery.checkbox.min.js"></script>

	<script src="http://maps.google.com/maps/api/js?sensor=false&language=en" type="text/javascript"></script>
	<script type="text/javascript" src="gmap3.js"></script>
	<link href="styles.css" rel="stylesheet" type="text/css" />
	
    <script type="text/javascript">
		$(document).ready(function(){
			$('#slider1').tinycarousel({ interval: true });	
		});
    </script>
    </head>
    <body>
<div class="headerimmap">
      <div class="innerheader">
    <div class="logo"><img src="images/logoimmap.png" width="273" height="66" /></div>
    <!-- <div class="linkstop">
    	<div id="flagmenu">
	    	<ul>
	    		<li><a href="#" class="flag pk" title="Pakistan"></a></li>
	    		<li><a href="#" class="flag af" title="Afghanistan"></a></li>
	    		<li><a href="#" class="flag iq" title="Iraq"></a></li>
	    	</ul>
	    </div>	
    </div> -->
    <div class="menutop">
          <div id='cssmenu'>
       		<ul>
              <li class='active'><a href='index.php'><span>Home</span></a></li>
              <li class='has-sub'><a href='index.php?m=history'><span>History</span></a>
              <li id="cprofile" style="display: none"><a href='index.php?m=about&contry=<?php echo $_REQUEST['contry'];?>'><span>Country Profile</span></a></li>
              <li class='last'><a href='index.php?m=disclaimer'><span>Disclaimer</span></a></li>
            </ul>
      </div>
   </div>
   <div class="logout"><a href="logout.php">Logout</a> | <a href="#">Change Password</a></div>
  </div>
    </div>
<div class="ceRSS"> </div>
<div>
		<!--- Start content-->
      	<div class="contentbox">
			<?php
			$m = $_REQUEST['m'];
			
			if ($m == ''){$m='def';} 
			if ($m=='def'){
				include 'home.php'; 
			} else if ($m=='content'){
				include 'defaultpage.php';
			}else if ($m=='about'){
				if ($_REQUEST['contry']=='PAK'){
					include 'about.html';
				} else if  ($_REQUEST['contry']=='IRQ'){
					include 'about_iraq.html';
				}
			} else if ($m=='history'){
				include 'history.php';
			} else if ($m=='disclaimer'){
				include 'disclaimer.php';
			}
			?>
			
  		</div>
  		<!--- End Content --->
    </div>
<br/>    

</div>

<div class="footercontainer">
  <div class="newsscrollerouter">
    <!-- <div style="margin:0 auto; width:1000px"> </div> -->
  </div>
  <div class="cecopyrights">
    <div class="copyrightinner">FOR INTERNAL iMMAP USE ONLY</div>
    <div class="copyrightinner">The information contained in this website is confidential and privileged against disclosure except for internal use by the recipient</div>
    <div class="copyrightinner">iMMAP ©2013</div>
  </div>
</div>


</body>
</html>

<?php 
pg_close($db);	
?>
