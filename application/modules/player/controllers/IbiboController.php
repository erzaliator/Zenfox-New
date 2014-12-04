<?php
class Player_IbiboController extends Zenfox_Controller_Action
{
	public function indexAction()
	{
		Zend_Layout::getMvcInstance()->disableLayout();

		echo "in index";
		$MerchantID = '201110042661';//your merchant id
		$MRef_ID = '123';//your order id
		$Amount = 1;
		$Description = 'Testing';
		$Currency = 'INR';
		$SecretPIN = 'fcem2661fcem';//your Secret word

		$soap_url = 'http://molv3.molsolutions.com/api/login/s_module/heartbeat.asmx?WSDL';
//		$soap_url = 'https://www.sandbox.paypal.com/wsdl/PayPalSvc.wsdl';
		$method = 'GetHeartBeat';

		$soap_param = array(array('MerchantID' => $MerchantID));

		try
		{
//			$client = new Zend_Soap_Client($soap_url, array('soap_version' => SOAP_1_2));
			/*$client = new SoapClient(NULL,array(
			        "location" => $soap_url,
			        "uri"      => "",
			        "style"    => SOAP_RPC,
		        	"use"      => SOAP_ENCODED
	        	   )); */
			$client = new SoapClient($soap_url, array('soap_version'   => SOAP_1_1));
/*			$client = new Zend_Soap_Client();
			$client->setWsdl($soap_url);
			$client->LogIn(array('username' => 'FortuityInfotech_demo_01@gmail.com', 'password' => 'fcem2661'));*/
		}
		catch(Exception $e)
		{
			Zenfox_Debug::dump($e, "Fault String:");
			//echo "exception";
			//print_r($e); //exit();
		}

		/*$rand_num = rand();
		$app_secret = '39004382290527505089';
		$consumer_key = 95800;
		$msg = $rand_num.'|'.$consumer_key.'|'.$app_secret;
		$signature = base64_encode(md5($msg,true));       
		$post_data['request_token']  = $rand_num;
	    	$post_data['consumer_key']  = $consumer_key;
	    	$post_data['sig']    = $signature;
	    	$statusUrl = "http://apps.ibibo.com/oauth/getAccessToken";
		$url = str_replace(" ","%20",$statusUrl);
		//$statusOut = $this->utils->getDataCurl($url,$post_data);

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		$statusOut = curl_exec($ch);
		curl_close($ch);
		$access_token_arr = json_decode($statusOut);
		$access_result = json_decode($statusOut,true);
//		Zenfox_Debug::dump($access_result, 'result');
		if($access_result['result'] == 'success')
		{
			$access_token = $access_result['access_token'];
			setcookie("access_token",$access_token,time()+2400);
			// authorize app
			$auth_post['access_token'] = $access_token;
			$auth_post['app_id'] = $consumer_key;
			$app_id = $consumer_key;
			$auth_msg = $app_id."|".$access_token."|".$app_secret;
			$auth_sign = base64_encode(md5($auth_msg,true));
			$surl = "http://apps.ibibo.com/taash";
			$authorizeurl = "http://apps.ibibo.com/oauth/authorize";
			$authorizeurl = str_replace(" ","%20",$authorizeurl);
			$authUrl = $authorizeurl."?access_token=".$access_token."&sig=".$auth_sign."&app_id=".$app_id."&surl=".$surl."&&scope=basic_info,user_friends,publish_stream,user_photos";
			if(isset($_COOKIE['access_token'] ))
			{
				$result = $this->getUserInfo($_COOKIE['access_token']);
				//Zenfox_Debug::dump($result, 'userData', true, true);
				if($result == "failed")
				{
					echo("<script> top.location.href='" . $authUrl . "'</script>");	
				}
				else
				{
					$this->getFriendsInfo($access_token);
					echo "Fetching 3 icoins for my app";
					$this->fetchIcoins($access_token);
					$this->sendGameNotification($access_token);
					//Zenfox_Debug::dump($result, 'data');
					$this->register($result);
				}	
			}	
		}*/
	}

	public function getUserInfo($access_token="")
	{
//		echo 'token->' . $access_token;
		$post_data['access_token'] = $access_token;
		$post_data['app_id'] = 95800;
		$userInfoUrl = "http://apps.ibibo.com/method/getUserInfo";
		$url = str_replace(" ","%20",$userInfoUrl);

//		Zenfox_Debug::dump($url, 'url');
		$ch = curl_init($url);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                $statusOut = curl_exec($ch);
		curl_close($ch);
		//Zenfox_Debug::dump($statusOut, 'status');

		//$statusOut = $this->utils->getDataCurl($url,$post_data);
		$result = json_decode($statusOut,true);
		//var_dump($result);
		if($result['result'] == "failed")
		{
			return $result['result'];
		}
		else
		{
			return $result['basicInfo'];
			/*$username = $result['basicInfo']['cn'].' '.$result['basicInfo']['sn'];
			$profilepic = $result['basicInfo']['profilePic'];
			echo "Hi ".$username." <img src=".$profilepic."><br/>";*/
		}		
	}

	public function register($userData)
	{
		//Zenfox_Debug::dump($userData, 'userData', true, true);
		$login = $userData['uid'];
		$firstName = $userData['cn'];
		$lastName = $userData['sn'];
		$email = $userData['mail'];
		$dob = $userData['dob'];
		$dob = explode('/', $dob);
		$dateOfBirth = $dob[2] . '-' . $dob[0] . '-' . $dob[1];
		$player = new Player();
		$authDetails = array();
		$newUser = false;
		if($player->validateLogin("$login"))
		{
			//echo "here";
			$frontendId = Zend_Registry::get('frontendId');
			$frontend = new Frontend();
			$frontendData = $frontend->getFrontendById($frontendId);
		
			$authDetails['login'] = "$login";
			$authDetails['password'] = md5($login);
			$authDetails['confirmPassword'] = md5($login);
			$authDetails['email'] = $email;
			$authDetails['firstName'] = $firstName;
			$authDetails['lastName'] = $lastName;
			$authDetails['dateOfBirth'] = $dateOfBirth;
			$authDetails['base_currency'] = $frontendData[0]['default_currency'];
			$authDetails['frontendId'] = $frontendId;
			$player->registerPlayer($authDetails);
			$newUser = true;
		}
		$playerId = $player->getPlayerId($login);
		$playerData = $player->getAccountDetails($playerId);
		//Zenfox_Debug::dump($playerData, 'data', true, true);
		if($newUser)
		{
			$frontController = Zend_Controller_Front::getInstance();
			$bonusSchemePlugin = new Zenfox_Controller_Plugin_BonusScheme($playerData[0]['login']);
			$frontController->registerPlugin($bonusSchemePlugin, 300);
		}
		$session = new Zenfox_Auth_Storage_Session();
		$session->write(array(
			'id' => $playerId,
			'roleName' => 'player',
			'authDetails' => $playerData));
	
		$playerSession = new PlayerSession($playerId);
		$playerSession->storeInformation();
	
		$this->_forward('index', 'game', 'player');
	}
}