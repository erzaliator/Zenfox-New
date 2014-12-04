<?php
abstract class Zenfox_Transaction
{
	private $_transactionId;
	private $_playerId;
	
	private $_amount;
	private $_paymentMethod;
	private $_visitIndexPage;
	private $_bankCode;
	private $_prevAmountSess;
	private $_prevPaymentTypeSess;
	
	private $_playerAddressSess;
	private $_playerContactSess;
	private $_playerPinCodeSess;
	private $_playerCitySess;
	
	private $_nameSess;
	private $_contact;
	private $_email;
	private $_address;
	private $_city;
	private $_state;
	private $_pin;
	
	private $_molSess;
	private $_schemeSess;
	
	private $_firstName;
	private $_lastName;
	private $_sex;
	private $_dob;
	
	public function __construct()
	{
		$session = new Zenfox_Auth_Storage_Session();
		$storedData = $session->read();
		$this->_playerId = $storedData['id'];
	}
	
	public function addTransaction($paymentMethod, $amount, $gatewayId, $currencyCode)
	{		
		$clientIpAddress = Zend_Controller_Front::getInstance()->getRequest()->getClientIp();
		$data['ipAddress'] = $clientIpAddress;
		$data['amount'] = $amount;
		$data['playerId'] = $this->_playerId;
		$data['currencyCode'] = $currencyCode;
		$data['paymentMethod'] = $paymentMethod;
		$data['status'] = 'UNPROCESSED';
		$data['requestUrl'] = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		$data['gatewayId'] = $gatewayId;
			
		$transaction = new PlayerTransactionRecord();
		$this->_transactionId = $transaction->insertData($data);
	}
	
	public function updateStatus($transactionId = NULL, $status = NULL)
	{
		if(!$transactionId)
		{
			$transactionId = $this->getTransactionId();
		}
		$playerTransactionRecord = new PlayerTransactionRecord();
		$playerTransactionRecord->updateData($this->_playerId, $transactionId, 'status', $status);
	}
	
	public function getTransactionId()
	{
		return $this->_transactionId;
	}
	
	public function setAmount()
	{
		$amountSession = new Zend_Session_Namespace('depositAmount');
		$this->_amount = $amountSession->value;
	}
	
	public function getAmount()
	{
		return $this->_amount;
	}
	
	public function setPaymentMethod()
	{
		$paymentTypeSess = new Zend_Session_Namespace('paymentType');
		$this->_paymentMethod = $paymentTypeSess->value;
	}
	
	public function getPaymentMethod()
	{
		return $this->_paymentMethod;
	}
	
	public function setTransactionCookie()
	{
		$transactionId = $this->getTransactionId();
		
		$cookie = isset($_COOKIE['transactionId'])?$_COOKIE['transactionId']:null;
		if($cookie)
		{
			$setTransactionId = $_COOKIE['transactionId'];
			$this->updateStatus($setTransactionId, 'REFRESHED');
		}
		setcookie('transactionId',$transactionId,time() + (3600 * 30),'/','.'.$_SERVER['HTTP_HOST']);
	}
	
	public function setBankCode()
	{
		$bankCodeSession = new Zend_Session_Namespace('bankCode');
		$this->_bankCode = $bankCodeSession->value;
	}
	
	public function getBankCode()
	{
		return $this->_bankCode;
	}
	
	public function setPlayerDetails()
	{
		$prevAmountSess = new Zend_Session_Namespace('prevAmount');
		$prevPaymentTypeSess = new Zend_Session_Namespace('prevPaymentType');
		
		$playerAddressSess = new Zend_Session_Namespace('playerAddress');
		$playerContactSess = new Zend_Session_Namespace('playerContact');
		$playerPinCodeSess = new Zend_Session_Namespace('playerPinCode');
		$playerCitySess = new Zend_Session_Namespace('playerCity');
		
		$nameSess = new Zend_Session_Namespace('name');
		$contactSess = new Zend_Session_Namespace('contact');
		$emailSess = new Zend_Session_Namespace('email');
		$addressSess = new Zend_Session_Namespace('address');
		$citySess = new Zend_Session_Namespace('city');
		$stateSess = new Zend_Session_Namespace('state');
		$pinSess = new Zend_Session_Namespace('pin');
		
		$firstNameSess = new Zend_Session_Namespace('firstName');
		$lastNameSess = new Zend_Session_Namespace('lastName');
		$sexSess = new Zend_Session_Namespace('sex');
		$dobSess = new Zend_Session_Namespace('dob');
		
		$molSess = new Zend_Session_Namespace('mol');
		$schemeSess = new Zend_Session_Namespace('schemeId');
		
		$this->_firstName = $firstNameSess->value;
		$this->_lastName = $lastNameSess->value;
		$this->_sex = $sexSess->value;
		$this->_dob = $dobSess->value;
		$this->_contact = $contactSess->value;
		$this->_email = $emailSess->value;
		$this->_address = $addressSess->value;
		$this->_city = $citySess->value;
		$this->_state = $stateSess->value;
		$this->_pin = $pinSess->value;
		//$this->_action = "/transaction/index";
	}
	
	public function getPlayerDetails()
	{
		return array(
			'firstName' => $this->_firstName,
			'lastName' => $this->_lastName,
			'sex' => $this->_sex,
			'dob' => $this->_dob,
			'contact' => $this->_contact,
			'email' => $this->_email,
			'address' => $this->_address,
			'city' => $this->_city,
			'state' => $this->_state,
			'pin' => $this->_pin,
		);
	}
	
	public function deleteSessions()
	{
		$amountSession = new Zend_Session_Namespace('depositAmount');
		$prevAmountSess = new Zend_Session_Namespace('prevAmount');
		$prevPaymentTypeSess = new Zend_Session_Namespace('prevPaymentType');
		$playerAddressSess = new Zend_Session_Namespace('playerAddress');
		$playerContactSess = new Zend_Session_Namespace('playerContact');
		$playerPinCodeSess = new Zend_Session_Namespace('playerPinCode');
		$playerCitySess = new Zend_Session_Namespace('playerCity');
		$nameSess = new Zend_Session_Namespace('name');
		$contactSess = new Zend_Session_Namespace('contact');
		$emailSess = new Zend_Session_Namespace('email');
		
		$amountSession->unsetAll();
		$prevAmountSess->unsetAll();
		$prevPaymentTypeSess->unsetAll();
		$playerAddressSess->unsetAll();
		$playerContactSess->unsetAll();
		$playerPinCodeSess->unsetAll();
		$playerCitySess->unsetAll();
		$nameSess->unsetAll();
		$contactSess->unsetAll();
		$emailSess->unsetAll();
	}
	
	public function creditAccount($playerId, $amount, $currencyCode, $transactionId, $trackerId = NULL, $molPayment = false, $molOfLine = NULL)
	{
		$transactionObj = new Transactions();
		$creditAmount = $transactionObj->credit('DEPOSIT', $playerId, $amount, $currencyCode, $transactionId, '', $trackerId);
		return $creditAmount['success'];
	}
	
	abstract public function start();
	abstract public function process();
	abstract public function endprocess();
	//abstract public function destroy($object);
}