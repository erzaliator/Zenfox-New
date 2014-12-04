<?php
require_once dirname(__FILE__) . '/../forms/MainForm.php';
require_once dirname(__FILE__) . '/../forms/BonusSchemeForm.php';
require_once dirname(__FILE__) . '/../forms/BonusLevelForm.php';
class Admin_BonusController extends Zenfox_Controller_Action
{
	private $_form;
	private $_session;
	private $_namespace;
	private $_temp;
	private $_noOfParts;
	public function init()
	{
		parent::init();
		$this->_redirector = $this->_helper->getHelper('Redirector');
        $contextSwitch = $this->_helper->getHelper('contextSwitch');
        $contextSwitch->setAutoJsonSerialization(false);
		$contextSwitch->addActionContext('create', 'json')
				->addActionContext('view', 'json')
				->addActionContext('edit', 'json')
              	->initContext();
// 		/Zend_Layout::getMvcInstance()->disableLayout();

	}
	public function getForm()
	{
		$schemeForm = new Admin_BonusSchemeForm();
		foreach($this->getSessionNamespace() as $key => $data)
		{
			if($key == 'form1')
			{
				$this->_noOfParts = $data['form1']['noOfParts'];
			}
		}
		if((null === $this->_form) && (!$this->_noOfParts))
		{
			$this->_form = new Admin_MainForm($schemeForm);
		}
		elseif(($this->_temp) && ($this->_noOfParts))
		{
			$levelForm = new Admin_BonusLevelForm();
			$this->_form = new Admin_MainForm($schemeForm, $levelForm, $this->_noOfParts);
			$this->_temp = 0;
		}
		return $this->_form;
	}
	public function getSessionNamespace()
	{
		$this->_session = new Zend_Session_Namespace($this->_namespace);
		return $this->_session;
	}
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
    	//Check the submit button value
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
    	//FIXME change the name of variable as $this->_action
    	$action = $request->getActionName();
    	if (!$form = $mainForm->getCurrentSubForm($countSessNamespace)) {
    		
    		return $this->_forward($actionName);
        }
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
        foreach($this->getSessionNamespace() as $key => $data)
        {
        	foreach($data as $formData)
        	{
        		if($key == 'form1')
	        	{
	        		if($formData['schemeId'])
	        		{
	        			$schemeId = $formData['schemeId'];
		        		if(!$this->updateSchemeData($formData))
		        		{
		        			$this->_redirect($language . '/error/error');
		        		}
	        		}
	        		else
	        		{
		        		if(!$schemeId = $this->insertSchemeData($formData))
		        		{
		        			$this->_redirect($language . '/error/error');
		        		}
	        		}
	        	}
	        	elseif($key != 'form1')
	        	{
	        		foreach($formData as $formKey => $value)
	        		{
	        			if(substr($formKey, 0, 11) == 'loyaltyForm')
	        			{
	        				$loyaltyFormData[$formKey] = $value;
	        			}
	        			else
	        			{
	        				$levelData[$formKey] = $value;
	        			}
	        		}
	        		if($levelData['levelId'])
	        		{
	        			$levelId = $levelData['levelId'];
	        			if(!$this->updateLevelData($levelData, $schemeId))
	        			{
	        				$this->_redirect($language . '/error/error');
	        			}
	        		}
	        		else
	        		{
	        			$levelData['schemeId'] = $schemeId;
	        			if(!$levelId = $this->insertLevelData($levelData))
	        			{
	        				$this->_redirect($language . '/error/error');
	        			}
	        		}
	        		foreach($loyaltyFormData as $loyaltyData)
	        		{
	        			$loyaltyData['schemeId'] = $schemeId;
	        			$loyaltyData['levelId'] = $levelId;
	        			if($loyaltyData['loyaltyFactorId'])
	        			{
	        				if(!$this->updateLoyaltyData($loyaltyData))
	        				{
	        					$this->_redirect($language . '/error/error');
	        				}
	        			}
	        			else
	        			{
	        				if(!$this->insertLoyaltyData($loyaltyData))
	        				{
	        					$this->_redirect($language . '/error/error');
	        				}
	        			}
	        		}
	        	}
        	}
        }
        $mainForm->deleteSession($this->_namespace);
        $mainForm->deleteSession($countSessNamespace);
        $mainForm->deleteSession('Action', $countSessNamespace);
        //$this->view->message = 'Your data is saved';
        $this->_helper->FlashMessenger(array('notice' => $this->view->translate("Your data is saved.")));
    //    exit();
	}
	public function insertLevelData($data)
	{
		$bonusConfiguration = new BonusConfiguration();
		$result = $bonusConfiguration->insertLevelData($data);
		if($result)
		{
			return $result;
		}
		return false;
	}
	public function insertSchemeData($data)
	{
		$bonusConfiguration = new BonusConfiguration();
		$result = $bonusConfiguration->insertSchemeData($data);
		if($result)
		{
			return $result;
		}
		return false;
	}
	public function insertLoyaltyData($data)
	{
		$bonusConfiguration = new BonusConfiguration();
		if($bonusConfiguration->insertLoyaltyData($data))
		{
			return true;
		}
		return false;
	}
	public function updateSchemeData($data)
	{
		$bonusConfiguration = new BonusConfiguration();
		if($bonusConfiguration->updateSchemeData($data))
		{
			return true;
		}
		return false;
	}
	public function updateLevelData($data)
	{
		$bonusConfiguration = new BonusConfiguration();
		if($bonusConfiguration->updateLevelData($data))
		{
			return true;
		}
		return false;
	}
	public function updateLoyaltyData($data)
	{
		$bonusConfiguration = new BonusConfiguration();
		if($bonusConfiguration->updateLoyaltyData($data))
		{
			return true;
		}
		return false;
	}
	public function setForm($mainForm, $countSessNamespace, $page)
    {
    	$session = new Zend_Session_Namespace($countSessNamespace);
    	$partId = $session->value;
    	$counter = $mainForm->setCounter($countSessNamespace, $page);
    	$loyaltyData = array();
    	foreach($this->getSessionNamespace() as $sessionData)
    	{
    		foreach($sessionData as $key => $data)
	   		{
	   			$counter--;
	   			if(!$counter)
	   			{
	   				$form = $mainForm->setForm($key, $data);
					return $form;
	   			}
	   			foreach($data as $index => $value)
	   			{
	   				if(substr($index,0,11) == 'loyaltyForm')
	   				{
	   					if($value['gameGroupId'])
	   					{
	   						$loyaltyData[$index] = $value;
	   					}
	   				}
	   			}
	   		}
    	}
    	$form = $mainForm->getCurrentSubForm($countSessNamespace);
    	if($loyaltyData)
	   	{
	   		$form = $mainForm->setForm($form->getName(), $loyaltyData);
	   	}
    	return $form;
    }
	public function editAction()
    {
    	$schemeId = $this->getRequest()->id;
    	$bonusScheme = new BonusScheme();
    	$levelId = $this->getRequest()->levelId;
    	if($levelId)
    	{
    		$bonusLevelData = $bonusLevel->getLevelData($levelId, $schemeId);
    		$form = new Admin_BonusLevelForm();
    		$bonusLevelForm = $form->getBonusLevelForm($bonusLevelData[0]);
    		$this->view->form = $bonusLevelForm;
    		if($this->getRequest()->isPost())
    		{
    			if($bonusLevelForm->isValid($_POST))
    			{
    				$data = $bonusLevelForm->getValues();
    				$bonusConfiguration = new BonusConfiguration();
    				$updateLevelData = $bonusConfiguration->updateLevelData($data, $schemeId);
    				if($updateLevelData)
    				{
    					$this->_helper->FlashMessenger(array('notice' => $this->view->translate("Bonus Level is updated successfully.")));
    				}
    				else
    				{
    					$this->_helper->FlashMessenger(array('notice' => $this->view->translate("Some problem while updating.")));
    				}
    			}
    		}
    	}
    	$bonusLevel = new BonusLevel();
    	$allLevelsData = $bonusLevel->getAllLevelsData($schemeId);
    	$levels = array();
    	foreach($allLevelsData as $index => $levelData)
    	{
    		$levels[$index]['Id'] = $levelData['levelId'];
    		$levels[$index]['Name'] = $levelData['levelName'];
    		$levels[$index]['(Min/Max) Points'] = $levelData['minPoints'] . '/' . $levelData['maxPoints'];
    		$levels[$index]['Bonus(%)'] = $levelData['bonusPercent'];
    		$levels[$index]['Fixed Bonus'] = $levelData['fixedBonus'];
    		$levels[$index]['Min Deposit'] = $levelData['minDeposit'];
    		$levels[$index]['Min Total Deposit'] = $levelData['minTotalDeposit'];
    		$levels[$index]['Reward Times'] = $levelData['rewardTimes'];
    		$levels[$index]['Fixed Real'] = $levelData['fixedReal'];
    	}
    	$this->view->allLevelsData = $levels;
    	$this->view->schemeId = $schemeId;
    }
    
    public function viewAction()
    {
    	$bonusScheme = new BonusScheme();
    	$schemeData = $bonusScheme->getAllSchemeData();
    	$this->view->schemeData = $schemeData;
    }
}
