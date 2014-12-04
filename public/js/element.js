$(document).ready();

function initMenu() {

/*---------------------------------to change body color scheme----------------------------------*/
	$("body").addClass("skin-blue");	
/*----------------------------------------------------------------------------------------------*/

/*--------------------------------to change the for-box width-----------------------------------*/	
    document.getElementById("form-box").style.width="650px";
/*----------------------------------------------------------------------------------------------*/

/*-------------------------------------for the login form---------------------------------------*/
    if($('input[type="text"][name="userName"]')[0])
    {
        $('input[type="text"][name="userName"]')[0].style.maxWidth="40em";
    }

    if($('input[type="text"][name="userName"]')[0])
    {
        $('input[type="password"][name="password"]')[0].style.maxWidth="40em";
    }
/*----------------------------------------------------------------------------------------------*/

/*---------------------------for the dashboard's collapsing-------------------------------------*/  

	var b=document.getElementsByClassName("sidebar-toggle")[0];
	var r=document.getElementsByClassName("right-side")[0];
	var h= document.getElementsByClassName("left-side")[0];
	var z=document.getElementById("form-box");
	b.addEventListener('click', function(){
	if(r.classList.contains('strech')){
	    r.classList.remove("strech");
	    h.style.visibility="visible";
	    document.getElementById("form-box").style.width="650px";
	    var col=document.getElementsByClassName("col-lg-push-1")[0];
	    col.classList.remove("col-lg-10");   
	    col.classList.add("col-lg-7");
	  }
	  else{
	    r.classList.add("strech");
	    h.style.visibility="hidden";
	    document.getElementById("form-box").style.width="1000px";  	    
	    var col=document.getElementsByClassName("col-lg-push-1")[0];
	    col.classList.remove("col-lg-7");   
	    col.classList.add("col-lg-10");  
	  }
    });
	var boxform=$("div#form-box");
	boxform.css({"margin-top":"30px"});
/*----------------------------------------------------------------------------------------------*/

//               `````````````````````` A P P L I C A T I O N   T O   G E E T A   M A M`````````````


/*-----------------------Jquery to change the width of the input fields--------------------------*/
	$("input").width("36em");					
	$("textarea").width("36em");
	$("input#submit").width("5em");


/*-----------------------------------------------------------------------------------------------*/
	//$("input").after("<br />");				   //to add br after every input field for spacing them
	//$("textarea").after("<br />");							 //to add br after every textarea field


	$("input:not(#submit)").addClass("form-control");						//change the form shape
	$("textarea").addClass("form-control");									//change the form shape
	$("input#submit").addClass("btn btn-primary btn-lg");			 //to change the button classes
	//$("input#create").addClass("btn btn-primary btn-lg");			 //to change the button classes
	//$("input#create").classList.remove("form-control");				 //to change the button classes


	$('h2#form-heading').css({								   //adding margin to the form elements
		"margin-left":"15px"
	});
	$('input[type="text"]').css({
		"margin-left":"10px"
	});
	$('input[type="text"]').css({
		"margin-left":"30px"
	});
	$('input[type="password"]').css({
		"margin-left":"10px"
	});
	$('input[type="password"]').css({
		"margin-left":"30px"
	});
	$('input[type="checkbox"]').css({
		"margin-top":"-30px",
	//	"padding-top":"-10px",
	//	"display":"inline-block",
	//	"float":"relative"
		"position":"relative",
		"top":"30px"
	});
	$('input[type="checkbox"]').css({
		"margin-left":"-50px"
	});
	$('input[type="radio"]').css({
		"margin-top":"-30px",
	//	"padding-top":"-10px",
	//	"display":"inline-block",
	//	"float":"relative"
		"position":"relative",
		"top":"30px"
	});
	$('input[type="radio"]').css({
		"margin-left":"-50px"
	});
	$('textarea').css({
		"margin-left":"30px"								
	});														
	$('label').css({										
		"margin-left":"10px"									
	});				
	$('input[type="submit"]').css({
		//"margin-right":"40px",
		"width":"5em",
		"margin-left":"30px"
	});	
	/*$('input#create').css({				
		"margin-right":"40px",
		"float":"right"
	});*/
	$('select').css({
		"margin-left":"10px"
	});
	$('select').css({
		"margin-left":"30px"
	});

/*--------------------End of Jquery to change the width of the input fields----------------------*/


	if($($('input[type="submit"]'))[0]){
		$('input[type="submit"]').addClass("btn btn-primary btn-lg");
		$('input[type="submit"]')[0].classList.remove("form-control");
		if($($('input[type="submit"]'))[1]){
		$('input[type="submit"]')[1].classList.remove("form-control");
		}
	}
	if($("input#create")[0]){
		var x=$("input#create")[0];
		x.style.width="5em";
		x.style.cssFloat="left";
	}
	if($("table")[0]){
		//document.getElementById("form-box").style.overflowX="scroll";
		//document.getElementById("form-box").style.width="650px";
	}
	//<input class="btn btn-primary btn-lg" style="width: 5em; margin-left: 30px; margin-right: 40px; float: right;" name="submit" id="submit" value="Submit" type="submit">
/*----------------------------------Jquery for the red unwanted element--------------------------*/
	
	if (document.getElementById("ui-datepicker-div")) {
   		document.getElementById("ui-datepicker-div").remove();
	}
/*-------------------------------End of Jquery for the red unwanted element----------------------*/


/*----------------------------------Jquery for the error input fields----------------------------*/

	//$("ul.errors")[0].parentNode.children[0];
/*-------------------------------End of Jquery for the error input fields------------------------*/

/*---Changing the dom structure of the navigation according to the template's specifications-----*/

	document.getElementsByClassName("navigation")[0].className="sidebar-menu";
	var z= $('ul.sidebar-menu').children();
	z[3].className="treeview";

	var z = $('ul.sidebar-menu').children;

/*---------------------------Navigation bar's jquery is over-------------------------------------*/


/*---------------------Jquery to change the heading according to the tab selected----------------*/
	activeli = $('li.active ul li.active a')[0].text;	
	$('h2#form-heading').text(activeli);
/*--------------End of Jquery to change the heading according to the tab selected----------------*/
}