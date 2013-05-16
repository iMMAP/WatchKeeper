// JavaScript Document
jQuery(function(){


jQuery("#email").change(function(){
	 jQuery("#success").hide()
	 jQuery("#err").hide()
	 
	 jQuery("#email").css({border:bbclr});
	 var email = jQuery("#email").val();				 
	 var path = jQuery('#path').val()+"ajax/chk_signup.php";
	 var param = "email="+email+"&act=email";
	 if(!email_chk.test(email) )
		  {
					jQuery("#email").css({border:bclr});
					jQuery("#err").show().html("Email is invalid!");							
					return false;
					
		  }
		else
		 {
		
		jQuery.ajax({
				type: 	'POST',
				data: 	param,
				url:	path,
				success:function(msg){
						if(msg == 1)
						 { 
							jQuery("#success").show().html("Available!");							
						 }
						else
						 {
							jQuery('#email').val('');
							jQuery("#err").show().html("Email address Already taken!");							
							return false;
						 }
						
						
					}
				})
	     
		 }})


jQuery("#username").change(function(){
	 jQuery("#success").hide()
	 jQuery("#err").hide()
	 
	 jQuery("#username").css({border:bbclr});
	 var username = jQuery("#username").val();				 
	 var path = jQuery('#path').val()+"ajax/chk_signup.php";
	 var param = "username="+username+"&act=username";
	 	if(username == ""  )
				{
					
					jQuery("#username").css({border:bclr});
					
					jQuery("#err").show().html("Please enter Username!");							
					return false;
					
		  }
		else
		 {
		
		jQuery.ajax({
				type: 	'POST',
				data: 	param,
				url:	path,
				success:function(msg){
					
						if(msg == 1)
						 { 
							jQuery("#success").show().html("Available!");							
						 }
						else
						 {
							jQuery('#username').val('');
							jQuery("#username").css({border:bclr});
							jQuery("#username").focus()
							jQuery("#err").show().html("Username Already taken!");							
							return false;
						 }
						
						
					}
				})
	     
		 }})

jQuery("#register").click(function(){
	jQuery("#success").hide()
	jQuery("#err").hide()

	var fname = jQuery('#name');
	var email = jQuery('#email');
	var uname = jQuery('#username');
	var pass = jQuery('#password');
	var cpass = jQuery('#cpassword');
	var birth = jQuery('#birth');
	var gender = jQuery('#gender');
	var mobile = jQuery('#mobile');
	var address = jQuery('#address');
	var city = jQuery('#city');
	var state = jQuery('#state');
	var zip = jQuery('#zipcode');

	
	var err_txt = "";
	var err = "";
	var num = 0;
			jQuery(".sign_inp").css({border:bbclr});
			
		if(fname.val() == "" )
				{
					num++;
					fname.css({border:bclr});
					err_txt = err_txt+num+"- Fullname can't be blank<br>";
					err = 1;
					
				}
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
			if(uname.val() == "" )
				{
					num++;
					uname.css({border:bclr});
					err_txt = err_txt+num+"- Username can't be blank<br>";
					err = 1;
					
				}

			if(pass.val() == "" )
				{
					num++;
					pass.css({border:bclr});
					err_txt = err_txt+num+"- Password can't be blank<br>";
					err = 1;
					
				}
			else if(pass.val().length < "6" )
				{
					num++;
					pass.css({border:bclr});
					err_txt = err_txt+num+"- Password can't be less than 6 characters<br>";
					err = 1;
					
				}	
					if(cpass.val() == "" )
				{
					num++;
					cpass.css({border:bclr});
					err_txt = err_txt+num+"- Confirm Password can't be blank<br>";
					err = 1;
					
				}
				
			if(cpass.val() != pass.val() )
				{
					num++;
					cpass.css({border:bclr});
					pass.css({border:bclr});
					err_txt = err_txt+num+"- Password mismatch<br>";
					err = 1;
					
				}		
			if(birth.val() == "" )
				{
					num++;
					birth.css({border:bclr});
					err_txt = err_txt+num+"- Please select DOB<br>";
					err = 1;
					
				}	
			if(gender.val() == "" )
				{
					num++;
					gender.css({border:bclr});
					err_txt = err_txt+num+"- Please select Gender<br>";
					err = 1;
					
				}	
			if(mobile.val() == "" )
				{
					num++;
					mobile.css({border:bclr});
					err_txt = err_txt+num+"- Mobile can't be blank<br>";
					err = 1;
					
				}	
				if(address.val() == "" )
				{
					num++;
					address.css({border:bclr});
					err_txt = err_txt+num+"- Address can't be blank<br>";
					err = 1;
					
				}	
				if(city.val() == "" )
				{
					num++;
					city.css({border:bclr});
					err_txt = err_txt+num+"- City can't be blank<br>";
					err = 1;
					
				}	
				if(state.val() == "" )
				{
					num++;
					state.css({border:bclr});
					err_txt = err_txt+num+"- State can't be blank<br>";
					err = 1;
					
				}		
	
				
				if(zip.val() == "" )
				{
					num++;
					zip.css({border:bclr});
					err_txt = err_txt+num+"- Zipcode can't be blank<br>";
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
				jQuery("#form_member").submit(); 
			 }
			 
		})



	jQuery("#editmembers").click(function(){
	jQuery("#success").hide()
	jQuery("#err").hide()

	var fname = jQuery('#name');
	var pass = jQuery('#password');
	var birth = jQuery('#birth');
	var gender = jQuery('#gender');
	var mobile = jQuery('#mobile');
	var address = jQuery('#address');
	var city = jQuery('#city');
	var state = jQuery('#state');
	var zip = jQuery('#zipcode');

	
	var err_txt = "";
	var err = "";
	var num = 0;
			jQuery(".sign_inp").css({border:bbclr});
			
		if(fname.val() == "" )
				{
					num++;
					fname.css({border:bclr});
					err_txt = err_txt+num+"- Fullname can't be blank<br>";
					err = 1;
					
				}

			if(pass.val() == "" )
				{
					num++;
					pass.css({border:bclr});
					err_txt = err_txt+num+"- Password can't be blank<br>";
					err = 1;
					
				}
			else if(pass.val().length < "6" )
				{
					num++;
					pass.css({border:bclr});
					err_txt = err_txt+num+"- Password can't be less than 6 characters<br>";
					err = 1;
					
				}	
			if(birth.val() == "" )
				{
					num++;
					birth.css({border:bclr});
					err_txt = err_txt+num+"- Please select DOB<br>";
					err = 1;
					
				}	
			if(gender.val() == "" )
				{
					num++;
					gender.css({border:bclr});
					err_txt = err_txt+num+"- Please select Gender<br>";
					err = 1;
					
				}	
			if(mobile.val() == "" )
				{
					num++;
					mobile.css({border:bclr});
					err_txt = err_txt+num+"- Mobile can't be blank<br>";
					err = 1;
					
				}	
				if(address.val() == "" )
				{
					num++;
					address.css({border:bclr});
					err_txt = err_txt+num+"- Address can't be blank<br>";
					err = 1;
					
				}	
				if(city.val() == "" )
				{
					num++;
					city.css({border:bclr});
					err_txt = err_txt+num+"- City can't be blank<br>";
					err = 1;
					
				}	
				if(state.val() == "" )
				{
					num++;
					state.css({border:bclr});
					err_txt = err_txt+num+"- State can't be blank<br>";
					err = 1;
					
				}		
	
				
				if(zip.val() == "" )
				{
					num++;
					zip.css({border:bclr});
					err_txt = err_txt+num+"- Zipcode can't be blank<br>";
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
				jQuery("#form_member").submit(); 
			 }
			 
		})
	})
function call_calender()
{
		
	new CalendarDateSelect( 
						   $('imgs').previous(), 
						   {
							   time:true, 
							   valid_date_check:function(date) 
							   { 
							   
								return(date <= (new Date()).stripTime()) 
							   }, 
							   year_range:20
							} 
						   );
}


