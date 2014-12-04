<?php
class Zenfox_Mail_Template_Registration
{
	public function getMailingInfo($code, $msgBody, $customMessage = NULL, $email = NULL, $subject = NULL)
	{
		$accountUnconfirm = new AccountUnconfirm();
		$playerData = $accountUnconfirm->getPlayerData($code);
		$mailTemplate = new Zenfox_Mail_Template($playerData['playerId']);
		$trackerId = $playerData['trackerId'];
		//$msgBody = $mailTemplate->getMsgBody($msgBody, 'Registration', $code);
		$textMsgBody = $mailTemplate->getMsgBody($msgBody, 'txt', 'Registration', $code, $trackerId);
		$htmlMsgBody = $mailTemplate->getMsgBody($msgBody, 'htm', 'Registration', $code, $trackerId);
		return array(
			'textMsgBody' => $textMsgBody,
			'htmlMsgBody' => $htmlMsgBody,
			'email' => $playerData['email'],
		);
	}
}
