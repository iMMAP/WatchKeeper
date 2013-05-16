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


if(isset($_POST["editmembers"]))
 {
				$id = isset($_POST["id"])?base64_decode($_POST["id"]):"";
				$organization = isset($_POST["organization"])?$_POST["organization"]:"";
				
				
				$arrValue = array (	
					         	"organization" => $organization
								
							);
				$where =  "id = ".$id;			
			
			$msg = array("Record Update Successfully","Error in updating");
			$val = $admin->update_tbl(TBLORG,$where ,$arrValue, $msg);
		
			// showing the msg of the query
			$msg = $admin->show_msg($val);
			  
	}				 

$id = isset($_GET["id"])?base64_decode($_GET["id"]):"";
if($id !="")
{
	$sql = "select * from ".TBLORG." where id =".$id;
	$row = $admin->RunQuerySingleObj($sql);
	if(!empty($row))
	{
		$organization = !empty($row->organization)?$row->organization:"";
						
	}
   else
	{
		header("location:organization.php?msg=".base64_encode(6)); 
	}
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
        Update Organization</div> </span>
          <br />
          <div id="msg" align="center"><?php echo $msg;?></div>
<div id="outer_div"  ></div>
        <div id="err" class="error" style="display:none"></div>
<div id="success" class="success" style="display:none"></div>
    <form name="form_member" id="form_member" action="" method="post" >
      <table width="100%" height="28" cellpadding="1" cellspacing="1">
        <tr>
          <td width="166" class="tb_h3" >Organization Name:</td>
          <td width="673" ><span class="tb_h3">
            <input name="organization" type="text" class="sign_inp" id="organization" style="width:400px;" value="<?php echo $organization;?>" />
          </span></td>
        </tr>
		
		
        <tr>
          <td height="17">&nbsp;</td>
          <td class="tb_h3" >&nbsp;</td>
        </tr>
        <tr>
          <td height="17">&nbsp;<input type="hidden" name="id" value="<?php echo base64_encode($id);?>" /></td>
          <td class="tb_h3" ><input type="submit" name="editmembers" id="editmembers" value="Update"  />
            <input type="button" name="button" id="button" value="Back" onclick="javascript:window.location.href='organization.php'" /></td>
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

