<?php

/*
 * This class is implemented to handle all the ticket related actions.
 */

class Tickets extends Doctrine_Record
{
	private $_userType;
	private $_ticketData;
	private $_ticket;
	protected $_id;
	private $_today;
	
	public function __construct($userId, $userType)
	{
		$this->_userType = $userType;
		$this->_id = $userId;
		$this->_ticket = new Ticket();
		$this->_ticketData = $this->_ticket->get('TicketData');
		$this->_today = new Zend_Date();
	}
	
	/*
	 * Save the data in the database
	 * @param array $ticket
	 */
	
	public function createTicket($ticket_data, $user_id = NULL, $ticketType = NULL)
	{
			if($this->_id)
			{
				$this->_ticket['start_by'] = $this->_userType;
				$this->_ticket['started_id'] = $this->_id;
				$this->_ticket['start_date'] = $this->_today->get(Zend_Date::W3C);
				$this->_ticket['frontend_id'] = Zend_Registry::getInstance()->get('frontendId');
				$this->_ticket['subject'] = $ticket_data['subject'];
				
				$this->_ticketData['reply_msg'] = $ticket_data['reply_msg'];
				$this->_ticketData['sent_by'] = $this->_userType;
				$this->_ticketData['time'] = $this->_today->get(Zend_Date::W3C);
				$this->_ticketData['frontend_id'] = Zend_Registry::getInstance()->get('frontendId');
				
				if($this->_userType == 'player')
				{
					$this->_ticket['ticket_status'] = 'OPEN';
					$this->_ticket['user_id'] = $this->_id;
					$this->_ticket['user_type'] = $this->_userType;
					
					$this->_ticketData['ticket_status'] = 'OPEN';
					$this->_ticketData['user_id'] = $this->_id;
					$this->_ticketData['user_type'] = $this->_userType;

				    $connName = Zenfox_Partition::getInstance()->getConnections($this->_id);
            		$partition = Doctrine_Manager::getInstance()->getConnection($connName);
            		
           			try
           			{
           				$this->_ticket->save($partition);
           			}
           			catch(Exception $e)
           			{
           				print('Unable to save ticket data.') . $e;
           				exit();
           			}
          
					return true;
				}
				//TODO check for affiliate
				if($this->_userType=='affiliate')
				{
					$this->_ticket['ticket_status'] = 'OPEN';
					$this->_ticket['user_id'] = $this->_id;
					$this->_ticket['user_type'] = $this->_userType;
					
					$this->_ticketData['ticket_status'] = 'OPEN';
					$this->_ticketData['user_id'] = $this->_id;
					$this->_ticketData['user_type'] = $this->_userType;
					$connName = Zenfox_Partition::getInstance()->getMasterConnection();
					$master = Doctrine_Manager::getInstance()->getConnection($connName);
					try
					{
						$this->_ticket->save($master);
					}
					catch(Exception $e)
					{
						print('Unable to save ticket data.') . $e;
						exit();
					}
					return true;
			
				}
				
				if($this->_userType == 'csr')
				{
					if($ticket_data['ticketStatus'] == 'FORWARDED')
					{
						//TODO implement it for false
						$this->forwardedTicket($ticket_data, $user_id);
					}
					$this->_ticket['ticket_status'] = $ticket_data['ticketStatus'];
					$this->_ticket['user_id'] = $user_id;
					if($ticketType == 'affiliate')
					{
						$this->_ticket['user_type'] = 'affiliate';
					}
					else
					{
						$this->_ticket['user_type'] = 'player';
					}
					
					$this->_ticket['csr_id'] = $this->_id;
					$this->_ticket['csr_owner'] = $this->_id;
					
					$this->_ticketData['ticket_status'] = $ticket_data['ticketStatus'];
					$this->_ticketData['owner'] = $this->_id;
					$this->_ticketData['note'] = $ticket_data['note'];
					$this->_ticketData['user_id'] = $user_id;
					if($ticketType == 'affiliate')
					{
						$this->_ticketData['user_type'] = 'affiliate';
					}
					else
					{
						$this->_ticketData['user_type'] = 'player';
					}
					
					if($ticketType == 'affiliate')
					{
						$connName = Zenfox_Partition::getInstance()->getConnections(0);
					}
					else
					{
						$connName = Zenfox_Partition::getInstance()->getConnections($user_id);
					}
					
            		$partition = Doctrine_Manager::getInstance()->getConnection($connName);
					
					try
					{
						$this->_ticket->save($partition);
					}
					catch(Exception $e)
					{
						print('Unable to save ticket data.') . $e;
						exit();
					}
					return true;
					
				}
			}
			return false;
	}
	/*
	 * View the tickets for a particular player_id
	 * @ return ticketDetails
	 */
	public function viewTickets($fromDate = NULL, $toDate = NULL, $ticket_status = NULL, $offset = NULL, $itemsPerPage = 5, $ticket_type = NULL)
	{
		
		$authSession = new Zend_Auth_Storage_Session();
		$sessionData = $authSession->read();
		$csrfrontendids = $sessionData['frontend_ids'];
		
		$csrfrontendids = implode(",", $csrfrontendids);
		
		if($this->_id)
		{
			if($this->_userType=='player')
			{
				$connName = Zenfox_Partition::getInstance()->getConnections($this->_id);
           		Doctrine_Manager::getInstance()->setCurrentConnection($connName);
     
           		$query = Zenfox_Query::create()
	           			->from('Ticket t')
	           			->where('t.user_id = ? ', $this->_id)
	           			->andWhere('t.user_type = ?', 'PLAYER')
           				->orderBy('t.start_date desc');
         
           		$ticketDetails = $query->fetchArray();
           		//TODO implement it for pagination and select from date and to date
           		return $ticketDetails;
			}
			
			elseif($this->_userType == 'affiliate')
			{
				$connName = Zenfox_Partition::getInstance()->getMasterConnection();
           		Doctrine_Manager::getInstance()->setCurrentConnection($connName);
     
           		$query = Zenfox_Query::create()
	           			->from('Ticket t')
	           			->where('t.user_id = ? ', $this->_id)
	           			->andWhere('t.user_type = ?', 'AFFILIATE');
         
           		$ticketDetails = $query->fetchArray();
           		//TODO implement it for pagination and select from date and to date
           		return $ticketDetails;
			}
			//FIXME move this to a new file
			else
			{
//				$allTicketsDetails = array();
//				$ticketsDetails = array();
				//TODO check it for paginator
				/*$query = "Zenfox_Query::create()
								->from('Ticket t')
								->whereIn('t.ticket_status', array('OPEN', 'CLOSE'))";*/
//				$query = "->from('Ticket t')->whereIn('t.ticket_status', array('OPEN', 'CLOSE'))";
				//$adapter = new Zenfox_Paginator_Adapter_DoctrineQuery($query , -1);
				//TODO set the offset value
				//FIXME set the itemsPerPage
				//$allTicketsDetails = $adapter->getItems(0, $itemsPerPage);
				if($fromDate)
				{
					/*$time = explode('T', $fromDate);
					$fromDate = $time[0] . " " . $time[1];*/
					if($toDate)
					{
						/*$time = explode('T', $toDate);
						$toDate = $time[0] . ' ' . $time[1];*/
						$query = "Zenfox_Query::create()
										->from('Ticket t')
										->where('t.ticket_status = ?', $ticket_status)
										->andWhereIn('t.frontend_id', array($csrfrontendids))
										->andWhere('t.start_date between ? and ?', array('$fromDate', '$toDate'))";
					}
					else
					{
						$query = "Zenfox_Query::create()
									->from('Ticket t')
									->where('t.ticket_status = ?', $ticket_status)
									->andWhereIn('t.frontend_id', array($csrfrontendids))
									->andWhere('t.start_date >= ?', '$fromDate')";
					}
				}
				else
				{
					$query = "Zenfox_Query::create()
								->from('Ticket t')
								->whereIn('t.ticket_status', array('OPEN', 'CLOSE'))
								->andWhereIn('t.frontend_id', array($csrfrontendids))";
				}
				if($ticket_type == 'affiliate')
				{
					$adapter = new Zenfox_Paginator_Adapter_DoctrineQuery($query, 0);
				}
				else
				{
					$adapter = new Zenfox_Paginator_Adapter_DoctrineQuery($query, -1);
				}
				$paginatorSession = new Zend_Session_Namespace('paginationCount');
				$paginatorSession->value = false;
		    	$paginator =  new Zend_Paginator($adapter);
				$paginator->setItemCountPerPage($itemsPerPage);
				$paginator->setPageRange(2);
				$paginator->setCurrentPageNumber($offset);
				$paginatorSession->unsetAll();
				
				$ticketData = array();
				$index = 0;
				if($paginator->getTotalItemCount())
				{
					foreach($paginator as $logs)
					{
						$startDate = $logs['start_date'];
						//$startDate = date ("Y-m-d H:i:s", strtotime("$ticketStartDate, + 4 HOUR 30 MINUTE"));

						$ticketData[$index]['Id'] = $logs['id'] . '-' . $logs['user_id']; 
						$ticketData[$index]['Subject'] = $logs['subject'];
						$ticketData[$index]['Status'] = $logs['ticket_status'];
						$ticketData[$index]['User Type'] = $logs['user_type'];
						$ticketData[$index]['Started By'] = $logs['start_by'];
						$ticketData[$index]['Start Date'] = $startDate;
						$index++;
					}
					$paginatorSession->unsetAll();
					return array($paginator, $ticketData);
				}
				return null;
				
				//return $paginator;
				/*foreach($allTicketsDetails as $ticket)
				{
					foreach($ticket as $ticketDetails)
					{
						$from_date = $ticketDetails['start_date'];
						$to_date = $ticketDetails['start_date'];
						$status = $ticketDetails['ticket_status'];
						if($fromDate)
						{
							if($toDate)
							{
								if($ticket_status)
								{
									if(($from_date >= $fromDate) && ($to_date <= $toDate) && ($status == $ticket_status))
									{
										$ticketsDetails[] = $ticketDetails;
									}
								}
								else
								{
									if(($from_date >= $fromDate) && ($to_date <= $toDate))
									{
										$ticketsDetails[] = $ticketDetails;
									}
								}
							}
							else
							{
								if(($from_date >= $fromDate))
								{
									$ticketsDetails[] = $ticketDetails;
								}
							}
						}
						else
						{
							$ticketsDetails[] = $ticketDetails;
						}
					}
				}*/
				//return $ticketsDetails;
			}
		}
	}
	/*
	 * reply of a ticket
	 */
	public function replyTicket($ticket_data, $ticket_id, $user_id = NULL, $ticketType = NULL)
	{
		if($this->_id)
		{
		//	$this->_ticketData = new TicketData();
			$today = new Zend_Date();
			$this->_ticketData['ticket_id'] = $ticket_id;
			$this->_ticketData['ticket_type_id'] = $ticket_id;
			$this->_ticketData['reply_msg'] = $ticket_data['reply_msg'];
			$this->_ticketData['sent_by'] = $this->_userType;
			$this->_ticketData['time'] = $this->_today->get(Zend_Date::W3C);
			$this->_ticketData['ticket_status'] = $ticket_data['ticket_status'];
			$this->_ticketData['frontend_id'] = Zend_Registry::getInstance()->get('frontendId');
			
			//TODO if ticket is closed no updation in ticket
			
			if($this->_userType=='player')
			{
				$this->_ticketData['user_id'] = $this->_id;
				$this->_ticketData['user_type'] = $this->_userType;

				$connName = Zenfox_Partition::getInstance()->getConnections($this->_id);
           		$partition = Doctrine_Manager::getInstance()->getConnection($connName);
				
           		try
           		{
           			$this->_ticketData->save($partition);
           		}
           		catch(Exception $e)
           		{
           			print('Unable to save reply ticket data') . $e;
           			exit();
           		}
				
           		Doctrine_Manager::getInstance()->setCurrentConnection($connName);
           		
				$query = Zenfox_Query::create()
						->update('Ticket t')
						->set('t.ticket_status', '?', $ticket_data['ticket_status'])
						->where('t.id = ?', $ticket_id);
				try
				{
					$query->execute();
				}
				catch(Exception $e)
				{
					print('Unable to update ticket data') . $e;
					exit();
				}
				
				//return true;
			}
			
			elseif($this->_userType=='affiliate')
			{
				$this->_ticketData['user_id'] = $this->_id;
				$this->_ticketData['user_type'] = $this->_userType;
				
				$connName = Zenfox_Partition::getInstance()->getMasterConnection();
				$master = Doctrine_Manager::getInstance()->getConnection($connName);
				try
				{
					$this->_ticketData->save($master);
				}
				catch(Exception $e)
				{
					print('Unable to save reply ticket data') . $e;
					exit();
				}
				
				Doctrine_Manager::getInstance()->setCurrentConnection($connName);
           		
				$query = Zenfox_Query::create()
						->update('Ticket t')
						->set('t.ticket_status', '?', $ticket_data['ticket_status'])
						->where('t.id = ?', $ticket_id);
				try
				{
					$query->execute();
				}
				catch(Exception $e)
				{
					print('Unable to update ticket data') . $e;
					exit();
				}
				//return true;
			}
			
			else
			{
				if($ticket_data['ticket_status'] == 'FORWARDED')
				{
					//TODO implement it for false
					$this->forwardedTicket($ticket_data, $user_id, $ticket_id);
				}
				$this->_ticketData['sent_by'] = 'CSR';
				$this->_ticketData['owner'] = $this->_id;
				$this->_ticketData['note'] = $ticket_data['note'];
				$this->_ticketData['user_id'] = $user_id;
				if($ticketType == 'affiliate')
				{
					$this->_ticketData['user_type'] = 'affiliate';
					$connName = Zenfox_Partition::getInstance()->getConnections(0);
				}
				else
				{
					$this->_ticketData['user_type'] = 'player';
					$connName = Zenfox_Partition::getInstance()->getConnections($user_id);
				}
				
				
           		$partition = Doctrine_Manager::getInstance()->getConnection($connName);
				
           		$this->_ticketData->save($partition);
           		
           		Doctrine_Manager::getInstance()->setCurrentConnection($connName);
           		
           		$query = Doctrine::getTable('Ticket')->findOneById($ticket_id);
           		$owner = $query['csr_owner'];
           		if(!$owner)
           		{
           			$query = Zenfox_Query::create()
           						->update('Ticket t')
           						->set('t.csr_owner', '?', $this->_id)
           						->where('t.id = ?', $ticket_id);
           			try
           			{
           				$query->execute();
           			}
           			catch(Exception $e)
           			{
           				print('Unable to update csr ticket data') . $e;
           				exit();
           			}
           		}
           		
           		$query = Zenfox_Query::create()
           				->update('Ticket t')
           				->set('t.ticket_status', '?', $ticket_data['ticket_status'])
           				->set('t.csr_id', '?', $this->_id)
           				->where('t.id = ?', $ticket_id);
           				
           		try
           		{
           			$query->execute();
           		}
           		catch(Exception $e)
           		{
           			print('Unable to update csr ticket data') . $e;
           			exit();
           		}
           		
           		//TODO update csr_owner if value is 0
				
				//return true;
			}
			
			if($ticket_data['ticket_status'] == 'CLOSE')
			{				
				$query = Zenfox_Query::create()
						->update('Ticket t')
						->set('t.closed_by ', '?', $this->_userType)
						->set('t.closed_id ', '?', $this->_id)
						->set('t.close_date', '?', $this->_today->get(Zend_Date::W3C))
						->where('t.id = ? ', $ticket_id);
				try
				{
					$query->execute();
				}
				catch(Exception $e)
				{
					print('Unable to update ticket data while ticket is being closed') . $e;
					exit();
				}
			}
			return true;
		}
		//TODO implement exception handler
	}
	/*
	 * Show the complete details of a ticket
	 * @ return records
	 */
	public function showTicket($ticketId, $user_id = NULL, $ticketType = NULL)
	{
		if($this->_id)
		{
			if($this->_userType=='player')
			{
				$user_id = $this->_id;
				$connName = Zenfox_Partition::getInstance()->getConnections($user_id);
           		Doctrine_Manager::getInstance()->setCurrentConnection($connName);
           		$query = Zenfox_Query::create()
           				->from('TicketData t')
           				->where('t.ticket_id = ?', $ticketId)
           				->andWhere('t.user_id = ?', $this->_id)
           				->andWhereIn('t.ticket_status', array('OPEN', 'CLOSE'))
           				->orderBy('t.time desc');
           			
           		$records = $query->fetchArray();
           		return $records;
			}
			if($this->_userType=='affiliate')
			{
				$connName = Zenfox_Partition::getInstance()->getMasterConnection();
           		Doctrine_Manager::getInstance()->setCurrentConnection($connName);
           		$query = Zenfox_Query::create()
           				->from('TicketData t')
           				->where('t.ticket_id = ? ', $ticketId)
           				->andWhere('t.user_id = ?',$this->_id)
           				->andWhereIn('t.ticket_status', array('OPEN', 'CLOSE'));
           			
           		$records = $query->fetchArray();
           		return $records;
			}
			if($ticketType == 'affiliate')
			{
				$connName = Zenfox_Partition::getInstance()->getConnections(0);
			}
			else
			{
				$connName = Zenfox_Partition::getInstance()->getConnections($user_id);
			}
			
           	Doctrine_Manager::getInstance()->setCurrentConnection($connName);
           	$query = Zenfox_Query::create()
           			->from('TicketData t')
           			->where('t.ticket_id = ? ', $ticketId)
           			->andWhere('t.user_id = ?',$user_id);
           			
           	try
           	{
           		$records = $query->fetchArray();
           	}
           	catch(Exception $e)
           	{
           		print_r($e); exit();
           	}
           	return $records;
		}
		//TODO implement exception handler
	}
	
	public function forwardedTicket($ticketData, $userId, $ticketId = NULL)
	{
		$forwarded = $this->_ticket->get('Forwarded');
		$forwarded['forwarded_by'] = $this->_id;
		//TODO add this field in form
		//Done Store the ids in TicketForm
		$forwarded['forwarded_to'] = $ticketData['csrId'];
		$forwarded['forwarded_time'] = $this->_today->get(Zend_Date::W3C);
		$forwarded['forwarded_note'] = $ticketData['note'];
		$forwarded['user_id'] = $userId;
		$forwarded['user_type'] = 'player';
		
		$connName = Zenfox_Partition::getInstance()->getConnections($userId);
		$partition = Doctrine_Manager::getInstance()->getConnection($connName);
		
		if($ticketId)
		{
			$forwarded['ticket_id'] = $ticketId;
			try
			{
				$forwarded->save($partition);
			}
			catch(Exception $e)
			{
				print('Unable to save player forwarded data') . $e;
				exit();
			}
			return true;
		}
		try
		{
			$this->_ticket->save($partition);
		}
		catch(Exception $e)
		{
			print('Unable to save forwarded ticket data') . $e;
			exit();
		}
		return true;
	}
	
	public function deleteTicket($ticketId)
	{
		$connName = Zenfox_Partition::getInstance()->getConnections($this->_id);
		$partition = Doctrine_Manager::getInstance()->getConnection($connName);
		
		$query = Zenfox_Query::create()
					->delete('Ticket t')
					->where('t.id = ?', $ticketId)
					->andWhere('t.user_id = ?', $this->_id);
		
		try
		{
			$query->execute();
		}
		catch(Exception $e)
		{
			return false;
		}
		
		$query = Zenfox_Query::create()
					->delete('TicketData td')
					->where('td.ticket_id = ?', $ticketId)
					->andWhere('td.user_id = ?', $this->_id);
		
		try
		{
			$query->execute();
		}
		catch(Exception $e)
		{
			return false;
		}
		
		return true;
	}
}