<?php
class LoyaltyFactor extends BaseLoyaltyFactor
{
	public function getLoyaltyData($schemeId)
	{
		$conn = Zenfox_Partition::getInstance()->getCommonConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
						->from('LoyaltyFactor lf')
						->where('lf.scheme_id = ?', $schemeId);
						
		$result = $query->fetchArray();
		$i = 0;
		$loyaltyData = array();
		foreach($result as $data)
		{
			$loyaltyData[$i]['loyaltyFactorId'] = $data['id'];
			$loyaltyData[$i]['levelId'] = $data['level_id'];
			$loyaltyData[$i]['gameGroupId'] = $data['gamegroup_id'];
			$loyaltyData[$i]['wagerFactor'] = $data['wager_factor'];
			$loyaltyData[$i]['loyaltyPerD'] = $data['loyalty_per_dollar'];
			$i++;
		}
		return $loyaltyData;
	}
}