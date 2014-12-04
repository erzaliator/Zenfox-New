<?php

class Zenfox_Transaction_Methods_Netbanking extends Zenfox_Transaction
{
	private $_amount;
	public function __construct($paymentType, $amount, $status)
	{
		parent::__construct($paymentType, $amount, $status);
		$this->_amount = $amount;
	}
	
	public function process($bankId)
	{
		$transactionId = $this->getTransactionId();
		echo 'id' . $transactionId;
		//TODO Replace it with the merchant Id
		$srcsiteid = 'T1472';
		$crn = 'INR';
		$amt = $this->_amount;
		$itc = 4;
		$prn = $transactionId;
		$cstbankid = $bankId;
		//TODO Replace it with merchant URL
		$uri = 'https://www.tpsl-india.in/PaymentGateway/GatewayEnter.jsp';
		$ch = curl_init($uri);
		$params['SRCSITEID'] = $srcsiteid;
		$params['CRN'] = $crn;
		$params['AMT'] = $amt;
		$param['ITC'] = $itc;
		$param['PRN'] = $prn;
		//$param['CSTBANKID'] = $cstbankid;
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		$body = curl_exec($ch);
		
		curl_close($ch);
		Zenfox_Debug::dump($body, 'body');
        return $body;
	}
	
	public function processloop()
	{
		
	}
	
	public function endprocess()
	{
		$playerId = 1;
		$currencyValue = 100;
		$playerTransactions = new PlayerTransactions();
		$sourceId = $playerTransactions->creditBonus($playerId, $currencyValue);
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
	}
	
	public function destroy($object)
	{
		unset($object);
	}
}