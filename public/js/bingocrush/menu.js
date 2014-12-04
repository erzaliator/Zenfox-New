// JavaScript Document

$(document).ready(function(){
	//alert("Nikhil");

$('#TTBingosubNav').hide();

var index = 1;

$('#main-menu').find(".active").each(function(){

if (index == 1){

//$(this).find('a').removeClass('selected-tab')
var con = $(this).find("#nav-menu-sub").html();

if(con) {
$('#TTBingosubNav').show();
$('#sub-menu').html(con);
}

else 
$('#TTBingosubNav').hide(); 
//$(this).find('a').addClass('selected-tab')
}

if (index == 2){
//$('.active').find('a').addClass('selected-tab')
}


index++;

// Each Function End

});


						   
// Ready Function End
});

function onHover(obj){
	document.getElementById("sub-menu-hover").innerHTML = "";
	if(obj.getElementsByTagName("ul")[0] != undefined){
		document.getElementById("sub-menu-hover").innerHTML = obj.getElementsByTagName("ul")[0].innerHTML;
	}
}
function onOut(){
	document.getElementById("sub-menu-hover").innerHTML = "";
}