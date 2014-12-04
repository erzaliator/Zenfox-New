$(document).ready(function()
{
	/*$(':button').click(function()
	{
		FB.login();
	});*/
	$('.tab').click(function () 
	{
		// Remove the 'active' class from the active tab.
		$('#tabs_container > .tabs > li.active')
		  	.removeClass('active');
			  
		// Add the 'active' class to the clicked tab.
		$(this).parent().addClass('active');
	
		$('#tabs_container > .tabs > li.active > a.tab_hover')
			.removeClass('tab_hover');
	
		// Remove the 'tab_contents_active' class from the visible tab contents.
		$('.ttfbbdyclr > div.tab_contents_active')
			.removeClass('tab_contents_active');
	
		// Add the 'tab_contents_active' class to the associated tab contents.
		$(this.rel).addClass('tab_contents_active');

	 });

	$('.tab').mouseover(function()
	{
		$(this).addClass('tab_hover');
		$('#tabs_container > .tabs > li.active > a.tab_hover')
			  .removeClass('tab_hover');
	});

	$('.tab').mouseout(function()
	{
		$(this).removeClass('tab_hover');
	});
	
	
	$('.tabi').mouseover(function()
	{
		$(this).addClass('tab_hover');
		$('#tabs_container > .tabs > li.active > a.tab_hover')
			  .removeClass('tab_hover');
	});

	$('.tabi').mouseout(function()
	{
		$(this).removeClass('tab_hover');
	});

	$("#accordion").tabs("#accordion div.pane", {tabs: 'h2', effect: 'slide', initialIndex: null});
	
});