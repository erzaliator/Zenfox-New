<?php

require_once dirname(__FILE__).'/../forms/MainForm.php';
require_once dirname(__FILE__).'/../forms/KenoForm.php';
require_once dirname(__FILE__).'/../forms/PjpMachineForm.php';

class Admin_KenoController extends Zenfox_Controller_Action
{
	protected $_form;
	protected $_namespace;
    protected $_session;
    protected $_noOfParts;
    protected $_controller;
    protected $_action;
    protected $_machineName;
    
    public function getForm($noParts = NULL)
    {
    	$this->_noOfParts = $noParts;
    	$keno = new Admin_KenoForm();
    	$pjp = new Admin_PjpMachineForm();
    	$form = new Admin_MainForm($keno, $pjp, $this->_noOfParts);
    	$this->_form = $form->getForm();
    	return $this->_form;
    	
    }
    
	public function viewAction()
	{
		$runningKeno = new RunningKeno();
		$allMachinesDetails = $runningKeno->getAllMachinesData();
		$this->view->machines = $allMachinesDetails;
	}
	
	
	public function createAction()
    {
    	$mainForm = $this->getForm();
    	
    	$namespace = $mainForm->setSession('create');
    	//echo $namespace;
    	$request = $this->getRequest();
    	$controller = $request->getControllerName();
    	$this->_namespace = $controller . '-' . $namespace;
    	
    	$session = new Zend_Session_Namespace($this->_namespace);
    	$session->unsetAll();
    	
    	$countSessNamespace = $namespace;
    	
		$session = new Zend_Session_Namespace($countSessNamespace);
    	$session->unsetAll();
    	
    	$subForm = $mainForm->getCurrentSubForm($countSessNamespace);
	    $action = 'process';
		$this->view->form = $mainForm->prepareSubForm($subForm, $controller, $action, $this->_namespace, $countSessNamespace);
    	
    }
    
    
    public function processAction()
    {
    	$request = $this->getRequest();
    	$data = $request->getPost();
    
    	$controller = $request->getControllerName();
    	$action = $request->getActionName();
    	
    	$flag = 'next';
    	//echo $action;
    	
    	foreach($data as $formData)
    	{
	    	$this->_namespace = $formData['formSession'];    		
	    	$countSessNamespace = $formData['countSession'];
	    	$session = new Zend_Session_Namespace($this->_namespace);
	    	$mainForm = $this->getForm($session->noParts);
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
		        				//echo 'this->_noOfparts '.$this->_noOfParts;
		        				$mainForm = $this->getForm($session->noParts);
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
	        	//echo $name;
	        	//echo 'valid subform';
	        	
	        	
	       		if ($mainForm->formIsValid($countSessNamespace, $this->_noOfParts))
	        	{
	        		$session = new Zend_Session_Namespace($this->_namespace);
	        		$subForms = array_keys($mainForm->getSubForms());
	        		
	        		$this->view->form = '';
	        			
	        		foreach($subForms as $subForm)
	        		{
	        			$data = $session->subFormData[$subForm];
	        			
	        			if($subForm == 'form1')
	        			{
	        				/*$data['machineId'] = $session->kenoId;
	        				$data['pjpEnabled'] = $session->pjpEnabled;*/
	        				$data['gameFlavour'] = $session->gameFlavour;
	        				$this->_machineName = $data['machineName'];
	        				if($session->currAction == 'create')
	        				{
	        					$this->saveKenoData($data);
	        				}
	        				
	        				elseif ($session->currAction == 'edit')
	        				{
	        					$this->updateKenoData($session->runningKenoId,$data);
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
	        		return;
	        	}
	        	
	        	$counter = $mainForm->setCounter($countSessNamespace,'next');
	        	//echo 'counter '.$counter;
	        	$form = $mainForm->getCurrentSubForm($countSessNamespace);
	        	//echo 'next '.$form->getName();
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
    		//echo 'previous form is '.$form->getName();
        	if($form)
        	{
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
    	$this->setForm($mainForm,$countSessNamespace,$controller, $action);
    	
    }
    
    public function saveKenoData($kenoData)
    {
    	$runningKenoConfig = new RunningKenoConfig();
    	$runningKenoConfig->insertData($kenoData);
    }
    
    public function savePjpData($data)
    {
    	/*echo 'in save pjp data :::';
    	print_r($data);*/
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
    }
    
    public function getSessionNamespace()
    {
    	$this->_session = new Zend_Session_Namespace($this->_namespace);
    	return $this->_session;
    }
    
    public function setForm($mainForm,$countSessNamespace, $controller, $action)
    {
    	$session = new Zend_Session_Namespace($this->_namespace);
       	$filledSubForms = $session->subFormData;
        
    	$form = $mainForm->getCurrentSubForm($countSessNamespace);
    	$name = $form->getName();
    	if(count($filledSubForms))
    	{
    	foreach($filledSubForms as $key => $value)
    	{
    		if($name == $key)
    		{	
    			$form = $mainForm->setForm($key, $value);
    			
    			$this->view->form = $mainForm->prepareSubForm($form, $controller, $action, $this->_namespace, $countSessNamespace);
    		}
    	}
    	}
        
    }
    
    public function editAction()
    {
    	$mainForm = $this->getForm();
    	
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
    	//echo 'running keno id: '.$request->id;
    	
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
    	$session->runningKenoId = $runningKenoId;
    	
    	$mainForm = $this->getForm($session->noParts);
    	
    	$subForm = $mainForm->getCurrentSubForm($countSessNamespace);
		$kenoForm = new Admin_KenoForm();
		$runningkenoData['allowedPjps'] = $addedPjps;
		$form = $kenoForm->setForm($subForm, $runningkenoData);
		//Sending session namespaces as hidden data
		$action = 'process';
		$this->view->form = $mainForm->prepareSubForm($form, $controller, $action, $this->_namespace, $namespace);
    	
    }
    
    public function viewdetailsAction()
    {
    	$request = $this->getRequest();
    	
    	$runningKenoId = $request->id;
    	
    	$runningKeno = new RunningKeno();
    	$runningkenoData = $runningKeno->getMachineData($runningKenoId);
    	
    	$pjpMachine = new PjpMachine();
    	$result = $pjpMachine->getMachineData($runningKenoId, $runningkenoData['gameFlavour']);
    	
    	$this->view->runningKenoData = $runningkenoData;
    	$this->view->pjpMachines = $result;
    }
    
}