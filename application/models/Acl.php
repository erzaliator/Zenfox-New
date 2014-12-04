<?php
class Acl
{
	/*public function permission($data)
	{
		$resource = Zend_Registry::getInstance()->get('resource');
		$session = new Zenfox_Auth_Storage_Session();
		$store = $session->read();
		$roleName = $store['roleName'];
		$id = $store['id'];
		$factory = new Zenfox_Acl_Factory();
		$resourceObj = Doctrine::getTable('Resource')->findOneByName($resource);
		$acl = $factory->createResourceAcl($resourceObj, $id, $roleName);
		$userRole = new Zenfox_Acl_Role_UserRole();
		$userResource = new Zenfox_Acl_Resource_UserResource();
		$acl->allow($userRole, $userResource, null, new Zenfox_Acl_Assert_UserAssertion());
		foreach($data as $key => $value)
		{
			if(!$acl->isAllowed($userRole, $userResource, $key))
			{
				$data[$key] = '********';
				//print($key . '->' . $value);
				//echo '<br>';
			}
		}
		return $data;
	}*/
}