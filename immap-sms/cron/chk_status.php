<?php
define('MAIN',realpath('../'));
include MAIN.'/includes/config.php';
include MAIN.'/includes/class.admin.php';
$admin = new Admin();
	
	$user = "923452003139"; // package cell
	$password = "7277";
	$baseurl ="http://203.215.160.179:8083/corporate_sms2/api";
	$xmlstatus = "";
	$error = "";
	$msgId = "";
	$xml = "";
	
	$sql = "select id,msgId from sms_inbound where status = 2";
	$rows = $admin->RunQueryObj($sql);
	
	if(!empty($rows))
	 {
		 
		$url = "$baseurl/auth.jsp?msisdn=".urlencode(trim($user))."&password=".urlencode(trim($password));	
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$xml = curl_exec($ch);
		curl_close($ch);
	
		$xml = new SimpleXMLElement($xml); 
		
		//$xml = simplexml_load_file($url);
		if($xml->response == 'OK')
		 {
		 	 $session_id = $xml->data;
			
			 if($session_id)
			  {
			  	
				 foreach($rows as $row)
				  {
				  	    $msgId = $row->msgid;			 
					   $url = "$baseurl/querymsg.jsp?session_id=".urlencode(trim($session_id))."&msg_id=".$msgId;
					  
					   $ch = curl_init();
						curl_setopt($ch, CURLOPT_URL, $url);
						curl_setopt($ch, CURLOPT_HEADER, false);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
						$xmlstatus = curl_exec($ch);
						curl_close($ch);
					
						$xmlstatus = new SimpleXMLElement($xmlstatus); 
					
					  //$xmlstatus = simplexml_load_file($url);
					  if($xmlstatus->response == 'OK')
						{
						  $status = $xmlstatus->data->recipient->status;
						  if(!empty($status))
						   {
							 $admin->MySQLQuery("UPDATE sms_inbound set status = ".$status." where  id='".$row->id."' ");
						   }
						}
					  
				   }
		  		} 
	     }
	 }
	 
?>