<?php

require_once 'PHPMailer/class.phpmailer.php';

class Mail
{
	private $_playerId;
	
	public function __construct($playerId = NULL)
	{
		$this->_playerId = $playerId;
	}
	
	public function sendToAll()
	{
		$mailLog = new EmailLog();
		$list = new EmailList();
		$email = new EmailTemplate();
		$mailLogsData = $mailLog->getMailLogData();
		foreach($mailLogsData as $logData)
		{
			$listData = $list->getListData($logData['list_id']);
			$template = $email->getTemplateInformation($logData['template_id']);
			$templateString = 'new Zenfox_Mail_Template_' . $template['templateName'] . ';';
			$mailTemplate = '';
			eval("\$mailTemplate = " . $templateString);
			$connections = Zenfox_Partition::getInstance()->getConnections(-1);
			foreach($connections as $conn)
			{
				Doctrine_Manager::getInstance()->setCurrentConnection($conn);
				$function = '';
				eval("\$function = " . $listData['function']);
				$allPlayersData = $function->fetchArray();
				foreach($allPlayersData as $playerData)
				{
					$msgBody = $mailTemplate->getMail($playerData['player_id'], $template['msgBody']);
					$this->_sendMail($template['subject'], $msgBody, $playerData['email']);
				}
			}
		}
	}
	
	protected function _sendMail($subject, $textMsgBody, $htmlMsgBody, $recepientAddress, $campaignId = NULL, $attachment = false, $addCc = false)
	{
		$language = Zend_Controller_Front::getInstance()->getRequest()->getParam('lang');
		
		$siteCode = Zend_Registry::get('siteCode');
		//$siteCode = 'bingocrush';
    	$mailConfigFile = APPLICATION_PATH . '/site_configs/' . $siteCode . '/mailConfig.json';
    	
		$fh = fopen($mailConfigFile, 'r');
        $mailConfigJson = fread($fh, filesize($mailConfigFile));
        fclose($fh);
        $mailConfig = Zend_Json::decode($mailConfigJson);
        
        /* $mail = new PHPMailer();
        
        $mail->IsSendmail();
        
        $mail->AddAddress($recepientAddress, $recepientAddress);
        $mail->SetFrom($mailConfig['authentication']['username'], $mailConfig['displayname']['name']);
        $mail->Subject = $subject;
        
        $mail->MsgHTML($htmlMsgBody);
        
        try{
        	$mail->Send();
        	//echo "Success!";
        } catch(Exception $e){
        	//Something went bad
        	//echo "Fail :(";
        	return "Some problem has been occured while sending the mail. Please contact to our customer support.";
        }
        return false; */
		
        $mail = new Zend_Mail('utf-8');
		$tr = new Zend_Mail_Transport_Smtp($mailConfig['authentication']['smtp'], $mailConfig['authentication']);
		Zend_Mail::setDefaultTransport($tr);

		$mail->setFrom($mailConfig['authentication']['username'], $mailConfig['displayname']['name']);

		if($campaignId)
		{
			$mail->addHeader('X-Mailgun-Campaign-Id', $campaignId . '-Bingocrush');
		}
		$mail->addTo($recepientAddress);
		$mail->setSubject($subject);
		$mail->setBodyText($textMsgBody);
		$mail->setBodyHtml($htmlMsgBody);
		$mail->setReplyTo($mailConfig['displayname']['reply-to']);

		if($attachment)
		{
			$mail->addCc('saket@fortuity.in');
			//$mail->addCc('ravinder@fortuity.in');
			$mail->addCc('support@bingocrush.co.uk');
			$at = $mail->createAttachment($attachment);
			$at->type        = 'image/jpg';
			$at->disposition = Zend_Mime::DISPOSITION_INLINE;
			$at->encoding    = Zend_Mime::ENCODING_BASE64;
			$at->filename    = 'rummybug.jpg';
		}
		if($addCc)
		{
			$mail->addCc($addCc);
		}

		try
		{
			$mail->send();
		}
		catch(Exception $e)
		{
			//Zenfox_Debug::dump($e, 'e', true, true);
			return "Some problem has been occured while sending the mail. Please contact to our customer support.";
		} 
		return false;
	}
	
	public function sendToOne($templateName, $category, $code = NULL, $message = NULL, $email = NULL)
	{
		/*echo "temp - " . $templateName;
		echo "cat - " . $category;
		echo 'code - ' . $code;
		echo 'email - ' . $email;*/
		
		/*$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$accountUnconfirm = new AccountUnconfirm();
		$userType = $accountUnconfirm->getUserType($code);*/
		
		$emailTemplate = new EmailTemplate();
		$templateData = $emailTemplate->getTemplateData($templateName, $category);
		
		$frontendName = Zend_Registry::get('frontendName');
		switch($frontendName)
		{
			case 'taashtime.com':
			case 'www.taashtime.com':
				$frontController = Zend_Controller_Front::getInstance();
				$module = $frontController->getRequest()->getModuleName();
				$userType = strtoupper($module);
				
				$session = new Zend_Auth_Storage_Session();
				$sessionData = $session->read();
				$campaignName = "";
				switch($templateName)
				{
					case 'Registration':
						$accountUnconfirm = new AccountUnconfirm();
						$playerData = $accountUnconfirm->getPlayerData($code);
						$userId = $playerData['playerId'];
						$emailList = $playerData['email'];
						$campaignName = 'Registration';
						break;
					case 'Recovery':
						$passwordRecovery = new PasswordRecovery();
						$userId = $passwordRecovery->getPlayerId($code);
						$playerData = $passwordRecovery->getPlayerData($userId, $userType);
						$emailList = $playerData['email'];
						$campaignName = 'Password Recovery';
						break;
					case 'Invitation':
						$campaignName = 'Invitation';
					default:
						$userId = $sessionData['id'];
						$emailList = $email;
					break;
				}
				$templateId = $templateData['templateId'];
				
				if($userId)
				{
					$emailQueue = new EmailQueue();
					$emailQueue->addEmailQueue($userId, $userType, $emailList, $templateId, $message, $campaignName);
				}
				
				$filePath = '/home/zenfox/backup_player/email_queue.txt';
				if(file_exists($filePath))
				{
					$fh = fopen($filePath, 'a');
					fwrite($fh, "PLAYER ID->" . $userId . " TEMPLATE ID->" . $templateId);
					fclose($fh);
				}
				break;
			case 'bingocrush.co.uk':
			case 'ace2jak.com':
				$templateString = 'new Zenfox_Mail_Template_' . $templateName . ';';
				$mailTemplate = '';
				eval("\$mailTemplate = " . $templateString);
				$mailInfo = $mailTemplate->getMailingInfo($code, $templateData['msgBody'], $message, $email, $templateData['subject']);
				//Zenfox_Debug::dump($mailInfo, 'mail');
				//echo $email;
				if(isset($mailInfo['subject']))
				{
					$templateData['subject'] = $mailInfo['subject']; 
				}
				if(!$email && isset($mailInfo['email']))
				{
					$this->_sendMail($templateData['subject'], $mailInfo['textMsgBody'], $mailInfo['htmlMsgBody'], $mailInfo['email'], $templateName);
				}
				elseif($email)
				{
					$this->_sendMail($templateData['subject'], $mailInfo['textMsgBody'], $mailInfo['htmlMsgBody'], $email, $templateName);
				}
				break;
		}
	}

	public function sendMails($subject, $textBody, $htmlBody, $email, $attachment = false, $addCc = false)
	{
		$this->_sendMail($subject, $textBody, $htmlBody, $email, '', $attachment, $addCc);
	}
}
