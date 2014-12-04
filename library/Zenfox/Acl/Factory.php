<?php
/**
 * This file contains the factory pattern for Acl.
 * This is used to dynamically load roles and priveleges depending on the resources
 * being handled. This helps in reducing the load times.
 *
 * Long description for file (if any)...
 *
 * LICENSE:
 *
 * @category
 * @package
 * @subpackage -
 * @copyright  2009 Yaswanth Narvaneni
 * @license    License Link
 * @since      November 30, 2009
*/

/**
 * This class implements the Factory pattern for loading different Acls depending on
 * the roles.
 *
 * Long description for class (if any)...
 *
 * @category
 * @package
 * @subpackage -
 * @copyright  2009 Yaswanth Narvaneni
 * @since      Novermber 30, 2009
 */
class Zenfox_Acl_Factory
{
	public $_acl  = null;
	/*public function __construct()
	{
		print "Constructing";
	}*/
	//$role is a string that is decided by auth
	private function _createRoles($acl, $id, $roleName)
	{
		//TODO pass the user type
		/*$role = explode('-', $id);
		$roleName = $role[0];*/
		//$csrId = $id;
		$connName = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($connName);
		if($roleName == 'player' && $id)
		{
			//$roleName = 'player';
			$role = Doctrine::getTable('Role')->findOneByName($roleName);
			$parents = $role->getParents();               
			foreach($parents as $parent)
			{
				if($acl->hasRole($parent))
				{
					continue;
				}
				$acl->addRole($parent);
			}
			$acl->addRole($role, $parents);
		}
		elseif($id && $roleName == 'admin')
		{
			$csrGroups = Doctrine::getTable('CsrGmsGroup')->findByCsrId($id);
			foreach($csrGroups as $group)
			{
				$roleName = $group->GmsGroup['name'];
				//print('roleName - ' . $roleName); exit();
				$role = Doctrine::getTable('Role')->findOneByName($roleName);
				$parents = $role->getParents();
				foreach($parents as $parent)
				{
					if($acl->hasRole($parent))
					{
						continue;
					}
					$acl->addRole($parent);
				}
				$acl->addRole($role, $parents);
			}
		}
		else
		{//echo "hi";
			//$roleName = 'visitor';
			$role = Doctrine::getTable('Role')->findOneByName($roleName);
			$parents = $role->getParents();               
			foreach($parents as $parent)
			{
				if($acl->hasRole($parent))
				{
					continue;
				}
				$acl->addRole($parent);
			}
			$acl->addRole($role, $parents);
		}    //print_r($role);   
		return $acl;
	}
	/**
	* This fills the acl with access permissions.
	* The resource can be of any RESOURCE_TYPE (REQUEST, GAME, MODEL) etc.
	*/
	//$role is a string that is decided by auth.
	//$resource is a string, this has to be converted to $resourceObj
	//FIXME:: Do we need resource_type?
	//public function createResourceAcl($id, $roleName)
	public function createResourceAcl($roleName)
	{
		
		$connName = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($connName);
/*		//FIXME:: Should this be Zenfox Acl to which resource_type or user_type is passed?
		$acl = new Zend_Acl();
		$acl = $this->_createRoles($acl, $id, $roleName);
		//Zenfox_Debug::dump($resource->getResourceId(), "First Resource");
		//Reverse list of the chain
		$resources = $resource->getParents();
		
		//FIXME:: UNDO THIS!
		array_push($resources, $resource);
		
		//print '<pre>'; print_r($resources); print '</pre>';
		//Top resource as no parent, so it's null at first
		$parent = null;
		foreach ($resources as $r)
		{
			//Zenfox_Debug::dump($r->name, "Resource: ", true, false);
			$acl->add($r, $parent);
			//next the parent will change
			$parent = $r;
		}
		$privileges = Privilege::findByResources($resources);
		$acl = $this->_setPrivileges($acl, $privileges);
		return $acl;*/

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
					//Zenfox_Debug::dump($resource['name'], "Resource");
					$this->_acl->add($resource);
				}
			}
			
			//Get role details
			$session = new Zend_Auth_Storage_Session();
		 	$store = $session->read();
         	$this->_currentRole = $store['roleName']?$store['roleName']:'visitor';
         	//$role = Doctrine::getTable('Role')->findOneByName($this->_currentRole);
         	$roles = Doctrine::getTable('Role')->findAll();
         	
         	foreach ($roles as $role)
         	{
         	
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
         	}
         	
         	//Get privileges for given role and resource
         	$pQuery = Doctrine_Query::create()
         				->from('Privilege p');
         				//->where('p.role_name = ?', $this->_currentRole)
         				//->andWhereIn('p.resource_name', $this->_acl->getResources());

         	$privileges =  $pQuery->execute();
     		$this->_setPrivileges($privileges);

			//print_r($privileges);
		}
		return $this->_acl;
	}
	
	private function _setPrivileges($privileges)
	{

        foreach($privileges as $privilege) 
        {
            $role = $privilege->getRole();
            $resource = $privilege->getResource();
            /*
        	$role = $privilege['role_name'];
        	$resource = $privilege['resource_name'];
            */
            if($privilege->mode == 'allow')
            {
            	echo "<pre>ALLOW:: " . $role['name'] . "::" . $resource['name'] . " ID:: " . $privilege['id'] . " ROLE ID:: " . $privilege['role_id'] . " Resource ID:: " . $privilege['resource_id'] . "</pre>";
            	//echo "<pre>ALLOW:: " . $role . "::" . $resource . " ID:: " . $privilege['id'] . " ROLE ID:: " . $privilege['role_id'] . " Resource ID:: " . $privilege['resource_id'] . "</pre>";
            	//print_r($privilege);
                $this->_acl->allow($role, $resource);
            }
            else
            {
            	echo "<pre>DENY:: " . $role['name'] . "::" . $resource['name'] . " ID:: " . $privilege['id'] . "</pre>";
            	//echo "<pre>DENY:: " . $role . "::" . $resource . " ID:: " . $privilege['id'] . "</pre>";
                $this->_acl->deny($role, $resource);
            }
        }
	}
	
	public function createPartnerAcl()
	{		
		$this->_acl = new Zenfox_Acl();
		$this->_addPartnerResources();
		$this->_addPartnerRoles();
		$this->_setPartnerPrivileges();
		return $this->_acl;
	}
	
	private function _addPartnerResources()
	{
		$allResources = Doctrine::getTable('PartnerResources')->findAll(Doctrine::HYDRATE_RECORD);
		
		foreach ($allResources as $resource)
		{
			if(!$this->_acl->has($resource))
			{
				//Zenfox_Debug::dump($resource['resource_name'], "Resource");
				$this->_acl->add($resource);
			}
		}
	}
	
	private function _addPartnerRoles()
	{
		$this->_acl->addRole('visitor');
		$partners = new Partners();
		$partnerGroups = new PartnerGroups();
		$partnerFrontends = new PartnerFrontends();
		$allPartners = $partners->getAllPartners();

		foreach($allPartners as $partner)
		{
			$allowedGroups = explode(',', $partner['allowed_group_ids']);
			$allGroups = $partnerGroups->getPartnerGroupsByIds($allowedGroups);
			
			$partnerFrontendId = $partner['partner_frontend_id'];
			$partnerFrontendData = $partnerFrontends->getFrontendData($partnerFrontendId);
			$partnerAllowedFrontends = explode(',', $partnerFrontendData['allowed_frontend_ids']);
			
			foreach($allGroups as $group)
			{
				$groupAllowedFrontends = explode(',', $group['allowed_frontend_ids']);
				$match = array_intersect($partnerAllowedFrontends, $groupAllowedFrontends);
				
				if(!$match)
				{
					echo "Some problem in allowed frontends.";
					exit();
				}
			}
			
			Zenfox_Debug::dump($allGroups, 'groups');
			Zenfox_Debug::dump($partnerFrontendData, 'data', true, true);
			
			$this->_acl->addRole($partner['alias']);
		}
	}
	
	private function _setPartnerPrivileges()
	{
		$partnerPrivileges = new PartnerPrivileges();
		$allPrivileges = $partnerPrivileges->getAllPrivileges();
		
		//Zenfox_Debug::dump($allPrivileges, 'all', true, true);
		foreach($allPrivileges as $privilege)
		{
			$partnerResource = Doctrine::getTable('PartnerResources')->findOneByPartnerResourceId($privilege['partner_resource_id']);
			
			if($privilege['partner_id'] == -1)
			{
				$roleName = 'visitor';
			}
			else
			{
				$partner = Doctrine::getTable('Partners')->findOneByPartnerId($privilege['partner_id']);
				$roleName = $partner['alias'];
			}
			if($privilege['mode'] == 'ALLOW')
			{
				echo "<pre>ALLOW:: " . $roleName . "::" . $partnerResource['resource_name'] . " ID:: " . $privilege['partner_privilege_id'] . " PARTNER ID:: " . $privilege['partner_id'] . " Resource ID:: " . $privilege['partner_resource_id'] . "</pre>";
				$this->_acl->allow($roleName, $partnerResource['resource_name']);
			}
			else
			{
				echo "<pre>DENY:: " . $roleName . "::" . $partnerResource['resource_name'] . " ID:: " . $privilege['partner_privilege_id'] . " PARTNER ID:: " . $privilege['partner_id'] . " Resource ID:: " . $privilege['partner_resource_id'] . "</pre>";
				$this->_acl->deny($roleName, $partnerResource['resource_name']);
			}
		}
	}
	
	
/*	private function _setPrivileges(Zend_Acl $acl, $privileges)
	{
		foreach($privileges as $privilege)
		{
			$role = $privilege->getRole();   
			$resource = $privilege->getResource();
			//the user's roles should already exist so we can
			//ignore the ones that don't
			if(!$acl->hasRole($role))
			{
				continue;
			}
			if($privilege->mode == 'allow')
			{
				$acl->allow($role, $resource);
			}
			else
			{
				$acl->deny($role, $resource);
			}
		}
		return $acl;
	}*/
}