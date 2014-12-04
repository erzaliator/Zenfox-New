<?php
/**
 * This class is implemented to configure the roulette machine
 * @author Nikhil Gupta
 * @date January 2, 2010
 */
require_once dirname(__FILE__).'/../forms/MainconfigForm.php';
require_once dirname(__FILE__).'/../forms/RouletteconfigForm.php';
require_once dirname(__FILE__).'/../forms/PjpForm.php';

class Admin_RouletteconfigController extends Zenfox_Controller_Action
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
	
	/*
	 * This function fetches all the roulette machines details from RunningRoulette
	 */
	public function viewAction()
	{
		$runningRoulette = new RunningRoulette();
		$allMachinesDetails = $runningRoulette->getAllMachinesData();
		$this->view->machines = $allMachinesDetails;
	}
	
	/*
	 * This function creates new roulette configuration and add pjp
	 */
	public function createAction()
	{
		$language = $this->getRequest()->getParam('lang');
//		$pjpConfig = new PjpConfig();
//		$pjpConfig->insertPjpDetail(9);
		$form = new Admin_MainconfigForm();
//		$pjp = new PjpMachine();
//		$allPjpDetails = $pjp->getPjpDetails();
		$this->view->form = $form->getNewRouletteForm();
		if($this->getRequest()->isPost())
		{
			if($form->isValid($_POST))
			{
				foreach($form->getSubForms() as $key => $subForm)
				{
					$data = $subForm->getValues();
					if($key == 'rouletteForm')
					{
						foreach($data as $rouletteData)
						{
							$runningRouletteData = $this->insertRouletteData($rouletteData);
							$runningRouletteId = $runningRouletteData['runningRouletteId'];
							if($runningRouletteData['pjpEnabled'] == 'ENABLED')
							{
								$pjpEnabled = true;
							}
							else
							{
								$pjpEnabled = false;
							}
							if(!($runningRouletteData))
							{
								//TODO write an error handler
								$this->_redirect($language . '/error/error');
							}
						}
					}
					elseif(($subForm->getValue('checkBox')) && ($pjpEnabled))
					{
						//Zenfox_Debug::dump($data, 'data');
						$id = explode('_', $key);
						$pjpMachinesId = $id[1];
						foreach($data as $pjpData)
						{
							$pjpData['gameId'] = $runningRouletteId;
							if(!($this->insertPjpData($pjpData)))
							{
								//TODO write an error handler
								$this->_redirect($language . '/error/error');
							}
						}
					}
				}
				$this->_redirect($language . '/rouletteconfig/view');
			}
		}
	}
	
	/*
	 * This function inserts the roulette data in database
	 */
	public function insertRouletteData($rouletteData)
	{
		$rouletteConfig = new RouletteConfig();
		$runningRoulleteId = $rouletteConfig->insertMachineData($rouletteData);
		if($runningRoulleteId)
		{
			return $runningRoulleteId;
		}
		return false;
	}
	/*
	 * This function edits roulette configuration as well as pjp data if pjp is enabled
	 */
	public function editAction()
	{
		$language = $this->getRequest()->getParam('lang');
		$form = new Admin_MainconfigForm();
		/*
		 * Get pjp is enabled or not
		 * Get runningRouletteId from url
		 * Get option to add new pjp
		 */
		$pjpEnabled = $this->getRequest()->pjp;
		$runningRouletteId = $this->getRequest()->id;
		//$addNewPjpOption = $this->getRequest()->option;
		//Get existing roulette configuration data from table for selected runningRouletteId
		$runningRoulette = new RunningRoulette();
		$rouletteDetail = $runningRoulette->getMachineData($runningRouletteId);
		if($pjpEnabled == 'ENABLED')
		{
			$pjp = new PjpMachine();
			$allPjpDetails = $pjp->getMachineData($runningRouletteId, $rouletteDetail['gameFlavour']);
			$this->view->form = $form->setRouletteConfigForm($rouletteDetail, $allPjpDetails, $pjpEnabled);
			/*if($addNewPjpOption)
			{
				$this->view->form = $form->setRouletteConfigForm($rouletteDetail, $allPjpDetails, $pjpEnabled, $addNewPjpOption);
			}
			else
			{
				$this->view->form = $form->setRouletteConfigForm($rouletteDetail, $allPjpDetails, $pjpEnabled);
			}*/
		}
		else
		{	
			$this->view->form = $form->setRouletteConfigForm($rouletteDetail);
		}
		if($this->getRequest()->isPost())
		{
			if($form->isValid($_POST))
			{
				//Get the submit value from main form. If not set, check the sub forms.
				$submitValue = $form->getValue('submit');
				if(!$submitValue)
				{
					foreach($form->getSubforms() as $key => $subForm)
					{
						$data = $subForm->getValues();
						if(($key == 'roulette') && $subForm->getValue('submit'))
						{
							//$data = $subForm->getValues();
							foreach($data as $rouletteData)
							{
								$gameFlavour = $this->editRouletteConfig($rouletteData, $runningRouletteId);
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
							//Zenfox_Debug::dump($data, 'data');
							$id = explode('_', $key);
							$pjpMachinesId = $id[1];
							
							foreach($data as $pjpData)
							{
								$pjpData['gameId'] = $runningRouletteId;
								$pjpData['gameFlavour'] = $gameFlavour;
								if(!($this->editPjp($pjpData, $pjpMachinesId)))
								{
									//TODO write an error handler
									$this->_redirect($language . '/error/error');
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
						//Zenfox_Debug::dump($formData, 'data', true, true);
						if($key == 'roulette')
						{
							if($data['pjpEnabled'] == 'ENABLED')
							{
								$pjpEnabled = true;
							}
							else
							{
								$pjpEnabled = false;
							}
							//Zenfox_Debug::dump($data, 'rouletteData', true, true);
							$gameFlavour = $this->editRouletteConfig($data, $runningRouletteId);
						}
						/*elseif($key == 'pjpForm')
						{
							if(!($this->insertPjpData($data)))
							{
								//TODO write an error handler
							}
						}*/
						elseif($data['checkBox'])
						{
							$id = explode('_', $key);
							$pjpMachinesId = $id[1];
							$data['gameId'] = $runningRouletteId;
							$data['gameFlavour'] = $gameFlavour;
							if(!($this->editPjp($data, $pjpMachinesId)))
							{
								//TODO write an error handler
								$this->_redirect($language . '/error/error');
							}
						}
					}
				}
				//Check the pjp status(Enabled/Disabled) is updated or not
				$rouletteDetail = $runningRoulette->getMachineData($runningRouletteId);
				$this->_redirect($language . '/rouletteconfig/edit/id/' . $runningRouletteId .
					'/pjp/' . $rouletteDetail['pjpEnabled']);
				/*$option = $form->getValue('option');
				if($option)
				{
					$this->_redirect('rouletteconfig/edit/id/' . $runningRouletteId .
					'/pjp/' . $rouletteDetail['pjpEnabled'] . '/option/' . $option);
				}
				else
				{
					$this->_redirect('rouletteconfig/edit/id/' . $runningRouletteId .
					'/pjp/' . $rouletteDetail['pjpEnabled']);
				}*/
			}
		}
	}
	
	/*
	 * This function updates roulette configuration for the selected runningRouletteId
	 * @returns boolean
	 */
	public function editRouletteConfig($rouletteData, $runningRouletteId)
	{
		$rouletteConfig = new RouletteConfig();
		//It returns game flavour
		$result = $rouletteConfig->updateMachineData($rouletteData, $runningRouletteId);
		return $result;
	}
	
	/*
	 * This function updates the pjp table data for the selected id
	 * @returns boolean
	 */
	public function editPjp($pjpData, $pjpMachinesId)
	{
		$session = new Zend_Session_Namespace('runningMachine');
		$session->value = 'roulette';
		$pjpConfig = new PjpConfig();
		if($pjpConfig->updatePjpDetail($pjpData, $pjpMachinesId))
		{
			return true;
		}
		return false;
	}
	
	/*
	 * This function inserts pjp data in table.
	 */
	public function insertPjpData($pjpData)
	{
		$session = new Zend_Session_Namespace('runningMachine');
		$session->value = 'roulette';
		$pjpConfig = new PjpConfig();
		if($pjpConfig->insertPjpDetail($pjpData))
		{
			return true;
		}
		return false;
	}
}