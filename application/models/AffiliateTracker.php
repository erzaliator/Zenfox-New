<?php

/**
 * AffiliateTracker
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6401 2009-09-24 16:12:04Z guilhermeblanco $
 */
class AffiliateTracker extends BaseAffiliateTracker
{
	public function getAffiliateTracker($id)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
	    Doctrine_Manager::getInstance()->setCurrentConnection($conn);
	    
	    $result = Doctrine::getTable('AffiliateTracker')->findOneByTracker_id($id);
        
	    return $result;
	    
	}
	
	public function getAffiliateTrackersByAffiliateId($id)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
	    Doctrine_Manager::getInstance()->setCurrentConnection($conn);
	    
	    $query = Zenfox_Query::create()
	    			->from ('AffiliateTracker a')
	    			->where	('a.affiliate_id = ?',$id);
	    			
	    $result = $query->fetchArray();	    
	    
	    return $result;
	}
	
	public function getAlltAffiliateTrackers()
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		 
		$query = Zenfox_Query::create()
		->from ('AffiliateTracker a');
		
	
		$result = $query->fetchArray();
		 
		return $result;
	}
	
	public function addAffiliateTracker($affiliateId,$data)
	{
	    $conn = Zenfox_Partition::getInstance()->getMasterConnection();

		$partition = Doctrine_Manager::getInstance()->getConnection($conn);		
	    
	    $this->tracker_type = $data['trackerType'];
	    if($data['trackerType'] == 'OFFLINE')
	    {
	    	$this->tracker_name = $data['trackerName'];
	    }
	    //Needs to be changed, should set the default affiliate scheme id for the affiliate frontend
	    //$this->scheme_id = $data['scheme'];
	    $this->scheme_id = $data['schemeId'];
	    $this->affiliate_id = $affiliateId;	    	    
	    $result = $this->save($partition);	    
	    try
	    {
	    	Doctrine_Manager::getInstance()->setCurrentConnection($conn);
	    	$query = Zenfox_Query::create()
	    			->from('AffiliateTracker a')
	    			->orderBy('a.tracker_id DESC');
			$result = $query->fetchArray();	    	
	   		$trackerId = $result[0]['tracker_id'];
	    }
	    catch (Exception $e)
	    {
	    	print "Exception:: " . $e->getMessage();
	    	print $partition->getName();exit();
	    }	    			

	    
	    if($data['trackerType'] == 'ONLINE')
	    {
	    	$newData = array(
	    				'trackerType' => 'ONLINE',
	    				'trackerName' => $trackerId);
	 		$this->updateAffiliateTracker($trackerId,$newData);
	    }
	    
	    return $trackerId;
	}
	
	public function updateAffiliateTracker($trackerId,$data)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
	    Doctrine_Manager::getInstance()->setCurrentConnection($conn);
	    
	    $affiliateTracker = Doctrine::getTable('AffiliateTracker')->findOneByTracker_id($trackerId);
	    $affiliateTracker->tracker_type = $data['trackerType'];
	    if($data['trackerType'] == 'OFFLINE')
	    {
	    	$affiliateTracker->tracker_name = $data['trackerName'];
	    }
	    else
	    {
	    	$affiliateTracker->tracker_name = 'TRACKER-' . $trackerId;
	    }
	    if($data['schemeId'])
	    {
	    	$affiliateTracker->scheme_id = $data['schemeId'];
	    }	    
	    $affiliateTracker->save();
	    $this->updateTrackerDetails($trackerId,$data);	    
	}
	
	public function updateTrackerDetails($trackerId,$data)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
	    Doctrine_Manager::getInstance()->setCurrentConnection($conn);
	    
		$trackerDetails = new TrackerDetail();
		$result = $trackerDetails->getTrackerDetails($trackerId);
		foreach($result as $detail)
		{
			Doctrine_Manager::getInstance()->setCurrentConnection($conn);
			$column = $detail['variable_name'];
			$query = Zenfox_Query::create()
					->update('TrackerDetail t')
					->set('t.variable_value' , '?' , $data[$column] )
					->where('t.tracker_id = ?',$trackerId)
					->andWhere('t.variable_name = ?' , $column);
			$ans = $query->execute();
		}			
	}
	
	public function getAffiliateTrackers()
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
	    Doctrine_Manager::getInstance()->setCurrentConnection($conn);
	    
	    $query = Zenfox_Query::create()
	    			->from ('AffiliateTracker a');
	    			
	    $result = $query->fetchArray();
	    
	    $trackers = array();
	    foreach($result as $tracker)
	    {
	    	$trackers[$tracker['affiliate_id']][] = $tracker;
	    }
	    
	    return $trackers;
	}
	
	public function getTrackerNameFromId($id)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
	    Doctrine_Manager::getInstance()->setCurrentConnection($conn);
	    
	    $query = Zenfox_Query::create()
	    			->from ('AffiliateTracker a')
	    			->where('a.tracker_id = ?',$id);
	    			
	    $result = $query->fetchOne();
	    return $result['tracker_name'];
	}
	
	public function getAffiliateTrackerByName($name)
	{
		$result = Doctrine::getTable('AffiliateTracker')->findOneByTracker_name($name);	
		return $result;
	}
	
	public function getMatchedTrackers($searchingField, $offset, $itemsPerPage, $searchString = NULL , $match,$order)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
				
		if(!$searchString)
    	{
    		$query = "Zenfox_Query::create()
    					->from('AffiliateTracker a')
    					->orderBy('a.tracker_id $order')";
    	}
    	else if(!$match)
   		{   			
   			$query = "Zenfox_Query::create()
   					->from('AffiliateTracker a')
   					->where('a.$searchingField LIKE ?', '$searchString%')
   					->orderBy('a.$searchingField $order')";
    	}
    	else if($match)
    	{
    		$query = "Zenfox_Query::create()
    				->from('AffiliateTracker a')
    				->where('a.$searchingField = ?', $searchString)
    				->orderBy('a.$searchingField $order')";    			
    	}
    	$adapter = new Zenfox_Paginator_Adapter_DoctrineQuery($query, 0);
    	$paginatorSession = new Zend_Session_Namespace('paginationCount');
		$paginatorSession->value = false;
    	$paginator =  new Zend_Paginator($adapter);
		$paginator->setItemCountPerPage($itemsPerPage);
		$paginator->setPageRange(2);
		$paginator->setCurrentPageNumber($offset);
		if(!$paginator)
		{
			return false;
		}
		$translate = Zend_Registry::get('Zend_Translate');
		$translate = Zend_Registry::get('Zend_Translate');
		if($paginator->getTotalItemCount())
		{
			foreach($paginator as $logs)
			{
				$table[$index][$translate->translate('Link Id')] = $logs['tracker_id'];	
				$table[$index][$translate->translate('Link Name')] = $logs['tracker_name'];
				$table[$index][$translate->translate('Link Type')] = $logs['tracker_type'];						
				$index++;
			}
		}
		$paginatorSession->unsetAll();
		return array($paginator, $table);		
	}
}