<?php
/*
 * This class is implemented to get the details of a group by passing gameGroupId.
 */
class Gamegroup extends BaseGamegroup
{	
	public function getGroupDetails($gameGroupId)
	{
	/*	$query = Zenfox_Query::create()
					->from('Gamegroup gr')
					->where('gr.id = ? ', $gameGroupId);
					
		$result = $query->fetchArray();*/
		try
		{
			$result = Doctrine::getTable('Gamegroup')->findOneById($gameGroupId);
		}
		catch(Exception $e)
		{
			return false;
		}
		if($result)
		{
			//Getting game details from GameGamegroup
			$gameGamegroup = new GameGamegroup();
			$gameDetails = $gameGamegroup->getGameDetails($result['id'], $result['name']);
			if(!$gameDetails)
			{
				return false;
			}
			$groupDetails[$result['name']] = $gameDetails;
			/*print($result['name']);
			echo '<pre>';
			Zenfox_Debug::dump(print_r($groupDetails), 'game');*/
			return $groupDetails;
		}
		return NULL;
	}
	
	public function getAllGroupDetails()
	{
		$conn = Zenfox_Partition::getInstance()->getCommonConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
						->from('Gamegroup');
						
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
	
	/**
	 * This method gets all the game groups
	 * @return unknown_type
	 */
	public function getAllGroups()
	{
		$conn = Zenfox_Partition::getInstance()->getCommonConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
					->from('Gamegroup');
					
		$result = $query->fetchArray();
		return $result;
	}
	/**
	 * this methods gets the gamegroup id by the gamegroup name
	 * @param $name
	 * @return unknown_type
	 */
	public function getIdByGameGroupName($name)
	{
		$conn = Zenfox_Partition::getInstance()->getCommonConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
					->select('id')
					->from('Gamegroup')
					->where('name = ?',$name);
					
		$result = $query->fetchOne();
		
		return $result['id'];
	}
	/**
	 * This method gets the game group details by id
	 * @param $id
	 * @return unknown_type
	 */
	public function getGameGroup($id)
	{
		$conn = Zenfox_Partition::getInstance()->getCommonConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		$query = Zenfox_Query::create()
					->from('Gamegroup')
					->where('id = ?',$id);
					
		$result = $query->fetchOne();
		
		return $result;
	}
}
