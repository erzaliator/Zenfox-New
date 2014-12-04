<?php

require_once dirname(__FILE__).'/../forms/ListallForm.php';
require_once dirname(__FILE__).'/../forms/FlowbackForm.php';
require_once dirname(__FILE__).'/../forms/WithdrawalForm.php';
require_once dirname(__FILE__).'/../forms/PersonalDetailsForm.php';
require_once dirname(__FILE__).'/../forms/IdUploadForm.php';
require_once dirname(__FILE__).'/../forms/BankDetailsForm.php';
require_once dirname(__FILE__).'/../forms/AddressUploadForm.php';

class Player_WithdrawalController extends Zenfox_Controller_Action
{	
	
	private $_form;
	private $_session;
	private $_namespace;
	private $_temp;
	private $_noOfParts;
	public function indexAction()
	{
	
	}
	
	
	public function requestAction()
	{
		$form = new Player_WithdrawalForm();
		$this->view->form = $form;

		$ajaxReq = $this->getRequest()->ajax;
		$this->view->ajaxReq = $ajaxReq;
		$error = false;
		
		$session = new Zenfox_Auth_Storage_Session();
		$store = $session->read();
		
		$playerId = $store['id'];
		
		$balance = $store['authDetails'][0]['balance'];
		$cash = $store['authDetails'][0]['cash'];
		$bonus = $store['authDetails'][0]['bonus_bank'] + $store['authDetails'][0]['bonus_winnings'];
		
		$this->view->balance = $balance;
		$this->view->cash = $cash;
		$this->view->bonus = $bonus;
		
		if($this->getRequest()->isPost()) 
		{
			if($form->isValid($_POST))
			{
				$data = $form->getValues();
				$amount = $data['amount'];
			
				$transaction = new PlayerTransactions();	

				$loginName = $store['authDetails'][0]['login'];

				$winnings = $store['authDetails'][0]['winnings'];

				$totalDeposits = $store['authDetails'][0]['total_deposits'];
				if($totalDeposits <= 0)
				{
					$error = 'You did not deposit any amount.';
					//$this->_helper->FlashMessenger(array('error' => $error));
				}
				elseif($amount > 5000)
				{
					$error = 'Withdrawal amount should be less than 5000';
					//$this->_helper->FlashMessenger(array('error' => $error));
				}
				/*elseif($amount > $winnings)
				{
					$error = 'Withdrawal amount is more than Winning amount';
					//$this->_helper->FlashMessenger(array('error' => $error));
					//$this->_helper->FlashMessenger(array('error' => 'Withdrawal amount is more than Winning amount'));
				}*/
				else
				{
					if($ajaxReq)
					{
						$dataArray = array(
							'player_id' => $playerId,
							'type' => 'WITHDRAWAL_FLOWBACK',
							'notes' => 'Withdrawal Flowback Request',
							'amount' => $amount 
						);
						$subject = "Withdrawal Flowback";
					}
					else
					{
						$dataArray = array(
							'player_id' => $playerId,
							'type' => 'WITHDRAWAL_REQUEST',
							'notes' => 'Withdrawal Request',
							'amount' => $amount 
						);
						$subject = "Withdrawal Request";
					}
					
					$sourceId = $transaction->registerWithdrawalRequest($dataArray);		
					if($sourceId == false)
					{
						$error = 'Transaction not saved';
						//$this->_helper->FlashMessenger(array('error' => 'Transaction not saved'));
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
							$error = 'Transaction timed out';
							//No entry in Audit Report so this leads to a timeout
							//$this->_helper->FlashMessenger(array('error' => 'Transaction timed out'));						
						}
						elseif(($result['processed'] == 'PROCESSED') && ($result['error'] == 'NOERROR'))
						{
							//Everything is well.
							$ticket = new Tickets($playerId, 'player');
							$ticketData['subject'] = $subject;
							$ticketData['reply_msg'] = "I have made " . strtolower($subject) . " for amount - " . $amount;
							$ticket->createTicket($ticketData);

							$mailMessage = $playerName . " has made " . strtolower($subject) . " for amount Rs. " . $amount . " Check the records<a href = 'http://www.admin.taashtime.com/player/view/playerId/$playerId'> HERE </a><br>Transaction Id -> " . $sourceId . "<br>Audit Id -> " . $result['auditId'];
							$mail = new Mail();
							$mail->sendMails($subject . '-' . $playerId . '-' . $loginName, $mailMessage, $mailMessage,'support@bingocrush.co.uk', '', '');
							
							/*$mail = new Mail();
							$mail->sendToOne('Withdrawalrequest', 'WITHDRAWAL_REQUEST', $amount, '', 'support@taashtime.com');
*/
							$url = '/ticket/view';
/*							$this->_helper->FlashMessenger(array('notice' => $this->view->translate("Transaction has Been Processed. A customer support ticket has been generated for you and it will be evaluated by our admin team. Please %sClick Here%s to check your ticket.", "<a href=\"" . $this->view->baseUrl($url) . "\">", "</a>")));
							//$this->_helper->FlashMessenger(array('notice' => 'Transaction has Been Processed'));
							$this->view->form = "";*/

							//$notice = "Transaction has Been Processed. A customer support ticket has been generated for you and it will be evaluated by our admin team. Please <a href='$url'>Click Here</a> to check your ticket. <a href='/game'>Click Here</a> for games.";
							$notice = "Transaction has Been Processed. It will be evaluated by our admin team. Till then please<a href='/game'>Click Here</a> for games.";
							if($ajaxReq)
							{
								Zend_Layout::getMvcInstance()->disableLayout();
								echo 'notice&'.$notice;
							}
							else
							{
								$this->_helper->FlashMessenger(array('notice' => $notice));
								//$this->_helper->FlashMessenger(array('notice' => $this->view->translate("Transaction has Been Processed. A customer support ticket has been generated for you and it will be evaluated by our admin team. Please %sClick Here%s to check your ticket.", "<a href=\"" . $this->view->baseUrl($url) . "\">", "</a>")));
								$this->view->form = "";
							}
						}
						elseif($result['error'] == 'ERROR')
						{
							$notes = $result['notes'];
							$explodeNotes = explode(":", $notes);
							$error = $notes;
							$error .= ". Please contact support with the following audit Id:: " . $result['auditId'];
							if(isset($explodeNotes[3]))
							{
								$error = $explodeNotes[3];
							}
							//$error = 'Your amount is not credited, please try again. If problem persists, please contact support with the following audit Id:: '. $result['auditId'];
							//$this->_helper->FlashMessenger(array('error' => $this->view->translate('Your amount is not credited, please try again. If problem persists, please contact support with the following audit Id:: '. $result['auditId'])));
						}
					}
				}	
			}
			else
			{
				foreach($form->getMessages() as $errorMessage)
				{
					if($ajaxReq)
					{
						$error = $errorMessage['notGreaterThan'];
					}
				}
				// Need a proper error message.
				//$this->_helper->FlashMessenger(array('error' => 'Valid Post Error'));
			}
		}
		if($error)
		{
			if($ajaxReq)
			{
				Zend_Layout::getMvcInstance()->disableLayout();
				echo 'error&'.$error;
			}
			else
			{
				$this->_helper->FlashMessenger(array('error' => $this->view->translate($error)));
			}
			//$this->_helper->FlashMessenger(array('notice' => 'Minimum Withdrawal Limit Rs. 500'));
		}
		/*else
		{
			$this->_helper->FlashMessenger(array('notice' => 'Minimum Withdrawal Limit Rs. 500'));
		}*/
	}
	
	public function modifyAction()
	{
		$type = $this->getRequest()->type;
		$kycobj = new Kyc();
		switch($type)
		{
			case 'updateidentity':
				
				$kycdata = $kycobj->getkycdetails($_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"]);

				$form = new Player_personaldetailsForm();
				$this->view->form = $form->getform($kycdata,"ID");
				
				break;
			case 'addbankdetails':
				
				$form = new Player_personaldetailsForm();
				$this->view->form = $form->getform("","BANK");
				
				break;
			case 'mydetails':
					$this->view->verified = yes;
			
				$kycdata = $kycobj->getkycminidetails($_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"]);
			//	Zenfox_Debug::dump($kycdata);exit();
				$count = count($kycdata);
				$count--;
				while($count>=0)
				{
					$detailskyc[$count][proof] = $kycdata[$count][type];
					
					if($kycdata[$count][kyc_document] == "OTHER")
					{
						$detailskyc[$count][IDtype] = $kycdata[$count][kyc_document_other];
						$detailskyc[$count][IDnumber] = $kycdata[$count][kyc_document_number];
						$detailskyc[$count][ExpiryDate] = $kycdata[$count][expiry_date];
						
					}
					else
					{
						$detailskyc[$count][IDtype] = $kycdata[$count][kyc_document];
						$detailskyc[$count][IDnumber] = $kycdata[$count][kyc_document_number];
						$detailskyc[$count][ExpiryDate] = $kycdata[$count][expiry_date];
					}
					$detailskyc[$count][Status] = $kycdata[$count][status];
					$count--;
				}
				$bankdetailsobj = new BankDetails();
				$bankdetails = $bankdetailsobj->getbankminidetails($_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"]);
				
				$count = count($bankdetails);
				$count--;
				while($count>=0)
				{
					$detailsbank[$count][name] = $bankdetails[$count][name];
					$detailsbank[$count][name_of_bank] = $bankdetails[$count][name_of_bank];
					$detailsbank[$count][account_number] = $bankdetails[$count][account_number];
					$detailsbank[$count][branch] = $bankdetails[$count][branch];
					$count--;
				}
				
				$this->view->table1 = $detailskyc;
				$this->view->table2 = $detailsbank;
				break;
			
		}
		
		
		if($this->getRequest()->isPost())
		{
			if($form->isValid($_POST))
			{
				$postvalues = $form->getValues();
				
				if(!empty($postvalues["bank_detail_form"]["bank"]))
				{
					
					if($postvalues["bank_detail_form"]["BankAccountNumber"] == $postvalues["bank_detail_form"]["BankAccountNumberRe"])
					{
						$this->view->form = "";
						$bankdetailsobj = new BankDetails();
						$data = $bankdetailsobj->getmaxbankid($_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"]);
						
						if(($data[name]== $postvalues["subform"]["nameasonbank"]) and ($data[name_of_bank]== $postvalues["bank_detail_form"]["bank"]) and ($data[branch]== $postvalues["bank_detail_form"]["Branch"]) and ($data[account_number]== $postvalues["bank_detail_form"]["BankAccountNumber"]))
						{
							$this->_helper->FlashMessenger( 'Current bank details are already added.');
						}
						else
						{
							$bankdetailsobj->insertbankdetails($_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"],$postvalues["bank_detail_form"]["nameasonbank"],$postvalues["bank_detail_form"]["bank"],$postvalues["bank_detail_form"]["BankAccountNumber"],$postvalues["bank_detail_form"]["ifsccode"],$postvalues["bank_detail_form"]["Branch"]);
						
							$this->_helper->FlashMessenger( 'The new bank details are added successfully. We will get back to you as soon as possible.');
						}
					}
					else 
					{
						$this->_helper->FlashMessenger( 'The account number does not match. Please check it again.');
					}
				}
				else 
				{
					$temppath = Zend_Registry::getInstance()->get('UploadDocumentPath');
					
					$today = new Zend_Date();
					$currentTime = $today->get(Zend_Date::W3C);
					
					$kycobj->disableproofs($_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"], "IDPROOF");
					
						if($postvalues[idproof_form]["idproof"] == "OTHER")
						{
							$kycobj->insertidproof($_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"],"IDPROOF",$postvalues[idproof_form]["idproof"],$postvalues[idproof_form]["idproofnumber"],$postvalues[idproof_form]["idproofexpiry"],$postvalues[idproof_form]["idproofauthority"],$postvalues[idproof_form]["idproofother"]);
						}
						else 
						{
							
							$kycobj->insertidproof($_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"],"IDPROOF",$postvalues[idproof_form]["idproof"],"","","","");
						}
						
						$kycid = $kycobj->getmaxid($_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"]);
						
						
							if(!empty($_FILES["ID1"]["tmp_name"]))
							{
								$oldpath =$temppath. $postvalues[idproof_form]["ID1"];
								$name = $_FILES["ID1"]["name"];
								$ext = end(explode(".", $name));
								$kycdocobj1 = new KycDocuments();
								$docnumber = 1;
								
								if($postvalues[idproof_form]["idproof"] != "OTHER")
								{
									$newpath = $temppath.$_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"]."_IDPROOF_".$postvalues[idproof_form]["idproof"]."_".$kycid."_1_".md5($_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"].$kycid.$docnumber.$currentTime).".".$ext;
								}
								else
								{
									$newpath = $temppath.$_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"]."_IDPROOF_".$postvalues[idproof_form]["idproofother"]."_".$kycid."_1_".md5($_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"].$kycid.$docnumber.$currentTime).".".$ext;
								}
								
								rename($oldpath, $newpath);
								$kycdocobj1->insertdoc($_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"],$kycid,$newpath);
							}
							
							if(!empty($_FILES["ID2"]["tmp_name"]))
							{
								$oldpath =$temppath. $postvalues[idproof_form]["ID2"];
								$name = $_FILES["ID2"]["name"];
								$ext = end(explode(".", $name));
							
								$kycdocobj2 = new KycDocuments();
								
								$docnumber = $kycdocobj2->getdocnumber($_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"],$kycid);
								if($postvalues[idproof_form]["idproof"] != "OTHER")
								{
									$newpath = $temppath.$_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"]."_IDPROOF_".$postvalues[idproof_form]["idproof"]."_".$kycid."_".$docnumber."_".md5($_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"].$kycid.$docnumber.$currentTime).".".$ext;
								}
								else
								{
									$newpath = $temppath.$_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"]."_IDPROOF_".$postvalues[idproof_form]["idproofother"]."_".$kycid."_".$docnumber."_".md5($_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"].$kycid.$docnumber.$currentTime).".".$ext;
								}
							
								rename($oldpath, $newpath);
								$kycdocobj2->insertdoc($_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"],$kycid,$newpath);
						
							}
							if(!empty($_FILES["ID3"]["tmp_name"]))
							{
								$oldpath =$temppath. $postvalues[idproof_form]["ID3"];
								$name = $_FILES["ID3"]["name"];
								$ext = end(explode(".", $name));
								$kycdocobj3 = new KycDocuments();
								$docnumber = $kycdocobj3->getdocnumber($_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"],$kycid);
								if($postvalues[idproof_form]["idproof"] != "OTHER")
								{
									$newpath = $temppath.$_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"]."_IDPROOF_".$postvalues[idproof_form]["idproof"]."_".$kycid."_".$docnumber."_".md5($_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"].$kycid.$docnumber.$currentTime).".".$ext;
								}
								else
								{
									$newpath = $temppath.$_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"]."_IDPROOF_".$postvalues[idproof_form]["idproofother"]."_".$kycid."_".$docnumber."_".md5($_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"].$kycid.$docnumber.$currentTime).".".$ext;
								}
							
								rename($oldpath, $newpath);
								$kycdocobj3->insertdoc($_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"],$kycid,$newpath);
						
							}

							
							$kycobj2 = new Kyc();
							
					$kycobj2->disableproofs($_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"], "ADDRESSPROOF");
				
					if($postvalues[address_form]["addressproof"] == "OTHER")
					{
						$kycobj2->insertidproof($_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"],"ADDRESSPROOF",$postvalues[address_form]["addressproof"],$postvalues[address_form]["addressproofnumber"],$postvalues[address_form]["addressproofexpiry"],$postvalues[address_form]["addressproofauthority"],$postvalues[address_form]["otheraddressproof"]);
					}
					else
					{
						$kycobj2->insertidproof($_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"],"ADDRESSPROOF",$postvalues[address_form]["addressproof"],"","","","");
					}
					
					
					$kycid = $kycobj2->getmaxid($_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"]);
					
						if(!empty($_FILES["ADDR1"]["tmp_name"]))
						{
							$oldpath =$temppath. $postvalues[address_form]["ADDR1"];
							$name = $_FILES["ADDR1"]["name"];
							$ext = end(explode(".", $name));
							$kycdocobj4 = new KycDocuments();
							$docnumber = 1;
							if($postvalues[address_form]["addressproof"] != "OTHER")
							{
								$newpath = $temppath.$_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"]."_ADDRESSPROOF_".$postvalues[address_form]["addressproof"]."_".$kycid."_1_".md5($_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"].$kycid.$docnumber.$currentTime).".".$ext;
							}
							else
							{
								$newpath = $temppath.$_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"]."_ADDRESSPROOF_".$postvalues[address_form]["addressproofother"]."_".$kycid."_1_".md5($_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"].$kycid.$docnumber.$currentTime).".".$ext;
							}
							
							rename($oldpath, $newpath);
							$kycdocobj4->insertdoc($_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"],$kycid,$newpath);
						}
						if(!empty($_FILES["ADDR2"]["tmp_name"]))
						{
							$oldpath =$temppath. $postvalues[address_form]["ADDR2"];
							$name = $_FILES["ADDR2"]["name"];
							$ext = end(explode(".", $name));
							$kycdocobj5 = new KycDocuments();
							$docnumber = $kycdocobj5->getdocnumber($_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"],$kycid);
							if($postvalues[address_form]["addressproof"] != "OTHER")
							{
								$newpath = $temppath.$_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"]."_ADDRESSPROOF_".$postvalues[address_form]["addressproof"]."_".$kycid."_".$docnumber."_".md5($_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"].$kycid.$docnumber.$currentTime).".".$ext;
							}
							else
							{
								$newpath = $temppath.$_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"]."_ADDRESSPROOF_".$postvalues[address_form]["addressproofother"]."_".$kycid."_".$docnumber."_".md5($_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"].$kycid.$docnumber.$currentTime).".".$ext;
							}
							
							rename($oldpath, $newpath);

							$kycdocobj5->insertdoc($_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"],$kycid,$newpath);
						}
						if(!empty($_FILES["ADDR3"]["tmp_name"]))
						{
							$oldpath =$temppath. $postvalues[address_form]["ADDR3"];
							$name = $_FILES["ADDR3"]["name"];
							$ext = end(explode(".", $name));
							$kycdocobj6 = new KycDocuments();
							$docnumber = $kycdocobj6->getdocnumber($_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"],$kycid);
							if($postvalues[address_form]["addressproof"] != "OTHER")
							{
								$newpath = $temppath.$_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"]."_ADDRESSPROOF_".$postvalues[address_form]["addressproof"]."_".$kycid."_".$docnumber."_".md5($_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"].$kycid.$docnumber.$currentTime).".".$ext;
							}
							else
							{
								$newpath = $temppath.$_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"]."_ADDRESSPROOF_".$postvalues[address_form]["addressproofother"]."_".$kycid."_".$docnumber."_".md5($_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"].$kycid.$docnumber.$currentTime).".".$ext;
							}
							
							rename($oldpath, $newpath);
							$kycdocobj6->insertdoc($_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"],$kycid,$newpath);
						}
					
					$this->_helper->FlashMessenger('Your ID proof and Address proof are updated successfully. Our verification team will verify your documents. We will get back to you as soon as possible.');
					$this->view->form = "";
						
				}
			}
		}
	}
	
	public function verificationAction()
	{
		$bankdetailsobj = new BankDetails();
		$bankdetails = $bankdetailsobj->getbankdetails($_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"]);
		
		$kycobj = new Kyc();
		$kyc = $kycobj->getkycdetails($_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"]);
		
		
		if((!empty($bankdetails)) and (!empty($kyc)))
		{
			if(($kyc[0][status] == "PENDING") or ($kyc[1][status] == "PENDING"))
			{
				$this->_helper->FlashMessenger( 'Your details are set for verification. If you want to update your details, please click on the respective links.');
				$this->view->verified = yes;
				$kycobj = new Kyc();
				$kycdata = $kycobj->getkycminidetails($_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"]);
			//	Zenfox_Debug::dump($kycdata);exit();
				$count = count($kycdata);
				$count--;
				while($count>=0)
				{
					$detailskyc[$count][proof] = $kycdata[$count][type];
					
					if($kycdata[$count][kyc_document] == "OTHER")
					{
						$detailskyc[$count][IDtype] = $kycdata[$count][kyc_document_other];
						$detailskyc[$count][IDnumber] = $kycdata[$count][kyc_document_number];
						$detailskyc[$count][ExpiryDate] = $kycdata[$count][expiry_date];
					}
					else
					{
						$detailskyc[$count][IDtype] = $kycdata[$count][kyc_document];
						$detailskyc[$count][IDnumber] = $kycdata[$count][kyc_document_number];
						$detailskyc[$count][ExpiryDate] = $kycdata[$count][expiry_date];
					}
					$detailskyc[$count][Status] = $kycdata[$count][status];
					$count--;
				}
				$bankdetailsobj = new BankDetails();
				$bankdetails = $bankdetailsobj->getbankminidetails($_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"]);
				
				$count = count($bankdetails);
				$count--;
				while($count>=0)
				{
					$detailsbank[$count][name] = $bankdetails[$count][name];
					$detailsbank[$count][name_of_bank] = $bankdetails[$count][name_of_bank];
					$detailsbank[$count][account_number] = $bankdetails[$count][account_number];
					$detailsbank[$count][branch] = $bankdetails[$count][branch];
					$count--;
				}
				
				$this->view->table1 = $detailskyc;
				$this->view->table2 = $detailsbank;
				
			}
			elseif(($kyc[0][status] == "ACCEPTED") and ($kyc[1][status] == "ACCEPTED"))
			{
				$form = new Player_WithdrawalForm();
				$this->view->form = $form;
				$this->view->withdrawalForm = true;
				$this->view->verified = yes;
			}
			else 
			{
				$this->_helper->FlashMessenger('Verification Rejected: Your documents are rejected from our verification team. You can contact to our customer support or update your documents by clicking on Update Identity link');
				$this->view->verified = yes;
			}
			
		}
		else 
		{
			
			$accountobj = new Account();
			$playerdata = $accountobj->getdetails($_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"]);
			
			
			$data["player_id"]=	 $playerdata["player_id"];
			$data["first_name"]= $playerdata["first_name"];
 			$data["last_name"]= $playerdata["last_name"] ;
			$data["email"]=	$playerdata["email"];
			$data["sex"]=  $playerdata["sex"] ;
 			$data["dateofbirth"]= $playerdata["dateofbirth"] ;
			$data["address"]= $playerdata["address"] ;
			$data["city"]=  $playerdata["city"];
			$data["state"]= $playerdata["state"] ;
			$data["country"]= $playerdata["country"];
 			$data["pin"]= $playerdata["pin"] ;
 			$data["phone"]=	$playerdata["phone"];
			
			
		
			$form = new Player_personaldetailsForm();
			$this->view->form = $form->getform($data);
		}
		

		if($this->getRequest()->isPost()) 
		{
			if((!empty($bankdetails)) and (!empty($kyc)))
			{
				//$this->_helper->FlashMessenger( 'details set for verifation and are verified in a maximum of 3 days');
				
			}
			else 
			{
			if($form->isValid($_POST))
			{
				$postvalues = $form->getValues();
				$temppath = Zend_Registry::getInstance()->get('UploadDocumentPath');
				
					if($postvalues[bank_detail_form]["BankAccountNumber"] == $postvalues[bank_detail_form]["BankAccountNumberRe"])
					{
						
						$today = new Zend_Date();
						$currentTime = $today->get(Zend_Date::W3C);
						
						$kycdocobj = new KycDocuments();
					
						if($postvalues[idproof_form]["idproof"] == "OTHER")
						{
							$kycobj->insertidproof($_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"],"IDPROOF",$postvalues[idproof_form]["idproof"],$postvalues[idproof_form]["idproofnumber"],$postvalues[idproof_form]["idproofexpiry"],$postvalues[idproof_form]["idproofauthority"],$postvalues[idproof_form]["idproofother"]);
						}
						else 
						{
							
							$kycobj->insertidproof($_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"],"IDPROOF",$postvalues[idproof_form]["idproof"],"","","","");
						}
						
						$kycid = $kycobj->getmaxid($_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"]);
						
						
							if(!empty($_FILES["ID1"]["tmp_name"]))
							{
								$oldpath =$temppath. $postvalues[idproof_form]["ID1"];
								$name = $_FILES["ID1"]["name"];
								$ext = end(explode(".", $name));
								$kycdocobj1 = new KycDocuments();
								$docnumber = 1;
								
								if($postvalues[idproof_form]["idproof"] != "OTHER")
								{
									$newpath = $temppath.$_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"]."_IDPROOF_".$postvalues[idproof_form]["idproof"]."_".$kycid."_1_".md5($_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"].$kycid.$docnumber.$currentTime).".".$ext;
								}
								else
								{
									$newpath = $temppath.$_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"]."_IDPROOF_".$postvalues[idproof_form]["idproofother"]."_".$kycid."_1_".md5($_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"].$kycid.$docnumber.$currentTime).".".$ext;
								}
								
								rename($oldpath, $newpath);
								$kycdocobj1->insertdoc($_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"],$kycid,$newpath);
							}
							
							if(!empty($_FILES["ID2"]["tmp_name"]))
							{
								$oldpath =$temppath. $postvalues[idproof_form]["ID2"];
								$name = $_FILES["ID2"]["name"];
								$ext = end(explode(".", $name));
							
								$kycdocobj2 = new KycDocuments();
								
								$docnumber = $kycdocobj2->getdocnumber($_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"],$kycid);
								if($postvalues[idproof_form]["idproof"] != "OTHER")
								{
									$newpath = $temppath.$_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"]."_IDPROOF_".$postvalues[idproof_form]["idproof"]."_".$kycid."_".$docnumber."_".md5($_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"].$kycid.$docnumber.$currentTime).".".$ext;
								}
								else
								{
									$newpath = $temppath.$_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"]."_IDPROOF_".$postvalues[idproof_form]["idproofother"]."_".$kycid."_".$docnumber."_".md5($_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"].$kycid.$docnumber.$currentTime).".".$ext;
								}
							
								rename($oldpath, $newpath);
								$kycdocobj2->insertdoc($_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"],$kycid,$newpath);
						
							}
							if(!empty($_FILES["ID3"]["tmp_name"]))
							{
								$oldpath =$temppath. $postvalues[idproof_form]["ID3"];
								$name = $_FILES["ID3"]["name"];
								$ext = end(explode(".", $name));
								$kycdocobj3 = new KycDocuments();
								$docnumber = $kycdocobj3->getdocnumber($_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"],$kycid);
								if($postvalues[idproof_form]["idproof"] != "OTHER")
								{
									$newpath = $temppath.$_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"]."_IDPROOF_".$postvalues[idproof_form]["idproof"]."_".$kycid."_".$docnumber."_".md5($_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"].$kycid.$docnumber.$currentTime).".".$ext;
								}
								else
								{
									$newpath = $temppath.$_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"]."_IDPROOF_".$postvalues[idproof_form]["idproofother"]."_".$kycid."_".$docnumber."_".md5($_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"].$kycid.$docnumber.$currentTime).".".$ext;
								}
							
								rename($oldpath, $newpath);
								$kycdocobj3->insertdoc($_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"],$kycid,$newpath);
						
							}

							
							$kycobj2 = new Kyc();
							
					$kycobj2->disableproofs($_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"], "ADDRESSPROOF");
				
					if($postvalues[address_form]["addressproof"] == "OTHER")
					{
						$kycobj2->insertidproof($_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"],"ADDRESSPROOF",$postvalues[address_form]["addressproof"],$postvalues[address_form]["addressproofnumber"],$postvalues[address_form]["addressproofexpiry"],$postvalues[address_form]["addressproofauthority"],$postvalues[address_form]["otheraddressproof"]);
					}
					else
					{
						$kycobj2->insertidproof($_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"],"ADDRESSPROOF",$postvalues[address_form]["addressproof"],"","","","");
					}
					
					
					$kycid = $kycobj2->getmaxid($_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"]);
					
						if(!empty($_FILES["ADDR1"]["tmp_name"]))
						{
							$oldpath =$temppath. $postvalues[address_form]["ADDR1"];
							$name = $_FILES["ADDR1"]["name"];
							$ext = end(explode(".", $name));
							$kycdocobj4 = new KycDocuments();
							$docnumber = 1;
							if($postvalues[address_form]["addressproof"] != "OTHER")
							{
								$newpath = $temppath.$_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"]."_ADDRESSPROOF_".$postvalues[address_form]["addressproof"]."_".$kycid."_1_".md5($_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"].$kycid.$docnumber.$currentTime).".".$ext;
							}
							else
							{
								$newpath = $temppath.$_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"]."_ADDRESSPROOF_".$postvalues[address_form]["addressproofother"]."_".$kycid."_1_".md5($_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"].$kycid.$docnumber.$currentTime).".".$ext;
							}
							
							rename($oldpath, $newpath);
							$kycdocobj4->insertdoc($_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"],$kycid,$newpath);
						}
						if(!empty($_FILES["ADDR2"]["tmp_name"]))
						{
							$oldpath =$temppath. $postvalues[address_form]["ADDR2"];
							$name = $_FILES["ADDR2"]["name"];
							$ext = end(explode(".", $name));
							$kycdocobj5 = new KycDocuments();
							$docnumber = $kycdocobj5->getdocnumber($_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"],$kycid);
							if($postvalues[address_form]["addressproof"] != "OTHER")
							{
								$newpath = $temppath.$_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"]."_ADDRESSPROOF_".$postvalues[address_form]["addressproof"]."_".$kycid."_".$docnumber."_".md5($_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"].$kycid.$docnumber.$currentTime).".".$ext;
							}
							else
							{
								$newpath = $temppath.$_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"]."_ADDRESSPROOF_".$postvalues[address_form]["addressproofother"]."_".$kycid."_".$docnumber."_".md5($_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"].$kycid.$docnumber.$currentTime).".".$ext;
							}
							
							rename($oldpath, $newpath);

							$kycdocobj5->insertdoc($_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"],$kycid,$newpath);
						}
						if(!empty($_FILES["ADDR3"]["tmp_name"]))
						{
							$oldpath =$temppath. $postvalues[address_form]["ADDR3"];
							$name = $_FILES["ADDR3"]["name"];
							$ext = end(explode(".", $name));
							$kycdocobj6 = new KycDocuments();
							$docnumber = $kycdocobj6->getdocnumber($_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"],$kycid);
							if($postvalues[address_form]["addressproof"] != "OTHER")
							{
								$newpath = $temppath.$_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"]."_ADDRESSPROOF_".$postvalues[address_form]["addressproof"]."_".$kycid."_".$docnumber."_".md5($_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"].$kycid.$docnumber.$currentTime).".".$ext;
							}
							else
							{
								$newpath = $temppath.$_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"]."_ADDRESSPROOF_".$postvalues[address_form]["addressproofother"]."_".$kycid."_".$docnumber."_".md5($_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"].$kycid.$docnumber.$currentTime).".".$ext;
							}
							
							rename($oldpath, $newpath);
							$kycdocobj6->insertdoc($_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"],$kycid,$newpath);
						}
						
						$bankdetailsobj->insertbankdetails($_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"],$postvalues[bank_detail_form]["nameasonbank"],$postvalues[bank_detail_form]["bank"],$postvalues[bank_detail_form]["BankAccountNumber"],$postvalues[bank_detail_form]["ifsccode"],$postvalues[bank_detail_form]["Branch"]);
						//Zenfox_Debug::dump($postvalues);exit();
						$accountobj = new Account();
						$playerdata = $accountobj->getdetails($_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"]);
			
			
						$data["player_id"]=	 $playerdata["player_id"];
						$data["first_name"]= $playerdata["first_name"];
 						$data["last_name"]= $playerdata["last_name"] ;
						$data["email"]=	$playerdata["email"];
						$data["sex"]=  $playerdata["sex"] ;
 						$data["dateofbirth"]= $playerdata["dateofbirth"] ;
						$data["address"]= $playerdata["address"] ;
						$data["city"]=  $playerdata["city"];
						$data["state"]= $playerdata["state"] ;
						$data["country"]= $playerdata["country"];
 						$data["pin"]= $playerdata["pin"] ;
 						$data["phone"]=	$playerdata["phone"];
 						
 						
						$completed = true;
						foreach($data as $playerDetail)
						{
							if(!$playerDetail)
							{
								$completed = false;
									break;
							}
						}
						
						if($completed)
						{
							if($data["dateofbirth"] == "0000-00-00")
							{
								$accountobj->insertaccount($_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"],$data["first_name"],$data["last_name"],$data["sex"],$postvalues["dateofbirth"],$data["address"],$data["city"],$data["state"],$data["country"],$data["pin"],$data["phone"],$data["email"]);
							}
						}
						else
						{
							$accountobj->insertaccount($_SESSION["Zend_Auth"]["storage"]["authDetails"][0]["player_id"],$postvalues["first_name"],$postvalues["last_name"],$postvalues["sex"],$postvalues["dateofbirth"],$postvalues["address"],$postvalues["city"],$postvalues["state"],$postvalues["country"],$postvalues["pin"],$postvalues["phone"],$postvalues["email"]);
						}
					
						
						$this->view->form = "";
						
						$this->_helper->FlashMessenger('Your details are set for verifation. Our verification team will verify your documents and it will take maximum of 3 working days.');
						$this->view->verified = yes;
					}
					else
					{
						$this->_helper->FlashMessenger(array('error' => 'Account number does not match. Please check it again.'));
					}
				}
			}
				
		}
	}		
			
	
	public function listunprocessedAction()
	{
		
		$session = new Zend_Auth_Storage_Session();
		$store = $session->read();
		$playerId = $store['id'];
		//$playerId = 1;
		$withdraw = new WithdrawalRequest();
		$result = $withdraw->listunprocessed($playerId);
		$this->view->paginator = $result[0];
		$this->view->contents = $result[1];
	}
	
	public function listdetailsAction()
	{
		$session = new Zend_Auth_Storage_Session();
		$store = $session->read();
		$playerId = $store['id'];
		//$playerId = 1;
		$withdrawalId = $this->getRequest()->withdrawal_id;
		$withdraw = new WithdrawalRequest();
		$result = $withdraw->listDetails($withdrawalId, $playerId);
		if(!$result)
		{
			$this->_helper->FlashMessenger(array('error' => 'No Records Found'));
		}
		else
		{
			$this->view->results = $result;
		}
	}
	public function listallAction()
	{	
		$session = new Zend_Auth_Storage_Session();
		$store = $session->read();
		$playerId = $store['id'];
		//$playerId = 1;
		$withdraw = new WithdrawalRequest();
		
		$form = new Player_ReconciliationForm();
		$this->view->form = $form;
		$offset = $this->getRequest()->pages;
		
		if($offset)
		{
			$itemsPerPage = $this->getRequest()->item;
			$from = $this->getRequest()->from;
			$till = $this->getRequest()->to;
			$transString = $this->getRequest()->transString;
			$transactionStatus = explode(',', $transString);
			$result = $withdraw->listTransaction($playerId , $itemsPerPage ,$from,$till,$offset , $transactionStatus);
			
			$this->view->paginator = $result[0];
			$this->view->contents = $result[1];
			$this->view->fromDate = $from;
			$this->view->toDate = $till;
			$this->view->transactionStatus = $transString;
		}
		if($this->getRequest()->isPost())
		{		
			if($form->isValid($_POST))
			{
				$offset = 1;
				$transactionStatus = array();		
				$data = $form->getValues();
				$from = $data['from_date'] . ' ' . $data['from_time'];
				$till = $data['to_date'] . ' ' . $data['to_time'];	
				foreach($data['transaction_status'] as $transactions)
				{
					$transactionStatus[] = $transactions;
				}
				$transString = implode(",", $transactionStatus);

				$result = $withdraw->listTransaction($playerId , $data['page'],$from,$till,$offset , $transactionStatus);
				
				$this->view->paginator = $result[0];
				$this->view->contents = $result[1];
				$this->view->fromDate = $from;
				$this->view->toDate = $till;
				$this->view->transactionStatus = $transString;
			}
		}
	}	
	
	public function insertflowbackAction()
	{
		
		
		$withdraw = new WithdrawalRequest();
		$session = new Zenfox_Auth_Storage_Session();
		$store = $session->read();
		$playerId = $store['id'];
		//$playerId = 1;
		$maxflow = $withdraw->getMaxFlowback($playerId);
		foreach($maxflow as $result)
		{
			//echo $result['remaining_amount'];
			$sum = $sum + (int)$result['remaining_amount'];	
		}
		$this->view->maxflow = $sum;
		$form = new Player_FlowbackForm();
		$this->view->form = $form->setForm($sum);
		
		if($this->getRequest()->isPost()) 
		{
			if($form->isValid($_POST))
			{
				$data = $form->getValues();
				$amount = $data['amount'];
				$transaction = new PlayerTransactions();
				
				$dataArray = array(
				'player_id' => $playerId,
				'type' => 'WITHDRAWAL_FLOWBACK',
				'notes' => 'Withdrawal Flowback',
				'amount' => $amount 
				);
				
				$sourceId = $transaction->registerWithdrawalRequest($dataArray);
				
				if($sourceId == false)
				{
					$this->_helper->FlashMessenger(array('error' => 'Transaction not saved'));
				}
				else
				{
					$tries = 0;
					$withdrawalRequest = new AuditReport();     
					while ($withdrawalRequest->checkIfPresent($sourceId, $playerId) == false && $tries < 4)
					{
						$tries = $tries + 1;		
					}
					
					if($withdrawalRequest->checkIfPresent($sourceId,$playerId) == false)
					{
						//No entry in Audit Report so this leads to a timeout
						$this->_helper->FlashMessenger(array('error' => 'Transaction timed out'));						
					}
					else
					{
						//Everything is well.
						$this->_helper->FlashMessenger(array('error' => 'Transaction has been processed'));
					}
				}
				
			}
			else
			{
				// Need a proper error message.
				$this->_helper->FlashMessenger(array('error' => 'Valid Post Error'));
			}
		}	
	}
}
