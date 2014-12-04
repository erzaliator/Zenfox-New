<?php
class PrivilegeConfig extends Doctrine_Record
{
	public function insertData($data)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$privilege = new Privilege();
		
		$privilege->resource_id = $data['resourceId'];
		$privilege->resource_name = $data['resourceName'];
		$privilege->resource_type = $data['resourceType'];
		$privilege->role_id = $data['roleId'];
		$privilege->role_name = $data['roleName'];
		$privilege->role_type = $data['roleType'];
		$privilege->mode = $data['mode'];
		
		$privilege->save();
		
		return true;
	}
	
	public function updateData($id,$data)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		
		$privilege = Doctrine::getTable('Privilege')->findOneById($id);
		$privilege->resource_id = $data['resourceId'];
		$privilege->resource_name = $data['resourceName'];
		$privilege->resource_type = $data['resourceType'];
		$privilege->role_id = $data['roleId'];
		$privilege->role_name = $data['roleName'];
		$privilege->role_type = $data['roleType'];
		$privilege->mode = $data['mode'];
		
		$privilege->save();
		
		return true;
		
	}	
}
