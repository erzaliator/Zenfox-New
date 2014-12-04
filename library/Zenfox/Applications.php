<?php
abstract class Zenfox_Applications
{
	public function __construct()
	{
		
	}
	
	public function registerPlayer($userData)
	{
		$login = $userData['login'];
		$firstName = $userData['firstName'];
		$lastName = $userData['lastName'];
		$email = $userData['email'];
		$dateOfBirth = $userData['dateOfBirth'];
		
		$player = new Player();
		$authDetails = array();
		$newUser = false;
		if($player->validateLogin("$login"))
		{
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
		
		$lastLogin = $playerData[0]['last_login'];
		
		$currentLogin = Zend_Date::now();
		$lastLogin = new Zend_Date($lastLogin);
		
		$currentTime = Zend_Date::now();
		$prevDay = $currentTime->sub(1, Zend_Date::DAY);
		
		$diff = $prevDay->compare($lastLogin, Zend_Date::DAY);
		if($diff >= 0)
		{
			$accountVariable = new AccountVariable();
			$data['variableName'] = 'freeMoney';
			$accountVariableData = $accountVariable->getData($playerId, $data['variableName']);
	
			$varId = $accountVariableData['varId'];
			$data['varId'] = $varId;
			$data['variableValue'] = floatval($accountVariableData['varValue']) + 500;
			$accountVariable->insert($data);
		}
	}
	
	abstract public function setUserData();
} 