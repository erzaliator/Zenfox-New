<?php
require_once(dirname(__FILE__) . '/../forms/HealthForm.php');


class Admin_HealthController extends Zenfox_Controller_Action
{
	public function systemhealthAction()
	{
		$form = new Admin_HealthForm();
		$tags = new SystemTag();
			$taglist = $tags->getSystemTags();
			$length=count($taglist);
		
			while($length > 0)
			{
				
				$newtaglist[$taglist[$length-1]['tagname']] = $taglist[$length-1]['tagname'];
				$length--;
			}
			
			$form->setvalue($newtaglist);
			$this->view->form = $form->getform();
			$offset = $this->getRequest()->page;
			$health= new SystemHealth();
				
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
					$offset = 1;
					$healthresult = $health->gethealth($postvalues["tag"],$postvalues["report_type"],$starttime,$endtime,$offset,$postvalues["items"]);
						
					if(!empty($healthresult))
					{
						$this->view->value=$healthresult[1];
						$this->view->paginator = $healthresult[0];
						$this->view->tag = $postvalues["tag"];
						$this->view->reporttype = $postvalues["report_type"];
						$this->view->starttime = $starttime;
						$this->view->endtime = $endtime;
						$this->view->itemsperpage = $postvalues["items"];
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
		elseif($offset)
		{
			
			$items = $this->getRequest()->itemsperpage;
			$tag = $this->getRequest()->tag;
			$starttime = $this->getRequest()->starttime;
			$reporttype = $this->getRequest()->reporttype;
			$endtime = $this->getRequest()->endtime;
			$healthresult = $health->gethealth($tag,$reporttype,$starttime,$endtime,$offset,$items);
							
			
			
			$this->view->value=$healthresult[1];
			$this->view->paginator = $healthresult[0];
			$this->view->tag = $tag;
			$this->view->reporttype = $reporttype;
			$this->view->starttime = $starttime;
			$this->view->endtime = $endtime;
			$this->view->itemsperpage = $items;
		}
		
		
	}
	
	
	
	public function playerhealthAction()
	{
		$form = new Admin_HealthForm();
		$tags = new SystemTag();
		$taglist = $tags->getPlayerTags();
		$length = count($taglist);
			
		while($length > 0)
			{
				
				$newtaglist[$taglist[$length-1]['tagname']] = $taglist[$length-1]['tagname'];
				$length--;
			}
			
		$form->setvalue($newtaglist);
		$this->view->form = $form->getform();
		$offset = $this->getRequest()->page;
		$health= new PlayerHealth();
		
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
					$offset = 1;
					$healthresult = $health->gethealth($postvalues["tag"],$postvalues["report_type"],$starttime,$endtime,$offset,$postvalues["items"]);
						
					if(!empty($healthresult))
					{
						$this->view->value=$healthresult[1];
						$this->view->paginator = $healthresult[0];
						$this->view->tag = $postvalues["tag"];
						$this->view->reporttype = $postvalues["report_type"];
						$this->view->starttime = $starttime;
						$this->view->endtime = $endtime;
						$this->view->itemsperpage = $postvalues["items"];
							
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
		elseif($offset)
		{
				
			$items = $this->getRequest()->itemsperpage;
			$tag = $this->getRequest()->tag;
			$starttime = $this->getRequest()->starttime;
			$reporttype = $this->getRequest()->reporttype;
			$endtime = $this->getRequest()->endtime;
			$healthresult = $health->gethealth($tag,$reporttype,$starttime,$endtime,$offset,$items);
				
				
				
			$this->view->value=$healthresult[1];
			$this->view->paginator = $healthresult[0];
			$this->view->tag = $tag;
			$this->view->reporttype = $reporttype;
			$this->view->starttime = $starttime;
			$this->view->endtime = $endtime;
			$this->view->itemsperpage = $items;
		}
	}
	
	
	
	public function trackerhealthAction()
	{
		
		$form = new Admin_HealthForm();
		$tags = new SystemTag();
		$taglist = $tags->getTrackerTags();
		$length=count($taglist);
			
		while($length > 0)
			{
				
				$newtaglist[$taglist[$length-1]['tagname']] = $taglist[$length-1]['tagname'];
				$length--;
			}
			
		$form->setvalue($newtaglist);
		$this->view->form = $form->getform();
		$offset = $this->getRequest()->page;
		$health= new TrackerHealth();
		
		
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
					$offset = 1;
					$healthresult = $health->gethealth($postvalues["tag"],$postvalues["report_type"],$starttime,$endtime, $offset,$postvalues["items"]);
			
					if(!empty($healthresult))
					{
						$this->view->value=$healthresult[1];
						$this->view->paginator = $healthresult[0];
						$this->view->tag = $postvalues["tag"];
						$this->view->reporttype = $postvalues["report_type"];
						$this->view->starttime = $starttime;
						$this->view->endtime = $endtime;
						$this->view->itemsperpage = $postvalues["items"];
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
		elseif($offset)
		{
	
			$items = $this->getRequest()->itemsperpage;
			$tag = $this->getRequest()->tag;
			$starttime = $this->getRequest()->starttime;
			$reporttype = $this->getRequest()->reporttype;
			$endtime = $this->getRequest()->endtime;
			$healthresult = $health->gethealth($tag,$reporttype,$starttime,$endtime,$offset,$items);
	
	
	
			$this->view->value=$healthresult[1];
			$this->view->paginator = $healthresult[0];
			$this->view->tag = $tag;
			$this->view->reporttype = $reporttype;
			$this->view->starttime = $starttime;
			$this->view->endtime = $endtime;
			$this->view->itemsperpage = $items;
		}
		
	
}
}