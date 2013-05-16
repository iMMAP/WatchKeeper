<!DOCTYPE html>
<!--
Design by mRova Solutions
http://www.mrova.com
Released for free under a Creative Commons Attribution 2.5 License
-->

<html>
	<head>
		<title>iMMAP Security News Login</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0;" />
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<!-- <link rel="stylesheet" href="http://code.jquery.com/mobile/1.0/jquery.mobile-1.0.min.css" /> -->
		<link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.0/jquery.mobile-1.3.0.min.css" />
		
		<link rel="stylesheet" href="css/style.css" />
		<link rel="stylesheet" href="css/photoswipe.css" />
		<!-- <script type="text/javascript" src="http://code.jquery.com/jquery-1.6.4.min.js"></script>
		<script type="text/javascript" src="http://code.jquery.com/mobile/1.0/jquery.mobile-1.0.min.js"></script> -->
		
		
		<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
		<script src="http://code.jquery.com/mobile/1.3.0/jquery.mobile-1.3.0.min.js"></script>
		<script type="text/javascript" src="js/klass.min.js"></script>
		<script type="text/javascript" src="js/code.photoswipe.jquery-3.0.4.min.js"></script>
		<script type="text/javascript" src="js/custom.js"></script>
		
	</head>
	<body>
		<div data-role="page" data-add-back-btn="true" id="login-page">
			<div data-role="header" id="header">
				<h1>Please Login</h1>
			</div><!-- /header -->
			
	<div data-role="content"><img src="../sec-web/images/logoimmap.png" width="100%" /></div>		
	<div data-role="content">  
		<form class="contact_form" action="auth.php" method="post" name="contact_form">
			<fieldset data-role="fieldcontain"> 
		        <label for="username">User Name:</label>
		        <input name="username" type="text"  placeholder="" required/>
		   </fieldset>
		   <fieldset data-role="fieldcontain"> 
				<label for="password">Password:</label>
				<input name="password" type="password"  placeholder="" required/>
			</fieldset>
		    <button class="submit" type="submit">Login</button>
		</form>
	</div>
			
	      <div data-role="footer" data-theme="a">
            <div class="ui-bar">
                        
           	 <!-- <a href="saveEvent.php?state=del&id=<?php echo $id;?>" data-role="button" data-icon="arrow-u" data-theme="a" style="float:right;">Delete</a>  -->
           
           </div>
          </div>
          <!-- /Footer --> 

		</div><!-- /page -->
	</body>
</html>
<script>
	$('#gallery-page').live('pageshow', function(event) {
    	getAlertLists($('#listview'), 10, 0);
	});
</script>
