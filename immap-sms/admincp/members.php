<?php
define('MAIN',realpath('../'));
include MAIN.'/includes/config.php';
include MAIN.'/includes/class.admin.php';
$admin = new Admin();

$pages = new Pager();

$pages->pageEnd = 100;	
$pages->pageSet = 15;
$pagnum = isset($_GET["pagenum"])?$_GET["pagenum"]:"1";

$msg = "";
// checking users for login
check_admin();

if( isset($_GET['id'])  )
 {
 	if($_GET['act'] == "del")
	 {
		 
	 pg_query("delete from ".TBLUSER." where id = '".base64_decode($_GET['id'])."' "); 
	 header("location:members.php?msg=".base64_encode(3));
	 }
   
   if($_GET['act'] == "active")
	{
		$stat = isset($_GET["status"])?$_GET["status"]:"";
		$id  = isset($_GET["id"])?$_GET["id"]:"";
		if($stat == 1)
		 {
		  $stat = 0;
		  $goto = 4;
		 }
		else
		 {
		   $stat = 1;
		   $goto = 5;
		 }
		 
		pg_query("update ".TBLUSER." set status=".$stat." where id=".$id);
		
		 header("location:members.php?msg=".base64_encode($goto));
	}
	
	
		
}		

$pages->baseQry  = "Select * from ".TBLUSER." order by org_id desc";// WHERE status = '1'

	$sql = $pages->getPagingQry();
	$rows = $admin->RunQuery($sql);
	
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
	   		<a href="add_member_lkpt.php" class="hea_txt">Create Member</a>
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
        <div class="all_box">Member</div></span>
          <br />
      <div id="msg" align="center" >
	  	<?php 
		  
		   $msg = isset( $_REQUEST['msg'] ) ? base64_decode($_REQUEST['msg']) : '';
			
			if( !empty($msg)){
				$msgtxt = getMsgTxt($msg,'Member');
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
        </tr>
      <?php
	  if(!empty($rows))
		{
		?>
        <tr bgcolor="#FBD4D5">
          <td width="38" class="tb_h2">Sr No</td>
          <td width="297" height="20" class="tb_h2"><a href="add_group.php" class="hea_txt">Members</a></td>
          <td width="188" class="tb_h2">Organization</td>
          <td width="110" class="tb_h2">Cell</td>
          <td width="79" class="tb_h2">Status</td>
          <td width="96" class="tb_h2">Action</td>
        </tr>
        <?php
	  	//$num = 1;
 if($pagnum == 1)
			  	$num = $pagnum;
			  else
			    $num = (--$pagnum * 100)+1;
		 foreach( $rows as $value ) {  
 		 $num++;
		  
				
				
		if($num%2==0)
			$color="#59C4EF";
			else
			$color="#FFFFFF";  
				  ?>
        <tr bgcolor="<?php echo $color;?>">
          <td class="tb_h3">&nbsp;<?php echo $num -1;?></td>
          <td height="17" class="tb_h3">&nbsp;<?php echo $value['fname']; ?></td>
          <td class="tb_h3"><?php echo getField('organization',TBLORG,$value['org_id']); ?></td>
          <td class="tb_h3"><?php echo $value['cell']; ?></td>
         
          
          <td class="tb_h3">&nbsp;<a href="members.php?id=<?php echo $value['id']; ?>&act=active&status=<?php echo $value['status']?>" class="hea_txt"><?php if($value['status'] == 1) echo "Active"; else echo "DeActive"; ?></a></td>
          <td class="tb_h3"><a href="edit_members.php?id=<?php echo base64_encode($value['id']); ?>" class="hea_txt">Edit</a> </td>
        </tr>
        <?php 
	
			} 
	
		?>	

        <tr>
          <td align="center" colspan="6" class="tb_h2">
              <?php $pages->getPaging(); ?>          </td>
        </tr>
        
      <?php
	   }
        else
			{
			?>
        <tr>
          <td align="center" colspan="6" class="tb_h2"><strong>No Records</strong></td>
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

