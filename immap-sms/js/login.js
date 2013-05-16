// JavaScript Document
jQuery(function(){

jQuery("#Login").click(function(){
	jQuery("#success").hide()
	jQuery("#err").hide()
	jQuery(".error1").hide()

	var txtUN = jQuery('#txtUN');
	var txtPWD = jQuery('#txtPWD');
	
	
	
	var err_txt = "";
	var err = "";
	var num = 0;
			jQuery(".sign_inp").css({border:bbclr});
	
		if(txtUN.val() == "" )
				{
					num++;
					txtUN.css({border:bclr});
					err_txt = err_txt+num+"- Username can't be blank<br>";
					err = 1;
					
				}
		   
			if(txtPWD.val() == "" )
				{
					num++;
					txtPWD.css({border:bclr});
					err_txt = err_txt+num+"- Password can't be blank<br>";
					err = 1;
					
				}

			
				
			if(err == 1)
			 {
				//id  = jQuery(this).attr('id');.fadeOut(5000)
				pos = jQuery('#frmLogin').offset();
				jQuery('html,body').animate({scrollTop: pos.top}, 1000);
				 jQuery('#err').show().html(err_txt);	
				 return false;
			 }
			else
			 {
				frmLogin.submit(); 
			 }
			 
		})
	})

// prototype function