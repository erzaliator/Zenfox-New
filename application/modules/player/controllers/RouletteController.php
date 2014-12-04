<?php
require_once dirname(__FILE__).'/../forms/DateSelectionForm.php';
class Player_RouletteController extends Zenfox_Controller_Action
{	
	public function init()
	{
		parent::init();
		$contextSwitch = $this->_helper->getHelper('contextSwitch');
		$contextSwitch->addActionContext('index', 'json')
              	->initContext();
	}
	
	public function indexAction()
	{
		
	}
	
	public function gamelogAction()
	{
		$session = new Zend_Auth_Storage_Session();
		$store = $session->read();
		//$role = explode('-', $store['id']);
		$player_id = $store['id'];
		if(!$player_id)
		{
			$this->_helper->FlashMessenger(array('error' => 'No record found.'));
		}
		//TODO get id from zend_session
		$form = new Player_DateSelectionForm();
		$this->view->form = $form;
		//$player_id = $this->getRequest()->id;
		$roulette = new RouletteLog($player_id);
		$offset = $this->getRequest()->pages;
		
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
				
			$fromDate = $data['from_date'] . " " . $data['h_from_time'] . ":" . $data['m_from_time'];
			$toDate = $data['to_date'] . " " . $data['h_to_time'] . ":" . $data['m_to_time'];
			
			$offset = 1;

			//$offset = $this->getRequest()->page;
			$result = $roulette->showLog($data['page'], $offset, $fromDate, $toDate);
			if(!$result)
			{
				$this->_helper->FlashMessenger(array('error' => 'No roulette record found.'));
			}
			$this->view->paginator = $result[0];
			$this->view->contents = $result[1];
			$this->view->fromDate = $fromDate;
			$this->view->toDate = $toDate;
			$this->view->playerId = $player_id;
			
			$this->view->from = $data['from_date'];
			$this->view->to = $data['to_date'];
			$this->view->fromHour = $data['h_from_time'];
			$this->fromMinute = $data['m_from_time'];
			$this->view->toHour = $data['h_to_time'];
			$this->view->toMinute = $data['m_to_time'];
			$this->view->fromPM = $fromPM;
			$this->view->toPM = $toPM;
			$this->view->items = $data['page'];
		}
		elseif($offset)
		{
			$itemsPerPage = $this->getRequest()->item;
			$from = $this->getRequest()->from;
			$to = $this->getRequest()->to;
			
			$explodeFromTime = explode(" ", $from);
			$fromDate = $explodeFromTime[0];
			$explodeTime = explode(":", $explodeFromTime[1]);
			$fromHour = $explodeTime[0];
			$fromMinute = $explodeTime[1];
			if($fromHour >= 12)
			{
				$fromPM = true;
			}
				
			$explodeToTime = explode(" ", $to);
			$toDate = $explodeToTime[0];
			$explodeTime = explode(":", $explodeToTime[1]);
			$toHour = $explodeTime[0];
			$toMinute = $explodeTime[1];
			if($toHour >= 12)
			{
				$toPM = true;
			}
			
			$result = $roulette->showLog($itemsPerPage, $offset, $from, $to);
			if(!$result)
			{
				$this->_helper->FlashMessenger(array('error' => 'No roulette record found.'));
			}
			$this->view->paginator = $result[0];
			$this->view->contents = $result[1];
			$this->view->fromDate = $from;
			$this->view->toDate = $to;
			$this->view->playerId = $player_id;
			
			$this->view->from = $fromDate;
			$this->view->to = $toDate;
			$this->view->fromHour = $fromHour;
			$this->fromMinute = $fromMinute;
			$this->view->toHour = $toHour;
			$this->view->toMinute = $toMinute;
			$this->view->fromPM = $fromPM;
			$this->view->toPM = $toPM;
			$this->view->items = $itemsPerPage;
		}
	}
}
