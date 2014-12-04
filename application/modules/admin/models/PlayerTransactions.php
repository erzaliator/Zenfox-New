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
	
	public function creditBonus($playerId, $amount)
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
	
	public function requestPlayerWithdrawal($dataArray)
	{
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
			//	echo $e->getMessage(); exit();
			return false;
		}
	
		return $result[0]['source_id'];
	
	
	}
}