<?php
class Zenfox_Mail_Template_Transactionfail
{
	public function getMailingInfo($code, $msgBody)
	{
		$session = new Zenfox_Auth_Storage_Session();
		$storedData = $session->read();
		$playerId = $storedData['id'];
		
		$mailTemplate = new Zenfox_Mail_Template($playerId);
		
		$textMsgBody = $mailTemplate->getMsgBody($msgBody, 'txt', 'Transaction', $code);
		$htmlMsgBody = $mailTemplate->getMsgBody($msgBody, 'htm', 'Transaction', $code);
		
		return array(
			'textMsgBody' => $textMsgBody,
			'htmlMsgBody' => $htmlMsgBody,
		);
	}
}