<?php

class WithdrawalRequest extends BaseWithdrawalRequest
{
	
	public function adminList($itemsPerPage, $offset, $fromDateTime, $toDateTime, $session = NULL, $dataArray = NULL, $csrfrontendids = NULL)
	{
		if(!$csrfrontendids)
		{
			$authSession = new Zend_Auth_Storage_Session();
			$sessionData = $authSession->read();
			$csrId = $sessionData['id'];
			$csrfrontendids = $sessionData["frontend_ids"];
			
			$csrfrontendids = implode(",",$csrfrontendids);
		}
			
		if($dataArray['player_id'] == -1)
		{
			if($dataArray['processed'] == '')
			{
				$query = "Zenfox_Query::create()
							->from('WithdrawalRequest w')
							->where('w.child_id = ?','0')
							->andWhere('w.datetime BETWEEN ? AND ?', array('$fromDateTime', '$toDateTime'))
							->andwhereIn('w.frontend_id',array($csrfrontendids))
							->orderBy('w.player_id ASC, w.withdrawal_id ASC')";
												
			}
			else 
			{
				$valueArray = $dataArray['processed'];
				//print_r($dataArray['processed']);exit();
				$query = "Zenfox_Query::create()
							->from('WithdrawalRequest w')
							->where('w.child_id = ?','0')
							->andwhereIn('w.processed',array('$valueArray'))
							->andWhere('w.datetime BETWEEN ? AND ?', array('$fromDateTime', '$toDateTime'))
							->andwhereIn('w.frontend_id',array($csrfrontendids))
							->orderBy('w.withdrawal_id ASC')";
				
			}
		}
		
		else if($dataArray['player_id'] != -1)
		{
			$playerId = $dataArray['player_id'];
			if($dataArray['processed' == ''])
			{
				$query = "Zenfox_Query::create()
							->from('WithdrawalRequest w')
							->where('w.player_id = ?',$playerId)
							->andwhere('w.child_id = ?','0')
							->andWhere('w.datetime BETWEEN ? AND ?', array('$fromDateTime', '$toDateTime'))
							->andwhereIn('w.frontend_id',array($csrfrontendids))
							->orderBy('w.player_id ASC, w.withdrawal_id ASC')";
			}
			else 
			{
				$valueArray = $dataArray['processed'];
				$query = "Zenfox_Query::create()
							->from('WithdrawalRequest w')
							->where('w.player_id = ?',$playerId)
							->andwhere('w.child_id = ?','0')
							->andwhereIn('w.processed',array($valueArray))
							->andWhere('w.datetime BETWEEN ? AND ?', array('$fromDateTime', '$toDateTime'))
							->andwhereIn('w.frontend_id',array($csrfrontendids))
							->orderBy('w.withdrawal_id ASC')";
			}
		}
		$index = 0;
		$withdrawalLog = array();
		if(!$offset && !$itemsPerPage)
		{
			$query = $query . ";";
			$str = "";
			$connections = Zenfox_Partition::getInstance()->getConnections(-1);
			foreach($connections as $conn)
			{
				$index = count($withdrawalLog);
				Doctrine_Manager::getInstance()->setCurrentConnection($conn);
				eval ( "\$str=" . $query );
				try
				{
					$withDrawals = $str->fetchArray();
				}
				catch(Exception $e)
				{
					Zenfox_Debug::dump($e, 'exception', true, true);
				}
				if($withDrawals)
				{
					$withdrawalLog = $this->_getWithdrawalLog($withdrawalLog, $index, $withDrawals);
				}
			}
			return $withdrawalLog;
		}
		
		$adapter = new Zenfox_Paginator_Adapter_DoctrineQuery($query, $dataArray['player_id'], $session);
		$paginatorSession = new Zend_Session_Namespace('paginationCount');
		$paginatorSession->value = false;
		$paginator =  new Zend_Paginator($adapter);
		
		//print_r($paginator);exit();
		//print('model - ' . $offset);			
		$paginator->setItemCountPerPage($itemsPerPage);
		$paginator->setPageRange(2);
		$paginator->setCurrentPageNumber($offset);
		
				
		/*
		 * player_id, withdrawal_id, requested and pending amount (in base currency), datetime
		 */
		
		if($paginator->getTotalItemCount())
		{
			/* foreach($paginator as $logs)
			{
				$withdrawalLog[$index]['player_id'] = $logs['player_id'];
				$withdrawalLog[$index]['withdrawal_id'] = $logs['withdrawal_id'];
				$withdrawalLog[$index]['initial_requested'] = $currency->setCurrency($logs['requested_currency'],$logs['initial_requested']);
				$withdrawalLog[$index]['remaining_amount'] = $currency->setCurrency($logs['requested_currency'],$logs['remaining_amount']);
				$withdrawalLog[$index]['status'] = $logs['processed'];
				//$withdrawalLog[$index][$translate->translate('Requested Currency')] = $logs['requested_currency'];				
			//	$withdrawalLog[$index][$translate->translate('Date & Time')] = $date->setDate($logs['datetime']);
				$withdrawalLog[$index]['datetime'] = $logs['datetime'];
				$index++;
			} */
			$withdrawalLog = $this->_getWithdrawalLog($withdrawalLog, $index, $paginator);
			//Zenfox_Debug::dump($withdrawalLog, 'withdrawal', true, true);
			$paginatorSession->unsetAll();
			return array($paginator, $withdrawalLog);
		}
		return NULL;
		
							
	}
	
	private function _getWithdrawalLog($withdrawalLog, $index, $withDrawals)
	{
		//$translate = Zend_Registry::get('Zend_Translate');
		$date = new Zenfox_Date();
		$currency = new Zenfox_Currency();
		
		foreach($withDrawals as $withdrawal)
		{
			$withdrawalLog[$index]['player_id'] = $withdrawal['player_id'];
			$withdrawalLog[$index]['withdrawal_id'] = $withdrawal['withdrawal_id'];
			$withdrawalLog[$index]['initial_requested'] = $currency->setCurrency($withdrawal['requested_currency'],$withdrawal['initial_requested']);
			$withdrawalLog[$index]['remaining_amount'] = $currency->setCurrency($withdrawal['requested_currency'],$withdrawal['remaining_amount']);
			$withdrawalLog[$index]['status'] = $withdrawal['processed'];
			//$withdrawalLog[$index][$translate->translate('Requested Currency')] = $logs['requested_currency'];
			//	$withdrawalLog[$index][$translate->translate('Date & Time')] = $date->setDate($logs['datetime']);
			$withdrawalLog[$index]['datetime'] = $withdrawal['datetime'];
			$index++;
		}
		
		return $withdrawalLog;
	}
	
	public function adminGetDetails($playerId  , $withdrawalId = -1)
	{
		$conn = Zenfox_Partition::getInstance()->getConnections($playerId);
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		if($withdrawalId == -1)
		{
			$query = Zenfox_Query::create()
					->from('WithdrawalRequest w')
					->where('player_id = ?',$playerId)
					->andWhereIn('processed',array('NOT_PROCESSED', 'PARTIALLY_PROCESSED'))
					->orderBy('child_id ASC');
		}
		else
		{
			$query = Zenfox_Query::create()
					->from('WithdrawalRequest w')
					->where('player_id = ?',$playerId)
					->andWhere('withdrawal_id = ?',$withdrawalId)
					->orderBy('child_id ASC');
		}
		
				
		//echo $query->getSql();
		//exit();
		
		try
		{
		
			$array = $query->fetchArray();
		}
		
		catch(Exception $e)
		{
			return false;	
		}
		
		$currency = new Zenfox_Currency();
		$newArray = array();
		$index = 0;
		foreach ($array as $record)
		{
			$newArray[$index]['Player Id'] = $record['player_id'];
			$newArray[$index]['Withdrawal Id'] = $record['withdrawal_id'];
			$newArray[$index]['Initial Request'] = $record['initial_requested'];
			$newArray[$index]['Remaining Amount'] = $record['remaining_amount'];
			$newArray[$index]['Requested Amount'] = $record['requested_amount'];
			$newArray[$index]['Withdrawal Type'] = $record['withdrawal_type'];
			$newArray[$index]['Status'] = $record['processed'];
			$newArray[$index]['Time'] = $record['datetime'];
			$index++;
			//$record['initial_requested'] = $currency->setCurrency($record['base_currency'],$record['initial_requested']); 
			//$record['remaining_amount'] = $currency->setCurrency($record['base_currency'],$record['remaining_amount']);
			//$newArray[] = $record;
		}
		
		
		return $newArray;
				
	}
	
	public function adminGetLastChild($playerId, $withdrawalId)
	{
		$conn = Zenfox_Partition::getInstance()->getConnections($playerId);
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
						->from('WithdrawalRequest w')
						->where('player_id = ?',$playerId)
						->andWhere('withdrawal_id = ?',$withdrawalId)
						->orderBy('child_id DESC');
		try 
		{
			$array = $query->fetchArray();
		}	

		catch(Exception $e)
		{
			return false;
		}
		
		return $array;
	}
	
	public function adminGetParent($playerId, $withdrawalId)
	{
		$conn = Zenfox_Partition::getInstance()->getConnections($playerId);
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
						->from('WithdrawalRequest w')
						->where('player_id = ?',$playerId)
						->andWhere('withdrawal_id = ?',$withdrawalId)
						->andWhere('child_id = ?','0');
		try 
		{
			$array = $query->fetchArray();
		}	

		catch(Exception $e)
		{
			return false;
		}
		
		return $array;
	}
	
	public function getlastfraudchecktime($playerId)
	{
		$conn = Zenfox_Partition::getInstance()->getConnections($playerId);
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$acceptquery = Zenfox_Query::create()
						->select('w.datetime , w.withdrawal_type')
						->from('WithdrawalRequest w')
						->where('w.withdrawal_type =?' , "WITHDRAWAL_ACCEPT")
						->andWhere('w.player_id =?' , $playerId)
						->orderBy('w.datetime desc')
						->limit(1);
						
		$lastaccepttime = $acceptquery->fetchArray();
			
			if(!empty($lastaccepttime))
			{
				$lasttime = $lastaccepttime[0]["datetime"];
				
				$lastrequestquery = Zenfox_Query::create()
						->select('w.datetime , w.withdrawal_type')
						->from('WithdrawalRequest w')
						->where('w.withdrawal_type =?' , "WITHDRAWAL_REQUEST")
						->andWhere('w.player_id =?' , $playerId)
						->andWhere('w.datetime < ?' , $lasttime)
						->orderBy('w.datetime desc')
						->limit(1);
						
				$lastrequesttime = $lastrequestquery->fetchArray();
				
				$lastchecktime = $lastrequesttime[0]['datetime'];
			}
			else
			{
				$accountobj = new AccountDetail(); 
				$details = $accountobj->getDetails($playerId);
						
				$lastchecktime = $details["created"];
			}
			
			return $lastchecktime;
			
			
	}
	
	public function getWithdrawalsByPlayerId($playerId)
	{
		$conn = Zenfox_Partition::getInstance()->getConnections($playerId);
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
					->from('WithdrawalRequest wr')
					->where('wr.player_id = ?', $playerId)
					->andWhereIn('wr.withdrawal_type', array('WITHDRAWAL_ACCEPT', 'WITHDRAWAL_PARTIAL_ACCEPT'));
		
		try
		{
			$withdrawalRequestData = $query->fetchArray();
		}
		catch(Exception $e)
		{
			return array(
				'success' => false
			);
		}
		if($withdrawalRequestData)
		{
			$totalWithdrawalAmount = 0;
			$lastWithdrawalAmount = 0;
			foreach($withdrawalRequestData as $data)
			{
				$totalWithdrawalAmount += $data['requested_amount'];
				$lastWithdrawalAccepted = $data['datetime'];
				$lastWithdrawalAmount = $data['requested_amount'];
			}
			return array(
				'success' => true,
				'totalAmount' => $totalWithdrawalAmount,
				'lastAccepted' => $lastWithdrawalAccepted,
				'lastWithdraw' => $lastWithdrawalAmount
			);
		}
		return array(
			'success' => false
		);
	}
	
}
