<?php
/**
 * This file contains Menu class, this is a generic class used for
 * Menu generation for players (and may be affiliates later)
 *
 * Long description for file (if any)...
 *
 * LICENSE:
 *
 * @package    models
 * @subpackage -
 * @copyright  2009 Yaswanth Narvaneni
 * @license    License Link
 * @since      19th Jan 2009
*/

/**
 * This class is used to generate the Menu and get the Menu specific Acl
 *
 *
 * @package    models
 * @subpackage -
 * @copyright  2009 Yaswanth Narvaneni
 * @since      19th Jan 2009
 */

class Menu
{
	private $_config = null;
	//private $_acl = null;
	private $_currentRole = null;
	
	public function __construct($moduleName)
	{
		//FIXME:: This navigation is only for player
    	switch($moduleName)
    	{
    		case 'player':
    			$siteCode = Zend_Registry::getInstance()->isRegistered('siteCode')?Zend_Registry::getInstance()->get('siteCode'):null;
    			$xmlPath = isset($siteCode)&&file_exists(APPLICATION_PATH . '/site_configs/'. $siteCode . '/navigation.xml')?APPLICATION_PATH . '/site_configs/'. $siteCode . '/navigation.xml' : APPLICATION_PATH . '/configs/navigation.xml';
    			$this->_config = new Zend_Config_Xml($xmlPath, 'nav');
    			break;
    		case 'affiliate':
    			$siteCode = Zend_Registry::getInstance()->isRegistered('siteCode')?Zend_Registry::getInstance()->get('siteCode'):null;
    			$xmlPath = isset($siteCode)&&file_exists(APPLICATION_PATH . '/site_configs/'. $siteCode . '/affiliateNavigation.xml')?APPLICATION_PATH . '/site_configs/'. $siteCode . '/affiliateNavigation.xml':APPLICATION_PATH . '/configs/affiliateNavigation.xml';
    			$this->_config = new Zend_Config_Xml($xmlPath, 'nav');
    			break;
    		case 'admin':
    			$siteCode = Zend_Registry::getInstance()->isRegistered('siteCode')?Zend_Registry::getInstance()->get('siteCode'):null;
    			$xmlPath = isset($siteCode)&&file_exists(APPLICATION_PATH . '/site_configs/'. $siteCode . '/adminNavigation.xml')?APPLICATION_PATH . '/site_configs/'. $siteCode . '/adminNavigation.xml':APPLICATION_PATH . '/configs/adminNavigation.xml';
    			$this->_config = new Zend_Config_Xml($xmlPath, 'nav');
    			break;
    		case 'partner':
    			$siteCode = Zend_Registry::getInstance()->isRegistered('siteCode')?Zend_Registry::getInstance()->get('siteCode'):null;
    			$xmlPath = isset($siteCode)&&file_exists(APPLICATION_PATH . '/site_configs/'. $siteCode . '/navigation.xml')?APPLICATION_PATH . '/site_configs/'. $siteCode . '/navigation.xml' : APPLICATION_PATH . '/configs/navigation.xml';
    			$this->_config = new Zend_Config_Xml($xmlPath, 'nav');
    			break;
    	}
	}
/*		
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
			
         	$role = Doctrine::getTable('Role')->findOneByName($this->getCurrentRole());
         	$parents = $role->getParents();
         	
         	foreach($parents as $parent)
			{
				if($this->_acl->hasRole($parent))
				{
					continue;
				}
				$this->_acl->addRole($parent);
			}
			$this->_acl->addRole($role, $parents);

         	
         	//Get privileges for given role and resource
         	$pQuery = Doctrine_Query::create()
         				->from('Privilege p')
         				->where('p.role_name = ?', $this->_currentRole)
         				->andWhereIn('p.resource_name', $this->_acl->getResources());

         	$privileges =  $pQuery->execute();
     		$this->_setPrivileges($privileges);
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
	*/
	public function getNavigation()
	{
		$navigation = new Zend_Navigation($this->_config);
		return $navigation;
	}
	
	/*public function getCurrentRole()
	{
			//Get role details
			$session = new Zend_Auth_Storage_Session();
		 	$store = $session->read();
         	$this->_currentRole = $store['roleName']?$store['roleName']:'visitor';
		
         	return $this->_currentRole;
	}*/
}