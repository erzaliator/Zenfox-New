<?php

require_once APPLICATION_PATH . '/modules/player/models/CefGamelog.php';
require_once APPLICATION_PATH . '/modules/player/models/CefGamelogArchive.php';

class Admin_RummygamelogController extends Zenfox_Controller_Action
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
		if($this->getRequest()->isPost())
		{
			$gameFlavour = $this->getRequest()->getParam('gameFlavour');
			$sessionId = $this->getRequest()->getParam('sessionId');
			$gameId = $this->getRequest()->getParam('gameId');
			
			$cefGamelog = new CefGamelog();
			$archiveId = $cefGamelog->getArchiveId($gameFlavour, $sessionId, $gameId);
			
			$cefGamelogArchive = new CefGamelogArchive();
			$gameLog = $cefGamelogArchive->getGamelog($sessionId, $archiveId);
			
			$data['success'] = true;
			$data['gameLog'] = $gameLog;
			$this->view->result = $data;
		}
		else
		{
			$data['success'] = false;
			$this->view->result = $data;
		}
	}
}