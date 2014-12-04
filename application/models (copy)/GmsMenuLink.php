<?php
class GmsMenuLink extends BaseGmsMenuLink
{
	public function getLinkData()
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
					->from('GmsMenuLink');
					
		$result = $query->fetchArray();
		return $result;
	}
	
	public function insertMenuLink($parentId , $link)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		$partition = Doctrine_Manager::getInstance()->setCurrentConnection($conn);
			
		$this->parent_id = $parentId;
		$this->link_id = $link;
		try{
			$this->save($partition);
		}catch(Exception $e)
		{
			echo $e;
		}
		
	}
	
	public function deleteMenuLink($parentId , $link)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		$partition = Doctrine_Manager::getInstance()->setCurrentConnection($conn);
			
		$query = Zenfox_Query::create()
					->delete('GmsMenuLink m')
					->where('m.parent_id = ?',$parentId)
					->andWhere('m.link_id = ?' , $link);
		
		$ans = $query->execute();
		
	}
	
	public function getLinks($parentId)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		$partition = Doctrine_Manager::getInstance()->setCurrentConnection($conn);
			
		$query = Zenfox_Query::create()
					->from('GmsMenuLink m')
					->where('m.parent_id = ?',$parentId);
					
		$result = $query->fetchArray();
		
		$linkArray = array();
		foreach($result as $link)
		{
			$linkArray[] = $link['link_id'];
		}
		if( count($linkArray) > 0 )
		{
			$query = Zenfox_Query::create()
					->from('GmsMenu m')
					->whereIn('m.id',$linkArray);
		
			$result = $query->fetchArray();		
			return $result;
		}		
	}
	
	public function getParents($linkId)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		$partition = Doctrine_Manager::getInstance()->setCurrentConnection($conn);
			
		$query = Zenfox_Query::create()
					->from('GmsMenuLink m')
					->where('m.link_id = ?',$linkId)
					->andWhere('m.parent_id != ?', -1);
					
		$result = $query->fetchArray();
		$linkArray = array();
		foreach($result as $link)
		{
			$linkArray[] = $link['parent_id'];
		}
		if( count($linkArray) > 0 )
		{
			$query = Zenfox_Query::create()
					->from('GmsMenu m')
					->whereIn('m.id',$linkArray);
		
			$result = $query->fetchArray();		
			return $result;
		}		
	}
	
	public function getnotLinks($parentId)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		$partition = Doctrine_Manager::getInstance()->setCurrentConnection($conn);
			
		$query = Zenfox_Query::create()
					->from('GmsMenuLink m')
					->where('m.parent_id != ?',$parentId);
					
		$result = $query->fetchArray();
		foreach($result as $link)
		{
			$linkArray[] = $link['link_id'];
		}
		$query = Zenfox_Query::create()
					->from('GmsMenu m')
					->whereIn('m.id',$linkArray);
		$result = $query->fetchArray();
		return $result;
				
	}
}
