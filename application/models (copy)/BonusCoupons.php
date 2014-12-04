<?php
class BonusCoupons extends BaseBonusCoupons
{
	public function getBonusCouponData($code, $playerId = NULL)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
					->from('BonusCoupons c')
					->where('c.coupon_code = ?', $code);
					
		if($playerId)
		{
			$query = $query->andWhere('c.player_id = ?', $playerId);
		}
					
		$result = $query->fetchArray();
		return $result;
	}
}