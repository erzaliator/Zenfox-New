<?php
class QuickJoin
{
	public function getFreeTableParameters($amountTye = 'FREE', $gameFlavour = NULL)
	{
		if(!$gameFlavour)
		{
			$gameFlavours = array('BestOfThree', 'MPPRummy');
			$gameFlavour = $gameFlavours[rand(0, count($gameFlavours) - 1)];
		}
		
		$tableCofig = new TableConfig();
		$tableConfigIds = $tableCofig->getTableConfigId($amountType, $gameFlavour);
		
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		if(is_array($tableConfigIds))
		{
			foreach($tableConfigIds as $tableConfigId)
			{
				$query = Zenfox_Query::create()
						->select('max(ot.config_log_id)')
						->from('OnlineTable ot')
						->where('ot.table_config_id = ?', $tableConfigId)
						->andWhere('ot.game_flavour = ?', $gameFlavour);
				
				$result = $query->fetchArray();
				$configLogId = $result[0];
				
				$query = Zenfox_Query::create()
						->from('OnlineTable ot')
						->where('ot.game_state = ?', 'Registration')
						->andWhere('ot.game_flavour = ?', $gameFlavour)
						->andWhere('ot.table_config_id = ?', $tableConfigId)
						->andWhere('ot.config_log_id = ?', $configLogId);
				
				$result = $query->fetchArray();
				
				if($result)
				{
					foreach($result as $onlineTableData)
					{
						$finlResult[] = $onlineTableData;
					}
				}
			}
		}
		else
		{
			$query = Zenfox_Query::create()
					->from('OnlineTable ot')
					->where('ot.game_state = ?', 'Registration');
			
			$finalResult = $query->fetchArray();
		}
		
		/* $query = Zenfox_Query::create()
					->select('ot.config_log_id')
					->from('OnlineTable ot')
					->where('ot.table_config_id = ?', 1)
					->andWhere('ot.game_flavour = ?', $gameFlavour);
		
		$result = $query->fetchArray();
		Zenfox_Debug::dump($result, 'result', true, true);
		
		$query = Zenfox_Query::create()
					->from('OnlineTable ot')
					->where('ot.game_state = ?', 'Registration');
					//->andWhere('ot.num_players > ?', 0);
		
		if(is_array($tableConfigIds))
		{
			$query = $query->andWhereIn('ot.table_config_id', $tableConfigIds);
			$query = $query->andWhere('ot.game_flavour = ?', $gameFlavour);
		}
					
		try
		{
			$result = $query->fetchArray();
		}
		catch(Exception $e)
		{
			
		} */
		/* if(!$result)
		{
			$query = Zenfox_Query::create()
					->from('OnlineTable ot')
					->where('ot.game_state = ?', 'Registration')
					->andWhere('ot.num_players = ?', 0);
		}
		if(is_array($tableConfigIds))
		{
			$query = $query->andWhereIn('ot.table_config_id', $tableConfigIds);
		}
		try
		{
			$result = $query->fetchArray();
		}
		catch(Exception $e)
		{
			
		} */
		//Zenfox_Debug::dump($result, 'result',true, true);
		$randomNumber = mt_rand(0, count($finalResult) - 1);
		return array(
			'flavour' => $finalResult[$randomNumber]['game_flavour'],
			'machineId' => $finalResult[$randomNumber]['room_id'],
		);
	}
	
	public function getTournamentRoom($tournamentId, $tierId = NULL)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
					->from('OnlineTable ot')
					->where('ot.tournament_id = ?', $tournamentId)
					->andWhere('(ot.num_players+ot.num_bots) < ?', 6);
		
		if($tierId)
		{
			$query = $query->andWhere('ot.tier_id = ?', $tierId);
		}
		try
		{
			$result = $query->fetchArray();
		}
		catch(Exception $e)
		{
			return false;
		}
		if($result)
		{
			$randomNumber = mt_rand(0, count($result) - 1);
			return array(
				'flavour' => $result[$randomNumber]['game_flavour'],
				'machineId' => $result[$randomNumber]['room_id'],
			);
		}
		return false;
	}
}