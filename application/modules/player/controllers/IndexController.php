<?php
require_once dirname(__FILE__).'/../forms/RegistrationForm.php';
require_once dirname(__FILE__).'/../forms/LoginForm.php';
require_once dirname(__FILE__).'/../forms/InviteFriendForm.php';

class Player_IndexController extends Zenfox_Controller_Action
{
    public function init()
    {
    	$frontController = Zend_Controller_Front::getInstance();
        //FIXME:: This has to be called all the time. There should be a way to fix it.
        
    	if($this->getRequest()->getActionName() == 'index')
    	{
    		Zend_Layout::getMvcInstance()->setLayout('layout_front');
    	}
    	
    	$this->_helper->contextSwitch
			->addActionContext('sitemap', 'xml')
    		->initContext();
    	
        parent::init();
        $contextSwitch = $this->_helper->getHelper('contextSwitch');
		$contextSwitch->addActionContext('winner', 'json')
					->addActionContext('invite', 'json')
            		->initContext();
    }

    public function indexAction()
    {
    	if(!isset($_COOKIE['coupon']))
    	{
    		$couponActive = $this->getRequest()->coupon;
    		if(isset($couponActive) && $couponActive)
    		{
    			setcookie('coupon',$couponActive,time() + (86400),'/','.'.$_SERVER['HTTP_HOST']);
    		}
    	}
 	
    	$request = Zend_Controller_Front::getInstance()->getRequest();
		$trackerId = $request->getParam('trackerId');
		$affId = $request->getParam('aff_id');
		
		$trackerSession = new Zend_Session_Namespace('tracker');
		$affSession = new Zend_Session_Namespace('aff_id');
		$affSession->value = $affId;
		
		if(!$trackerId)
		{
			$trackerId = isset($trackerSession->value) ? $trackerSession->value : NULL;
			if(!$trackerId)
			{
				$request = Zend_Controller_Front::getInstance()->getRequest();
				$buddyId = $request->getParam('buddyId');
		    	$buddySession = new Zend_Session_Namespace('buddy');
		    	if(!$buddyId)
		    	{
		    		$buddyId = isset($buddySession->value) ? $buddySession->value : NULL;
		    	}
		    	$buddySession->value = $buddyId;
			}
		}
    	$trackerSession->value = $trackerId;
    	//$trackerSession->unsetAll();
    	
    	$webConfig = Zend_Registry::getInstance()->isRegistered('webConfig')?Zend_Registry::getInstance()->get('webConfig'):'';
    	$this->imagesDir = $webConfig['cssDir']?$webConfig['cssDir']:'null';

    	$session = new Zend_Auth_Storage_Session();
    	$store = $session->read();
    	$playerId = $store['id'];
    	
    	if($store)
    	{
    		$imageName = md5("image" . $playerId) . '.jpg';
			$loginName = $store['authDetails'][0]['login'];
			$firstName = $store['authDetails'][0]['first_name'];
			$cash = $store['authDetails'][0]['cash'] + $store['authDetails'][0]['bonus_bank'] + $store['authDetails'][0]['bonus_winnings'];
			$bonus = 0;
			if($store['authDetails'][0]['total_deposits'] > 0)
			{
				$bonus = $store['authDetails'][0]['bonus_due'];
			}
			$loyaltyPoints = $store['authDetails'][0]['loyalty_points_left'];
	    
			$currency = new Zend_Currency();
			$currencySession = new Zend_Session_Namespace('currency');
			
			$source = $currency->getShortName('', $currencySession->oldValue);
			$destination = $currency->getShortName('', $currencySession->newValue);
			$currConv = new CurrencyConversion();
			$cash = $currConv->getConvertedValue($source, $destination, $cash);
			$bonus = $currConv->getConvertedValue($source, $destination, $bonus);
			$store['cash'] = $cash;
			$store['bonus'] = $bonus;
			$session->write($store);
    		$imagePath = APPLICATION_PATH . "/../public/images/profiles/" . $imageName;
	       	if(!file_exists($imagePath))
	       	{
	       		$imagePath = "/images/profiles/profile-m1.jpg";
	       	}
	       	else
	       	{
	         	$imagePath = "/images/profiles/" . $imageName;
	       	}
	    	if($cash)
			{
				$cash = $currency->setValue($cash);
			}
			else
			{
				$cash = $currency->setValue(0);
			}
			$currency = new Zend_Currency();
    		if($bonus)
			{
				$bonus = $currency->setValue($bonus);
			}
			else
			{
				$bonus = $currency->setValue(0);
			}
    		if($loyaltyPoints)
			{
				$loyaltyPoints = $loyaltyPoints;
			}
			else
			{
				$loyaltyPoints = 0;
			}
			$freeChips = 0;
			$accountVariable = new AccountVariable();
			$varData = $accountVariable->getData($playerId, 'freeMoney');
			if($varData)
			{
				$freeChips = floatval($varData['varValue']);
			}
	       	$this->view->cash = $cash;
	       	$this->view->bonus = $bonus;
			$this->view->freeChips = $freeChips;
	       	$this->view->loyality = $loyaltyPoints;
	       	$this->view->imagePath = $imagePath;
    	}
    	else
    	{
    		$decorator = new Decorator();
    		$form = new Player_RegistrationForm();
		 	$form->registration('registration');
		 	$form->setAction('/auth/signup');
		 	
		 	$form = $decorator->addDecorators($form, 'signup');
		 	$heading = "JOIN NOW!";
		 	$this->view->heading = $heading;
		 	$this->view->form = $form;
    	}
        
        //IPL Code Start Here
    	$siteCode = Zend_Registry::get('siteCode');
		$iplFile = APPLICATION_PATH . '/site_configs/' . $siteCode . '/ipl.json';
		if(file_exists($iplFile))
		{			
			if($webConfig['ipl'] == 'enabled')
			{
				$fh = fopen($iplFile, 'r');
				$jsonData = fread($fh, filesize($iplFile));
				fclose($fh);
					
				$iplArray = Zend_Json::decode($jsonData);
				
				$date = new Zend_Date();
				$today = $date->get(Zend_Date::W3C);
				
				foreach($iplArray as $time => $iplData)
				{
					$date = new Zend_Date();
					$iplTime = new Zend_Date($time);
					$difference = $date->sub($iplTime)->toValue();
					$minute = floor($difference/60);
					if($minute > 210)
					{
						continue;
					}
					else
					{
						//Zenfox_Debug::dump($iplArray, 'array');
						$team1Name = $iplArray[$time]['team-1']['name'];
						$team1Image = $iplArray[$time]['team-1']['imageUrl'];
						$team1Value = strtoupper($iplArray[$time]['team-1']['name']);
							
						$team2Name = $iplArray[$time]['team-2']['name'];
						$team2Image = $iplArray[$time]['team-2']['imageUrl'];
						$team2Value = strtoupper($iplArray[$time]['team-2']['name']);
							
						$vote = $iplArray[$time]['vote']['voteNumber'];
							
						break;
					}
				}
					
				//$iplConfig = Zend_Json::decode($jsonData);
				//$vote = $iplConfig['vote']['voteNumber'];
				//$playerId = $store['id'];
				$conn = Zenfox_Partition::getInstance()->getMasterConnection();
				Doctrine_Manager::getInstance()->setCurrentConnection($conn);
				$accountVariable = new AccountVariable();
				if($this->getRequest()->isPost())
				{
					if($playerId)
					{
						if(isset($_POST['team']))
						{
							$data['playerId'] = $store['id'];
							$data['variableValue'] = $_POST['team'];
							$data['variableName'] = $vote;
							$checkedValue = $accountVariable->insert($data);
							if($checkedValue)
							{
								$this->view->voteCast = true;
							}
						}
						else
						{
							$this->view->noTeam = true;
						}
					}
					else
					{
						$this->view->noPlayerId = true;
					}
				}
				
				if($playerId)
				{
					$checkedValue = $accountVariable->getData($playerId, $vote);
					if($checkedValue)
					{
						//$team1 = strtoupper($iplConfig['team-1']['name']);
						//$team2 = strtoupper($iplConfig['team-2']['name']);
						$team1 = $team1Value;
						$team2 = $team2Value;
							
						if($checkedValue['varValue'] == $team1)
						{
							$this->view->team_1_checked = "checked";
							$this->view->team_2_checked = "";
						}
						elseif($checkedValue['varValue'] == $team2)
						{
							$this->view->team_2_checked = "checked";
							$this->view->team_1_checked = "";
						}
					}
				}
				
				$this->view->team_1_name = $team1Name;
				$this->view->team_1_image = $team1Image;
				$this->view->team_1_value = $team1Value;
					
				$this->view->team_2_name = $team2Name;
				$this->view->team_2_image = $team2Image;
				$this->view->team_2_value = $team2Value;
			}
		}
    }

    public function winnerAction()
    {
    	$this->view->homePage = $this->getRequest()->home;
    	$systemHealth = new SystemHealth();
    	$realMoneyWinnerList = $systemHealth->getRealMoneyWinnerList();
    	$bonusMoneyWinnerList = $systemHealth->getBonusMoneyWinnerList();
    	
    	$startTime = $realMoneyWinnerList['start_time'];
    	$endTime = $realMoneyWinnerList['end_time'];
    	$realWinnerList = Zend_Json::decode($realMoneyWinnerList['value']);
    	//$realWinnerList = array(array('1494' => '200'));
    	$bonusWinnerList = Zend_Json::decode($bonusMoneyWinnerList['value']);
    	$player = new Player();
    	$realResult = array();
    	$bonusResult = array();
    	if($realWinnerList)
    	{
    		foreach($realWinnerList as $index => $winnerList)
    		{
    			foreach($winnerList as $playerId => $winAmount)
    			{
    				$playerDetails = $player->getAccountDetails($playerId);
    				$realResult[$index]['login'] = $playerDetails['0']['login'];
    				$realResult[$index]['amount'] = $winAmount;
    				$realResult[$index]['playerId'] = $playerId;
    			}
    		}
    	}
    	if($bonusWinnerList)
    	{
    		foreach($bonusWinnerList as $index => $winnerList)
    		{
    			foreach($winnerList as $playerId => $winAmount)
    			{
    				$playerDetails = $player->getAccountDetails($playerId);
    				$name = $playerDetails['0']['login'];
    				if(strpos($playerDetails['0']['login'], "rediff") === 0)
    				{
    					$playerData = $player->getPlayerData($playerId);
    					$firstName = $playerData['firstName'];
    					$name = isset($firstName) ? $firstName : $name;
    				}
    				$bonusResult[$index]['login'] = $playerDetails['0']['login'];
    				$bonusResult[$index]['amount'] = $winAmount;
    				$bonusResult[$index]['playerId'] = $playerId;
    			}
    		}
    	}
    	
    	$startTime = explode(" ", $startTime);
    	$endTime = explode(" ", $endTime);

    	$this->view->realWinnerList = $realResult;
    	$this->view->bonusWinnerList = $bonusResult;
    	$this->view->startTime = date('d-M-Y', strtotime($startTime[0]));
    	$this->view->endTime = date('d-M-Y', strtotime($endTime[0]));
		/*$gameFlavour = $this->getRequest()->game_flavour;
		$gameId = $this->getRequest()->game_id;
		$gameId = null;*/
	$gameFlavour = null;
	$gameId = null;
    	//$frontendId = Zend_Registry::get('frontendId');
	$frontendId = 1;
        /* $recentStats = new RecentStats();
        $topWinners = $recentStats->getTopWinners($gameFlavour, $frontendId, $gameId); */

        $amountType = $this->getRequest()->amountType;
        $topWinners = $realResult;
        if($amountType == 'FREE')
        {
        	$topWinners = $bonusResult;
        }
        $this->view->winners = $topWinners;
        $this->view->gameFlavour = $gameFlavour;
        $this->view->gameId = $gameId;
    }
    
    public function sitemapAction()
    {
    }
    
    public function inviteAction()
    {
    	$session = new Zenfox_Auth_Storage_Session();
    	$store = $session->read();
    	$playerId = $store['id'];
	$this->view->login = $this->getRequest()->login;
    	
    	if(!isset($_POST['emails']))
    	{
    		
    		$form = new Player_InviteFriendForm();
    		$this->view->form = $form;
    	}
    	else
    	{
    		if(!isset($_POST['message']))
    		{
    			$_POST['message'] = "";
    		}
    		$inviteFriends = new InviteFriends();
    		$data = $inviteFriends->invite($playerId, $_POST['emails'], $_POST['message']);
	    	/* $emailLogs = new EmailLogs();
	    	$alreadySentEmailList = $emailLogs->getEmailAddresses($playerId);
	    	
	    	$alreadySentEmailAddresses = explode(',', $alreadySentEmailList[0]['email_list']);
	
	    	$emailsList = explode(',', $_POST['emails']);
	    	$emails = array_map('trim', $emailsList);
	    	//Zenfox_Debug::dump($emails, 'emails', true, true);
	    	$emailValidator = new Zend_Validate_EmailAddress();
	    	foreach($emails as $email)
	    	{
	    		if($emailValidator->isValid($email))
	    		{
	    			if(!in_array($email, $alreadySentEmailAddresses))
	    			{
	    				$validEmailAddresses[] = $email;
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
	
	    	$message = $_POST['message'];
	    	if($validEmailAddresses)
	    	{
	    		$validEmailAddresses = implode(",", $validEmailAddresses);
	    		$mail = new Mail();
	    		$mail->sendToOne('Invitation', 'INVITE_FRIEND', NULL, $message, $validEmailAddresses);
	    		// foreach($validEmailAddresses as $email)
	    		//{
	    			//$mail = new Mail();
	    			//$mail->sendToOne('Invitation', 'INVITE_FRIEND', NULL, $message, $email);
	    		//} 
				$data['success'] = true;
				$data['msg'] = 'Your invitation has been sent to your friends.';
	    		$this->_helper->FlashMessenger(array('notice' => $this->view->translate("Your invitation has been sent to your friends.")));
	    	}
	    	elseif(!$invalidEmailAddresses)
	    	{
				$data['success'] = false;
				$data['msg'] = 'Your already have invited these friends.';
	    		$this->_helper->FlashMessenger(array('notice' => $this->view->translate("Your already have invited these friends.")));
	    	}
		else
		{
			$data['success'] = false;
			$data['msg'] = 'Some of emails are invalid.';
			$this->_helper->FlashMessenger(array('notice' => $this->view->translate("Some of emails are invalid.")));
		} */
//	    	$emailLogs->insertEmails($invitedEmailList, $playerId);
    		if($this->getRequest()->ajax)
    		{
    			Zend_Layout::getMvcInstance()->disableLayout();
    			echo $data['msg'];
    		}
			else
			{
				$this->view->data = $data;
				$this->_helper->FlashMessenger(array('notice' => $this->view->translate($data['msg'])));
			}
    	}
    }
    
 	public function unsubscribeAction()
    {
    	$session = new Zenfox_Auth_Storage_Session();
    	$store = $session->read();
    	$playerId = $store['id'];
    	$playerobj = new Player();
    	
    	$playerIdofrequestedemail = $playerobj->getAccountIdFromEmail($this->getRequest()->emailId);
    	if($playerId == $playerIdofrequestedemail)
    	{
    		$emailId = $this->getRequest()->emailId . " \n";
    		$fileName = "/tmp/unsubscribe.txt";
    		$fh = fopen($fileName, 'a');
    		fwrite($fh, $emailId);
    		fclose($fh);
    		$result = $playerobj->unsubscribeemail($playerId);
    		if($result)
    		{
    			$this->_helper->FlashMessenger(array('notice' => $this->view->translate("Your email has been unsubscribed.")));
    		}
    		else 
    		{
    			$this->_helper->FlashMessenger(array('error' => $this->view->translate("Your email has not been unsubscribed.")));
    		}
    	}
    	else 
    	{
    		$this->_helper->FlashMessenger(array('error' => $this->view->translate("Can not unsubscribe. Email-Id Invalid!!")));
    	}
    	
    }

    public function reportbugAction()
    {
    	Zend_Layout::getMvcInstance()->disableLayout();

    	//$email = $this->getRequest()->to;
	$email = 'bharathi@fortuity.in';
    	$subject = $this->getRequest()->subject;
    	$textBody = $this->getRequest()->message;
    	$htmlBody = $this->getRequest()->message;
	$guestEmail = $this->getRequest()->email;
    	$image = $this->getRequest()->image;

	$session = new Zenfox_Auth_Storage_Session();
        $store = $session->read();
	$playerInfo = '<br>Login -> Guest <br>Email -> ' . $guestEmail;
	if($store)
	{
	        $playerInfo = '<br> Player Id -> ' . $store['id'] . '<br>Login Name -> ' . $store['authDetails'][0]['login'] . '<br>Email -> ' . $store['authDetails'][0]['email'];
	}

	$textBody = 'Player Info: ' . $playerInfo . '<p>' . $textBody;
	$htmlBody = 'Player Info: ' . $playerInfo . '<p>' . $htmlBody;
    	$attachment = base64_decode($image);
    	$mail = new Mail();
    	$mail->sendMails($subject, $textBody, $htmlBody, $email, $attachment);
    }
    
    public function mailresponseAction()
    {
    	$messageHeader = $_POST['message-headers'];
    	$varPos = strpos($messageHeader, 'Variables');
    	$jsonString = "";
    	$startJson = false;
    	for($i = $varPos+10; $i<strlen($messageHeader); $i++)
    	{
    		if($messageHeader[$i] == '{')
    	    {
    			$startJson = true;
    		}
		if($startJson && $messageHeader[$i] != "\\")
    		{
    			$jsonString .= $messageHeader[$i];
    		}
    		if($messageHeader[$i] == '}')
    		{
    			break;
    		}
    	}
	try
    	{
    		$decodeMailTag = Zend_Json::decode($jsonString);
    	}
    	catch(Exception $e)
    	{
    		//$filePath = APPLICATION_PATH . "/../public/images/profiles/error_logs.txt";
    		$filePath = "/home/zenfox/backup_player/error_logs.txt";
    		$fh = fopen($filePath, 'a');
    		fwrite($fh, "JsonString -> " . $jsonString . " Exception -> " . $e);
    		fclose($fh);
    	}
    			
    	$event = $_POST['event'];
    	//$mailTag = $_POST['X-Mailgun-Tag'];
    	//$decodeMailTag = Zend_Json::decode($mailTag);
    	$campaignName = $decodeMailTag['campaignName'];
    	$playerId = $decodeMailTag['playerId'];

	//Clicked Response
	//$campaignName = $_POST['campaign-name'];
	//$url = $_POST['url'];
	//$explodeUrl = explode('/', $url);
	//$playerId = $explodeUrl[6];
    	
    	$addBonus['msg'] = "Not credited";
	$email = $_POST['recipient'];
    	if($campaignName == 'Invitation' && $event == 'delivered')
    	{
		$playerInvitations = new PlayerInvitations();
	        $isValid = $playerInvitations->addEmailToEmailList($playerId, $email);
		if($isValid)
		{
	    		/*$inviteFriends = new InviteFriends();
    			$addBonus = $inviteFriends->addInvitationBonus($playerId);*/
		}
    	} 
    	//$filePath = APPLICATION_PATH . "/../public/images/profiles/error_logs.txt";
    	$filePath = "/home/zenfox/backup_player/error_logs.txt";
    	$fh = fopen($filePath, 'a');
    	fwrite($fh, "PlayerId - > " . $playerId . " Email -> " . $email . " Mail Tag -> " . $messageHeader . " Campaign Name -> " . $campaignName . " Event -> " . $event . " Add Bonus -> " . $addBonus['msg']);
    	fclose($fh); 
    }
}
