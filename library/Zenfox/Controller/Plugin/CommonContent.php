<?php

/**
 * This class loads the common content for every page
 * @author nikhil
 *
 */
require_once APPLICATION_PATH .'/modules/player/forms/LoginForm.php';
class Zenfox_Controller_Plugin_CommonContent extends Zend_Controller_Plugin_Abstract
{
	public function preDispatch(Zend_Controller_Request_Abstract $request)
	{
		$module = $request->getModuleName();
		if($module == 'player')
		{
			$decorator = new Decorator();
			$loginForm = new Player_LoginForm();
			$loginForm = $decorator->addDecorators($loginForm, 'login');
			if($this->getRequest()->format == 'json')
			{
				$loginForm->setAction('/auth/login/format/json');
			}
			else
			{
				$loginForm->setAction('/auth/login');
			}
			
			$viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer');
			$view = $viewRenderer->view;
			$view->loginForm = $loginForm;
		}
	}
}