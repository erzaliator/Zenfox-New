<?php
/**
 * This class is used to give Joining Bonus once it is failed to give in BonusScheme Plugin
 */

class Registration
{
	public function joiningBonus($loginName, $playerId = NULL, $frontendId = NULL)
	{
		$player = new Player();
		if(!$playerId)
		{
			$playerId = $player->getPlayerId($loginName);
		}
		if($playerId)
		{
			if(!$frontendId)
			{
				$frontendId = Zend_Registry::get('frontendId');
			}
			$frontend = new Frontend();
			$schemeId = $frontend->getBonusSchemeId($frontendId);
			
			$bonusLevel = new BonusLevel();
			$amount = $bonusLevel->getAmount($schemeId, -1);
			
			$accountDetail = $player->getAccountDetails($playerId);
			$baseCurrency = $accountDetail[0]['base_currency'];
			$playerTransaction = new PlayerTransactions();
			$playerTransaction->creditBonus($playerId, $amount['bonus'], $baseCurrency);
			
			$data['playerId'] = $playerId;
			$data['variableName'] = 'freeMoney';
			$data['variableValue'] = 5000;
			$accountVariable = new AccountVariable();
			$accountVariable->insert($data);
			
			if(isset($accountDetail[0]['buddy_id']))
			{
				$data['playerId'] = $playerId;
				$data['variableName'] = 'is-credited-master';
				$data['variableValue'] = 0;
				/* $conn = Zenfox_Partition::getInstance()->getMasterConnection();
				 Doctrine_Manager::getInstance()->setCurrentConnection($conn); */
				$accountVariable = new AccountVariable();
				$accountVariable->insert($data);
			}
		}
	}
}