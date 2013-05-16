// JavaScript Document

jQuery(function(){

jQuery("#addKeyword").click(function(){
	jQuery("#success").hide()
	jQuery("#err").hide()
	var keyword = jQuery('#key');
	

	
	var err_txt = "";
	var err = "";
	var num = 0;
			jQuery(".sign_inp").css({border:bbclr});
			if(keyword.val() == "" )
				{
					num++;
					keyword.css({border:bclr});
					err_txt = err_txt+num+"- Keyword can't be blank<br>";
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
			 
		})
	})


