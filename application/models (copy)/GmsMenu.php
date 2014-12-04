<?php
class GmsMenu extends BaseGmsMenu implements Zend_Acl_Resource_Interface
{
	public function getResourceId()
	{
		//FIXME:: Ideally this should be prefixed with RESOURCE_TYPE
		return $this->address;
	}
	
	public function getMenuById($menuId)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		$partition = Doctrine_Manager::getInstance()->setCurrentConnection($conn);
			
		$query = Zenfox_Query::create()
				->from('GmsMenu m')
				->where('m.id = ?', $menuId);
		
		$result = $query->fetchArray();
		return $result[0]['address'];
	}
	
	public function getAllLinks()
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		$partition = Doctrine_Manager::getInstance()->setCurrentConnection($conn);
			
		$query = Zenfox_Query::create()
				->from('GmsMenu m')
				->where('m.link = ? ' , 'LINK');
		try
		{
			return $query->fetchArray();
		}
		catch(Exception $e)
		{
			return false;	
		}
	}
	
	public function getAllMenus()
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		$partition = Doctrine_Manager::getInstance()->setCurrentConnection($conn);
			
		$query = Zenfox_Query::create()
				->from('GmsMenu m')
				->where('m.link = ? ' , 'NOLINK')
				->andWhere('m.id != ?' , -1);
		try
		{
			return $query->fetchArray();
		}
		catch(Exception $e)
		{
			return false;	
		}
	}
	
	public function createMenu($data)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		$partition = Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
					->select('m.id')
					->from('GmsMenu m')
					->orderBy('m.id DESC')
					->limit(1);	
		$result = $query->fetchArray();
		$this->id = $result[0]['id'] + 1;
		$id = $this->id;
		$this->name = $data['name'];
		$this->description = $data['desc'];
		$this->address = $data['address'];
		if($data['type'] == 'Link')
		{
			$this->link = 'LINK';	
		}
		else
		{
			if($data['links'])
			{
				foreach($data['links'] as $link)
				{
					$menuLink = new GmsMenuLink();
					$result = $menuLink->insertMenuLink($id,$link);
				}
			}
		}
		if($data['menus'])
		{
			foreach($data['menus'] as $menu)
			{
				$menuLink = new GmsMenuLink();
				$result = $menuLink->insertMenuLink($menu,$id);
			}
		}
		else
		{
			$menuLink = new GmsMenuLink();
			$result = $menuLink->insertMenuLink(-1,$id);
		}
		
		$this->visible = $data['visible'];
		try
		{
			$this->save($partition);
			return true;
		}
		catch(Exception $e)
        {
        	echo $e;
        }
	}
	
	public function listAllMenus()
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		$partition = Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
					->from('GmsMenu m')
					->where('m.link = ?' , 'NOLINK')
					->andWhere('m.id != ?', -1);
		try
		{
			$ans = $query->fetchArray();
			if(!$ans)
			{
				return 0;
			}
		}
		catch(Exception $e)
		{
			return false;	
		}
		
		$translate = Zend_Registry::get('Zend_Translate');
	    	foreach($ans as $logs)
			{	
				$gmsMenuLink = new GmsMenuLink();
				$links = $gmsMenuLink->getLinks($logs['id']);
				$linkNames = array();
				if($links)
				{
					foreach($links as $link)
					{
						$linkNames[] = $link['name'];
					}
				}
				$linkString = "";
				$linkString = implode(",", $linkNames);
				
				$gmsMenuLink = new GmsMenuLink();
				$parents = $gmsMenuLink->getParents($logs['id']);
				$parentNames = array();
				if($parents)
				{
					foreach($parents as $parent)
					{
						$parentNames[] = $parent['name'];
					}
				}
				$parentString = "";
				$parentString = implode(",", $parentNames);
				
				$table[$index][$translate->translate('Name')] = $logs['name'];
				$table[$index][$translate->translate('Description')] = $logs['description'];
				$table[$index][$translate->translate('Associated Links')] = $linkString;
				$table[$index][$translate->translate('Associated Parent Menus')] = $parentString;
				$table[$index][$translate->translate('Edit')] = 'Edit';
				$ids[$index] = $logs['id'];
				$index++;
			}
		return array($table , $ids);
					
	}
	
	public function getInfo($id)
	{
		$query = Zenfox_Query::create()
					->from('GmsMenu m')
					->where('m.id = ?' , $id);
		try
		{
			return $query->fetchArray();
		}
		catch(Exception $e)
		{
			return false;	
		}	
	}
	
	public function editMenu($id,$data,$preLinks,$preParents)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		$partition = Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		if($preLinks)
		{
			foreach($preLinks as $pre)
	    	{
	    		$state=1;
	    		if($data['addedlinks'])
	    		{
	    			foreach($data['addedlinks'] as $link)
	    			{
	    				echo $pre['id'].'+++'.$link;
	    				if ($pre['id'] == $link)
	    				{
	    					echo 'here';
	    					$state=0;
	    					break;
	    				}
	    			}
	    		}
	    		if($state)
	    		{
	    			echo 'deleting';
	    			$menuLink = new GmsMenuLink();
	    			$result = $menuLink->deleteMenuLink($id,$pre['id']);
	    		}
	    	}
    	}
		if($data['links'])
    	{
			foreach($data['links'] as $link)
			{
				$menuLink = new GmsMenuLink();
				$result = $menuLink->insertMenuLink($id,$link);
			}
    	}
    	
		if($preParents)
		{
			foreach($preParents as $pre)
	    	{
	    		$state=1;
	    		if($data['addedmenus'])
	    		{
	    			foreach($data['addedmenus'] as $menu)
	    			{
	    				if ($pre['id'] == $menu)
	    				{
	    					$state=0;
	    					break;
	    				}
	    			}
	    		}
	    		if($state)
	    		{
	    			$menuLink = new GmsMenuLink();
	    			$result = $menuLink->deleteMenuLink($pre['id'],$id);
	    		}
	    	}
    	}
		if($data['menus'])
    	{
			foreach($data['menus'] as $menu)
			{
				$menuLink = new GmsMenuLink();
				$result = $menuLink->insertMenuLink($menu,$id);
			}
    	}
		if(!$data['addedmenus'] && !$data['menus'] && $preLinks)
    	{
    		$menuLink = new GmsMenuLink();
	    	$result = $menuLink->deleteMenuLink(-1,$id);
    	}
    	
		$query = Doctrine_Query::create()
    			->update('GmsMenu m')
    			->set('m.name', '?', $data['name'])
    			->set('m.description', '?', $data['desc'])
    			->set('m.visible', '?', $data['visible'])
    			->set('m.enabled', '?', $data['enabled'])
    			->where('m.id = ?', $id);
		$result = $query->execute();
		return $result;
    		
	}
	
	public function listAllLinks()
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		$partition = Doctrine_Manager::getInstance()->setCurrentConnection($conn);
			
		$query = Zenfox_Query::create()
				->from('GmsMenu m')
				->where('m.link = ? ' , 'LINK');
		try
		{
			$ans = $query->fetchArray();
		}
		catch(Exception $e)
		{
			return false;	
		}
		
		$translate = Zend_Registry::get('Zend_Translate');
	    foreach($ans as $logs)
		{	
			$table[$index][$translate->translate('Id')] = $logs['id'];
			$table[$index][$translate->translate('Name')] = $logs['name'];
			$table[$index][$translate->translate('Description')] = $logs['description'];
			$table[$index][$translate->translate('Enabled/Disabled')] = $logs['enabled'];				
			$table[$index][$translate->translate('Address')] = $logs['address'];
			$table[$index][$translate->translate('Status')] = $logs['visible'];
			$table[$index][$translate->translate('Edit')] = 'Edit';
			$index++;
		}
		return $table;
	}
	
	public function editLink($id,$data,$preMenus)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		$partition = Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		if($preMenus)
		{
			foreach($preMenus as $pre)
	    	{
	    		$state=1;
	    		if($data['addedmenus'])
	    		{
	    			foreach($data['addedmenus'] as $menu)
	    			{
	    				if ($pre['id'] == $menu)
	    				{
	    					$state=0;
	    					break;
	    				}
	    			}
	    		}
	    		if($state)
	    		{
	    			$menuLink = new GmsMenuLink();
	    			$result = $menuLink->deleteMenuLink($pre['id'],$id);
	    		}
	    	}
    	}
		if($data['menus'])
    	{
			foreach($data['menus'] as $menu)
			{
				$menuLink = new GmsMenuLink();
				$result = $menuLink->insertMenuLink($menu,$id);
			}
    	}
		if(!$data['menus'] && !$data['addedmenus'])
		{
			$menuLink = new GmsMenuLink();
			$result = $menuLink->insertMenuLink(-1,$id);
		}
		$query = Doctrine_Query::create()
    			->update('GmsMenu m')
    			->set('m.name', '?', $data['name'])
    			->set('m.description', '?', $data['desc'])
    			->set('m.visible', '?', $data['visible'])
    			->set('m.address', '?', $data['address'])
    			->set('m.enabled', '?', $data['enabled'])
    			->where('m.id = ?', $id);
		$result = $query->execute();
		return $result;
	}
}