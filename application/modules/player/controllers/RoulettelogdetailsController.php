<?php
class Player_RoulettelogdetailsController extends Zenfox_Controller_Action
{
	public function indexAction()
	{
		$session = new Zend_Auth_Storage_Session();
		$store = $session->read();
		$playerId = $store['id'];
		$logId = $this->getRequest()->logId;
		$sessionId = $this->getRequest()->sessId;
		
		$gamelogRoulette = new GamelogRoulette();
		$gamelogDetails = $gamelogRoulette->getRoulettelogDetails($logId, $sessionId, $playerId);
		$machineInstance = new Roulette();
		$Files = $machineInstance->getFilesPathFromId($gamelogDetails['machineId']);
		
		$swfFile =  $Files["swfFile"];
		if(!$gamelogDetails)
		{
			$this->_helper->FlashMessenger(array('error' => 'No log detail found.'));
		}
		$this->view->swfFile = $swfFile;
		$this->view->logDetails = $gamelogDetails;
	}
}