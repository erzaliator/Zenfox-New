<?php
class Zenfox_Mail_Template_Recovery
{
	public function getMailingInfo($code, $msgBody, $customMessage = NULL, $email = NULL, $subject = NULL)
	{
		$frontController = Zend_Controller_Front::getInstance();
		$module = $frontController->getRequest()->getModuleName();
		
		$userType = strtoupper($module);
		$passwordRecovery = new PasswordRecovery();
		$playerId = $passwordRecovery->getPlayerId($code);
		$playerData = $passwordRecovery->getPlayerData($playerId, $userType);
		$mailTemplate = new Zenfox_Mail_Template($playerId);
		
		$textMsgBody = $mailTemplate->getMsgBody($msgBody, 'txt', 'Recovery', $code);
		$htmlMsgBody = $mailTemplate->getMsgBody($msgBody, 'htm', 'Recovery', $code);
		return array(
			'textMsgBody' => $textMsgBody,
			'htmlMsgBody' => $htmlMsgBody,
			'email' => $playerData['email'],
		);
	}
}