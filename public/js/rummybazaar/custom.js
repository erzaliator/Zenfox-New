jQuery(function(){
	jQuery(document).ready(function(){
		$('.bxslider').bxSlider();
		$(".inline").colorbox({inline:true, width:"40%"});
	});
	
	/*-----Slide toggle Faqs ---*/
				
	jQuery(".hidden-menu").hide();
	jQuery(".side-menu .displayed-menu").click(function(){
		jQuery(this).parent().children(".hidden-menu").slideToggle();
		jQuery(this).toggleClass("plus");
	});
	
	jQuery(".displayed-menu").click(function(){
		jQuery(".hidden-menu").toggle(500);
  	});
			    
	jQuery(".answer").hide();
	jQuery(".list-block .question").click(function(){
		jQuery(this).parent().children(".answer").slideToggle();
		//jQuery(this).toggleClass("plus");
	});
		
	/*------Quick links slide function----*/

	jQuery("#div1").hide();
	$('#btn').click(function() {   
		$('#div1').animate({width:'toggle'},350);
	});
	
	jQuery(".menu-icon").click(function(){
		jQuery(".main-menu").slideToggle();
		
		// Optimalisation: Store the references outside the event handler:
		var $window = $(window);

		function checkWidth() {
			var windowsize = $window.width();
			if (windowsize > 959) {
				//if the window is greater than 440px wide then turn on jScrollPane..
				$(".main-menu").show();
			}
		} 
		// Execute on load
		checkWidth();
		// Bind event listener
		$(window).resize(checkWidth);
	
	});
			
	jQuery(".login-popup").hide();
    jQuery(".login").click(function(){
    	jQuery(".login-popup").slideToggle();       
    });      
       
    jQuery(".form-close").click(function(){
    	jQuery(".login-popup").hide();
   	});
    
});

$(document).ready(function() { 

	var listarray = new Array("Rummy Rules", 
	                                                       "How to Play", 
	                                                       "Legality", 
	                                                       "Certification");

	 for( i=0; i<listarray.length; i++)
	 {
	       $(".bx-controls .bx-pager-item a:eq(" + i + ")").text(listarray[i]);
	 }
	 
	});