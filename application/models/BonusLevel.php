<?php
class BonusLevel extends BaseBonusLevel
{
	public function getAllLevelsData($schemeId)
	{
		$conn = Zenfox_Partition::getInstance()->getCommonConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
						->from('BonusLevel bl')
						->where('bl.scheme_id = ? ', $schemeId);
						
		$result = $query->fetchArray();
		$i = 0;
		$levelData = array();
		foreach($result as $data)
		{
			$levelData[$i]['levelId'] = $data['level_id'];
			$levelData[$i]['levelName'] = $data['level_name'];
			$levelData[$i]['minPoints'] = $data['min_points'];
			$levelData[$i]['maxPoints'] = $data['max_points'];
			$levelData[$i]['bonusPercent'] = $data['bonus_percentage'];
			$levelData[$i]['fixedBonus'] = $data['fixed_bonus'];
			$levelData[$i]['minDeposit'] = $data['min_deposit'];
			$levelData[$i]['minTotalDeposit'] = $data['min_total_deposit'];
			$levelData[$i]['rewardTimes'] = $data['reward_times'];
			$levelData[$i]['description'] = $data['description'];
			$levelData[$i]['fixedReal'] = $data['fixed_real'];
			$i++;
		}
		return $levelData;
	}
	
	public function getLevelData($levelId, $schemeId)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
						->from('BonusLevel bl')
						->where('bl.level_id = ?', $levelId)
						->andWhere('bl.scheme_id = ?', $schemeId);
						
		$result = $query->fetchArray();
		return $result;
	}
	
	public function getLevelId()
	{
		$conn = Zenfox_Partition::getInstance()->getCommonConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
						->select('bl.level_id')
						->from('BonusLevel bl')
						->orderBy('bl.scheme_id DESC, bl.level_id DESC')
						->limit(1);
						
		$result = $query->fetchArray();
		Zenfox_Debug::dump($result, 'levelId');
		return $result[0]['level_id'];
	}
	
	public function getAmount($schemeId, $levelId)
	{
		$conn = Zenfox_Partition::getInstance()->getCommonConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
						->select('bl.fixed_bonus, bl.fixed_real')
						->from('BonusLevel bl')
						->where('bl.scheme_id = ?', $schemeId)
						->andWhere('bl.level_id = ?', $levelId);
						
		try
		{
			$result = $query->fetchArray();
		}
		catch(Exception $e)
		{
			$filePath = '/home/zenfox/backup_player/error_logs.txt';
			$fh = fopen($filePath, 'a');
			fwrite($fh, "GETTING AMOUNT FROM SCHEME ID->" . $e);
			fclose($fh);
			return false;
		}
		
		$bonus = 0;
		$real = 0;
		if($result)
		{
			$bonus = $result[0]['fixed_bonus'];
			$real = $result[0]['fixed_real'];
		}
		return array(
			'bonus' => $bonus,
			'real' => $real
		);
	}
	
	public function getBonusPercentage($playerId)
	{
		$conn = Zenfox_Partition::getInstance()->getConnections($playerId);
		$currentConnection = Doctrine_Manager::getInstance()->getConnection($conn);
		
		$query = "select scheme_id, level_id, level_name, min_points, total_loyalty_points ,max_points, bonus_percentage, 
				bonus_release_percentage from bonus_levels, account_details where account_details.bonus_scheme_id = scheme_id and 
				account_details.total_loyalty_points between min_points and  max_points and account_details.player_id=" . $playerId;
		
		$loyaltyBonus = 0;
		$bonus2Cash = 0;
		$levelPercent = 0;
		
		try
		{
			$result = $currentConnection->prepare($query);
			$result->execute();
			$resultset = $result->fetchAll();
		}
		catch(Exception $e)
		{
			return array(
				'loyaltyBonus' => $loyaltyBonus,
				'bonus2Cash' => $bonus2Cash,
				'levelPercent' => $levelPercent
			);
		}
		if($resultset)
		{
			$totalLoyaltyPoints = floatval($resultset[0]['total_loyalty_points']);
			$minPoints = floatval($resultset[0]['min_points']);
			$maxPoints = floatval($resultset[0]['max_points']);
			$loyaltyBonus = $resultset[0]['bonus_percentage'];
			$bonus2Cash = floatval($resultset[0]['bonus_release_percentage']) * 100;
			$levelPercent = 0;
			if($totalLoyaltyPoints && $maxPoints)
			{
				$levelPercent = (($totalLoyaltyPoints-$minPoints) / ($maxPoints-$minPoints)) * 100;
			}
		}
		return array(
			'loyaltyBonus' => $loyaltyBonus,
			'bonus2Cash' => $bonus2Cash,
			'levelPercent' => $levelPercent
		);
	}
	
	public function getLevelIdByPoints($loyaltyPoints, $playerId, $schemeId)
	{
		$conn = Zenfox_Partition::getInstance()->getConnections($playerId);
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
					->from('BonusLevel bl')
					->where('bl.scheme_id = ?', $schemeId)
					->andWhere('bl.min_points <= ?', $loyaltyPoints)
					->andWhere('bl.max_points > ?', $loyaltyPoints)
					->andWhere('bl.min_points != ?', '-1');
		
		try
		{
			$result = $query->fetchArray();
		}
		catch(Exception $e)
		{
			return false;
		}
		return array(
			'id' => $result[0]['level_id'],
			'name' => $result[0]['level_name']
		);
	}
}