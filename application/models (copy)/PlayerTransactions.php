<?php
class PlayerTransactions extends BasePlayerTransaction
{
	public function setTableDefinition()
	{
		parent::setTableDefinition();
		$this->hasColumn('csr_id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'length' => '4',
             ));
	}
	
	public function creditBonus($playerId, $amount, $currency=null, $notes="Bonus Credit")
	{
		$connName = Zenfox_Partition::getInstance()->getConnections($playerId);
		$partition = Doctrine_Manager::getInstance()->getConnection($connName);
		/*
		$today = new Zend_Date();
		$this->player_id = $playerId;
		$this->transaction_type = 'CREDIT_BONUS';
		$this->amount = $amount;
		$this->amount_type = 'BONUS';
		$this->notes = $notes;
*/

		$today = new Zend_Date();
		$this->player_id = $playerId;
		$this->transaction_type = 'CREDIT_BONUS';
		$this->amount = $amount;
		$this->amount_type = 'BONUS';
		$this->notes = $notes; 

		$player = new Player();
		$playerDetails = $player->getAccountDetails($playerId);
		
/*		$today = new Zend_Date();
		$this->player_id = $playerId;
		$this->transaction_type = 'CREDIT_DEPOSITS';
		$this->amount = $amount;
		$this->amount_type = 'REAL';
		$this->notes = $notes; */
		$this->tracker_id = $playerDetails[0]['tracker_id'];

		if(isset($currency))
		{
			/*
			 * FIXME:: Should we query this from DB or shoudl we query this from session?
			 */
			Doctrine_Manager::getInstance()->setCurrentConnection($connName);
			$query = Zenfox_Query::create()
						->from('AccountDetail a')
						->where('a.player_id= ?', $playerId);
			try
			{
				$result = $query->fetchArray();
			}
			catch(Exception $e)
			{
				$filePath = '/home/zenfox/backup_player/error_logs.txt';
	            $fh = fopen($filePath, 'a');
	            fwrite($fh, "GETTING ACCOUNT DETAIL IN PLAYER TRANSACTION->" . $e);
	            fclose($fh);
				return false;
			}
			if($result)
			{
				$this->transaction_currency = $result[0]['base_currency'];
			}
			else
			{
				return false;
			}
		}
		$this->frontend_id = Zend_Registry::getInstance()->get('frontendId');
		//$this->notes = 'Saved Bonus Fund';
		$this->trans_start_time = $today->get(Zend_Date::W3C);
		try
		{
			$this->save($partition);
		}
		catch(Exception $e)
		{
			$filePath = '/home/zenfox/backup_player/error_logs.txt';
			if(file_exists($filePath))
			{
				$fh = fopen($filePath, 'a');
				fwrite($fh, "CREDITING BONUS->" . $e);
				fclose($fh);
			}
			//print $e; exit();
			return false;
		}
		Doctrine_Manager::getInstance()->setCurrentConnection($connName);
		$query = Zenfox_Query::create()
					->from('PlayerTransactions t')
					->where('t.player_id = ?', $playerId)
					->orderBy('t.source_id DESC')
					->limit(1);
		try
		{
			$result = $query->fetchArray();
			//print_r($result);
		}
		catch(Exception $e)
		{
			return false;
		}
		return $result[0]['source_id'];
	}
	
	
	public function awardWinnings($playerId, $amount,$currency=null, $amount_type = 'BONUS', $notes="Manual Cash Credited")
	{
		$connName = Zenfox_Partition::getInstance()->getConnections($playerId);
		$partition = Doctrine_Manager::getInstance()->getConnection($connName);
	

		$today = new Zend_Date();
		$this->player_id = $playerId;
		$this->transaction_type = 'AWARD_WINNINGS';
		$this->amount = $amount;
		$this->amount_type = $amount_type;
		$this->notes = $notes; 

		$player = new Player();
		$playerDetails = $player->getAccountDetails($playerId);
		
		$this->tracker_id = $playerDetails[0]['tracker_id'];

		if(isset($currency))
		{
			/*
			 * FIXME:: Should we query this from DB or shoudl we query this from session?
			 */
			Doctrine_Manager::getInstance()->setCurrentConnection($connName);
			$query = Zenfox_Query::create()
						->from('AccountDetail a')
						->where('a.player_id= ?', $playerId);
			try
			{
				$result = $query->fetchArray();
			}
			catch(Exception $e)
			{
				$filePath = '/home/zenfox/backup_player/error_logs.txt';
	            $fh = fopen($filePath, 'a');
	            fwrite($fh, "GETTING ACCOUNT DETAIL IN PLAYER TRANSACTION->" . $e);
	            fclose($fh);
				return false;
			}
			if($result)
			{
				$this->transaction_currency = $result[0]['base_currency'];
			}
			else
			{
				return false;
			}
		}
		$this->frontend_id = Zend_Registry::getInstance()->get('frontendId');
		//$this->notes = 'Saved Bonus Fund';
		$this->trans_start_time = $today->get(Zend_Date::W3C);
		try
		{
			$this->save($partition);
		}
		catch(Exception $e)
		{
			$filePath = '/home/zenfox/backup_player/error_logs.txt';
			$fh = fopen($filePath, 'a');
			fwrite($fh, "CREDITING BONUS->" . $e);
			fclose($fh);
			//print $e; exit();
			return false;
		}
		Doctrine_Manager::getInstance()->setCurrentConnection($connName);
		$query = Zenfox_Query::create()
					->from('PlayerTransactions t')
					->where('t.player_id = ?', $playerId)
					->orderBy('t.source_id DESC')
					->limit(1);
		try
		{
			$result = $query->fetchArray();
			//print_r($result);
		}
		catch(Exception $e)
		{
			return false;
		}
		return $result[0]['source_id'];
	}
	
	public function registerWithdrawalRequest($dataArray)
	{
		//echo "hi"; exit();
		//Zenfox_Debug::dump($dataArray);exit;
		$connName = Zenfox_Partition::getInstance()->getConnections($dataArray['player_id']);
		$partition = Doctrine_Manager::getInstance()->getConnection($connName);
		
		$this->player_id = $dataArray['player_id'];
		
        
		$this->transaction_type = $dataArray['type'];
		$this->amount = $dataArray['amount'];
		$this->amount_type = 'REAL';
		// go to account_details and select base_currency
		
		
		$storage = new Zend_Auth_Storage_Session();
		$session = $storage->read();
		
		//print_r($session);
		//echo $session['authDetails'][0]['base_currency']; exit();
		
		$this->transaction_currency =  $session['authDetails'][0]['base_currency'];
		$this->base_currency =  $session['authDetails'][0]['base_currency'];
		//$this->base_currency = 'INR';
		//$this->transaction_currency = 'INR';		
		// Source ID is autoincrement I guess
		$this->frontend_id = Zend_Registry::getInstance()->get('frontendId');
		$this->notes = $dataArray['notes'];
		
		//print_r($this);
		
		              
		try
        {
        	$this->save($partition);
           	           	
        }
        catch(Exception $e)
        {
//         	echo $e;
//         	echo 'Here';exit();
        	
        	return false;
        }
        
        Doctrine_Manager::getInstance()->setCurrentConnection($connName);
		$query = Zenfox_Query::create()
					->select('t.source_id')
					->from('PlayerTransactions t')
					->where('t.player_id = ?', $dataArray['player_id'])
					->orderBy('t.source_id DESC')
					->limit(1);
		//echo $query->getSqlQuery()."###########################################################";			
				
		try
		{
			$result = $query->fetchArray();
		}
		catch(Exception $e)
		{
		//	echo $e->getMessage(); exit();
			return false;
		}
		
		return $result[0]['source_id'];
        
        
	}


	
	public function checkSourceId($playerId, $sourceId)
	{
		if(!$sourceId)
		{
			return false;
		}
		$auditReport = new AuditReport();
		$reportMessage = $auditReport->checkerror($sourceId, $playerId);
				
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
			return false;
		}
		if(($reportMessage['processed'] == 'PROCESSED') && ($reportMessage['error'] == 'NOERROR'))
		{
			return true;
		}
		elseif($counter != 3)
		{
			return false;
		}
	}
	
	public function buyMarketItemTransaction($playerId,$buyPrice)
	{
		$conn = Zenfox_Partition::getInstance()->getConnections($playerId);
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$playerTransactions = new PlayerTransactions();
		$playerTransactions->player_id = $playerId;
		$playerTransactions->amount = $buyPrice;		
        $playerTransactions->transaction_type = 'PLACE_WAGER';		
		$playerTransactions->notes = 'Place Wager';		
		
		$playerTransactions->amount_type = 'BONUS';
		
		$storage = new Zend_Auth_Storage_Session();
		$session = $storage->read();
				
		$playerTransactions->transaction_currency =  $session['authDetails'][0]['base_currency'];
		$playerTransactions->base_currency =  $session['authDetails'][0]['base_currency'];
		
		$playerTransactions->frontend_id = Zend_Registry::getInstance()->get('frontendId');
			              
		try
        {
        	$playerTransactions->save($partition);
           	           	
        }
        catch(Exception $e)
        {
        	echo $e;       	
        	return false;
        }
        
       
		$query = Zenfox_Query::create()
					->select('t.source_id')
					->from('PlayerTransactions t')
					->where('t.player_id = ?', $playerId)
					->orderBy('t.source_id DESC')
					->limit(1);
		try
		{
			$result = $query->fetchArray();			
		}
		catch(Exception $e)
		{		
			return false;
		}
		
		return $result[0]['source_id'];        
		
	}
	public function sellMarketItemTransaction($playerId,$sellPrice)
	{
		
		$conn = Zenfox_Partition::getInstance()->getConnections($playerId);
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$today = new Zend_Date();
		
		$this->player_id = $playerId;
		$this->amount = $sellPrice;
		$this->transaction_type = 'CREDIT_BONUS';
		$this->notes = 'Bonus Credit';
		
		$this->amount_type = 'BONUS';
		
		$session = new Zenfox_Auth_Storage_Session();
		$store = $session->read();
		$playerData = $store['authDetails'][0];
		$currency = $playerData['base_currency'];		

		
		if(isset($currency))
		{
			
			/*
			 * FIXME:: Should we query this from DB or shoudl we query this from session?
			 */
		//	Doctrine_Manager::getInstance()->setCurrentConnection($connName);
			$query = Zenfox_Query::create()
						->from('AccountDetail a')
						->where('a.player_id= ?', $playerId);
			
			try
			{
				$result = $query->fetchArray();
				
			}
			catch(Exception $e)
			{
				print ("Ahem! Exception!" . $e->getMessage());
				return false;
			}
			
			if($result)
			{
				$this->transaction_currency = $result[0]['base_currency'];
			}
			else
			{
				return false;
			}
		}
		$this->frontend_id = Zend_Registry::getInstance()->get('frontendId');
		
		$this->trans_start_time = $today->get(Zend_Date::W3C);
		try
		{
			$this->save($partition);
		}
		catch(Exception $e)
		{
			
			return false;
		}
		
		$query = Zenfox_Query::create()
					->from('PlayerTransactions t')
					->where('t.player_id = ?', $playerId)
					->orderBy('t.source_id DESC')
					->limit(1);
		try
		{
			$result = $query->fetchArray();
			
			
		}
		catch(Exception $e)
		{
			return false;
		}
		return $result[0]['source_id'];
	}

	public function creditDeposit($playerId, $amount, $transCurrency, $transactionId, $trackerId = NULL)
     	{
 //     	Zenfox_Debug::dump($playerId, 'amount', true, true);
	        $connName = Zenfox_Partition::getInstance()->getConnections($playerId);
        	$partition = Doctrine_Manager::getInstance()->getConnection($connName);
	        $today = new Zend_Date();
	        $this->player_id = $playerId;
	        $this->transaction_type = 'CREDIT_DEPOSITS';
	        $this->amount = $amount;
        	$this->amount_type = 'REAL';
	        $this->transaction_currency = $transCurrency;
		$this->merchant_trans_id = $transactionId;
	        $this->frontend_id = Zend_Registry::getInstance()->get('frontendId');
	        $this->notes = 'Saved Deposit Money';
		$this->tracker_id = $trackerId;
	        $this->trans_start_time = $today->get(Zend_Date::W3C);
        	try
	        {
	            $this->save($partition);
        	}
	        catch(Exception $e)
        	{
	            return false;
        	}
	        Doctrine_Manager::getInstance()->setCurrentConnection($connName);
        	$query = Zenfox_Query::create()
                	    ->from('PlayerTransactions t')
	                    ->where('t.player_id = ?', $playerId)
        	            ->orderBy('t.source_id DESC')
                	    ->limit(1);
	        try
        	{
	            $result = $query->fetchArray();
        	}
	        catch(Exception $e)
        	{
	            return false;
        	}
	        return $result[0]['source_id'];
	    }		

		public function placeWager($playerId, $amount, $amountType, $sessionId = NULL, $notes = NULL)
	{
		$conn = Zenfox_Partition::getInstance()->getConnections($playerId);
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$date = new Zend_Date();
		$date->setTimezone('Asia/Calcutta');
		$currentTime = $date->get(Zend_Date::W3C);
		
		$playerTransactions = new PlayerTransactions();
		$playerTransactions->player_id = $playerId;
		$playerTransactions->transaction_type = 'PLACE_WAGER';
		$playerTransactions->amount = $amount;
		$playerTransactions->transaction_currency = 'INR';
		$playerTransactions->base_currency = 'INR';
		$playerTransactions->amount_type = $amountType;
		$playerTransactions->frontend_id = Zend_Registry::get('frontendId');
		$playerTransactions->trans_start_time = $currentTime;
		$playerTransactions->session_id = $sessionId;
		$playerTransactions->notes = $notes;
		
		try
		{
			$playerTransactions->save();
		}
		catch(Exception $e)
		{
			return false;
		}
		
		$query = Zenfox_Query::create()
				->from('PlayerTransactions t')
				->where('t.player_id = ?', $playerId)
				->orderBy('t.source_id DESC')
				->limit(1);
		try
		{
			$result = $query->fetchArray();
		}
		catch(Exception $e)
		{
			return false;
		}
		return $result[0]['source_id'];
	}

	public function creditBonusDue($playerId, $amount, $buddyBaseCurrency, $notes = "Credit Bonus Due")
	{
		$conn = Zenfox_Partition::getInstance()->getConnections($playerId);
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
	
		$date = new Zend_Date();
		$date->setTimezone('Asia/Calcutta');
		$currentTime = $date->get(Zend_Date::W3C);
	
		$playerTransactions = new PlayerTransactions();
		$playerTransactions->player_id = $playerId;
		$playerTransactions->transaction_type = 'CREDIT_BONUS_DUE';
		$playerTransactions->amount = $amount;
		$playerTransactions->transaction_currency = 'INR';
		$playerTransactions->base_currency = $buddyBaseCurrency;
		$playerTransactions->amount_type = 'BONUS';
		$playerTransactions->frontend_id = Zend_Registry::get('frontendId');
		$playerTransactions->trans_start_time = $currentTime;
		$playerTransactions->notes = $notes;
	
		try
		{
			$playerTransactions->save();
		}
		catch(Exception $e)
		{
			return false;
		}
	
		$query = Zenfox_Query::create()
				->from('PlayerTransactions t')
				->where('t.player_id = ?', $playerId)
				->orderBy('t.source_id DESC')
				->limit(1);
		try
		{
			$result = $query->fetchArray();
		}
		catch(Exception $e)
		{
			return false;
		}
		return $result[0]['source_id'];
	}
	
	public function requestPlayerWithdrawal($dataArray)
	{
		//
		$connName = Zenfox_Partition::getInstance()->getConnections($dataArray['player_id']);
		$partition = Doctrine_Manager::getInstance()->getConnection($connName);
		
		$player = new Player();
		$playerDetails = $player->getAccountDetails($dataArray['player_id']);
	
		$this->player_id = $dataArray['player_id'];
	
	
		$this->transaction_type = $dataArray['type'];
		$this->amount = $dataArray['amount'];
		$this->amount_type = 'REAL';
		// go to account_details and select base_currency
	
		$this->transaction_currency =  $playerDetails[0]['base_currency'];
		$this->base_currency =  $playerDetails['base_currency'];

		$this->frontend_id = Zend_Registry::getInstance()->get('frontendId');
		$this->notes = $dataArray['notes'];
	
		try
		{
			
			$this->save($partition);
	
		}
		catch(Exception $e)
		{
			echo $e;
			echo 'Here';exit();
			 
			return false;
		}
	
		Doctrine_Manager::getInstance()->setCurrentConnection($connName);
		$query = Zenfox_Query::create()
				->select('t.source_id')
				->from('PlayerTransactions t')
				->where('t.player_id = ?', $dataArray['player_id'])
				->orderBy('t.source_id DESC')
				->limit(1);
		//echo $query->getSqlQuery()."###########################################################";
	
		try
		{
			$result = $query->fetchArray();
		}
		catch(Exception $e)
		{
				echo $e->getMessage(); exit();
			return false;
		}
	
		return $result[0]['source_id'];
	
	
	}
	
	public function saveProcessing($dataArray)
	{
		$connName = Zenfox_Partition::getInstance()->getConnections($dataArray['player_id']);
		$partition = Doctrine_Manager::getInstance()->getConnection($connName);
		
		$session = new Zend_Auth_Storage_Session();
		$store = $session->read();
		//print_r($store);exit();
		$csr_id = $store['authDetails'][0]['id'];
		
		$this->player_id = $dataArray['player_id'];
		
        
		$this->transaction_type = $dataArray['type'];
		$this->amount = $dataArray['amount'];
		$this->amount_type = $dataArray['amount_type'];
		$this->notes = $dataArray['notes'];
		
		$player = new Player();
		
		$playerAccount = $player->getAccountDetails($dataArray['player_id']);
		//print_r($playerAccount);
		//print_r($playerAccount[0]['base_currency']); exit();
		
		$this->transaction_currency = $playerAccount[0]['base_currency'];
		$this->base_currency = $playerAccount[0]['base_currency'];
		
		/*$player = new Player();
		
		$playerAccount = $player->getAccountDetails($dataArray['player_id']);
		//print_r($playerAccount);
		//print_r($playerAccount[0]['base_currency']); exit();
		
		$this->transaction_currency = $playerAccount[0]['base_currency'];
		$this->base_currency = $playerAccount[0]['base_currency'];*/
	//	$this->transaction_currency = Zend_Registry::getInstance()->get('Zend_Locale');
	//	$this->base_currency = 'INR';
	//	$this->transaction_currency = 'INR';
		$this->csr_id = $csr_id;
		// Source ID is autoincrement I guess
		$this->frontend_id = Zend_Registry::getInstance()->get('frontendId');
		//$this->notes = 'Withdrawal Accept';
		//echo $csr_id; exit();
		
	//	print_r($dataArray);exit();
		
		try
        {
        	$this->save($partition);
           	           	
        }
        catch(Exception $e)
        {
        	//echo "HEER1";	
        	return false;
        }
        
      	Doctrine_Manager::getInstance()->setCurrentConnection($connName);
		$query = Zenfox_Query::create()
					->select('t.source_id')
					->from('PlayerTransactions t')
					->where('t.player_id = ?', $dataArray['player_id'])
					->orderBy('t.source_id DESC')
					->limit(1);
		//echo $query->getSqlQuery()."###########################################################";			
				
		try
		{
			$result = $query->fetchArray();
		}
		catch(Exception $e)
		{
		//	echo $e->getMessage(); exit();
			return false;
		}
		
		return $result[0]['source_id'];
	}
	
	public function withdraw($playerId, $amount)
	{
		$connName = Zenfox_Partition::getInstance()->getConnections($playerId);
		$partition = Doctrine_Manager::getInstance()->getConnection($connName);
		$today = new Zend_Date();
		$this->player_id = $playerId;
		$this->transaction_type = 'CREDIT_BONUS';
		$this->amount = $amount;
		$this->amount_type = 'BONUS';
		$this->transaction_currency = 'EUR';
		$this->frontend_id = Zend_Registry::getInstance()->get('frontendId');
		$this->notes = 'Saved Bonus Fund';
		$this->trans_start_time = $today->get(Zend_Date::W3C);
		try
		{
			$this->save($partition);
		}
		catch(Exception $e)
		{
			return false;
		}
		Doctrine_Manager::getInstance()->setCurrentConnection($connName);
		$query = Zenfox_Query::create()
					->from('AuditReport t')
					->where('t.player_id = ?', $playerId)
					->orderBy('t.source_id DESC')
					->limit(1);
		try
		{
			$result = $query->fetchArray();
		}
		catch(Exception $e)
		{
			return false;
		}
		return $result[0]['source_id'];
	}
	
	public function credit($playerId, $amount)
	{
		$connName = Zenfox_Partition::getInstance()->getConnections($playerId);
		$partition = Doctrine_Manager::getInstance()->getConnection($connName);
		$today = new Zend_Date();
		$this->player_id = $playerId;
		$this->transaction_type = 'CREDIT_BONUS';
		$this->amount = $amount;
		$this->amount_type = 'BONUS';
		$this->transaction_currency = 'EUR';
		$this->frontend_id = Zend_Registry::getInstance()->get('frontendId');
		$this->notes = 'Saved Bonus Fund';
		$this->trans_start_time = $today->get(Zend_Date::W3C);
		try
		{
			$this->save($partition);
		}
		catch(Exception $e)
		{
			return false;
		}
		Doctrine_Manager::getInstance()->setCurrentConnection($connName);
		$query = Zenfox_Query::create()
					->from('AuditReport t')
					->where('t.player_id = ?', $playerId)
					->orderBy('t.source_id DESC')
					->limit(1);
		try
		{
			$result = $query->fetchArray();
		}
		catch(Exception $e)
		{
			return false;
		}
		return $result[0]['source_id'];
	}
	
	


        public function getdistinctgameflavours()
        {
                $conn = Zenfox_Partition::getInstance()->getCommonConnection();
                Doctrine_Manager::getInstance()->setCurrentConnection($conn);

                $query = Zenfox_Query::create()
                                ->select('distinct(pt.game_flavour) as GameFlavours')
                                ->from('PlayerTransactions pt');

                $result = $query->fetchArray();

                return $result;

        }
        
		public function getdistincttransactiontypes()
        {
                $conn = Zenfox_Partition::getInstance()->getCommonConnection();
                Doctrine_Manager::getInstance()->setCurrentConnection($conn);

                $query = Zenfox_Query::create()
                                ->select('distinct(pt.transaction_type) as TransactionType')
                                ->from('PlayerTransactions pt');

                $result = $query->fetchArray();

                return $result;

        }
}
