<?php
define('MAIN',realpath('../'));
include MAIN.'/includes/config.php';
include MAIN.'/includes/class.main.php';
$dbObj = new Main();


 
		$email = $_GET["email"];
		
		$sql="select * from tbl_users where email = '".$email."'";
		
		$emailtexts = getForgetEmailText();
		
		$subject = $emailtexts[0];
		
		$emailtext = $emailtexts[1];
		
		$val = $dbObj->RunQuerySingle($sql);
		//$adminemail = getAdminMail();
		$adminemail = 'abuse@pamtext.com';
		if(!empty($val))
		 {
		  $pass=$val["password"];
		  $username=$val["username"];
		  $emailtext = str_replace("%username",$username, $emailtext);
		  $emailtext = str_replace("%email",$email, $emailtext);
		  $emailtext = str_replace("%password",$pass, $emailtext);
		
		  $to  = $email ; 
		  
		 	$message = $emailtext;
			 $headers  = "MIME-Version: 1.0\r\n";
			 $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
			 $headers .= "From: PamText \r\n";
			 //$to." ".$subject." ".$message." ".$headers;
			//mail($to, $subject, $message, $headers);
			//mail($to, $subject, $message, $headers)
			 if(1) 
			  echo 1;
			 else
			  echo "Email Not Send Successfully!";	
			}
			else
				echo "Email Does Not Exist in our Database !";	
		 
?>