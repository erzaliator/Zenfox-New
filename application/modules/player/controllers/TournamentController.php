<?php

class Player_TournamentController extends Zenfox_Controller_Action
{
	
	public function init()
	{
		parent::init();
	
		$contextSwitch = $this->_helper->getHelper('contextSwitch');
		$contextSwitch->addActionContext('register', 'json')
					->addActionContext('list', 'json')
					->addActionContext('desc', 'json')
					->addActionContext('current', 'json')
					->initContext();
	}
	
	public function indexAction()
	{
		$session = new Zend_Auth_Storage_Session();
                $store = $session->read();
                $loginName = $store['authDetails'][0]['login'];
                $firstName = $store['authDetails'][0]['first_name'];
                $email = $store['authDetails'][0]['email'];
                $name = empty($firstName)?$loginName:$firstName;
		if(!$name)
		{
			$name = 'Guest';
		}
		$this->view->name = $name;
		$this->view->email = $email;
	}

	public function registerAction()
	{
		$request = $this->getRequest();

		$session = new Zenfox_Auth_Storage_Session();
		$storedData = $session->read();
		$playerId = $storedData['id'];

		if(!$playerId)
		{
			$this->_helper->FlashMessenger(array('error' => 'Please login to register'));
		}
		else
		{

			//FIXME:: Change this after the first tournament is done
			$tournamentId = isset($request->tournamentId)?$request->tournamentId:1;
			$frontendId = Zend_Registry::getInstance()->get('frontendId');

			$level = isset($request->level)?$request->level:1;
			$currentLevel = $this->getRequest()->currentLevel;
			$tournamentRegister = new TournamentRegistrations();
			$status = $tournamentRegister->registerPlayer($tournamentId, $playerId, $frontendId, $level);
			if($status == 0)
			{
				$this->view->status = "NOT_REGISTERED";
				$this->view->message="No more registrations are accepted now!";
			}
			elseif($status == 1)
			{
				/*$filePath = APPLICATION_PATH . '/site_configs/rum/tournament_registration.html';
				$fh = fopen($filePath, 'r');
				$fileContent = fread($fh, filesize($filePath));
				$session = new Zend_Auth_Storage_Session();
				$store = $session->read();
				$loginName = $store['authDetails'][0]['login'];
				$firstName = $store['authDetails'][0]['first_name'];
				$email = $store['authDetails'][0]['email'];
				$name = empty($firstName)?$loginName:$firstName;
				$fileContent = str_replace('#name#', $name, $fileContent);
				$fileContent = str_replace('#email#', $email, $fileContent);*/

				//MAIL CODE START HERE
				/*$tournament = new Tournaments();
				$tournamentDetail = $tournament->getTournamentById($tournamentId);
				$tournamentConfigId = $tournamentDetail['tournament_config_id'];
				$tournamentConfig = new TournamentConfig();
				$tournamentConfigData = $tournamentConfig->getTournamentDetails($tournamentConfigId);
				$rewardArray = Zend_Json::decode($tournamentConfigData['rewards']);
				
				$configArray = Zend_Json::decode($tournamentConfigData['config']);
				$explodeTime = explode(" ", $tournamentDetail['start_time']);
				$tournamentStartDate = date('d-M-Y',strtotime($explodeTime[0]));
				$tournamentStartTime = date('g:i a', strtotime($explodeTime[1]));
				
				$link = 'http://' .  $_SERVER['SERVER_NAME'] . "/tournament/desc/tournamentId/" . $tournamentId;
				$filePath = APPLICATION_PATH . '/site_configs/rum/tournament_registration.html';
				$fh = fopen($filePath, 'r');
				$fileContent = fread($fh, filesize($filePath));
				$session = new Zend_Auth_Storage_Session();
				$store = $session->read();
				$loginName = $store['authDetails'][0]['login'];
				$firstName = $store['authDetails'][0]['first_name'];
				$email = $store['authDetails'][0]['email'];
				$name = empty($firstName)?$loginName:$firstName;
				$fileContent = str_replace('<TIME_OF_TOURNAMENT>', $tournamentStartTime, $fileContent);
				$fileContent = str_replace('<DATE_OF_TOURNAMENT>', $tournamentStartDate, $fileContent);
				$fileContent = str_replace('<LINK>', $link, $fileContent);
				$mail = new Mail();
				$mail->sendMails('Registration', $fileContent, $fileContent, $email);*/
				//END HERE
			
				if(isset($currentLevel) && ($currentLevel == $level))
				{
					$this->_redirect("/game/quickjoin/tournamentId/".tournamentId."/level/".currentLevel);
				}
				$this->view->status = "REGISTERED";
				$this->view->message="Thank you! You have been registered to play the tournament on TaashTime. Good Luck!!";
			}
			elseif($status == 2)
			{
				if(isset($currentLevel) && ($currentLevel == $level))
				{
					$this->_redirect("/game/quickjoin/tournamentId/".tournamentId."/level/".currentLevel);
				}
				$this->view->status = "ALREADY_REGISTERED";
				$this->view->message="You are already registered. Please wait before the tournament begins. Good Luck!!";
			}
			elseif($status == 3)
			{
				$this->view->status = "UNKNOWN";
				$this->view->message="You don't have enough balance to register for tournament, please deposit!";
			}
			elseif($status == 4)
			{
				$this->view->status = "COMPLETED";
				$this->view->message="Level-" . $level . " is completed.";
			}
			else
			{
				$this->view->status = "UNKNOWN";
				$this->view->message="Something went wrong!";
			}
			/* $player = new Player();
			$accountDetails = $player->getAccountDetails($playerId);
			$enabledRegistartion = true;
			$placeWager = true;
			$accountVariable = new AccountVariable();
			$variableName = 'tournamentChips';
			$varData = $accountVariable->getData($playerId, $variableName);
			$tournamentChips = $varData['varValue'];
			switch($level)
			{
				case '1':
					if($tournamentChips < 4000)
					{
						$tournamentChips = 4000;
					}
					break;
				case '2':
					if($tournamentChips < 5000)
					{
						if($accountDetails[0]['cash'] >= 10)
						{
							$placeWager = $this->placeWager($playerId, 10);
							$tournamentChips = 5000;
						}
						else
						{
							$enabledRegistartion = false;
						}
					}
					break;
				case '3':
					if($tournamentChips < 6500)
					{
						if($accountDetails[0]['cash'] >= 50)
						{
							$placeWager = $this->placeWager($playerId, 50);
							$tournamentChips = 6500;
						}
						else
						{
							$enabledRegistartion = false;
						}
					}
					break;
			}

			if($enabledRegistartion && $placeWager)
			{
				$tourneyRegistration = new TourneyRegistrations();
				$status = $tourneyRegistration->registerPlayer($tourneyId, $playerId, $frontendId, $tournamentChips, 'LEVEL-' . $level);
				//$status=0;
				if($level < 1)
				{
					$status = 0;
				}
				if($status == 0)
				{
					$this->view->status = "NOT_REGISTERED";
					$this->view->message="No more registrations are accepted now!";
				}
				elseif($status == 1)
				{
					$filePath = APPLICATION_PATH . '/site_configs/rum/tournament_registration.html';
                	                $fh = fopen($filePath, 'r');
                        	        $fileContent = fread($fh, filesize($filePath));
                                	$session = new Zend_Auth_Storage_Session();
	                                $store = $session->read();
        	                        $loginName = $store['authDetails'][0]['login'];
                	                $firstName = $store['authDetails'][0]['first_name'];
                        	        $email = $store['authDetails'][0]['email'];
                                	$name = empty($firstName)?$loginName:$firstName;
	                                $fileContent = str_replace('#name#', $name, $fileContent);
					$fileContent = str_replace('#email#', $email, $fileContent);
                	                $mail = new Mail();
                        	        $mail->sendMails('Registration', $fileContent, $fileContent, $email);

					$this->view->status = "REGISTERED";
					$this->view->message="Thank you for registering to the tournament. The tournament should start at 9:00PM on Shivratri. Good luck!";
				}
				elseif($status == 2)
				{
					$this->view->status = "ALREADY_REGISTERED";
					$this->view->message="You are already registered. Please wait before the tournament begins on Shivratri";
				}
				else
				{
					$this->view->status = "UNKNOWN";
					$this->view->message="Something went wrong!";
				}
			}
			else
			{
				$this->view->status = "UNKNOWN";
				$this->view->message="You don't have enough balance to register for tournament, please deposit!";
			} */
		}
	}
	public function placeWager($playerId, $amount)
	{
		$playerTransactions = new PlayerTransactions();
		$sourceId = $playerTransactions->placeWager($playerId, $amount);
		
		if(!$sourceId)
		{
			return false;
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
			return false;
		}
		if(($reportMessage['processed'] == 'PROCESSED') && ($reportMessage['error'] == 'NOERROR'))
		{
			return true;
		}
		elseif($counter != 3)
		{
			return false;
		}
	}

	public function currentAction()
	{
		//echo "in current";
		//Zend_Layout::getMvcInstance()->disableLayout();
		$tournamentId = $this->getRequest()->tournamentId;
		//$requestType = $this->getRequest()->requestType;
		if(!$tournamentId)
		{
			$this->_redirect('/tournament/list');
		}
		
		$session = new Zenfox_Auth_Storage_Session();
		$storedData = $session->read();
		$playerId = $storedData['id'];
		
		$levelId = -1;
		
		$tournament = new Tournaments();
		$tournamentDetail = $tournament->getTournamentById($tournamentId);
		$tournamentConfigId = $tournamentDetail['tournament_config_id'];
		$tournamentConfig = new TournamentConfig();
		$tournamentConfigData = $tournamentConfig->getTournamentDetails($tournamentConfigId);
		$configArray = Zend_Json::decode($tournamentConfigData['config']);
		
		$elgCriteriaArr = array();
		$amountArray = array();
		$entryFee = "";
		
		$onlineTournament = new OnlineTournaments();
		$onlineDetails = $onlineTournament->getOnlineDetails($tournamentId);
		$tournamentState = $onlineDetails['tournament_state'];
		$currentLevel = $onlineDetails['current_tier_id'] ? $onlineDetails['current_tier_id'] : -1;
		
		
		foreach($configArray as $configData)
		{
			$timeGap = 0;
			foreach($configData as $configuration)
			{
				$eligibilityCriteria = $configuration['eligibilityCriteria'][0]['amount'];
				$amount = $configuration['buyinCost'][0]['amount'];
				if($configuration['buyinCost'][0]['amountType'] == 'FREE')
				{
					$amount = 'FREE';
				}
				$elgCriteriaArr[$configuration['level']] = $configuration['eligibilityCriteria'][0]['amount'];
				$amountArray[$configuration['level']] = $amount;
			}
		}
		$entryFee = implode('|', $elgCriteriaArr);
		$amount = implode('|', $amountArray);
		
		if($playerId)
		{
			$tournamentRegistration = new TournamentRegistrations();
			$registeredLevel = $tournamentRegistration->getRegisteredLevel($playerId, $tournamentId);
			
			if($registeredLevel)
			{
				/* $explodeRegisteredLevel = explode('-', $registeredLevel);
				$levelId = $explodeRegisteredLevel[1]; */
				$levelId = $registeredLevel;
			}
			if($currentLevel)
			{
				$data['error'] = 0;
				$data['currentLevel'] = $currentLevel;
				$data['tournamentId'] = $tournamentId;
				$data['noOfLevels'] = count($configArray['tiers']);
				$data['levelId'] = $levelId;
				$data['entryFee'] = $entryFee;
				$data['amount'] = $amount;
				$data['tournamentState'] = $tournamentState;
				$string = "error=0&currentLevel=".$currentLevel . "&tournamentId=" . $tournamentId . 
					"&noOfLevels=" . count($configArray['tiers']) . "&levelId=" . $levelId . "&entryFee=" . $entryFee . "
					&amount=" . $amount . "&tournamentState=" . $tournamentState;
			}
			else
			{
				echo "error=1" ;
			}
		}
		else
		{
			$data['error'] = 1;
			$data['msg'] = "You are not logged in. Please login first!!";
			$string = "error=1&msg=You are not logged in. Please login first!!";
		}
		
		if($this->getRequest()->format == 'json')
		{
			$this->view->tournamentDetails = $data; 
		}
		else
		{
			Zend_Layout::getMvcInstance()->disableLayout();
			echo $string;
		}
	}
	
	public function listAction()
	{
		$this->view->homePage = $this->getRequest()->home;
		$session = new Zenfox_Auth_Storage_Session();
		$storedData = $session->read();
		$this->view->loggedIn = false;
		if($storedData)
		{
			$this->view->loggedIn = true;
		}
		$tournaments = new Tournaments();
		$tournamentsList = $tournaments->getTournamentsList();
		$currentTournaments = array();
		$upcomingTournaments = array();
		$completedTournaments = array();
		if($tournamentsList)
		{
			foreach($tournamentsList as $tournament)
			{
				switch($tournament['Status'])
				{
					case 'STARTED':
						$currentTournaments[] = $tournament;
						break;
					default:
						$upcomingTournaments[] = $tournament;
					break;
				}
			}
			$this->view->currentTournamentsList = $currentTournaments;
			//$this->view->completedTournamentsList = array_reverse($completedTournaments);
			$this->view->upcomingTournamentsList = $upcomingTournaments;
			$this->view->tournaments = true;
		}
		else
		{
			$message = "Hi There! The Tournaments page is getting upgraded! Please be patient for an exceptional Online Rummy experience. " .
								"Please check the page after some time. ";
			$this->_helper->FlashMessenger(array('notice' => $this->view->translate($message)));
			$this->view->tournaments = false;
		}
		$offset = $this->getRequest()->page ? $this->getRequest()->page : 1;
		$itemsPerPage = $this->getRequest()->items ? $this->getRequest()->items : 10;
		$completedTournaments = $tournaments->getCompletedTournaments($offset, $itemsPerPage);
		if($completedTournaments)
		{
			$this->view->completedTournamentsList = $completedTournaments['tournamentsList'];
			$this->view->paginator = $completedTournaments['paginator'];
		}
		//Zenfox_Debug::dump($completedTournaments, 'current');
	}
	
	public function descAction()
	{
		$session = new Zenfox_Auth_Storage_Session();
		$storedData = $session->read();
		$this->view->loggedIn = false;
		if($storedData)
		{
			$this->view->loggedIn = true;
		}
		
		$tournamentId = $this->getRequest()->tournamentId;
		$tournament = new Tournaments();
		$tournamentDetail = $tournament->getTournamentById($tournamentId);
		$tournamentConfigId = $tournamentDetail['tournament_config_id'];
		$tournamentConfig = new TournamentConfig();
		$tournamentConfigData = $tournamentConfig->getTournamentDetails($tournamentConfigId);
		$rewardArray = Zend_Json::decode($tournamentConfigData['rewards']);
		
		$configArray = Zend_Json::decode($tournamentConfigData['config']);
		$explodeTime = explode(" ", $tournamentDetail['start_time']);
		$tournamentStartDate = date('d-M-Y',strtotime($explodeTime[0]));

		$tournamentConfiguration = array();
		foreach($configArray as $configData)
		{
			$timeGap = 0;
			foreach($configData as $configuration)
			{
				$tournamentConfiguration[$configuration['level']]['eligibilityCriteria'] = $configuration['eligibilityCriteria'][0]['amount'];
				$amount = $configuration['buyinCost'][0]['amount'];
				$duration = $configuration['duration'];
				if($configuration['buyinCost'][0]['amountType'] == 'FREE')
				{
					$amount = 'FREE';
					$tournamentStartTime = date('g:i a', strtotime($explodeTime[1]));
				}
				else
				{
					$tournamentStartTime = date('g:i a', strtotime("$explodeTime[1], + $timeGap SEC"));
				}
				$timeDuration = $timeGap + $duration;
				$tournamentEndTime = date('g:i a', strtotime("$explodeTime[1], + $timeDuration Sec"));
				$timeGap += $configuration['duration'] + $configuration['break'];
				
				$tournamentConfiguration[$configuration['level']]['entryFee'] = $amount;
				$tournamentConfiguration[$configuration['level']]['startTime'] = $tournamentStartTime; 
				$tournamentConfiguration[$configuration['level']]['endTime'] = $tournamentEndTime;
				$tournamentConfiguration[$configuration['level']]['amountType'] = $configuration['buyinCost'][0]['amountType'];
			}
		}

		$resultDuration = $timeDuration+1800;
		$resultDisplayTime = date('g:i a', strtotime("$explodeTime[1], + $resultDuration Sec"));
		$this->view->tournamentId = $tournamentId;
		$this->view->startDate = $tournamentStartDate;
		$this->view->rewards = $rewardArray['rewards'];
		$this->view->tournamentName = $tournamentDetail['tournament_name'];
		$this->view->configuration = $tournamentConfiguration;
		$this->view->resultDisplayTime = $resultDisplayTime;
		$this->view->status = $tournamentDetail['status'];
	}

	public function resultAction()
	{
		$tournamentId = $this->getRequest()->tournamentId;
		$tournament = new Tournaments();
		$tournamentDetail = $tournament->getTournamentById($tournamentId);
		$tournamentConfigId = $tournamentDetail['tournament_config_id'];
		$tournamentConfigId = 5;
		$tournamentConfig = new TournamentConfig();
		$tournamentConfigData = $tournamentConfig->getTournamentDetails($tournamentConfigId);
		
		$configArray = Zend_Json::decode($tournamentConfigData['config']);
		$explodeTime = explode(" ", $tournamentDetail['start_time']);
		$tournamentStartDate = date('d-M-Y',strtotime($explodeTime[0]));
		$tournamentStartTime = date('g:i a', strtotime($explodeTime[1]));
		foreach($configArray as $configData)
		{
			$timeGap = 0;
			foreach($configData as $configuration)
			{
				$duration = $configuration['duration'];
				
				$timeDuration = $timeGap + $duration;
				$tournamentEndTime = date('g:i a', strtotime("$explodeTime[1], + $timeDuration Sec"));
				$timeGap += $configuration['duration'] + $configuration['break'];
			}
		}
		
		$rewardArray = Zend_Json::decode($tournamentConfigData['rewards']);
		$consolationArray = $rewardArray['consolationRewards'];
		$noOfConsolationPrizes = $consolationArray['numberOfRewards'];
		$consolationAmountType = $consolationArray['rewards'][1][0]['amountType'];
		$consolationAmount = $consolationArray['rewards'][1][0]['amount'];

		$noOfTopWinners = count($rewardArray['rewards']);
		$ranks = $noOfConsolationPrizes + $noOfTopWinners;
		
		$topWinners = array();
		$consolationWinners = array();
		$tournamentFinalResult = new TournamentFinalResults();
		$results = $tournamentFinalResult->getTournamentResult($tournamentId, $ranks);

		foreach($results as $tournamentResult)
		{
			if($tournamentResult['rank'] <= $noOfTopWinners)
			{
				$topWinners[] = $tournamentResult;
			}
			else
			{
				$consolationWinners[] = $tournamentResult;
			}
		}
		$newTopWinnerList = array();
		$newTopWinnerList = $this->_sortWinnerList($topWinners, 1, $newTopWinnerList);
		$player = new Player();
		$finalWinnerList = array();
		$finalConsolationWinners = array();
		$index = 0;
		foreach($newTopWinnerList as $winnerList)
		{
			$playerName = $player->getPlayerName($winnerList['player_id']);
			$prizeArray = Zend_Json::decode($winnerList['rewards']);
			$finalWinnerList[$index][$winnerList['rank']]['playerName'] = $playerName;
			$finalWinnerList[$index][$winnerList['rank']]['amount'] = $prizeArray['rewards'][0]['amount'];
			$finalWinnerList[$index][$winnerList['rank']]['amountType'] = $prizeArray['rewards'][0]['amountType'];
			$index++;
		}
		$index = 0;
		foreach($consolationWinners as $winnerList)
		{
			$playerName = $player->getPlayerName($winnerList['player_id']);
			$prizeArray = Zend_Json::decode($winnerList['rewards']);
			$finalConsolationWinners[$index][$winnerList['rank']]['playerName'] = $playerName;
			$index++;
			/* $finalConsolationWinners[$winnerList['rank']]['amount'] = $prizeArray[0]['amount'];
			$finalConsolationWinners[$winnerList['rank']]['amountType'] = $prizeArray[0]['amountType']; */
		}

		$this->view->winnerList = $finalWinnerList;
		$this->view->consolationWinner = $finalConsolationWinners;
		$this->view->consolationAmountType = $consolationAmountType;
		$this->view->consolationAmount = $consolationAmount;
		$this->view->tournamentStartDate = $tournamentStartDate;
		$this->view->tournamentStartTime = $tournamentStartTime;
		$this->view->tournamentEndTime = $tournamentEndTime;
		$this->view->tournamentName = $tournamentDetail['tournament_name'];
	}
	
	private function _sortWinnerList($winnersList, $index, $newWinnerList)
	{
		foreach($winnersList as $winners)
		{
			if($index == $winners['rank'])
			{
				$newWinnerList[] = $winners;
			}
		}
		if(count($newWinnerList) < count($winnersList))
		{
			$index++;
			$newWinnerList = $this->_sortWinnerList($winnersList, $index, $newWinnerList);
		}
		return $newWinnerList;
	}
}
