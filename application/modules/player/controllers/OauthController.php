<?php
require_once ('Oauth/Oauth2.php');
require_once ('Oauth/Server.php');
class Player_OauthController extends Zenfox_Controller_Action
{
	public function init()
	{
		$contextSwitch = $this->_helper->getHelper('contextSwitch');
		$contextSwitch->addActionContext('post', 'json')
              		->initContext();
	}
	/*public static function urlencode_rfc3986($input) 
	{
  		if (is_array($input)) 
  		{
    		return array_map(array('OAuthUtil', 'urlencode_rfc3986'), $input);
  		} 
  		else if (is_scalar($input)) 
  		{
    		return str_replace('+',' ',str_replace('%7E', '~', rawurlencode($input)));
  		} 
  		else 
  		{
    		return '';
  		}
	}*/
	
	//Zenfox
	public function indexAction()
	{
		/*echo hash_hmac('sha1', "1234", "143168342410923", true);
		$encode = base64_encode(hash_hmac('sha1', "1234", "143168342410923", true));
		$decode = base64_decode($encode);
		echo $encode;
		echo $decode;*/
		/*$DATA= 'james' ;
		$KEY= 'moveme'; 
		$hash = base64_encode(hash_hmac("sha256", utf8_encode($DATA), utf8_encode($KEY), false)); 
		echo $hash; 
		exit();*/
		//Callback URL is the url to redirect after successfully authorizing
        $oauthOptions = array(
			'callbackUrl' => 'http://taashtime.tld/oauth/callback/',
			'clientId' => '98765',
		);
		
        $oauth2 = new Oauth2($oauthOptions);
        
		$oauth2->authorizationRedirect();
	}
	
	public function callbackAction()
	{
        $code = $this->getRequest()->getParam('code');
        $params = $this->getRequest()->getParam('param');
        Zenfox_Debug::dump($params, 'param');
        //Zenfox_Debug::dump(base64_decode($code), 'code');
        //if (!isset($myTokenSessionNamespace->token)) {

            if (!empty($code)) {

                $verificationCode = trim(addslashes(strip_tags($code)));

                $oauthOptions = array(
                            'callbackUrl' => 'http://taashtime.tld/oauth/callback/',
                            'clientId' => '98765',
                            'clientSecret' => 'abcd1234',
                        );

                $oauth2 = new Oauth2($oauthOptions);

                $oauth2->setVerificationCode($verificationCode);

                $accessToken = $oauth2->requestAccessToken();
                $accessToken = '12345';

                $accessTokenSess = new Zend_Session_Namespace('accessToken');
                $accessTokenSess->value = $accessToken;
                Zenfox_Debug::dump($accessToken, 'access_token');
                //exit;

                //$myTokenSessionNamespace->token = $acessToken;

            } else {

                Zend_Debug::dump('verification code not found');

            }

     //   }
	}
	
	//Indyarocks
	public function authorizeAction()
	{
		$requestUrl = $this->getRequest()->getParam('redirectUri');
		$requestUrl = explode(',', $requestUrl);
		$requestUrl = implode('/', $requestUrl);
		
		$clientIdSent = $this->getRequest()->getParam('clientId');
		
		$server = new Server();
		$clientIdStored = $server->getClientId();
		if($clientIdSent == $clientIdStored)
		{
			$code = null; //Or generate your own code algo.
			$server->setCode($code); //If null is passed, Server generates its own code in a default way
			$code = $server->getCode();
			//Params must be a comma seperated string
			$params['userId'] = 1;
			$params['name'] = 'nik';
		}
		else
		{
			//Code need not to be send. Can ignore the code parameter
			$code = NULL;
			$params['error'] = "Invalid Application Request";
		}
		$param = implode(',', $params);
		$this->_redirect($requestUrl . 'code/' . $code . '/param/' . $param);
	}
	
	public function accessAction()
	{
		Zend_Layout::getMvcInstance()->disableLayout();
		$server = new Server();
		$server->setCode(base64_decode($_POST['code']));
		$server->setSecretKey('abcd1234');
		$server->setHashKey();
		$code = $server->checkHashKey($_POST['hashKey']);
		if($code)
		{
			$accessToken = $server->getAccessToken();
		}
		echo $accessToken;
		print_r($_POST);
	}
	
	public function postAction()
	{
		Zend_Layout::getMvcInstance()->disableLayout();
		print_r($_POST['winner_data']);
		$accessTokenSess = new Zend_Session_Namespace('accessToken');
        //$accessToken = $accessTokenSess->value;
        /*$accessToken = '12345';
		$values['amount'] = 100;
		$values['game_id'] = 2;
		$values['friends_id'] = '5,6,7';
		$data['user_id'] = 1;
		$data['message_type'] = 'win';
		$data['values'] = $values;
		$jsonData = json_encode($data);*/
		//echo $jsonData;
		/*$oauth = new Oauth2();
		$oauth->pushData($accessToken, $jsonData);
		$this->view->winnerData = $_POST['winner_data'];*/
		//$this->view->winnerData = $data;
	}
}