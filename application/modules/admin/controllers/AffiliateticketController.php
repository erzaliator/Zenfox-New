<?php
require_once dirname(__FILE__).'/../forms/TicketForm.php';
require_once dirname(__FILE__).'/../forms/ReplyForm.php';
require_once dirname(__FILE__).'/../forms/DropdownMenuForm.php';
class Admin_AffiliateticketController extends Zenfox_Controller_Action
{
	public function init()
	{
		parent::init();
		$this->_redirector = $this->_helper->getHelper('Redirector');
        $contextSwitch = $this->_helper->getHelper('contextSwitch');
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
			$toDate = $this->getRequest()->to;
			$status = $this->getRequest()->status;
			$ticketType = $this->getRequest()->ticketType;
			$allTicketsDetails = $ticket->viewTickets($fromDate, $toDate, $status, $offset, $itemsPerPage, $ticketType);
			$this->view->fromDate = $fromDate;
			$this->view->toDate = $toDate;
			$this->view->status = $status;
			$this->view->ticketType = $ticketType;	
		}
        if($this->getRequest()->isPost())
        {
        	if($form->isValid($_POST))
        	{
        		$form_data = $form->getValues();
        		$from_date = $form_data['start_date'] . $form_data['from_time'];
        		$to_date = $form_data['end_date'] . $form_data['to_time'];
        		$ticket_status = $form_data['ticket_status'];
        		$itemsPerPage = $form_data['items_per_page'];
        		$ticketType = 'affiliate';
        		$allTicketsDetails = $ticket->viewTickets($from_date, $to_date, $ticket_status, $offset, $itemsPerPage, $ticketType);
        		$this->view->fromDate = $from_date;
        		$this->view->toDate = $to_date;
        		$this->view->status = $ticket_status;
        		$this->view->ticketType = $ticketType;
        	}
        }
//        Zenfox_Debug::dump($allTicketsDetails, 'all tickets');
        $this->view->paginator =$allTicketsDetails;
	}
	
	public function createAction()
	{
		$session = new Zend_Auth_Storage_Session();
		$store = $session->read();
		$userType = $store['roleName'];
		$csrId = $store['id'];
		$ticket = new Tickets($csrId, $userType);
		$form = new Admin_TicketForm();
		$this->view->form = $form;
		/*$csrIds = new CsrIds();
		$ids = $csrIds->getIds();
		$this->view->csrIds = $ids;*/
		if($this->getRequest()->isPost())
		{
			if($form->isValid($_POST))
			{
				$data = $form->getValues();
				$ticketType = 'affiliate';
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
				
				if($ticket->createTicket($data, $user_id, $ticketType))
				{
					$form = new Admin_TicketForm();
					$this->view->form = $form;
					//$this->view->message = $this->view->translate("Your reply has been sent");
					$this->_helper->FlashMessenger(array('notice' => $this->view->translate("Your reply has been sent")));
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
		$message = $ticket->showTicket($this->getRequest()->ticket_id, $this->getRequest()->id, $this->getRequest()->ticketType);
		/*
		 * Taking the value from the database and set into form
		 */
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
		$this->view->sender = $fromName;
		$this->view->receiver = $toName;
		$this->view->messages = $message;
		//$this->_helper->FlashMessenger(array('notice' => $this->view->translate($message)));
		if($this->getRequest()->isPost())
		{
			if($form->isValid($_POST))
			{
				$data = $form->getValues();
				$ticket->replyTicket($data, $this->getRequest()->ticket_id, $this->getRequest()->id, $this->getRequest()->ticketType);
				$form = new Admin_ReplyForm();
				$this->view->form = $form;
				//$this->view->message = $this->view->translate('Your reply has been sent.');
				$this->_helper->FlashMessenger(array('notice' => $this->view->translate("Your reply has been sent.")));
			}
		}
	}
}
