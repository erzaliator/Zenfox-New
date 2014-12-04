
<?php
require_once(dirname(__FILE__) . '/../forms/ConversionForm.php');
require_once(dirname(__FILE__) . '/../forms/TransactingPlayersForm.php');
require_once(dirname(__FILE__) . '/../forms/RegistrationSummaryForm.php');
require_once(dirname(__FILE__) . '/../forms/TransactionSummaryForm.php');
require_once(dirname(__FILE__) . '/../forms/TrackerPlayersForm.php');


class Admin_AnalyticsController extends Zenfox_Controller_Action
{
	public function conversionAction()
	{
		$frontendobject = new Frontend();
		$frontends = $frontendobject->getFrontends();

		$length = count($frontends);
		while($length >0)
		{
			$newfrontends[$frontends[$length-1]['id']] = $frontends[$length-1]['name'];
			$length--;
		}
		
		$form = new Admin_ConversionForm();
		$form->setvalue($newfrontends);
		$this->view->form = $form->getform();
		
		if ($this->getRequest()->isPost())
		{
			if($form->isValid($_POST))
			{
				$postvalues = $form->getvalues();
				
				$starttime = $postvalues['startdate'];
				$endtime = $postvalues['enddate'];
			
				if($starttime <= $endtime)
				{
					$health= new SystemHealth();
					$healthresult = $health->getconversionhealth($postvalues["networkorfrontend"],$postvalues["frontendid"],$postvalues["report_type_type"],$postvalues["report_type_time"],$starttime,$endtime);
					
					if(!empty($healthresult))
					{
						$sumArray = array();
						foreach ($healthresult as $k=>$subArray)
						 {
 						 	foreach ($subArray as $id=>$value) 
 						 	{
  							  	$sumArray[$id]+=$value;
 							}
						}
						
						$sumArray["Time"] = "TOTAL";
						$healthresult[count($healthresult)] = $sumArray;
						$this->view->value = $healthresult;
					}
					else
					{
						$this->_helper->FlashMessenger(array('error' => 'No Records found.'));
					}
				}
				else
				{
					$this->_helper->FlashMessenger(array('error' => 'wrong time entered.'));
				}
			}
		}
		
	}
	
	public function transactingplayersAction()
	{
		
		$form = new Admin_TransactingPlayerForm();
		$frontendobject = new Frontend();
		$frontends = $frontendobject->getFrontends();
		
		$length=count($frontends);
		while($length >0)
		{
			$newfrontends[$frontends[$length-1]['id']] = $frontends[$length-1]['name'];
			$length--;
		}
		
		$affiliateobject = new Affiliate();
		$affiliates = $affiliateobject->getAffiliates();
		
		$length=count($affiliates);
		while($length >0)
		{
			$newaffiliates[$affiliates[$length-1]['affiliate_id']] = $affiliates[$length-1]['alias'];
			$length--;
		}
		
		$affiliatetrackerobject = new AffiliateTracker();
		$affiliatetrackers = $affiliatetrackerobject->getAlltAffiliateTrackers();
		
		$length=count($affiliatetrackers);
		while($length >0)
		{
			$newaffiliatetrackers[$affiliatetrackers[$length-1]['tracker_id']] = $affiliatetrackers[$length-1]['tracker_name'];
			$length--;
		}
		
		$form->setvalue($newfrontends,$newaffiliates,$newaffiliatetrackers);
		$this->view->form = $form->getform();
		
		
		if ($this->getRequest()->isPost())
		{
			if($form->isValid($_POST))
			{
				$postvalues = $form->getvalues();
		
				$starttime = $postvalues['startdate']. " " . $postvalues['starttime'];
				$newdatetime = new Zend_Date($starttime);
				$starttime = $newdatetime->get(Zend_Date::W3C);
					
				$endtime = $postvalues['enddate']. " " . $postvalues['endtime'];
				$newdatetime = new Zend_Date($endtime);
				$endtime = $newdatetime->get(Zend_Date::W3C);
				
				if($starttime <= $endtime)
				{
					$syshealth= new SystemHealth();
					$trahealth = new TrackerHealth();
					
					if(($postvalues["networkorfrontend"] == "Frontend") or ($postvalues["networkorfrontend"] == "Network"))
					{
						$healthresult = $syshealth->gettransactingplayers($postvalues["networkorfrontend"],$postvalues["frontendid"],$postvalues["report_type_time"],$starttime,$endtime);
					}
					elseif($postvalues["networkorfrontend"] == "Tracker")
					{
						$healthresult = $syshealth->gettransactingplayers($postvalues["networkorfrontend"],$postvalues['trackerid'],$postvalues["report_type_time"],$starttime,$endtime);
					}
					else 
					{
						$healthresult = $syshealth->gettransactingplayers($postvalues["networkorfrontend"],$postvalues['affiliateid'],$postvalues["report_type_time"],$starttime,$endtime);
					}
					
					if(!empty($healthresult))
					{
						$this->view->value = $healthresult;
					}
					else
					{
						$this->_helper->FlashMessenger(array('error' => 'No Records found.'));
					}
					
				}
				else
				{
					$this->_helper->FlashMessenger(array('error' => 'wrong time entered.'));
				}
			}
		}
	}
	
	public function registrationsAction()
	{
		$frontendobject = new Frontend();
		$frontends = $frontendobject->getFrontends();
	
		$length=count($frontends);
		while($length >0)
		{
			$newfrontends[$frontends[$length-1]['id']] = $frontends[$length-1]['name'];
			$length--;
		}
		
		$form = new Admin_RegistrationSummaryForm();
		$form->setvalue($newfrontends);
		$this->view->form = $form->getform();
		
		if ($this->getRequest()->isPost())
		{
			if($form->isValid($_POST))
			{
				$postvalues = $form->getvalues();
	
				$starttime = $postvalues['startdate']. " " . $postvalues['starttime'];
				$newdatetime = new Zend_Date($starttime);
				$starttime = $newdatetime->get(Zend_Date::W3C);
					
				$endtime = $postvalues['enddate']. " " . $postvalues['endtime'];
				$newdatetime = new Zend_Date($endtime);
				$endtime = $newdatetime->get(Zend_Date::W3C);
	
				if($starttime <= $endtime)
				{
					$health= new SystemHealth();
					$healthresult = $health->getregistrationsummary($postvalues["networkorfrontend"],$postvalues["frontendid"], $postvalues["report_type_time"],$starttime,$endtime);
					
					if(!empty($healthresult))
					{
						$this->view->value = $healthresult;
					}
					else
					{
						$this->_helper->FlashMessenger(array('error' => 'No Records found.'));
					}
				}
				else
				{
					$this->_helper->FlashMessenger(array('error' => 'wrong time entered.'));
				}
			}
		
				
		}
	}
	
	public function transactionsAction()
	{
		$form = new Admin_TransactingPlayerForm();
		$frontendobject = new Frontend();
		$frontends = $frontendobject->getFrontends();
		
		$length=count($frontends);
		while($length >0)
		{
			$newfrontends[$frontends[$length-1]['id']] = $frontends[$length-1]['name'];
			$length--;
		}
		
		$affiliateobject = new Affiliate();
		$affiliates = $affiliateobject->getAffiliates();
		
		$length=count($affiliates);
		while($length >0)
		{
			$newaffiliates[$affiliates[$length-1]['affiliate_id']] = $affiliates[$length-1]['alias'];
			$length--;
		}
		
		$affiliatetrackerobject = new AffiliateTracker();
		$affiliatetrackers = $affiliatetrackerobject->getAlltAffiliateTrackers();
		
		$length=count($affiliatetrackers);
		while($length >0)
		{
			$newaffiliatetrackers[$affiliatetrackers[$length-1]['tracker_id']] = $affiliatetrackers[$length-1]['tracker_name'];
			$length--;
		}
		
		$form->setvalue($newfrontends,$newaffiliates,$newaffiliatetrackers);	
		$this->view->form = $form->getform();
		
		
		if ($this->getRequest()->isPost())
		{
			if($form->isValid($_POST))
			{
				$postvalues = $form->getvalues();
		
				$starttime = $postvalues['startdate']. " " . $postvalues['starttime'];
				$newdatetime = new Zend_Date($starttime);
				$starttime = $newdatetime->get(Zend_Date::W3C);
					
				$endtime = $postvalues['enddate']. " " . $postvalues['endtime'];
				$newdatetime = new Zend_Date($endtime);
				$endtime = $newdatetime->get(Zend_Date::W3C);
		
				if($starttime <= $endtime)
				{
					$syshealth= new SystemHealth();
					
		
					if(($postvalues["networkorfrontend"] == "Frontend") or ($postvalues["networkorfrontend"] == "Network"))
					{
						$healthresult = $syshealth->getsystemtransactionslist($postvalues["networkorfrontend"],$postvalues["frontendid"],$postvalues["report_type_time"],$starttime,$endtime);
					}
					elseif($postvalues["networkorfrontend"] == "Tracker")
					{
						$healthresult = $syshealth->getsystemtransactionslist($postvalues["networkorfrontend"],$postvalues['trackerid'],$postvalues["report_type_time"],$starttime,$endtime);
					}
					else
					{
						$healthresult = $syshealth->getsystemtransactionslist($postvalues["networkorfrontend"],$postvalues['affiliateid'],$postvalues["report_type_time"],$starttime,$endtime);
					}
					
					if(!empty($healthresult))
					{
						$sumArray = array();
						foreach ($healthresult as $k=>$subArray)
						 {
 						 	foreach ($subArray as $id=>$value) 
 						 	{
  							  	$sumArray[$id]+=$value;
 							}
						}
						
						$sumArray["Time"] = "TOTAL";
						$healthresult[count($healthresult)] = $sumArray;
						$this->view->value = $healthresult;
					}
					else
					{
						$this->_helper->FlashMessenger(array('error' => 'No Records found.'));
					}
				}
				else
				{
					$this->_helper->FlashMessenger(array('error' => 'wrong time entered.'));
				}
			}
		}
		
	}
	
	public function networktransactionsummaryAction()
	{
		$form = new Admin_TransactionSummaryForm();
		$this->view->form = $form->getform();
		
		if ($this->getRequest()->isPost())
		{
			if($form->isValid($_POST))
			{
				$postvalues = $form->getvalues();
				
		
				$starttime = $postvalues['startdate'];
				$newdatetime = new Zend_Date($starttime);
				$starttime = $newdatetime->get(Zend_Date::W3C);
					
				$endtime = $postvalues['enddate'];
				$newdatetime = new Zend_Date($endtime);
				$endtime = $newdatetime->get(Zend_Date::W3C);
		
				if($starttime <= $endtime)
				{
					$syshealth= new SystemHealth();
					$healthresult = $syshealth->gettransactionsummary($postvalues["report_type_time"],$starttime,$endtime);
					
					if(!empty($healthresult))
					{
						$this->view->value = $healthresult;
					}
					else
					{
						$this->_helper->FlashMessenger(array('error' => 'No Records found.'));
					}
				}
				else
				{
					$this->_helper->FlashMessenger(array('error' => 'wrong time entered.'));
				}
			}
		}
	}
	
	public function networkwageringAction()
	{
		$form = new Admin_TransactionSummaryForm();
		$this->view->form = $form->getform();
		$starttime = $this->getRequest()->start_date;
		
		if ($this->getRequest()->isPost())
		{
			if($form->isValid($_POST))
			{
				$postvalues = $form->getvalues();

				$starttime = $postvalues['startdate'];
				$endtime = $postvalues['enddate'];
				
				$newdatetime = new Zend_Date($starttime);
				$starttime = $newdatetime->get(Zend_Date::W3C);
				
				$newdatetime = new Zend_Date($endtime);
		
		
				$nextdatetime = $newdatetime->add(24, Zend_Date::HOUR);
				$newdatetime = new Zend_Date($nextdatetime);
			
				$endtime = $newdatetime->get(Zend_Date::W3C);
				
				/*$nextdatetime = $newdatetime->sub(48, Zend_Date::HOUR);
				$newdatetime = new Zend_Date($nextdatetime);
			
				$previoustime = $newdatetime->get(Zend_Date::W3C);*/
				
				$syshealth= new SystemHealth();
				$healthresult = $syshealth->getnetworkwagerings($starttime , $endtime);
				
				$this->view->displaylinks = "yes";
				//$this->view->nextdate = $endtime;
				//$this->view->previousdate = $previoustime;
						
				if(!empty($healthresult))
				{
					$sumArray = array();
						foreach ($healthresult as $k=>$subArray)
						 {
 						 	foreach ($subArray as $id=>$value) 
 						 	{
  							  	$sumArray[$id]+=$value;
 							}
						}
						
						$sumArray["TIME"] = "TOTAL DAY Wise";
						$healthresult[count($healthresult)] = $sumArray;
						//Zenfox_Debug::dump($healthresult);exit;
						$this->view->value = $healthresult;
						
						
				}
				else
				{
					$this->_helper->FlashMessenger(array('error' => 'No Records found for the data '.$starttime));
				}
				
			}
		}
		elseif(!empty($starttime))
		{
			
				$newdatetime = new Zend_Date($starttime);
				$starttime = $newdatetime->get(Zend_Date::W3C);
		
		
				$nextdatetime = $newdatetime->add(24, Zend_Date::HOUR);
				$newdatetime = new Zend_Date($nextdatetime);
			
				$endtime = $newdatetime->get(Zend_Date::W3C);
				
				$nextdatetime = $newdatetime->sub(48, Zend_Date::HOUR);
				$newdatetime = new Zend_Date($nextdatetime);
			
				$previoustime = $newdatetime->get(Zend_Date::W3C);
				
				$syshealth= new SystemHealth();
				$healthresult = $syshealth->getnetworkwagerings($starttime , $endtime);
				
				$this->view->displaylinks = "yes";
				$this->view->nextdate = $endtime;
				$this->view->previousdate = $previoustime;
				if(!empty($healthresult))
				{
					$sumArray = array();
						foreach ($healthresult as $k=>$subArray)
						 {
 						 	foreach ($subArray as $id=>$value) 
 						 	{
  							  	$sumArray[$id]+=$value;
 							}
						}
						
						$sumArray["Time"] = "TOTAL per DAY";
						$healthresult[count($healthresult)] = $sumArray;
						$this->view->value = $healthresult;
						
						
				}
				else
				{
					
					$this->_helper->FlashMessenger(array('error' => 'No Records found for the data '.$starttime));
				}
		}
		
		
	}
	
	public function trackerplayersAction()
	{
		$form = new Admin_TrackerPlayersForm();
		$this->view->form = $form->getform();
		
		if ($this->getRequest()->isPost())
		{
			if($form->isValid($_POST))
			{
				$postvalues = $form->getValues();
				$playerobj = new Player();
				$playerdata = $playerobj->getTrackerRegistration($postvalues["trackerid"],$postvalues["startdate"],$postvalues["enddate"]);
				$this->view->playerdata = $playerdata;
			}
		}
	}
}