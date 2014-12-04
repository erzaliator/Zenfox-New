<?php
require_once(dirname(__FILE__) . '/generated/BasePasswordRecovery.php');
class PasswordRecovery extends BasePasswordRecovery
{
	public function insertData($data)
	{
		$frontendId = Zend_Registry::get('frontendId');
		
		$playerData = $this->getPlayerData($data['userId'], $data['userType']);
		$today = new Zend_Date();
		$currentTime = $today->get(Zend_Date::W3C);
		$expiryTime = date("Y-m-d H:i:s", strtotime("$currentTime, +15 DAYS"));
		if($playerData)
		{
			if($playerData['status'] != 'UNPROCESSED')
			{
				$data['expiryTime'] = $expiryTime;
				$data['created'] = $currentTime;
				$this->updateData($data);
			}
			return $playerData['code'];
		}
		else
		{
			$randomNo = rand(1, 100000);	
			$code = md5($data['login'] . $currentTime . $randomNo);
			$this->user_id = $data['userId'];
			$this->user_type = $data['userType'];
			$this->email = $data['email'];
			$this->code = $code;
			$this->expiry_time = $expiryTime;
			$this->created = $currentTime;
			$this->frontend_id = $frontendId;
			
			try
			{
				$this->save();
			}
			catch(Exception $e)
			{
				//print $e; exit();
				return false;
			}
		}
		return $code;
	}

	public function getcodeDetail($entrytype , $data , $usertype)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		//echo "in modelsssss";
		
		
		
		if($entrytype == "user_id")
		{
			$query = Zenfox_Query::create()
						->select('pr.*')
						->from('PasswordRecovery pr')
						->where('pr.user_id = ?', $data)
						->andwhere('pr.user_type = ?' , $usertype);
		} 	
		else 
		{
			$query = Zenfox_Query::create()
						->select('pr.*')
						->from('PasswordRecovery pr')
						->where('pr.email = ?', $data)
						->andwhere('pr.user_type = ?' , $usertype);
		}
		
					
					
			
		
		
		$results = $query->fetchArray();
		//print_r($results);
		return $results;
		//exit();
	}
	
	public function updateData($data)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$frontendId = Zend_Registry::get('frontendId');
		
		$query = Zenfox_Query::create()
					->update('PasswordRecovery pr')
					->set('pr.expiry_time', '?', $data['expiryTime'])
					->set('pr.created', '?', $data['created'])
					->set('pr.status', '?', 'UNPROCESSED')
					->where('pr.user_id = ?', $data['userId'])
					->andWhere('pr.user_type = ?', $data['userType'])
					->andWhere('pr.frontend_id = ?', $frontendId);
					
		$query->execute();
	}
	
	public function getPlayerId($code)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
					->from('PasswordRecovery pr')
					->where('pr.code = ?', $code);

		try
		{
			$result = $query->fetchArray();
		}
		catch(Exception $e)
		{
			return false;
		}
		return $result[0]['user_id'];
	}
	
	public function getPlayerData($userId, $userType)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$frontendId = Zend_Registry::get('frontendId');
		
		$query = Zenfox_Query::create()
						->from('PasswordRecovery pr')
						->where('pr.user_id = ?', $userId)
						->andWhere('pr.user_type = ?', $userType)
						->andWhere('pr.frontend_id = ?', $frontendId);
						
		try
		{
			$result = $query->fetchArray();
		}
		catch(Exception $e)
		{
			return false;
		}
		if($result)
		{
			return array(
					'code' => $result[0]['code'],
					'status' => $result[0]['status'],
					'email' => $result[0]['email'],
				);
		}
		return NULL;
	}

	public function updateStatus($userId, $userType)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$frontendId = Zend_Registry::get('frontendId');
		
		$query = Zenfox_Query::create()
					->update('PasswordRecovery pr')
					->set('pr.status', '?', 'PROCESSED')
					->where('pr.user_id = ?', $userId)
					->andWhere('pr.user_type = ?', $userType)
					->andWhere('pr.frontend_id = ?', $frontendId);
					
		$query->execute();
	}
}
