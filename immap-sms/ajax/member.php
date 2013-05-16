<?php
define('MAIN',realpath('../'));
include MAIN.'/includes/config.php';
include MAIN.'/includes/class.main.php';
$main = new Main();

$organization = isset($_REQUEST["organization"])?$_REQUEST["organization"]:"";
$group_id = isset($_REQUEST["group_id"])?$_REQUEST["group_id"]:"";

$group = isset($_REQUEST["group"])?$_REQUEST["group"]:"";
$subgroup_id = isset($_REQUEST["subgroup_id"])?$_REQUEST["subgroup_id"]:"";
$subgroup_id_h = isset($_REQUEST["subgroup_id_h"])?$_REQUEST["subgroup_id_h"]:"";



$act = isset($_REQUEST["act"])?$_REQUEST["act"]:"";
$rs = "";
if($act == "organization")
 {
	
	$sql = "SELECT * FROM ".TBLGROUP." WHERE `org_id` = '".$organization."'";
	//aaaaa
	$rows = $main->RunQuery($sql);
	
	if(!empty($rows))
	 {
	 	$rs .= "<select name='group' id='group' class='sign_inp' onchange='chk_SubGroup()' 	><option value=''>Select Group</option>";
		foreach($rows as $row)
		 {
			if($group_id == $row["id"])
			$rs	.= "<option value=".$row["id"]." selected='selected'>".$row["group_name"]."</option>"; 
			else
			 $rs	.= "<option value=".$row["id"]." >".$row["group_name"]."</option>"; 
		 }
		 $rs .="</select>";
		
	 }
	 
		echo $rs ;
	
 
 }
 
if($act == "group")
 {
	
	 $sql = "SELECT * FROM ".TBLSUBGROUP." WHERE `group_id` = '".$group."'";
	//aaaaa
	$rows = $main->RunQuery($sql);
	
	if(!empty($rows))
	 {
	 	$rs .= "<select name='subgroup' id='subgroup' class='sign_inp' ><option value=''>Select SubGroup</option>";
		foreach($rows as $row)
		 {
			if($subgroup_id_h == $row["id"])
			$rs	.= "<option value=".$row["id"]." selected='selected'>".$row["subgroup"]."</option>"; 
			else
			 $rs	.= "<option value=".$row["id"]." >".$row["subgroup"]."</option>"; 
		 }
		 $rs .="</select>";
		
	 }
	 
		echo $rs ;
	
 
 }




?>