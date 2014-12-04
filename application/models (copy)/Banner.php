<?php
class Banner extends BaseBanner
{
	public function getBannerData($frontendId)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
				->from('Banner b')
				->where('b.frontend_id = ?', $frontendId);
				
		$result = $query->fetchArray();
		return $result;
	}
}