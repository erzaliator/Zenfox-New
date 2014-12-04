<?php

class ThirdpartyConnect extends BaseThirdpartyConnect
{
	/*public function __construct()
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
	}*/
	public function insertData($data)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		$this->player_id = $data['playerId'];
		$this->domain = $data['domain'];
		try
		{
			$this->save();
		}
		catch(Exception $e)
		{
			return false;
		}
		return true;
	}
	
	public function updateData($data)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		$query = Zenfox_Query::create()
					->update('ThirdpartyConnect tc')
					->set('tc.parent_id', '?', $data['parentId'])
					->set('tc.linked', '?', $data['linked'])
					->where('tc.player_id = ?', $data['playerId'])
					->andWhere('tc.domain = ?', $data['domain']);
					
		try
		{
			$query->execute();
		}
		catch(Exception $e)
		{
			return false;
		}
		return true;
	}
}
