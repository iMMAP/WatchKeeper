// JavaScript Document

jQuery(function(){



jQuery("#addTeam").click(function(){
	jQuery("#success").hide()
	jQuery("#err").hide()
	var name = jQuery('#name');
	var object = jQuery('#object');

	
	var err_txt = "";
	var err = "";
	var num = 0;
			jQuery(".sign_inp").css({border:bbclr});
			
		if(object.val() == "" )
				{
					num++;
					object.css({border:bclr});
					err_txt = err_txt+num+"- Please select Object<br>";
					err = 1;
					
				}
			if(name.val() == "" )
				{
					num++;
					name.css({border:bclr});
					err_txt = err_txt+num+"- Name can't be blank<br>";
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
				frm_signup.submit(); 
			 }
			 
		})
	})


