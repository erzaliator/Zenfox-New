<?php
class Zenfox_Controller_Plugin_LoginBonus extends Zend_Controller_Plugin_Abstract
{	
	public function dispatchLoopShutdown()
	{
		$session = new Zend_Auth_Storage_Session();
		$storedData = $session->read();
		$buddyId = $storedData['authDetails'][0]['buddy_id'];
		if(isset($buddyId))
		{
			$playerTransaction = new PlayerTransactions();
			$playerId = $storedData['id'];
			$baseCurrency = $storedData['authDetails'][0]['base_currency'];
			$data['playerId'] = $playerId;
			$data['variableName'] = 'noof-logins-' . $buddyId;
			$data['variableValue'] = $playerId;
			$accountVariable = new AccountVariable();
			$accountVariableData = $accountVariable->getData($buddyId, $data['variableName']);
			if($accountVariableData)
			{
				$varValue = $accountVariableData['varValue'];
				if($varValue)
				{
					$data['variableValue'] = $varValue . ',' . $playerId;
				}
			}
			$accountVariable->insert($data);
			$accountVariableData = $accountVariable->getData($buddyId, $data['variableName']);
			if($accountVariableData)
			{
				$varValue = $accountVariableData['varValue'];
				$buddies = explode(',', $varValue);
				if(count($buddies) == 10)
				{
					$playerTransaction->creditBonus($buddyId, 100, $baseCurrency);
					$data['variableValue'] = '';
				}
			}
			$accountVariable->insert($data);
		}
	}
}