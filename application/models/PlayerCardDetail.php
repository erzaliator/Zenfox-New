<?php
class PlayerCardDetail extends BasePlayerCardDetail
{
	public function getAllData($playerId, $paymentMethod)
	{
		$conn = Zenfox_Partition::getInstance()->getCommonConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
					->from('PlayerCardDetail p')
					->where('p.player_id = ?', $playerId)
					->andWhere('p.payment_method = ?', $paymentMethod);
					
		$result = $query->fetchArray();
		return $result;
	}
	
	public function insertData($playerId, $data)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		$playerCardDetail = new PlayerCardDetail();
		
		switch($data['paymentType'])
		{
			case 'CASH':
				$cardNo = $this->_getCardNo($playerId);
				if($cardNo)
				{
					$explodeCardNo = explode('-', $cardNo);
					$explodeCardNo[1]++;
					$newCardNo = implode('-', $explodeCardNo);
				}
				else
				{
					$newCardNo = 'GHARPAY-1';
				}
				$data['cvc'] = $newCardNo;
				break;
		}
		$playerCardDetail->player_id = $playerId;
		$playerCardDetail->card_no = $data['cvc'];
		$transId = $this->checkTransId($playerId, $data['cvc']);
		if(isset($transId))
		{
			return $transId;
		}
		if($data['paymentType'] != 'NETBANKING')
		{
			$playerCardDetail->card_holder_first_name = $data['firstName'];
			$playerCardDetail->card_holder_middle_name = $data['middleName'];
			$playerCardDetail->card_holder_last_name = $data['lastName'];
			$playerCardDetail->card_holder_address = $data['address'];
			$playerCardDetail->card_holder_city = $data['city'];
			$playerCardDetail->card_holder_zip = $data['zip'];
			$playerCardDetail->card_holder_country = $data['country'];
			$playerCardDetail->card_type = $data['cardType'];
			$playerCardDetail->card_expiry_year = $data['expYear'];
			$playerCardDetail->card_expiry_month = $data['expMonth'];
		}

		try
		{
			$playerCardDetail->save();
		}
		catch(Exception $e)
		{
			return array('message' => 'There is some problem in transaction. Please try again. If you still face the same problem again, contact to our customer support.');
		}
		
		//$conn = Zenfox_Partition::getInstance()->getConnections($playerId);
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
						->from('PlayerCardDetail pr')
						->where('pr.player_id = ?', $playerId)
						->orderBy('pr.id DESC')
						->limit(1);

		try
		{
			$result = $query->fetchArray();
		}
		catch(Exception $e)
		{
			return array('message' => 'There is some problem in transaction. Please try again. If you still face the same problem again, contact to our customer support.');
		}
		//Zenfox_Debug::dump($result, 'result');
		return $result[0]['id'];
	}
	
	public function checkTransId($playerId, $cardNo)
	{
		//We don't need to change connection. Check in the master.
		$query = Zenfox_Query::create()
					->from('PlayerCardDetail p')
					->where('p.player_id = ?', $playerId)
					->andWhere('p.card_no = ?', $cardNo);
					
		$result = $query->fetchArray();
		if($result)
		{
			return $result[0]['id'];
		}
		return NULL;
	}
	
	public function getDataById($id)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
					->from('PlayerCardDetail pr')
					->where('pr.id = ?', $id);
					
		try
		{
			$result = $query->fetchArray();
		}
		catch(Exception $e)
		{
			return false;
		}
		return $result;
	}
	
	private function _getCardNo($playerId)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
						->select('pcd.card_no')
						->from('PlayerCardDetail pcd')
						->where('pcd.player_id = ?', $playerId)
						->orderBy('pcd.id desc')
						->limit(1);
		
		$result = $query->fetchArray();
		if($result)
		{
			return $result[0]['card_no'];
		}
		return NULL;
	}
}