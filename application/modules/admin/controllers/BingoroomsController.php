<?php

require_once dirname(__FILE__).'/../forms/MainForm.php';
require_once dirname(__FILE__).'/../forms/BingoRoomForm.php';
require_once dirname(__FILE__).'/../forms/BingoSessSchedulingForm.php';

class Admin_BingoroomsController extends Zenfox_Controller_Action
{
	protected $_form;
	protected $_namespace;
    protected $_session;
    protected $_temp;
    protected $_noOfParts;
    protected $_controller;
    protected $_action;

    /**
     * Get all the sub forms from the main form
     * @return form instance
     */
    public function getForm()
    {
    	foreach($this->getSessionNamespace() as $key => $data)
		{
			if($key == 'form1')
			{
				$this->_noOfParts = 1;
				//$gameType = $data['form1']['gameType'];
			}
			
		}
		
		$bingoRoomForm = new Admin_BingoRoomForm();
		//Check if there is any form exists in session
		if((null === $this->_form) && (!$this->_noOfParts))
		{
			$this->_form = new Admin_MainForm($bingoRoomForm);
		}
		//Add as many subforms as many no of parts
    	if(($this->_temp) && ($this->_noOfParts))
    	{
    		$schedulingForm = new Admin_BingoSessSchedulingForm();
			$this->_form = new Admin_MainForm($bingoRoomForm, $schedulingForm, $this->_noOfParts);
			$this->_temp = 0;	
    	}
    	return $this->_form;
    }
	
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
     * Get the session namespace we're using
     *
     * @return Zend_Session_Namespace
     */
    public function getSessionNamespace()
    {
        $this->_session = new Zend_Session_Namespace($this->_namespace);
        return $this->_session;
    }
    
    public function processAction()
    {
    	$language = $this->getRequest()->getParam('lang');
    	$this->_temp = 1;
    	$formInstance = $this->getForm();
    	$mainForm = $formInstance->getForm();
    	$request = $this->getRequest();
    	//Get the post data from the submitted form
    	$data = $request->getPost($mainForm->getName());
    	$controller = $request->getControllerName();
    	$action = $request->getActionName();
    	foreach($data as $formData)
    	{
    		$this->_namespace = $formData['formSession'];    		
    		$countSessNamespace = $formData['countSession'];
    		$sessionNamespace = explode('_', $countSessNamespace);
    		$actionName = $sessionNamespace[0];
    		$formInstance = $this->getForm();
    		$mainForm = $formInstance->getForm();
    		foreach($formData as $key => $value)
    		{
    			if($key == 'prev')
    			{
    				$form = $this->setForm($mainForm, $countSessNamespace, 'prev');
    				$this->view->form = $mainForm->prepareSubForm($form, $controller, $action, $this->_namespace, $countSessNamespace);
            		return $this->render($actionName);
    			}
    		}
    	}
    	$action = $request->getActionName();
    	if (!$form = $mainForm->getCurrentSubForm($countSessNamespace)) {
    		
    		return $this->_forward($actionName);
        }
      
        //FIXME change the render name for edit 
        if (!$mainForm->subFormIsValid($form,
                                   $this->getRequest()->getPost(), $this->getSessionNamespace())) {
            $this->view->form = $mainForm->prepareSubForm($form, $controller, $action, $this->_namespace, $countSessNamespace);
            return $this->render($actionName);
        }
       
        $formInstance = $this->getForm();
    	$mainForm = $formInstance->getForm();
        
        if (!$mainForm->formIsValid($countSessNamespace, $this->_noOfParts)) {
	        $form = $this->setForm($mainForm, $countSessNamespace, 'next');
            $this->view->form = $mainForm->prepareSubForm($form, $controller, $action, $this->_namespace, $countSessNamespace);
            return $this->render($actionName);
        }
        $var = 0;
        $isBingoRoomId = false;
        foreach($this->getSessionNamespace() as $data)
        {
        	foreach($data as $key => $formData)
        	{
        		if($key == 'form1')
        		{
        			$formData['gameFlavours'] = implode(',', $formData['gameFlavours']);
        			Zenfox_Debug::dump($formData, 'room');
        			if($formData['bingoRoomId'])
        			{
        				$isBingoRoomId = true;
        				$bingoRoomId = $formData['bingoRoomId'];
        				$this->updateBingoRoomData($formData);
        			}
        			else
        			{
        				$bingoRoomId = $this->insertBingoRoomData($formData);
        			}
        		}
        		else
        		{
        			$finalData['bingoRoomId'] = $bingoRoomId;
        			Zenfox_Debug::dump($formData, 'formdata');
        			foreach($formData as $index => $subFormData)
        			{
        				$subFormKey = explode('_', $index);
        				if($subFormKey[0] == 'day')
	        			{
	        				$finalData['day'] = $subFormKey[1];
	        			}
	        			elseif(($subFormKey[0] == 'sess') && ($subFormData != -1))
	        			{
	        				$finalData['sequence'] = $subFormKey[2];
	        				$finalData['sessionId'] = $subFormData;
	        				Zenfox_Debug::dump($finalData, 'final');
	        				if($isBingoRoomId)
	        				{
	        					$this->updateRoomsSessionData($finalData);
	        				}
	        				else
	        				{
	        					$this->insertRoomsSessionData($finalData);
	        				}
	        			}
        			}
        		}
        	}
        }
        echo "Your data is saved";
        $mainForm->deleteSession($this->_namespace);
		$mainForm->deleteSession($countSessNamespace);
		$mainForm->deleteSession('Action', $countSessNamespace);
    }
    
    public function setForm($mainForm, $countSessNamespace, $page)
    {
    	$session = new Zend_Session_Namespace($countSessNamespace);
    	$counter = $mainForm->setCounter($countSessNamespace, $page);
    	foreach($this->getSessionNamespace() as $sessionData)
    	{
    		//Zenfox_Debug::dump($sessionData, 'data');
    		foreach($sessionData as $key => $data)
    		{
    			if($key != 'form1')
    			{
	    			$finalData = array();
	    			$day = -1;
			    	foreach($data as $rooomSessionData)
			    	{
			    		if($day != $rooomSessionData['day'])
			    		{
			    			$temp = array();
			    			$day = $rooomSessionData['day'];
			    		}
			    		$finalData['roomId'] = $rooomSessionData['room_id'];
			    		$temp[$rooomSessionData['sequence']] = $rooomSessionData['session_id'];
			    		$finalData[$rooomSessionData['day']] = $temp;
			    	}
			    	$data = $finalData;
    			}
    			$counter--;
	   			if(!$counter)
	   			{
	   				$form = $mainForm->setForm($key, $data);
					return $form;
	   			}
    		}
    	}
    	$form = $mainForm->getCurrentSubForm($countSessNamespace);
    	return $form;
    }
    
    public function insertBingoRoomData($roomData)
    {
    	$bingoRoomsConfig = new BingoRoomsConfig();
    	$bingoRoomId = $bingoRoomsConfig->insertData($roomData);
    	return $bingoRoomId;
    }
    
    public function insertRoomsSessionData($sessionData)
    {
    	$roomsSessionConfig = new RoomsSessionConfig();
    	$roomsSessionConfig->insertData($sessionData);
    }
    
    public function updateBingoRoomData($roomData)
    {
    	$bingoRoomsConfig = new BingoRoomsConfig();
    	$bingoRoomsConfig->updateData($roomData);
    }
    
    public function updateRoomsSessionData($sessionData)
    {
    	$roomsSessionConfig = new RoomsSessionConfig();
    	$roomsSessionConfig->updateData($sessionData);
    }
    
    /**
     * This function creates new form
     * @return unknown_type
     */
	
	public function createAction()
	{
		$formInstance = $this->getForm();
    	$mainForm = $formInstance->getForm();
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
	
	public function viewAction()
	{
		$bingoRoom = new BingoRoom();
		$allRooms = $bingoRoom->getAllRooms();
		$this->view->rooms = $allRooms;
		//Zenfox_Debug::dump($allRooms, 'allrooms');
	}
	
	public function editAction()
	{
		$formInstance = $this->getForm();
    	$mainForm = $formInstance->getForm();
    	$namespace = $mainForm->setSession('edit');
    	$request = $this->getRequest();
    	$controller = $request->getControllerName();
    	$this->_namespace = $controller . '-' . $namespace;
    	//Creating session for storing forms
    	//FIXME if some other is also working on same bingo form
    	$session = new Zend_Session_Namespace($this->_namespace);
    	$session->unsetAll();
    	//Creating session for storing action name
    	$countSessNamespace = $namespace;
    	//Creating session for storing counter value
		$session = new Zend_Session_Namespace($countSessNamespace);
    	$session->unsetAll();
    	$bingoRoomId = $request->id;
    	$bingoRoom = new BingoRoom();
    	$roomData = $bingoRoom->getRoomData($bingoRoomId);
    	$roomsSession = new RoomsSession();
    	$sessionData = $roomsSession->getSessionData($bingoRoomId);
//    	Zenfox_Debug::dump($roomData, 'data');
//    	Zenfox_Debug::dump($sessionData, 'session', true, true);
    	//Zenfox_Debug::dump($data, 'data', true, true);
    	$bingoRoomData = array();
    	$bingoRoomData['form1'] = $roomData;
    	$roomsSessionData['form2_0'] = $sessionData;
    	$this->getSessionNamespace()->form1 = $bingoRoomData;
    	$this->getSessionNamespace()->form2_0 = $roomsSessionData;
    	foreach($this->getSessionNamespace() as $sessionData)
    	{
    		//Zenfox_Debug::dump($sessionData, 'sess');
    	}
    	$this->_temp = 1;
    	$subForm = $mainForm->getCurrentSubForm($countSessNamespace);
		$bingoRoomForm = new Admin_BingoRoomForm();
		$form = $bingoRoomForm->setForm($subForm, $roomData);
		//Sending session namespaces as hidden data
		$action = 'process';
		$this->view->form = $mainForm->prepareSubForm($form, $controller, $action, $this->_namespace, $namespace);
	}
}