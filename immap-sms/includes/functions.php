<?php
function check_user()
{
	if (!isset($_SESSION['session_name']) || $_SESSION['session_name'] == "")
	{
		header("location: login.php?msg=expire");
	}
}


function check_admin()
{
	if ( !isset($_SESSION['session_admin_id']) && !isset($_SESSION['session_member_id']))
	{
		header("location: index.php");
	}
}

// get counbtry full naem


function display($msg,$dis = true)
{
	if ($msg != "")
	{
		if($dis == true)
			echo "<div class='dis_msg'>".$msg."</div>";
		else
			echo "<div class='dis_error'>".$msg."</div>";
	}
}


//Gentate Alpha Numeric Capital Character
function gen_password($length = 17)
{
$password= "";
$chars = "ABCDEFGHJKLMNPQRSTUVWXYZ23456789";
for($i = 0; $i < $length; $i++)
{
$x = rand(0, strlen($chars) -1);
$password .= $chars{$x};
}
return $password;
}
function getProfileImage($id)
 { 
 	$obj = new DBConnect();
	$rs = "";
	$sql = "select profile_img,id from tbl_user where id = '".$id."'";
	$row = $obj->RunQuerySingle($sql);
	if(!empty($row))
	 {
		if(!empty($row["profile_img"]))
			$rs = FULL_PATH."profile_img/".$row["id"]."/sth_".$row["profile_img"];
		else
			$rs = FULL_PATH."images/default_profile_normal.png"; 
	 }
	
	return $rs;
		
}	



function getFieldWhere($field,$table,$where="")
 {
  		$obj = new DBConnect();
		$res = "";		
		 $sql = "select ".$field." from ".$table." ".$where;
		$row = $obj->RunQuerySingle($sql);
		if(!empty($row))
		{
		
			$res = $row[$field];		
		}
		
		return $res;	
	}		



function getField($field,$table,$id="")
 {
  		$obj = new DBConnect();
		$res = "";		
		 $sql = "select ".$field." from ".$table." where id = '".$id."'";
		
		$row = $obj->RunQuerySingle($sql);
		if(!empty($row))
		{
		
			$res = $row[$field];		
		}
		
		return $res;	
	}		

function getField2($field1,$field2,$table,$id="")
 {
  		$obj = new DBConnect();
		$res = "";		
		$sql = "select ".$field1.",".$field2." from ".$table." where id = '".$id."'";
		$row = $obj->RunQuerySingle($sql);
		
		if(!empty($row))
		{
		
			$res = $row[$field1]."?||?".$row[$field2];		
		}
		
		return $res;	
	}		

function getMessage($key)
	{
	    $obj = new DBConnect();
		$rs = "";
		$sql = "Select description from tbl_message where keyword = '".$key."'";
		$rows = $obj->RunQuery($sql);
		if(!empty($rows))
		{
			foreach($rows as $row)
			{
				$rs = $row['description']  ;
			}
		}
		return $rs;
	}	

function getSiteTitle()
	{
	    $obj = new DBConnect();
		$rs = "";
		$sql = "Select site_title from tbl_admin where id = '1'";
		$rows = $obj->RunQuery($sql);
		if(!empty($rows))
		{
			foreach($rows as $row)
			{
				$rs = $row['site_title']  ;
			}
		}
		return $rs;
	}


function getSiteIndexText()
	{
	    $obj = new DBConnect();
		$rs = "";
		$sql = "Select tag_text from tbl_admin where id = '1'";
		$rows = $obj->RunQuery($sql);
		if(!empty($rows))
		{
			foreach($rows as $row)
			{
				$rs = $row['tag_text']  ;
			}
		}
		return $rs;
	}




function getSiteDesc()
	{
	  $obj = new DBConnect();
		$rs = "";
		$sql = "Select metadesc from tbl_admin where id = '1'";
		$rows = $obj->RunQuery($sql);
		if(!empty($rows))
		{
			foreach($rows as $row)
			{
				$rs = $row['metadesc']  ;
			}
		}
		return $rs;
	}
	
   function getSiteKey()
	{
		$obj = new DBConnect();
		$rs = "";
		$sql = "Select metakey from tbl_admin where id = '1'";
		$rows = $obj->RunQuery($sql);
		if(!empty($rows))
		{
			foreach($rows as $row)
			{
				$rs = $row['metakey']  ;
			}
		}
		return $rs;
	}
//Get Admin Email	
function getAdminMail()
   {
		$obj = new DBConnect();
		$rs = "";
		$sql = "Select * from tbl_admin where id = '1'";
		$rows = $obj->RunQuery($sql);
		if(!empty($rows))
		{
			foreach($rows as $row)
			{
				$rs = $row['email'];
			}
		}
		return $rs;
	}
 function getForgetEmailText()
   {
		$obj = new DBConnect();
		$email = "";
		$sql = "Select * from tbl_admin where id = '1'";
		$rows = $obj->RunQuery($sql);
		if(!empty($rows))
		{
			foreach($rows as $row)
			{
				$email[] = $row['emailtext'];
				$email[] = $row['emailtxt_t'];
			}
		}
		return $email;
	}
	
 function getSignupEmailText()
   {
		$obj = new DBConnect();
		$email = "";
		$sql = "Select * from tbl_admin where id = '1'";
		$rows = $obj->RunQuery($sql);
		if(!empty($rows))
		{
			foreach($rows as $row)
			{
				$email[] = $row['signuptext'];
				$email[] = $row['signuptxt_t'];
			}
		}
		return $email;
	}
	
 function getSigntxtEmailText()
   {
		$obj = new DBConnect();
		$email = "";
		$sql = "Select * from tbl_admin where id = '1'";
		$rows = $obj->RunQuery($sql);
		if(!empty($rows))
		{
			foreach($rows as $row)
			{
				$email[] = $row['sign_txt'];
				$email[] = $row['signtxt_t'];
			}
		}
		return $email;
	}	
	
 

/****************************************************************************
		checking valid username
	*****************************************************************************/
	function chk_username($user= ""){
		$obj = new DBConnect();
		$ret = true;
		if($user != "" ){
			$sql = "select full_name from tbl_user where full_name = '".$user."'";
			$row = $obj->RunQuerySingle($sql);
			if(!empty($row)){
				$ret = false;
			}
		}
		return $ret;
	}
	
	
	
	/****************************************************************************
		checking valid email
	*****************************************************************************/
	function chk_emails($email= ""){
		$obj = new DBConnect();
		$ret = true;
		if($email != "" ){
			$sql = "select email from tbl_user where email = '".$email."'";
			$row = $obj->RunQuerySingle($sql);
			if(!empty($row)){
				$ret = false;
			}
		}
		return $ret;
	}
 
// cehcl user ack_id
	function account_chk($id= ""){
		$obj = new DBConnect();
		$ret = 0;
		if($id != "" ){
			$sql = "select id,act_chk from tbl_users where id = '".$id."'";
			$row = $obj->RunQuerySingle($sql);
			if(!empty($row)){
				$ret = $row["act_chk"];
			}
		}
		return $ret;
	}
 




/*
* Getting the time zone values
*/
function get_time_zone($class="", $id = "" , $index=1)
{
	$html = '
			<select id="time_zone" name="time_zone" class="'.$class.'"  tabindex="'.$index.'">
			<option value="">Select</option>
			<option value="UTC">(GMT+00:00) UTC</option>
			<option value="Dublin">(GMT+00:00) Dublin</option>
			<option value="London">(GMT+00:00) London</option>
			<option value="Sydney">(GMT+10:00) Sydney</option>
			<option value="Hawaii">(GMT-10:00) Hawaii</option>
			<option value="Alaska">(GMT-09:00) Alaska</option>
			
			<option value="Pacific Time (US &amp; Canada)">(GMT-08:00) Pacific Time (US &amp; Canada)</option>
			<option value="Arizona">(GMT-07:00) Arizona</option>
			<option value="Mountain Time (US &amp; Canada)">(GMT-07:00) Mountain Time (US &amp; Canada)</option>
			<option value="Central Time (US &amp; Canada)">(GMT-06:00) Central Time (US &amp; Canada)</option>
			<option value="Eastern Time (US &amp; Canada)">(GMT-05:00) Eastern Time (US &amp; Canada)</option>
			
			<option value="Indiana (East)">(GMT-05:00) Indiana (East)</option>
			
			<option value="International Date Line West">(GMT-11:00) International Date Line West</option>
			<option value="Midway Island">(GMT-11:00) Midway Island</option>
			<option value="Samoa">(GMT-11:00) Samoa</option>
			<option value="Tijuana">(GMT-08:00) Tijuana</option>
			<option value="Chihuahua">(GMT-07:00) Chihuahua</option>
			<option value="Mazatlan">(GMT-07:00) Mazatlan</option>
			<option value="Central America">(GMT-06:00) Central America</option>
			
			<option value="Guadalajara">(GMT-06:00) Guadalajara</option>
			<option value="Mexico City">(GMT-06:00) Mexico City</option>
			<option value="Monterrey">(GMT-06:00) Monterrey</option>
			<option value="Saskatchewan">(GMT-06:00) Saskatchewan</option>
			<option value="Bogota">(GMT-05:00) Bogota</option>
			<option value="Lima">(GMT-05:00) Lima</option>
			<option value="Quito">(GMT-05:00) Quito</option>
			<option value="Atlantic Time (Canada)">(GMT-04:00) Atlantic Time (Canada)</option>
			<option value="Caracas">(GMT-04:00) Caracas</option>
			
			<option value="La Paz">(GMT-04:00) La Paz</option>
			<option value="Santiago">(GMT-04:00) Santiago</option>
			<option value="Newfoundland">(GMT-03:30) Newfoundland</option>
			<option value="Brasilia">(GMT-03:00) Brasilia</option>
			<option value="Buenos Aires">(GMT-03:00) Buenos Aires</option>
			<option value="Georgetown">(GMT-03:00) Georgetown</option>
			<option value="Greenland">(GMT-03:00) Greenland</option>
			<option value="Mid-Atlantic">(GMT-02:00) Mid-Atlantic</option>
			<option value="Azores">(GMT-01:00) Azores</option>
			
			<option value="Cape Verde Is.">(GMT-01:00) Cape Verde Is.</option>
			<option value="Casablanca">(GMT+00:00) Casablanca</option>
			<option value="Edinburgh">(GMT+00:00) Edinburgh</option>
			<option value="Lisbon">(GMT+00:00) Lisbon</option>
			<option value="Monrovia">(GMT+00:00) Monrovia</option>
			<option value="Amsterdam">(GMT+01:00) Amsterdam</option>
			<option value="Belgrade">(GMT+01:00) Belgrade</option>
			<option value="Berlin">(GMT+01:00) Berlin</option>
			<option value="Bern">(GMT+01:00) Bern</option>
			
			<option value="Bratislava">(GMT+01:00) Bratislava</option>
			<option value="Brussels">(GMT+01:00) Brussels</option>
			<option value="Budapest">(GMT+01:00) Budapest</option>
			<option value="Copenhagen">(GMT+01:00) Copenhagen</option>
			<option value="Ljubljana">(GMT+01:00) Ljubljana</option>
			<option value="Madrid">(GMT+01:00) Madrid</option>
			<option value="Paris">(GMT+01:00) Paris</option>
			<option value="Prague">(GMT+01:00) Prague</option>
			<option value="Rome">(GMT+01:00) Rome</option>
			
			<option value="Sarajevo">(GMT+01:00) Sarajevo</option>
			<option value="Skopje">(GMT+01:00) Skopje</option>
			<option value="Stockholm">(GMT+01:00) Stockholm</option>
			<option value="Vienna">(GMT+01:00) Vienna</option>
			<option value="Warsaw">(GMT+01:00) Warsaw</option>
			<option value="West Central Africa">(GMT+01:00) West Central Africa</option>
			<option value="Zagreb">(GMT+01:00) Zagreb</option>
			<option value="Athens">(GMT+02:00) Athens</option>
			<option value="Bucharest">(GMT+02:00) Bucharest</option>
			
			<option value="Cairo">(GMT+02:00) Cairo</option>
			<option value="Harare">(GMT+02:00) Harare</option>
			<option value="Helsinki">(GMT+02:00) Helsinki</option>
			<option value="Istanbul">(GMT+02:00) Istanbul</option>
			<option value="Jerusalem">(GMT+02:00) Jerusalem</option>
			<option value="Kyev">(GMT+02:00) Kyev</option>
			<option value="Minsk">(GMT+02:00) Minsk</option>
			<option value="Pretoria">(GMT+02:00) Pretoria</option>
			<option value="Riga">(GMT+02:00) Riga</option>
			
			<option value="Sofia">(GMT+02:00) Sofia</option>
			<option value="Tallinn">(GMT+02:00) Tallinn</option>
			<option value="Vilnius">(GMT+02:00) Vilnius</option>
			<option value="Baghdad">(GMT+03:00) Baghdad</option>
			<option value="Kuwait">(GMT+03:00) Kuwait</option>
			<option value="Moscow">(GMT+03:00) Moscow</option>
			<option value="Nairobi">(GMT+03:00) Nairobi</option>
			<option value="Riyadh">(GMT+03:00) Riyadh</option>
			<option value="St. Petersburg">(GMT+03:00) St. Petersburg</option>
			
			<option value="Volgograd">(GMT+03:00) Volgograd</option>
			<option value="Tehran">(GMT+03:30) Tehran</option>
			<option value="Abu Dhabi">(GMT+04:00) Abu Dhabi</option>
			<option value="Baku">(GMT+04:00) Baku</option>
			<option value="Muscat">(GMT+04:00) Muscat</option>
			<option value="Tbilisi">(GMT+04:00) Tbilisi</option>
			<option value="Yerevan">(GMT+04:00) Yerevan</option>
			<option value="Kabul">(GMT+04:30) Kabul</option>
			<option value="Ekaterinburg">(GMT+05:00) Ekaterinburg</option>
			
			<option value="Islamabad">(GMT+05:00) Islamabad</option>
			<option value="Karachi">(GMT+05:00) Karachi</option>
			<option value="Tashkent">(GMT+05:00) Tashkent</option>
			<option value="Chennai">(GMT+05:30) Chennai</option>
			<option value="Kolkata">(GMT+05:30) Kolkata</option>
			<option value="Mumbai">(GMT+05:30) Mumbai</option>
			<option value="New Delhi">(GMT+05:30) New Delhi</option>
			<option value="Kathmandu">(GMT+05:45) Kathmandu</option>
			<option value="Almaty">(GMT+06:00) Almaty</option>
			
			<option value="Astana">(GMT+06:00) Astana</option>
			<option value="Dhaka">(GMT+06:00) Dhaka</option>
			<option value="Novosibirsk">(GMT+06:00) Novosibirsk</option>
			<option value="Sri Jayawardenepura">(GMT+06:00) Sri Jayawardenepura</option>
			<option value="Rangoon">(GMT+06:30) Rangoon</option>
			<option value="Bangkok">(GMT+07:00) Bangkok</option>
			<option value="Hanoi">(GMT+07:00) Hanoi</option>
			<option value="Jakarta">(GMT+07:00) Jakarta</option>
			<option value="Krasnoyarsk">(GMT+07:00) Krasnoyarsk</option>
			
			<option value="Beijing">(GMT+08:00) Beijing</option>
			<option value="Chongqing">(GMT+08:00) Chongqing</option>
			<option value="Hong Kong">(GMT+08:00) Hong Kong</option>
			<option value="Irkutsk">(GMT+08:00) Irkutsk</option>
			<option value="Kuala Lumpur">(GMT+08:00) Kuala Lumpur</option>
			<option value="Perth">(GMT+08:00) Perth</option>
			<option value="Singapore">(GMT+08:00) Singapore</option>
			<option value="Taipei">(GMT+08:00) Taipei</option>
			<option value="Ulaan Bataar">(GMT+08:00) Ulaan Bataar</option>
			
			<option value="Urumqi">(GMT+08:00) Urumqi</option>
			<option value="Osaka">(GMT+09:00) Osaka</option>
			<option value="Sapporo">(GMT+09:00) Sapporo</option>
			<option value="Seoul">(GMT+09:00) Seoul</option>
			<option value="Tokyo">(GMT+09:00) Tokyo</option>
			<option value="Yakutsk">(GMT+09:00) Yakutsk</option>
			<option value="Adelaide">(GMT+09:30) Adelaide</option>
			<option value="Darwin">(GMT+09:30) Darwin</option>
			<option value="Brisbane">(GMT+10:00) Brisbane</option>
			
			<option value="Canberra">(GMT+10:00) Canberra</option>
			<option value="Guam">(GMT+10:00) Guam</option>
			<option value="Hobart">(GMT+10:00) Hobart</option>
			<option value="Melbourne">(GMT+10:00) Melbourne</option>
			<option value="Port Moresby">(GMT+10:00) Port Moresby</option>
			<option value="Vladivostok">(GMT+10:00) Vladivostok</option>
			<option value="Magadan">(GMT+11:00) Magadan</option>
			<option value="New Caledonia">(GMT+11:00) New Caledonia</option>
			<option value="Solomon Is.">(GMT+11:00) Solomon Is.</option>
			
			<option value="Auckland">(GMT+12:00) Auckland</option>
			<option value="Fiji">(GMT+12:00) Fiji</option>
			<option value="Kamchatka">(GMT+12:00) Kamchatka</option>
			<option value="Marshall Is.">(GMT+12:00) Marshall Is.</option>
			<option value="Wellington">(GMT+12:00) Wellington</option>
			<option value="Nuku\'alofa">(GMT+13:00) Nuku\'alofa</option></select>
		';
	return $html;
}	
	
	




/*
* Getting the time Combo
*/
function make_combine_array($req)
{
	
	$i=1;
	$arr = array();
	foreach($req as $k=>$r)
	{
		$v = explode("-",$k);
		$val = array_pop($v);
		krsort($v);
		$name = array_pop($v);
		
		if($val != $i)
		{
			$i++;
		}
		
		if($val == $i)
		{
			$arr[$i][$name] = $r;
		}
		
	}
	return $arr;
}





/*
* Getting the time Combo
*/
function get_lang_array($file = 'eng')
{
	if(empty($file))
		$file = 'eng';
		
	$f = "languages/".$file."/global.lng";
	$lanArray = array();
	if(is_file($f))
	{
		$handle = fopen($f, "r");
		// removing first 2  lines
		$buffer = fgets($handle);
		$buffer = fgets($handle);

		while (!feof($handle)) {
			$buffer = fgets($handle);
			$buffer = trim($buffer);
			if(!empty($buffer))
			{
				$a = explode("=",$buffer);
				$lanArray += array($a[0] => $a[1]);
			}
		}
		fclose($handle);
	}
	return $lanArray;	
}



function change_css()
{
	$chk_name = check_lang_name();
	$ret = "";
	if($chk_name == 'eng')
	{
		$ret = '<style>
					div#horiz-menu a {
						padding: 0 19px;
					}
				</style>';
	}
	else
	{
		$ret = '<style>
					div#horiz-menu a {
						padding: 0 8px;
					}
				</style>';
	}
	echo $ret;
}







/*
* This the function which returns the name of the brower
*/
function _browser($a_browser = false, $a_version = false, $name = false)
{
    $browser_list = 'msie firefox konqueror safari netscape navigator opera mosaic lynx amaya omniweb chrome avant camino flock seamonkey aol mozilla gecko';
    $user_browser = strtolower($_SERVER['HTTP_USER_AGENT']);
    $this_version = $this_browser = '';
   
    $browser_limit = strlen($user_browser);
    foreach (w($browser_list) as $row)
    {
        $row = ($a_browser !== false) ? $a_browser : $row;
        $n = stristr($user_browser, $row);
        if (!$n || !empty($this_browser)) continue;
       
        $this_browser = $row;
        $j = strpos($user_browser, $row) + strlen($row) + 1;
        for (; $j <= $browser_limit; $j++)
        {
            $s = trim(substr($user_browser, $j, 1));
            $this_version .= $s;
           
            if ($s === '') break;
        }
    }
   
    if ($a_browser !== false)
    {
        $ret = false;
        if (strtolower($a_browser) == $this_browser)
        {
            $ret = true;
           
            if ($a_version !== false && !empty($this_version))
            {
                $a_sign = explode(' ', $a_version);
                if (version_compare($this_version, $a_sign[1], $a_sign[0]) === false)
                {
                    $ret = false;
                }
            }
        }
       
        return $ret;
    }
   
    //
    $this_platform = '';
    if (strpos($user_browser, 'linux'))
    {
        $this_platform = 'linux';
    }
    elseif (strpos($user_browser, 'macintosh') || strpos($user_browser, 'mac platform x'))
    {
        $this_platform = 'mac';
    }
    else if (strpos($user_browser, 'windows') || strpos($user_browser, 'win32'))
    {
        $this_platform = 'windows';
    }
   
    if ($name !== false)
    {
        return $this_browser . ' ' . $this_version;
    }
   
    return array(
        "browser"      => $this_browser,
        "version"      => $this_version,
        "platform"     => $this_platform,
        "useragent"    => $user_browser
    );
}
function w($a = '')
{
    if (empty($a)) return array();
   
    return explode(' ', $a);
}
function get_top_css()
{
	$browser = _browser();
	
	$css="";
	if($browser['browser'] == 'msie' and $browser['version'] <= 6)
	{
		$css = '<!--[if lt IE 6]><link rel="stylesheet" href="'.FULL_PATH.'css/main_ie.css" type="text/css" />
				<link rel="stylesheet" href="'.FULL_PATH.'css/style_ie.css" type="text/css" /><![endif]-->';
	}
	else
	{
		$css = '<!--[if !IE]>-->
				<link rel="stylesheet" href="'.FULL_PATH.'css/main.css" type="text/css" />
				<link rel="stylesheet" href="'.FULL_PATH.'css/style.css" type="text/css" /><!--<![endif]-->
				<!--[if gte IE 6]><link rel="stylesheet" href="'.FULL_PATH.'css/main_ie7.css" type="text/css" /><link rel="stylesheet" href="'.FULL_PATH.'css/style_ie7.css" type="text/css" /><![endif]-->';
		
	}
	return $css;
}

function getMsgTxt($msg, $table="")
 {
	$msgtxt = "";
	if($msg == '1')
	 $msgtxt = ucfirst($table)." has been added succresfully";
	elseif($msg == '2')
	 $msgtxt = ucfirst($table)." has been updated succresfully";
	elseif($msg == '3')
	 $msgtxt = ucfirst($table)." has been deleted succresfully";
	elseif($msg == '5')
	 $msgtxt = ucfirst($table)." has been activated succresfully";
	elseif($msg == '4')
	 $msgtxt = ucfirst($table)." has been deactivated succresfully";
	elseif($msg == '6')
	 $msgtxt = "Record does not exist";
	elseif($msg == '7')
	 $msgtxt = "Error while adding ".ucfirst($table);
	elseif($msg == '8')
	 $msgtxt = "Member(s) has been assigned to the group";
	elseif($msg == '9')
	 $msgtxt = "Details not available";
	elseif($msg == '10')
	 $msgtxt = "Error while sending sms, Email has been sent to the administrator";
	
	else
	 $msgtxt = "Invalid parameter";
	return $msgtxt; 
 }

  
		//Get Site Title
		function getConDD($id="")
		 {
			 $obj = new DBConnect();
			$rs = "";
			$row = "";
			$sql = "";
			$rows = array();
			$sql = "select * from ".TBLCON." order by country asc";
			
		
			$rows = $obj->RunQuery($sql);
			
			if(!empty($rows))
			 {
				$rs .= '<select name="country" id="country" class="sign_inp">
                         <option value="">Select Country</option>';
			 foreach($rows as $row)
			  {
				if($id == $row["id"])
				 	$rs .= '<option value="'.$row["id"].'" selected="selected">'.$row["country"].'</option>';
			    else
				 	$rs .= '<option value="'.$row["id"].'" >'.$row["country"].'</option>';
					  
			  }
			  	$rs .= '</select>';
			 }
		
			 
			return $rs;
	     } 
 

 
		
		function getOrgDD($id="",$fun="")
		 {
			 $obj = new DBConnect();
			$rs = "";
			$row = "";
			$sql = "";
			$rows = array();
			$sql = "select * from ".TBLORG." order by organization asc";
			
		
			$rows = $obj->RunQuery($sql);
			
			if(!empty($rows))
			 {
				if(!empty($fun))
				$rs .= '<select name="organization" id="organization" class="sign_inp" onchange="'.$fun.'">';
                else
				$rs .= '<select name="organization" id="organization" class="sign_inp" >';
				$rs .= '<option value="">Select Organization</option>';
			 foreach($rows as $row)
			  {
				if($id == $row["id"])
				 	$rs .= '<option value="'.$row["id"].'" selected="selected">'.$row["organization"].'</option>';
			    else
				 	$rs .= '<option value="'.$row["id"].'" >'.$row["organization"].'</option>';
					  
			  }
			  	$rs .= '</select>';
			 }
		
			 
			return $rs;
	     } 
		 
 	function getDD($name,$table,$event,$select_name,$where,$id="")
		 {
			 $obj = new DBConnect();
			$rs = "";
			$row = "";
			$sql = "";
			$rows = array();
			 $sql = "select * from ".$table." ".$where;
			
			$rows = $obj->RunQueryObj($sql);
			
			if(!empty($rows))
			 {
				$rs .= '<select name="'.$name.'" id="'.$name.'" '.$event.'>
                         <option value="">Select '.ucfirst($name).'</option>';
			 foreach($rows as $row)
			  {
				if($id == $row->id)
				 	$rs .= '<option value="'.$row->id.'" selected="selected">'.$row->$select_name.'</option>';
			    else
				 	$rs .= '<option value="'.$row->id.'" >'.$row->$select_name.'</option>';
					  
			  }
			  	$rs .= '</select>';
			 }
		
			 
			return $rs;
	     }	
		 
 function getGroupChDD()
		 {
			 $obj = new DBConnect();
			$rs = "";
			$row = "";
			$sql = "";
			$rows = array();
			$sql = "select * from ".TBLGROUP." where status != 3 order by group_name asc";
			
		    
			$rows = $obj->RunQuery($sql);
			
			if(!empty($rows))
			 {
				$rs .= '<select name="group" id="group" class="sign_inp" onchange="chk_SubGroup()">
                         <option value="">Select Group</option>';
			 foreach($rows as $row)
			  {
				
				 	$rs .= '<option value="'.$row["id"].'" >'.$row["group_name"].'</option>';
					  
			  }
			  	$rs .= '</select>';
			 }
		
			 
			return $rs;
	     } 
		 
 	function getGroupDD($id="")
		 {
			 $obj = new DBConnect();
			$rs = "";
			$row = "";
			$sql = "";
			$rows = array();
			$sql = "select * from ".TBLGROUP." where status !=3 order by group_name asc";
			
		    
			$rows = $obj->RunQuery($sql);
			
			if(!empty($rows))
			 {
				$rs .= '<select name="group" id="group" class="sign_inp">
                         <option value="">Select Group</option>';
			 foreach($rows as $row)
			  {
				if($id == $row["id"])
				 	$rs .= '<option value="'.$row["id"].'" selected="selected">'.$row["group_name"].'</option>';
			    else
				 	$rs .= '<option value="'.$row["id"].'" >'.$row["group_name"].'</option>';
					  
			  }
			  	$rs .= '</select>';
			 }
		
			 
			return $rs;
	     } 
		 
  	function getSubGroupDD($id="")
		 {
			 $obj = new DBConnect();
			$rs = "";
			$row = "";
			$sql = "";
			$rows = array();
			$sql = "select * from ".TBLSUBGROUP." where status !=3 order by subgroup asc";
			
		
			$rows = $obj->RunQuery($sql);
			
			if(!empty($rows))
			 {
				$rs .= '<select name="subgroup" id="subgroup" class="sign_inp">
                         <option value="">Select SubGroup</option>';
			 foreach($rows as $row)
			  {
				if($id == $row["id"])
				 	$rs .= '<option value="'.$row["id"].'" selected="selected">'.$row["subgroup"].'</option>';
			    else
				 	$rs .= '<option value="'.$row["id"].'" >'.$row["subgroup"].'</option>';
					  
			  }
			  	$rs .= '</select>';
			 }
		
			 
			return $rs;
	     } 
////////////////////////////




////////	
?>