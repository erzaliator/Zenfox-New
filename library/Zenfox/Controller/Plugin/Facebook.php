<?php
require_once ('facebook/facebook.php');
class Zenfox_Controller_Plugin_Facebook extends Zend_Controller_Plugin_Abstract
{
	private $_userId;
	private $_facebook;
	public function __construct()
	{
		$defaultModule = Zend_Registry::get('defaultModule');
		if($defaultModule == 'player')
		{
			$siteCode = Zend_Registry::get('siteCode');
			$facebookFile = APPLICATION_PATH . '/site_configs/' . $siteCode . '/facebook.json';
			$fh = fopen($facebookFile, 'r');
			$facebookKeyJson = fread($fh, filesize($facebookFile));
			fclose($fh);
			$facebookConfig = Zend_Json::decode($facebookKeyJson);
			$appapikey = $facebookConfig['application']['apiKey'];
			$appsecret = $facebookConfig['application']['secret'];
		
		//      $appapikey = '00c8acaf15e4634fda64d7399047da6b';
		//      $appsecret = 'e00c4df3bbcf21838706613a0ce8a5d1';
		//$appapikey = 'e87e0fea7ecd1840608b014a1b6509dd';
		//$appsecret = 'f12d9087b3a1939762973732bd92ea70';
		$this->_facebook = new Facebook($appapikey, $appsecret);
		//Check user is authenticated or not
		$this->_userId = $this->_facebook->get_loggedin_user();
		//$this->_userId = 0;
		}
	}
	
	public function init()
	{
		parent::init();
	}

	public function routeShutDown(Zend_Controller_Request_Abstract $request)
	{
		//print("in router shutdown");
		if($this->_userId)
		{
			//print("got user id");
			$player = new Player();
			$authDetails = array();
			//Check user is registered on our server or not
			if($player->validateLogin("$this->_userId"))
			{
				//print("User s not registered");
				for($i = 0; $i < 5; $i++)
				{
					//Fetch the userdata from facebook
					$userDetail = $this->_facebook->api_client->users_getInfo($this->_userId,
						'name, first_name, last_name, birthday_date, current_location, sex');
					if(is_array($userDetail))
					{
						break;
					}
				}
				if(!is_array($userDetail))
				{
					print("The session time is out. Please try again");
					sleep(30);
					$this->_facebook->require_login();
				}
				/*                              $userDetail = $this->_facebook->api_client->users_getInfo($this->_userId, 'name, first_name, last_name, birthday_date, current_loca    tion, sex');
				if(!is_array($userDetail))
				{
					print "<pre>Unable to get Facebook Info. No Donut for you! Debug Data::";
					print "User Id:: " . $this->_userId . "User Details:: ";
					print_r($userDetail);
					print "<a/pre>";
				}*/
				$userName = $userDetail[0]['name'];
				$sex = $userDetail[0]['sex'];
				if((strtolower($sex)) == 'male')
				{
					$authDetails['sex'] = 'M';
				}
				elseif((strtolower($sex)) == 'female')
				{
					$authDetails['sex'] = 'F';
				}
				$authDetails['login'] = "$this->_userId";
				$authDetails['password'] = $this->_userId . $userDetail[0]['birthday_date'];
				$authDetails['confirmPassword'] = $this->_userId . $userDetail[0]['birthday_date'];
				$authDetails['email'] = $this->_userId . '@facebook.com';
				$authDetails['first_name'] = $userDetail[0]['first_name'];
				$authDetails['last_name'] = $userDetail[0]['last_name'];
				$authDetails['dateOfBirth'] = $userDetail[0]['birthday_date'];
				$authDetails['city'] = $userDetail[0]['current_location']['city'];
				$authDetails['state'] = $userDetail[0]['current_location']['state'];
				$authDetails['country'] = $userDetail[0]['current_location']['country'];
				$authDetails['pin'] = $userDetail[0]['current_location']['zip'];
				$authDetails['bank'] = 1000;
				$authDetails['winnings'] = 1000;
				$authDetails['bonus_bank'] = 1000;
				$authDetails['bonus_winnings'] = 1000;
				$authDetails['cash'] = 2000;
				$authDetails['balance'] = 4000;
				$player->registerPlayer($authDetails);
			}
			// Got the user id from registerPlayer;
			//  $userId is the login for facebook user
			//print "Getting player ID";
			$playerId = $player->getPlayerId($this->_userId);
			if(!$playerId)
			{
				throw new Zenfox_Exception('Player Id not found.');
			}
			if($playerId)
			{
				$playerSession = new PlayerSession($playerId);
				$playerSession->storeInformation();
				if(!$playerSession)
				{
					throw new Zenfox_Exception('Unable to store Player Session');
				}
				$playerData = $player->getAccountDetails($playerId);
				if(!$playerData)
				{
					throw new Zenfox_Exception('No Account Details.');
				}
			}
			$session = new Zenfox_Auth_Storage_Session();
			$session->write(array(
			'id' => $playerId,
			'roleName' => 'player',
			'authDetails' => $playerData));
			$frontController = Zend_Controller_Front::getInstance();
			$aclPlugin = $frontController->getPlugin('Zenfox_Controller_Plugin_Acl');
			$aclPlugin->setRoleName('player');
			$aclPlugin->setId($playerId);
			//print "Getttng out of plugin";
			//$request->setControllerName('facebook');
			//$request->setActionName('index');
		}
		else
		{
			//print "Sending to facebook login";
			$fParam = $request->getParam('controller');
			//$token = $request->getParam('auth_token');
			if($fParam == 'facebook')
			{
				$this->_facebook->require_login();
			}
		}
	}

	public function routeStartup(Zend_Controller_Request_Abstract $request)
	{
		if(!$this->_userId)
		{
			$token = $request->getParam('auth_token');
			if($token)
			{	
				/*
				 * FIXME:: Fix this to point ot a dynamic application
				 */
				header('Location: http://apps.facebook.com/playdorm');
				//header('Location: http://apps.facebook.com/logicdicedemo');
			}
		}
	}
}
