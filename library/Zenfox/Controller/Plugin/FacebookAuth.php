<?php
class Zenfox_Controller_Plugin_FacebookAuth extends Zend_Controller_Plugin_Abstract
{
	public function routeShutdown(Zend_Controller_Request_Abstract $request)
	{
		/*define('FACEBOOK_APP_ID', '00c8acaf15e4634fda64d7399047da6b');
		define('FACEBOOK_SECRET', 'e00c4df3bbcf21838706613a0ce8a5d1');*/
		$siteCode = Zend_Registry::get('siteCode');
		$facebookFile = APPLICATION_PATH . '/site_configs/' . $siteCode . '/facebook.json';
		$fh = fopen($facebookFile, 'r');
		$facebookKeyJson = fread($fh, filesize($facebookFile));
		fclose($fh);
		$facebookConfig = Zend_Json::decode($facebookKeyJson);
		define('FACEBOOK_APP_ID', $facebookConfig['application']['apiKey']);
		define('FACEBOOK_SECRET', $facebookConfig['application']['secret']);
		function get_facebook_cookie($app_id, $application_secret)
		{
			$args = array();
			if(!isset($_COOKIE['fbs_' . $app_id]))
			{
				return;
			}
			parse_str(trim($_COOKIE['fbs_' . $app_id], '\\"'), $args);
			ksort($args);
			$payload = '';
			foreach ($args as $key => $value) 
			{
				if ($key != 'sig') 
				{
					$payload .= $key . '=' . $value;
				}
			}
			if (md5($payload . $application_secret) != $args['sig']) 
			{
				return null;
			}
			return $args;
		}
		$cookie = get_facebook_cookie(FACEBOOK_APP_ID, FACEBOOK_SECRET);
		$facebookLogout = $request->getParam('fLogout');
		if($cookie && !$facebookLogout)
		{
			$player = new Player();
			$authDetails = array();
			$userId = $cookie['uid'];
			$playerId = $player->getPlayerId($userId);
			$controller = $request->getControllerName();
			$action = $request->getActionName();
			if($action == 'logout')
			{
				?>
				<html>
					
				</html>
				<?php
			}
			elseif(!$playerId)
			{
				/*$authDetails['login'] = "$userId";
				$authDetails['password'] = $userId . $cookie['birthday'];
				$authDetails['confirmPassword'] = $userId . $cookie['birthday'];
				$authDetails['email'] = $cookie['email'];
				$authDetails['first_name'] = $cookie['first_name'];
				$authDetails['last_name'] = $cookie['last_name'];
				$authDetails['dateOfBirth'] = $cookie['birthday'];
				
				$sex = $cookie['gender'];
				if((strtolower($sex)) == 'male')
				{
					$authDetails['sex'] = 'M';
				}
				elseif((strtolower($sex)) == 'female')
				{
					$authDetails['sex'] = 'F';
				}
				
				if($cookie['location']['name'])
				{
					$location = explode(', ', $cookie['location']['name']);
					$authDetails['city'] = $location[0];
					$authDetails['state'] = $location[1];
				}
//				$authDetails['country'] = $userDetail[0]['current_location']['country'];
//				$authDetails['pin'] = $userDetail[0]['current_location']['zip'];
				$authDetails['bank'] = 1000;
				$authDetails['winnings'] = 1000;
				$authDetails['bonus_bank'] = 1000;
				$authDetails['bonus_winnings'] = 1000;
				$authDetails['cash'] = 2000;
				$authDetails['balance'] = 4000;*/
				$user = json_decode(file_get_contents('https://graph.facebook.com/me?access_token=' . $cookie['access_token']));
			//	Zenfox_Debug::dump($user, 'user');
				$authDetails['login'] = "$userId";
				$authDetails['password'] = $userId . $user->birthday;
				$authDetails['confirmPassword'] = $userId . $user->birthday;
				$authDetails['email'] = $user->email;
				$authDetails['first_name'] = $user->first_name;
				$authDetails['last_name'] = $user->last_name;
				$authDetails['dateOfBirth'] = $user->birthday;
				//Zenfox_Debug::dump($authDetails, 'auth', true, true);
				$sex = $user->gender;
				if((strtolower($sex)) == 'male')
				{
					$authDetails['sex'] = 'M';
				}
				elseif((strtolower($sex)) == 'female')
				{
					$authDetails['sex'] = 'F';
				}
				
				if($user->location->name)
				{
					$location = explode(', ', $user->location->name);
					$authDetails['city'] = $location[0];
					$authDetails['state'] = $location[1];
				}
//				$authDetails['country'] = $userDetail[0]['current_location']['country'];
//				$authDetails['pin'] = $userDetail[0]['current_location']['zip'];
				$authDetails['bank'] = 1000;
				$authDetails['winnings'] = 1000;
				$authDetails['bonus_bank'] = 1000;
				$authDetails['bonus_winnings'] = 1000;
				$authDetails['cash'] = 2000;
				$authDetails['balance'] = 4000;
			//	Zenfox_Debug::dump($authDetails, 'details', true, true);
				$player->registerPlayer($authDetails);
				$playerId = $player->getPlayerId($userId);
				if($playerId)
				{
					$request->setParam('facebookAuth', 1);
				}
			}
			
			$session = new Zenfox_Auth_Storage_Session();
			$facebookSession = new Zend_Session_Namespace('facebookAuth');
			$facebookPopup = new Zend_Session_Namespace('facebookPopup');
			if((!$session->read()) && (!$facebookSession->value))
			{
				if(!$facebookPopup->value)
				{
					$facebookPopup->value = true;
					?>
					<SCRIPT LANGUAGE="javascript">
					<!--
					function CONFIRM(){
						if (!confirm("You are logged in through Facebook. Would you like to continue?"))
						var url = location.protocol + "//" + location.host +  "/auth/login";
				        window.location.href = url;
					}
					document.writeln(CONFIRM())
					<!-- END -->
					</SCRIPT>
					<?php
					//$request->setParam('facebookAuth', 1);
					$request->setParam('playerId', $playerId);
					$request->setControllerName('auth');
					$request->setActionName('login');
					$playerData = $player->getAccountDetails($playerId);
					$session->write(array(
						'id' => $playerId,
						'roleName' => 'player',
						'authDetails' => $playerData,
						));
					$playerSession = new PlayerSession($playerId);
					$playerSession->storeInformation();
					$frontController = Zend_Controller_Front::getInstance();
					$aclPlugin = $frontController->getPlugin('Zenfox_Controller_Plugin_Acl');
					$aclPlugin->setRoleName('player');
					$aclPlugin->setId($playerId);
					$facebookSession = new Zend_Session_Namespace('facebookAuth');
				}
				$facebookSession->value = false;
			}
		}
	}
}
