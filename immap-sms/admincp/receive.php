<?php 
define('MAIN',realpath('../'));
include MAIN.'/includes/config.php';
include MAIN.'/includes/class.admin.php';
include MAIN.'/cron/cron-functions.php';
$admin = new Admin();



$username = isset($_REQUEST["username"])?$_REQUEST["username"]:"";
$password = isset($_REQUEST["password"])?$_REQUEST["password"]:"";
$from = isset($_REQUEST["from"])?substr($_REQUEST["from"], 1):"";
$text = isset($_REQUEST["text"])?$_REQUEST["text"]:"";
$mid = isset($_REQUEST["mid"])?$_REQUEST["mid"]:"";
$sid = isset($_REQUEST["sid"])?$_REQUEST["sid"]:"";
$ins_id = "";



/*$username = "phf";
$password = "phf2012";
$from = "923335049649";


//$text = "hs$";
$text = "gall$ Test from cell phone";*/
$unique_id =  date("YmdHis").rand(1,999999);
 SMSLogging("CALLING SMS FUNCTION FOR  : $from");
 
if($username == "phf" and $password == "phf2012")
{
	
 ///// if cell number in the admin table then allow to distribute the SMS///////////
 
$go = getFieldWhere("id","sms_admin_user","where cell =".$from." and status=1");

 if($go)
  { 
  
   	SMSLogging("Cell number is admin  :");
	 $message = "";
	 $message = explode("$",$text);
	 
	 if(!empty($message[0]) and !empty($message[1]))
	  {
		  $gs = ucfirst(substr($message[0], 0,1));
		
		SMSLogging("Group SubGroup : $gs");
		
		
		

		 
		 
		if($gs == 'G')
		 {
			
			  $group_id = getFieldWhere("id","sms_group","where UPPER(sgroup)='".strtoupper($message[0])."' and status = 1");
			 SMSLogging("Group ID : $group_id");
			 if($group_id)
			  {
				   $sql = 'select user_id from sms_user_group where group_id ='.$group_id;
				 
				  $rows = $admin->RunQueryObj($sql);
				SMSLogging("Get Group User : $sql");
				  foreach($rows as $row)
				   {
					   
					   		
							$user_id = !empty($row->user_id)?$row->user_id:"";
							SMSLogging("Get User ID : $user_id");
							if(!empty($user_id))
							 {
								
								$msisdn_to = getFieldWhere("cell","sms_user","where id=".$user_id." and status = 1");
								SMSLogging("Get To whome you send SMS : $msisdn_to");
								if($msisdn_to)
								{
									$arrValue = array (	
									"ref_id" => '',
									"msisdn_from" => $from,
									"msisdn_to" => $msisdn_to,
									"user_id" => $user_id,
									"message" => $message[1],
									"group_id" => $group_id,		
									"subgroup_id" => '',
									"unique_id" => $unique_id,
									"status" => 0,
									"type" => 'm',
									"date_time" => date("Y-m-d H:i:s")
									);
									
									
									$ins_id = $admin->Insert(TBLOB, $arrValue);  
									
									SMSLogging("Inserted into OB : ");
								}
								
							 }
							 
							
							 
				   }
			  }
			 else
			  {
				 	 $arrValue = array (	
									"ref_id" => '',
									"msisdn_from" => $from,
									"msisdn_to" => $from,
									"user_id" => '',
									"message" => 'Invalid group!',
									"group_id" => '',		
									"subgroup_id" => '',
									"unique_id" => $unique_id,
									"status" => 0,
									"type" => 'm',
									"date_time" => date("Y-m-d H:i:s")
									);
									
									
									$ins_id = $admin->Insert(TBLOB, $arrValue);  	
			  }
			 
		 }
		 
		if($gs == 'S')
		 {
			
			$subgroup_id = getFieldWhere("id","sms_subgroup","where ssubgroup ='".strtoupper($message[0])."' and status = 1");
			$group_id = getFieldWhere("group_id","sms_subgroup","where id =".$subgroup_id);
			
			 if($subgroup_id)
			  {
				   $sql = 'select user_id from sms_user_group where subgroup_id ='.$subgroup_id;
				 
				  $rows = $admin->RunQueryObj($sql);
				  
				  foreach($rows as $row)
				   {
					   
					   		
							 $user_id = !empty($row->user_id)?$row->user_id:"";
							
							if(!empty($user_id))
							 {
								
								$msisdn_to = getFieldWhere("cell","sms_user","where id=".$user_id." and status = 1");
								
								if($msisdn_to)
								{
									$arrValue = array (	
									"ref_id" => '',
									"msisdn_from" => $from,
									"msisdn_to" => $msisdn_to,
									"user_id" => $user_id,
									"message" => $message[1],
									"group_id" => $group_id,		
									"subgroup_id" => $subgroup_id,
									"unique_id" => $unique_id,
									"status" => 0,
									"type" => 'm',
									"date_time" => date("Y-m-d H:i:s")
									);
									
									
									$ins_id = $admin->Insert(TBLOB, $arrValue);  	 
								}
								
							 }
							 
							
							 
				   }
			  }
			 else
			  {
				  //Group not found send SMS 
				  
				  $arrValue = array (	
									"ref_id" => '',
									"msisdn_from" => $from,
									"msisdn_to" => $from,
									"user_id" => '',
									"message" => 'Invalid SubGroup!',
									"group_id" => '',		
									"subgroup_id" => '',
									"unique_id" => $unique_id,
									"status" => 0,
									"type" => 'm',
									"date_time" => date("Y-m-d H:i:s")
									);
									
									
									$ins_id = $admin->Insert(TBLOB, $arrValue);  	
			  }
			 
		 
			 
		 }
		///Get group or subgroup
		
		/// send message to the group or subgroup
	  }
	 else if(!empty($message[0]))				
	  {
		
		$gs = strtoupper($message[0]);
		
			if($gs == 'HG')
			 {
				 
					   $sql = 'select group_name,sgroup from sms_group where status = 1';
					   $hmsg = "";
					  $rows = $admin->RunQueryObj($sql);
					  if(!empty($rows))
					   {
						    $hmsg .= "--Group--\n";
						  foreach($rows as $row)
						   {
							   $hmsg .= $row->group_name." : ".$row->sgroup."\n";
						   }
						   
						   $hmsg = substr($hmsg, 0, -1);
						   
						   $arrValue = array (	
										"ref_id" => '',
										"msisdn_from" => $from,
										"msisdn_to" => $from,
										"user_id" => '',
										"message" => $hmsg,
										"group_id" => '',		
										"subgroup_id" => '',
										"unique_id" => $unique_id,
										"status" => 0,
										"type" => 'm',
										"date_time" => date("Y-m-d H:i:s")
										);
										
							$ins_id = $admin->Insert(TBLOB, $arrValue);  
						   
						   
					   }
			 }////end of help group 
			  
			if($gs == 'HS')
			  {
				  $sql = 'select subgroup,ssubgroup from sms_subgroup where status = 1';
				  $hmsg = "";
				  $rows = $admin->RunQueryObj($sql);
				  if(!empty($rows))
				   {
					    $hmsg .= "--SubGroup--\n";
					  foreach($rows as $row)
					   {
						   $hmsg .= $row->subgroup." : ".$row->ssubgroup."\n";
					   }
					   
					   $hmsg = substr($hmsg, 0, -1);
					   
					   $arrValue = array (	
									"ref_id" => '',
									"msisdn_from" => $from,
									"msisdn_to" => $from,
									"user_id" => '',
									"message" => $hmsg,
									"group_id" => '',		
									"subgroup_id" => '',
									"unique_id" => $unique_id,
									"status" => 0,
									"type" => 'm',
									"date_time" => date("Y-m-d H:i:s")
									);
									
					    $ins_id = $admin->Insert(TBLOB, $arrValue);   
			  } 
			 
			 
		 }	///end of Help Sub Group
		}//// End of Help if
	 
	
  }
 
 
 if($ins_id)
  {
	
		$sql ="";
		$rsQry = "";
		$rows = "";
	
	 $rsQry = "select * from sms_outbound WHERE status = 0 order by id asc";
 	 $rows = $admin->RunQueryObj($rsQry);
	 
	//SMSLogging("SQL : $rsQry");
		if(!empty($rows))
		{
			 foreach( $rows as $row ) {  
			  $ref_id = !empty($row->id)?$row->id:"";
			  $msisdn = !empty($row->msisdn_to)?$row->msisdn_to:"";
			  $message = !empty($row->message)?$row->message:"";
			  $user_id = !empty($row->user_id)?$row->user_id:"";		
			  $group_id = !empty($row->group_id)?$row->group_id:"";
			  $subgroup_id = !empty($row->subgroup_id)?$row->subgroup_id:"";
			  $unique_id = !empty($row->unique_id)?$row->unique_id:"";
			  SMSLogging("CALLING SMS FUNCTION FOR  : $msisdn");
			  sendSMSAllGateways($admin); // sending sms 
   		 } // foreach
	 }// end if	
	 
	 }
   
  }


?>