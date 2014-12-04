<?php
/*
 * This file is for authentication
 * Importing the forms directory
 */

require_once dirname(__FILE__).'/../forms/LoginForm.php';
require_once dirname(__FILE__).'/../forms/QuickRegistrationForm.php';
require_once dirname(__FILE__).'/../forms/RegistrationForm.php';

class Admin_AuthController extends Zenfox_Controller_Action
{
	
	public function init()
	{
		parent::init();

		$this->_redirector = $this->_helper->getHelper('Redirector');
        $contextSwitch = $this->_helper->getHelper('contextSwitch');
        $contextSwitch->setAutoJsonSerialization(false);
		$contextSwitch->addActionContext('login', 'json')
              		->initContext();
	}

	/*
	 * Validating the login information
	 */

	public function loginAction()
	{
		$language = $this->getRequest()->getParam('lang');
		$form = new Admin_LoginForm();
		$this->view->form = $form;
		
		$session = new Zend_Auth_Storage_Session();
		$store = $session->read();
		if($store)
		{
			$this->_redirect($language . '/home');
		}
		
		if($this->getRequest()->isPost())
		{
			if($form->isValid($_POST))
			{
				$data = $form->getValues();
				//$auth = Zenfox_Auth::getInstance();
				//$authAdapter = new Zenfox_Auth_Adapter_Authentication($data['userName'],$data['password']);
				/*
				 * Call the authenticate function of Authentication
				 * @return object of Zendfox_Auth_Result
				 */

				$auth = Zend_Auth::getInstance();
				$zenfoxAuth = new Zenfox_Admin_Auth_Adapter_Database(
				                    $data['userName'],
				                    $data['password']
				                    );
				$zenfoxAuthResult = $auth->authenticate($zenfoxAuth);

				//$zenfoxAuth = new Zenfox_Player_Auth_Adapter_Database($data['userName'],$data['password']);
				//$result = $auth->authenticate($authAdapter);
				$zenfoxAuthResult = $zenfoxAuth->authenticate();
				if($zenfoxAuthResult->isValid())
				{
					/*
					 * Save the data in current session
					 */
					$storage = new Zenfox_Auth_Storage_Session();
					$storage->write($zenfoxAuth->getResultRowObject());

					//Go to home page
					//$this->_redirect('auth/home');
					if($this->getRequest()->format == 'json')
					{
						//$this->view->message = $this->view->translate("Your message has been sent");
					}
					else
					{
						$this->_redirect($language . '/home');
					}
				}
				else
				{
				/*	$storage = new Zenfox_Auth_Storage_Session();
					$storage->write(array('username'=>$result->getIdentity()));
					$this->_redirect('auth/home');
				*/
					//Print the error message
					foreach($zenfoxAuthResult->getMessages() as $message)
					{
						echo $message;
					}
				}
			}
		}
	}

	/*
	 * Implementing signupAction
	 * Save the data in the database
	 */
	//Currently no need to sign up. Check it further
/*	public function signupAction()
	{
		$form = new Admin_QuickRegistrationForm();
		$this->view->form = $form;
		if($this->getRequest()->isPost())
		{
			if($form->isValid($_POST))
			{
				$data = $form->getValues();
				$registerUser = new Admin();
				if(($registerUser->registerAdmin($data)))
				{
					$message = "You are successfully registered. Please click here to sign in.";
					$this->view->form = '';
					$this->view->message = $message;
				}
				else
				{
					echo "Not able to register";
				}
			}
		}
	}*/

	/*
	 * Implementing logoutAction
	 * Clear session
	 */
	public function logoutAction()
	{
		$language = $this->getRequest()->getParam('lang');
		$session = new Zend_Auth_Storage_Session();
		$session->clear();
		$this->_redirect($language . '/auth/login');
	}
	//TODO implement it for updating csr profile, if required.
/*	public function registrationAction()
	{
		$session = new Zend_Auth_Storage_Session();
		$data = $session->read();
		if(!$data)
		{
			$this->_redirect('auth/login');
		}
		$form = new Admin_RegistrationForm();
		$this->view->form = $form;
	}*/
}