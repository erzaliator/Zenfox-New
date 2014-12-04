<?php
/*
 * This file is for authentication
 * Importing the forms directory
 */

require_once dirname(__FILE__).'/../forms/LoginForm.php';
require_once dirname(__FILE__).'/../forms/RegistrationForm.php';
require_once dirname(__FILE__).'/../forms/ChangePasswordForm.php';
require_once dirname(__FILE__).'/../forms/PasswordRecoveryForm.php';
require_once dirname(__FILE__).'/../forms/CouponForm.php';

/*require_once("IPLocation/IpLocation/Ip.php");
require_once("IPLocation/IpLocation/Url.php");
require_once("IPLocation/IpLocation/Service/GeoIp.php");
require_once("IPLocation/IpLocation/Service/CsvWebhosting.php");*/

class Player_AuthController extends Zenfox_Controller_Action
{
	public function init()
	{
		parent::init();

        $contextSwitch = $this->_helper->getHelper('contextSwitch');
		$contextSwitch->addActionContext('view', 'json')
					->addActionContext('signup', 'json')
					->addActionContext('edit', 'json')
					->addActionContext('registration', 'json')
					->addActionContext('changepwd', 'json')
					->addActionContext('login', 'json')
					->addActionContext('logout', 'json')
					->addActionContext('image', 'json')
              		->initContext();
	}

	/*
	 * Validating the login information
	 */

	public function loginAction()
	{		
		// For configuration options
		// @see Zend_Queue_Adapater::__construct()
		/* $options = array(
		        'name' => 'queue1',
		);
		 
		// Create an array queue
		$queue = new Zend_Queue('Array', $options);
		 
		// Get list of queues
		foreach ($queue->getQueues() as $name) {
			echo "name->" . $name, "\n";
		}
		 
		// Create a new queue
		$queue2 = $queue->createQueue('queue2');
		 
		// Get number of messages in a queue (supports Countable interface from SPL)
		echo "count->" . count($queue);
		 
		// Get up to 5 messages from a queue
		
		 
		// Send a message to the currently active queue
		$queue->send('My Test Message');
		$messages = $queue->receive(5);
		Zenfox_Debug::dump($messages, 'message');
		foreach ($messages as $i => $message) {
			echo "message->" . $message->body, "\n";
		
			// We have processed the message; now we remove it from the queue.
			$queue->deleteMessage($message);
		}
		// Delete a queue we created and all of it's messages
		$queue->deleteQueue('queue2'); */
		
		
		/*$accountUnconfirm = new AccountUnconfirm();
		$accountUnconfirmData = $accountUnconfirm->getAllPlayers();
		$mail = new Mail();*/
		//$mail->sendToOne('Registration', 'CONFIRMATION', $result[1]);
		/*$objIpLocationObject = new IpLocation_Url(new IpLocation_Service_CsvWebhosting());
		$results = $objIpLocationObject->getUrlLocation('http://logicdice.com/');*/ // google.com IP address
		/*$objIpLocationObject = new IpLocation_Ip(new IpLocation_Service_CsvWebhosting());
		$results = $objIpLocationObject->getIpLocation('203.105.185.18');
		print_r($results);*/
		/*$frontController = Zend_Controller_Front::getInstance();
		$bonusSchemePlugin = new Zenfox_Controller_Plugin_BonusScheme('niktesting6');
		$frontController->registerPlugin($bonusSchemePlugin, 300);*/
		
		$language = $this->getRequest()->getParam('lang');
		$form = new Player_LoginForm();
		$decorator = new Decorator();
		$form = $decorator->addDecorators($form, 'login');
		$this->view->form = $form;
		
		$storage = new Zenfox_Auth_Storage_Session();

		/*$facebookAuth = $this->getRequest()->getParam('facebookAuth');
		$playerId = $this->getRequest()->getParam('playerId');
		
		$this->view->facebookAuth = $facebookAuth;*/
		$session = $storage->read();
		if($session)
		{
			$this->_redirect($language . '/game');
		}
		/*$this->view->format = $this->getRequest()->format;
		if($session && !$facebookAuth)
		{
			if($this->getRequest()->format == 'json')
			{
				unset($this->view->form);
				unset($this->view->facebookAuth);
				$this->view->success = 'true';
			}
			else
			{
				$this->_redirect($language . '/home');
			}
		}*/
		if($this->getRequest()->isPost())
		{
			
			if($form->isValid($_POST))
			{
				$prevSess = new Zend_Session_Namespace('prevAmount');
				$prevSess->unsetAll();
				/*if($form->getValue('fgPassword'))
				{
					$this->_redirect($language . '/auth/forgotpassword');
				}*/
				if($form->getValue('facebookLogin'))
				{
					$this->render('facebooklogin');
					//$this->view->facebook = true;
				}
				$data = $form->getValues();
				//$auth = Zenfox_Auth::getInstance();
				//$authAdapter = new Zenfox_Auth_Adapter_Authentication($data['userName'],$data['password']);
				/*
				 * Call the authenticate function of Authentication
				 * @return object of Zendfox_Auth_Result
				 */
	
				//$auth = Zend_Auth::getInstance();
				$zenfoxAuth = new Zenfox_Player_Auth_Adapter_Database(
				                    $data['userName'],
				                    $data['password']
				                    );
				//$zenfoxAuthResult = $auth->authenticate($zenfoxAuth);

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

					$playerId = $session['id'];
					$player_session = new PlayerSession($playerId);
					$facebookSession = new Zend_Session_Namespace('facebookAuth');
					$facebookSession->value = true;
					if($player_session->storeInformation())
					{
						/* $userActions = new UserActions($playerId);
						$userActions->creditBuddyBonus(); */
						/*
						 * Credit user with login bonus.
						 */
						$userActions = new UserActions($playerId);
						$creditBonus = $userActions->creditLoginBonus();
						if($creditBonus['success'])
						{
							$this->_helper->FlashMessenger(array('notice' => $creditBonus['msg']));
						}

						if($this->getRequest()->format == 'json')
						{
      						unset($this->view->form);
      						unset($this->view->facebookAuth);
      						
      						$currency = new Zend_Currency();
							$imageName = md5("image" . $playerId) . '.jpg';
							$loginName = $session['authDetails'][0]['login'];
							$firstName = $session['authDetails'][0]['first_name'];
							//$cash = $session['authDetails'][0]['cash'];
							//$bonus = $session['authDetails'][0]['bonus_bank'] + $session['authDetails'][0]['bonus_winnings'];
							$cash = $session['authDetails'][0]['bank'] + $session['authDetails'][0]['winnings'] + $session['authDetails'][0]['bonus_bank'] + $session['authDetails'][0]['bonus_winnings'];
							$bonus = 0;
							if($store['authDetails'][0]['total_deposits'] > 0)
							{
								$bonus = $store['authDetails'][0]['bonus_due'];
							}

							$loyaltyPoints = $session['authDetails'][0]['loyalty_points_left'];
							$currencySession = new Zend_Session_Namespace('currency');
							$source = $currency->getShortName('', $currencySession->oldValue);
							$destination = $currency->getShortName('', $currencySession->newValue);
							$currConv = new CurrencyConversion();
							$cash = $currConv->getConvertedValue($source, $destination, $cash);
							$bonus = $currConv->getConvertedValue($source, $destination, $bonus);
							$imagePath = APPLICATION_PATH . "/../public/images/profiles/" . $imageName;
					       	if(!file_exists($imagePath))
					       	{
					       		$imagePath = "/images/profiles/profile-m1.jpg";
					       	}
					       	else
					       	{
					         	$imagePath = "/images/profiles/" . $imageName;
					       	}
						$freeChips = 0;
						$accountVariable = new AccountVariable();
						$varData = $accountVariable->getData($playerId, 'freeMoney');
						if($varData)
						{
							$freeChips = round($varData['varValue'], 2);
						} 
					       	$name = empty($firstName)?$loginName:$firstName;
					       	
					       	$authData['user_name'] = $name;
					       	$authData['balance'] = $cash;
					       	$authData['bonus'] = $bonus;
					       	$authData['loyalty_points'] = $loyaltyPoints;
					       	$authData['image_path'] = $imagePath;
						$authData['free_chips'] = $freeChips;
      						
      						$this->view->success=$authData;
						}
						else
						{
							$frontendName = Zend_Registry::getInstance()->get('frontendName');
							$redirectUrl = $_COOKIE['redirectUrl'];
							$vote = $_COOKIE['vote'];
							//$prevAction = $_COOKIE['login-action'];
							setcookie('redirectUrl',"",time(),'/','.'.$_SERVER['HTTP_HOST']);
							setcookie('vote',"",time() + (86400 * 30),'/','.'.$_SERVER['HTTP_HOST']);
							if($vote && (strpos($redirectUrl, 'index/index') || $redirectUrl == '/'))
							{
								$this->_redirect('/');
							}
							if($frontendName == 'ace2jak.com')
							{
								$this->_redirect($language . '/');
							}
							//setcookie('login-action',"",time(),'/','.'.$_SERVER['HTTP_HOST']);
							if(($redirectUrl != '/favicon.ico') && (!strpos($redirectUrl, 'auth/login')) && (!strpos($redirectUrl, 'index/index')) && (!strpos($redirectUrl, 'auth/level')) && ($redirectUrl != '/') && (!strpos($redirectUrl, 'crossdomain.xml')) && (!strpos($redirectUrl, 'auth/logout')))
							{
								$this->_redirect($language . $redirectUrl);
							}
							else
							{
								$this->_redirect($language . '/game');
							}
							/*$prevController = $_COOKIE['login-controller'];
							$prevAction = $_COOKIE['login-action'];
							setcookie('login-controller',"",time(),'/','.'.$_SERVER['HTTP_HOST']);
							setcookie('login-action',"",time(),'/','.'.$_SERVER['HTTP_HOST']);
							if($prevController != 'favicon.ico')
							{
								$this->_redirect($language . '/' . $prevController . '/' . $prevAction);
							}
							else
							{
								$this->_redirect($language . '/game');
							}*/
							/*if($prevController == 'banking' && $prevAction == 'deposit')
							{
								$this->_redirect($language . '/banking/deposit');
							}
							else
							{
								$this->_redirect($language . '/game');
							}*/
							//$this->_redirect($language . '/game');
						}
					}

				
				}
				else
				{
					if($this->getRequest()->format == 'json')
					{
						$this->view->success = false;
					}
					else
					{
						$this->view->form = "";
						$this->_helper->FlashMessenger(array('warning' => $this->view->translate($zenfoxAuthResult->getMessages())));
					}
				}
			}
			else
			{
				//$form->getElement('userName')->addError('This is not correct');
				if($this->getRequest()->format == 'json')
				{
					$data['userName'] = $_POST['username'];
					$data['password'] = $_POST['passwd'];
					
					unset($this->view->form);
	      			unset($this->view->facebookAuth);
					$userData = $this->auth($data);
					if($userData)
					{
	      				$this->view->success=$userData;
					}
					else
					{
						$this->view->success='false';
					}
				}
				/*if($form->getValue('fgPassword'))
				{
					$this->_redirect($language . '/auth/forgotpassword');
				}*/
				/*if($form->getValue('facebookLogin'))
				{
					//$this->view->facebook = true;
					$form = new Player_LoginForm();
					$this->view->form = $form;
					$this->render('facebooklogin');
				}*/
			}
		}
	}

	/*
	 * Implementing signupAction
	 * Save the data in the database
	 */
	public function signupAction()
	{
		$form = new Player_RegistrationForm();
		$decorator = new Decorator();
		$form->registration('registration');
		$form = $decorator->addDecorators($form, 'signup');
		$this->view->quickRegistrationForm = $form;
		$ajax = $this->getRequest()->ajax;
		//$this->view->quickRegistrationForm = $form->registration();
		//$this->view->submitButton = $form->submitButton();
		if($this->getRequest()->isPost())
		{
			if($form->isValid($_POST))
			{
				if($this->getRequest()->format == 'json')
				{
					$data = $_POST;
				}
				else
				{
					$data = $form->getValues();
				}
				//$data = $form->getValues();
				//Zenfox_Debug::dump($data, 'data', true, true);
				if($data['terms'])
				{
					$trackerId = isset($_COOKIE['trackerId'])?$_COOKIE['trackerId']:null;
					$buddyId = isset($_COOKIE['buddyId'])?$_COOKIE['buddyId']:null;

					if($trackerId)
					{
						$data['trackerId'] = $trackerId;
					}
					else
					{
						$trackerId = isset($this->getRequest()->trackerId)?$this->getRequest()->trackerId:NULL;
						if($trackerId)
						{
							$data['trackerId'] = $trackerId;
						}
					}
					if($buddyId)
					{
						$data['buddyId'] = $buddyId;
					}
					
					$player = new Player();
					$result = $player->registerUnconfirm($data);
					//$result[0] = true;
					//$result[1] = 'ec779437b22d3fc2799d863d41d2bcd9';
					if($result[0])
					{
						//echo "here"; exit();
						$accountUnconfirm = new AccountUnconfirm();
						$playerDetails = $accountUnconfirm->getPlayerData($result[1]);
						$variableData['playerId'] = $playerDetails['playerId'];
						$variableData['variableName'] = 'CV_AFF-ID';
						/*$variableData['variableValue'] = $data['affId'];
						if($data['affId'])
						{
							$accountUnconfirmVariables = new AccountUnconfirmVariables();
							$accountUnconfirmVariables->insertVarData($variableData);
						}*/

						$affId = isset($_COOKIE['affId'])?$_COOKIE['affId']:null;
						if(!$affId)
						{
							$affId = isset($this->getRequest()->affid)?$this->getRequest()->affid:NULL;
							if(!$affId)
							{
								$affId = $data['affId'];
							}
						}
						if($affId)
						{
							$variableData['variableValue'] = $affId;
							$accountUnconfirmVariables = new AccountUnconfirmVariables();
							$accountUnconfirmVariables->insertVarData($variableData);
						}

						//Zenfox_Debug::dump($playerDetails, 'data', true, true);
						/*$mail = new Zenfox_Mail_Template($playerDetails['playerId']);
						$mail->generateMail('CONFIRMATION', 'registration', $result[1], $playerDetails['login'], $playerDetails['email']);*/
						
						//Enable it once the mail server starts working 
						$mail = new Mail();
						$mailResponse = $mail->sendToOne('Registration', 'CONFIRMATION', $result[1]); 
						//$mailResponse = false;
						$this->view->quickRegistrationForm = '';
						
						//FOR TESTING PURPOSE ONLE, Remove it(CLICK HERE option)
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
						$trackerSession = new Zend_Session_Namespace('tracker');
						$trackerSession->unsetAll();
						$buddySession = new Zend_Session_Namespace('buddy');
						$buddySession->unsetAll();
						/*if($this->getRequest()->format == 'json')
						{
							$this->view->success = true;
						}*/
						if($this->getRequest()->format == 'json')
						{
							$this->view->success = true;
							$this->view->confirmUrl = $url. '/format/json';
						}
						elseif(!$mailResponse)
						{
							$frontendSName = Zend_Registry::get('frontendShortName');
							//$this->_helper->FlashMessenger(array('notice' => $this->view->translate("<br> Please %sClick Here%s to confirm.", "<a href=\"" . $this->view->baseUrl($url) . "\">", "</a>")));
							//$this->_helper->FlashMessenger(array('notice' => $this->view->translate("Thank you for registering at Bingo Crush. <br>We have sent you an activation link to your registered email address. Please check your inbox/spam folder for the email. <br>Click on the activation link and your account will be validated and an instant £20 will be credited.")));
							$this->_helper->FlashMessenger(array('notice' => $this->view->translate("Thank you for registering at " . $frontendSName . ". <br>We have sent you an activation link to your registered email address. Please check your inbox/spam folder for the email.")));
						}
						if($ajax)
						{
							if(!$mailResponse)
							{
								echo "Thank you for registering at Bingo Crush. We have sent you an activation link to your registered email address. Please check your inbox/spam folder for the email. Click on the activation link and your account will be validated and an instant £20 will be credited.";
								//echo "Thank you for registering at Bingo Crush. Click on OK button and your account will be validated and an instant £20 will be credited.&" . $url;
							}
							else
							{
								echo $mailResponse;
							}
						}
						//$this->view->submitButton = '';
						//$this->view->message = $this->view->translate("You are successfully registered. Please click here to sign in.");
						//$this->view->message = $this->view->translate("You have been successfully registered. Please <a href=\"" . $this->view->baseUrl("auth/login") . "\"> click here </a> to sign in.");
						//$this->_helper->FlashMessenger(array('notice' => $this->view->translate("You have been successfully registered. Please <a href=\"" . $this->view->baseUrl("auth/login") . "\"> click here </a> to sign in.")));
						//$this->_helper->FlashMessenger(array('notice' => $this->view->translate("A confirmation e-mail has been sent to your email address. <br> Please check your mail for further instructions. Please %sClick Here%s to confirm.", "<a href=\"" . $this->view->baseUrl($url) . "\">", "</a>")));
					}
					else
					{
						/*if($this->getRequest()->format == 'json')
						{
							$this->view->success = false;
						}*/
						if($this->getRequest()->format == 'json')
						{
							$this->view->success = false;
							$this->view->error = $result[1];
						}
						else
						{
							$this->_helper->FlashMessenger(array('error' => $this->view->translate($result[1])));
						}
						if($ajax)
						{
							echo $result[1];
						}
						//throw new Zenfox_Exception('Unable to register.');
						//print_r($result[1]);
						//$this->view->message = $result[1];
						//$this->_helper->FlashMessenger(array('error' => $this->view->translate($result[1])));
					}
				}
				else
				{
					if($this->getRequest()->format == 'json')
					{
						$this->view->success = false;
						$this->view->error = "Please select Terms & Conditions";
					}
					else
					{
						$this->_helper->FlashMessenger(array('error' => $this->view->translate("Please select Terms & Conditions")));
					}
					if($ajax)
					{
						echo "Please select Terms & Conditions";
					}
					//$this->_helper->FlashMessenger(array('error' => $this->view->translate("Please select Terms & Conditions")));
				}
				
			}
			else
			{
				foreach($form->getMessages() as $field => $messages)
				{
					foreach($messages as $message)
					{
						$error = $message;
					}
				}
				if($ajax)
				{
					echo $error;
				}
				$this->view->success = false;
				$this->view->error = $error;
				//print_r($form->getMessages());
			}
		}
		if($ajax)
		{
			Zend_Layout::getMvcInstance()->disableLayout();
			$this->view->quickRegistrationForm = "";
			$this->view->ajax = true;
		}
	}

	/*
	 * Implementing logoutAction
	 * Clear session
	 */
	public function logoutAction()
	{
//		if(!$_COOKIE['facebook'])
//		{
			$player = new PlayerSession();
			$player->deleteSession();
			$this->_helper->FlashMessenger(array('notice' => 'You have been logged out. Please wait while you are redirecting on login page.'));
			$this->view->link = 'http://' . $_SERVER['HTTP_HOST'];
			$this->view->success = true;
//		}
	}
	
	/*
	 * Implements edit player profile
	 */
	public function editAction()
	{
		//TODO implement it for not registered user
		$storage = new Zenfox_Auth_Storage_Session();
		$session = $storage->read();
		//$role = explode('-', $session['id']);
		$playerId = $session['id'];
		$loginName = $session['authDetails'][0]['login'];
		$firstName = $session['authDetails'][0]['first_name'];
		$name = empty($firstName)?$loginName:$firstName;
		$this->view->name = $name;
		$imageName = md5("image" . $playerId) . '.jpg';
		$imagePath = "http://" . $_SERVER['HTTP_HOST'] . "/images/profiles/" . $imageName;
		if(!fopen($imagePath, 'r'))
		{
			$imagePath = "/images/profiles/profile-m1.jpg";
		}
		else
		{
			$imagePath = "/images/profiles/" . $imageName;
		}
		$this->view->image = $imagePath;
		
		//$form = new Player_RegistrationForm();
		$player = new Player();
		
		$noOfBuddies = $player->getNoOfBuddies($playerId);
		
		$bonusLevel = new BonusLevel();
		$bonusPercentage = $bonusLevel->getBonusPercentage($playerId);
		
		$this->view->loyaltyBonus = $bonusPercentage['loyaltyBonus'];
		$this->view->bonus2Cash = $bonusPercentage['bonus2Cash'];
		$this->view->noOfBuddies = $noOfBuddies;
		//Called getPlayerData method of Player model to get complete player details.
		$playerData = $player->getPlayerData($playerId);
		if(!$playerData)
		{
			$this->_helper->FlashMessenger(array('error' => 'No record found.'));
		}
		else
		{
			//for Playdorm
			/*$form = new Player_RegistrationForm();
			$gnForm = $form->registration('general', $playerData);
			$form = new Player_RegistrationForm();
			$stForm = $form->registration('setting', $playerData);
			$form = new Player_RegistrationForm();
			$cnForm = $form->registration('connect', $playerData);
			$this->view->gnForm = $gnForm; 
			$this->view->stForm = $stForm; 
			$this->view->cnForm = $cnForm;
			$this->view->showForms = true;*/
			
			//for taashtime
			$form = new Player_RegistrationForm();
			$form->registration('edit', $playerData);
			$decorator = new Decorator();
			$editForm = $decorator->addDecorators($form, 'edit');
			$this->view->form = $editForm;
			//$this->view->form = $form->editForm($playerData);
			//$this->view->submitButton = $form->submitButton();
		}
		if($this->getRequest()->isPost())
		{
			if($form->isValid($_POST))
			{
				$data = $form->getValues();
				
				$currentTime = Zend_Date::now();
				$dob = new Zend_Date($data['dateofbirth']);
				$diff = $currentTime->sub($dob)->toValue();
				$year = floor($diff / (365 * 24 * 60 * 60));
				
				if($year >= 18)
				{
					//$editUser = new Player();
					//Called editPrfile method of Player model
					if($player->editProfile($data, $playerId))
					{
						//$form = new Player_RegistrationForm();
						$this->view->form = '';
						$this->view->submitButton = '';
						//$this->view->message = $this->view->translate("Your profile has been updated successfully.");
						$this->_helper->FlashMessenger(array('notice' => $this->view->translate("Your profile has been updated successfully")));
					}
					else
					{
						$this->_helper->FlashMessenger(array('error' => 'Unable to edit data.'));
					}
				}
				else
				{
					$this->_helper->FlashMessenger(array('error' => 'Sorry! You are under 18.'));
				}
			}
			
			//TODO Uncomment for Playdorm
			/*if($gnForm->isValid($_POST))
			{
				$data = $gnForm->getValues();
				//$player->editProfile($data, $playerId);
				//Zenfox_Debug::dump($data, 'data');
			}
			elseif($stForm->isValid($_POST))
			{
				$data = $stForm->getValues();
				//$player->editProfile($data, $playerId);
				//Zenfox_Debug::dump($data, 'data');
			}
			elseif($cnForm->isValid($_POST))
			{
				$data = $cnForm->getValues();
				//$player->editProfile($data, $playerId);
				//Zenfox_Debug::dump($data, 'data');
			}
			if($player->editProfile($data, $playerId))
			{
				$this->view->showForms = false;
				$this->_helper->FlashMessenger(array('notice' => $this->view->translate("Your profile has been updated successfully")));
			}
			else
			{
				$this->_helper->FlashMessenger(array('error' => 'Unable to edit data.'));
			}*/
		}
	}
	
	/*
	 * This function implements complete player registration
	 */
	public function registrationAction()
	{
		$form = new Player_RegistrationForm();
		$decorator = new Decorator();
		$form->registration('completeRegistration');
		$form = $decorator->addDecorators($form, 'registration');
		$this->view->completeRegistrationForm = $form;
		//$this->view->completeRegistrationForm = $form->registration(true);
		//$this->view->submitButton = $form->submitButton();
		if($this->getRequest()->isPost())
		{
			if($form->isValid($_POST))
			{
				$data = $form->getValues();
				
				$currentTime = Zend_Date::now();
				$dob = new Zend_Date($data['dateofbirth']);
				$diff = $currentTime->sub($dob)->toValue();
				$year = floor($diff / (365 * 24 * 60 * 60));
				
				//Zenfox_Debug::dump($data, 'data', true, true);
				if($year >= 18)
				{
					$player = new Player();
					$result = $player->registerUnconfirm($data, true);
					
					if($result[0])
					{
						$accountUnconfirm = new AccountUnconfirm();
						$playerDetails = $accountUnconfirm->getPlayerData($result[1]);
						//$mail = new Zenfox_Mail_Template($playerDetails['playerId']);
						//$mail->generateMail('CONFIRMATION', 'registration', $result[1], $playerDetails['login'], $playerDetails['email']);
							
						//Enable it once the mail server starts working
						$mail = new Mail();
						$mail->sendToOne('Registration', 'CONFIRMATION', $result[1]);
						//$this->mail($result[1]);
						$this->view->completeRegistrationForm = '';
							
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
						$trackerSession = new Zend_Session_Namespace('tracker');
						$trackerSession->unsetAll();
						$buddySession = new Zend_Session_Namespace('buddy');
						$buddySession->unsetAll();
						//$this->view->submitButton = '';
						//$this->view->message = $this->view->translate("You are successfully registered. Please click here to sign in.");
						//$this->view->message = $this->view->translate("You have been successfully registered. Please <a href=\"" . $this->view->baseUrl("auth/login") . "\"> click here </a> to sign in.");
						//$this->_helper->FlashMessenger(array('notice' => $this->view->translate("A confirmation e-mail has been sent to your email address. <br> Please check your mail for further instructions. Please %sClick Here%s to confirm.", "<a href=\"" . $this->view->baseUrl($url) . "\">", "</a>")));
						//$this->_helper->FlashMessenger(array('notice' => $this->view->translate("Welcome to TaashTime!! <br> A confirmation e-mail has been sent to your email address. <br> Please check your mail, confirm your account and claim your inaugral bonus Rs. 25")));
						$this->_helper->FlashMessenger(array('notice' => $this->view->translate("Thank you for registering at Bingo Crush. <br>We have sent you an activation link to your registered email address. Please check your inbox/spam folder for the email. <br>Click on the activation link and your account will be validated and an instant £20 will be credited.")));
						//$this->_helper->FlashMessenger(array('notice' => $this->view->translate("Thank you for registering at Bingo Crush. You will be redirected to validation page, your account will be validated and an instant £20 will be credited automatically.")));
						//$this->view->link = $url;
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
				else
				{
					$this->_helper->FlashMessenger(array('error' => $this->view->translate('Sorry! You are under 18.')));
				}
			}
		}
	}
	
	/*
	 * This function is used to view the player details
	 */
	public function viewAction()
	{
		$player = new Player();
		$session = new Zenfox_Auth_Storage_Session();
		$store = $session->read();
		$playerId = $store['id'];
		$playerData = $player->getPlayerData($playerId);
		
		$countryCode = $playerData['country'];
		$loyaltyPoints = $store['authDetails'][0]['total_loyalty_points'];
		$schemeId = $store['authDetails'][0]['bonus_scheme_id'];
		
		$bonusLevel = new BonusLevel();
		$currentLevel = $bonusLevel->getLevelIdByPoints($loyaltyPoints, $playerId, $schemeId);
		$countryName = "";
		if($countryCode)
		{
			$country = new Country();
			$countryName = $country->getCountryByCode($countryCode);
		}
		
		$completed = true;
		foreach($playerData as $playerDetail)
		{
			if(!$playerDetail)
			{
				$completed = false;
				break;
			}
		}
		if(!$playerData)
		{
			$this->_helper->FlashMessenger(array('error' => 'No record found.'));
		}
		$imageName = md5("image" . $playerId) . '.jpg';
		
		$imagePath = "http://" . $_SERVER['HTTP_HOST'] . "/images/profiles/" . $imageName;
		
		$webConfig = Zend_Registry::getInstance()->isRegistered('webConfig')?Zend_Registry::getInstance()->get('webConfig'):'';
		
		$cdnImageServer = $webConfig['cdnImageServer'];
		
		if(!fopen($imagePath, 'r'))
		{
			$imagePath = $cdnImageServer . "/images/profiles/profile-m1.jpg";
		}
		else
		{
			$imagePath = $cdnImageServer . "/images/profiles/" . $imageName;
		}
		$loginName = $store['authDetails'][0]['login'];
		$firstName = $store['authDetails'][0]['first_name'];
		$firstName = "";
		
		$noOfBuddies = $player->getNoOfBuddies($playerId);
		
		$bonusLevel = new BonusLevel();
		$bonusPercentage = $bonusLevel->getBonusPercentage($playerId);
		
		$kycobj = new Kyc();
		$kyc = $kycobj->getkycdetails($playerId);

		if(!$kyc)
		{
			$this->view->verified = 'Incomplete';
		}
		elseif(($kyc[0]['status'] == "ACCEPTED") && ($kyc[1]['status'] == "ACCEPTED"))
		{
			$this->view->verified = 'Verified';
		}
		elseif(($kyc[0]['status'] == "REJECTED") || ($kyc[1]['status'] == "REJECTED"))
		{
			$this->view->verified = 'Rejected';
		}
		else
		{
			$this->view->verified = 'Pending';
		}
		
		$this->view->completed = $completed;
		$this->view->loyaltyBonus = $bonusPercentage['loyaltyBonus'];
		$this->view->bonus2Cash = $bonusPercentage['bonus2Cash'];
		$this->view->noOfBuddies = $noOfBuddies;
		$this->view->name = empty($firstName)?$loginName:$firstName;
		$this->view->imagePath = $imagePath;
		$this->view->playerData = $playerData;
		$this->view->country = $countryName;
		$this->view->loyaltyPoints = $loyaltyPoints;
		$this->view->level = $currentLevel['name'];
	}
	
	/*
	 * This function is used to change the current password
	 */
	public function changepwdAction()
	{
		$session = new Zenfox_Auth_Storage_Session();
		$store = $session->read();
		$playerId = $store['id'];
		$form = new Player_ChangePasswordForm();
		if(!$playerId)
		{
			$this->_helper->FlashMessenger(array('error' => 'No record found.'));
		}
		$this->view->changePasswordForm = $form;
		if($this->getRequest()->isPost())
		{
			if($form->isValid($_POST))
			{
				$data = $form->getValues();
				$player = new Player();
				if(md5($data['currentPassword']) == $store['authDetails'][0]['password'])
				{
					if($data['newPassword'] == $data['confirmPassword'])
					{
						if($player->changePassword(md5($data['newPassword']), $playerId))
						{
							//$this->view->message = $this->view->translate("Your password has been changed successfully. Please try to Log In.");
							$this->_helper->FlashMessenger(array('notice' => $this->view->translate("Your password has been changed successfully.")));
							$this->view->link = 'http://' . $_SERVER['SERVER_NAME'] . '/auth/logout';
							$this->view->changePasswordForm = '';
							$playerSession = new PlayerSession($playerId);
							$session->write($playerSession->updateSession());
						}
						else
						{
							$this->_helper->FlashMessenger(array('error' => 'Unable to change password.'));
						}
					}
					else
					{
						//$this->view->changePasswordForm = '';
						//$this->view->message = $this->view->translate('Confirm password does not match, please try again.');
						$this->_helper->FlashMessenger(array('error' => $this->view->translate("Password not changed! New Password and Confirm Password fields do not match, please try again.")));
						$this->view->link = 'http://' . $_SERVER['SERVER_NAME'] . '/auth/changepwd';
					}
				}
				else
				{
                    //FIXME:: Write error message
					//TODO write the error handler
					//Done 
					//echo "bye";
					//$this->_redirect('auth/changepwd/msg');
					//$this->view->changePasswordForm = '';
					//$this->view->message = $this->view->translate('Wrong current password, please try again.');
					$this->_helper->FlashMessenger(array('error' => $this->view->translate("Wrong password, please try again.")));
					$this->view->link = 'http://' . $_SERVER['SERVER_NAME'] . '/auth/changepwd';
				}
			}
		}
	}
	
	public function confirmAction()
	{
		$language = $this->getRequest()->getParam('lang');
		//FIXME:: Add an error message
		$confirmationCode = $this->getRequest()->code;
		//$form = new Player_CouponForm();
		$autoLogin = Zend_Registry::get('autoLogin');
		$accountUnconfirm = new AccountUnconfirm();
		$playerData = $accountUnconfirm->getPlayerData($confirmationCode);
		$player = new Player();
		$accountUnconfirmVariables = new AccountUnconfirmVariables();
		$unconfirmVarData = $accountUnconfirmVariables->getVariableValue($playerData['playerId']);
		if($this->getRequest()->format == 'json')
		{
			Zend_Layout::getMvcInstance()->disableLayout();
		}
		
		if($playerData)
		{
			$url = '/' . $language . '/auth/login';
			if($playerData['confirmation'] == 'NO')
			{
				$result = $player->registerPlayer($playerData);
				$playerId = "";
				if($result[0])
				{
					$playerId = $player->getPlayerIdByRawQuery($playerData['login']);
					//$playerId = $player->getPlayerId($playerData['login']);
					$count = 0;
					while(!$playerId && $count <= 5)
					{
						//$playerId = $player->getPlayerId($playerData['login']);
						$playerId = $player->getPlayerIdByRawQuery($playerData['login']);
						$count++;
					}
					$frontController = Zend_Controller_Front::getInstance();
					if($unconfirmVarData && $playerId)
					{
						foreach($unconfirmVarData as $varData)
						{
							$data['variableName'] = $varData['variable_name'];
							$data['variableValue'] = $varData['variable_value'];
							$data['playerId'] = $playerId;
							$accountVariable = new AccountVariable();
							$accountVariable->insert($data);
						}
					}
					
					if($playerId)
					{
						/* $bonusSchemePlugin = new Zenfox_Controller_Plugin_BonusScheme($playerId);
						$frontController->registerPlugin($bonusSchemePlugin, 300); */
						$registration = new Registration();
						$registration->joiningBonus($playerData['login']);
						
						$accountDetail = $player->getAccountDetails($playerId);
						if($autoLogin)
						{
							//$accountDetail = $player->getAccountDetails($playerId);
							$storage = new Zend_Auth_Storage_Session();
							$storage->write(array(
																'id' => $playerId,
																'roleName' => 'player',
																'authDetails' => $accountDetail,
							));
							$urlRecords = new UrlRecords();
							$urlRecords->addRecords($playerId);
							//$frontController = Zend_Controller_Front::getInstance();
							$aclPlugin = $frontController->getPlugin('Zenfox_Controller_Plugin_Acl');
							$aclPlugin->setRoleName('player');
							$aclPlugin->setId($playerId);
							//echo "before"; exit();
							$playerSession = new PlayerSession($playerId);
							$playerSession->storeInformation();
							$player->updateLastLogin($playerId);
							
							$userActions = new UserActions($playerId);
							$userActions->creditBuddyBonus();
							
							$this->view->displayPixel = true;
							//$this->view->autoLogin = $autoLogin;
							//$this->view->link = 'http://' . $_SERVER['SERVER_NAME'] . '/auth/login';
						}
							
						if($accountDetail[0]['tracker_id'])
						{
							$landingPage = $_COOKIE['landingPage'];
							$varName = 'PT_Registration';
							switch($landingPage)
							{
								case 'LANDINGPAGE_1':
									$varName = 'PT_LANDING_1';
									break;
								case 'LANDINGPAGE_2':
									$varName = 'PT_LANDING_2';
									break;
								case 'DIRECT_LOGIN':
									$varName = 'PT_DIRECT_LOGIN';
									break;
							}
							$trackerDetail = new TrackerDetail();
							$trackerDetails = $trackerDetail->getVariableValue($accountDetail[0]['tracker_id'], $varName);
							if($trackerDetails)
							{
								//$this->view->pixelTracker = $trackerDetails;
								$pixelSession = new Zend_Session_Namespace('pixelTracker');
								$pixelSession->value = $trackerDetails;
								$pixelSession->trackerId = $accountDetail[0]['tracker_id'];
							}
						}
						//$this->view->form = $form;
						$goalSession = new Zend_Session_Namespace('goalSession');
						$goalSession->value = true;
						if($this->getRequest()->format == 'json')
						{
							$data['success'] = true;
							echo json_encode($data);
						}
						else
						{
// 							$mail = new Mail();
// 							$mail->sendToOne('welcome', 'PROMOTIONS', NULL, NULL, $playerData['email']);
							//$this->_helper->FlashMessenger(array('notice' => $this->view->translate("You have been successfully registered. If you have coupon code then enter it.")));
							$this->_helper->FlashMessenger(array('notice' => $this->view->translate("Thank you for validating your account. Free £20 is credited to your account. Good luck at games!")));
							//$this->_helper->actionStack('redeem', 'coupon');
							$this->_helper->actionStack('index', 'game');
							/* $request = clone $this->getRequest();
							$request->setActionName('howtoplay')
									->setControllerName('help')
									->setParams(array('page' => 'confirm'));
							$this->_helper->actionStack($request); */
							//$this->_helper->actionStack('howtoplay', 'help', 'default', array('page' => 'confirm'));
						}
					}
					else
					{
						/* $filePath = '/home/zenfox/backup_player/error_logs.txt';
						$fh = fopen($filePath, 'a');
						fwrite($fh, "DID NOT GET PLAYER ID FOR " . $playerData['login']);
						fclose($fh); */
						$confirmSession = new Zend_Session_Namespace('confirmSession');
						$confirmSession->value = $playerData['login'];
						$this->_helper->FlashMessenger(array('notice' => $this->view->translate("You have been successfully registered.")));
						$this->_helper->FlashMessenger(array('error' => $this->view->translate("Some problem has been occured while crediting the bonus. Please <a href=\"" . $this->view->baseUrl("auth/reconfirm") . "\"> click here </a> to get the bonus.")));
						//$this->_helper->FlashMessenger(array('error' => $this->view->translate("Some problem has been occured while crediting the bonus. Please contact to our customer support and get free Rs. 25 bonus.")));
					}
				}
				if(isset($result[1]))
				{
					$this->_helper->FlashMessenger(array('error' => $result[1]));
				}
				//Use this session only ones
		//		$confirmSession = new Zend_Session_Namespace('confirmSession');
		//		$confirmSession->value = true;
		//		$this->_redirect('/coupon/redeem');
				/*$trackerId = $this->getRequest()->trackerId;
				$frontendId = Zend_Registry::get('frontendId');
				$varName = 'FRONTEND_' . $frontendId . '_IDSITE';
				$trackerDetail = new TrackerDetail();
				$idSite = $trackerDetail->getVariableValue($trackerId, $varName);
				echo '<img src="'. Piwik_getUrlTrackGoal( $idSite = $idSite, $idGoal = 2) . '" alt="" />';*/
	//			Zenfox_Debug::dump($storage->read(), 'sessionData');
		/*		$this->_helper->FlashMessenger(array('notice' => $this->view->translate("You have been successfully registered. If you have coupon code then enter it.")));
				$this->_helper->actionStack('redeem', 'coupon');*/
				//$this->_helper->FlashMessenger(array('notice' => $this->view->translate("You have been successfully registered. You will be redirected on Game Page in few seconds. If not, Please %sclick here%s to sign in.", "<a href=\"" . $this->view->baseUrl($url) . "\">", "</a>")));
			}
			else
			{
				if($this->getRequest()->format == 'json')
				{
					$data['success'] = false;
					$data['error'] = "Your registration has already been confirmed.";
					echo json_encode($data);
				}
				else
				{
					$this->_helper->FlashMessenger(array('error' => $this->view->translate("Your registration has already been confirmed. Please %sclick here%s to sign in.", "<a href=\"" . $this->view->baseUrl($url) . "\">", "</a>")));
				}
				//$goalSession = new Zend_Session_Namespace('goalSession');
				//$goalSession->value = true;
				//$this->_helper->FlashMessenger(array('error' => $this->view->translate("Your registration has already been confirmed. Please %sclick here%s to sign in.", "<a href=\"" . $this->view->baseUrl($url) . "\">", "</a>")));
			}
		}
		else
		{
			if($this->getRequest()->format == 'json')
			{
				$data['success'] = false;
				$data['error'] = "The confirmation link is expired.";
				echo json_encode($data);
			}
			else
			{
				$url = '/'.$language.'/auth/registration';
				$this->_helper->FlashMessenger(array('error' => $this->view->translate("The confirmation link is expired. Please try registering %shere%s.", "<a href=\"" . $this->view->baseUrl($url) . "\">", "</a>")));
			}
/*			$url = '/'.$language.'/auth/registration';
			$this->_helper->FlashMessenger(array('error' => $this->view->translate("The confirmation link is expired. Please try registering %shere%s.", "<a href=\"" . $this->view->baseUrl($url) . "\">", "</a>")));*/
		}
	}
	
	public function forgotpasswordAction()
	{
		$form = new Player_PasswordRecoveryForm();
		$this->view->form = $form->provideInformation();
		if($this->getRequest()->isPost())
		{
			if($form->isValid($_POST))
			{
				$data = $form->getValues();
				$pos = strpos($data['login'], '@');
				$player = new Player();
				if($pos)
				{
					$playerId = $player->checkAccountIdFromEmail($data['login']);
					$email = $data['login'];
				}
				else
				{
					$playerData = $player->getAccountIdFromLogin($data['login'], true);
					$playerId = $playerData['player_id'];
					//$email = $player->getEmailFromLogin($data['login']);
					$email = $playerData['email'];
				}
				if(!isset($playerId))
				{
					$url = '/auth/signup';
					$this->_helper->FlashMessenger(array('error' => $this->view->translate("The details you provided do not match any of our records. Please check the details and try again or try registering %shere%s", "<a href=\"" . $this->view->baseUrl($url) . "\">", "</a>")));
				}
				else
				{
					$data['email'] = $email;
					$data['userId'] = $playerId;
					$data['userType'] = 'PLAYER';

					//FIXME set the connection in model
					$conn = Zenfox_Partition::getInstance()->getMasterConnection();
					Doctrine_Manager::getInstance()->setCurrentConnection($conn);
					$passwordRecovery = new PasswordRecovery();
					$code = $passwordRecovery->insertData($data);
					if(!$code)
					{
						$this->_helper->FlashMessenger(array('error' => $this->view->translate("An error occured while changing the password, please try again. <br>If problem persists contact our %s customer support %s", "<a href=\"" . $this->view->baseUrl("ticket/create") . "\">", "</a>")));
					}
					else
					{
						$mail = new Mail($playerId);
						$mail->sendToOne('Recovery', 'FORGOT_PASSWORD', $code);
//						$mail = new Zenfox_Mail_Template($playerId);
//						$mail->generateMail('Recovery', 'FORGOT_PASSWORD');
						$this->_helper->FlashMessenger(array('notice' => $this->view->translate('An email has been sent to your primary email address.')));
						$this->view->form = '';
					}
				}
			}
		}
	}
	
	public function resetpasswordAction()
	{
		$code = $this->getRequest()->code;
		$passwordRecovery = new PasswordRecovery();
		$playerId = $passwordRecovery->getPlayerId($code);
		if($playerId)
		{
			$form = new Player_PasswordRecoveryForm();
			$this->view->form = $form->resetPassword();
			if($this->getRequest()->isPost())
			{
				if($form->isValid($_POST))
				{
					$data = $form->getValues();
					if($data['password'] == $data['confirmPassword'])
					{
						$player = new Player();
						$resetPassword = $player->changePassword(md5($data['password']), $playerId);
						if($resetPassword)
						{
							$passwordRecovery->updateStatus($playerId, 'PLAYER');
							$language = $this->getRequest()->getParam('lang');
							$url = '/' . $language . '/auth/login';
							$this->_helper->FlashMessenger(array('notice' => $this->view->translate("Your password is successfully reset. Please %sclick here to sign in.", "<a href = \"" . $this->view->baseUrl($url) . "\">", "</a>")));
							$this->view->form = '';
						}
						else
						{
							$this->_helper->FlashMessenger(array('error' => $this->view->translate("There is some problem in resetting your password, please try again. <br>If problem persists contact our %s customer support %s", "<a href=\"" . $this->view->baseUrl("ticket/create") . "\">", "</a>")));
						}
					}
					else
					{
						$this->_helper->FlashMessenger(array('error' => $this->view->translate('New Password and Confirm Password fields do not match, please try again.')));
					}
				}
			}
		}
		else
		{
			$this->_helper->FlashMessenger(array('error' => "Player data not found. There is some problem in resetting your password, please try again. <br>If problem persists contact our %s customer support %s", "<a href=\"" . $this->view->baseUrl("ticket/create") . "\">", "</a>"));
		}
	}
	
	public function facebookloginAction()
	{
		
	}
	
	public function auth($data)
	{
		$zenfoxAuth = new Zenfox_Player_Auth_Adapter_Database(
				                    $data['userName'],
				                    $data['password']
				                    );
				                  
		$zenfoxAuthResult = $zenfoxAuth->authenticate();
		if($zenfoxAuthResult->isValid())
		{
			
			$storage = new Zenfox_Auth_Storage_Session();
			$storage->write($zenfoxAuth->getResultRowObject());
			$session = $storage->read();
			//$role = explode('-', $session['id']);
			$playerId = $session['id'];
			$player_session = new PlayerSession($playerId);
			$facebookSession = new Zend_Session_Namespace('facebookAuth');
			$facebookSession->value = true;
			if($player_session->storeInformation())
			{
				/*$currency = new Zend_Currency();
				$imageName = md5("image" . $playerId) . '.jpg';
				$loginName = $session['authDetails'][0]['login'];
				$firstName = $session['authDetails'][0]['first_name'];
				$cash = $session['authDetails'][0]['cash'];
				$bonus = $session['authDetails'][0]['bonus_bank'] + $session['authDetails'][0]['bonus_winnings'];
				$loyaltyPoints = $session['authDetails'][0]['loyalty_points_left'];
				$currencySession = new Zend_Session_Namespace('currency');
				$source = $currency->getShortName('', $currencySession->oldValue);
				$destination = $currency->getShortName('', $currencySession->newValue);
				$currConv = new CurrencyConversion();
				$cash = $currConv->getConvertedValue($source, $destination, $cash);
				$bonus = $currConv->getConvertedValue($source, $destination, $bonus);
				$imagePath = APPLICATION_PATH . "/../public/images/profiles/" . $imageName;
		       	if(!file_exists($imagePath))
		       	{
		       		$imagePath = "/images/" . $this->imagesDir . "../profiles/profile-m1.jpg";
		       	}
		       	else
		       	{
		         	$imagePath = "/images/profiles/" . $imageName;
		       	}
		       	$name = empty($firstName)?$loginName:$firstName;
		       	
		       	$authData['user_name'] = $name;
		       	$authData['balance'] = $cash;
		       	$authData['bonus'] = $bonus;
		       	$authData['loyalty_points'] = $loyaltyPoints;
		       	$authData['image_path'] = $imagePath;
		       	//$authData['success'] = true;
		       	return $authData;*/
			return true;
			}
		}
	}
	
	public function getsfsloginAction()
	{
		//Zend_Layout::getMvcInstance()->disableLayout();
		
		/*$userName = $_POST['username'];
		$tableId = $_POST['tableId'];
		$flavour = $_POST['flavour'];
		*/
		$userName = $_GET['username'];
		$tableId = $_GET['tableId'];
		$flavour = $_GET['flavour'];
		
		$authSession = new Zend_Auth_Storage_Session();
		$storedData = $authSession->read();
		$this->view->data = $storedData;
		$this->view->get = $_GET;
		
		if(($storedData) && ($storedData['authDetails'][0]['login'] == $userName))
		{
			$phpsessid = Zend_Session::getId();
			$data['success'] = true;
			$data['login'] = $userName . '|' . $tableId . '|' . $flavour;
			$data['pass_key'] = md5($tableId . md5($phpsessid));
			//$data['pass_key'] = 'b6c4d0092f41847c7c0aec4af7b7bf60';
		}
		else
		{
			$data['success'] = false;
		}
		
		$this->view->loginData = $data;
	}
	
	public function imageAction()
	{
		$session = new Zend_Auth_Storage_Session();
		$sessionData = $session->read();
		
		if($this->getRequest()->format == 'json')
		{
			$playerId = $this->getRequest()->playerId;
			$player = new Player();
			$playerData = $player->getAccountDetails($playerId);
			$playerFrontendId = $playerData[0]['frontend_id'];
			$imagePath = "";
			$sex = $sessionData['authDetails'][0]['sex'];
			switch($playerFrontendId)
			{
				case 1:
					$imageName = md5("image" . $playerId) . '.jpg';
					$imagePath = "http://" . $_SERVER['HTTP_HOST'] . "/images/profiles/" . $imageName;
				       	if(!fopen($imagePath,'r'))
				       	{
				       		//$imagePath = "http://" . $_SERVER['HTTP_HOST'] . "/images/profiles/profile-m1.jpg";
				       		$imagePath = "";
				       	}
				       	else
				       	{
				         	$imagePath =  "http://" . $_SERVER['HTTP_HOST'] . "/images/profiles/" . $imageName;
				       	}
					//$imagePath = "http://" . $_SERVER['HTTP_HOST'] . "/public/images/profiles/" . $imageName;
					break;
				case 2:
					$imagePath = "http://graph.facebook.com/" . $playerData[0]['login'] . "/picture";
					break;
			}
			$this->view->url = $imagePath;
			$this->view->sex = $sex;
		}
		else
		{
			$form = new Player_RegistrationForm();
			$this->view->imageForm = $form->registration('image');
			if($this->getRequest()->isPost())
			{
				if($form->isValid($_POST))
				{
					$playerId = $sessionData['id'];
					$data = $form->getValues();
					$imageName = $data['image'];
			
					$accountVarData['variableName'] = 'profile_image';
					$accountVarData['variableValue'] = $imageName;
					$accountVarData['playerId'] = $playerId;
					$accountVariable = new AccountVariable();
					if($accountVariable->insert($accountVarData))
					{
						//$this->_redirect('/game');
						$this->_helper->FlashMessenger(array('notice' => 'Image has been uploaded successfully. It may take upto 1 hour to view in your profile.'));
					}
					else
					{
						$this->_helper->FlashMessenger(array('error' => 'There is some problem in uploading the image, please try again.'));
					}
				}
			}
		}
		/*$form = new Player_RegistrationForm();
		$this->view->imageForm = $form->registration('image');
		if($this->getRequest()->isPost())
		{
			if($form->isValid($_POST))
			{
				$data = $form->getValues();
				//$this->_redirect('/game');
				$session = new Zend_Auth_Storage_Session();
				$sessionData = $session->read();
				$playerId = $sessionData['id'];
				$data = $form->getValues();
				$imageName = $data['image'];
				
				$accountVarData['variableName'] = 'profile_image';
				$accountVarData['variableValue'] = $imageName;
				$accountVarData['playerId'] = $playerId;
				$accountVariable = new AccountVariable();
				if($accountVariable->insert($accountVarData))
				{
					$this->_redirect('/game');
				}
				else
				{
					$this->_helper->FlashMessenger(array('error' => 'There is some problem in uploading the image, please try again.'));
				}
			}
		}*/
	}

	public function reconfirmAction()
	{
		$confirmSession = new Zend_Session_Namespace('confirmSession');
		if(isset($confirmSession->value))
		{
			$loginName = $confirmSession->value;
			
			$confirmSession->unsetAll();
				
			$player = new Player();
			$playerId = $player->getPlayerIdByRawQuery($loginName);
				
			if($playerId)
			{
				$frontController = Zend_Controller_Front::getInstance();
				$bonusSchemePlugin = new Zenfox_Controller_Plugin_BonusScheme($playerId);
				$frontController->registerPlugin($bonusSchemePlugin, 300);
					
				$accountDetail = $player->getAccountDetails($playerId);
				$storage = new Zend_Auth_Storage_Session();
				$storage->write(array(
									'id' => $playerId,
									'roleName' => 'player',
									'authDetails' => $accountDetail,
				));
				$urlRecords = new UrlRecords();
				$urlRecords->addRecords($playerId);
				//$frontController = Zend_Controller_Front::getInstance();
				$aclPlugin = $frontController->getPlugin('Zenfox_Controller_Plugin_Acl');
				$aclPlugin->setRoleName('player');
				$aclPlugin->setId($playerId);
				//echo "before"; exit();
				$playerSession = new PlayerSession($playerId);
				$playerSession->storeInformation();
				$player->updateLastLogin($playerId);
		
				$userActions = new UserActions($playerId);
				$userActions->creditBuddyBonus();
		
				$this->view->displayPixel = true;
				
				$mail = new Mail();
				$mail->sendToOne('welcome', 'PROMOTIONS', NULL, NULL, $playerData['email']);
				$this->_helper->FlashMessenger(array('notice' => $this->view->translate("Congratulations!! You got your bonus. If you have coupon code then enter it.")));
				$this->_helper->actionStack('redeem', 'coupon');
			}
			else
			{
				$this->_helper->FlashMessenger(array('error' => $this->view->translate("Still did not get bonus? Please contact to our customer support.")));
			}
		}
		else
		{
			$filePath = '/home/zenfox/backup_player/email_queue.txt';
			$fh = fopen($filePath, 'a');
			fwrite($fh, "CONFIRMATION");
			fclose($fh);
			
			
			$code = $this->getRequest()->code;
			if($code)
			{
				$mail = new Mail();
				$mail->sendToOne('Registration', 'CONFIRMATION', $code);
				
				$frontendName = Zend_Registry::getInstance()->get('frontendName');
				if($frontendName == 'ace2jak.com')
				{
					$this->_helper->FlashMessenger(array('notice' => $this->view->translate("Thank you for registering at AceJak. <br>We have sent you an activation link to your registered email address. Please check your inbox/spam folder for the email.")));
				}
				elseif($frontendName == 'taashtime.com')
				{
					$this->_helper->FlashMessenger(array('notice' => $this->view->translate("Welcome to TaashTime!! <br> A confirmation e-mail has been sent to your email address. <br> Please check your mail, confirm your account and claim your inaugral bonus Rs. 25")));
				}
				elseif($frontendName == 'bingocrush.co.um')
				{
					$this->_helper->FlashMessenger(array('notice' => $this->view->translate("Thank you for registering at Bingo Crush. <br>We have sent you an activation link to your registered email address. Please check your inbox/spam folder for the email. <br>Click on the activation link and your account will be validated and an instant £20 will be credited.")));
				}
			}
			else
			{
				$this->_helper->FlashMessenger(array('error' => $this->view->translate("This is not a valid link.")));
			}
		}
	}
	
	public function levelAction()
	{
		$storage = new Zenfox_Auth_Storage_Session();
		$session = $storage->read();
		$playerId = $session['id'];
		
		$variable = $_POST['variable'];
		if($variable == 'live')
		{
			Zend_Layout::getMvcInstance()->disableLayout();
			$onlineTable = new OnlineTable();
			echo $onlineTable->getLiveTables();
		}
		elseif($playerId)
		{
			$bonusLevel = new BonusLevel();
			$bonusPercentage = $bonusLevel->getBonusPercentage($playerId);
			$this->view->level = $bonusPercentage['levelPercent'];
		}
		else
		{
			$this->view->level = 0;
		}
	}
}
