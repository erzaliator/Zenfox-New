<?php

/**
 * This class is used to add customer headers
 */

class Zenfox_Controller_Plugin_Header extends Zend_Controller_Plugin_Abstract
{
	public function dispatchLoopShutdown()
	{
		$response = $this->getResponse();
		$response->setHeader('Cache-Control', 'no-cache, must-revalidate', true);
	}
}