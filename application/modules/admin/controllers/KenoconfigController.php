<?php

require_once dirname(__FILE__).'/../forms/MainconfForm.php';
require_once dirname(__FILE__).'/../forms/KenoForm.php';
require_once dirname(__FILE__).'/../forms/PjpForm.php';

class Admin_KenoconfigController extends Zenfox_Controller_Action
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
	
	public function viewAction()
	{
		$runningKeno = new RunningKeno();
		$allMachinesDetails = $runningKeno->getAllMachinesData();
		$this->view->machines = $allMachinesDetails;
	}
	
	public function createAction()
    {
    	$mainForm = new Admin_MainconfForm();
    	$this->_machineName = 'keno';
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
    	
    	$this->_machineName = 'keno';
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
    		
        	//print $form->getName();
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
	        			//echo '*form is form1*';
	        			//$session = new Zend_Session_Namespace($this->_namespace);
	        			$isEnabled = $value['pjpEnabled'];
	        			$kenoMachine = $value['machineId'];
	        			$currAction = $value['currAction'];
	        			$keno = new Keno();
						$result = $keno->getKenoMachine($kenoMachine);
						$session->gameFlavour = $result['game_flavour'];
						$session->machineName = $value['machineName'];
						$session->kenoId = $kenoMachine;
						$session->currAction = $currAction;
	        			if($isEnabled == 'ENABLED')
	        			{
	        				if($session->currAction == 'create')
	        				{
		        				//echo 'enabled';
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
					$session->value = 'keno';
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
	        		
	        		/*$session = new Zend_Session_Namespace($this->_namespace);
	        		$subForms = array_keys($mainForm->getSubForms());
	        		
	        		$this->view->form = '';
	        			
	        		foreach($subForms as $subForm)
	        		{
	        			$data = $session->subFormData[$subForm];
	        			
	        			if($subForm == 'form1')
	        			{
	        				
	        				$data['gameFlavour'] = $session->gameFlavour;
	        				$this->_machineName = $data['machineName'];
	        				if($session->currAction == 'create')
	        				{
	        					$this->saveKenoData($data);
	        				}
	        				
	        				elseif ($session->currAction == 'edit')
	        				{
	        					$this->updateKenoData($session->runningMachineId,$data);
	        				}	
	        					
	        			}
	        			else
	        			{
	        				$id = $this->getRunningKenoId($session->machineName,$session->kenoId);
	        				$data['gameId'] = $id;
	        				$data['pjpId'] = $session->pjpIds[$subForm];
	        				$data['gameFlavour'] = $session->gameFlavour;
	        				
	        				if($session->currAction == 'create')
	        				{
	        					$this->savePjpData($data);
	        				}
	        				
	        				elseif ($session->currAction == 'edit')
	        				{
	        					$this->updatePjpData($data, $data['pjpId']);
	        				}
	        			}
	        		}
	        		echo 'Data is saved';
	        		return;*/
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
    
    /*public function saveKenoData($kenoData)
    {
    	$runningKenoConfig = new RunningKenoConfig();
    	$runningKenoConfig->insertData($kenoData);
    }
    
    public function savePjpData($data)
    {
    	$session = new Zend_Session_Namespace('runningMachine');
		$session->value = 'keno';
    	$pjpConfig = new PjpConfig();
    	$pjpConfig->insertPjpDetail($data); 
    }
    
    public function updateKenoData($id, $data)
    {
    	$runningKenoConfig = new RunningKenoConfig();
    	$runningKenoConfig->updateRunningKeno($id,$data);
    }
    
    public function updatePjpData($data, $id)
    {
    	$pjpConfig = new PjpConfig();
    	$pjpConfig->updatePjpDetail($data, $id); 
    }
    
    public function getRunningKenoId($machineName, $machineId)
    {
    	$runningKeno = new RunningKeno();
    	$result = $runningKeno->getRunningkenoId($machineId,$machineName);
    	$id = $result['id'];
    	//print_r($result);
    	//print $id;
    	return $id;
    }*/
    
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
    
    public function editAction()
    {
    	$this->_machineName = 'keno';
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
    	
    	$runningKenoId = $request->id;
    	
    	$runningKeno = new RunningKeno();
    	$runningkenoData = $runningKeno->getMachineData($runningKenoId);
    	
    	$pjpMachine = new PjpMachine();
    	$result = $pjpMachine->getMachineData($runningKenoId, $runningkenoData['gameFlavour']);
    	
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
    	$session->runningMachineId = $runningKenoId;
    	
    	$mainForm = $this->getForm($this->_machineName, $session->noParts);
    	
    	$subForm = $mainForm->getCurrentSubForm($countSessNamespace);
		$kenoForm = new Admin_KenoForm();
		$runningkenoData['allowedPjps'] = $addedPjps;
		$form = $kenoForm->setForm($subForm, $runningkenoData);
		$action = 'process';
		$this->view->form = $mainForm->prepareSubForm($form, $controller, $action, $this->_namespace, $namespace);
    	
    }
    
    /*public function viewdetailsAction()
    {
    	$request = $this->getRequest();
    	
    	$runningKenoId = $request->id;
    	
    	$runningKeno = new RunningKeno();
    	$runningkenoData = $runningKeno->getMachineData($runningKenoId);
    	
    	$pjpMachine = new PjpMachine();
    	$result = $pjpMachine->getMachineData($runningKenoId, $runningkenoData['gameFlavour']);
    	
    	$this->view->runningKenoData = $runningkenoData;
    	$this->view->pjpMachines = $result;
    }*/
    
}