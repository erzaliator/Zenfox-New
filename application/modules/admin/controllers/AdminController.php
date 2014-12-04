<?php

require_once dirname(__FILE__).'/../forms/CsrGenerationForm.php';
require_once dirname(__FILE__).'/../forms/GroupGenerationForm.php';
require_once dirname(__FILE__).'/../forms/EditCsrForm.php';
require_once dirname(__FILE__).'/../forms/EditGroupForm.php';

class Admin_AdminController extends Zenfox_Controller_Action
{
	public function init()
	{
		parent::init();
		$this->_redirector = $this->_helper->getHelper('Redirector');
        $contextSwitch = $this->_helper->getHelper('contextSwitch');
        $contextSwitch->setAutoJsonSerialization(false);
		$contextSwitch->addActionContext('createcsr', 'json')
					  ->addActionContext('creategroup', 'json')	
					  ->addActionContext('listallcsrs', 'json')
					  ->addActionContext('editcsrAction', 'json')							
              	->initContext();
        //Zend_Layout::getMvcInstance()->disableLayout();
	}
	public function createcsrAction()
	{
		$csr = new Csr();
		$form = new Admin_CsrGenerationForm();
		$gmsGroup = new GmsGroup();
		$groups = $gmsGroup->getAllGroups();
		$getGms = $this->getRequest()->getGms;
		$from = $this->getRequest()->from;
		if ($getGms)
		{
			$this->view->groups = $groups;
			
		}
		
		/*else if ($from == 'extjs')
		{
			print_r($_POST);
			foreach($_POST as $value)
			{
				$_POST['alias'] = $_POST['alias'];
				$_POST['passwd'] = $_POST['passwd'];
				$_POST['enabled'] = $_POST['enabled'];
				for($i=0; $i<count($_POST)-4 ;$i++)
				{
					$arr[$i]  = $_POST['g'.$i];
				}	
				$_POST['groups'] = $arr ;
			}
		}*/
		
		
		$this->view->form = $form->setupForm($groups);
		
		if($this->getRequest()->isPost())
		{
			if($form->isValid($_POST))
			{
				//Zenfox_Debug::dump($_POST,'valid post',true,true);
					$data = $form->getValues();
					if($data)
				{
					$result = $csr->createCsr($data);
					if($result == -1)
					{
						$this->view->Success = 'false';
					//	echo 'Csr with this alias already exists. Please choose another alias';
					}
					else
					{
						$this->view->Success = 'true';
						//$this->_helper->FlashMessenger(array('error' => 'Transaction not saved'));
						//echo 'Create Successful';
					}
				}
			}
		  }
				
	}
	
	public function creategroupAction()
	{
		$gmsGroup = new GmsGroup();
		$form = new Admin_GroupGenerationForm();
		$csr = new Csr();
		$menu = new GmsMenu();
		$group = new GmsGroup();
		$csrs = $csr->getAllCsrs();
		$menus = $menu->getAllMenus();
		$this->view->form = $form->setupForm($csrs,$menus);
		
		
		$getCsrs = $this->getRequest()->getCsrs;
		$getmenu = $this->getRequest()->getMenu;
		if($getmenu)
		{
			$this->view->Menu = $menus;
		}
		if($getCsrs)
		{
			$this->view->Csrs = $csrs;
		}
		else {
		
		if($this->getRequest()->isPost())
		{
			if($form->isValid($_POST))
			{
				$data = $form->getValues();
				$result = $group->createGroup($data);
				if($result)
				{
					//$this->_helper->FlashMessenger(array('error' => 'Transaction not saved'));
					echo 'Create Successful';
				}
			}
		}
	  }
	}
	
	public function listallcsrsAction()
	{
		$csr = new Csr();
		$result = $csr->getAllCsrs();
		$gmsGroup = new GmsGroup();
		$allGroups = $gmsGroup->getAllGroups();
		$state = 0;
		//Zenfox_Debug::dump($allGroups,'all',true,true);
		if(!$result)
		{
			//$this->_helper->FlashMessenger(array('error' => 'No Menus or Links to display'));
			echo 'No Csrs to display';
		}
		else
		{
			$translate = Zend_Registry::get('Zend_Translate');
		    foreach($result as $logs)
			{	
				$csrGmsGroup = new CsrGmsGroup();
				$groups = $csrGmsGroup->getGroups($logs['id']);
				
				$groupNames = array();
				if($groups)
				{
					foreach($groups as $group)
					{
						$groupNames[] = $group['name'];
						$preGroupNames[] = $group['id'].'*'.$group['name'];

					}
				}
				
				foreach($allGroups as $group1)
				{
					
					if($groups)
					{
						foreach($groups as $pre)
						{
							if($pre['id'] != $group1['id'])
							{
								
								$state = 1;
							}
								
						}
						if($state == 1)
						{
						  $otherGroups[] =  $group1['id'].'*'.$group1['name'];
						  $state = 0;
						  
						}
						
					}
					else 
					{
						//$otherGroups[] =  $group1['id'].'*'.$group1['name'];
					}
					
				}
				
				$groupString = "";
				$otherGroupString = "";
				$preGroupString = "";
				$preGroupString = implode(",", $preGroupNames);
				$otherGroupString = implode(",", $otherGroups);
				$groupString = implode(",", $preGroupNames);
				$table[$index][$translate->translate('Alias')] = $logs['alias'];
				$table[$index][$translate->translate('Name')] = $logs['name'];
				$table[$index][$translate->translate('Associated Groups')] = $groupString;
				$table[$index][$translate->translate('Pre Groups')] = $preGroupString;
				$table[$index][$translate->translate('Other Groups')] = $otherGroupString;				
				$table[$index][$translate->translate('Enabled/Disabled')] = $logs['enabled'];
				$table[$index][$translate->translate('Edit')] = 'Edit';
				$idArray[$index] =$logs['id'];
				$index++;
				//$otherGroups = Null;
			}
			
			$this->view->results = $table;
			$this->view->ids = $idArray;
		}
	}
	
	public function editcsrAction()
	{
		
		$id = $this->getRequest()->id;
		$form = new Admin_EditCsrForm();
		$csr = new Csr();
		$csrGmsGroup = new CsrGmsGroup();
		$gmsGroup = new GmsGroup();
		$data = $csr->getInfo($id);
		
		$allGroups = $gmsGroup->getAllGroups();
		$preGroups = $csrGmsGroup->getGroups($id);
		$otherGroups = array();
		foreach($allGroups as $group)
		{
			$state = 1;
			if($preGroups)
			{
				foreach($preGroups as $pre)
				{
					if($pre['id'] == $group['id'])
					{
						$state = 0;
					}	
				}
			}
			if($state)
			{
				$otherGroups[] = $group;	
			}
		}
		$this->view->form = $form->setupForm($data[0],$preGroups,$otherGroups);
		
		if($this->getRequest()->isPost())
		{
			if($form->isValid($_POST))
			{			
				$newdata = $form->getValues();

				/*if($data[0]['passwd'] != $newdata['passwd'])
				{
					echo 'Error !! You did not enter your old password correctly';
				}
				else
				{*/
					$result = $csr->editCsr($id,$newdata,$preGroups);
					if($result)
					{
						$this->_helper->FlashMessenger(array('notice' => 'Profile is edited successfully'));
					}
				//}
			}
		}
	}
	
	public function listallgroupsAction()
	{
		$group = new GmsGroup();
		$result = $group->getAllGroups();
		if(!$result)
		{
			//$this->_helper->FlashMessenger(array('error' => 'No Menus or Links to display'));
			echo 'No Csrs to display';
		}
		else
		{
			$translate = Zend_Registry::get('Zend_Translate');
		    foreach($result as $logs)
			{	
				$csrGroup = new CsrGmsGroup();
				$csrs = $csrGroup->getCsrs($logs['id']);
				$csrNames = array();
				if($csrs)
				{
					foreach($csrs as $csr)
					{
						$view = new Zend_View();
						//$csrNames[] = $csr['name'];
				//		$csrNames[] = ''.'<a href="/admin/editcsr/'.$csr[id].'">'.$csr['name'].'</a><br />';
						$csrNames[] = ''.'<a href="'.$view->url(array(																													
										'action'     => 'editcsr',
										'id'         =>  $logs['id'])
															).'">'.$csr['name'].'</a><br />';									
					}
				}
				
				$csrString = "";
				$csrString = implode(",", $csrNames);
				
				$groupMenu = new GmsGroupGmsMenu();
				$menus = $groupMenu->getMenus($logs['id']);
				$menuNames = array();
				if($menus)
				{
					foreach($menus as $menu)
					{
						$menuNames[] = $menu['name'];
					}
				}
				$menuString = "";
				$menuString = implode(",", $menuNames);
				$table[$index][$translate->translate('Name')] = $logs['name'];
				$table[$index][$translate->translate('Description')] = $logs['description'];
				$table[$index][$translate->translate('Associated Csrs')] = $csrString;				
				$table[$index][$translate->translate('Associated Menus')] = $menuString;
				$table[$index][$translate->translate('Edit')] = 'Edit';
				$idArray[$index] =$logs['id'];
				$index++;
			}
			
			$this->view->results = $table;
			$this->view->ids = $idArray;
		}
	}
	
	public function editgroupAction()
	{
		$id = $this->getRequest()->id; 	
		$form = new Admin_EditGroupForm();
		$csr = new Csr();
		$csrGmsGroup = new CsrGmsGroup();
		$group = new GmsGroup();
		$gmsMenu = new GmsMenu();
		$groupMenu = new GmsGroupGmsMenu();
		$data = $group->getInfo($id);
		
		$allCsrs = $csr->getAllCsrs();
		$preCsrs = $csrGmsGroup->getCsrs($id);
		$otherCsrs = array();
		
		foreach($allCsrs as $csr)
		{
			$state = 1;
			if($preCsrs)
			{
				foreach($preCsrs as $pre)
				{
					if($pre['id'] == $csr['id'])
					{
						$state = 0;
					}	
				}
			}
			if($state)
			{
				$otherCsrs[] = $csr;	
			}
		}
		
		$allMenus = $gmsMenu->getAllMenus();
		$preMenus = $groupMenu->getMenus($id);
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
		$this->view->form = $form->setupForm($data[0],$preCsrs,$otherCsrs,$preMenus,$otherMenus);
		
		if($this->getRequest()->isPost())
		{
			if($form->isValid($_POST))
			{
				$data = $form->getValues();
				$result = $group->editGroup($id,$data,$preCsrs,$preMenus);
				if($result)
				{
					echo 'Edit Successful';
				}
			}
		}
	}
}
