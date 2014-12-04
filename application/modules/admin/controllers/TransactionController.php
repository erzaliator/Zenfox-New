<?php
require_once dirname(__FILE__).'/../forms/TransactionForm.php';

class Admin_TransactionController extends Zenfox_Controller_Action
{
	public function init()
	{
		parent::init();
		$this->_redirector = $this->_helper->getHelper('Redirector');
        $contextSwitch = $this->_helper->getHelper('contextSwitch');
        $contextSwitch->setAutoJsonSerialization(false);
		$contextSwitch->addActionContext('allplayertransaction', 'json')
					  ->initContext();
       
	}
	public function alltransactionsAction()
	{
		$form = new Admin_TransactionForm();
		$form = $form->getForm();
		$this->view->form = $form;
		$transaction = new AffiliateTransaction();
		$request = $this->getRequest();
		$offset = $request->page;
        $itemsPerPage = $request->item;
        
	 	if(!$offset)
        {
        	$offset = 1;
        }
        else
        {
        	$fromDate = $request->fromDate;
        	$toDate = $request->toDate;
        	$transType = $request->transType;
        	$paginator = $transaction->getAllTransactions($offset,$itemsPerPage,$fromDate,$toDate,$transType);
        	$this->view->paginator = $paginator;
        	$this->view->fromDate = $fromDate;
        	$this->view->toDate = $toDate;
        	$this->view->transType = $transType;
        }
		if($request->isPost())
		{
			if($form->isValid($_POST))
			{
				$data = $form->getValues();
				$fromDate = $data['fromDate'];
				$toDate = $data['toDate'];
				$transType = $data['transType'];
				if($data['fromTime'])
					$fromTime = $data['fromTime'].':00';
				else
					$fromTime = '';
				if($data['toTime'])
					$toTime = $data['toTime'].':00';
				else
					$toTime = '';
				if($fromDate)
					$fromDate = $fromDate.' '.$fromTime;
				else
					$fromDate = '';
				if($toDate)
					$toDate = $toDate.' '.$toTime;
				else
					$toDate = '';
				$itemsPerPage = $data['items'];
				$paginator = $transaction->getAllTransactions($offset,$itemsPerPage,$fromDate,$toDate,$transType);
				$this->view->paginator = $paginator;
				$this->view->fromDate = $fromDate;
        		$this->view->toDate = $toDate;
        		$this->view->transType = $transType;
			}
		}
	}
	
	
	public function allplayertransactionAction()
	{
		$player = new Player();
		$playerData = $player->getAllAccounts();
	// Zenfox_Debug::dump('in' , 'true',true,true);
	 	$download = $this->getRequest()->download;
		$transaction = new AuditReport();
		$form = new Admin_TransactionForm();
		$form = $form->getForm($playerData);
		$this->view->form = $form;
		
		$offset = $this->getRequest()->pages;
		if($offset)
		{
			$playerId = $this->getRequest()->id;
			$itemsPerPage = $this->getRequest()->item;
			$from = $this->getRequest()->from;
			$to = $this->getRequest()->to;
			$status = $this->getRequest()->status;
			$transType = $this->getRequest()->transT;
			//$amount_type = explode(',', $amtString);
			$result = $transaction->getTransactionData($offset ,$itemsPerPage, $from, $to, $transType, $status, $playerId);
			if(!$result)
			{
				$this->_helper->FlashMessenger(array('error' => $this->view->translate('No record found.')));
			}
			$this->view->paginator = $result[0];
			$this->view->contents = $result[1];
			$this->view->fromDate = $from;
			$this->view->toDate = $to;
			//$this->view->amountType = $amtString;
			$this->view->transactionType = $transType;
			$this->view->playerId = $playerId;
			$this->view->status = $status;
		}
		
		
		if(!$download)
		{
			if($this->getRequest()->isPost())
			{ //print_r($_POST);exit();
				$data = $_POST;
				$fromDate = $data['fromDate'] . ' ' . $data['fromTime'].':00';
				//setcookie('data[start_date]',$fromDate,time() + (86400 * 30),'/','.'.$_SERVER['HTTP_HOST']);
				$toDate =  $data['toDate'] . ' ' . $data['toTime'].':00';
				//setcookie('data[end_date]',$toDate,time() + (86400 * 30),'/','.'.$_SERVER['HTTP_HOST']);
				$itemsPrePage = $data['items'];
				//setcookie('data[items]',$itemsPrePage,time() + (86400 * 30),'/','.'.$_SERVER['HTTP_HOST']);
				$transType = implode(',',$data['transType']);
				//setcookie('data[trans_type]',$transType,time() + (86400 * 30),'/','.'.$_SERVER['HTTP_HOST']);
				$status = implode(',',$data['status']);
				
				//setcookie('data[status]',implode('*',$status),time() + (86400 * 30),'/','.'.$_SERVER['HTTP_HOST']);
				$playerId = $data['player_id'];
				//setcookie('data[player_id]',$playerId,time() + (86400 * 30),'/','.'.$_SERVER['HTTP_HOST']);
				
				$start = $_REQUEST["start"]?$_REQUEST["start"]:0;
	        	$offset = $start/$data['items_per_page'] + 1 ;
				//echo $playerId; exit();
				$result = $transaction->getTransactionData($offset ,'10', $fromDate, $toDate, $transType, $status, $playerId);
				$this->view->paginator = $result[0];
				$this->view->contents = $result[1];
				$this->view->fromDate = $fromDate;
				$this->view->toDate = $toDate;
				//$this->view->amountType = $amtString;
				$this->view->transactionType = $transType;
				$this->view->playerId = $playerId;
				$this->view->status = $status;
			}
		}
		//$transactions = $transaction->getTransactionData($offset ,'15',' 2010-01-18 22:37',' 2011-01-20 00:00','PLACE_WAGER',$status);
		if($download)
		{
			$fromDate = $_COOKIE['data']['start_date'];
			$toDate = $_COOKIE['data']['end_date'];
			$transType = $_COOKIE['data']['trans_type'];
			$status = $_COOKIE['data']['status'];
			$playerId = $_COOKIE['data']['player_id'];
			//echo $playerId.'<br>';
			$offset = 0;
			$status = explode('*',$status);
			/*print_r($playerId);
			exit();*/
			$index = 3;
			$transactions = $transaction->getTransactionData($offset ,'10', $fromDate, $toDate, $transType, $status, $playerId, $download);
		    
			$sheet[1][1] = 'Player ID';
			$sheet[1][2] = 'Transaction Type';
			$sheet[1][3] = 'Transaction Status';
			$sheet[1][4] = 'Amount Type';
			$sheet[1][5] = 'Amount';			
			foreach($transactions as $key=>$value)
			{
				$sheet[$index][1] =  $value['player_id'];
				$sheet[$index][2] = $value['transaction_type'];
				$sheet[$index][3] = $value['transaction_status'];
				$sheet[$index][4] = $value['amount_type'];
				$sheet[$index][5] = $value['amount'];
				$index++;
			}
		//	print_r($sheet);exit();
			$this->view->sheet = $sheet;
			/*Zenfox_Debug::dump($sheet,'sheet array');
			exit();*/
		}
		if(count($transactions) == 0)
		{
		 	$this->view->transactions = 'null';
		}
		else
		{
			
			$this->view->transactions = $transactions;
		}
		
	
	}
}