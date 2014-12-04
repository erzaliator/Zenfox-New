<?php
class AccountUnconfirmVariables extends BaseAccountUnconfirmVariables
{
	public function insertVarData($data)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$accountUnconfirmVariables = new AccountUnconfirmVariables();
		
		try
		{
			$accountUnconfirmVariables->player_id = $data['playerId'];
			$accountUnconfirmVariables->variable_name = $data['variableName'];
			$accountUnconfirmVariables->variable_value = $data['variableValue'];
			$accountUnconfirmVariables->save();
		}
		catch(Exception $e)
		{
			return false;
		}
	}
	
	public function getVariableValue($playerId)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
					->from('AccountUnconfirmVariables auv')
					->where('auv.player_id = ?', $playerId);
		
		$result = $query->fetchArray();
		if($result)
		{
			return $result;
		}
		return NULL;
	}
}