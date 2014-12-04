<?php
/**
 * This class implements bingo game configuration
 * @author Nikhil Gupta 
 * @date Jan 20, 2010
 */
require_once dirname(__FILE__).'/../forms/MainForm.php';
require_once dirname(__FILE__).'/../forms/BingoForm.php';
require_once dirname(__FILE__).'/../forms/VariablePotForm.php';
require_once dirname(__FILE__).'/../forms/FixedPotForm.php';
require_once dirname(__FILE__).'/../forms/BingoActivePreBuysForm.php';
require_once dirname(__FILE__).'/../forms/PJPForm.php';
require_once dirname(__FILE__).'/../forms/BingoCategoryForm.php';
require_once dirname(__FILE__).'/../forms/BingoRoomForm.php';
require_once dirname(__FILE__).'/../forms/BingoSessionsForm.php';
require_once dirname(__FILE__).'/../forms/PatternForm.php';


class Admin_BingoController extends Zenfox_Controller_Action
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
    	//Zenfox_Debug::dump($this->getSessionNamespace());//exit;
    	foreach($this->getSessionNamespace() as $key => $data)
		{
			if($key == 'form1')
			{
				$this->_noOfParts = $data['form1']['noOfParts'];
				$gameType = $data['form1']['gameType'];
			}
		}
		$bingoForm = new Admin_BingoForm();
		//Check if there is any form exists in session
		if((null === $this->_form) && (!$this->_noOfParts))
		{
			$this->_form = new Admin_MainForm($bingoForm);
		}
		//Add as many subforms as many no of parts


		if(($this->_temp) && ($this->_noOfParts))
    	{
    		if($gameType == 'VARIABLE')
			{
				$potForm = new Admin_VariablePotForm();
			}
			elseif($gameType == "FIXED")
			{
				$potForm = new Admin_FixedPotForm();
			}
			$this->_form = new Admin_MainForm($bingoForm, $potForm, $this->_noOfParts);
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
    	
    	//Creating session for storing action name
    	$countSessNamespace = $namespace;
    	//Creating session for storing counter value
		
    	$subForm = $mainForm->getCurrentSubForm($countSessNamespace);
		//Give the action name where submit action will be occured.
		$action = 'process';
		$this->view->form = $mainForm->prepareSubForm($subForm, $controller, $action, $this->_namespace, $countSessNamespace);
    }

    //This function is used store the form data in session
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
    	//Zenfox_Debug::dump($data);
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
        
  		foreach($this->getSessionNamespace() as $data)
		{
			foreach($data as $key => $formData)
			{
				if($key == 'form1')
				{
					$gameType = $formData['gameType'];
					$bingoId = $formData['bingoGameId'];
					if($bingoId)
					{
						
						if(!$this->updateBingoData($formData))
						{
							$this->_redirect($language . '/error/error');
						}
					}
					else
					{
    					//	Zenfox_Debug::dump($formData,'session',true,true);
						
						if(!$this->insertBingoData($formData))
						{
							$this->_redirect($language . '/error/error');
						}
						
					}
				}
				if($key != 'form1')
				{
					if($gameType == 'VARIABLE')
					{
						
						$varPotId = $formData['varPotId'];
						if($varPotId)
						{
							$formData['gameId'] = $bingoId;
							if(!$this->updateVarPotData($formData))
							{
								$this->_redirect($language . '/error/error');
							}
						}
						elseif((!$varPotId) && ($bingoId))
						{
							$formData['gameId'] = $bingoId;
							if(!$this->insertVarPotData($formData))
							{
								$this->_redirect($language . '/error/error');
							}
						}
						else
						{
							if(!$this->insertVarPotData($formData))
							{
								$this->_redirect($language . '/error/error');
							}
						}
					}
					elseif($gameType == 'FIXED')
					{
						//Zenfox_Debug::dump($formData,'session',true,true);exit;
						$fixedPotId = $formData['fixedPotId'];
						if($fixedPotId)
						{
							if(!$this->updateFixedPotData($formData))
							{
								$this->_redirect($language . '/error/error');
							}
						}
						elseif((!$fixedPotId) && ($bingoId))
						{
							$formData['gameId'] = $bingoId;
							if(!$this->insertFixedPotData($formData))
							{
								$this->_redirect($language . '/error/error');
							}
						}
						else
						{
							if(!$this->insertFixedPotData($formData))
							{
								$this->_redirect($language . '/error/error');
							}
						}
					}
				}
			}
     }	
		
		//$mainForm->deleteSession($this->_namespace);
		//$mainForm->deleteSession($countSessNamespace);
		//$mainForm->deleteSession('Action', $countSessNamespace);
		
		$this->_helper->FlashMessenger(array('notice' => $this->view->translate("Your data is saved.")));
    }
    //Insert the bingo data in database
   
		
    
    
    
    public function insertBingoData($data)
    {
    	$bingo = new BingoConfig();
    	if($bingo->insertData($data))
    	{
    		return true;
    	}
    	return false;
    }
    //Insert the variable pot data in database
    public function insertVarPotData($data)
    {
    	$varPot = new VarPotConfig();
    	if($varPot->insertData($data))
    	{
    		return true;
    	}
    	return false;
    }
    //insert fixed pot data in database
    public function insertFixedPotData($data)
    {
    	$fixedPot = new FixedPotConfig();
    	if($fixedPot->insertData($data))
    	{
    		return true;
    	}
    	return false;
    }
    //If the click on next button, check the data in the session or not and set it
    //accordingly.
    public function setForm($mainForm, $countSessNamespace, $page)
    {
    	$session = new Zend_Session_Namespace($countSessNamespace);
    	$partId = $session->value;
    	$counter = $mainForm->setCounter($countSessNamespace, $page);
    	
    	//Zenfox_Debug::dump($counter);
    	foreach($this->getSessionNamespace() as $sessionData)
    	{
    		//Zenfox_Debug::dump($sessionData);
    		foreach($sessionData as $key => $data)
	   		{
	   		
	   			$counter--;
	   			if(!$counter)
	   			{
	   				$form = $mainForm->setForm($key, $data);
					return $form;
	   			}
	   		}
    	}
    	$form = $mainForm->getCurrentSubForm($countSessNamespace);
    	$form->partId->setValue(($partId));
    	
    	return $form;
    }
    
    /**
     * This function is used to edit the forms
     * @return unknown_type
     */
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
    	$bingoId = $request->id;
    	$bingo = new BingoGame();
    	$data = $bingo->getData($bingoId);
    	$bingoData = array();		
    	//getPjpByGameId($gameId)
    	
  		if($data['pjpEnabled'] == 'ENABLED')
    	{
    		$bingopjpobj = new BingoPjp();
    		$pjpData = $bingopjpobj->getPjpDataByGameId($bingoId);
    		
    		$data["pjppercentReal"] = $pjpData["percent_real"];
  			$data["pjppercentBbs"] = $pjpData["percent_bbs"];
  			$data["pjpmaxcalls"] = $pjpData["max_no_of_calls"];
  			$data["pjpfixedReal"] = $pjpData["fixed_amount_real"];
  			$data["pjpfixedBbs"] = $pjpData["fixed_amount_bbs"];
    	}
    	
    	$bingogamecategoryobj = new BingoGameCategory();
    	$data["category"] = $bingogamecategoryobj->getcategoriesbygameId($bingoId);
    	
    	//Zenfox_Debug::dump($categorieslist, 'cat');
    	
    	
    	if($data['gameType'] == 'FIXED')
    	{
    		$fixedPotPayment = new BingoFixedPotPayment();
    		$potData = $fixedPotPayment->getData($bingoId);
    	}
    	elseif($data['gameType'] == 'VARIABLE')
    	{
    		$varPotPay = new BingoVariablePotPayment();
    		$potData = $varPotPay->getData($bingoId);
    	}
    	$data["noOfParts"] = count($potData);
    	
    	$bingoData['form1'] = $data;
    	$this->getSessionNamespace()->form1 = $bingoData;
    	$i = 0;
    	$allPotData = array();
    	foreach($potData as $key => $info)
    	{
    		$name = 'form2_' . $i;
    		$allPotData[$i][$name] = $info;
    		$this->getSessionNamespace()->$name = $allPotData[$i];
    		$i++;
    	}
    	$this->_temp = 1;
    	
    	$subForm = $mainForm->getCurrentSubForm($countSessNamespace);
		$bingoForm = new Admin_BingoForm();
		$form = $bingoForm->setForm($subForm, $data);
		//Sending session namespaces as hidden data
		$action = 'process';
		$this->view->form = $mainForm->prepareSubForm($form, $controller, $action, $this->_namespace, $namespace);
    }
    
    //Update the bingo data in database
    public function updateBingoData($data)
    {
    	$bingo = new BingoConfig();
    	if($bingo->updateData($data))
    	{
    		return true;
    	}
    	return false;
    }
    //Update the fixed pot data in database
	public function updateFixedPotData($data)
    {
    	$fixedPotPayment = new FixedPotConfig();
    	if($fixedPotPayment->updateData($data))
    	{
    		return true;
    	}
    	return false;
    }
    //Update variable pot data in database
    public function updateVarPotData($data)
    {
    	$varPot = new VarPotConfig();
    	if($varPot->updateData($data))
    	{
    		return true;
    	}
    	return false;
    }
    
    public function viewAction()
    {
    	$bingo = new BingoGame();
    	$allBingoData = $bingo->getAllData();
    	$this->view->allBingoData = $allBingoData;
    }
    
	public function roomsAction()
    {
    	$bingorooms = new BingoRoom();
    	$roomslist = $bingorooms->getAllRooms();
    	$count = count($roomslist);
		$index =0;
		while($index < $count)
		{
			if($roomslist[$index]["enabled"] == "ENABLED")
			{
				$roomslist[$index]["Change Status"] = '<form action="/bingo/roomstatus/roomId/' . $roomslist[$index]["id"] . '/Status/DISABLED" method = "POST"><input type="submit" name="status" value="Disable the Room"></form>';
			}
			else 
			{
				$roomslist[$index]["Change Status"] = '<form action="/bingo/roomstatus/roomId/' . $roomslist[$index]["id"] . '/Status/ENABLED" method = "POST"><input type="submit" name="status" value="Enable the Room"></form>';
			}
			$index++;
		}
		$this->view->allrooms = $roomslist;
		
		
   		
   		$sessionsobj = new BingoSession();
    	$sessions = $sessionsobj->getAllSessions();
    	$sessiondata = array();
   		 foreach($sessions as $data)
        {
        	$sessiondata[$data["id"]] = $data["name"];
        	
        }
      	
      	$runningroomobj = new BingoRunningRoom();
   		$runningrooms = $runningroomobj->getAllRunningRooms();
   				
    	$count = count($runningrooms);
    	$index = 0;
    	while($index < $count)
    	{
    		$rooms[$index]["room Id"] = $runningrooms[$index]["game_id"];
    		$rooms[$index]["room Name"] = $runningrooms[$index]["room_name"];
    		$rooms[$index]["Game Flavour"] = $runningrooms[$index]["game_type"];
    		$rooms[$index]["Total Players"] = $runningrooms[$index]["players"];
    		$rooms[$index]["Session Name"] = $sessiondata[$runningrooms[$index]["session_id"]];
    		$rooms[$index]["Amount Type"] = $runningrooms[$index]["amount_type"];
    		
    					 					
    		$index++;
    	}
		$this->view->runningrooms = $rooms;
		
    
    }
    
    public function roomstatusAction()
    {
    	$bingorooms = new BingoRoom();
   		 $roomId = $this->getRequest()->roomId;
   		 $status = $this->getRequest()->Status;
		if($roomId && $status)
		{
			if($status == "ENABLED")
			{
				$roomsessionobj = new BingoRoomSession();
				$roomsessiondata = $roomsessionobj->getroomdata($roomId);
				if(!$roomsessiondata)
				{
					$this->_helper->FlashMessenger(array('message' => 'Room with roomId '.$roomId. ' ENABLED but no Sessions were added to this room'));
				}
				else
				{
					$this->_helper->FlashMessenger(array('message' => 'Room with roomId '.$roomId. ' is ENABLED '));
				}
			}
			elseif($status == "DISABLED")
			{
				$runningroomobj = new BingoRunningRoom();
				$roomdata = $runningroomobj->getRunningRoomData($roomId);
				if($roomdata)
				{
					$this->_helper->FlashMessenger(array('message' => 'Currently a game is running in this room with roomId '.$roomId.' so the room will be DISABLED when the game is completed'));
				}
				else
				{
					$this->_helper->FlashMessenger(array('message' => 'Room with roomId '.$roomId. ' is DISABLED '));
				}
			}
			$bingorooms->changestatus($roomId,$status);
		}
    }
    
    public function roomsessionsAction()
    {
    	$roomId = $this->getRequest()->roomId;
    	$roomsessionsobj = new BingoRoomSession();
    	if($roomId)
    	{
    		if($this->getRequest()->isPOST())
    		{
    			//Zenfox_Debug::dump($_POST);
    			
    			$deleteresult = $roomsessionsobj->deleteroomsessions($roomId);
    					
    					if($deleteresult )
    					{
    						$roomresult = $roomsessionsobj->insertroomssessions($roomId,$_POST);
    						if($roomresult)
    						{
    							
    							$this->_helper->FlashMessenger(array('success' => 'Update Successful'));
    						}
    						else
    						{
    							$this->_helper->FlashMessenger(array('error' => 'Sessions not Updated properly so try inserting again'));
    						}
    						
    					}
    					else
    					{
    						$this->_helper->FlashMessenger(array('error' => 'Update Failed'));
    					}
    		}
    		
    		$sessionsobj = new BingoSession();
    		$sessions = $sessionsobj->getAllSessions();
    		
    		$roomsessions = $roomsessionsobj->getroomdata($roomId);
    		
    		$count = count($roomsessions);
    		while($count>=0)
    		{
    			$count--;
    			$roomsessions[$count]["sequence"] = $roomsessions[$count]["sequence"]%24;
    			$sessionssequence[$roomsessions[$count]["day"]."_".$roomsessions[$count]["sequence"]] = $roomsessions[$count]["session_id"];
    		}
    	
    		$formstart = "<form method='POST'>";
    		
    		$hourcount = 0;
    		$daycount =1;
    		$days = array(0,"monday","tuesday","wednesday","thursday","friday","saturday","sunday");
    		while($hourcount < 24)
    		{
    			$result[$hourcount]["time"] = $hourcount.":00 - ".($hourcount+1).":00";
    			while($daycount<=7)
    			{
    				$formDataStartTillId = "<select  name='";
    				$formDataStartAfterId = "' class='h timepicker'>";
    	
    				$sessionindex = 0;
    				$count = count($sessions);
    				while($sessionindex < $count)
    				{
    					if($sessionssequence[$daycount."_".$hourcount] == $sessions[$sessionindex]['id'])
    					{
    						$formDataStartAfterId = $formDataStartAfterId."<option value=".$sessions[$sessionindex]['id']." selected>".$sessions[$sessionindex]['name']."</option>";	
    					}
    					else
    					{
    						$formDataStartAfterId = $formDataStartAfterId."<option value=".$sessions[$sessionindex]['id'].">".$sessions[$sessionindex]['name']."</option>";
    					}
    					
    					$sessionindex++;
    				}
    				$result[$hourcount][$days[$daycount]] = $formDataStartTillId.$daycount."_".$hourcount.$formDataStartAfterId;
    				
    				$formDataStartTillId = "";
    				$formDataStartAfterId = "";
    				$daycount++;
    			}
    			
    			$daycount = 1;
    			$hourcount++;
    		}
    	
    		$formend = "<input type='submit' value='save' name='status'></form>";
    		
    	
    		
    		$this->view->result = $result;
    		$this->view->formstart = $formstart;
    		$this->view->formend = $formend;
    	
    		
    	}
    	
    }
    
    public function viewactiveprebuysAction()
    {
    	$form = new Admin_BingoActivePreBuysForm();
    	$this->view->form = $form->getform();
    	$Bingoprebuyobj = new BingoPrebuy();
    	$offset = $this->getRequest()->page;
   		if(($offset))
    	{
    		$starttime = $this->getRequest()->starttime;
    		$endtime = $this->getRequest()->endtime;
    		$status = $this->getRequest()->status;
    		$itemsperpage = $this->getRequest()->item;
    		
    		$Activeprebuys = $Bingoprebuyobj->getactiveprebuys($starttime,$endtime,$status,$offset,$itemsperpage);
				
				$this->view->result = $Activeprebuys[1];
				$this->view->paginator = $Activeprebuys[0];
				$this->view->starttime = $starttime;
				$this->view->endtime = $endtime;
				$this->view->status = $status;
    	}
    	
     	if($this->getRequest()->isPOST())
    	{
    		if($form->isvalid($_POST))
    		{
    			$postvalues = $form->getValues();
    			
    			$starttime = $postvalues['startdate'];
				$newdatetime = new Zend_Date($starttime);
				$starttime = $newdatetime->get(Zend_Date::W3C);
					
				$endtime = $postvalues['enddate']. " " . "24:00:00";
				$newdatetime = new Zend_Date($endtime);
				$endtime = $newdatetime->get(Zend_Date::W3C);
				
				$status = implode($postvalues["status"],',');	
				
				$Activeprebuys = $Bingoprebuyobj->getactiveprebuys($starttime,$endtime,$status,1,$postvalues["items"]);
				
    			if(!empty($Activeprebuys))
					{
						$this->view->result = $Activeprebuys[1];
						$this->view->paginator = $Activeprebuys[0];
						$this->view->starttime = $starttime;
						$this->view->endtime = $endtime;
						$this->view->status = $status;
					}
					else
					{
						$this->_helper->FlashMessenger(array('error' => 'No Records found.'));
					}
				
    		}
    	}
    	
    	
    }
    
    public function activeprebuysAction()
    {
    	$form = new Admin_BingoActivePreBuysForm();
    	$this->view->form = $form->getform();
    	
    	$PlayerId = $this->getRequest()->PlayerId;
    	$PrebuyId = $this->getRequest()->PrebuyId;
    	$statuschangesto = $this->getRequest()->Statuschangesto;
    	$submit = $this->getRequest()->submit;
		$offset = $this->getRequest()->page;
    	
		$Bingoprebuyobj = new BingoPrebuy();
		
    	if(($PlayerId) && ($PrebuyId) &&  ($submit))
    	{
			  $Bingoprebuyobj->changestatus($PlayerId,$PrebuyId,$statuschangesto);
    	}
    	
    	if(($offset) && (!$starttime)&& (!$endtime))
    	{
    		$starttime = $this->getRequest()->starttime;
    		$endtime = $this->getRequest()->endtime;
    		$status = $this->getRequest()->status;
    		$itemsperpage = $this->getRequest()->item;
    		
    		$Activeprebuys = $Bingoprebuyobj->getactiveprebuys($starttime,$endtime,$status,$offset,$itemsperpage);
				
				$this->view->result = $Activeprebuys[1];
				$this->view->paginator = $Activeprebuys[0];
				$this->view->starttime = $starttime;
				$this->view->endtime = $endtime;
				$this->view->status = $status;
    	}
    }
    
    
	public function viewcategoriesAction()
    {
    	$categoryobj = new BingoCategory();
    	$categories = $categoryobj->getAllCategories();
    	$this->view->details = $categories;
    }
    
    
    public function categoriesAction()
    {
    	$categoryobj = new BingoCategory();
    	$CategoryId = $this->getRequest()->CategoryId;
    	$CreateCategory = $this->getRequest()->createcategory;
    	if($CategoryId)
    	{
    		$Categorydata = $categoryobj->getcategorybyId($CategoryId);
    		$form = new Admin_BingoCategoryForm();
    		$this->view->form = $form->getForm($Categorydata[0]);  
    		if($this->getRequest()->isPost())
    		{
    			if($form->isValid($_POST))
    			{
    				$postvalues = $form->getValues();
    				$result = $categoryobj->updatecategorydetails($postvalues);
    				
    				if($result)
    				{
    					$Categorydata = $categoryobj->getcategorybyId($CategoryId);
    					$this->view->form = $form->getForm($Categorydata[0]); 
    					$this->_helper->FlashMessenger(array('success' => 'Update Successful'));
    				}
    				else
    				{
    					$this->_helper->FlashMessenger(array('error' => 'Update Failed'));
    				}
    				
    			}
    		}		
    	}
    	else 
    	{
    		if($CreateCategory)
    		{
    			$form = new Admin_BingoCategoryForm();
    			$this->view->form = $form->getForm();  
    			if($this->getRequest()->isPost())
    			{
    				if($form->isValid($_POST))
    				{
    					$postvalues = $form->getValues();
    					$result = $categoryobj->insertcategorydetails($postvalues);
    				
    					if($result)
    					{
    						$this->view->form = "";
    						$this->_helper->FlashMessenger(array('success' => 'New Category Created Successfully'));
    						echo "<br/>"."<br/>";
    						echo '<a href = "/bingo/viewcategories/">'.' << back'.' </a>';
							echo "<br/>"."<br/>";
    					}
    					else
    					{
    						$this->_helper->FlashMessenger(array('error' => 'Category not created'));
    					}
    				
    				}
    			}
    		}
    	}
    		
    }
    
	public function viewsessionsAction()
    {
    	$sessionsobj = new BingoSession();
    	$sessions = $sessionsobj->getAllSessions();
    	$this->view->sessions = $sessions;
    }
    
	public function sessionsAction()
    {
    	$SessionId = $this->getRequest()->SessionId;
    	$CreateSession = $this->getRequest()->createSession;
    	$form = new Admin_BingoSessionsForm();
    	$sessionsobj = new BingoSession();
    	$sessiongameobj = new BingoSessionGame();
    	if($SessionId)
    	{
    		$this->view->sessionId = $SessionId;
    		
    		$addgames = $this->getRequest()->addgames;
    		
    		
    			$sessiondata = $sessionsobj->getSessionData($SessionId);
    			$sessiondata["bingo"] = $sessiongameobj->getSessionGamesList($SessionId);
    			$this->view->form = $form->getForm($sessiondata);
    		
    			if($this->getRequest()->isPost())
    			{
    				if($form->isValid($_POST))
    				{
    					$postvalues = $form->getValues();
    					//Zenfox_Debug::dump($postvalues["bingo"]);//exit;
    					$postvalues["id"] = $SessionId;
    					$sessionresult = $sessionsobj->updatebingosession($postvalues);
    					
    					if($sessionresult )
    					{
    						$gameresults = $sessiongameobj->updatebingogames($SessionId,$postvalues["bingo"]);
    						if($gameresults)
    						{
    							$sessiondata = $sessionsobj->getSessionData($SessionId);
    							$sessiondata["bingo"] = $sessiongameobj->getSessionGamesList($SessionId);
    							$this->view->form = $form->getForm($sessiondata);
    							$this->_helper->FlashMessenger(array('success' => 'Update Successful'));
    						}
    						else
    						{
    							$this->_helper->FlashMessenger(array('error' => 'Games not Updated properly so try inserting again'));
    						}
    						
    					}
    					else
    					{
    						$this->_helper->FlashMessenger(array('error' => 'Update Failed'));
    					}
    				}
    			}
    		
    	}
    	elseif($CreateSession)
    	{
    		$this->view->form = $form->getForm();
    		if($this->getRequest()->isPost())
    		{
    			if($form->isValid($_POST))
    			{
    				$postvalues = $form->getValues();
    				
    			$result = $sessionsobj->insertbingosession($postvalues);
    				
    				if($result)
    				{
    					$SessionId = $sessionsobj->getLatestInsertData();
    					$gameresults = $sessiongameobj->updatebingogames($SessionId,$postvalues["bingo"]);
    					if($gameresults)
    					{
    						$this->view->form = "";
    						$sessiondata = $sessionsobj->getSessionData($SessionId);
    						$sessiondata["bingo"] = $sessiongameobj->getSessionGamesList($SessionId);
    						$this->view->form = $form->getForm($sessiondata);
    						$this->view->form = $form->getForm($sessiondata);
    						$this->_helper->FlashMessenger(array('success' => 'Insert Successful'));
    					}
    					else
    					{
    						$this->_helper->FlashMessenger(array('error' => 'Games not Inserted so try inserting again'));
    					}
    					
    				}
    				else
    				{
    					$this->_helper->FlashMessenger(array('error' => 'Insert Failed'));
    				}
    			}
    		}
    	}
    	
    }
    
	public function viewpjpAction()
    {
    	$pjpobj = new Pjp();
    	$pjpdetails = $pjpobj->getPjpDetails();
    	
    			$count = count($pjpdetails);
    			$index =0;
    	
    			while($index<$count)
    			{
    				$tabledetails[$index]["Id"] = $pjpdetails[$index]["id"];
    				$tabledetails[$index]["Name"] = $pjpdetails[$index]["pjp_name"];
    				$tabledetails[$index]["PJP Type"] = $pjpdetails[$index]["reset_close"];
    				$tabledetails[$index]["PJP Status"] = $pjpdetails[$index]["closed"];
    				$index++;
    			}
    			$this->view->details = $tabledetails;
    }
    
	public function pjpAction()
    {
    	$pjpobj = new Pjp();
    	$PJPId = $this->getRequest()->PJPId;
    	$CreatePjp = $this->getRequest()->createpjp;
    	if($PJPId)
    	{
    		$pjpdetails = $pjpobj->getpjpbyId($PJPId);
    		$form = new Admin_PJPForm();
    		$this->view->form = $form->getForm($pjpdetails[0]);  
    		if($this->getRequest()->isPost())
    		{
    			if($form->isValid($_POST))
    			{
    				$postvalues = $form->getValues();
    				$postvalues["Id"] = $PJPId;
    				$result = $pjpobj->updatepjpdetails($postvalues);
    				
    				if($result)
    				{
    					$pjpdetails = $pjpobj->getpjpbyId($PJPId);
    					$this->view->form = $form->getForm($pjpdetails[0]); 
    					$this->_helper->FlashMessenger(array('success' => 'Update Successful'));
    				}
    				else
    				{
    					$this->_helper->FlashMessenger(array('error' => 'Update Failed'));
    				}
    				
    			}
    		}		
    	}
    	else 
    	{
    		if($CreatePjp)
    		{
    			$form = new Admin_PJPForm();
    			$this->view->form = $form->getForm();  
    			if($this->getRequest()->isPost())
    			{
    				if($form->isValid($_POST))
    				{
    					$postvalues = $form->getValues();
    					$result = $pjpobj->insertpjpdetails($postvalues);
    				
    					if($result)
    					{
    						$this->view->form = "";
    						$this->_helper->FlashMessenger(array('success' => 'New PJP Created Successfully'));
    						echo "<br/>"."<br/>";
    						echo '<a href = "/bingo/viewpjp/">'.' << back'.' </a>';
							echo "<br/>"."<br/>";
    					}
    					else
    					{
    						$this->_helper->FlashMessenger(array('error' => 'PJP not created'));
    					}
    				
    				}
    			}
    		}
    		
    		
    	}
    
    }
    
    
	public function patternsAction()
    {
    	$form = new Admin_PatternForm();
    	$this->view->form = $form->getForm();
    	
    	if($this->getRequest()->isPost())
    			{
    				if($form->isValid($_POST))
    				{
    					$postvalues = $form->getValues();
    					
    					$patternobj = new BingoPattern();
    					$result = $patternobj->insertPatternData($postvalues);
    					if($result)
    					{
    						$this->_helper->FlashMessenger(array('error' => 'Pattern inserted successfully'));
    					}
    					else
    					{
    						$this->_helper->FlashMessenger(array('error' => 'Insert Failed'));
    					}
    				}
    			}
    }
    
 	public function recentwinnersAction()
    {
   		$runningroomobj = new BingoRunningRoom();
		$roomdata = $runningroomobj->getAllRunningRooms();
		
		//Zenfox_Debug::dump($roomdata);
		$this->view->winners = "";
		$bingorecentwinnersobj = new BingoRecentWinners();
		$lengthofRoomData = count($roomdata);
		$index = 0;
		while($index < $lengthofRoomData)
		{
			$recentwinners[$index]["RoomName"] =$roomdata[$index]["room_name"];
			$recentwinners[$index]["list"] = $bingorecentwinnersobj->getbingorecentwinnerslist($roomdata[$index]["game_id"]);
			$this->view->winners[$index] = $recentwinners[$index];
			$index++;
		}
		
    }
    
}
