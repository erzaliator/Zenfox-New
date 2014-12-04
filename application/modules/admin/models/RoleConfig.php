<?php
class RoleConfig extends Doctrine_Record
{
	public function insertData($data)
	{
		$conn = Zenfox_Partition::getInstance()->getConnections(0);
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$role = new Role();
		
		$role->name = $data['name'];
		$role->description = $data['description'];
		$role->role_type = $data['roleType'];
		$role->parent_id = $data['parentId'];
		
		$role->save();
		
		return true;
	}
	
	public function updateData($id,$data)
	{
		$conn = Zenfox_Partition::getInstance()->getConnections(0);
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		
		$role = Doctrine::getTable('Role')->findOneById($id);
		$role->name = $data['name'];
		$role->description = $data['description'];
		$role->role_type = $data['roleType'];
		$role->parent_id = $data['parentId'];
		
		$role->save();
		
		return true;
		
	}	
}
