<?php
class Affiliate_SchemeController extends Zenfox_Controller_Action
{
	public function detailsAction()
	{
		$schemeId = $this->getRequest()->schemeId;
		$affiliateScheme = new AffiliateScheme();
		$schemeName = $affiliateScheme->getSchemeName($schemeId);
		$schemeDef = new AffiliateSchemeDef();
		$schemeDefData = $schemeDef->getAffiliateSchemeDef($schemeId);
		//Zenfox_Debug::dump($schemeDefData, 'data');
		$this->view->contents = $schemeDefData;
		$this->view->schemeName = $schemeName;
	}
	
	public function productAction()
	{
		
	}
	
	public function paymentplansAction()
	{
		
	}
}