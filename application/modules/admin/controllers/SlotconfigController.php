<?php
/**
 * This class implements slot configuration
 * @author Nikhil Gupta
 */
require_once dirname(__FILE__).'/../forms/SlotConfigForm.php';
require_once dirname(__FILE__).'/../forms/PjpForm.php';
require_once dirname(__FILE__).'/../forms/MainconfigForm.php';

class Admin_SlotconfigController extends Zenfox_Controller_Action
{
	public function init()
	{
		parent::init();
		$this->_redirector = $this->_helper->getHelper('Redirector');
        $contextSwitch = $this->_helper->getHelper('contextSwitch');
		$contextSwitch->addActionContext('create', 'json')
				->addActionContext('view', 'json')
				->addActionContext('edit', 'json')
              	->initContext();
	}
	
	/**
	 * This function is used to view all slots details
	 * 
	 */
	public function viewAction()
	{
		$runningSlot = new RunningSlot();
		$slotData = $runningSlot->getAllMachinesData();
		$this->view->slotData = $slotData;
	}
	
	/**
	 * This function is used to create new slot configuration
	 * 
	 */
	public function createAction()
	{
		$language = $this->getRequest()->getParam('lang');
		$form = new Admin_MainconfigForm();
//		$pjp = new PjpMachine();
//		$allPjpDetails = $pjp->getPjpDetails();
		$machineId = $this->getRequest()->machineId;
		if($machineId)
		{
			$this->view->form = $form->getNewSlotForm($machineId);
		}
		else
		{
			$slot = new Slot();
			$allSlotsDetails = $slot->getAllSlotsDetails();
			$this->view->slotDetails = $allSlotsDetails;
		}
		if($this->getRequest()->isPost())
		{
			if($form->isValid($_POST))
			{
				foreach($form->getSubForms() as $key => $subForm)
				{
					$data = $subForm->getValues();
					if($key == 'slotForm')
					{
						foreach($data as $slotData)
						{
							$runningSlotData = $this->insertSlotData($slotData);
							//Zenfox_Debug::dump($runningSlotData,'slotData');
							$runningSlotId = $runningSlotData['runningSlotId'];
							if($runningSlotData['pjpEnabled'] == 'ENABLED')
							{
								$pjpEnabled = true;
							}
							else
							{
								$pjpEnabled = false;
							}
							if(!($runningSlotData))
							{
								//TODO write an error handler
							}
						}
					}
					elseif(($subForm->getValue('checkBox')) && ($pjpEnabled))
					{
						//Zenfox_Debug::dump($data, 'data');
						foreach($data as $pjpData)
						{
							$pjpData['gameId'] = $runningSlotId;
							if(!($this->insertPjpData($pjpData)))
							{
								//TODO write an error handler
							}
						}
					}
				}
				$this->_redirect($language . '/slotconfig/view');
			}
		}
	}
	
	/**
	 * This function passes the slotData to SlotConfig for inserting in slot tables
	 * @param $slotData
	 * 
	 */
	public function insertSlotData($slotData)
	{
		$slotConfig = new SlotConfig();
		$runningSlotData = $slotConfig->insertMachineData($slotData);
		if($runningSlotData)
		{
			return $runningSlotData;
		}
		return false;
	}
	
	/**
	 * This function implements editing of slot configuration and pjp configuration
	 * 
	 */
	public function editAction()
	{
		$language = $this->getRequest()->getParam('lang');
		$runningSlotsId = $this->getRequest()->id;
		$pjpEnabled = $this->getRequest()->pjp;
		//$addNewPjpOption = $this->getRequest()->option;
		
		$runningSlot = new RunningSlot();
		$slotData = $runningSlot->getMachineData($runningSlotsId);
		$form = new Admin_MainconfigForm();
		if($pjpEnabled == 'ENABLED')
		{
			$pjp = new PjpMachine();
			$allPjpDetails = $pjp->getMachineData($runningSlotsId, $slotData['gameFlavour']);
			$this->view->slotForm = $form->setSlotConfigForm($slotData, $allPjpDetails, $pjpEnabled);
		}
		else
		{
			$this->view->slotForm = $form->setSlotConfigForm($slotData);
		}
		if($this->getRequest()->isPost())
		{
			if($form->isValid($_POST))
			{
				$submitValue = $form->getValue('submit');
				if(!$submitValue)
				{
					foreach($form->getSubforms() as $key => $subForm)
					{
						$data = $subForm->getValues();
						if(($key == 'slot') && $subForm->getValue('submit'))
						{
							//$data = $subForm->getValues();
							foreach($data as $slotData)
							{
								$gameFlavour = $this->editSlotConfig($slotData, $runningSlotsId);
							}
						}
						/*elseif(($key == 'pjpForm') && $subForm->getValue('submit'))
						{
							foreach($data as $pjpData)
							{
								if(!($this->insertPjpData($pjpData)))
								{
									//TODO write an error handler
								}
							}
						}*/
						elseif(($subForm->getValue('submit')) && ($subForm->getValue('checkBox')))
						{
							//$data = $subForm->getValues();
							//Zenfox_Debug::dump($data, 'data', true, true);
							$id = explode('_', $key);
							$pjpMachinesId = $id[1];
							foreach($data as $pjpData)
							{
								$pjpData['gameId'] = $runningSlotsId;
								$pjpData['gameFlavour'] = $gameFlavour;
								if(!($this->editPjp($pjpData, $pjpMachinesId)))
								{
									//TODO write an error handler
								}
							}
						}
					}
				}
				else
				{
					$formData = $form->getValues();
					foreach($formData as $key => $data)
					{
						//Zenfox_Debug::dump($data, 'slotdata', true, true);
						if($key == 'slot')
						{
							if($data['pjpEnabled'] == 'ENABLED')
							{
								$pjpEnabled = true;
							}
							else
							{
								$pjpEnabled = false;
							}
							$gameFlavour = $this->editSlotConfig($data, $runningSlotsId);
						}
						/*elseif($key == 'pjpForm')
						{
							if(!($this->insertPjpData($data)))
							{
								//TODO write an error handler
							}
						}*/
						elseif($data['checkBox'] && $pjpEnabled)
						{
							//Zenfox_Debug::dump($data['checkBox'], 'data', true, true);
							$id = explode('_', $key);
							$pjpMachinesId = $id[1];
							$data['gameId'] = $runningSlotsId;
							$data['gameFlavour'] = $gameFlavour;
							if(!($this->editPjp($data, $pjpMachinesId)))
							{
								//TODO write an error handler
							}
						}
					}
				}
				//Check the pjp status(Enabled/Disabled) is updated or not
				$slotDetail = $runningSlot->getMachineData($runningSlotsId);
				$this->_redirect($language . '/slotconfig/edit/id/' . $runningSlotsId .
					'/pjp/' . $slotDetail['pjpEnabled']);
				/*$option = $form->getValue('option');
				if($option)
				{
					$this->_redirect('slotconfig/edit/id/' . $runningSlotsId .
					'/pjp/' . $slotDetail['pjp_enabled'] . '/option/' . $option);
				}
				else
				{
					$this->_redirect('slotconfig/edit/id/' . $runningSlotsId .
					'/pjp/' . $slotDetail['pjp_enabled']);
				}*/
			}
		}
	}
	
	public function editSlotConfig($slotData, $runningSlotsId)
	{
		$slotConfig = new SlotConfig();
		//It returns the current game flavour
		$result = $slotConfig->updateMachineData($slotData, $runningSlotsId);
		return $result;
	}
	/*
	 * This function updates the pjp table data for the selected id
	 * @returns boolean
	 */
	public function editPjp($pjpData, $pjpMachinesId)
	{
		$session = new Zend_Session_Namespace('runningMachine');
		$session->value = 'slots';
		$pjpConfig = new PjpConfig();
		if($pjpConfig->updatePjpDetail($pjpData, $pjpMachinesId))
		{
			return true;
		}
	}
	
	/*
	 * This function inserts pjp data in table.
	 */
	public function insertPjpData($pjpData)
	{
		$session = new Zend_Session_Namespace('runningMachine');
		$session->value = 'slots';
		$pjpConfig = new PjpConfig();
		if($pjpConfig->insertPjpDetail($pjpData))
		{
			return true;
		}
	}
}