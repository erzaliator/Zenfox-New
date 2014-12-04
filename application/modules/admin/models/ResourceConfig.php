<?php
class ResourceConfig extends Doctrine_Record
{
	public function insertData($data)
	{
		$conn = Zenfox_Partition::getInstance()->getConnections(0);
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$resource = new Resource();
		
		$resource->name = $data['name'];
		$resource->description = $data['description'];
		$resource->resource_type = $data['resourceType'];
		$resource->parent_id = $data['parentId'];
		
		$resource->save();
		
		return true;
	}
	
	public function updateData($id,$data)
	{
		$conn = Zenfox_Partition::getInstance()->getConnections(0);
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		
		$resource = Doctrine::getTable('Resource')->findOneById($id);
		$resource->name = $data['name'];
		$resource->description = $data['description'];
		$resource->resource_type = $data['resourceType'];
		$resource->parent_id = $data['parentId'];
		
		$resource->save();
		
		return true;
		
	}	
}
