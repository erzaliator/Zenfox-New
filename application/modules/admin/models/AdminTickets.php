<?php
class AdminTickets extends Doctrine_Record
{
	private $_ticket;
	private $ticketData;
	public function init()
	{
		parent::init();
	}
	
	public function __construct()
	{
		$this->_ticket = new Ticket();
		$this->_ticketData = $this->_ticket->get('TicketData');
	}
	
	public function view()
	{
		$allTicketsDetails = array();
		//It will returns the array of all connections.
		$conns = Zenfox_Partition::getInstance()->getConnections(-1);
		foreach($conns as $conn)
		{
			Doctrine_Manager::getInstance()->setCurrentConnection($conn);
			
			$query = Zenfox_Query::create()
						->from('Ticket t')
						->leftJoin('t.TicketData td')
						->where('t.ticket_status = ? ', 'open');
			
			$ticketDetails = $query->fetchArray();
			$allTicketsDetails[] = $ticketDetails;
		}
		//Zenfox_Debug::Dump($allTicketsDetails, 'Ticket', true, true);
		return $allTicketsDetails;
	}
	
	public function show($user_id)
	{
		$conn = Zenfox_Partition::getInstance()->getConnections($user_id);
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
					->from('Ticket t')
					->leftJoin('t.TicketData td')
					->where('t.user_id = ? ', $user_id);
		
		$ticketDetails = $query->fetchArray();
		return $ticketDetails;
	}
	
	public function conversation($user_id, $ticket_id)
	{
		$conn = Zenfox_Partition::getInstance()->getConnections($user_id);
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		$query = Zenfox_Query::create()
					->from('TicketData td')
					->where('td.ticket_id = ? ', $ticket_id);
		$ticketDetails = $query->fetchArray();
		return $ticketDetails;
	}
	
	public function create($csr_id,$ticket_data)
	{
		$player = new Player();
		$user_id = $player->getAccountIdFromLogin($ticket_data['userName']);
		if($user_id)
		{
			$today = new Zend_Date();
			$today->setTimezone('Indian/Maldives');
			
			$this->_ticketData['reply_msg'] = $ticket_data['reply_msg'];
			$this->_ticketData['time'] = $today->get(Zend_Date::W3C);
			$this->_ticketData['ticket_status'] = $ticket_data['ticket_status'];
			$this->_ticketData['user_id'] = $user_id;
			$this->_ticketData['user_type'] = 'player';
			$this->_ticketData['owner'] = $csr_id;
			$this->_ticketData['note'] = $ticket_data['note'];
			
			$this->_ticket['start_date'] = $today->get(Zend_Date::W3C);
			$this->_ticket['ticket_status'] = $ticket_data['ticket_status'];
			$this->_ticket['user_id'] = $user_id;
			$this->_ticket['user_type'] = 'player';
			$this->_ticket['start_by'] = 'csr';
			$this->_ticket['started_id'] = $csr_id;
			$this->_ticket['csr_id'] = $csr_id;
			$this->_ticket['csr_owner'] = $csr_id;
			if($ticket_data['ticket_status'] == 0)
			{
				$this->_ticket['closed_by'] == $this->_userType;
				$this->_ticket['closed_id'] == $this->_playerId;
				$this->_ticket['close_date'] == $today->get(Zend_Date::W3C);
			}
			
			$conn = Zenfox_Partition::getInstance()->getConnections($user_id);
			$partition = Doctrine_Manager::getInstance()->getConnection($conn);
			
			$this->_ticket->save($partition);
			return true;
		}
	}
}