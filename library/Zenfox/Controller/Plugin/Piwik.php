<?php
class Zenfox_Controller_Plugin_Piwik extends Zend_Controller_Plugin_Abstract
{
	public function postDispatch(Zend_Controller_Request_Abstract $request)
	{
		$view = Zend_Layout::getMvcInstance()->getView();
		$view->piwiktracker();
	}
}