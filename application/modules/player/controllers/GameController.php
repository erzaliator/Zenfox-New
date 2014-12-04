<?php
class Player_GameController extends Zenfox_Controller_Action
{
	public function init()
	{
		//echo $_SERVER['HTTP_REFERER'];
		//exit();
		//Zend_Layout::getMvcInstance()->disableLayout();
		parent::init();
		$contextSwitch = $this->_helper->getHelper('contextSwitch');
		$contextSwitch->addActionContext('view', 'json')
					->addActionContext('getsfslogin', 'json')
					->addActionContext('index', 'json')
					->addActionContext('game', 'json')
					->addActionContext('allgame', 'json')
					->addActionContext('opponentslist', 'json')
              		->initContext();
	}
	public function indexAction()
	{
		$frontendName = Zend_Registry::getInstance()->get('frontendName');
                if($frontendName == 'ace2jak.com')
                {
                        Zend_Layout::getMvcInstance()->setLayout('popup_layout');
                }
		$appRequest = $this->getRequest()->appPage;
		if($appRequest)
		{
			$this->view->openPopup = "false";
			$platform = $this->getRequest()->getParam('platform');
			$this->view->platform = $platform;
			//Zend_Layout::getMvcInstance()->disableLayout();
			Zend_Layout::getMvcInstance()->setLayout('layout_app');
		}
		//print($this->getRequest()->name);
		$frontendId = Zend_Registry::getInstance()->get('frontendId');
		$this->view->frontendId = $frontendId;
		$session = new Zend_Auth_Storage_Session();
		$store = $session->read();
		//$playerId = $store['id'];
		$playerId = $store['id']?$store['id']:-1;
		/*
		 * Getting all the groups by passsing frontendId to GamegroupFrontend
		 */
		$gamegroupFrontend = new GamegroupFrontend();
		$groupsDetails = $gamegroupFrontend->getAllGroups($frontendId,$playerId);
		//unset($groupsDetails);
		if(!$groupsDetails)
		{
			//throw new Zend_Exception('No Game');
			//$this->_helper->FlashMessenger(array('error' => $this->view->translate("No game groups listed!")));
		}
		elseif($groupsDetails)
		{
			foreach($groupsDetails as $key => $value)
			{
				$group['id'] = $key;
				if($value)
				{
					foreach($value as $k => $v)
						$group['name'] = $k;
				}
				$groups[] = $group;
			}
			$this->view->groups = $groups;
		}
		
		$flavour = new Flavour();
		$gameFlavours = $flavour->getGameFlavours();
		if(!$gameFlavours)
		{
			//throw new Zend_Exception('No Flavour');
			//$this->_helper->FlashMessenger(array('error' => $this->view->translate("No game flavours listed!")));
		}
		else
		{
			$this->view->gameFlavours = $gameFlavours;
		}
		
		$gameGamegroup = new GameGamegroup();
		if(isset($groups))
		{
			foreach($groups as $group)
			{
				$allGameDetails[$group['id']] = $gameGamegroup->getGameDetails($group['id'], $group['name']);
			}
		}
		//Zenfox_Debug::dump($allGameDetails, 'details', true, true);
		if(!isset($allGameDetails))
		{
			//throw new Zend_Exception('No Game Details');
			//$this->_helper->FlashMessenger(array('error' => $this->view->translate("No games listed!")));
		}
		else
		{
			$type = $this->getRequest()->type;
			switch($type)
			{
				case 'slots':
					$this->view->defaultTab = 0;
					break;
				case 'roulette':
					$this->view->defaultTab = 1;
					break;
				case 'keno':
					$this->view->defaultTab = 2;
					break;
				default:
					$this->view->defaultTab = 0;
			}
			//Zend_Layout::getMvcInstance()->disableLayout();
			Zend_Layout::getMvcInstance()->setLayout('layout');
			$this->view->allGameDetails = $allGameDetails;

			
		}
		if($frontendName == 'bingocrush.co.uk' || $frontendName == 'bingobible.co.uk')
		{
			$bingoRunningRoom = new BingoRunningRoom();
			$allRunningRooms = $bingoRunningRoom->getAllRunningRooms();
			$this->view->allRunningRooms = $allRunningRooms;
		}
		
			$this->view->playerId = $playerId;
		$webConfig = Zend_Registry::get('webConfig');
		$flashDir = isset($webConfig['flashDir'])?$webConfig['flashDir']:"taashtime.tld/";
		$imagesDir = isset($webConfig['imagesDir'])?$webConfig['imagesDir']:"rummy.tld/";
		$hostName = $_SERVER['HTTP_HOST'];
		$hostAddress = 'http://' . $hostName;
		$this->view->hostAddress = $hostAddress;
		$this->view->flashDir = $flashDir;
		$tournament = $this->getRequest()->tournament;
		if(isset($tournament))
		{
			$this->view->tabName = 'TOURNAMENT';
		}
		if($store)
		{
			$currency = new Zend_Currency();
			$imageName = md5("image" . $playerId) . '.jpg';
			$loginName = $store['authDetails'][0]['login'];
			$firstName = $store['authDetails'][0]['first_name'];
			//$cash = $store['authDetails'][0]['cash'];
			//$bonus = $store['authDetails'][0]['bonus_bank'] + $store['authDetails'][0]['bonus_winnings'];
			$cash = $store['authDetails'][0]['bank'] + $store['authDetails'][0]['winnings'] + $store['authDetails'][0]['bonus_bank'] + $store['authDetails'][0]['bonus_winnings'];
			$bonus = 0;
			if($store['authDetails'][0]['noof_deposits'])
			{
				$bonus = $store['authDetails'][0]['bonus_due'];
			}
			$loyaltyPoints = $store['authDetails'][0]['loyalty_points_left'];
			$currencySession = new Zend_Session_Namespace('currency');
			if(!$currencySession->oldValue)
			{
				$currencySession->oldValue = 'en_IN';
				$currencySession->newValue = 'en_IN';
			}
			$source = $currency->getShortName('', $currencySession->oldValue);
			$destination = $currency->getShortName('', $currencySession->newValue);
			$currConv = new CurrencyConversion();
			$cash = $currConv->getConvertedValue($source, $destination, $cash);
			$bonus = $currConv->getConvertedValue($source, $destination, $bonus);
			$imagePath = APPLICATION_PATH . "/../public/images/profiles/" . $imageName;
	       	if(!file_exists($imagePath))
	       	{
	       		$imagePath = "/images/profiles/profile-m1.jpg";
	       	}
	       	else
	       	{
	         	$imagePath = "/images/profiles/" . $imageName;
	       	}
		if($appRequest)
		{
			$imagePath = $this->getRequest()->imagePath;
		}
	       	$name = empty($firstName)?$loginName:$firstName;
			
			if(is_numeric($name))
			{
				$name = "Player-".$name;
			}
			
			$userDetails = Zend_Json::encode($store['authDetails'][0]);
			$freeChips = 0;
			$accountVariable = new AccountVariable();
			//$varData = $accountVariable->getData($playerId, 'freeMoney','-4');
			$varData = $accountVariable->getData($playerId, 'freeMoney');
			if($varData)
			{
				$freeChips = floatval($varData['varValue']);
			} 
			$this->view->userDetails = $userDetails;
			$this->view->playerId = $playerId;
			$this->view->cash = $cash;
			$this->view->bonus = $bonus;
			$this->view->loyaltyPoints = $loyaltyPoints;
			$this->view->imagePath = $imagePath;
			$this->view->name = $name;
			$this->view->freeChips = $freeChips;
			$this->view->login = $loginName;
			//$this->view->phpsessid = Zend_Session::getId();
			$phpSessId = Zend_Session::getId();
			$passKey = md5(-1 . md5($phpSessId));
			$this->view->passKey = $passKey;
		}
		else
		{
			$userDetails = Zend_Json::encode('null');
		}
		//exit();
		//print_r($allGameDetails);
		
	}
	
	public function gameAction()
	{
		$this->view->allGameDetails = true;
		Zend_Layout::getMvcInstance()->setLayout('popup_layout');
		$trackerId = isset($_COOKIE['trackerId'])?$_COOKIE['trackerId']:null;
		$this->view->trackerId = $trackerId;
		$this->view->tournament = $this->getRequest()->tournament ? $this->getRequest()->tournament : 'false';
		
		//$frontendId = Zend_Registry::getInstance()->get('frontendId');
		/* $frontend = new Frontend();
		$frontendData = $frontend->getFrontendById($frontendId);
		$this->view->currency = $frontendData[0]['default_currency']; */


		$webConfig = Zend_Registry::get('webConfig');		
		$flashDir = isset($webConfig['flashDir'])?$webConfig['flashDir']:"taashtime.tld/";

		$this->view->flashDir = $flashDir;
		$request = $this->getRequest();
		$machineId = $request->machineId;
		$flavour = $request->flavour;
		$amountType = $request->amountType;
		$gameName = $request->gameName;
		if($request->tabbed == "TRUE")
		{
			$tabbedGame = $request->tabbed;
		}
		$this->view->seatIndex = $request->seat;
		$storage = new Zend_Auth_Storage_Session();
		$session = $storage->read();
		$loginName = $session['authDetails'][0]['login'];
		if($gameName != 'bingo')
		{
			$flavourInstance = new Flavour();
			$runningTableName = $flavourInstance->getTableName($flavour);
			//Zenfox_Debug::dump($runningTableName, 'table', true, true);
			if(!$runningTableName)
			{
				//$this->_helper->FlashMessenger(array('error' => $this->view->translate("Problem in loading game.")));
			}
			switch($runningTableName)
			{
				case 'online_tables':
					$runningMachineInstance = new OnlineTable();
					$machineInstance = new TableConfig();
					break;
				case 'running_keno':
					$runningMachineInstance = new RunningKeno();
					$machineInstance = new Keno();
					break;
				case 'running_roulette':
					$runningMachineInstance = new RunningRoulette();
					$machineInstance = new Roulette();
					break;
				case 'running_slots':
					$runningMachineInstance = new RunningSlot();
					$machineInstance = new Slot();
					break;
			}
	//		print('machineId - ' . $machineId);
	//		exit();
			if($runningMachineInstance)
			{
				$machineData = $runningMachineInstance->getMachineData($machineId, $flavour);
			}
			if(!$machineData)
			{
				//$this->_helper->FlashMessenger(array('error' => $this->view->translate("Problem in loading game.")));
			}
			$this->view->machineName = $machineData['machineName'];
			$mainMachineId = $machineData['machineId'];
			$currency = $session['authDetails'][0]['base_currency'];
			$userDetails = Zend_Json::encode($session['authDetails'][0]);
			if($machineInstance)
			{
				$fileData = $machineInstance->getFilesPathFromId($mainMachineId);
			}
			//Zenfox_Debug::dump($fileData, 'data', true, true);
			/*$mainMachineData = $machineInstance->getSwfFileFromId($mainMachineId);
			$swfFile = $mainMachineData['swfFile'];
			$amountType = $mainMachineData['amountType'];*/
			if(!$fileData)
			{
				//$this->_helper->FlashMessenger(array('error' => $this->view->translate("Problem in loading game.")));
			}
	
			$this->view->machineId = $machineId;
			$this->view->flavour = $flavour;
			$this->view->amountType = $amountType;
			$this->view->login = $loginName;
			$this->view->currency = $currency;
			$this->view->userDetails = $userDetails;
			//TODO check the locale, change the file name
			$locale = Zend_Registry::get('Zend_Locale');
			//$swfFile = $fileData['swfFile'].'game.swf';
			$swfFile = $fileData['swfFile'].'game.swf';
			$file = $_SERVER['DOCUMENT_ROOT'] . $fileData['swfFile'] . 'game_' . $locale . '.swf'; 
			if(file_exists($file))
			{
				$swfFile = $file;
			}
			$this->view->swfFile = $swfFile;
			$this->view->configFile = $fileData['swfFile'].'config.txt';
			$this->view->guideConfig = $fileData['swfFile'].'guide_config.txt';
			$this->view->phpsessid = Zend_Session::getId();
			$this->view->tabbed = isset($tabbedGame)?true:false;
//Yaswanth
		//	$playerId = $store['id'];
			$this->view->tabLoginName = $session['authDetails'][0]['login'];

			$this->view->tabCash = $session['authDetails'][0]['cash'];
			$this->view->tabBonus = $session['authDetails'][0]['bonus_bank'] + $session['authDetails'][0]['bonus_winnings'];

		}
		elseif($session)
		{
			$this->view->machineId = $machineId;
			$this->view->flavour = $flavour;
			$this->view->amountType = $amountType;
			$this->view->login = $loginName;
			$this->view->playerId = $session['id'];
			$this->view->phpsessid = Zend_Session::getId();
			$this->view->gameName = 'bingo';
		}
		else
		{
			$this->view->tabbed = isset($tabbedGame)?true:false;
			$this->view->tabLoginName = "guest";
			$this->view->login = 'guest';
			$this->view->phpsessid = Zend_Session::getId();
			$this->view->machineId = $machineId;
                        $this->view->flavour = $flavour;
                        $this->view->amountType = $amountType;
		}

//		print('swf - ' . $swfFile);
//		echo '<br>';
//		print('machineId - ' . $machineId);
//		echo '<br>';
//		print('flavour - ' . $flavour);
//		echo '<br>';
//		print('amountType - ' . $amountType);
//		exit();
	}
	public function jsonAction()
	{
		Zend_Layout::getMvcInstance()->disableLayout();
		$frontendId = Zend_Registry::getInstance()->get('frontendId');
		$session = new Zend_Auth_Storage_Session();
		$store = $session->read();
	//	$playerId = $store['id'];
		$loginName = $store['authDetails'][0]['login'];
		$currency = $store['authDetails'][0]['base_currency'];
		$currency = $currency?$currency:"USD";
		$locale = Zend_Registry::get('Zend_Locale');
		$gamegroupFrontend = new GamegroupFrontend();
		$groupsDetails = $gamegroupFrontend->getAllGroups($frontendId,-1);
		foreach($groupsDetails as $key => $value)
		{
			$group['id'] = $key;
			if($value)
			{
				foreach($value as $k => $v)
					$group['name'] = $k;
			}
			$groups[] = $group;
		}
		$gameGamegroup = new GameGamegroup();
		foreach($groups as $group)
		{
			$allGameDetails[$group['id']] = $gameGamegroup->getGameDetails($group['id'], $group['name']);
		}
		$data = array();
		$i = 0;
		$flavourInstance = new Flavour();
		$siteHttpUrl = "http://". $_SERVER['HTTP_HOST'];
		$phpsessid = Zend_Session::getId();
		foreach($allGameDetails as $gameDetails)
		{
			foreach($gameDetails as $games)
			{
				foreach($games as $game)
				{
					$runningTableName = $flavourInstance->getTableName($game['gameFlavour']);
					if($runningTableName == 'running_keno')
					{
						$machineInstance = new Keno();
					}
					elseif($runningTableName == 'running_roulette')
					{
						$machineInstance = new Roulette();
					}
					elseif($runningTableName == 'running_slots')
					{
						$machineInstance = new Slot();
					}
					$swfFile = $machineInstance->getSwfFileFromId($game['machineId']);
					$data[$i]['game_id'] = $game['machineId'];
					$data[$i]['game_flavour'] = $game['gameFlavour'];
					$data[$i]['amount_type'] = $game['amountType'];
					$data[$i]['currency'] = $currency;
					$data[$i]['frontend_id'] = $frontendId;
					$data[$i]['locale'] = "$locale";
					$data[$i]['login'] = $loginName . '|' . $game['machineId'] . '|' . $game['gameFlavour'];
					$data[$i]['game_swf_path'] = $siteHttpUrl . "/games/single-player/" . $game['gameFlavour'] . "/" . $swfFile;
					$data[$i]['image_url'] = $siteHttpUrl . "/images/thumbnails/swfs/". $game['gameFlavour']."_".$game['runningMachineId'].".swf";
					$data[$i]['game_name'] = $game['machineName'];
					$data[$i]['game_config'] = $siteHttpUrl . "/games/single-player/" . $game['gameFlavour'] . "/" . $game['gameFlavour'] . "_" . $game['machineId'] . ".txt";
					$data[$i]['pass_key'] = md5($game['machineId'] . md5($phpsessid));
					$i++;
				}
			}
		}
		$json = json_encode($data);
		echo $json;
	}
	
	public function getsfsloginAction()
	{
		//Zend_Layout::getMvcInstance()->disableLayout();
		
		if($this->getRequest()->isPost())
		{
			$userName = $_POST['username'];
			$tableId = $_POST['tableId'];
			$flavour = $_POST['flavour'];
		}
		else
		{
			$userName = $_GET['username'];
			$tableId = $_GET['tableId'];
			$flavour = $_GET['flavour'];
		}
	
		$data['userName'] = $userName;
		$data['tableId'] = $tableId;
		$data['flavour'] = $flavour;
		
		$authSession = new Zend_Auth_Storage_Session();
		$storedData = $authSession->read();
		//$this->view->data = $storedData;
		//$this->view->get = $_GET;
		
		if(($storedData) && ($storedData['authDetails'][0]['login'] == $userName))
		{
			$data['success'] = true;
			if(!$tableId)
			{
				$playerId = $storedData['id'];
				//$cash = $storedData['authDetails'][0]['cash'];
				//$bonus = $storedData['authDetails'][0]['bonus_bank'] + $storedData['authDetails'][0]['bonus_winnings'];
				$cash = $storedData['authDetails'][0]['cash'] + $storedData['authDetails'][0]['bonus_bank'] + $storedData['authDetails'][0]['bonus_winnings'];
				$bonus = 0;
				if($store['authDetails'][0]['noof_deposits'])
				{
					$bonus = $store['authDetails'][0]['bonus_due'];
				}
				$accountVariable = new AccountVariable();
				//$varData = $accountVariable->getData($playerId, 'freeMoney', '-4');
				$varData = $accountVariable->getData($playerId, 'freeMoney');
				if($varData)
				{
					$freeChips = floatval($varData['varValue']);
				} 
				$data['balance'] = $cash;
				$data['bonus'] = $bonus;
				$data['free_chips'] = $freeChips;
			}
			else
			{
				$phpsessid = Zend_Session::getId();
				$data['login'] = $userName . '|' . $tableId . '|' . $flavour;
				$data['pass_key'] = md5($tableId . md5($phpsessid));
			}
		}
		else
		{
			$data['success'] = false;
		}
		//$data['login'] = $storedData['authDetails'][0]['login'];
		
		$this->view->loginData = $data;
	}
	
	public function quickjoinAction()
	{
		setcookie("landingPage", "DIRECT_LOGIN", time() + (86400 * 30), "/", '.'.$_SERVER['HTTP_HOST']);
		/*$quickJoin = new QuickJoin();
		$passingParameters = $quickJoin->getFreeTableParameters();
		$flavour = $passingParameters['flavour'];
		$machineId = $passingParameters['machineId'];
		$amountType = $passingParameters['amountType'];
		$this->_redirect('/game/game/flavour/' . $flavour . '/machineId/' . $machineId . '/amountType/' . $amountType);*/

		$tournamentId = $this->getRequest()->tournamentId;
		$gameFlavour = $this->getRequest()->flavour;
		$amountType = isset($this->getRequest()->amount_type)?$this->getRequest()->amount_type:'FREE';
		$quickJoin = new QuickJoin();

		if($tournamentId)
		{
			$machineId = NULL;
			$level = $this->getRequest()->level;
			$passingParameters = $quickJoin->getTournamentRoom($tournamentId, $level);
			if($passingParameters)
			{
				$flavour = $passingParameters['flavour'];
				$machineId = $passingParameters['machineId'];
			}
			if($machineId)
			{
				$this->_redirect('/game/game/flavour/' . $flavour . '/machineId/' . $machineId . '/amountType/' . $amountType);
			}
			else
			{
				$url = '/game/quickjoin/tournamentId/' . $tournamentId;
				if($level)
				{
					$url .= '/level/' . $level;
				}
				$this->_helper->FlashMessenger(array('notice' => 'All rooms are filled. Please <a href="' . $this->view->baseUrl($url) . '">Click Here</a> to try again.'));
			}
		}
		else
		{
			$passingParameters = $quickJoin->getFreeTableParameters($amountType, $gameFlavour);
			$flavour = $passingParameters['flavour'];
			$machineId = $passingParameters['machineId'];
			$this->_redirect('/game/game/flavour/' . $flavour . '/machineId/' . $machineId . '/amountType/' . $amountType);
		}

		//$passingParameters = $quickJoin->getFreeTableParameters($amountType, $gameFlavour)
		//$amountType = $passingParameters['amountType']
	}
	
	public function allgameAction()
	{
		$frontendId = Zend_Registry::getInstance()->get('frontendId');
		$this->view->frontendId = $frontendId;
		$session = new Zend_Auth_Storage_Session();
		$store = $session->read();

		$playerId = $store['id']?$store['id']:-1;
		/*
		 * Getting all the groups by passsing frontendId to GamegroupFrontend
		 */
		$gamegroupFrontend = new GamegroupFrontend();
		$groupsDetails = $gamegroupFrontend->getAllGroups($frontendId,$playerId);
		if(!$groupsDetails)
		{
			//throw new Zend_Exception('No Game');
			$this->_helper->FlashMessenger(array('error' => $this->view->translate("No game groups listed!")));
		}
		elseif($groupsDetails)
		{
			foreach($groupsDetails as $key => $value)
			{
				$group['id'] = $key;
				if($value)
				{
					foreach($value as $k => $v)
						$group['name'] = $k;
				}
				$groups[] = $group;
			}
			$this->view->groups = $groups;
		}
		
		$flavour = new Flavour();
		$gameFlavours = $flavour->getGameFlavours();
		if(!$gameFlavours)
		{
			//throw new Zend_Exception('No Flavour');
			$this->_helper->FlashMessenger(array('error' => $this->view->translate("No game flavours listed!")));
		}
		else
		{
			$this->view->gameFlavours = $gameFlavours;
		}
		
		$gameGamegroup = new GameGamegroup();
		if(isset($groups))
		{
			foreach($groups as $group)
			{
				$allGameDetails[$group['id']] = $gameGamegroup->getGameDetails($group['id'], $group['name']);
			}
		}
		if(!isset($allGameDetails))
		{
			//throw new Zend_Exception('No Game Details');
			$this->_helper->FlashMessenger(array('error' => $this->view->translate("No games listed!")));
		}
		else
		{
			$this->view->allGameDetails = $allGameDetails;
		}
		$session = new Zenfox_Auth_Storage_Session();
		$sessionData = $session->read();
		
		$loginName = $sessionData['authDetails'][0]['login'];
		$password = $sessionData['authDetails'][0]['password'];
		
		$this->view->loginName = $loginName.'|1|RU_US';
		$this->view->password = md5(-1 . md5(Zend_Session::getId()));
		//Zenfox_Debug::dump($allGameDetails, 'all');
	}
	
	public function getgamificationplayerdata($playerId)
	{
		if($playerid%2 == 0)
		{
			$db_host = "192.168.1.15:3308";
		}
		else
		{
			$db_host = "192.168.1.15:3309";
		}
		
		$db_user = "msandbox";
		$db_password = "msandbox";
		$db_name = "gamify";

		$db = MySqlDatabase::getInstance();
		$dbhandle = mysql_connect($db_host, $db_user, $db_password)
 											 or die("Unable to connect to MYSQL");

 		$selected = mysql_select_db($db_name,$dbhandle)
 											 or die("Could not select  DATABASE");
 											 
	}
	
	public function opponentslistAction()
	{
		
		$session = new Zend_Auth_Storage_Session();
		$store = $session->read();
		$playerId = $store['id']?$store['id']:-1;
		
		$listNo = $this->getRequest()->listNo;
		
		$higherLimit = ($listNo*15) -1;
		$lowerLimit = $higherLimit - 14;
		
		$opponentId = $this->getRequest()->opponentId;
		
		$opponentsdetailsobj = new OpponentsDetails();
		
		if($opponentId)
		{
			$opponentdata = $opponentsdetailsobj->getopponentcompletedata($playerId , $opponentId);
			
			if($opponentdata)
			{
				$imageName = md5("image" . $opponentId) . '.jpg';
		
				$imagePath = APPLICATION_PATH . "/../public/images/profiles/" . $imageName;
				if(!file_exists($imagePath))
				{
					$imagePath = $this->cdnImageServer . "/images/profiles/profile-m1.jpg";
				}
				else
				{
					$imagePath = $this->cdnImageServer . "/images/profiles/" . $imageName;
				}
			
			$opponentdata["url"] = $imagePath;
			$opponentdata["taashRating"] = 1400;
			$opponentdata["opponentId"] = $opponentId;
			
				$this->view->success = "true";
				$this->view->data = $opponentdata;
			}
			else
			{
				$data = array();
				$data["message"] = "Database Connection Error";
			
		
				$this->view->success = "false";
				$this->view->data = $data;
			}
			
			
		}
		else
		{
			$allopponentslist = $opponentsdetailsobj->getopponentsminilist($playerId);
			
			if($playerId and $allopponentslist)
			{
				$accountobj = new Account();
		
				$totalopponents = count($allopponentslist);
				$index =0;
		
				while($index < $totalopponents)
				{
					$opponentdetails[$index]["id"] = $allopponentslist[$index]["opponent_id"];
			
					$details = $accountobj->getdetails($allopponentslist[$index]["opponent_id"]);
			
					if($details["first_name"])
					{
						$opponentdetails[$index]["name"] = $details["first_name"];
					}
					else 
					{
						$opponentdetails[$index]["name"] = $details["login"];
					}
			
			
					$imageName = md5("image" . $allopponentslist[$index]["opponent_id"]) . '.jpg';
		
					$imagePath = APPLICATION_PATH . "/../public/images/profiles/" . $imageName;
					if(!file_exists($imagePath))
					{
						$imagePath = $this->cdnImageServer . "/images/profiles/profile-m1.jpg";
					}
					else
					{
						$imagePath = $this->cdnImageServer . "/images/profiles/" . $imageName;
					}
			
					$opponentdetails[$index]["url"] = $imagePath;
			
					$opponentdetails[$index]["gamesplayed"] = $allopponentslist[$index]["games"];
			
					$index++;
				}
		
				$length = count($opponentdetails);
			
				$index = 0;
				$activeopponentslist = array();
				$nonactivefinalopponentslist = array();
				$thirdindex =0;
				$fourthindex =0;
		
				
				//Sorting here in the order of games played most first
				while($index < $length)
				{
				
					$secondindex = $index +1;
				
					while($secondindex < $length)
					{
						if($opponentdetails[$index]["gamesplayed"] < $opponentdetails[$secondindex]["gamesplayed"])
						{
							$temp = $opponentdetails[$index];
							$opponentdetails[$index] = $opponentdetails[$secondindex];
							$opponentdetails[$secondindex] = $temp;
						}
						$secondindex++;
					}
			
			
						$playersessionobj[$index] = new PlayerSession($opponentdetails[$index]["id"]);
						$playersessiondata = $playersessionobj[$index]->getSessionData();
						
						if($playersessiondata)
						{
							if($playerId != $opponentdetails[$index]["id"])
							{
									$activeopponentslist[$thirdindex] = $opponentdetails[$index];
									$thirdindex++;
								
							}
							else
							{
								$playerdetails = $opponentdetails[$index];
							}
						}
						else
						{
									$nonactivefinalopponentslist[$fourthindex] = $opponentdetails[$index];
									$fourthindex++;
						}
				
			
					$index++;
				}
		
				$finalopponentslist = array();
				$result = array();
				$finalopponentslist = array_merge($activeopponentslist,$nonactivefinalopponentslist);
				
				$finallength = count($finalopponentslist);
				$index = 0;
				
				while($lowerLimit <= $higherLimit)
				{
					if($lowerLimit < $finallength)
					{
						$result[$index] = $finalopponentslist[$lowerLimit];
						$index++;
					}
					$lowerLimit++;
					
				}
				
				$data = array();
				$data["me"] = $playerdetails;
				$data["appUsers"] = $result;
				$data["nonAppUsers"] = array();
		
				
				$this->view->success = "true";
				$this->view->data = $data;
			}
			else
			{
				$data = array();
				$data["message"] = "Session Expired OR Database Connection Error";
			
		
				$this->view->success = "false";
				$this->view->data = $data;
				
			}
		
		}
		
	}
	
	public function inviteAction()
	{
		$authSession = new Zenfox_Auth_Storage_Session();
        $sessionData = $authSession->read();
        $senderEmail = $sessionData['authDetails'][0]['email'];
        $senderName = $sessionData['authDetails'][0]['login'];

        $playerId = $this->getRequest()->id;
        //$playerId = 5;
        $player = new Player();
        $playerData = $player->getPlayerData($playerId);

        $receiverEmail = $playerData['email'];
        //$receiverEmail = "nikhil@fortuity.in";
        $message = $senderEmail . " has invited you to join the game";

        $templateName = 'Gameinvitation';
        $category = 'INVITE_GAME';
        $code = NULL;

        $emailTemplate = new EmailTemplate();
        $templateData = $emailTemplate->getTemplateData($templateName, $category);
        $templateData['subject'] = str_replace('$username', $senderName, $templateData['subject']);

        $templateString = 'new Zenfox_Mail_Template_' . $templateName . ';';
        $mailTemplate = '';
        eval("\$mailTemplate = " . $templateString);
        $mailInfo = $mailTemplate->getMailingInfo($code, $templateData['msgBody'], $message, $receiverEmail);
        $mailInfo['textMsgBody'] = str_replace('$username', $senderName, $mailInfo['textMsgBody']);
        $mailInfo['textMsgBody'] = str_replace('$opponentname', $playerData['login'], $mailInfo['textMsgBody']);
        $mailInfo['textMsgBody'] = str_replace('$useremail', $receiverEmail, $mailInfo['textMsgBody']);

        $mailInfo['htmlMsgBody'] = str_replace('$username', $senderName, $mailInfo['htmlMsgBody']);
        $mailInfo['htmlMsgBody'] = str_replace('$opponentname', $playerData['login'], $mailInfo['htmlMsgBody']);
        $mailInfo['htmlMsgBody'] = str_replace('$useremail', $receiverEmail, $mailInfo['htmlMsgBody']);
        //Zenfox_Debug::dump($templateData['subject'], 'subject');
        //Zenfox_Debug::dump($mailInfo, 'mail', true, true);
        //echo $email;
                
        $mail = new Mail();
        $mail->sendMails($templateData['subject'], $mailInfo['textMsgBody'], $mailInfo['htmlMsgBody'], $receiverEmail, '', '');
        //$mail->sendToOne('Invitation', 'INVITE_FRIEND', NULL, $message, $receiverEmail);
        echo "true";
	}
                
}
