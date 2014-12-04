<?php
class Track
{
	public function getRecords($trackerId, $frontendId, $reportType = NULL, $type)
	{
		/* $siteManager = new Piwik_Site_Controller();
		$request = new Piwik_VisitsSummary_API();
		$goals = new Piwik_Goals_API(); */
		
		$frontend = new Frontend();
		$frontendData = $frontend->getFrontendById($frontendId);
		$url = $frontendData[0]['url'] . '/trackerId/' . $trackerId;
		//$idSite = $siteManager->getSitesIdFromSiteUrl($url);
		
		$date = Zend_Date::now();
		$today = $date->toString('Y-M-d');
		
		$varName = 'EARNINGS_FRONTEND_' . $frontendId;
		$trackerDetailInstance = new TrackerDetail();
		$earnings = $trackerDetailInstance->getVariableValue($trackerId, $varName);
		return array('earnings' => $earnings);
		//Select the period day, week or month
		//echo 'report' . $reportType;
		/* if(!$reportType)
		{
			$reportType = 'day';
		}
		//$visits = $request->getVisits($idSite, $reportType, 'today');
		
		for($i=0;$i<8;$i++)
		{
			
			$uniqueVisitors = $request->getUniqueVisitors($idSite, $reportType, $today);
			$visits = $request->getVisits($idSite, $reportType, $today);
			
			$finalArr[$i][] = $today;
			$finalArr[$i][] = $uniqueVisitors;
			
			$finalArr1[$i][] = $today;
			$finalArr1[$i][] = $visits;
			$today = date ("Y-m-d", strtotime("$today , -1 day"));
		}
		//Zenfox_Debug::dump($finalArr, 'connection', true, true);
		if($type == 0)
		return $finalArr1;
		if($type == 1)
		return $finalArr; */
		
		
	//	$uniqueVisitors = $request->getUniqueVisitors($idSite, $reportType, 'today');
		
		/*$actions = $request->getActions($idSite, $reportType, 'today');
		
		$goal = $goals->getGoals($idSite);
		$goalArray = array();
		if($goal)
		{
			foreach($goal as $goalData)
			{
				$goalArray[$goalData['name']] = $goals->getConversions($idSite, $reportType, 'today', $goalData['idgoal']);
			}
		}*/
		
		//return array(array('earnings', $earnings), array('uniquevisits', $uniqueVisitors));
			/*'visits' => $visits,
			'actions' => $actions,
			'goals' => $goalArray
		);*/
	}
	
	
	
	
	public function getTotalAffiliateVisits($affId, $frontendId, $type)
	{
		$siteManager = new Piwik_Site_Controller();
		$request = new Piwik_VisitsSummary_API();
		$goals = new Piwik_Goals_API();
		
		$frontend = new Frontend();
		$frontendData = $frontend->getFrontendById($frontendId);
		$url = $frontendData[0]['url'] . '/trackerId/' ;
		
		$count = 0;
		$count1 = 0;
		
		$date = Zend_Date::now();
		$today = $date->toString('Y-M-d');
		
		$reportType = 'day';
		
		$affiliateTracker = new AffiliateTracker();
		$affiliateTrackers = $affiliateTracker->getAffiliateTrackersByAffiliateId($affId); 
	//	 Zenfox_Debug::dump($affiliateTrackers, 'connection', true, true);
	
		
			
			
			for($i=0;$i<8;$i++)
			{
				
			//	Zenfox_Debug::dump($affiliateTrackers, 'data');
				foreach ($affiliateTrackers as $key=>$value)
				{
					$url1 = $url.$affiliateTrackers[$key]['tracker_id'];
				//	Zenfox_Debug::dump($url1, 'url');
					$idSite = $siteManager->getSitesIdFromSiteUrl($url1);
				//	Zenfox_Debug::dump($idSite, 'id');
					$uniqueVisitors = $request->getUniqueVisitors($idSite, 'day', $today);
					$visits = $request->getVisits($idSite, 'day', $today);
				//	Zenfox_Debug::dump($visits, 'connection'.$i);
					$count = $count + $uniqueVisitors;
					$count1 = $count1 + $visits;
					$url1 = $url;
				}
				
			//	exit();
			//	Zenfox_Debug::dump($visits, 'connection', true, true);
					
				
				$finalArr[$i][] = $today;
				$finalArr[$i][] = $count;
			
				$finalArr1[$i][] = $today;
				$finalArr1[$i][] = $count1;
				$today = date ("Y-m-d", strtotime("$today , -1 day"));
				$count = 0;
				$count1 = 0;
				
				
				
			}
		//	Zenfox_Debug::dump($finalArr1, 'connection', true, true);
		
			if ($type == 0)
			return $finalArr1;
			if($type == 1)
			return $finalArr;
}


	
	public function getPlayerReport($trackerId, $frontendId)
	{
		$totalDeposits = 0;
		$noOfDepositors = 0;
		$totalRegistrations = 0;
		$connections = Zenfox_Partition::getInstance()->getConnections(-1);
		//Zenfox_Debug::dump($connections, 'connection', true, true);
		foreach($connections as $connection)
		{
			Doctrine_Manager::getInstance()->setCurrentConnection($connection);
			$query = Zenfox_Query::create()
						->select('SUM(a.total_deposits) as total_deposit, COUNT(a.total_deposits) as noof_depositors')
						->from('AccountDetail a')
						->where('a.tracker_id = ?', $trackerId)
						->andWhere('a.frontend_id = ?', $frontendId)
						->andWhere('a.total_deposits > 0');
						
			$result = $query->fetchArray();
			foreach($result as $playerData)
			{
				$totalDeposits += $playerData['total_deposit'];
				$noOfDepositors += $playerData['noof_depositors'];
			}
			
			$query = Zenfox_Query::create()
						->select('COUNT(player_id) as registrations')
						->from('AccountDetail a')
						->where('a.tracker_id = ?', $trackerId)
						->andWhere('a.frontend_id = ?', $frontendId);
						
			$result = $query->fetchArray();
			$totalRegistrations += $result[0]['registrations'];
		}
		$finalResult['totalDeposits'] = $totalDeposits;
		$finalResult['noOfDepositors'] = $noOfDepositors;
		$finalResult['registrations'] = $totalRegistrations;
		return($finalResult);
	}



	
	
	
	public function getTrackerEarnings($trackerId, $frontendId)
	{
		
		
		$connections = Zenfox_Partition::getInstance()->getConnections(-1);
		
		$query = Zenfox_Query::create()
						->select('td.variable_name , td.variable_value')
						->from('TrackerDetail td')
						->where('td.tracker_id = ?', $trackerId)
						->andWhere('td.variable_name LIKE ?', 'EARNINGS_2%_%_%');
						
						$result = $query->fetchArray();
						Zenfox_Debug::dump($result, 'connection', true, true);
						
						foreach($result as $key=>$value)
						{
							$dateArr = explode('_',$result[$key]['variable_name']);
							$date =  $dateArr[1].'-'.$dateArr[2].'-'.$dateArr[3];

							$finalData[$key][] = $date;
							$finalData[$key][] = $result[$key]['variable_value'];
						
						}
						
		}
		
		
		
		
		public function getAffiliateEarnings($affId)
		{
			$affiliateTracker = new AffiliateTracker();
			$affiliateTrackers = $affiliateTracker->getAffiliateTrackersByAffiliateId($affId);
			
			
			foreach ($affiliateTrackers as $key=>$value)
			{
				$trackerId = $affiliateTrackers[$key]['tracker_id'];
				$query = Zenfox_Query::create()
						->select('td.variable_name , td.variable_value')
						->from('TrackerDetail td')
						->where('td.tracker_id = ?', $trackerId)
						->andWhere('td.variable_name LIKE ?', 'EARNINGS_2%_%_%');
						
				$result = $query->fetchArray();
				//Zenfox_Debug::dump($result, 'connection', true, true);
						
				foreach($result as $key=>$value)
				{
					$dateArr = explode('_',$result[$key]['variable_name']);
					$date =  $dateArr[1].'-'.$dateArr[2].'-'.$dateArr[3];

					$finalData[$key][] = $date;
					$finalData[$key][] = $result[$key]['variable_value'];
				
				}
				
			
			}
			
		}
		
		
		


}

	
	