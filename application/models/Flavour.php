<?php
/**
 * This class implements all flavour options
 * @author Nikhil Gupta
 * @date January 2, 2010 
 */
class Flavour extends BaseFlavour
{
	/*
	 * This function gets all the table names from Flavour
	 * @return array
	 */
	
	public function getTableName($gameFlavour)
	{
		$conn = Zenfox_Partition::getInstance()->getCommonConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		try
		{
			$result = Doctrine::getTable('Flavour')->findOneByGameFlavour($gameFlavour);
		}
		catch(Exception $e)
		{
			return false;
		}
		return $result['running_table'];
	}
	
	/*
	 * This function gets all flavour data from table
	 * @returns array
	 */
	public function getFlavourData()
	{
		$conn = Zenfox_Partition::getInstance()->getCommonConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
					->from('Flavour');
					
		$result = $query->fetchArray();
		return $result;
	}
	/**
	 * gets all the game flavours from flavours table
	 * @return unknown_type
	 */
	public function getGameFlavours()
	{
		$conn = Zenfox_Partition::getInstance()->getCommonConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		$query = Zenfox_Query::create()
					->select('game_flavour')
					->from('Flavour');
					
		try
		{
			$result = $query->fetchArray();
		}
		catch(Exception $e)
		{
			return false;
		}
		
		$gameFlavours = array();
		if($result)
		{
			foreach($result as $item)
			{
				$gameFlavours[] = $item['game_flavour'];
			}
			return $gameFlavours;
		}
		return NULL;
	}
	/**
	 * This method gets all the running games
	 * @return unknown_type
	 */
	public function getAllGames()
	{
		$gameFlavours = $this->getGameFlavours();
		$allMachinesData = array();
		foreach($gameFlavours as $gameFlavour)
		{
			$tableName = $this->getTableName($gameFlavour);
			if($tableName == 'running_roulette')
			{
				$instance = new RunningRoulette();
			}
			elseif($tableName == 'running_keno')
			{
				$instance = new RunningKeno();
			}
			elseif($tableName == 'running_slots')
			{
				$instance = new RunningSlot();
			}
			$machinesData = $instance->getAllMachinesData();
			
			$allMachinesData[$gameFlavour] = $machinesData;
		}
		return $allMachinesData;
	}
	
	public function getFlavourName($gameFlavour)
	{
		$conn = Zenfox_Partition::getInstance()->getCommonConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
						->select('f.name')
						->from('Flavour f')
						->where('f.game_flavour = ?', $gameFlavour);
		$result = $query->fetchArray();
		return $result;
	}
	
	public function getAllFlavoursName()
	{
		$conn = Zenfox_Partition::getInstance()->getCommonConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
						->select('f.name, f.game_flavour')
						->from('Flavour f');
		$result = $query->fetchArray();
		return $result;
	}
}