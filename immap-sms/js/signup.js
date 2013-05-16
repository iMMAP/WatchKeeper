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
							jQuery("#email").css({border:bclr});
							jQuery("#email").focus();
							jQuery("#err").show().html("Email address Already taken!");							
							return false;
						 }
						
						
					}
				})
	     
		 }})


jQuery("#uname").change(function(){
	 jQuery("#success").hide()
	 jQuery("#err").hide()
	 
	 jQuery("#uname").css({border:bbclr});
	 var uname = jQuery("#uname").val();				 
	 var path = jQuery('#path').val()+"ajax/chk_signup.php";
	 var param = "name="+name+"&act=username";
	 	if(uname == ""  )
				{
					
					jQuery("#uname").css({border:bclr});
					
					
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
							jQuery('#uname').val('');
							Query("#uname").css({border:bclr});
							Query("#uname").focus();
							jQuery("#err").show().html("Username Already taken!");							
							return false;
						 }
						
						
					}
				})
	     
		 }})

jQuery("#register").click(function(){
	jQuery("#success").hide()
	jQuery("#err").hide()

	var fname = jQuery('#fname');
	var email = jQuery('#email');
	var uname = jQuery('#uname');
	var pass = jQuery('#pass');
	var cpass = jQuery('#cpass');
	var birth = jQuery('#birth');
	var gender = jQuery('#gender');
	var mobile = jQuery('#mobile');
	var address = jQuery('#add');
	var city = jQuery('#city');
	var state = jQuery('#state');
	var zip = jQuery('#zip');

	
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
			if(birth.val() != "" )
				{
					
					var bDay = birth.val();
					var now = new Date()
					 var bD = bDay.split('/');
					var years = 0;
					
					if(bD.length==3)
					 {
					  var born = new Date(bD[2], bD[1]*1-1, bD[0]);
					    years = Math.floor((now.getTime() - born.getTime()) / (365.25 * 24 * 60 * 60 * 1000));
					  
					 }
					
					if(years <= 18)
					{
						num++;
						birth.css({border:bclr});
						err_txt = err_txt+num+"- You must be 18 to register <br>";
						err = 1;
					}
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
				frm_signup.submit(); 
			 }
			 
		})
	})

// prototype function