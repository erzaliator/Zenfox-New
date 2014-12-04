<?php
class Zenfox_Mail_Template_Withdrawalrequest
{
	public function getMailingInfo($amount, $msgBody, $customMessage, $email)
	{
		$session = new Zend_Auth_Storage_Session();
		$storedData = $session->read();
		$playerId = $storedData['id'];
		
		$mailTemplate = new Zenfox_Mail_Template($playerId);

		$textMsgBody = $mailTemplate->getMsgBody($msgBody, 'txt', 'Withdrawal', $amount);
		$htmlMsgBody = $mailTemplate->getMsgBody($msgBody, 'htm', 'Withdrawal', $amount);

		return array(
			'textMsgBody' => $textMsgBody,
			'htmlMsgBody' => $htmlMsgBody,
		);
	}
}