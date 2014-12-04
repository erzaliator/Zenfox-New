<?php
class Zenfox_Mail_Template
{
	private $_playerId;
	private $_player;
	
	public function __construct($playerId = NULL)
	{
		$this->_player = new Player();
		$this->_playerId = $playerId;
	}
	
	public function generateMail($templateName, $category, $code = NULL, $userName = NULL, $recepientAddress = NULL)
	{
		$email = new EmailTemplate();
		$emailData = $email->getTemplateData($templateName, $category);
		//Zenfox_Debug::dump($emailData, 'email', true, true);
		if($this->_playerId == NULL)
		{
			$playerIds = $this->_player->getAllPlayersId('frontend_id', 1);
			foreach($playerIds as $playerId)
			{
				$msgBody = $this->_generateBody($playerId, $emailData['body']);
				$this->sendMail($emailData['subject'], $msgBody, $templateName, $category, $code, $userName, $recepientAddress);
			}
		}
		else
		{
			$msgBody = $this->_generateBody($this->_playerId, $emailData['body']);
			$this->sendMail($emailData['subject'], $msgBody, $templateName, $category, $code, $userName, $recepientAddress);
		}
	}
	
	public function sendMail($subject, $msgBody, $templateName, $category, $code, $userName, $recepientAddress)
	{
		
		$msgBody = $this->_generateBody($this->_playerId, $msgBody);
		$language = Zend_Controller_Front::getInstance()->getRequest()->getParam('lang');
		
		$siteCode = Zend_Registry::get('siteCode');
    	$mailConfigFile = APPLICATION_PATH . '/site_configs/' . $siteCode . '/mailConfig.json';
		$fh = fopen($mailConfigFile, 'r');
        $mailConfigJson = fread($fh, filesize($mailConfigFile));
        fclose($fh);
        $mailConfig = Zend_Json::decode($mailConfigJson);
        
		$mail = new Zend_Mail('utf-8');
		//$tr = new Zend_Mail_Transport_Smtp('smtp.gmail.com', $mailConfig['authentication']);
		$tr = new Zend_Mail_Transport_Smtp($mailConfig['authentication']['smtp'], $mailConfig['authentication']);
		Zend_Mail::setDefaultTransport($tr);
		
		//$mail->setFrom($mailConfig['authentication']['username'], $mailConfig['displayname']['name']);
		$mail->setFrom($mailConfig['displayname']['email'], $mailConfig['displayname']['name']);
		$mail->setSubject($subject);
		//TODO put the player email address
		$mail->addTo($recepientAddress);
		
		if($templateName == 'Forgot_Password')
		{
			$frontController = Zend_Controller_Front::getInstance();
			$module = $frontController->getRequest()->getModuleName();
			
			$userType = strtoupper($module);
			$passwordRecovery = new PasswordRecovery();
			$playerData = $passwordRecovery->getPlayerData($this->_playerId, $userType);
			if($playerData['status'] == 'UNPROCESSED')
			{
				$url = 'http://' .  $_SERVER['SERVER_NAME'] . '/' . $language . '/auth/resetpassword/code/' . $playerData['code'];
				$msgBody = str_replace('$link', $url, $msgBody);
			}
		}
		elseif($templateName == 'CONFIRMATION')
		{
			if($category == 'registration')
			{
				$url = 'http://' .  $_SERVER['SERVER_NAME'] . '/' . $language . '/auth/confirm/code/' . $code;
				$msgBody = str_replace('$link', $url, $msgBody);
				$msgBody = str_replace('$username', $userName, $msgBody);
			}
		}
		$mail->setBodyHtml($msgBody);
		$mail->send();
		return true;
		//return $msgBody;
		
	}

	public function getSubject($subject)
        {
                return $this->_generateBody($this->_playerId, $subject, 'htm');
        }
	
	public function getMsgBody($msgBody, $contentType, $templateName = NULL, $code = NULL, $trackerId = NULL, $customMessage = NULL, $buddyId = NULL, $email = NULL)
	{
		$msgBody = $this->_generateBody($this->_playerId, $msgBody, $contentType);
		$language = Zend_Controller_Front::getInstance()->getRequest()->getParam('lang');
		$frontendConfig = Zend_Registry::get('frontendConfig');
		$companyName = $frontendConfig['frontends'][$_SERVER['HTTP_HOST']]['site_name'];
		$companySite = "<a href = http://" . $_SERVER['HTTP_HOST'] . ">" . $_SERVER['HTTP_HOST'] . "</a>";
		
		switch($templateName)
		{
			case 'Registration':
				if($language && $trackerId)
				{
					$url = 'http://' .  $_SERVER['HTTP_HOST'] . '/' . $language . '/auth/confirm/code/' . $code . '/trackerId/' . $trackerId;
				}
				elseif($language && !$trackerId)
				{
					$url = 'http://' .  $_SERVER['HTTP_HOST'] . '/' . $language . '/auth/confirm/code/' . $code;
				}
				elseif($trackerId)
				{
					$url = 'http://' .  $_SERVER['HTTP_HOST'] . '/auth/confirm/code/' . $code . '/trackerId/' . $trackerId;
				}
				else
				{
					$url = 'http://' .  $_SERVER['HTTP_HOST'] . '/auth/confirm/code/' . $code;
				}
				$msgBody = str_replace('$link', $url, $msgBody);
				$msgBody = str_replace('$companyName', $companyName, $msgBody);
				$msgBody = str_replace('$companySite', $companySite, $msgBody);
				break;
				
			case 'Recovery':
				if($language)
				{
					$url = 'http://' .  $_SERVER['HTTP_HOST'] . '/' . $language . '/auth/resetpassword/code/' . $code;
				}
				else
				{
					$url = 'http://' .  $_SERVER['HTTP_HOST'] . '/auth/resetpassword/code/' . $code;
				}
				$msgBody = str_replace('$link', $url, $msgBody);
				break;
				
			case 'Invitation':
				if(isset($customMessage))
				{
					$player = new Player();
					$userName = $player->getUserName($this->_playerId);
					$customMessage = $userName . ' says, "' .$customMessage . '"';
				}
				$link = "http://" . $_SERVER['HTTP_HOST'] . "/index/unsubscribe/emailId/" . $email;
				//$link = "http://" . $_SERVER['HTTP_HOST'] . '/index/index/buddyId/' . $buddyId;
				$companySite = "<a href = http://" . $_SERVER['HTTP_HOST'] . '/index/index/buddyId/' . $buddyId . ">" . $_SERVER['HTTP_HOST'] . "</a>";
				$msgBody = str_replace('$link', $link, $msgBody);
				//$msgBody = str_replace('$buddyLink', $link, $msgBody);
				$msgBody = str_replace('$customMessage', $customMessage, $msgBody);
				$msgBody = str_replace('$companyName', $companyName, $msgBody);
				$msgBody = str_replace('$companySite', $companySite, $msgBody);
				break;
				
			case 'Transaction':
				$transactionId = $code;
				$playerTransactionRecord = new PlayerTransactionRecord();
				$transactionData = $playerTransactionRecord->getTransactionData('',$transactionId);
				$amount = $transactionData['amount'];
				$transTime = $transactionData['transTime'];
				$msgBody = str_replace('$amount', $amount, $msgBody);
				$msgBody = str_replace('$transactionId', $transactionId, $msgBody);
				$msgBody = str_replace('$transactionTime', $transTime, $msgBody);
				$msgBody = str_replace('$companyName', $companyName, $msgBody);
				break;
			case 'Withdrawal':
				$link = "<a href = 'http://www.admin.taashtime.com/player/view/playerId/$this->_playerId'> HERE </a>";
				$msgBody = str_replace('$amount', $code, $msgBody);
				$msgBody = str_replace('$link', $link, $msgBody);
				//Zenfox_Debug::dump($msgBody, 'body', true, true);
		}	
	/*	$language = Zend_Controller_Front::getInstance()->getRequest()->getParam('lang');
		
		$siteCode = Zend_Registry::get('siteCode');
    	$mailConfigFile = APPLICATION_PATH . '/site_configs/' . $siteCode . '/mailConfig.json';
		$fh = fopen($mailConfigFile, 'r');
        $mailConfigJson = fread($fh, filesize($mailConfigFile));
        fclose($fh);
        $mailConfig = Zend_Json::decode($mailConfigJson);
        
		$mail = new Zend_Mail('utf-8');
		$tr = new Zend_Mail_Transport_Smtp('smtp.gmail.com', $mailConfig['authentication']);
		Zend_Mail::setDefaultTransport($tr);
		
		$mail->setFrom('nikhil@fortuity.in', 'nik');
		$mail->setSubject($subject);
		//TODO put the player email address
		$mail->addTo('nikg4u@gmail.com', 'nikhil');
		
		if($templateName == 'FORGOT_PASSWORD')
		{
			$passwordRecovery = new PasswordRecovery();
			$playerData = $passwordRecovery->getPlayerData($this->_playerId);
			if($playerData['status'] == 'UNPROCESSED')
			{
				$url = 'http://' .  $_SERVER['SERVER_NAME'] . '/' . $language . '/auth/resetpassword/code/' . $playerData['code'];
				$msgBody = str_replace('$link', $url, $msgBody);
			}
		}
		elseif($templateName == 'CONFIRMATION')
		{
			if($category == 'registration')
			{
				$url = 'http://' .  $_SERVER['SERVER_NAME'] . '/' . $language . '/auth/confirm/code/' . $code;
				$msgBody = str_replace('$link', $url, $msgBody);
				$msgBody = str_replace('$username', $userName, $msgBody);
			}
		}
		$mail->setBodyHtml($msgBody);
		$mail->send();*/
		return $msgBody;
		
	}
	
	/*public function getBody($emailBody, $searchingField = NULL, $searchingString = NULL)
	{
		if($this->_playerId == NULL)
		{
			$playerIds = $this->_player->getAllPlayersId('frontend_id', 1);
			//Zenfox_Debug::dump($playerIds, 'playerIds', true, true);
			foreach($playerIds as $playerId)
			{
				$output = $this->_generateBody($playerId, $emailBody);
			}
			//print_r(count_chars($string, '<'));
		}
		else
		{
			$output = $this->_generateBody($this->_playerId, $emailBody);
		}
		return $output;
	}*/
	
	protected function _generateBody($playerId, $emailBody, $contentType)
	{
		$htmTagStrtpos = '';
		$string = $emailBody;
		$temp = true;
		$i = 0;
		$output = '';
		while($temp)
		{
			$strtpos = strpos($string, '[', $i);
			$endpos = strpos($string, ']', $i);
			if($contentType == 'txt')
			{
				$htmTagStrtpos = strpos($string, '<', $i);
				$htmTagEndpos = strpos($string, '>', $i);
			}
			if(($strtpos) && ((!$htmTagStrtpos) || ($strtpos < $htmTagStrtpos)))
			{
				$output .= substr($string, $i, $strtpos - $i);
				$i = $endpos + 1;
				$subString = substr($string, $strtpos + 1, $endpos - $strtpos - 1);
				$tagData = $this->_getTagData($subString, $playerId);
				$output .= $tagData;
			}
			elseif(($htmTagStrtpos) && ((!$strtpos) || ($htmTagStrtpos < $strtpos)))
			{
				$output .= substr($string, $i, $htmTagStrtpos - $i);
				$i = $htmTagEndpos + 1;
			}
			else
			{
				$output .= substr($string, $i, strlen($string) - $i);
				$temp = false;
			}
		}
		//Zenfox_Debug::dump($output, 'output', true, true);
		return $output;
	}
	
	protected function _getTagData($tagName, $playerId)
	{
		$tag = new EmailTag();
		$query = $tag->getQuery($tagName) . "($playerId);";
		return $this->_executeQuery($query);
	}
	
	protected function _executeQuery($query)
	{
		$result = '';
		$varTab = '';
		$explodeQuery = explode('.', $query);
		$str = 'new ' . $explodeQuery[0] . '();';
		eval("\$varTab=" . $str);
		$newQuery = '$varTab->' . $explodeQuery[1] . ';';
		//Zenfox_Debug::dump($explodeQuery, 'ex', true, true);
		/*if($explodeQuery[0] == '$player')
		{
			$str = 'new Player();';
			//$player = new Player();
			eval("\$player=" . $str);
		}
		elseif($explodeQuery[0] == '$admin')
		{
			$admin = new Csr();
		}*/
		eval("\$result=" . $newQuery);
		return $result;
	}
}
