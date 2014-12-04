<?php
//FIXME put the player model in application/model
require_once dirname(__FILE__).'/../forms/PlayerProfileForm.php';
require_once dirname(__FILE__).'/../forms/UserForm.php';
require_once dirname(__FILE__).'/../forms/UserBalanceForm.php';
require_once dirname(__FILE__).'/../forms/CreditBonusForm.php';
require_once dirname(__FILE__).'/../../player/models/TransactionReports.php';
require_once dirname(__FILE__).'/../forms/JournalDataForm.php';
require_once dirname(__FILE__).'/../models/AccountDetail.php';
class Admin_PlayerController extends Zenfox_Controller_Action
{
	public function init()
	{
		parent::init();
		$this->_redirector = $this->_helper->getHelper('Redirector');
        $contextSwitch = $this->_helper->getHelper('contextSwitch');
         $contextSwitch->setAutoJsonSerialization(false);
		$contextSwitch->addActionContext('index', 'json')
						->addActionContext('view', 'json')
						->addActionContext('adjustbalance', 'json')
						->addActionContext('confirmplayer', 'json')
						->addActionContext('buddy', 'json')
						->addActionContext('transactiondetail', 'json')						
              	->initContext();
	}
	
	public function indexAction()
	{
		$language = $this->getRequest()->getParam('lang');		
		$player = new Player();
	 	$form = new Admin_UserForm();
        $this->view->form = $form;
        $offset = $this->getRequest()->page;
        $itemsPerPage = $this->getRequest()->item;        
        $offset = $this->getRequest()->pages;         
        if($offset)
        {        
        	$searchField = $this->getRequest()->field;
        	$match = $this->getRequest()->match;
        	$accountType = $this->getRequest()->accountType;
        	$searchString = $this->getRequest()->str;
        	$playersData = $player->getAllPlayers($searchField, $match, $accountType, $offset, $itemsPerPage, $searchString);
        	if(!$playersData)
        	{
        		$this->_redirect($language . '/error/error');
        	}
        	$this->view->paginator = $playersData[0];
        	//$this->view->items = $itemsPerPage;
        	$this->view->searchField = $searchField;
        	$this->view->match = $match;
        	$this->view->searchStr = $searchString;
        }
        //$this->view->offset = $offset;
        if($this->getRequest()->isPost())
        {
        	if($form->isValid($_POST))
        	{
        		$data = $form->getValues();
        		$offset = 1;
        		$playersData = $player->getAllPlayers($data['searchField'], $data['match'], $data['accountType'] ,$offset, $data['items'], $data['searchString']);
        		if(!$playersData)
        		{
        			$this->_redirect($language . '/error/error');
        		}
        		$this->view->searchField = $data['searchField'];
        		$this->view->match = $data['match'];
        		$this->view->items = $data['items'];
        		$this->view->accountType = $data['accountType'];
        		$this->view->searchStr = $data['searchString'];
        		$this->view->paginator = $playersData[0];
        		$this->view->contents = $playersData[1];        		
        		if(count($playersData[1]) == 1)
        		{
        			foreach($playersData[1] as $info){        				
						$id = $info['Player Id'];						
					}							
					$type = $data['accountType'];								
					$this->_redirect("en_GB/player/view/playerId/$id/accountType/$type");
        		}
        		//$this->view->items = $data['items'];
        	}
        }
	}
	
	public function viewAction()
	{
		$playerId = $this->getRequest()->playerId;
		$accountType = isset($this->getRequest()->accountType)?$this->getRequest()->accountType:'confirmed';
	//	echo $playerId;exit();
		if(isset($_POST['status']))
		{
			$status = $_POST['status'];
		}
		$player = new Player();
		//Called getPlayerData method of Player model to get complete player details.
		
		$player = new Player();
		$playerfrontendid = $player->getfrontendidofplayer($playerId,$accountType);
		$authSession = new Zend_Auth_Storage_Session();
		$sessionData = $authSession->read();
		$csrId = $sessionData['id'];
		$csrfrontendids = $sessionData['frontend_ids'];
		if(!in_array($playerfrontendid,$csrfrontendids))
 		{
 			$this->_helper->FlashMessenger(array('error' => "Player with player id ". $playerId." not found or you are not authorised to view/edit this player's details"));
 			$this->view->csrpermission = "yes";
 		}
 		else 
 		{
			
	
			if(isset($status))
			{
				echo $player->changeStatus($playerId, $status);
				
			}
			
			//$accountType = 'confirmed';
			$insertCsrNote = $this->getRequest()->insertCsrNote;
			$auditRepot = new AuditReport();
			$totalDeposit = 0;
			$totalWithdrawal = 0;
			$totalPartialWithdrawal = 0;
		
		
			$accountUnconfirm = new AccountUnconfirm();

			//new added Sundeep 
			$journal = new Journal();
			$journalform = new Admin_JournalDataForm();
			$this->view->form = $journalform->getform();
			$note = $this->getRequest()->value;
			$playerid = $this->getRequest()->playerId;
			$session = new Zenfox_Auth_Storage_Session();
			$store = $session->read();
			$csrId = $store['authDetails'][0]['id'];
			if(!empty($this->getRequest()->value))
			{
				$journal->insertnote($note , $playerid ,$csrId );	
			}
			$journaldata = $journal->getnotes($playerid);
			$length = count($journaldata);
			$csr = new Csr();
			$csrname = array();
			while($length>0)
			{
				$csrdata = $csr->getInfo($journaldata[$length-1]["csr_id"]);
				$csrname[$length-1]["csrname"] = $csrdata[0]["alias"];
				$csrname[$length-1]["note"] = $journaldata[$length-1]["note"];
				$csrname[$length-1]["create time"] = $journaldata[$length-1]["created"];
				$length--;		
			}
			$this->view->csrName = $csrname;
	
		
			$accountdetailobject = new AccountDetail();
		
			$buddyslist = $accountdetailobject->getbuddyslist($playerid);
		
		
			$length = count($buddyslist);
			while($length>0)
			{
				$innerlengths[$length-1]=count($buddyslist[$length-1]);
				$length--;
			
			}
		
		
			$tempindex=0;
			$length = count($buddyslist);
			$buddydata = array();
			while($length>0)
			{
				while($innerlengths[$length-1]>0)
				{
					$buddydata[$tempindex]["player_id"] = $buddyslist[$length-1][$innerlengths[$length-1]-1]["player_id"];
					$buddydata[$tempindex]["email"] = $buddyslist[$length-1][$innerlengths[$length-1]-1]["email"];
					$buddydata[$tempindex]["loginname"] = $buddyslist[$length-1][$innerlengths[$length-1]-1]["login"];
					$tempindex++;
					$innerlengths[$length-1]--;
				}
				$length--;
			}
			$this->view->buddys = $buddydata;
			//added till here
		
			//sundeep code adding ipproof tables
			$kycobj = new Kyc();
			$kycdata = $kycobj->getkycminidetails($playerId);
		
			$count = count($kycdata);
			$count--;
			$detailskyc = array();
			while($count>=0)
			{
				$detailskyc[$count]['proof'] = $kycdata[$count]['type'];
		
				if($kycdata[$count]['kyc_document'] == "OTHER")
				{
					$detailskyc[$count]['IDtype'] = $kycdata[$count]['kyc_document_other'];
					$detailskyc[$count]['IDnumber'] = $kycdata[$count]['kyc_document_number'];
					$detailskyc[$count]['ExpiryDate'] = $kycdata[$count]['expiry_date'];
				}
				else
				{
					$detailskyc[$count]['IDtype'] = $kycdata[$count]['kyc_document'];
					$detailskyc[$count]['IDnumber'] = $kycdata[$count]['kyc_document_number'];
					$detailskyc[$count]['ExpiryDate'] = $kycdata[$count]['expiry_date'];
				}
				$detailskyc[$count]['Status'] = $kycdata[$count]['status'];
		
				$count--;
			}
			
			
			$this->view->ids = $detailskyc;
		
			//till hear- june 28 2012
		
			//sundeep code for bank details table 
		
			$bankdetailsobj = new BankDetails();
		
			$bankdetails = $bankdetailsobj->getbankminidetails($playerId);
			$this->view->bankdetails = $bankdetails;
		
			//till here august 7 2012
			if($accountType == 'confirmed')
			{
			/*$depositData = $auditRepot->getTransaction($playerId, 'CREDIT_DEPOSITS');
			foreach($depositData as $key=>$value)
			{
				if($key == 0) $lastDeposit = $depositData[$key]['amount'];
				
				$totalDeposit = $totalDeposit + $depositData[$key]['amount'];
			}
			
			$withdrawalData = $auditRepot->getTransaction($playerId, 'WITHDRAWAL_ACCEPT');
			foreach($withdrawalData as $key=>$value)
			{
				if($key == 0) $lastWithdrawal = $withdrawalData[$key]['amount'];
				
				$totalWithdrawal = $totalWithdrawal + $withdrawalData[$key]['amount'];
			}
			
			$partialWithdrawalData = $auditRepot->getTransaction($playerId, 'WITHDRAWAL_PARTIAL_ACCEPT');
			foreach($partialWithdrawalData as $key=>$value)
			{
				if($key == 0) $lastPartialWithdrawal = $partialWithdrawalData[$key]['amount'];
				
				$totalPartialWithdrawal = $totalPartialWithdrawal + $partialWithdrawalData[$key]['amount'];
			}
			
			$transaction = array(	'Total Deposit'=>$totalDeposit, 'Last Deposite'=>$lastDeposit, 
								 	'Total Withdrawal'=>$totalWithdrawal+$totalPartialWithdrawal, 'Last Withdrawal'=>$lastWithdrawal+$lastPartialWithdrawal
								);
			
			
			$this->view->transaction = $transaction;
			
			$loyaltyPoints = $auditRepot->getTransaction($playerId);
			$this->view->loyaltyPoints = $loyaltyPoints[0]['total_loyalty_points'];
		
				
			*/
						
			$accountData = $player->getAccountDetails($playerId);
			$playerData = $player->getPlayerData($playerId);
			
			$transaction = new TransactionReports($playerId);
			
			$date = new Zend_Date();
			$today = $date->get(Zend_Date::W3C);
			$explodeToday = explode('T', $today);
			$currentDate = $explodeToday[0];
			$currentTime = $explodeToday[1];
			
			$to = $currentDate . ' ' . $currentTime;
			$from = $accountData[0]['created'];
			$transType = array('AWARD_WINNINGS','CREDIT_DEPOSITS','PLACE_WAGER','CREDIT_BONUS','WITHDRAWAL_REQUEST','WITHDRAWAL_FLOWBACK','WITHDRAWAL_ACCEPT','WITHDRAWAL_REJECT', 'LOCK_FUNDS', 'UNLOCK_FUNDS', 'PLACE_WAGER_LOCK', 'AWARD_WINNINGS_LOCK');
			$amountType = array('REAL','BONUS','BOTH');
			if($playerId != 2463)
			{
				$allTransactions = $transaction->getLastTransactions(5);
				$this->view->playerTransactions = $allTransactions;
			}
			
			$playerGamelog = new PlayerGamelog();
			$gameHistory = $playerGamelog->getPlayerGameHistory($playerId, 0, 5);
			$recentGameHistory = array();
			$index = 0;
			if(count($gameHistory[1]) > 5)
			{
				foreach($gameHistory[1] as $playerGameHistory)
				{
					if($index == 5)
					{
						break;
					}
					$recentGameHistory[$index]['Player Id'] = $playerGameHistory['Player Id'];
					$recentGameHistory[$index]['Game Type'] = $playerGameHistory['Game Type'];
					$recentGameHistory[$index]['Flavour'] = $playerGameHistory['Flavour'];
					$recentGameHistory[$index]['Result'] = $playerGameHistory['Result'];
					$recentGameHistory[$index]['Wagered Amount'] = $playerGameHistory['Wagered Amount'];
					$recentGameHistory[$index]['Time'] = $playerGameHistory['Time'];
					$index++;
				}
			}
			else
			{
				$recentGameHistory = $gameHistory[1];
			}
			
			
				$this->view->gameHistory = $recentGameHistory;
			
				$this->view->accountData = $accountData; 
 			
			

			$accountVariable = new AccountVariable();
			$varName = 'freeMoney';
			$variableData = $accountVariable->getData($playerId, $varName);
			$freeMoney = $variableData['varValue'];

			$tournamentRegisteration = new TournamentRegistrations();
			$lastRegisteredTournament = $tournamentRegisteration->getLastRegisteredTournament($playerId);
			
			$lastWithdrawAmount = 0;
			$lastWithdrawalAccepted = "";
			$withdrawalRequest = new WithdrawalRequest();
			$withdrawalRequestData = $withdrawalRequest->getWithdrawalsByPlayerId($playerId);
			if($withdrawalRequestData['success'])
			{
				$totalWithdrawal = $withdrawalRequestData['totalAmount'];
				$lastWithdrawalAccepted = $withdrawalRequestData['lastAccepted'];
				$lastWithdrawAmount = $withdrawalRequestData['lastWithdraw'];
			}
			foreach($accountData as $account)	
			{
				$loginTime = $account['last_login'];
				$createdTime = $account['created'];
				
				$i=0;
				
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
				$i++;
				$table[$i][$translate->translate('Category')] = 'Last Name';
				$table[$i][$translate->translate('Value')] = $playerData['lastName'];
				$i++;
				$table[$i][$translate->translate('Category')] = 'Sex';
				$table[$i][$translate->translate('Value')] = $playerData['sex'];
				$i++;
				$table[$i][$translate->translate('Category')] = 'DOB';
				$table[$i][$translate->translate('Value')] = $playerData['dateOfBirth'];
				$i++;
				$table[$i][$translate->translate('Category')] = 'Address';
				$table[$i][$translate->translate('Value')] = $playerData['address'];
				$i++;
				$table[$i][$translate->translate('Category')] = 'City';
				$table[$i][$translate->translate('Value')] = $playerData['city'];
				$i++;
				$table[$i][$translate->translate('Category')] = 'State';
				$table[$i][$translate->translate('Value')] = $playerData['state'];
				$i++;
				$table[$i][$translate->translate('Category')] = 'Pin';
				$table[$i][$translate->translate('Value')] = $playerData['pin'];
				$i++;
				$table[$i][$translate->translate('Category')] = 'Country';
				$table[$i][$translate->translate('Value')] = $playerData['country'];
				$i++;
				$table[$i][$translate->translate('Category')] = 'Email';
				$table[$i][$translate->translate('Value')] = $account['email'];
				$i++;
				$table[$i][$translate->translate('Category')] = 'Joining Date';
				$table[$i][$translate->translate('Value')] = $createdTime;
				$i++;
				$table[$i][$translate->translate('Category')] = 'Last Login';
				$table[$i][$translate->translate('Value')] = $loginTime;
				$i++;
				$table[$i][$translate->translate('Category')] = 'Balance';
				$table[$i][$translate->translate('Value')] = $account['balance'];
				$i++;
				$table[$i][$translate->translate('Category')] = 'Bank';
				$table[$i][$translate->translate('Value')] = $account['bank'];
				$i++;
				$table[$i][$translate->translate('Category')] = 'Winnings';
				$table[$i][$translate->translate('Value')] = $account['winnings'];
				$i++;
				$table[$i][$translate->translate('Category')] = 'cash';
				$table[$i][$translate->translate('Value')] = $account['cash'];
				$i++;
				$table[$i][$translate->translate('Category')] = 'Bonus Bank';
				$table[$i][$translate->translate('Value')] = $account['bonus_bank'];
				$i++;
				$table[$i][$translate->translate('Category')] = 'Bonus Winnings';
				$table[$i][$translate->translate('Value')] = $account['bonus_winnings'];
				$i++;
				$table[$i][$translate->translate('Category')] = 'Total Deposit';
				$table[$i][$translate->translate('Value')] = $account['total_deposits'];
				$i++;
				$table[$i][$translate->translate('Category')] = 'Last Deposit';
				$table[$i][$translate->translate('Value')] = $account['last_deposit'];
				$i++;
				$table[$i][$translate->translate('Category')] = 'Last Winnings';
				$table[$i][$translate->translate('Value')] = $account['last_winning'];
				$i++;
				$table[$i][$translate->translate('Category')] = 'Last Wagered';
				$table[$i][$translate->translate('Value')] = $account['last_wagered'];
				$i++;
				$table[$i][$translate->translate('Category')] = 'Last Withdrawal';
				$table[$i][$translate->translate('Value')] = $account['last_withdrawal'];
				$i++;
				$table[$i][$translate->translate('Category')] = 'Base Currency';
				$table[$i][$translate->translate('Value')] = $account['base_currency'];
				$i++;
				$table[$i][$translate->translate('Category')] = 'Tracker Id';
                $table[$i][$translate->translate('Value')] = $account['tracker_id'];
                $i++;
				$table[$i][$translate->translate('Category')] = 'Phone Number';
				$table[$i][$translate->translate('Value')] = $playerData['phone'];
				$i++;
				$table[$i][$translate->translate('Category')] = 'Bonus Due';
                $table[$i][$translate->translate('Value')] = $account['bonus_due'];
                $i++;
				$table[$i][$translate->translate('Category')] = 'Free Money';
				$table[$i][$translate->translate('Value')] = $freeMoney;
				$i++;
				$table[$i][$translate->translate('Category')] = 'Loyalty Points';
				$table[$i][$translate->translate('Value')] = $account['total_loyalty_points'];
				$i++;
				$table[$i][$translate->translate('Category')] = 'Loyalty Points Left';
				$table[$i][$translate->translate('Value')] = $account['loyalty_points_left'];
				$i++;
				$table[$i][$translate->translate('Category')] = 'Total Withdrawal Accepted';
				$table[$i][$translate->translate('Value')] = $totalWithdrawal;
				$i++;
				$table[$i][$translate->translate('Category')] = 'Last Withdrawal Accepted';
				$table[$i][$translate->translate('Value')] = $lastWithdrawalAccepted;
				$i++;
				$table[$i][$translate->translate('Category')] = 'Last Withdrawal Amount';
				$table[$i][$translate->translate('Value')] = $lastWithdrawAmount;
				$i++;
				$table[$i][$translate->translate('Category')] = 'Last Registered Tournament';
				if($lastRegisteredTournament)
				{
					$table[$i][$translate->translate('Value')] = $lastRegisteredTournament['name'] . ' | ' . $lastRegisteredTournament['registrationTime'];
				}
				else
				{
					$table[$i][$translate->translate('Value')] = "No Registered Tournament Yet";
				}
				$i++;
				// Added buddy_id to the list

				$table[$i][$translate->translate('Category')] = 'Buddy Id';
                $table[$i][$translate->translate('Value')] = $account['buddy_id'];
              	switch($account['status'])
                {
                	case 'ENABLED':
                    	$status = 'DISABLED';
                    	break;
                    case 'DISABLED':
                    	$status = 'ENABLED';
                    	break;
                }
                $i++;
                $form = '<form action="/player/view/playerId/' . $playerId . '" method = "POST"><input type="submit" name="status" value="' . $status . '"></form>';
                $table[$i][$translate->translate('Category')] = 'Status';
                $table[$i][$translate->translate('Value')] = $account['status'] . $form;
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
			$this->view->code = $account[0]['code'];
		}
		$playerData = $player->getPlayerData($playerId);
		//Zend_Layout::getMvcInstance()->disableLayout();\
		
		//$csrNoteObj = new Journal();
		//$csrNotes = $csrNoteObj->getDataByPlayerId($playerId);
		
		//$this->view->csrNotes = $csrNotes;
		
			$this->view->contents = $table;
			$this->view->playerData = $playerData;
			$this->view->accountType = $accountType;
			$this->view->playerId = $playerId; 	
		
			

		if($insertCsrNote == 'true')
		{
			if($this->getRequest()->isPost())
			{
				$session = new Zenfox_Auth_Storage_Session();
		 		$store = $session->read();
				$csrId = $store['authDetails'][0]['id'];
				$date = new Zend_Date;
				$playerId = $this->getRequest()->playerId;
				$msg = $_POST['note'];
				$data = array('csrId'=>$csrId, 'playerId'=>$playerId, 'msg'=>$msg, 'date'=>$date);
				$insert = $csrNoteObj->insertData($data);
				$this->view->csrNote = $insert;
				//Zenfox_Debug::dump($insert, 'post',true,true);
			}
			
		}
 		}
 		
	}
	
	public function adjustbalanceAction()
	{
		
		
		$playerId = $this->getRequest()->playerId;
		$from = $this->getRequest()->format;
		$player = new Player();
		$playerTransaction = new PlayerTransactions();
		$data = $player->getAccountDetails($playerId);	
		
		$form = new Admin_UserBalanceForm();
		$this->view->form = $form->setupForm($data[0]);
		$offset = $this->getRequest()->page;
		
		$dataArray = array();
		if($this->getRequest()->isPost())
		{
			if($form->isValid($_POST))
			{//Zenfox_Debug::dump($form->getValues(), 'POST VALID', true, true);
				$this->view->valid = 'valid';
				
				$newData = $form->getValues();
				/*Zenfox_Debug::dump($newData, 'formData');
				Zenfox_Debug::dump($_POST, 'post', true, true);*/
				//Zenfox_Debug::dump(intval($newData['bank']), 'timezone', true, true);	
				if($data[0]['bank'] != $newData['bank'])
				{
					if($from == 'json')
					{
						if($_POST['bank_action'] == 'DEBIT')
						$newData['bank'] = $data[0]['bank'] + $newData['bank'];
						if($_POST['bank_action'] == 'CREDIT')
						$newData['bank'] = $data[0]['bank'] - $newData['bank'];
					}
					
					//Zenfox_Debug::dump($newData['bank'], 'bank', true, true);
					$dataArray = array(
								'player_id' => $playerId,
								'type' => 'ADJUST_BANK',
								'amount_type' => 'REAL',
								'amount' => $newData['bank'],
								'notes' => $newData['notes']
								);
					$result = $playerTransaction->saveProcessing($dataArray);
				}
				if($data[0]['winnings'] != $newData['winnings'])
				{
					if($from == 'json')
					{
						if($_POST['winnings_action'] == 'DEBIT')
						$newData['winnings'] = $data[0]['winnings'] - $newData['winnings'];
						if($_POST['winnings_action'] == 'CREDIT')
						$newData['winnings'] = $data[0]['winnings'] + $newData['winnings'];
					}
					$dataArray = array(
								'player_id' => $playerId,
								'type' => 'ADJUST_WINNINGS',
								'amount_type' => 'REAL',
								'amount' => $newData['winnings'],
								'notes' => $newData['notes']
								);
					$playerTransaction = new PlayerTransactions();
					$result = $playerTransaction->saveProcessing($dataArray);
				}
				if($data[0]['bonus_bank'] != $newData['bonus'])
				{
					if($from == 'json')
					{
						if($_POST['bonus_action'] == 'DEBIT')
						$newData['bonus'] = $data[0]['bonus_bank'] - $newData['bonus'];
						if($_POST['bonus_action'] == 'CREDIT')
						$newData['bonus'] = $data[0]['bonus_bank'] + $newData['bonus'];
					}
					
					$dataArray = array(
								'player_id' => $playerId,
								'type' => 'ADJUST_BONUS_BANK',
								'amount_type' => 'BONUS',
								'amount'   => $newData['bonus'],
								'notes' => $newData['notes']
								);
					$playerTransaction = new PlayerTransactions();		
					$result = $playerTransaction->saveProcessing($dataArray);
				}
				if($data[0]['bonus_winnings'] != $newData['bonusWinnings'])
				{
					if($from == 'json')
					{
						if($_POST['bonus_winnings_action'] == 'DEBIT')
						$newData['bonusWinnings'] = $data[0]['bonus_winnings'] - $newData['bonusWinnings'];
						if($_POST['bonus_winnings_action'] == 'CREDIT')
						$newData['bonusWinnings'] = $data[0]['bonus_winnings'] + $newData['bonusWinnings'];
					}
					$dataArray = array(
								'player_id' => $playerId,
								'type' => 'ADJUST_BONUS_WINNINGS',
								'amount_type' => 'BONUS',
								'amount' => $newData['bonusWinnings'],
								'notes' => $newData['notes']
								);
					$playerTransaction = new PlayerTransactions();
					$result = $playerTransaction->saveProcessing($dataArray);
				}
		//	Zenfox_Debug::dump($dataArray, 'timezone', true, true);
		$this->view->done = 'done';
			}
		}
	}
	
	public function creditbonusAction()
	{		
		$playerId = $this->getRequest()->playerId;
		$session = new Zend_Auth_Storage_Session();
		$store = $session->read();
		$csr_id = $store['authDetails'][0]['id'];
		$form = new Admin_CreditBonusForm();
		$this->view->form = $form;
		if($this->getRequest()->isPost())
		{
			if($form->isValid($_POST))
			{
				$data = $form->getValues();
				if($data['credit_bonus'])
				{
					$dataArray = array(
					'player_id' => $playerId,
					'type' => 'CREDIT_BONUS',
					'notes' => 'Credit Bonus',
					'amount' => $data['credit_bonus'],
					'amount_type' => 'BONUS' 
					);
					$transaction = new PlayerTransactions();
					$sourceId = $transaction->saveProcessing($dataArray);
					$tries = 0;
					$withdrawalRequest = new AuditReport();     
					while ($withdrawalRequest->checkIfPresent($sourceId, $playerId , 'CREDIT_BONUS') == false && $tries < 4)
					{
						$tries = $tries + 1;		
					}	
					$result = $withdrawalRequest->checkIfPresent($sourceId,$playerId,'CREDIT_BONUS');					
					if(!$result)
					{
							//No entry in Audit Report so this leads to a timeout
						$this->_helper->FlashMessenger(array('error' => 'Transaction timed out'));						
					}
					else
					{
						//Everything is well.
						if($result == 'Adjust Bonus Winnings')
							$this->_helper->FlashMessenger(array('error' => 'Transaction has Been Processed'));
						else 
							$this->_helper->FlashMessenger(array('error' => $result));
					}
				}
				if($data['credit_bonus_due'])
				{
					$dataArray = array(
					'player_id' => $playerId,
					'type' => 'CREDIT_BONUS_DUE',
					'notes' => 'Credit Bonus Due',
					'amount' => $data['credit_bonus_due'],
					'amount_type' => 'BONUS' 
					);
					$transaction = new PlayerTransactions();
					$sourceId = $transaction->saveProcessing($dataArray);
					
					$tries = 0;
					$withdrawalRequest = new AuditReport();     
					while ($withdrawalRequest->checkIfPresent($sourceId, $playerId,$csrId) == false && $tries < 4)
					{
						$tries = $tries + 1;		
					}	
					$result = $withdrawalRequest->checkIfPresent($sourceId,$playerId,$csrId);					
					if(!$result)
					{
							//No entry in Audit Report so this leads to a timeout
						$this->_helper->FlashMessenger(array('error' => 'Transaction timed out'));						
					}
					else
					{
						//Everything is well.
						if($result == 'Adjust Bonus Bank')
							$this->_helper->FlashMessenger(array('error' => 'Transaction has Been Processed'));
						else 
							$this->_helper->FlashMessenger(array('error' => $result));
					}
				}													
				if($data['credit_free_money'])
				{
					$accountVariable = new AccountVariable();
					$varName = 'freeMoney';
					$freeMoney = 0;
					$variableData = $accountVariable->getData($playerId, $varName);
					if($variableData)
					{
						$freeMoney = $variableData['varValue'];
					}
					$freeMoney += $data['credit_free_money'];
					$varData['playerId'] = $playerId;
					$varData['variableName'] = 'freeMoney';
					$varData['variableValue'] = $freeMoney;
					if($accountVariable->insert($varData))
					{
						$this->_helper->FlashMessenger(array('error' => 'Transaction has Been Processed'));
					}
					else
					{
						$this->_helper->FlashMessenger(array('error' => "Some problem has been occured"));
					}
				}
				if($data['credit_winnings'])
				{
					
					$player = new Player();
		
					$playerAccount = $player->getAccountDetails($playerId);
	
					$transaction = new PlayerTransactions();
					$sourceId = $transaction->awardWinnings($playerId, $data['credit_winnings'],$playerAccount[0]['base_currency'], 'REAL', $data['notes']);
					$tries = 0;
					$withdrawalRequest = new AuditReport();
					while ($withdrawalRequest->checkIfPresent($sourceId, $playerId , 'AWARD_WINNINGS') == false && $tries < 4)
					{
						$tries = $tries + 1;
					}
					$result = $withdrawalRequest->checkIfPresent($sourceId,$playerId,'AWARD_WINNINGS');
					if(!$result)
					{
						//No entry in Audit Report so this leads to a timeout
						$this->_helper->FlashMessenger(array('error' => 'Transaction timed out'));
					}
					else
					{
						//Everything is well.
						if($result == 'Adjust Bonus Winnings')
						$this->_helper->FlashMessenger(array('error' => 'Transaction has Been Processed'));
						else
						$this->_helper->FlashMessenger(array('error' => $result));
					}
				}
				if($data['loyaltyPoints'])
				{
					$player = new Player();
					$prevLoyaltyPoints = $player->getLoyaltyPoints($playerId);
					$totalLoyaltyPoints = $prevLoyaltyPoints['totalLoyaltyPoints'];
					$loyaltyPointsLeft = $prevLoyaltyPoints['loyaltyPointsLeft'];
						
					$currentTotalLoyaltyPoints = $totalLoyaltyPoints + $data['loyaltyPoints'];
					$currentLoyaltyPointsLeft = $loyaltyPointsLeft + $data['loyaltyPoints'];
					$player->updateLoyaltyPoints($playerId, $currentTotalLoyaltyPoints, $currentLoyaltyPointsLeft);
					
					$this->_helper->FlashMessenger(array('notice' => 'Loyalty Points Added Successfully'));
				}
				$this->view->form = "";
			}
		}				
	}
	
	public function confirmplayerAction()
	{
		$language = $this->getRequest()->getParam('lang');
		$confirmationCode = $this->getRequest()->code;
		//Zenfox_Debug::dump($confirmationCode, 'timezone', true, true);
		$accountUnconfirm = new AccountUnconfirm();
		$playerData = $accountUnconfirm->getPlayerData($confirmationCode);

		if($playerData)
		{
			if($playerData['confirmation'] == 'NO')
			{
				$player = new Player();
				$result = $player->registerPlayer($playerData);
				//$url = '/' . $language . '/auth/login';
				$this->_helper->FlashMessenger(array('notice' => $this->view->translate("Player has been successfully registered. ")));
			}
			else
			{
				$this->_helper->FlashMessenger(array('error' => $this->view->translate('Player is already registered.')));
			}
		}
		else
		{
			$this->_helper->FlashMessenger(array('error' => $this->view->translate('The link is expired. Please try to re-register.')));
		}
	}
	
	public function editAction()
	{
		$language = $this->getRequest()->getParam('lang');
		$playerId = $this->getRequest()->id;
		$form = new Admin_PlayerProfileForm();
		$player = new Player();
		//Called getPlayerData method of Player model to get complete player details.
		$playerData = $player->getPlayerData($playerId);
		if(!$playerData)
		{
			$this->_redirect($language . '/error/error');
		}
		$this->view->form = $form->editProfile($playerData);
		//$this->view->submitButton = $form->submitButton();
		if($this->getRequest()->isPost())
		{
			if($form->isValid($_POST))
			{
				$data = $form->getValues();
				$editUser = new Player();
				if($data["password"] != "")
				{
					$md5ofPassword = md5($data["password"]);
					if($editUser->changePassword($md5ofPassword, $playerId))
					{
						$this->_helper->FlashMessenger(array('notice' => $this->view->translate("Player password has been updated successfully.")));
					}
                                	else
                                	{
						$this->_helper->FlashMessenger(array('error' => $this->view->translate("Player password updating failed.")));
					}
				}
				$loginName["login"] = $data["login"];
					if($editUser->updateAccountDetails($loginName, $playerId))
					{
						$this->_helper->FlashMessenger(array('notice' => $this->view->translate("Player login has been updated successfully.")));
					}
                                	else
                                	{
						$this->_helper->FlashMessenger(array('error' => $this->view->translate("Player login updating failed.")));
					}
				//Called editPrfile method of Player model
				if($editUser->editProfile($data, $playerId))
				{
					$form = new Admin_PlayerProfileForm();
					$this->view->form = '';
					//$this->view->submitButton = '';
					//$this->view->message = $this->view->translate("Player profile has been updated successfully.");
					$this->_helper->FlashMessenger(array('notice' => $this->view->translate("Player profile has been updated successfully.")));
				}
				else
				{
					$this->_redirect($language . '/error/error');
				}
			}
			
		}
	}
	
	public function buddyAction()
	{
		$playerId = $this->getRequest()->playerId;
		$buddyObj = new AccountDetail();
		
		$buddyData = $buddyObj->getBuddy($playerId);
		$this->view->data = $buddyData;
	}
	
	public function transactiondetailAction()
	{
		$transactionId = $this->getRequest()->transId;
		
		$playerTransObj = new PlayerTransactionRecord();
		$playerTransactionData = $playerTransObj->getDataByTransactionId($transactionId);
		$this->view->data = $playerTransactionData;
		
		//Zenfox_Debug::dump($playerTransactionData, 'data', true, true);
	}
	
	public function cardsdetailAction()
	{
		if($_POST)
		{
			$playerId = $_POST['playerId'];
			$playerCardDetails = new PlayerCardDetails();
			$player = new Player();
			
			if($playerId)
			{
				if($_POST['cardId'])
				{
					$playerCardDetails->changeStatus($_POST['cardId'], $playerId, $_POST['status']);
				}
				$playerData = $player->getAccountDetails($playerId);
				$login = $playerData[0]['login'];
				$created = $playerData[0]['created'];
				
				$secretKey = md5($login . $created);
				$cardDetails = $playerCardDetails->getCardDetails($playerId, $secretKey);
			}
			$playerCard = array();
			$index = 0;
			foreach($cardDetails as $detail)
			{
				$playerCard[$index]['Player Id'] = $playerId;
				$playerCard[$index]['Card No'] = substr($detail['card_no'], 12);
				$playerCard[$index]['CVC No'] = $detail['card_cvc_no'];
				$playerCard[$index]['Type'] = $detail['card_type'];
				$playerCard[$index]['Subtype'] = $detail['card_subtype'];
				
				$status = 'ENABLED';
				if($detail['enabled'] == 'ENABLED')
				{
					$status = 'DISABLED';
				}
				
				$form = '<form action="/player/cardsdetail/" method = "POST">
						<input type="hidden" name="cardId" value="' . $detail['id'] . '">
						<input type="hidden" name="playerId" value="' . $playerId . '">
						<input type="hidden" name="status" value="' . $status . '">
						<input type="submit" name="submit" value="' . $status . '">
						</form>';
		
				$playerCard[$index]['Status'] = $detail['enabled'] .$form;
				$index++;
			}
			
			$this->view->cardDetails = $playerCard;
		}
	}
	
}
