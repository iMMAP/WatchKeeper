<?php
define('MAIN',realpath('../'));
include MAIN.'/includes/config.php';
include MAIN.'/includes/class.main.php';
$main = new Main();


$act = isset($_REQUEST["act"])?$_REQUEST["act"]:"";

$rss = "";
$rs = "";
$rsg = "";
if($act == "subgroupMember")
 {
	$subgroup = isset($_REQUEST["subgroup"])?$_REQUEST["subgroup"]:"";
	
	$sql = "SELECT ug.id,u.id as uid,u.fname,ug.group_id,ug.subgroup_id FROM ".TBLUSER." u inner join sms_user_group ug on u.id = ug.user_id WHERE subgroup_id = '".$subgroup."' and u.status = 1";
	//aaaaa<td><input type="checkbox" name="chk_'.$row["id"].'" id="chk_'.$row["id"].'" value="'.$row["id"].'" /></td>
	$rows = $main->RunQueryObj($sql);
	
	if(!empty($rows))
	 {
	 	$rs .= '<table width="100%" cellpadding="2" cellspacing="2"  style="padding-top:40px;">
              <tr bgcolor="#fbd4d5">
               <td class="tb_h2"><input type="checkbox" name="chkall" id="chkall" value = "1" onclick = "selectchk()" />Check all</td>
                <td class="tb_h2">Name</td>
                <td class="tb_h2">Group</td>
                <td class="tb_h2">SubGroup</td>
                </tr>';
				
		foreach($rows as $row)
		 {
			$rs .=' <tr>
                <td><input type="checkbox" name="chk[]" id="chk_'.$row->uid.'" value="'.$row->uid.'" /></td>
                <td class="tb_h3">'.$row->fname.'</td>
                <td class="tb_h3">'.getField("group_name",TBLGROUP,$row->group_id).'</td>
                <td class="tb_h3">'.getField("subgroup",TBLSUBGROUP,$row->subgroup_id).'</td>
                </tr>';
		 }
		 $rs .="</table>";
		
	 }
	 
		echo $rs ;
 }


if($act == "groupMember")
 {
	$group = isset($_REQUEST["group"])?$_REQUEST["group"]:"";
	 $sql = "SELECT ug.id,u.id as uid,u.fname,ug.group_id,ug.subgroup_id FROM ".TBLUSER." u inner join sms_user_group ug on u.id = ug.user_id WHERE ug.group_id = '".$group."' and u.status = 1";
	//aaaaa
	$rows = $main->RunQueryObj($sql);
	
	if(!empty($rows))
	 {
	 	$rs .= '<table width="100%" cellpadding="2" cellspacing="2"  style="padding-top:40px;">
              <tr bgcolor="#fbd4d5">
                <td class="tb_h2"><input type="checkbox" name="chkall" id="chkall" value = "1" onclick = "selectchk()" />Check all</td>
                <td class="tb_h2">Name</td>
                <td class="tb_h2">Group</td>
                <td class="tb_h2">SubGroup</td>
                </tr>';
				
		foreach($rows as $row)
		 {
			$rs .=' <tr>
                <td><input type="checkbox" name="chk[]" id="chk_'.$row->uid.'"  value="'.$row->uid.'"  /></td>
                <td class="tb_h3">'.$row->fname.'</td>
                <td class="tb_h3">'.getField("group_name",TBLGROUP,$row->group_id).'</td>
                <td class="tb_h3">'.getField("subgroup",TBLSUBGROUP,$row->subgroup_id).'</td>
                </tr>';
		 }
		 $rs .="</table>";
		
	 }
	 
		echo $rs ;
	
 
 }

if($act == "subgroup")
 {
	$group = isset($_REQUEST["group"])?$_REQUEST["group"]:"";
	 $sql = "SELECT * FROM ".TBLSUBGROUP." WHERE group_id = '".$group."'";
	//aaaaa
	$rows = $main->RunQuery($sql);
	
	if(!empty($rows))
	 {
	 	$rsg .= "<select name='subgroup' id='subgroup' class='sign_inp' onchange='subgroupchg()' ><option value=''>Select SubGroup</option>";
		foreach($rows as $row)
		 {
			
			 $rsg	.= "<option value=".$row["id"]." >".$row["subgroup"]."</option>"; 
		 }
		 $rsg .="</select>";
		
	 }
	 
		echo $rsg ;
	
 
 }

?>