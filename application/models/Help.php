<?php
class Help extends BaseHelp
{
	public function getCompleteData()
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
					->from('Help');
					
		$result = $query->fetchArray();
		
		$pages = $this->_generateLink($result);
		return $pages;
	}
	
	protected function _generateLink($result)
	{
		static $temp = array();
		$pages = array();
		$index = 0;
		foreach($result as $helpData)
		{
			if(!in_array($helpData['id'], $temp))
			{
				$temp[] = $helpData['id'];
				$query = Zenfox_Query::create()
							->from('Help h')
							->where('h.parent_id = ?', $helpData['id']);
				$data = $query->fetchArray();
				$url = '/help/display/id/' . $helpData['id'];
				$pages[$index]['id'] = $helpData['id'];
				$pages[$index]['url'] = $url;
				$pages[$index]['title'] = $helpData['title'];
				if($data)
				{
					$pages[$index]['page'] = $this->_generateLink($data);
				}
				$index++;
			}
		}
		return $pages;
	}
	
	public function getDataById($id)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
					->select('h.content')
					->from('Help h')
					->where('h.id = ?', $id);
					
		$result = $query->fetchArray();
		return $result[0]['content'];
	}
	
	public function getDatabyPage($pageAddress)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
					->select('h.content')
					->from('Help h')
					->where('h.page_address = ?', $pageAddress);
					
		$result = $query->fetchArray();
		if(isset($result[0]))
		{
			return $result[0]['content'];
		}
	}
	
	public function getDataByParentId($parentId)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
					->select('h.id')
					->from('Help h')
					->where('h.parent_id = ?', $parentId);
					
		$result = $query->fetchArray();
		
		$temp = array();
		if($result)
		{
			foreach($result as $helpData)
			{
				if(!in_array($helpData['id'], $temp))
				{
					$temp[] = $helpData['id'];
					$this->getDataByParentId($helpData['id']);
				}	
			}
		}
		
		return $temp;
	}
}