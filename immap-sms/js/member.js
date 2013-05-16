// JavaScript Document

function chnage_org(){
	
	 
	 var  organization_h = "";
	 var  group_id = "";
	 organization_h = jQuery("#organization_h").val();
	 group_id = jQuery("#group_h").val();
	
	 jQuery("#organization").css({border:bbclr});
	 var organization = jQuery("#organization").val();				 
	 var path = jQuery('#path').val()+"ajax/member.php";
	  if(organization_h == "")
	   var param = "organization="+organization+"&act=organization";
	 else
	   var param = "organization="+organization_h+"&group_id="+group_id+"&act=organization";
	 
	 organization_h = jQuery("#organization_h").val("");
	 
	jQuery.ajax({
				type: 	'POST',
				data: 	param,
				url:	path,
				success:function(msg){
					
						jQuery("#group_span").html("");
						if(msg == "")
						 { 
							jQuery("#group_span").html("Organization hasn't any group");							
						 }
						else
						 {
							
							jQuery("#group_span").html(msg);		
						 }
						
						
					}
				})
}

function chk_SubGroup(){
	 
	 var group_h = "";
	 var subgroup_id_h = "";
	 
	group_h = jQuery("#group_h").val();
	subgroup_id_h = jQuery("#subgroup_id_h").val();
	
	 jQuery("#group").css({border:bbclr});
	 var group = jQuery("#group").val();	
	
	 var path = jQuery('#path').val()+"ajax/member.php";
	  if(group_h == "")
	   var param = "group="+group+"&act=group";
	 else
	   var param = "group="+group_h+"&subgroup_id_h="+subgroup_id_h+"&act=group";
	 
	 
	 group_h = jQuery("#group_h").val("");
	 
	jQuery.ajax({
				type: 	'POST',
				data: 	param,
				url:	path,
				success:function(msg){
					
						jQuery("#subgroup_span").html("");
						if(msg == "")
						 { 
							jQuery("#subgroup_span").html("Group hasn't any subgroup");							
						 }
						else
						 {
							
							jQuery("#subgroup_span").html(msg);
							
						 }
						
						
					}
				})
}



jQuery(function(){

jQuery("#add").click(function(){
	jQuery("#success").hide()
	jQuery("#err").hide()

	var organization = jQuery('#organization');
	var fname = jQuery('#fname');
	var cell = jQuery('#cell');
	var email = jQuery('#email');
	
	
	var err_txt = "";
	var err = "";
	var num = 0;
			jQuery(".sign_inp").css({border:bbclr});
	
		if(organization.val() == "" )
				{
					num++;
					organization.css({border:bclr});
					err_txt = err_txt+num+"- Please select organization <br>";
					err = 1;
					
				}
		   			
			 if(fname.val() == "" )
				{
					num++;
					fname.css({border:bclr});
					err_txt = err_txt+num+"- Full name can't be blank<br>";
					err = 1;
					
				}
				
			
			if(cell.val() == "" )
				{
					
					num++;
					cell.css({border:bclr});
					err_txt = err_txt+num+"- Cell number can't be blank<br>";
					err = 1;
					
				}	
			else if(!numeric.test(cell.val()) )
				{
					num++;
					cell.css({border:bclr});
					err_txt = err_txt+num+"- Cell number is invalid<br>";
					err = 1;
					
				}	
/*
			if(email.val() == ""  )
				{
					num++;
					email.css({border:bclr});
					err_txt = err_txt+num+"- Email can't be blank<br>";
					err = 1;
					
				}	
			else if(!email_chk.test(email.val()) )
				{
					num++;
					email.css({border:bclr});
					err_txt = err_txt+num+"- Email is invalid<br>";
					err = 1;
					
				}	
				*/
			if(err == 1)
			 {
				//id  = jQuery(this).attr('id');.fadeOut(5000)
				pos = jQuery('.container').offset();
				jQuery('html,body').animate({scrollTop: pos.top}, 1000);
				 jQuery('#err').show().html(err_txt);	
				 return false;
			 }
			else
			 {
				 jQuery("#form_member").submit(); 
				
			 }
			 
		})

jQuery("#addmember").click(function(){
	jQuery("#success").hide()
	jQuery("#err").hide()

	var fname = jQuery('#fname');
	var cell = jQuery('#cell');
	
	
	var err_txt = "";
	var err = "";
	var num = 0;
			jQuery(".sign_inp").css({border:bbclr});
	
			 if(fname.val() == "" )
				{
					num++;
					fname.css({border:bclr});
					err_txt = err_txt+num+"- Full name can't be blank<br>";
					err = 1;
					
				}
				
			
			if(cell.val() == "" )
				{
					
					num++;
					cell.css({border:bclr});
					err_txt = err_txt+num+"- Cell number can't be blank<br>";
					err = 1;
					
				}	
			else if(!numeric.test(cell.val()) )
				{
					num++;
					cell.css({border:bclr});
					err_txt = err_txt+num+"- Cell number is invalid<br>";
					err = 1;
					
				}	

				
			if(err == 1)
			 {
				//id  = jQuery(this).attr('id');.fadeOut(5000)
				pos = jQuery('.container').offset();
				jQuery('html,body').animate({scrollTop: pos.top}, 1000);
				 jQuery('#err').show().html(err_txt);	
				 return false;
			 }
			else
			 {
				 jQuery("#form_member").submit(); 
				
			 }
			 
		})
	})





  function addMessage()
   {
			jQuery("#success").hide()
			jQuery("#err").hide()
			
			
			var sms_msg = jQuery("#sms_msg");
			var group = jQuery("#group");
		
			
			var err_txt = "";
			var err = "";
			var num = 0;
				jQuery(".sign_inp").css({border:bbclr});
					
				
					if(key.val() == "" )
						{
							num++;
							key.css({border:bclr});
							err_txt = err_txt+num+"- Please Select Objects<br>";
							err = 1;
							
						}
					 else
					  {
					
					
					
							if(key.val() == 21)
							 {
								var team = jQuery("#team");	
								if(team.val() == "" )
									{
										num++;
										team.css({border:bclr});
										err_txt = err_txt+num+"- Please Select Team<br>";
										err = 1;
										
									}
								
								
							  }
							
							
							  
					  }
					  
					if(key.val() == 21 || key.val() == 25 || key.val() == "")
					 {
							if(key.val() == 21 || key.val() == 25 )
							 {
								if(sms_msg.val() == "")
								 {
											num++;
											sms_msg.css({border:bclr});
											err_txt = err_txt+num+"- Message Field can't be empty<br>";
											err = 1;
								 }	 
							 }
					 }
					else
					 {
						 num++;
							//sms_msg.css({border:bclr});
							err_txt = err_txt+num+"- functionality Does not exist!<br>";
							err = 1;
					 }
						
					if(err == 1)
					 {
						//id  = jQuery(this).attr('id');.fadeOut(5000)
						pos = jQuery('#outer_div').offset();
						jQuery('html,body').animate({scrollTop: pos.top}, 1000);
						 jQuery('#err').show().html(err_txt);	
						 return false;
					 }
					else
					 {
						jQuery('#form_keyword').submit(); 
					 }

		
											 
											    
   }
// prototype function