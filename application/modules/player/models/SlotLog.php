<?php
class SlotLog extends Doctrine_Record
{
	private $_playerId;
	
	public function __construct($player_id)
	{
		$this->_playerId = $player_id;
	}
	
	public function showLog($itemsPerPage, $offset = 0, $fromDateTime = NULL, $toDateTime = NULL)
	{
		/*$time = explode('T', $fromDate);
		$fromDateTime = $time[0] . " " . $time[1];
		$time = explode('T', $toDate);
		$toDateTime = $time[0] . " " . $time[1];*/
		$allResults = array();
		/*$conn = Zenfox_Partition::getInstance()->getConnections($this->_playerId);
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);*/
		//TODO check it for paginator
		$query = "Zenfox_Query::create()
						->from('GamelogSlot gs')
						->where('gs.player_id = ?', '$this->_playerId')
						->andWhere('gs.datetime BETWEEN ? AND ?', array('$fromDateTime', '$toDateTime'))";
		/*if($fromDateTime)
		{
			if($toDateTime)
			{
				$query = "Zenfox_Query::create()
						->from('GamelogKeno gk')
						->where('gk.player_id = ?', '$this->_playerId')
						->andWhere('gk.datetime BETWEEN ? AND ?', array('$fromDateTime', '$toDateTime'))";
			}
			else
			{
				$query = "Zenfox_Query::create()
						->from('GamelogKeno gk')
						->where('gk.player_id = ?', '$this->_playerId')
						->andWhere('gk.datetime > ?', '$fromDateTime')";
			}
		}
		else
		{
			$query = "Zenfox_Query::create()
						->from('GamelogKeno gk')
						->where('gk.player_id = ?', '$this->_playerId')";
		}*/
		$adapter = new Zenfox_Paginator_Adapter_DoctrineQuery($query, $this->_playerId);
//		$paginator =  new Zend_Paginator($adapter);
//		$paginator->setItemCountPerPage($itemsPerPage);
//		$paginator->setPageRange(2);
//		$paginator->setCurrentPageNumber($offset);
		$paginatorSession = new Zend_Session_Namespace('paginationCount');
		$paginatorSession->value = false;
		$paginator =  new Zend_Paginator($adapter);
//		print('items-' . $itemsPerPage);
//		print('offset-' . $offset); exit();
		$paginator->setItemCountPerPage($itemsPerPage);
		$paginator->setPageRange(2);
		$paginator->setCurrentPageNumber($offset);
		$translate = Zend_Registry::get('Zend_Translate');
		$date = new Zenfox_Date();
		$currency = new Zenfox_Currency();
		$slotLogs = array();
		$index = 0;
//		print('page - ' . $paginator->count());
//		Zenfox_Debug::dump($paginator, 'paginator', true, true);
		if($paginator->getTotalItemCount())
		{
			foreach($paginator as $logs)
			{
				$slotLogs[$index][$translate->translate('Gamelog Id')] = $logs['session_id'] . '-' . $logs['log_id'];
				//$kenoLogs[$index][$translate->translate('Session Id')] = $logs['session_id'];
				$slotLogs[$index][$translate->translate('Machine Name')] = $logs->RunningSlot['machine_name'];
				$slotLogs[$index][$translate->translate('Currency')] = $logs['wagered_currency'];
				//$kenoLogs[$index][$translate->translate('Win Amount')] = $logs['win_amount'];
				$slotLogs[$index][$translate->translate('Amount Type')] = $logs['amount_type'];
				$slotLogs[$index][$translate->translate('Pjp Win Status')] = $logs['pjp_winstatus'];
				//$kenoLogs[$index][$translate->translate('Pjp Win Amount')] = $logs['pjp_win_amount'];
				//$kenoLogs[$index]['Date & Time'] = $logs['datetime'];
				$slotLogs[$index][$translate->translate('Bet Amount')] = $currency->setCurrency($logs['wagered_currency'], $logs['bet_amount']);
				$slotLogs[$index][$translate->translate('Win Amount')] = $currency->setCurrency($logs['wagered_currency'], $logs['win_amount']);
				$slotLogs[$index][$translate->translate('Pjp_Win Amount')] = $currency->setCurrency($logs['wagered_currency'], $logs['pjp_win_amount']);
				$slotLogs[$index][$translate->translate('Date & Time')] = $logs['datetime'];// $date->setDate($logs['datetime']);
				$slotLogs[$index][$translate->translate('Outcome')] = '';
				$index++;
			}
			$paginatorSession->unsetAll();
			return array($paginator, $slotLogs);
		}
		return NULL;
		/*$result = $adapter->getItems(0, $itemsPerPage);
		
		$time = explode('T', $fromDate);
		$fromDate = $time[0] . " " . $time[1];
		$time = explode('T', $toDate);
		$toDate = $time[0] . " " . $time[1];
		
		
		foreach($result as $results)
		{
			if($fromDate)
			{
				if($toDate)
				{
					if(($fromDate <= $results['datetime']) && ($toDate >= $results['datetime']))
					{
						$allResults[] = $results;
					}
				}
				else
				{
					if($fromDate <= $results['datetime'])
					{
						$allResults[] = $results;
					}
				}
			}
			else
			{
				$allResults[] = $results;
			}
		}*/
		//TODO change it for paginator		
	//	$adapter = new Zenfox_Paginator_Adapter_DoctrineQuery($query, $this->_playerId);
	//	$items = $adapter->getItems($offset, $itemsPerPage);
		
		//return $allResults;
	}
	
	/*public function setCurrency($currency, $value)
	{
		$currency = new Zend_Currency($currency);
		return $currency->toCurrency($value);
	}
	
	public function setDate($date)
	{
		$serverTimeZone = Zend_Registry::getInstance()->get('serverTimeZone');
		date_default_timezone_set($serverTimeZone);
		$date = new Zend_Date($date, Zend_Date::ISO_8601);
		$userTimeZone = Zend_Registry::getInstance()->get('userTimeZone');
		$date->setTimezone($userTimeZone);
		return $date;
	}*/
}
