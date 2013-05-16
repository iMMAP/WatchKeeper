<?php
define('MAIN',realpath('../'));
include MAIN.'/includes/config.php';
include MAIN.'/includes/class.admin.php';

include MAIN.'/cron/cron-functions.php';
$admin = new Admin();


$msg = isset( $_REQUEST['msg'] ) ? base64_decode($_REQUEST['msg']) : '';
// checking users for login
check_admin();



$msg = "";
// checking users for login




if(isset($_POST["add_ms"]))
 {
	$count = 20;
	$sms_msg = isset($_POST["sms_msg"])?$_POST["sms_msg"]:"";
	$group = isset($_POST["group"])?$_POST["group"]:"testGroup";

	$subgroup = isset($_POST["subgroup"])?$_POST["subgroup"]:"testSubGroup";
	$unique_id =  date("YmdHis").rand(1,999999);
	
	$ins_id = "";
	

	for($i=0; $i<$count; $i++)
	{
		
		 
		  $msisdn_to = "923335049649";
		  
		  
		  
			
				$arrValue = array (	
					"ref_id" => '',
					"msisdn_to" => $msisdn_to,
					"user_id" => $_POST["chk"][$i],
					"message" => $sms_msg,
					"group_id" => $group,		
					"subgroup_id" => $subgroup,
					"unique_id" => $unique_id,
					"status" => 0,
					"type" => 'w',
					"date_time" => date("Y-m-d H:i:s")
					);
				$ins_id = $admin->Insert(TBLOB, $arrValue);
			 
			
		 
		 
	}
	
	
 	if($ins_id)
	 {
		
		$sql ="";
		$rsQry = "";
		$rows = "";


/*while(true)
	{*/
	
	 $rsQry = "select * from sms_outbound WHERE status = 0 order by id asc LIMIT 0, 10";
	 //$rsQry = "select * from sms_outbound WHERE status = 0 order by id asc";
 	 $rows = $admin->RunQueryObj($rsQry);
	 
	//SMSLogging("SQL : $rsQry");
		if(!empty($rows))
		{
			 foreach( $rows as $row ) {  
		 
		  $res = "";
			  $ref_id = !empty($row->id)?$row->id:"";
			  $msisdn = !empty($row->msisdn_to)?$row->msisdn_to:"";
			  $message = !empty($row->message)?$row->message:"";
			  $user_id = !empty($row->user_id)?$row->user_id:"";		
			  $group_id = !empty($row->group_id)?$row->group_id:"";
			  $subgroup_id = !empty($row->subgroup_id)?$row->subgroup_id:"";
			  $unique_id = !empty($row->unique_id)?$row->unique_id:"";
			  
			  
			  SMSLogging("CALLING SMS FUNCTION FOR  : $msisdn");
			  $res = sendTop6($ref_id, $msisdn,$message,$user_id,$group_id,$subgroup_id,$unique_id,$admin,'w'); // sending sms 

	   
   		 } // foreach
	 }// end if	
	 
		$num = "";
		if($res == "ok")
		 $num = "1";
		else
		 $num = "10";
		
		header("Location:message.php?msg=".base64_encode($num));
	 	exit();
	 }
	else
	 {
	 $msg = 7;
	 }
 }

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>:::: Message ::::</title>
<link href="main.css" rel="stylesheet" type="text/css" />                                           

<script type="text/javascript" src="../js/lib/jquery.js"></script>
<script type="text/javascript" src="../js/default.js"></script>
<script type="text/javascript" src="../js/message.js"></script>
</head>
<body>
<!-- CONATINER -->
<div class="container">
<!-- HEADER  -->
	<div>
		     <div class="header_menu"><div align="right" >
			
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
        Create New Message</div> 
          </span>
          <br />
          <div id="msg" align="center" >
	  	<?php 
		  
		   $msg = isset( $_REQUEST['msg'] ) ? base64_decode($_REQUEST['msg']) : '';
			
			if( !empty($msg)){
				$msgtxt = getMsgTxt($msg,'Message');
				 echo $admin->display_msg($msgtxt,true);
			}
		
			?></div>
		<div id="outer_div"  ></div>
        <div id="err" class="error1" style="display:none"></div>
		<div id="success" class="success" style="display:none"></div>
    <form action="" method="post" enctype="multipart/form-data" name="form_keyword" id="form_keyword" >
	<input type="hidden" name="path" id="path" value="<?php echo FULL_PATH?>" />
	<input type="hidden" name="add_ms" id="add_ms" value="add_ms" />
    <input type="hidden" name="organization_h" id="organization_h" value="" />
     <input type="hidden" name="group_h" id="group_h" value="" />
     
     
         <div id="msg" align="center" >
	  	<?php 
		  
		   
			
			if( !empty($msg)){
				$msgtxt = getMsgTxt($msg,'Messages');
				 echo $admin->display_msg($msgtxt,false);
			}
		
			?></div>
      <table width="100%" height="28" cellpadding="1" cellspacing="1">
       
		
		 
		
		 <tr id="tr_msg">
          <td width="109" class="tb_h3" valign="top">Message:</td>
          <td width="404" id="output" >
		  	<textarea name="sms_msg" cols="30" rows="6"  id="sms_msg"   class="sign_inp"></textarea></td>
          <td width="323" align="left" valign="bottom">&nbsp;&nbsp;        </td>
        </tr>
      
     	<tr>
          <td height="17">&nbsp;</td>
          <td class="tb_h3" >&nbsp;</td>
          <td class="tb_h3" >&nbsp;</td>
        </tr>
        <tr>
          <td height="17">&nbsp;</td>
          <td class="tb_h3" ><input name="btnAdd" type="submit" id="btnAdd" value="Send" onclick="return addMessage();"  />&nbsp;&nbsp;
		  
		  </td>
          <td class="tb_h3" >&nbsp;</td>
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

