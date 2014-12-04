<?php
class Player_BingoController extends Zenfox_Controller_Action
{
	public function init()
	{
		parent::init();

        $contextSwitch = $this->_helper->getHelper('contextSwitch');
		$contextSwitch->addActionContext('recentwinners', 'json')
						->addActionContext('prebuy', 'json')
						->initContext();
	}
	public function indexAction()
	{
		Zend_Layout::getMvcInstance()->setLayout('popup_layout');
		$session = new Zenfox_Auth_Storage_Session();
		$sessionData = $session->read();
		$playerId = $sessionData['id'];
		
		$loginName = $sessionData['authDetails'][0]['login'];
		$password = $sessionData['authDetails'][0]['password'];
		
		$imageName = md5("image" . $playerId) . '.jpg';
		$imagePath = APPLICATION_PATH . "/../public/images/profiles/" . $imageName;
		if(!file_exists($imagePath))
		{
			$imagePath = "/images/" . $this->imagesDir . "/profiles/profile-m1.jpg";
		}
		else
		{
			$imagePath = "/images/profiles/" . $imageName;
		}

		$gameType = $this->getRequest()->gameType;
		$gameId = $this->getRequest()->gameId;
		$gameConfig = 'config_bingo';
		$swfPath = "/games/bingocrush/multi-player/bingo/game.swf";
		switch(trim($gameType))
		{
			case '75':
				$gameConfig = 'config_bingo75';
				$swfPath = "/games/bingocrush/multi-player/bingo75/game.swf";
				break;
				
		}
		
		$this->view->loginName = $loginName.'|' . $gameId . '|' . trim($gameType);
		$this->view->password = md5(-1 . md5(Zend_Session::getId()));
		$this->view->imagePath = $imagePath;
		$this->view->playerId = $playerId;
		$this->view->sessionId = $this->getRequest()->sessionId;
		$this->view->currency = $this->getRequest()->currency;
		$this->view->amountType = $this->getRequest()->amountType;
		$this->view->gameConfig = $gameConfig;
		$this->view->gameId = $gameId;
		$this->view->flavour = $this->getRequest()->flavour;
		$this->view->swfPath = $swfPath;
	}
	
	public function bingoAction()
	{
		$session = new Zenfox_Auth_Storage_Session();
		$sessionData = $session->read();
		$playerId = $sessionData['id'];
		
		$loginName = $sessionData['authDetails'][0]['login'];
		$password = $sessionData['authDetails'][0]['password'];
		
		$imageName = md5("image" . $playerId) . '.jpg';
		$imagePath = APPLICATION_PATH . "/../public/images/profiles/" . $imageName;
		if(!file_exists($imagePath))
		{
			$imagePath = "/images/" . $this->imagesDir . "../profiles/profile-m1.jpg";
		}
		else
		{
			$imagePath = "/images/profiles/" . $imageName;
		}
		
		$this->view->loginName = $loginName.'|1|RU_US';
		$this->view->password = md5(-1 . md5(Zend_Session::getId()));
		$this->view->imagePath = $imagePath;
	}
	
	public function prebuyAction()
	{
		
		$playerId = $this->getRequest()->playerId;
		$sfsroomId = $this->getRequest()->roomId;
		$cards = $this->getRequest()->cards;
		
		
		$runningroomsobj = new BingoRunningRoom();
		$roomId = $runningroomsobj->getroomIdfromsfsroomId($sfsroomId);


		$bingoCategory = new BingoCategory();
		$bingoCategory->getAllCategories();
		
		$bingoprebuyobj = new BingoPrebuy();
		$result = $bingoprebuyobj->addprebuycards($playerId,$roomId,$cards);
		
		if($result)
		{
			$this->view->result = "true";
		}
		else
		{
			$this->view->result = "false";
		}
		
	}
	
	public function recentwinnersAction()
	{
		$sfsroomId = $this->getRequest()->sfsRoomId;
		
		$runningroomsobj = new BingoRunningRoom();
		$roomId = $runningroomsobj->getroomIdfromsfsroomId($sfsroomId);
		
		$this->view->winners = "";
		if($roomId)
		{
			$bingorecentwinnersobj = new BingoRecentWinners();
			$recentwinners = $bingorecentwinnersobj->getbingorecentwinnerslist($roomId);
			//Zenfox_Debug::dump($recentwinners);
			$this->view->winners = $recentwinners;
		}
		
	}
	
	public function gamelogAction()
	{
		$session = new Zenfox_Auth_Storage_Session();
		$storedData = $session->read();
		
		$playerId = $storedData['id'];
		$bingoGamelogPlayer = new BingoGamelogPlayer();
		
		$offset = $this->getRequest()->pages;
		
		$fromPM = false;
		$toPM = false;
		
		if($this->getRequest()->isPost())
		{
			$data = $_POST;
		
			if($data['p_from_time'] == 'pm' && $data['h_from_time'] != 12)
			{
				$data['h_from_time'] = $data['h_from_time'] + 12;
			}
			if($data['p_from_time'] == 'am' && $data['h_from_time'] == 12)
			{
				$data['h_from_time'] = '00';
			}
			if($data['p_to_time'] == 'pm' && $data['h_to_time'] != 12)
			{
				$data['h_to_time'] = $data['h_to_time'] + 12;
			}
			if($data['p_to_time'] == 'am' && $data['h_to_time'] == 12)
			{
				$data['h_to_time'] = '00';
			}
				
			if($data['p_from_time'] == 'pm')
			{
				$fromPM = true;
			}
			if($data['p_to_time'] == 'pm')
			{
				$toPM = true;
			}
		
			$fromDate = $data['from_date'] . " " . $data['h_from_time'] . ":" . $data['m_from_time'];
			$toDate = $data['to_date'] . " " . $data['h_to_time'] . ":" . $data['m_to_time'];
				
			$offset = 1;
			
			$result = $bingoGamelogPlayer->getBingoLogs($playerId, $data['page'], $offset, $fromDate, $toDate);
			if(!$result)
			{
				$this->_helper->FlashMessenger(array('error' => 'No keno record found.'));
			}
			$this->view->paginator = $result['paginator'];
			$this->view->contents = $result['gamelogs'];
			$this->view->fromDate = $fromDate;
			$this->view->toDate = $toDate;
			$this->view->playerId = $playerId;
				
			$this->view->from = $data['from_date'];
			$this->view->to = $data['to_date'];
			$this->view->fromHour = $data['h_from_time'];
			$this->fromMinute = $data['m_from_time'];
			$this->view->toHour = $data['h_to_time'];
			$this->view->toMinute = $data['m_to_time'];
			$this->view->fromPM = $fromPM;
			$this->view->toPM = $toPM;
			$this->view->items = $data['page'];
		}
		elseif($offset)
		{
			$itemsPerPage = $this->getRequest()->item;
			$from = $this->getRequest()->from;
			$to = $this->getRequest()->to;
				
			$explodeFromTime = explode(" ", $from);
			$fromDate = $explodeFromTime[0];
			$explodeTime = explode(":", $explodeFromTime[1]);
			$fromHour = $explodeTime[0];
			$fromMinute = $explodeTime[1];
			if($fromHour >= 12)
			{
				$fromPM = true;
			}
		
			$explodeToTime = explode(" ", $to);
			$toDate = $explodeToTime[0];
			$explodeTime = explode(":", $explodeToTime[1]);
			$toHour = $explodeTime[0];
			$toMinute = $explodeTime[1];
			if($toHour >= 12)
			{
				$toPM = true;
			}
				
			$result = $bingoGamelogPlayer->getBingoLogs($playerId, $itemsPerPage, $offset, $fromDate, $toDate);
			if(!$result)
			{
				$this->_helper->FlashMessenger(array('error' => 'No keno record found.'));
			}
			$this->view->paginator = $result['paginator'];
			$this->view->contents = $result['gamelogs'];
			$this->view->fromDate = $from;
			$this->view->toDate = $to;
			$this->view->playerId = $player_id;
				
			$this->view->from = $fromDate;
			$this->view->to = $toDate;
			$this->view->fromHour = $fromHour;
			$this->fromMinute = $fromMinute;
			$this->view->toHour = $toHour;
			$this->view->toMinute = $toMinute;
			$this->view->fromPM = $fromPM;
			$this->view->toPM = $toPM;
			$this->view->items = $itemsPerPage;
		}
	}
	
	public function showlogAction()
	{
		$authSession = new Zenfox_Auth_Storage_Session();
		$sessionData = $authSession->read();
		$playerId = $sessionData['id'];
		$gamelogId = $this->getRequest()->logId;
		
		$bingoGamelog = new BingoGamelog();
		$bingoGamelog->getGamelogById($gamelogId, $playerId);
	}
}
