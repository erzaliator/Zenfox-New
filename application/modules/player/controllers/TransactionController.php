<?php

set_include_path('lib'.PATH_SEPARATOR.get_include_path());
require_once('lib/CitrusPay.php');

require_once dirname(__FILE__).'/../forms/TransactionForm.php';
class Player_TransactionController extends Zenfox_Controller_Action
{
	/* private $_amountSession;
	private $_paymentTypeSession;
	private $_visitIndexPage;
	private $_bankCodeSession;
	private $_prevAmountSess;
	private $_prevPaymentTypeSess;
	
	private $_playerAddressSess;
	private $_playerContactSess;
	private $_playerPinCodeSess;
	private $_playerCitySess;

	private $_nameSess;
	private $_contactSess;
	private $_emailSess;
	private $_addressSess;
        private $_citySess;
        private $_stateSess;
        private $_pinSess;

	private $_molSess;
	private $_schemeSess;

	private $_firstNameSess;
	private $_lastNameSess;
	private $_sexSess;
	private $_dobSess; */
	
	public function init()
	{
		$this->_paymentTypeSession = new Zend_Session_Namespace('paymentType');
		/* $this->_amountSession = new Zend_Session_Namespace('depositAmount');
		$this->_paymentTypeSession = new Zend_Session_Namespace('paymentType');
		//$this->_visitIndexPage = new Zend_Session_Namespace('visitIndexPage');
		$this->_bankCodeSession = new Zend_Session_Namespace('bankCode');
		$this->_prevAmountSess = new Zend_Session_Namespace('prevAmount');
		$this->_prevPaymentTypeSess = new Zend_Session_Namespace('prevPaymentType');
		
		$this->_playerAddressSess = new Zend_Session_Namespace('playerAddress');
		$this->_playerContactSess = new Zend_Session_Namespace('playerContact');
		$this->_playerPinCodeSess = new Zend_Session_Namespace('playerPinCode');
		$this->_playerCitySess = new Zend_Session_Namespace('playerCity');

		$this->_nameSess = new Zend_Session_Namespace('name');
		$this->_contactSess = new Zend_Session_Namespace('contact');
		$this->_emailSess = new Zend_Session_Namespace('email');
		$this->_addressSess = new Zend_Session_Namespace('address');
                $this->_citySess = new Zend_Session_Namespace('city');
                $this->_stateSess = new Zend_Session_Namespace('state');
                $this->_pinSess = new Zend_Session_Namespace('pin');

		$this->_firstNameSess = new Zend_Session_Namespace('firstName');
		$this->_lastNameSess = new Zend_Session_Namespace('lastName');
		$this->_sexSess = new Zend_Session_Namespace('sex');
		$this->_dobSess = new Zend_Session_Namespace('dob');
		
		$this->_molSess = new Zend_Session_Namespace('mol');
		$this->_schemeSess = new Zend_Session_Namespace('schemeId'); */
	}
	public function indexAction()
	{
		$frontendName = Zend_Registry::get('frontendName');
		
		$goalSession = new Zend_Session_Namespace('goalSession');
        $goalSession->value = true;

		//$prevAmountSess = new Zend_Session_Namespace('prevAmount');
		$authSession = new Zenfox_Auth_Storage_Session();
		$store = $authSession->read();
		$playerId = $store['id'];
		
		$transactionFactory = new Zenfox_Transaction_Factory();

		/* $schemeId = $this->_schemeSess->value;
		$player = new Player();
		if($schemeId == 2)
		{
             $updateSchemeId = $player->updateSchemeId($playerId, $schemeId);
        } */


		//$transaction = new PlayerTransactionRecord();
		
		//$form = new Player_TransactionForm();
		
		if(!$this->getRequest()->isPost())
		{				
			/* $clientIpAddress = Zend_Controller_Front::getInstance()->getRequest()->getClientIp();
			$data['ipAddress'] = $clientIpAddress;
			$data['amount'] = $this->_amountSession->value;
			
			$actualDepositAmountSess = new Zend_Session_Namespace('actualDepositAmount');
			//$actualDepositAmountSess->value = $data['amount'];
			
			$siteCode = Zend_Registry::getInstance()->isRegistered('siteCode')?Zend_Registry::getInstance()->get('siteCode'):null;
			$discountSess = new Zend_Session_Namespace('discountSess');
			$amount = $data['amount'];
			
			//Discount
			
			$discountFile = APPLICATION_PATH . '/site_configs/' . $siteCode . '/discount.json';
			if(file_exists($discountFile))
			{
				$fh = fopen($discountFile, 'r');
				$jsonData = fread($fh, filesize($discountFile));
				$fileData = Zend_Json::decode($jsonData);
			}
			
			if($amount >= 100 && $amount <= 249)
			{
				$discount = 0;
				//$discount = mt_rand($fileData[100][0], $fileData[100][sizeof($fileData[100]) - 1]);
				//$nextHigherAmount = 250;
			}
			elseif($amount >= 250 && $amount <= 499)
			{
				$discount = 0;
				//$discount = mt_rand($fileData[250][0], $fileData[250][sizeof($fileData[250]) - 1]);
				//$nextHigherAmount = 500;
			}
			elseif($amount >= 500 && $amount <= 999)
			{
				$discount = 0;
				//$discount = mt_rand($fileData[500][0], $fileData[500][sizeof($fileData[500]) - 1]);
				//$nextHigherAmount = 1000;
			}
			elseif($amount >= 1000 && $amount <= 1999)
			{
				$discount = 0;
				//$discount = mt_rand($fileData[1000][0], $fileData[1000][sizeof($fileData[1000]) - 1]);
				//$nextHigherAmount = 2000;
			}
			elseif($amount >= 2000 && $amount <= 4999)
			{
				$discount = 0;
				//$discount = mt_rand($fileData[2000][0], $fileData[2000][sizeof($fileData[2000]) - 1]);
				//$nextHigherAmount = 5000;
			}
			elseif($amount >= 5000 && $amount <= 9999)
			{
				$discount = 0;
				//$discount = mt_rand($fileData[5000][0], $fileData[5000][sizeof($fileData[5000]) - 1]);
				//$nextHigherAmount = 10000;
			}
			elseif($amount >= 10000)
			{
				$discount = 0;
				//$discount = 1200;
				//$nextHigherAmount = 20000;
			} */
			
			/* $actualDepositAmountSess->value = $amount;
			$amount = $amount - $discount;
			$data['amount'] = $amount;

			$firstName = $this->_firstNameSess->value;
			$lastName = $this->_lastNameSess->value;
			$sex = $this->_sexSess->value;
			$dob = $this->_dobSess->value;
			$contact = $this->_contactSess->value;
			$email = $this->_emailSess->value;
			$address = $this->_addressSess->value;
			$city = $this->_citySess->value;
			$state = $this->_stateSess->value;
			$pin = $this->_pinSess->value;
			$action = "/transaction/index"; */
			
			/* $this->view->firstName = $firstName;
			$this->view->lastName = $lastName;
			$this->view->sex = $sex;
			$this->view->dob = $dob;
			$this->view->contact = $contact;
			$this->view->email = $email;
			$this->view->address = $address;
			$this->view->city = $city;
			$this->view->state = $state;
			$this->view->pin = $pin; */
			/* 
			$data['playerId'] = $playerId;
			$data['currencyCode'] = 'INR';
			$data['paymentMethod'] = $this->_paymentTypeSession->value;
			$data['status'] = 'UNPROCESSED';
			$data['requestUrl'] = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; */
				
			if($this->_paymentTypeSession->value)
			{
				$paymentType = $this->_paymentTypeSession->value;
				
				$siteCode = Zend_Registry::getInstance()->isRegistered('siteCode')?Zend_Registry::getInstance()->get('siteCode'):null;
				$gatewaysFile = APPLICATION_PATH . '/site_configs/' . $siteCode . '/gateways_order.json';
				$fh = fopen($gatewaysFile, 'r');
				$fileData = fread($fh, filesize($gatewaysFile));
				$gatewaysOrder = Zend_Json::decode($fileData);
				$maxPriority = max($gatewaysOrder);
				foreach($gatewaysOrder as $index => $priority)
				{
					if($maxPriority == $priority)
					{
						$gateway = $index;
						break;
					}
				}
				
				switch($this->_paymentTypeSession->value)
				{
					case 'NETBANKING':
						//$data['gatewayId'] = 'L1472';
						if($frontendName == 'ace2jak.com')
						{
							$bankCodeSession = new Zend_Session_Namespace('bankCode');
							$bankCode = $bankCodeSession->value;
							
							$gateway = 'TECHPROCESS';
							if(!is_numeric($bankCode))
							{
								$paymentType = "NET_BANKING";
								$gateway = "CITRUSPAY";
							}
							
							/* $playerGateways = new PlayerGateways();
							 $allGateways = $playerGateways->getGatewaysByPlayerId($playerId);	 */
							//$data['gatewayId'] = 'L2636';
							/* $gatewaysFile = APPLICATION_PATH . '/site_configs/ace2jack/gateways_order.json';
							$fh = fopen($gatewaysFile, 'r');
							$fileData = fread($fh, filesize($gatewaysFile)); */
				
							/* $accountVariable = new AccountVariable();
							$data['playerId'] = $playerId;
							$data['variableName'] = 'PTG';
							$accountVariableData = $accountVariable->getData($playerId, $data['variableName']); */
										
							/* if(!$accountVariableData)
							{
								$vardata['playerId'] = $playerId;
								$vardata['variableName'] = 'PTG';
								$vardata['variableValue'] = $fileData;
								$accountVariable->insert($vardata);
									
								$accountVariableData = $accountVariable->getData($playerId, $data['variableName']);
							} */
							/* $gatewaysOrder = Zend_Json::decode($accountVariableData['varValue']);
							$maxPriority = max($gatewaysOrder);
											
							foreach($gatewaysOrder as $index => $priority)
							{
								if($maxPriority == $priority)
								{
									$gateway = $index;
									break;
								}
							} */
				
							/* if($allGateways)
								{
								foreach($allGateways as $gateways)
								{
								if($gateways['status'])
								{
								$gateway = $gateways['gateway'];
								break;
								}
								}
								}
								else
								{
								$playerGateways->addGateway($playerId, $gateway);
								} */
								/* $triedGateways[] = $gateway;
								$gatewaySession = new Zend_Session_Namespace('gatewaySession');
								$gatewaySession->value = $triedGateways; */
							}
						break;
					/* case 'DEBIT':
					case 'CREDIT':
						$gateway = 'TECHPROCESS';
						break;
					case 'MOBIKWIK':
						$gateway = 'MOBIKWIK';
						break;
					case 'CASH':
						$data['gatewayId'] = 'GHARPAY';
						break;
					case 'MOL':
						$data['gatewayId'] = '201110042661';
						break; */
				}
				
				$gatewayInstance = $transactionFactory->getInstance($gateway);
				$processedData = $gatewayInstance->start();
								
				$firstName = $processedData['firstName'];
				$lastName = $processedData['lastName'];
				$sex = $processedData['sex'];
				$dob = $processedData['dob'];
				$contact = $processedData['contact'];
				$email = $processedData['email'];
				$address = $processedData['address'];
				$city = $processedData['city'];
				$state = $processedData['state'];
				$pin = $processedData['pin'];
				$transactionId = $processedData['transactionId'];
				$amount = $processedData['amount'];
				$bankCode = $processedData['bankCode'];
				$action = $processedData['action'];
					
				//$transactionId = $transaction->insertData($data);
				/* $cookie = isset($_COOKIE['transactionId'])?$_COOKIE['transactionId']:null;
				if($cookie)
							{
								$setTransactionId = $_COOKIE['transactionId'];
				$playerTransactionRecord = new PlayerTransactionRecord();
				$playerTransactionRecord->updateData($playerId, $setTransactionId, 'status', 'REFRESHED');
				}
				setcookie('transactionId',$transactionId,time() + (3600 * 30),'/','.'.$_SERVER['HTTP_HOST']); */
				
					
				/* if($frontendName == 'ace2jak.com' && $this->_paymentTypeSession->value == 'NETBANKING')
				{
				CitrusPay::setApiKey("86c91f23fec7b3193a99c41a8446bc572ce93adb",'production');
				
				$vanityUrl = "2o6t69fv9p";
				$currency = "INR";
				//$amount = 1;
				
				$merchantTxnId = $transactionId;
				$addressState = $state;
				$addressCity = $city;
				$addressStreet1 = $address;
				$addressZip = $pin;
				$firstName = $firstName;
				$lastName = $lastName;
				$phoneNumber = $contact;
				$email = $email;
				$paymentMode = "NET_BANKING";
				$issuerCode = $this->_bankCodeSession->value;
				
				//$cardHolderName = "";
				//$cardNumber = "";
				//$expiryMonth = "";
				//$cardType = "";
				//$cvvNumber = "";
				//$expiryYear = "";
				
				$orderAmount = $amount;
				$data = "$vanityUrl$orderAmount$merchantTxnId$currency";
				$secSignature = Zend_Crypt_Hmac::compute(CitrusPay::getApiKey(), "sha1", $data);
				//$action = CitrusPay::getCPBase()."$vanityUrl";
				$time = time()*1000;
				$time = number_format($time,0,'.','');
				
				$this->view->issuerCode = $issuerCode;
				$this->view->mode = $paymentMode;
				$this->view->reqTime = $time;
				$this->view->signature = $secSignature;
				
				//$this->view->cardHolder = $cardHolderName;
				//$this->view->cardNumber = $cardNumber;
				//$this->view->type = $cardType;
				//$this->view->expiryMonth = $expiryMonth;
				//$this->view->expiryYear = $expiryYear;
				//$this->view->cvvNumber = $cvvNumber;
				} */
					
				$this->view->firstName = $firstName;
				$this->view->lastName = $lastName;
				$this->view->sex = $sex;
				$this->view->dob = $dob;
				$this->view->contact = $contact;
				$this->view->email = $email;
				$this->view->address = $address;
				$this->view->city = $city;
				$this->view->state = $state;
				$this->view->pin = $pin;
				$this->view->transactionId = $transactionId;
				$this->view->code = $bankCode;
				$this->view->amount = $amount;
				$this->view->paymentType = $this->_paymentTypeSession->value;
				$this->view->action = $action;
				$this->view->gateway = $gateway;
					
				if($gateway == 'CITRUSPAY')
				{
					$this->view->issuerCode = $bankCode;
					$this->view->mode = $paymentType;
					$this->view->reqTime = $processedData['reqTime'];
					$this->view->signature = $processedData['signature'];
				}
				elseif($gateway == 'EBS')
				{
					$this->view->returnUrl = $processedData['returnUrl'];
					$this->view->description = $processedData['description'];
					$this->view->mode = $processedData['mode'];
					$this->view->secureHash = $processedData['hash'];
				}
			}
			//$this->view->discount = $discount;
		}
		/* switch($this->_paymentTypeSession->value)
		{
			case 'NETBANKING':
			case 'DEBIT':
			case 'CREDIT':
				$form->getTransactionForm($amount, $bankCode, $playerId);
				//$this->view->discountEnabled = true;
				break;
			case 'CASH':
				$playerAddress = $this->_playerAddressSess->value;
				$playerCity = $this->_playerCitySess->value;
				$playerPinCode = $this->_playerPinCodeSess->value;
				$playerContact = $this->_playerContactSess->value;
				$this->view->form = $form->getAddressForm($amount, $playerAddress, $playerCity, $playerPinCode, $playerContact, $playerId);
				break;
			case 'MOL':
				$this->view->form = $form->getMolForm($amount, $playerId);
				break;
			
		} */

		if($this->getRequest()->isPost())
		{
			$gatewayInstance = $transactionFactory->getInstance($_POST['gateway']);
			$process = $gatewayInstance->process();
			$this->_helper->FlashMessenger(array('error' => $process));
			/* setcookie('transactionId','',time(),'/','.'.$_SERVER['HTTP_HOST']);
			$postTransactionId = $_POST['transId'];
			$playerTransactionRecord = new PlayerTransactionRecord();
			$playerTransactionRecord->updateData($playerId, $postTransactionId, 'status'); */
			/* if($form->isValid($_POST) && (!$this->getRequest()->ajax))
			{
				$confirmation = $_POST['confirm'];
				//$this->_paymentTypeSession->value = 'NETBANKING';
				$updateSchemeId = true;
				if($schemeId)
				{
					$updateSchemeId = $player->updateSchemeId($playerId, $schemeId);
				}
				if(isset($confirmation) && $updateSchemeId)
				{
					switch($this->_paymentTypeSession->value)
					{
						case 'NETBANKING':
						case 'DEBIT':
						case 'CREDIT':
							$tpslWrapObj = new TPSL_Wrapper();
							if($tpslWrapObj->appStatus)
							{
								$result = $tpslWrapObj->processRequest();
								preg_match('/^<RESULT>(.*)<\/RESULT>$/', $result, $match);
								if($match[1] != '')
								{
									header('Location: https://www.tpsl-india.in/PaymentGateway/TransactionRequest.jsp?msg=' . $match[1]);
									//header('Location: https://www.tpsl-india.in/PaymentGateway/TransactionRequest.jsp?msg=' . $match[1]);
									exit;
								}
								else
								{
									$this->_helper->FlashMessenger(array('error' => 'Oops! We seem to have missed your last action! <br>Please try again or write to us at <a href="mailto:support@taashtime.com">support@taashtime.com</a>'));
								}
							}
							break;
						case 'CASH':
							//$data = $form->getValues();
							$data = $_POST;
							
							$playerCardDetail = new PlayerCardDetail();
							$loginName = $store['authDetails'][0]['login'];
							$firstName = $store['authDetails'][0]['first_name'];
							$cardDetail['firstName'] = empty($firstName)?$loginName:$firstName;
							$cardDetail['paymentType'] = 'CASH';
							$cardDetail['middleName'] = "";
							$cardDetail['lastName'] = "";
							$cardDetail['address'] = $data['address'];
							$cardDetail['city'] = $data['city'];
							$cardDetail['zip'] = $data['postalCode'];
							$cardDetail['country'] = 'IN';
							$cardDetail['cardType'] = "";
							$cardDetail['expYear'] = "";
							$cardDetail['expMonth'] = "";
							$playerCardId = $playerCardDetail->insertData($playerId, $cardDetail);
							if($playerCardId)
							{
								$date = new Zend_Date();
								$date->setTimezone('Asia/Calcutta');
								
								$currentDay = $date->get(Zend_Date::DAY);
								$currentMonth = $date->get(Zend_Date::MONTH);
								$currentYear = $date->get(Zend_Date::YEAR);
								$currentHour = $date->get(Zend_Date::HOUR);
								
								if($currentHour >= 11)
								{
									$currentDay++;
								}
								
								$deliveryDay = $currentDay . '-' . $currentMonth . '-' . $currentYear;
								
								$transactionDetails = array();
								$transactionDetails['customerDetails'] = array();
								$transactionDetails['orderDetails'] = array();
								$transactionDetails['additionalInformation'] = array();
								
								$transactionDetails['customerDetails']['address'] = $data['address'];
								$transactionDetails['customerDetails']['contactNo'] = $data['phone'];
								$transactionDetails['customerDetails']['email'] = $store['authDetails'][0]['email'];
								$transactionDetails['customerDetails']['firstName'] = $cardDetail['firstName'];
								$transactionDetails['customerDetails']['lastName'] = $store['authDetails'][0]['last_name'];
								
								$transactionDetails['orderDetails']['pincode'] = $data['postalCode'];
								$transactionDetails['orderDetails']['clientOrderID'] = $data['transId'];
								$transactionDetails['orderDetails']['deliveryDate'] = $deliveryDay;
								$transactionDetails['orderDetails']['orderAmount'] = $data['amount'];
								$transactionDetails['orderDetails']['templateID'] = $playerCardId;
								
								$soapClient = new SoapClient("http://webservices.gharpay.in/GharpayService?wsdl", array('trace' => 1));
								$headerUser=new SoapHeader("http://webservices.gharpay.in","username", "taashtime_api");
								$headerPass = new SoapHeader("http://webservices.gharpay.in","password", 'p@s$e99h');
								$soapClient->__setSoapHeaders(array($headerUser,$headerPass));
								try 
								{
									$gatewayOrderId = $soapClient->createOrder($transactionDetails);
								}
								catch(Exception $e) 
								{
									$this->_helper->FlashMessenger(array('error' => 'There is some problem occured. Please contact to our customer support.'));
								}
								if($transaction->updateGharpayTransaction($data['transId'], $gatewayOrderId))
								{
									$this->_helper->FlashMessenger(array('notice' => 'Thank you for depositing. Our guy will reach you with in 24 hours. Please note your transaction id ' . $data['transId']));
								}
								else
								{
									$this->_helper->FlashMessenger(array('error' => 'There is some problem occured. Please contact to our customer support with the transaction id ' . $data['transId']));
								}
							}
							break;
						case 'MOL':
							$data = $form->getValues();

							//$MerchantID = '201110042661';//your merchant id
							$MerchantID = '201207050121';
							$MRef_ID = $data['transId'];
							$Amount = $data['amount'];
							//$Description = 'Testing';
							$Description = 'Development';
							$Currency = 'INR';
							//$SecretPIN = 'fcem2661fcem';//your Secret word
							$SecretPIN = 'gvnc2943gvnc';
							
							//$soap_url = 'http://molv3.molsolutions.com/api/login/s_module/heartbeat.asmx?WSDL';
							$soap_url = 'https://global.mol.com/api/login/s_module/heartbeat.asmx?WSDL';
							$method = 'GetHeartBeat';
							
							$soap_param = array(array('MerchantID' => $MerchantID));
							$client = new SoapClient($soap_url, array('soap_version'   => SOAP_1_1));
							$client->soap_defencoding = 'UTF-8';
							$client->decode_utf8 = false;
							
							$result = $client->__call($method, $soap_param);
							$HeartBeat = $result->GetHeartBeatResult->HB;
							
							$Signature = sha1(strtolower($MerchantID.$MRef_ID.$Amount.$Currency.$SecretPIN.$HeartBeat));
							
							//$redirectUrl = "http://molv3.molsolutions.com/api/login/u_module/purchase.aspx?MerchantID=$MerchantID&Amount=$Amount&MRef_ID=$MRef_ID&Description=$Description&Currency=$Currency&HeartBeat=$HeartBeat&Signature=$Signature";
							$redirectUrl = "https://global.mol.com/api/login/u_module/purchase.aspx?MerchantID=$MerchantID&Amount=$Amount&MRef_ID=$MRef_ID&Description=$Description&Currency=$Currency&HeartBeat=$HeartBeat&Signature=$Signature";
							$this->_molSess->value = true;
							$this->_redirect($redirectUrl);
							break;
					}
				}
				elseif(!$updateSchemeId)
				{
					$this->_helper->FlashMessenger(array('error' => 'There is some problem occured. Please contact to our customer support.'));
				}
				else
				{
						$this->_redirect('/banking/deposit');
				}
			} */
		}
	}

	public function confirmAction()
	{
		/* $this->_amountSession->unsetAll();
		$this->_prevAmountSess->unsetAll();
		$this->_prevPaymentTypeSess->unsetAll();
		$this->_playerAddressSess->unsetAll();
		$this->_playerContactSess->unsetAll();
		$this->_playerPinCodeSess->unsetAll();
		$this->_playerCitySess->unsetAll();
		$this->_nameSess->unsetAll();
		$this->_contactSess->unsetAll();
		$this->_emailSess->unsetAll(); */
		
		if($this->_paymentTypeSession->value)
		{
			switch($this->_paymentTypeSession->value)
			{
				case 'NETBANKING':
				case 'DEBIT':
				case 'CREDIT':
					$authSession = new Zenfox_Auth_Storage_Session();
					$store = $authSession->read();
					$playerId = $store['id'];
					
					$siteCode = Zend_Registry::getInstance()->isRegistered('siteCode')?Zend_Registry::getInstance()->get('siteCode'):null;
					$gatewaysFile = APPLICATION_PATH . '/site_configs/' . $siteCode . '/gateways_order.json';
					$fh = fopen($gatewaysFile, 'r');
					$fileData = fread($fh, filesize($gatewaysFile));
					$gatewaysOrder = Zend_Json::decode($fileData);
					$maxPriority = max($gatewaysOrder);
					foreach($gatewaysOrder as $index => $priority)
					{
						if($maxPriority == $priority)
						{
							$currentGateway = $index;
							break;
						}
					}
						
					/* $accountVariable = new AccountVariable();
					$data['playerId'] = $playerId;
					$data['variableName'] = 'PTG';
					$accountVariableData = $accountVariable->getData($playerId, $data['variableName']);
						
					$data['varId'] = $accountVariableData['varId'];
						
					$gatewaysOrder = Zend_Json::decode($accountVariableData['varValue']);
					$maxPriority = max($gatewaysOrder);
					
					foreach($gatewaysOrder as $index => $priority)
					{
						if($maxPriority == $priority)
						{
							$currentGateway = $index;
							break;
						}
					} */
						
					//$currentGateway = $triedGateways[count($triedGateways) - 1];
						
					$transactionFactory = new Zenfox_Transaction_Factory();
					$gatewayInstance = $transactionFactory->getInstance($currentGateway);
					$response = $gatewayInstance->endprocess();
						
					if($response)
					{
						//Enable it later
						/* $minPriority = min($gatewaysOrder);
						$gatewaysOrder[$currentGateway] = $minPriority - 1;
						$data['variableValue'] = Zend_Json::encode($gatewaysOrder);
					
						$accountVariable->update($data); */
						
						
						/*$accountVariableData = $accountVariable->getData($playerId, $data['variableName']);
					
						$gatewaysOrder = Zend_Json::decode($accountVariableData['varValue']);
						$maxPriority = max($gatewaysOrder);
					
						foreach($gatewaysOrder as $index => $priority)
						{
						if($maxPriority == $priority)
						{
						$currentGateway = $index;
						break;
						}
						}
					
					
						$gatewayInstance = $transactionFactory->getInstance($currentGateway);
						$processedData = $gatewayInstance->start();
					
						$this->view->firstName = $firstName;
						$this->view->lastName = $lastName;
						$this->view->sex = $sex;
						$this->view->dob = $dob;
						$this->view->contact = $contact;
						$this->view->email = $email;
						$this->view->address = $address;
						$this->view->city = $city;
						$this->view->state = $state;
						$this->view->pin = $pin;
						$this->view->transactionId = $transactionId;
						$this->view->code = $bankCode;
						$this->view->amount = $amount;
						$this->view->paymentType = $this->_paymentTypeSession->value;
						$this->view->action = $action;
						$this->view->gateway = $gateway;
							
						if($gateway == 'CITRUSPAY')
						{
						$this->view->issuerCode = $bankCode;
						$this->view->mode = $this->_paymentTypeSession->value;
						$this->view->reqTime = $processedData['reqTime'];
						$this->view->signature = $processedData['signature'];
						}*/
					
					}
					break;
				case 'MOBIKWIK':
					$transactionFactory = new Zenfox_Transaction_Factory();
					$gatewayInstance = $transactionFactory->getInstance('MOBIKWIK');
					$response = $gatewayInstance->endprocess();
					break;
				default:
					$transactionFactory = new Zenfox_Transaction_Factory();
					$gatewayInstance = $transactionFactory->getInstance('TECHPROCESS');
					$response = $gatewayInstance->endprocess();
					break;
			}
			/* $gatewaySession = new Zend_Session_Namespace('gatewaySession');
			$triedGateways = $gatewaySession->value; */
			
			$this->_helper->FlashMessenger(array('error' => $this->view->translate($response)));
		}	
		/* $orderId = $this->getRequest()->order_id;
		$gateTransactionTime = $this->getRequest()->time;
		$referenceNo = $this->getRequest()->ReferenceNo;

		$molMerchantId = $this->getRequest()->MerchantID;
		$molOrderId = $this->getRequest()->MOLOrderID;

		$service = $this->getRequest()->service;

		if($molMerchantId && $molOrderId && $this->_paymentTypeSession->value && $this->_molSess->value)
		{
			$data['gatewayTransId'] = $this->getRequest()->MOLOrderID;
			$data['bankName'] =  "";
			$data['gatewayResponse'] = Zend_Json::encode($_GET);
			$data['status'] = 'PROCESSED';
			$data['responseUrl'] = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
			$data['gatewayTransTime'] =  $this->getRequest()->TransDateTime;
			$responseCode = $this->getRequest()->ResCode;
			$transactionId = $this->getRequest()->MRef_ID;
			$actualDepositAmountSess = new Zend_Session_Namespace('actualDepositAmount');
		        $amount = $actualDepositAmountSess->value;
			//$amount = $this->getRequest()->Amount;
			$transaction = new PlayerTransactionRecord();
			$authSession = new Zenfox_Auth_Storage_Session();
			$store = $authSession->read();
			$playerId = $store['id'];
			$transactionData = $transaction->getTransactionData($playerId, $transactionId);
			//Zenfox_Debug::dump($transactionData, 'data', true, true);
			if($responseCode == 100)
			{
				if($transactionData['status'] == 'PENDING')
				{
					$data['result'] = "Successful";
					$transaction->updateRecords($data, $transactionId);
					$currencyCode = $this->getRequest()->Currency;
					$email = $store['authDetails'][0]['email'];
					$trackerId = $store['authDetails'][0]['tracker_id'];
					$this->_creditAccount($playerId, $amount, $currencyCode, $transactionId, $email, $trackerId, true);
				}
				elseif($transactionData['status'] == 'PROCESSED')
				{
					$fundValue = $currencyCode . $amount;
					$creditSession = new Zend_Session_Namespace('creditSession');
					$creditSession->value = $fundValue;
					$this->_redirect('banking/index/trackerId/' . $trackerId . '/transactionId/' . $transactionId)->setRedirectCode('307');
				}
				else
				{
					$this->_addMolError($responseCode, $transactionId, $data);
				}
			}
			else
			{
				$this->_addMolError($responseCode, $transactionId, $data);
			}
		}
		elseif($referenceNo  && $this->_paymentTypeSession->value)
		{
			$status = $this->getRequest()->Status;
			$transactionId = $this->getRequest()->ReferenceNo;
			$gatewayTransId = $this->getRequest()->TransactionId;
			$amount = $this->getRequest()->Amount;
			$gatewayResponse = Zend_Json::encode($_POST);
			
			$data['gatewayTransId'] =  $gatewayTransId;
			$data['bankName'] =  "";
			$data['gatewayResponse'] = $gatewayResponse;
			$data['gatewayTransTime'] =  "";
			$data['responseUrl'] = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
			
			$transaction = new PlayerTransactionRecord();
			$authSession = new Zenfox_Auth_Storage_Session();
			$store = $authSession->read();
			$playerId = $store['id'];
			
			if(!$status)
			{
				$data['status'] = 'PROCESSED';
				$data['result'] = "Successful";
				$transaction->updateRecords($data, $transactionId);
			
				$currencyCode = 'INR';
				$email = $store['authDetails'][0]['email'];
				$trackerId = $store['authDetails'][0]['tracker_id'];
				$this->_creditAccount($playerId, $amount, $currencyCode, $transactionId, $email, $trackerId);
			}
			else
			{
				$data['status'] = 'ERROR';
				switch($status)
				{
					case '-2':
						$data['result'] = "Invalid Reference Number.";
						break;
					case '-3':
						$data['result'] = "Duplicate Reference Number.";
						break;
					case '-4':
						$data['result'] = "Missing Reference Number.";
						break;
					case '-26':
						$data['result'] = "Amount missing.";
						break;
					case '-27':
						$data['result'] = "Invalid Amount.";
						break;
					case '-202':
						$data['result'] = "No reply from the Bank.";
						break;
					case '-300':
						$data['result'] = "No Approval. Failed at Bank";
						break;
					case '-305':
						$data['result'] = "Failed. Failed from bank.";
						break;
					case '-400':
						$data['result'] = "Invalid Merchant (Not registered), null value or invalid IP address.";
						break;
					case '-999':
						$data['result'] = "Other errors.";
						break;
				}
				$transaction->updateRecords($data, $transactionId);
				$this->_createTicket($transactionId, $playerId);			
			}
		}
		elseif($orderId && $gateTransactionTime)
		{
			$soapClient = new SoapClient("http://webservices.gharpay.in/GharpayService?wsdl", array('trace' => 1));
			$headerUser=new SoapHeader("http://webservices.gharpay.in","username", "taashtime_api");
			$headerPass = new SoapHeader("http://webservices.gharpay.in","password", 'p@s$e99h');
			$soapClient->__setSoapHeaders(array($headerUser,$headerPass));
			try
			{
				$status = $soapClient->viewOrderStatus($orderId);
			}
			catch(Exception $e)
			{
				print $e->getMessage();
			} 

			$playerTransactionRecord = new PlayerTransactionRecord();
            $transactionData = $playerTransactionRecord->getDataByGatewayTransId('',$orderId);
            $playerId = $transactionData['player_id'];
            $amount = $transactionData['amount'];
            $transId = $transactionData['transaction_id'];

			if($status == 'Delivered')
			{
				$status = 'PROCESSED';
				$result = 'Delivered';
					$playerTransactionRecord->updateGharpayTransaction($transId, $orderId, $gateTransactionTime, $status, $result);
					
					$player = new Player();
					$currencyCode = 'INR';
					$email = $player->getEmail($playerId);
					$this->_creditAccount($playerId, $amount, $currencyCode, $transId, $email);

			}
			else
			{
				switch($status)
				{
					case 'Pending':
						$status = 'PENDING';
						$result = 'Delivery is pending';
						break;
					case 'On-The-Way':
						$status = 'PENDING';
						$result = 'Delivery is On the way';
						break;
					case 'Cancelled	by Client':
						$status = 'ERROR';
						$result = 'Order is cancelled by taashtime';
						break;
					case 'Cancelled by Customer':
						$status = 'ERROR';
						$result = 'Order is cancelled by the customer';
						break;
					case 'Failed':
						$status = 'ERROR';
						$result = 'Failed';
						break;
					case 'Deferred By Customer':
						$status = 'ERROR';
                        $result = 'Deferred By Customer';
                        break;
					case 'Invalid':
                        $status = 'ERROR';
                        $result = 'Invalid Order';
                        break;
				}
				$playerTransactionRecord->updateGharpayTransaction($transactionData['transaction_id'], $gatewayOrderId, $gateTransactionTime, $status, $result);
				$this->_createTicket($transId, $playerId);
			}
		}
		elseif($this->_paymentTypeSession->value)
		{
			$authSession = new Zenfox_Auth_Storage_Session();
			$store = $authSession->read();
			$playerId = $store['id'];
			
			$frontendName = Zend_Registry::get('frontendName');
			
			if($frontendName == 'ace2jak.com')
			{
				$jsonData = Zend_Json::encode($_POST);
				$transactionId =  $_POST['TxId'];
				
				$data['gatewayTransId'] =  $_POST['TxRefNo'];
				$data['bankName'] =  $this->_bankCodeSession->value;
				$data['gatewayResponse'] = $jsonData;
				$data['gatewayTransTime'] =  $_POST['txnDateTime'];
				$data['responseUrl'] = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
				$data['result'] = $_POST['TxMsg'];
				$data['status'] = 'ERROR';
				
				$transaction = new PlayerTransactionRecord();
				
				if($_POST['TxStatus'] == 'SUCCESS')
				{
					$data['status'] = 'PROCESSED';
					
					$actualDepositAmountSess = new Zend_Session_Namespace('actualDepositAmount');
					$actualDepositAmountSess->unsetAll();
					
					$amount = $_POST['amount'];
					
					//$amount = $tpslWrapObj->responseData[4];
					$currencyCode = $_POST['currency'];
					$email = $store['authDetails'][0]['email'];
					$trackerId = $store['authDetails'][0]['tracker_id'];
					$this->_creditAccount($playerId, $amount, $currencyCode, $transactionId, $email, $trackerId);
				}
				else
				{
					$this->_helper->FlashMessenger(array('error' => 'Your amount is not credited, may be you cancelled the payment, please try again. If problem persists, please contact our support.'));
				}
				$transaction->updateRecords($data, $transactionId);
				$this->_bankCodeSession->unsetAll();
			}
			else
			{
				$tpslWrapObj = new TPSL_Wrapper();
				if($tpslWrapObj->appStatus)
				{
					$propertyFilePath = APPLICATION_PATH . '/../public/MerchantDetails.properties';
					$result = $tpslWrapObj->processResponse($propertyFilePath);
						
					$transactionId =  $tpslWrapObj->responseData[1];
					$gatewayResponse = array();
					$jsonData = json_encode($tpslWrapObj);
					$data['gatewayTransId'] =  $tpslWrapObj->responseData[2];
					$data['bankName'] =  $tpslWrapObj->responseData[5];
					$data['gatewayResponse'] = $jsonData;
					$data['gatewayTransTime'] =  $tpslWrapObj->responseData[13];
					$data['responseUrl'] = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
					$data['result'] = $result;
				
					$transaction = new PlayerTransactionRecord();
					$transactionResult = $tpslWrapObj->responseData[14];
					//Credit the deposit in player account
					//Transaction is successful
					if($transactionResult == '0300')
					{
						$data['status'] = 'PROCESSED';
						$transaction->updateRecords($data, $transactionId);
							
						$actualDepositAmountSess = new Zend_Session_Namespace('actualDepositAmount');
						$amount = $actualDepositAmountSess->value;
						$actualDepositAmountSess->unsetAll();
				
						//$amount = $tpslWrapObj->responseData[4];
						$currencyCode = $tpslWrapObj->responseData[8];
						$email = $store['authDetails'][0]['email'];
						$trackerId = $store['authDetails'][0]['tracker_id'];
						$this->_creditAccount($playerId, $amount, $currencyCode, $transactionId, $email, $trackerId);
					}
					elseif($transactionResult)
					{
						$data['status'] = 'ERROR';
						$transaction->updateRecords($data, $transactionId);
				
						$bankCode = $tpslWrapObj->responseData[5];
						switch($bankCode)
						{
							case '10':
								$bankName = 'ICICI Bank';
								break;
							case '50':
								$bankName = 'Axis Bank';
								break;
							case '120':
								$bankName = 'Corporation Bank';
								break;
							case '130':
								$bankName = 'Yes Bank';
								break;
							case '140':
								$bankName = 'Karnataka Bank';
								break;
							case '160':
								$bankName = 'Oriental Bank of Commerce';
								break;
							case '240':
								$bankName = 'Bank of India';
								break;
							case '180':
								$bankName = 'South Indian Bank';
								break;
							case '200':
								$bankName = 'Vijaya Bank';
								break;
							case '270':
								$bankName = 'Federal Bank';
								break;
							case '310':
								$bankName = 'Bank of Baroda';
								break;
							case '340':
								$bankName = 'Bank of Bahrain and Kuwait';
								break;
							case '370':
								$bankName = 'Dhanlaxmi Bank';
								break;
							case '330':
								$bankName = 'Deutsche Bank';
								break;
							case '190':
								$bankName = 'Union Bank of India';
								break;
							case '450':
								$bankName = 'Standard Chartered Bank';
								break;
							case '420':
								$bankName = 'Indian Overseas Bank';
								break;
							case '280':
								$bankName = 'Allahabad Bank';
								break;
							case '300':
								$bankName = 'HDFC Bank';
								break;
							case '520':
								$bankName = 'IDBI Bank';
								break;
							case '530':
								$bankName = 'State Bank of India';
								break;
							case '440':
								$bankName = 'City Union Bank';
								break;
							case '550':
								$bankName = 'State Bank of Mysore';
								break;
							case '560':
								$bankName = 'State Bank of Hyderabad';
								break;
							case '490':
								$bankName = 'Indian Bank';
								break;
							case '620':
								$bankName = 'Tamilnad Mercantile Bank';
								break;
							case '540':
								$bankName = 'Development Credit Bank';
								break;
						}
							
						$this->_createTicket($transactionId, $playerId, $bankName);
					}
					else
					{
						$this->_helper->FlashMessenger(array('error' => 'Your amount is not credited, may be you cancelled the payment, please try again. If problem persists, please contact our support.'));
					}
				}
				else
				{
					$this->_helper->FlashMessenger(array('error' => 'Your amount is not credited, may be you cancelled the payment, please try again. If problem persists, please contact our support.'));
				}
			}
		} */
		if(!$this->_paymentTypeSession->value)
		{
			$this->_helper->FlashMessenger(array('error' => $this->view->translate("Invalid Link!!")));
		}
		$this->_paymentTypeSession->unsetAll();
		//$this->_molSess->unsetAll();
	}
	
	private function _creditAccount($playerId, $amount, $currencyCode, $transactionId, $email, $trackerId = NULL, $molPayment = false, $molOfLine = NULL)
	{
		//Independence Day Special
		$previousAmount = $amount;
		/*if($amount == 1947)
		{
			$amount = 2000;
		}*/
		$playerTransactions = new PlayerTransactions();
		$sourceId = $playerTransactions->creditDeposit($playerId, $amount, $currencyCode, $transactionId);
		if(!$sourceId && !$molOfLine)
		{
			$this->_helper->FlashMessenger(array('error' => 'Could not credit amount.'));
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
		if($counter == 3 && !$reportMessage && !$molOfLine)
		{
			$this->_helper->FlashMessenger(array('error' => $this->view->translate("Your amount has not been credited, please try again. <br>If problem persists contact our %s customer support %s", "<a href=\"" . $this->view->baseUrl("ticket/create") . "\">", "</a>" )));
		}
		if(($reportMessage['processed'] == 'PROCESSED') && ($reportMessage['error'] == 'NOERROR'))
		{
			$error = false;
			
			$playerTransactions = new PlayerTransactions();
			//$bonusDiscountArray = array(25,30,35,40,45,50,55,60,65,70,75,80,85,90,95,100);
			//$randomNumber = mt_rand(0, count($bonusDiscountArray) - 1);
			//$discountPercent = $bonusDiscountArray[$randomNumber];
			$discountPercent = 45;
			$bonusAmount = $amount * $discountPercent / 100;
			/*if($previousAmount == 1947)
			{
				$bonusAmount = 1947;
			}*/
			//$bonusAmount = $amount * $discountPercent / 100;

			//DISCOUNT
			//$sourceId = $playerTransactions->creditBonus($playerId, $bonusAmount, 'INR', 'Instant Bonus');
			/*$sourceId = $playerTransactions->creditBonusDue($playerId, $bonusAmount, 'INR', 'Independence Day Bonus');
			
			if(!$sourceId)
			{
				$error = true;
				$this->_helper->FlashMessenger(array('error' => 'Could not credit bonus amount.'));
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
			//if($counter == 3 && !$reportMessage)
			if($counter == 3 && !$reportMessage)
			{
				$error = true;
				$this->_helper->FlashMessenger(array('error' => $this->view->translate("Your bonus amount has not been credited, please try again. <br>If problem persists contact our %s customer support %s", "<a href=\"" . $this->view->baseUrl("ticket/create") . "\">", "</a>" )));
			}*/
			//DISCOUNT END			

			if($molPayment)
			{
				$playerTransactions = new PlayerTransactions();
				$bonusAmount = $amount / 10;
				$sourceId = $playerTransactions->creditBonusDue($playerId, $bonusAmount, $currencyCode);
				/*$bonusAmount = ($amount * 12.12) / 100;
				$sourceId = $playerTransactions->creditBonus($playerId, $bonusAmount, $currencyCode);*/
				//if(!$sourceId)
				if(!$sourceId && !$molOfLine)
				{
					$error = true;
					$this->_helper->FlashMessenger(array('error' => 'Could not credit bonus amount.'));
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
				//if($counter == 3 && !$reportMessage)
				if($counter == 3 && !$reportMessage && !$molOfLine)
				{
					$error = true;
					$this->_helper->FlashMessenger(array('error' => $this->view->translate("Your bonus amount has not been credited, please try again. <br>If problem persists contact our %s customer support %s", "<a href=\"" . $this->view->baseUrl("ticket/create") . "\">", "</a>" )));
				}
			}
			if(!$error)
			{
				$couponSess = new Zend_Session_Namespace('bonusCoupon');
				$code = $couponSess->value;
			
				if($code)
				{
					$redeemCoupon = new RedeemCoupon();
					$isCouponRedeemed = $redeemCoupon->redeem($playerId, $code, $currencyCode);
				}
			
				if($isCouponRedeemed['error'] && !$molOfLine)
				{
					$this->_helper->FlashMessenger(array('error' => $this->view->translate($isCouponRedeemed['message'])));
				}
				else
				{
					$mail = new Mail();
					$mail->sendToOne('Transactionsuccess', 'TRANSACTION_SUCCESS', $transactionId, '', $email);

					$couponSess->unsetAll();
			
					$fundValue = $currencyCode . $amount;
					$creditSession = new Zend_Session_Namespace('creditSession');
					$creditSession->value = $fundValue;
			
					if(($_POST['browser'] == 'chrome') || ($_POST['browser'] == 'msie'))
					{
						Zend_Layout::getMvcInstance()->disableLayout();
						$this->view->form = '/banking/index/trackerId/' . $trackerId  . '/transactionId/' . $transactionId;
					}
					elseif(!$molOfLine)
					{
						$this->_redirect('banking/index/trackerId/' . $trackerId  . '/transactionId/' . $transactionId)->setRedirectCode('307');
					}
				}
			}
		}
		elseif($counter != 3 && !$molOfLine)
		{
			$this->view->form = '';
			$this->_helper->FlashMessenger(array('error' => $this->view->translate('Your amount is not credited, please try again. If problem persists, please contact support with the following audit Id:: '. $reportMessage['auditId'])));
		}
	}
	
	private function _createTicket($transactionId, $playerId, $bankName = NULL, $molOfLine = NULL)
	{
		$frontendName = Zend_Registry::get('frontendName');
		
		if(!$molOfLine)
		{
			$this->_helper->FlashMessenger(array('error' => 'Your amount is not credited, may be you cancelled the payment, please try again. If problem persists, please contact our support.'));
					
			if($frontendName != 'ace2jak.com')
			{
				$url = '/ticket/view';
				$this->_helper->FlashMessenger(array('notice' => $this->view->translate("A customer support ticket has been generated for you and it will be evaluated by our Bank Processing team. Please %sClick Here%s to check your ticket.", "<a href=\"" . $this->view->baseUrl($url) . "\">", "</a>")));
			}
		}
			
		if($frontendName != 'ace2jak.com')
		{
			$playerTransactionRecord = new PlayerTransactionRecord();
			$transactionData = $playerTransactionRecord->getTransactionData($playerId, $transactionId);
			
			$amount = (float)$transactionData['amount'];
			$transTime = $transactionData['transTime'];
				
			/* $authSession = new Zenfox_Auth_Storage_Session();
			 $store = $authSession->read();
			$userName = $store['authDetails'][0]['login'];
			$userType = $store['roleName'];
			$playerId = $store['id']; */
			$player = new Player();
			$userName = $player->getUserName($playerId);
			$userType = 'player';
			
			$ticket = new Tickets($playerId, $userType);
			$ticketData['subject'] = 'Transaction Failed';
			if($bankName)
			{
				$ticketData['reply_msg'] = 'Hi,<p>My last bank transaction with TaashTime was unsuccessful. I am bringing to your attention the Transaction ID, exact process time, Bank Name and Amount for transaction. Please confirm whether it is a bank process failure or an error on your part. </p><p>Transaction ID:'.$transactionId.'<br>Time of failed process:'.$transTime.'<br>Bank Name:'.$bankName.'<br>Amount of Transaction:'.$amount.'</p><p>Please ensure that the query is swiftly resolved. <br>Best,<br>'.$userName.'.</p>';
			}
			else
			{
				$ticketData['reply_msg'] = 'Hi,<p>My last bank transaction with TaashTime was unsuccessful. I am bringing to your attention the Transaction ID, exact process time, Payment Type and Amount for transaction. Please confirm whether it is a bank process failure or an error on your part. </p><p>Transaction ID:'.$transactionId.'<br>Time of failed process:'.$transTime.'<br>Transaction Type:'.$this->_paymentTypeSession->value.'<br>Amount of Transaction:'.$amount.'</p><p>Please ensure that the query is swiftly resolved. <br>Best,<br>'.$userName.'.</p>';
			}
			$ticket->createTicket($ticketData);
			$this->view->amount = $amount;
		}
	}

	public function processAction()
	{
		Zend_Layout::getMvcInstance()->disableLayout();
		$molMerchantId = $this->getRequest()->MerchantID;
		$molOrderId = $this->getRequest()->MOLOrderID;
		
		if($molMerchantId && $molOrderId)
		{
			$data['gatewayTransId'] = $this->getRequest()->MOLOrderID;
			$data['bankName'] =  "";
			$data['gatewayResponse'] = Zend_Json::encode($_GET);
			$data['status'] = 'PROCESSED';
			$data['responseUrl'] = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
			$data['gatewayTransTime'] =  $this->getRequest()->TransDateTime;
			$responseCode = $this->getRequest()->ResCode;
			$transactionId = $this->getRequest()->MRef_ID;
			$amount = $this->getRequest()->Amount;
			$transaction = new PlayerTransactionRecord();
			/*$authSession = new Zenfox_Auth_Storage_Session();
			$store = $authSession->read();
			$playerId = $store['id'];*/
			$this->view->error = false;
			$transactionData = $transaction->getTransactionData('',$transactionId);
			if($responseCode == 100)
			{
				$playerId = $transactionData['playerId'];
				$player = new Player();
				$accountDetails = $player->getAccountDetails($playerId);
				$data['result'] = "Successful";
				if($transactionData['status'] == 'UNPROCESSED')
				{
					$transaction->updateRecords($data, $transactionId);
					$currencyCode = $this->getRequest()->Currency;
					$email = $accountDetails[0]['email'];
					$trackerId = $accountDetails[0]['tracker_id'];
					/*$email = $store['authDetails'][0]['email'];
					$trackerId = $store['authDetails'][0]['tracker_id'];*/
					$this->_creditAccount($playerId, $amount, $currencyCode, $transactionId, $email, $trackerId, true, true);
				}
				else
				{
					$this->view->error = true;
				}
			}
			elseif($transactionData['status'] == 'UNPROCESSED')
			{
				$this->view->error = true;
				$this->_addMolError($responseCode, $transactionId, $data, true);
			}
			else
			{
				$this->view->error = true;
			}
		}
		else
		{
			$this->view->error = true;
		}
	}

	private function _addMolError($responseCode, $transactionId, $data, $molOfLine)
	{
		$authSession = new Zenfox_Auth_Storage_Session();
		$store = $authSession->read();
		$playerId = $store['id'];

		$transaction = new PlayerTransactionRecord();
		$data['status'] = 'ERROR';
		switch($responseCode)
		{
			case 105:
				$data['result'] = "Order Not Found.";
				$transaction->updateRecords($data, $transactionId);
				break;
			case 200:
				$data['result'] = "Generic error.";
				$transaction->updateRecords($data, $transactionId);
				break;
			case 201:
				$data['result'] = "Failed to deduct MOLPoints.";
				$transaction->updateRecords($data, $transactionId);
				break;
			case 202:
				$data['result'] = "Unexpected error occurs during generate Order Id.";
				$transaction->updateRecords($data, $transactionId);
				break;
			case 203:
				$data['result'] = "Failed to register user.";
				$transaction->updateRecords($data, $transactionId);
				break;
			case 204:
				$data['result'] = "Failed to retrieve user wallet.";
				$transaction->updateRecords($data, $transactionId);
				break;
			case 205:
				$data['result'] = "Password hash not match.";
				$transaction->updateRecords($data, $transactionId);
				break;
			case 206:
				$data['result'] = "Failed to activate user account.";
				$transaction->updateRecords($data, $transactionId);
				break;
			case 207:
				$data['result'] = "Failed to retrieve transaction summary.";
				$transaction->updateRecords($data, $transactionId);
				break;
			case 208:
				$data['result'] = "Failed to generate HeartBeat.";
				$transaction->updateRecords($data, $transactionId);
				break;
			case 209:
				$data['result'] = "Duplication email found.";
				$transaction->updateRecords($data, $transactionId);
				break;
			case 210:
				$data['result'] = "Failed to update Offline Message.";
				$transaction->updateRecords($data, $transactionId);
				break;
			case 400:
				$data['result'] = "Incomplete parameters on submission.";
				$transaction->updateRecords($data, $transactionId);
				break;
			case 401:
				$data['result'] = "Invalid parameters on submission.";
				$transaction->updateRecords($data, $transactionId);
				break;
			case 403:
				$data['result'] = "Invalid amount.";
				$transaction->updateRecords($data, $transactionId);
				break;
			case 405:
				$data['result'] = "Invalid SHA1 checksum.";
				$transaction->updateRecords($data, $transactionId);
				break;
			case 600:
				$data['result'] = "Invalid Merchant ID.";
				$transaction->updateRecords($data, $transactionId);
				break;
			case 601:
				$data['result'] = "Request are not submitted from the Merchant’s IP address.";
				$transaction->updateRecords($data, $transactionId);
				break;
			case 602:
				$data['result'] = "Duplicated merchant reference ID.";
				$transaction->updateRecords($data, $transactionId);
				break;
			case 603:
				$data['result'] = "Unable to determine Merchant account.";
				$transaction->updateRecords($data, $transactionId);
				break;
			case 800:
				$data['result'] = "Insufficient balance to continue the order.";
				$transaction->updateRecords($data, $transactionId);
				break;
			case 801:
				$data['result'] = "User session has expired.";
				$transaction->updateRecords($data, $transactionId);
				break;
			case 803:
				$data['result'] = "User is spending too much time at a certain page.";
				$transaction->updateRecords($data, $transactionId);
				break;
			case 802:
				$data['result'] = "User has chosen to cancel the transaction.";
				$transaction->updateRecords($data, $transactionId);
				break;
			case 999:
				$data['result'] = "Expired HeartBeat value.";
				$transaction->updateRecords($data, $transactionId);
				break;
		}
		$this->_createTicket($transactionId, $playerId, NULL, $molOfLine);
	}
}
