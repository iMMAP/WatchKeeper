<?php
	$user = "923455009308"; // package cell
	$password = "3186";
	$session_id = "";	
	$xml  = "";
	$to   = "03335649620";
	$cell = "923005148416";
	$text = "My Test janab";
	$mask = "PHFSecurity";
	//$baseurl ="http://api.clickatell.com";
	$baseurl ="http://203.215.160.179:8083/corporate_sms2/api";
			

	
	//$url = "$baseurl/http/auth?user=".urlencode(trim($user))."&password=".urlencode(trim($password))."&api_id=".urlencode(trim($api_id))."";	
 $url = "$baseurl/auth.jsp?msisdn=".urlencode(trim($user))."&password=".urlencode(trim($password));	

$xml = simplexml_load_file($url);
$xmlsms = "";

/*echo "<pre>";

print_r($xml);
die();
*///echo $xml->getName() . "<br />";


$error = "";
$msgId = "";

	  if($xml->response == 'OK')
	   {
		   
		    $session_id = $xml->data;
			 if($session_id)
			  {
				  
				echo   $url = "$baseurl/sendsms.jsp?session_id=".urlencode(trim($session_id))."&to=".urlencode(trim($cell))."&text=".urlencode(trim($text))."&mask=".urlencode(trim($mask));
				  $xmlsms = simplexml_load_file($url);
				  
				
				  if($xmlsms->response == 'OK')
				   	{
				   		$msgId = $xmlsms->data;
						
				   }
				  else
				  	$error = getResponce($xml->data); 
				  
			  }
			 
	   }
	  else
	   {
		     
			 echo $url = "$baseurl/sendsms.jsp?session_id=".urlencode(trim($session_id))."&to=".urlencode(trim($cell))."&text=".urlencode(trim($text))."&mask=".urlencode(trim($mask));	
			 echo getResponce($xml->data);
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
        $rs =  "Out of credit.";
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
}	
	
    ?>