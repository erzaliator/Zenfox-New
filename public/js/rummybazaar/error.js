$(document).ready(function(){
	var index = 1;
	if ($("ul.errors").length > 0){
		$(".content-block").each(function(){
			$(this).find('li').removeClass('login_form_button');
			$(this).find('li:eq(3)').addClass('login_button');
		});
	}
});