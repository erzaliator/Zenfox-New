<?php
class EmailTag extends BaseEmailTag
{
	public function getQuery($tagName)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
						->from('EmailTag t')
						->where('t.name = ?', $tagName);
						
		$result = $query->fetchArray();
		return $result[0]['query'];
	}
	
	public function createTag($name,$query)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		$partition = Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$q = Zenfox_Query::create()
			->from('EmailTag t')
			->where('t.name = ?' , $name);
		$ans = $q->fetchArray();
		if($ans[0]['name'] != null)
		{
			return -1;
		}
		$this->name = $name;
		$this->query = $query;
		$this->save($partition);
		return 1;
		
	}
	
	public function getQueryById($id)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		$partition = Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		$q = Zenfox_Query::create()
				->from('EmailTag t')
				->where('t.id = ?' , $id);
		$ans = $q->fetchArray();
		return $ans;
	}
	
	public function editTag($id,$query)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		$partition = Doctrine_Manager::getInstance()->setCurrentConnection($conn);
  
		$q = Doctrine_Query::create()
    			->update('EmailTag t')
    			->set('t.query', '?', $query)
    			->where('t.id = ?', $id);
    	$ans =$q->execute();
		return $ans;
		
	}
	
	public function listAll($page)
	{
		$offset  = 1;
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		$partition = Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = "Zenfox_Query::create()
				->from('EmailTag t')";
		
	    try
		{
			$adapter = new Zenfox_Paginator_Adapter_DoctrineQuery($query,0);
			$paginatorSession = new Zend_Session_Namespace('paginationCount');
			$paginatorSession->value = false;
			$paginator =  new Zend_Paginator($adapter);
			$paginator->setItemCountPerPage($page);
			$paginator->setPageRange(2);
			$paginator->setCurrentPageNumber($offset);	
		}
		catch(Exception $e)
		{
			return false;
		}
		
		if($paginator->getTotalItemCount())
		{
			
			$translate = Zend_Registry::get('Zend_Translate');
		    foreach($paginator as $logs)
			{	
				$table[$index][$translate->translate('Tag Name')] = $logs['name'];
				$table[$index][$translate->translate('Query')] = $logs['query'];
				$table[$index][$translate->translate('Edit')] = 'Edit';
				$id[$index] = $logs['id'];
				$index++;
			}
			$paginatorSession->unsetAll();
			return array($paginator,$table,$id);
		}
		return NULL;
	}
}