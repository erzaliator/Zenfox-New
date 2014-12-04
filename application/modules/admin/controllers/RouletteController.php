<?php
/**
 * This class is implemented to configure the roulette machine
 * @author Anilkumar 
 * @date March 9, 2011
 */
require_once dirname(__FILE__).'/../forms/RouletteForm.php';
require_once dirname(__FILE__).'/../forms/PjpForm.php';
require_once dirname(__FILE__).'/../forms/MainForm.php';
require_once dirname(__FILE__).'/../forms/MainconfForm.php';

class Admin_RouletteController extends Zenfox_Controller_Action
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
	
	//This function creates new session and new form
	public function createAction()
    {
		$mainForm = new Admin_MainconfForm();
    	$this->_machineName = 'roulette';
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
    
    //This function is used store the form data in session
    public function processAction()
    {
    	$language = $this->getRequest()->getParam('lang');
    	
    	$this->_machineName = 'roulette';
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
						$rouletteMachine = $value['machineId'];
						$session->rouletteId = $rouletteMachine;
						$session->currAction = $currAction;
						$session->machineName = $value['machineName'];
						$roulette = new Roulette();
						$session->gameFlavour = $roulette->getGameFlavour($rouletteMachine);
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
					$session->value = 'roulette';
	        		$subForms = array_keys($mainForm->getSubForms());
	        		
	        		//This is to save the all forms data
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
					//$this->view->message = $message;
	        		
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
	        					$this->insertRouletteData($data);
	        				}
	        				
	        				if ($session->currAction == 'edit')
	        				{
	        					$this->updateRouletteData($session->runningMachineId,$data);
	        				}	
	        			}
	        			else
	        			{
	        				$data['pjpId'] = $session->pjpIds[$subForm];
	        				$data['gameFlavour'] = $session->gameFlavour;
	        				
	        				if($session->currAction == 'create' )
	        				{
	        					$this->savePjpData($data);
	        				}
	        				
	        				elseif ($session->currAction == 'edit')
	        				{
	        					$data['gameId'] = $session->runningMachineId;
	        					$this->updatePjpData($data, $data['pjpId']);
	        				}
	        			}
	        		}
	        		echo 'Data is saved.';
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
    	
    	/*$request = $this->getRequest();
    	$data = $request->getPost();
    
    	$controller = $request->getControllerName();
    	$action = $request->getActionName();
    	
    	$flag = 'prev';
        foreach($data as $formData)
    	{
	    	$this->_namespace = $formData['formSession'];    		
	    	$countSessNamespace = $formData['countSession'];
	    	$session = new Zend_Session_Namespace($this->_namespace);
	    	$mainForm = new Admin_MainconfForm();
	    	$mainForm->getForm($session->noParts);
    	    foreach($formData as $key => $value)
    		{
    			if($key == 'next')
    			{
    				$flag = 'next';
    			}
    		}
    		$session = new Zend_Session_Namespace($this->_namespace);
	    	$form = $mainForm->getCurrentSubForm($countSessNamespace);
	    	$name = $form->getName();
	    	foreach($_POST as $key => $value)
        	{
        		$session->subFormData[$name] = $value;
        		$message = $mainForm->saveFormData($countSessNamespace, $name, $controller, $action, $flag, $value, $this->_namespace);
    			$this->view->message = $message;
        	}
    		$form = $mainForm->getCurrentSubForm ( $countSessNamespace );
			$name = $form->getName ();
			$session = new Zend_Session_Namespace($this->_namespace);
			if ($session->pjpCount && $name!='form1') 
			{
				$this->view->pjpId = $session->pjpIds [$name];
				$session->pjpCount--;
			}
    	}*/
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
    
    /*
	 * This Action to view roulette configurations
	 */
    public function viewAction()
	{
		$runningRoulette = new RunningRoulette();
		$allMachinesDetails = $runningRoulette->getAllMachinesData();
		$this->view->machines = $allMachinesDetails;
	}
	/*
	 * This function edits roulette configuration as well as pjp data if pjp is enabled
	 */
	public function editAction()
	{
		$this->_machineName = 'roulette';
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
    	
    	$runningRouletteId = $request->id;
    	$session->runningMachineId = $runningRouletteId;
    	$runningRoulette = new RunningRoulette();
    	$runningRouletteData = $runningRoulette->getMachine($runningRouletteId);
    	$pjpMachine = new PjpMachine();
    	$result = $pjpMachine->getMachineData($runningRouletteId, $runningRouletteData['gameFlavour']);
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
    	$session->runningMachineId = $runningRouletteId;
    	
    	$mainForm->getForm($this->_machineName, $session->noParts);
    	
    	$subForm = $mainForm->getCurrentSubForm($countSessNamespace);
		$rouletteForm = new Admin_RouletteForm();
		$runningRouletteData['allowedPjps'] = $addedPjps;
		$form = $rouletteForm->setForm($subForm, $runningRouletteData);
		$action = 'process';
		$this->view->form = $mainForm->prepareSubForm($form, $controller, $action, $this->_namespace, $namespace);
	}
	
	/*
	 * This function updates the pjp table data for the selected id
	 * @returns boolean
	 */
	/*
	public function savePjpData($data)
    {
    	$roulette = new RunningRoulette();
    	$rouletteData = $roulette->getLatestMachineData();
    	$data['gameId'] = $rouletteData['runningRouletteId'];
    	$session = new Zend_Session_Namespace('runningMachine');
		$session->value = 'roulette';
    	$pjpConfig = new PjpConfig();
    	$pjpConfig->insertPjpDetail($data); 
    }
	 public function updatePjpData($pjpData, $pjpId)
	{
		$pjpConfig = new PjpConfig();
    	$pjpConfig->updatePjpDetail($pjpData, $pjpId); 
	}*/
	
	/*
	 * This function inserts pjp data in table.
	 */
	/*public function insertPjpData($pjpData)
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
    
	/*
	 * This function inserts the roulette data in database
	 */
	/*public function insertRouletteData($rouletteData)
	{
		$rouletteConfig = new RouletteConfig();
		$runningRoulleteId = $rouletteConfig->insertMachineData($rouletteData);
		if($runningRoulleteId)
		{
			return $runningRoulleteId;
		}
		return false;
	}
	
	public function updateRouletteData($id, $data)
    {
    	$rouletteConfig = new RouletteConfig();
    	$rouletteConfig->updateMachineData($id,$data);
    }*/
}