<?php 
require_once ('facebook-php-sdk/src/facebook.php');
class Player_FacebookController extends Zenfox_Controller_Action
{
	private $_facebook;
	private $_facebookConfig;
	private $_facebookSession;
	private $_facebookUser;
	private $_facebookUserId;
	private $_appName;
	private $_appId;
	private $_appApiKey;
	private $_appSecret;
	private $_accessToken;
	
	public function init()
	{
		Zend_Layout::getMvcInstance()->disableLayout();
		parent::init();
		
		$contextSwitch = $this->_helper->getHelper('contextSwitch');
		$contextSwitch->addActionContext('facebooklogin', 'json')
					->addActionContext('sorry', 'json')
					->initContext();
		
		$siteCode = Zend_Registry::get('siteCode');
		$facebookFile = APPLICATION_PATH . '/site_configs/' . $siteCode . '/facebook.json';
		$fh = fopen($facebookFile, 'r');
		$facebookKeyJson = fread($fh, filesize($facebookFile));
		fclose($fh);
		$this->_facebookConfig = Zend_Json::decode($facebookKeyJson);
		
		$this->_appName = $this->_facebookConfig['application']['appName'];
		$this->_appId = $this->_facebookConfig['application']['appId'];
		$this->_appApikey = $this->_facebookConfig['application']['apiKey'];
		$this->_appSecret = $this->_facebookConfig['application']['secret'];
		
		$this->_facebook = new Facebook(array(
					  'appId'  => $this->_appId,
					  'secret' => $this->_appSecret,
					  'cookie' => true,
					));
					
		//$this->_facebookSession = $this->_facebook->getSession();
		$this->_facebookUserId = $this->_facebook->getUser();
		$this->_accessToken = $this->_facebook->getAccessToken();
		
		
		
		$this->_facebookUser = null;
		// Session based API call.
		/* if ($this->_facebookSession) 
		{
			$facebookAuthSession = new Zend_Session_Namespace('facebookAuthSession');
			$facebookAuthSession->value = $this->_facebookSession;
			try 
			{
			    //$this->_facebookUserId = $this->_facebook->getUser();
			    $this->_facebookUserId = $this->_facebookSession['uid'];
			    //$this->_facebookUser = $this->_facebook->api('/me');
		  	} 
		  	catch (FacebookApiException $e) 
		  	{
		    	error_log($e);
		  	}
		}  */
	}
	public function indexAction()
	{		
		if ($this->_facebookUserId) 
		{
			$facebookInviteSess = new Zend_Session_Namespace('facebookInviteSession');
			if(isset($facebookInviteSess->value))
			{
				$facebookInviteSess->unsetAll();
				$this->view->loginUrl = 'http://zenfox.tld/facebook/invite';
			}
			else
			{
				
				//Zenfox_Debug::dump($this->getRequest()->data, 'buddyId', true, true);
				$registerData = $this->register($this->_facebookUserId, $this->_accessToken, 2, $this->getRequest()->buddyId);
				$newUser = $registerData['newUser'];
				if($newUser)
				{
					$playerId =  $registerData['playerId'];
					$this->addBonus($playerId);
				}
				$this->view->loginUrl = 'http://apps.facebook.com/'.$this->_appName.'/gameindex';
			}
		} 
		else 
		{
			if(isset($_POST['submit']))
			{
				$facebookInviteSess = new Zend_Session_Namespace('facebookInviteSession');
				$facebookInviteSess->value = true;
			}
			$cancelUrl = 'http://apps.facebook.com/'.$this->_appName.'/sorry';
			//$loginUrl = $this->_facebook->getLoginUrl(array('canvas' => 1,'fbconnect' => 0,'display'=>'page', 'req_perms'=>'email, user_birthday', 'cancel_url' => $cancelUrl, 'next' => 'http://apps.facebook.com/zen-fox/sorry'));
			$loginUrl = $this->_facebook->getLoginUrl(array('canvas' => 1,'fbconnect' => 0,'display'=>'page', 'scope'=>'email'));
		  	$this->view->loginUrl = $loginUrl;
		}
	}

	public function gameindexAction()
	{		
		Zend_Layout::getMvcInstance()->setLayout('facebook_layout');
		if($_POST['submit'] == 'facebook')
		{
			$cancelUrl = 'http://apps.facebook.com/'.$this->_appName.'/sorry';
			$loginUrl = $this->_facebook->getLoginUrl(array('canvas' => 1,'fbconnect' => 0,'display'=>'page', 'req_perms'=>'user_likes, publish_stream', 'next' => 'http://apps.facebook.com/zen-fox/gameindex', 'cancel_url' => $cancelUrl));
		  	$this->view->loginUrl = $loginUrl;	
		}
		//TODO save these ids in database
		//No Need of it, sending buddyId with the invitation
		//$invitedFriendsId = $_POST['ids'];
		
		//WALL POST
		
		//$uid = $this->_facebook->getUser();
		$fql = 'SELECT uid FROM user WHERE uid IN (SELECT uid2 FROM friend WHERE uid1='.$this->_facebookUserId.')';
        $_friends = $this->_facebook->api( array( 'method' => 'fql.query', 'query' => $fql ) );
        $friends = array();
        if (is_array($_friends) && count($_friends))
        {
                foreach ($_friends as $friend)
                {
                        $friends[] = $friend['uid'];
                }
        }
        //Zenfox_Debug::dump($friends, 'friends', true, true);
		//$facebookSession = $this->_facebook->getSession();
		/* foreach($friends as $friendId)
		{
			$result = $this->_facebook->api(
        			'/' . $friendId . '/feed/',
					'POST',
        			array('access_token' => $this->_accessToken, 'message' => 'Hi!! I invite you...', 'picture' => 'http://play.taashtime.com/css/rummy.tld/images/tt_18plus.png'));
		} */
		//$user = json_decode(file_get_contents('https://graph.facebook.com/me?access_token=' . $this->_facebookSession['access_token']));
		//print_r($user);
		//echo '<br>';
		/*foreach($user as $index => $userDetails)
		{
			print($index . "=");
			print_r($userDetails);
			if($index == 'location')
			{
				echo '<br>';
				echo "Location";
				print_r($userDetails->name);
				/*echo '<br>';
				echo "Location";
				foreach($userDetails['location'] as $name => $userLocation)
				{
					print($name . "=");
					print_r($userLocation);
				}
			}
			if($index == 'work')
			{
				foreach($userDetails as $workDetails)
				{
					echo '<br>';
					echo "Work";
					print($workDetails->employer->name . ' ');
					print($workDetails->location->name);
				}
				/*echo '<br>';
				echo "Location";
				print_r($userDetails->name);
			}
			echo '<br>';
		}*/
		
		$fql = 'SELECT uid FROM user WHERE uid IN (SELECT uid2 FROM friend WHERE uid1='.$this->_facebookUserId.') AND is_app_user = 1';
		//$fql = 'SELECT uid FROM user WHERE uid IN (SELECT uid2 FROM friend WHERE uid1='.$this->_facebookUserId.')';
		$_friends = $this->_facebook->api( array( 'method' => 'fql.query', 'query' => $fql ) );

		// Extract the user ID's returned in the FQL request into a new array.
		$friends = array();
		if (is_array($_friends) && count($_friends)) {
			foreach ($_friends as $friend) {
				$friends[] = $friend['uid'];
				//$user = json_decode(file_get_contents('https://graph.facebook.com/' . $friend['uid'] . '?access_token=' . $this->_facebookSession['access_token']));
				//print_r($user);
				//echo '<br>';
			}
		}
		//exit();
	
		// Convert the array of friends into a comma-delimeted string.
		$friends = implode(',', $friends);
		
		$frontendId = Zend_Registry::getInstance()->get('frontendId');
		$session = new Zend_Auth_Storage_Session();
		$store = $session->read();
	
		$playerId = $store['id'];
		$gameGroupFrontend = new GamegroupFrontend();
		if(!$playerId && $this->_facebookUserId)
		{
			$player = new Player();
			$playerId = $player->getPlayerId($this->_facebookUserId);
			$playerData = $player->getAccountDetails($playerId);
			
			$session = new Zenfox_Auth_Storage_Session();
			$session->write(array(
				'id' => $playerId,
				'roleName' => 'player',
				'authDetails' => $playerData));
	
			$playerSession = new PlayerSession($playerId);
			$playerSession->storeInformation();
		}
		$store = $session->read();
		//$playerId is the partition key
		if($playerId)
		{
			$accountVariable = new AccountVariable();
			
			$tutorialRead = $_POST['tutorialRead'];
			if(isset($tutorialRead))
			{
				Zend_Layout::getMvcInstance()->disableLayout();
				//Tutorial Check
				$data['variableName'] = 'tutorialRead';
				$data['variableValue'] = 1;
				$data['playerId'] = $playerId;
				$accountVariable->insert($data);
			}
			else
			{
				$login = $store['authDetails'][0]['login'];
				$password = $store['authDetails'][0]['password'];
				//Zenfox_Debug::dump($store, 'data', true, true);
					
				$cash = $store['authDetails'][0]['cash'];
				$bonus = $store['authDetails'][0]['bonus_bank'] + $store['authDetails'][0]['bonus_winnings'];
				$loyaltyPoints = $store['authDetails'][0]['loyalty_points_left'];
					
				$currency = new Zend_Currency();
				$currencySession = new Zend_Session_Namespace('currency');
				$source = $currency->getShortName('', $currencySession->oldValue);
				$destination = $currency->getShortName('', $currencySession->newValue);
				$currConv = new CurrencyConversion();
				$cash = $currConv->getConvertedValue($source, $destination, $cash);
				$cashValue = empty($cash) ? $currency->setValue(0) : $currency->setValue($cash);
				$bonus = $currConv->getConvertedValue($source, $destination, $bonus);
				$totalBonus = empty($bonus) ? $currency->setValue(0) : $currency->setValue($bonus);
				$store['cash'] = $cash;
				$store['bonus'] = $bonus;
					
				$playerDetails['firstName'] = $store['authDetails'][0]['first_name'];
				$playerDetails['lastName'] = $store['authDetails'][0]['last_name'];
				$playerDetails['dateOfBirth'] = $store['authDetails'][0]['dateofbirth'];
				$playerDetails['cash'] = $cashValue;
				$playerDetails['bonus'] = $totalBonus;
					
				$gameGroups = $gameGroupFrontend->getAllGroups($frontendId, $playerId);
					
				//adding daily free chips
				$lastLogin = $store['lastlogin'];
					
				$currentLogin = Zend_Date::now();
				$lastLogin = new Zend_Date($lastLogin);
					
				$difference = $currentLogin->sub($lastLogin)->toValue();
				
				$daydifference = floor($difference/(60*60*24));
				if($daydifference >= 1)
				{
					$this->view->success = true;
					$accountVariable = new AccountVariable();
					if($daydifference > 1)
					{
						$vardata['playerId'] = $playerId;
						$vardata['variableName'] = 'CONSECUTIVE_DAYS';
						$vardata['variableValue'] = 0;
						$accountVariable->insert($vardata);
					}
					$useractionobj = new UserActions();
					$dailybonus["success"] = "true";
					$dailybonus["data"] = $useractionobj->addFreeChips($playerId);
				
					$this->view->dailybonus = json_encode($dailybonus);
					$store['lastlogin'] = $store['authDetails'][0]['last_login'];
				
				}
				else
				{
					$dailybonus["success"] = "false";
					$this->view->dailybonus = json_encode($dailybonus);
				}
				$session->write($store);
					
				//till here
				
				//Tutorial Check
				$variableData = $accountVariable->getData($playerId, 'tutorialRead');
				$this->view->tutorialRead = $variableData['varValue'];
					
				$this->view->gameGroups = $gameGroups;
				$this->view->login = $login;
				$this->view->password = $password;
				$this->view->appName = $this->_appName;
				$this->view->buddyId = $playerId;
				$this->view->friends = $friends;
				$this->view->appId = $this->_appId;
				$this->view->playerData = $playerDetails;
			}			
		}
	}
	
	public function gameAction()
	{
		$request = $this->getRequest();
		if($request->format == 'json')
		{
			$uid = $_POST['uid'];
			$accessToken = $_POST['accessToken'];
			$tableId = $_GET['tableId'];
			$flavour = $_GET['flavour'];
			$newUser = $this->register($uid, $accessToken);
		}
		else
		{
			$machineId = $request->machineId;
			$flavour = $request->flavour;
			$amountType = $request->amountType;
			$this->_forward('game', 'game', 'player', array('flavour' => $flavour, 'machineId' => $machineId, 'amountType' => $amountType));
		}
	}
	
	public function sorryAction()
	{
		$uid = $this->_facebook->getUser();
		$fql = 'SELECT uid FROM user WHERE uid IN (SELECT uid2 FROM friend WHERE uid1='.$uid.') AND is_app_user = 1';
		$_friends = $this->_facebook->api( array( 'method' => 'fql.query', 'query' => $fql ) );
		$friends = array();
		$index = 0;
		if (is_array($_friends) && count($_friends))
		{
			foreach ($_friends as $friend)
			{
				$user = json_decode(file_get_contents('https://graph.facebook.com/' . $friend['uid'] . '?access_token=' . $this->_accessToken));
				$friends[$index]['id'] = $friend['uid'];
				$friends[$index]['name'] = $user->name;
				$friends[$index]['image'] = "http://graph.facebook.com/" . $friend['uid'] . "/picture";
				$index++;
			}
		}
		Zenfox_Debug::dump($friends, 'friends');
	}
	
	public function register($uid, $accessToken, $frontendId, $buddyId = NULL, $newUser = NULL)
	{	
		$player = new Player();
		$authDetails = array();
		$user = json_decode(file_get_contents('https://graph.facebook.com/me?access_token=' . $accessToken));
			//Check user is registered on our server or not
		if($player->validateLogin("$uid"))
		{
			$frontendId = Zend_Registry::get('frontendId');
			$frontend = new Frontend();
    		$frontendData = $frontend->getFrontendById($frontendId);
		  	$user = json_decode(file_get_contents('https://graph.facebook.com/me?access_token=' . $accessToken));
		  	
		  	$facebookBirthDay = explode('/', $user->birthday);
			$playdormBirthDay[] = $facebookBirthDay[2];
			$playdormBirthDay[] = $facebookBirthDay[0];
			$playdormBirthDay[] = $facebookBirthDay[1];
			$user->birthday = implode('-', $playdormBirthDay);
			
		  	$authDetails['login'] = "$uid";
		  	$authDetails['password'] = md5($uid);//$uid . $user->birthday;
		  	$authDetails['confirmPassword'] = $uid . $user->birthday;
			$authDetails['email'] = $user->email;
			$authDetails['firstName'] = $user->first_name;
			$authDetails['lastName'] = $user->last_name;
			$authDetails['dateOfBirth'] = $user->birthday;
			//$authDetails['base_currency'] = $frontendData[0]['default_currency'];
			$authDetails['frontendId'] = $frontendId;
			$authDetails['buddyId'] = $buddyId;
			
			$trackerSession = new Zend_Session_Namespace('tracker');
			$tracker_id = isset($trackerSession->value) ? $trackerSession->value : NULL;
			$authDetails['trackerId'] = $tracker_id;
			$trackerSession->unsetAll();
			if($tracker_id)
			{
				$affSession = new Zend_Session_Namespace('affSession');
				$aff_id = isset($affSession->value) ? $affSession->value : NULL;
				$affSession->unsetAll();
			}
			
			/*$authDetails['bank'] = $this->_facebookConfig['application']['bank'];
			$authDetails['winnings'] = $this->_facebookConfig['application']['winnings'];
			$authDetails['bonus_bank'] = $this->_facebookConfig['application']['bonus_bank'];
			$authDetails['bonus_winnings'] = $this->_facebookConfig['application']['bonus_winnings'];
			$authDetails['cash'] = $this->_facebookConfig['application']['cash'];
			$authDetails['balance'] = $this->_facebookConfig['application']['balance'];*/
			
			$sex = $user->gender;
			if((strtolower($sex)) == 'male')
			{
				$authDetails['sex'] = 'M';
			}
			elseif((strtolower($sex)) == 'female')
			{
				$authDetails['sex'] = 'F';
			}
			
			if(isset($user->location->name))
			{
				$location = explode(', ', $user->location->name);
				$authDetails['city'] = $location[0];
				$authDetails['state'] = $location[1];
			}
			//Zenfox_Debug::dump($authDetails, 'auth', true, true);
			
			$player->registerPlayer($authDetails);
			$newUser = true;
		}
			
		$playerId = $player->getPlayerId($uid);
		if($newUser)
		{
			/* $data['variableName'] = 'CV_AFF-ID';
			$data['variableValue'] = $aff_id;
			$data['playerId'] = $playerId;
			$accountVariable = new AccountVariable();
			$accountVariable->insert($data); */
			
			$data['variableName'] = 'freeMoney';
			$data['variableValue'] = 60000;
			$data['playerId'] = $playerId;
			$accountVariable = new AccountVariable();
			$accountVariable->insert($data);
		}
		if(!$playerId)
		{
			return false;
		}
		
		$accountVariable = new AccountVariable();
		$variableData = $accountVariable->getData($playerId, 'tutorialRead');
		if(!$variableData)
		{
			$data['variableName'] = 'tutorialRead';
			$data['variableValue'] = 0;
			$data['playerId'] = $playerId;
			$accountVariable->insert($data);
		}
		
		$facebookBirthDay = explode('/', $user->birthday);
		$playdormBirthDay[] = $facebookBirthDay[2];
		$playdormBirthDay[] = $facebookBirthDay[0];
		$playdormBirthDay[] = $facebookBirthDay[1];
		$authDetails['email'] = $user->email;
		$user->birthday = implode('-', $playdormBirthDay);
		$authDetails['firstName'] = $user->first_name;
		$authDetails['lastName'] = $user->last_name;
		$authDetails['dateOfBirth'] = $user->birthday;
		$sex = $user->gender;
		if((strtolower($sex)) == 'male')
		{
			$authDetails['sex'] = 'M';
		}
		elseif((strtolower($sex)) == 'female')
		{$accountVariable->insert($data);
			$authDetails['sex'] = 'F';
		}
		
		if(!$player->updateFacebookData($playerId, $authDetails))
		{
			return false;
		}
		
		$playerData = $player->getAccountDetails($playerId);
//		Zenfox_Debug::dump($playerData, 'data', true, true);
/*		if($newUser)
		{
			$frontController = Zend_Controller_Front::getInstance();
			$bonusSchemePlugin = new Zenfox_Controller_Plugin_BonusScheme($playerData[0]['login']);
			$frontController->registerPlugin($bonusSchemePlugin, 300);
		}
*/
		$session = new Zenfox_Auth_Storage_Session();
		$session->write(array(
			'id' => $playerId,
			'roleName' => 'player',
			'lastlogin' => $playerData[0]["last_login"],
			'authDetails' => $playerData));
		
		
		$playerSession = new PlayerSession($playerId);
		$playerSession->storeInformation();
		//Zenfox_Debug::dump($session->read(), 'session', true, true);
		return array('newUser' => $newUser, 'playerId' => $playerId);
	}
	
	public function facebookloginAction()
	{
		$this->_facebookUserId = $this->getRequest()->userId;
		//$this->_facebookSession['access_token'] = $this->getRequest()->accessToken;
		$frontendId = Zend_Registry::get('frontendId');
		if ($this->_facebookUserId && !($this->getRequest()->format == 'json'))  
		{
			$registerData = $this->register($this->_facebookUserId, $this->_accessToken, $frontendId);
			$newUser = $registerData['newUser'];
			$playerId = $registerData['playerId'];
			$error = false;
			if($newUser)
			{
				$player = new Player();
				$frontendId = Zend_Registry::get('frontendId');
				$frontend = new Frontend();
				if(!$schemeId = $frontend->getBonusSchemeId($frontendId))
				{
					$error = true;
					$this->_helper->FlashMessenger(array('error' => 'There is some problem while adding joining bonus. Please contact to our customer support'));
				}
	//			Zenfox_Debug::dump($schemeId, 'id');
				$bonusLevel = new BonusLevel();
				if(!$amount = $bonusLevel->getAmount($schemeId, -1))
				{
					$error = true;
					$this->_helper->FlashMessenger(array('error' => 'There is some problem while adding joining bonus. Please contact to our customer support'));
				}
	//			Zenfox_Debug::dump($amount, 'amount', true, true);
				$accountDetail = $player->getAccountDetails($playerId);
				$baseCurrency = $accountDetail[0]['base_currency'];
				$playerTransaction = new PlayerTransactions();
				if(!$playerTransaction->creditBonus($playerId, $amount['bonus'], $baseCurrency))
				{
					$error = true;
					$this->_helper->FlashMessenger(array('error' => 'There is some problem while adding joining bonus. Please contact to our customer support'));
				}

				if(isset($accountDetail[0]['buddy_id']))
				{
					$data['playerId'] = $playerId;
					$data['variableName'] = 'is-credited-master';
					$data['variableValue'] = 0;
					$conn = Zenfox_Partition::getInstance()->getMasterConnection();
					Doctrine_Manager::getInstance()->setCurrentConnection($conn);
					$accountVariable = new AccountVariable();
					$accountVariable->insert($data);
				}
			}
			if($playerId && !$error)
			{
				$this->_redirect('/game');
			}
			else
			{
				$this->_helper->FlashMessenger(array('error' => 'There is some problem while getting player details. Please try again.'));
			}
			$this->view->success = 'true';
		}
		elseif($this->getRequest()->format == 'json')
		{
			//echo "here"; exit();
			$uid = $_POST['uid'];
			$accessToken = $_POST['accessToken'];
			$newUser = $this->register($uid, $accessToken, $frontendId);
			//$this->view->success = 'true';
			
			 $storage = new Zenfox_Auth_Storage_Session();
             $session = $storage->read();
             $playerId = $session['id'];
             $currency = new Zend_Currency();
             $imageName = md5("image" . $playerId) . '.jpg';
             $loginName = $session['authDetails'][0]['login'];
             $firstName = $session['authDetails'][0]['first_name'];
             $cash = $session['authDetails'][0]['cash'];
             $bonus = $session['authDetails'][0]['bonus_bank'] + $session['authDetails'][0]['bonus_winnings'];
             $loyaltyPoints = $session['authDetails'][0]['loyalty_points_left'];
             $currencySession = new Zend_Session_Namespace('currency');
             $source = $currency->getShortName('', $currencySession->oldValue);
             $destination = $currency->getShortName('', $currencySession->newValue);
             $currConv = new CurrencyConversion();
             $cash = $currConv->getConvertedValue($source, $destination, $cash);
             $bonus = $currConv->getConvertedValue($source, $destination, $bonus);
             $imagePath = APPLICATION_PATH . "/../public/images/profiles/" . $imageName;
             if(!file_exists($imagePath))
             {
             	$imagePath = "/images/" . $this->imagesDir . "../profiles/profile-m1.jpg";
             }
             else
             {
             	$imagePath = "/images/profiles/" . $imageName;
             }
             $name = empty($firstName)?$loginName:$firstName;

             $authData['user_name'] = $name;
             $authData['balance'] = $cash;
             $authData['bonus'] = $bonus;
             $authData['loyalty_points'] = $loyaltyPoints;
             $authData['image_path'] = $imagePath;
             
             $this->view->success=$authData;
		}
	}
	
	public function inviteAction()
	{
		//Zend_Layout::getMvcInstance()->enableLayout();
	}

	public function addBonus($playerId)
	{
		 $player = new Player();
                 $frontendId = Zend_Registry::get('frontendId');
                 $frontend = new Frontend();
                 if(!$schemeId = $frontend->getBonusSchemeId($frontendId))
                 {
                        $this->_helper->FlashMessenger(array('error' => 'There is some problem while adding joining bonus. Please contact to our customer support'));
                 }
//                      Zenfox_Debug::dump($schemeId, 'id');
                        $bonusLevel = new BonusLevel();
                        if(!$amount = $bonusLevel->getAmount($schemeId, -1))
                        {
                               $this->_helper->FlashMessenger(array('error' => 'There is some problem while adding joining bonus. Please contact to our customer support'));
                        }
//                      Zenfox_Debug::dump($amount, 'amount', true, true);
                        $accountDetail = $player->getAccountDetails($playerId);
                        $baseCurrency = $accountDetail[0]['base_currency'];
                        $playerTransaction = new PlayerTransactions();
                        if(!$playerTransaction->creditBonus($playerId, $amount['bonus'], $baseCurrency))
                        {
                               $this->_helper->FlashMessenger(array('error' => 'There is some problem while adding joining bonus. Please contact to our customer support'));
                        }
                        if(isset($accountDetail[0]['buddy_id']))
                        {
                               $data['playerId'] = $playerId;
                               $data['variableName'] = 'is-credited-master';
                               $data['variableValue'] = 0;
                               $conn = Zenfox_Partition::getInstance()->getMasterConnection();
                               Doctrine_Manager::getInstance()->setCurrentConnection($conn);
                               $accountVariable = new AccountVariable();
                               $accountVariable->insert($data);
			}
	}
	
	public function paymentAction()
	{
		$app_secret = $this->_appSecret;

		// Validate request is from Facebook and parse contents for use.
		$request = $this->parse_signed_request($_POST['signed_request'], $app_secret);
		
		// Get request type.
		// Two types:
		//   1. payments_get_items.
		//   2. payments_status_update.
		$request_type = $_POST['method'];
		
		// Setup response.
		$response = '';
		
		if ($request_type == 'payments_get_items') {
		  // Get order info from Pay Dialog's order_info.
		  // Assumes order_info is a JSON encoded string.
		  $order_info = json_decode($request['credits']['order_info'], true);
		
		  // Get item id.
		  $item_id = $order_info['item_id'];
		
		  // Simulutates item lookup based on Pay Dialog's order_info.
		  if ($item_id == '1a') {
		    $item = array(
		      'title' => '100 some game cash',
		      'description' => 'Spend cash in some game.',
		      // Price must be denominated in credits.
		      'price' => 1,
		      //'image_url' => 'http://some_image_url/coin.jpg',
		    );
		
		    // Construct response.
		    $response = array(
		                  'content' => array(
		                                 0 => $item,
		                               ),
		                  'method' => $request_type,
		                );
		    // Response must be JSON encoded.
		    $response = json_encode($response);
		  }
		
		} else if ($request_type == "payments_status_update") {
		  // Get order details.
		  $order_details = json_decode($request['credits']['order_details'], true);
		
		  // Determine if this is an earned currency order.
		  $item_data = json_decode($order_details['items'][0]['data'], true);
		  $earned_currency_order = (isset($item_data['modified'])) ?
		                             $item_data['modified'] : null;
		
		  // Get order status.
		  $current_order_status = $order_details['status'];
		
		  if ($current_order_status == 'placed') {
		    // Fulfill order based on $order_details unless...
		
		    if ($earned_currency_order) {
		      // Fulfill order based on the information below...
		      // URL to the application's currency webpage.
		      $product = $earned_currency_order['product'];
		      // Title of the application currency webpage.
		      $product_title = $earned_currency_order['product_title'];
		      // Amount of application currency to deposit.
		      $product_amount = $earned_currency_order['product_amount'];
		      // If the order is settled, the developer will receive this
		      // amount of credits as payment.
		      $credits_amount = $earned_currency_order['credits_amount'];
		    }
		
		    $next_order_status = 'settled';
		
		    // Construct response.
		    $response = array(
		                  'content' => array(
		                                 'status' => $next_order_status,
		                                 'order_id' => $order_details['order_id'],
		                               ),
		                  'method' => $request_type,
		                );
		    // Response must be JSON encoded.
		    $response = json_encode($response);
		
		  } else if ($current_order_status == 'disputed') {
		    // 1. Track disputed item orders.
		    // 2. Investigate user's dispute and resolve by settling or refunding the order.
		    // 3. Update the order status asychronously using Graph API.
		
		  } else if ($current_order_status == 'refunded') {
		    // Track refunded item orders initiated by Facebook. No need to respond.
		
		  } else if ($current_order_status == 'settled') {
		    
		    // Verify that the order ID corresponds to a purchase you've fulfilled, then…
		    
		    // Get order details.
		    $order_details = json_decode($request['credits']['order_details'], true);
		
		    // Construct response.
		    $response = array(
		                  'content' => array(
		                                 'status' => 'settled',
		                                 'order_id' => $order_details['order_id'],
		                               ),
		                  'method' => $request_type,
		                );
		    // Response must be JSON encoded.
		    $response = json_encode($response);
		    
		  } else {
		    // Track other order statuses.
		
		  }
		}
		
		// Send response.
		echo $response;
		
	}
	
	// These methods are documented here:
	// https://developers.facebook.com/docs/authentication/signed_request/
	function parse_signed_request($signed_request, $secret) {
		list($encoded_sig, $payload) = explode('.', $signed_request, 2);
	
		// decode the data
		$sig = $this->base64_url_decode($encoded_sig);
		$data = json_decode($this->base64_url_decode($payload), true);
	
		if (strtoupper($data['algorithm']) !== 'HMAC-SHA256') {
			error_log('Unknown algorithm. Expected HMAC-SHA256');
			return null;
		}
	
		// check sig
		$expected_sig = hash_hmac('sha256', $payload, $secret, $raw = true);
		if ($sig !== $expected_sig) {
			error_log('Bad Signed JSON signature!');
			return null;
		}
	
		return $data;
	}
	
	function base64_url_decode($input) {
		return base64_decode(strtr($input, '-_', '+/'));
	}
}
