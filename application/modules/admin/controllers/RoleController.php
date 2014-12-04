<?php
require_once dirname(__FILE__).'/../forms/RoleForm.php';

class Admin_RoleController extends Zenfox_Controller_Action
{
	public function viewAction()
	{
		$roleInstance = new Role();
		$roles = $roleInstance->getRoles();
		
		$this->view->roles = $roles;
	}
	
	public function createAction()
	{
		$form = new Admin_RoleForm();
		$roleForm = $form->getForm();
		$this->view->form = $roleForm;
		
		if($this->getRequest()->isPost())
		{
			if($roleForm->isValid($_POST))
			{
				//RoleConfig class has methods to insert and update roles data
				$roleConfig = new RoleConfig();
				$roleConfig->insertData($_POST);
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
		//id of the requested role
		$id = $request->id;
		$role = new Role();
		//gets the data of the requested role
		$roleData = $role->getRoleById($id);
		
		$parentId = $roleData['parentId'];
		//gets the parent data for the current role
		$parentData = $role->getRoleById($parentId);
		
		$this->view->roleData = $roleData;
		$this->view->parentData = $parentData;
		
	}
	
	public function editAction()
	{
		$form = new Admin_RoleForm();
		$request = $this->getRequest();
		//id of the requested role
		$id = $request->id;
		$role = new Role();
		//gets the data of the requested role
		$result = $role->getRoleById($id);
		//sets the form with the fetched data
		$form = $form->setForm($result);
		$this->view->form = $form;
		
		if($this->getRequest()->isPost())
		{
			if($form->isValid($_POST))
			{
				$roleConfig = new RoleConfig();
				$roleConfig->updateData($id,$_POST); 
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