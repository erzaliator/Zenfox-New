// JavaScript Document

$(document).ready(function() {		
	
	//Execute the slideShow
	slideShow();
	
	// Home page Menu
	$('#menu ul.navigation li:first').addClass('hfirst');
	$('#menu ul.navigation li:last').addClass('hlast');

});

function slideShow() {

	//Set the opacity of all images to 0
	$('#bannergallery a').css({opacity: 0.0});
	
	//Get the first image and display it (set it to full opacity)
	$('#bannergallery a:first').css({opacity: 1.0});
	
	//Call the gallery function to run the slideshow, 5000 = change to next image after 5 seconds
	setInterval('gallery()',5000);
	
}

function gallery() {
	
	//if no IMGs have the show class, grab the first image
	var current = ($('#bannergallery a.show')?  $('#bannergallery a.show') : $('#bannergallery a:first'));

	//Get next image, if it reached the end of the slideshow, rotate it back to the first image
	var next = ((current.next().length) ? ((current.next().hasClass('caption'))? $('#bannergallery a:first') :current.next()) : $('#bannergallery a:first'));	
	
	//Set the fade in effect for the next image, show class has higher z-index
	next.css({opacity: 0.0})
	.addClass('show')
	.animate({opacity: 1.0}, 1000);

	//Hide the current image
	current.animate({opacity: 0.0}, 1000)
	.removeClass('show');
	
}
