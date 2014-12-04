<?php

/**
 * This class handles Citruspay payment gateway
 * Enter description here ...
 * @author nikhil
 *
 */
class Zenfox_Transaction_Gateway_Citruspay extends Zenfox_Transaction
{
	private function _setPlayerDetails()
	{
		parent::setPlayerDetails();
	}
	
	private function _getPlayerDetails()
	{
		return parent::getPlayerDetails();
	}
	
	private function _addTransaction($paymentMethod, $amount, $gatewayId, $currencyCode)
	{
		parent::addTransaction($paymentMethod, $amount, $gatewayId, $currencyCode);
	}
	
	private function _getTransactionId()
	{
		return parent::getTransactionId();
	}
	
	private function _setAmount()
	{
		parent::setAmount();
	}
	
	private function _getAmount()
	{
		return parent::getAmount();
	}
	
	private function _setPaymentMethod()
	{
		parent::setPaymentMethod();
	}
	
	private function _getPaymentMethod()
	{
		return parent::getPaymentMethod();
	}
	
	private function _setTransactionCookie()
	{
		parent::setTransactionCookie();
	}
	
	private function _setBankCode()
	{
		parent::setBankCode();
	}
	
	private function _getBankCode()
	{
		return parent::getBankCode();
	}
	
	private function _updateTransactionStatus($transactionId, $status = NULL)
	{
		parent::updateStatus($transactionId, $status);
	}
	
	private function _creditAccount($playerId, $amount, $currencyCode, $transactionId, $trackerId)
	{
		return parent::creditAccount($playerId, $amount, $currencyCode, $transactionId, $trackerId);
	}
	
	public function start()
	{
		$this->_setPlayerDetails();
		$playerDetails = $this->_getPlayerDetails();
		
		$this->_setAmount();
		$amount = $this->_getAmount();
		
		$this->_setPaymentMethod();
		$paymentMethod = $this->_getPaymentMethod();
		
		$gatewayId = 'CITRUSPAY';
		
		$currencyCode = 'INR';
		
		$this->_addTransaction($paymentMethod, $amount, $gatewayId, $currencyCode);
		$this->_setTransactionCookie();
		
		$transactionId = $this->_getTransactionId();
		
		$this->_setBankCode();
		$bankCode = $this->_getBankCode();
		
		CitrusPay::setApiKey("86c91f23fec7b3193a99c41a8446bc572ce93adb",'production');
		
		$vanityUrl = "2o6t69fv9p";
				
		//$cardHolderName = "";
		//$cardNumber = "";
		//$expiryMonth = "";
		//$cardType = "";
		//$cvvNumber = "";
		//$expiryYear = "";
		
		$data = "$vanityUrl$amount$transactionId$currencyCode";
		$secSignature = Zend_Crypt_Hmac::compute(CitrusPay::getApiKey(), "sha1", $data);
		
		$action = CitrusPay::getCPBase()."$vanityUrl";
		
		$time = time()*1000;
		$time = number_format($time,0,'.','');
		
		//$this->view->cardHolder = $cardHolderName;
		//$this->view->cardNumber = $cardNumber;
		//$this->view->type = $cardType;
		//$this->view->expiryMonth = $expiryMonth;
		//$this->view->expiryYear = $expiryYear;
		//$this->view->cvvNumber = $cvvNumber;
	
		$processedData = array();
		foreach($playerDetails as $index => $value)
		{
			$processedData[$index] = $value;
		}
		$processedData['transactionId'] = $transactionId;
		$processedData['amount'] = $amount;
		$processedData['bankCode'] = $bankCode;
		$processedData['action'] = $action;
		$processedData['reqTime'] = $time;
		$processedData['signature'] = $secSignature;
	
		return $processedData;
	}
	
	public function process()
	{
		setcookie('transactionId','',time(),'/','.'.$_SERVER['HTTP_HOST']);
	
		$this->_updateTransactionStatus($_POST['transId'], 'PENDING');
	
		return true;
	}
	
	public function endprocess()
	{			
		$jsonData = Zend_Json::encode($_POST);
		$transactionId =  $_POST['TxId'];
	
		$this->_setBankCode();	
		$data['gatewayTransId'] =  $_POST['TxRefNo'];
		$data['bankName'] =  $this->_getBankCode();
		$data['gatewayResponse'] = $jsonData;
		$data['gatewayTransTime'] =  $_POST['txnDateTime'];
		$data['responseUrl'] = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		$data['result'] = $_POST['TxMsg'];
		$data['status'] = 'ERROR';
		
		$error = "";
		
		$transaction = new PlayerTransactionRecord();
		
		if($_POST['TxStatus'] == 'SUCCESS')
		{
			$data['status'] = 'PROCESSED';
			$amount = $_POST['amount'];
			$currencyCode = $_POST['currency'];
			$email = $_POST['email'];
			
			$session = new Zenfox_Auth_Storage_Session();
			$storedData = $session->read();
			$playerId = $storedData['id'];
			
			$trackerId = $storedData['authDetails'][0]['tracker_id'];
			
			$transaction->updateRecords($data, $transactionId);
			
			if($this->_creditAccount($playerId, $amount, $currencyCode, $transactionId, $trackerId))
			{
				$bankCodeSession = new Zend_Session_Namespace('bankCode');
				$bankCodeSession->unsetAll();
				
				$mail = new Mail();
				$mail->sendToOne('Transactionsuccess', 'TRANSACTION_SUCCESS', $transactionId, '', $email);
				
				$frontendName = Zend_Registry::get('frontendName');
				
				header('Location: https://' . $frontendName . '/banking/index/trackerId/' . $trackerId  . '/transactionId/' . $transactionId);
				exit;
			}
			else
			{
				$error =  "Some problem has been occured while crediting the amount. Please try again, if the problem persists then contact to our customer support!!";
			}
		}
		else
		{
			$error = "Your amount is not credited, may be you cancelled the payment, please try again. If problem persists, please contact our support.";
		}
		
		
		$transaction->updateRecords($data, $transactionId);
		
		return $error;
	}
}
