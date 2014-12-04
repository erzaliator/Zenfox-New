<?php

require_once dirname(__FILE__) . '/../forms/DateForm.php';
class Partner_ReportController extends Zend_Controller_Action
{
	public function init()
	{
		parent::init();
	}
	
	public function registrationsAction()
	{
		$dateForm = new Partner_DateForm();
		$this->view->dateForm = $dateForm;
		
		$offset = $this->getRequest()->page;
		$player = new Player();
		
		$authSession = new Zenfox_Auth_Storage_Session();
		$sessionData = $authSession->read();
		
		$partnerFrontendId = $sessionData['authDetails'][0]['partner_frontend_id'];
		$partnerId = $sessionData['id'];
		
		$partnerFrontends = new PartnerFrontends();
		$frontendData = $partnerFrontends->getFrontendData($partnerFrontendId);
		
		$allowedFrontendIds = $frontendData['allowed_frontend_ids'];
		$sessionName = 'Searching_' . $partnerId;
		$session = new Zend_Session_Namespace($sessionName);
		
		if($this->getRequest()->isPost())
		{
			if($dateForm->isValid($_POST))
			{
				$offset = 1;
				$data = $dateForm->getValues();
		
				$from_date = $data['from_date'] . ' ' . $data['from_time'];
				$to_date = $data['to_date'] . ' ' . $data['to_time'];
				$playersData = $player->getAllRegistrations($offset, $data['items'], $session, $from_date, $to_date, $allowedFrontendIds);
		
				if(!$playersData[1])
				{
					echo "No record found";
				}
			}
		}
		elseif($offset)
		{
			$itemsPerPage = $this->getRequest()->item;
			$from_date = $this->getRequest()->from;	
			$to_date = $this->getRequest()->to;
				
			$playersData = $player->getAllRegistrations($offset, $itemsPerPage, $session, $from_date, $to_date, $allowedFrontendIds);
			if(!$playersData)
			{
				$this->_redirect('/error/error');
			}
		}
		if(isset($playersData[1]))
		{
			if($playersData[1])
			{
				$this->view->paginator = $playersData[0];
				$this->view->contents = $playersData[1];
				$this->view->from = $from_date;
				$this->view->to = $to_date;
			}
		}
	}
	
	public function gamehistoryAction()
	{
		$playerId = $this->getRequest()->id;
		
		$error = false;
		if(isset($playerId))
		{
			$player = new Player();
			$playerData = $player->getPlayerData($playerId);
				
			$authSession = new Zenfox_Auth_Storage_Session();
			$sessionData = $authSession->read();
				
			$partnerFrontendId = $sessionData['authDetails'][0]['partner_frontend_id'];
			$partnerId = $sessionData['id'];
				
			$partnerFrontends = new PartnerFrontends();
			$frontendData = $partnerFrontends->getFrontendData($partnerFrontendId);
				
			$allowedFrontendIdsString = $frontendData['allowed_frontend_ids'];
			$allowedFrontendIdsArray = explode(',', $allowedFrontendIdsString);
				
			if(!in_array($playerData['frontendId'], $allowedFrontendIdsArray))
			{
				$error = true;
				echo "Sorry! You don't have permission to visit the detail of this player.";
			}
			else
			{
				$dateForm = new Partner_DateForm();
				$dateForm->getElement('playerId')->setValue($playerId);
				$this->view->dateForm = $dateForm;
					
				$offset = $this->getRequest()->page;
				$playerGamelog = new PlayerGamelog();
					
				$sessionName = 'Searching_' . $partnerId;
				$session = new Zend_Session_Namespace($sessionName);
					
				if($this->getRequest()->isPost())
				{
					if($dateForm->isValid($_POST))
					{
						$offset = 1;
						$data = $dateForm->getValues();
							
						$from_date = $data['from_date'] . ' ' . $data['from_time'];
						$to_date = $data['to_date'] . ' ' . $data['to_time'];
						$playersGameHistory = $playerGamelog->getGameHistory($offset, $data['items'], $session, $from_date, $to_date, $playerId, $allowedFrontendIds);
							
						if(!$playersGameHistory[1])
						{
							echo "No record found";
						}
					}
				}
				elseif($offset)
				{
					$itemsPerPage = $this->getRequest()->item;
					$from_date = $this->getRequest()->from;
					$to_date = $this->getRequest()->to;
						
					$playersGameHistory = $playerGamelog->getGameHistory($offset, $itemsPerPage, $session, $from_date, $to_date, $playerId, $allowedFrontendIds);
					if(!$playersGameHistory)
					{
						$this->_redirect('/error/error');
					}
				}
				if(isset($playersGameHistory[1]))
				{
					if($playersGameHistory[1])
					{
						$this->view->paginator = $playersGameHistory[0];
						$this->view->contents = $playersGameHistory[1];
						$this->view->from = $from_date;
						$this->view->to = $to_date;
						$this->view->playerId = $playerId;
					}
				}
			}
		}
		else
		{
			echo "Please enter a player id. If you don't know the player id, please click on <a href = '/player/search'><b>Seach Player</b></a>";
		}
	}
	
	public function depositorsAction()
	{
		$dateForm = new Partner_DateForm();
		$this->view->dateForm = $dateForm;
		
		$offset = $this->getRequest()->page;
		$player = new Player();
		
		$authSession = new Zenfox_Auth_Storage_Session();
		$sessionData = $authSession->read();
		
		$partnerFrontendId = $sessionData['authDetails'][0]['partner_frontend_id'];
		$partnerId = $sessionData['id'];
		
		$partnerFrontends = new PartnerFrontends();
		$frontendData = $partnerFrontends->getFrontendData($partnerFrontendId);
		
		$allowedFrontendIds = $frontendData['allowed_frontend_ids'];
		$sessionName = 'Searching_' . $partnerId;
		$session = new Zend_Session_Namespace($sessionName);
		
		if($this->getRequest()->isPost())
		{
			if($dateForm->isValid($_POST))
			{
				$offset = 1;
				$data = $dateForm->getValues();
		
				$from_date = $data['from_date'] . ' ' . $data['from_time'];
				$to_date = $data['to_date'] . ' ' . $data['to_time'];
				$playersData = $player->getAllDepositors($offset, $data['items'], $session, $from_date, $to_date, $allowedFrontendIds);
		
				if(!$playersData[1])
				{
					echo "No record found";
				}
			}
		}
		elseif($offset)
		{
			$itemsPerPage = $this->getRequest()->item;
			$from_date = $this->getRequest()->from;
			$to_date = $this->getRequest()->to;
		
			$playersData = $player->getAllDepositors($offset, $itemsPerPage, $session, $from_date, $to_date, $allowedFrontendIds);
			if(!$playersData)
			{
				$this->_redirect('/error/error');
			}
		}
		if(isset($playersData[1]))
		{
			if($playersData[1])
			{
				$this->view->paginator = $playersData[0];
				$this->view->contents = $playersData[1];
				$this->view->from = $from_date;
				$this->view->to = $to_date;
			}
		}
	}
	
	public function transactionsAction()
	{
		$dateForm = new Partner_DateForm();
		$this->view->dateForm = $dateForm;
		
		$offset = $this->getRequest()->page;
		$playerTransactionRecord = new PlayerTransactionRecord();
		
		$authSession = new Zenfox_Auth_Storage_Session();
		$sessionData = $authSession->read();
		
		$partnerFrontendId = $sessionData['authDetails'][0]['partner_frontend_id'];
		$partnerId = $sessionData['id'];
		
		$partnerFrontends = new PartnerFrontends();
		$frontendData = $partnerFrontends->getFrontendData($partnerFrontendId);
		
		$allowedFrontendIds = $frontendData['allowed_frontend_ids'];
		$sessionName = 'Searching_' . $partnerId;
		$session = new Zend_Session_Namespace($sessionName);
		
		if($this->getRequest()->isPost())
		{
			if($dateForm->isValid($_POST))
			{
				$offset = 1;
				$data = $dateForm->getValues();
		
				$from_date = $data['from_date'] . ' ' . $data['from_time'];
				$to_date = $data['to_date'] . ' ' . $data['to_time'];
				$transactionData = $playerTransactionRecord->getplayerfailedtransactions(-1 ,"ALL",$from_date, $to_date, 1, $data['items'], $allowedFrontendIds);
		
				if(!$transactionData[1])
				{
					echo "No record found";
				}
			}
		}
		elseif($offset)
		{
			$itemsPerPage = $this->getRequest()->item;
			$from_date = $this->getRequest()->from;
			$to_date = $this->getRequest()->to;
		
			$transactionData = $playerTransactionRecord->getplayerfailedtransactions(-1 ,"ALL",$from_date, $to_date, $offset, $itemsPerPage, $allowedFrontendIds);
			if(!$transactionData)
			{
				$this->_redirect('/error/error');
			}
		}
		if(isset($transactionData[1]))
		{
			if($transactionData[1])
			{
				$this->view->paginator = $transactionData[0];
				$this->view->contents = $transactionData[1];
				$this->view->from = $from_date;
				$this->view->to = $to_date;
			}
		}
	}
	
	public function gamelogsAction()
	{
		$playerId = $this->getRequest()->id;
		
		if(!isset($playerId))
		{
			echo "Please enter a player id. If you don't know the player id, please click on <a href = '/player/search'><b>Seach Player</b></a>";
		}
		else
		{
			$player = new Player();
			$playerData = $player->getPlayerData($playerId);
			
			$authSession = new Zenfox_Auth_Storage_Session();
			$sessionData = $authSession->read();
			
			$partnerFrontendId = $sessionData['authDetails'][0]['partner_frontend_id'];
			$partnerId = $sessionData['id'];
			
			$partnerFrontends = new PartnerFrontends();
			$frontendData = $partnerFrontends->getFrontendData($partnerFrontendId);
			
			$allowedFrontendIdsString = $frontendData['allowed_frontend_ids'];
			$allowedFrontendIdsArray = explode(',', $allowedFrontendIdsString);
			
			if(!in_array($playerData['frontendId'], $allowedFrontendIdsArray))
			{
				echo "Sorry! You don't have permission to visit the detail of this player.";
			}
			else
			{
				$dateForm = new Partner_DateForm();
				$dateForm->getElement('playerId')->setValue($playerId);
				$this->view->dateForm = $dateForm;
				
				$offset = $this->getRequest()->page;
				$playerGamelog = new PlayerGamelog();
					
				$sessionName = 'Searching_' . $partnerId;
				$session = new Zend_Session_Namespace($sessionName);
					
				if($this->getRequest()->isPost())
				{
					if($dateForm->isValid($_POST))
					{
						$offset = 1;
						$data = $dateForm->getValues();
							
						$from_date = $data['from_date'] . ' ' . $data['from_time'];
						$to_date = $data['to_date'] . ' ' . $data['to_time'];
						$playerGameLogs = $playerGamelog->getPlayerGamelogDetails($playerId, $data['items'], $offset, $from_date, $to_date);
							
						if(!$playerGameLogs[1])
						{
							echo "No record found";
						}
					}
				}
				elseif($offset)
				{
					$itemsPerPage = $this->getRequest()->item;
					$from_date = $this->getRequest()->from;
					$to_date = $this->getRequest()->to;
						
					$playerGameLogs = $playerGamelog->getPlayerGamelogDetails($playerId, $itemsPerPage, $offset, $from_date, $to_date);
					if(!$playerGameLogs)
					{
						$this->_redirect('/error/error');
					}
				}
				if(isset($playerGameLogs[1]))
				{
					if($playerGameLogs[1])
					{
						$this->view->paginator = $playerGameLogs[0];
						$this->view->contents = $playerGameLogs[1];
						$this->view->from = $from_date;
						$this->view->to = $to_date;
						$this->view->playerId = $playerId;
					}
				}
			}
		}
	}
}