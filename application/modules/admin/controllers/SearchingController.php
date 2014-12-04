<?php
//FIXME put the player model in application/model
require_once dirname(__FILE__).'/../../player/forms/RegistrationForm.php';
//require_once dirname(__FILE__).'/../../player/models/Player.php';
require_once dirname(__FILE__).'/../forms/UserForm.php';
class Admin_SearchingController extends Zenfox_Controller_Action
{
	public function init()
	{
		parent::init();
		$this->_redirector = $this->_helper->getHelper('Redirector');
        $contextSwitch = $this->_helper->getHelper('contextSwitch');
       $contextSwitch->setAutoJsonSerialization(false);
		$contextSwitch->addActionContext('index', 'json')
						->addActionContext('edit', 'json')				
              	->initContext();
        //Zend_Layout::getMvcInstance()->disableLayout();
	}
	
	public function indexAction()
	{
		$authSession = new Zend_Auth_Storage_Session();
		$sessionData = $authSession->read();
		$csrId = $sessionData['id'];
		$csrfrontendids = $sessionData['frontend_ids'];
		$sessionName = 'Searching_' . $csrId;
		$session = new Zend_Session_Namespace($sessionName);
		$language = $this->getRequest()->getParam('lang');
		$player = new Player();
	 	$form = new Admin_UserForm();
       	$this->view->form = $form;
        $offset = $this->getRequest()->page;
       
        /*if($offset)
        {
        	$itemsPerPage = $this->getRequest()->item;
        	$searchField = $this->getRequest()->field;
        	$match = $this->getRequest()->match;
        	
        	$searchString = $this->getRequest()->str;
        	$fromTime = $this->getRequest()->from;
			$from_date = date ("Y-m-d H:i:s", strtotime("$fromTime, - 5 HOUR 30 MINUTE"));
			
			$toTime = $this->getRequest()->to;
			$to_date = date ("Y-m-d H:i:s", strtotime("$toTime, - 5 HOUR 30 MINUTE"));
        	if($searchField == 'registration')
        	{
        		$playersData = $player->getAllRegistrations($offset, $itemsPerPage, $session, $from_date, $to_date);
        	}
        	elseif($searchField == 'depositor')
        	{
        		$playersData = $player->getAllDepositors($offset, $itemsPerPage, $session, $from_date, $to_date);
        	}
        	else
        	{
        		$playersData = $player->getAllPlayers($searchField, $match, $offset, $itemsPerPage, $session, $searchString);
        	}
        	if(!$playersData)
        	{
        		$this->_redirect($language . '/error/error');
        	}

        	$this->view->paginator = $playersData[0];
        	//$this->view->items = $itemsPerPage;
        	$this->view->searchField = $searchField;
        	$this->view->match = $match;
        	$this->view->searchStr = $searchString;
        	$this->view->contents = $playersData[1];
        	$this->view->accountType = 'confirmed';
        	$this->view->from = $from_date;
		    $this->view->to = $to_date;
        }*/
        
        //$this->view->offset = $offset;
        if($this->getRequest()->isPost())
        {
        	if($form->isValid($_REQUEST))
        	{        
        		//$offset = 1;
        		//$session->unsetAll();
        		$player = new Player();
        		$data = $form->getValues();
        		$playerId = '';
        		switch($data['searchField'])
        		{
        			case 'player_id':
        				$playerId = $data['searchString'];
        				break;
        			case 'login':
        				$csrfrontendids = implode(",", $csrfrontendids);
        				//$playerId = $player->getAccountIdFromLogin($data['searchString']);
        				$offset = 1;
        				
        				$playersData = $player->getAllPlayers($data['searchField'], 0, $offset, $data['items'], $session, $data['searchString'], $csrfrontendids,$data["accountType"]);
        				
        				if((count($playersData[1]) == 1) and ($playersData[1][0]['Login Name'] == $data['searchString']))
        				{
        					$playerId = $playersData[1][0]['Player Id'];
						$csrfrontendids = explode(",", $csrfrontendids);
        				}
        				else
        				{
        					$this->view->paginator = $playersData[0];
        					$this->view->searchField = $data['searchField'];
        					$this->view->searchStr = $data['searchString'];
        					$this->view->accountType = $data["accountType"];
        					$this->view->contents = $playersData[1];
        				}
        				break;
        			case 'email':
        				$csrfrontendids = implode(",", $csrfrontendids);
        				$offset = 1;
        				
        					$playersData = $player->getAllPlayers($data['searchField'], 0, $offset, $data['items'], $session, $data['searchString'], $csrfrontendids,$data["accountType"]);
        				
        				$this->view->paginator = $playersData[0];
			        	$this->view->searchField = $data['searchField'];
			        	$this->view->searchStr = $data['searchString'];
			        	$this->view->contents = $playersData[1];
			        	$this->view->accountType = $data["accountType"];
        				//$playerId = $player->getAccountIdFromEmail($data['searchString']);
        				break;
        			case 'first_name':
        				$offset = 1;
        				$playersData = $player->getPlayersByFirstName($data['searchString'], $data["accountType"],$offset, $data['items'], $csrfrontendids);
        				$this->view->paginator = $playersData[0];
        				$this->view->searchField = $data['searchField'];
        				$this->view->searchStr = $data['searchString'];
        				$this->view->contents = $playersData[1];
        				$this->view->accountType = $data["accountType"];
        		}
        		if($playerId)
        		{
        			$player = new Player();
					$playerfrontendid = $player->getfrontendidofplayer($playerId,$data["accountType"]);
					
					if (in_array($playerfrontendid,$csrfrontendids))
 					{
 						$this->_redirect('/player/view/playerId/'.$playerId.'/accountType/'.$data["accountType"]);
 					}
 					else 
 					{
        				$this->_helper->FlashMessenger(array('error' => "Player not found or You are not authorised to view/edit this player's details"));
 					}
        		}

        		/*$start = $_REQUEST["start"]?$_REQUEST["start"]:0;
        		
        		$offset = $start/$data['items'] + 1 ;
        		
        		$fromTime = $data['start_date'] . ' ' . $data['from_time'];
				$from_date = date ("Y-m-d H:i:s", strtotime("$fromTime, - 5 HOUR 30 MINUTE"));

				$toTime = $data['end_date'] . ' ' . $data['to_time'];
				$to_date = date ("Y-m-d H:i:s", strtotime("$toTime, - 5 HOUR 30 MINUTE"));
        		
        		if($data['searchField'] == 'registration')
        		{
        			$playersData = $player->getAllRegistrations($offset, $data['items'], $session, $from_date, $to_date);
        		}
				elseif($data['searchField'] == 'depositor')
				{
					$playersData = $player->getAllDepositors($offset, $data['items'], $session, $from_date, $to_date);
				}
        		else
        		{
	        		try
	        		{
	        			if($data["accountType"] == "unconfirmed")
	        			$playersData = $player->getUnconfirmPlayers($data['searchField'], $data['match'], $offset, $data['items'], $session, $data['searchString']);
	        			else
	        			$playersData = $player->getAllPlayers($data['searchField'], $data['match'], $offset, $data['items'], $session, $data['searchString']);
	        		}
	        		catch(Exception $e)
	        		{
	        			$playersData = null;
	        		}
        		}       		
        		
        		if(!$playersData)
        		{
        			echo "No record found";
        			//$this->view->success = 'false';
        			//$this->_redirect($language . '/error/error');
        		}
        		
        		else
        		{  
			        foreach($playersData[1] as $key=>$value)
			        {
			        	$playersData[1][$key]["Player Id"] = $playersData[1][$key]["Player Id"];
			        	$playersData[1][$key]["User Name"] = $playersData[1][$key]["User Name"]; 
						$playersData[1][$key]["Email"] = $playersData[1][$key]["Email"];
						$playersData[1][$key]["Type"] = $data["accountType"];
			        }
      
			    
		       //$this->view->success = 'true';
		       $this->view->searchField = $data['searchField'];
		       $this->view->match = $data['match'];
		       $this->view->searchStr = $data['searchString'];
		       $this->view->paginator = $playersData[0];
		       $this->view->accountType = $data["accountType"];
		       $this->view->from = $from_date;
		       $this->view->to = $to_date;


		        $this->view->contents = $playersData[1];
	        		
	        	}*/
        	}
        	/*
        	else
        	{
        		Zend_Layout::getMvcInstance()->disableLayout();
        		print_r($_POST);
        		print_r($form->getMessages());
        		echo "Error in submitting form data"; 
        	}
        	*/
        }
		elseif($offset)
        {
        	$csrfrontendids = implode(",", $csrfrontendids);
        	$itemsPerPage = $this->getRequest()->item;
        	$searchField = $this->getRequest()->field;
        	$accountType = $this->getRequest()->accountType;
        	$searchString = $this->getRequest()->str;
        	
        	if($searchField == 'first_name')
        	{
        		$playersData = $player->getPlayersByFirstName($searchString,$accountType, $offset, $itemsPerPage,$csrfrontendids);
        	}
        	else
        	{
        		$playersData = $player->getAllPlayers($searchField, 0, $offset, $itemsPerPage, $session, $searchString, $csrfrontendids,$accountType);
        	}
        	if(!$playersData)
        	{
        		$this->_redirect($language . '/error/error');
        	}

        	$this->view->paginator = $playersData[0];
        	$this->view->searchField = $searchField;
        	$this->view->searchStr = $searchString;
        	$this->view->contents = $playersData[1];
        	$this->view->accountType = $accountType;
        }
        /*$headings = array();
		if($playersData[1])
        {
        	$i = 0;
        	foreach($playersData[1] as $data)
        	{
        		foreach($data as $key => $value)
        		{
        			if($i == 0)
        			{
        				$headings[] = $key;
        			}
        		}
        		$i++;
        	}
        	$this->view->playerData = $playersData[1];
        }
        $this->view->headings = $headings;*/
	}
	public function editAction()
	{
		$language = $this->getRequest()->getParam('lang');
		$playerId = $this->getRequest()->id;
		//Zenfox_Debug::dump($playerId,'playerId',true,true);
		$form = new Player_RegistrationForm();
		$player = new Player();
		//Called getPlayerData method of Player model to get complete player details.
		$playerData = $player->getPlayerData($playerId);
		
		if(!$playerData)
		{
			$this->_redirect($language . '/error/error');
		}
		$this->view->form = $form->editForm($playerData);
		$this->view->submitButton = $form->submitButton();
		//Zenfox_Debug::dump($_POST,'post data',true,true);
		if($this->getRequest()->isPost())
		{
			if($form->isValid($_POST))
			{//Zenfox_Debug::dump($_POST,'post data',true,true);
				$data = $form->getValues();
				$editUser = new Player();
				//Called editPrfile method of Player model
				if($editUser->editProfile($data, $playerId))
				{
					//$form = new Player_RegistrationForm();
					$this->view->form = '';
					$this->view->submitButton = '';
					$this->view->successMessage = "Player profile has been updated successfully.";
					$this->_helper->FlashMessenger(array('notice' => $this->view->translate("Player profile has been updated successfully.")));
				}
				else
				{
					$this->_redirect($language . '/error/error');
				}
			}
		}
	}
}
