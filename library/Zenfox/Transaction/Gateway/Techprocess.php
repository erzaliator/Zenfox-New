<?php

/**
* This class handles Techprocess payment gateway
* Enter description here ...
* @author nikhil
*
*/
class Zenfox_Transaction_Gateway_Techprocess extends Zenfox_Transaction
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
		
		$gatewayId = 'TECHPROCESS-L1472';
		
		$frontendName = Zend_Registry::get('frontendName');
		if($frontendName == 'ace2jak.com')
		{
			$gatewayId = 'TECHPROCESS-L2636';
		}
		
		$currencyCode = 'INR';
		
		$this->_addTransaction($paymentMethod, $amount, $gatewayId, $currencyCode);
		$this->_setTransactionCookie();
		
		$transactionId = $this->_getTransactionId();
		
		$this->_setBankCode();
		$bankCode = $this->_getBankCode();
		
		$processedData = array();
		foreach($playerDetails as $index => $value)
		{
			$processedData[$index] = $value;
		}
		$processedData['transactionId'] = $transactionId;
		$processedData['amount'] = $amount;
		$processedData['bankCode'] = $bankCode;
		$processedData['action'] = '/transaction/index';
		
		return $processedData;
	}
	
	public function process()
	{
		setcookie('transactionId','',time(),'/','.'.$_SERVER['HTTP_HOST']);
		
		$this->_updateTransactionStatus($_POST['transId'], 'PENDING');
		
		$confirmation = $_POST['confirm'];
			
		if(isset($confirmation))
		{
			$tpslWrapObj = new TPSL_Wrapper();
			if($tpslWrapObj->appStatus)
			{
				$result = $tpslWrapObj->processRequest();
				preg_match('/^<RESULT>(.*)<\/RESULT>$/', $result, $match);
				if($match[1] != '')
				{
					header('Location: https://www.tpsl-india.in/PaymentGateway/TransactionRequest.jsp?msg=' . $match[1]);
					exit;
				}
				else
				{
					return 'Oops! We seem to have missed your last action! <br>Please try again or write to us at <a href="mailto:support@taashtime.com">support@taashtime.com</a>';
				}
			}
		}
	}
	
	public function endprocess()
	{
		$tpslWrapObj = new TPSL_Wrapper();
		if($tpslWrapObj->appStatus)
		{
			$session = new Zenfox_Auth_Storage_Session();
			$storedData = $session->read();
			$playerId = $storedData['id'];
			
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
			$data['status'] = 'ERROR';
			
			$transaction = new PlayerTransactionRecord();
			$transactionResult = $tpslWrapObj->responseData[14];
			
			//Credit the deposit in player account
			//Transaction is successful
			if($transactionResult == '0300')
			{
				$data['status'] = 'PROCESSED';
				$transaction->updateRecords($data, $transactionId);
			
				$amount = $tpslWrapObj->responseData[4];
				$currencyCode = $tpslWrapObj->responseData[8];
				$email = $store['authDetails'][0]['email'];
				$trackerId = $store['authDetails'][0]['tracker_id'];
				if($this->_creditAccount($playerId, $amount, $currencyCode, $transactionId, $email, $trackerId))
				{
					$bankCodeSession = new Zend_Session_Namespace('bankCode');
					$bankCodeSession->unsetAll();
					
					$mail = new Mail();
					$mail->sendToOne('Transactionsuccess', 'TRANSACTION_SUCCESS', $transactionId, '', $email);
					
					$frontendName = Zend_Registry::get('frontendName');
					
					header('Location: https://' . $frontendName . '/banking/index/trackerId/' . $trackerId  . '/transactionId/' . $transactionId);
					exit;
				}
			}
			else
			{
				$error = "Your amount is not credited, may be you cancelled the payment, please try again. If problem persists, please contact our support.";
			}
		}
		else
		{
			$error =  "Some problem has been occured while crediting the amount. Please try again, if the problem persists then contact to our customer support!!";
		}
		
		
		$transaction->updateRecords($data, $transactionId);
		
		return $error;
	}
}
