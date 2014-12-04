<?php
class AccountUnconfirm extends BaseAccountUnconfirm
{
	public function getPlayerData($code)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		try
		{
			$query = Zenfox_Query::create()
						->from('AccountUnconfirm au')
						->where('au.code = ?', $code);
			
			$result = $query->fetchArray();
			//$result = Doctrine::getTable('AccountUnconfirm')->findOneByCode($code);
		}
		catch(Exception $e)
		{
			$filePath = '/home/zenfox/backup_player/error_logs.txt';
			$fh = fopen($filePath, 'a');
			fwrite($fh, "GETTING PLAYER DATA FROM ACCOUNT UNCONFIRM->" . $e);
			fclose($fh);
			return false;
		}
		if($result)
		{
			//$result = $result->toArray();
			return array(
					'playerId' => $result[0]['player_id'],
	    			'login' => $result[0]['login'],
	    			'firstName' => $result[0]['first_name'],
	    			'lastName' => $result[0]['last_name'],
	    			'email' => $result[0]['email'],
	    			'sex' => $result[0]['sex'],
	    			'dateOfBirth' => $result[0]['dateofbirth'],
	    			'address' => $result[0]['address'],
	    			'city' => $result[0]['city'],
	    			'state' => $result[0]['state'],
	    			'country' => $result[0]['country'],
	    			'pin' => $result[0]['pin'],
	    			'phone' => $result[0]['phone'],
	    			'securityQuestion' => $result[0]['question'],
	    			'hint' => $result[0]['hint'],
	    			'securityAnswer' => $result[0]['answer'],
	    			'newsletter' => $result[0]['newsletter'],
	    			'promotions' => $result[0]['promotions'],
					'code' => $result[0]['code'],
					'expiryTime' => $result[0]['expiry_time'],
					'confirmation' => $result[0]['confirmation'],
					'password' => $result[0]['password'],
					'trackerId' => $result[0]['tracker_id'],
					'buddyId' => $result[0]['buddy_id'],
					'frontendId' => $result[0]['frontend_id'],
					'created' => $result[0]['created'],
					'lastAccessedAddress' => $result[0]['last_accessed_address'],
					'bonusAble' => $result[0]['bonusable']
			);
		}
		return false;
	}
	
	public function getAccountDetail($playerId)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		$partition = Doctrine_Manager::getInstance()->setCurrentConnection($conn);
	
        $query = Zenfox_Query::create()
        				
                        ->from('AccountUnconfirm a')
                        ->where('a.player_id = ?', $playerId);

        try
        {
        	$result = $query->fetchArray();
        }
        catch(Exception $e)
        {
        	return;
        }
    //    Zenfox_Debug::dump($result, 'timezone', true, true);
        return $result;
		
	}
	
	
	public function getcodeDetail($playerentry,$value)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		$partition = Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		
		if($playerentry == "player_id")
		{
			//echo "in player id place";
			$query = Zenfox_Query::create()
					->select('a.code,a.confirmation,a.login,a.email,a.player_id')
					->from('AccountUnconfirm a')
					->where('a.player_id = ?', $value);
			try
			{
				$result = $query->fetchArray();
			}
			catch(Exception $e)
			{
				return;
			}
			//    Zenfox_Debug::dump($result, 'timezone', true, true);
			return $result;
		}
		elseif ($playerentry == "login")
		{
			//echo "in login place";
			$query = Zenfox_Query::create()
			->select('a.code,a.confirmation,a.login,a.email,a.player_id')
			->from('AccountUnconfirm a')
			->where('a.login = ?', $value);
			try
			{
				$result = $query->fetchArray();
			}
			catch(Exception $e)
			{
				return;
			}
			//    Zenfox_Debug::dump($result, 'timezone', true, true);
			return $result;
		}
		elseif($playerentry == "email")
		{
			//echo "in email place";
				$query = Zenfox_Query::create()
				->select('a.code,a.confirmation,a.login,a.email,a.player_id')
				->from('AccountUnconfirm a')
				->where('a.email = ?', $value);
				
				try
				{
					$result = $query->fetchArray();
				}
				catch(Exception $e)
				{
					return;
				}
				//    Zenfox_Debug::dump($result, 'timezone', true, true);
				return $result;
				
		}
		else 
		{
			//echo "in empty place";
					$query = Zenfox_Query::create()
						->select('a.code,a.confirmation,a.login,a.email,a.player_id')
						->from('AccountUnconfirm a');
						//->limit(5);
				
				try
				{
					$result = $query->fetchArray();
				}
				catch(Exception $e)
				{
					return;
				}
				//    Zenfox_Debug::dump($result, 'timezone', true, true);
				return $result;
		
		}
			
		
	
		try
		{
			$result = $query->fetchArray();
		}
		catch(Exception $e)
		{
			return;
		}
		//    Zenfox_Debug::dump($result, 'timezone', true, true);
		return $result;
	
	}
	
	/*public function getPlayerId($code)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
						->select('a.player_id')
						->from('AccountUnconfirm a')
						->where('a.code = ?', $code);

		print "Code:: $code";

		$result = $query->fetchArray();
		$playerId = $result[0]['player_id'];
		
		return $playerId;
	}*/
	
	public function getUserName($playerId)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
						->select('a.login')
						->from('AccountUnconfirm a')
						->where('a.player_id = ?', $playerId);
						
		$result = $query->fetchArray();
		$userName = $result[0]['login'];
		
		return $userName;
	}
	
	public function getAllPlayers()
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
					->select('a.player_id')
					->from('AccountUnconfirm a');
					
		$result = $query->fetchArray();
		foreach($result as $data)
		{
			foreach($data as $playerId)
			{
				Zenfox_Debug::dump($playerId, 'result');
			}
		}
	}
}
