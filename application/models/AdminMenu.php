<?php 
class AdminMenu
{
private $_config = null;
	private $_acl = null;
	private $_currentRole = null;
	private $_module = null;
	public function __construct($moduleName)
	{
		$this->_module = $moduleName;
	}
	public function getNavigation()
	{
		$filePath = APPLICATION_PATH . '/site_configs/azfx/webConfig.json';
		$fh = fopen($filePath, 'r');
		$jsonData = fread($fh, filesize($filePath));
		$arrayData = Zend_Json::decode($jsonData);
		$xmlConfig = $arrayData['xmlConfig'];
		if(!$xmlConfig)
		{
			//Generate Navigation From Database
			$session = new Zend_Session_Namespace('linkIds');
			$visitedIdSess = new Zend_Session_Namespace('visitedId');
			$session->unsetAll();
			$visitedIdSess->unsetAll();
			$gmsMenuLink = new GmsMenuLink();
			$linkData = $gmsMenuLink->getLinkData();
			//Zenfox_Debug::dump($linkData, 'data');
			foreach($linkData as $data)
			{
				if(!in_array($data['link_id'], $visitedIdSess->value))
				{
					$temp = false;
					if($session->value)
					{
						foreach($session->value as $linkId => $parentId)
						{
							if(($linkId == $data['link_id']) && ($parentId == $data['parent_id']))
							{
								$temp = true;
							}
						}
					}
					if(!$temp)
					{
						$session->unsetAll();
						$pages[] = $this->createPages($session, $visitedIdSess, $data);
					}
				}
			}
			foreach($pages as $pageData)
			{
				if($pageData)
				{
					$container[] = $pageData;
				}
			}
			
			$config = new Zend_Config(array(), true);
			$config->nav = array();
			$this->_generateXML($config->nav, $container);
			$writer = new Zend_Config_Writer_Xml();
			$writer->setConfig($config)
					->setFilename('/tmp/adminNavigation.xml')
					->write();
			
			$navigation = new Zend_Navigation($container);
			if(Zend_Registry::getInstance()->isRegistered('Cache'))
	        {
	            $cache = Zend_Registry::getInstance()->get('Cache');
	            $key = 'adminMenu';
	            $json = Zend_Json::encode($navigation);
	            $cache->save($json, $key);
	        }
			$session->unsetAll();
			$visitedIdSess->unsetAll();
			return $navigation; 
		}
		else
		{
			//Generate Navigation From XML File
			if(Zend_Registry::getInstance()->isRegistered('Cache'))
			{
				$cache = Zend_Registry::getInstance()->get('Cache');
				$key = 'adminMenu';
				if($cache->test($key))
				{
					$navigation = $cache->load($key);
				}
				else
				{
					$siteCode = Zend_Registry::getInstance()->isRegistered('siteCode')?Zend_Registry::getInstance()->get('siteCode'):null;
    				$xmlPath = isset($siteCode)&&file_exists(APPLICATION_PATH . '/site_configs/'. $siteCode . '/adminNavigation.xml')?APPLICATION_PATH . '/site_configs/'. $siteCode . '/adminNavigation.xml':APPLICATION_PATH . '/configs/adminNavigation.xml';
					//$xmlPath = APPLICATION_PATH . '/configs/adminNavigation.xml';
					$configFile = new Zend_Config_Xml($xmlPath, 'nav');
			
					$navigation = new Zend_Navigation($configFile);
			
					$cache->save($navigation, $key);
				}
				//TODO throw exception
				//Zend_Cache::throwException('The cache does not exist.');
			}
			else
			{
				$siteCode = Zend_Registry::getInstance()->isRegistered('siteCode')?Zend_Registry::getInstance()->get('siteCode'):null;
    			$xmlPath = isset($siteCode)&&file_exists(APPLICATION_PATH . '/site_configs/'. $siteCode . '/adminNavigation.xml')?APPLICATION_PATH . '/site_configs/'. $siteCode . '/adminNavigation.xml':APPLICATION_PATH . '/configs/adminNavigation.xml';
					
				//$xmlPath = APPLICATION_PATH . '/configs/adminNavigation.xml';
				$configFile = new Zend_Config_Xml($xmlPath, 'nav');
					
				$navigation = new Zend_Navigation($configFile);
			}
			return $navigation;
		}
	}
	private function _generateXML($xmlNav, $pages)
	{
		foreach($pages as $page)
		{
			$resource = str_replace('-', '', strtolower(str_replace(' ', '', $page['label'])));
			$xmlNav->$resource = array();
			foreach($page as $index => $data)
			{
				$xmlNav->$resource->$index = $data;
				if($index == 'pages')
				{
					$xmlNav->$resource->pages = array();
					$this->_generateXML($xmlNav->$resource->pages, $page['pages']);
				}
			}
		}
		return $xmlNav;
	}
	public function createPages($session, $visitedIdSess, $linkData = NULL)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		if($visitedIdSess->value)
		{
			foreach($visitedIdSess->value as $gmsMenuLinkId)
			{
				$visitedIds[] = $gmsMenuLinkId;
			}
		}
		if(!in_array($linkData['link_id'], $visitedIds))
		{
			$visitedIds[] = $linkData['link_id'];
		}
		$visitedIdSess->value = $visitedIds;
		$linkId = $linkData['link_id'];
		$parentId = $linkData['parent_id'];
		/*Zenfox_Debug::dump($linkId, 'linkId');
		Zenfox_Debug::dump($parentId, 'parentId');
		Zenfox_Debug::dump($visitedIdSess->value, 'visited');*/
		if(($parentId != -1) && (!in_array($parentId, $visitedIdSess->value)))
		{
			$query = Zenfox_Query::create()
							->from('GmsMenuLink gml')
							->where('gml.link_id = ?', $parentId);
							
			$gmsMenuLinkData = $query->fetchArray();
			//Zenfox_Debug::dump($gmsMenuLinkData, 'data');
			foreach($gmsMenuLinkData as $linkData)
			{
				$page = $this->createPages($session, $visitedIdSess, $linkData);
				return $page;
			}
		}
		if(!$session->value)
		{
			$ids[$linkId] = $parentId;
		}
		else
		{
			$temp = false;
			foreach($session->value as $link_id => $parent_id)
			{
				$ids[$link_id] = $parent_id;
				if(($link_id == $linkId) && ($parent_id == $parentId))
				{
					$temp = true;
				}
			}
			if(!$temp)
			{
				$ids[$linkId] = $parentId;
			}
			//Zenfox_Debug::dump($ids, 'id');
		}
		$session->value = $ids;
		//Zenfox_Debug::dump($session->value, 'session');
		if(($linkData != NULL) && (!$temp))
		{
			$gmsMenuData = Doctrine::getTable('GmsMenu')->findOneById($linkId);
			$address = explode('-', $gmsMenuData['address']);
			$module = $address[0];
			$controller = $address[1];
			$action = $address[2];
			
			//print "<p>#############" . $gmsMenuData['address'] . "</p><br>";
			
			$page = array();
			$i = 0;
			if($this->_module == 'admin')
			{
				$page['label'] = $gmsMenuData['name'];
				$page['resource'] = $gmsMenuData['address'];
				if($action)
				{
					$page['module'] = $module;
					$page['controller'] = $controller;
					$page['action'] = $action;
				}
				else
				{
					$page['uri'] = "#";
				}
				if($gmsMenuData['visible'] == 'VISIBLE')
				{
					$visible = true;
				}
				else
				{
					$visible = false;
				}
				$page['visible'] = $visible;
			}
			$query = Zenfox_Query::create()
							->from('GmsMenuLink gml')
							->where('gml.parent_id = ?', $linkId);
							
			$gmsMenuLinkData = $query->fetchArray();
			//Zenfox_Debug::dump($gmsMenuLinkData, 'data');
			foreach($gmsMenuLinkData as $linkData)
			{
				$page['pages'][$i] = $this->createPages($session, $visitedIdSess, $linkData);
				$i++;
			}
		}
		return $page;
	}
	public function getAcl()
	{
		if(!$this->_acl)
		{
			$this->_acl = new Zenfox_Acl();
			//TODO:: Build rest of the ACL here
			//Get all resources
			//Get Current Role
			//Get Privileges for current Roles and resources
			$allResources = Doctrine::getTable('Resource')->findAll(Doctrine::HYDRATE_RECORD);
			
			foreach ($allResources as $resource)
			{
				if(!$this->_acl->has($resource))
				{
					$this->_acl->add($resource);
				}
			}
			
			//Get role details
			$session = new Zend_Auth_Storage_Session();
		 	$store = $session->read();
         	$this->_currentRole = $store['roleName']?$store['roleName']:'visitor';
			if($this->_currentRole == 'csr')
			{
				$string = array();
				$csrGroups = Doctrine::getTable('CsrGmsGroup')->findByCsrId($store['id']);
				foreach($csrGroups as $group)
				{
					$roleName = $group->GmsGroup['name'];
					//$string[] = $roleName;
					//print('roleName - ' . $roleName); exit();
					$role = Doctrine::getTable('Role')->findOneByName($roleName);
					$parents = $role->getParents();
					foreach($parents as $parent)
					{
						if($this->_acl->hasRole($parent))
						{
							continue;
						}
						$this->_acl->addRole($parent);
						$privileges = $this->privileges($parent->name);
					}
					$this->_acl->addRole($role, $parents);
					$arr[] = $role->name;
					//$this->_acl->addRole($roleName, $role);
					$privileges = $this->privileges($roleName);
				}
				//Zenfox_Debug::dump($string, 'string');
				$this->_currentRole = implode('-', $arr);
				//print($this->_currentRole);
				if(!$this->_acl->hasRole($this->_currentRole))
				{
					$this->_acl->addRole(new Zend_Acl_Role($this->_currentRole), $arr);
					//$this->_acl->addRole(new Zend_Acl_Role($this->_currentRole), 'Customer Support');
				}
			}
         	else
         	{
         		$role = Doctrine::getTable('Role')->findOneByName($this->_currentRole);
	         	$parents = $role->getParents();
	         	
	         	foreach($parents as $parent)
				{
					if($this->_acl->hasRole($parent))
					{
						continue;
					}
					$this->_acl->addRole($parent);
					$privileges = $this->privileges($parent->name);
				}
				$this->_acl->addRole($role, $parents);
				//$this->_acl->addRole(new Zend_Acl_Role('abc'), $role);
				$privileges = $this->privileges($this->_currentRole);
         	}
         	//Get privileges for given role and resource
/*         	$pQuery = Doctrine_Query::create()
         				->from('Privilege p')
         				->where('p.role_name = ?', $this->_currentRole)
         				->andWhereIn('p.resource_name', $this->_acl->getResources());

         	$privileges =  $pQuery->execute();
     		$this->_setPrivileges($privileges);*/
		}
		//print_r($privileges);
		return $this->_acl;
	}
	
	private function _setPrivileges($privileges)
	{

        foreach($privileges as $privilege) 
        {
            $role = $privilege->getRole();
            $resource = $privilege->getResource();
     
            if($privilege->mode == 'allow')
            {
                $this->_acl->allow($role, $resource);
            }
            else
            {
                $this->_acl->deny($role, $resource);
            }
        }
	}
	
	public function privileges($currentRole)
	{
		$pQuery = Doctrine_Query::create()
         				->from('Privilege p')
         				->where('p.role_name = ?', $currentRole)
         				->andWhereIn('p.resource_name', $this->_acl->getResources());

        $privileges =  $pQuery->execute();
     	$this->_setPrivileges($privileges);
     	return true;
	}
	public function getCurrentRole()
	{
		//print('role - ' . $this->_currentRole);
		return $this->_currentRole;
	}
	
	
	public function getJsonLink()
	{
		$session = new  Zend_Auth_Storage_Session();
		$sessionData = $session->read();
		$gmsMenu = new GmsMenu();
		$gmsMenuLink = new GmsMenuLink();
		$menus = $gmsMenu->getAllMenus();
		$links = $gmsMenu->getAllLinks();

		
	 	
		
		$aclObjFile = APPLICATION_PATH . "/configs/adminAcl.obj";
		if(file_exists($aclObjFile))
		{
			$aclFp = fopen($aclObjFile, "r");
			$acl = unserialize(fread($aclFp, filesize($aclObjFile)));
			
		}
		else
		{
			Zenfox_Debug::dump(null ,'acl obj',true,true);
		}
		
		$linkInfo =  array();
		
		
		$index1 = 0;
		foreach($links as $key=>$value)
		{
			//Zenfox_Debug::dump($value, 'val');
			 if($acl->isAllowed($sessionData['id'], $links[$key]['address']))
			 {
			 	$parentLinks = $gmsMenuLink->getParents($links[$key]['id']);
			 	//Zenfox_Debug::dump($parentLinks ,'parent links',true,true);
			 	if($parentLinks != null)
			 	{
				 	foreach($parentLinks as $key1=>$value1)
				 	{
				 		$linkInfo[$index1]['linkId'] = $links[$key]['id'];
				 		$linkInfo[$index1]['linkName'] = $links[$key]['name'];
				 		$linkInfo[$index1]['linkAddress'] = $links[$key]['address'];
				 		$linkInfo[$index1]['parentId'] = $parentLinks[$key1]['id'];
				 		$linkInfo[$index1]['parentName'] = $parentLinks[$key1]['name'];
				 		$linkInfo[$index1]['parentAddress'] = $parentLinks[$key1]['address'];
				 	}
			 	}
			 	
			 if($parentLinks == null)
			 	{
				 	
				 		$linkInfo[$index1]['linkId'] = $links[$key]['id'];
				 		$linkInfo[$index1]['linkName'] = $links[$key]['name'];
				 		$linkInfo[$index1]['linkAddress'] = $links[$key]['address'];
				 		$linkInfo[$index1]['parentId'] = 'not';//$parentLinks[$key1]['id'];
				 		$linkInfo[$index1]['parentName'] ='not';// $parentLinks[$key1]['name'];
				 		$linkInfo[$index1]['parentAddress'] ='not';// $parentLinks[$key1]['address'];
				 	
			 	}
			 	
			 	
			 	/*$arr = explode('-',$links[$key]['address']);
			 	
			 	$allowLinks[$index]['address']=$links[$key]['address'];
			 	$allowLinks[$index]['name']=$links[$key]['name'];
			 	$allowLinks[$index]['id']=$links[$key]['id'];
			 	*/
			 	
			 	
			 	$index1++;
			 }
		}
		if(!$sessionData)
		{
			$linkInfo[$index1]['linkId'] = 1;
			$linkInfo[$index1]['linkName'] = 'Login';
			$linkInfo[$index1]['linkAddress'] = 'admin-auth-login';
			$linkInfo[$index1]['parentId'] = 'not';//$parentLinks[$key1]['id'];
			$linkInfo[$index1]['parentName'] ='not';// $parentLinks[$key1]['name'];
			$linkInfo[$index1]['parentAddress'] ='not';// $parentLinks[$key1]['address'];
		}	
		
		//Zenfox_Debug::dump($linkInfo ,'parent links',true,true);
		
		return $linkInfo;
	}
}
