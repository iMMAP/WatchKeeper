<?php
function SMSLogging( $text )
{
	$log_file = "delivery.log";
	 $text = "[".date('Y-m-j G:i:s') ."]". $text; 
	 error_log($text."\n", 3, $log_file);

}

foreach($_REQUEST as $key => $val)
{
	SMSLogging("ALL  Parameters.$key ==>".$val);
}

?>