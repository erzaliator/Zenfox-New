<?php
/**
 * This class is used to add promotional bonus to player account
 */

class PromotionalBonus
{
	public function addBonus($playerId, $fundAmount, $lastDeposit)
	{
		$currentTime = Zend_Date::now();
		$prevDay = $currentTime->sub(1, Zend_Date::DAY);
		
		$lastDeposit = new Zend_Date($lastDeposit);
		$difference = $prevDay->compare($lastDeposit, Zend_Date::DAY);
		
		$accountVariable = new AccountVariable();
		$varName = 'LAST_PROMOTIONAL_BONUS';
		$variableData = $accountVariable->getData($playerId, $varName);
		
		if($variableData)
		{
			$bonusPercentage = $variableData['varValue'];
		}
		else
		{
			$bonusPercentage = -1;
		}
		
		if(($bonusPercentage != -1) || $variableData)
		{
			switch($difference)
			{
				case '-1':
					if($bonusPercentage == -1)
					{
						$bonusPercentage = 4;
					}
					break;
				case '0':
					if($bonusPercentage == -1)
					{
						$bonusPercentage = 4;
					}
					else
					{
						$bonusPercentage += 4;
					}
					break;
				case '1':
					$bonusPercentage = 0;
					break;
			}
			
			if($bonusPercentage)
			{
				$amount = ($fundAmount * $bonusPercentage) / 100;
				$playerTransaction = new PlayerTransactions();
				$sourceId = $playerTransaction->creditBonus($playerId, $amount, 'INR');
				
				if(!$sourceId)
				{
					return array(
									'error' => true,
									'message' => 'Could not credit bonus.');
				}
				$auditReport = new AuditReport();
				$reportMessage = $auditReport->checkError($sourceId, $playerId);
				
				$counter = 0;
				while((!($reportMessage['processed'] == 'PROCESSED')) && (!($reportMessage['error'] == 'NOERROR')))
				{
					if($counter == 3)
					{
						break;
					}
					$reportMessage = $auditReport->checkError($sourceId, $playerId);
					if($reportMessage)
					{
						break;
					}
						
					$counter++;
				}
				if($counter == 3 && !$reportMessage)
				{
					return array(
									'error' => true,
									'message' => "Your bonus amount has not been credited, please try again. <br>If problem persists contact our <a href = '/ticket/create'> customer support </a>");
				}
				if(($reportMessage['processed'] != 'PROCESSED') && ($reportMessage['error'] != 'NOERROR'))
				{
					return array(
									'error' => true,
									'message' => 'Your bonus amount is not credited, please try again. If problem persists, please contact support with the following audit Id:: '. $reportMessage['auditId']);
				}
			}
		}
		$data['playerId'] = $playerId;
		$data['variableName'] = 'LAST_PROMOTIONAL_BONUS';
		$data['variableValue'] = $bonusPercentage;
		$accountVariable->insert($data);
		
		return array(
			'error' => false);
	}
}