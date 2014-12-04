// JavaScript Document

$(document).ready(function(){
	var index = 1;
	var isActive = false;
	$('#all-menu').find('#active').each(function(){
		isActive = true;
		if (index == 1){
		
			var con = $(this).parent().find('#nav-menu-sub').html();
			
			if(!con) {
				con = '<li><a href="">' + document.getElementById("active").text; + '</a></li>';
			}
			//$('#inner-nav').show();
			$('#sub-menu').html(con);
		}
		
		index++;
		
		// Each Function End
		
	});	

	if(!isActive){
		var url = document.URL;
		var splitUrl = url.split("/");
		var con = '<li><a href="">' + splitUrl[4].charAt(0).toUpperCase() + splitUrl[4].slice(1) + '</a></li>';
		
		//$('#inner-nav').show();
		$('#sub-menu').html(con);
	}
// Ready Function End
});