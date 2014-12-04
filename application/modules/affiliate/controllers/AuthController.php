<?php
require_once dirname(__FILE__).'/../forms/RegistrationForm.php';
require_once dirname(__FILE__).'/../forms/LoginForm.php';
require_once dirname(__FILE__).'/../forms/ChangePasswordForm.php';

class Affiliate_AuthController extends Zenfox_Controller_Action
{
	public function signupAction()
	{
		$form = new Affiliate_RegistrationForm();
		
		$registrationForm = $form->getForm();
		$session = new Zend_Session_Namespace('referer');
		$refererAlias = $session->refererAlias;
		if($refererAlias)
			$registrationForm->masterId->setValue($refererAlias);
			
		$this->view->registrationForm = $registrationForm;
		
		$request = $this->getRequest();
		if($request->isPost())
		{
			if($registrationForm->isValid($_POST))
			{
				$data = $registrationForm->getValues();
				$data['masterId'] = $refererAlias;
				$data['lang'] = Zend_Registry::get('Zend_Locale');
				$affiliateConfig = new AffiliateConfig();
				$result = $affiliateConfig->registerAffiliate($data);
				if($result[0])
				{
					/*$mail = new Mail();
					$code = 'afsdjfsdas223';
					$mail->sendToOne('Registration', 'CONFIRMATION', $code);
					$this->_helper->FlashMessenger(array('notice' => $this->view->translate('An email has been sent to your primary email address.')));*/
					$isPiwikEnabled = Zend_Registry::getInstance()->get('piwikEnabled');
					if($isPiwikEnabled)
					{
						$user = new Piwik_User_Controller();
						$user->addUser($data['alias'], $data['password'], $data['email'], $data['firstName']);
					}
					$this->view->registrationForm = '';
                    //$this->view->message = $this->view->translate("You have been successfully registered. Please <a href=\"" . $this->view->baseUrl("auth/login") . "\"> click here </a> to sign in.");
                    $this->_helper->FlashMessenger(array('notice' => $this->view->translate("You have been successfully registered. Please %sclick here%s to sign in.","<a href=\"" . $this->view->baseUrl("auth/login") . "\">", "</a>")));
				}
				else
				{
                    // FIXME:: Replace this with an error message
					//print_r($result[1]);
					$this->_helper->FlashMessenger(array('notice' => $this->view->translate($result[1])));
				}
			}
		}
	}
	
	public function registrationAction()
	{
		$form = new Affiliate_RegistrationForm();
		$this->view->registrationForm = $form->getForm();
		if($this->getRequest()->isPost())
		{
			if($form->isValid($_POST))
			{
				$data = $form->getValues();
				//Zenfox_Debug::dump($data, 'data');
				$affiliateConfig = new AffiliateConfig();
				
				$result = $affiliateConfig->registerUnconfirm($data);
				//Zenfox_Debug::dump($result, 'result', true, true);
				if($result[0])
				{
					/*$accountUnconfirm = new AccountUnconfirm();
					$affiliateDetails = $accountUnconfirm->getAffiliateData($result[1]);*/
					//Zenfox_Debug::dump($affiliateDetails, $affiliateDetails, true, true);
					/*$mail = new Zenfox_Mail_Template($affiliateDetails['id']);
					$mail->generateMail('CONFIRMATION', 'registration', $result[1], $affiliateDetails['alias'], $affiliateDetails['email']);*/
					
					$mail = new Mail();
					//Zenfox_Debug::dump($result[1], "Affiliate Details", true, true);
					$mail->sendToOne('Registration', 'CONFIRMATION', $result[1]);
					$this->view->registrationForm = '';
					//FOR TESTING PURPOSE ONLE, Remove it
					$code = $result[1];
					$language = $this->getRequest()->getParam('lang');
					$trackerId = $this->getRequest()->trackerId;
					if($language && $trackerId)
					{
						$url = '/' . $language . '/auth/confirm/code/' . $code . '/trackerId/' . $trackerId;
					}
					elseif($language && !$trackerId)
					{
						$url = '/' . $language . '/auth/confirm/code/' . $code;
					}
					elseif($trackerId)
					{
						$url = '/auth/confirm/code/' . $code . '/trackerId/' . $trackerId;
					}
					else
					{
						$url = '/auth/confirm/code/' . $code;
					}
					//$this->view->message = $this->view->translate("You have been successfully registered. Please <a href=\"" . $this->view->baseUrl("auth/login") . "\"> click here </a> to sign in.");
					$this->_helper->FlashMessenger(array('notice' => $this->view->translate("A confirmation e-mail has been sent to your email address. <br> Please check your mail for further instructions. Please <a href=\"" . $this->view->baseUrl("auth/login") . "\"> click here </a> to sign in.")));
				}
				else
				{
                    //FIXME:: Replace this with an error message
					//print_r($result[1]);
					//throw new Zenfox_Exception('Unable to register.');
					//$this->view->message = $result[1];
					$this->_helper->FlashMessenger(array('error' => $this->view->translate($result[1])));
				}
			}
		}
	}
	
	public function confirmAction()
	{
		$language = $this->getRequest()->getParam('lang');
		$confirmationCode = $this->getRequest()->code;
		$autoLogin = Zend_Registry::get('autoLogin');
		$accountUnconfirm = new AccountUnconfirm();
		$affiliateData = $accountUnconfirm->getAffiliateData($confirmationCode);
		//Zenfox_Debug::dump($affiliateData, $affiliateData, true, true);
		
		$affiliateConfig = new AffiliateConfig();
		if($affiliateData)
		{
			
			$url = '/' . $language . '/auth/login';
			if($affiliateData['confirmation'] == 'NO')
			{
				$result = $affiliateConfig->confirmAffiliate($affiliateData);
				
				if($result[0])
				{
					/*$frontController = Zend_Controller_Front::getInstance();
					$bonusSchemePlugin = new Zenfox_Controller_Plugin_BonusScheme($affiliateData['alias']);
					$frontController->registerPlugin($bonusSchemePlugin, 300);*/
					$affiliateId = $affiliateConfig->getAffiliateIdFromLogin($affiliateData['alias']);
					if($autoLogin)
					{
						$affiliate = new Affiliate();
						$affiliateDetails = $affiliate->getAffiliate($affiliateId);
						$storage = new Zend_Auth_Storage_Session();
						$storage->write(array(
							'id' => $affiliateId,
							'roleName' => 'affiliate',
							'authDetails' => $affiliateDetails,
							));
						/*$aclPlugin = $frontController->getPlugin('Zenfox_Controller_Plugin_Acl');
						$aclPlugin->setRoleName('affiliate');
						$aclPlugin->setId($affiliateId);*/
					}
					
					$this->_helper->FlashMessenger(array('notice' => $this->view->translate("You have been successfully registered. You will be redirected on Game Page in few seconds. If not, Please %sclick here%s .", "<a href=\"" . $this->view->baseUrl($url) . "\">", "</a>")));
				}
				else 
				{
					$this->_helper->FlashMessenger(array('error' => $this->view->translate($result[1])));
				}
				
			}
			else
			{
				$this->_helper->FlashMessenger(array('error' => $this->view->translate("Your registration has already been confirmed. Please %sclick here%s to sign in.", "<a href=\"" . $this->view->baseUrl($url) . "\">", "</a>")));
			}
		}
		else
		{
			$url = '/'.$language.'/auth/registration';
			$this->_helper->FlashMessenger(array('error' => $this->view->translate("The confirmation link is expired. Please try registering %shere%s.", "<a href=\"" . $this->view->baseUrl($url) . "\">", "</a>")));
		}
	}
	
	public function loginAction()
	{
		$loginForm = new Affiliate_LoginForm();
		$form = $loginForm->getForm();
		$this->view->form = $form;
		
		$storage = new Zenfox_Auth_Storage_Session();
		$session = $storage->read();
		
		if($session)
		{
			$this->_redirect('/tracker/view');
		}
		if($this->getRequest()->isPost())
		{
			if($form->isValid($_POST))
			{
				$data = $form->getValues();

				$auth = Zend_Auth::getInstance();
				$zenfoxAuth = new Zenfox_Affiliate_Auth_Adapter_Authentication(
				                    $data['alias'],
				                    $data['password']
				                    );
				try
				{
					$zenfoxAuthResult = $auth->authenticate($zenfoxAuth);
				}
				catch (Exception $e)
				{
					Zenfox_Debug::dump($e, "Exception!", true, true);
				}

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
					$session = $storage->read();
					//Zenfox_Debug::dump($session, "Affiliate Session", true, true);
					//$role = explode('-', $session['id']);
					$affiliateId = $session['id'];
					/*$loginName = $session['authDetails'][0]['alias'];
					$md5Password = md5($session['authDetails'][0]['passwd']);
					$request = new Piwik_Log_Controller();
					$request->logme($loginName, $md5Password);*/
					$this->_redirect('/tracker/view');
					//Go to home page
					//$this->_redirect('auth/home');
				}
				else
				{
					$this->_helper->FlashMessenger(array('error' => $this->view->translate($zenfoxAuthResult->getMessages())));
				}
			}
		}
	}
	
	public function logoutAction()
	{
		//echo 'in logout';
		$session = new Zenfox_Auth_Storage_Session();
		//print_r($session->read());
		$session->clear();
		$this->_redirect('/');
	}
	public function viewAction()
	{
		$session = new Zenfox_Auth_Storage_Session();
		$store = $session->read();
		$id = $store['id'];
		$affiliate = new Affiliate();
		$affiliateDetails = $affiliate->getAffiliate($id);
		$this->view->affiliateDetails = $affiliateDetails;	
	}
	
	public function editAction()
	{
		$session = new Zenfox_Auth_Storage_Session();
		$store = $session->read();
		$id = $store['id'];
		$affiliate = new Affiliate();
		$affiliateDetails = $affiliate->getAffiliate($id);
		$this->view->affiliateDetails = $affiliateDetails;
		
		$form = new Affiliate_RegistrationForm();
		$registrationForm = $form->setForm($affiliateDetails);
		$this->view->form = $registrationForm;
		
		if($this->getRequest()->isPost())
		{
			if($registrationForm->isValid($_POST))
			{
				$data = $registrationForm->getValues();
				$affiliateConfig = new AffiliateConfig();
				$affiliateConfig->updateProfile($id,$data);
				$this->view->form = '';
				//echo 'Profile Updated';
                $this->view->translate("Your profile has been updated successfully");
			}
            else
            {
                //throw Zenfox_Exception ("Data invalid!");
            }
		}
	}
	
	public function changepasswordAction()
	{
		$affiliateConfig = new AffiliateConfig();
		$session = new Zenfox_Auth_Storage_Session();
		$store = $session->read();
		$id = $store['id'];
		$form = new Affiliate_ChangePasswordForm();
		$form = $form->getForm();
		$this->view->form = $form;
		if($this->getRequest()->isPost())
		{
			if($form->isValid($_POST))
			{
				$data = $form->getValues();
				$result = $affiliateConfig->updatePassword($id,$data);
				if($result[0])
				{
					$this->view->form = '';
					//$this->view->message = $this->view->translate("Your password has been successfully changed");
					$this->_helper->FlashMessenger(array('notice' => $this->view->translate("Your password has been successfully changed")));
				}
				else
				{
					//print_r($result[1]);
                    //throw Zenfox_Exception ("Data invalid!");
				}
			}
		}
	}
	
	
}
