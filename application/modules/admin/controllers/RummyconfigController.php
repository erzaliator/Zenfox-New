<?php
/**
 * This class implements bingo game configuration
 * @author Nikhil Gupta 
 * @date Oct 17, 2011
 */
require_once dirname(__FILE__).'/../forms/MainForm.php';
require_once dirname(__FILE__) . '/../forms/RummyConfigForm.php';
require_once dirname(__FILE__) . '/../forms/RummyConfigMainForm.php';

class Admin_RummyconfigController extends Zend_Controller_Action
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
				$this->_noOfParts = $data['form1']['noOfParts'];
			}
		}
		//$this->_noOfParts = 0;
		$rummyForm = new Admin_RummyConfigMainForm();
		//Check if there is any form exists in session
		if((null === $this->_form) && (!$this->_noOfParts))
		{
			$this->_form = new Admin_MainForm($rummyForm);
		}
		//Add as many subforms as many no of parts
    	if(($this->_temp) && ($this->_noOfParts))
    	{
    		$configForm = new Admin_RummyConfigForm();
			$this->_form = new Admin_MainForm($rummyForm, $configForm, 1);
			$this->_temp = 0;	
    	}
    	return $this->_form;
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
    
//This function is used store the form data in session
    public function processAction()
    {
    	$gameFlavour = $this->getRequest()->getParam('flavour');
    	if(!$gameFlavour)
    	{
    		$this->_redirect('/rummyconfig/create');
    	}
    	$tableConfigData = new TableConfigData();
    	$configData = $tableConfigData->getConfigDataByFlavour($gameFlavour);
    	//Zenfox_Debug::dump($configData, 'data');
    	$jsonConfig = $configData['default_config'];
		$jsonConfigData = Zend_Json::decode($jsonConfig);
		//Zenfox_Debug::dump($configData, 'config');
		foreach($jsonConfigData as $key => $value)
		{
			$configData[$key] = $value;
		}
		
		$configData['table_name'] = $configData['config_table_name'];
		$configData['table_description'] = $configData['description'];
		$rummyConfigForm = new Admin_RummyConfigForm();
		$configEditForm = $rummyConfigForm->getForm($configData);
    	
    	$this->view->configEditForm = $configEditForm;
    	
    	if($this->getRequest()->isPost())
    	{
    		if($this->getRequest()->getParam('gameType'))
    		{
	    		if($configEditForm->isValid($_POST))
	    		{
	    			$data = $configEditForm->getValues();
	    			
	    			$newConfigData['InitDecks']  = $data['InitDecks'];
					$newConfigData['InitJokers']  = $data['InitJokers'];
					$newConfigData['EarlyDropPoints']  = $data['EarlyDropPoints'];
					$newConfigData['MidDropPoints']  = $data['MidDropPoints'];
					$newConfigData['MaxPoints']  = $data['MaxPoints'];
					$newConfigData['MinPoints']  = $data['MinPoints'];
					$newConfigData['DefaultErrorTime']  = $data['DefaultErrorTime'];
					$newConfigData['TurnTimeout']  = $data['TurnTimeout'];
					$newConfigData['MeldTimeout']  = $data['MeldTimeout'];
					$newConfigData['GameStartWait']  = $data['GameStartWait'];
					$newConfigData['NoActivePlayerWait']  = $data['NoActivePlayerWait'];
					$newConfigData['ShowResultWait']  = $data['ShowResultWait'];
					$newConfigData['MatchResultWait']  = $data['MatchResultWait'];
					$newConfigData['SessionStartWait']  = $data['SessionStartWait'];
					$newConfigData['CanPlayerJoinInSession']  = (bool)$data['CanPlayerJoinInSession'];
					$newConfigData['LoopOverSessions']  = (bool)$data['LoopOverSessions'];
					$newConfigData['MaxSessionPoints']  = $data['MaxSessionPoints'];
					$newConfigData['HouseEdge']  = $data['HouseEdge'];
					$newConfigData['MaxTimeoutLimit']  = $data['MaxTimeoutLimit'];
					$newConfigData['PlayerSelectTimeout']  = $data['PlayerSelectTimeout'];
					$jsonConfigData = Zend_Json::encode($newConfigData);

					$modifiedData['config'] = $jsonConfigData;
					$modifiedData['minPlayer'] = $data['minPlayer'];
					$modifiedData['maxPlayer'] = $data['maxPlayer'];
					$modifiedData['maxSpectators'] = $data['maxSpectators'];
					$modifiedData['amountType'] = $data['amountType'];
					$modifiedData['minBet'] = $data['minBet'];
					$modifiedData['maxBet'] = $data['maxBet'];
					$modifiedData['minActiveRoom'] = $data['minActiveRoom'];
					$modifiedData['incrementRooms'] = $data['incrementRooms'];
					$modifiedData['createRooms'] = $data['createRooms'];
					$modifiedData['maxRooms'] = $data['maxRooms'];
					$modifiedData['tableName'] = $data['tableName'];
					$modifiedData['tableDescription'] = $data['tableDescription'];
					$modifiedData['status'] = $data['status'];
					$modifiedData['gameFlavour'] = $data['flavour'];
					$modifiedData['gameType'] = $data['gameType'];
					$modifiedData['gameRules'] = $data['gameRules'];

					$tableConfig = new TableConfig();
					$tableConfig->createTableConfig($modifiedData);
					$this->_helper->FlashMessenger(array('notice' => $this->view->translate("Table is created successfully.")));
	    		}
    		}
    	}
    	/*$this->_temp = 1;
    	$formInstance = $this->getForm();
    	$mainForm = $formInstance->getForm();
    	$request = $this->getRequest();
    	//Get the post data from the submitted form
    	$data = $request->getPost($mainForm->getName());
    	$controller = $request->getControllerName();
    	$action = $request->getActionName();
    	//Check the submit button value
    	foreach($data as $key => $formData)
    	{
    		if($key == 'form1')
    		{
    			$gameFlavour = $formData['flavour'];
    			$tableConfigId = $formData['tableConfigId'];
    			
    			$tableConfig = new TableConfig();
				$tableConfigData = $tableConfig->getTableConfigDataByFlavour($gameFlavour, $tableConfigId);
				
				$jsonConfig = $tableConfigData['config'];
				$configData = Zend_Json::decode($jsonConfig);
				//Zenfox_Debug::dump($configData, 'config');
				foreach($configData as $key => $value)
				{
					$tableConfigData[$key] = $value;
				}
				$config['form2_0'] = $tableConfigData;
				//Zenfox_Debug::dump($tableConfigData, 'table');
				
    		}
    		$this->_namespace = $formData['formSession'];
    		$this->getSessionNamespace()->form2_0 = $config;
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
    	
    	//FIXME change the name of variable as $this->_action
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
        //$mainForm = $formInstance->setForm();
        if (!$mainForm->formIsValid($countSessNamespace, $this->_noOfParts)) {
	        $form = $this->setForm($mainForm, $countSessNamespace, 'next');
            $this->view->form = $mainForm->prepareSubForm($form, $controller, $action, $this->_namespace, $countSessNamespace);
            return $this->render($actionName);
        }
        // Valid form!
        // Render information in a verification page
        $modifiedData = array();
		foreach($this->getSessionNamespace() as $key => $data)
		{
			if($key == 'form2_0')
			{
				$configData['InitDecks']  = $data['form2_0']['InitDecks'];
				$configData['InitJokers']  = $data['form2_0']['InitJokers'];
				$configData['EarlyDropPoints']  = $data['form2_0']['EarlyDropPoints'];
				$configData['MidDropPoints']  = $data['form2_0']['MidDropPoints'];
				$configData['MaxPoints']  = $data['form2_0']['MaxPoints'];
				$configData['MinPoints']  = $data['form2_0']['MinPoints'];
				$configData['DefaultErrorTime']  = $data['form2_0']['DefaultErrorTime'];
				$configData['TurnTimeout']  = $data['form2_0']['TurnTimeout'];
				$configData['MeldTimeout']  = $data['form2_0']['MeldTimeout'];
				$configData['GameStartWait']  = $data['form2_0']['GameStartWait'];
				$configData['NoActivePlayerWait']  = $data['form2_0']['NoActivePlayerWait'];
				$configData['ShowResultWait']  = $data['form2_0']['ShowResultWait'];
				$configData['MatchResultWait']  = $data['form2_0']['MatchResultWait'];
				$configData['SessionStartWait']  = $data['form2_0']['SessionStartWait'];
				$configData['CanPlayerJoinInSession']  = (bool)$data['form2_0']['CanPlayerJoinInSession'];
				$configData['LoopOverSessions']  = (bool)$data['form2_0']['LoopOverSessions'];
				$configData['MaxSessionPoints']  = $data['form2_0']['MaxSessionPoints'];
				$configData['HouseEdge']  = $data['form2_0']['HouseEdge'];
				$configData['MaxTimeoutLimit']  = $data['form2_0']['MaxTimeoutLimit'];
				$configData['PlayerSelectTimeout']  = $data['form2_0']['PlayerSelectTimeout'];
				$jsonConfigData = Zend_Json::encode($configData);
				
				$modifiedData['config'] = $jsonConfigData;
				$modifiedData['minPlayer'] = $data['form2_0']['minPlayer'];
				$modifiedData['maxPlayer'] = $data['form2_0']['maxPlayer'];
				$modifiedData['maxSpectators'] = $data['form2_0']['maxSpectators'];
				$modifiedData['amountType'] = $data['form2_0']['amountType'];
				$modifiedData['minBet'] = $data['form2_0']['minBet'];
				$modifiedData['maxBet'] = $data['form2_0']['maxBet'];
				$modifiedData['minActiveRoom'] = $data['form2_0']['minActiveRoom'];
				$modifiedData['incrementRooms'] = $data['form2_0']['incrementRooms'];
				$modifiedData['createRooms'] = $data['form2_0']['createRooms'];
				$modifiedData['maxRooms'] = $data['form2_0']['maxRooms'];
				$modifiedData['tableName'] = $data['form2_0']['tableName'];
			}
			else
			{
				$modifiedData['gameFlavour'] = $data['form1']['flavour'];
				$modifiedData['tableConfigId'] = $data['form1']['tableConfigId'];
			}
		}
		$tableConfig = new TableConfig();
		$tableConfig->updateTableConfigData($modifiedData);
		//Unset the sessions
		$mainForm->deleteSession($this->_namespace);
		$mainForm->deleteSession($countSessNamespace);
		$mainForm->deleteSession('Action', $countSessNamespace);
		$this->_helper->FlashMessenger(array('notice' => $this->view->translate("Your data is saved.")));*/
    }
    
	//If the click on next button, check the data in the session or not and set it
    //accordingly.
    public function setForm($mainForm, $countSessNamespace, $page)
    {
    	$session = new Zend_Session_Namespace($countSessNamespace);
    	$partId = $session->value;
    	$counter = $mainForm->setCounter($countSessNamespace, $page);
    	
    	foreach($this->getSessionNamespace() as $sessionData)
    	{
    		if($sessionData)
    		{
	    		foreach($sessionData as $key => $data)
		   		{
		   			if($key == 'form1')
		   			{
		   				echo "form 1";
		   			}
		   			if(($key == 'form2_0'))
		   			{
		   				//echo "form 2";
		   				$form = $mainForm->setForm($key, $data);
						return $form;
		   			}
		   			/*$counter--;
		   			if(!$counter)
		   			{
		   				$form = $mainForm->setForm($key, $data);
						return $form;
		   			}*/
		   		}
    		}
    	}
    	$form = $mainForm->getCurrentSubForm($countSessNamespace);
    	
    	return $form;
    }
    
	public function indexAction()
	{
		$tableConfig = new TableConfig();
		$tableConfigData = $tableConfig->getAllTableConfig();

		foreach($this->getSessionNamespace() as $key => $sessionData)
		{
			$this->getSessionNamespace()->$key = NULL;
		}
		
		$this->getSessionNamespace()->form1 = $tableConfigData;
		$formInstance = $this->getForm();
    	$mainForm = $formInstance->getForm();
    	$namespace = $mainForm->setSession('index');
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
		$rummyForm = new Admin_RummyConfigMainForm();
		$form = $rummyForm->setForm($subForm, $tableConfigData);
		//Give the action name where submit action will be occured.
		$action = 'process';
		$this->view->form = $mainForm->prepareSubForm($form, $controller, $action, $this->_namespace, $countSessNamespace);
	}
	
	public function createAction()
	{
		$tableConfigData = new TableConfigData();
		$gameFlavours = $tableConfigData->getAllFlavours();

		$rummyConfigForm = new Admin_RummyConfigForm();
		//$configCreateForm = $rummyConfigForm->getForm();
		$flavourSelectionForm = $rummyConfigForm->getFlavourSelectionForm($gameFlavours);
		$this->view->configCreateForm = $flavourSelectionForm;
		/*if($this->getRequest()->isPost())
		{
			if($flavourSelectionForm->isValid($_POST))
			{
				$data = $flavourSelectionForm->getValues();
				$configData['InitDecks']  = $data['InitDecks'];
				$configData['InitJokers']  = $data['InitJokers'];
				$configData['EarlyDropPoints']  = $data['EarlyDropPoints'];
				$configData['MidDropPoints']  = $data['MidDropPoints'];
				$configData['MaxPoints']  = $data['MaxPoints'];
				$configData['MinPoints']  = $data['MinPoints'];
				$configData['DefaultErrorTime']  = $data['DefaultErrorTime'];
				$configData['TurnTimeout']  = $data['TurnTimeout'];
				$configData['MeldTimeout']  = $data['MeldTimeout'];
				$configData['GameStartWait']  = $data['GameStartWait'];
				$configData['NoActivePlayerWait']  = $data['NoActivePlayerWait'];
				$configData['ShowResultWait']  = $data['ShowResultWait'];
				$configData['MatchResultWait']  = $data['MatchResultWait'];
				$configData['SessionStartWait']  = $data['SessionStartWait'];
				$configData['CanPlayerJoinInSession']  = (bool)$data['CanPlayerJoinInSession'];
				$configData['LoopOverSessions']  = (bool)$data['LoopOverSessions'];
				$configData['MaxSessionPoints']  = $data['MaxSessionPoints'];
				$configData['HouseEdge']  = $data['HouseEdge'];
				$configData['MaxTimeoutLimit']  = $data['MaxTimeoutLimit'];
				$configData['PlayerSelectTimeout']  = $data['PlayerSelectTimeout'];
				$jsonConfigData = Zend_Json::encode($configData);
				
				$modifiedData['config'] = $jsonConfigData;
				$modifiedData['minPlayer'] = $data['minPlayer'];
				$modifiedData['maxPlayer'] = $data['maxPlayer'];
				$modifiedData['maxSpectators'] = $data['maxSpectators'];
				$modifiedData['amountType'] = $data['amountType'];
				$modifiedData['minBet'] = $data['minBet'];
				$modifiedData['maxBet'] = $data['maxBet'];
				$modifiedData['minActiveRoom'] = $data['minActiveRoom'];
				$modifiedData['incrementRooms'] = $data['incrementRooms'];
				$modifiedData['createRooms'] = $data['createRooms'];
				$modifiedData['maxRooms'] = $data['maxRooms'];
				$modifiedData['tableName'] = $data['tableName'];
				$modifiedData['gameFlavour'] = $data['flavour'];
				$modifiedData['gameType'] = $data['gameType'];
				$modifiedData['tableDescription'] = $data['tableDescription'];
				$modifiedData['status'] = $data['status'];
				
				$tableConfig = new TableConfig();
				$tableConfig->createTableConfig($modifiedData);
				
				$this->_helper->FlashMessenger(array('notice' => $this->view->translate("Your data is saved.")));
			}
		}*/
	}
	
	public function viewAction()
	{
		$tableConfig = new TableConfig();
		$tableConfigData = $tableConfig->getAllTableConfig();
		$finalConfig = array();
		$index = 0;
		foreach($tableConfigData as $configData)
		{
			$finalConfig[$index]['Table Id'] = $configData['table_config_id'];
			$finalConfig[$index]['Flavour'] = $configData['game_flavour'];
			$finalConfig[$index]['Table Name'] = $configData['table_name'];
			$finalConfig[$index]['(Max/Min) Players'] = $configData['max_players'] . '/' . $configData['min_players'];
			$finalConfig[$index]['(Max/Min) Bet'] = $configData['max_bet'] . '/' . $configData['min_bet'];
			$finalConfig[$index]['Amount Type'] = $configData['amount_type'];
			$finalConfig[$index]['Description'] = $configData['table_description'];
			$finalConfig[$index]['Status'] = $configData['status'];
			$index++;
		}
		$this->view->rummyConfig = $finalConfig;
	}
	
	public function editAction()
	{
		$tableConfigId = $this->getRequest()->tableId;
		$gameFlavour = $this->getRequest()->flavour;
		
		if(!$tableConfigId || !$gameFlavour)
		{
			$this->_redirect('/rummyconfig/view');
		}
		
		$tableConfig = new TableConfig();
		$tableConfigData = $tableConfig->getTableConfigDataByFlavour($gameFlavour, $tableConfigId);
		
		$jsonConfig = $tableConfigData['config'];
		$configData = Zend_Json::decode($jsonConfig);
		//Zenfox_Debug::dump($configData, 'config');
		foreach($configData as $key => $value)
		{
			$tableConfigData[$key] = $value;
		}
		
		$rummyConfigForm = new Admin_RummyConfigForm();
		$configEditForm = $rummyConfigForm->getForm($tableConfigData);
		
		$this->view->configEditForm = $configEditForm;
		
		if($this->getRequest()->isPost())
		{
			if($configEditForm->isValid($_POST))
			{
				$data = $configEditForm->getValues();
				$configData['InitDecks']  = $data['InitDecks'];
				$configData['InitJokers']  = $data['InitJokers'];
				$configData['EarlyDropPoints']  = $data['EarlyDropPoints'];
				$configData['MidDropPoints']  = $data['MidDropPoints'];
				$configData['MaxPoints']  = $data['MaxPoints'];
				$configData['MinPoints']  = $data['MinPoints'];
				$configData['DefaultErrorTime']  = $data['DefaultErrorTime'];
				$configData['TurnTimeout']  = $data['TurnTimeout'];
				$configData['MeldTimeout']  = $data['MeldTimeout'];
				$configData['GameStartWait']  = $data['GameStartWait'];
				$configData['NoActivePlayerWait']  = $data['NoActivePlayerWait'];
				$configData['ShowResultWait']  = $data['ShowResultWait'];
				$configData['MatchResultWait']  = $data['MatchResultWait'];
				$configData['SessionStartWait']  = $data['SessionStartWait'];
				$configData['CanPlayerJoinInSession']  = (bool)$data['CanPlayerJoinInSession'];
				$configData['LoopOverSessions']  = (bool)$data['LoopOverSessions'];
				$configData['MaxSessionPoints']  = $data['MaxSessionPoints'];
				$configData['HouseEdge']  = $data['HouseEdge'];
				$configData['MaxTimeoutLimit']  = $data['MaxTimeoutLimit'];
				$configData['PlayerSelectTimeout']  = $data['PlayerSelectTimeout'];
				$jsonConfigData = Zend_Json::encode($configData);
				
				$modifiedData['config'] = $jsonConfigData;
				$modifiedData['minPlayer'] = $data['minPlayer'];
				$modifiedData['maxPlayer'] = $data['maxPlayer'];
				$modifiedData['maxSpectators'] = $data['maxSpectators'];
				$modifiedData['amountType'] = $data['amountType'];
				$modifiedData['minBet'] = $data['minBet'];
				$modifiedData['maxBet'] = $data['maxBet'];
				$modifiedData['minActiveRoom'] = $data['minActiveRoom'];
				$modifiedData['incrementRooms'] = $data['incrementRooms'];
				$modifiedData['createRooms'] = $data['createRooms'];
				$modifiedData['maxRooms'] = $data['maxRooms'];
				$modifiedData['tableName'] = $data['tableName'];
				$modifiedData['tableDescription'] = $data['tableDescription'];
				$modifiedData['status'] = $data['status'];
				$modifiedData['gameFlavour'] = $gameFlavour;
				$modifiedData['tableConfigId'] = $tableConfigId;
				
				$tableConfig->updateTableConfigData($modifiedData);
				$this->view->configEditForm = '';
				$this->_helper->FlashMessenger(array('notice' => $this->view->translate("Your data is saved.")));
			}
		}
	}
}