<?php
define('MAIN',realpath('../'));
include MAIN.'/includes/config.php';
include MAIN.'/includes/class.admin.php';

$admin = new Admin();
$msg = "";

//print_r( $_SESSION );
$val = "";
$msg = "";
if(isset($_POST['txtUN']))
{
	 $sql = "Select * from ".TBLADMIN." where username = '".mysql_real_escape_string($_POST['txtUN'])."' and password = '".mysql_real_escape_string($_POST['txtPWD'])."'";
	
	
	$val = $admin->RunQuerySingle($sql);
	
	
	if( !empty($val))
	{
		$_SESSION['session_admin_id'] = $val['id'];	
		header("location: organization.php");	
	}
   else
    $msg = "Username/Password Is Incorrect";

	
}



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>:::: Admin  Control Panel ::::</title>
<link href="main.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/lib/jquery.js"></script>
<script type="text/javascript" src="../js/default.js"></script>
<script type="text/javascript" src="../js/login.js"></script>
</head>

<body>
<!-- CONATINER -->

<div class="container">
<!-- HEADER  -->
	<div>
	   <div class="h_mid">
	    <div class="h_left">
		
		<!-- LOGO  -->
		 <div class="logo"></div>
		 
		 <!-- LOGO  -->	
		
		</div>
		<div class="h_right">
		     <div class="header_menu"></div>
			 
			
		</div>
	   </div> 
	</div>
<!-- END HEADER  -->

<!-- BANNER -->
<div class="banner"></div>
<!-- END BANNER -->

<!-- MID  -->
<div class="mid">
     <!-- LEFT MENU -->
    <div class="mid_left"></div>
	<!-- END LEFT MENU -->
	
	<!-- RIGHT OBJECTS -->
	<div class="mid_right">
	<br /><br /><br />
	<div class="login_box">
	  <form name="frmLogin" id="frmLogin" action="" method="post">
     
	      <?php
				if(isset($msg) && !empty($msg))
				{
				
					echo '<div class="error1" align="center">'.$msg.'</div>';
				}
				
			?>
	       <div id="err" class="error1" style="display:none"></div>
		   <div id="success" class="success" style="display:none"></div>
        <div class="h1_box">Login</div>
	    <div class="h3_box">User name:</div>
	    <div class="h2_box">
          <input name="txtUN" id="txtUN" type="text" class="txt_box_border" />
        </div>
	    <div class="next_line"></div>
	    <div class="h3_box">password:</div>
	    <div class="h2_box">
          <input name="txtPWD" id="txtPWD" type="password" class="txt_box_border" />
        </div>
	    <div class="next_line"></div>
	    <div class="h4_box"></div>
	    <div class="next_line"></div>
	    <div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	      &nbsp;&nbsp;
           <input name="btnLogin" type="submit" id="Login" value="Login" class="login_button"  />
        </div>
	  	    <div class="next_line"></div>
	    
	    </form>
	</div>
	  
	  
	  <div class="login_box"> </div>
	 
	</div>
	<!-- RIGHT OBJECTS -->
</div>

<!-- END MID  -->

<!-- FOOTER -->
<div class="footer_mid"><?php include ("footer.php");?></div>
<!-- END FOOTER -->

</div>
<!-- END CONATINER -->
</body>
</html>


