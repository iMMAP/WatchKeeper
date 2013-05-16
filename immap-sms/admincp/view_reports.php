<?php
define('MAIN',realpath('../'));
include MAIN.'/includes/config.php';
include MAIN.'/includes/class.admin.php';
$admin = new Admin();

$pages = new Pager();

$pages->pageEnd = 200;	
$pages->pageSet = 15;
$pagnum = isset($_GET["pagenum"])?$_GET["pagenum"]:"1";

$msg = "";
// checking users for login
check_admin();

if(isset($_GET["id"]) and !empty($_GET["id"]))
 {
	  $pages->baseQry  = "Select id,message,group_id,subgroup_id,user_id,status,msisdn_to from sms_inbound  where unique_id='".base64_decode($_GET["id"])."' order by id desc  ";// WHERE status = '1'

	$sql = $pages->getPagingQry();
	$rows = $admin->RunQueryObj($sql);
 }
else
 {
	header("location:reports.php?msg=".base64_encode(9));  
 }


	
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>:::: Admin  Control Panel ::::</title>
<link href="main.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/lib/jquery.js"></script>
<script type="text/javascript" src="js/default.js"></script>


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
<div class="hea_ico">
<div class="hea_right3">
    <div class="auto1_div"></div>
	   
	   <div class="auto1_div2">
	   		<a href="add_group.php" class="hea_txt">Create Group</a>
	   </div>
		<div class="auto1_div">
			<img src="images/create_event.gif" width="18" height="21" />
		</div>
        
	   
	
		<div class="auto1_div"></div>
		
	  </div></div>

</div>
<!-- END BANNER -->

<!-- MID  -->
  <div class="mid"> 
    <!-- LEFT MENU -->
    <!-- END LEFT MENU -->
    <!-- RIGHT OBJECTS -->
    <div>
      <form name="form_plan" id="form_plan" action="" method="post" >
        <br/>
          <span class="h1_box_2"> 
        <div class="all_box">Groups</div></span>
          <br />
      <div id="msg" align="center" >
	  	<?php 
		  
		   $msg = isset( $_REQUEST['msg'] ) ? base64_decode($_REQUEST['msg']) : '';
			
			if( !empty($msg)){
				$msgtxt = getMsgTxt($msg,'Group');
				 echo $admin->display_msg($msgtxt,false);
			}
		
			?></div>
          <div class="all_box">
        <div></div>
          <div></div>
      </form>
      <table width="100%" height="28" cellpadding="2" cellspacing="2">
        <tr>
          <td class="tb_h2">&nbsp;</td>
                  
         
          <td class="tb_h2">&nbsp;</td>
          <td class="tb_h2">&nbsp;</td>
          <td class="tb_h2">&nbsp;</td>
           <td class="tb_h2">&nbsp;</td>
          <td class="tb_h2">&nbsp;</td>
          <td class="tb_h2">&nbsp;<input type="button" name="button" id="button" value="Back" onclick="javascript:window.location.href='reports.php'" /></td>
          
        </tr>
      <?php
	  if(!empty($rows))
		{
			
			if($pagnum == 1)
			  	$num = $pagnum;
			  else
			    $num = (--$pagnum * 200)+1;
		?>
        <tr bgcolor="#FBD4D5">
          <td width="39" height="20" class="tb_h2">Sr no</td>
          <td width="606" class="tb_h2">message</td>
          <td width="181" class="tb_h2">Sent to</td>
          <td width="181" class="tb_h2">Group</td>
          <td width="181" class="tb_h2">SubGroup</td> 
          <td width="181" class="tb_h2">Cell</td>
          <td width="181" class="tb_h2">Status</td>
         
        </tr>
        <?php
	  	

		 foreach( $rows as $value ) {  
 		
		if($num%2==0)
			$color="#59C4EF";
			else
			$color="#FFFFFF";  
				  ?>
            
        <tr bgcolor="<?php echo $color;?>">
          <td height="17" class="tb_h3">&nbsp;<?php echo $num++; ?></td>
         
          
          <td class="tb_h3">&nbsp;
         <?php echo $value->message; ?></td>
          <td class="tb_h3">&nbsp;<?php  echo  getField("fname","sms_user",$value->user_id); ?></td>
          
           <td class="tb_h3"> 
            <?php  echo  getField("group_name","sms_group",$value->group_id); ?>
          </td>
           <td class="tb_h3"><?php  echo getField("subgroup","sms_subgroup",$value->subgroup_id); ?></td>
           <td class="tb_h3"><?php  echo $value->msisdn_to; ?></td>
          <td class="tb_h3">
          <?php 
		  	if($value->status == 2)
			 echo "Processing";
			elseif($value->status == 1)
			 echo "Sent";
			else
			 echo "Not Sent"; 
		  ?>
          </td>
         
        </tr>
        <?php 
	
			} 
	
		?>	

        <tr>
          <td align="center" colspan="7" class="tb_h2">
              <?php 
			  $pages->pageParam ="id=".$_GET["id"];
			  $pages->getPaging(); ?>          </td>
        </tr>
        
      <?php
	   }
        else
			{
			?>
        <tr>
          <td align="center" colspan="7" class="tb_h2"><strong>No Records</strong></td>
        </tr>
        <?php 
			}
	
		?>
      </table>
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

