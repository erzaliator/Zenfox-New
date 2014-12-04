<?php
/**
 * This class implements all roulette operations
 * @author Nikhil Gupta
 * @date January 2, 2010
 */
class Keno extends BaseKeno
{
	/*
	 * This function retunrs the machine names
	 * @return array
	 */
	
	public function getMachineNames($gameFlavour, $partitionKey)
	{
		$connName = Zenfox_Partition::getInstance()->getCommonConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($connName);
		
		/*
		 * Getting the machine name for selected gameFlavour from Roulette table
		 */
		
		$query = Zenfox_Query::create()
					->from('Keno k')
					->where('k.game_flavour = ? ', $gameFlavour);
					
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
					->from('Keno');
					
		$result = $query->fetchArray();
		return $result;
	}
	/**
	 * Get Keno machine details for a given id
	 * @param $id
	 * @return unknown_type
	 */
	public function getKenoMachine($id)
	{
		$conn = Zenfox_Partition::getInstance()->getCommonConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$result = Doctrine::getTable('Keno')->findOneByMachine_id($id);
		
		return $result;
	}
	
	public function getFilesPathFromId($id)
	{
		$conn = Zenfox_Partition::getInstance()->getCommonConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		try
		{
			$result = Doctrine::getTable('Keno')->findOneByMachine_id($id);
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