<?php
/**
 * This class is used to display photos of players
 */

class Player_GalleryController extends Zenfox_Controller_Action
{
	public function init()
	{
		parent::init();
	}
	
	public function indexAction()
	{
		$offset = $this->getRequest()->page;
		$clientIpAddress = Zend_Controller_Front::getInstance()->getRequest()->getClientIp();
		
		$sessionName = 'Gallery_' . $clientIpAddress;
		$session = new Zend_Session_Namespace($sessionName);
		$player = new Player();
		if($offset)
		{
			$itemsPerPage = $this->getRequest()->item;
			$recentJoiners = $player->getRecentJoiners($offset, $itemsPerPage, $session);
		}
		else
		{
			$recentJoiners = $player->getRecentJoiners(1, 12, $session);
		}
		
		$this->view->paginator = $recentJoiners[0];
		$this->view->recentJoiners = $recentJoiners[1];
	}
}
