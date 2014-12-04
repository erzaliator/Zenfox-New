<?php

class Zenfox_Transaction_Gateway_Mobikwik extends Zenfox_Transaction
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
		
		$frontendId = Zend_Registry::get('frontendId');
	
		$gatewayId = 'MOBIKWIK-' . $frontendId;
	
		$currencyCode = 'INR';
	
		$this->_addTransaction($paymentMethod, $amount, $gatewayId, $currencyCode);
		$this->_setTransactionCookie();
	
		$transactionId = $this->_getTransactionId();
	
		$this->_setBankCode();
		$bankCode = $this->_getBankCode();
	
		$action = "http://secure.taashnetwork.com/prepare.php";
	
		$processedData = array();
		foreach($playerDetails as $index => $value)
		{
			$processedData[$index] = $value;
		}
		$processedData['transactionId'] = $transactionId;
		$processedData['amount'] = $amount;
		$processedData['bankCode'] = $bankCode;
		$processedData['action'] = $action;
	
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
		$jsonData = $_POST['result'];
		$postData = Zend_Json::decode($_POST['result']);
		
		$transactionId =  $postData['transactionId'];
				
		$data['gatewayTransId'] =  "";
		$data['bankName'] =  "";
		$data['gatewayResponse'] = $jsonData;
		$data['gatewayTransTime'] =  "";
		$data['responseUrl'] = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		$data['result'] = "Failed";
		$data['status'] = 'ERROR';
		
		$error = "";
		
		$transaction = new PlayerTransactionRecord();
		
		if($postData['success'])
		{
			if($postData['flag'])
			{
				$data['gatewayTransId'] =  $postData['refid'][0];
				$data['status'] = 'PROCESSED';
				
				$session = new Zenfox_Auth_Storage_Session();
				$storedData = $session->read();
				$playerId = $storedData['id'];
				
				$amount = $postData['amount'][0];
				$currencyCode = $storedData['authDetails'][0]['base_currency'];
				$email = $storedData['authDetails'][0]['email'];
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
		}
		else
		{
			$error = $postData['message'];
		}
	
		$transaction->updateRecords($data, $transactionId);
	
		return $error;
	}
}