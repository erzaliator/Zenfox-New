<?php

/**
 * This model is used to generate overview of the player reports
 */

class ReportOverview
{
	public function generateReport($fromDate, $toDate)
	{
		$registrations = $this->getTotalRegistrations($fromDate, $toDate, true);
		$depositors = $this->getTotalDeposits($fromDate, $toDate, true);
		$withdrawals = $this->getTotalWithdrawals($fromDate, $toDate, true);
		
		$finalData[0]['Total Registrations'] = "<a href='#' onclick=submitForm('/report/registration')>" . $registrations['totalRegistrations'] . "</a>";
		$finalData[0]['No Of Deposits'] = "<a href='#' onclick=submitForm('/report/depositor')>" . $depositors['totalDepositors'] . "</a>";
		$finalData[0]['Total Deposits'] =  "<a href='#' onclick=submitForm('/report/depositor')>" . $depositors['totalDeposit'] . "</a>";
		$finalData[0]['Withdrawal Accept'] = $withdrawals['totalWithdrawalAccepted'];
		$finalData[0]['Accepted Amount'] = $withdrawals['withdrawalAccepted'];
		$finalData[0]['Withdrawal Reject'] = $withdrawals['totalWithdrawalRejected'];
		$finalData[0]['Rejected Amount'] = $withdrawals['withdrawalRejected'];
		
		return $finalData;
	}
	
	public function getTotalRegistrations($fromDate, $toDate, $count = false)
	{
		$connections = Zenfox_Partition::getInstance()->getConnections(-1);
		
		$totalRegistration = 0;
		
		foreach($connections as $connection)
		{
			Doctrine_Manager::getInstance()->setCurrentConnection($connection);
			
			$query = Zenfox_Query::create();
			
			if($count)
			{
				$query = $query->select('count(a.player_id)');
			}
			
			$query = $query->from('AccountDetail a')
						->where('a.created between ? and ?', array($fromDate, $toDate));
				
			try
			{
				$accountData = $query->fetchArray();
			}
			catch(Exception $e)
			{
				//Zenfox_Debug::dump($e, 'exception', true, true);
			}
			
			if($count)
			{
				$totalRegistration += $accountData[0]['count'];
			}
			
			$registrations[] = $accountData; 
		}
		
		return array(
			'totalRegistrations' => $totalRegistration,
			'registrations' => $registrations
		);
	}
	
	public function getTotalDeposits($fromDate, $toDate, $count = false)
	{
		$connections = Zenfox_Partition::getInstance()->getConnections(-1);
		
		$totalDepositors = 0;
		$totalDeposit = 0;
		
		foreach($connections as $connection)
		{
			Doctrine_Manager::getInstance()->setCurrentConnection($connection);
			
			$query = Zenfox_Query::create()
						->select('count(a.source_id), sum(a.amount) as amount')
						->from('AuditReport a')
						->where('a.transaction_type = ?', 'CREDIT_DEPOSITS')
						->andWhere('a.trans_start_time between ? and ?', array($fromDate, $toDate))
						->andWhere('a.transaction_status = ?', 'PROCESSED')
						->andWhere('a.error = ?', 'NOERROR');
				
			try
			{
				$auditData = $query->fetchArray();
				//Zenfox_Debug::dump($auditData, 'data');
			}
			catch(Exception $e)
			{
				//Zenfox_Debug::dump($e, 'audit', true, true);
			}
			
			if($count)
			{
				$totalDepositors += $auditData[0]['count'];
				if($auditData[0]['amount'])
				{
					$totalDeposit += $auditData[0]['amount'];
				}
			}
			
			$depositer[] = $auditData;
		}
		
		return array(
			'totalDepositors' => $totalDepositors,
			'totalDeposit' => $totalDeposit,
			'depositer' => $depositer
		);
	}
	
	public function getTotalWithdrawals($fromDate, $toDate)
	{
		$connections = Zenfox_Partition::getInstance()->getConnections(-1);
		
		$totalWithdrawalAccepted = 0;
		$withdrawalAccepted = 0;
		$totalWithdrawalRejected = 0;
		$withdrawalRejected = 0;
		
		foreach($connections as $connection)
		{
			Doctrine_Manager::getInstance()->setCurrentConnection($connection);
			
			$query = Zenfox_Query::create()
						->select('count(w.withdrawal_id), w.withdrawal_type, sum(w.requested_amount) as amount')
						->from('WithdrawalRequest w')
						->where('w.datetime between ? and ?', array($fromDate, $toDate))
						->groupBy('w.withdrawal_type');
				
			try
			{
				$withdrawalData = $query->fetchArray();
				//Zenfox_Debug::dump($withdrawalData, 'withdrawal');
			}
			catch(Exception $e)
			{
				//Zenfox_Debug::dump($e, 'withdrawal', true, true);
			}
			
			foreach($withdrawalData as $data)
			{
				switch($data['withdrawal_type'])
				{
					case 'WITHDRAWAL_ACCEPT':
						$totalWithdrawalAccepted += $data['count'];
						$withdrawalAccepted += $data['amount'];
						break;
					case 'WITHDRAWAL_REJECT':
						$totalWithdrawalRejected += $data['count'];
						$withdrawalRejected += $data['amount'];
						break;
				}
			}
			
			$withdrawals[] = $withdrawalData;
		}
		
		return array(
			'totalWithdrawalAccepted' => $totalWithdrawalAccepted,
			'withdrawalAccepted' => $withdrawalAccepted,
			'totalWithdrawalRejected' => $totalWithdrawalRejected,
			'withdrawalRejected' => $withdrawalRejected,
			'withdrawals' => $withdrawals
		);
	}
}
