<?php
class Piwik_Log_Controller extends Piwik_Controller
{
	static private $instance = null;
	static public function getInstance()
	{
		if (self::$instance == null)
		{
			$c = __CLASS__;
			self::$instance = new $c();
		}
		return self::$instance;
	}

	public function logme($userLogin, $md5Password)
	{
		$login = $userLogin;
		$password = $md5Password;

		if(strlen($password) != 32)
		{
			throw new Exception("The password parameter is expected to be a MD5 hash of the password.");
		}

		if($login == Zend_Registry::get('config')->superuser->login)
		{
			throw new Exception("The Super User cannot be authenticated using this URL.");
		}

		//$objLogin = get
		$authenticated = $this->authenticate($login, $password);
		if($authenticated === false)
		{
			return false; //echo Piwik_Translate('Login_LoginPasswordNotCorrect');
		}
		return $authenticated;
	}

	protected function authenticate($login, $md5Password)
	{
		$tokenAuth = Piwik_UsersManager_API::getInstance()->getTokenAuth($login, $md5Password);

		$auth = Zend_Registry::get('auth');
		$auth->setLogin($login);
		$auth->setTokenAuth($tokenAuth);

		$authResult = $auth->authenticate();
		if(!$authResult->isValid())
		{
		return false;//return Piwik_Translate('Login_LoginPasswordNotCorrect');
		}

		$authCookieName = Zend_Registry::get('config')->General->login_cookie_name;
		$authCookieExpiry = time() + Zend_Registry::get('config')->General->login_cookie_expire;
		$authCookiePath = Zend_Registry::get('config')->General->login_cookie_path;
		$cookie = new Piwik_Cookie($authCookieName, $authCookieExpiry, $authCookiePath);
		$cookie->set('login', $login);
		//$cookie->set('token_auth', $authResult->getTokenAuth());
		$cookie->set('token_auth', $auth->getHashTokenAuth($login, $authResult->getTokenAuth()));
		$cookie->setSecure(Piwik::isHttps());
		$cookie->save();

		Piwik_Session::regenerateId();
		$authAdapter = Zend_Registry::get('auth');
		Zend_Registry::get('access')->reloadAccess($authAdapter);

		return $authResult->getTokenAuth();

		//Piwik_Url::redirectToUrl($urlToRedirect);
	}
}