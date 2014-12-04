<?php
require_once dirname(__FILE__).'/../forms/GameGroupForm.php';

class Admin_GamegroupController extends Zenfox_Controller_Action
{
	public function indexAction()
	{
		$gamegroupInstance = new Gamegroup();
		$gamegroups = $gamegroupInstance->getAllGroups();
		$this->view->gamegroups = $gamegroups;
	}
	
	public function viewgroupAction()
	{
		$request = $this->getRequest();
		$id = $request->id;
		$gamegroupInstance = new Gamegroup();
		$groupsDetails = $gamegroupInstance->getGroupDetails($id);
		foreach($groupsDetails as $key => $value)
		{
			$groupName = $key;
			$groupData = $value;
		}
		
		//print_r($groupData);
		
		$this->view->groupName = $groupName;
		$this->view->groupData = $groupData;
		$this->view->groupId = $id;
		//print_r($groups);
	}
	
	public function creategroupAction()
	{
		$form = new Admin_GameGroupForm();
		$gameGroupForm = $form->getForm();
		$this->view->form = $gameGroupForm;
		$request = $this->getRequest();
		if($request->isPost())
		{
			if($gameGroupForm->isValid($_POST))
			{
				$gameGroupConfig = new GameGroupConfig();
				$gameGroupConfig->insertGameGroup($_POST);
				$gameGroup = new Gamegroup();
				$gameGroupId = $gameGroup->getIdByGameGroupName($_POST['name']);
				$flavour = new Flavour();
				$gameFlavours = $flavour->getGameFlavours();
				foreach($gameFlavours as $gameFlavour)
				{
					if($_POST[$gameFlavour])
					{
						$runningMachineIds = $_POST[$gameFlavour];
						foreach($runningMachineIds as $runningMachineId)
						{
							$gameGroupConfig->insertGameGameGroup($gameFlavour,$runningMachineId,$gameGroupId);
						}
					}
				}
				$this->view->form = '';
				echo 'Game group is added';
			}
		}
	}
	public function editgroupAction()
	{
		$form = new Admin_GameGroupForm();
		$request = $this->getRequest();
		$groupId = $request->id;
		$gameGroup = new Gamegroup();
		$groupDetails = $gameGroup->getGameGroup($groupId);
		$groupData['name'] = $groupDetails['name'];
		$groupData['description'] = $groupDetails['description'];
		$gameGameGroup = new GameGamegroup();
		$allGameData = $gameGameGroup->getGameDetails($groupId);
		foreach($allGameData as $flavour => $machineDetails)
		{
			$runningMachineIds = array();
			foreach($machineDetails as $id => $data)
			{
				$runningMachineIds[] = $id;
			}
			$groupData[$flavour] = $runningMachineIds;
		}
		$gameGroupForm = $form->setForm($groupData);
		$this->view->form = $gameGroupForm;
		
		if($request->isPost())
		{
			if($gameGroupForm->isValid($_POST))
			{
				$gameGroupConfig = new GameGroupConfig();
				$gameGroupConfig->updateGameGroup($groupId, $_POST);
				
				//$gameGroupConfig->deleteGameGameGroups($groupId);
				$flavour = new Flavour();
				$gameFlavours = $flavour->getGameFlavours();
				foreach($gameFlavours as $gameFlavour)
				{
					$runningMachineIds = $_POST[$gameFlavour];
					$ids = $gameGameGroup->getRunningMachineIds($groupId,$gameFlavour);
					if($runningMachineIds)
					{
						foreach($ids as $id)
						{
							if (!in_array($id,$runningMachineIds))
							{
								$gameGroupConfig->deleteGameGameGroup($groupId,$gameFlavour,$id);
							}
						}
					}
					else
					{
						foreach($ids as $id)
						{
							$gameGroupConfig->deleteGameGameGroup($groupId,$gameFlavour,$id);
						}
					}
					if($_POST[$gameFlavour])
					{
						foreach($runningMachineIds as $runningMachineId)
						{
							if(!$gameGameGroup->getGameGameGroup($groupId,$gameFlavour,$runningMachineId))
							{
								$gameGroupConfig->insertGameGameGroup($gameFlavour,$runningMachineId,$groupId);
							}
							
						}
					}
					
				}
				$this->view->form = '';
				echo 'data is updated';
			}
		}
	}
}