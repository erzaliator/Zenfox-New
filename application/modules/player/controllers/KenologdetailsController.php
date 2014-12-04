<?php
class Player_KenologdetailsController extends Zenfox_Controller_Action
{
	public function init()
	{
		parent::init();
	}
	public function indexAction()
	{
		$session = new Zend_Auth_Storage_Session();
		$store = $session->read();
		$playerId = $store['id'];
		$logId = $this->getRequest()->logId;
		$sessionId = $this->getRequest()->sessId;
		
		$gamelogKeno = new GamelogKeno();
		$gamelogDetails = $gamelogKeno->getKenologDetails($logId, $sessionId, $playerId);
		$machineInstance = new Keno();
		$swfFile = $machineInstance->getFilesPathFromId($gamelogDetails['machineId']);

		if(!$gamelogDetails)
		{
			$this->_helper->FlashMessenger(array('error' => 'No log detail found.'));
		}
		$this->view->swfFile = $swfFile;
		$this->view->logDetails = $gamelogDetails;
	}
}