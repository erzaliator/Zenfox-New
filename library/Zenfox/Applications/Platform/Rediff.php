<?php
class Zenfox_Applications_Platform_Rediff extends Zenfox_Applications
{
	private $_userData;
	private $_userId;
	
	public function __construct($userId)
	{
		$this->_userId = $userId;
	}
	
	public function setUserData()
	{
		/*$headers = array();
		foreach($_SERVER as $key => $value)
		{
			if(strpos($key, 'HTTP_X') === 0)
			{
				$headers[str_replace(' ', '-', str_replace('_', ' ', strtolower(substr($key, 5))))] = $value;
			}
		}
		$userid = $headers['x-redf-uid'];*/
		$userid = $this->_userId;
		$baseurl = "http://www.rediffapi.com/profile/$userid?version=2";
		
		$curl = curl_init();
		$authkey = '4a35e13701f64dc354e3a8c68d73fc58d58dd2dd';
		$referer = 'http://rediff.taashtime.com/rediff';//Callback URL
		$headers = array(
			"Connection: Close",
			"X-REDF-UID:".$userid,
			"X-REDF-AUTHKEY:".$authkey,
			"X-REDF-REFERER:".$referer,
		);
		
		curl_setopt($curl, CURLOPT_URL, $baseurl);
		curl_setopt($curl, CURLOPT_HEADER, 0);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($curl, CURLOPT_VERBOSE, 1);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, false);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		
		$result = curl_exec($curl);
		$userinfo = simplexml_load_string(trim(stripslashes($result)));

//		Zenfox_Debug::dump($userinfo, 'info');
		
		$playerData['login'] = "Rediff-" . $userid;
		$playerData['firstName'] = $userinfo->user->firstname;
		$playerData['lastName'] = $userinfo->user->lastname;
		$playerData['city'] = $userinfo->user->location->city;
		$playerData['country'] = $userinfo->user->location->country;
//		Zenfox_Debug::dump($playerData, 'data', true, true);
		if(!isset($userinfo->user->firstname))
		{
			$playerData['firstName'] = $userinfo->user->fname;
		}
		if(!isset($userinfo->user->lastname))
		{
			$playerData['lastName'] = $userinfo->user->lname;
		}
		$playerData['email'] = $playerData['firstName'] . $userid . '@rediff.com';
		$playerData['dateOfBirth'] = '0000:00:00';
		
		$this->_userData = $playerData;
		$this->__register();
		return array(
			'success' => true
		);
		/*$city = $userinfo->user->location->city;
		$country = $userinfo->user->location->country;*/	
	}
	
	private function __register()
	{
		parent::registerPlayer($this->_userData);
	}
}