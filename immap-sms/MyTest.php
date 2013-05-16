<?php
$to  = 'mkhan@immap.org' ; 
				$subject = "PHF Safe and security";
				$message = "Dear ,<br /><br />

							<br /><br />
							
							PHF Safe and security";
				
				
					
				$headers  = "MIME-Version: 1.0\r\n";
				$headers .= "From: PHF Safety and Security <noreply@paksafe.org>\r\n";
				//$headers .= 'Cc: syed.ali@pakhumanitarianforum.org' . "\r\n";
				$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
			
				if(mail($to, $subject, $message, $headers))
				{
				echo "mail Sent";	
				}				
				else {
				echo "Error while sending email";	
				}
?>