// JavaScript Document

jQuery(function(){



jQuery("#addPlans").click(function(){
	jQuery("#success").hide()
	jQuery("#err").hide()
	var name = jQuery('#name');
	var descp = jQuery('#descp');
	var price = jQuery('#price');

	
	var err_txt = "";
	var err = "";
	var num = 0;
			jQuery(".sign_inp").css({border:bbclr});
			

			if(name.val() == "" )
				{
					num++;
					name.css({border:bclr});
					err_txt = err_txt+num+"- Name can't be blank<br>";
					err = 1;
					
				}
			if(descp.val() == "" )
				{
					num++;
					descp.css({border:bclr});
					err_txt = err_txt+num+"- Description can't be blank<br>";
					err = 1;
					
				}
			if(price.val() == "" )
				{
					num++;
					price.css({border:bclr});
					err_txt = err_txt+num+"- Price can't be blank<br>";
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


