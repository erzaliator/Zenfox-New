<?php
require_once dirname(__FILE__).'/../forms/ReconciliationForm.php';
require_once dirname(__FILE__).'/../../player/models/TransactionReports.php';
class Admin_ReconciliationController extends Zenfox_Controller_Action
{
	public function init()
	{
		parent::init();
		$contextSwitch = $this->_helper->getHelper('contextSwitch');
		$contextSwitch->setAutoJsonSerialization(false);
		$contextSwitch->addActionContext('index', 'json')
             	->initContext();
	}
	
	public function indexAction()
	{
		
		$form = new Admin_ReconciliationForm();
		$playerId = $this->getRequest()->playerId;
		
		$player = new Player();
		//$playerData = $player->getAllAccounts();
		$playerData = "";

		$this->view->form = $form->setupForm($playerData, $playerId);
		$offset = $this->getRequest()->pages;
		if($offset)
		{
			$player = new Player();
			$playerfrontendid = $player->getfrontendidofplayer($playerId);
		
			$authSession = new Zend_Auth_Storage_Session();
			$sessionData = $authSession->read();
			$csrId = $sessionData['id'];
			$groupobj = new CsrGmsGroup();
       		 $csrfrontendids = $groupobj->getFrontendList($csrId,"yes");
			if (!in_array($playerfrontendid,$csrfrontendids))
 			{
 				$this->_helper->FlashMessenger(array('error' => "Player with player id ". $playerId." not found or you are not authorised to view/edit this player's details"));
 			}
 			else 
 			{
				$transaction = new TransactionReports($playerId);
				$itemsPerPage = $this->getRequest()->item;

				$from = $this->getRequest()->from;
				//$from = date ("Y-m-d H:i:s", strtotime("$fromTime, - 5 HOUR 30 MINUTE"));
				$to = $this->getRequest()->to;
				//$to = date ("Y-m-d H:i:s", strtotime("$toTime, - 5 HOUR 30 MINUTE"));

				$amtString = $this->getRequest()->amT;
				$transString = $this->getRequest()->transT;
				$amount_type = explode(',', $amtString);
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
				$this->view->amountType = $amtString;
				$this->view->transactionType = $transString;
				$this->view->playerId = $playerId;
 			}
		}
		
		if($this->getRequest()->isPost())
		{
			if($form->isValid($_POST))
			{ 
				$offset = 1;
				$data = $form->getValues();
				$playerId = $data['player_id'];
				
				$player = new Player();
				$playerfrontendid = $player->getfrontendidofplayer($playerId);
		
				$authSession = new Zend_Auth_Storage_Session();
				$sessionData = $authSession->read();
				$csrId = $sessionData['id'];
				$groupobj = new CsrGmsGroup();
       			 $csrfrontendids = $groupobj->getFrontendList($csrId,"yes");
				if (in_array($playerfrontendid,$csrfrontendids))
 				{
 				
					$transaction = new TransactionReports($playerId);
					$amount_type = array();
					$transaction_type = array();
					if($data['amount_type'])
					{
						foreach($data['amount_type'] as $amount)
						{
							$amount_type[] = $amount;
						}
						$amtString = implode(",", $amount_type);
					}
					if($data['transaction_type'])
					{
						foreach($data['transaction_type'] as $transactions)
						{
							$transaction_type[] = $transactions;
						}
						$transString = implode(",", $transaction_type);
					}
					/*Zenfox_Debug::dump($amtString, 'amt');
					Zenfox_Debug::dump($transString, 'trans', true, true);*/
					$fromDate = $data['from_date'] . ' ' . $data['from_time'];
					//$fromDate = date ("Y-m-d H:i:s", strtotime("$fromTime, - 5 HOUR 30 MINUTE"));

					$toDate = $data['to_date'] . ' ' . $data['to_time'];
	
// 					//$toDate = date ("Y-m-d H:i:s", strtotime("$toTime, - 5 HOUR 30 MINUTE"));
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
					$this->view->amountType = $amtString;
					$this->view->transactionType = $transString;
					$this->view->playerId = $playerId;
				}
				else 
				{
 					$this->_helper->FlashMessenger(array('error' => "Player with player id ". $playerId." not found or you are not authorised to view/edit this player's details"));
				}
			}
		}
	}
}