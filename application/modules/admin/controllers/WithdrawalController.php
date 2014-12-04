<?php

require_once dirname(__FILE__).'/../forms/DateSelectionForm.php';
require_once dirname(__FILE__).'/../forms/WithdrawalProcessingForm.php';
require_once dirname(__FILE__).'/../forms/TransactionForm.php';
require_once dirname(__FILE__).'/../forms/UserForm.php';
require_once dirname(__FILE__).'/../forms/UpdateProofForm.php';
require_once dirname(__FILE__).'/../forms/AddExistingProofsForm.php';
require_once dirname(__FILE__).'/../forms/UpdateVerificationForm.php';
require_once dirname(__FILE__).'/../forms/CheckIdsForm.php';


class Admin_WithdrawalController extends Zend_Controller_Action
{
	public function init()
	{
		parent::init();
		
		$this->_redirector = $this->_helper->getHelper('Redirector');
        $contextSwitch = $this->_helper->getHelper('contextSwitch');
         $contextSwitch->setAutoJsonSerialization(false);
		$contextSwitch->addActionContext('index', 'json')
					  ->initContext();
	}
	
	public function indexAction()
	{	
		$auditRepot = new AuditReport();
		$type = $this->getRequest()->type;
		$playerId = $this->getRequest()->playerId;
		
		if($type == 'CREDIT_DEPOSITS')
			$data = $auditRepot->getTransaction($playerId, 'CREDIT_DEPOSITS');
		if($type == 'WITHDRAWAL_ACCEPT')
		{
			$data1 = $auditRepot->getTransaction($playerId, 'WITHDRAWAL_ACCEPT');
			$data2 = $auditRepot->getTransaction($playerId, 'WITHDRAWAL_PARTIAL_ACCEPT');
			$data = array_merge($data1 , $data2);;
		}	
		
			$this->view->data = $data;
			$this->view->type = $type;		
		
			
			
	//Zenfox_Debug::dump($data , 'data', true , true );
	}
	
	public function listallAction()
	{
		$authSession = new Zend_Auth_Storage_Session();
		$sessionData = $authSession->read();
		$csrId = $sessionData['id'];
		$sessionName = 'Withdrawal_' . $csrId;
		$session = new Zend_Session_Namespace($sessionName);
		$form = new Admin_DateSelectionForm();
		$this->view->form = $form;
		$request = new WithdrawalRequest();
		$offset = $this->getRequest()->pages;
		
		$dataArray = array(
		'player_id' => -1,
		'processed' => '');
		
		if($offset)
		{	
			//echo $offset; exit();
			$itemsPerPage = $this->getRequest()->item;
			$from = $this->getRequest()->from;
			$to = $this->getRequest()->to;			
			$dataArray['player_id'] = $this->getRequest()->player_id;
			$dataArray['processed'] = $this->getRequest()->processed;
			
					
			
			$result = $request->adminList($itemsPerPage, $offset, $from, $to, $session, $dataArray);
			if(!$result)
			{
				$this->_helper->FlashMessenger(array('error' => 'No withdrawal found.'));
			}
			$this->view->paginator = $result[0];
			$this->view->contents = $result[1];
			$this->view->fromDate = $from;
			$this->view->toDate = $to;
			$this->view->player_id = $dataArray['player_id'];
			$this->view->processed = $dataArray['processed'];

		}
		
		if($this->getRequest()->isPost())
		{
			if($form->isValid($_POST))
			{
    			$session->unsetAll();
				$offset = 1;
				$data = $form->getValues();
				$fromDate = $data['from_date'] . ' ' . $data['from_time'];
				$toDate = $data['to_date'] . ' ' . $data['to_time'];
								
				$withdrawalArray = array(
				'PROCESSED' => false,
				'NOT_PROCESSED' => false,
				'PARTIALLY_PROCESSED' => false,
				);
				
				if($data['player_id'])
				{
					$dataArray['player_id'] = $data['player_id'];
				}
				//ENUM('AWARD_WINNINGS', 'CREDIT_DEPOSITS', 'PLACE_WAGER','WITHDRAWAL_REQUEST','WITHDRAWAL_FLOWBACK','WITHDRAWAL_ACCEPT','WITHDRAWAL_REJECT','CONVERT_BONUS_REAL','CONVERT_REAL_BONUS','CREDIT_BONUS','CREDIT_BUDDY_BONUS','WITHDRAWAL_PARTIAL_ACCEPT', 'WITHDRAWAL_PARTIAL_REJECT','WITHDRAWAL_PARTIAL_FLOWBACK', 'ADJUST_BANK', 'ADJUST_WINNINGS', 'ADJUST_BONUS_WINNINGS', 'ADJUST_BONUS_BANK')
							
				if($data['withdrawal_type'])
				{
					//echo "here1";
					//print_r($data['withdrawal_type']);exit();
					
					foreach ($data['withdrawal_type'] as $withdrawal_type)
					{
						$withdrawalArray[$withdrawal_type] = true;
						$valueArray[] = $withdrawal_type;
					//	echo $withdrawal_type;
					}
				//	exit();
					if ($withdrawalArray['PROCESSED'] == true && $withdrawalArray['NOT_PROCESSED'] == true)
					{
						$dataArray['processed'] = '';
					}
					else 
					{
						
						$dataArray['processed'] = implode("','",$valueArray);
					}
					
				}
				
				//print_r($dataArray);//exit();
				
				$result = $request->adminList($data['items'], $offset, $fromDate, $toDate, $session, $dataArray);
			//	print_r($result);
			//	exit();	
				if(!$result)
				{
					$this->_helper->FlashMessenger(array('error' => $form->getView()->translate('No withdrawal found.')));
					echo $form->getView()->translate('No withdrawal found.');
				}
			//	print_r($result[1]);exit();
				$this->view->paginator = $result[0];
				$this->view->contents = $result[1];
				//Zenfox_Debug::dump($result[1], 'content');
				$this->view->fromDate = $fromDate;
				$this->view->toDate = $toDate;
				$this->view->player_id = $dataArray['player_id'];
				$this->view->processed = $dataArray['processed'];
				$this->view->item = $data['items'];
				
				//echo 'HERE';
				
			}
		}
		
	}
	
	public function checkwithdrawalAction()
	{
		$authSession = new Zend_Auth_Storage_Session();
		$sessionData = $authSession->read();
		$csrId = $sessionData['id'];
        $csrfrontendids = $sessionData["frontend_ids"];
        $player = new Player();
		
		$kycobj = new Kyc();
		$kycdata = $kycobj->getallkycdetails();
		
		$fullkycdata = array_merge($kycdata[1],$kycdata[0]);
		function aasort (&$array, $key)
		{
			$sorter=array();
			$ret=array();
			reset($array);
			foreach ($array as $ii => $va) {
				$sorter[$ii]=$va[$key];
			}
			asort($sorter);
			foreach ($sorter as $ii => $va) {
				$ret[$ii]=$array[$ii];
			}
			$array=$ret;
		}
		 	aasort($fullkycdata,'time');
		 	$data = array_values($fullkycdata);
			$count = count($data);
			$index = 0;
			$secondindex =0;
			$fullkycdata = array();
			while($index<$count)
			{
				
				$playerfrontendid = $player->getfrontendidofplayer($data[$index]["player_id"]);
				if (in_array($playerfrontendid,$csrfrontendids))
 				{
 					$fullkycdata[$secondindex] = $data[$index];
 					$secondindex++;
 				}
 				
				$index++;
			}
		 	
		 	
		 	
		 	$count = count($fullkycdata);
			$index = 0;
		while($index < $count)
		{
				
			$finallist[$index]["player_id"] =  $fullkycdata[$index]["player_id"];
			$finallist[$index]["type"] =  $fullkycdata[$index]["type"];
			
			if($fullkycdata[$index]["kyc_document"] == "OTHER")
			{
				$finallist[$index]["kyc_document"] =  $fullkycdata[$index]["kyc_document_other"];
			}
			else
			{
				$finallist[$index]["kyc_document"] =  $fullkycdata[$index]["kyc_document"];
			}
			
			$finallist[$index]["status"] =  $fullkycdata[$index]["status"];
			$finallist[$index]["time"] =  $fullkycdata[$index]["time"];
			
				
			$kycdata = $kycobj->getkycminidetailsbytype($finallist[$index]["player_id"] , $finallist[$index]["type"]);
			
			$kycid = 	$kycdata["id"];
				
				
			$kycdocobj = new KycDocuments();
			$paths = $kycdocobj->getdocpaths($finallist[$index]["player_id"], $kycid);
			
			$totalcount = count($paths);
			$totalindex = 0;
			$finallist[$index]["proof"]="";
			while($totalcount >0)
			{
				$id = $totalindex+1; 
				$url = "<a href=".  $this->view->url(array ('controller'=> 'withdrawal', 'action'=> 'checkwithdrawal',  'download' => $id ,'type' => $finallist[$index]["type"], 'playerId' => $finallist[$index]["player_id"]) ).">Download Proof". $id ."</a>";
				if(!empty($finallist[$index]["proof"]))
				{
					$finallist[$index]["proof"] = $finallist[$index]["proof"]." and ".$url;
				}
				else
				{
					$finallist[$index]["proof"] = $url;
				}
						
				$totalindex++;
				$totalcount--;
			} 
			
				$index++;
		}
		
	
		$this->view->table1 = $finallist;
		$prooftype = $this->getRequest()->type;
		$playerid = $this->getRequest()->playerId;
		
		if(!empty($playerid))
		{
		  $playerfrontendid = $player->getfrontendidofplayer($playerid);
		  if (in_array($playerfrontendid,$csrfrontendids))
 		  {
 				
			$this->view->table1 = "";
			$kycdata = $kycobj->getkycminidetailsbytype($playerid , $prooftype);
			
			
					$detailskyc[0][proof] = $kycdata[type];
					
					$kycid = 	$kycdata[id];
					if($kycdata[kyc_document] == "OTHER")
					{
						$detailskyc[0][IDtype] = $kycdata[kyc_document_other];
						$detailskyc[0][IDnumber] = $kycdata[kyc_document_number];
						$detailskyc[0][ExpiryDate] = $kycdata[expiry_date];
						$detailskyc[0][IssuingAuthority] = $kycdata[issuing_authority];
							
					}
					else
					{
						$detailskyc[0][IDtype] = $kycdata[kyc_document];
						$detailskyc[0][IDnumber] = $kycdata[kyc_document_number];
						$detailskyc[0][ExpiryDate] = $kycdata[expiry_date];
						$detailskyc[0][IssuingAuthority] = $kycdata[issuing_authority];
					}
					
					$detailskyc[0][Status] = $kycdata[status];
				
			
			
			$this->view->iddetails = $detailskyc;
			
			$form = new Admin_UpdateProofForm();
			$this->view->form = $form->getform($detailskyc[0]);
			
			$kycdocobj = new KycDocuments();
			$paths = $kycdocobj->getdocpaths($playerid, $kycid);
			
			$count = count($paths);
			$this->view->download = $count;
			
			
			$downloadproofs = $this->getRequest()->download;
			if(!empty($downloadproofs))
			{
				$index = $downloadproofs-1;
				$paths[$index]['document_path'] = str_replace('home', 'var', $paths[$index]['document_path']);
						header("Content-length: ".filesize($paths[$index]["document_path"]));
						header("Content-type: ".mime_content_type($paths[$index]["document_path"]));
						header('Content-Disposition: attachment; filename="' . basename($paths[$index]["document_path"]) . '"');
						readfile($paths[$index]["document_path"]);
							
						$this->view->layout()->disableLayout();
						$this->_helper->viewRenderer->setNoRender(true);
					
			}
			
			if($this->getRequest()->isPost())
			{
				if($form->isValid($_POST))
				{
					$postvalues = $form->getvalues();
			
					$kycobj->updateproof($playerid,$prooftype,$postvalues["type"],$postvalues["Number"],$postvalues ["expiryDate"],$postvalues ["Authority"],$postvalues ["status"]);
						
					$kycobj = new Kyc();
					$kycdata = $kycobj->getkycminidetailsbytype($playerid , $prooftype);
						
						
					$detailskyc[0][proof] = $kycdata[type];
						
					$kycid = 	$kycdata[id];
					if($kycdata[kyc_document] == "OTHER")
					{
						$detailskyc[0][IDtype] = $kycdata[kyc_document_other];
						$detailskyc[0][IDnumber] = $kycdata[kyc_document_number];
						$detailskyc[0][ExpiryDate] = $kycdata[expiry_date];
						$detailskyc[0][IssuingAuthority] = $kycdata[issuing_authority];
							
					}
					else
					{
						$detailskyc[0][IDtype] = $kycdata[kyc_document];
						$detailskyc[0][IDnumber] = $kycdata[kyc_document_number];
						$detailskyc[0][ExpiryDate] = $kycdata[expiry_date];
						$detailskyc[0][IssuingAuthority] = $kycdata[issuing_authority];
					}
						
					$detailskyc[0][Status] = $kycdata[status];
			
					$this->view->iddetails = $detailskyc;
				}
			}
 		  }
 		  else 
 		  {
 		  	$this->_helper->FlashMessenger(array('error' => "Player not found or You are not authorised to view/edit this player's details"));
			$this->view->table1 = "";
 		  }
		}
		else 
		{
			$form = new Admin_AddExistingProofsForm();
			$this->view->form = $form->getform();
			
			if($this->getRequest()->isPost())
			{
				if($form->isValid($_POST))
				{
					
					$postvalues = $form->getvalues();
					
					$playerfrontendid = $player->getfrontendidofplayer($postvalues["playerid"]);
					if (in_array($playerfrontendid,$csrfrontendids))
 					{
 						$this->view->table1 = "";
						$accountobj = new Account();
						$data = $accountobj->getdetails($postvalues["playerid"]);
						
						$data["playerid"] = $postvalues["playerid"];
					
						$form1 = new Admin_UpdateVerificationForm();
						$this->view->form = $form1->getform($data);
 					}
 					else 
 					{
 						$this->_helper->FlashMessenger(array('error' => "Player not found or You are not authorised to view/edit this player's details"));
 					}
				}
					
			}
		}
	}
	
	public function checkidsAction()
	{
		$form = new Admin_CheckIdsForm();
		$this->view->form = $form->getform();
		$authSession = new Zend_Auth_Storage_Session();
		$sessionData = $authSession->read();
		$csrId = $sessionData['id'];
        $csrfrontendids = $sessionData["frontend_ids"];
        $player = new Player();
			
		if($this->getRequest()->isPost()) 
		{
			if($form->isValid($_POST))
			{
				$postvalues = $form->getValues();
				
				$kycobj = new Kyc();
				$playerIds = $kycobj->getplayerids($postvalues["document_number"]);
				
				if(!empty($playerIds))
				{
					$count = count($playerIds);
					$index = 0;
					$secondindex =0;
					$accountdetailsobj = new AccountDetail();
					while($index<$count)
					{
						
						$playerfrontendid = $player->getfrontendidofplayer($playerIds[$index]["player_id"]);
						
						if (in_array($playerfrontendid,$csrfrontendids))
						{
							$details = $accountdetailsobj->getDetails($playerIds[$index]["player_id"]) ;
							
							$mydetails[$secondindex]["PLAYER ID"] =   $playerIds[$index]["player_id"];
							$mydetails[$secondindex]["LOGIN NAME"] =   $details["login"];
							$mydetails[$secondindex]["EMAIL"] =   $details["email"];
							
							$secondindex++;
						}
						$index++;
					}
					if(!empty($mydetails))
					{
						$this->view->playerids = $mydetails;
					}
					else
					{
						$this->_helper->FlashMessenger(array('message' => 'No Records found.'));
					}
				}
				else
				{
					$this->_helper->FlashMessenger(array('message' => 'No Records found.'));
				}
				
				
				
				
				
			}
		}
	}
	
	public function addverifiedAction()
	{
		$form = new Admin_UpdateVerificationForm();
		$this->view->form = $form->getform();
		
		if($this->getRequest()->isPost()) 
		{
			if($form->isValid($_POST))
			{
				
				$postvalues = $form->getValues();
				$bankdetailsobj = new BankDetails();
				$bankdetails = $bankdetailsobj->getbankdetails($postvalues["playerid"]);
				
				$kycobj = new Kyc();
				$kyc = $kycobj->getkycdetails($postvalues["playerid"]);
				
				$accountobj = new Account();
				$accountdetails = $accountobj->getdetails($postvalues["playerid"]);
				
				
				$temppath = Zend_Registry::getInstance()->get('UploadDocumentPath');
					
					if($postvalues["BankAccountNumber"] == $postvalues["BankAccountNumberRe"])
					{
						
						//echo $postvalues["first_name"]."<br/>".$accountdetails["first_name"]."<br/>".$postvalues["last_name"]."<br/>".$accountdetails["last_name"]."<br/>".$postvalues["sex"]."<br/>".$accountdetails["sex"]."<br/>".$postvalues["dateofbirth"]."<br/>".$accountdetails["dateofbirth"]."<br/>".$postvalues["address"]."<br/>".$accountdetails["address"]."<br/>".$postvalues["city"]."<br/>".$accountdetails["city"]."<br/>".$postvalues["state"]."<br/>".$accountdetails["state"]."<br/>".$postvalues["country"]."<br/>".$accountdetails["country"]."<br/>".$postvalues["pin"]."<br/>".$accountdetails["pin"]."<br/>".$postvalues["phone"]."<br/>".$accountdetails["phone"]."<br/>".$postvalues["email"]."<br/>".$accountdetails["email"]."<br/>".$postvalues["idproof"]."<br/>".$kyc[0]["kyc_document"]."<br/>".$postvalues["idproofother"]."<br/>".$kyc[0]["kyc_document_other"]."<br/>".$postvalues["idproofnumber"]."<br/>".$kyc[0]["kyc_document_number"]."<br/>".$postvalues["idproofauthority"]."<br/>".$kyc[0]["issuing_authority"]."<br/>".$postvalues["idproofexpiry"]."<br/>".$kyc[0]["expiry_date"]."<br/>".$postvalues["addressproof"]."<br/>".$kyc[1]["kyc_document"]."<br/>".$postvalues["otheraddressproof"]."<br/>".$kyc[1]["kyc_document_other"]."<br/>".$postvalues["addressproofnumber"]."<br/>".$kyc[1]["kyc_document_number"]."<br/>".$postvalues["addressproofauthority"]."<br/>".$kyc[1]["issuing_authority"]."<br/>".$postvalues["addressproofexpiry"]."<br/>".$kyc[1]["expiry_date"]."<br/>".$postvalues["nameasonbank"]."<br/>".$bankdetails[0]["name"]."<br/>".$postvalues["bank"]."<br/>".$bankdetails[0]["name_of_bank"]."<br/>".$postvalues["BankAccountNumber"]."<br/>".$bankdetails[0]["account_number"]."<br/>".$postvalues["Branch"]."<br/>".$bankdetails[0]["branch"]."<br/>".$postvalues["ifsccode"]."<br/>".$bankdetails[0]["ifsc_code"];
						
						if(($postvalues["first_name"] == $accountdetails["first_name"] ) and ($postvalues["last_name"] == $accountdetails["last_name"] ) and  ($postvalues["dateofbirth"] == $accountdetails["dateofbirth"] ) and ($postvalues["address"] == $accountdetails["address"] ) and ($postvalues["city"] == $accountdetails["city"] ) and ($postvalues["state"] == $accountdetails["state"] ) and ($postvalues["country"] == $accountdetails["country"] ) and ($postvalues["pin"] == $accountdetails["pin"] ) and ($postvalues["phone"] == $accountdetails["phone"] ) and ($postvalues["email"] == $accountdetails["email"] ) and ($postvalues["idproof"] == $kyc[0]["kyc_document"] )  and ($postvalues["idproofnumber"] == $kyc[0]["kyc_document_number"] ) and ($postvalues["idproofauthority"] == $kyc[0]["issuing_authority"] ) and ($postvalues["idproofexpiry"] == $kyc[0]["expiry_date"] ) and ($postvalues["addressproof"] == $kyc[1]["kyc_document"] )  and ($postvalues["addressproofnumber"] == $kyc[1]["kyc_document_number"] ) and ($postvalues["addressproofauthority"] == $kyc[1]["issuing_authority"] ) and ($postvalues["addressproofexpiry"] == $kyc[1]["expiry_date"] ) and ($postvalues["nameasonbank"] == $bankdetails[0]["name"])  and ($postvalues["bank"] == $bankdetails[0]["name_of_bank"]) and ($postvalues["BankAccountNumber"] == $bankdetails[0]["account_number"]) and ($postvalues["Branch"] == $bankdetails[0]["branch"]) and ($postvalues["ifsccode"] == $bankdetails[0]["ifsc_code"]) )
						{
							$this->view->form = "";
							$this->_helper->FlashMessenger(array('error' => 'Details Set Already'));
						}
						else 
						{
							$today = new Zend_Date();
							$currentTime = $today->get(Zend_Date::W3C);
							
							
							$kycobj->disableproofs($postvalues["playerid"], "IDPROOF");
								
							if($postvalues["idproof"] == "OTHER")
							{
								$kycobj->insertidproof($postvalues["playerid"],"IDPROOF",$postvalues["idproof"],$postvalues["idproofnumber"],$postvalues["idproofexpiry"],$postvalues["idproofauthority"],$postvalues["idproofother"],"ACCEPTED");
							}
							else
							{
									
								$kycobj->insertidproof($postvalues["playerid"],"IDPROOF",$postvalues["idproof"],$postvalues["idproofnumber"],$postvalues["idproofexpiry"],$postvalues["idproofauthority"],"","ACCEPTED");
							}
							
							$kycid = $kycobj->getmaxid($postvalues["playerid"]);
							
							if(!empty($_FILES["ID1"]["tmp_name"]))
							{
								$oldpath =$temppath. $postvalues["ID1"];
								$name = $_FILES["ID1"]["name"];
								$ext = end(explode(".", $name));
								$kycdocobj1 = new KycDocuments();
								$docnumber = 1;
							
								if($postvalues["idproof"] != "OTHER")
								{
									$newpath = $temppath.$postvalues["playerid"]."_IDPROOF_".$postvalues["idproof"]."_".$kycid."_1_".md5($postvalues["playerid"].$kycid.$docnumber.$currentTime).".".$ext;
								}
								else
								{
									$newpath = $temppath.$postvalues["playerid"]."_IDPROOF_".$postvalues["idproofother"]."_".$kycid."_1_".md5($postvalues["playerid"].$kycid.$docnumber.$currentTime).".".$ext;
								}
							
								rename($oldpath, $newpath);
								$kycdocobj1->insertdoc($postvalues["playerid"],$kycid,$newpath);
							}
								
							if(!empty($_FILES["ID2"]["tmp_name"]))
							{
								$oldpath =$temppath. $postvalues["ID2"];
								$name = $_FILES["ID2"]["name"];
								$ext = end(explode(".", $name));
									
								$kycdocobj2 = new KycDocuments();
							
								$docnumber = $kycdocobj2->getdocnumber($postvalues["playerid"],$kycid);
								if($postvalues["idproof"] != "OTHER")
								{
									$newpath = $temppath.$postvalues["playerid"]."_IDPROOF_".$postvalues["idproof"]."_".$kycid."_".$docnumber."_".md5($postvalues["playerid"].$kycid.$docnumber.$currentTime).".".$ext;
								}
								else
								{
									$newpath = $temppath.$postvalues["playerid"]."_IDPROOF_".$postvalues["idproofother"]."_".$kycid."_".$docnumber."_".md5($postvalues["playerid"].$kycid.$docnumber.$currentTime).".".$ext;
								}
									
								rename($oldpath, $newpath);
								$kycdocobj2->insertdoc($postvalues["playerid"],$kycid,$newpath);
							
							}
							if(!empty($_FILES["ID3"]["tmp_name"]))
							{
								$oldpath =$temppath. $postvalues["ID3"];
								$name = $_FILES["ID3"]["name"];
								$ext = end(explode(".", $name));
								$kycdocobj3 = new KycDocuments();
								$docnumber = $kycdocobj3->getdocnumber($postvalues["playerid"],$kycid);
								if($postvalues["idproof"] != "OTHER")
								{
									$newpath = $temppath.$postvalues["playerid"]."_IDPROOF_".$postvalues["idproof"]."_".$kycid."_".$docnumber."_".md5($postvalues["playerid"].$kycid.$docnumber.$currentTime).".".$ext;
								}
								else
								{
									$newpath = $temppath.$postvalues["playerid"]."_IDPROOF_".$postvalues["idproofother"]."_".$kycid."_".$docnumber."_".md5($postvalues["playerid"].$kycid.$docnumber.$currentTime).".".$ext;
								}
									
								rename($oldpath, $newpath);
								$kycdocobj3->insertdoc($postvalues["playerid"],$kycid,$newpath);
							
							}
							
								
							$kycobj2 = new Kyc();
								
							$kycobj2->disableproofs($postvalues["playerid"], "ADDRESSPROOF");
							
							if($postvalues["addressproof"] == "OTHER")
							{
								$kycobj2->insertidproof($postvalues["playerid"],"ADDRESSPROOF",$postvalues["addressproof"],$postvalues["addressproofnumber"],$postvalues["addressproofexpiry"],$postvalues["addressproofauthority"],$postvalues["otheraddressproof"],"ACCEPTED");
							}
							else
							{
								$kycobj2->insertidproof($postvalues["playerid"],"ADDRESSPROOF",$postvalues["addressproof"],$postvalues["addressproofnumber"],$postvalues["addressproofexpiry"],$postvalues["addressproofauthority"],"","ACCEPTED");
							}
								
								
							$kycid = $kycobj2->getmaxid($postvalues["playerid"]);
								
							if(!empty($_FILES["ADDR1"]["tmp_name"]))
							{
								$oldpath =$temppath. $postvalues["ADDR1"];
								$name = $_FILES["ADDR1"]["name"];
								$ext = end(explode(".", $name));
								$kycdocobj4 = new KycDocuments();
								$docnumber = 1;
								if($postvalues["addressproof"] != "OTHER")
								{
									$newpath = $temppath.$postvalues["playerid"]."_ADDRESSPROOF_".$postvalues["addressproof"]."_".$kycid."_1_".md5($postvalues["playerid"].$kycid.$docnumber.$currentTime).".".$ext;
								}
								else
								{
									$newpath = $temppath.$postvalues["playerid"]."_ADDRESSPROOF_".$postvalues["addressproofother"]."_".$kycid."_1_".md5($postvalues["playerid"].$kycid.$docnumber.$currentTime).".".$ext;
								}
									
								rename($oldpath, $newpath);
								$kycdocobj4->insertdoc($postvalues["playerid"],$kycid,$newpath);
							}
							if(!empty($_FILES["ADDR2"]["tmp_name"]))
							{
								$oldpath =$temppath. $postvalues["ADDR2"];
								$name = $_FILES["ADDR2"]["name"];
								$ext = end(explode(".", $name));
								$kycdocobj5 = new KycDocuments();
								$docnumber = $kycdocobj5->getdocnumber($postvalues["playerid"],$kycid);
								if($postvalues["addressproof"] != "OTHER")
								{
									$newpath = $temppath.$postvalues["playerid"]."_ADDRESSPROOF_".$postvalues["addressproof"]."_".$kycid."_".$docnumber."_".md5($postvalues["playerid"].$kycid.$docnumber.$currentTime).".".$ext;
								}
								else
								{
									$newpath = $temppath.$postvalues["playerid"]."_ADDRESSPROOF_".$postvalues["addressproofother"]."_".$kycid."_".$docnumber."_".md5($postvalues["playerid"].$kycid.$docnumber.$currentTime).".".$ext;
								}
									
								rename($oldpath, $newpath);
								$kycdocobj5->insertdoc($postvalues["playerid"],$kycid,$newpath);
							}
							if(!empty($_FILES["ADDR3"]["tmp_name"]))
							{
								$oldpath =$temppath. $postvalues[address_form]["ADDR3"];
								$name = $_FILES["ADDR3"]["name"];
								$ext = end(explode(".", $name));
								$kycdocobj6 = new KycDocuments();
								$docnumber = $kycdocobj6->getdocnumber($postvalues["playerid"],$kycid);
								if($postvalues["addressproof"] != "OTHER")
								{
									$newpath = $temppath.$postvalues["playerid"]."_ADDRESSPROOF_".$postvalues["addressproof"]."_".$kycid."_".$docnumber."_".md5($postvalues["playerid"].$kycid.$docnumber.$currentTime).".".$ext;
								}
								else
								{
									$newpath = $temppath.$postvalues["playerid"]."_ADDRESSPROOF_".$postvalues["addressproofother"]."_".$kycid."_".$docnumber."_".md5($postvalues["playerid"].$kycid.$docnumber.$currentTime).".".$ext;
								}
									
								rename($oldpath, $newpath);
								$kycdocobj6->insertdoc($postvalues["playerid"],$kycid,$newpath);
							}
							
							$bankdetailsobj->insertbankdetails($postvalues["playerid"],$postvalues["nameasonbank"],$postvalues["bank"],$postvalues["BankAccountNumber"],$postvalues["ifsccode"],$postvalues["Branch"]);
								
							
							
							$accountobj->insertaccount($postvalues["playerid"],$postvalues["first_name"],$postvalues["last_name"],$postvalues["sex"],$postvalues["dateofbirth"],$postvalues["address"],$postvalues["city"],$postvalues["state"],$postvalues["country"],$postvalues["pin"],$postvalues["phone"],$postvalues["email"]);
								
							
							$this->view->form = "";
							$this->_helper->FlashMessenger(array('error' => 'Details Added Successfully'));
						}
						
						
					}
					else
					{
						$this->_helper->FlashMessenger(array('error' => 'ACCOUNT NUMBERS DID NOT MATCH'));
					}
				}
		}
	}
	
	
	public function listdetailsAction()
	{
		/*
		 *  Changes need to be made to the BasePlayerTransactions in the admin side.
		 */
		
		$session = new Zend_Auth_Storage_Session();
		$store = $session->read();
		/*print_r($store);
		print_r($store['authDetails'][0]['id']);
		exit();*/
		
				
		$request = $this->getRequest();
		$playerId = $request->player_id;
		$withdrawalId = $request->withdrawal_id;
		$status = $request->status;
		$withdrawalRequest = new WithdrawalRequest();
		if($status == 'PROCESSED')
		{
			$data = $withdrawalRequest->adminGetDetails($playerId,$withdrawalId);
		}
		else
		{
			$data = $withdrawalRequest->adminGetDetails($playerId);
		}
		$totalRemainingAmount = 0;
		if($data)
		{
			foreach($data as $withdrawalData)
			{
				$totalRemainingAmount += $withdrawalData['Remaining Amount'];
			}
		}
		//print_r($data);
		//exit();
		
		$player = new Player();
		$playerCardDetails = new PlayerCardDetails();
		$playerData = $player->getAccountDetails($playerId);
		$login = $playerData[0]['login'];
		$created = $playerData[0]['created'];
			
		$secretKey = md5($login . $created);
		$cardDetails = $playerCardDetails->getCardDetails($playerId, $secretKey);

		if( strcmp($data[0]['Status'], 'PROCESSED') != 0 )
		{
			$this->view->showForm = true;
			$form = new Admin_WithdrawalProcessingForm();
			$this->view->form = $form->getForm($cardDetails);
			$this->view->maxAmount = $totalRemainingAmount;
		}
		
		if($this->getRequest()->isPost())
		{
			if($form->isValid($_POST))
			{
				$values = $form->getValues();
				
				$error = false;
				$transaction = new PlayerTransactions();
				
				if($values['amount'] < 0 || (float)$values['amount'] > (float)$totalRemainingAmount)
				{
					$this->_helper->FlashMessenger(array('error' => $form->getView()->translate('Invalid Amount')));
					echo $form->getView()->translate('Invalid Amount');
					$error = true;
				}
				
				//print_r($values);exit();
							
				if(!$error && $values['type'] == 'reject' && $values['amount'])
				{
					
					//$this->_helper->FlashMessenger(array('error' => $form->getView()->translate('Incorrect Options selected')));
					//$error = true;
					
					$transaction = new PlayerTransactions();
					$dataArray = array(
							'player_id' => $playerId,
							'withdrawal_id' => $withdrawalId,
							'amount'	=> $values['amount'],
							'type'		=> 'WITHDRAWAL_REJECT',
							'notes'		=> $values['notes']
					);
				}
				
				/*else if($values['type'] == 'reject') 
				{
										
					$parentArray = $withdrawalRequest->adminGetParent($playerId, $withdrawalId);
				//	print_r($childArray);
					$dataArray = array(
									'player_id' => $playerId,
								'withdrawal_id' => $withdrawalId,
									'amount'	=> $parentArray[0]['remaining_amount'],
									'type'		=> 'WITHDRAWAL_REJECT',
									'notes'		=> $values['notes']
					);
				}*/
				
				else if(!$error && $values['type'] == 'accept' && $values['amount'])
				{
					if($values['cardId'])
					{
						$cardDetails = $playerCardDetails->getCardDetailsById($values['cardId'], $playerId, $secretKey);

						$address = $cardDetails['card_holder_address'];
						$city = $cardDetails['card_holder_city'];
						$state = $cardDetails['card_holder_state'];
						$pin = $cardDetails['card_holder_zip'];
						$country = $cardDetails['card_holder_country'];
						
						if(!$address || !$city || !$state || !$pin || !$country)
						{
							$playerDetails = $player->getPlayerData($playerId);
							$address = $playerDetails['address'];
							$city = $playerDetails['city'];
							$state = $playerDetails['state'];
							$pin = $playerDetails['pin'];
							$country = $playerDetails['country'];
						}
						
						/*$postArray['merchant_refund_id'] = 'test_progaming';
						$postArray['merchant_pwd'] = 'poiuytrewq123';*/
						$postArray['merchant_refund_id'] = 'LPS_PRO_bingocrush_s';
                                                $postArray['merchant_pwd'] = 'lkoijuhyggftrf454';
						$postArray['refund_type'] = 5;
						$postArray['merchant_ref_number'] = 1;
						$postArray['firstname'] = $cardDetails['card_holder_first_name'];
						$postArray['lastname'] = $cardDetails['card_holder_last_name'];
						$postArray['bill_firstname'] = $cardDetails['card_holder_first_name'];
						$postArray['bill_lastname'] = $cardDetails['card_holder_last_name'];
						$postArray['bill_address1'] = $address;
						$postArray['bill_city'] = $city;
						$postArray['bill_state'] = $state;
						$postArray['bill_zip'] = $pin;
						$postArray['bill_country'] = $country;
						$postArray['pan'] = $cardDetails['card_no'];
						$postArray['pan_expmo'] = $cardDetails['card_expiry_month'];
						$postArray['pan_expyr'] = $cardDetails['card_expiry_year'];
						$postArray['pan_type'] = $cardDetails['card_subtype'];
						$postArray['scsscheck'] = 'Y';
						$postArray['crdstrg_token'] = '';
						$postArray['refund_currency'] = $playerData[0]['base_currency'];
						$postArray['refund_amount'] = $values['amount'];
						$postArray['settle_currency'] = $playerData[0]['base_currency'];
						
						/* $postString = "";
						foreach($postArray as $index => $value)
						{
							$postString .= $index . "=" . $value . "&"; 
						}
						Zenfox_Debug::dump($postString, 'string', true, true); */
						
						$client = new Zend_Http_Client('https://lps-reports.com/refunds/refund.asp');
						
						$client->setParameterPost($postArray);
						$client->request(Zend_Http_Client::POST);
						$response = $client->getLastResponse()->getBody();
						
						$data['playerId'] = $playerId;
						$data['cardId'] = $values['cardId'];
						$data['csrId'] = $store['id'];
						$data['response'] = $response;
						$data['amount'] = $values['amount'];
						$data['status'] = 'PROCESSED';
						
						$response = explode('&', $response);
						$finalDataArray = array();
						foreach($response as $responseData)
						{
							$explodeResponseData = explode("=", $responseData);
							$finalDataArray[$explodeResponseData[0]] = $explodeResponseData[1];
							//Zenfox_Debug::dump($explodeResponseData, 'exData');
						}
						
						if($finalDataArray['RefundSubmit_status'] != 00)
						{
							$data['status'] = 'ERROR';
							$data['error'] = $finalDataArray['RefundSubmit_status'];
						}
						
						$bankWithdrawalRecords = new BankWithdrawalRecords();
						$recordId = $bankWithdrawalRecords->addRecords($data);
						if($finalDataArray['RefundSubmit_status'] == 00 && $finalDataArray['Bank_status'] == 00)
						{
							if($recordId)
							{
								$transaction = new PlayerTransactions();
								$dataArray = array(
									'player_id' => $playerId,
									'withdrawal_id' => $withdrawalId,
									'amount'	=> $values['amount'],
									'type'		=> 'WITHDRAWAL_ACCEPT',
									'notes'		=> $values['notes']
								);
							}
							else
							{
								$error = true;
								$this->_helper->FlashMessenger(array('error' => $form->getView()->translate('Some problem has been occured while inserting records in bank withdrawal.')));
								echo $form->getView()->translate('Some problem has been occured while inserting records in bank withdrawal.');
							}
						}
						else
						{
							$errorCode = $finalDataArray['RefundSubmit_status'];
							if(!$errorCode)
							{
								$errorCode = $finalDataArray['Bank_status'];
							}
							
							$filePath = APPLICATION_PATH . '/site_configs/bingocrush/LPSRecreditsErrorCode.json';
							$fh = fopen($filePath, 'r');
							$fileData = fread($fh, filesize($filePath));
							$jsonToArray = Zend_Json::decode($fileData);
							
							$error = true;
							$this->_helper->FlashMessenger(array('error' => $form->getView()->translate($jsonToArray[$errorCode])));
							echo $form->getView()->translate($jsonToArray[$errorCode]);
						}

					}
					else
					{
						$error = true;
						$this->_helper->FlashMessenger(array('error' => $form->getView()->translate('Select a card')));
						echo $form->getView()->translate('Select a card');
					}
				}
				elseif(!$error)
				{
					$error = true;
					$this->_helper->FlashMessenger(array('error' => $form->getView()->translate('Invalid Options')));
					echo $form->getView()->translate('Invalid Options');
				}

				
				if($error == false)
				{
					$sourceId = $transaction->saveProcessing($dataArray);
					//$sourceId = 2;
					
					if($sourceId == false)
					{
						$this->_helper->FlashMessenger(array('error' => $form->getView()->translate('Transaction not saved')));
						echo $form->getView()->translate("Not Saved");
					}
					else
					{
						if($recordId)
						{
							$bankWithdrawalRecords->updateSourceId($recordId, $sourceId);
						}
						//echo 'HERE';
						$tries = 0;
						$auditReport = new AuditReport();

						$session = new Zend_Auth_Storage_Session();
						$store = $session->read();
						$csrId = $store['authDetails'][0]['id'];
						
						while ($auditReport->checkIfAuditIdPresent($sourceId, $playerId, $csrId) === false && $tries < 4)
						{
							$tries = $tries + 1;		
						}
						
						if($auditReport->checkIfAuditIdPresent($sourceId,$playerId,$csrId) === false)
						{
							//No entry in Audit Report so this leads to a timeout
							$this->_helper->FlashMessenger(array('error' => $form->getView()->translate('Transaction timed out')));
							echo 'Transaction timed out';						
						}
						else
						{
							//Everything is well.
							$array = $auditReport->checkIfAuditIdPresent($sourceId,$playerId,$csrId);

							if($array[0]['error'] == 'NOERROR')
							{
								$this->_helper->FlashMessenger(array('error' => $form->getView()->translate('Transaction has been processed')));
								echo $form->getView()->translate('Transaction processed');
								$data = $withdrawalRequest->adminGetDetails($playerId);
							}
							else 
							{
								//print_r($array[0]['notes']);exit();
								$this->_helper->FlashMessenger(array('error' => $form->getView()->translate('Transaction has some errors.')));
								$this->_helper->FlashMessenger(array('error' => $form->getView()->translate('Error Note ')));
								echo $array[0]['notes'];
								
							}
						}
					}
				}
					
				}
				
			}
		
			if($data == false)
			{
				$this->view->data = false;
			
			}
			else
			{
				$this->view->data = $data;
			}
	}
	
	public function requestAction()
	{
		$form = new Admin_TransactionForm();
		$this->view->form = $form->getPlayerWithdrawalForm();
		
		$authSession = new Zend_Auth_Storage_Session();
		$sessionData = $authSession->read();
		$csrId = $sessionData['id'];
        $csrfrontendids = $sessionData["frontend_ids"];
        $player = new Player();
        
		if($this->getRequest()->isPost())
		{
			if($form->isValid($_POST))
			{
				$data = $form->getValues();
				$playerId = $data['playerId'];
				
				$playerfrontendid = $player->getfrontendidofplayer($playerId);
						
				if (in_array($playerfrontendid,$csrfrontendids))
				{
					$amount = $data['amount'];
					$transaction = new PlayerTransactions();
					$dataArray = array(
							'player_id' => $playerId,
							'type' => 'WITHDRAWAL_REQUEST',
							'notes' => 'Withdrawal Request',
							'amount' => $amount 
					);
				
					$sourceId = $transaction->requestPlayerWithdrawal($dataArray);
					
					if($sourceId == false)
					{
						$error = 'Transaction not saved';
					}
					else
					{
						$tries = 0;
						$withdrawalRequest = new AuditReport();
						while ($withdrawalRequest->checkError($sourceId, $playerId) == false && $tries < 4)
						{
							$tries = $tries + 1;
						}
						$result = $withdrawalRequest->checkError($sourceId,$playerId);
						if(!$result)
						{
						//No entry in Audit Report so this leads to a timeout
							$error = 'Transaction timed out';
						}
						elseif(($result['processed'] == 'PROCESSED') && ($result['error'] == 'NOERROR'))
						{
							$notice = "Transaction has Been Processed.";
							$this->_helper->FlashMessenger(array('notice' => $notice));
							$this->view->form = "";
						}
						else
						{
							$this->_helper->FlashMessenger(array('error'=> 'Your amount is not credited, please try again. If problem persists, check the following audit Id:: '. $result['auditId']));
						}
					}		
				}
				else
				{
					$this->_helper->FlashMessenger(array('error' => "Player not found or You are not authorised to view/edit this player's details"));				
				}
				
			}
		}
	}
	
	
		
}



	
	
