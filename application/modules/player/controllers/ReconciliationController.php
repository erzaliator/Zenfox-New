<?php
require_once dirname(__FILE__).'/../forms/ReconciliationForm.php';
class Player_ReconciliationController extends Zenfox_Controller_Action
{
	public function init()
	{
		parent::init();
		$contextSwitch = $this->_helper->getHelper('contextSwitch');
		$contextSwitch->addActionContext('index', 'json')
              	->initContext();
	}
	
	public function indexAction()
	{		
		$session = new Zend_Auth_Storage_Session();
		$store = $session->read();
		//$role = explode('-', $store['id']);
		$player_id = $store['id'];
		if(!$player_id)
		{
			$this->_helper->FlashMessenger(array('error' => 'No record found.'));
		}
		$form = new Player_ReconciliationForm();
		$this->view->form = $form;
		//$player_id = $this->getRequest()->id;
		$transaction = new TransactionReports($player_id);
		$lastTransactions = $transaction->getLastTransactions(5);
		$offset = $this->getRequest()->pages;
		if($offset)
		{
			$itemsPerPage = $this->getRequest()->item;
			$from = $this->getRequest()->from;
			$to = $this->getRequest()->to;
			//$amtString = $this->getRequest()->amT;
			$transString = $this->getRequest()->transT;
			//$amount_type = explode(',', $amtString);
			
			//TODO Changed only for rummy
			$amount_type = array();
			$transaction_type = explode(',', $transString);
			$result = $transaction->showTransactions($itemsPerPage, $offset, $from, $to, $amount_type, $transaction_type);
			if(!$result)
			{
				$this->_helper->FlashMessenger(array('error' => $this->view->translate('No record found.')));
			}
			$this->view->paginator = $result[0];
			$this->view->contents = $result[1];
			$this->view->fromDate = $from;
			$this->view->toDate = $to;
			//$this->view->amountType = $amtString;
			$this->view->transactionType = $transString;
			$this->view->post = true;
		}
		else
		{
			$this->view->contents = $lastTransactions;
		}
		if($this->getRequest()->isPost())
		{
			if($form->isValid($_POST))
			{
				$offset = 1;
				$data = $form->getValues();
				$amount_type = array();
				$transaction_type = array();
				/*if($data['amount_type'])
				{
					foreach($data['amount_type'] as $amount)
					{
						$amount_type[] = $amount;
					}
					$amtString = implode(",", $amount_type);
				}*/
				$data['transaction_type'] = array('AWARD_WINNINGS', 'CREDIT_DEPOSITS', 'PLACE_WAGER', 'CREDIT_BONUS', 'WITHDRAWAL_FLOWBACK', 'WITHDRAWAL_REQUEST');
				if($data['transaction_type'])
				{
					foreach($data['transaction_type'] as $transactions)
					{
						$transaction_type[] = $transactions;
					}
					$transString = implode(",", $transaction_type);
				}
				
				$date = new Zend_Date();
				$today = $date->get(Zend_Date::W3C);
				
				$toDate = $today;
				
				$oneWeekAgo = date ("Y-m-d H:i:s", strtotime("$today, - 7 DAY"));
				$oneMonthAgo = date ("Y-m-d H:i:s", strtotime("$today, - 1 MONTH"));
				
				switch($data['reportType'])
				{
					case 'WEEKLY':
						$fromDate = $oneWeekAgo;
						break;
					case 'MONTHLY':
						$fromDate = $oneMonthAgo;
						break;
				}				
				/*Zenfox_Debug::dump($amtString, 'amt');
				Zenfox_Debug::dump($transString, 'trans', true, true);*/
				/* $fromDate = $data['from_date'] . ' ' . $data['from_time'];
				$toDate = $data['to_date'] . ' ' . $data['to_time']; */
				$result = $transaction->showTransactions($data['page'], $offset, $fromDate, $toDate, $amount_type, $transaction_type);
				if(!$result)
				{
					$this->_helper->FlashMessenger(array('error' => $this->view->translate('No record found.')));
				}
				//$result[0]->setCurrentPageNumber(1);
				$this->view->paginator = $result[0];
				$this->view->contents = $result[1];
				$this->view->fromDate = $fromDate;
				$this->view->toDate = $toDate;
				//$this->view->amountType = $amtString;
				$this->view->transactionType = $transString;
				$this->view->post = true;
			}
		}
	}
}