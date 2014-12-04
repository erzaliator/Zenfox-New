<?php
class EarningsSummary
{
	public function getAffiliateEarnings($affiliateId)
	{
		$trackerDetail = new TrackerDetail();
		$affiliateTrackerInstance = new AffiliateTracker();
		$trackers = $affiliateTrackerInstance->getAffiliateTrackersByAffiliateId($affiliateId);
		$earnings = 0;
		foreach($trackers as $tracker)
		{
			$detail = $trackerDetail->getTrackerEarnings($tracker['tracker_id']);
			$earnings += $detail;
		}
		return $earnings;
	}
	
	public function getSubAffiliateEarnings($affiliateId)
	{
		$affiliateInstance = new Affiliate();
		$subAffiliates = $affiliateInstance->getAllSubAffiliates($affiliateId);
		
		$totalSubEarnings = 0;
		
		$subAffiliateEarnings = array();
		$i = 0;
		foreach($subAffiliates as $subAffiliate)
		{
			$trackerDetail = new TrackerDetail();
			$affiliateTrackerInstance = new AffiliateTracker();
			$trackers = $affiliateTrackerInstance->getAffiliateTrackersByAffiliateId($subAffiliate['affiliate_id']);
			$earnings = 0;
			foreach($trackers as $tracker)
			{
				$detail = $trackerDetail->getTrackerEarnings($tracker['tracker_id']);
				$earnings += $detail;
			}
			$subAffiliateEarnings[$i]['alias'] = $affiliateInstance->getAliasFromAffiliateId($subAffiliate['affiliate_id']);
			$subAffiliateEarnings[$i]['earnings'] = $earnings;
			$i++;
		}
		
		return $subAffiliateEarnings;
	}
}