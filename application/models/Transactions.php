<?php
/**
 * This class is used to handle all kind of transactions
 */

class Transactions
{
	public function credit($transactionType, $playerId, $amount, $transCurrency = NULL, $transactionId = NULL, $buddyBaseCurrency = NULL, $trackerId = NULL, $notes = NULL)
	{
		$playerTransactions = new PlayerTransactions();
		
		switch($transactionType)
		{
			case 'BONUS':
				$sourceId = $playerTransactions->creditBonus($playerId, $amount, $transCurrency, $notes);
				break;
			case 'DEPOSIT':
				$sourceId = $playerTransactions->creditDeposit($playerId, $amount, $transCurrency, $transactionId);
				break;
			case 'BONUS_DUE':
				$sourceId = $playerTransactions->creditBonusDue($playerId, $amount, $buddyBaseCurrency, $notes);
				break;
		}
		
		if(!$sourceId)
		{
			return array(
				'success' => false,
				'error' => 'Could not credit bonus.'
			);
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
			$message = 'Your amount has not been credited, please try again. <br>If problem persists contact our <a href = "/ticket/create">customer support</a>';
			return array(
				'success' => false,
				'error' => $message
			);
		}
		if(($reportMessage['processed'] == 'PROCESSED') && ($reportMessage['error'] == 'NOERROR'))
		{
			return array(
				'success' => true,
				'sourceId' => $sourceId
			);
		}
		elseif($counter != 3)
		{
			$message = 'Your amount is not credited, please try again. If problem persists, please contact support with the following audit Id:: '. $reportMessage['auditId'];
			return array(
				'success' => false,
				'error' => $message
			);
		}
	}
}
