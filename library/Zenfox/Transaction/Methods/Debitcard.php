<?php

class Zenfox_Transaction_Methods_Debitcard extends Zenfox_Transaction
{
	public function __construct($paymentType)
	{
		parent::__construct($paymentType);
	}
	/*public function init()
	{
		$transFile = APPLICATION_PATH . '/configs/transactionConfig.json';
		$fh = fopen($transFile, "r");
		$transJson = fread($fh, filesize($transFile));
		fclose($fh);
		
		$transConfig = Zend_Json::decode($transJson);
		Zenfox_Debug::dump($transConfig, 'config');
		$session = new Zenfox_Auth_Storage_Session();
		$storedData = $session->read();
		Zenfox_Debug::dump($storedData, 'data');
		$player = new Player();
		$playerData = $player->getPlayerData($storedData['id']);
		Zenfox_Debug::dump($playerData, 'playerData');
		if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
	    {
	      $ip=$_SERVER['HTTP_CLIENT_IP'];
	    }
	    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
	    {
	      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
	    }
	    else
	    {
	      $ip=$_SERVER['REMOTE_ADDR'];
	    }
	    echo $ip;
	}*/
	
	public function process()
	{
		echo 'in debit';
		return true;
		/*$client = new SoapClient("https://www.i-point.bz/secure/ts/processor.wsdl",array('exceptions' => 0,"trace" => 1));
		$result = $client->insertNewApplication("99444445", "henrik", "piski", "", "", "", "", "", "", "","F","BOV", "444444444444", "09/2006", "mytest", "22386");
		switch ($result){
			case '0': 
				$message = "Transaction is refused! Unknown mobile or userid";
				break;
			case '1': 
				$message = "Transaction is inserted!";
				break;
			case '3': 
				$message = "Transaction is pending!";
				break;
			case '4': 
				$message = "Internal Error!";
				break;
			case '5': 
				$message = "Invalid Parameters!";
				break;
			case '6': 
				$message = "Unknown Merchant!";
				break;
			case '7': 
				$message = "The daily deposit limit has been reached!";
				break;
		}
		return $message;
		$session = new Zenfox_Auth_Storage_Session();
		$storedData = $session->read();
		
		$playerId = $storedData['id'];
		$player = new Player();
		$playerData = $player->getPlayerData($playerId);
		$firstName = $playerData['firstName'];
		$lastName = $playerData['lastName'];
		$email = $playerData['email'];
		$address = $playerData['address'];
		$city = $playerData['city'];
		$state = $playerData['state'];
		$pin = $playerData['pin'];
		$country = $playerData['country'];
		$phoneNo = $playerData['phone'];
		
		if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
	    {
	      $ip=$_SERVER['HTTP_CLIENT_IP'];
	    }
	    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
	    {
	      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
	    }
	    else
	    {
	      $ip=$_SERVER['REMOTE_ADDR'];
	    }
	    $ipAddress = $ip;
		$currencyCode = $storedData['authDetails'][0]['base_currency'];
		$callbackUrl = "http://zenfox.tld/";
		
		$requestUrl = "http://zenfox.tld/auth/view/merchantId/1";
		
		//TODO return the string that has to passed to API
		return true;*/
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