$j = jQuery.noConflict();

$j(document).ready
(
	function()
	{
		/**
		 * External links
		 */
		$j('#footer-adcont a.external').attr('target', '_blank');
		
		/**
		 * Close link
		 */
		$j('#footer-adcont-close').click
		(
			function()
			{
				$j('#footer-adcont').remove();
			}
		);
		
		/**
		 * Auto-adjust container height
		 */
		var $link = $j('#footer-adcont-content a');
		
		if ($link.length)
		{
			var linkHeight = $link.outerHeight();
			
			if (linkHeight > 60)
			{
				linkHeight = 60;
			}
			else if (linkHeight < 40)
			{
				linkHeight = 40;
			}
			
			$j('#footer-adcont-content, #footer-adcont-bar, #footer-adcont').height(linkHeight);
		}
	}
);