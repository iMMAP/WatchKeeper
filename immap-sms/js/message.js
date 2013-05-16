// JavaScript Document
function selectchk(){
  var val = jQuery("#chkall").val();
  
  if(val == 1)
   {
	   jQuery('input[id*="chk_"]').attr("checked","checked")
	   jQuery("#chkall").val(2);
   }
  else
   {
	    jQuery('input[id*="chk_"]').removeAttr('checked')
		jQuery("#chkall").val(1);
   }
 }
function subgroupchg()
 {
	   var id = jQuery("#subgroup").val();
	   var path = jQuery('#path').val()+"ajax/message.php";
	   var param = "subgroup="+id+"&act=subgroupMember";
	  
	if(id)
	{
	jQuery.ajax({
				type: 	'POST',
				data: 	param,
				url:	path,
				success:function(msg){
					
						
						if(msg == "")
						 { 
							jQuery("#memb").html("SubGroup hasn't any Member");							
						 }
						else
						 {
							
							jQuery("#memb").html(msg);		
							
						 }
						
						
					}
				}) 
	}
	else
	{
		chk_SubGroup();	
    }
 }
/// textfield count functions max 160 char
 

function imposeMaxLength(Object, MaxLen)

{

  return (Object.value.length <= (MaxLen));

}

// to display the text areas length 

function len_display(Object,MaxLen){

    var len_remain = MaxLen-Object.value.length;

    if(len_remain >=0)

	{

    	document.getElementById("chars_left").value=len_remain;

	}

}

function chk_SubGroup(){
	 
	
	 
	
	
	
	 var group = jQuery("#group").val();	
	
	 var path = jQuery('#path').val()+"ajax/message.php";
	  
	   var param = "group="+group+"&act=groupMember";
	
	
	 
	if(group)
	 {
	 
	jQuery.ajax({
				type: 	'POST',
				data: 	param,
				url:	path,
				success:function(msg){
					
					
						if(msg == "")
						 { 
							
							jQuery("#memb").html("Group hasn't any subgroup");	
							 jQuery("#subgroup_span").html('<select class=sign_inp><option>Select SubGroup</option></select>');	
						 }
						else
						 {
							
							jQuery("#memb").html(msg);		
							call_member(group)
						 }
						
						
					}
				})
	 }
	else
	 {
			jQuery("#memb").html('');
		    jQuery("#subgroup_span").html('<select class=sign_inp><option>Select SubGroup</option></select>');	
		  
	 }
}

function call_member(id)
 {
	   var path = jQuery('#path').val()+"ajax/message.php";
	   var param = "group="+id+"&act=subgroup";
	 
	jQuery.ajax({
				type: 	'POST',
				data: 	param,
				url:	path,
				success:function(msg){
					
						
						if(msg == "")
						 { 
							
							jQuery("#subgroup_span").html("Group hasn't any Member");
							 //jQuery("#subgroup_span").html('<select class=sign_inp><option>Select Subgroup</option></select>');	
						 }
						else
						 {
							
							jQuery("#subgroup_span").html(msg);		
							
						 }
						
						
					}
				})
 }

function addMessage()
 {
	  /*jQuery('input[id*="chk_"]').each(function(index) {
    alert(index + ': ' + jQuery(this).text());
  });*/
	
	jQuery("#success").hide()
	jQuery("#err").hide()

	var sms_msg = jQuery('#sms_msg');
	var group = jQuery('#group');
	var subgroup = jQuery('#subgroup');
	
	
	var err_txt = "";
	var err = "";
	var num = 0;
			jQuery(".sign_inp").css({border:bbclr});
	
		if(sms_msg.val() == "" )
				{
					num++;
					sms_msg.css({border:bclr});
					err_txt = err_txt+num+"- Message can't be blank<br>";
					err = 1;
					
				}
		if(group.val() == ""  )
				{
					num++;
					group.css({border:bclr});
					err_txt = err_txt+num+"- Please select group<br>";
					err = 1;
					
				}	
			
			
	
	 
	

			
				
			if(err == 1)
			 {
				//id  = jQuery(this).attr('id');.fadeOut(5000)
				pos = jQuery('.outer_div').offset();
				jQuery('html,body').animate({scrollTop: pos.top}, 1000);
				 jQuery('#err').show().html(err_txt);	
				 return false;
			 }
			else
			 {
				frm_signup.submit(); 
			 }
			 
		
 }

