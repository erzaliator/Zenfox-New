<?php

require_once dirname(__FILE__) . '/../forms/SearchForm.php';
require_once dirname(__FILE__).'/../../player/models/TransactionReports.php';
require_once dirname(__FILE__) . '/../forms/DateForm.php';

class Partner_PlayerController extends Zenfox_Controller_Action
{
	public function init()
	{
		parent::init();
	}
	
	public function searchAction()
	{
		$searchForm = new Partner_SearchForm();
		$this->view->searchForm = $searchForm;
		
		$offset = $this->getRequest()->page;
		$player = new Player();
		
		$authSession = new Zenfox_Auth_Storage_Session();
		$sessionData = $authSession->read();
		
		$partnerFrontendId = $sessionData['authDetails'][0]['partner_frontend_id'];
		$partnerId = $sessionData['id'];
		
		$partnerFrontends = new PartnerFrontends();
		$frontendData = $partnerFrontends->getFrontendData($partnerFrontendId);
		
		$allowedFrontendIds = $frontendData['allowed_frontend_ids'];
		$sessionName = 'Searching_' . $partnerId;
		$session = new Zend_Session_Namespace($sessionName);
		
		if($this->getRequest()->isPost())
		{
			if($searchForm->isValid($_REQUEST))
			{
				$offset = 1;
				$data = $searchForm->getValues();
				
				$searchField = $data['searchField'];
				$searchString = $data['searchString'];
				$accountType = $data["accountType"];
				
				$playerId = '';
				switch($data['searchField'])
				{
					case 'player_id':
						$playerId = $data['searchString'];
						break;
					case 'login':
						$playersData = $player->getAllPlayers($data['searchField'], 0, $offset, $data['items'], $session, $data['searchString'], $allowedFrontendIds,$data["accountType"]);
		
						if((count($playersData[1]) == 1) and ($playersData[1][0]['Login Name'] == $data['searchString']))
						{
							$playerId = $playersData[1][0]['Player Id'];
						}
						break;
					case 'email':
						$playersData = $player->getAllPlayers($data['searchField'], 0, $offset, $data['items'], $session, $data['searchString'], $allowedFrontendIds,$data["accountType"]);
						
						if((count($playersData[1]) == 1) and ($playersData[1][0]['Email'] == $data['searchString']))
						{
							$playerId = $playersData[1][0]['Player Id'];
						}
						break;
					case 'first_name':
						$playersData = $player->getPlayersByFirstName($data['searchString'], $data["accountType"],$offset, $data['items'], $allowedFrontendIds);
						
						if((count($playersData[1]) == 1) and ($playersData[1][0]['User Name'] == $data['searchString']))
						{
							$playerId = $playersData[1][0]['Player Id'];
						}
						break;
				}
				if($playerId)
				{
					$this->_redirect('/player/profile/playerId/'.$playerId.'/accountType/'.$data["accountType"]);
				}
			}
			
		}
		elseif($offset)
		{
			$itemsPerPage = $this->getRequest()->item;
			$searchField = $this->getRequest()->field;
			$accountType = $this->getRequest()->accountType;
			$searchString = $this->getRequest()->str;
			 
			if($searchField == 'first_name')
			{
				$playersData = $player->getPlayersByFirstName($searchString,$accountType, $offset, $itemsPerPage,$allowedFrontendIds);
			}
			else
			{
				$playersData = $player->getAllPlayers($searchField, 0, $offset, $itemsPerPage, $session, $searchString, $allowedFrontendIds,$accountType);
			}
			if(!$playersData)
			{
				$this->_redirect($language . '/error/error');
			}
		}
		
		if(isset($playersData[1]))
		{
			if($playersData[1])
			{
				$this->view->paginator = $playersData[0];
				$this->view->searchField = $searchField;
				$this->view->searchStr = $searchString;
				$this->view->accountType = $accountType;
				$this->view->contents = $playersData[1];
			}
			else
			{
				echo "Player not found.";
			}
		}
	}
	
	public function reconcileAction()
	{
		$playerId = $this->getRequest()->id;	
		
		$error = false;
		if(isset($playerId))
		{
			$player = new Player();
			$playerData = $player->getPlayerData($playerId);
			
			$authSession = new Zenfox_Auth_Storage_Session();
			$sessionData = $authSession->read();
			
			$partnerFrontendId = $sessionData['authDetails'][0]['partner_frontend_id'];
			$partnerId = $sessionData['id'];
			
			$partnerFrontends = new PartnerFrontends();
			$frontendData = $partnerFrontends->getFrontendData($partnerFrontendId);
			
			$allowedFrontendIdsString = $frontendData['allowed_frontend_ids'];
			$allowedFrontendIdsArray = explode(',', $allowedFrontendIdsString);
			
			if(!in_array($playerData['frontendId'], $allowedFrontendIdsArray))
			{
				$error = true;
				echo "Sorry! You don't have permission to visit the detail of this player.";
			}
			else
			{
				$reconciliationForm = new Partner_DateForm();
				$reconciliationForm->getElement('playerId')->setValue($playerId);
				$this->view->reconciliationForm = $reconciliationForm;
				
				$offset = $this->getRequest()->page;
				
				$sessionName = 'Searching_' . $partnerId;
				$session = new Zend_Session_Namespace($sessionName);
					
				$transaction = new TransactionReports($playerId);
				$amtString = "";
				$transString = "";
				
				if($this->getRequest()->isPost())
				{
					if($reconciliationForm->isValid($_POST))
					{
						$offset = 1;
						$data = $reconciliationForm->getValues();
							
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
				
						$from_date = $data['from_date'] . ' ' . $data['from_time'];
						$to_date = $data['to_date'] . ' ' . $data['to_time'];
							
						$playerTransactions = $transaction->showTransactions($data['items'], $offset, $from_date, $to_date, $amount_type, $transaction_type);
				
						if(!$playerTransactions[1])
						{
							echo "No record found";
						}
					}
				}
				elseif($offset)
				{
					$itemsPerPage = $this->getRequest()->item;
					$from_date = $this->getRequest()->from;
					$to_date = $this->getRequest()->to;
					$amtString = $this->getRequest()->amT;
					$transString = $this->getRequest()->transT;
					
					$amount_type = explode(',', $amtString);
					$transaction_type = explode(',', $transString);
						
					$playerTransactions = $transaction->showTransactions($itemsPerPage, $offset, $from_date, $to_date, $amount_type, $transaction_type);
					if(!$playerTransactions)
					{
						$this->_redirect('/error/error');
					}
				}
				if(isset($playerTransactions[1]))
				{
					if($playerTransactions[1])
					{
						$this->view->paginator = $playerTransactions[0];
						$this->view->contents = $playerTransactions[1];
						$this->view->from = $from_date;
						$this->view->to = $to_date;
						$this->view->amountType = $amtString;
						$this->view->transactionType = $transString;
						$this->view->playerId = $playerId;
					}
				}
			}
		}
		else
		{
			echo "Please enter a player id. If you don't know the player id, please click on <a href = '/player/search'><b>Seach Player</b></a>";
		}
	}
	
	public function withdrawalAction()
	{
		$dateForm = new Partner_DateForm();
		$this->view->dateForm = $dateForm;
		
		$offset = $this->getRequest()->page;
		
		$authSession = new Zenfox_Auth_Storage_Session();
		$sessionData = $authSession->read();
		
		$partnerFrontendId = $sessionData['authDetails'][0]['partner_frontend_id'];
		$partnerId = $sessionData['id'];
		
		$partnerFrontends = new PartnerFrontends();
		$frontendData = $partnerFrontends->getFrontendData($partnerFrontendId);
		
		$allowedFrontendIds = $frontendData['allowed_frontend_ids'];
		$sessionName = 'Searching_' . $partnerId;
		$session = new Zend_Session_Namespace($sessionName);
		
		$request = new WithdrawalRequest();
		
		$dataArray = array(
				'player_id' => -1,
				'processed' => ''
			);
		
		if($this->getRequest()->isPost())
		{
			if($dateForm->isValid($_POST))
			{
				$offset = 1;
				$data = $dateForm->getValues();
		
				$from_date = $data['from_date'] . ' ' . $data['from_time'];
				$to_date = $data['to_date'] . ' ' . $data['to_time'];
				
				if($data['withdrawal_type'])
				{
					$dataArray['processed'] = implode("','",$data['withdrawal_type']);						
				}
				
				$withdrawlList = $request->adminList($data['items'], $offset, $from_date, $to_date, $session, $dataArray, $allowedFrontendIds);
		
				if(!$withdrawlList[1])
				{
					echo "No record found";
				}
			}
		}
		elseif($offset)
		{
			$itemsPerPage = $this->getRequest()->item;
			$from_date = $this->getRequest()->from;
			$to_date = $this->getRequest()->to;
			$dataArray['processed'] = $this->getRequest()->processed;
		
			$withdrawlList = $request->adminList($itemsPerPage, $offset, $from_date, $to_date, $session, $dataArray, $allowedFrontendIds);
			if(!$withdrawlList)
			{
				$this->_redirect('/error/error');
			}
		}
		if(isset($withdrawlList[1]))
		{
			if($withdrawlList[1])
			{
				$this->view->paginator = $withdrawlList[0];
				$this->view->contents = $withdrawlList[1];
				$this->view->from = $from_date;
				$this->view->to = $to_date;
				$this->view->processed = $dataArray['processed'];
			}
		}
	}
	
	public function profileAction()
	{
		$playerId = $this->getRequest()->playerId;
		$accountType = isset($this->getRequest()->accountType)?$this->getRequest()->accountType:'confirmed';
		
		$player = new Player();
		$playerfrontendid = $player->getfrontendidofplayer($playerId,$accountType);
		
		$authSession = new Zenfox_Auth_Storage_Session();
		$sessionData = $authSession->read();
		
		$partnerFrontendId = $sessionData['authDetails'][0]['partner_frontend_id'];
		$partnerId = $sessionData['id'];
		
		$partnerFrontends = new PartnerFrontends();
		$frontendData = $partnerFrontends->getFrontendData($partnerFrontendId);
		
		$allowedFrontendIdsString = $frontendData['allowed_frontend_ids'];
		$allowedFrontendIdsArray = explode(',', $allowedFrontendIdsString);
		
		if(!in_array($playerfrontendid, $allowedFrontendIdsArray))
		{
			echo "Sorry! you don't have permission to view the profile of this player.";
		}
		
		else
		{
			if($accountType == 'confirmed')
			{
				$accountData = $player->getAccountDetails($playerId);
				$playerData = $player->getPlayerData($playerId);
				
				$i=0;
				
				foreach($accountData as $account)
				{
					$loginTime = $account['last_login'];
					$createdTime = $account['created'];
				
					/* $loginTime = date ("Y-m-d H:i:s", strtotime("$userLogin, + 4 HOUR 30 MINUTE"));
					 $createdTime = date ("Y-m-d H:i:s", strtotime("$accountCreated, + 4 HOUR 30 MINUTE")); */
				
					$translate = Zend_Registry::get('Zend_Translate');
					$table[$i][$translate->translate('Category')] = 'Player Id';
					$table[$i][$translate->translate('Value')] = $playerId;
					
					$i++;
					$table[$i][$translate->translate('Category')] = 'Login Name';
					$table[$i][$translate->translate('Value')] = $account['login'];
					
					$i++;
					$table[$i][$translate->translate('Category')] = 'First Name';
					$table[$i][$translate->translate('Value')] = $playerData['firstName'];
					$table[3][$translate->translate('Category')] = 'Last Name';
					$table[3][$translate->translate('Value')] = $playerData['lastName'];
					$table[4][$translate->translate('Category')] = 'Sex';
					$table[4][$translate->translate('Value')] = $playerData['sex'];
					$table[5][$translate->translate('Category')] = 'DOB';
					$table[5][$translate->translate('Value')] = $playerData['dateOfBirth'];
					$table[6][$translate->translate('Category')] = 'Address';
					$table[6][$translate->translate('Value')] = $playerData['address'];
					$table[7][$translate->translate('Category')] = 'City';
					$table[7][$translate->translate('Value')] = $playerData['city'];
					$table[8][$translate->translate('Category')] = 'State';
					$table[8][$translate->translate('Value')] = $playerData['state'];
					$table[9][$translate->translate('Category')] = 'Pin';
					$table[9][$translate->translate('Value')] = $playerData['pin'];
				
					$table[10][$translate->translate('Category')] = 'Email';
					$table[10][$translate->translate('Value')] = $account['email'];
					$table[11][$translate->translate('Category')] = 'Joining Date';
					$table[11][$translate->translate('Value')] = $createdTime;
					$table[12][$translate->translate('Category')] = 'Last Login';
					$table[12][$translate->translate('Value')] = $loginTime;
					$table[13][$translate->translate('Category')] = 'Balance';
					$table[13][$translate->translate('Value')] = $account['balance'];
					$table[14][$translate->translate('Category')] = 'Bank';
					$table[14][$translate->translate('Value')] = $account['bank'];
					$table[15][$translate->translate('Category')] = 'Winnings';
					$table[15][$translate->translate('Value')] = $account['winnings'];
					$table[16][$translate->translate('Category')] = 'cash';
					$table[16][$translate->translate('Value')] = $account['cash'];
					$table[17][$translate->translate('Category')] = 'Bonus Bank';
					$table[17][$translate->translate('Value')] = $account['bonus_bank'];
					$table[18][$translate->translate('Category')] = 'Bonus Winnings';
					$table[18][$translate->translate('Value')] = $account['bonus_winnings'];
					$table[19][$translate->translate('Category')] = 'Total Deposit';
					$table[19][$translate->translate('Value')] = $account['total_deposits'];
					$table[20][$translate->translate('Category')] = 'Last Deposit';
					$table[20][$translate->translate('Value')] = $account['last_deposit'];
					/*$table[11][$translate->translate('Category')] = 'Last Deposit Amount';
					 $table[11][$translate->translate('Value')] = $lastDeposit;*/
					$table[21][$translate->translate('Category')] = 'Last Winnings';
					$table[21][$translate->translate('Value')] = $account['last_winning'];
					$table[22][$translate->translate('Category')] = 'Last Wagered';
					$table[22][$translate->translate('Value')] = $account['last_wagered'];
					/*$table[14][$translate->translate('Category')] = 'Total Withdrawal';
					 $table[14][$translate->translate('Value')] = $totalWithdrawal+$totalPartialWithdrawal;*/
					$table[23][$translate->translate('Category')] = 'Last Withdrawal';
					$table[23][$translate->translate('Value')] = $account['last_withdrawal'];
					/*$table[16][$translate->translate('Category')] = 'Last Withdrawal Amount';
					 $table[16][$translate->translate('Value')] = $lastWithdrawal+$lastPartialWithdrawal;*/
					$table[24][$translate->translate('Category')] = 'Base Currency';
					$table[24][$translate->translate('Value')] = $account['base_currency'];
					$table[25][$translate->translate('Category')] = 'Tracker Id';
					$table[25][$translate->translate('Value')] = $account['tracker_id'];
					$table[26][$translate->translate('Category')] = 'Phone Number';
					$table[26][$translate->translate('Value')] = $playerData['phone'];
					$table[27][$translate->translate('Category')] = 'Bonus Due';
					$table[27][$translate->translate('Value')] = $account['bonus_due'];
				
					$table[29][$translate->translate('Category')] = 'Loyalty Points';
					$table[29][$translate->translate('Value')] = $account['total_loyalty_points'];
					$table[30][$translate->translate('Category')] = 'Loyalty Points Left';
					$table[30][$translate->translate('Value')] = $account['loyalty_points_left'];
				
					$table[35][$translate->translate('Category')] = 'Buddy Id';
					$table[35][$translate->translate('Value')] = $account['buddy_id'];
				}
			}
			else
			{
				$account = $accountUnconfirm->getAccountDetail($playerId);
				$translate = Zend_Registry::get('Zend_Translate');
					
					
				$table[0][$translate->translate('Category')] = 'Login Name';
				$table[0][$translate->translate('Value')] = $account[0]['login'];
				$table[1][$translate->translate('Category')] = 'Name';
				$table[1][$translate->translate('Value')] = $account[0]['first_name'].' '.$account[0]['last_name'];
				$table[2][$translate->translate('Category')] = 'Email';
				$table[2][$translate->translate('Value')] = $account[0]['email'];
				$table[3][$translate->translate('Category')] = 'Promotions';
				$table[3][$translate->translate('Value')] = $account[0]['promotions'];
				$table[4][$translate->translate('Category')] = 'Expiry Time';
				$table[4][$translate->translate('Value')] = $account[0]['expiry_time'];
				$table[5][$translate->translate('Category')] = 'Created at';
				$table[5][$translate->translate('Value')] = $account[0]['created'];
				$table[6][$translate->translate('Category')] = 'Confirmation Code';
				$table[6][$translate->translate('Value')] = $account[0]['code'];
					
			}
			
			$this->view->contents = $table;
			$this->view->playerId = $playerId;
		}
	}
}