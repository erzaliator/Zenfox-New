<?php
class AffiliateScheme extends BaseAffiliateScheme
{
	public function getAffiliateSchemes()
	{
		$conn = Zenfox_Partition::getInstance()->getConnections(0);
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
					->from('AffiliateScheme');
					
		$result = $query->fetchArray();
		return $result;
	}
	
	/**
	 * this method gets the affiliate scheme by id
	 * @param $id
	 * @return unknown_type
	 */
	public function getAffiliateScheme($id)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
    					->from('AffiliateScheme a')
    					->where('a.id = ?' , $id);
		
		return $query->fetchArray();
	}
	
	public function getSchemeName($schemeId)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$affiliateScheme = Doctrine::getTable('AffiliateScheme')->findOneById($schemeId);
		
		return $affiliateScheme['name'];
	}
	
	public function getMatchedSchemes($searchField,$searchString,$match)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		if(!$searchString)
    	{
    		$query = Zenfox_Query::create()
    					->from('AffiliateScheme a');    					    					
    					
    	}
    	else 
    	{
    		if(!$match)
    		{
    			$query = Zenfox_Query::create()
    					->from('AffiliateSchemeDef a')
    					->where('a.$searchingField LIKE ?', '$searchString%');    			
    		}
    		else
    		{
    			$query = Zenfox_Query::create()
    					->from('AffiliateSchemeDef a')
    					->where('a.$searchingField = ?', $searchString);    							    			
    		}
    		
    	}    	
    	return $query->fetchArray();    	
	}
	
	public function updateScheme($data,$id)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Doctrine_Query::create()
    			->update('AffiliateScheme a')
    			->set('a.name', '?', $data['name'])
    			->set('a.description', '?', $data['desc'])
    			->set('a.note', '?', $data['note'])
    			->where('a.id = ?', $id);
    			
    	return $query->execute();
	}
}