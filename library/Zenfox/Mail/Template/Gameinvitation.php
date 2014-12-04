<?php
class Zenfox_Mail_Template_Gameinvitation
{
	public function getMailingInfo($code, $msgBody, $customMessage, $email)
	{
		$session = new Zend_Auth_Storage_Session();
		$storedData = $session->read();
		$playerId = $storedData['id'];
		
		$mailTemplate = new Zenfox_Mail_Template($playerId);
		$textMsgBody = $mailTemplate->getMsgBody($msgBody, 'txt', 'Gameinvitation', $code, '', $customMessage, $playerId, $email);
		$htmlMsgBody = $mailTemplate->getMsgBody($msgBody, 'htm', 'Gameinvitation', $code, '', $customMessage, $playerId, $email);
		return array(
			'textMsgBody' => $textMsgBody,
			'htmlMsgBody' => $htmlMsgBody,
		);
	}
}