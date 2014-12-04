<?php
/*
 * This class is implemented to get the table names from flavour and machine data 
 * for the same table.
 */
class GameGamegroup extends BaseGameGamegroup
{
	public function getGameDetails($gameGroupId, $groupName)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
					->from('GameGamegroup gp')
					->where('gp.gamegroup_id = ? ', $gameGroupId);
					
		try
		{
			$result = $query->fetchArray();
		}
		catch(Exception $e)
		{
			return false;
		}
		$flavour = new Flavour();
		$i = 0;
		$finalObject = array();
		//Getting table names from Flavour
		foreach($result as $gameGroup)
		{
			$tableName = $flavour->getTableName($gameGroup['game_flavour']);
			/*if(!$tableName)
			{
				return false;
			}*/
			$result[$i]['game_flavour'] = array(
									'tableName' => $tableName,
									'flavour' => $gameGroup['game_flavour']);
/*			$i++;
		}
		$i = 0;
		//Getting machine data from table, got from flavour.
		foreach($result as $gameGroup)
		{*/
			if($tableName == 'running_roulette')
			{
				//$groupName = 'roulette';
				$runningRoulette = new RunningRoulette();
				$machineData = $runningRoulette->getMachineData($gameGroup['running_machine_id'], $gameGroup['game_flavour']);
			}
			if($tableName == 'running_keno')
			{
				//$groupName = 'keno';
				$runningKeno = new RunningKeno();
				$machineData = $runningKeno->getMachineData($gameGroup['running_machine_id'], $gameGroup['game_flavour']);
			}
			if($tableName == 'running_slots')
			{
				//$groupName = 'slots';
				$runningSlot = new RunningSlot();
				$machineData = $runningSlot->getMachineData($gameGroup['running_machine_id'], $gameGroup['game_flavour']);
			}
			if($machineData)
			{
				$result[$i]['running_machine_id'] = $machineData;
				$finalObject[$groupName][$machineData['amountType']][$gameGroup['running_machine_id']] = $machineData;
				$i++;
			}
		}
		if(!$i)
		{
			return false;
		}
		//Zenfox_Debug::dump($finalObject, 'table');
		return $finalObject;
	}
	
	public function getAllGroupsDetails()
	{
		$conn = Zenfox_Partition::getInstance()->getCommonConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
						->from('GameGamegroup');
						
		try
		{
			$result = $query->fetchArray();
		}
		catch(Exception $e)
		{
			return false;
		}
		return $result;
	}
	
	public function getGamegroupId($gameFlavour, $runningMachineId)
	{
		$conn = Zenfox_Partition::getInstance()->getCommonConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
					->from('GameGamegroup gp')
					->where('gp.game_flavour = ?', $gameFlavour)
					->andWhere('gp.running_machine_id = ?', $runningMachineId);
		
		try
		{
			$result = $query->fetchArray();
		}
		catch(Exception $e)
		{
			Zenfox_Debug::dump($e, 'ex', true, true);
		}
		if($result)
		{
			return $result[0]['gamegroup_id'];
		}
	}
}
