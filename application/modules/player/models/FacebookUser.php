<?php
/**
 * This class is used to handle Facebook Operations
 */

class FacebookUser
{
	public function creditMaster($playerId, $masterPlayerId)
	{
		$accountVariable = new AccountVariable();
		$data['playerId'] = $playerId;
		$data['variableName'] = $masterPlayerId;
		$variableData = $accountVariable->getData($data['playerId'], $data['variableName']);
		if(!$variableData)
		{
			$data['variableValue'] = 'credited';
			$accountVariable->insert($data);
			
			$data['variableName'] = 'freeMoney';
			$accountVariableData = $accountVariable->getData($masterPlayerId, $data['variableName']);
	
			$freeChips = 1000;
			$varId = $accountVariableData['varId'];
			$data['playerId'] = $masterPlayerId;
			$data['varId'] = $varId;
			$data['variableValue'] = floatval($accountVariableData['varValue']) + $freeChips;
			$accountVariable->update($data);
		}
	}
}