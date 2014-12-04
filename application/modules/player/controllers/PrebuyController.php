<?php
require_once dirname(__FILE__) . '/../forms/PrebuyForm.php';
class Player_PrebuyController extends Zenfox_Controller_Action
{
	
	public function init()
	{
		//echo $_SERVER['HTTP_REFERER'];
		//exit();
		//Zend_Layout::getMvcInstance()->disableLayout();
		parent::init();
		$contextSwitch = $this->_helper->getHelper('contextSwitch');
		$contextSwitch->addActionContext('prebaughtplayers', 'json')
		              		->initContext();
	}
	
	public function indexAction()
	{
		$roomId = $this->getRequest()->roomId;
		
		$form = new Player_PrebuyForm();
		$form->setroomId($roomId);
		
		$this->view->form = $form->getform();
		
		if($this->getRequest()->isPost())
		{
			if($form->isValid($_POST))
			{
				$session = new Zenfox_Auth_Storage_Session();
				$sessionData = $session->read();
				$playerId = $sessionData['id'];
		
				$postvalues = $form->getValues();
				
				//Zenfox_Debug::dump($postvalues,"postvalues",true,true);
				$bingoprebuyobj = new BingoPrebuy();
				$result = $bingoprebuyobj->insertprebuydata($playerId,$postvalues);
				$this->_redirect( "/prebuy/view"); 
			}
		}
		
	}
	
	public function viewAction()
	{
		$session = new Zenfox_Auth_Storage_Session();
		$sessionData = $session->read();
		$playerId = $sessionData['id'];
		
		$prebuyId = $this->getRequest()->prebuyId;
		$bingoprebuyobj = new BingoPrebuy();
		if($prebuyId)
		{
			$bingoprebuyobj->changestatus($playerId,$prebuyId,"DISABLED");
		}
		
		$data = $bingoprebuyobj->getprebuydata($playerId);
		
		$categoryobj = new BingoCategory();
		$allcategories = $categoryobj->getAllCategories();
		
		$length = count($allcategories);
		while($length>0)
		{
			$length--;
			$category[$allcategories[$length]["id"]] = $allcategories[$length]["name"];
		}
		
		$count = count($data);
		while($count > 0)
		{
			$count--;
			$prebuys[$count]["Category Name"] = $category[$data[$count]["category_id"]];
			$prebuys[$count]["Total Games"] = $data[$count]["total_games"];
			$prebuys[$count]["Remaining Games"] = $data[$count]["remaining_games"];
			$prebuys[$count]["Created"] = $data[$count]["created"];
			$prebuys[$count]["Change Status"] = ' <form action="/prebuy/view/prebuyId/' . $data[$count]["prebuy_id"] . '" method = "POST"><input type="submit" name="status" value="Disable Prebuy"></form>';
			
		}
		
		$this->view->data = $prebuys;
	}
	
	public function prebaughtplayersAction()
	{
		$sfsRoomId = $this->getRequest()->sfsRoomId;
		
		if($sfsRoomId)
		{
			$runningroomobj = new BingoRunningRoom();
			$playerslist = $runningroomobj->getprebaughtplayersfromsfsroomId($sfsRoomId);
			
			$accountobj = new Account();
			
			$length = count($playerslist);
			$index = 0;
			
			while($index < $length)
			{
				$details = $accountobj->getdetails($playerslist[$index]);
				
				$data["userlist"][$index] = $details["login"];
				
				$index++;
			}
			
			$this->view->success = "true";
			$this->view->data = $data;
		}
		
	}
	
}