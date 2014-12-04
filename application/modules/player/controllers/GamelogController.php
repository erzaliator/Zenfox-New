<?php

/**
 * This class is used to display the gamelogs for every game
 */

//require_once dirname(__FILE__).'/../forms/DateSelectionForm.php';
class Player_GamelogController extends Zenfox_Controller_Action
{
	public function init()
	{
		parent::init();
		$contextSwitch = $this->_helper->getHelper('contextSwitch');
		$contextSwitch->addActionContext('log', 'json')
						->initContext();
	}
	
	public function indexAction()
	{
		/* $form = new Player_DateSelectionForm();
		$this->view->form = $form; */
		
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
	}
	
	public function logAction()
	{
		$frontendName = Zend_Registry::getInstance()->get('frontendName');
		if($frontendName == 'ace2jak.com')
		{
			Zend_Layout::getMvcInstance()->setLayout('popup_layout');
		}
		$authSession = new Zenfox_Auth_Storage_Session();
		$sessionData = $authSession->read();
		
		$playerId = $sessionData['id'];
		//$playerId = '65447';
		$sessionId = $this->getRequest()->sessionId;
		$gameId = $this->getRequest()->gameId;
				
		$miniflushGamelog = new MiniflushGamelog();
		$gameLogs = $miniflushGamelog->getGamelogsBySessionId($sessionId, $gameId, $playerId);
		
		$webConfig = Zend_Registry::get('webConfig');
		$flashDir = isset($webConfig['flashDir'])?$webConfig['flashDir']:"taashtime.tld/";
		$imagesDir = isset($webConfig['imagesDir'])?$webConfig['imagesDir']:"rummy.tld/";
		$hostName = $_SERVER['HTTP_HOST'];
		$hostAddress = 'http://' . $hostName;
		$this->view->hostAddress = $hostAddress;
		$this->view->flashDir = $flashDir;
		
		$this->view->gameLogs = Zend_Json::encode($gameLogs);
	}
}