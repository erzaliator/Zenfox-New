<?php
class PlayerTransactionRecord extends BasePlayerTransactionRecords
{
	public function insertData($data)
	{
//		Zenfox_Debug::dump($data, 'data');
		$frontendName = Zend_Registry::get('frontendName');
		if($frontendName == 'bingocrush.co.uk')
		{
			$conn = Zenfox_Partition::getInstance()->getConnections($data['playerId']); 
		}
		else
		{
			$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		}
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$transactionRecord = new PlayerTransactionRecord();
		$transactionRecord->gateway_id = $data['gatewayId'];
		$transactionRecord->player_id = $data['playerId'];
		$transactionRecord->amount = $data['amount'];
		$transactionRecord->payment_method = $data['paymentMethod'];
		$transactionRecord->currency_code = $data['currencyCode'];
		$transactionRecord->request_url = $data['requestUrl'];
		$transactionRecord->ip = $data['ipAddress'];
		$transactionRecord->status = $data['status'];
		$transactionRecord->frontend_id = Zend_Registry::get('frontendId');
		
		$date = new Zend_Date();
		$today = $date->get(Zend_Date::W3C);
		$transactionRecord->trans_start_time = $today;
		
		try
		{
			$transactionRecord->save();
		}
		catch(Exception $e)
		{
			//print($e); exit();
		}

		$query = Zenfox_Query::create()
					->from('PlayerTransactionRecord tr')
					->where('tr.player_id = ?', $data['playerId'])
					->orderBy('tr.transaction_id DESC')
					->limit(1);
		
		try
		{
			$result = $query->fetchArray();
		}
		catch(Exception $e)
		{
			//Zenfox_Debug::dump($e, 'exception', true, true);
		}
		return $result[0]['transaction_id'];	
	}

	public function getTransactionId($playerId)
	{
		$frontendName = Zend_Registry::get('frontendName');
		if($frontendName == 'bingocrush.co.uk')
		{
			$conn = Zenfox_Partition::getInstance()->getConnections($playerId); 
		}
		else
		{
			$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		}
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		$query = Zenfox_Query::create()
					->from('PlayerTransactionRecord tr')
					->where('tr.player_id = ?', $playerId)
					->orderBy('tr.transaction_id DESC')
					->limit(1);
		
		$result = $query->fetchArray();
		return $result[0]['transaction_id'];
	}
	
	public function updateData($playerId,$transactionId, $field, $status = 'PENDING')
	{
		$frontendName = Zend_Registry::get('frontendName');
		if($frontendName == 'bingocrush.co.uk')
		{
			$conn = Zenfox_Partition::getInstance()->getConnections($playerId); 
		}
		else
		{
			$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		}
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		if($field == 'status')
		{
			$query = Zenfox_Query::create()
					->update('PlayerTransactionRecord tr')
					->set('tr.status', '?', $status)
					->where('tr.transaction_id = ?', $transactionId);
			$query->execute();
		}
	}
	
	public function getDataById($playerId, $id)
	{
		$frontendName = Zend_Registry::get('frontendName');
		if($frontendName == 'bingocrush.co.uk')
		{
			$conn = Zenfox_Partition::getInstance()->getConnections($playerId);
		}
		else
		{
			$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		}
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
					->from('TransactionRecord tr')
					->where('tr.id = ?', $id);
					
		$result = $query->fetchArray();
		return $result;
	}
	
	public function updateRecords($data, $transactionId)
	{
		//Zenfox_Debug::dump($data, 'data');
		$frontendName = Zend_Registry::get('frontendName');
		if($frontendName == 'bingocrush.co.uk')
		{
			$conn = Zenfox_Partition::getInstance()->getConnections($data['playerId']);
		}
		else
		{
			$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		}
		
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$date = new Zend_Date();
		$currentTime = $date->get(Zend_Date::W3C);
		
		$query = Zenfox_Query::create()
					->update('PlayerTransactionRecord tr')
					->set('tr.gateway_trans_id', '?', $data['gatewayTransId'])
					->set('tr.bank_name', '?', $data['bankName'])
					->set('tr.gateway_response', '?', $data['gatewayResponse'])
					->set('tr.status', '?', $data['status'])
					->set('tr.trans_end_time', '?', $currentTime)
					->set('tr.gateway_trans_time', '?', $data['gatewayTransTime'])
					->set('tr.response_url', '?', $data['responseUrl'])
					->set('tr.transaction_result', '?', $data['result'])
					->where('tr.transaction_id = ?', $transactionId);
					
		try
		{
			$query->execute();
		}
		catch(Exception $e)
		{
			//Zenfox_Debug::dump($e, 'ex', true, true);
			return false;
		}
		return true;
	}
	
	public function updateAmount($amount, $playerId, $gatewayId, $paymentMethod)
	{
		$transactionId = $this->getTransactionId($playerId);
		$date = new Zend_Date();
        $today = $date->get(Zend_Date::W3C);

		$query = Zenfox_Query::create()
					->update('PlayerTransactionRecord tr')
					->set('tr.amount', '?', $amount)
					->set('tr.trans_start_time', '?', $today)
					->set('tr.gateway_id', '?', $gatewayId)
					->set('tr.payment_method', '?', $paymentMethod)
					->where('tr.transaction_id = ?', $transactionId);

		try
		{
			$query->execute();
		}
		catch(Exception $e)
		{
			print_r($e);
			exit();
		}
	}

	public function getTransactionData($playerId, $transactionId)
	{
		$frontendName = Zend_Registry::get('frontendName');
		if($frontendName == 'bingocrush.co.uk')
		{
			$conn = Zenfox_Partition::getInstance()->getConnections($playerId); 
		}
		else
		{
			$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		}
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
					->from('PlayerTransactionRecord pr')
					->where('pr.transaction_id = ?', $transactionId);
		
		if($frontendName == 'bingocrush.co.uk')
		{
			$query = $query->andWhere('pr.player_id = ?', $playerId);
		}
					
		$result = $query->fetchArray();
		$amount = 0;
		$transTime = '0000:00:00';
		$transactionType = "";
		$transResult = "";
		if($result)
		{
			$amount = $result[0]['amount'];
			$transTime = $result[0]['trans_end_time'];
			$transactionType = $result[0]['payment_method'];
			$status = $result[0]['status'];
			$playerId = $result[0]['player_id'];
			$transResult = $result[0]['transaction_result'];
		}
		return array(
				'amount' => $amount,
				'transTime' => $transTime,
				'transactionType' => $transactionType,
				'status' => $status,
				'playerId' => $playerId,
				'result' => $transResult
			);
	}

	public function updateGharpayTransaction($transactionId, $gatewayTransId, $gatewayTransTime = NULL, $status = NULL, $result = NULL)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$date = new Zend_Date();
		$currentTime = $date->get(Zend_Date::W3C);
		
		$query = Zenfox_Query::create()
					->update('PlayerTransactionRecord ptr');
		
		if($gatewayTransTime)
		{
			$query = $query->set('ptr.gateway_trans_time', '?', $gatewayTransTime)
					->set('ptr.status', '?', $status)
					->set('ptr.transaction_result', '?', $result)
					->set('ptr.trans_end_time', '?', $currentTime);
		}
		else
		{
			$query = $query->set('ptr.gateway_trans_id', '?', $gatewayTransId)
					->set('ptr.status', '?', 'PENDING')
					->set('ptr.trans_end_time', '?', $currentTime);
		}
		
		$query = $query->where('ptr.transaction_id = ?', $transactionId);
		
		try
		{
			$query->execute();
		}
		catch(Exception $e)
		{
			Zenfox_Debug::dump($e, 'exception', true, true);
			return false;
		}
		return true;
	}
	
	public function getDataByGatewayTransId($playerId, $gatewayTransId)
	{
		$frontendName = Zend_Registry::get('frontendName');
		if($frontendName == 'bingocrush.co.uk')
		{
			$conn = Zenfox_Partition::getInstance()->getConnections($playerId); 
		}
		else
		{
			$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		}
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
					->from('PlayerTransactionRecord ptr')
					->where('ptr.gateway_trans_id = ?', $gatewayTransId);
		
		try
		{
			$result = $query->fetchArray();
		}
		catch(Exception $e)
		{
			Zenfox_Debug::dump($e, 'exception', true, true);
			return false;
		}
		Zenfox_Debug::dump($result, 'result');
		return $result[0];
	}

	public function getAllTransaction($fromTime, $toTime, $offset = NULL, $itemsPerPage = NULL)
	{
		if($fromTime)
		{
			if($toTime)
			{
				$query = "Zenfox_Query::create()
							->from('PlayerTransactionRecord ptr')
							->where('ptr.trans_start_time between ? and ?', array('$fromTime', '$toTime'))";
			}
			else
			{
				$query = "Zenfox_Query::create()
							->from('PlayerTransactionRecord ptr')
							->where('ptr.trans_start_time >= ?', '$fromTime')";
			}
		}
		else
		{
			$query = "Zenfox_Query::create()
							->from('PlayerTransactionRecord')";
		}
		$frontendName = Zend_Registry::get('frontendName');
		if(!$offset && !$itemsPerPage)
		{
			$transactionReport = array();
			$query = $query . ";";
		
			if($frontendName == 'bingocrush.co.uk')
			{
				$str = "";
				$connections = Zenfox_Partition::getInstance()->getConnections(-1);
				foreach($connections as $conn)
				{
					$index = count($transactionReport);
					Doctrine_Manager::getInstance()->setCurrentConnection($conn);
					eval ( "\$str=" . $query );
					try
					{
						$result = $str->fetchArray();
					}
					catch(Exception $e)
					{
						//Zenfox_Debug::dump($e, 'exception', true, true);
					}
					if($result)
					{
						$transactionReport = $this->_generateTransactionsReport($transactionReport, $index, $result);
					}
				}
			}
			else
			{
				$conn = Zenfox_Partition::getInstance()->getConnections(0);
				$index = count($transactionReport);
				Doctrine_Manager::getInstance()->setCurrentConnection($conn);
				eval ( "\$str=" . $query );
				try
				{
					$result = $str->fetchArray();
				}
				catch(Exception $e)
				{
					Zenfox_Debug::dump($e, 'exception', true, true);
				}
				if($result)
				{
					$transactionReport = $this->_generateTransactionsReport($transactionReport, $index, $result);
				}
			}
			
			return $transactionReport;
		}
		else
		{
			if($frontendName == 'bingocrush.co.uk')
			{
				$adapter = new Zenfox_Paginator_Adapter_DoctrineQuery($query, -1);
			}
			else
			{
				$adapter = new Zenfox_Paginator_Adapter_DoctrineQuery($query, 0);
			}
			$paginatorSession = new Zend_Session_Namespace('paginationCount');
			$paginatorSession->value = false;
			$paginator = new Zend_Paginator($adapter);
			$paginator->setItemCountPerPage($itemsPerPage);
			$paginator->setPageRange(2);
			$paginator->setCurrentPageNumber($offset);
			
			$transactionReport = array();
			if($paginator->getTotalItemCount())
			{
				$index = count($transactionReport);
				$transactionReport = $this->_generateTransactionsReport($transactionReport, $index, $paginator);
				$paginatorSession->unsetAll();
				return array($paginator, $transactionReport);
			}
		}
		return NULL;
	}
	
	private function _generateTransactionsReport($transactionReport, $index, $allTransactions)
	{
		foreach($allTransactions as $transaction)
		{
			$transStartTime = $transaction['trans_start_time'];
			//$transStartTime = date ("Y-m-d H:i:s", strtotime("$startTime, + 5 HOUR 30 MINUTE"));
			
			$transEndTime = '';
			if($transaction['trans_end_time'])
			{			
				$transEndTime = $transaction['trans_end_time'];
				//$transEndTime = date ("Y-m-d H:i:s", strtotime("$endTime, + 5 HOUR 30 MINUTE"));
			}
			
			$transactionReport[$index]['Player Id'] = $transaction['player_id'];
			$transactionReport[$index]['Player IP'] = $transaction['ip'];
			$transactionReport[$index]['Start Time'] = $transStartTime;
			$transactionReport[$index]['End Time'] = $transEndTime;

			$index++;
		}
		return $transactionReport;
	}
	
	public function getplayerfailedtransactions($playerid,$payment_method,$fromTime, $toTime, $offset = NULL, $itemsPerPage = NULL, $frontendIds = NULL)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		if($payment_method == "ALL")
		{
			$query = "Zenfox_Query::create()
			->from('PlayerTransactionRecord ptr')
			->where('ptr.status !=?' , 'PROCESSED')";
			
			if($playerid != -1)
			{
				$query .= "->andwhere('ptr.player_id =?', '$playerid')";
			}
			
			$query .= "->andwhere('ptr.trans_start_time between ? and ?', array('$fromTime', '$toTime'))";
		}
		else 
		{
			$query = "Zenfox_Query::create()
			->from('PlayerTransactionRecord ptr')
			->where('ptr.status !=?' , 'PROCESSED')";
			
			if($playerid != -1)
			{
				$query .= "->andwhere('ptr.player_id =?', '$playerid')"; 
			}
			
			$query .= "->andwhere('ptr.payment_method =?' , '$payment_method')
			->andwhere('ptr.trans_start_time between ? and ?', array('$fromTime', '$toTime'))";
		}
		
		if($frontendIds)
		{
			$query .= "->andWhereIn('ptr.frontend_id', array($frontendIds))";
		}

		$query .="->orderBy('ptr.trans_start_time  desc')";

		if($playerid != -1)
		{
			$adapter = new Zenfox_Paginator_Adapter_DoctrineQuery($query, $playerid);
		}
		else
		{
			$frontendName = Zend_Registry::get('frontendName');
			if($frontendName == 'bingocrush.co.uk')
			{
				$adapter = new Zenfox_Paginator_Adapter_DoctrineQuery($query, -1);
			}
			else
			{
				$adapter = new Zenfox_Paginator_Adapter_DoctrineQuery($query, 0);
			}
		}
		$paginatorSession = new Zend_Session_Namespace('paginationCount');
		$paginatorSession->value = false;
		$paginator =  new Zend_Paginator($adapter);
		$paginator->setItemCountPerPage($itemsPerPage);
		$paginator->setPageRange(2);
		$paginator->setCurrentPageNumber($offset);
		
		$index = 0;
		if($paginator->getTotalItemCount())
		{
			foreach($paginator as $logs)
			{
				$result[$index]["Player Id"] = $logs["player_id"];
				
				$result[$index]["transaction result"] = $logs["transaction_result"];
				$result[$index]["amount"] = $logs["amount"];
				$result[$index]["payment method"] = $logs["payment_method"];
				$result[$index]["bank name"] = $logs["bank_name"];
				$result[$index]["status"] = $logs["status"];
				$result[$index]["trans start time"] = $logs["trans_start_time"];
				$result[$index]["trans end time"] = $logs["trans_end_time"];
				$index++;
			}
			$paginatorSession->unsetAll();
			
			return array($paginator, $result);
		}
		
		return NULL;
		
		
		
		
		
		
		
		
		
		
		
	}
}
