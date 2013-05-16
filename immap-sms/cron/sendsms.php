<?php
define('MAIN',realpath('../'));
include MAIN.'/includes/config.php';
include MAIN.'/includes/class.admin.php';
include 'cron-functions.php';
$dbObj = new Admin();


$sql ="";
$rsQry = "";
$rows = "";


/*while(true)
	{*/
	
	 $rsQry = "select * from sms_outbound WHERE status = 0 order by id asc";
 	 $rows = $dbObj->RunQueryObj($rsQry);
	 
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
			  sendSMSAllGateways($ref_id, $msisdn,$message,$user_id,$group_id,$subgroup_id,$unique_id,$dbObj,'w'); // sending sms 

	   
   		 } // foreach
	 }// end if	
	 

  ?> 