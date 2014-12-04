<?php

/**
 * AuditReport
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6401 2009-09-24 16:12:04Z guilhermeblanco $
 */
class AuditReport extends BaseAuditReport
{
	
	public function setTableDefinition()
	{
		parent::setTableDefinition();
		$this->hasColumn('csr_id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'length' => '4',
             ));
	}
	
	public function checkError($sourceId, $playerId)
	{
		$conn = Zenfox_Partition::getInstance()->getConnections($playerId);
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		try
		{
			$result = Doctrine::getTable('AuditReport')->findOneBySourceId($sourceId);
		}
		catch(Exception $e)
		{
			return false;
		}
		if($result)
		{
			return array(
				'processed' => $result['processed'],
				'error' => $result['error']);
		}
		return NULL;
	}
	
	public function checkIfPresent($sourceId, $playerId, $csrId)
	{
		$conn = Zenfox_Partition::getInstance()->getConnections($playerId);
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		//print $sourceId.$playerId.$csrId;
		
		$query = Zenfox_Query::create()
		           ->from('AuditReport t')
					->where('t.player_id = ?', $playerId)
					->andWhere('t.source_id = ?', $sourceId)
					->andWhere('t.csr_id = ?', $csrId)
					->limit(1);
	//	echo $query->getSql();exit();
		
		$array = $query->fetchArray();		
					
		if($query->count() != 1)
		{
			return false;
		}
		else 
		{
			return $array;
		}
	}
	
	public function getTransaction($playerId, $transactionType = null)
	{
		$conn = Zenfox_Partition::getInstance()->getConnections($playerId);
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		if($transactionType != null)
		{
		$query = Zenfox_Query::create()
		           ->from('AuditReport t')
					->where('t.player_id = ?', $playerId)
					->andWhere('t.transaction_type = ?', $transactionType)
					->orderBy('t.trans_end_time DESC');
		}
					
		if($transactionType == null)			
		{
			$query = Zenfox_Query::create()
		           ->from('AuditReport t')
					->where('t.player_id = ?', $playerId)
					->orderBy('t.trans_end_time DESC');
		
		}		
			$array = $query->fetchArray();	
			//Zenfox_Debug::dump($array,'array data',true,true);		
			return $array;
	}
	
	public function getTransactionData($offset, $itemsPerPage, $fromDate = NULL, $toDate = NULL, $transType = NULL, $status = NULL, $playerId, $download = NULL)
	{
	  //echo $playerId; exit();
		$conn = Zenfox_Partition::getInstance()->getConnections($playerId);
	    Doctrine_Manager::getInstance()->setCurrentConnection($conn);
	    //echo $conn;
	   // echo Doctrine_Manager::getInstance()->getCurrentConnection()->getName();
	   // exit();
	/*   $query = Zenfox_Query::create()
	    			->from ('AuditReport ar')
	    			->Where('ar.trans_start_time between ? and ?', array($fromDate, $toDate))
	    			->andWhere('ar.transaction_type = ?',$transType);
	    print_r($query->fetchArray());exit();*/
	    /*if($fromDate && $toDate)
	    {*/
	    if($playerId)
	    {
	    	if($transType != NULL && $transType != 'ALL' && $status != NULL)
	    	{
	    		
	    		$statusStr = implode(',', $status);
	    		
	    		$query = "Zenfox_Query::create()
	    			->from ('AuditReport ar')
	    			->Where('ar.trans_start_time between ? and ?', array('$fromDate', '$toDate'))
	    			->andWhere('ar.transaction_type = ?','$transType')
	    			->andWhere('ar.player_id = ?','$playerId')
	    			->andWhereIn('ar.transaction_status',array($statusStr))";
	    	}
	    	/*if($transType != NULL && $transType != 'ALL' && $status != NULL && $playerId == NULL) 
	    	{
	    		$statusStr = implode(',', $status);
	    		
	    		$query = "Zenfox_Query::create()
	    			->from ('AuditReport ar')
	    			->Where('ar.trans_start_time between ? and ?', array('$fromDate', '$toDate'))
	    			->andWhere('ar.transaction_type = ?','$transType')
	    			->andWhereIn('ar.transaction_status',array($statusStr))";
	    		
	    		//echo $query;
	    		//exit();
	    	}*/
	    	if($transType != NULL && $transType != 'ALL' && $status == NULL)
	    	{
	    		
	    		$query = "Zenfox_Query::create()
	    			->from ('AuditReport ar')
	    			->Where('ar.trans_start_time between ? and ?', array('$fromDate', '$toDate'))
	    			->andWhere('ar.player_id = ?','$playerId')
	    			->andWhere('ar.transaction_type = ?','$transType')";
	    	}
	    	
	    }
	    else
	    {
	    	if($transType != NULL && $transType != 'ALL' && $status == NULL)
	    	{
	    		
	    		
	    		
	    		$query = "Zenfox_Query::create()
	    			->from ('AuditReport ar')
	    			->Where('ar.trans_start_time between ? and ?', array('$fromDate', '$toDate'))";
	    	}

	    	if($transType != NULL && $transType != 'ALL' && $status != NULL)
	    	{
	    		echo $playerId;
	    		$statusStr = implode(',', $status);
	    		
	    		$query = "Zenfox_Query::create()
	    			->from ('AuditReport ar')
	    			->Where('ar.trans_start_time between ? and ?', array('$fromDate', '$toDate'))
	    			->andWhere('ar.transaction_type = ?','$transType')
	    			->andWhereIn('ar.transaction_status',array($statusStr))";
	    	}
	    }
	    /*}
	    elseif($transType != NULL && $transType != 'ALL')
	    {
	    	$query = "Zenfox_Query::create()
	    			->from ('AuditReport ar')
	    			->where('ar.transaction_type = ?','$transType')";
	    }
	    else
	    {
	    	$query = "Zenfox_Query::create()
	    			->from ('AuditReport ar')";
	    }
	   */
    	
	    if($download == NULL)
	    {
	    	//echo $query;
	    	
		  	$adapter = new Zenfox_Paginator_Adapter_DoctrineQuery($query,-1);
		   	$paginatorSession = new Zend_Session_Namespace('paginationCount');
			$paginatorSession->value = false;
	    	$paginator =  new Zend_Paginator($adapter);
	    	$paginator->setItemCountPerPage($itemsPerPage);
			$paginator->setPageRange(2);
			$paginator->setCurrentPageNumber($offset);
			$paginatorSession->unsetAll();
			return $paginator;
	    }
		
		if($download != NULL)
		{
			//echo $query.'<br>';
			/* $query = "Zenfox_Query::create()
	    			->from ('AuditReport ar')
	    			->Where('ar.trans_start_time between ? and ?', array('2008-01-21 00:00:00', '2011-07-27 00:00:00'))
	    			->andWhere('ar.transaction_type = ?','CREDIT_DEPOSITS')
	    			->andWhere('ar.player_id = ?','6')
	    			->andWhereIn('ar.transaction_status',array(PROCESSED,ERROR,STARTED,UNPROCESSED))";*/
			$adapter = new Zenfox_Paginator_Adapter_DoctrineQuery($query,-1);
		   	$paginatorSession = new Zend_Session_Namespace('paginationCount');
			$paginatorSession->value = false;
	    	$paginator =  new Zend_Paginator($adapter);
			$paginator->setItemCountPerPage(count($paginator)*10);
			$paginator->setPageRange(2);
			$paginator->setCurrentPageNumber(0);
			$paginatorSession->unsetAll();
			
			//foreach ($paginator as $value)echo $value['trans_start_time'].'<br>';
			//print_r($paginator);//,'data',true,true);
			//exit();
			return $paginator;	
		}
	}
	
}