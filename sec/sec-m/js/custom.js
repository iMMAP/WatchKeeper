var offset = 1;

$('.returnTopAction').live('click', function() {
   $('html, body').animate({scrollTop: '0'}, 700);
});
		
function getAlertLists(e, limit, offset){
	$.getJSON('addAlertLists.php?limit='+limit+'&offset='+offset, function(data) {
		// console.log(data);
		// console.log(e);
		if ($('#morelist')){$('#morelist').remove();}
		var html ='';
	     $.each(data, function(index, item) {
	         html += '<li><a href="addAlert.php?id='+item.id+'"><h2>' + item.name+ '</h2><p>'+item.location+','+item.tgl+' '+item.time+'</p><p>'+item.desc+'</p></a></li>';
	     });	
	      html += '<li id="morelist"><a href="#" onclick="getAlertLists($(\'#listview\'), '+limit+', '+(offset+limit)+');">Load more ...</a></li>';     
	     e.append($(html));
	   	 e.trigger('create');
	   	 e.listview('refresh');
	});
}	

