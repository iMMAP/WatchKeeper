// JavaScript Document

jQuery(function(){

jQuery("#photo").focus(function(){
										   
										   
						   if(jQuery("#photo").val()=="Paste the URL here!")
							{
								jQuery("#photo").val("");
								jQuery("#edit_").attr("disabled","disabled");
								

							}
						   })	

jQuery("#photo").blur(function(){
						jQuery('#photo').css({border:bbclr, backgroundColor:clr});
					   if(jQuery("#photo").val()=="")
						{
							
							jQuery("#photo").val("Paste the URL here!");
							jQuery("#edit_").attr("disabled","");
						}
					   })



jQuery("#photo").change(function(){
								 
								 	var o_img_name = jQuery("#img_name").val();
									
									if(o_img_name !="")
									 {
										var path = jQuery('#path').val()+"ajax/get_image.php";
										var param = "o_img_name="+o_img_name+"&act=del";
								
									
										jQuery.ajax({
												type: 	'POST',
												data: 	param,
												url:	path,
												success:function(msg){
													
													if(msg==1) 
												  	 {	 
														jQuery("#img_name").val("");														
													 }
													
													}
												})
									 }
									 
									var img_url = jQuery("#photo").val();
									var num = Math.floor(Math.random()*9999999)
									var path = jQuery('#path').val()+"ajax/get_image.php";
									var param = "img_url="+img_url+"&num="+num+"&act=create";
									jQuery("#photo_img").html("");	
									
										jQuery.ajax({
												type: 	'POST',
												data: 	param,
												url:	path,
												success:function(msg){
													if(msg!="") 
													 {
														
														 var img = '<img src="'+jQuery("#path").val()+'ticked_images/'+msg+'" width="480" height="335" class="img_bdr">';
														
														jQuery("#photo_img").show().html(img);	
														jQuery("#img_name").val(msg);	
														jQuery("#edit_").attr("disabled","");
														
													 }
													else
													 {
															 jQuery("#photo_img").show().html("Format not supportable");	
													 }
													}
												})
								  })



jQuery("#delaccount").click(function(){
				
						if(confirm("Are you sure to Delete!"))
						 {	
						
							jQuery("#del").val("delete");
							jQuery("#frm_edit").submit();
						 }
						else
						 {
							 return false;
						 }
									 })
jQuery("#p_address").change(function(){
					 var p_address = jQuery("#p_address").val();				 
					 var path = jQuery('#path').val()+"ajax/chk_url.php";
					 var param = "p_address="+p_address;
					
						jQuery.ajax({
								type: 	'POST',
								data: 	param,
								url:	path,
								success:function(msg){
									
										if(msg == 1)
										 { 
											jQuery("#upa").show().html(p_address);
											jQuery("#upa_msg").show().html("This url is available!");							
										 }
										else
										 {
											jQuery("#upa").show().html(p_address);
											jQuery("#p_address").val('');
											jQuery("#upa_msg").show().html("Url already taken!");							
											return false;
										 }
										
										
									}
								})				 
									 })

jQuery("#edit_").click(function(){
	jQuery("#success").hide()

	 jQuery("#err").hide()
	var pass = jQuery('#pass');
	var cpass = jQuery('#cpass');
	var err_txt = "";
	var err = "";
	var num = 0;
			jQuery(".sign_inp").css({border:bbclr});
				if(cpass.val() != pass.val() )
				{
					num++;
					cpass.css({border:bclr});
					pass.css({border:bclr});
					err_txt = err_txt+num+"- Password mismatch<br>";
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
				frm_edit.submit(); 
			 }
			 
		})
	})

// prototype function
function call_calender()
{
	new CalendarDateSelect( $('imgs').previous(), {time:true, valid_date_check:function(date) { return(date >= (new Date()).stripTime()) }, year_range:10} );
}

