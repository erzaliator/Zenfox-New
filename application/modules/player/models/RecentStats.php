<?php

/** 
 * @author ny
 * 
 * 
 */
class RecentStats {
	//TODO - Insert your code here
	

	function __construct() {
		
	//TODO - Insert your code here
	}
	
	/**
	 * 
	 */
	function __destruct() {
		
	//TODO - Insert your code here
	}
	
	/**
	 * 
	 * @param mixed $gameFlavour
	 * @param mixed $frontendId
	 * @return mixed $recentWinners
	 */
	
	public function getTopWinners($gameFlavour = null, $frontendId = null, $runningMachineId = null)
	{
		/*
		 * FIXME:: This has to be replaced with traversing all the slaves
		 */
		$conn = Zenfox_Partition::getInstance()->getCommonConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$date = new Zend_Date();
        $today = $date->get(Zend_Date::W3C);
        $lastWeek = date ("Y-m-d H:i:s", strtotime("$today, -7 DAY"));
        
		
/*		$query1 = Zenfox_Query::create()
				->from('AuditReport a')
				->where('a.game_flavour = ?', 'Keno')
				->andWhere('a.running_machine_id = ?', 1)
				->limit(10);
		Zenfox_Debug::dump($query1->fetchArray(), 'data');*/
	
		$query = Zenfox_Query::create()
				   ->select('p.login, max(a.amount) AS amount, a.amount_type, a.transaction_currency, a.game_flavour')
		           ->from('AuditReport a')
		           ->leftJoin('a.AccountDetail p')
		           ->where('a.trans_start_time > ?', $lastWeek)
		           ->andWhere('a.transaction_type = ?', 'AWARD_WINNINGS')
		           ->groupBy('a.player_id')
		           ->orderBy('max(a.amount) DESC')
		           ->limit(10);
		           
		if(!is_null($gameFlavour))
		{	
			if(is_array($gameFlavour))
			{
				$query = $query->whereIn('a.game_flavour', $gameFlavour);
			}
			else
			{
				$query = $query->andWhere('a.game_flavour = ?', $gameFlavour);
			}
		}
		
		if(!is_null($frontendId))
		{
			if(is_array($frontendId))
			{
				$query = $query->whereIn('a.frontend_id', $frontendId);
			}
			else
			{
				$query = $query->andWhere('a.frontend_id = ?', $frontendId);
			}
		}

		if(!is_null($runningMachineId))
		{
			if(is_array($runningMachineId))
			{
				$query = $query->whereIn('a.running_machine_id', $runningMachineId);
			}
			else
			{
				$query = $query->andWhere('a.running_machine_id = ?', $runningMachineId);
			}
		}
//		Zenfox_Debug::dump($query->getSql(), 'query');
		$topWinnersArray = $query->fetchArray();
		
		/*
		 * recentWinners array:
		 * recentWinners = array(
		 * 							array('gameFlavour' => 'RU_US', 'name'=>'Player Name', 'amount'=>'10.00', 'currency' => 'EUR'),
		 * 						) 
		 */
		
		$topWinners = array();
		$i = 0;
		foreach ($topWinnersArray as $topWinner)
		{
			$topWinners[$i]['game_flavour'] = $topWinner ['game_flavour'];
			$topWinners[$i]['login'] = $topWinner['AccountDetail']['login'];
			$topWinners[$i]['amount'] = $topWinner['amount'];
			$topWinners[$i]['currency'] = $topWinner['transaction_currency'];
			$topWinners[$i]['amount_type'] = $topWinner['amount_type'];
			
			$i++;
		}
		
		return $topWinners;	
	}
	
	public function getRecentWinners($gameFlavour = null, $frontendId = null)
	{
		/*
		 * FIXME:: This has to be replaced with traversing all the slaves
		 */
		$conn = Zenfox_Partition::getInstance()->getCommonConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
				   ->select('p.login, MAX(a.amount) as amount, a.amount_type, a.transaction_currency, a.game_flavour')
		           ->from('AuditReport a')
		           ->leftJoin('a.AccountDetail p')
		           ->orderBy('a.trans_end_time DESC')
		           ->where('processed = ?', 'PROCESSED')
		           ->andWhere('error = ?', 'NOERROR')
		           ->groupBy('a.player_id')
		           ->limit(10);
		           
		           
		if(!is_null($gameFlavour))
		{	
			if(is_array($gameFlavour))
			{
				$query = $query->andWhere('a.game_flavour = ?', $gameFlavour);
			}
			else
			{
				$query = $query->andWhereIn('a.game_flavour', $gameFlavour);
			}
		}
		
		if(!is_null($frontendId))
		{
			if(is_array($frontendId))
			{
				$query = $query->whereIn('a.frontend_id', $frontendId);
			}
			else
			{
				$query = $query->andWhere('a.frontend_id = ?', $frontendId);
			}
		}
		
		
		$recentWinnersArray = $query->fetchArray();
		
		/*
		 * recentWinners array:
		 * recentWinners = array(
		 * 							array('gameFlavour' => 'RU_US', 'name'=>'Player Name', 'amount'=>'10.00', 'currency' => 'EUR'),
		 * 						) 
		 */
		
		$recentWinners = array();
		$i = 0;
		foreach ($recentWinnersArray as $recentWinner)
		{
			$recentWinners[$i]['game_flavour'] = $recentWinner ['game_flavour'];
			$recentWinners[$i]['login'] = $recentWinner['AccountDetail']['login'];
			$recentWinners[$i]['amount'] = $recentWinner['amount'];
			$recentWinners[$i]['currency'] = $recentWinner['transaction_currency'];
			$recentWinners[$i]['amount_type'] = $recentWinner['amount_type'];
			
			$i++;
		}
		
		
		return $recentWinners;		
	}
}

?>
