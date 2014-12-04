<?php
require_once dirname(__FILE__).'/../forms/ReferForm.php'; 

class Player_ReferController extends Zenfox_Controller_Action
{
	 public function referAction()
	 {
		$session = new Zenfox_Auth_Storage_Session();
		$store = $session->read();
		//Zenfox_Debug::dump($store, 'store');
		$playerId = $store['id'];

		$player = new Player();
		$playerEmail = $player->getEmailFromPlayerId($playerId);

		$referForm = new Player_ReferForm();
		$this->view->form = $referForm->getForm();
		
		if($this->getRequest()->isPost())
		{
			if($referForm->isValid($_POST))
			{
				$result = $referForm->getValue('mailIds');
				//Zenfox_Debug::dump($result, $result, true, true);
			}
		}	
	 }
}
