function initMenu()
{
	$('.left-nav ul.navigation ul').hide();
	$('.left-nav ul.navigation li.active ul').show();
	$('.left-nav ul.navigation li a').click(function(event)
	{
		
		var checkElement = $(this).next();
		//alert(checkElement.href);
		if((checkElement.is('ul')) && (checkElement.is(':visible')))
		{
			return false;
		}
		if((checkElement.is('ul')) && (!checkElement.is(':visible'))) 
		{
			var temp = false;
			$('.left-nav ul.navigation li ul li a').click(function(event)
			{
				var checkEl = $(this).next();
				//alert(checkEl.href);
				if((checkEl.is('ul')) && (checkEl.is(':visible')))
				{
					temp = true;
					$('.left-nav ul.navigation li ul li ul').slideDown('normal');
					//$(".help-body-content").load(this.href+'/temp/true');
					event.preventDefault();
					alert(temp);
				}
				if((checkEl.is('ul')) && (!checkEl.is(':visible')))
				{
					alert("here");
					//$('.left-nav ul.navigation ul:visible ul:visible').slideUp('normal');
					checkEl.slideDown('normal');
					$(".help-body-content").load(this.href+'/temp/true');
					event.preventDefault();
				}
			});
			alert(temp);
			if(!temp)
			{
				$('.left-nav ul.navigation ul:visible').slideUp('normal');
				checkElement.slideDown('normal');
				//$(".help-body-content").load(this.href+'/temp/true');
			}
			event.preventDefault();
			//return true;
		}
	});
}
$(document).ready(function() {initMenu();});