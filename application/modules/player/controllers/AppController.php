<?php
require_once dirname(__FILE__) . '/../forms/CoinsForm.php';
class Player_AppController extends Zenfox_Controller_Action
{
	public function indexAction()
	{
		Zend_Layout::getMvcInstance()->disableLayout();
		$refererAddress =  $_SERVER['HTTP_REFERER'];
		/*if(!$refererAddress)
		{
			foreach($_SERVER as $key => $value)
			{
				if(strpos($key, 'HTTP_X') === 0)
				{
					$currentPlatForm = 'rediff';
				}
			}
		}
		else
		{*/
			$platforms = array('ibibo', 'rediff', 'zapak');
			foreach($platforms as $platFormName)
			{
				if(strpos($refererAddress, $platFormName))
				{
					$currentPlatForm = $platFormName;
					break;
				}
			}
		//}
		//$currentPlatForm = 'ibibo';
		$userId = $this->getRequest()->userid;
		$platformInstance = Zenfox_Applications_Factory::getInstance($currentPlatForm, $userId);
		$setUserData = $platformInstance->setUserData();
		$ibiboAccessTokenSession = new Zend_Session_Namespace('ibiboAccessTokenSession');
		$ibiboAccessTokenSession->unsetAll();
		if($setUserData['success'])
		{
			$imagePath = "";
			switch($currentPlatForm)
			{
				case 'ibibo':
					$imagePath = $setUserData['userInfo']['profilePic'];
					break;
				case 'rediff':
					$imagePath = $setUserData['imagePath'];
                                        break;
			}
			$appImageSession = new Zend_Session_Namespace('appImage');
			$appImageSession->value = $imagePath;
			$this->_forward('index', 'game', 'player', array('appPage' => true, 'imagePath' => $imagePath, 'platform' => $currentPlatForm));
			//$this->_redirect('/game/index/appPage/true');
		}
		else
		{
			echo $setUserData['error'];
		}
	}

	public function balanceAction()
	{
		//$postData['access_token'] = $_COOKIE['access_token'];
		Zend_Layout::getMvcInstance()->disableLayout();

		$ibiboSession = new Zend_Session_Namespace('IbiboSession');
                $accessToken = $ibiboSession->value;

		$postData['access_token'] = $accessToken;
                $postData['app_id'] = 79921;
//              Zenfox_Debug::dump($postData, 'data');
                $balUrl = "http://apps.ibibo.com/method/icoin_balance";
                $url = str_replace(" ","%20",$balUrl);
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                $statusOut = curl_exec($ch);
//              Zenfox_Debug::dump($statusOut, 'result');
                curl_close($ch);

		$result = json_decode($statusOut,true);
                $currentBalance['balance'] = $result['balance'];

		echo json_encode($currentBalance);


		//Zenfox_Debug::dump($postData, 'accessToken');

		$ibiboSession = new Zend_Session_Namespace('IbiboSession');
		$accessToken = $ibiboSession->value;

		//echo $accessToken;

		$form = new Player_CoinsForm();
//		echo $form;
		if($this->getRequest()->isPost())
		{
			if($form->isValid($_POST))
			{
				$data = $form->getValues();
//				Zenfox_Debug::dump($data, 'data', true, true);
				$coinBalance = $data['coins'];

				$postData['access_token'] = $accessToken;
		                $postData['app_id'] = 79921;
		//		Zenfox_Debug::dump($postData, 'data');
				$balUrl = "http://apps.ibibo.com/method/icoin_balance";
				$url = str_replace(" ","%20",$balUrl);
			 	$ch = curl_init($url);
		                curl_setopt($ch, CURLOPT_POST, 1);
		                curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
                		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		                $statusOut = curl_exec($ch);
				//Zenfox_Debug::dump($statusOut, 'result');
                		curl_close($ch);

		                $result = json_decode($statusOut,true);
				$currentBalance = $result['balance'];
				if($coinBalance <= $currentBalance)
				{
					echo "Enough balance";
				}
				else
				{
					echo "No sufficient balance";
				}
			}
		}
/*		Zend_Layout::getMvcInstance()->disableLayout();
		echo "in payment";
		$postData['access_token'] = $_COOKIE['access_token'];
		$postData['app_id'] = 95800;
//		$postData['coins'] = 15;
//		$postData['itemname'] = 'taash';
//		$postData['transid'] = 100;
//		$postData['app_secret'] = '39004382290527505089';
		$balUrl = "http://apps.ibibo.com/method/icoin_balance";
//		$balUrl = "http://apps.ibibo.com/method/ingameDebitIcoins";
		$url = str_replace(" ","%20",$balUrl);
Zenfox_Debug::dump($url, 'url');
		$ch = curl_init($url);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                $statusOut = curl_exec($ch);
		curl_close($ch);

		$result = json_decode($statusOut,true);
Zenfox_Debug::dump($postData, 'data');
		Zenfox_Debug::dump($result, 'result');*/
	}

	public function creditAction()
	{

		$ibiboSession = new Zend_Session_Namespace('IbiboSession');
                $accessToken = $ibiboSession->value;

		$form = new Player_CoinsForm();
		$this->view->form = $form;
                if($this->getRequest()->isPost())
                {
                        if($form->isValid($_POST))
                        {
                                $data = $form->getValues();
//				Zenfox_Debug::dump($data, 'data');
                                $coinBalance = $data['coins'];
				if($data['coins'] == 'custom')
				{
					$coinBalance = $data['customIcoins'];
					if(!$coinBalance)
					{
						$coinBalance = 0;
					}
				} 
//				echo 'bal-' . $coinBalance; exit();

				$session = new Zenfox_Auth_Storage_Session();
	                        $store = $session->read();
        	                $playerId = $store['id'];

				//For Real Transaction
				/*
				$clientIpAddress = Zend_Controller_Front::getInstance()->getRequest()->getClientIp();
				$transactionData['ipAddress'] = $clientIpAddress;
				$transactionData['amount'] = $coinBalance;
				$transactionData['gatewayId'] = 'Ibibo';
				$transactionData['playerId'] = $playerId;
				$transactionData['currencyCode'] = 'INR';
				$transactionData['paymentMethod'] = "ICoins";
				$transactionData['status'] = 'UNPROCESSED';
				$transactionData['requestUrl'] = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
				$transaction = new PlayerTransactionRecord();
				$transactionEntry = $transaction->insertData($transactionData);
				$transactionId = $transaction->getTransactionId($playerId);
				*/
				$transactionId = 0;
                                $postData['access_token'] = $accessToken;
                                $postData['app_id'] = '09447';
                                $balUrl = "http://apps.ibibo.com/method/icoin_balance";
                                $url = str_replace(" ","%20",$balUrl);
                                $ch = curl_init($url);
                                curl_setopt($ch, CURLOPT_POST, 1);
                                curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                                $statusOut = curl_exec($ch);
                                curl_close($ch);

                                $result = json_decode($statusOut,true);
                                $currentBalance = $result['balance'];
				if($coinBalance <= 0)
				{
					$response = "Enter Valid Coins";
				}
                                elseif($coinBalance <= $currentBalance)
                                {
					$response = $this->_convertCoins($accessToken, $coinBalance, $playerId, $transactionId);
                                }
                                else
                                {
                                        $response = "Not Enough Icoins";
                                }
				$this->view->response = $response;
				//Zenfox_Debug::dump($response, 'response', true, true);
                        }
                }

	}

	private function _convertCoins($accessToken, $coinBalance, $playerId, $transactionId)
	{
		$postData['access_token'] = $accessToken;
                $postData['app_id'] = '09447';
		$postData['coins'] = $coinBalance;
		$postData['itemname'] = 'taash';
		$postData['transid'] = 100;
//              $postData['app_secret'] = '39755702334780676004';
		$debitUrl = "http://apps.ibibo.com/method/ingameDebitIcoins";
                $url = str_replace(" ","%20",$debitUrl);
                
		$ch = curl_init($url);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                $statusOut = curl_exec($ch);
                curl_close($ch);

                $result = json_decode($statusOut,true);
		if($result['result'] != 'failed')
		{
			//For Real Money Transaction
			/*
			$date = new Zend_Date();
		        $today = $date->get(Zend_Date::W3C);

			$transactionData['gatewayTransId'] =  '123';//$result['transactionid']; 
			$transactionData['bankName'] =  "Ibibo";
			$transactionData['gatewayResponse'] = '{}';//$statusOut;
			$transactionData['status'] = 'PROCESSED';
			$transactionData['gatewayTransTime'] =  $today;
			$transactionData['responseUrl'] = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
			$transactionData['result'] = 'Success';//$result['result'];
			$transaction = new PlayerTransactionRecord();
			$transaction->updateRecords($transactionData, $transactionId);
			*/

                	$data['playerId'] = $playerId;
	                $data['variableName'] = 'freeMoney';

        	        $accountVariable = new AccountVariable();
                	$varData = $accountVariable->getData($playerId, 'freeMoney');
	                $freeChips = floatval($varData['varValue']);
        	        $data['varId'] = $varData['varId'];
                	$totalFreeChips = (int)($freeChips) + $coinBalance * 10;
	                $data['variableValue'] = "$totalFreeChips";

        	        $accountVariable->insert($data);
                	return "Your account has been credited with " . $coinBalance * 10 . " Taash Coins.";
		}
//		return $result;
		return "Problem in converting ICoins. Please contact to our customer support";

/*		$session = new Zenfox_Auth_Storage_Session();
                $store = $session->read();
                $playerId = $store['id'];

		$data['playerId'] = $playerId;
		$data['variableName'] = 'freeMoney';
		
		$accountVariable = new AccountVariable();
		$varData = $accountVariable->getData($playerId, 'freeMoney');
		$freeChips = floatval($varData['varValue']);
		$data['varId'] = $varData['varId'];
		$totalFreeChips = (int)($freeChips) + $coinBalance;
		$data['variableValue'] = "$totalFreeChips";
		
		$accountVariable->insert($data);
		return "Your account has been credited with free chips " . $totalFreeChips;
/*		$amount = 10;
		$session = new Zenfox_Auth_Storage_Session();
		$store = $session->read();
		$playerId = $store['id'];
		$playerData = $store['authDetails'][0];
		$baseCurrency = $playerData['base_currency'];

		$playerTransactions = new PlayerTransactions();
		$sourceId = $playerTransactions->creditBonus($playerId, $amount, $baseCurrency);
		if(!$sourceId)
		{
			return "Your amount is not credited, please try again. If problem persists, please contact our customer support";
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
			return "Your amount is not credited, please try again. If problem persists, please contact our customer support";
		}
		if(($reportMessage['processed'] == 'PROCESSED') && ($reportMessage['error'] == 'NOERROR'))
		{
			return "Congratulations!! Your account has been credited by Rs. " . $amount;
		}
		elseif($counter != 3)
		{
			return "Your amount is not credited, please try again. If problem persists, please contact our customer support with audit id : " . $reportMessage['auditId'];
		}*/
	}
}