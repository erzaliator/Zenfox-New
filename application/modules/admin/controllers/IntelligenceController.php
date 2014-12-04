<?php
require_once dirname(__FILE__) . '/../forms/NetworkTrafficForm.php';
require_once dirname(__FILE__) . '/../forms/NetworkSnapshotForm.php';
//require_once dirname(__FILE__) . '/../../../models/Snapshot.php';

class Admin_IntelligenceController extends Zenfox_Controller_Action 
{
	public function networktrafficAction() 
	{
		$session = new Zend_Session_Namespace('Tags');
		$form = new Admin_NetworkTrafficForm();
		$this->view->form = $form;
		$systemHealth = new SystemHealth();
		$offset = $this->getRequest()->pages;
		
		if($offset) 
		{
		
			if($tagName)
			{
				foreach($session->tags as $storedTag => $storedOffset)
				{
					/*print('storedTag - ' . $storedTag);
					print('tagName - ' . $tagName);*/
					$offset = $this->getRequest()->pages;
					if($storedTag != $tagName)
					{
						//echo "inside";
						$offset = $storedOffset;
					}
					$result = $systemHealth->getSystemDetailReportByTag($storedTag, $reportType, $from, $to, $offset, $itemsPerPage);
					$finalReports[] = $result;
					$store[$storedTag] = $offset;
				}
				$this->view->currentPage = $session->offset;
			}
			else
			{
				foreach($session->tags as $storedTag => $storedOffset)
				{
					$result = $systemHealth->getSystemDetailReportByTag($storedTag, $reportType, $from, $to, $offset, $itemsPerPage);
					$finalReports[] = $result;
					$store[$storedTag] = $offset;
				}
			$this->view->currentPage = $offset;
			$session->offset = $offset;
			}
		
			//exit();
			
			$session->tags = $store;
			$this->view->item = $itemsPerPage;
			$this->view->fromDate = $from;
			$this->view->toDate = $to;
			$this->view->reportType = $reportType;
			$this->view->finalReports = $finalReports;
		}
		
		if($this->getRequest()->isPost())
		{
			if($form->isValid($_POST))
			{
				$session->unsetAll();
				$offset = 1;
				$data = $form->getValues();
				$from = $data['fromDate'] . ' ' . $data['fromTime'];
				$to = $data['toDate'] . ' ' . $data['toTime'];
				$newTagName = array();
				
				$systemTag = new SystemTag();
				$allTags = $systemTag->getAllTags();

				if($allTags) 
				{
					foreach($allTags as $tag)
					{
						$result = $systemHealth->getSystemDetailReportByTag($tag['tag'], $data['reportType'], $from, $to, $offset, $data['page']);
						$finalReports[] = $result;
						$tagName = $tag['tag'];
						$store[$tagName] = $offset;
					}
				}
				
				$dateArray = array();
				
				foreach($finalReports as $report) {
					foreach($report['start_time'] as $datetime) {
						if(!in_array($datetime,$dateArray)) {
							$dateArray[] = $datetime;
						}
					}
				}
				sort($dateArray);
				
				$session->tags = $store;
				$session->offset = $offset;
				$this->view->item = $data['page'];
				$this->view->currentPage = $offset;
				$this->view->fromDate = $from;
				$this->view->toDate = $to;
				$this->view->dateTime = $dateArray;
				$this->view->reportType = $data['reportType'];
				$this->view->finalReports = $finalReports;
				//print '<pre>';
				//foreach($finalReports as $report)
				//print_r($report['tagData']);
				//exit();
			}
		}
	}
	
	
	public function frontendtrafficAction() 
	{
		$csrGmsGroup = new CsrGmsGroup();
		$session = new Zend_Auth_Storage_Session();
		$store = $session->read();
		$csrId = $store['authDetails'][0]['id'];		
		$frontendIdList = $csrGmsGroup->getFrontendList($csrId,true);
		
		$session = new Zend_Session_Namespace('Tags');
		$form = new Admin_NetworkTrafficForm();
		$this->view->form = $form;
		$systemHealth = new SystemHealth();
		$offset = $this->getRequest()->pages;
		
		
		
		if($offset) 
		{
		
			if($tagName)
			{
				foreach($session->tags as $storedTag => $storedOffset)
				{
					/*print('storedTag - ' . $storedTag);
					print('tagName - ' . $tagName);*/
					$offset = $this->getRequest()->pages;
					if($storedTag != $tagName)
					{
						//echo "inside";
						$offset = $storedOffset;
					}
					$result = $systemHealth->getSystemDetailReportByTag($storedTag, $reportType, $from, $to, $offset, $itemsPerPage,$frontendIdList);
					$finalReports[] = $result;
					$store[$storedTag] = $offset;
				}
				$this->view->currentPage = $session->offset;
			}
			else
			{
				foreach($session->tags as $storedTag => $storedOffset)
				{
					$result = $systemHealth->getSystemDetailReportByTag($storedTag, $reportType, $from, $to, $offset, $itemsPerPage,$frontendIdList);
					$finalReports[] = $result;
					$store[$storedTag] = $offset;
				}
			$this->view->currentPage = $offset;
			$session->offset = $offset;
			}
		
			//exit();
			
			$session->tags = $store;
			$this->view->item = $itemsPerPage;
			$this->view->fromDate = $from;
			$this->view->toDate = $to;
			$this->view->reportType = $reportType;
			$this->view->finalReports = $finalReports;
		}
		
		if($this->getRequest()->isPost())
		{
			if($form->isValid($_POST))
			{
				$session->unsetAll();
				$offset = 1;
				$data = $form->getValues();
				$from = $data['fromDate'] . ' ' . $data['fromTime'];
				$to = $data['toDate'] . ' ' . $data['toTime'];
				$newTagName = array();
				
				$systemTag = new SystemTag();
				$allTags = $systemTag->getAllTags();

				if($allTags) 
				{
					foreach($allTags as $tag)
					{
						$result = $systemHealth->getSystemDetailReportByTag($tag['tag'], $data['reportType'], $from, $to, $offset, $data['page'],$frontendIdList);
						$finalReports[] = $result;
						$tagName = $tag['tag'];
						$store[$tagName] = $offset;
					}
				}
				
				$dateArray = array();
				
				foreach($finalReports as $report) {
					foreach($report['start_time'] as $datetime) {
						if(!in_array($datetime,$dateArray)) {
							$dateArray[] = $datetime;
						}
					}
				}
				sort($dateArray);
				
				$session->tags = $store;
				$session->offset = $offset;
				$this->view->item = $data['page'];
				$this->view->currentPage = $offset;
				$this->view->fromDate = $from;
				$this->view->toDate = $to;
				$this->view->dateTime = $dateArray;
				$this->view->reportType = $data['reportType'];
				$this->view->finalReports = $finalReports;
				//print '<pre>';
				//foreach($finalReports as $report)
				//print_r($report['tagData']);
				//exit();
			}
		}
	}
	
	
	public function networksnapshotAction()
	{
		$form = new Admin_NetworkSnapshotForm();
		$this->view->form = $form;
		
		if($this->getRequest()->isPost())
		{
			if($form->isValid($_POST))
			{
				$data = $form->getValues();
				//print_r($data);
				$fromDate = new Zend_Date($data['fromDate']);
				$toDate = new Zend_Date($data['toDate']);
				$fromTime = $data['fromTime'];
				$toTime = $data['toTime'];
				$today = new Zend_Date(date('Y-m-d',strtotime("today")));
				//print_r($today);
				//exit(); 
				$shouldProcess = true;
				//$toDate->
				//$beforeTo = $toDate->addDay(-1);
				//print_r($beforeTo);
				//exit();
				
				
				if($fromDate->compareDate($toDate,'YYYY-MM-dd') > 0)
				{
					$this->_helper->FlashMessenger(array('error' => $form->getView()->translate('Invalid Dates')));
					$shouldProcess = false;
				}
				
				if($shouldProcess)
				{
					$systemHealth = new SystemHealth();
					$snapShot = new Snapshot();
					$tagNames = $snapShot->getNetworkSnapShotTags();
					$today = date('Y-m-d',strtotime('today'));
					$singleDay = 0;
					$finalData = array();
					
					
					if($fromDate->compareDate($toDate,'YYYY-MM-dd') == 0)
					{
						foreach ($tagNames as $tag => $function) {
							
								if($snapShot->isSpecialAccumulationTag($tag)) {
								
									$finalData[$tag]['value'] = $systemHealth->getSnapshotForSpecialAccumulationTag($tag,$data['fromDate'],$data['toDate']);
									continue;
								}
								
								$eohSnapshot[$tag] = $systemHealth->getSnapshotForTag($data['fromDate'].' '.$data['fromTime'],
																			 $data['toDate'].' '.$data['toTime'],$tag,'EOH',$function);
								$finalData[$tag]['value'] = $eohSnapshot[$tag]['value']['value'];											 
						}
						$singleDay = 1;													 
					}
					else 
					{
						$eohFrom = array();
						$eodSnapshot = array();
						$eohTo = array();
						$fromNextString = strtotime("${data['fromDate']} + 1 days");
						$fromNext = date('Y-m-d',$fromNextString);
						$toBeforeString = strtotime("${data['toDate']} - 1 days");
						$toBefore = date('Y-m-d',$toBeforeString);
						$finalData = array();
						$specialAccumulationTags = $snapShot->getSpecialAccumulationTags(); 
						//print $fromNext.'<br>'.$toBefore;
						
						
						foreach ($tagNames as $tag => $function)
						{
							if($snapShot->isSpecialAccumulationTag($tag)) {
								
								$finalData[$tag]['value'] = $systemHealth->getSnapshotForSpecialAccumulationTag($tag,$data['fromDate'],$data['toDate']);
								continue;
							}
							
							$eohFrom[$tag]['value'] = $systemHealth->getSnapshotForTag($data['fromDate'].' '.$data['fromTime'],$data['fromDate'].' '.'23:59:59',$tag,'EOH',$function);
							if($fromNextString <= $toBeforeString)
							{
								$eodSnapshot[$tag]['value'] = $systemHealth->getSnapshotForTag($fromNext.' '.'00:00:00',$toBefore.' '.'23:59:59',$tag,'EOD',$function); 
								/*if($tag == 'networkDepositsAmount') {
									print '$$$$$$$$$$$$$$$$$$$';
									print_r($eodSnapshot[$tag]);
								}*/
							}
							$eohTo[$tag]['value'] = $systemHealth->getSnapshotForTag($data['toDate'].'00:00:00',$data['toDate'].' '.$data['toTime'],$tag,'EOH',$function);
							
							if(!$snapShot->isNetworkJsonTag($tag)) {
							
								$finalData[$tag]['value'] = $eohFrom[$tag]['value']['value'] + $eodSnapshot[$tag]['value']['value'] + $eohTo[$tag]['value']['value'];
							}
							else {
								if($fromNextString <= $toBeforeString) {
								/*	if($tag == 'networkDepositsAmount') {
										print '<pre>';
										print_r(array($eohFrom[$tag],$eodSnapshot[$tag],$eohTo[$tag]));
										print '</pre>';
									}*/
									$finalData[$tag]['value'] = $systemHealth->getSummaryJsonTag($tag,array($eohFrom[$tag],$eodSnapshot[$tag],$eohTo[$tag]),3,true);
								}
								else {
									$finalData[$tag]['value'] = $systemHealth->getSummaryJsonTag($tag,array($eohFrom[$tag],$eohTo[$tag]),2);
								}
								//$finalData[$tag] = $systemHealth->ge
							}
							//Might need /3 for the depositsPerPlayer kind of tags.
							
						}
					}
					//exit();
					//print '<pre>';
					/*print_r($eodSnapshot);
					print_r($eohFrom);
					print_r($eohTo);*/
					//print_r($finalData);
					//$finalData = $systemHealth->getSnapshotTotal($finalData);
					
					$this->view->tableData =$finalData;
					//exit();
					//print_r($finalData);exit();
					/*print '<pre>';
					//print_r($tagNames);
					print_r($eohFrom);
					print_r($eodSnapshot);
					print_r($eohTo);
					print '</pre>'	;
					exit();*/
					
					/*$tableData = array();
					$numRows = ($singleDay == 0) ? 3 : 1;
					$i = 0;
					foreach($tagNames as $tag => $function) {
						//EMPTY LOOP to init $tag
					}
					//echo $tag;
					//echo $singleDay;
					//print_r( $eohFrom[$tag]['start_time']);
					//echo $numRows;
					for($i = 0 ; $i < $numRows ; $i++)
					{
						if($singleDay)
						{
							$tableData[$i]['start_time'] = $eohSnapshot[$tag]['start_time'];
							$tableData[$i]['end_time'] = $eohSnapshot[$tag]['end_time'];
							$tableData[$i]['report_type'] = $eohSnapshot[$tag]['report_type'];
							
							foreach ($tagNames as $tag => $function)
							{
								$tableData[$i][$tag] = $eohSnapshot[$tag]['value'];
							}
							
						}
						else 
						{
							if($i == 0)
							{
								$tableData[$i]['start_time'] = $eohFrom[$tag]['start_time'];
								$tableData[$i]['end_time'] = $eohFrom[$tag]['end_time'];
								$tableData[$i]['report_type'] = $eohFrom[$tag]['report_type'];
							}
							else if($i == 1)
							{
								$tableData[$i]['start_time'] = $eodSnapshot[$tag]['start_time'];
								$tableData[$i]['end_time'] = $eodSnapshot[$tag]['end_time'];
								$tableData[$i]['report_type'] = $eodSnapshot[$tag]['report_type'];
							}
							else
							{
								$tableData[$i]['start_time'] = $eohTo[$tag]['start_time'];
								$tableData[$i]['end_time'] = $eohTo[$tag]['end_time'];
								$tableData[$i]['report_type'] = $eohTo[$tag]['report_type'];
							}
							foreach ($tagNames as $tag => $function)
							{
								if($i == 0)
								{
									$tableData[$i][$tag] = $eohFrom[$tag]['value'];
								}
								else if ($i == 1) 
								{
									$tableData[$i][$tag] = $eodSnapshot[$tag]['value'];
								}
								else 
								{
									$tableData[$i][$tag] = $eohTo[$tag]['value'];
								}
							}
							
													
						}
					}	
					
					print '<pre>';
					print_r($tableData);exit();*/
				}
				
			
			}
		}
		
	}
	
	public function frontendsnapshotAction()
	{
		$csrGmsGroup = new CsrGmsGroup();
		$session = new Zend_Auth_Storage_Session();
		$store = $session->read();
		$csrId = $store['authDetails'][0]['id'];		
		$frontendIdList = $csrGmsGroup->getFrontendList($csrId,true);
		
		$form = new Admin_NetworkSnapshotForm();
		$this->view->form = $form;
		
		if($this->getRequest()->isPost())
		{
			if($form->isValid($_POST))
			{
				$data = $form->getValues();
				//print_r($data);
				$fromDate = new Zend_Date($data['fromDate']);
				$toDate = new Zend_Date($data['toDate']);
				$fromTime = $data['fromTime'];
				$toTime = $data['toTime'];
				$today = new Zend_Date(date('Y-m-d',strtotime("today")));
				//print_r($today);
				//exit(); 
				$shouldProcess = true;
				//$toDate->
				//$beforeTo = $toDate->addDay(-1);
				//print_r($beforeTo);
				//exit();
				
				
				if($fromDate->compareDate($toDate,'YYYY-MM-dd') > 0)
				{
					$this->_helper->FlashMessenger(array('error' => $form->getView()->translate('Invalid Dates')));
					$shouldProcess = false;
				}
				
				if($shouldProcess)
				{
					$systemHealth = new SystemHealth();
					$snapShot = new Snapshot();
					$tagNames = $snapShot->getNetworkSnapShotTags();
					$today = date('Y-m-d',strtotime('today'));
					$singleDay = 0;
					$finalData = array();
					
					
					if($fromDate->compareDate($toDate,'YYYY-MM-dd') == 0)
					{
						foreach ($tagNames as $tag => $function) {
							
								if($snapShot->isSpecialAccumulationTag($tag)) {
								
									$finalData[$tag]['value'] = $systemHealth->getSnapshotForSpecialAccumulationTag($tag,$data['fromDate'],$data['toDate'],$frontendIdList);
									continue;
								}
								
								$eohSnapshot[$tag] = $systemHealth->getSnapshotForTag($data['fromDate'].' '.$data['fromTime'],
																			 $data['toDate'].' '.$data['toTime'],$tag,'EOH',$function,$frontendIdList);
								$finalData[$tag]['value'] = $eohSnapshot[$tag]['value']['value'];											 
						}
						$singleDay = 1;													 
					}
					else 
					{
						$eohFrom = array();
						$eodSnapshot = array();
						$eohTo = array();
						$fromNextString = strtotime("${data['fromDate']} + 1 days");
						$fromNext = date('Y-m-d',$fromNextString);
						$toBeforeString = strtotime("${data['toDate']} - 1 days");
						$toBefore = date('Y-m-d',$toBeforeString);
						$finalData = array();
						$specialAccumulationTags = $snapShot->getSpecialAccumulationTags(); 
						//print $fromNext.'<br>'.$toBefore;
						
						
						foreach ($tagNames as $tag => $function)
						{
							if($snapShot->isSpecialAccumulationTag($tag)) {
								
								$finalData[$tag]['value'] = $systemHealth->getSnapshotForSpecialAccumulationTag($tag,$data['fromDate'],$data['toDate'],$frontendIdList);
								continue;
							}
							
							$eohFrom[$tag]['value'] = $systemHealth->getSnapshotForTag($data['fromDate'].' '.$data['fromTime'],$data['fromDate'].' '.'23:59:59',$tag,'EOH',$function);
							if($fromNextString <= $toBeforeString)
							{
								$eodSnapshot[$tag]['value'] = $systemHealth->getSnapshotForTag($fromNext.' '.'00:00:00',$toBefore.' '.'23:59:59',$tag,'EOD',$function); 
								/*if($tag == 'networkDepositsAmount') {
									print '$$$$$$$$$$$$$$$$$$$';
									print_r($eodSnapshot[$tag]);
								}*/
							}
							$eohTo[$tag]['value'] = $systemHealth->getSnapshotForTag($data['toDate'].'00:00:00',$data['toDate'].' '.$data['toTime'],$tag,'EOH',$function,$frontendIdList);
							
							if(!$snapShot->isNetworkJsonTag($tag)) {
							
								$finalData[$tag]['value'] = $eohFrom[$tag]['value']['value'] + $eodSnapshot[$tag]['value']['value'] + $eohTo[$tag]['value']['value'];
							}
							else {
								if($fromNextString <= $toBeforeString) {
								/*	if($tag == 'networkDepositsAmount') {
										print '<pre>';
										print_r(array($eohFrom[$tag],$eodSnapshot[$tag],$eohTo[$tag]));
										print '</pre>';
									}*/
									$finalData[$tag]['value'] = $systemHealth->getSummaryJsonTag($tag,array($eohFrom[$tag],$eodSnapshot[$tag],$eohTo[$tag]),3,true);
								}
								else {
									$finalData[$tag]['value'] = $systemHealth->getSummaryJsonTag($tag,array($eohFrom[$tag],$eohTo[$tag]),2);
								}
								//$finalData[$tag] = $systemHealth->ge
							}
							//Might need /3 for the depositsPerPlayer kind of tags.
							
						}
					}

					
					$this->view->tableData =$finalData;
				}
			}
		}
	}
}
	
	
