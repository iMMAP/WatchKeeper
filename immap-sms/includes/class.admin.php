<?php
include MAIN.'/includes/include_files.php';
class Admin extends  DBConnect
{
	/*
	 * Main Header file for all Pages
	*/	
	function get_admin_header($title = "" , $js , $css, $before =array())
	{
		$out ="";
		$out_css = $this->get_css($css);
		$out_js  = $this->get_js($js);
		$out_before = $this->get_js($before);
		//$ie_css = get_top_css();
		/**/
		$this->prevent_cache_headers();
		$html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<meta name=Description content="'.getSiteDesc().'">
    <META NAME="Keywords" CONTENT="'.getSiteKey().'">
	<link rel="shortcut icon" href="'.FULL_PATH.'images/icon.ico">
	<title>'.$title.'</title>
	
	<link href="'.FULL_PATH.'admincp/css/main.css" rel="stylesheet" type="text/css" />	
	<link href="'.FULL_PATH.'admincp/css/style.css" rel="stylesheet" type="text/css" />	
	'.$out_before.'
	<script type="text/javascript" src="'.FULL_PATH.'js/lib/jquery.js"></script>
	<script type="text/javascript" src="'.FULL_PATH.'js/default.js"></script>
	<script type="text/javascript" src="'.FULL_PATH.'images/stuHover.js"></script>
	

	'.$out_css.'
	'.$out_js.'
	</head>
	<body>
	<input type="hidden" name="path" id="path" value="'.FULL_PATH.'" />
	<!-- CONTAINER-->
	<div style="background-color:#0092CD; height:100px; padding-left:20px;">
	&nbsp;
		  
		  <div style="margin:auto;">
		   <a href="#"><img src="'.FULL_PATH.'images/logo_03.jpg" border="0" /></a> 
		  </div>
		  
		
	</div>
	<div class="container">';
		return $html;
		
		
	}
	
	

	
	
		
	
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
	 * Main footer for all pages
	*/	
	function get_admin_footer()
	{
		$html = '	<!-- FOOTER -->
						<div class="footer_box">
						
						<div class="fot_up"></div>
						<div class="fot_mid">
						<div>
						  <div align="center">
							<div align="center">Copyright 2000 ©<strong> smsTexting.com</strong>.com All rights reserved.</div>
						  </div>
						</div>
						</div>
						<div class="fot_down_admin"></div>
						
						
						</div>
						<!-- END FOOTER -->
						</div>
						<!-- CONTAINER-->
						</body>
						</html>';		
		return $html;
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
	
	
	/*
	 * Top Menu For Admin Pages
	*/
	function get_admin_top_menu($link="")
	{
	 	
		
		$pagename =  basename($_SERVER['PHP_SELF']);
		
		if( $pagename == "plans.php")
			$report = "top_menu_";
		else
			$report = "";
		
		if( $pagename == "users.php" || $pagename == "edit_user.php" )
			$users = "top_menu_";
		else
			$users = "";
		if($pagename == "content.php")
			$contents = "top_menu_";
		else
			$contents = "";
		
		if($pagename == "settings.php")
			$settings = "top_menu_";
		else
			$settings = "";
			
		if( $pagename == "advertisement.php" || $pagename == "edit_advertisment.php" || $pagename == "add_advertisment.php")
			$advertisement = "top_menu_";
		else
			$advertisement = "";					
		
		if($pagename == "logout.php" )
			$logout = "top_menu_";
		else
			$logout = "";			

		
		/*<div class="login">
			<a href="'.FULL_PATH.'login">Login</a> | <a href="'.FULL_PATH.'signup">Signup</a></div>*/
			
		$html = '
				<div class="top_menu">
			<!--<div class="menu_left"></div>-->
			<div class="menu_mid_admin">';
			if(empty($report))
			  $html .= '<a href="'.FULL_PATH.'admincp/plan.php">&nbsp;Plans</a>';
			else
			 $html .= '<span class="'.$report.'">&nbsp;Plans</span>';
			
			if(empty($contents))
			  $html .= '<a href="'.FULL_PATH.'admincp/content.php" >&nbsp;Memebers</a>';
			else
			 $html .= '<span class="'.$contents.'">&nbsp;Memebers</span>';
			 
			if(empty($users))
			  $html .= '<a href="'.FULL_PATH.'admincp/users.php" >&nbsp;Keywords</a>';
			else
			 $html .= '<span class="'.$users.'">&nbsp;&nbsp;&nbsp;&nbsp;Keywords</span>';
			
			if(empty($contents))
			  $html .= '<a href="'.FULL_PATH.'admincp/content.php" >&nbsp;Greeting</a>';
			else
			 $html .= '<span class="'.$contents.'">&nbsp;Greeting </span>';

			if(empty($settings))
			  $html .= '<a href="'.FULL_PATH.'admincp/settings.php">&nbsp;Settings</a>';
			else
			 $html .= '<span class="'.$settings.'">&nbsp;&nbsp;&nbsp;&nbsp;Settings</span>';
			
			if(empty($advertisement))
			  $html .= '<a href="'.FULL_PATH.'admincp/advertisement.php" >&nbsp;Advertise';
			else
			 $html .= '<span class="'.$advertisement.'">&nbsp;Advertise</span>';
			 
			if(empty($logout))
			  $html .= '<a href="'.FULL_PATH.'admincp/logout.php" >&nbsp;&nbsp;&nbsp;&nbsp;Logout</a>';
			else
			 $html .= '<span class="'.$logout.'">&nbsp;;Logout</span>';	
		
		
		$html .='</div> ';

		return $html;
	}
	
/*	function get_admin_top_menu($link="")
	 {
	 	$pagename =  basename($_SERVER['PHP_SELF']);
		
		if($pagename == "user_edit.php" || $pagename == "users.php" || $pagename == "user_oreder.php" || $pagename == "user_view.php" || $pagename == "sms_log.php" || $pagename == "order_master.php" || $pagename == "order.php" || $pagename == "keyword.php")
			$user = "top_l";
		else
			$user = "top_link";
			
		if($pagename == "news.php" || $pagename == "news_add.php" || $pagename == "newsedit.php")
			$news = "top_l";
		else
			$news = "top_link";
		if($pagename == "promo_code.php" || $pagename == "promo_add.php" || $pagename == "promo_edit.php")
			$promo = "top_l";
		else
			$promo = "top_link";
			
		if($pagename == "signs.php" || $pagename == "signs_add.php" || $pagename == "signs_edit.php")
			$signs = "top_l";
		else
			$signs = "top_link";
			
		if($pagename == "pricing.php")
			$pricing = "top_l";
		else
			$pricing = "top_link";
			
		if($pagename == "setting" || $pagename == "settings.php")
			$setting = "top_l";
		else
			$setting = "top_link";	
			
		if($pagename == "keyword" || $pagename == "keyword.php")
			$keyword = "top_l";
		else
			$keyword = "top_link";		
			
			
		if($pagename == "logout" || $pagename == "logout.php")
			$logout = "top_l";
		else
			$logout = "top_link";	
		
		if($pagename == "content" || $pagename == "content.php" || $pagename == "faqs.php" || $pagename == "faq_add.php" || $pagename == "faq_edit.php")
			$content = "top_l";
		else
			$content = "top_link";	
		

		
		
$html = '
		<!-- HEADER -->
			<div class="admin_header" >
				
				<div class="header_logo">
					<a href="'.FULL_PATH.'index">
						<img src="'.FULL_PATH.'images/logo.gif" alt="logo" width="196" height="100" border="0" />
					</a>
				</div>
				
			  
				  <!-- LOGIN -->
				  <div class="log_in_admin" >
				  
					
				  </div>
				  <!-- END LOGIN -->
				 
			</div>
			<!-- END HEADER -->
			<!-- BUTTON -->
			<div class="button" style="padding-top: 0px;">
			<!-- MENU -->
			
			<ul id="nav">
				<li class="top"><a href="'.FULL_PATH.'admin797/users.php" class="'.$user.'"><span>Members</span></a></li>
				<li class="top"><a href="'.FULL_PATH.'admin797/content.php" class="'.$content.'"><span>Contents</span></a></li>
				<li class="top"><a href="'.FULL_PATH.'admin797/news.php" class="'.$news.'"><span>News</span></a></li>
				<li class="top"><a href="'.FULL_PATH.'admin797/promo_code.php" class="'.$promo.'"><span>Promo Code </span></a></li>
				<li class="top"><a href="'.FULL_PATH.'admin797/pricing.php" class="'.$pricing.'"><span>Pricing</span></a></li>
				<li class="top"><a href="'.FULL_PATH.'admin797/signs.php" class="'.$signs.'"><span>Signs</span></a></li>
				<li class="top"><a href="'.FULL_PATH.'admin797/settings.php" class="'.$setting.'"><span>Settings </span></a></li>	
				';	
			if(isset($_SESSION['session_admin_id']) && $_SESSION['session_admin_id'] !="")
			 {
			 	$html .= '<li class="top"><a href="'.FULL_PATH.'admin797/logout.php" class="'.$logout.'"><span>Logout </span></a></li>';
			 }	
				
$html .= '
			</ul>
			<!-- END MENU -->
			</div>
			<!-- END BUTTON -->

		';


return $html;
}
*/	
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
								jQuery("#msg").html("'.$out.'").fadeOut(5000);
								
						});
					</script>';
			
		}		
		return $m;
	}
	
	
	
	
	/*
	 * getting the showing values
	*/	
	function display_msg_nofade($msg,$dis)
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
								jQuery("#msg").html("'.$out.'");
								
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
	 * Uploading images
	*/	
	function uploading_imgs($files, $id, $name)
	{
		$dir = "../profile_img/$id/";
			if (!is_dir($dir)) {
			mkdir($dir) ;
			chmod($dir, 0777);
			}
		
		$upload = "";
			
		if($files[$name]['name'] != "")
		{
			$chk = "";
			$ext_f = 0;
			$arr = array('gif','jpg','png', 'swf', 'psd', 'bmp');
			$ext_f  = strtolower(substr($files[$name]['name'],-3));
			$chk = array_search($ext_f, $arr );
			
			// checking if the file is image file
			if($chk != "")
			{
				$file = time().$files[$name]['name'];
				$th_file = "th_".time().$files[$name]['name'];
				if(move_uploaded_file($files[$name]['tmp_name'],$dir.$file))
				{
					$creathumb_obj = new Thumbnail($dir.$file,128,128,$dir.$th_file);
					$creathumb_obj->create();
					$upload= $file;
				}// end if file upload				
				
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
	
	
	/*
	* getting the event types
	*/
	function get_city($class = "",$id="",$index=0,$pid = 0)
	{
		$age="";
		if($pid != 0)
			$sql = "Select ID, TITLE from tbl_category where PARENT_ID = '".$pid."'  order by TITLE asc";
		else
			$sql = "Select ID, TITLE from tbl_category order by TITLE asc";
		$rows = $this->RunQuery($sql);
		if(!empty($rows))
		{
			$age= '<select id="city" name="city" class="'.$class.'"   tabindex="'.$index.'" >
						<option value="">Select</option>';
			foreach($rows as $row)
			{
				if($id == $row['ID'])
					$age .= '<option value="'.$row["ID"].'" selected="selected" >'.$row["TITLE"].'</option>
					';
				else
					$age .= '<option value="'.$row["ID"].'">'.$row["TITLE"].'</option>
					';
			}
			$age .= '</select>';
		}
		return $age;
		
	}
	
	
	
	/*
	* getting the event types
	*/
	function get_state($class = "",$id="",$index=0)
	{
		$age="";
		$sql = "Select DISTINCT(stitle) ,ID from tbl_state order by title asc";
		$rows = $this->RunQuery($sql);
		if(!empty($rows))
		{
			$age= '<select id="state"  name="state" class="'.$class.'"   tabindex="'.$index.'" style="z-index:1" >
						<option value="">Select</option>';
			foreach($rows as $row)
			{
				if($id == $row['ID'])
					$age .= '<option value="'.$row["ID"].'" selected="selected" >'.$row["stitle"].'</option>
					';
				else
					$age .= '<option value="'.$row["ID"].'">'.$row["stitle"].'</option>
					';
			}
			$age .= '</select>';
		}
		return $age;
		
	}
	
	
	/*
	* getting the event types
	*/
	function get_city_name($id="")
	{
		$age="";
		$sql = "Select  TITLE from tbl_state where ID = '".$id."'";
		$rows = $this->RunQuerySingle($sql);
		if(!empty($rows))
		{
			$age = $rows['TITLE'];
		}
		return $age;
		
	}
	
	/*
	 * getting the sign size
	*/
	function get_sign_val($id="")
	{
		$val = array();
		if($id != "")
		{
			$sql = "Select * from tbl_signs where id = '".$id."'";
			$rows = $this->RunQuerySingle($sql);
			if(!empty($rows))
			{
				$val[] = $rows['size'];
				$val[] = $rows['price'];
				
			}
		}
		return $val;
	}
	
}
?>
