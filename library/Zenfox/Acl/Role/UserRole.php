<?php
class Zenfox_Acl_Role_UserRole implements Zend_Acl_Role_Interface
{
	public function getRoleId()
	{
		$session = new Zenfox_Auth_Storage_Session();
		$store = $session->read();
		$roleName = $store['roleName'];
		return $roleName;
	}
}