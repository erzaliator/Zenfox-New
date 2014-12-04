<?php
class Mobile
{
	public function authenticateUser($email, $frontendId)
	{
		$accountData = $this->_checkPlayerExist($email, $frontendId);
		$newUser = false;
		
		if(!$accountData)
		{
			$explodeEmail = explode("@", $email);
			$firstName = $explodeEmail[0];
			
			$playerData['login'] = $email;
			$playerData['password'] = md5($email);//$uid . $user->birthday;
			$playerData['email'] = $email;
			$playerData['firstName'] = $firstName;
			$playerData['frontendId'] = $frontendId;
			$playerData['trackerId'] = 0;
			$playerData['lastName'] = "";
			$playerData['sex'] = "";
			$playerData['dateOfBirth'] = "";
			$playerData['address'] = "";
			$playerData['city'] = "";
			$playerData['state'] = "";
			$playerData['country'] = "";
			$playerData['pin'] = "";
			$playerData['phone'] = "";
			$playerData['promotions'] = "";
			$playerData['buddyId'] = "";
			$playerData['bonusAble'] = "";
			$playerData['newsletter'] = "";
			$playerData['code'] = "";
			
			$this->_registerPlayer($playerData);
			
			$accountData = $this->_checkPlayerExist($email, $frontendId);
			
			$newUser = true;
		}

		$playerId = $accountData[0]['player_id'];
		
		$authData = false;
		
		if($playerId)
		{
			$authSession = new Zenfox_Auth_Storage_Session();
			$authSession->write(array(
				'id' => $playerId,
				'roleName' => 'player',
				'lastlogin' => $accountData[0]["last_login"],
				'authDetails' => $accountData));
				
				
			$session = $authSession->read();
			
			$playerSession = new PlayerSession($playerId);
			$playerSession->storeInformation();
				
			if($newUser)
			{
				$registration = new Registration();
				$registration->joiningBonus($playerData['login'], $playerId, $frontendId);
			}
				
			$currency = new Zend_Currency();
			$imageName = md5("image" . $playerId) . '.jpg';
			$loginName = $session['authDetails'][0]['login'];
			$firstName = $session['authDetails'][0]['first_name'];
			
			$balance = $sessionData['authDetails'][0]['balance'];
			$cash = $sessionData['authDetails'][0]['cash'];
			$bonus = $sessionData['authDetails'][0]['bonus_bank'] + $sessionData['authDetails'][0]['bonus_winnings'];
			$buddyBonus = $sessionData['authDetails'][0]['buddy_earnings'];
			
				
			$loyaltyPoints = $session['authDetails'][0]['loyalty_points_left'];
			$currencySession = new Zend_Session_Namespace('currency');
			$source = $currency->getShortName('', $currencySession->oldValue);
			$destination = $currency->getShortName('', $currencySession->newValue);
			$currConv = new CurrencyConversion();
			
			$cash = $currConv->getConvertedValue($source, $destination, $cash);
			$bonus = $currConv->getConvertedValue($source, $destination, $bonus);
			$balance = $currConv->getConvertedValue($source, $destination, $balance);
			$buddyBonus = $currConv->getConvertedValue($source, $destination, $buddyBonus);
			
			$imagePath = APPLICATION_PATH . "/../public/images/profiles/" . $imageName;
			if(!file_exists($imagePath))
			{
				$imagePath = "/images/profiles/profile-m1.jpg";
			}
			else
			{
				$imagePath = "/images/profiles/" . $imageName;
			}
			$freeChips = 0;
			$accountVariable = new AccountVariable();
			$varData = $accountVariable->getData($playerId, 'freeMoney');
			if($varData)
			{
				$freeChips = round($varData['varValue'], 2);
			}
			$name = empty($firstName)?$loginName:$firstName;
			
			$authData['user_name'] = $name;
			$authData['balance'] = $balance;
			$authData['cash'] = $cash;
			$authData['bonus'] = $bonus;
			$authData['buddy_earnings'] = $buddyBonus;
			$authData['loyalty_points'] = $loyaltyPoints;
			$authData['image_path'] = $imagePath;
			$authData['free_chips'] = $freeChips;
		}
			
		return $authData;
	}
	
	private function _checkPlayerExist($email, $frontendId)
	{
		$connections = Zenfox_Partition::getInstance()->getConnections(-1);
		foreach($connections as $connection)
		{
			Doctrine_Manager::getInstance()->setCurrentConnection($connection);
			
			$query = Zenfox_Query::create()
						->from('AccountDetail a')
						->where('a.email = ?', $email)
						->andWhere('a.frontend_id = ?', $frontendId);
			
			try
			{
				$result = $query->fetchArray();
			}
			catch(Exception $e)
			{
				Zenfox_Debug::dump($e, 'exceptions', true, true);
			}
			
			if($result)
			{
				return $result;
			}
		}
		
		return false;
	}
	
	private function _registerPlayer($playerData)
	{
		$player = new Player();
		$player->registerPlayer($playerData);
	}
	
	private function _addFunCoins($playerId)
	{
		$registration = new Registration();
		$registration->joiningBonus($playerData['login']);
	}
}