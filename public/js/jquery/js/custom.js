// JavaScript Document

$(document).ready(function(){
	//alert("Nikhil");

$('#inner-nav').hide();

var index = 1;

$('#main-menu').find(".active").each(function(){

if (index == 1){

$(this).find('a').removeClass('selected-tab')
var con = $(this).find("#nav-menu-sub").html();

if(con) {
$('#inner-nav').show();
$('#sub-menu').html(con);
}

else 
$('#inner-nav').hide(); 
$(this).find('a').addClass('selected-tab')
}

if (index == 2){
$('.active').find('a').addClass('selected-tab')
}


index++;

// Each Function End

});


						   
// Ready Function End
});