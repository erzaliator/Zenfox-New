<?php

/**
 * This class is used to generate manifest
 */

class Zenfox_View_Helper_Manifest extends Zend_View_Helper_Abstract
{
	public $view;
	
	public function setView(Zend_View_Interface $view)
	{
		$this->view = $view;
	}
	
	public function manifest()
	{
		?>
		http://taashtime.tld/cache.appcache
		<?php 
	}
}