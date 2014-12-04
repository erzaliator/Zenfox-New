<?php

/**
 * Account
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 *
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6401 2011-04-15 16:12:04Z guilhermeblanco $
 */
class UserActions
{

	private $_playerId;
	//define ("TIME_PERIOD_24_HOURS", "24");

	public function __construct($playerId)
	{
		$this->_playerId = $playerId;
	}
	//public function creditLoginBonus($amount, $amountType = "BONUS", $timePeriod = TIME_PERIOD_24_HOURS)
	public function creditLoginBonus($amount = NULL, $amountType = "BONUS")
	{
		$session = new Zend_Auth_Storage_Session();
		$storedData = $session->read();
		$playerId = $storedData['id'];
		$buddyId = $storedData['authDetails'][0]['buddy_id'];
		$lastLogin = $storedData['authDetails'][0]['last_login'];
		$totalDeposit = $storedData['authDetails'][0]['total_deposits'];
		
		
		$currentLogin = Zend_Date::now();
		$lastLogin = new Zend_Date($lastLogin);
		
		$currentTime = Zend_Date::now();
		$prevDay = $currentTime->sub(1, Zend_Date::DAY);
		
		$diff = $prevDay->compare($lastLogin, Zend_Date::DAY);
		if($diff >= 0)
		{
			$player = new Player();
			$prevLoyaltyPoints = $player->getLoyaltyPoints($playerId);
			$totalLoyaltyPoints = $prevLoyaltyPoints['totalLoyaltyPoints'];
			$loyaltyPointsLeft = $prevLoyaltyPoints['loyaltyPointsLeft'];
				
			$currentTotalLoyaltyPoints = $totalLoyaltyPoints + 10;
			$currentLoyaltyPointsLeft = $loyaltyPointsLeft + 10;
			$player->updateLoyaltyPoints($playerId, $currentTotalLoyaltyPoints, $currentLoyaltyPointsLeft);
		}
		
		//Zenfox_Debug::dump($difference, 'difference', true, true);
		
		/* $d1 = new Zend_Date('1 Jan 2008');
		$d2 = new Zend_Date('1 Feb 2010');
		$diff = $d2->sub($d1)->toValue();
		$months = floor(((($diff/60)/60)/24)/30);
		Zenfox_Debug::dump($months, 'months'); */

		$frontendvariableobj = new FrontendVariables();
		$LoginBounusData = $frontendvariableobj->getdata(1,"LOGINBONUS");
		
		$LoginBounusData = json_decode($LoginBounusData["variableValue"]);
		
		//Zenfox_Debug::dump($LoginBounusData);exit;
		if($LoginBounusData->status == "ENABLED")
		{
			$staticDate = new Zend_Date("'".$LoginBounusData->from_date." ".$LoginBounusData->from_time."'");
			$staticdiff = $staticDate->sub($lastLogin)->toValue();
		
			
			if($staticdiff >= 1)
			{
				//Zend_Debug::dump($staticDate);Zend_Debug::dump($staticdiff);exit;
				$promotionTime = new Zend_Date("'".$LoginBounusData->to_date." ".$LoginBounusData->to_time."'");
				$currentLogin = Zend_Date::now();
				$dif = $promotionTime->sub($currentLogin)->toValue();
				$seconds = floor($dif);//Zenfox_Debug::dump($promotionTime);Zenfox_Debug::dump($lastLogin);Zenfox_Debug::dump($dif);exit;
				if($seconds >= 0)
				{
					return $this->addBalance($playerId, $LoginBounusData->amount, 'GBP', $LoginBounusData->bonustype,$LoginBounusData->note);
				}
			}
		}
		
		/*$staticDate = new Zend_Date("2013-09-26 11:45:00");
		$staticdiff = $staticDate->sub($lastLogin)->toValue();
		
		if($staticdiff >= 1)
		{
			$promotionTime = new Zend_Date('2013-09-27 11:45:00');
			$currentLogin = Zend_Date::now();
			$dif = $promotionTime->sub($currentLogin)->toValue();
			$seconds = floor($dif);//Zenfox_Debug::dump($promotionTime);Zenfox_Debug::dump($lastLogin);Zenfox_Debug::dump($dif);exit;
			if($seconds >= 0)
			{
				return $this->addBalance($playerId, 5, 'GBP', 'BONUS');
			}
		}
		*/
		
		$lastlogindate = $lastLogin->getDate();
		$difference = $currentLogin->sub($lastlogindate)->toValue();
		$daydifference = floor($difference/(60*60*24));
		
		if($daydifference >= 1)
		{
			$accountVariable = new AccountVariable();
			if($daydifference > 1)
			{
				$vardata['playerId'] = $playerId;
				$vardata['variableName'] = 'CONSECUTIVE_DAYS';
				$vardata['variableValue'] = 0;
				$accountVariable->insert($vardata);
			}
			
			$vardata['playerId'] = $playerId;
			$vardata['variableName'] = 'INVITED_FRIENDS';
			$vardata['variableValue'] = 0;
			$accountVariable->insert($vardata);
			
			 $details = $this->addFreeChips($playerId);
		}
		
		
		
		
		//YASWANTH CODE
		
		/*
		 * Check the user log-in in the last 24 hours (or timePeriod) and if he did not then credi him be the amount given
		 */

		/* $conn = Zenfox_Partition::getInstance()->getConnections($this->_playerId);
	    Doctrine_Manager::getInstance()->setCurrentConnection($conn);

	    $query = Zenfox_Query::create()
					//->select('datediff(now(), a.last_login) as datediff, a.base_currency')
					->select('a.last_login, a.base_currency')
	    			->from ('AccountDetail a')
	    			->where	(
	    				'a.player_id = ?', 
	    				$this->_playerId);

		$result = $query->fetchArray();


		$messenger = Zend_Controller_Action_HelperBroker::getStaticHelper('flashMessenger');

		$creditAccount = false;

		if(is_null($result[0]['last_login']))
		{
			$creditAccount = true;
		}
		else
		{
			//$currentDate = Zend_Date::now();
			$currentDate = new Zend_Date (Zend_Date::DATES);
			$lastLoginDate = new Zend_Date ($result[0]['last_login'], Zend_Date::DATES);
			
			$dateDifference = $currentDate->sub($lastLoginDate)->toValue();
			
			$dateDifference = floor(((($diff/60)/60)/24)/30);
			if( $dateDifference >= 1)
			{
				$creditAccount = true;
			}
		}
		

		//if(is_null($result[0]['datediff']) || $result[0]['datediff'] >= 1)
		if($creditAccount)
		{
			$playerTransactions = new PlayerTransactions();
			
			$sourceId = $playerTransactions->creditBonus($this->_playerId, $amount, $result[0]['base_currency'], "Login Bonus");


			if($playerTransactions->checkSourceId($this->_playerId, $sourceId))
			{
				$messenger->addMessage('Congratulations. Your account has been credited with '. new Zend_Currency(array('value' => $amount, 'currency'=> $result[0]['base_currency'])));
	
			}
			else
			{
				$messenger->addMessage(array('error'=>'Oops, unable to credit your Login Bonus. Please contact customer support'));
			}

		}

		try
		{
			$query = Zenfox_Query::create()
					->update('AccountDetail a')
					->set('a.last_login', 'NOW()')
					->where('a.player_id =?', $this->_playerId);

			$query->execute();
		}
		catch (Exception $e)
		{
				$messenger->addMessage(array('error'=>'Oops, unable to update your Login Status'));
		} */
		
	}
	
	public function creditBuddyBonus()
	{
		$session = new Zend_Auth_Storage_Session();
		$storedData = $session->read();
		$playerId = $storedData['id'];
		$buddyId = $storedData['authDetails'][0]['buddy_id'];
		$lastLogin = $storedData['authDetails'][0]['last_login'];
		
		/* $currentLogin = Zend_Date::now();
		$lastLogin = new Zend_Date($lastLogin);
		 
		$difference = $currentLogin->compare($lastLogin, Zend_Date::DAY);
		
        if($difference >= 1)
        {
        	$this->addFreeChips($playerId);
        } */
		$player = new Player();
		if($buddyId)
		{
			$player = new Player();
			$prevLoyaltyPoints = $player->getLoyaltyPoints($playerId);
			$totalLoyaltyPoints = $prevLoyaltyPoints['totalLoyaltyPoints'];
			$loyaltyPointsLeft = $prevLoyaltyPoints['loyaltyPointsLeft'];
			
			$currentTotalLoyaltyPoints = $totalLoyaltyPoints + 500;
			$currentLoyaltyPointsLeft = $loyaltyPointsLeft + 500;
			$player->updateLoyaltyPoints($playerId, $currentTotalLoyaltyPoints, $currentLoyaltyPointsLeft);
			
			$data['playerId'] = $playerId;
			$data['variableName'] = 'is-credited-master';
/*			$conn = Zenfox_Partition::getInstance()->getMasterConnection();
			Doctrine_Manager::getInstance()->setCurrentConnection($conn);*/
			$accountVariable = new AccountVariable();
			$accountVariableData = $accountVariable->getData($playerId, $data['variableName']);
			//Zenfox_Debug::dump($accountVariableData, 'data', true, true);
			if($accountVariableData['varValue'] == 0)
			{
				$buddyAccountDetail = $player->getAccountDetails($buddyId);
				$buddyBaseCurrency = $buddyAccountDetail[0]['base_currency'];
				$playerTransaction = new PlayerTransactions();
				if($playerTransaction->creditBonusDue($buddyId, 25, $buddyBaseCurrency))
				{
					$data['variableValue'] = 1;
					$data['varId'] = $accountVariableData['varId'];
					$accountVariable->update($data);
					
					$data['playerId'] = $buddyId;
					$data['variableName'] = 'total-friends';
					$data['variableValue'] = 1;
					$accountVariableData = $accountVariable->getData($data['playerId'], $data['variableName']);
					if($accountVariableData)
					{
						$varId = $accountVariableData['varId'];
						$data['varId'] = $varId;
						$data['variableValue'] = ++$accountVariableData['varValue'];
						$accountVariable->update($data);
					}
					else
					{
						$accountVariable->insert($data);
					}
					
					$data['variableName'] = 'freeMoney';
					$accountVariableData = $accountVariable->getData($buddyId, $data['variableName']);

					$varId = $accountVariableData['varId'];
					$data['varId'] = $varId;
					$data['variableValue'] = floatval($data['varValue']) + 1000;
					$accountVariable->update($data);
					
					//Zenfox_Debug::dump($accountVariableData, 'data', true, true);
					/*
					// Commented by Yaswanth.
					//FIXME:: If total-friends=0 (which is happening) then 100 would be credited automatically
					if($accountVariableData['varValue']%10 == 0)
					{
						$playerTransaction = new PlayerTransactions();
						$playerTransaction->creditBonus($buddyId, 100, $buddyBaseCurrency);
					}
					*/
				}
			}
		}
	}
	
	public function addFreeChips($playerId, $totalFreeChips = NULL)
	{
		//echo "in my tld";exit;
		$accountVariable = new AccountVariable();
		$data['playerId'] = $playerId;
		$data['variableName'] = 'CONSECUTIVE_DAYS';
		$accountVariableData = $accountVariable->getData($playerId, $data['variableName']);

		// if is true for the first time login (after the daily bonus is implemented) only 
		if(!$accountVariableData)
		{
			$accountVariable->insert($data);
			$accountVariableData = $accountVariable->getData($playerId, $data['variableName']);
		}
		
		$freeChips = array(0,500,1000,1500,2000,2500,3000,5000);
		$varId = $accountVariableData['varId'];
		$data['varId'] = $varId;
		$data['variableValue'] = $accountVariableData['varValue']+1;
		$accountVariable->update($data);
		if($data['variableValue'] <= 7)
		{
			$index = $data['variableValue'];
		}
		else 
		{
			$index =7;
		}
		
		$returndata =  array(
			'consecutiveday' => $data['variableValue'],
			'bonusamount' => $freeChips[$index]
		);
		
		
		$data['variableName'] = 'freeMoney';
		$accountVariableData = $accountVariable->getData($playerId, $data['variableName']);

		$varId = $accountVariableData['varId'];
		$data['varId'] = $varId;
		$data['variableValue'] = floatval($accountVariableData['varValue']) + $freeChips[$index];
		$accountVariable->insert($data);
		
		return $returndata;
	}
	
	public function addBalance($playerId, $fund, $transactionCurrency, $transactionType = NULL,$note = NULL)
	{
		$playerTransactions = new PlayerTransactions();
		$currencyValue = $fund;
		
		switch($transactionType)
		{
			case 'BONUS':
				$sourceId = $playerTransactions->creditBonus($playerId, $currencyValue, $transactionCurrency, $note);
				break;
			case 'LOGIN_BONUS_CASH':
				$sourceId = $playerTransactions->awardWinnings($playerId, $currencyValue, $transactionCurrency, 'REAL', 'Login Bonus to Real Cash');
			default:
				$sourceId = $playerTransactions->creditDeposit($playerId, $currencyValue, $transactionCurrency, 1);
				break;
		}

		//$sourceId = $playerTransactions->creditDeposit($playerId, $currencyValue, $transactionCurrency, 1);
		if(!$sourceId)
		{
			//$this->_helper->FlashMessenger(array('error' => 'Could not credit bonus.'));
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
			//$this->_helper->FlashMessenger(array('error' => $this->view->translate("Your amount has not been credited, please try again. <br>If problem persists contact our %s customer support %s", "<a href=\"" . $this->view->baseUrl("ticket/create") . "\">", "</a>" )));
		}
		if(($reportMessage['processed'] == 'PROCESSED') && ($reportMessage['error'] == 'NOERROR'))
		{	
			/* $fundValue = $currency . $currencyValue;
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
			} */
			return array(
				'success' => true,
				'msg' => 'Congratulations!! Your login bonus £' . $currencyValue . ' has been credited into your account.');
		}
		elseif($counter != 3)
		{
			//$this->view->form = '';
			//$this->_helper->FlashMessenger(array('error' => $this->view->translate('Your amount is not credited, please try again. If problem persists, please contact support with the following audit Id:: '. $reportMessage['auditId'])));
		}
	}
}