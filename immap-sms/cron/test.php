<?php
//phpinfo();
define('MAIN',realpath('../'));
include MAIN.'/includes/config.php';
include MAIN.'/includes/class.admin.php';

$admin = new Admin();
sendSMSAllGateways($admin);
function sendSMSAllGateways($dbObj)
{
	SMSLogging( "function sendSMSAllGateways call\n" );
	
	
	$user = "923455009308"; // package cell
	$password = "3186";
	
	$baseurl ="http://203.215.160.179:8083/corporate_sms2/api";
	$xmlsms = "";
	$error = "";
	$msgId = "";
	$xml = "";
	$mask = "PHFSecurity";
	
	
 
	 $url = "$baseurl/auth.jsp?msisdn=".urlencode(trim($user))."&password=".urlencode(trim($password));	
	//$xml = simplexml_load_file($url);
	
	



 

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$xml = curl_exec($ch);
	curl_close($ch);

	$xml = new SimpleXMLElement($xml); 



	if($xml->response == 'OK')
	   {
		   
		$sql ="";
		$rsQry = "";
		$rows = "";
		
		
		
		$rsQry = "select * from sms_outbound WHERE status = 0 order by id asc";
		$rows = $dbObj->RunQueryObj($rsQry);
		
		
		
		
		if(!empty($rows))
		{
			 foreach( $rows as $row ) {  
		 
			  $res = "";
			  $ref_id = !empty($row->id)?$row->id:"";
			  $msisdn = !empty($row->msisdn_to)?$row->msisdn_to:"";
			  $text = !empty($row->message)?$row->message:"";
			  $user_id = !empty($row->user_id)?$row->user_id:"";		
			  $group_id = !empty($row->group_id)?$row->group_id:"";
			  $subgroup_id = !empty($row->subgroup_id)?$row->subgroup_id:"";
			  $unique_id = !empty($row->unique_id)?$row->unique_id:"";
			   $type = !empty($row->type)?$row->type:"";
			   	  $session_id = $xml->data;
				
				 
				 if($session_id)
				  {
					  $session_ids = '';
					$url = "$baseurl/sendsms.jsp?session_id=".urlencode(trim($session_id))."&to=".urlencode(trim($msisdn))."&text=".urlencode(trim($text))."&mask=".urlencode(trim($mask));
					  //$xmlsms = simplexml_load_file($url);
					    $ch = curl_init();
						curl_setopt($ch, CURLOPT_URL, $url);
						curl_setopt($ch, CURLOPT_HEADER, false);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
						$xmlsms = curl_exec($ch);
						curl_close($ch);
						$xmlsms = new SimpleXMLElement($xmlsms); 
					
						
					
					  if($xmlsms->response == 'OK')
						{
							$msgId = $xmlsms->data;
							
							$sqlQuery ="INSERT INTO sms_inbound (ref_id,msisdn_to,message,group_id,subgroup_id,user_id,unique_id,status,date_time,msgId,type) 
				values ('".mysql_real_escape_string($ref_id)."','".mysql_real_escape_string($msisdn)."','".mysql_real_escape_string($text)."','".mysql_real_escape_string($group_id)."','".mysql_real_escape_string($subgroup_id)."','".mysql_real_escape_string($user_id)."','".mysql_real_escape_string($unique_id)."',2,NOW(),'".mysql_real_escape_string($msgId)."','".mysql_real_escape_string($type)."')";
			
							$dbObj->MySQLQuery($sqlQuery);
							SMSLogging("SQL:".$sqlQuery);
							$dbObj->MySQLQuery("UPDATE sms_outbound set status=1 where  id='".$ref_id."' ");
							SMSLogging("UPDATE sms_outbound set status=1 where  id='".$ref_id."'");	
							
					   }
					  else
					  {
						$err = "";
						$err = explode(" ",$xmlsms->data);
						 $error = getResponce($err[1]); 
						SMSLogging("Error3->sendsms: ".$error."'");	
						
						
					  }
				  }
				 else
				  {
					  
					   $err = "";
						$err = explode(" ",$xml->data);
						$error = getResponce($err[1]); 
					
						SMSLogging("Error2->session: ".$error."'");	
						http://203.215.160.179:8083/corporate_sms2/api/ping.jsp?session_id=xxx 
						$url_ = "$baseurl/ping.jsp?session_id=".urlencode(trim($session_id));	
						$xml_ping = simplexml_load_file($url);
						if($xml_ping->response == 'OK')
					     {
							  $session_id = $xml_ping->data;
						 }
		   
						
						
						
						
				  }
			 
			  
		 } // foreach
		}// end if	*/
			 
			
			 
	   }
	  else
	   {
		     
			$err = "";
			$err = explode(" ",$xml->data);
			$error = getResponce($err[1]); 
				
			 SMSLogging("Error1-> auth: ".$error."'");	
			  
	   }
	
if($error)
 {
		$to  = 'mkhan@immap.org' ; 
				$subject = "PHF Safe and security";
				$message = "Dear $username,<br /><br />

							".$error."<br /><br />
							
							PHF Safe and security";
				
				
					
				$headers  = "MIME-Version: 1.0\r\n";
				$headers .= "From: PHF Safety and Security <noreply@paksafe.org>\r\n";
				//$headers .= 'Cc: syed.ali@pakhumanitarianforum.org' . "\r\n";
				$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
			
				mail($to, $subject, $message, $headers);
				
				return "error";
					 
 }
 else
 {
	return "ok";	 
 }
	
}

function getResponce($res)
{

	$rs = "";
	switch ($res) {
    case "200":
        $rs =  "Failed login. Username and password do not match.";
        break;
    case "201":
        $rs =  "Unknown MSISDN, Please Check Format i-e 92345xxxxxxx";
        break;
    case "100":
        $rs =  "To buy credit for the Corporate SMS solution, please follow the steps below:<br><br>
				To purchase Rs. 100 worth of credit, please send an SMS 'credit' to 80100.<br><br> 
				To purchase Rs. 500 worth of credit, please send an SMS 'credit' to 80500. <br><br>
				To purchase Rs. 1000 worth of credit, please send an SMS 'credit' to 81000.<br><br>";
        break;
	case "101":
        $rs =  "Field or input parameter missing";
        break;
	case "102":
        $rs =  "Invalid session ID or the session has expired. Login again.";
        break;
	case "103":
        $rs =  "Invalid Mask";
        break;
	case "211":
        $rs =  "Unknown Message ID.";
        break;
	case "300":
        $rs =  "Account has been blocked/suspended";
        break;
	case "400":
        $rs =  "Duplicate list name.";
        break;
	case "401":
        $rs =  "List name is missing.";
        break;
	case "411":
        $rs =  " Invalid MSISDN in the list.";
        break;
	case "412":
        $rs =  "List Id is missing.";
        break;
	case "413":
        $rs =  "No MSISDNs in the list.";
        break;
	case "414":
        $rs =  "List could not be updated. Unknown error.";
        break;
	case "415":
        $rs =  "Invalid List ID.";
        break;
	case "500":
        $rs =  "Duplicate campaign name.";
        break;
	case "501":
        $rs =  "Campaign name is missing.";
        break;
	case "502":
        $rs =  "SMS text is missing.";
        break;
	case "503":
        $rs =  "No list selected or one of the list IDs is invalid.";
        break;	
	case "504":
        $rs =  "Invalid schedule time for campaign.";
        break;	
	case "505":
        $rs =  "Invalid schedule time for campaign.";
        break;	
	case "506":
        $rs =  "Can not send message at the specified time. Please specify a different time.";
        break;	
	case "507":
        $rs =  "Campaign could not be saved. Unknown Error.";
        break;	
	case "600":
        $rs =  "Campaign ID is missing";
        break;	
		
		
	return $rs;
}
	




	if(!empty($row))
	 {
		$rs =$row["mobile"];
	 }
	
	return $rs;

}

function SMSLogging( $text )
{
	$log_file = "send_sms.log";
	 $text = "[".date('Y-m-j G:i:s') ."]". $text; 
	 error_log($text."\n", 3, $log_file);

}

?>