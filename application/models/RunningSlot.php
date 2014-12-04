<?php
/**
 * This class is used to get RunningSlot machine data
 * @author nikhil
 * @date January 9, 2010
 */
class RunningSlot extends BaseRunningSlot
{
	/**
	 * This function is used to get all machines data
	 * @return array
	 */
	public function getAllMachinesData()
	{
		$conn = Zenfox_Partition::getInstance()->getCommonConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
						->from('RunningSlot');
						
		$result = $query->fetchArray();
		return $result;
	}
	
	/**
	 * This function is used to get the machine data for seletcted id
	 * @param $runningSlotsId
	 * @return array
	 */
	public function getMachineData($runningSlotsId, $gameFlavour)
	{
		$conn = Zenfox_Partition::getInstance()->getCommonConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
				
		$query = Zenfox_Query::create()
					->from('RunningSlot r')
					->where('r.id = ?', $runningSlotsId)
					->andWhere('r.game_flavour = ?', $gameFlavour)
					->andWhere('r.enabled = ?', 'ENABLED');
		try
		{
			$result = $query->fetchArray();
		}
		catch(Exception $e)
		{
			return false;
		}
//		print(Doctrine_Manager::getInstance()->getCurrentConnection()->getName());
//		print('slotFlavour - ' . $result['game_flavour']);
		//return $result;
		if($result)
		{
			return array(
				'runningMachineId' => $result[0]['id'],
				'machineId' => $result[0]['machine_id'],
				'gameFlavour' => $result[0]['game_flavour'],
				'amountType' => $result[0]['amount_type'],
				'featureEnabled' => $result[0]['feature_enabled'],
				'bonusSpinsEnabled' => $result[0]['bonus_spins_enabled'],
				'denomination' => $result[0]['denominations'],
				'defaultDenomination' => $result[0]['default_denomination'],
				'defaultCurrency' => $result[0]['default_currency'],
				'pjpEnabled' => $result[0]['pjp_enabled'],
				'maxBet' => $result[0]['max_bet'],
				'machineType' => $result[0]['machine_type'],
				'maxBetlines' => $result[0]['max_betlines'],
				'maxCoins' => $result[0]['max_coins'],
				'minBetlines' => $result[0]['min_betlines'],
				'minCoins' => $result[0]['min_coins'],
				'enabled' => $result[0]['enabled'],
				'createdBy' => $result[0]['created_by'],
				'createdTime' => $result[0]['created_time'],
				'lastUpdatedBy' => $result[0]['last_updated_by'],
				'lastUpdatedTime' => $result[0]['last_updated_time'],
				'machineName' => $result[0]['machine_name'],
				'description' => $result[0]['description']);
		}
		return NULL;
	}
	
	public function getLatestMachineData()
	{
		$conn = Zenfox_Partition::getInstance()->getCommonConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
						->from('RunningSlot s')
						->orderBy('s.id DESC')
						->limit(1);
						
		$result = $query->fetchArray();
		return array(
				'runningSlotId' => $result[0]['id'],
				'pjpEnabled' => $result[0]['pjp_enabled']);
	}
	
	public function getSlotsGameFlavour($runningSlotsId)
	{
		$conn = Zenfox_Partition::getInstance()->getCommonConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
						->select('rs.game_flavour')
						->from('RunningSlot rs')
						->where('rs.id = ?', $runningSlotsId);
						
		$result = $query->fetchArray();
		return $result[0]['game_flavour'];
	}
}
