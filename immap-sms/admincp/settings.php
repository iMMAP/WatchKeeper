<?php
define('MAIN',realpath('../'));
include MAIN.'/includes/config.php';
include MAIN.'/includes/class.admin.php';
$admin = new Admin();

$msg = "";
// checking users for login
check_admin();

$username = isset($_POST["username"])?$_POST["username"]:"";
$hpassword = isset($_POST["hpassword"])?$_POST["hpassword"]:"";
$opassword = isset($_POST["opassword"])?$_POST["opassword"]:"";
$npassword = isset($_POST["npassword"])?$_POST["npassword"]:"";
$cpassword = isset($_POST["cpassword"])?$_POST["cpassword"]:"";


if(isset($_POST["editmembers"]))
 {
				
				//$go = getFieldWhere("id","sms_admin","where password =".)
			if(!empty($username))
			 {
				 if($npassword == $cpassword)
				 {
					
					
					if($opassword == base64_decode($hpassword))
					 {
							$arrValue = array (	
					         	"username" => $username,
								"password" => $npassword								
							);
						$where =  "id = 1";	
							
							
						
						$msg = array("Record Update Successfully","Error in updating");
						$val = $admin->update_tbl("sms_admin",$where ,$arrValue, $msg);
						// showing the msg of the query
						$msg = $admin->show_msg($val);
						
						if($val)
						 {
							 	$hpassword = "";
								$opassword = "";
								$npassword = "";
								$cpassword = "";
						 }
						
					 
				     }
					else
				 	 {
						  $msg = "Old Password is wrong";
					 }
					
				 }
				else
				 {
					 $msg = "New password and confirm password mismatch";
				 }
			 }
			else
			 {
				 $msg = "Please enter username";
			 }
				
				
	}				 


	$sql = "select * from sms_admin where id =1";
	$row = $admin->RunQuerySingleObj($sql);
	if(!empty($row))
	{
		$username = !empty($row->username)?$row->username:"";
		$password = !empty($row->password)?$row->password:"";
				
	}
  
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>:::: Admin  Control Panel ::::</title>
<link href="main.css" rel="stylesheet" type="text/css" />
<link href="../css/silver.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/lib/prototype.js"></script>
<script type="text/javascript" src="../js/lib/jquery.js"></script>
<script type="text/javascript" src="js/default.js"></script>
<script type="text/javascript" src="../js/admin/members.js"></script>


</head>

<body>
<!-- CONATINER -->

<div class="container">
<!-- HEADER  -->
	<div>
	 
		     <div class="header_menu"><div align="right" >
			 <?php include('top.php');?>
			 </div></div>
			 
			 <!-- Button -->
			 <div id="menu">
				<?php include('header.php')?>
		  </div>
			 <!-- END Button -->
	 
	</div>
<!-- END HEADER  -->

<!-- BANNER -->
<div class="banner">
  <div class="hea_ico"></div>
</div>
<!-- END BANNER -->

<!-- MID  -->
  <div class="mid"> 
    <!-- LEFT MENU -->
    <!-- END LEFT MENU -->
    <!-- RIGHT OBJECTS -->
    <div>
      
          <span class="h1_box_2">
        <div class="all_box"> <br/>
        Update Settings</div> </span>
          <br />
          <div id="msg" align="left"><strong><?php echo $msg;?></strong></div>
<div id="outer_div"  ></div>
        <div id="err" class="error" style="display:none"></div>
<div id="success" class="success" style="display:none"></div>
    <form name="form_member" id="form_member" action="" method="post" >
    <input type="hidden" name="hpassword" id="hpassword" value="<?php echo base64_encode($password)?>" />
      <table width="100%" height="28" cellpadding="1" cellspacing="1">
        <tr>
          <td width="166" class="tb_h3" >Username:</td>
          <td width="673" ><span class="tb_h3">
            <input name="username" type="text" class="sign_inp" id="username" style="width:400px;" value="<?php echo $username;?>" />
          </span></td>
        </tr>
        <tr>
          <td width="166" class="tb_h3" >Old Password:</td>
          <td width="673" ><span class="tb_h3">
            <input name="opassword" type="password" class="sign_inp" id="opassword" style="width:400px;" value="<?php echo $opassword;?>" />
          </span> <br /></td>
        </tr>
		<tr>
          <td width="166" class="tb_h3" >New Password:</td>
          <td width="673" ><span class="tb_h3">
            <input name="npassword" type="password" class="sign_inp" id="npassword" style="width:400px;" value="<?php echo $npassword;?>" />
          </span></td>
        </tr>
        <tr>
          <td width="166" class="tb_h3" >Confirm Password:</td>
          <td width="673" ><span class="tb_h3">
            <input name="cpassword" type="password" class="sign_inp" id="cpassword" style="width:400px;" value="<?php echo $cpassword;?>" />
          </span></td>
        </tr>
		
        <tr>
          <td height="17">&nbsp;</td>
          <td class="tb_h3" >&nbsp;</td>
        </tr>
        <tr>
          <td height="17">&nbsp;</td>
          <td class="tb_h3" ><input type="submit" name="editmembers" id="editmembers" value="Update"  /></td>
        </tr>
      </table>
      </form>
    </div>
    <!-- RIGHT OBJECTS -->
</div>

<!-- END MID  -->

<!-- FOOTER -->
<div class="footer_mid"><?php include ("footer.php");?></div>
<!-- END FOOTER -->

</div>
<!-- END CONATINER -->

<div id="theFormDiv"></div>

</body>
</html>

