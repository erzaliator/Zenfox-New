<?php
require_once dirname(__FILE__).'/../forms/TicketForm.php';
require_once dirname(__FILE__).'/../forms/ReplyForm.php';
require_once dirname(__FILE__).'/../forms/DropdownMenuForm.php';
class Admin_TicketController extends Zenfox_Controller_Action
{
	public function init()
	{
		parent::init();
		$this->_redirector = $this->_helper->getHelper('Redirector');
        $contextSwitch = $this->_helper->getHelper('contextSwitch');
        $contextSwitch->setAutoJsonSerialization(false);
		$contextSwitch->addActionContext('view', 'json')
					->addActionContext('create', 'json')
					->addActionContext('reply', 'json')
              		->initContext();
	}
	
	public function viewAction()
	{
		$form = new Admin_DropdownMenuForm();
        $this->view->form = $form;
		$session = new Zend_Auth_Storage_Session();
		$store = $session->read();
		$userType = $store['roleName'];
		$csrId = $store['id'];
		$ticket = new Tickets($csrId, $userType);
		$offset = $this->getRequest()->page;
		$itemsPerPage = $this->getRequest()->item;
		if(!$offset)
		{
			$offset = 1;
		}
		else
		{
			$fromDate = $this->getRequest()->from;
			//$fromDate = date ("Y-m-d H:i:s", strtotime("$fromTime, - 5 HOUR 30 MINUTE"));
			$toDate = $this->getRequest()->to;
			//$toDate = date ("Y-m-d H:i:s", strtotime("$toTime, - 5 HOUR 30 MINUTE"));
			
			$status = $this->getRequest()->status;
			//$ticketType = $this->getRequest()->ticketType;
			$allTicketsDetails = $ticket->viewTickets($fromDate, $toDate, $status, $offset, $itemsPerPage);//, $ticketType);
			$this->view->fromDate = $fromDate;
			$this->view->toDate = $toDate;
			$this->view->status = $status;
			$this->view->paginator = $allTicketsDetails[0];
        	$this->view->contents = $allTicketsDetails[1];
			//$this->view->ticketType = $ticketType;	
		}
        if($this->getRequest()->isPost())
        {//Zenfox_Debug::dump($_POST, 'post',true,true);
        	if($form->isValid($_POST))
        	{
        		$form_data = $form->getValues();
        		
        		$from_date = $form_data['start_date'] . ' ' . $form_data['from_time'];
				//$from_date = date ("Y-m-d H:i:s", strtotime("$fromTime, - 5 HOUR 30 MINUTE"));

				$to_date = $form_data['end_date'] . ' ' . $form_data['to_time'];
				//$to_date = date ("Y-m-d H:i:s", strtotime("$toTime, - 5 HOUR 30 MINUTE"));
        		$ticket_status = $form_data['ticket_status'];
        		$itemsPerPage = $form_data['items_per_page'];
        		//$ticketType = 'player';
        		
        		$allTicketsDetails = $ticket->viewTickets($from_date, $to_date, $ticket_status, $offset, $itemsPerPage);//, $ticketType);
        		
        		$this->view->fromDate = $from_date;
        		$this->view->toDate = $to_date;
        		$this->view->status = $ticket_status;
        		//$this->view->ticketType = $ticketType;
        		$this->view->paginator = $allTicketsDetails[0];
        		$this->view->contents = $allTicketsDetails[1];
        		if(!$allTicketsDetails[1])
        		{
        			$this->_helper->FlashMessenger(array('notice' => $this->view->translate("No Ticket")));
        		}
        	}
        }
	}
	
	public function createAction()
	{
		$session = new Zend_Auth_Storage_Session();
		$store = $session->read();
		$userType = $store['roleName'];
		$csrId = $store['id'];
		$csrfrontendids = $sessionData["frontend_ids"];
		$ticket = new Tickets($csrId, $userType);
		$form = new Admin_TicketForm();
		$this->view->form = $form;
		/*$csrIds = new CsrIds();
		$ids = $csrIds->getIds();
		$this->view->csrIds = $ids;*/
		if($this->getRequest()->isPost())
		{
			if($form->isValid($_POST))
			{//Zenfox_Debug::dump($_POST, 'post',true,true);
				$data = $form->getValues();
				$ticketType = 'player';
				//TODO get user id from url
				//Done got the user_id from form data
				$login = new CsrIds();
				if($ticketType == 'affiliate')
				{
					$user_id = $login->getAffiliateId($data['userName']);
				}
				else
				{
					$user_id = $login->getUserId($data['userName']);
				}
				 $player = new Player();
				$playerfrontendid = $player->getfrontendidofplayer($user_id);
				if (in_array($playerfrontendid,$csrfrontendids))
 				{
 					if($ticket->createTicket($data, $user_id, $ticketType))
					{
					//echo 'in here';
						$form = new Admin_TicketForm();
						$this->view->form = $form;
						$this->view->message = $this->view->translate("Your message has been sent");
						$this->_helper->FlashMessenger(array('notice' => $this->view->translate("Your message has been sent")));
					}
 				}
 				else
 				{
 					$this->_helper->FlashMessenger(array('error' => $data['userName']." not found or You are not authorised to view/edit this player's details"));
 				}
				
			}
		}
	}
	
	public function replyAction()
	{
		$session = new Zend_Auth_Storage_Session();
		$store = $session->read();
		$userType = $store['roleName'];
		$playerId = $store['id'];
		$ticket = new Tickets($playerId, $userType);
		$form = new Admin_ReplyForm();
		$this->view->form = $form;
		$ticketData = $this->_getTicketData($this->getRequest()->ticket_id, $this->getRequest()->user_id, $this->getRequest()->userType);
		$form->ticket_status->setValue($ticketData['lastTicketStatus']);
		//
		/*$message = $ticket->showTicket($this->getRequest()->ticket_id, $this->getRequest()->user_id, $this->getRequest()->userType);
		
		$fromName = array();
		$toName = array();
		foreach($message as $tickets)
		{
			$lastTicketStatus = $tickets['ticket_status'];
		}
		$form->ticket_status->setValue($lastTicketStatus);
		foreach($message as $msg)
		{
			if($msg['sent_by'] == 'CSR')
			{
				$csr = new CsrIds();
				if($msg['ticket_status'] == 'FORWARDED')
				{
					$receiver = $csr->getForwardedCsrName($msg['time'], $msg['user_id']);
				}
				else
				{
					$receiver = $csr->getPlayerLogin($msg['user_id']);
				}
				$sender = $csr->getCsrName($msg['owner']);
			}
			if($msg['sent_by'] == 'PLAYER')
			{
				$player = new CsrIds();
				$sender = $player->getPlayerLogin($msg['user_id']);
				$receiver = 'CSR';
			}
			if($msg['sent_by'] == 'AFFILIATE')
			{
				$affiliate = new CsrIds();
				$sender = $affiliate->getAffiliateAlias($msg['user_id']);
				$receiver = 'CSR';
			}
			$fromName[] = $sender;
			$toName[] = $receiver;
		}
		$csrIds = new CsrIds();
		$this->view->sender = $fromName;
		$this->view->receiver = $toName;
		$this->view->messages = $message;
		$this->view->csrIds = $csrIds->getIds();
		$index = 0;
		$messageContent = array();
		foreach($message as $messageData)
		{
			$messageContent[$index]['From'] = $fromName[$index];
			$messageContent[$index]['To'] = $toName[$index];
			$messageContent[$index]['Message'] = $messageData['reply_msg'];
			$messageContent[$index]['Time'] = $messageData['time'];
			$index++;
		}
		$this->view->contents = $messageContent;*/
		//$this->_helper->FlashMessenger(array('notice' => $this->view->translate($message)));
		if($this->getRequest()->isPost())
		{//Zenfox_Debug::dump($_POST ,'relpy',true,true);
			if($form->isValid($_POST))
			{ 
				$data = $form->getValues();
				
				//Zenfox_Debug::dump('-ticket_id-'.$this->getRequest()->ticket_id.'-id-'. $this->getRequest()->id.'-ticketType-'. $this->getRequest()->ticketType ,'relpy',true,true);
				$ticket->replyTicket($data, $this->getRequest()->ticket_id, $this->getRequest()->user_id, $this->getRequest()->userType);
				$form = new Admin_ReplyForm();
				$this->view->form = $form;
				//$this->view->message = $this->view->translate('Your reply has been sent.');
				$this->view->sent = 'sent';
				$this->_helper->FlashMessenger(array('notice' => $this->view->translate("Your reply has been sent.")));
				$ticketData = $this->_getTicketData($this->getRequest()->ticket_id, $this->getRequest()->user_id, $this->getRequest()->userType);
			}
		}
		$this->view->sender = $ticketData['fromName'];
		$this->view->receiver = $ticketData['toName'];
		$this->view->messages = $ticketData['message'];
		$this->view->csrIds = $ticketData['csrIds'];
		$this->view->contents = $ticketData['messageContent'];
	}
	
	private function _getTicketData($ticketId, $userId, $userType)
	{
		$session = new Zend_Auth_Storage_Session();
		$store = $session->read();
		$userType = $store['roleName'];
		$playerId = $store['id'];
		$ticket = new Tickets($playerId, $userType);
		
		$message = $ticket->showTicket($ticketId, $userId, $userType);
		/*
		 * Taking the value from the database and set into form
		 */
		$fromName = array();
		$toName = array();
		foreach($message as $tickets)
		{
			$lastTicketStatus = $tickets['ticket_status'];
		}
		
		foreach($message as $msg)
		{
			if($msg['sent_by'] == 'CSR')
			{
				$csr = new CsrIds();
				if($msg['ticket_status'] == 'FORWARDED')
				{
					$receiver = $csr->getForwardedCsrName($msg['time'], $msg['user_id']);
				}
				else
				{
					$receiver = $csr->getPlayerLogin($msg['user_id']);
				}
				$sender = $csr->getCsrName($msg['owner']);
			}
			if($msg['sent_by'] == 'PLAYER')
			{
				$player = new CsrIds();
				$sender = $player->getPlayerLogin($msg['user_id']);
				$receiver = 'CSR';
			}
			if($msg['sent_by'] == 'AFFILIATE')
			{
				$affiliate = new CsrIds();
				$sender = $affiliate->getAffiliateAlias($msg['user_id']);
				$receiver = 'CSR';
			}
			$fromName[] = $sender;
			$toName[] = $receiver;
		}
		$csrIds = new CsrIds();
		$allCsrIds = $csrIds->getIds();
		$index = 0;
		$messageContent = array();
		foreach($message as $messageData)
		{
			$ticketTime = $messageData['time'];
			$messageContent[$index]['From'] = $fromName[$index];
			$messageContent[$index]['To'] = $toName[$index];
			$messageContent[$index]['Message'] = $messageData['reply_msg'];
			if($messageData['ticket_status'] == 'FORWARDED')
			{
				$messageContent[$index]['Note'] = $messageData['note'];
			}
			$messageContent[$index]['Time'] =  date ("Y-m-d H:i:s", strtotime("$ticketTime, + 5 HOUR 30 MINUTE"));
			$index++;
		}

		return array(
			'lastTicketStatus' => $lastTicketStatus,
			'fromName' => $fromName,
			'toName' => $toName,
			'message' => $message,
			'csrIds' => $allCsrIds,
			'messageContent' => $messageContent
		);
	}
}
