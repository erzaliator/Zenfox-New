<?php
/**
 * This class implements pjp machines operations
 * @author Nikhil Gupta
 * @date January 2, 2010
 */
class PjpMachine extends BasePjpMachine
{
	/*
	 * This function gets all the pjp data from table
	 */
	public function getPjpDetails()
	{
		$conn = Zenfox_Partition::getInstance()->getCommonConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
					->from('PjpMachine');
					
		$result = $query->fetchArray();
		return $result;
	}
	
	public function getMachineData($gameId, $gameFlavour)
	{
//		print('gameId - ' . $gameId);
//		print('gameFlavour - ' . $gameFlavour);
		$conn = Zenfox_Partition::getInstance()->getCommonConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
					->from('PjpMachine pm')
					->where('pm.game_id = ? and pm.game_flavour = ?', array($gameId, $gameFlavour));
					
		$result = $query->fetchArray();
//		Zenfox_Debug::dump($result, 'pjp');
		return $result;
	}
	
	public function getPjpMachinesByGameId($gameId)
	{
		//$gameId = 1;
		$conn = Zenfox_Partition::getInstance()->getCommonConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
						->from('PjpMachine pm')
						->where('pm.game_id = ?', $gameId);
						
		$result = $query->fetchArray();
		return $result;
	}
	
	public function getPjpMachineData($pjpMachineId)
	{
		$conn = Zenfox_Partition::getInstance()->getCommonConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
						->from('PjpMachine pm')
						->where('pm.id = ?', $pjpMachineId);
						
		$result = $query->fetchArray();
		return $result;
	}
	
}