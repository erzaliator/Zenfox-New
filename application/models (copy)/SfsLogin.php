<?php
class SfsLogin extends BaseSfsLogin
{
	public function getSfsLoginById($id)
	{
		$conn = Zenfox_Partition::getInstance()->getCommonConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$result = Doctrine::getTable('SfsLogin')->findOneById($id);
		
		return $result;
	}
	
	public function getSfsLoginsByPlayerId($playerId)
	{
		$conns = Zenfox_Partition::getInstance()->getConnections(-1);
		foreach($conns as $conn)
		{
			Doctrine_Manager::getInstance()->setCurrentConnection($conn);
			$query = Zenfox_Query::create()
					->from('SfsLogin')
					->where('player_id = ?',$playerId);
					
			$result = $query->fetchArray();
			
			if($result)
			{
				return $result;
			}	
		}
	}
}