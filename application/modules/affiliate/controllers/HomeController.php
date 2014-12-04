<?php
require_once dirname(__FILE__) . '/../forms/AffiliateTrackerForm.php';
class Affiliate_HomeController extends Zenfox_Controller_Action
{
	private $_storage;
	public function init()
	{
		parent::init();
		/*$session = new Zenfox_Auth_Storage_Session();
		$this->_storage = $session->read();
		$loginName = $this->_storage['authDetails'][0]['alias'];
		$md5Password = md5($this->_storage['authDetails'][0]['passwd']);
		$request = new Piwik_Log_Controller();
		$request->logme($loginName, $md5Password);*/
	}
	
	public function indexAction()
	{
		$form = new Affiliate_AffiliateTrackerForm();
		$this->view->form = $form->getOptions();
		$reportType = '';
		if($this->getRequest()->isPost())
		{
			if($form->isValid($_POST))
			{
				$reportType = $form->getValue('options');
			}
		}
		//print_r($_COOKIE);
		/*setcookie('nik', 'hello');
		$this->_redirect('/auth/view');*/
		$affiliateId = $this->_storage['id'];
		$affiliateTracker = new AffiliateTracker();
		$affiliateTrackers = $affiliateTracker->getAffiliateTrackersByAffiliateId($affiliateId);
		//Zenfox_Debug::dump($affiliateTrackers, 'trackers', true, true);
		//Zenfox_Debug::dump($affiliateTrackers, 'tracker');
		$frontend = new Frontend();
		$ids = explode(',', $this->_storage['allowed_frontend_ids']);
		$allFrontendsData = $frontend->getFrontendById($ids);
		//Zenfox_Debug::dump($allFrontendsData, 'frontend');
		/*$trackerDetail = new TrackerDetail();
		$siteManager = new Piwik_Site_Controller();
		$request = new Piwik_VisitsSummary_API();
		$goals = new Piwik_Goals_API();
		$date = Zend_Date::now();
		$today = $date->toString('Y-M-d');*/
		$earnings = 0;
		$registrations = 0;
		$depositors = 0;
		/*$visits = 0;
		$uniqueVisits = 0;
		$pageViews = 0;*/
		$track = new Track();
		/*if($affiliateTrackers)
		{
			foreach($affiliateTrackers as $trackerData)
			{
				foreach($allFrontendsData as $frontendData)
				{
					$trackRecords = $track->getRecords($trackerData['tracker_id'], $frontendData['id'], $reportType);
					/*$varName = 'EARNINGS_FRONTEND_' . $frontendData['id'];
					$url = $frontendData['url'] . '/trackerId/' . $trackerData['tracker_id'];
					$idSite = $siteManager->getSitesIdFromSiteUrl($url);
					$earnings = $earnings + $trackerDetail->getVariableValue($trackerData['tracker_id'], $frontendData['id']);
					$visits = $visits + $request->getVisits($idSite, 'month', $today);
					$uniqueVisits = $uniqueVisits + $request->getUniqueVisitors($idSite, 'month', $today);
					$pageViews = $pageViews + $request->getActions($idSite, 'month', $today);
					$goal = $goals->getGoals($idSite);
					if($goal)
					{
						foreach($goal as $goalData)
						{
							switch($goalData['name'])
							{
								case 'Registration':
									$registrations = $registrations + $goals->getConversions($idSite, 'month', $today, $goalData['idgoal']);
									break;
								case 'No Of Depositors':
									$depositors = $depositors + $goals->getConversions($idSite, 'month', $today, $goalData['idgoal']);
									break;
							}
						}
					}*/
					/*$earnings = $earnings + $trackRecords['earnings'];
					$visits = $visits + $trackRecords['visits'];
					$uniqueVisits = $uniqueVisits + $trackRecords['uniqueVisitors'];
					$pageViews = $pageViews + $trackRecords['actions'];
					if(isset($trackRecords['goals']))
					{
						foreach($trackRecords['goals'] as $goalName => $goalValue)
						{
							switch($goalName)
							{
								case 'Registration':
									$registrations = $registrations + $goalValue;
									break;
								case 'No Of Depositors':
									$depositors = $depositors + $goalValue;
									break;
							}
						}
					}
				}
			}
		}*/
		$finalData = array();
		$finalData[0]['Total Earnings'] = $earnings;
		$finalData[0]['Total Registrations'] = $registrations;
		$finalData[0]['Total Depositors'] = $depositors;
		$this->view->content = $finalData;
		//Zenfox_Debug::dump($finalData, 'final');
		$this->view->affiliateName = $this->_storage['authDetails'][0]['firstname']; 
	}	
}
