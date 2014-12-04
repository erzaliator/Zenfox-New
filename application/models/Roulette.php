<?php
/**
 * This class implements all roulette operations
 * @author Nikhil Gupta
 * @date January 2, 2010
 */
class Roulette extends BaseRoulette
{
	/*
	 * This function retunrs the machine names
	 * @return array
	 */
	
	public function getMachineNames($gameFlavour, $partitionKey)
	{
		$conn = Zenfox_Partition::getInstance()->getCommonConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
					->from('Roulette r')
					->where('r.game_flavour = ? ', $gameFlavour);
					
		$result = $query->fetchArray();
		return $result;
	}
	
	/*
	 * Get all the machine details from table
	 */
	public function getMachineDetails()
	{
		$conn = Zenfox_Partition::getInstance()->getCommonConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
					->from('Roulette');
					
		$result = $query->fetchArray();
		return $result;
	}
	
	/**
	 * Get the game flavour for selected machineId
	 */
	public function getGameFlavour($machineId)
	{
		$conn = Zenfox_Partition::getInstance()->getCommonConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
						->select('r.game_flavour')
						->from('Roulette r')
						->where('r.machine_id = ?', $machineId);
						
		$result = $query->fetchArray();
		return $result[0]['game_flavour'];
	}
	
	public function getFilesPathFromId($id)
	{
		$conn = Zenfox_Partition::getInstance()->getCommonConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		try
		{
			$result = Doctrine::getTable('Roulette')->findOneByMachine_id($id);
		}
		catch(Exception $e)
		{
			return false;
		}
		return array(
			'configFile' => $result['config_file'],
			'swfFile' => $result['swf_file']
		);
	}
}