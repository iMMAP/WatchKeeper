<?php
define('MAIN',realpath('../'));
include MAIN.'/includes/config.php';
include MAIN.'/includes/class.admin.php';
$admin = new Admin();

$msg = "";
// checking users for login
check_admin();

$email = "";
$pass = "";


if(isset($_POST["organization"]) and isset($_POST["cell"]))
 {
		

				$organization = isset($_POST["organization"])?$_POST["organization"]:"";
				$fname = isset($_POST["fname"])?$_POST["fname"]:"";
				$cell = isset($_POST["cell"])?$_POST["cell"]:"";
				$email = isset($_POST["email"])?$_POST["email"]:"";
				$password = isset($_POST["password"])?$_POST["password"]:"";
				$country = isset($_POST["country"])?$_POST["country"]:"";
				
				$characters = '0123456789abcdefghijklmnopqrstuvwxyz';
				$randomString = '';
				
				for ($i = 0; $i < 6; $i++) {
					$randomString .= $characters[rand(0, strlen($characters) - 1)];
				}
				
				
				
				
				
				
				$date = date("Y-m-d");
				
				$arrValue = array (	
					        "org_id" => $organization,
						    "fname" => $fname,
							"cell" => $cell,
							"email" => $email,
							"password" => $randomString,
							"country_id" => $country,
							"date_time" => $date,
							"status" => 1
							);
				
				
			 $ins_id = $admin->Insert("sms_user", $arrValue);
			if($ins_id)
			{	
				
				$to  = $email ;
				$subject = "WatchKeeper";
				$message = "Dear ".$fname.",<br /><br />
				Your user name is: ".$email."<br /><br />
Your password is: ".$randomString."<br /><br />
	You can change your password once you have logged in and you can also reset your password if you have forgotten it.<br /><br />	
Best Regards,<br /><br />
WatchKeeper";
				
				
					
				$headers  = "MIME-Version: 1.0\r\n";
				$headers .= "From: WatchKeeper <noreply@immap.org>\r\n";
				
				$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
					
				mail($to, $subject, $message, $headers);
				
				 header("Location:members.php?msg=".base64_encode(1)); 
			}
			else {
				
				 $msg =   $admin->display_msg('Error while adding member!',false);
			}
			  
		
			// showing the msg of the query
			$msg = $admin->show_msg($val);
			  
	}				 



		
		$org_id = isset($_POST["org_id"])?$_POST["org_id"]:"";
		$fname =  isset($_POST["fname"])?$_POST["fname"]:"";
		$cell =   isset($_POST["cell"])?$_POST["cell"]:"";
		$email =  isset($_POST["email"])?$_POST["email"]:"";
		
		
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>:::: Admin  Control Panel ::::</title>
<link href="main.css" rel="stylesheet" type="text/css" />
<link href="../css/silver.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/lib/jquery.js"></script>
<script type="text/javascript" src="../js/default.js"></script>
<script type="text/javascript" src="../js/member.js"></script>

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
        Add Member</div> </span>
          <br />
          <div id="msg" align="center"><?php echo $msg;?></div>
<div id="outer_div"  ></div>
        <div id="err" class="error" style="display:none"></div>
<div id="success" class="success" style="display:none"></div>
    <form name="form_member" id="form_member" action="" method="post" >
	 <input type="hidden" name="path" id="path" value="<?php echo FULL_PATH?>" /> 
     
      <table width="100%" height="28" cellpadding="1" cellspacing="1">
        <tr>
          <td width="166" class="tb_h3" >Organization:</td>
          <td width="673" ><span class="tb_h3">
           <?php
		  
             echo getOrgDD($org_id,"chnage_org()");
		   ?>
          </span></td>
        </tr>
        <tr>
          <td width="166" class="tb_h3" >Country:</td>
          <td width="673" ><span class="tb_h3">
           <?php
		  
             echo getDD("country","sms_country","class='sign_inp' style='border: 2px solid rgb(216, 216, 216);'","country","where status = 1",'');
		   ?>
          </span></td>
        </tr>
		 <tr>
       
		
          <td width="166" class="tb_h3" >Full Name:</td>
          <td width="673" ><span class="tb_h3">
           <input type="text" name="fname" id="fname" class="sign_inp" value="<?php echo $fname;?>" />  
          </span></td>
        </tr>
        <tr>
          <td width="166" class="tb_h3" >Cell number:</td>
          <td width="673" ><span class="tb_h3">
			<input type="text" name="cell" id="cell" class="sign_inp" value="<?php echo $cell;?>" />        
           </span><br /> &nbsp;<strong>Example: 923335262552</strong></td>
        </tr>
         <tr>
          <td width="166" class="tb_h3" >Email:</td>
          <td width="673" ><span class="tb_h3">
			<input type="text" name="email" id="email" class="sign_inp" value="<?php echo $email;?>" />          
           </span></td>
        </tr>
         
		
        <tr>
          <td height="17">&nbsp;</td>
          <td class="tb_h3" >&nbsp;</td>
        </tr>
        <tr>
          <td height="17">&nbsp;</td>
          <td class="tb_h3" ><input type="submit" name="editmembers" id="add" value="Add Member"  />
            <input type="button" name="button" id="button" value="Back" onclick="javascript:window.location.href='members.php'" /></td>
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
<script language="javascript">
	chnage_org();
	chk_SubGroup();
</script>
