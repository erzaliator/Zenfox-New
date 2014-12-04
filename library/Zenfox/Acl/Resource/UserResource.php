<?php
class Zenfox_Acl_Resource_UserResource implements Zend_Acl_Resource_Interface
{
	public function getResourceId()
	{
		$resource = Zend_Registry::getInstance()->get('resource');
		return $resource;
	}
}