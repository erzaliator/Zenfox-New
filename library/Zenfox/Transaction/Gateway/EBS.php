<?php

class Zenfox_Transaction_Gateway_EBS extends Zenfox_Transaction
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
		
		$gatewayId = 'EBS-5880';
		
		$currencyCode = 'INR';
		
		$this->_addTransaction($paymentMethod, $amount, $gatewayId, $currencyCode);
		$this->_setTransactionCookie();
		
		$transactionId = $this->_getTransactionId();
		
		$returnUrl = "http://" . $_SERVER['HTTP_HOST'] . "/transaction/confirm?DR={DR}";
		
		$hash = "ebskey|5880|".$amount."|".$transactionId."|".$returnUrl."|TEST";
		
		$secure_hash = md5($hash);
		
		$processedData = array();
		foreach($playerDetails as $index => $value)
		{
			$processedData[$index] = $value;
		}
		$processedData['transactionId'] = $transactionId;
		$processedData['amount'] = $amount;
		$processedData['action'] = "https://secure.ebs.in/pg/ma/sale/pay";
		$processedData['hash'] = $secure_hash;
		$processedData['mode'] = "TEST";
		$processedData['returnUrl'] = $returnUrl;
		$processedData['description'] = "TaashCash";
		$processedData['bankCode'] = "";
		
		return $processedData;
	}
	
	public function process()
	{
		
	}
	
	public function endprocess()
	{
		$secret_key = "ebskey";         // Your Secret Key
		$error = "Some problem has been occured while getting response. Please contact to our customer support";
		
		if(isset($_GET['DR']))
		{
			$DR = preg_replace("/\s/","+",$_GET['DR']);
			
			$rc4 = new Crypt_RC4($secret_key);
			$QueryString = base64_decode($DR);
			$rc4->decrypt($QueryString);
			$QueryString = split('&',$QueryString);
			
			$response = array();
			foreach($QueryString as $param)
			{	
				$param = split('=',$param);
				$response[$param[0]] = urldecode($param[1]);
			}
			
			$data['gatewayTransId'] =  $response['TransactionID'];
			$data['bankName'] =  "";
			$data['gatewayResponse'] = Zend_Json::encode($response);
			$data['gatewayTransTime'] =  $response['DateCreated'];
			$data['responseUrl'] = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
			$data['result'] = $response['ResponseCode'] . '-' . $response['ResponseMessage'];
			$data['status'] = 'ERROR';
			
			$transactionId = $response['MerchantRefNo'];
			
			$transaction = new PlayerTransactionRecord();
			if($response['ResponseCode'] == 0)
			{
				$data['status'] = 'PROCESSED';
				$amount = $response['Amount'];
				$currencyCode = "INR";
				$email = $response['BillingEmail'];
					
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
			
		}
		return $error;
	}
}
