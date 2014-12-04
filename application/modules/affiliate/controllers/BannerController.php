<?php
require_once dirname(__FILE__).'/../forms/AffiliateTrackerForm.php';

class Affiliate_BannerController extends Zenfox_Controller_Action
{
	public function indexAction()
	{
		$session = new Zenfox_Auth_Storage_Session();
		$storage = $session->read();
		$affiliateId = $storage['id'];
		
		$frontend = new Frontend();
		$ids = explode(',', $storage['allowed_frontend_ids']);
		$allFrontendsData = $frontend->getFrontendById($ids);
		$banner = new Banner();
		foreach($allFrontendsData as $frontendData)
		{
			$bannerData[] = $banner->getBannerData($frontendData['id']);
		}
		
		$this->view->allBanners = $bannerData;
		//$form = new Affiliate_AffiliateTrackerForm();
		//$this->view->form = $form->getBannerForm();
		//$this->view->form = $form->chooseBannerForm();
		if($this->getRequest()->isPost())
		{
			$explodePostValue = explode(':', $_POST['banner']);
			$bannerUrl = $explodePostValue[0];
			$bannerWidth = $explodePostValue[1];
			$bannerHeight = $explodePostValue[2];
			$bannerFrontend = $explodePostValue[3];
			$landingPage = $explodePostValue[4];
			$explodeLandingPage = explode('-', $landingPage);
			$controller = $explodeLandingPage[1];
			$action = $explodeLandingPage[2];
			
			$affiliateTracker = new AffiliateTracker();
			$affiliateTrackerData = $affiliateTracker->getAffiliateTrackersByAffiliateId($affiliateId);
			foreach($affiliateTrackerData as $trackerData)
			{
				$trackerDetail = new TrackerDetail();
				$varName = 'FRONTEND_' . $bannerFrontend . '_URL';
				$varValue = $trackerDetail->getVariableValue($trackerData['tracker_id'], $varName);
				if($trackerData['tracker_id'] < 10)
				{
					$varValue = substr($varValue, 0, -12);
				}
				if(($trackerData['tracker_id'] >=10) && ($trackerData['tracker_id'] < 100))
				{
					$varValue = substr($varValue, 0, -13);
				}
				if($varValue)
				{
					$trackerUrls[] = $varValue . '/' . $controller . '/' . $action . '/trackerId/' . $trackerData['tracker_id'];
					$bannerUrls[] = $varValue . $bannerUrl;
				}
			}
			
			$this->view->bannerUrls = $bannerUrls;
			$this->view->bannerWidth = $bannerWidth;
			$this->view->bannerHeight = $bannerHeight;
			$this->view->bannerFrontend = $bannerFrontend;
			$this->view->landingPage = $landingPage;
			$this->view->trackerUrls = $trackerUrls;
			
			/* if($form->isValid($_POST))
			{
				$data = $form->getValues();
				$banner = new Banner();
				$bannerData = $banner->getBannerData($data['frontendId']);
				$trackerDetail = new TrackerDetail();
				$varName = 'FRONTEND_' . $data['frontendId'] . '_URL';
				$varValue = $trackerDetail->getVariableValue($data['trackerId'], $varName);
				if($data['trackerId'] < 10)
				{
					$varValue = substr($varValue, 0, -12);
				}
				if(($data['trackerId'] >=10) && ($data['trackerId'] < 100))
				{
					$varValue = substr($varValue, 0, -13);
				}
				$trackerUrl = $varValue . '/index/index/trackerId/' . $data['trackerId'];
				$this->view->banners = $bannerData;
				$this->view->trackerUrl = $trackerUrl;
				$this->view->varValue = $varValue;
				$this->view->trackerId = $data['trackerId']; */
				//$this->view->form = '';
			//}
		}
	}
}