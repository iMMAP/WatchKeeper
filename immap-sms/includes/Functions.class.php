<?php

class Functions extends  DBConnect
{
	function check_user(){
		if(!isset($_SESSION["session_userid"]) || $_SESSION["session_userid"] == "" )
			header("Location: ".FULL_PATH);
	}
	
	function check_admin(){
		if(!isset($_SESSION["session_admin_id"])  || $_SESSION["session_admin_id"] == "" )
			header("Location: ".FULL_PATH."admincontrol");
	}
	
	
	
	
	function get_user_posts($user_id =""){
		$res = "";
		if($user_id!= ""){
			$sql = "Select count(id) as cnt from tbl_ticked where user_id = '".$user_id."' and status = '1'";
			$rs = $this->RunQuerySingle($sql);
			if(!empty($rs)){
				$res = $rs['cnt'];
			}
		}
		return $res;
	}
	
	
	
	
	
	
	/****************************************************************************
		checking valid username
	*****************************************************************************/
	function chk_username($user= ""){
		
		$ret = true;
		if($user != "" ){
			$sql = "select username from tbl_user where username = '".$user."'";
			$row = $this->RunQuerySingle($sql);
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
		
		$ret = true;
		if($email != "" ){
			$sql = "select username from tbl_user where email = '".$email."'";
			$row = $this->RunQuerySingle($sql);
			if(!empty($row)){
				$ret = false;
			}
		}
		return $ret;
	}
	
	
	/****************************************************************************
		getting the selective fields from id
	*****************************************************************************/
	function get_from_id($user_id = "", $table = "", $arr = array()){
		
		$ret = array();
		if($user_id != "" and !empty($arr) and $table != ""){
			$fields = implode(", ", $arr);
			
			$sql = "Select ".$fields." from ".$table." where id = '".$user_id."'";
			
			$row = $this->RunQuerySingle($sql);
			if(!empty($row)){
				$ret = $row;
			}
		}
		return $ret;
	}
	
	
	
	
	/****************************************************************************
		getting the selective fields from id
	*****************************************************************************/
	function get_custom_sql($table = "", $where = "", $arr = array()){
		
		$ret = array();
		if($where != "" and !empty($arr) and $table != ""){
			$fields = implode(", ", $arr);
			
			$sql = "Select ".$fields." from ".$table." where ".$where."";
			
			$row = $this->RunQuerySingle($sql);
			if(!empty($row)){
				$ret = $row;
			}
		}
		return $ret;
	}
	
	
	
	
	
	/****************************************************************************
		sending tracker email 
	*****************************************************************************/
	function send_track_mail($usr_id="" ,$tracking_id=""){
		
		if($usr_id != "" and $tracking_id != ""){
			
			$usr = $this->get_info_from_id($usr_id);
			$tracking = $this->get_info_from_id($tracking_id);
			
			/* recipients */
			$to  = $tracking['email']; 
			
			/* subject */
			$subject = $usr['full_name']." is now Following You on Ticked.Me";
			
			/* message */
			$message = '
			<html>
			<head>
			<title>'.$usr['full_name'].' is now Following You on Ticked.Me </title>
			</head>
			<body>
			Hi, '.$tracking['full_name'].'
			
			<p>
				<a href="'.FULL_PATH.'users'.$usr_id.'" >
				<strong>'.$usr['full_name'].' </strong> </a>
				is now Following You on Ticked.Me 
			</p>
			</body>
			</html>
			';
			
			
			
			/* To send HTML mail, you can set the Content-type header. */
			$headers  = "MIME-Version: 1.0\r\n";
			$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
			
			/* additional headers */
			$headers .= "To: ".$tracking['full_name']." <".$to.">\r\n";
			$headers .= "From: Ticked <admin@Ticked.com>\r\n";
			
			/* and now mail it */
			//mail($to, $subject, $message, $headers);
		}
	}
	
	
	
	
	
	//Gentate Alpha Numeric Capital Character
	function getSignupEmailText()
	 {
			$email = "";
			$sql = "Select * from tbl_admin where id = '1'";
			$rows = $this->RunQuery($sql);
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
	 
	//Get Admin Email	
	function getAdminMail()
	{
		$email = "";
		$sql = "Select * from tbl_admin where id = '1'";
		$rows = $this->RunQuery($sql);
		if(!empty($rows))
		{
			foreach($rows as $row)
			{
				$email = $row['email'];
			}
		}
		return $email;
	}
		
	function getForgetEmailText()
	{
		$email = "";
		$sql = "Select * from tbl_admin where id = '1'";
		$rows = $this->RunQuery($sql);
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

	function getContent($id)
	{
		$content = "";
		$sql = "Select content from tbl_content where id = '$id'";
		$rows = $this->RunQuery($sql);
		if(!empty($rows))
		{
			foreach($rows as $row)
			{
				
				$content = $row['content'];
			}
		}
		return $content;
	}
	
	// getting the values form the url
	function get_url($val = 0){
		$ret = array();
			
		/*** get the route from the url ***/
		//$route = (empty($_GET['rt'])) ? '' : $_GET['rt'];
		$route = strstr($_SERVER['QUERY_STRING'],'=');
		$route = substr($route,1,strlen($route));
		
			if(isset($route)){
				$arr = explode('/',$route);
				$len = sizeof($arr);
				//echo $val;
				
				for($i=$val; $i<$len; $i++){
					$ret[] = $arr[$i];
					//echo $i.'<br />';
				}// for
			}// if $_GET
		
		return $ret;
	}// end get_url


	
	
	// Date function
	function date_diff($dbDate){   //$d is create date
		
		//echo $dbDate."<br>";
		
		$date = date(' g:i A, M jS', strtotime($dbDate));
		
		// Work out the Date plus 8 hours
		// get the current timestamp into an array
		// set the default timezone to use. Available since PHP 5.1
/*		$date_time_array = getdate();
		$hours = $date_time_array['hours']-12;
		$minutes = $date_time_array['minutes'];
		$seconds = $date_time_array['seconds'];
		$month = $date_time_array['mon'];
		$day = $date_time_array['mday'];
		$year = $date_time_array['year'];
		
		// use mktime to recreate the unix timestamp
		// adding 19 hours to $hours
		$timestamp = mktime($hours + 0,$minutes,$seconds,$month,$day,$year);
		$d1 = strftime('%Y-%m-%d %H:%M:%S',$timestamp);	
		$d1 = (is_string($d1) ? strtotime($d1) : $d1);*/
		$d1 = strtotime("now");
		$d2 = strtotime($dbDate);
		// echo(strtotime("now") . "<br />");
		// echo "($d1 - $d2)<br>";
		$diff_secs = abs($d1 - $d2);
		$base_year = min(date("Y", $d1), date("Y", $d2));
	
		$diff = mktime(0, 0, $diff_secs, 1, 1, $base_year);
		$diffArray = array(
			"years" => date("Y", $diff) - $base_year,
			"months_total" => (date("Y", $diff) - $base_year) * 12 + date("n", $diff) - 1,
			"months" => date("n", $diff) - 1,
			"days_total" => floor($diff_secs / (3600 * 24)),
			"days" => date("j", $diff) - 1,
			"hours_total" => floor($diff_secs / 3600),
			"hours" => date("G", $diff),
			"minutes_total" => floor($diff_secs / 60),
			"minutes" => (int) date("i", $diff),
			"seconds_total" => $diff_secs,
			"seconds" => (int) date("s", $diff)
		);
		if($diffArray['days'] > 0){
			if($diffArray['days'] == 1){
				$days = '1 day';
			}else{
				$days = $diffArray['days'] . ' days';
			}
			return $date;//$days . ' and ' . $diffArray['hours'] . ' hours ago';
		}else if($diffArray['hours'] > 0){
			if($diffArray['hours'] == 1){
				$hours = '1 hour';
			}else{
				$hours = $diffArray['hours'] . ' hours';
			}
			return $hours . ' and ' . $diffArray['minutes'] . ' minutes ago';
		}else if($diffArray['minutes'] > 0){
			if($diffArray['minutes'] == 1){
				$minutes = '1 minute';
			}else{
				$minutes = $diffArray['minutes'] . ' minutes';
			}
			return $minutes . ' and ' . $diffArray['seconds'] . ' seconds ago';
		}else{
			return 'Less than a minute ago';
		}
	}

	
	
	/****************************************************************************
		param
			id 			=> for the div unique id and delete
			suser_id 	=> for the user information
			user_txt	=> putting the user text in
			diff		=> Show the difference
			$display	=> for trashcan to show or not
	*****************************************************************************/
	function get_update_div($id = 0,$suser_id = 0,$usr_txt = "", $diff = "",$display = "block"){
		$msg = "";
		if($usr_txt != "" and $diff != "" and $id != 0 and $suser_id != 0){
			$img = '<img src="'.FULL_PATH.'public/images/default_profile_normal.png" border="0" />';
			$trash = '<img src="'.FULL_PATH.'public/images/icon_trash.gif" border="0" />';
			$loder = '<img src="'.FULL_PATH.'public/images/loader.gif" border="0" />';
			$reply = '<img src="'.FULL_PATH.'public/images/icon_reply.gif" border="0" />';
			
			
			$sql = "Select * from tbl_user where id = '".$suser_id."'";
			$rs = $this->RunQuerySingle($sql);
			if(!empty($rs)){
				$imgs = $rs['profile_img'];
				$user_name = $rs['username'];
				if($imgs != "")
				$img = '<img src="'.FULL_PATH.'public/profile_img/th_'.$imgs.'" border="0" />';
			}
			
			$link = FULL_PATH.$user_name;
			
			if(substr($usr_txt,0,1)=='@')
			{
				$space_pos = strpos($usr_txt,' ');
				$user_n  = substr($usr_txt,0,$space_pos);
				$user_nick  = urlencode(substr($usr_txt,1,$space_pos));
				$rest_msg = substr($usr_txt,$space_pos, strlen($usr_txt));
				$usr_n = '<a href="'.FULL_PATH.$user_nick.'">'.$user_n.'</a>';
				$usr_txts = $usr_n.$rest_msg;
			}
			else
				$usr_txts = $usr_txt;
			$msg = '<div class="user_div" onmouseout="div_clr(this)" onmouseover="div_color(this)" style="display:'.$display.'" id="div_'.$id.'">
						<div class="dash_div"></div>
						
						<div class="user_div_left">
							<div class="profile_image">'.$img.'</div>
							<div class="user_sts">
							<span class="sts_name"><a href="'.$link.'" id="name_'.$id.'">'.$user_name.'</a></span>: 
							'.$usr_txts.'<br>
								<span class="time_txt">'.$diff.'</span>
							</div>
						</div>
						
						<div class="user_div_right">';
						
						
					if(isset($_SESSION["session_userid"]) && $_SESSION["session_userid"] == $suser_id){
						$msg .= '<div class="loader">'.$loder.'</div>
								<div class="trash_can">
									<a class="href_a" onclick="del_update(\''.$id.'\')">'.$trash.'</a>
								</div>';
						}
					else
					{
						$msg .= '<div class="loader">'.$loder.'</div>
								<div class="trash_can">
									<a class="href_a" onclick="reply_update(\''.$id.'\')">'.$reply.'</a>
								</div>';
					}
				$msg .= '</div>
				</div>';
		}
		return $msg;
	}
	
	
	
	
	
	
	/****************************************************************************
		param
			id 			=> for the div unique id and delete
			suser_id 	=> for the user information
			user_txt	=> putting the user text in
			diff		=> Show the difference
			$display	=> for trashcan to show or not
	*****************************************************************************/
	function get_update_div_post($id = 0,$suser_id = 0,$usr_txt = "", $diff = "",$display = "block"){
		$msg = "";
		if($usr_txt != "" and $diff != "" and $id != 0 and $suser_id != 0){
			$img = '<img src="'.FULL_PATH.'public/images/default_profile_normal.png" border="0" />';
			$noimg = '<img src="'.FULL_PATH.'public/images/default_profile_normal.png" border="0" />';
			$trash = '<img src="'.FULL_PATH.'public/images/icon_trash.gif" border="0" />';
			$loder = '<img src="'.FULL_PATH.'public/images/loader.gif" border="0" />';
			$reply = '<img src="'.FULL_PATH.'public/images/icon_reply.gif" border="0" />';
			
			
			$sql = "Select * from tbl_user where id = '".$suser_id."'";
			$rs = $this->RunQuerySingle($sql);
			if(!empty($rs)){
				$imgs = $rs['profile_img'];
				$user_name = $rs['username'];
				if($imgs != "")
				$img = '<img src="'.FULL_PATH.'public/profile_img/th_'.$imgs.'" border="0" />';
				
				//echo __SITE_PATH.'/public/profile_img/th_'.$imgs."<br /><br />";
				
				if(!is_readable(__SITE_PATH.'/public/profile_img/th_'.$imgs))
					$img = $noimg;	
			}
			
			$link = FULL_PATH.urlencode($user_name);
			
				$usr_txts = $usr_txt;
			$msg = '<div class="user_div" onmouseout="div_clr(this)" onmouseover="div_color(this)" style="display:'.$display.'" id="div_'.$id.'">
						<div class="dash_div"></div>
						
						<div class="user_div_left">
							<div class="profile_image">'.$img.'</div>
							<div class="user_sts">
							<span class="sts_name"><a href="'.$link.'" id="name_'.$id.'">'.$user_name.'</a></span>: 
							'.$usr_txts.'<br>
								<span class="time_txt">'.$diff.'</span>
							</div>
						</div>
						
						<div class="user_div_right">';
						
						
					if(isset($_SESSION["session_userid"]) && $_SESSION["session_userid"] == $suser_id){
						$msg .= '<div class="loader">'.$loder.'</div>
								<div class="trash_can">
									<a class="href_a" onclick="del_update(\''.$id.'\')">'.$trash.'</a>
								</div>';
					}
				$msg .= '</div>
				</div>';
		}
		return $msg;
	}
	
	
	
	
	
	
	
	
	
	
	/****************************************************************************
		param
			id 			=> for the div unique id and delete
			suser_id 	=> for the user information
			user_txt	=> putting the user text in
			diff		=> Show the difference
			$display	=> for trashcan to show or not
	*****************************************************************************/
	function get_update_div_user_profile($id = 0,$suser_id = 0,$usr_txt = "", $diff = "",$display = "block"){
		$msg = "";
		if($usr_txt != "" and $diff != "" and $id != 0 and $suser_id != 0){
			$img = '<img src="'.FULL_PATH.'public/images/default_profile_normal.png" border="0" />';
			$trash = '<img src="'.FULL_PATH.'public/images/icon_trash.gif" border="0" />';
			$loder = '<img src="'.FULL_PATH.'public/images/loader.gif" border="0" />';
			$reply = '<img src="'.FULL_PATH.'public/images/icon_reply.gif" border="0" />';
			
			
			$sql = "Select * from tbl_user where id = '".$suser_id."'";
			$rs = $this->RunQuerySingle($sql);
			if(!empty($rs)){
				$imgs = $rs['profile_img'];
				$user_name = $rs['username'];
				if($imgs != "")
				$img = '<img src="'.FULL_PATH.'public/profile_img/th_'.$imgs.'" border="0" />';
			}
			
			$link = FULL_PATH.$user_name;
			
			if(substr($usr_txt,0,1)=='@')
			{
				$space_pos = strpos($usr_txt,' ');
				$user_n  = substr($usr_txt,0,$space_pos);
				$user_nick  = urlencode(substr($usr_txt,1,$space_pos));
				$rest_msg = substr($usr_txt,$space_pos, strlen($usr_txt));
				$usr_n = '<a href="'.FULL_PATH.$user_nick.'">'.$user_n.'</a>';
				$usr_txts = $usr_n.$rest_msg;
			}
			else
				$usr_txts = $usr_txt;
			$msg = '<div class="user_div" onmouseout="div_clr(this)" onmouseover="div_color(this)" style="display:'.$display.'" id="div_'.$id.'">
						<div class="dash_div"></div>
						
						<div class="user_div_left">
							<div class="profile_image">'.$img.'</div>
							<div class="user_sts">
							<span class="sts_name"><a href="'.$link.'" id="name_'.$id.'">'.$user_name.'</a></span>: 
							'.$usr_txts.'<br>
								<span class="time_txt">'.$diff.'</span>
							</div>
						</div>
						
						<div class="user_div_right">';
						
						
					if(isset($_SESSION["session_userid"]) && $_SESSION["session_userid"] == $suser_id){
						$msg .= '<div class="loader">'.$loder.'</div>
								<div class="trash_can">
									<a class="href_a" onclick="del_update(\''.$id.'\')">'.$trash.'</a>
								</div>';
						}
				$msg .= '</div>
				</div>';
		}
		return $msg;
	}
	
	
	
	
	
	
	
	
	/****************************************************************************
		param
			id 			=> for the div unique id and delete
			suser_id 	=> for the user information
			user_txt	=> putting the user text in
			diff		=> Show the difference
			$display	=> for trashcan to show or not
	*****************************************************************************/
	function get_update_div_profile($id = 0,$suser_id = 0,$usr_txt = "", $diff = "",$display = "block"){
		$msg = "";
		if($usr_txt != "" and $diff != "" and $id != 0 and $suser_id != 0){
			
			$sql = "Select * from tbl_user where id = '".$suser_id."'";
			$rs = $this->RunQuerySingle($sql);
			if(!empty($rs)){
				$user_name = $rs['username'];
			}
			
			$link = FULL_PATH.urlencode($user_name);
			$msg = '<div class="user_div" onmouseout="div_clr(this)" onmouseover="div_color(this)" style="display:'.$display.'" id="div_'.$id.'">
						<div class="dash_div"></div>
						
						<div class="user_div_left">
							
							<div class="user_sts">
							<span class="sts_name"><a href="'.$link.'">@'.$user_name.'</a></span>: 
							'.$usr_txt.'<br>
								<span class="time_txt">'.$diff.'</span>
							</div>
						</div>
						
						<div class="user_div_right"></div>
				</div>';
		}
		return $msg;
	}
	
	
	
	
	
	
	
	/****************************************************************************
		param
			id 			=> for the div unique id and delete
			suser_id 	=> for the user information
			user_txt	=> putting the user text in
			diff		=> Show the difference
			$display	=> for trashcan to show or not
	*****************************************************************************/
	function get_tracker_view($trackid = 0,$suser_id = 0,$blk = 0, $track = 0){
		
		$msg = "";
		$display = "block";
		$usr_txt = "";
		$diff = "";
		$usr = "";
		$no_ticked = "";
		if($trackid != 0 and $suser_id != 0)
		 {
		 	
			$img = '<img src="'.FULL_PATH.'images/default_profile_normal.png" border="0" />';
			$loder = '<img src="'.FULL_PATH.'images/loader.gif" border="0" />';
			
			$sql = "Select * from tbl_user where id = '".$suser_id."'";
			
			//echo "\n\n\n";
			$rs = $this->RunQuerySingle($sql);
			if(!empty($rs)){
				$imgs = $rs['profile_img'];
				$user_name = $rs['full_name'];
				if($imgs != "")
				$img = '<img src="'.FULL_PATH.'profile_img/'.$suser_id.'/sth_'.$imgs.'" border="0" class="img_bdr" />';
				$link = FULL_PATH."users/".$suser_id;
				
				$usr = $this->get_last_update($suser_id);
				if(sizeof($usr)>0){
					$title = $usr['title'];
					$message = $usr['message'];
					$diff = $usr['create_time'];
				}

			
			
			if($track == 0)
			{
				$trackk = "Following this user";
				$vall = 'none';
			}
			else
			{
				$trackk = "Stop Following this user";
				$vall = 'block';
			}
			//'.$this->get_user_posts($suser_id).'
			$msg = '<div class="user_div"  style="display:'.$display.' padding-left:0px;" id="div_'.$suser_id.'">
			<table width="400">
			<tr>
			 <td width="379"><h3><a href="'.$link.'">'.$user_name.'</a></h3></td>
			 <td width="109" rowspan="4" valign="top" align="left">'.$img.'</td>
			</tr>
			<tr>
			 <td  align="left"><strong>Total Ticked: '.$this->get_user_posts($suser_id).'</strong></td>
			 </tr>
			<tr>
			 <td  align="left">';
					if($suser_id != $_SESSION['session_userid'])			
						$msg .=	'<a style="cursor:pointer;" class="href_a" id="trk_'.$suser_id.'" onclick="javascript:track(\''.$suser_id.'\')">'.$trackk.'</a>';
						
			$msg .=	'</td>
			 </tr>
			<tr>
			 <td ><table >
			   <tr>
				 <td width="371"  align="left"><span class="s_head"><br />Latest Ticked</span><br /></td>
			   </tr>
			   <tr>
				 <td style="font-size:14px; color:#0F6F97; font-weight:bold;"  align="left">'.$title.'</td>
			   </tr>
			   <tr>
				 <td  align="left">&nbsp;&nbsp;'.$message.'</td>
			   </tr>
			   <tr>
				 <td  align="left">'.$diff.'</td>
			   </tr>
			 </table></td>
			</tr>
			</table>
			</div>
			<hr>
			';
			}
			
			
		}
		return $msg;
	}
	
	
	/****************************************************************************
		getting user last update
	*****************************************************************************/
	function get_last_update($user_id = 0){
		$ret = array();
		if($user_id != 0){
			$sql = "Select title,message,create_time from tbl_ticked where user_id = '".$user_id."' and status = '1' order by create_time desc";
			$row = $this->RunQuerySingle($sql);
			if(!empty($row)){
				$ret['title'] = $row['title'];
				$ret['message'] = $row['message'];
				$ret['create_time']= $this->date_diff($row['create_time']);
			}
		}
		return $ret;
	}
	
	
	
	/****************************************************************************
		getting user last update
	*****************************************************************************/
	function get_user_block($user_id = 0, $s_userid = 0){
		$ret = array();
		if($user_id != 0){
			$sql = "Select block from tbl_tracking where user_id = '".$user_id."' and tracking_id = '".$s_userid."'";
			$row = $this->RunQuerySingle($sql);
			if(!empty($row)){
				$ret = $row['block'];
			}
			else{
				/*$arr = array(
							'tracking_id' => $s_userid,
							'user_id' => $user_id,
							'block' => 1
						);
				$rs = $this->Insert('tbl_tracking', $arr);
				$ret = 1;*/
			}
		}
		return $ret;
	}
	
	
	
	
	/****************************************************************************
		Format facebox
	****************************************************************************/
	function get_format(){
		$content = "";
		$content = $this->getContent(4);
		$content6 = $this->getContent(6);
		$myboxx = '<div class="format_head">
					<div  id="format" class="format_c">
						 <div class="txt_head">Format</div>
						'.$content.'
					</div>
					<div  id="promo" class="format_c">
						 <div class="txt_head">Promotion</div>
						'.$content6.'
					</div></div>';
		return $myboxx;
	}
	
	
	/****************************************************************************
		Trem facebox
	****************************************************************************/
	function get_term(){
		$content = "";
		$content = $this->getContent(3);
		$myboxx = '	<div class="format_head">
					<div  id="term" class="term_c" >
						 <div class="txt_head">Format</div>
						 <div class="term_cs">
						'.$content.'
						</div>
					</div></div>';
		return $myboxx;
	}
	
	
	/****************************************************************************
		getting the user is tracking someone
	*****************************************************************************/
	function get_tracking($user_id = 0,$uid = ""){
		
		$ret = false;
		if($user_id != 0 and $uid != "")
		 {
			
			
				$u_id = $uid;
				$sqls = "Select id from tbl_tracking where user_id = '".$user_id."' and tracking_id = '".$u_id."'";
				$rs = $this->RunQuerySingle($sqls);
				if(!empty($rs)){
					$id = $rs['id'];
					if($id != "")
						$ret = true;
					else
						$ret = false;
				}// if $rs empty
			
		}// if $user_id
		return $ret;
	}
	
	
	
	
	/****************************************************************************
		getting the id of the user and this friends
	*****************************************************************************/
	function get_friend_me($user_id=""){
		$ret = "('".$user_id."', ";
		if($user_id != ""){
			$sql = "Select tracking_id from tbl_tracking where user_id = '".$user_id."' and status = 1 and block = 0";
			$rows = $this->RunQuery($sql);
			if(!empty($rows)){
				foreach($rows as $row){
					$ret .= " '".$row['tracking_id']."', ";
				}
			}
		}
		$ret = substr($ret,0,-2);
		$ret .= ")";
		return $ret;
	}
	
	
	/****************************************************************************
		getting number of people who are trackinging him
	*****************************************************************************/
	function get_trackers($user_id = 0){
		$ret = "";
		if($user_id != 0){
			$sql = "Select id from tbl_tracking where tracking_id = '".$user_id."'";
			$ret = $this->RunQueryRow($sql);
		}
		return $ret;
	}
	
	
	/****************************************************************************
		getting number of people he is tracking
	*****************************************************************************/
	function get_trackings($user_id = 0){
		$ret = "";
		if($user_id != 0){
			$sql = "Select id from tbl_tracking where user_id = '".$user_id."'";
			$ret = $this->RunQueryRow($sql);
		}
		return $ret;
	}
	
	
	/****************************************************************************
		getting user id from the ussername
	*****************************************************************************/
	function get_id_from_name($u_name = ""){
		$ret = "";
		if($u_name != ""){
			$sql = "Select id from tbl_user where username = '".$u_name."'";
			$row = $this->RunQuerySingle($sql);
			$ret = $row['id'];
		}
		return $ret;
	}
	
	
	/****************************************************************************
		getting user info from the ussername
	*****************************************************************************/
	function get_info_from_name($u_name = ""){
		$ret = "";
		if($u_name != ""){
			$sql = "Select * from tbl_user where username = '".$u_name."'";
			$row = $this->RunQuerySingle($sql);
			$ret = $row;
		}
		return $ret;
	}
	
	
	
	/****************************************************************************
		getting user info from the ussername
	*****************************************************************************/
	function get_info_from_id($u_id = ""){
		$ret = "";
		if($u_id != ""){
			$sql = "Select * from tbl_user where id = '".$u_id."'";
			$row = $this->RunQuerySingle($sql);
			$ret = $row;
		}
		return $ret;
	}
	
	
	/****************************************************************************
		getting tracking with pictures
	*****************************************************************************/
	function get_pic_track($user_id = 0){
		$ret = "<div class='pic_head'><strong>Tracking</strong></div><div class='pic_pic'>";
		if($user_id != 0){	
			$sql = "Select t.tracking_id, u.username, u.id, u.profile_img
						from 
						tbl_tracking t 
						INNER JOIN 
						tbl_user u 
						ON  
						t.tracking_id = u.id
						where user_id = '".$user_id."' ";
			$rows = $this->RunQuery($sql);
			if(!empty($rows)){
				foreach($rows as $row){
					$img = __SITE_PATH."/public/profile_img/s_".$row['profile_img'];
					if(is_readable($img))
						$imgs = '<img src="'.FULL_PATH.'/public/profile_img/s_'.$row['profile_img'].'" border="0">';
					else
						$imgs = '<img src="'.FULL_PATH.'/public/images/profile_small.png" border="0">';
						
					$ret .= '<div class = "s_pic"><a href="'.FULL_PATH.$row['username'].'">'.$imgs.'</a></div>';
				}
			}
		}
		$ret .= '</div>';
		return $ret;
	}
	
	
	
	/****************************************************************************
		getting user info from the ussername
	*****************************************************************************/
	function get_info_tracking($u_id = "",$t_id = ""){
		$ret = "";
		if($u_id != ""){
			$sql = "Select * from tbl_tracking where user_id = '".$u_id."' and tracking_id = '".$t_id."'";
			$row = $this->RunQuerySingle($sql);
			$ret = $row;
		}
		return $ret;
	}
	
	
	
	
	
	
	/****************************************************************************
		param
			id 			=> for the div unique id and delete
			suser_id 	=> for the user information
			user_txt	=> putting the user text in
			diff		=> Show the difference
			$display	=> for trashcan to show or not
	*****************************************************************************/
	function get_search_view($usr_id = 0,$suser_id = 0,$blk = 0, $track = 0){
		
		$msg = "";
		$display = "block";
		$usr_txt = "";
		$diff = "";
		
		if($usr_id != 0 and $suser_id != 0){
			$img = '<img src="'.FULL_PATH.'public/images/default_profile_normal.png" border="0" />';
			$loder = '<img src="'.FULL_PATH.'public/images/loader.gif" border="0" />';
			
			$sql = "Select * from tbl_user where id = '".$suser_id."'";
			$rs = $this->RunQuerySingle($sql);
			if(!empty($rs)){
				$imgs = $rs['profile_img'];
				$user_name = $rs['username'];
				if($imgs != "")
				$img = '<img src="'.FULL_PATH.'public/profile_img/th_'.$imgs.'" border="0" />';
				$link = FULL_PATH.urlencode($user_name);
				$usr = $this->get_last_update($suser_id);
				if(sizeof($usr)>0){
					$usr_txt = $usr['user_text'];
					$diff = $usr['create_time'];
				}
			}
			
			if($blk == 0)
				$blkk = "Block";
			else
				$blkk = "Un Block";
			
			if($track == 0)
				$trackk = "Follow";
			else
				$trackk = "Un Follow";
			
			// the who is folowing will able to block 
			if($track == 1)
				$vall = 'block';
			else
				$vall = 'none';

			
			
			$msg = '<div class="user_div" onmouseout="div_clr(this)" onmouseover="div_color(this)" style="display:'.$display.'" id="div_'.$usr_id.'">
						<div class="dash_div"></div>
						
						<div class="user_div_left_track">
							<div class="profile_image">'.$img.'</div>
							<div class="user_sts">
							<span class="sts_name"><a href="'.$link.'">'.$user_name.'</a></span>: 
							'.$usr_txt.'<br>
								<span class="time_txt">'.$diff.'</span>
							</div>
						</div>
						
						<div class="user_div_right_track">
							<div class="loader">'.$loder.'</div>
								<div class="blk_div">';
					if($suser_id != $_SESSION['session_userid'])			
						$msg .=	'<a class="href_a" id="trk_'.$suser_id.'" onclick="track(\''.$suser_id.'\')">'.$trackk.'</a>';
						
			$msg .=			'</div>
								<div class="blk_div" style="display:'.$vall.'">';
								
			$msg .=		'<a class="href_a" id="blok_'.$suser_id.'" onclick="block(\''.$suser_id.'\')">'.$blkk.'</a>';
			
								
			$msg .=				'</div>
						</div>
				</div>';
		}
		return $msg;
	}
	
	
	
	
	/****************************************************************************
		param
			id 			=> for the div unique id and delete
			suser_id 	=> for the user information
			user_txt	=> putting the user text in
			diff		=> Show the difference
			$display	=> for trashcan to show or not
	*****************************************************************************/
	function get_sts_search_view($usr_id = 0,$suser_id = 0,$blk = 0, $track = 0, $imgs = "", $user_name = "", $usr_txt = "", $diff = ""){
		
		$msg = "";
		$display = "block";
		$msgs = "";
		
		if($usr_id != 0 and $suser_id != 0){
			$img = '<img src="'.FULL_PATH.'public/images/default_profile_normal.png" border="0" />';
			$loder = '<img src="'.FULL_PATH.'public/images/loader.gif" border="0" />';
			
			//$sql = "Select * from tbl_user where id = '".$suser_id."'";
			//$rs = $this->RunQuerySingle($sql);
			//if(!empty($rs)){
				//$imgs = $rs['profile_img'];
				//$user_name = $rs['username'];
				if($imgs != "")
					$img = '<img src="'.FULL_PATH.'public/profile_img/th_'.$imgs.'" border="0" />';
				$link = FULL_PATH.urlencode($user_name);
				//$usr = $this->get_last_update($suser_id);
				//if(sizeof($usr)>0){
					//$usr_txt = $usr['user_text'];
					//$diff = $usr['create_time'];
				//}
			//}
			
			if($blk == 0)
				$blkk = "Block";
			else
				$blkk = "Un Block";
			
			if($track == 0)
				$trackk = "Follow";
			else
				$trackk = "Un Follow";
			
			// the who is folowing will able to block 
			if($track == 1)
				$vall = 'block';
			else
				$vall = 'none';

			
			
			$msg = '<div class="user_div" onmouseout="div_clr(this)" onmouseover="div_color(this)" style="display:'.$display.'" id="div_'.$usr_id.'">
						<div class="dash_div"></div>
						
						<div class="user_div_left_track">
							<div class="profile_image">'.$img.'</div>
							<div class="user_sts">
							<span class="sts_name"><a href="'.$link.'">'.$user_name.'</a></span>: 
							'.$usr_txt.'<br>
								<span class="time_txt">'.$diff.'</span>
							</div>
						</div>
						
						<div class="user_div_right_track">
							<div class="loader">'.$loder.'</div>
								<div class="blk_div">';
					if($suser_id != $_SESSION['session_userid'])			
						$msgs .=	'<a class="href_a" id="trk_'.$suser_id.'" onclick="track(\''.$suser_id.'\')">'.$trackk.'</a>';
						
			$msgs .=			'</div>
								<div class="blk_div" style="display:'.$vall.'">';
								
			$msgs .=		'<a class="href_a" id="blok_'.$suser_id.'" onclick="block(\''.$suser_id.'\')">'.$blkk.'</a>';
			
								
			$msg .=				'</div>
						</div>
				</div>';
		}
		return $msg;
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	/*
	* Getting the time zone values
	*/
	function get_time_zone($class="" , $timezone="")
	{
				
		
		$html = '<select id="time_zone" name="time_zone" class="'.$class.'" style="width:400px;" >';
		$html .= '<option value="">Select</option>';
		
		if($timezone == "UTC")
			$html .= '<option value="UTC" selected="selected" >(GMT+00:00) UTC</option>';
		else
			$html .= '<option value="UTC" >(GMT+00:00) UTC</option>';


		if($timezone == "Dublin")
			$html .= '<option value="Dublin" selected="selected">(GMT+00:00) Dublin</option>';
		else
			$html .= '<option value="Dublin">(GMT+00:00) Dublin</option>';


		if($timezone == "London")
			$html .='<option value="London" selected="selected">(GMT+00:00) London</option>';
		else
			$html .='<option value="London" >(GMT+00:00) London</option>';	



		if($timezone == "Sydney")
			$html .= '<option value="Sydney" selected="selected">(GMT+10:00) Sydney</option>';
		else
			$html .= '<option value="Sydney">(GMT+10:00) Sydney</option>';
			



		if($timezone == "Hawaii")
			$html .= '<option value="Hawaii" selected="selected">(GMT-10:00) Hawaii</option>';
		else
			$html .= '<option value="Hawaii">(GMT-10:00) Hawaii</option>';
		


		if($timezone == "Alaska")
			$html .= '<option value="Alaska" selected="selected">(GMT-09:00) Alaska</option>';	
		else
			$html .= '<option value="Alaska">(GMT-09:00) Alaska</option>';	
			
			
			
		if($timezone == "PacificTimeUSCanada")
			$html .= '<option value="PacificTimeUSCanada" selected="selected">(GMT-08:00) Pacific Time (US &amp; Canada)</option>';
		else
		  	$html .= '<option value="PacificTimeUSCanada">(GMT-08:00) Pacific Time (US &amp; Canada)</option>';
			
			
		if($timezone == "Arizona")
			$html .= '<option value="Arizona" selected="selected">(GMT-07:00) Arizona</option>';
		else
			$html .= '<option value="Arizona">(GMT-07:00) Arizona</option>';
			
			
			
		if($timezone == "MountainTimeUSCanada")
			$html .= '<option value="MountainTimeUSCanada" selected="selected">(GMT-07:00) Mountain Time (US &amp; Canada)</option>';
		else
			$html .= '<option value="MountainTimeUSCanada">(GMT-07:00) Mountain Time (US &amp; Canada)</option>';
			
			
		if($timezone == "CentralTimeUSCanada")
			$html .= '<option value="CentralTimeUSCanada" selected="selected">(GMT-06:00) Central Time (US &amp; Canada)</option>';
		else
			$html .= '<option value="CentralTimeUSCanada">(GMT-06:00) Central Time (US &amp; Canada)</option>';
			
			
		if($timezone == "EasternTimeUSCanada")
			$html .= '<option value="EasternTimeUSCanada" selected="selected">(GMT-05:00) Eastern Time (US &amp; Canada)</option>';
		else
			$html .= '<option value="EasternTimeUSCanada">(GMT-05:00) Eastern Time (US &amp; Canada)</option>';
			
			
			
		if($timezone == "IndianaEast")
			$html .= '<option value="IndianaEast" selected="selected">(GMT-05:00) Indiana (East)</option>';
		else
			$html .= '<option value="IndianaEast">(GMT-05:00) Indiana (East)</option>';
			
			
		if($timezone == "InternationalDateLineWest")
			$html .= '<option value="InternationalDateLineWest" selected="selected">(GMT-11:00) International Date Line West</option>';
		else
			$html .= '<option value="IInternationalDateLineWest">(GMT-11:00) International Date Line West</option>';
			
			
			
		if($timezone == "MidwayIsland")
			$html .= '<option value="MidwayIsland" selected="selected">(GMT-11:00) Midway Island</option>';
		else
			$html .= '<option value="MidwayIsland">(GMT-11:00) Midway Island</option>';
			
			
			
		if($timezone == "Samoa")
			$html .= '<option value="Samoa" selected="selected">(GMT-11:00) Samoa</option>';
		else
			$html .= '<option value="Samoa">(GMT-11:00) Samoa</option>';
			
			
		if($timezone == "Tijuana")
			$html .= '<option value="Tijuana" selected="selected">(GMT-08:00) Tijuana</option>';
		else
			$html .= '<option value="Tijuana">(GMT-08:00) Tijuana</option>';
			
			
			
		if($timezone == "Chihuahua")
			$html .= '<option value="Chihuahua" selected="selected">(GMT-07:00) Chihuahua</option>';
		else
			$html .= '<option value="Chihuahua">(GMT-07:00) Chihuahua</option>';
			
			
			
		if($timezone == "Mazatlan")
			$html .= '<option value="Mazatlan" selected="selected">(GMT-07:00) Mazatlan</option>';
		else
			$html .= '<option value="Mazatlan">(GMT-07:00) Mazatlan</option>';
		
		
		
		if($timezone == "CentralAmerica")
			$html .= '<option value="CentralAmerica" selected="selected">(GMT-06:00) Central America</option>';
		else
			$html .= '<option value="CentralAmerica">(GMT-06:00) Central America</option>';
			
			
			
		if($timezone == "Guadalajara")
			$html .= '<option value="Guadalajara" selected="selected">(GMT-06:00) Guadalajara</option>';
		else
			$html .= '<option value="Guadalajara">(GMT-06:00) Guadalajara</option>';
			
			
		if($timezone == "MexicoCity")
			$html .= '<option value="MexicoCity" selected="selected">(GMT-06:00) Mexico City</option>';
		else
			$html .= '<option value="MexicoCity">(GMT-06:00) Mexico City</option>';
			
			
		if($timezone == "Monterrey")
			$html .= '<option value="Monterrey" selected="selected">(GMT-06:00) Monterrey</option>';
		else
			$html .= '<option value="Monterrey">(GMT-06:00) Monterrey</option>';
			
			
			
			
		if($timezone == "Saskatchewan")
			$html .= '<option value="Saskatchewan" selected="selected">(GMT-06:00) Saskatchewan</option>';
		else
			$html .= '<option value="Saskatchewan">(GMT-06:00) Saskatchewan</option>';
			
			
		if($timezone == "Bogota")
			$html .= '<option value="Bogota" selected="selected">(GMT-05:00) Bogota</option>';
		else
			$html .= '<option value="Bogota">(GMT-05:00) Bogota</option>';
			
			
		if($timezone == "Lima")
			$html .= '<option value="Lima" selected="selected">(GMT-05:00) Lima</option>';
		else
			$html .= '<option value="Lima">(GMT-05:00) Lima</option>';
		
		
		if($timezone == "Quito")
			$html .= '<option value="Quito" selected="selected">(GMT-05:00) Quito</option>';
		else
			$html .= '<option value="Quito">(GMT-05:00) Quito</option>';
		
		
		if($timezone == "AtlanticTimeCanada")
			$html .= '<option value="AtlanticTimeCanada" selected="selected">(GMT-04:00) Atlantic Time (Canada)</option>';
		else
			$html .= '<option value="AtlanticTimeCanada" >(GMT-04:00) Atlantic Time (Canada)</option>';
		
		
		
		if($timezone == "Caracas")
			$html .= '<option value="Caracas" selected="selected">(GMT-04:00) Caracas</option>';
		else
			$html .= '<option value="Caracas" >(GMT-04:00) Caracas</option>';
		
		
		if($timezone == "LaPaz")
			$html .= '<option value="LaPaz" selected="selected">(GMT-04:00) La Paz</option>';
		else
			$html .= '<option value="LaPaz" >(GMT-04:00) La Paz</option>';
			
			
			
			
		if($timezone == "Santiago")
			$html .= '<option value="Santiago" selected="selected">(GMT-04:00) Santiago</option>';	
		else
			$html .= '<option value="Santiago" >(GMT-04:00) Santiago</option>';	
		
		
		
		if($timezone == "Newfoundland")
			$html .= '<option value="Newfoundland" selected="selected">(GMT-03:30) Newfoundland</option>';
		else
			$html .= '<option value="Newfoundland">(GMT-03:30) Newfoundland</option>';
		
		
		if($timezone == "Brasilia")
			$html .= '<option value="Brasilia" selected="selected">(GMT-03:00) Brasilia</option>';
		else
			$html .= '<option value="Brasilia">(GMT-03:00) Brasilia</option>';
		
		
		if($timezone == "BuenosAires")
			$html .= '<option value="BuenosAires" selected="selected">(GMT-03:00) Buenos Aires</option>';
		else
			$html .= '<option value="BuenosAires">(GMT-03:00) Buenos Aires</option>';
		
		
		if($timezone == "Georgetown")
			$html .= '<option value="Georgetown" selected="selected">(GMT-03:00) Georgetown</option>';
		else
			$html .= '<option value="Georgetown">(GMT-03:00) Georgetown</option>';
		
		
		if($timezone == "Greenland")
			$html .= '<option value="Greenland" selected="selected">(GMT-03:00) Greenland</option>';
		else
			$html .= '<option value="Greenland">(GMT-03:00) Greenland</option>';
		
		
		if($timezone == "Mid-Atlantic")
			$html .= '<option value="Mid-Atlantic" selected="selected">(GMT-02:00) Mid-Atlantic</option>';
		else
			$html .= '<option value="Mid-Atlantic">(GMT-02:00) Mid-Atlantic</option>';
		
		
		if($timezone == "Azores")
			$html .= '<option value="Azores" selected="selected">(GMT-01:00) Azores</option>';
		else
			$html .= '<option value="Azores">(GMT-01:00) Azores</option>';
		
		
		if($timezone == "CapeVerdeIs")
			$html .= '<option value="CapeVerdeIs" selected="selected">(GMT-01:00) Cape Verde Is.</option>';
		else
			$html .= '<option value="CapeVerdeIs">(GMT-01:00) Cape Verde Is.</option>';
		
		
		if($timezone == "Casablanca")
			$html .= '<option value="Casablanca" selected="selected">(GMT+00:00) Casablanca</option>';
		else
			$html .= '<option value="Casablanca">(GMT+00:00) Casablanca</option>';
		
		
		if($timezone == "Edinburgh")
			$html .= '<option value="Edinburgh" selected="selected">(GMT+00:00) Edinburgh</option>';
		else
			$html .= '<option value="Edinburgh">(GMT+00:00) Edinburgh</option>';
		
		
		if($timezone == "Lisbon")
			$html .= '<option value="Lisbon" selected="selected">(GMT+00:00) Lisbon</option>';
		else
			$html .= '<option value="Lisbon">(GMT+00:00) Lisbon</option>';
		
		
		if($timezone == "Monrovia")
			$html .= '<option value="Monrovia" selected="selected">(GMT+00:00) Monrovia</option>';
		else
			$html .= '<option value="Monrovia">(GMT+00:00) Monrovia</option>';
		
		
		if($timezone == "Amsterdam")
				$html .= '<option value="Amsterdam" selected="selected">(GMT+01:00) Amsterdam</option>';
		else
			$html .= '<option value="Amsterdam">(GMT+01:00) Amsterdam</option>';
		
		
		if($timezone == "Belgrade")
			$html .= '<option value="Belgrade" selected="selected">(GMT+01:00) Belgrade</option>';
		else
			$html .= '<option value="Belgrade">(GMT+01:00) Belgrade</option>';
		
		
		if($timezone == "Berlin")
			$html .= '<option value="Berlin" selected="selected">(GMT+01:00) Berlin</option>';
		else
			$html .= '<option value="Berlin">(GMT+01:00) Berlin</option>';
		
		
		if($timezone == "Bern")
			$html .= '<option value="Bern" selected="selected">(GMT+01:00) Bern</option>';
		else
		 $html .= '<option value="Bern">(GMT+01:00) Bern</option>';
		
		
		if($timezone == "Bratislava")
			$html .= '<option value="Bratislava" selected="selected">(GMT+01:00) Bratislava</option>';
		else
			$html .= '<option value="Bratislava">(GMT+01:00) Bratislava</option>';
		
		
		if($timezone == "Brussels")
			$html .= '<option value="Brussels" selected="selected">(GMT+01:00) Brussels</option>';
		else
			$html .= '<option value="Brussels">(GMT+01:00) Brussels</option>';
		
		
		if($timezone == "Budapest")
			$html .= '<option value="Budapest" selected="selected">(GMT+01:00) Budapest</option>';
		else
			$html .= '<option value="Budapest">(GMT+01:00) Budapest</option>';
		
		
		if($timezone == "Copenhagen")
			$html .= '<option value="Copenhagen" selected="selected">(GMT+01:00) Copenhagen</option>';
		else
			$html .= '<option value="Copenhagen">(GMT+01:00) Copenhagen</option>';
		
		
		
		if($timezone == "Ljubljana")
			$html .= '<option value="Ljubljana" selected="selected">(GMT+01:00) Ljubljana</option>';
		else
			$html .= '<option value="Ljubljana">(GMT+01:00) Ljubljana</option>';
		
		
		if($timezone == "Madrid")
			$html .= '<option value="Madrid" selected="selected">(GMT+01:00) Madrid</option>';
		else
			$html .= '<option value="Madrid">(GMT+01:00) Madrid</option>';
		
		
		if($timezone == "Paris")
			$html .= '<option value="Paris" selected="selected">(GMT+01:00) Paris</option>';
		else
			$html .= '<option value="Paris">(GMT+01:00) Paris</option>';
		
		
		if($timezone == "Prague")
			$html .= '<option value="Prague" selected="selected">(GMT+01:00) Prague</option>';
		else
		$html .= '<option value="Prague">(GMT+01:00) Prague</option>';	
		
		
		if($timezone == "Rome")
			$html .= '<option value="Rome" selected="selected">(GMT+01:00) Rome</option>';
		else
		$html .= '<option value="Rome">(GMT+01:00) Rome</option>';
		
		
		if($timezone == "Sarajevo")
			$html .= '<option value="Sarajevo" selected="selected">(GMT+01:00) Sarajevo</option>';
		else
			$html .= '<option value="Sarajevo">(GMT+01:00) Sarajevo</option>';
		
		
		if($timezone == "Skopje")
			$html .= '<option value="Skopje" selected="selected">(GMT+01:00) Skopje</option>';
		else
			$html .= '<option value="Skopje">(GMT+01:00) Skopje</option>';
		
		
		if($timezone == "Stockholm")
			$html .= '<option value="Stockholm" selected="selected">(GMT+01:00) Stockholm</option>';
		else
			$html .= '<option value="Stockholm">(GMT+01:00) Stockholm</option>';
		
		
		if($timezone == "Vienna")
			$html .= '<option value="Vienna" selected="selected">(GMT+01:00) Vienna</option>';
		else
			$html .= '<option value="Vienna">(GMT+01:00) Vienna</option>';
		
		
		if($timezone == "Warsaw")
			$html .= '<option value="Warsaw" selected="selected">(GMT+01:00) Warsaw</option>';
		else
			$html .= '<option value="Warsaw">(GMT+01:00) Warsaw</option>';
		
		
		if($timezone == "WestCentralAfrica")
			$html .= '<option value="WestCentralAfrica" selected="selected">(GMT+01:00) West Central Africa</option>';
		else
			$html .= '<option value="WestCentralAfrica">(GMT+01:00) West Central Africa</option>';
		
		
		if($timezone == "Zagreb")
			$html .= '<option value="Zagreb" selected="selected">(GMT+01:00) Zagreb</option>';
		else
			$html .= '<option value="Zagreb">(GMT+01:00) Zagreb</option>';
		
		
		if($timezone == "Athens")
			$html .= '<option value="Athens" selected="selected">(GMT+02:00) Athens</option>';
		else
			$html .= '<option value="Athens">(GMT+02:00) Athens</option>';
		
		
		if($timezone == "Bucharest")
			$html .= '<option value="Bucharest" selected="selected">(GMT+02:00) Bucharest</option>';
		else
			$html .= '<option value="Bucharest">(GMT+02:00) Bucharest</option>';
		
		
		if($timezone == "Cairo")
			$html .= '<option value="Cairo" selected="selected">(GMT+02:00) Cairo</option>';
		else
			$html .= '<option value="Cairo">(GMT+02:00) Cairo</option>';
		
		
		if($timezone == "Harare")
			$html .= '<option value="Harare" selected="selected">(GMT+02:00) Harare</option>';
		else
			$html .= '<option value="Harare">(GMT+02:00) Harare</option>';
		
		
		if($timezone == "Helsinki")
			$html .= '<option value="Helsinki" selected="selected">(GMT+02:00) Helsinki</option>';
		else
			$html .= '<option value="Helsinki">(GMT+02:00) Helsinki</option>';
		
		
		if($timezone == "Istanbul")
				$html .= '<option value="Istanbul" selected="selected">(GMT+02:00) Istanbul</option>';
		else
				$html .= '<option value="Istanbul">(GMT+02:00) Istanbul</option>';
		
		
		if($timezone == "Jerusalem")
			$html .= '<option value="Jerusalem" selected="selected">(GMT+02:00) Jerusalem</option>';
		else
			$html .= '<option value="Jerusalem">(GMT+02:00) Jerusalem</option>';

		
		if($timezone == "Kyev")
			$html .= '<option value="Kyev" selected="selected">(GMT+02:00) Kyev</option>';
		else
			$html .= '<option value="Kyev">(GMT+02:00) Kyev</option>';
		
		
		if($timezone == "Minsk")
			$html .= '<option value="Minsk" selected="selected">(GMT+02:00) Minsk</option>';
		else
			$html .= '<option value="Minsk">(GMT+02:00) Minsk</option>';
		if($timezone == "Pretoria")
			$html .= '<option value="Pretoria" selected="selected">(GMT+02:00) Pretoria</option>';
		else
			$html .= '<option value="Pretoria">(GMT+02:00) Pretoria</option>';
		if($timezone == "Riga")
			$html .= '<option value="Riga" selected="selected">(GMT+02:00) Riga</option>';
		else
			$html .= '<option value="Riga">(GMT+02:00) Riga</option>';
			
		if($timezone == "Sofia")
			$html .= '<option value="Sofia" selected="selected">(GMT+02:00) Sofia</option>';
		else
			$html .= '<option value="Sofia">(GMT+02:00) Sofia</option>';
		
		
		if($timezone == "Tallinn")
			$html .= '<option value="Tallinn" selected="selected">(GMT+02:00) Tallinn</option>';
		else
			$html .= '<option value="Tallinn">(GMT+02:00) Tallinn</option>';
		
		
		if($timezone == "Vilnius")
			$html .= '<option value="Vilnius" selected="selected">(GMT+02:00) Vilnius</option>';
		else
			$html .= '<option value="Vilnius">(GMT+02:00) Vilnius</option>';
		
		
		if($timezone == "Baghdad")
			$html .= '<option value="Baghdad" selected="selected">(GMT+03:00) Baghdad</option>';
		else
			$html .= '<option value="Baghdad">(GMT+03:00) Baghdad</option>';
		
		
		if($timezone == "Kuwait")
			$html .= '<option value="Kuwait" selected="selected">(GMT+03:00) Kuwait</option>';
		else
			$html .= '<option value="Kuwait">(GMT+03:00) Kuwait</option>';
		
		
		if($timezone == "Moscow")
			$html .= '<option value="Moscow" selected="selected">(GMT+03:00) Moscow</option>';
		else
			$html .= '<option value="Moscow">(GMT+03:00) Moscow</option>';
		
		
		if($timezone == "Nairobi")
			$html .= '<option value="Nairobi" selected="selected">(GMT+03:00) Nairobi</option>';
		else
			$html .= '<option value="Nairobi">(GMT+03:00) Nairobi</option>';
		
		
		if($timezone == "Riyadh")
			$html .= '<option value="Riyadh" selected="selected">(GMT+03:00) Riyadh</option>';
		else
			$html .= '<option value="Riyadh">(GMT+03:00) Riyadh</option>';
		
		
		if($timezone == "StPetersburg")
			$html .= '<option value="StPetersburg" selected="selected">(GMT+03:00) St. Petersburg</option>';
		else
			$html .= '<option value="StPetersburg">(GMT+03:00) St. Petersburg</option>';
		
		
		if($timezone == "Volgograd")
			$html .= '<option value="Volgograd" selected="selected">(GMT+03:00) Volgograd</option>';
		else
			$html .= '<option value="Volgograd">(GMT+03:00) Volgograd</option>';
		
		
		if($timezone == "Tehran")
			$html .= '<option value="Tehran" selected="selected">(GMT+03:30) Tehran</option>';
		else
			$html .= '<option value="Tehran">(GMT+03:30) Tehran</option>';
		
		
		if($timezone == "AbuDhabi")
			$html .= '<option value="AbuDhabi" selected="selected">(GMT+04:00) Abu Dhabi</option>';
		else
			$html .= '<option value="AbuDhabi">(GMT+04:00) Abu Dhabi</option>';
			
		
		if($timezone == "Baku")
		$html .= '<option value="Baku" selected="selected">(GMT+04:00) Baku</option>';
		else
		$html .= '<option value="Baku">(GMT+04:00) Baku</option>';
		
		
		if($timezone == "Muscat")
		$html .= '<option value="Muscat" selected="selected">(GMT+04:00) Muscat</option>';
		else
		$html .= '<option value="Muscat">(GMT+04:00) Muscat</option>';
		
		
		if($timezone == "Tbilisi")
		$html .= '<option value="Tbilisi" selected="selected">(GMT+04:00) Tbilisi</option>';
		else
		$html .= '<option value="Tbilisi">(GMT+04:00) Tbilisi</option>';
		
		
		if($timezone == "Yerevan")
		$html .= '<option value="Yerevan" selected="selected">(GMT+04:00) Yerevan</option>';
		else
		$html .= '<option value="Yerevan">(GMT+04:00) Yerevan</option>';
		
		
		if($timezone == "Kabul")
		$html .= '<option value="Kabul" selected="selected">(GMT+04:30) Kabul</option>';
		else
		$html .= '<option value="Kabul">(GMT+04:30) Kabul</option>';
		
		
		if($timezone == "Ekaterinburg")
		$html .= '<option value="Ekaterinburg" selected="selected">(GMT+05:00) Ekaterinburg</option>';
		else
		$html .= '<option value="Ekaterinburg">(GMT+05:00) Ekaterinburg</option>';
		
		
		if($timezone == "Islamabad")
		$html .= '<option value="Islamabad" selected="selected">(GMT+05:00) Islamabad</option>';
		else
		$html .= '<option value="Islamabad">(GMT+05:00) Islamabad</option>';
		
		
		if($timezone == "Karachi")
		$html .= '<option value="Karachi" selected="selected">(GMT+05:00) Karachi</option>';
		else
		$html .= '<option value="Karachi">(GMT+05:00) Karachi</option>';
		
		
		if($timezone == "Tashkent")
		$html .= '<option value="Tashkent" selected="selected">(GMT+05:00) Tashkent</option>';
		else
		$html .= '<option value="Tashkent">(GMT+05:00) Tashkent</option>';
		
		
		if($timezone == "Chennai")
		$html .= '<option value="Chennai" selected="selected">(GMT+05:30) Chennai</option>';
		else
		$html .= '<option value="Chennai">(GMT+05:30) Chennai</option>';
		
		
		if($timezone == "Kolkata")
		$html .= '<option value="Kolkata" selected="selected">(GMT+05:30) Kolkata</option>';
		else
		$html .= '<option value="Kolkata">(GMT+05:30) Kolkata</option>';
		
		
		if($timezone == "Mumbai")
		$html .= '<option value="Mumbai" selected="selected">(GMT+05:30) Mumbai</option>';
		else
		$html .= '<option value="Mumbai">(GMT+05:30) Mumbai</option>';
		
		
		if($timezone == "NewDelhi")
		$html .= '<option value="NewDelhi" selected="selected">(GMT+05:30) New Delhi</option>';
		else	
		$html .= '<option value="NewDelhi">(GMT+05:30) New Delhi</option>';
		
		
		if($timezone == "Kathmandu")
		$html .= '<option value="Kathmandu" selected="selected">(GMT+05:45) Kathmandu</option>';
		else
		$html .= '<option value="Kathmandu">(GMT+05:45) Kathmandu</option>';
		
		
		if($timezone == "Almaty")
		$html .= '<option value="Almaty" selected="selected">(GMT+06:00) Almaty</option>';
		else
		$html .= '<option value="Almaty">(GMT+06:00) Almaty</option>';
		
		
		if($timezone == "Astana")
		$html .= '<option value="Astana" selected="selected">(GMT+06:00) Astana</option>';
		else
		$html .= '<option value="Astana">(GMT+06:00) Astana</option>';
		
		
		if($timezone == "Dhaka")
		$html .= '<option value="Dhaka" selected="selected">(GMT+06:00) Dhaka</option>';
		else
		$html .= '<option value="Dhaka">(GMT+06:00) Dhaka</option>';
		
		
		if($timezone == "Novosibirsk")
		$html .= '<option value="Novosibirsk" selected="selected">(GMT+06:00) Novosibirsk</option>';
		else
		$html .= '<option value="Novosibirsk">(GMT+06:00) Novosibirsk</option>';
		
		
		if($timezone == "SriJayawardenepura")
		$html .= '<option value="SriJayawardenepura" selected="selected">(GMT+06:00) Sri Jayawardenepura</option>';
		else
		$html .= '<option value="SriJayawardenepura">(GMT+06:00) Sri Jayawardenepura</option>';
		
		
		if($timezone == "Rangoon")
		$html .= '<option value="Rangoon" selected="selected">(GMT+06:30) Rangoon</option>';
		else
		$html .= '<option value="Rangoon">(GMT+06:30) Rangoon</option>';
		
		
		if($timezone == "Bangkok")
		$html .= '<option value="Bangkok" selected="selected">(GMT+07:00) Bangkok</option>';
		else
		$html .= '<option value="Bangkok">(GMT+07:00) Bangkok</option>';
		
		
		if($timezone == "Hanoi")
		$html .= '<option value="Hanoi" selected="selected">(GMT+07:00) Hanoi</option>';
		else
		$html .= '<option value="Hanoi">(GMT+07:00) Hanoi</option>';
		
		
		if($timezone == "Jakarta")
		$html .= '<option value="Jakarta" selected="selected">(GMT+07:00) Jakarta</option>';
		else
		$html .= '<option value="Jakarta">(GMT+07:00) Jakarta</option>';
		
		
		if($timezone == "Krasnoyarsk")
			$html .= '<option value="Krasnoyarsk" selected="selected">(GMT+07:00) Krasnoyarsk</option>';
		else
			$html .= '<option value="Krasnoyarsk">(GMT+07:00) Krasnoyarsk</option>';
		
		
		if($timezone == "Beijing")
		$html .= '<option value="Beijing" selected="selected">(GMT+08:00) Beijing</option>';
		else
		$html .= '<option value="Beijing">(GMT+08:00) Beijing</option>';
		
		
		if($timezone == "Chongqing")
		$html .= '<option value="Chongqing" selected="selected">(GMT+08:00) Chongqing</option>';
		else
		$html .= '<option value="Chongqing">(GMT+08:00) Chongqing</option>';
		
		
		if($timezone == "HongKong")
		$html .= '<option value="HongKong" selected="selected">(GMT+08:00) Hong Kong</option>';
		else
		$html .= '<option value="HongKong">(GMT+08:00) Hong Kong</option>';
		
		
		if($timezone == "Irkutsk")
		$html .= '<option value="Irkutsk" selected="selected">(GMT+08:00) Irkutsk</option>';
		else
		$html .= '<option value="Irkutsk">(GMT+08:00) Irkutsk</option>';
		
		
		if($timezone == "KualaLumpur")
		$html .= '<option value="KualaLumpur" selected="selected">(GMT+08:00) Kuala Lumpur</option>';
		else
		$html .= '<option value="KualaLumpur">(GMT+08:00) Kuala Lumpur</option>';
		
		
		if($timezone == "Perth")
		$html .= '<option value="Perth" selected="selected">(GMT+08:00) Perth</option>';
		else
			$html .= '<option value="Perth">(GMT+08:00) Perth</option>';
		
		
		if($timezone == "Singapore")
		$html .= '<option value="Singapore" selected="selected">(GMT+08:00) Singapore</option>';
		else
		$html .= '<option value="Singapore">(GMT+08:00) Singapore</option>';
		
		
		if($timezone == "Taipei")
		$html .= '<option value="Taipei" selected="selected">(GMT+08:00) Taipei</option>';
		else
		$html .= '<option value="Taipei">(GMT+08:00) Taipei</option>';
		
		
		if($timezone == "UlaanBataar")
		$html .= '<option value="UlaanBataar" selected="selected">(GMT+08:00) Ulaan Bataar</option>';
		else
		$html .= '<option value="UlaanBataar">(GMT+08:00) Ulaan Bataar</option>';
		
		
		if($timezone == "Urumqi")
		$html .= '<option value="Urumqi" selected="selected">(GMT+08:00) Urumqi</option>';
		else
		$html .= '<option value="Urumqi">(GMT+08:00) Urumqi</option>';
		if($timezone == "Osaka")
		
		
		$html .= '<option value="Osaka" selected="selected">(GMT+09:00) Osaka</option>';
		else
		$html .= '<option value="Osaka">(GMT+09:00) Osaka</option>';
		
		
		if($timezone == "Sapporo")
		$html .= '<option value="Sapporo" selected="selected">(GMT+09:00) Sapporo</option>';
		else
		$html .= '<option value="Sapporo">(GMT+09:00) Sapporo</option>';
		
		
		if($timezone == "Seoul")
		$html .= '<option value="Seoul" selected="selected">(GMT+09:00) Seoul</option>';
		else
		$html .= '<option value="Seoul">(GMT+09:00) Seoul</option>';
		
		
		if($timezone == "Tokyo")
		$html .= '<option value="Tokyo" selected="selected">(GMT+09:00) Tokyo</option>';
		else
		$html .= '<option value="Tokyo">(GMT+09:00) Tokyo</option>';
		
		
		if($timezone == "Yakutsk")
		$html .= '<option value="Yakutsk" selected="selected">(GMT+09:00) Yakutsk</option>';
		else
		$html .= '<option value="Yakutsk">(GMT+09:00) Yakutsk</option>';
		
		
		if($timezone == "Adelaide")
		$html .= '<option value="Adelaide" selected="selected">(GMT+09:30) Adelaide</option>';
		else
		$html .= '<option value="Adelaide">(GMT+09:30) Adelaide</option>';
		
		
		if($timezone == "Darwin")
			$html .= '<option value="Darwin" selected="selected">(GMT+09:30) Darwin</option>';
		else
		$html .= '<option value="Darwin">(GMT+09:30) Darwin</option>';
		
		
		if($timezone == "Brisbane")
		$html .= '<option value="Brisbane" selected="selected">(GMT+10:00) Brisbane</option>';
		else
		$html .= '<option value="Brisbane">(GMT+10:00) Brisbane</option>';
		
		
		if($timezone == "Canberra")
		$html .= '<option value="Canberra" selected="selected">(GMT+10:00) Canberra</option>';
		else
		$html .= '<option value="Canberra">(GMT+10:00) Canberra</option>';
		
		
		if($timezone == "Guam")
		$html .= '<option value="Guam" selected="selected">(GMT+10:00) Guam</option>';
		else
		$html .= '<option value="Guam">(GMT+10:00) Guam</option>';
		
		
		if($timezone == "Hobart")
		$html .= '<option value="Hobart" selected="selected">(GMT+10:00) Hobart</option>';
		else
			$html .= '<option value="Hobart">(GMT+10:00) Hobart</option>';
		
		
		if($timezone == "Melbourne")
		$html .= '<option value="Melbourne" selected="selected">(GMT+10:00) Melbourne</option>';
		else
		$html .= '<option value="Melbourne">(GMT+10:00) Melbourne</option>';
		
		
		if($timezone == "Port Moresby")
		$html .= '<option value="Port Moresby" selected="selected">(GMT+10:00) Port Moresby</option>';
		else
		$html .= '<option value="Port Moresby">(GMT+10:00) Port Moresby</option>';
		
		
		if($timezone == "Vladivostok")
		$html .= '<option value="Vladivostok"> selected="selected"(GMT+10:00) Vladivostok</option>';
		else
		$html .= '<option value="Vladivostok">(GMT+10:00) Vladivostok</option>';
		
		
		if($timezone == "Magadan")
		$html .= '<option value="Magadan" selected="selected">(GMT+11:00) Magadan</option>';
		else
		$html .= '<option value="Magadan">(GMT+11:00) Magadan</option>';
		
		
		if($timezone == "NewCaledonia")
		$html .= '<option value="NewCaledonia" selected="selected">(GMT+11:00) New Caledonia</option>';
		else
		$html .= '<option value="NewCaledonia">(GMT+11:00) New Caledonia</option>';
		
		
		if($timezone == "SolomonIs")
		$html .= '<option value="SolomonIs"> selected="selected"(GMT+11:00) Solomon Is.</option>';
		else
		$html .= '<option value="SolomonIs">(GMT+11:00) Solomon Is.</option>';
		
		
		if($timezone == "Auckland")
			$html .= '<option value="Auckland" selected="selected">(GMT+12:00) Auckland</option>';
		else
			$html .= '<option value="Auckland">(GMT+12:00) Auckland</option>';
		
		
		if($timezone == "Fiji")
		$html .= '<option value="Fiji" selected="selected">(GMT+12:00) Fiji</option>';
		else
		$html .= '<option value="Fiji">(GMT+12:00) Fiji</option>';
		
		
		if($timezone == "Kamchatka")
		$html .= '<option value="Kamchatka" selected="selected">(GMT+12:00) Kamchatka</option>';
		else
			$html .= '<option value="Kamchatka">(GMT+12:00) Kamchatka</option>';
		
		
		if($timezone == "MarshallIs")
		$html .= '<option value="MarshallIs" selected="selected">(GMT+12:00) Marshall Is.</option>';
		else
		$html .= '<option value="MarshallIs">(GMT+12:00) Marshall Is.</option>';
		
		
		
		if($timezone == "Wellington")
		$html .= '<option value="Wellington" selected="selected">(GMT+12:00) Wellington</option>';
		else
		$html .= '<option value="Wellington">(GMT+12:00) Wellington</option>';
		
		
		if($timezone == "Nukualofa")
		$html .= '<option value="Nukualofa" selected="selected">(GMT+13:00) Nuku\'alofa</option></select>';
		else
		$html .= '<option value="Nukualofa">(GMT+13:00) Nuku\'alofa</option></select>';
		
		return $html;
	}
	
	
	
	
	
	function validate_Post($data)
	 {
	 	$arrData =explode(";",$data);
		$item = "";
		$price = "";
		$location = "";
		$custom = "";
		$errors = "";
		$result = "";
		$flag = 0;
		
		$first = substr(trim($data),0,1);
		
		$item = isset($arrData[0])?trim($arrData[0]) : "";
		$price = isset($arrData[1])?trim($arrData[1]):"";
		$location = isset($arrData[2])?trim($arrData[2]):"";
		$custom = isset($arrData[3])?trim($arrData[3]):"";
		
		// for comment
		
		$c = count($arrData);
		
		if($first != ';')
		{
			if( (count($arrData ) > 2) &&  ( count($arrData ) < 6 ) )  // length is OK
			{
				//echo 'in';
				if(strlen($item) < 0)
				{
					$errors[] = "The minimal value for item name is 1 char";
					$flag =1;
				}
				if(strlen($price) < 0)
				{
					$errors[] = "The minimal value for currecny is 1 char";
					$flag =1;
				}
				else
				{
					
					$priceLen =0;
					$priceLen = strlen($price);
					$sign = substr($price,0,1);
					$sign = md5($sign);
					$signs = "$";
					$countSign = 0;
					if(strcasecmp($sign , "c3e97dd6e97fb5125688c97f36720cbe")==0)
					{
						$countSign =1;
						$signs = "$";
					}
					elseif(strcasecmp($sign , "d527ca074d412d9d0ffc844872c4603c")==0)
					{
						$countSign =1;
						$signs = "£";
					}
					elseif(strcasecmp($sign , "0bcef9c45bd8a48eda1b26eb0c61c869") ==0)
					{
						$countSign =1;
						$signs = "€";
						$price = str_replace("%u20AC","€",$price);
					}
					if($priceLen == 1)
					{
						$numPrice = substr($price,0,strlen($price));						
						if(!is_numeric($numPrice) )
						{
							$flag = 1;
							$errors[] = "Non Numeric Price ";
						}
					}
					else
					{
						$numPrice = substr($price,1,strlen($price));
						if(!is_numeric($numPrice) )
						{
							$flag = 1;
							$errors[] = "Non Numeric Price ";
						}
					}
					if(!is_numeric($numPrice) )
					{
						$flag = 1;
						$errors[] = "Non Numeric Price ";
					}
				
					if($countSign == 1)
					{
						 $price = $signs . substr($price,1,strlen($price));
						
					}
					else
					{
						 $price = $signs . substr($price,0,strlen($price));
					}
	
	
				}
				if(strlen($location) < 0)
				{
					$errors[] = "The minimal value for location is 1 char";
					$flag =2;
				}
			
			}
			else
			{
				$errors[] = "length is NOTOK";
				$flag =1;
			}
		
		
		
		if( $flag == 0) 
			{
				$result = $item ."&#59; &nbsp;". urldecode($price) ."&#59; &nbsp;". trim($location) ."&#59; &nbsp;". trim($custom) ;
			}
		}	
		else
			$result = trim($data);//substr($data,1,strlen($data));
		
		return $result;//." Flag :: ".$flag." count:: ".$countSign;
		
		
	 } // end function
	
}// end funciton calss
?>
