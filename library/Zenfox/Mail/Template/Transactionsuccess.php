<?php
class Zenfox_Mail_Template_Transactionsuccess
{
	public function getMailingInfo($transactionId, $msgBody, $customMessage, $email)
	{
		$session = new Zenfox_Auth_Storage_Session();
		$storedData = $session->read();
		if($storedData)
		{
			$playerId = $storedData['id'];
		}
		else
		{
			$playerTransactionRecord = new PlayerTransactionRecord();
			$transactionData = $playerTransactionRecord->getTransactionData('',$transactionId);
			$playerId = $transactionData['playerId'];
		}
		
		$mailTemplate = new Zenfox_Mail_Template($playerId);
		
		$textMsgBody = $mailTemplate->getMsgBody($msgBody, 'txt', 'Transaction', $transactionId);
		$htmlMsgBody = $mailTemplate->getMsgBody($msgBody, 'htm', 'Transaction', $transactionId);
		
		return array(
			'textMsgBody' => $textMsgBody,
			'htmlMsgBody' => $htmlMsgBody,
		);
	}
}