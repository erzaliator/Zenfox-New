<?php
class GamelogKeno extends BaseGamelogKeno
{
	public function getKenologDetails($playerId)
	{
		$conn = Zenfox_Partition::getInstance()->getConnections($playerId);
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
						->from('GamelogKeno gk')
						
						->where('gk.player_id = ?', $playerId);
			//Zenfox_Debug::dump($query->fetchArray(),'data',true,true);			
		try
		{
			$data = $query->fetchArray();
			
		}
		catch(Exception $e)
		{
			return false;
		}
		if($data)
		{
			return $data;
			
		}
		else{return NULL;}
		//return NULL;
	}
	
	public function getKenolog($playerId, $fromDate, $toDate, $itemsPerPage, $offset)
	{
		$query = "Zenfox_Query::create()
					->from('GamelogKeno g')
					->where('g.datetime BETWEEN ? AND ?', array('$fromDate', '$toDate'))
					->andWhere('g.player_id = ?', '$playerId')
					->orderBy('g.player_id ASC')";
		
		$adapter = new Zenfox_Paginator_Adapter_DoctrineQuery($query, $playerId);
    	$paginatorSession = new Zend_Session_Namespace('paginationCount');
		$paginatorSession->value = false;
    	$paginator =  new Zend_Paginator($adapter);
		$paginator->setItemCountPerPage($itemsPerPage);
		$paginator->setPageRange(2);
		$paginator->setCurrentPageNumber($offset);
		if(!$paginator->getTotalItemCount())
		{
			return false;
		}
		else
		{
			$gameLogData = array();
			$index = 0;
			foreach($paginator as $logData)
			{
				$gameLogData[$index]['Gamelog Id'] = $logData['session_id'] . '-' . $logData['log_id'] . '-' . $logData['game_flavour'];
				$gameLogData[$index]['Currency'] = $logData['wagered_currency'];
				$gameLogData[$index]['Bet Amount'] = $logData['bet_amount'];
				$gameLogData[$index]['Win Amount'] = $logData['win_amount'];
				$gameLogData[$index]['Date & Time'] = $logData['datetime'];
				$index++;
			}
			return array(
				'paginator' => $paginator,
				'logData' => $gameLogData
			);
		}
	}
}