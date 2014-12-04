<?php
require_once dirname(__FILE__).'/../forms/PrivilegeForm.php';

class Admin_PrivilegeController extends Zenfox_Controller_Action
{
	/*public function viewAction()
	{
		//initially roles are displayed
		//After selecting role, privileges corresponding to that role will be displayed
		$roleInstance = new Role();
		$roles = $roleInstance->getRoles();
		$this->view->roles = $roles;
		
		$request = $this->getRequest();
		//id of the role
		$id = $request->id;
		if($id)
		{
			$privilegeInstance = new Privilege();
			//getting privileges corresponding to the role
			$privileges = $privilegeInstance->getPrivilegesByRoleId($id);
			$this->view->privileges = $privileges;
			$this->view->roles = '';
		}	
		
	}*/
	
	public function viewAction()
	{
		$roleInstance = new Role();
		//getting all the roles
		$roles = $roleInstance->getRoles();
		$this->view->roles = $roles;
		
		$privilegeInstance = new Privilege();
		//getting all the privileges
		$privileges = $privilegeInstance->getPrivileges();
		$this->view->privileges = $privileges;
	}
	
	public function createAction()
	{
		$form = new Admin_PrivilegeForm();
		$privilegeForm = $form->getForm();
		$this->view->form = $privilegeForm;
		
		if($this->getRequest()->isPost())
		{
			if($privilegeForm->isValid($_POST))
			{
				$data = $_POST;
				$resourceId = $data['resourceId'];
				$roleId = $data['roleId'];
				$privilegeInstance = new Privilege();
				//checking whether a privilege with the same role and resource already exists
				$privilege = $privilegeInstance->getPrivilegeByRoleIdAndResourceId($roleId,$resourceId);
				if($privilege && ($data['existingId'] != $privilege['id']))
				{
					$this->view->form = $form->setForm($data);
					$this->view->privilegeId = $privilege['id'];
					return;
				}
				$resource = new Resource();
				//getting resource data corresponding to the privilege
				$resourceData = $resource->getResourceById($resourceId);
				$role  = new Role();
				//getting role data corresponding to the privilege
				$roleData = $role->getRoleById($roleId);
				$data['resourceName'] = $resourceData['name'];
				$data['resourceType'] = $resourceData['resourceType'];
				$data['roleName'] = $roleData['name'];
				$data['roleType'] = $roleData['roleType'];
				//ResourceConfig class has methods to insert and update resource data
				$priviligeConfig = new PrivilegeConfig();
				$priviligeConfig->insertData($data);
				$this->view->form = '';
				echo 'data is saved';
			}
			else
			{
				echo 'enter valid data';
			}
		}
	}
	
	public function viewdetailsAction()
	{
		$request = $this->getRequest();
		//id of the requested privilege
		$id = $request->id;
		$privilege = new Privilege();
		//gets the data of the requested privilege
		$privilegeData = $privilege->getPrivilegeById($id);
		
		$this->view->privilegeData = $privilegeData;
	}
	
	public function editAction()
	{
		$form = new Admin_PrivilegeForm();
		$request = $this->getRequest();
		//id of the requested privilege
		$id = $request->id;
		$privilege = new Privilege();
		//gets the data of the requested privilege
		$result = $privilege->getPrivilegeById($id);
		//sets the form with the fetched data
		$form = $form->setForm($result);
		$this->view->form = $form;
		
		if($this->getRequest()->isPost())
		{
			if($form->isValid($_POST))
			{
				$data = $_POST;
				$resourceId = $data['resourceId'];
				$roleId = $data['roleId'];
				$resource = new Resource();
				//getting resource data corresponding to the privilege
				$resourceData = $resource->getResourceById($resourceId);
				$role  = new Role();
				//getting role data corresponding to the privilege
				$roleData = $role->getRoleById($roleId);
				$data['resourceName'] = $resourceData['name'];
				$data['resourceType'] = $resourceData['resourceType'];
				$data['roleName'] = $roleData['name'];
				$data['roleType'] = $roleData['roleType'];
				$privilegeConfig = new PrivilegeConfig();
				$privilegeConfig->updateData($id,$data); 
				$this->view->form = '';
				echo 'data is updated';
			}
			else
			{
				echo 'enter valid data';
			}
		}
	}
}