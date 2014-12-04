<?php
require_once dirname(__FILE__).'/../forms/AffiliateTrackerForm.php';

class Affiliate_TrackerController extends Zenfox_Controller_Action
{
	private $_storage;
	private $_isPiwikEnabled;
	public function init()
	{
		parent::init();
		$session = new Zenfox_Auth_Storage_Session();
		$this->_storage = $session->read();
		//print_r($this->_storage);
		$loginName = $this->_storage['authDetails'][0]['alias'];
		$md5Password = md5($this->_storage['authDetails'][0]['passwd']);
		$this->_isPiwikEnabled = Zend_Registry::getInstance()->get('piwikEnabled');
		if($this->_isPiwikEnabled)
		{
			$request = new Piwik_Log_Controller();
			$request->logme($loginName, $md5Password);
		}
		$contextSwitch = $this->_helper->getHelper('contextSwitch');
		$contextSwitch->addActionContext('graph', 'json')
					  ->addActionContext('uniquevisitors', 'json') 
					  ->addActionContext('visitors', 'json') 
		
              		->initContext();
	}
	public function createAction()
	{
		//Zenfox_Debug::dump($this->_storage, 'store');
		$affiliateId = $this->_storage['id'];
		$request = $this->getRequest();
		$form = new Affiliate_AffiliateTrackerForm();
		$form = $form->getForm();
		$this->view->form = $form;
		if($request->isPost())
		{
			if($form->isValid($_POST))
			{
				$data = $form->getValues();
				$data['schemeId'] = $this->_storage['default_scheme_id'];
				$affiliateTracker = new AffiliateTracker();
				$trackerId = $affiliateTracker->addAffiliateTracker($affiliateId,$data);
				//$trackerId = 4;
				if($this->_isPiwikEnabled)
				{
					$manager = new Piwik_Site_Controller();
					$user = new Piwik_User_Controller();
					$goal = new Goal();
					$goals = array('Registrations', 'No Of Depositors');
				}
				$login = $this->_storage['authDetails'][0]['alias'];
				$frontend = new Frontend();
				$ids = explode(',', $this->_storage['allowed_frontend_ids']);
				$allFrontendsData = $frontend->getFrontendById($ids);
				$frontendId = Zend_Registry::get('frontendId');
				$affiliateFrontend = new AffiliateFrontend();
				$affiliateFrontendData = $affiliateFrontend->getAffiliateFrontendById($frontendId);
				$currency = $affiliateFrontendData['default_currency'];
				foreach($allFrontendsData as $frontendData)
				{
					$siteName = 'Tracker-' . $trackerId . '-F' . $frontendData['id'];
					$url = $frontendData['url'] . '/trackerId/' . $trackerId;
					// Set the default currency for the site
					//$manager->setDefaultCurrency(isset($this->_storage['authDetails'][0]['affiliate_base_currency'])?$this->_storage['authDetails'][0]['affiliate_base_currency']:'USD');
					//print $manager->getDefaultCurrency();exit();
					$timeZone = $this->_storage['authDetails'][0]['timezone'];
					if(!$timeZone)
					{
						$timeZone = $affiliateFrontendData['timezone'];
						if(!$timeZone)
						{
							$timeZone = Zend_Registry::get('userTimeZone');
						}
					}
					/*Zenfox_Debug::dump($currency, 'currency');
					Zenfox_Debug::dump($timeZone, 'timezone', true, true);*/
					if($this->_isPiwikEnabled)
					{
						$idSite = $manager->addSite($siteName, $url, $timeZone, $currency);
						$user->setUserAccess($login, 'admin', $idSite);
						$goal->createGoals($goals, $idSite);
						
						$trackerDetail = new TrackerDetail();
						$varName = 'FRONTEND_' . $frontendData['id'] . '_IDSITE';
						$varValue = $idSite;
						$trackerDetail->addTrackerDetails($trackerId, $varName, $varValue);
					}
		        	$trackerDetail = new TrackerDetail();
		        	$varName = 'FRONTEND_' . $frontendData['id'] . '_URL';
		        	$varValue = $url;
		        	$trackerDetail->addTrackerDetails($trackerId, $varName, $varValue);
		        	$trackerDetail = new TrackerDetail();
		        	$varName = 'EARNINGS_FRONTEND_' . $frontendData['id'];
		        	$varValue = 0;
		        	$trackerDetail->addTrackerDetails($trackerId, $varName, $varValue);
		        	$trackerDetail = new TrackerDetail();
		        	$varName = 'ACQUISTIONS_FRONTEND_' . $frontendData['id'];
		        	$varValue = 0;
		        	$trackerDetail->addTrackerDetails($trackerId, $varName, $varValue);
				}
				
				$trackerDetail = new TrackerDetail();
				$varName = 'EARNINGS';
				$varValue = 0;
				$trackerDetail->addTrackerDetails($trackerId, $varName, $varValue);
				
				$this->view->form = '';
				$this->_helper->FlashMessenger(array('notice' => $this->view->translate("Tracker is added")));
				$this->_redirect('/banner/index');
			}
		}
	}
	
	public function graphAction()
	{
		/*$reportType = '';
		$track = new Track();
		$trackRecords = $track->getRecords(2, 1, $reportType);*/
		$series = array(
						array('2008-06-30 8:00AM',2),
						array('2008-07-1 8:00AM',4),
						array('2008-07-2 8:00AM',0),
						array('2008-07-3 8:00AM',0),
						array('2008-07-4 8:00AM',3),
						array('2008-07-5 8:00AM',7));
		$this->view->series = $series;
		
		
	}
	
	public function uniquevisitorsAction()
	{
		$trackId = $this->getRequest()->trackId;
		
		if($trackId != null)
		{
		$reportType = '';
		$track = new Track();
		$trackRecords = $track->getRecords($trackId, 1, $reportType, 1);
		return $this->view->series = $trackRecords; 
		}
		
		if($trackId == null)
		{
		$id = $this->_storage['id'];
		$reportType = '';
		$track = new Track();
		$trackRecords = $track->getTotalAffiliateVisits($id , 1, 1);
		return $this->view->series = $trackRecords; 
		}
	}
	
	public function visitorsAction()  /*Gives the total visitors from an affiliate*/
	{
		$trackId = $this->getRequest()->trackId;
		
		if($trackId != null)
		{
		$reportType = '';
		$track = new Track();
		$trackRecords = $track->getRecords($trackId, 1, $reportType, 0);
		return $this->view->series = $trackRecords; 
		}
		
		if($trackId == null)
		{
		$id = $this->_storage['id'];
		$track = new Track();
		$trackRecords = $track->getTotalAffiliateVisits($id , 1, 0);
		return $this->view->series = $trackRecords; 
		}
	}
	
	
	
	public function viewAction()
	{		
		
		
		//Zenfox_Debug::dump('gff', 'schemes', true, true);
		$id = $this->_storage['id'];
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
		//Zenfox_Debug::dump($affiliateSchemes, 'schemes', true, true);
		
		$finalData = array();
		$i = 0;
		/*$siteManager = new Piwik_Site_Controller();
		$request = new Piwik_VisitsSummary_API();
		$goals = new Piwik_Goals_API();*/
		$frontend = new Frontend();
		$ids = explode(',', $this->_storage['allowed_frontend_ids']);
		$allFrontendsData = $frontend->getFrontendById($ids);
		/*$date = Zend_Date::now();
		$today = $date->toString('Y-M-d');*/
		foreach($affiliateSchemes as $schemeData)
		{
			foreach($schemeData as $scheme)
			{
				foreach($allFrontendsData as $frontendData)
				{
					//FIXME check the landing page
					$url = $frontendData['url'] . '/index/index/trackerId/' . $scheme['tracker']['tracker_id'];
					//$idSite = $siteManager->getSitesIdFromSiteUrl($url);
					$finalData[$i]['Tracker Name'] = $scheme['tracker']['tracker_name'] . '_' . $scheme['tracker']['tracker_id'] . '_' . $frontendData['id'];
					$finalData[$i]['Tracker Link'] = $url;
					$finalData[$i]['Frontend'] = $frontendData['name'];
					$varName = 'EARNINGS_FRONTEND_' . $frontendData['id'];
					$finalData[$i]['Earnings'] = $trackerDetailInstance->getVariableValue($scheme['tracker']['tracker_id'], $varName);
					/*$finalData[$i]['Visits'] = $request->getVisits($idSite, 'day', $today);
					$finalData[$i]['Unique Visits'] = $request->getUniqueVisitors($idSite, 'day', $today);
					$finalData[$i]['Page Views'] = $request->getActions($idSite, 'day', $today);
					$goal = $goals->getGoals($idSite);
					if($goal)
					{
						foreach($goal as $goalData)
						{
							$finalData[$i][$goalData['name']] = $goals->getConversions($idSite, 'day', $today, $goalData['idgoal']);
						}
					}*/
					$i++;
				}
				/*$goal = $goals->getGoals($idSite);
				if($goal)
				{
					foreach($goal as $goalData)
					{
						$finalData[$i][$goalData['name']] = $goals->getConversions($idSite, 'day', '2010-11-16', $goalData['idgoal']);
					}
				}*/
			}
		}
		//Zenfox_Debug::dump($finalData, 'final', true, true);
		//$track = new Track();
		//$track->getAffiliateEarnings(1);
		
		$this->view->contents = $finalData;
		//$this->view->x = $x;
		
	}
	public function editAction()
	{
		$form = new Affiliate_AffiliateTrackerForm();
		$request = $this->getRequest();
		/*$storage = new Zenfox_Auth_Storage_Session();
		$session = $storage->read();*/
		$affiliateId = $this->_storage['id'];
		$trackerId = $request->id;
		$affiliateTracker = new AffiliateTracker();
		$data = $affiliateTracker->getAffiliateTracker($trackerId);
		$form = $form->setForm($data);
		$this->view->form = $form;
		
		if($request->isPost())
		{
			if($form->isValid($_POST))
			{
				$data = $form->getValues();
				$affiliateTracker = new AffiliateTracker();
				$affiliateTracker->updateAffiliateTracker($trackerId,$data);
				$this->view->form = '';
				$this->_helper->FlashMessenger(array('notice' => $this->view->translate("Tracker is updated")));
			}
		}
	}
	
	public function trackerdetailsAction()
	{
		$trackerId = $this->getRequest()->tId;
		$frontendId = $this->getRequest()->fId;
		$track = new Track();
		$playersReport = $track->getPlayerReport($trackerId, $frontendId);
		/*$frontend = new Frontend();
		$frontendData = $frontend->getFrontendById($frontendId);
		$siteManager = new Piwik_Site_Controller();
		$request = new Piwik_VisitsSummary_API();
		$goals = new Piwik_Goals_API();*/
		$i = 0;
		$finalData = array();
		$data = array();
		/*$date = Zend_Date::now();
		$today = $date->toString('Y-M-d');
		$url = $frontendData[0]['url'] . '/trackerId/' . $trackerId;*/
		$affiliateTracker = new AffiliateTracker();
		$trackerData = $affiliateTracker->getAffiliateTracker($trackerId);
		$trackerName = $trackerData['tracker_name'];
		/*$varName = 'EARNINGS_FRONTEND_' . $frontendId;
		$trackerDetailInstance = new TrackerDetail();
		$earnings = $trackerDetailInstance->getVariableValue($trackerId, $varName);*/
		$affiliateScheme = new AffiliateScheme();
		$schemeName = $affiliateScheme->getSchemeName($trackerData['scheme_id']);
		$reportType = '';
		$track = new Track();
		$trackRecords = $track->getRecords($trackerId, $frontendId, $reportType);
		
		//$idSite = $siteManager->getSitesIdFromSiteUrl($url);
		$finalData[$i]['Tracker Name'] = $trackerName . '-(' . $trackRecords['frontendName'] . ')';
		$finalData[$i]['Scheme'] = $schemeName;
		$data[$i]['Earnings'] = $trackRecords['earnings'];
		$data[$i]['Total Deposits'] = $playersReport['totalDeposits'];
		$data[$i]['No Of Depositors'] = $playersReport['noOfDepositors'];
		$data[$i]['Registrations'] = $playersReport['registrations'];
		//$data[$i]['Unique Visits'] = $trackRecords['uniqueVisitors'];
		
		//TODO: Get from database
		$data[$i]['Total Withdrawls'] = 0;
		$data[$i]['Acquistions'] = 0;
		//Select the period day, week, or month
		/*$finalData[$i]['Visits'] = $trackRecords['visits'];
		$finalData[$i]['Unique Visits'] = $trackRecords['uniqueVisitors'];
		$finalData[$i]['Page Views'] = $trackRecords['actions'];*/
		//$goal = $goals->getGoals($idSite);
		/*if($trackRecords['goals'])
		{
			foreach($trackRecords['goals'] as $goalName => $goalValue)
			{
				$finalData[$i][$goalName] = $goalValue;
			}
		}*/
		/*$trackerId = $this->getRequest()->tId;
		$ids = explode(',', $this->_storage['allowed_frontend_ids']);
		$frontend = new Frontend();
		$allFrontendsData = $frontend->getFrontendById($ids);
		$siteManager = new Piwik_Site_Controller();
		$request = new Piwik_VisitsSummary_API();
		$goals = new Piwik_Goals_API();
		$i = 0;
		$finalData = array();
		$date = Zend_Date::now();
		$today = $date->toString('Y-M-d');
		foreach($allFrontendsData as $frontendData)
		{
			$url = $frontendData['url'] . '/trackerId/' . $trackerId;
			$varName = 'EARNINGS_FRONTEND_' . $frontendData['id'];
			$trackerDetailInstance = new TrackerDetail();
			$earnings = $trackerDetailInstance->getVariableValue($trackerId, $varName);
			$idSite = $siteManager->getSitesIdFromSiteUrl($url);
			$finalData[$i]['Tracker Name'] = 'Tracker-' . $trackerId . '-(' . $frontendData['name'] . ')';
			$finalData[$i]['Earnings'] = $earnings;
			$finalData[$i]['Visits'] = $request->getVisits($idSite, 'day', $today);
			$finalData[$i]['Unique Visits'] = $request->getUniqueVisitors($idSite, 'day', $today);
			$finalData[$i]['Page Views'] = $request->getActions($idSite, 'day', $today);
			$goal = $goals->getGoals($idSite);
			if($goal)
			{
				foreach($goal as $goalData)
				{
					$finalData[$i][$goalData['name']] = $goals->getConversions($idSite, 'day', $today, $goalData['idgoal']);
				}
			}
			$i++;
		}*/
		//$this->view->contents = $finalData;
		$this->view->contents = NULL;
		$this->view->data = $data;
		$this->view->schemeId = $trackerData['scheme_id'];
		/*$request = $this->getRequest();
		$trackerId = $request->id;
		$trackerDetailInstance = new TrackerDetail();
		$trackerDetails = $trackerDetailInstance->getTrackerDetails($trackerId);
		$this->view->trackerDetails = $trackerDetails;*/
	}
	
	public function alltrackersAction()
	{
		/*$storage = new Zenfox_Auth_Storage_Session();
		$session = $storage->read();*/
		$id = $this->_storage['id'];
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
}
