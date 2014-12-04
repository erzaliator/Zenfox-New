<?php

require_once dirname(__FILE__).'/../forms/MenuGenerationForm.php';
require_once dirname(__FILE__).'/../forms/EditMenuForm.php';
require_once dirname(__FILE__).'/../forms/EditLinkForm.php';

class Admin_MenuController extends Zenfox_Controller_Action
{
	public function init()
	{
		parent::init();
		$this->_redirector = $this->_helper->getHelper('Redirector');
        $contextSwitch = $this->_helper->getHelper('contextSwitch');
        $contextSwitch->setAutoJsonSerialization(false);
		$contextSwitch->addActionContext('jsonmenu', 'json')				
              	->initContext();
        Zend_Layout::getMvcInstance()->disableLayout();
	}
	
	public function jsonmenuAction()
	{
		$allowLinksObj = new AdminMenu();
		$allowLink = $allowLinksObj->getJsonLink();
		
		//Zenfox_Debug::dump($allowLink , 'links' , true , true);
		return $this->view->links = $allowLink;		
		
	}

	public function createAction()
	{
		$menu = new GmsMenu();
		$form = new Admin_MenuGenerationForm();
		$result = $menu->getAllLinks();
		$menus = $menu->getAllMenus();	
		$this->view->form = $form->setupForm($result,$menus);
		if($this->getRequest()->isPost())
		{
			if($form->isValid($_POST))
			{
				$data = $form->getValues();
				$result = $menu->createMenu($data);
				if($result)
				{
					//$this->_helper->FlashMessenger(array('error' => 'Transaction not saved'));
					echo 'Create Successful';
				}
			}
		}		
	}
	
	public function listallmenusAction()
	{
		$menu = new GmsMenu();
		$result = $menu->listAllMenus();
		if(!$result)
		{
			//$this->_helper->FlashMessenger(array('error' => 'No Menus or Links to display'));
			echo 'No Menus or Links to display';
		}
		else
		{
			$this->view->results = $result[0];
			$this->view->ids = $result[1];
		}
	}
	
	public function editmenuAction()
	{
		$id = $this->getRequest()->id;
		$form = new Admin_EditMenuForm();
		$gmsMenu = new GmsMenu();
		$gmsMenuLink = new GmsMenuLink();
		$data = $gmsMenu->getInfo($id);
		$allLinks = $gmsMenu->getAllLinks();
		$allMenus = $gmsMenu->getAllMenus();
		$preLinks = $gmsMenuLink->getLinks($id);
		$preParents = $gmsMenuLink->getParents($id);
		$otherLinks = array();
		$otherMenus = array();
		if(!$preLinks)
		{
			$otherLinks = $allLinks;	
		}
		else
		{
			foreach($allLinks as $link)
			{
				$state = 1;
				foreach($preLinks as $pre)
				{
					if($pre['id'] == $link['id'])
					{
						$state = 0;
					}	
				}
				if($state)
				{
					if($link['link'] == 'LINK')
						$otherLinks[] = $link;	
				}
			}
		}
		
		foreach($allMenus as $menu)
		{
			$state = 1;
			if($preParents)
			{
				foreach($preParents as $pre)
				{
					if($pre['id'] == $menu['id'])
					{
						$state = 0;
					}	
				}
			}
			if($state)
			{
				$otherMenus[] = $menu;	
			}
		}
		
		$this->view->form = $form->setupForm($data[0],$preLinks,$otherLinks,$preParents,$otherMenus);
		
		if($this->getRequest()->isPost())
		{
			if($form->isValid($_POST))
			{
				$data = $form->getValues();
				$result = $gmsMenu->editMenu($id,$data,$preLinks,$preParents);
				if($result)
				{
					echo 'Edit Successful';
				}	
			}
		}
	}
	
	public function listalllinksAction()
	{
		$link = new GmsMenu();
		$result = $link->listAllLinks();
		if(!$result)
		{
			//$this->_helper->FlashMessenger(array('error' => 'No Menus or Links to display'));
			echo 'No Menus or Links to display';
		}
		else
		{
			$this->view->results = $result;
		}
	}
	
	public function editlinkAction()
	{
		$id = $this->getRequest()->id;
		$form = new Admin_EditLinkForm();
		$gmsMenu = new GmsMenu();
		$gmsMenuLink = new GmsMenuLink();
		$data = $gmsMenu->getInfo($id);
		
		$allMenus = $gmsMenu->getAllMenus();
		$preMenus = $gmsMenuLink->getParents($id);
		$otherMenus = array();
		foreach($allMenus as $menu)
		{
			$state = 1;
			if($preMenus)
			{
				foreach($preMenus as $pre)
				{
					if($pre['id'] == $menu['id'])
					{
						$state = 0;
					}	
				}
			}
			if($state)
			{
				$otherMenus[] = $menu;	
			}
		}
		$this->view->form = $form->setupForm($data[0],$preMenus,$otherMenus);
		
		if($this->getRequest()->isPost())
		{
			if($form->isValid($_POST))
			{
				$data = $form->getValues();
				$result = $gmsMenu->editLink($id,$data,$preMenus);
				if($result)
				{
					echo 'Edit Successful';
				}		
			}
		}
	}
}
