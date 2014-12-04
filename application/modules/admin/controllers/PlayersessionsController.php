<?php
require_once dirname(__FILE__).'/../../player/models/PlayerSession.php';
class Admin_PlayersessionsController extends Zenfox_Controller_Action
{
	public function indexAction()
	{
		$playerSession = new PlayerSession();
		$request = $this->getRequest();
		$offset = $request->page;
		if($request->isPost())
		
			$itemsPerPage = $request->items;
			
		elseif($request->itemsPerPage)
		
			$itemsPerPage = $request->itemsPerPage;
	
		else
		
			$itemsPerPage = 2;
		
        	  
        if(!$offset)
        {
        	$offset = 1;
        }
        
        $paginator = $playerSession->getAllPlayerSessions($offset, $itemsPerPage);
        $items = $paginator->getCurrentItems();
        $frontend = new Frontend();
        if($items[0])
        {
        	$headings = array_keys($items[0]);
        }
        for($i = 0; $i<count($items);$i++)
        {
        	$item = $items[$i];
        	$frntend = $frontend->getFrontendById($item['frontend_id']);
        	$item['frontend_id'] = $frntend['name'];
        	$playerFrntend = $frontend->getFrontendById($item['player_frontend_id']);
        	$item['player_frontend_id'] = $playerFrntend['name'];
        	$items[$i] = $item;
        }
        
        $this->view->items = $items;
		$this->view->headings = $headings;
        $this->view->paginator = $paginator;
        
	}
	
	public function viewsfsAction()
	{
		$request = $this->getRequest();
		$playerId = $request->id;
		$page = $request->page;
		$sfsLoginInstance = new SfsLogin();
		$sfsLogins = $sfsLoginInstance->getSfsLoginsByPlayerId($playerId);
		if($sfsLogins)
		{
			$headings = array_keys($sfsLogins[0]);
		}
		$this->view->page = $page;
		$this->view->headings = $headings;
		$this->view->sfsLogins = $sfsLogins;
	}
}