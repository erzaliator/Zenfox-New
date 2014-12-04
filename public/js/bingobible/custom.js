jQuery(function()
	{
		$(".game-page-img-3").click(function(e){
			e.stopPropagation();	
			$( ".my-profile" ).toggle("slow");
 
		});
		
		$('body').click(function(){
            $(".my-profile").fadeOut("slow");
        });
		
		
			jQuery(".menu-icon").click(function(){
		jQuery(".menu").slideToggle();
		
		// Optimalisation: Store the references outside the event handler:
		var $window = $(window);

		function checkWidth() {
			var windowsize = $window.width();
			if (windowsize > 959) {
				//if the window is greater than 440px wide then turn on jScrollPane..
				$(".menu").show();
			}
		} 
		// Execute on load
		checkWidth();
		// Bind event listener
		$(window).resize(checkWidth);
	
	});

	});