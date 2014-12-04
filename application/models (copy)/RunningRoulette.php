<?php

/**
 * RunningRoulette
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6401 2009-09-24 16:12:04Z guilhermeblanco $
 */

/**
 * This class has implemented to get the RunningRoulette Game information
 * @author Nikhil Gupta
 * @date January 2, 2010
 */
class RunningRoulette extends BaseRunningRoulette
{
	/*
	 * This function get all the data of the game for selected machineId
	 * @returns array
	 */
	public function getMachineData($id, $gameFlavour)
	{
		$conn = Zenfox_Partition::getInstance()->getCommonConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
					->from('RunningRoulette r')
					->where('r.id = ?', $id)
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
		if($result)
		{
			return array(
				'runningMachineId' => $result[0]['id'],
				'machineName' => $result[0]['machine_name'],
				'gameFlavour' => $result[0]['game_flavour'],
				'description' => $result[0]['description'],
				'maxBet' => $result[0]['max_bet'],
				'maxBetString' => $result[0]['max_bet_string'],
				'enabled' => $result[0]['enabled'],
				'machineId' => $result[0]['machine_id'],
				'pjpEnabled' => $result[0]['pjp_enabled'],
				'amountType' => $result[0]['amount_type']);
		}
		return NULL;
	}
	
	/*
	 * This function get all the machines details from RunningRoulette
	 * @return array
	 */
	public function getAllMachinesData()
	{
		//FIXME read it from slave.
		//TODO Call a getCommonConnection function to make the connection
		//DONE Wrote the getCommonConnection function in partition.php
		$conn = Zenfox_Partition::getInstance()->getCommonConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
					->from('RunningRoulette');
					
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
	
	public function getLatestMachineData()
	{
		$conn = Zenfox_Partition::getInstance()->getCommonConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
						->from('RunningRoulette r')
						->orderBy('r.id DESC')
						->limit(1);
						
		try
		{
			$result = $query->fetchArray();
		}
		catch(Exception $e)
		{
			return false;
		}
		return array(
				'runningRouletteId' => $result[0]['id'],
				'pjpEnabled' => $result[0]['pjp_enabled']);
	}
}