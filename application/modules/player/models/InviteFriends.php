<?php

/**
 * This class is used to invite friends and credit bonus on daily basis
 */

class InviteFriends
{
	public function invite($playerId, $postedEmailList, $message)
	{
		$emailLogs = new EmailLogs();
		$alreadySentEmailList = $emailLogs->getEmailAddresses($playerId);
		
		$player = new Player();
		
		if($alreadySentEmailList)
		{
			$alreadySentEmailAddresses = explode(',', $alreadySentEmailList[0]['email_list']);
		}
		else
		{
			$alreadySentEmailAddresses = array();
		}

		$emailsList = explode(',', $postedEmailList);
		$emails = array_map('trim', $emailsList);
		
		$emailValidator = new Zend_Validate_EmailAddress();
		$validEmailAddresses = array();
		$invalidEmailAddresses = array();
		
		foreach($emails as $email)
		{
			if($emailValidator->isValid($email))
			{
				if(!in_array($email, $alreadySentEmailAddresses))
				{
					$alreadyExist = $player->getAccountIdFromEmail($email);
					if(!$alreadyExist)
					{
						$validEmailAddresses[] = $email;
					}
					if($alreadySentEmailAddresses)
					{
						$alreadySentEmailAddresses[] = $email;
					}
					else
					{
						$alreadySentEmailAddresses[0] = $email;
					}
				}
			}
			else
			{
				$invalidEmailAddresses[] = $email;
			}
		}
		
		$invitedEmailList = implode(',', $alreadySentEmailAddresses);
		
		if($validEmailAddresses)
		{
			/* $session = new Zend_Auth_Storage_Session();
			$storedData = $session->read();
			$lastLogin = $storedData['authDetails'][0]['last_login'];
			
			$currentLogin = Zend_Date::now();
			$lastLogin = new Zend_Date($lastLogin);
				
			$difference = $currentLogin->compare($lastLogin, Zend_Date::DAY); */
			
			/* $accountVariable = new AccountVariable();
			$varName = 'INVITED_FRIENDS';
			$variableData = $accountVariable->getData($playerId, $varName); */
			
			$emailLogs->insertEmails($invitedEmailList, $playerId);
			return $this->_sendInvitation($playerId, $validEmailAddresses, $message);
			
			if($difference >= 1)
			{
				if(count($validEmailAddresses) <= 50)
				{
					/* $vardata['playerId'] = $playerId;
					$vardata['variableName'] = 'INVITED_FRIENDS';
					$vardata['variableValue'] = count($validEmailAddresses);
					$accountVariable->insert($vardata); */
					/* $emailLogs->insertEmails($invitedEmailList, $playerId);
					return $this->_sendInvitation($playerId, $validEmailAddresses, $message); */
					/* foreach($validEmailAddresses as $email)
					 {
					$mail = new Mail();
					$mail->sendToOne('Invitation', 'INVITE_FRIEND', NULL, $message, $email);
					} */
					
					//$this->_helper->FlashMessenger(array('notice' => $this->view->translate("Your invitation has been sent to your friends.")));
				}
				else
				{
					/* $data['success'] = false;
					$data['msg'] = 'Sorry! You can not invite more than 50 friends in a day.'; */
				}
			}
			else
			{
				$alreadyInvitedFriends = 0;
				if($variableData)
				{
					$alreadyInvitedFriends = $variableData['varValue'];
				}

				if((count($validEmailAddresses)+$alreadyInvitedFriends) <= 50)
				{
					/* $vardata['playerId'] = $playerId;
					$vardata['variableName'] = 'INVITED_FRIENDS';
					$vardata['variableValue'] = count($validEmailAddresses)+$alreadyInvitedFriends;
					$accountVariable->insert($vardata); */
					/* $emailLogs->insertEmails($invitedEmailList, $playerId);
					return $this->_sendInvitation($playerId, $validEmailAddresses, $message); */
				}
				else
				{
					/* $data['success'] = false;
					$data['msg'] = 'Sorry! You already have invited 50 friends for today. You can invite more friends tomorrow.'; */
				}
			}
		}
		elseif(!$invalidEmailAddresses)
		{
			$data['success'] = false;
			$data['msg'] = 'Your already have invited these friends.';
			//$this->_helper->FlashMessenger(array('notice' => $this->view->translate("Your already have invited these friends.")));
		}
		else
		{
			$data['success'] = false;
			$data['msg'] = 'Some of emails are invalid.';
			//$this->_helper->FlashMessenger(array('notice' => $this->view->translate("Some of emails are invalid.")));
		}
		$emailLogs->insertEmails($invitedEmailList, $playerId);
		return $data;
	}
	
	private function _sendInvitation($playerId, $validEmailAddresses, $message)
	{
		//$amount = count($validEmailAddresses) * 5;
		
		$data['success'] = true;
		$validEmailAddresses = implode(",", $validEmailAddresses);
		$mail = new Mail();
		$mail->sendToOne('Invitation', 'INVITE_FRIEND', NULL, $message, $validEmailAddresses);

		/* $playerTransaction = new PlayerTransactions();
		$sourceId = $playerTransaction->creditBonus($playerId, $amount, 'INR', 'Crediting Invitation Bonus');
			
		if(!$sourceId)
		{
			$data['success'] = false;
			$data['msg'] = 'Could not credit bonus.';
		}
		$auditReport = new AuditReport();
		$reportMessage = $auditReport->checkError($sourceId, $playerId);
			
		$counter = 0;
		while((!($reportMessage['processed'] == 'PROCESSED')) && (!($reportMessage['error'] == 'NOERROR')))
		{
			if($counter == 3)
			{
				break;
			}
			$reportMessage = $auditReport->checkError($sourceId, $playerId);
			if($reportMessage)
			{
				break;
			}
				
			$counter++;
		}
		if($counter == 3 && !$reportMessage)
		{
			$data['success'] = false;
			$data['msg'] = "Your bonus amount has not been credited, please try again. <br>If problem persists contact our <a href = '/ticket/create'> customer support </a>";
		}
		if(($reportMessage['processed'] != 'PROCESSED') && ($reportMessage['error'] != 'NOERROR'))
		{
			$data['success'] = false;
			$data['msg'] = 'Your bonus amount is not credited, please try again. If problem persists, please contact support with the following audit Id:: '. $reportMessage['auditId'];
		} */
		if($data['success'])
		{
			$site = 'Taashtime';
			$frontendName = Zend_Registry::getInstance()->get('frontendName');
			if($frontendName == 'ace2jak.com')
			{
				$site = 'Ace2Jak';
			}
			else if($frontendName == 'bingocrush.co.uk')
			{
				$site = 'Bingocrush';
			}
			
			$data['success'] = true;
			$data['msg'] = 'Congratulation!! Your invitation has been sent to your friends. Your account will be credited as soon as your friend joins ' . $site . '.';
		}
		return $data;
	}
	
	public function addInvitationBonus($playerId)
	{
		/* $player = new Player();
		$accountData = $player->getAccountDetails($playerId);
		
		$lastLogin = $accountData[0]['last_login'];
			
		$currentLogin = Zend_Date::now();
		$lastLogin = new Zend_Date($lastLogin);
		
		$difference = $currentLogin->compare($lastLogin, Zend_Date::DAY); */
		$alreadyInvitedFriends = 0;
		$accountVariable = new AccountVariable();
		$varName = 'INVITED_FRIENDS';
		$variableData = $accountVariable->getData($playerId, $varName);
		if($variableData)
		{
			$alreadyInvitedFriends = $variableData['varValue'];
		}
		/* if($difference < 1)
		{
			if($variableData)
			{
				$alreadyInvitedFriends = $variableData['varValue'];
			}
		} */
		
		$alreadyInvitedFriends++;
	
		$vardata['playerId'] = $playerId;
		$vardata['variableName'] = 'INVITED_FRIENDS';
		$vardata['variableValue'] = $alreadyInvitedFriends;
		$accountVariable->insert($vardata);
	
		$data['success'] = true;
	
		if($alreadyInvitedFriends <= 50)
		{
			$playerTransaction = new PlayerTransactions();
			$sourceId = $playerTransaction->creditBonus($playerId, 5, 'INR', 'New Year Invitation Bonus For Delivered Mails');
				
			if(!$sourceId)
			{
				$data['success'] = false;
				$data['msg'] = 'Could not credit bonus.';
			}
			$auditReport = new AuditReport();
			$reportMessage = $auditReport->checkError($sourceId, $playerId);
				
			$counter = 0;
			while((!($reportMessage['processed'] == 'PROCESSED')) && (!($reportMessage['error'] == 'NOERROR')))
			{
				if($counter == 3)
				{
					break;
				}
				$reportMessage = $auditReport->checkError($sourceId, $playerId);
				if($reportMessage)
				{
					break;
				}
			
				$counter++;
			}
			if($counter == 3 && !$reportMessage)
			{
				$data['success'] = false;
				$data['msg'] = "Your bonus amount has not been credited, please try again. <br>If problem persists contact our <a href = '/ticket/create'> customer support </a>";
			}
			if(($reportMessage['processed'] != 'PROCESSED') && ($reportMessage['error'] != 'NOERROR'))
			{
				$data['success'] = false;
				$data['msg'] = 'Your bonus amount is not credited, please try again. If problem persists, please contact support with the following audit Id:: '. $reportMessage['auditId'];
			}
			if($data['success'])
			{
				$data['success'] = true;
				$data['msg'] = 'Congratulation!! Your invitation has been sent to your friends. Your account has been credited with Rs. ' . $amount;
			}
		}
	
		return $data;
	}
}