<?php
class Zenfox_Mail_Template_Notification
{
	public function getMail($playerId, $msgBody)
	{
		$mailTemplate = new Zenfox_Mail_Template($playerId);
		$msgBody = $mailTemplate->getMsgBody($msgBody);
		return $msgBody;
	}
}