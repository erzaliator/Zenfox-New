<?php

require_once dirname(__FILE__) . '/../forms/DateSelectionForm.php';
class Player_RummylogController extends Zenfox_Controller_Action
{
	public function indexAction()
	{
		$session = new Zend_Auth_Storage_Session();
		$store = $session->read();
		
		//TODO Commentedout after testing
		$playerId = $store['id'];
		$fromPM = false;
		//$playerId = 43;

		$offset = $this->getRequest()->page;
		$playerGamelog = new PlayerGamelog();
		if($offset)
		{
			$fromTime = $this->getRequest()->from;
			$toTime = $this->getRequest()->to;
			$itemsPerPage = $this->getRequest()->items;
			
			$explodeFromTime = explode(" ", $fromTime);
			$fromDate = $explodeFromTime[0];
			$explodeTime = explode(":", $explodeFromTime[1]);
			$fromHour = $explodeTime[0];
			$fromMinute = $explodeTime[1];
			if($fromHour >= 12)
			{
				$fromPM = true;
			}
			
			$explodeToTime = explode(" ", $toTime);
			$toDate = $explodeToTime[0];
			$explodeTime = explode(":", $explodeToTime[1]);
			$toHour = $explodeTime[0];
			$toMinute = $explodeTime[1];
			if($toHour >= 12)
			{
				$toPM = true;
			}
			
			$result = $playerGamelog->getPlayerGamelogDetails($playerId, $itemsPerPage, $offset, $fromTime, $toTime);
			if(!$result)
			{
				$this->_helper->FlashMessenger(array('error' => 'No record found.'));
			}
			$this->view->paginator = $result[0];
			$this->view->contents = $result[1];
			$this->view->fromDate = $fromTime;
			$this->view->toDate = $toTime;
			$this->view->playerId = $playerId;
			
			$this->view->fromDate = $fromDate;
			$this->view->toDate = $toDate;
			$this->view->fromHour = $fromHour;
			$this->fromMinute = $fromMinute;
			$this->view->toHour = $toHour;
			$this->view->toMinute = $toMinute;
			$this->view->fromPM = $fromPM;
			$this->view->toPM = $toPM;
			$this->view->items = $itemsPerPage;
		}
		
		//$form = new Player_DateSelectionForm();
		//$this->view->form = $form;
		if($this->getRequest()->isPost())
		{
			
				$data = $_POST;
			
			if($data['p_from_time'] == 'pm' && $data['h_from_time'] != 12)
			{
				$data['h_from_time'] = $data['h_from_time'] + 12;
			}
			if($data['p_from_time'] == 'am' && $data['h_from_time'] == 12)
			{
				$data['h_from_time'] = '00';
			}
			if($data['p_to_time'] == 'pm' && $data['h_to_time'] != 12)
			{
				$data['h_to_time'] = $data['h_to_time'] + 12;
			}
			if($data['p_to_time'] == 'am' && $data['h_to_time'] == 12)
			{
				$data['h_to_time'] = '00';
			}
			
			if($data['p_from_time'] == 'pm')
			{
				$fromPM = true;
			}
			if($data['p_to_time'] == 'pm')
			{
				$toPM = true;
			}
				
				$offset = 1;
				$fromTime = $data['from_date'] . " " . $data['h_from_time'] . ":" . $data['m_from_time'];
			$toTime = $data['to_date'] . " " . $data['h_to_time'] . ":" . $data['m_to_time'];
				
				$result = $playerGamelog->getPlayerGamelogDetails($playerId, $data['page'], $offset, $fromTime, $toTime);
				if(!$result)
				{
					$this->_helper->FlashMessenger(array('error' => 'No record found.'));
				}
				$this->view->paginator = $result[0];
				$this->view->contents = $result[1];
				$this->view->fromDate = $fromTime;
				$this->view->toDate = $toTime;
				$this->view->playerId = $playerId;
				
				$this->view->fromDate = $data['from_date'];
			$this->view->toDate = $data['to_date'];
			$this->view->fromHour = $data['h_from_time'];
			$this->fromMinute = $data['m_from_time'];
			$this->view->toHour = $data['h_to_time'];
			$this->view->toMinute = $data['m_to_time'];
			$this->view->fromPM = $fromPM;
			$this->view->toPM = $toPM;
			$this->view->items = $data['page'];
			
		}
		if(!$this->getRequest()->isPost() && !$offset)
		{
			$date = new Zend_Date();
			$currentDate = $date->get(Zend_Date::DAY);
			$currentMonth = $date->get(Zend_Date::MONTH);
			$currentYear = $date->get(Zend_Date::YEAR);
			$currentHour = $date->get(Zend_Date::HOUR);
			$currentMinute = $date->get(Zend_Date::MINUTE);
			
			$today = $currentYear . "-" . $currentMonth . "-" . $currentDate;
			$pm = false;
			
			if($currentHour >= 12)
			{
				$pm = true;
			}
			
			$this->view->fromDate = $today;
			$this->view->toDate = $today;
			$this->view->fromHour = 0;
			$this->fromMinute = 0;
			$this->view->toHour = $currentHour;
			$this->view->toMinute = $currentMinute;
			$this->view->fromPM = false;
			$this->view->toPM = $pm;
			$this->view->items = 0;
			
			$this->_helper->FlashMessenger(array('notice' => 'Choose a datetime and select the game you want to analyze.<br>Get a setp by step analysis of your rummy game by clicking next.<br>Analyze your games and improve your skill in Rummy.'));
		}
	}
	
	public function logAction()
	{
		Zend_Layout::getMvcInstance()->setLayout('popup_layout');
		
		$session = new Zenfox_Auth_Storage_Session();
		$storedData = $session->read();
		$playerId = $storedData['id'];
		$sessionId = $this->getRequest()->sessId;
		$gameId = $this->getRequest()->gameId;
		$flavour = $this->getRequest()->flavour;
		
		$this->view->gameId = $gameId;
		$this->view->sessionId = $sessionId;
		$this->view->flavour = $flavour;
		$this->view->playerId = $playerId;
	}
}
