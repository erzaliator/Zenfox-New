<?php

require_once dirname(__FILE__) . '/../forms/DateSelectionForm.php';
require_once dirname(__FILE__) . '/../forms/FrontendSelectForm.php';
require_once dirname(__FILE__).'/../forms/UserForm.php';
//require_once APPLICATION_PATH . '/modules/player/models/PlayerGamelog.php';

class Admin_RummyreportController extends Zend_Controller_Action
{
	public function indexAction()
	{
		$player = new Player();
		
		$form = new Admin_DateSelectionForm();
		$this->view->form = $form;
		$authSession = new Zend_Auth_Storage_Session();
		$sessionData = $authSession->read();
		$csrId = $sessionData['id'];
		$sessionName = 'Searching_' . $csrId;
		$session = new Zend_Session_Namespace($sessionName);
		$offset = $this->getRequest()->pages;
		if($offset)
		{
			$itemsPerPage = $this->getRequest()->item;
			$fromDate = $this->getRequest()->from;
			//$fromDate = date ("Y-m-d H:i:s", strtotime("$fromTime, - 5 HOUR 30 MINUTE"));
			
			$toDate = $this->getRequest()->to;
			//$toDate = date ("Y-m-d H:i:s", strtotime("$toTime, - 5 HOUR 30 MINUTE"));

			$playerData = $player->getAllRegistrations($offset, $itemsPerPage, $session, $fromDate, $toDate);
			$contents = $this->_getPlayerReport($playerData[1], $fromDate, $toDate);
				
			$this->view->paginator = $playerData[0];
			$this->view->contents = $contents;
			$this->view->fromDate = $fromDate;
			$this->view->toDate = $toDate;
		}
		
		if($this->getRequest()->isPost())
		{
			if($form->isValid($_POST))
			{
				$session->unsetAll();
				$offset = 1;
				$data = $form->getValues();
				
				$fromDate = $data['from_date'] . ' ' . $data['from_time'];
				//$fromDate = date ("Y-m-d H:i:s", strtotime("$fromTime, - 5 HOUR 30 MINUTE"));

				$toDate = $data['to_date'] . ' ' . $data['to_time'];
				//$toDate = date ("Y-m-d H:i:s", strtotime("$toTime, - 5 HOUR 30 MINUTE"));

				$itemsPerPage = $data['items'];
				$playerData = $player->getAllRegistrations($offset, $itemsPerPage, $session, $fromDate, $toDate);
				$contents = $this->_getPlayerReport($playerData[1], $fromDate, $toDate);
				
				$this->view->paginator = $playerData[0];
				$this->view->contents = $contents;
				$this->view->fromDate = $fromDate;
				$this->view->toDate = $toDate;
			}
		}
	}
	
	private function _getPlayerReport($playerData, $fromDate, $toDate)
	{
		$auditReport = new AuditReport();
		$playerGamelog = new PlayerGamelog();
		$currency = new Zenfox_Currency();
		
		$index = 0;
		$contents = array();
				
		foreach($playerData as $playerDetail)
		{
			$playerId = $playerDetail['Player Id'];
			$auditData = $auditReport->getTransactionByPlayerId($playerId, $fromDate, $toDate);
			$totalGames = $playerGamelog->getTotalGames($playerId, $fromDate, $toDate);
			$totalWins = $playerGamelog->getNumberOfWins($playerId, $fromDate, $toDate);
			
			$contents[$index]['Player Id'] = $playerId;
			$contents[$index]['Login Name'] = $playerDetail['User Name'];
			$contents[$index]['Player Name'] = $playerDetail['Player Name'];
			$contents[$index]['Email'] = $playerDetail['Email'];
			$contents[$index]['Join Date'] = $playerDetail['Join Date'];
			$contents[$index]['Total Wager'] = $currency->setCurrency('INR', $auditData['totalWagers']);
			$contents[$index]['Total Winning'] = $currency->setCurrency('INR', $auditData['totalWinnings']);
			$contents[$index]['Total No Of Games'] = $totalGames;
			$contents[$index]['Total No Of Wins'] = $totalWins;
			$index++;
		}
		
		return $contents;
	}
	
	public function winnerAction()
	{
		$form = new Admin_DateSelectionForm();
		$this->view->form = $form;
		$authSession = new Zend_Auth_Storage_Session();
		$sessionData = $authSession->read();
		$csrId = $sessionData['id'];
		$sessionName = 'Searching_' . $csrId;
		$session = new Zend_Session_Namespace($sessionName);
		$offset = $this->getRequest()->pages;
		$playerGamelog = new PlayerGamelog();
		if($offset)
		{
			$itemsPerPage = $this->getRequest()->item;
			$fromDate = $this->getRequest()->from;			
			$toDate = $this->getRequest()->to;

			$playerGamelogData = $playerGamelog->getWinners($offset, $itemsPerPage, $session, $fromDate, $toDate);
				
			$this->view->paginator = $playerGamelogData[0];
			$this->view->contents = $playerGamelogData[1];
			$this->view->fromDate = $fromDate;
			$this->view->toDate = $toDate;
		}
		if($this->getRequest()->isPost())
		{
			if($form->isValid($_POST))
			{
				$session->unsetAll();
				$offset = 1;
				$data = $form->getValues();
				
				$fromDate = $data['from_date'] . ' ' . $data['from_time'];
				$toDate = $data['to_date'] . ' ' . $data['to_time'];

				$itemsPerPage = $data['page'];
				$playerGamelogData = $playerGamelog->getWinners($offset, $itemsPerPage, $session, $fromDate, $toDate);
				
				$this->view->paginator = $playerGamelogData[0];
				$this->view->contents = $playerGamelogData[1];
				$this->view->fromDate = $fromDate;
				$this->view->toDate = $toDate;
			}
		}
	}
	
	public function registrationAction()
	{
		$authSession = new Zend_Auth_Storage_Session();
		$sessionData = $authSession->read();
		$csrId = $sessionData['id'];
		$sessionName = 'Searching_' . $csrId;
		$session = new Zend_Session_Namespace($sessionName);
		
		$player = new Player();
	 	$form = new Admin_DateSelectionForm();
       	$this->view->form = $form;
        $offset = $this->getRequest()->page;
        
		if($this->getRequest()->isPost())
        {
        	if($form->isValid($_REQUEST))
        	{
        		$session->unsetAll();
        		$data = $form->getValues();
        		
        		$start = $_REQUEST["start"]?$_REQUEST["start"]:0;
        		$offset = $start/$data['items'] + 1 ;
        		
        		$from_date = $data['from_date'] . ' ' . $data['from_time'];
				//$from_date = date ("Y-m-d H:i:s", strtotime("$fromTime, - 5 HOUR 30 MINUTE"));

				$to_date = $data['to_date'] . ' ' . $data['to_time'];
				//$to_date = date ("Y-m-d H:i:s", strtotime("$toTime, - 5 HOUR 30 MINUTE"));
				
				$accountType = $data['accountType'];
				if($accountType == 'uconfirmed')
				{
					$playersData = $player->getUnconfirmPlayers($offset, $data['items'], $session, $from_date, $to_date, $data['frontend']);
				}
				else
				{
					$playersData = $player->getAllRegistrations($offset, $data['items'], $session, $from_date, $to_date, $data['frontend']);
				}
        		
        		if(!$playersData)
        		{
        			echo "No record found";
        		}
        		
        		else
        		{
			        $this->view->paginator = $playersData[0];
			        $this->view->from = $from_date;
			        $this->view->to = $to_date;
			        $this->view->contents = $playersData[1];
			        $this->view->frontendId = $data['frontend'];
			        $this->view->accountType = $accountType;
        		}
        	}
        }
		elseif($offset)
        {
        	$itemsPerPage = $this->getRequest()->item;
        	$frontendId = $this->getRequest()->frontendId;
        	$accountType = $this->getRequest()->accountType;
        	
        	$from_date = $this->getRequest()->from;
			//$from_date = date ("Y-m-d H:i:s", strtotime("$fromTime, - 5 HOUR 30 MINUTE"));
			
			$to_date = $this->getRequest()->to;
			//$to_date = date ("Y-m-d H:i:s", strtotime("$toTime, - 5 HOUR 30 MINUTE"));
			
			if($accountType == 'uconfirmed')
			{
				$playersData = $player->getUnconfirmPlayers($offset, $itemsPerPage, $session, $from_date, $to_date, $frontendId);
			}
        	else
        	{
        		$playersData = $player->getAllRegistrations($offset, $itemsPerPage, $session, $from_date, $to_date, $frontendId);
        	}
        	if(!$playersData)
        	{
        		$this->_redirect('/error/error');
        	}

        	$this->view->paginator = $playersData[0];
        	$this->view->contents = $playersData[1];
        	$this->view->from = $from_date;
		    $this->view->to = $to_date;
		    $this->view->frontendId = $frontendId;
		    $this->view->accountType = $accountType;
        }
	}
	
	public function depositorAction()
	{
		$authSession = new Zend_Auth_Storage_Session();
		$sessionData = $authSession->read();
		$csrId = $sessionData['id'];
		$sessionName = 'Searching_' . $csrId;
		$session = new Zend_Session_Namespace($sessionName);
		
		$player = new Player();
	 	$form = new Admin_DateSelectionForm();
       	$this->view->form = $form;
        $offset = $this->getRequest()->page;
        
		if($this->getRequest()->isPost())
        {
        	if($form->isValid($_REQUEST))
        	{
        		$session->unsetAll();
        		$data = $form->getValues();
        		$start = $_REQUEST["start"]?$_REQUEST["start"]:0;
        		$offset = $start/$data['items'] + 1 ;
        		
        		$from_date = $data['from_date'] . ' ' . $data['from_time'];
				//$from_date = date ("Y-m-d H:i:s", strtotime("$fromTime, - 5 HOUR 30 MINUTE"));

				$to_date = $data['to_date'] . ' ' . $data['to_time'];
				//$to_date = date ("Y-m-d H:i:s", strtotime("$toTime, - 5 HOUR 30 MINUTE"));
        		
        		$playersData = $player->getAllDepositors($offset, $data['items'], $session, $from_date, $to_date);
        		
        		if(!$playersData)
        		{
        			echo "No record found";
        		}
        		
        		else
        		{
			        $this->view->paginator = $playersData[0];
			        $this->view->from = $from_date;
			        $this->view->to = $to_date;
			        $this->view->contents = $playersData[1];
        		}
        	}
        }
		elseif($offset)
        {
        	$itemsPerPage = $this->getRequest()->item;
        	
        	$from_date = $this->getRequest()->from;
			//$from_date = date ("Y-m-d H:i:s", strtotime("$fromTime, - 5 HOUR 30 MINUTE"));
			
			$to_date = $this->getRequest()->to;
			//$to_date = date ("Y-m-d H:i:s", strtotime("$toTime, - 5 HOUR 30 MINUTE"));
			
        	$playersData = $player->getAllDepositors($offset, $itemsPerPage, $session, $from_date, $to_date);
        	if(!$playersData)
        	{
        		$this->_redirect('/error/error');
        	}

        	$this->view->paginator = $playersData[0];
        	$this->view->contents = $playersData[1];
        	$this->view->from = $from_date;
		    $this->view->to = $to_date;
        }
	}
	
	public function gamehistoryAction()
	{
		$authSession = new Zend_Auth_Storage_Session();
		$sessionData = $authSession->read();
		$csrId = $sessionData['id'];
		$csrfrontendids = $sessionData['frontend_ids'];
		$sessionName = 'Searching_' . $csrId;
		$session = new Zend_Session_Namespace($sessionName);
		
		$form = new Admin_DateSelectionForm();
		$this->view->form = $form;
		
		$offset = $this->getRequest()->page;
        $playerGamelog = new PlayerGamelog();
		
		if($this->getRequest()->isPost())
		{
			if($form->isValid($_POST))
			{
				$data = $form->getValues();
				$fromTime = $data['from_date'] . ' ' . $data['from_time'];
				$toTime = $data['to_date'] . ' ' . $data['to_time'];

				$player = new Player();
				$playerfrontendid = $player->getfrontendidofplayer($data['playerId']);
		
				if (in_array($playerfrontendid,$csrfrontendids))
 				{
						$playersGameHistory = $playerGamelog->getGameHistory(1, $data['items'], $session, $fromTime, $toTime, $data['playerId']);
						if(!$playersGameHistory)
        				{
        					echo "No record found";
        				}
        				else
        				{
			    		    $this->view->paginator = $playersGameHistory[0];
			    		    $this->view->contents = $playersGameHistory[1];
			     			   $this->view->totalGames = $playersGameHistory[2];
			     			   $this->view->from = $fromTime;
			       			 $this->view->to = $toTime;
			       			 $this->view->playerId = $data['playerId'];
        				}
 				}
 				else
 				{
 					$this->_helper->FlashMessenger(array('error' => "you can't get data for this player"));
 				}
			}
		}
		elseif($offset)
        {
        	$itemsPerPage = $this->getRequest()->item;
        	
        	$fromTime = $this->getRequest()->from;			
			$toTime = $this->getRequest()->to;
			$playerId = $this->getRequest()->playerId;
			$totalGames = $this->getRequest()->totalGames;
			
			$player = new Player();
			$playerfrontendid = $player->getfrontendidofplayer($playerId);
		
			if (in_array($playerfrontendid,$csrfrontendids))
 			{
        		$playersGameHistory = $playerGamelog->getGameHistory($offset, $itemsPerPage, $session, $fromTime, $toTime, $playerId);
        		if(!$playersGameHistory)
        		{
        			$this->_redirect('/error/error');
        		}

        		$this->view->paginator = $playersGameHistory[0];
        		$this->view->totalGames = $totalGames;
        		$this->view->contents = $playersGameHistory[1];
        		$this->view->from = $fromTime;
		   		$this->view->to = $toTime;
		  		$this->view->playerId = $playerId;
 			}
        	else
 				{
 					$this->_helper->FlashMessenger(array('error' => "you can't get data for this player"));
 				}
 			
        }
	}
	
	public function transactionAction()
	{
		$authSession = new Zend_Auth_Storage_Session();
		$sessionData = $authSession->read();
		$csrId = $sessionData['id'];
		$csrfrontendids = $sessionData['frontend_ids'];
		$sessionName = 'Searching_' . $csrId;
		$session = new Zend_Session_Namespace($sessionName);
		$player = new Player();
		
		$form = new Admin_DateSelectionForm();
		$this->view->form = $form;
		
		$offset = $this->getRequest()->page;
		if($this->getRequest()->isPost())
		{
			if($form->isValid($_POST))
			{
				$data = $form->getValues();
				
				$fromTime = $data['from_date'] . ' ' . $data['from_time'];
				//$fromTime = date ("Y-m-d H:i:s", strtotime("$from, - 5 HOUR 30 MINUTE"));
				
				$toTime = $data['to_date'] . ' ' . $data['to_time'];
				//$toTime = date ("Y-m-d H:i:s", strtotime("$to, - 5 HOUR 30 MINUTE"));
				$playerTransactionRecord = new PlayerTransactionRecord($data['playerId']);
				
				$playerfrontendid = $player->getfrontendidofplayer($data['playerId']);
		
				if (in_array($playerfrontendid,$csrfrontendids))
 				{
        			$transactionData = $playerTransactionRecord->getplayerfailedtransactions($data["playerId"] ,$data["paymentmethod"],$fromTime, $toTime, 1, $data['items']);
 					if(!$transactionData)
        			{
        				$this->_helper->FlashMessenger(array('error' => "no records found"));
        			}

					$this->view->paginator = $transactionData[0];
					$this->view->contents = $transactionData[1];
					$this->view->from = $fromTime;
					$this->view->to = $toTime;
					$this->view->playerid = $data['playerId'];
					$this->view->paymentmethod = $data['paymentmethod'];
 				}
        		else
 				{
 					$this->_helper->FlashMessenger(array('error' => "you can't get data for this player"));
 				}
				
			}
		}
		elseif($offset)
		{
			$itemsPerPage = $this->getRequest()->item;
			$fromTime = $this->getRequest()->from;
			$toTime = $this->getRequest()->to;
			$playerid = $this->getRequest()->playerid;
			$paymentmethod = $this->getRequest()->paymentmethod;
				
			$playerfrontendid = $player->getfrontendidofplayer($playerid);
			$playerTransactionRecord = new PlayerTransactionRecord($playerid);
		
				if (in_array($playerfrontendid,$csrfrontendids))
 				{
					$transactionData = $playerTransactionRecord->getplayerfailedtransactions($playerid ,$paymentmethod,$fromTime, $toTime, $offset,$itemsPerPage);
 					 if(!$transactionData)
        			{
        				$this->_redirect('/error/error');
        			}

					$this->view->paginator = $transactionData[0];
					$this->view->contents = $transactionData[1];
					$this->view->from = $fromTime;
					$this->view->to = $toTime;
					$this->view->playerid = $playerid;
					$this->view->paymentmethod = $paymentmethod;
 				}
        		else
 				{
 					$this->_helper->FlashMessenger(array('error' => "you can't get data for this player"));
 				}	
				
		}
	}
	
	public function gamelogAction()
	{
		$authSession = new Zend_Auth_Storage_Session();
		$sessionData = $authSession->read();
		$csrId = $sessionData['id'];
		$csrfrontendids = $sessionData['frontend_ids'];
		$player = new Player();
		
		$form = new Admin_DateSelectionForm();
		$this->view->form = $form;
		
		$offset = $this->getRequest()->page;
	
		$playerGamelog = new PlayerGamelog();
		if($this->getRequest()->isPost())
		{
			if($form->isValid($_POST))
			{
				$data = $form->getValues();
				
				$offset = 1;
				$fromDate = $data['from_date'] . ' ' . $data['from_time'];
				$toDate = $data['to_date'] . ' ' . $data['to_time'];
				$playerId = $data['playerId'];
				
				$playerfrontendid = $player->getfrontendidofplayer($data['playerId']);
		
				if (in_array($playerfrontendid,$csrfrontendids))
 				{
					$result = $playerGamelog->getPlayerGamelogDetails($playerId, $data['items'], $offset, $fromDate, $toDate);
 					if(!$result)
        			{
						$this->_helper->FlashMessenger(array('error' => 'No record found.'));
        			}

					$this->view->paginator = $result[0];
					$this->view->contents = $result[1];
					$this->view->from = $fromDate;
					$this->view->to = $toDate;
					$this->view->playerId = $playerId;
 				}
        		else
 				{
 					$this->_helper->FlashMessenger(array('error' => "you can't get data for this player"));
 				}
			
			}
		}
		elseif($offset)
		{
			$itemsPerPage = $this->getRequest()->item;
			
			$fromDate = $this->getRequest()->from;
			$toDate = $this->getRequest()->to;
			$playerId = $this->getRequest()->playerId;
			
			$playerfrontendid = $player->getfrontendidofplayer($playerId);
			
				if (in_array($playerfrontendid,$csrfrontendids))
 				{
					$result = $playerGamelog->getPlayerGamelogDetails($playerId, $itemsPerPage, $offset, $fromDate, $toDate);
 					  if(!$result)
        			{
        				$this->_redirect('/error/error');
        			}

					$this->view->paginator = $result[0];
					$this->view->contents = $result[1];
					$this->view->from = $fromDate;
					$this->view->to = $toDate;
					$this->view->playerId = $playerId;
 				}
        		else
 				{
 					$this->_helper->FlashMessenger(array('error' => "you can't get data for this player"));
 				}	
		}
	}
	
	public function regularAction()
	{
		$form = new Admin_DateSelectionForm();
		$this->view->form = $form;
		
		$offset = $this->getRequest()->page;
		$playerGamelog = new PlayerGamelog();
		
		$authSession = new Zend_Auth_Storage_Session();
		$sessionData = $authSession->read();
		$csrId = $sessionData['id'];
		$sessionName = 'Searching_' . $csrId;
		$session = new Zend_Session_Namespace($sessionName);
		
		if($this->getRequest()->isPost())
		{
			if($form->isValid($_POST))
			{
				$data = $form->getValues();
				$session->unsetAll();

				$offset = 1;
				$fromDate = $data['from_date'] . ' ' . $data['from_time'];
				$toDate = $data['to_date'] . ' ' . $data['to_time'];
				$playerId = $data['playerId'];
				
				$result = $playerGamelog->getGameHistory(1, $data['items'], $session, $fromDate, $toDate, "", $data['frontend']);
				if(!$result)
				{
					$this->_helper->FlashMessenger(array('error' => 'No record found.'));
				}

				$this->view->paginator = $result[0];
				$this->view->contents = $result[1];
				$this->view->from = $fromDate;
				$this->view->to = $toDate;
				$this->view->frontendId = $data['frontend'];
			}
		}
		elseif($offset)
		{
			$itemsPerPage = $this->getRequest()->item;
			
			$fromTime = $this->getRequest()->from;
			$toTime = $this->getRequest()->to;
			$frontendId = $this->getRequest()->frontendId;
			$result = $playerGamelog->getGameHistory($offset, $itemsPerPage, $session, $fromTime, $toTime, "", $frontendId);
			
			$this->view->paginator = $result[0];
			$this->view->contents = $result[1];
			$this->view->from = $fromTime;
			$this->view->to = $toTime;
			$this->view->frontendId = $frontendId;
		}
	}
	
	public function logAction()
	{
		Zend_Layout::getMvcInstance()->setLayout('popup_layout');

         $playerId = $this->getRequest()->playerId;
                $sessionId = $this->getRequest()->sessId;
                $gameId = $this->getRequest()->gameId;
                $flavour = $this->getRequest()->flavour;

                $this->view->gameId = $gameId;
                $this->view->sessionId = $sessionId;
                $this->view->flavour = $flavour;
                $this->view->playerId = $playerId;
		
	}
	
	public function onlineAction()
	{
		$playerSessions = new PlayerSessions();
		$allSessions = $playerSessions->getfrontendwisesessions();
		
		if($allSessions)
		{
			$this->view->sessions = $allSessions;
		}
		else
		{
			$this->_helper->FlashMessenger(array('error' => 'No Sessions found.'));
		}
		
		$form = new Admin_FrontendSelectForm();
		$this->view->form = $form->getform();
		
		if($this->getRequest()->isPost())
		{
			if($form->isValid($_POST))
			{
				$postdata = $form->getValues();
				$data = $playerSessions->getfrontendsessions($postdata["frontend_id"]);
				
				if($data)
				{
					$this->view->data = $data;
				}
				else
				{
					$this->_helper->FlashMessenger(array('error' => 'No Sessions found in the frontend you selected'));
				}
			
				
			}
		}
		
		
		
		
		
	}
}