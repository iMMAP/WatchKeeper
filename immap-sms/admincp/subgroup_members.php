<?php
define('MAIN',realpath('../'));
include MAIN.'/includes/config.php';
include MAIN.'/includes/class.admin.php';
$admin = new Admin();

$pages = new Pager();

$pages->pageEnd = 300;	
$pages->pageSet = 15;

$gid = isset($_REQUEST["gid"])?$_REQUEST["gid"]:"";
$msg = "";
// checking users for login
check_admin();

if( isset($_POST['delete'])  )
 {
	
	
	$del = isset($_POST["Unsubscribe"])?$_POST["Unsubscribe"]:"";
 	foreach($del as $val)
	 {
		 	 $qry = "delete from sms_user_group where subgroup_id =".base64_decode($gid)." and user_id =".$val;
		
		 pg_query($qry);
	 }
	
	 header("location:subgroup_members.php?gid=".$gid."&msg=".base64_encode(3));
	
   
   
	
	
		
}	

$pages->baseQry  = "Select u.*,ug.group_id,ug.subgroup_id from ".TBLUSER." u inner join sms_user_group ug on u.id = ug.user_id where ug.subgroup_id  = ".base64_decode($gid)." order by u.id desc";// WHERE status = '1'

	$sql = $pages->getPagingQry();
	$rows = $admin->RunQueryObj($sql);
	
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
	   		<a href="add_Submembers.php?gid=<?php echo $gid?>" class="hea_txt">Assign Member</a>
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
      	<input type="hidden" name="gid" id="gid" value="<?php echo $gid?>" />
        <br/>
          <span class="h1_box_2"> 
        <div class="all_box"><?php echo ucfirst(getField('subgroup','sms_subgroup',base64_decode($gid)));?>'s Members</div></span>
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
      
      <table width="100%" height="28" cellpadding="2" cellspacing="2">
        <tr>
          <td class="tb_h2">&nbsp;</td>
          <td class="tb_h2">&nbsp;</td>
          <td class="tb_h2">&nbsp;</td>
          <td class="tb_h2">&nbsp;</td>
          <td class="tb_h2">&nbsp;</td>
          <td class="tb_h2">&nbsp;</td>
          <td class="tb_h2" align="right"><input type="button" name="button" id="button" value="Back" onclick="javascript:window.location.href='subgroups.php'" /></td>
                  
         
         
        </tr>
      <?php
	  if(!empty($rows))
		{
		?>
        <tr bgcolor="#FBD4D5">
          <td width="42" class="tb_h2">Sr No</td>
          <td width="115" class="tb_h2">Unsubscribe</td>
          <td width="260" height="20" class="tb_h2"><a href="add_group.php" class="hea_txt">Members</a></td>
          <td width="114" class="tb_h2">Organization</td>
          <td width="100" class="tb_h2">Group</td>
          <td width="89" class="tb_h2">SubGroup</td>
          <td width="82" class="tb_h2">Cell</td>
        
         
         
        </tr>
        <?php
	  	$num = 1;

		 foreach( $rows as $value ) {  
 		 $num++;
		if($num%2==0)
			$color="#59C4EF";
			else
			$color="#FFFFFF";  
				  ?>
        <tr bgcolor="<?php echo $color;?>">
          <td class="tb_h3">&nbsp;<?php echo $num -1;?></td>
          <td class="tb_h3"><input type="checkbox" name="Unsubscribe[]" id="Unsubscribe[]" value="<?php echo $value->id;?>" /></td>
          <td height="17" class="tb_h3">&nbsp;<?php echo $value->fname; ?></td>
          <td class="tb_h3"><?php echo getField('organization',TBLORG,$value->org_id); ?></td>
          <td class="tb_h3"><?php echo getField('group_name',TBLGROUP,$value->group_id); ?></td>
          <td class="tb_h3"><?php echo getField('subgroup',TBLSUBGROUP,$value->subgroup_id); ?></td>
          <td class="tb_h3"><?php echo $value->cell; ?></td>
         
          
          
        </tr>
        <?php 
	
			} 
	
		?>	
<tr>
          <td align="left" colspan="6" class="tb_h2">
              <input type="submit" name="delete" id="delete" value="Unsubscribe Members from <?php echo ucfirst(getField('subgroup','sms_subgroup',base64_decode($gid)));?>" />    
               </td>
        </tr>
        <tr>
          <td align="center" colspan="7" class="tb_h2">
              <?php 
			  $pages->pageParam ="gid=".$gid;
			  $pages->getPaging(); 
			  ?>          </td>
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

