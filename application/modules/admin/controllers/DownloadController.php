<?php
require_once dirname(__FILE__) . '/../../player/models/TransactionReports.php';
require_once dirname(__FILE__).'/../forms/ReconciliationForm.php';
class Admin_DownloadController extends Zenfox_Controller_Action
{
	public function indexAction()
	{
		$form = new Admin_ReconciliationForm();
		$playerId = $this->getRequest()->playerId;
				
		$this->view->form = $form->setupForm("", $playerId);
		if($this->getRequest()->isPost())
		{
			if($form->isValid($_POST))
			{
				$formData = $form->getValues();
			}
		}
		$from = $this->getRequest()->from;
		$to = $this->getRequest()->to;
		$rType = $this->getRequest()->rType;
		if($rType == 'email')
		{
			$searchField = $this->getRequest()->field;
			$searchString = $this->getRequest()->str;
		}
		
		$excelReport = $this->_generateExcelSheet($rType, $from, $to, $searchField, $searchString);
		$this->view->excelReport = $excelReport;
		$this->view->fromDate = $from;
		$this->view->toDate = $to;
	}
	
	private function _generateExcelSheet($reportType, $fromTime = NULL, $toTime = NULL, $searchField = NULL, $searchString = NULL)
	{
		$player = new Player();
		switch($reportType)
		{
			case 'registration':
				$frontendId = $this->getRequest()->frontendId;
				$accountType = $this->getRequest()->accountType;
				$trackerId = $this->getRequest()->trackerId;
				if($accountType == 'uconfirmed')
				{
					$result = $player->getUnconfirmPlayers("", "", "", $fromTime, $toTime, $frontendId, $trackerId);
				}
				else
				{
					$result = $player->getAllRegistrations("", "", "", $fromTime, $toTime, $frontendId, $trackerId);
				}
				break;
			case 'depositor':
				$result = $player->getAllDepositors("", "", "", $fromTime, $toTime);
				break;
			case 'gamehistory':
				$playerId = $this->getRequest()->playerId;
				$playerGamelog = new PlayerGamelog();
				if($playerId)
				{
					$result = $playerGamelog->getGameHistory("", "", "", $fromTime, $toTime, $playerId);
				}
				else
				{
					$result = $playerGamelog->getGameHistory("", "", "", $fromTime, $toTime);
				}
				break;
			case 'email':
				$result = $player->getAllPlayers($searchField, 0, "", "", "", $searchString);
				break;
			case 'reconciliation':
				$playerId = $this->getRequest()->playerId;
				$amountType = explode(',', $this->getRequest()->amtType);
				$transactionType = explode(',', $this->getRequest()->transType);
				$transactionReport = new TransactionReports($playerId);
				$result = $transactionReport->getPlayerTransaction($fromTime, $toTime, $amountType, $transactionType);
				break;
			case 'transaction':
				$playerTransactionRecord = new PlayerTransactionRecord();
				$result = $playerTransactionRecord->getAllTransaction($fromTime, $toTime);
				break;
			case 'regular':
                $frontendId = $this->getRequest()->frontendId;
                $playerGamelog = new PlayerGamelog();
                $result = $playerGamelog->getGameHistory("", "", "", $fromTime, $toTime, "", $frontendId);
                break;
			case 'playerslist':
				$tournamentid = $this->getRequest()->tournamentid;
				$registrationobject = new TournamentRegistrations();
				$result = $registrationobject->getplayerlist($tournamentid);
				break;
			case 'withdrawal':
				$dataArray['player_id'] = $this->getRequest()->playerId;
				$dataArray['processed'] = $this->getRequest()->processed;
				$withdrawalRequest = new WithdrawalRequest();
				$result = $withdrawalRequest->adminList("", "", $fromTime, $toTime, "", $dataArray);
		}
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
		return $excelReport;
	}
}
