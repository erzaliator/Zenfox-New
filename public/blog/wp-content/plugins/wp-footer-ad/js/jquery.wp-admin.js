$j = jQuery.noConflict();

$j(document).ready
(
	function()
	{
		/**
		 * Common actions
		 */
		$j('a[href=#]').attr('href', 'javascript:void(0);');
	}
);