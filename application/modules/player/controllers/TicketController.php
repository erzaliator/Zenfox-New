<?php
/*
 * This file is creating for new tickets, view all tickets
 */
require_once dirname(__FILE__).'/../forms/TicketForm.php';
require_once dirname(__FILE__).'/../forms/TicketReplyForm.php';
class Player_TicketController extends Zenfox_Controller_Action
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
	public function indexAction()
	{
		$this->_forward('view');
	}
	public function createAction()
	{
		$language = $this->getRequest()->getParam('lang');
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
		$decorator = new Zenfox_DecoratorForm();
		$form = new Player_TicketForm();
		$form->getElement('subject')->setDecorators($decorator->openingUlTagDecorator);
		$form->getElement('reply_msg')->setDecorators($decorator->changeUlTagDecorator);
		$form->getElement('submit')->setDecorators($decorator->closingUlButtonTagDecorator);
		$this->view->form = $form;
		if($this->getRequest()->isPost())
		{
			if($form->isValid($_POST))
			{
				$data = $form->getValues();
				/*
				 * Sending user_type to Tickets
				 */
				$playerId = $store['id'];
				$userType = $store['roleName'];
				$ticket = new Tickets($playerId, $userType);
				if(($ticket->createTicket($data)))
				{
					$this->_redirect($language . '/ticket/view');
//					$form = new Player_TicketForm();
//					$this->view->form = $form;
//					$this->view->message = $this->view->translate("Your ticket is submited successfully");
				}
				else
				{
					//$this->_redirect('error/error');
					$this->_helper->FlashMessenger(array('error' => 'Unable to create ticket.'));
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
		$playerId = $store['id'];
		if(!$playerId)
		{
			$this->_helper->FlashMessenger(array('error' => 'No record found.'));
		}
		$ticket = new Tickets($playerId, $userType);
		$data = $ticket->viewTickets();
		//Zenfox_Debug::dump($data, 'data');
		if($data)
		{
			$csr = new Csr();
			$ticketContent = array();
			//$this->view->messages=$data;
			foreach($data as $index => $ticketData)
			{
				switch($ticketData['start_by'])
				{
					case 'PLAYER':
						$userName = "me";
						break;
					case 'CSR' :
						$csrInfo = $csr->getInfo($ticketData['started_id']);
						$userName = $csrInfo[0]['name'];
						break;
				}
				
				$ticketContent[$index]['ticketId'] = $ticketData['id'];
				$ticketContent[$index]['userName'] = $userName;
				$ticketContent[$index]['subject'] = $ticketData['subject'];
				$ticketContent[$index]['startDate'] = $ticketData['start_date'];
			}
			
			$this->view->messages = $ticketContent;
		}
		else
		{
			$this->_helper->FlashMessenger(array('notice' => $this->view->translate('No tickets')));
		}
	}
	/*
	 * This function is for replying a ticket
	 */
	public function replyAction()
	{
		Zend_Layout::getMvcInstance()->disableLayout();
		/* $language = $this->getRequest()->getParam('lang');
		$decorator = new Zenfox_DecoratorForm();
		$form = new Player_TicketReplyForm();
		$form->getElement('reply_msg')->setDecorators($decorator->openingUlTagDecorator);
		$form->getElement('ticket_status')->setDecorators($decorator->changeUlTagDecorator);
		$form->getElement('submit')->setDecorators($decorator->closingUlButtonTagDecorator); */
		$session = new Zend_Auth_Storage_Session();
		$store = $session->read();
		$userType = $store['roleName'];
		$playerId = $store['id'];
		$ticketId = $this->getRequest()->ticket_id;
		$replyMessage = $this->getRequest()->replyMsg;
		$subject = $this->getRequest()->subject;
		$ticket = new Tickets($playerId, $userType);
		if(isset($replyMessage))
		{
			$data['ticket_status'] = 'OPEN';
			$data['reply_msg'] = $replyMessage;
			$ticket->replyTicket($data,$ticketId);
			echo $ticketId;
		}
		else
		{
			$message = $ticket->showTicket($ticketId);
			//Zenfox_Debug::dump($message, 'message');
			
			$sender = "";
			$messages = "";
			$time = "";
			foreach($message as $msg)
			{
				if($msg['sent_by'] == 'CSR')
				{
					$csr = new CsrIds();
					$sender .= $csr->getCsrName($msg['owner']) . "|";
				}
				if($msg['sent_by'] == 'PLAYER')
				{
					$player = new CsrIds();
					$sender .= $player->getPlayerLogin($msg['user_id']) . "|";
				}
				$messages .= $msg['reply_msg'] . "|";
				$time .= $msg['time'] . "|";
			}
			echo $sender . "&" . $messages . "&" . $ticketId . "&" . $subject . "&" . $time;
		}
		/*
		* Taking the value from the database and set into form
		*/
		/*
		$this->view->sender = $fromName;
		$this->view->messages = $message;
		//$this->_helper->FlashMessenger(array('notice' => $this->view->translate($message)));
		foreach($message as $ticketData)
		{
			$lastTicketStatus = $ticketData['ticket_status'];
		}
		$form->ticket_status->setValue($lastTicketStatus);
		$this->view->form = $form; */
		/* if($this->getRequest()->isPost())
		{
			if($form->isValid($_POST))
			{
				$data = $form->getValues();
				$ticket->replyTicket($data,$this->getRequest()->ticket_id);
				$this->_redirect($language . '/ticket/view');
//				$form = new Player_TicketReplyForm();
//				$this->view->form = $form;
//				$this->view->message = $this->view->translate('The message has been sent');
			}
		} */
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
	
	public function deleteAction()
	{
		Zend_Layout::getMvcInstance()->disableLayout();
		$session = new Zenfox_Auth_Storage_Session();
		$storedData = $session->read();
		$playerId = $storedData['id'];
		$ticketId = $this->getRequest()->ticket_id;
		$tickets = new Tickets($playerId, 'player');
		$deleteTicket = $tickets->deleteTicket($ticketId);
		echo $deleteTicket;
	}
}