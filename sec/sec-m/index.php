<?php
include('checkSession.php');
?>

<!DOCTYPE html>
<!--
Design by mRova Solutions
http://www.mrova.com
Released for free under a Creative Commons Attribution 2.5 License
-->
<html>
	<head>
		<title>iMMAP Security News</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0;" />
		<meta name="apple-mobile-web-app-capable" content="yes" />

		<!-- <link rel="stylesheet" href="http://code.jquery.com/mobile/1.0/jquery.mobile-1.0.min.css" /> -->
		<link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.0/jquery.mobile-1.3.0.min.css" />
		
		<link rel="stylesheet" href="css/style.css" />
		<link rel="stylesheet" href="css/photoswipe.css" />
		<!-- <script type="text/javascript" src="http://code.jquery.com/jquery-1.6.4.min.js"></script>
		<script type="text/javascript" src="http://code.jquery.com/mobile/1.0/jquery.mobile-1.0.min.js"></script> -->
		
		
		<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
		<script src="http://code.jquery.com/mobile/1.3.0/jquery.mobile-1.3.0.min.js"></script>

		<script type="text/javascript" src="http://maps.google.com/maps/api/js?v=3&sensor=false&language=en"> </script>
        <script type="text/javascript" src="http://jquery-ui-map.googlecode.com/svn/trunk/ui/jquery.ui.map.js"></script>
        <script type="text/javascript" src="http://jquery-ui-map.googlecode.com/svn/trunk/ui/jquery.ui.map.services.js"></script>
        <script type="text/javascript" src="http://jquery-ui-map.googlecode.com/svn/trunk/ui/jquery.ui.map.extensions.js"></script>

		<script type="text/javascript" src="js/klass.min.js"></script>
		<script type="text/javascript" src="js/code.photoswipe.jquery-3.0.4.min.js"></script>
		<script type="text/javascript" src="js/custom.js"></script>
	</head>
	<body>
		<div data-role="page" >
			<div data-role="header" id="header">
				<h1>iMMAP Security News</h1>
			</div><!-- /header -->
			<div data-role="content">
				<ul data-role="listview" data-inset="true" data-theme="a">
					<li>
						<a href="gallery.php">Security Alert</a>
					</li>
					<li>
						<a href="ISA.php">iMMAP Security Advisory</a>
					</li>
					<li>
						<a href="risklevel.php">Risk Level and Movement States</a>
					</li>
				</ul>
				<!-- <p class="copyright">Copyright &copy; mobi. Designed by iMMAP</p> -->
			</div><!-- /content -->
			  <div data-role="footer" data-theme="a">
            <div class="ui-bar">
             <!-- <a href="share-dialog.html"  data-role="button" data-icon="star" data-theme="a" data-rel="dialog">Share</a> --> 
             <a href="logout.php" data-role="button" data-icon="plus" data-theme="a" style="float:left;">Logout</a>
             <a href="" data-role="button" data-icon="arrow-u" data-theme="a" style="float:right;" class="returnTopAction">Return top</a>             
           </div>
          </div>
          <!-- /Footer --> 

		</div><!-- /page -->
	</body>
</html>

<script>

	function getParameterByName( name,href )
	{
	  name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
	  var regexS = "[\\?&]"+name+"=([^&#]*)";
	  var regex = new RegExp( regexS );
	  var results = regex.exec( href );
	  if( results == null )
	    return "";
	  else
	    return decodeURIComponent(results[1].replace(/\+/g, " "));
	}
	
	$('#gallery-page').live('pageshow', function(event) {
    	getAlertLists($('#listview'), 10, 0);
	});
	
	$(document).on("pageinit", "#basic-map", function(e) { 
		initialize(getParameterByName('location',e.currentTarget.baseURI), getParameterByName('lat',e.currentTarget.baseURI), getParameterByName('lng',e.currentTarget.baseURI));
    });
    
    $(document).bind("pageinit", function(){
    		// bringCoord
			$("#getCoord").click(function(){			
				$.mobile.changePage("map.php",
				{
					data:{
						id:$("#id").val(),
						date:$("#date").val(),
						time:$("#time").val(),
						countries:$("#countries").val(),
						location:$("#location").val(),
						message:$("#message").val(),
						incidenttype:$("#incidenttype").val(),
						sms:$("#checkbox-2").is(":checked"),
						lat:$("#lat").val(),
						lng:$("#lng").val()
					},
					reloadPage:  true
				});
			}); 
			$("#bringCoord").click(function(e){
				// console.log($('#map_canvas').gmap('get', 'markers > 0'));	
				var lat = $('#map_canvas').gmap('get', 'markers > 0').position.lat();		
				var lng = $('#map_canvas').gmap('get', 'markers > 0').position.lng();	
				$.mobile.changePage("addAlert.php",
				{
					data:{
						id:getParameterByName('id',e.currentTarget.baseURI),
						date:getParameterByName('date',e.currentTarget.baseURI),
						time:getParameterByName('time',e.currentTarget.baseURI),
						countries:getParameterByName('countries',e.currentTarget.baseURI),
						location:getParameterByName('location',e.currentTarget.baseURI),
						message:getParameterByName('message',e.currentTarget.baseURI),
						incidenttype:getParameterByName('incidenttype',e.currentTarget.baseURI),
						sms:getParameterByName('sms',e.currentTarget.baseURI),
						lng : lng,
						lat : lat,
						flg : 'map'
					},
					reloadPage:  true
				});
			});
	});
	
	
	function initialize(loc, slat, slng) {
                    mobileDemo = { 'center': '24.9,67', 'zoom': 10 };
         			$('#map_canvas').gmap({ 'center': mobileDemo.center, 'zoom': mobileDemo.zoom, 'disableDefaultUI':false });
         			
                    $('#map_canvas').gmap().bind('init', function(event, map) {
                    	if (slat==''){
                    		$('#map_canvas').gmap('search', {'address': loc}, function(results, status) {
								if ( status === 'OK' ) {
									var lat, lng;
									$.each(results[0].address_components, function(i,v) {
										// var lat, lng;
										if ( v.types[0] == "administrative_area_level_1" || 
											 v.types[0] == "administrative_area_level_2" ) {
											 	lat = results[0].geometry.location.lat();
											 	lng = results[0].geometry.location.lng();
										} else if ( v.types[0] == "country") {
										}
									});
									createmarker(lat,lng);
									$('#map_canvas').gmap('refresh'); 
									var center = $('#map_canvas').gmap('get', 'markers > 0'); 
									$('#map_canvas').gmap('get', 'map').panTo(center.position); 
								}
							}); 
						} else {
							createmarker(slat,slng);
							$('#map_canvas').gmap('refresh'); 
							var center = $('#map_canvas').gmap('get', 'markers > 0'); 
							$('#map_canvas').gmap('get', 'map').panTo(center.position); 
						}	
						
						
							function createmarker(lat,lng) {
								var position = new google.maps.LatLng(lat, lng);
								$('#map_canvas').gmap('addMarker', {
									'position': position, 
									'draggable': true, 
									'bounds': false
								}, function(map, marker) {
									$('#dialog').append('<form id="dialog'+marker.__gm_id+'" method="get" action="/" style="display:none;"><p><label for="country">Country</label><input id="country'+marker.__gm_id+'" class="txt" name="country" value=""/></p><p><label for="state">State</label><input id="state'+marker.__gm_id+'" class="txt" name="state" value=""/></p><p><label for="address">Address</label><input id="address'+marker.__gm_id+'" class="txt" name="address" value=""/></p><p><label for="comment">Comment</label><textarea id="comment" class="txt" name="comment" cols="40" rows="5"></textarea></p></form>');
									findLocation(marker.getPosition(), marker);
								}).dragend( function(event) {
									findLocation(event.latLng, this);
								}).click( function() {
									// openDialog(this);
								});
							}
						});
						
						function findLocation(location, marker) {
							
							$('#map_canvas').gmap('search', {'location': location}, function(results, status) {
								if ( status === 'OK' ) {
									$.each(results[0].address_components, function(i,v) {
										if ( v.types[0] == "administrative_area_level_1" || 
											 v.types[0] == "administrative_area_level_2" ) {
											$('#state'+marker.__gm_id).val(v.long_name);
										} else if ( v.types[0] == "country") {
											$('#country'+marker.__gm_id).val(v.long_name);
										}
									});
									marker.setTitle(results[0].formatted_address);
									$('#address'+marker.__gm_id).val(results[0].formatted_address);
									openDialog(marker);
								}
							});
						}
						
						function openDialog(marker) {
							$('#dialog'+marker.__gm_id).dialog({'modal':true, 'title': 'Edit and save point', 'buttons': { 
								"Remove": function() {
									$(this).dialog( "close" );
									marker.setMap(null);
								},
								"Save": function() {
									$(this).dialog( "close" );
								}
							}});
						}
						
						// var $lastPageForm = $('.last-page').find('contact_form');
						// console.log($lastPageForm);
						// $('.not-last-page').find('contact_form').on('submit', function () {
						    // $.each($(this).find('input'), function () {
						        // $lastPageForm.append($(this).clone());
						    // });
						    // return false;
						// });
                }
</script>
