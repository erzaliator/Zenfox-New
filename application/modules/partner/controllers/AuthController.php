<?php

require_once dirname(__FILE__).'/../forms/LoginForm.php';
class Partner_AuthController extends Zenfox_Controller_Action
{
	public function init()
	{
		parent::init();
	}
	
	public function loginAction()
	{
		$loginForm = new Partner_LoginForm();
		$this->view->loginForm = $loginForm;
		
		if($this->getRequest()->isPost())
		{
			if($loginForm->isValid($_POST))
			{
				$formData = $loginForm->getValues();
				$partnerLogin = new PartnerLogin();
				$authenticate = $partnerLogin->authenticate($formData);
				if($authenticate['success'])
				{
					$this->_redirect('/home');
				}
				else
				{
					$this->view->message = $authenticate['message'];
				}
			}
		}
	}
	
	public function registrationAction()
	{
		
	}
	
	public function logoutAction()
	{
		$partners = new Partners();
		$partners->deleteAuthSession();
		
		$this->_redirect('/auth/login');
	}
}