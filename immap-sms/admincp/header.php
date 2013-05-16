<script language="JavaScript">
<!--
function mmLoadMenus() {


} // mmLoadMenus()
//-->
</script>
<script language="JavaScript" src="js/mm_menu.js"></script>
<script language="JavaScript1.2">mmLoadMenus();</script>

<?php

				 
$page = basename($_SERVER['PHP_SELF']);

if ( $page == "admin_members.php" || $page == "add_admin_member.php" || $page == "edit_admin_member.php")  
{
?>
<a href="#" class="menu_active" name="members" id="members" ><strong class="menu_txt">Admin Member</strong></a>
<?php
}
else{
?>
<a href="admin_members.php" name="objects" id="objects"  >Admin Member</a>
<?php

}

if ( $page == "organization.php" || $page == "add_organization.php" || $page == "edit_organization.php")  
{
?>
<a href="#" class="menu_active" name="members" id="members" ><strong class="menu_txt">Organization</strong></a>
<?php
}
else{
?>
<a href="organization.php" name="objects" id="objects"  >Organization</a>
<?php

}
if ($page == "country.php" || $page == "add_country.php" || $page == "edit_country.php"){
?>
<a href="#" name="country" class="menu_active" ><strong class="menu_txt">Country</strong></a>
<?php
}
else{
?>
<a href="country.php" >Country</a>
<?php
}
if ( $page == "groups.php" || $page == "edit_groups.php" || $page == "edit_greeting.php" || $page == "add_group.php" || $page == "group_members.php" || $page == "add_members.php")  
{
?>
<a href="#" class="menu_active" name="greeting" id="greeting" ><strong class="menu_txt">Groups</strong></a>
<?php
}
else{
?>
<a href="groups.php" name="greeting" id="greeting"  >Groups</a>
<?php
}
if ($page == "subgroups.php" || $page == "add_subgroup.php"  || $page == "edit_subgroups.php"  || $page == "subgroup_members.php"  || $page == "add_Submembers.php"){
?>

<a href="#" name="plans" class="menu_active" ><strong class="menu_txt">Sub Groups</strong></a>
<?php
}
else{
?>
<a href="subgroups.php" >Sub Groups</a>
<?php
	}





if ( $page == "members.php" ||  $page == "edit_members.php") 
{
?>
<a href="#" class="menu_active" name="members" id="members" ><strong class="menu_txt">Members</strong></a>
<?php
}
else{
?>
<a href="members.php" name="members" id="members"  >Members</a>
<?php

}

if ( $page == "message.php" ) 
{
?>
<a href="#" class="menu_active" name="members" id="members" ><strong class="menu_txt">Message</strong></a>
<?php
}
else{
?>
<a href="message.php" name="members" id="members"  >Message</a>
<?php

}

if ( $page == "reports.php" ||  $page == "view_reports.php" ) 
{
?>
<a href="#" class="menu_active" name="members" id="members" ><strong class="menu_txt">Reports</strong></a>
<?php
}
else{
?>
<a href="reports.php" name="members" id="members"  >Reports</a>
<?php

}

if ( $page == "settings.php" ) 
{
?>
<a href="#" class="menu_active" name="settings" id="settings" ><strong class="menu_txt">Settings</strong></a>
<?php
}
else{
?>
<a href="settings.php" name="settings" id="settings"  >Settings</a>
<?php

}

?>
<a href="logout.php" >Logout</a>