<?php
require_once dirname(__FILE__).'/../forms/AffiliateTrackerForm.php';
require_once dirname(__FILE__).'/../forms/TrackerGenerationForm.php';
require_once dirname(__FILE__).'/../forms/EditTrackerForm.php';

class Admin_AffiliatetrackerController extends Zenfox_Controller_Action
{
	public function viewaffiliatesAction()
	{
		$affiliate = new Affiliate();
		$affiliates = $affiliate->getAffiliates();
		$this->view->affiliates = $affiliates;
		$affiliateTracker = new AffiliateTracker();
		$affiliateTrackers = $affiliateTracker->getAffiliateTrackers();
		$this->view->affiliateTrackers = $affiliateTrackers;
	}

	public function viewtrackerAction()
	{
		$request = $this->getRequest();
		$trackerId = $request->id;
		
		$affiliateTracker = new AffiliateTracker();
		$affiliateTrackerDetails = $affiliateTracker->getAffiliateTracker($trackerId);		
		//$this->view->affiliateTrackerDetails = $affiliateTrackerDetails;
		$trackerDetailInstance = new TrackerDetail();
		$trackerDetails = $trackerDetailInstance->getTrackerDetails($trackerId);
		$affiliate = new Affiliate();
		$alias = $affiliate->getAliasFromAffiliateId($affiliateTrackerDetails['affiliate_id']);		
		$affiliateScheme = new AffiliateScheme();
		$scheme = $affiliateScheme->getSchemeName($affiliateTrackerDetails['scheme_id']);
		$translate = Zend_Registry::get('Zend_Translate');
		$table[0][$translate->translate('Category')] = 'Tracker Type';
		$table[0][$translate->translate('Value')] = $affiliateTrackerDetails['tracker_type'];
		$table[1][$translate->translate('Category')] = 'Tracker Name';
		$table[1][$translate->translate('Value')] = $affiliateTrackerDetails['tracker_name'];
		$table[2][$translate->translate('Category')] = 'Affiliate Name';
		$table[2][$translate->translate('Value')] = $alias;
		$table[3][$translate->translate('Category')] = 'Scheme Name';
		$table[3][$translate->translate('Value')] = $scheme;
		$index = 4;		
	    foreach($trackerDetails as $data)
		{	
			$table[$index][$translate->translate('Category')] = $data['variable_name'];
			$table[$index][$translate->translate('Value')] = $data['variable_value'];
			
			$index++;
		}
		$this->view->contents = $table;
		$this->view->id = $affiliateTrackerDetails['tracker_id'];	
		$this->view->trackerDetails = $trackerDetails;
	}
	
	public function edittrackerAction()
	{
		$form = new Admin_EditTrackerForm();
		$request = $this->getRequest();
		$trackerId = $request->id;
		$affiliateTrackerInstance = new AffiliateTracker();
		$data = $affiliateTrackerInstance->getAffiliateTracker($trackerId);
		$trackerDetails = new TrackerDetail();
		$details = $trackerDetails->getTrackerDetails($trackerId);				
		$this->view->form = $form->setupForm($data,$details);
		
		if($request->isPost())
		{
			if($form->isValid($_POST))
			{
				$data = $form->getValues();
				$affiliateTrackerInstance->updateAffiliateTracker($trackerId,$data);
				echo 'Tracker is updated';
			}
		}
	}
	
	public function trackersummaryAction()
	{
		$request = $this->getRequest();
		$id = $request->id;
		$affiliateTracker = new AffiliateTracker();
		$affiliateTrackers = $affiliateTracker->getAffiliateTrackersByAffiliateId($id);
		$schemes = array();
		foreach($affiliateTrackers as $affiliateTracker)
		{
			$schemes[$affiliateTracker['scheme_id']][] = $affiliateTracker;
		}
		//$this->view->affiliateTrackers = $affiliateTrackers;
		$trackerDetailInstance = new TrackerDetail();
		$affiliateSchemes = array();
		foreach($schemes as $schemeId => $affiliateTrackers)
		{
			$trackers = array();
			$i = 0;
			foreach($affiliateTrackers as $affiliateTracker)
			{
				$trackerDetails = $trackerDetailInstance->getTrackerEarnings($affiliateTracker['tracker_id']);
				$trackers[$i]['tracker'] = $affiliateTracker;
				$trackers[$i]['trackerDetails'] = $trackerDetails;
				$i++;
			}
			$affiliateSchemes[$schemeId] = $trackers;
		}
		$this->view->affiliateSchemes = $affiliateSchemes;
		$this->view->affiliateId = $id;
	}
	
	public function trackerdetailsAction()
	{
		$request = $this->getRequest();
		$trackerId = $request->id;
		$trackerDetailInstance = new TrackerDetail();
		$trackerDetails = $trackerDetailInstance->getTrackerDetails($trackerId);
		$this->view->trackerDetails = $trackerDetails;
	}
	
	public function alltrackersAction()
	{
		$request = $this->getRequest();
		$id = $request->id;
		$affiliateTracker = new AffiliateTracker();
		$affiliateTrackers = $affiliateTracker->getAffiliateTrackersByAffiliateId($id);
		$this->view->affiliateTrackers = $affiliateTrackers;
		$trackerDetailInstance = new TrackerDetail();
		$trackers = array();
		$i = 0;
		foreach($affiliateTrackers as $affiliateTracker)
		{
			$trackerDetails = $trackerDetailInstance->getTrackerDetails($affiliateTracker['tracker_id']);
			$trackers[$i]['tracker'] = $affiliateTracker;
			$trackers[$i]['trackerDetails'] = $trackerDetails;
			$i++;
		}
		$this->view->trackers = $trackers;
	}
	
	public function createAction()
	{
		$request = $this->getRequest();
		$id = $request->id;
		$affiliateTracker = new AffiliateTracker();
		$trackerDetails = new TrackerDetail();		
		$scheme = new AffiliateScheme();
		$schemes = $scheme->getAffiliateSchemes();
		$affiliate = new Affiliate();
		$result = $affiliate->getAffiliate($id);				
		$affiliateFrontendId = $result['affiliateFrontendId'];		
		$affiliateFrontend = new AffiliateFrontend();
		$frontend = new Frontend();
		$frontends = $affiliateFrontend->getAffiliateFrontendById($affiliateFrontendId);
		$frontendIdArray = array();
		$frontendNameArray = array();
		$frontendIdArray = explode(',', $frontends['allowed_frontend_ids']);
		foreach($frontendIdArray as $frontendid)
		{
			$result = $frontend->getFrontendById($frontendid);
			$frontendNameArray[] = $result['name'];
		}		
		$form = new Admin_TrackerGenerationForm();
		$this->view->form = $form->setupForm($schemes,$frontendIdArray,$frontendNameArray);
		
		if($request->isPost())
		{
			if($form->isValid($_POST))
			{
				$data = $form->getValues();								
				$trackerId = $affiliateTracker->addAffiliateTracker($id,$data);
															
				$result1 = $trackerDetails->addTrackerDetails($trackerId,'URL',$data['url']);
				
				if($data['partner'])
				{
					$partnerArray = array();
					$partnerString = "";
					foreach($data['partner'] as $partner)
					{
						$partnerArray[] = $partner;
					}
					$partnerString = implode(",", $partnerArray);
					$trackerDetails = new TrackerDetail();
					$result2 = $trackerDetails->addTrackerDetails($trackerId,'PARTNERS',$partnerString);
				}
			}
		}
	}
	
}