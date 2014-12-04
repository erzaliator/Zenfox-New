<?php
require_once dirname(__FILE__).'/../forms/TransactionForm.php';
class Affiliate_ReportController extends Zenfox_Controller_Action
{
	public function registrationAction()
	{
		$session = new Zenfox_Auth_Storage_Session();
		$sessionData = $session->read();
		$affiliateId = $sessionData['id'];
		
		$sessionName = 'Searching_' . $affiliateId;
		$session = new Zend_Session_Namespace($sessionName);
		$offset = $this->getRequest()->page;
		$download = $this->getRequest()->download;
		
		$affiliateTracker = new AffiliateTracker();
		$affiliateTrackers = $affiliateTracker->getAffiliateTrackersByAffiliateId($affiliateId);

		$form = new Affiliate_TransactionForm();
		$form = $form->getForm($affiliateTrackers);
		$this->view->form = $form;
		
		$accountVariable = new AccountVariable();
		$player = new Player();
		if($this->getRequest()->isPost())
		{
			if($form->isValid($_POST))
			{
				$session->unsetAll();
				$data = $form->getValues();

				$fromDate = $data['fromDate'];
				$toDate = $data['toDate'];
				$fromTime = $data['fromTime'].':00';
				$toTime = $data['toTime'].':00';
				
				$fromTime = $fromDate . ' ' . $fromTime;
				$fromDate = date ("Y-m-d H:i:s", strtotime("$fromTime, - 5 HOUR 30 MINUTE"));
				
				$toTime = $toDate . ' ' . $toTime;
				$toDate = date ("Y-m-d H:i:s", strtotime("$toTime, - 5 HOUR 30 MINUTE"));
				
				
				if($data['tracker'] == -1)
				{
					foreach($affiliateTrackers as $affiliateTracker)
					{
						$trackerIds[] = $affiliateTracker['tracker_id'];
					}
				}
				else
				{
					$trackerIds = array($data['tracker']);
				}
				
				$paginationData = $player->getTrackerRegistration($trackerIds, $fromDate, $toDate, 1, $data['items'], $session);
				$this->view->paginator = $paginationData[0];
				$this->view->content = $paginationData[1];
				$this->view->from = $fromDate;
				$this->view->to = $toDate;
				$this->view->trackerId = implode(",", $trackerIds);
			}
		}
		elseif($offset)
		{
			$itemsPerPage = $this->getRequest()->item;
			$fromDate = $this->getRequest()->from;		
			$toDate = $this->getRequest()->to;
			$trackerId = $this->getRequest()->trackerId;
			$trackerIds = explode(",", $trackerId);		
			$paginationData = $player->getTrackerRegistration($trackerIds, $fromDate, $toDate, $offset, $itemsPerPage, $session);
			$this->view->paginator = $paginationData[0];
			$this->view->content = $paginationData[1];
			$this->view->from = $fromDate;
			$this->view->to = $toDate;
			$this->view->trackerId = $trackerIds;
		}
		elseif($download)
		{
			$fromDate = $this->getRequest()->from;
			$toDate = $this->getRequest()->to;
			$trackerId = $this->getRequest()->trackerId;
			$trackerIds = explode(",", $trackerId);
			$result = $player->getTrackerRegistration($trackerIds, $fromDate, $toDate);
			$excelReport = array();
			$i = 0;
			foreach($result as $reportData)
			{
				$index = 1;
				$i++;
				foreach($reportData as $tagName => $value)
				{
					if($i == 2)
					{
						$i = 1;
					}
					$excelReport[$i][$index] = $tagName;
					if($i == 1)
					{
						$i++;
					}
					$excelReport[$i][$index] = $value;
					$index++;
				}
			}
			$this->view->excelReport = $excelReport;
			$this->view->fromDate = $fromDate;
			$this->view->toDate = $toDate;
			$this->view->download = true;
		}
	}
	
	public function transactionAction()
	{
		echo "in transaction";
	}
}