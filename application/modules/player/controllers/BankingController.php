<?php
require_once dirname(__FILE__) . '/../forms/FundForm.php';
require_once dirname(__FILE__) . '/../forms/TransactionForm.php';
require_once dirname(__FILE__) . '/../forms/RegistrationForm.php';
require_once dirname(__FILE__) . '/../forms/InviteFriendForm.php';
class Player_BankingController extends Zenfox_Controller_Action
{
	public function init()
	{
		parent::init();
	}
	public function fundbonusAction()
	{
		//echo "in banking";
		$session = new Zenfox_Auth_Storage_Session();
		$store = $session->read();
		//Zenfox_Debug::dump($store, 'store');
		$playerId = $store['id'];
		/*if(!$playerId)
		{
			$this->_helper->viewRenderer->setNoRender();
			Zend_Layout::getMvcInstance()->disableLayout();
		}*/
		$playerData = $store['authDetails'][0];

		$bonus = $playerData['bonus_bank'] + $playerData['bonus_winnings'];
		//Change it
		$maxFund = 100;
		if($bonus < 100)
		{
			$this->_helper->FlashMessenger(array('notice' => $this->view->translate('Sorry, you already have more than %s Rs in your account.', $maxFund)));
		}
		else
		{
			$this->_helper->FlashMessenger(array('notice' => $this->view->translate('We currently do not take real money deposit. We regret for inconvenience. We will be coming with real money shortly. Till then have fun to play rummy by funding your bonus money.')));
			$form = new Player_FundForm();
			$this->view->form = $form;
		}

		/*$form = new Player_FundForm();
		$this->view->form = $form;*/
		$playerTransactions = new PlayerTransactions();
		if($this->getRequest()->isPost())
		{
				//Zenfox_Debug::dump($_POST, "POST DATA:: ", true, true);
			if($form->isValid($_POST))
			{
				$fund = $form->getValue('fund');
				$currency = $form->getValue('currency');
				$currencyValue = $fund;
				$baseCurrency = $playerData['base_currency'];
				$transactionCurrency = isset($currency)?$currency:$baseCurrency;
				//$sourceId = $playerTransactions->creditBonus($playerId, $currencyValue, $transactionCurrency);
				$sourceId = $playerTransactions->creditDeposit($playerId, $currencyValue, $transactionCurrency, 1);
				if(!$sourceId)
				{
					$this->_helper->FlashMessenger(array('error' => 'Could not credit bonus.'));
				}
				$auditReport = new AuditReport();
				$reportMessage = $auditReport->checkError($sourceId, $playerId);
				
				$counter = 0;
				while((!($reportMessage['processed'] == 'PROCESSED')) && (!($reportMessage['error'] == 'NOERROR')))
				{
					if($counter == 3)
					{
						break;
					}
					$reportMessage = $auditReport->checkError($sourceId, $playerId);
					if($reportMessage)
					{
						break;
					}					

					$counter++;
				}
				if($counter == 3 && !$reportMessage)
				{
						$this->_helper->FlashMessenger(array('error' => $this->view->translate("Your amount has not been credited, please try again. <br>If problem persists contact our %s customer support %s", "<a href=\"" . $this->view->baseUrl("ticket/create") . "\">", "</a>" )));
				}
				if(($reportMessage['processed'] == 'PROCESSED') && ($reportMessage['error'] == 'NOERROR'))
				{
					/*$playerData['cash'] = 100;
					$playerData['bonus_bank'] = 100;
					$playerData['bonus_winnings'] = 100;
					$player = new Player();
					$updateAccountDetails = $player->updateAccountDetails($playerData);
					$store['authDetails'] = $updateAccountDetails;
					$session->write($store); 
					$this->view->form = '';*/


					$fundValue = $currency . $currencyValue;
					$creditSession = new Zend_Session_Namespace('creditSession');
					$creditSession->value = $fundValue;
					$trackerId = $store['authDetails'][0]['tracker_id'];
					if(($_POST['browser'] == 'chrome') || ($_POST['browser'] == 'msie'))
					{
						Zend_Layout::getMvcInstance()->disableLayout();
						$this->view->form = '/banking/index/trackerId/' . $trackerId;
					}
					else
					{
						$this->_redirect('banking/index/trackerId/' . $trackerId)->setRedirectCode('307');
					}
					//$this->view->message = $this->view->translate('Congratulation!!Your amount is credited by $100.');
				}
				elseif($counter != 3)
				{
					$this->view->form = '';
					$this->_helper->FlashMessenger(array('error' => $this->view->translate('Your amount is not credited, please try again. If problem persists, please contact support with the following audit Id:: '. $reportMessage['auditId'])));
				}
			}
		}
	}
	public function indexAction()
	{
		$creditSession = new Zend_Session_Namespace('creditSession');
		$fund = $creditSession->value;
		if(!$fund)
		{
			$this->_helper->FlashMessenger(array('error' => 'This link is not valid.'));
			//$this->_redirect('/error/error');
		}
		else
		{
			$this->view->transactionId = $this->getRequest()->transactionId;
			$session = new Zenfox_Auth_Storage_Session();
			$sessionData = $session->read();
			$playerId = $sessionData['id'];
			$noOfDeposit = $sessionData['authDetails'][0]['noof_deposits'];
			if($noOfDeposit == 1)
			{
				$date = new Zend_Date();
				$date->setTimezone('Asia/Calcutta');
				$currentTime = $date->get(Zend_Date::W3C);
				$currentTime = explode('T', $currentTime);
				$currentTime = $currentTime[0] . ' ' . $currentTime[1];
				$currentTime = explode('+', $currentTime);
				$currentTime = $currentTime[0];

				$accountVariable = new AccountVariable();
				$data['playerId'] = $playerId;
				$data['variableName'] = 'DEPOSIT_FIRST_TIME';
				$data['variableValue'] = $currentTime;
				$accountVariable->insert($data);
				
				$accountVariable = new AccountVariable();
				$data['variableName'] = 'DEPOSIT_FIRST_TIME_AMOUNT';
				$data['variableValue'] = substr($fund, 3);
				$accountVariable->insert($data);
			}
			/*$lastDeposit = $sessionData['authDetails'][0]['last_deposit'];
			$promotionalBonus = new PromotionalBonus();
			$addBonus = $promotionalBonus->addBonus($playerId, substr($fund, 3), $lastDeposit);
			if($addBonus['error'])
			{
				$this->_helper->FlashMessenger(array('error' => $this->view->translate($addBonus['message'])));
			}*/
			$goalSession = new Zend_Session_Namespace('goalSession');
			$goalSession->value = true;
			$link = '<a href = "/game">real money tables</a>';
			$this->_helper->FlashMessenger(array('notice' => $this->view->translate("Congratulations!! Your account has been credited by %s", $fund)));
			$this->_helper->FlashMessenger(array('notice' => $this->view->translate("Alright!! Now it's time to win some big bucks playing at %s! Play now!", $link)));
			$this->view->fund = $fund;
		}
		$creditSession->unsetAll();
		//FIXME:: Add currency symbol
		//Done
		//$fund = $this->getRequest()->fund;
		//$this->view->message = $this->view->translate('Congratulation!! Your amount is credited by %s .', $fund);
	}
	
	public function depositAction()
	{	
		$frontendName = Zend_Registry::get('frontendName');
				
		$session = new Zend_Auth_Storage_Session();
		$store = $session->read();
		$playerId = $store['id'];
		
		$siteCode = Zend_Registry::getInstance()->get('siteCode');
		$gatewaysFile = APPLICATION_PATH . '/site_configs/' . $siteCode . '/gateways_order.json';
		$fh = fopen($gatewaysFile, 'r');
		$fileData = fread($fh, filesize($gatewaysFile));
			
		$accountVariable = new AccountVariable();
		$data['playerId'] = $playerId;
		$data['variableName'] = 'PTG';
		$accountVariableData = $accountVariable->getData($playerId, $data['variableName']);
			
		if(!$accountVariableData)
		{
			$vardata['playerId'] = $playerId;
			$vardata['variableName'] = 'PTG';
			$vardata['variableValue'] = $fileData;
			$accountVariable->insert($vardata);
				
			$accountVariableData = $accountVariable->getData($playerId, $data['variableName']);
		}
		$gatewaysOrder = Zend_Json::decode($accountVariableData['varValue']);
		$maxPriority = max($gatewaysOrder);
			
		foreach($gatewaysOrder as $index => $priority)
		{
			if($maxPriority == $priority)
			{
				$gateway = $index;
				break;
			}
		}
			
		$banksListFile = APPLICATION_PATH . '/site_configs/ace2jack/banks.json';
		//Enable it later
		/* switch($gateway)
		{
			case 'TECHPROCESS':
				$banksListFile = APPLICATION_PATH . '/configs/techprocess_banks.json';
				break;
			case 'CITRUSPAY':
				$banksListFile = APPLICATION_PATH . '/configs/citrus_banks.json';
				break;
		} */
			
		if(isset($banksListFile))
		{
			$fh = fopen($banksListFile, 'r');
			$fileData = fread($fh, filesize($banksListFile));
			$banksList = Zend_Json::decode($fileData);
				
			$this->view->banksList = $banksList;
		}
		
		$this->view->gateway = $gateway;
		
		$loginName = $store['authDetails'][0]['login'];
		$created = $store['authDetails'][0]['created'];
		$secretKey = md5($loginName . $created);
		$cardId = "";
		
		$cookie = isset($_COOKIE['transactionId'])?$_COOKIE['transactionId']:null;
		if($cookie)
		{
			$setTransactionId = $_COOKIE['transactionId'];
			$status = isset($_COOKIE['status'])?$_COOKIE['status']:'BACK';
			$playerTransactionRecord = new PlayerTransactionRecord();
			$playerTransactionRecord->updateData($playerId, $setTransactionId, 'status', $status);
		}
		setcookie('transactionId','',time(),'/','.'.$_SERVER['HTTP_HOST']);
		setcookie('status','',time(),'/');
		
		$playerData = $store['authDetails'][0];
		$bonusSchemeId = $playerData['bonus_scheme_id'];
		$noOfDeposit = $store['authDetails'][0]['noof_deposits'];
		$this->view->noOfDeposit = $noOfDeposit;
		
		$player = new Player();
		$playerDetails = $player->getPlayerData($playerId);
		$completed = true;
		if($playerDetails['dateOfBirth'] == '0000-00-00')
		{
			$completed = false;
		}
		if($completed)
		{
			$explodeDOB = explode('-', $playerDetails['dateOfBirth']);
			$this->view->dobYear = $explodeDOB[0];
			$this->view->dobMonth = $explodeDOB[1];
			$this->view->dobDate = $explodeDOB[2];
			foreach($playerDetails as $playerDetail)
			{
				if(!$playerDetail)
				{
					$completed = false;
					break;
				}
			}
		}
		
		$country = new Country();
		$countryCode = $playerData['country'];
		$allCountries = $country->getAllCountriesList();
		$this->view->allCountries = $allCountries;
		
		/* $date = new Zend_Date();
		$currentYear = $date->get(Zend_Date::YEAR); */
		$this->view->currentYear = Zend_Date::now()->get(Zend_Date::YEAR)-18;

		//$allowedMolPlayerIds = array(5,2130,52);
		//if(in_array($playerId, $allowedMolPlayerIds))
		//{
			$this->view->mol = true;
			$this->view->completed = $completed;
			$this->view->countryCode = $countryCode;
		//}
		

		$amount = $this->getRequest()->amount;
		$this->view->amount = $amount;
		if(isset($amount) && !in_array($amount, array('100', '250','500','1000','2000','5000')))
		{
			$this->view->customAmount = true;
		}
		
		$form = new Player_RegistrationForm();
		$this->view->editForm = $form->registration('edit');
		
		$ajax = $this->getRequest()->ajax;
		if($ajax)
		{
			Zend_Layout::getMvcInstance()->disableLayout();
			$this->view->ajaxReq = true;
			$message = "";
		}

		$accountVariable = new AccountVariable();
		if($frontendName == 'bingocrush.co.uk')
		{
			$playerCardDetails = new PlayerCardDetails();
			$cardDetails = $playerCardDetails->getCardDetails($playerId, $secretKey);
			$this->view->cardDetails = $cardDetails;
		}
		$error = false;
		if($this->getRequest()->isPost())
		{
			$formName = $_POST['formName'];
			$amountSession = new Zend_Session_Namespace('depositAmount');
			$playerNameSess = new Zend_Session_Namespace('name');
			$firstNameSess = new Zend_Session_Namespace('firstName');
			$lastNameSess = new Zend_Session_Namespace('lastName');
			$sexSess = new Zend_Session_Namespace('sex');
			$dobSess = new Zend_Session_Namespace('dob');
			$contactSess = new Zend_Session_Namespace('contact');
			$emailSess = new Zend_Session_Namespace('email');
			$addressSess = new Zend_Session_Namespace('address');
            $citySess = new Zend_Session_Namespace('city');
            $stateSess = new Zend_Session_Namespace('state');
            $countrySess = new Zend_Session_Namespace('country');
            $pinSess = new Zend_Session_Namespace('pin');
            $couponSess = new Zend_Session_Namespace('bonusCoupon');
            
			switch($formName)
			{
				case 'amount':
					$amount = $_POST['amount'];
					if(!$amount)
					{
						$error = true;
						$message = "Please select the amount";
					}
					if($frontendName == 'bingocrush.co.uk' && $amount<10)
					{
						$error = true;
						$message = "Please deposit minimum £10";
					}
					elseif($frontendName != 'bingocrush.co.uk' && $amount<100)
                    {
                    	$error = true;
                        $message = "Please deposit minimum 100";
                    }
					else
					{
						$varName = "PROFILE_PAGE";
						$pageCount = 0;
						$varData = $accountVariable->getData($playerId, $varName);
						if($varData)
						{
							$pageCount = $varData['varValue'];
						}
						$pageCount++;
						$data['playerId'] = $playerId;
						$data['variableName'] = $varName;
						$data['variableValue'] = $pageCount;
						$accountVariable->insert($data);
						
						$amountSession->value = $amount;
						echo $completed;
					}
					break;
				case 'profile':
					$firstName = $_POST['firstName'];
					$lastName = $_POST['lastName'];
					$sex = $_POST['sex'];
					$dob = $_POST['dob'];
					$contactNo = $_POST['contactNo'];
					$address = $_POST['address'];
					$city = $_POST['city'];
					$state = $_POST['state'];
					$pinCode = $_POST['pin'];
					$email = $_POST['email'];
					$countryName = $_POST['country'];
					foreach($_POST as $index => $postData)
					{
						if($index != 'ajax' && $index != 'formName')
						{
							if(!trim($postData))
							{
								switch($index)
								{
									case 'firstName':
										$index = 'First Name';
										break;
									case 'lastName':
										$index = 'Last Name';
										break;
									case 'contactNo':
										$index = 'Contact No';
										break;
									case 'address':
										$index = 'Address';
										break;
									case 'city':
										$index = 'City';
										break;
									case 'pin':
										$index = 'Pincode';
										break;
									case 'state':
										$index = 'State';
										break;
								}
								$error = true;
								$message = "Please fill " . $index;
								break;
							}
							elseif($index == 'dob' && $postData == '0000-00-00')
							{
								$index = 'Date Of Birth';
								$error = true;
								$message = "Please fill " . $index;
								break;
							}
							if($index == 'contactNo' && (!is_numeric($postData) || strlen($postData) < 10))
							{
								$error = true;
								$message = "Please enter valid phone number, it must be 10 digits long";
							}
						}
					}
							
					$playerNameSess->value = $firstName . " " . $lastName;
					$firstNameSess->value = $firstName;
					$lastNameSess->value = $lastName;
					$sexSess->value = $sex;
					$dobSess->value = $dob;
					$contactSess->value = $contactNo;
					$emailSess->value = $email;
                    $addressSess->value = $address;
                    $citySess->value = $city;
                    $stateSess->value = $state;
                    $pinSess->value = $pinCode;
                    $countrySess->value = $countryName;
                    
                    $varName = "PAYMENT_PAGE";
                    $pageCount = 0;
                    $varData = $accountVariable->getData($playerId, $varName);
                    if($varData)
                    {
                    	$pageCount = $varData['varValue'];
                    }
                    $pageCount++;
                    $data['playerId'] = $playerId;
                    $data['variableName'] = $varName;
                    $data['variableValue'] = $pageCount;
                    $accountVariable->insert($data);
                    
					break;
				case 'coupon':
					$couponCode = $_POST['couponCode'];
					if($couponCode)
					{
						$bonusCoupons = new BonusCoupons();
						$couponData = $bonusCoupons->getBonusCouponData($couponCode, $playerId);
						if(!$couponData)
						{
							$error = true;
							$message = "Invalid coupon.";
						}
						elseif($couponData['status'] == 'REDEEMED')
						{
							$error = true;
							$message = "This coupon is already redeemed. Would you like to enter another one?";
						}
						else
						{
							$couponSess->value = $couponCode;
						}
					}
					if($bonusSchemeId != $_POST['schemeId'])
					{
						$schemeSess = new Zend_Session_Namespace('schemeId');
						$schemeSess->value = $_POST['schemeId'];
					}
					break;
				case 'payment':
					$paymentType = $_POST['paymentType'];
					$amount = $amountSession->value;
					switch($paymentType)
					{
						case 'CASH':
							if($amount < 1000)
							{
								$error = true;
								$message = "For Cash On Delivery, minimum deposit amount is Rs. 1000";
							}
							if(!$error)
							{
								try
								{
									$city = $citySess->value;
									$soapClient = new SoapClient("http://services.gharpay.in/GharpayService?wsdl", array('trace' => 1));
									$headerUser=new SoapHeader("http://webinterface.webservices.gharpay.com","username", "taashtime_api");
									$headerPass = new SoapHeader("http://webinterface.webservices.gharpay.com","password", "t6e4#wno");
									$soapClient->__setSoapHeaders(array($headerUser,$headerPass));
									$pinCodes = $soapClient->getPincodesInCity($city);
								}
								catch(Exception $e)
								{
									//print $e->getMessage();
								}
								$pinCodeMatched = false;
								$pin = $pinSess->value;
								foreach($pinCodes->item as $pinCode)
								{
									if($pinCode == $pin)
									{
										$pinCodeMatched = true;
										break;
									}
								}
								if(!$pinCodeMatched)
								{
									$error = true;
									$message = "Please enter a valid pin code and city.";
								}
							}
							break;
						case 'NETBANKING':
							if($amount < 100)
							{
								$error = true;
								$message = "Please deposit minimum 100 or above.";
							}
							if(isset($_POST['bankCode']))
							{
								$bankCode = $_POST['bankCode'];
								$bankCodeSession = new Zend_Session_Namespace('bankCode');
								$bankCodeSession->value = $bankCode;
							}
							break;
						case 'DEBIT':
						case 'CREDIT':
							if($frontendName == 'bingocrush.co.uk' && $amount < 10)
							{
								$error = true;
								$message = "Please deposit minimum £10 or above.";
							}
							elseif($frontendName != 'bingocrush.co.uk' && $amount<100)
                            {
                            	$error = true;
                                $message = "Please deposit minimum 100";
                            }
							elseif($frontendName == 'bingocrush.co.uk')
							{
								$validMonth = '';
								$validYear = '';
								if(!isset($_POST['cardId']))
								{
									$expiryMonth = $_POST['exMonth'];
									$expiryYear = $_POST['exYear'];
									$cardNo = $_POST['cardNo'];
									$cvcNo = $_POST['cvcNo'];
									$issueNo = $_POST['issueNo'];
									$cardSubType = $_POST['cardSubType'];
									$cardHolderFirstName = $_POST['firstName'];
									$cardHolderLastName = $_POST['lastName'];
									
									if($paymentType == 'DEBIT')
									{
										$validMonth = $_POST['valMonth'];
										$validYear = $_POST['valYear'];
									}
									
									$cardData['firstName'] = $_POST['firstName'];
									$cardData['lastName'] = $_POST['lastName'];
									$cardData['address'] = $addressSess->value;
									$cardData['city'] = $citySess->value;
									$cardData['state'] = $stateSess->value;
									$cardData['zip'] = $pinSess->value;
									$cardData['country'] = $countrySess->value;
									$cardData['cardNo'] = $_POST['cardNo'];
									$cardData['cvcNo'] = $_POST['cvcNo'];
									$cardData['exMonth'] = $_POST['exMonth'];
									$cardData['exYear'] = $_POST['exYear'];
									$cardData['issueNo'] = $_POST['issueNo'];
									$cardData['type'] = $paymentType;
									$cardData['subType'] = $cardSubType;
									$cardData['secretKey'] = $secretKey;
									$cardData['valMonth'] = $validMonth;
									$cardData['valYear'] = $validYear;
									
									$cardId = $playerCardDetails->addCardDetail($playerId, $cardData);
								}
								else
								{
									$cardDetails = $playerCardDetails->getCardDetailsById($_POST['cardId'], $playerId, $secretKey);
									$expiryMonth = $cardDetails['card_expiry_month'];
									$expiryYear = $cardDetails['card_expiry_year'];
									$cardNo = $cardDetails['card_no'];
									$cvcNo = $cardDetails['card_cvc_no'];
									$issueNo = $cardDetails['card_issue_number'];
									$cardSubType = $cardDetails['card_subtype'];
									$cardHolderFirstName = $cardDetails['card_holder_first_name'];
									$cardHolderLastName = $cardDetails['card_holder_last_name'];
									if($paymentType == 'DEBIT')
									{
										$validMonth = $cardDetails['card_valid_month'];
										$validYear = $cardDetails['card_valid_year'];
									}
									$cardId = $_POST['cardId'];
								}
							}
							else
							{
								 $bankCode = 670;
								 $bankCodeSession = new Zend_Session_Namespace('bankCode');
								 $bankCodeSession->value = $bankCode;
							}
							break;
						case 'MOL':
							if($amount < 100)
							{
								$error = true;
								$message = "Please deposit minimum 100 or above.";
							}
							elseif($amount > 8000)
							{
								$error = true;
								$message = "You can't deposit more than £8000";
							}
							break;
						case 'WT':
							$acNumber = $_POST['acNumber'];
							$acName = $_POST['acName'];
							$bankName = $_POST['bankName'];
							$transAmount = $_POST['transAmount'];
							$bankTransId = $_POST['bankTransId'];
							
							if(!$acNumber || !$acName || !$bankName || !$transAmount || !$bankTransId)
							{
								$error = true;
								$message = "Please fill the details.";
							}
							else
							{
								$data['acNumber'] = $acNumber;
								$data['acName'] = $acName;
								$data['bankName'] = $bankName;
								$data['transAmount'] = $transAmount;
								$data['bankTransId'] = $bankTransId;
								$data['playerId'] = $playerId;
								
								$wireTransfer = new WireTransfer();
								$addRecords = $wireTransfer->addRecords($data);
								if(!$addRecords)
								{
									$error = true;
									$message = "Some problem has been occured while putting the request. Please try again. If you still face the same problem, please contact to our customer support.";
								}
							}
							break;
						case 'MOBIKWIK':
							if($amount < 100)
							{
								$error = true;
								$message = "Please deposit minimum 100 or above.";
							}
							break;
					}
					if(!$error)
					{
						$editData['first_name'] = $firstNameSess->value;
						$editData['last_name'] = $lastNameSess->value;
						$editData['sex'] = $sexSess->value;
						$editData['dateofbirth'] = $dobSess->value;
						$editData['phone'] = $contactSess->value;
						$editData['address'] = $addressSess->value;
						$editData['city'] = $citySess->value;
						$editData['state'] = $stateSess->value;
						$editData['pin'] = $pinSess->value;
						$editData['country'] = $countrySess->value;
						if(!$completed)
						{
							$player->editProfile($editData, $playerId);
						}
						else
						{
							$playerNameSess->value = $playerData['first_name'] . " " . $playerData['last_name'];
							$firstNameSess->value = $playerData['first_name'];
							$lastNameSess->value = $playerData['last_name'];
							$sexSess->value = $playerData['sex'];
							$dobSess->value = $playerData['dateofbirth'];
							$contactSess->value = $playerData['phone'];
							$emailSess->value = $playerData['email'];
							$addressSess->value = $playerData['address'];
							$citySess->value = $playerData['city'];
							$stateSess->value = $playerData['state'];
							$pinSess->value = $playerData['pin'];
							$couponSess->value = $playerData['country'];
							$countrySess->value = $playerData['country'];
						}
						
						$paymentTypeSession = new Zend_Session_Namespace('paymentType');
						$paymentTypeSession->value = $paymentType;
						if($frontendName == 'bingocrush.co.uk')
						{
							$clientIpAddress = Zend_Controller_Front::getInstance()->getRequest()->getClientIp();
							$data['ipAddress'] = $clientIpAddress;
							$data['amount'] = $amountSession->value;
							$data['gatewayId'] = 'LPS';
							$data['playerId'] = $playerId;
							$data['currencyCode'] = $playerData['base_currency'];
							$data['paymentMethod'] = $paymentTypeSession->value;
							$data['status'] = 'UNPROCESSED';
							$data['requestUrl'] = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
							
							$transaction = new PlayerTransactionRecord();
							$transactionId = $transaction->insertData($data);
							//$transactionId = mt_rand(1, 100000);
							
							if($paymentType == 'CREDIT' || $paymentType == 'DEBIT')
							{
								//FOR SCSS TESTING ACCOUNT
								/* $postArray['merchant_User_Id'] = 'test_progaming';
								$postArray['merchantpwd'] = 'NI4TH6NZEEziFgvCpAty'; */
								
								//FOR 3D SECURE
								/* $postArray['merchant_User_Id'] = 'test_progaming_3d';
								$postArray['merchantpwd'] = '0vh6uj0CrrcLsJYpTnWb'; */
								
								//FOR SCSS LIVE
								$postArray['merchant_User_Id'] = 'LPS_PRO_bingocrush_s';
                                $postArray['merchantpwd'] = 'D8uJ7wDP44pY5Wl2g0ko';
								$postArray['merchant_ipaddress'] = '88.208.236.120';
								$postArray['customer_firstname'] = $firstNameSess->value;
								$postArray['customer_lastname'] = $lastNameSess->value;
								$postArray['customer_phone'] = $contactSess->value;
								$postArray['customer_email'] = $emailSess->value;
								$postArray['customer_ipaddress'] = Zend_Controller_Front::getInstance()->getRequest()->getClientIp();
								$postArray['bill_firstname'] = $cardHolderFirstName;
								$postArray['bill_lastname'] = $cardHolderLastName;
								$postArray['bill_address1'] = $addressSess->value;
								$postArray['bill_city'] = $citySess->value;
								$postArray['bill_country'] = $countrySess->value;
								$postArray['bill_zip'] = $pinSess->value;
								$postArray['customer_cc_expmo'] = $expiryMonth;
								$postArray['customer_cc_expyr'] = $expiryYear;
								$postArray['customer_cc_number'] = $cardNo;
								$postArray['customer_cc_type'] = $cardSubType;
								$postArray['customer_cc_cvc'] = $cvcNo;
								$postArray['merchant_ref_number'] = $transactionId;
								$postArray['currencydesc'] = $playerData['base_currency'];
								//$postArray['currencydesc'] = "GBP";
								$postArray['amount'] = $amountSession->value;
								$postArray['scsscheck'] = 'Y';
								if($paymentType == 'DEBIT')
								{
									$postArray['customer_dc_startmo'] = $validMonth;
									$postArray['customer_dc_startyr'] = $validYear;
									$postArray['customer_dc_issue'] = $issueNo;
								}
								//Zenfox_Debug::dump($postArray, 'post', true, true);
									
								//FOR SCSS TESTING ACCOUNT
								//$client = new Zend_Http_Client('https://l2p0s5p0r2o1c7e1ss.com/payment/test/payment.asp');
								
								//FOR 3D SECURE
								//$client = new Zend_Http_Client('https://l2p0s5p0r2o1c7e1ss.com/payment/3dsecure/Test/payment.asp');
								
								//FOR SCSS LIVE
								$client = new Zend_Http_Client('https://l4p2s7p2r4o3c9e3ss.com/ProcessRequest/ProcessRequest.aspx');
								
								$client->setParameterPost($postArray);
								$client->request(Zend_Http_Client::POST);
								$response = $client->getLastResponse()->getBody();
								//Zenfox_Debug::dump($response, 'res', true, true);
								$data['playerId'] = $playerId;
								$data['gatewayResponse'] = $response;
								$response = explode('&', $response);
								$finalDataArray = array();
								foreach($response as $responseData)
								{
									$explodeResponseData = explode("=", $responseData);
									$finalDataArray[$explodeResponseData[0]] = $explodeResponseData[1];
									//Zenfox_Debug::dump($explodeResponseData, 'exData');
								}
								
								
								/* if($finalDataArray['ResponseType'] == 2)
								{
									$mdString = "TransactionId=" . $finalDataArray['LPS_transaction_id'] .
												"&Merchant_ref_number=" . $finalDataArray['Merchant_ref_number'] . 
												"&BackToMerchantURL=grp77_BRplMo";
									
									$vbvUrl = $finalDataArray['VBV_URL'];
									$md = urlencode($mdString);
									$paReq = $finalDataArray['PAReq'];
									$termUrl = "https://l2p0s5p0r2o1c7e1ss.com/payment/3Dsecure/test/3dTermUrl.asp";
									
									echo $vbvUrl . "&" . $md . "&" . $paReq . "&" . $termUrl;
								} */
								
								
								
								if($cardId)
								{
									$cardToken = $finalDataArray['CrdStrg_Token'];
									$playerCardDetails = new PlayerCardDetails();
									$playerCardDetails->updateCardDetail($cardId, $playerId, $cardToken, $secretKey);
								}
								
								$explodeDate = explode('/', $finalDataArray['Bank_date']);
								$gatewayTransTime = $explodeDate[2] . '-' . $explodeDate[1] . '-' . $explodeDate[0] . ' ' . $finalDataArray['Bank_time'];
								
								$data['gatewayTransId'] = $finalDataArray['LPS_transaction_id'];
								$data['bankName'] =  $cardId;
								$data['status'] = 'PROCESSED';
								$data['responseUrl'] = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
								$data['gatewayTransTime'] =  $gatewayTransTime;
								$data['result'] = $finalDataArray['Fraudscreening_status'];
								$transactionId = $finalDataArray['Merchant_ref_number'];
								
								
								//Zenfox_Debug::dump($response, 'response');
								$url = 'https://' . $_SERVER['HTTP_HOST'] . '/banking/confirm';
								//$url = "";
								$depositSession = new Zend_Session_Namespace('depositSession');
																
								if($finalDataArray['ResponseType'] == 1 && $finalDataArray['Fraudscreening_status'] == 0)
								{
									$error = false;
									
									if($finalDataArray['Bank_status'] == 00)
									{
										$transaction->updateRecords($data, $transactionId);
										$transactionObj = new Transactions();
										$creditAmount = $transactionObj->credit('DEPOSIT', $playerId, $amountSession->value, $playerData['base_currency'], $transactionId, '', $playerData['tracker_id']);
										if(!$creditAmount['success'])
										{
											$error = true;
										}
											
										if(!$error)
										{
											$player = new Player();
											$playerDetail = $player->getAccountDetails($playerId);
											$playerData = $playerDetail[0];
											$amount = $amountSession->value;
											
											$depositBonus = new DepositBonus();
											$bonusPercentage = $depositBonus->getBonusPercentage($amount);
											if($bonusPercentage && $playerData['noof_deposits'] != 1)
											{
												if($playerData['noof_deposits'] == 3)
                                                                                                {
                                                                                                        $bonusPercentage = 4;
                                                                                                }

												$bonusAmount = $amount * $bonusPercentage;
												$creditBonus = $transactionObj->credit('BONUS', $playerId, $bonusAmount, $playerData['base_currency'], $transactionId, '', '', "Bonus on Deposit");
												if(!$creditBonus['success'])
												{
													$error = true;
												}
											}
										
											/* if($playerData['noof_deposits'] == 1)
											{
												$bonusAmount = $amount * 5;
												$creditBonus = $transactionObj->credit('BONUS', $playerId, $bonusAmount, $playerData['base_currency'], $transactionId, '', '', "First Time Depositor");
												if(!$creditBonus['success'])
												{
													$error = true;
												}
											} */
										
											$prevLoyaltyPoints = $player->getLoyaltyPoints($playerId);
											$totalLoyaltyPoints = $prevLoyaltyPoints['totalLoyaltyPoints'];
											$loyaltyPointsLeft = $prevLoyaltyPoints['loyaltyPointsLeft'];
										
											if($playerData['noof_deposits'] <= 3)
											{
												$currentTotalLoyaltyPoints = $totalLoyaltyPoints + $amount * 3;
												$currentLoyaltyPointsLeft = $loyaltyPointsLeft + $amount * 3;
											}
											else
											{
												$currentTotalLoyaltyPoints = $totalLoyaltyPoints + $amount;
												$currentLoyaltyPointsLeft = $loyaltyPointsLeft + $amount;
											}
											$player->updateLoyaltyPoints($playerId, $currentTotalLoyaltyPoints, $currentLoyaltyPointsLeft);
												
											if(!$error)
											{
												$depositSession->value = true;
												echo $url;
											}
											else
											{
												$depositSession->value = false;
												echo $url;
											}
										}
										else
										{
											$depositSession->value = false;
											echo $url;
										}
									}
									else
									{
										$data['status'] = 'ERROR';
										$data['result'] = $finalDataArray['Bank_status'];
										$transaction->updateRecords($data, $transactionId);
										$depositSession->value = false;
										echo $url;
									}
								}
								elseif($finalDataArray['LPS_transaction_id'] == -1)
								{
									$transactionId = $transaction->getTransactionId($playerId);
									$data['status'] = 'ERROR';
									$data['gatewayTransId'] = "LPS - " . $transactionId;
									$transaction->updateRecords($data, $transactionId);
									$depositSession->value = false;
									echo $url;
								}
								else
								{
									$depositSession->value = false;
									echo $url;
								}
							}
						}
						elseif($paymentType == 'WT')
						{
							$subject = "Wire Transfer - " . $playerId . " - " . $store['authDetails'][0]['login'];
							$message = $store['authDetails'][0]['login'] . " has put a request for Rs. " . $transAmount .
									"<br><b>Details:<br><br>Player Id - " . $playerId . "<br>Bank Account Number - " . $acNumber
									. "<br>Account Holder Name - " . $acName . "<br>Bank Name - " . $bankName . 
									"<br>Bank Transaction Id - " . $bankTransId . "<br>Amount - " . $transAmount;
							
							$emails = array('yaswanth@fortuity.in', 'support@taashtime.com');
							foreach($emails as $email)
							{
								$mail = new Mail();
								$mail->sendMails($subject, $message, $message, $email, '', '');
							}
							
							echo "success&WT&Thank you for depositing! We have sent a request to our Account Team. They	will process your request and add the money to your Taashtime account.";
						}
						else
						{
							$url = 'https://' . $_SERVER['HTTP_HOST'] . '/transaction/index';
                            echo "success&".$url;						
						}
					}
					break;
			}
		}
		else
		{
			$varName = "AMOUNT_PAGE";
			$pageCount = 0;
			$varData = $accountVariable->getData($playerId, $varName);
			if($varData)
			{
				$pageCount = $varData['varValue'];
			}
			$pageCount++;
			$data['playerId'] = $playerId;
			$data['variableName'] = $varName;
			$data['variableValue'] = $pageCount;
			$accountVariable->insert($data);
		}
		if($error)
		{
			echo "error&".$message;
		}
		
		$withdrawalRequest = new WithdrawalRequest();
		$data = $withdrawalRequest->adminGetDetails($playerId);
		$totalRemainingAmount = 0;
		if($data)
		{
			foreach($data as $withdrawalData)
			{
				$totalRemainingAmount += $withdrawalData['Remaining Amount'];
			}
		}

		//$totalRemainingAmount = 500;
		$this->view->withdrawalAmount = $totalRemainingAmount;
		
		$loginName = $playerData['login'];
		$firstName = $playerData['first_name'];
		
		$playerName = empty($firstName)?$loginName:$firstName;
		
		$this->view->firstName = $firstName;
		$this->view->lastName = $playerData['last_name'];
		$this->view->sex = $playerData['sex'];
		$this->view->dob = $playerData['dateofbirth'];
		$this->view->city = $playerData['city'];
		//$this->view->playerName = $playerName;
		$this->view->phone = $playerData['phone'];
		$this->view->email = $playerData['email'];
		$this->view->address = $playerData['address'];
		$this->view->pin = $playerData['pin'];
		$this->view->state = $playerData['state'];

		$index = 0;
		$cityList = array();
		$cityList[$index]['label'] = 'Hyderabad';
		$cityList[$index]['value'] = 'Hyderabad';
		$index++;
		$cityList[$index]['label'] = 'Chennai';
		$cityList[$index]['value'] = 'Chennai';
		$index++;
		$cityList[$index]['label'] = 'Mumbai';
		$cityList[$index]['value'] = 'Mumbai';
		$index++;
		$cityList[$index]['label'] = 'Navi Mumbai';
		$cityList[$index]['value'] = 'Navi Mumbai';
		$index++;
		$cityList[$index]['label'] = 'Thane';
		$cityList[$index]['value'] = 'Thane';
		$index++;
		$cityList[$index]['label'] = 'Bangalore';
		$cityList[$index]['value'] = 'Bangalore';
		$index++;
		$cityList[$index]['label'] = 'Pune';
		$cityList[$index]['value'] = 'Pune';
		$index++;
		$cityList[$index]['label'] = 'New Delhi';
		$cityList[$index]['value'] = 'New Delhi';
		$index++;
		$cityList[$index]['label'] = 'Ghaziabad';
		$cityList[$index]['value'] = 'Ghaziabad';
		$index++;
		$cityList[$index]['label'] = 'Noida';
		$cityList[$index]['value'] = 'Noida';
		$index++;
		$cityList[$index]['label'] = 'Gurgaon';
		$cityList[$index]['value'] = 'Gurgaon';
		$index++;
		$cityList[$index]['label'] = 'Visakhapatnam';
		$cityList[$index]['value'] = 'Visakhapatnam';
		$index++;
		$cityList[$index]['label'] = 'Delhi';
		$cityList[$index]['value'] = 'DELHI';
		$index++;
		$cityList[$index]['label'] = 'Faridabad';
		$cityList[$index]['value'] = 'Faridabad';
		$index++;
		$cityList[$index]['label'] = 'Kolkata';
		$cityList[$index]['value'] = 'Kolkata';
		$index++;
		$cityList[$index]['label'] = 'Chandigarh';
		$cityList[$index]['value'] = 'Chandigarh';
		$index++;
                $cityList[$index]['label'] = 'Ahmedabad';
                $cityList[$index]['value'] = 'Ahmedabad';
		
		foreach($cityList as $index => $cities)
		{
			if($cities['value'] == $playerData['city'])
			{
				$cityList[$index]['selected'] = "selected";
			}
		}
		
		$this->view->cityList = $cityList;
		
		$bonusScheme = new BonusScheme();
		$allBonusSchemes = $bonusScheme->getAllSchemeData();
		$this->view->bonusSchemes = $allBonusSchemes;
	}

	public function funcoinsAction()
	{
		$form = new Player_InviteFriendForm();
		$this->view->form = $form;
		
		$authSession = new Zenfox_Auth_Storage_Session();
		$playerDetails = $authSession->read();
		$playerId = $playerDetails['id'];
		
		$amount = $this->getRequest()->amount;
		if($amount)
		{
			$this->view->form = "";
			$totalBalance = $playerDetails['authDetails'][0]['bank'] + $playerDetails['authDetails'][0]['winnings'] + $playerDetails['authDetails'][0]['bonus_bank'] + $playerDetails['authDetails'][0]['bonus_winnings'];
			if($totalBalance >= $amount)
			{
				$playerTransactions = new PlayerTransactions();
				$sourceId = $playerTransactions->placeWager($playerId, $amount, 'BOTH', NULL, "Purchased Funcoins");
			
				if(!$sourceId)
				{
					$this->_helper->FlashMessenger(array('error' => $this->view->translate("Some problem has been occured while converting TaashCash to FunConis. Please try again, if the problem persists then please contact to our customer support.")));
				}
				else
				{
					$auditReport = new AuditReport();
					$reportMessage = $auditReport->checkError($sourceId, $playerId);
						
					$counter = 0;
					while((!($reportMessage['processed'] == 'PROCESSED')) && (!($reportMessage['error'] == 'NOERROR')))
					{
						if($counter == 3)
						{
							break;
						}
						$reportMessage = $auditReport->checkError($sourceId, $playerId);
						if($reportMessage)
						{
							break;
						}
							
						$counter++;
					}
					if($counter == 3 && !$reportMessage)
					{
						$this->_helper->FlashMessenger(array('error' => $this->view->translate("Some problem has been occured while converting TaashCash to FunConis. Please contact to our customer support with Source Id - $sourceId.")));
					}
					if(($reportMessage['processed'] == 'PROCESSED') && ($reportMessage['error'] == 'NOERROR'))
					{
						$accountVariable = new AccountVariable();
						$varData = $accountVariable->getData($playerId, 'freeMoney');
						if($varData)
						{
							$freeMoney = floatval($varData['varValue']);
						}
						switch($amount)
						{
							case '10':
								$freeMoney += 1000;
								break;
							case '25':
								$freeMoney += 2750;
								break;
							case '50':
								$freeMoney += 6000;
								break;
							case '100':
								$freeMoney += 12500;
								break;
							case '500':
								$freeMoney += 75000;
								break;
						}
						$varId = $varData['varId'];
						$data['varId'] = $varId;
						$data['playerId'] = $playerId;
						$data['variableValue'] = $freeMoney;
						$updateFreeMoney = $accountVariable->update($data);
						if($updateFreeMoney)
						{
							$this->_helper->FlashMessenger(array('notice' => $this->view->translate("Congratulation!!")));
						}
						else
						{
							$this->_helper->FlashMessenger(array('error' => $this->view->translate("Some problem has been occured while converting TaashCash to FunConis. Please contact to our customer support with FunCoin Id - $varId.")));
						}
					}
					elseif($counter != 3)
					{
						$this->_helper->FlashMessenger(array('error' => $this->view->translate("Some problem has been occured while converting TaashCash to FunConis. Please contact to our customer support with Source Id - $sourceId.")));
					}
				}
			}
			else
			{
				$this->_helper->FlashMessenger(array('error' => $this->view->translate("Sorry! You don't have enough TaashCash in your account. Do you want to get TaashCash? <a href='/banking/deposit'> Click Here </a>")));
			}
		}
		
		$facebook = $this->getRequest()->facebook;
		if($facebook)
		{
			Zend_Layout::getMvcInstance()->disableLayout();
			$accountVariable = new AccountVariable();
			$data['playerId'] = $playerId;
			$data['variableName'] = 'FACEBOOK_LIKE';
			$accountVariableData = $accountVariable->getData($playerId, $data['variableName']);
			$this->view->form = "";
			
			// if is true for the first time login (after the daily bonus is implemented) only
			if(!$accountVariableData)
			{
				$data['variableValue'] = 1;
				$accountVariable->insert($data);
				
				$data['variableName'] = 'freeMoney';
				$accountVariableData = $accountVariable->getData($playerId, $data['variableName']);
				
				$varId = $accountVariableData['varId'];
				$data['varId'] = $varId;
				$data['variableValue'] = floatval($accountVariableData['varValue']) + 20000;
				$accountVariable->insert($data);
				echo "Congratulation!! 20,000 free coins added to your account successfully!";
			}
			else
			{
				echo "Sorry!! You have already got free coins.";
			}
		}
	}

	public function detailAction()
	{
		//echo "in detail";
	}
	
	public function confirmAction()
	{		
		$depositSession = new Zend_Session_Namespace('depositSession');
		$authSession = new Zenfox_Auth_Storage_Session();
		$sessionData = $authSession->read();
		$playerId = $sessionData['id'];

		if($playerId == 1)
		{
			//$playerIds = array(190,158,48,950,30,133,109,443,228,267,492,100,582,705,346,592,363,553,34,964,210,493,380,478,131,399,268,102,89,123,63,19,26,130,204,406,322,704,368,155,527,438,144,156,435,54,25,80,142,982,97,511,407,271,526,357,651,115,148,393,62,32,425,499,129,284,186,658,281,170,205,189,283,473,317,571,678,989,287,193,898,454,304,917,977,884,615,424,306,187,909,291,272,742,865,185,367,453,888,924,613,942,616,968,781,819,802,376,854,415,979,501,881,27,563,42,653,770,800,516,714,297,31,628,625,601,985,179,599,342,806,436,480,104,926,401,586,947,397,870,718,701,348,47,52,206,325,450,697,128,149,414,943,717,440,197,965,963,316,900,788,880,364,576,337,552,213,930,585,41,784,661,486,95,312,125,953,995,39,575,53,244,154,715,432,666,177,949,908,199,863,724,35,911,233,292,238,419,75,315,521,24,173,449,347,86,216,891,475,20,33,83,101,584,538,251,554,182,349,699,452,208,122,933,365,951,434,261,116,21,175,139,92,712,503,808,103,614,894,150,293,519,604,55,288,624,318,106,141,286,483,236,270,294,510,181,938,905,279,90,108,574,734,217,76,439,301,17,307,194,136,685,79,249,282,64,246,314,392,416,518,241,253,255,290,159,229,396,378,427,515,361,46,420,87,289,437,82,370,172,298,73,219,524,207,345,81,37,165,687,321,428,221,431,258,262,410,231,239,381,105,529,308,118,242,117,137,489,491,462,66,302,110,226,232,256,61,71,85,355,359,366,223,387,212,88,522,36,285,160,58,84,166,200,240,260,350,422,389,433,487,535,472,275,94,512,310,502,446,423,528,211,91,477,60,180,250,274,444,490,167,201,299,451,509,408,506,495,409,114,43,500,78,300,151,222,247,277,353,411,507,44,178,192,198,254,276,352,498,540,77,99,145,215,237,537,539,184,690,787,725,319,126,730,864,743,944,642,494,313,448,391,587,741,907,605,970,768,677,545,925,464,882,305,496,793,923,203,74,899,617,700,934,627,707,945,600,958,783,214,634,385,169,689,731,681,914,931,867,135,929,903,890,597,29,629,732,957,726,610,859,196,713,654,733,649,388,402,330,146,798,635,22,789,65,227,591,514,533,667,675,630,941,67,138,482,479,549,686,991,140,855,127,612,790,738,996,636,631,120,640,961,191,723,893,694,555,174,637,645,993,669,481,978,623,303,851,505,119,394,369,218,919,975,883,93,418,818,588,484,266,259,577,889,668,773,430,532,626,132,974,702,691,638,607,660,728,706,643,517,404,551,873,959,708,992,51,541,445,853,698,720,278,609,265,40,722,195,960,442,340,633,906,901,188,710,377,426,602,608,593,810,771,650,375,343,727,230,655,737,695,927,344,455,558,441,861,356,939,955,157,611,400,811,386,581,709,334,264,372,918,916,379,940,716,641,928,488,799,384,673,578,589,688,663,263,684,579,904,922,980,245,858,648,362,373,862,910,235,671,504,536,544,652,622,520,994,872,719,981,550,857,580,676,657,659,801);
			//$playerIds = array(1);
			/*foreach($playerIds as $id)
			{
				$player = new Player();
                                $playerDetail = $player->getAccountDetails($id);
                                $playerData = $playerDetail[0];
				//Zenfox_Debug::dump($playerData, 'data');
				$transactionObj = new Transaction();
        	                $creditAmount = $transactionObj->credit('BONUS', $id, 5, $playerData['base_currency'], '', '', $playerData['tracker_id'], 'Bonus amount on date 2013-06-13');
				Zenfox_Debug::dump($id . ' -> ' . $creditAmount, 'amount');
			}*/
		}
		$playerData = $sessionData['authDetails'][0];
			
		$auditReport = new AuditReport();
		$lastTransaction = $auditReport->getRecentTransactionByPlayerId($playerId, 'CREDIT_DEPOSITS');
		$contentData = array();
		if($lastTransaction)
		{
			$contentData[0]['Real Balance'] = $lastTransaction[0]['cash_balance'];
			$contentData[0]['Bonus Balance'] = $lastTransaction[0]['bb_balance'];
			$contentData[0]['Total Balance'] = $lastTransaction[0]['cash_balance'] + $lastTransaction[0]['bb_balance'];
			$this->view->contents = $contentData;
		}
		if($depositSession->value)
		{
			if($lastTransaction)
			{
				$this->view->message = "Thanks for your deposit. Your account is now credited with " .  $lastTransaction[0]['amount'] . " Cash.";
			}
			else
			{
				$this->view->message = "Some problem has been occured while processing the request. Please contact to our customer support.";
			}
		}
		else
		{
			$playerTransactionRecord = new PlayerTransactionRecord();
			$transactionId = $playerTransactionRecord->getTransactionId($playerId);
			$transactionData = $playerTransactionRecord->getTransactionData($playerId, $transactionId);
			$transResult = $transactionData['result'];
			//$transResult = 9003;
			
			$errorFile = APPLICATION_PATH . '/site_configs/bingocrush/LPSErrorCode.json';
			$fh = fopen($errorFile, 'r');
			$jsonData = fread($fh, filesize($errorFile));
			$errorCodes = Zend_Json::decode($jsonData);
			
			$this->view->message = $errorCodes[$transResult];
		}
	}
	
	public function convertlpAction()
	{
		$authSession = new Zenfox_Auth_Storage_Session();
		$sessionData = $authSession->read();
		//Zenfox_Debug::dump($sessionData, 'data');
			
		$playerId = $sessionData['id'];
		$loyaltyPointsLeft = $sessionData['authDetails'][0]['loyalty_points_left'];
		$totalLoyaltyPoints = $sessionData['authDetails'][0]['total_loyalty_points'];
		$schemeId = $sessionData['authDetails'][0]['bonus_scheme_id'];
		
		$this->view->lpl = $loyaltyPointsLeft;
		$this->view->tlp = $totalLoyaltyPoints;
		
		$tradeArray = array(5000,10000,15000,20000);
		$bonusLevel = new BonusLevel();
		$currentLevel = $bonusLevel->getLevelIdByPoints($loyaltyPointsLeft, $playerId, $schemeId);
		$levelId = $currentLevel['id'];
		
		$this->view->currentLevel = $levelId;
		$this->view->convertLP = $tradeArray[$levelId-1];
		
		if($_POST)
		{
			$lp = $_POST['lp'];
			$lastDeposit = $sessionData['authDetails'][0]['last_deposit'];
			
			$dateObject = new Zend_Date();
			$currentWeekDayNumber = $dateObject->get(Zend_Date::WEEKDAY_DIGIT);
			$currentWeekDayNumber--;
			$date1 = Zend_Date::now()->addDay("-$currentWeekDayNumber");
			
			$lastWeekDate = $date1->get(Zend_Date::W3C);
			
			$lastWeekDate = explode("T", $lastWeekDate);
			$lastWeekDate = $lastWeekDate[0] . " 00:00:00";
			
			$staticDate = new Zend_Date($lastWeekDate);
			$lastDepositDate = new Zend_Date($lastDeposit);
			$diff = $lastDepositDate->compare($staticDate);
			
			if($lastDeposit && $lastDeposit != '0000-00-00 00:00:00' && $diff >= 0)
			{
				if($lp > $loyaltyPointsLeft)
				{
					$this->_helper->FlashMessenger(array("error" => "<b>You have insufficient laoyalty points.</b>"));
				}
				else
				{
					$bonusAmount = $lp / 100;
					 
					$loyaltyToBonus = new LoyaltyToBonus();
					$convertedLP = $loyaltyToBonus->getConvertedLoyaltyPoints($playerId, $lastWeekDate);
					
					if(!$convertedLP || $convertedLP < $tradeArray[$levelId - 1])
					{
						if(($convertedLP + $lp) <= $tradeArray[$levelId - 1])
						{
							$data['playerId'] = $playerId;
							$data['convertedLP'] = $lp;
							$data['prevLP'] = $loyaltyPointsLeft;
							$data['currentLP'] = $loyaltyPointsLeft - $lp;
							$data['bonus'] = $bonusAmount;
							$data['levelId'] = $levelId;
								
							$l2bId = $loyaltyToBonus->addRecords($data);
								
							$transactionObj = new Transaction();
							$creditBonus = $transactionObj->credit('BONUS', $playerId, $bonusAmount, $sessionData['authDetails'][0]['base_currency'], '', '', '', "Convert loyalty points to bonus");
							if($creditBonus['success'])
							{
								$sourceId = $creditBonus['sourceId'];
								$loyaltyToBonus->updateSourceId($playerId, $l2bId, $sourceId);
								$currentTotalLoyaltyPoints = $totalLoyaltyPoints;
								$currentLoyaltyPointsLeft = $loyaltyPointsLeft - $lp;
								$this->view->lpl = $currentLoyaltyPointsLeft;
							
								$player = new Player();
								$player->updateLoyaltyPoints($playerId, $currentTotalLoyaltyPoints, $currentLoyaltyPointsLeft);
								$this->_helper->FlashMessenger(array("notice" => "<b>Congratulation!! You have successfully converted loyalty points to bonus.</b>"));
							}
							else
							{
								$this->_helper->FlashMessenger(array('error' => $creditBonus['error']));
							}
						}
						else
						{
							$this->_helper->FlashMessenger(array('error' => '<b>You can convert upto ' . $tradeArray[$levelId -1] . ' loyalty points in a week. Please enter valid loyalty points.</b>'));
						}
					}
					else
					{
						$this->_helper->FlashMessenger(array('error' => '<b>You have already converted to maximum limit. Please try next week.</b>'));
					}
				}
			}
			else
			{
				$this->_helper->FlashMessenger(array('error' => '<b>You do not have any deposit in this week. Please deposit first.</b>'));
			}
		}
	}
	
	public function faqAction()
	{
		$siteName = Zend_Registry::getInstance()->get('siteName');
		$this->view->siteName = $siteName;
	}
}
