<?php
class Coupons
{
	public function update($code, $status, $couponData)
	{
		$redeemedTimes = $couponData['redeemed_times'];
		$remainingRedeems = $couponData['remaining_redeems'];
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
					->update('BonusCoupons c')
					->set('c.redeemed_times', '?', $redeemedTimes)
					->set('c.remaining_redeems', '?', $remainingRedeems)
					->set('c.status', '?', $status)
					->where('c.coupon_code = ?', $code);
					
		try
		{
			$query->execute();
		}
		catch(Exception $e)
		{
			return false;
		}
		return true;
	}
}