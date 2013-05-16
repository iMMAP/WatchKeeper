<?php
include MAIN.'/includes/include_files.php';
class Main extends  DBConnect
{
	/*
	 * Main Header file for all Pages
	*/	
	function get_header($title = "" , $js , $css, $before =array())
	{
		$out ="";
		$out_css = $this->get_css($css);
		$out_js  = $this->get_js($js);
		$out_before = $this->get_js($before);
		/**/
		$this->prevent_cache_headers();
	
		$html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<meta name=Description content="'.getSiteDesc().'">
    <META NAME="Keywords" CONTENT="'.getSiteKey().'">
	
	
	<title>'.$title.'</title>
	<link href="'.FULL_PATH.'css/main.css" rel="stylesheet" type="text/css" />	
	<link href="'.FULL_PATH.'css/style.css" rel="stylesheet" type="text/css" />	
	
	'.$out_before.'
	<script type="text/javascript" src="'.FULL_PATH.'js/lib/jquery.js"></script>
	<script type="text/javascript" src="'.FULL_PATH.'js/default.js"></script>
	'.$out_css.'
	'.$out_js.'
	</head>
	<body>
	<center>
	<div class="outer_div">
	 <input type="hidden" name="path" id="path" value="'.FULL_PATH.'" />
	 <div class="header">
	  <div class="logo_">
	   <a href="'.FULL_PATH.'"><img src="'.FULL_PATH.'images/logo_03.jpg" border="0" /></a>
	  </div>
	 
		<div class="search_div_h">
		
		<input type="text" value="" name="search_title" id="search_title" class="search_div_h_text" /> 
		 
		<input type="submit" class="top_search_btn" value="" name="btn_search_title" id="btn_search_title" style="cursor:pointer;" />
		
		</div>
		
		</div> <!-- header -->
		<div class="content_outer">
	';
		return $html;
	}
	
	
	
	/*
	 * Top menu for all Pages
	*/	
	function get_top_menu($link="")
	{
		$pagename =  basename($_SERVER['PHP_SELF']);
		
		if($pagename == "index" || $pagename == "index.php")
			$index = "top_menu_";
		else
			$index = "";
		if($pagename == "recent" || $pagename == "recent.php")
			$recent = "top_menu_";
		else
			$recent = "";
		if($pagename == "popular" || $pagename == "popular.php")
			$popular = "top_menu_";
		else
			$popular = "";
		if($pagename == "anonymous" || $pagename == "anonymous.php")
			$anonymous = "top_menu_";
		else
			$anonymous = "";
		
		if($pagename == "login" || $pagename == "login.php")
			$login = "top_menu_";
		else
			$login = "";
		if($pagename == "signup" || $pagename == "signup.php")
			$signup = "top_menu_";
		else
			$signup = "";					
		
		if($pagename == "profile" || $pagename == "profile.php" || $pagename == "settings" || $pagename == "settings.php" )
			$profile = "top_menu_";
		else
			$profile = "";			

		
		/*<div class="login">
			<a href="'.FULL_PATH.'login">Login</a> | <a href="'.FULL_PATH.'signup">Signup</a></div>if(empty($anonymous))
			  $html .= '<a href="'.FULL_PATH.'anonymous">Anonymous</a>';
			else
			 $html .= '<span class="'.$anonymous.'">Anonymous</span>';*/
			
		$html = '
				<div class="top_menu">
			<!--<div class="menu_left"></div>-->
			<div class="menu_mid">';
			if(empty($index))
			  $html .= '<a href="'.FULL_PATH.'index">Home</a>';
			else
			 $html .= '<span class="'.$index.'">Home</span>';
			
			if(empty($recent))
			  $html .= '<a href="'.FULL_PATH.'recent">Recent</a>';
			else
			 $html .= '<span class="'.$recent.'">Recent</span>';
			
			if(empty($popular))
			  $html .= '<a href="'.FULL_PATH.'popular">Popular</a>';
			else
			 $html .= '<span class="'.$popular.'">Popular</span>';
			 
			
				   
			 
		
		$html .='</div> <!-- menu_mid -->
			
			<div class="login">';
			
		if(isset($_SESSION['session_email']) and $_SESSION['session_email'] != "")
		  {
			 $html .='<a href="'.FULL_PATH.'logout">Logout</a>';
			 $html .= '|';
			 if(empty($profile))
			  $html .= '<a href="'.FULL_PATH.'user/profile">My Profile</a>';
			 else
			  $html .= '<a href="'.FULL_PATH.'user/profile"><strong>My Profile</strong></a>';
		 }
		else
		 {
		 	if(empty($login))
			  $html .= '<a href="'.FULL_PATH.'login">Login</a>';
			else
			  $html .= '<a href="'.FULL_PATH.'login"><strong>Login</strong></a>';
			$html .= '|';
			if(empty($signup))
			  $html .= '<a href="'.FULL_PATH.'signup">Signup</a>';
			else
			 $html .= '<a href="'.FULL_PATH.'signup"><strong>Signup</strong></a>';
			
			 
				
			//$html .='<a href="'.FULL_PATH.'signup">Signup</a><a href="'.FULL_PATH.'login">Login</a>'; 
		 }
			
			
			
		$html .= '	</div>
			<div class="menu_right"></div>
			<div class="content">';
		return $html;
	}
	
	/*
	 * Main footer for all pages
	*/	
	function get_footer()
	{
		$html = '
		<div class="footer">
			
				<div class="footer_left"></div>
				<div class="footer_mid">
				<ul>
					<li><a href="'. FULL_PATH .'aboutus">About Us</a></li>
					<li><a href="'. FULL_PATH .'faq">F.A.Q</a></li>
					<li><a href="'. FULL_PATH .'advertise">Advertise With Us</a></li>
					<li><a href="'. FULL_PATH .'contactus">Contact Us</a></li>
			   </ul>	
			   <ul>	
				    <li><a href="'. FULL_PATH .'term">Terms of Use</a></li>
					<li><a href="'. FULL_PATH .'feedback">Feedback</a></li>
					<li><a href="'. FULL_PATH .'help">Get Help</a></li>
					<li><a href="'. FULL_PATH .'abuse">Report Abuse </a></li>

				</ul>
				<ul>
				    <li>
					    <a href="'.getfield("twitter_url","tbl_admin",1).'" target="_blank">Twitter</a>
					</li>
                    <li>
					  	<a href="'.getfield("facebook_url","tbl_admin",1).'" target="_blank">Facebook Fan Page</a>
					</li> 
				</ul>
				<ul>
					<li><a href="'. FULL_PATH .'signup">Sign up</a></li>
					<li><a href="'. FULL_PATH .'login">Log in</a></li>
				</ul>
				</div>
				
				<div class="footer_right"></div>
			
			</div> <!-- footer -->
			</div> <!-- content -->
			
		</div> <!-- content_outer -->
		</div>
	   </center>	
		<br />						
		<script type="text/javascript">
		var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
		document.write(unescape("%3Cscript src=\'" + gaJsHost + "google-analytics.com/ga.js\' type=\'text/javascript\'%3E%3C/script%3E"));
		</script>
		<script type="text/javascript">
		try {
		var pageTracker = _gat._getTracker("UA-10167792-1");
		pageTracker._trackPageview();
		} catch(err) {}</script>
				</body>
			   </html>';		
		return $html;
	}
	/*
	 * Main Right Protion for all pages
	*/	
/*	function get_right_top($name, $image, $uid='')
	{
		$html = '<div class="right_content"><div class="member_div" style="width:300px; padding-left:25px; border:solid 1px #dfdfdf; margin-top:10px;">
					<table cellpadding="5" cellspacing="0" width="100%">
				  <tr>
					<td>
				
				<a href="'.FULL_PATH.'users/'. $uid .'"><strong>'.$name.'</strong></a>				
				
			</td>
			<td rowspan="4" align="right">';	
				if(!empty($image))
				 {
				 $html .= '<img  class="img_bdr" src="'.FULL_PATH.'profile_img/'.$_SESSION['session_userid'].'/sth_'.$image.'"/>';
				 }
				else
				 {
				$html .= '<img  class="img_bdr" src="'.FULL_PATH.'images/default_profile_normal.png"/></a>';
				 }
				 
				$html .= ' </td>
				  </tr>
				  <tr>
					<td><a href="'.FULL_PATH.'user/profile">Profile</a></td>
					</tr>
				  <tr>
					<td><a href="'.FULL_PATH.'user/settings">Settings</a></td>
					</tr>
				  </table>
		</div></div><div>&nbsp;</div>';

	return $html;
	}*/
	function get_right_top($name, $image, $uid)
	{
	 	$pagename =  basename($_SERVER['PHP_SELF']);
		$pagedir =  basename(dirname($_SERVER['PHP_SELF']));
		$user_id = $uid;

		$session_userid = isset($_SESSION['session_userid'])?$_SESSION['session_userid']:"";
		
		$uid = isset($_SESSION['session_userid'])?$_SESSION['session_userid']:$uid;
		
		$functions = new Functions();	
		$html = '<div class="right_content"><div class="member_div" style="width:300px; padding-left:5px; border:solid 1px #dfdfdf; margin-top:10px;">
					<table cellpadding="5" cellspacing="0" width="100%">
				  <tr>';
					$html .= '	<td rowspan="4" align="left" valign="top">';
				if($pagedir == "user")
				  $chk_im = '../profile_img/'.$user_id.'/sth_'.$image;
				else
				  $chk_im = 'profile_img/'.$user_id.'/sth_'.$image;
				if(file_exists($chk_im))
				 {
				 $html .= '<img  class="img_bdr" src="'.FULL_PATH.'profile_img/'.$user_id.'/sth_'.$image.'"/>';
				 }
				else
				 {
				$html .= '<img  class="img_bdr" src="'.FULL_PATH.'images/default_profile_normal.png"/></a>';
				 }
				$html .= ' </td>';
					$html .= '<td  align="left">';
					if(empty($session_userid) || $user_id == $session_userid)
						$html .= '<a href="'.FULL_PATH.'users/'.$uid.'"><strong>'.$name.'</strong></a>';
					else
					    $html .= '<a href="'.FULL_PATH.'users/'.$user_id.'"><strong>'.$name.'</strong></a>';
						
					 $html .= '</td>';
					
					
				
				$html .= '  </tr>';
				  
				if(!empty($session_userid) && $user_id == $session_userid)
				 {
					$html .= '<tr>
					<td align="left"><a href="'.FULL_PATH.'user/settings">Settings</a></td>
				   </tr>';
				  
				  $html .= '<tr>
					<td align="left"><a href="'.FULL_PATH.$uid.'/following">Following</a></td>
				   </tr>
				  <tr>
					<td align="left"><a href="'.FULL_PATH.$uid.'/followers">Followers</a></td>
				  </tr>';
				 }
				else
				 {
				 
				  $html .= '<tr>
					<td align="left"><a href="'.FULL_PATH.$user_id.'/following">Following</a></td>
				   </tr>
				  <tr>
					<td align="left"><a href="'.FULL_PATH.$user_id.'/followers">Followers</a></td>
				  </tr>';
				 }
				  if($pagename ==  "user.php" || $pagename ==  "users")
				   {				  
				 $html .= ' <tr>
					<td align="left">
					
					<form name="status_frm" id="status_frm" action="" method="post">
					 <input name="user_id" id="user_id" type="hidden" value="'.$user_id.'"  />';
					 if(isset($_SESSION['session_userid']) and $_SESSION['session_userid'] != "" and $_SESSION['session_userid'] !=$user_id)
			 		  {
						$track = '<input name="track" id="track" value="Follow" type="submit" class="button_small" />';
						$ret = $functions->get_tracking($_SESSION['session_userid'],$user_id);
						if($ret == true)
						 {
						  $track = '<input name="untrack" id="untrack" value="Un Follow" type="submit" class="button_small" />';
						 }	
						 $html .= $track;			
						//$block_arr = $functions->get_info_tracking($_SESSION['session_userid'],$usr_id);
					   }
					$html .= '</form></td>
				  </tr>';
				  }
				 
				 $html .= ' </table>
		</div></div><div>&nbsp;</div>';

	return $html;
	}
	
	/*
	 * Main Right Protion for all pages
	*/	
	function get_right()
	{
		$html = '<div class="right_content">
					<div class="right_1">
						<div class="right_1_top"></div>
						<div class="right_1_mid">
						<!--<img src="'.FULL_PATH.'images/right_top_img_03.jpg" border="0" /> -->
						
						'.getGoogleAds(1).'
						
						</div> <!-- right_1_mid -->
						<div class="right_1_bottom"></div>
					
					</div> <!-- right_1 -->
					
					<div class="follow">
					<div class="follow_text"><strong>Follow Us</strong> on</div>
					<a href="'.getfield("facebook_url","tbl_admin",1).'" target="_blank"><img src="'.FULL_PATH.'images/facebook_06.jpg" border="0" /></a><a href="'.getfield("twitter_url","tbl_admin",1).'" target="_blank"><img src="'.FULL_PATH.'images/tweeter_03.jpg" border="0"  /></a>
					
					
					</div> <!-- follow -->';
				//////////////////////////////////////////////
					$main = new Main();
					//$strSQL = "SELECT u.id, u.full_name, u.profile_img, t.id as tic_id, t.title, t.create_time FROM tbl_user u, tbl_ticked t, tbl_rate r WHERE u.id = t.user_id AND t.id = r.ticked_id ORDER BY r.rating DESC LIMIT 4";
					//$strSQL = "SELECT * FROM tbl_ticked 
						//		GROUP BY user_id
						//		ORDER BY r.rating DESC LIMIT 4";			
					$strSQL = "SELECT MAX( rating ) , user_id, id, create_time, title
								FROM tbl_ticked
								GROUP BY user_id
								ORDER BY rating DESC";		
					$rows = $main->RunQuery( $strSQL );
					
					
				//////////////////////////////////////////////
					
			$html .= '<div class="right_2">
					<h3> Top Rated Members</h3>';
			foreach( $rows as $row ) 
			{		
			$img = getField('profile_img', 'tbl_user' , $row['user_id'] );
			$name = getField('full_name', 'tbl_user' , $row['user_id'] );
			
			$html .= '<div class="member_div">
					<div class="members_pic">
					<a href="'.FULL_PATH.'users/'.$row["user_id"] .'" />';
					
					
					 if(file_exists('profile_img/'.$row["user_id"].'/sth_'.$img))
						 $html .= '	<img class="img_bdr" src="'.FULL_PATH.'profile_img/'.$row["user_id"].'/sth_'.$img.'">';
						 else if(file_exists('../profile_img/'.$row["user_id"].'/sth_'.$img))
						 $html .= '	<img class="img_bdr" src="'.FULL_PATH.'profile_img/'.$row["user_id"].'/sth_'.$img.'">';
						 else						
						 $html .= '	<img class="img_bdr" src="'.FULL_PATH.'images/default_profile_normal.png">';
					
					
					
					
					$html .= '</a>
					</div>
					<div class="members_text">
					<a href="'.FULL_PATH .'users/'. $row["user_id"] .'" />' . $name .'</a>
					
					<span class="date2">'. date_diff($row["create_time"]) .'</span><br />
					
					<a href="'.FULL_PATH .'message/'. $row["id"].'" />' .substr($row["title"], 0 , 65);
					
						if( strlen( $row['title'] ) > 65 )
						{
							$html .= ' . . . ';
						}
						
		$html .= '</a></div> <!-- memb_text --><div class="hr_"></div>
					</div> <!-- member_div --><br />';

			}
			
			
			
	
			
			 $sql_img = "SELECT img_name,id,title from tbl_ticked where img_name != ''  ORDER BY id DESC LIMIT 10";
			$rows_img = $main->RunQuery($sql_img);
		   
		   /**/
		   $html .= '</div> <!-- right_2 -->';
					
			if(!empty($rows_img))
			 {		
			 $html .= '		<div class="right_2">
					<h3 style="width:auto !important;">Recent Photos</h3>
					<div class="nev_btns"> 
					<div class="module photo_ticked clearfix">
						<div class="module_nav">
							<button class="prev">
														
							</button>
							<button class="next">
							
							</button>
						</div>		
					</div>
					</div> <!-- nav_btn -->
					<div class="photo">
					<div style="overflow: hidden; visibility: visible; position: relative; z-index: 2; left: 0px; width: 432px;" class="photo_info">
	<ul style="margin: 0pt; padding: 0pt; position: relative; list-style-type: none; z-index: 1; width: 2304px; left: -1440px;" class="photos">
					';
						foreach( $rows_img as $row_img ) 
						 {	
						
					     $html .= '<li style="overflow: hidden; float: left; width: 120px; height: 100px;" class="photo">
						<a href="'.FULL_PATH.'message/'.$row_img['id'].'" title="'.$row_img['title'].'">';
							
						 if(file_exists('ticked_images/'.$row_img["id"].'/sth_'.$row_img["img_name"]))
						 $html .= '	<img class="img_bdr" src="'.FULL_PATH.'ticked_images/'.$row_img["id"].'/sth_'.$row_img["img_name"].'">';
						 else if(file_exists('../ticked_images/'.$row_img["id"].'/sth_'.$row_img["img_name"]))
						 $html .= '	<img class="img_bdr" src="'.FULL_PATH.'ticked_images/'.$row_img["id"].'/sth_'.$row_img["img_name"].'">';
						 else						
						 $html .= '	<img class="img_bdr" src="'.FULL_PATH.'images/image_not_found.jpg">
						</a>';
						
						 $html .= '<span style="text-align:center;  width: 100px">
						 <a href="'.FULL_PATH.'message/'.$row_img['id'].'" title="'.$row_img["title"].'">'.$row_img["title"].'</a>
						</span>
					   </li>';

						 }
					
					
			$html .= '</ul>
</div></div> <!-- photo -->
					</div> <!-- right_2<3> -->	';
				}	
				$sql_img = "SELECT yimg_name,id,title from tbl_ticked where videos_name != ''  ORDER BY id DESC LIMIT 10";
				$rows_img = $main->RunQuery($sql_img);
				if(!empty($rows_img))
			 	 {			
					
			$html .= '		<div class="right_2">
					<h3 style="width:auto !important;">Recent Videos</h3>
					<div class="nev_btns">
					<div class="module photo_ticked clearfix">
						<div class="module_nav">
							<button class="prev">
														
							</button>
							<button class="next">
							
							</button>
						</div>		
					</div>
					</div> <!-- nav_btn -->
					
					<div class="photo">
					<div style="overflow: hidden; visibility: visible; position: relative; z-index: 2; left: 0px; width: 432px;" class="photo_info">
	<ul style="margin: 0pt; padding: 0pt; position: relative; list-style-type: none; z-index: 1; width: 2304px; left: -1440px;" class="photos">
					';
						foreach( $rows_img as $row_img ) 
						 {	
						
						
						
					      $html .= '<li style="overflow: hidden; float: left; width: 120px; height: 100px;" class="photo">
						<a href="'.FULL_PATH.'message/'.$row_img['id'].'" title="'.$row_img['title'].'">';
							
						 if(file_exists('ticked_images/'.$row_img["id"].'/vsth_'.$row_img["yimg_name"]))
						 $html .= '	<img class="img_bdr" src="'.FULL_PATH.'ticked_images/'.$row_img["id"].'/vsth_'.$row_img["yimg_name"].'">';
						 else if(file_exists('../ticked_images/'.$row_img["id"].'/vsth_'.$row_img["yimg_name"]))
						 $html .= '	<img class="img_bdr" src="'.FULL_PATH.'ticked_images/'.$row_img["id"].'/svth_'.$row_img["yimg_name"].'">';
						 else						
						 $html .= '	<img class="img_bdr" src="'.FULL_PATH.'images/image_not_found.jpg">
						</a>';
						
						 $html .= '<span style="text-align:center;  width: 100px">
						 <a href="'.FULL_PATH.'message/'.$row_img['id'].'" title="'.$row_img["title"].'">'.$row_img["title"].'</a>
						</span>
					   </li>';

						 }
					
					
			$html .= '</ul>
</div>

					</div> <!-- photo -->
					</div> <!-- right_2<4> -->	
				';
				}			
					
					
			$html .= '</div> <!-- right_content -->
			<br clear="all" />
			';
			
		
			
		return $html;
	}

	/*
	 * Main New Right Protion for all pages
	*/
	
	
	/*
	 * getting css files
	*/	
	function get_css($css)
	{
		$out="";
		if(!empty($css))
		{
			foreach($css as $c)
			{
				$out.='<link rel="stylesheet"  href="'.FULL_PATH.$c.'"type="text/css" />
				';
			}
		}
		return $out;
	}
	
	
	/*
	 * getting js files
	*/	
	function get_js($js)
	{
		$out="";
		if(!empty($js))
		{
			foreach($js as $j)
			{
				$out.='<script type="text/javascript" src="'.FULL_PATH.$j.'"></script>
				';
			}
		}
		return $out;
	}
	
	
	
	
	
	
	
	
	
	
	
	/*
	 * Prevent caching of pages. When the Javascript needs to refresh a page,
	 * it wants to actually refresh it, so we want to prevent the browser from
	 * caching them.
	 */
	function prevent_cache_headers() {
	  header('Cache-Control: private, no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
	  header('Pragma: no-cache');
	}
	
	
	
	
	

	
	//<div class="fot_down_last"></div><br />


	
	/*
	 * Parsing values
	*/	
	function parse_http_args($post = "")
	{
		$post_val = array();
		if($post_val != "")
		{
			foreach($post as $k=>$p)
				$post_val[$k] = $p;
		}
		return $post_val;
	}
	
	
	
	
	/*
	 * Inserting values into database
	 Prarameter 
	 	$tbl = db table name
		$arr = array containing the db fields name and values to insert
	 	$msg = array containg success message at 0 index
				and non-success message at 1 index
	
	return 
		return array
			0 index - containing message
			1 index - containing true or false
			2 index - retrun the id of the inserted row from db		
	*/	
	function insert_tbl($tbl = "" , $arr = array(), $msg = array())
	{
		$msg_val = array();
		if(!empty($arr) and !empty($tbl))
		{
			$id = $this->Insert($tbl, $arr);
			if($id)
			{	
				if($msg[0] == "")
					$msg_val[0] = "Successfully Uploaded";
				else
					$msg_val[0] = $msg[0];
				$msg_val[1] = true;
				$msg_val[2] = $id;
			}
			else
			{	
				if($msg[0] == "")
					$msg_val[0] = "Not Successfully Uploaded";
				else
					$msg_val[0] = $msg[0];
				$msg_val[1] = false;
			}
		}		
		return $msg_val;
	}
	
	
	
	
	/*
	 * update table in the  database
	*/	
	function update_tbl($tbl = "" , $where,  $arr = array(), $msg = array())
	{
		$msg_val = array();
		if(!empty($arr) and !empty($tbl))
		{
			$id = $this->UpdateRec($tbl ,$where , $arr);
			if($id)
			{	
				if($msg[0] == "")
					$msg_val[0] = "Successfully Uploaded";
				else
					$msg_val[0] = $msg[0];
				$msg_val[1] = true;
			}
			else
			{	
				if($msg[0] == "")
					$msg_val[0] = "Not Successfully Uploaded";
				else
					$msg_val[0] = $msg[0];
				$msg_val[1] = false;
			}
		}		
		return $msg_val;
	}
	
	
	
	/*
	 * update table in the  database
	*/	
	function update_tbl_all($tbl = "" , $where,  $arr = array(), $msg = array())
	{
		$msg_val = array();
		if(!empty($arr) and !empty($tbl))
		{
			$id = $this->UpdateRec_all($tbl ,$where , $arr);
			if($id)
			{	
				if($msg[0] == "")
					$msg_val[0] = "Successfully Uploaded";
				else
					$msg_val[0] = $msg[0];
				$msg_val[1] = true;
			}
			else
			{	
				if($msg[0] == "")
					$msg_val[0] = "Not Successfully Uploaded";
				else
					$msg_val[0] = $msg[0];
				$msg_val[1] = false;
			}
		}		
		return $msg_val;
	}
	
	

	
	
	/*
	 * getting the showing values
	*/	
	function show_msg($msg = array())
	{
		$m = "";
		if(!empty($msg))
		{
			
			if($msg[1] == true)
				$dis =  "<div class='dis_msg'>".$msg[0]."</div>";
			else
				$dis = "<div class='dis_error'>".$msg[0]."</div>";
			
			
			$m = '<script type="text/javascript">
							jQuery(function(){
								jQuery("#msg").html("'.$dis.'").fadeOut(5000);
								
						});
					</script>';
			
			
		}		
		return $m;
	}

function display_msg_ticked($msg,$dis)
	{
		$m = "";
		if(!empty($msg))
		{
		
			if($dis == true)
			 {
			 $m = '<script type="text/javascript">
							jQuery(function(){
								jQuery("#success").show().html("'.$msg.'").fadeOut(5000);
								
						});
					</script>';
			 }				
			else
			 {			
				$m = '<script type="text/javascript">
							jQuery(function(){
								jQuery("#err").show().html("'.$msg.'").fadeOut(5000);
								
						});
					</script>';
			 }

			
		}		
		return $m;
	}


	/*
	 * getting the showing values
	*/	
	function display_msg($msg,$dis)
	{
		$m = "";
		if(!empty($msg))
		{
		
			if($dis == true)
				$out =  "<div class='dis_msg'>".$msg."</div>";
			else
				$out = "<div class='dis_error'>".$msg."</div>";
		
			
			$m = '<script type="text/javascript">
							jQuery(function(){
								jQuery("#msg").show().html("'.$out.'").fadeOut(5000);
								
						});
					</script>';

			
		}		
		return $m;
	}

	function display_msg2($msg,$dis,$tid)
	{
		$m = "";
		if(!empty($msg))
		{
		
			if($dis == true)
				$out =  "<div class='error'>".$msg."</div>";
			else
				$out = "<div class='error'>".$msg."</div>";
		
			
			$m = '<script type="text/javascript">
		
							jQuery(function(){
								jQuery("#msg'.$tid.'").show().html("'.$out.'").fadeOut(5000);
								
						});
					</script>';

			
		}		
		return $m;
	}

	
	/*
	 * getting the showing values or ajax
	*/	
	function return_msg($msg,$dis)
	{
		$out = "";
		if(!empty($msg))
		{
			if($dis == true)
				$out =  "<div class='dis_msg'>".$msg."</div>";
			else
				$out = "<div class='dis_error'>".$msg."</div>";
		}		
		return $out;
	}




	
	/*
	 * Sending email
	*/	
	function send_email($to="",$from="", $subject="", $body)
	{
		$mail = "";
		if($to != "")
		{
			$headers  = "MIME-Version: 1.0\r\n";
			$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
			$headers .= "To: ".$to." <".$to.">\r\n";
			$headers .= "From: ".$from." <".$from.">\r\n";
			//if(mail($to, $subject, nl2br($body), $headers))
				//$mail = true;
			//else
				$mail = false;
		}
		return $mail;
	}
	
	
	
	/*
	 * Uploading images
	*/	
	function uploading_imgs($files ="", $id="", $name="")
	{
		if($name == "img")
			$dir = "../profile_img/$id/";
		else if(empty($id))	
		  $dir = "temp_images/";
		else
		  $dir = "ticked_images/$id/";


			if (!is_dir($dir)) {
				mkdir($dir);
				chmod($dir, 0777);
			}
			
			
			
		
		$upload = "";
			
		if($files[$name]['name'] != "")
		{
			$chk = "";
			$ext_f = 0;
			$arr = array('swf','gif','jpg','jpeg','png', 'swf', 'psd', 'bmp');
			$ext_f  = strtolower(substr($files[$name]['name'],-3));
			$chk = array_search($ext_f, $arr );
			
			// checking if the file is image file
			if($chk != "")
			{

				if($name == "img")
				 {
					$file = time().$files[$name]['name'];
					$th_file = "th_".$file;
					$sth_file = "sth_".$file;
					$mth_file = "mth_".$file;
					
					if(move_uploaded_file($files[$name]['tmp_name'],$dir.$file))
					{
						$creathumb_obj = new Thumbnail($dir.$file,128,128,$dir.$th_file);
						$creathumb_obj->create();
						
						$creathumb_obj = new Thumbnail($dir.$file,55,55,$dir.$sth_file);
						$creathumb_obj->create();
						
						$creathumb_obj = new Thumbnail($dir.$file,75,75,$dir.$mth_file);
						$creathumb_obj->create();
						$upload= $file;
					}// end if file upload				
				}
			   else
				{
					
					$file = time().$files[$name]['name'];
					$th_file = "th_".$file;
					$sth_file = "sth_".$file;
					$mth_file = "pr_".$file;
					
					
					if(move_uploaded_file($files[$name]['tmp_name'],$dir.$file))
					{
						
						$creathumb_obj = new Thumbnail($dir.$file,140,120,$dir.$th_file);
						$creathumb_obj->create();
						
						$creathumb_obj = new Thumbnail($dir.$file,100,70,$dir.$sth_file);
						$creathumb_obj->create();
						
						$creathumb_obj = new Thumbnail($dir.$file,400,300,$dir.$mth_file);
						$creathumb_obj->create();
						$upload= $file;
					}// end if file upload				
				   
				 
				}
				
			}
			else
			{
				$upload= "";
			}
		}// end if $_FILES	
		else
			$upload = "";
		return $upload;
	}
	
	
	
	/*
	 * checking server side
	*/
	function get_error_box($arr)
	{
		$chk = 1;
		$html='<br /><div class="error_box">
				<div class="error_head">Please Try Again</div>';
		foreach($arr as $k=>$v)
		{
			if($v == "")
			{
				$html .= '<li class="error_body"><strong>'.$k.' </strong>con\'t be blank.</li>';
				$chk++;
			}
		}	
		$html .="</div>";
		
		if($chk == 1)
			return $chk;
		else
			return $html;
	}


	
	
	
	
	
}
?>
