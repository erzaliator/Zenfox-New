<?php
/*
 * This file is creating for new tickets, view all tickets
 */
require_once dirname(__FILE__).'/../forms/TicketForm.php';
require_once dirname(__FILE__).'/../forms/TicketReplyForm.php';
class Affiliate_TicketController extends Zenfox_Controller_Action
{
	public function init()
	{
		parent::init();
		$contextSwitch = $this->_helper->getHelper('contextSwitch');
		$contextSwitch->addActionContext('create', 'json')
					->addActionContext('view', 'json')
					->addActionContext('reply', 'json')
              		->initContext();
	}
	
	/*
	 * Create a new ticket
	 */
	public function createAction()
	{
		/*$conn = Zenfox_Partition::getInstance()->getConnections(3);
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		$manager = Doctrine_Manager::getInstance();
		$manager->setImpl('TicketTemplate', 'Ticket')
				->setImpl('ForwardedTemplate', 'Forwarded');
		$ticket = new Ticket();
		$ticket->Forwarded->forwarded_note = 'Hi! How are you?';*/
//		$ticket->save();
		/*
		 * TODO store the data in session table
		 * and get the user_type from PlayerSessions
		 */
		$session = new Zend_Auth_Storage_Session();
		$store = $session->read();
		$form = new Affiliate_TicketForm();
		$this->view->form = $form;
		if($this->getRequest()->isPost())
		{
			if($form->isValid($_POST))
			{
				$data = $form->getValues();
				/*
				 * Sending user_type to Tickets
				 */
				$affiliateId = $store['id'];
				$userType = $store['roleName'];
				$ticket = new Tickets($affiliateId, $userType);
				if(($ticket->createTicket($data)))
				{
					$form = new Affiliate_TicketForm();
					$this->view->form = $form;
					//$this->view->message = $this->view->translate("Your ticket has been submited successfully");
					$this->_helper->FlashMessenger(array('notice' => $this->view->translate("Your ticket has been submited successfully")));
				}
				else
				{
					$this->_redirect('error/ticket');
				}
			}
		}
	}
	/*
	 * This function will show all the tickets of the user who is logged in
	 */
	public function viewAction()
	{
		$session = new Zend_Auth_Storage_Session();
		$store = $session->read();
		$userType = $store['roleName'];
		$affiliateId = $store['id'];
		$ticket = new Tickets($affiliateId, $userType);
		$data = $ticket->viewTickets();
		$this->view->messages=$data;
		//$this->_helper->FlashMessenger(array('notice' => $this->view->translate($data)));
	}
	/*
	 * This function is for replying a ticket
	 */
	public function replyAction()
	{
		$form = new Affiliate_TicketReplyForm();
		$session = new Zend_Auth_Storage_Session();
		$store = $session->read();
		$userType = $store['roleName'];
		$affiliateId = $store['id'];
		$ticket = new Tickets($affiliateId, $userType);
		$message = $ticket->showTicket($this->getRequest()->ticket_id);
		/*
		 * Taking the value from the database and set into form
		 */
		$fromName = array();
		foreach($message as $msg)
		{
			if($msg['sent_by'] == 'CSR')
			{
				$csr = new CsrIds();
				$sender = $csr->getCsrName($msg['owner']);
			}
			if($msg['sent_by'] == 'PLAYER')
			{
				$player = new CsrIds();
				$sender = $player->getPlayerLogin($msg['user_id']);
			}
			if($msg['sent_by'] == 'AFFILIATE')
			{
				$affiliate = new CsrIds();
				$sender = $affiliate->getAffiliateAlias($msg['user_id']);
			}
			$fromName[] = $sender;
		}
		$this->view->sender = $fromName;
		$this->view->messages = $message;
		//$this->_helper->FlashMessenger(array('notice' => $this->view->translate($message)));
		foreach($message as $ticketData)
		{
			$lastTicketStatus = $ticketData['ticket_status'];
		}
		$form->ticket_status->setValue($lastTicketStatus);
		$this->view->form = $form;
		if($this->getRequest()->isPost())
		{
			if($form->isValid($_POST))
			{
				$data = $form->getValues();
				$ticket->replyTicket($data,$this->getRequest()->ticket_id);
				$form = new Affiliate_TicketReplyForm();
				$this->view->form = $form;
				//$this->view->message = $this->view->translate('Your reply has been sent');
				$this->_helper->FlashMessenger(array('notice' => $this->view->translate("Your reply has been sent")));
			}
		}
	}
	/*
	 * This function will show all conversations of a particular ticket
	 */
	/*public function showAction()
	{
		$session = new Zend_Auth_Storage_Session();
		$store = $session->read();
		if(!$store)
		{
			$this->_redirect('auth/login');
		}
		$user_type = $store['id'];
		$ticket = new Tickets($user_type);
		$message = $ticket->showTicket($this->getRequest()->ticket_id);
		$this->view->message = $message;
	}*/
}
