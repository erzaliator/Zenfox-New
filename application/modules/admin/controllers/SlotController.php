<?php
/**
 * This class is implemented to configure the slot machine
 * @author Nikhil Gupta
 * @date January 2, 2010
 */
require_once dirname(__FILE__).'/../forms/SlotForm.php';
require_once dirname(__FILE__).'/../forms/PjpForm.php';
require_once dirname(__FILE__).'/../forms/MainForm.php';
require_once dirname(__FILE__).'/../forms/MainconfForm.php';

class Admin_SlotController extends Zenfox_Controller_Action
{
	protected $_form;
	protected $_namespace;
    protected $_session;
    protected $_noOfParts;
    protected $_controller;
    protected $_action;
    protected $_machineName;
    
	public function init()
	{
		parent::init();
		$this->_redirector = $this->_helper->getHelper('Redirector');
        $contextSwitch = $this->_helper->getHelper('contextSwitch');
		$contextSwitch->addActionContext('create', 'json')
				->addActionContext('view', 'json')
				->addActionContext('edit', 'json')
				->addActionContext('process', 'json')
              	->initContext();
	}
	
	public function createAction()
    {
    	$mainForm = new Admin_MainconfForm();
    	$this->_machineName = 'slots';
    	$mainForm->getForm($this->_machineName);
    	
    	$namespace = $mainForm->setSession('create');
    	$request = $this->getRequest();
    	$controller = $request->getControllerName();
    	$this->_namespace = $controller . '-' . $namespace;

    	//Creating session for storing forms
    	$session = new Zend_Session_Namespace($this->_namespace);
    	$session->unsetAll();
    	//Creating session for storing action name
    	$countSessNamespace = $namespace;
    	//Creating session for storing counter value
		$session = new Zend_Session_Namespace($countSessNamespace);
    	$session->unsetAll();
    	$subForm = $mainForm->getCurrentSubForm($countSessNamespace);
    	
		//Give the action name where submit action will be occured.
	    $action = 'process';
		$this->view->form = $mainForm->prepareSubForm($subForm, $controller, $action, $this->_namespace, $countSessNamespace);
		
    }
    
    public function processAction()
    {
    	$language = $this->getRequest()->getParam('lang');
    	
    	$this->_machineName = 'slots';
    	$request = $this->getRequest();
    	$data = $request->getPost();
    
    	$controller = $request->getControllerName();
    	$action = $request->getActionName();
    	
    	$flag = 'next';
    	
    	foreach($data as $formData)
    	{
	    	$this->_namespace = $formData['formSession'];
	    	$countSessNamespace = $formData['countSession'];
	    	$session = new Zend_Session_Namespace($this->_namespace);
	    	$mainForm = new Admin_MainconfForm();
	    	$mainForm->getForm($this->_machineName, $session->noParts);
	    	
    		foreach($formData as $key => $value)
    		{
    			if($key == 'prev')
    			{
    				$flag = 'prev';
    			}
    		}
    	}
    	
    	if($flag == 'next')
    	{
    		$form = $mainForm->getCurrentSubForm($countSessNamespace);
        	if (!$mainForm->subFormIsValid($form,
                                   $this->getRequest()->getPost(), $this->getSessionNamespace())) 
            {
                              
            	$this->view->form = $mainForm->prepareSubForm($form, $controller, $action, $this->_namespace, $countSessNamespace);
       		}
	        else
	        {
	        	$session = new Zend_Session_Namespace($this->_namespace);
	        	$name = $form->getName();
	        	foreach($_POST as $key => $value)
	        	{
	        		$session->subFormData[$name] = $value;
	        		if($name == 'form1')
	        		{
	        			$isEnabled = $value['pjpEnabled'];
	        			$currAction = $value['currAction'];
						$slotMachine = $value['machineId'];
						$session->slotId = $slotMachine;
						$session->currAction = $currAction;
						$session->machineName = $value['machineName'];
						$slot = new Slot();
						$session->gameFlavour = $slot->getGameFlavour($slotMachine);
	        			if($isEnabled == 'ENABLED')
	        			{
	        				if($session->currAction == 'create')
	        				{
		        				$allowedPjps = $value['allowedPjps'];
		        				$session->noParts = count($allowedPjps);
		        				$mainForm->getForm($this->_machineName, $session->noParts);
			    				$subForms = array_keys($mainForm->getSubForms());
			    				
			    				$i = 0;
			    				if($allowedPjps)
							    {
								    foreach($subForms as $sub)
								    {
								    	if(!($sub == 'form1'))
								    	{
								    		$session->pjpIds[$sub] = $allowedPjps[$i];
								    		$i++;
								    	}
								    }
							    }
	        				}			
	        			}
	        			else
	        			{
	        				$session->noParts = 0;
	        			}
	        		}
	        	}
	        	
	        	
	       		if ($mainForm->formIsValid($countSessNamespace, $session->noParts))
	        	{
	        		$session = new Zend_Session_Namespace($this->_namespace);
					$session->value = 'slots';
	        		$subForms = array_keys($mainForm->getSubForms());
	        		
	        		$runningMachine = new RunningMachine();
	        		$message = $runningMachine->saveMachineData($this->_namespace, $subForms);
	        		
	        		//Unset the sessions
	        		$mainForm->deleteSession($this->_namespace);
					$mainForm->deleteSession($countSessNamespace);
					$mainForm->deleteSession('Action', $countSessNamespace);
					
	        		if(!$message){
						$this->_redirect($language . '/error/error');
					}
					
	        		$this->_helper->FlashMessenger(array('notice' => $this->view->translate($message)));
	        		return;
	        	}
	        	$counter = $mainForm->setCounter($countSessNamespace,'next');
	        	$form = $mainForm->getCurrentSubForm($countSessNamespace);
	        	if($form)
	        	{
	        		$this->view->form = $mainForm->prepareSubForm($form, $controller, $action, $this->_namespace, $countSessNamespace);
	        	}	
	       	}
    	}
    	else if($flag == 'prev')
    	{
    		$counter = $mainForm->setCounter($countSessNamespace,'prev');
    		$form = $mainForm->getCurrentSubForm($countSessNamespace);
        	if($form)
        	{
        		$mainForm->setForm($countSessNamespace,$this->_machineName, $this->_namespace);
        		$this->view->form = $mainForm->prepareSubForm($form, $controller, $action, $this->_namespace, $countSessNamespace);
        	}
    	}
    	$form = $mainForm->getCurrentSubForm($countSessNamespace);
    	$name = $form->getName();
    	$session = new Zend_Session_Namespace($this->_namespace);
    	if($name != 'form1')
    	{
    		$this->view->pjpId = $session->pjpIds[$name];
    	}
    }
    
     /**
     * Get the session namespace we're using
     *
     * @return Zend_Session_Namespace
     */
	public function getSessionNamespace()
    {
    	$this->_session = new Zend_Session_Namespace($this->_namespace);
    	return $this->_session;
    }
    
	/*public function getRunningSlotId($machineName, $machineId)
    {
    	$runningSlot = new RunningSlot();
    	$result = $runningSlot->getRunningSlotId($machineId,$machineName);
    	$id = $result['id'];
    	return $id;
    }
	/*
	 * This function inserts the slot data in database
	 */
	/*public function insertSlotData($slotData)
	{
		$slotConfig = new SlotConfig();
		$runningSlotData = $slotConfig->insertMachineData($slotData);
		$runningSlotId = $runningSlotData['runningSlotId'];
		if($runningSlotId)
		{
			return $runningSlotId;
		}
		return false;
	}
	
	public function updateSlotData($id, $data)
    {
    	$slotConfig = new SlotConfig();
    	$slotConfig->updateMachineData($id,$data);
    }
    
	public function savePjpData($data)
    {
    	$slot = new RunningSlot();
    	$slotData = $slot->getLatestMachineData();
    	$data['gameId'] = $slotData['runningSlotId'];
    	$session = new Zend_Session_Namespace('runningMachine');
		$session->value = 'slots';
    	$pjpConfig = new PjpConfig();
    	$pjpConfig->insertPjpDetail($data); 
    }
	/*
	 * This function edits slot configuration as well as pjp data if pjp is enabled
	 */
	
	
	/*
	 * This function updates the pjp table data for the selected id
	 * @returns boolean
	 */
	/*public function updatePjpData($pjpData, $pjpMachinesId)
	{
		$pjpConfig = new PjpConfig();
    	$pjpConfig->updatePjpDetail($pjpData, $pjpMachinesId); 
	}*/
	
    
	/*
	 * This function inserts pjp data in table.
	 */
		
	public function viewAction()
	{
		$runningSlot = new RunningSlot();
		$slotData = $runningSlot->getAllMachinesData();
		$this->view->machines = $slotData;
	}
	
	public function editAction()
	{
    	$this->_machineName = 'slots';
		$mainForm = new Admin_MainconfForm();
    	$mainForm->getForm($this->_machineName);
    	
    	$namespace = $mainForm->setSession('edit');
    	$request = $this->getRequest();
    	$controller = $request->getControllerName();
    	$this->_namespace = $controller . '-' . $namespace;
    	
    	$session = new Zend_Session_Namespace($this->_namespace);
    	$session->unsetAll();
    	
    	$countSessNamespace = $namespace;
    	
		$session = new Zend_Session_Namespace($countSessNamespace);
    	$session->unsetAll();
    	
    	$runningSlotId = $request->id;
    	$session->runningMachineId = $runningSlotId;
    	$runningSlot = new RunningSlot();
    	$runningSlotData = $runningSlot->getMachine($runningSlotId);
    	$pjpMachine = new PjpMachine();
    	$result = $pjpMachine->getMachineData($runningSlotId, $runningSlotData['gameFlavour']);
    	$session = $this->getSessionNamespace();

    	$i = 0;
    	foreach($result as $row)
    	{
    		$name = 'form2_' . $i;
    		$data = $pjpMachine->getPjpMachineData($row['id']);
    		$session->subFormData[$name] = $data;
    		$session->pjpIds[$name] = $row['pjp_id'];
    		$session->pjpMachineIds[$name] = $row['id'];
    		$i++;
    	}
    	$addedPjps = array();
    	if($session->pjpIds)
    	{
    		foreach($session->pjpIds as $key => $value)
    		{
    			$addedPjps[] = $value;
    		}
    	}
    	$session->noParts =  count($result);
    	$session->runningMachineId = $runningSlotId;
    	
    	$mainForm = $this->getForm($this->_machineName, $session->noParts);
    	
    	$subForm = $mainForm->getCurrentSubForm($countSessNamespace);
		$slotForm = new Admin_SlotForm();
		$runningSlotData['allowedPjps'] = $addedPjps;
		$form = $slotForm->setForm($subForm, $runningSlotData);
		//Sending session namespaces as hidden data
		$action = 'process';
		$this->view->form = $mainForm->prepareSubForm($form, $controller, $action, $this->_namespace, $namespace);
	}
}