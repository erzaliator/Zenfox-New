<?php
class GamelogRoulette extends BaseGamelogRoulette
{
	public function getRoulettelogDetails($playerId)
	{
		$conn = Zenfox_Partition::getInstance()->getConnections($playerId);
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
						->from('GamelogRoulette gr')
						
						->where('gr.player_id = ?', $playerId);
				
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
	
	public function getRoulettelog($playerId, $fromDate, $toDate, $itemsPerPage, $offset)
	{
		$query = "Zenfox_Query::create()
						->from('GamelogRoulette r')
						->where('r.datetime BETWEEN ? AND ?', array('$fromDate', '$toDate'))
						->andWhere('r.player_id = ?', '$playerId')
						->orderBy('r.player_id ASC')";
	
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