<?php
class Zenfox_Mail_Template_Invitation
{
	public function getMailingInfo($code, $msgBody, $customMessage, $email, $subject)
	{
		$session = new Zend_Auth_Storage_Session();
		$storedData = $session->read();
		$playerId = $storedData['id'];
		
		$mailTemplate = new Zenfox_Mail_Template($playerId);
		$textMsgBody = $mailTemplate->getMsgBody($msgBody, 'txt', 'Invitation', $code, '', $customMessage, $playerId, $email);
		$htmlMsgBody = $mailTemplate->getMsgBody($msgBody, 'htm', 'Invitation', $code, '', $customMessage, $playerId, $email);
		$subject = $mailTemplate->getSubject($subject);
		
		return array(
			'textMsgBody' => $textMsgBody,
			'htmlMsgBody' => $htmlMsgBody,
			'subject' => $subject,
		);
	}
}