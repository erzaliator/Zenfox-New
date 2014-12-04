<?php
/**
 * This class is used to display playdorm report
 */

//require_once dirname(__FILE__).'/../forms/DateSelectionForm.php';
class Player_ReportController extends Zenfox_Controller_Action
{
	public function init()
	{
		parent::init();
	}
	
	public function indexAction()
	{
		$transactionType = $this->getRequest()->type;
		$offset = $this->getRequest()->pages;
		$this->view->post = false;
		
		$authSession = new Zenfox_Auth_Storage_Session();
		$sessionData = $authSession->read();
		$playerId = $sessionData['id'];
		
		$transactionReport = new TransactionReports($playerId);

		$reportName = "";
		switch($transactionType)
		{
			case 'CREDIT_DEPOSITS':
				$reportName = "Deposits";
				break;
			case 'WITHDRAWAL_REQUEST':
				$reportName = "Withdrawals";
				break;
			case 'ADJUST_BALANCE':
				$reportName = "Adjust Balance";
				break;
		}
		
		$this->view->reportName = $reportName;
		
		if($this->getRequest()->isPost())
		{
			$data = $_POST;
			
			if($data['p_from_time'] == 'pm' && $data['h_from_time'] != 12)
			{
				$data['h_from_time'] = $data['h_from_time'] + 12;
			}
			if($data['p_from_time'] == 'am' && $data['h_from_time'] == 12)
			{
				$data['h_from_time'] = '00';
			}
			if($data['p_to_time'] == 'pm' && $data['h_to_time'] != 12)
			{
				$data['h_to_time'] = $data['h_to_time'] + 12;
			}
			if($data['p_to_time'] == 'am' && $data['h_to_time'] == 12)
			{
				$data['h_to_time'] = '00';
			}
			
			if($data['p_from_time'] == 'pm')
			{
				$fromPM = true;
			}
			if($data['p_to_time'] == 'pm')
			{
				$toPM = true;
			}
			
			$fromTime = $data['from_date'] . " " . $data['h_from_time'] . ":" . $data['m_from_time'];
			$toTime = $data['to_date'] . " " . $data['h_to_time'] . ":" . $data['m_to_time'];

			$offset = 0;
			$report = $transactionReport->getTransactionsForPlaydorm($transactionType, $fromTime, $toTime, $data['page'], $offset);
			$transactions = $report[1];
			$this->view->paginator = $report[0];
			$this->view->from = $fromTime;
			$this->view->to = $toTime;
			$this->view->post = true;
			
			$this->view->fromDate = $data['from_date'];
			$this->view->toDate = $data['to_date'];
			$this->view->fromHour = $data['h_from_time'];
			$this->fromMinute = $data['m_from_time'];
			$this->view->toHour = $data['h_to_time'];
			$this->view->toMinute = $data['m_to_time'];
			$this->view->fromPM = $fromPM;
			$this->view->toPM = $toPM;
			$this->view->items = $data['page'];
		}
		elseif($offset)
		{
			$fromTime = $this->getRequest()->from;
			$toTime = $this->getRequest()->to;
			$itemsPerPage = $this->getRequest()->item;
			
			$explodeFromTime = explode(" ", $fromTime);
			$fromDate = $explodeFromTime[0];
			$explodeTime = explode(":", $explodeFromTime[1]);
			$fromHour = $explodeTime[0];
			$fromMinute = $explodeTime[1];
			if($fromHour >= 12)
			{
				$fromPM = true;
			}
			
			$explodeToTime = explode(" ", $toTime);
			$toDate = $explodeToTime[0];
			$explodeTime = explode(":", $explodeToTime[1]);
			$toHour = $explodeTime[0];
			$toMinute = $explodeTime[1];
			if($toHour >= 12)
			{
				$toPM = true;
			}
			
			$report = $transactionReport->getTransactionsForPlaydorm($transactionType, $fromTime, $toTime, $itemsPerPage, $offset);
			$transactions = $report[1];
			$this->view->paginator = $report[0];
			$this->view->from = $fromTime;
			$this->view->to = $toTime;
			$this->view->post = true;
			
			$this->view->fromDate = $fromDate;
			$this->view->toDate = $toDate;
			$this->view->fromHour = $fromHour;
			$this->fromMinute = $fromMinute;
			$this->view->toHour = $toHour;
			$this->view->toMinute = $toMinute;
			$this->view->fromPM = $fromPM;
			$this->view->toPM = $toPM;
			$this->view->items = $itemsPerPage;
		}
		else
		{
			$transactions = $transactionReport->getRecentTransactions(5, $transactionType);
			
			$date = new Zend_Date();
			$currentDate = $date->get(Zend_Date::DAY);
			$currentMonth = $date->get(Zend_Date::MONTH);
			$currentYear = $date->get(Zend_Date::YEAR);
			$currentHour = $date->get(Zend_Date::HOUR);
			$currentMinute = $date->get(Zend_Date::MINUTE);
			
			$today = $currentYear . "-" . $currentMonth . "-" . $currentDate;
			$pm = false;
			
			if($currentHour >= 12)
			{
				$pm = true;
			}
			
			$this->view->fromDate = $today;
			$this->view->toDate = $today;
			$this->view->fromHour = 0;
			$this->fromMinute = 0;
			$this->view->toHour = $currentHour;
			$this->view->toMinute = $currentMinute;
			$this->view->fromPM = false;
			$this->view->toPM = $pm;
			$this->view->items = 0;
		}
		$this->view->contents = $transactions;
	}
}
