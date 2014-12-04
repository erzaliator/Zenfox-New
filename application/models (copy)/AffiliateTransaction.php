<?php
class AffiliateTransaction extends BaseAffiliateTransaction
{
	public function getAllTransactions($offset, $itemsPerPage, $fromDate = NULL, $toDate = NULL, $transType = NULL)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
	    Doctrine_Manager::getInstance()->setCurrentConnection($conn);
	    if($fromDate && $toDate)
	    {
	    	if($transType != NULL && $transType != 'ALL')
	    	{
	    		$query = "Zenfox_Query::create()
	    			->from ('AffiliateTransaction a')
	    			->where('a.trans_end_time >= ?','$fromDate')
	    			->andwhere('a.trans_end_time <= ?','$toDate')
	    			->andWhere('a.trans_type = ?','$transType')";
	    	}
	    	else
	    	{
	    		$query = "Zenfox_Query::create()
	    			->from ('AffiliateTransaction a')
	    			->where('a.trans_end_time >= ?','$fromDate')
	    			->andwhere('a.trans_end_time <= ?','$toDate')";
	    	}	
	    }
	    elseif($transType != NULL && $transType != 'ALL')
	    {
	    	$query = "Zenfox_Query::create()
	    			->from ('AffiliateTransaction a')
	    			->where('a.trans_type = ?','$transType')";
	    }
	    else
	    {
	    	$query = "Zenfox_Query::create()
	    			->from ('AffiliateTransaction a')";
	    }
	   
	    			
	   	$adapter = new Zenfox_Paginator_Adapter_DoctrineQuery($query, 0);
	   	$paginatorSession = new Zend_Session_Namespace('paginationCount');
		$paginatorSession->value = false;
    	$paginator =  new Zend_Paginator($adapter);
		$paginator->setItemCountPerPage($itemsPerPage);
		$paginator->setPageRange(2);
		$paginator->setCurrentPageNumber($offset);
		$paginatorSession->unsetAll();
		return $paginator;
	}
	
	public function getTransactionsWithinDateRange($affiliateId,$fromDate,$toDate,$offset,$itemsPerPage)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
	    Doctrine_Manager::getInstance()->setCurrentConnection($conn);
	    
	    $query = "Zenfox_Query::create()
	    			->from ('AffiliateTransaction a')
	    			->where('a.affiliate_id = ?','$affiliateId')
	    			->andWhere('a.trans_end_time >= ?','$fromDate')
	    			->andwhere('a.trans_end_time <= ?','$toDate')";
	    			
	    $adapter = new Zenfox_Paginator_Adapter_DoctrineQuery($query, 0);
	    $paginatorSession = new Zend_Session_Namespace('paginationCount');
		$paginatorSession->value = false;
    	$paginator =  new Zend_Paginator($adapter);
		$paginator->setItemCountPerPage($itemsPerPage);
		$paginator->setPageRange(2);
		$paginator->setCurrentPageNumber($offset);
		$paginatorSession->unsetAll();
		
		$transactionData = array();
		$index = 0;
		$affTracker = new AffiliateTracker();
		$csrIds = new CsrIds();
		
		if($paginator->getTotalItemCount())
		{
			foreach($paginator as $transactions)
			{
				$transactionData[$index]['Transaction Id'] = $transactions['audit_id'];
				$transactionData[$index]['Tracker Name'] = $affTracker->getTrackerNameFromId($transactions['tracker_id']);
				$transactionData[$index]['Player Name'] = $csrIds->getPlayerLogin($transactions['player_id']);
				$transactionData[$index]['Transaction Type'] = $transactions['trans_type'];
				$transactionData[$index]['Amount'] = $transactions['commission_amount'];
				$transactionData[$index]['Date & Time'] = $transactions['trans_end_time'];
				$index++;
			}
		}
		return array(
			$paginator,
			$transactionData,
		);
	}
}