<?php
class Affiliate_EarningsController extends Zenfox_Controller_Action
{
	public function summaryAction()
	{
		$storage = new Zenfox_Auth_Storage_Session();
		$session = $storage->read();
		$affiliateId = $session['id'];
		
		$earningsSummary = new EarningsSummary();
		$earnings = $earningsSummary->getAffiliateEarnings($affiliateId);
		//echo $earnings;
		
		$subAffiliateEarnings = $earningsSummary->getSubAffiliateEarnings($affiliateId);
		
		$totalSubEarnings = 0;
		
		foreach($subAffiliateEarnings as $subAffEarning)
		{
			$totalSubEarnings += $subAffEarning['earnings'];
		}
		$this->view->earnings = $earnings;
		$this->view->subAffiliateEarnings = $subAffiliateEarnings;
		$this->view->totalSubEarnings = $totalSubEarnings;
		//print_r($subAffiliateEarnings);
	}
}