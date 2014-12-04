<?php
require_once dirname(__FILE__).'/../forms/ResourceForm.php';

class Admin_ResourceController extends Zenfox_Controller_Action
{
	public function viewAction()
	{
		$resourceInstance = new Resource();
		$resources = $resourceInstance->getResources();
		
		$this->view->resources = $resources;
	}
	
	public function createAction()
	{
		$form = new Admin_ResourceForm();
		$resourceForm = $form->getForm();
		$this->view->form = $resourceForm;
		
		if($this->getRequest()->isPost())
		{
			if($resourceForm->isValid($_POST))
			{
				//ResourceConfig class is used to insert and update resource data
				$resourceConfig = new ResourceConfig();
				$resourceConfig->insertData($_POST);
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
		//id of the requested resource
		$id = $request->id;
		$resource = new Resource();
		//gets the data of the requested resource
		$resourceData = $resource->getResourceById($id);
		
		$parentId = $resourceData['parentId'];
		//gets the parent data for the current resource
		$parentData = $resource->getResourceById($parentId);
		
		$this->view->resourceData = $resourceData;
		$this->view->parentData = $parentData;
		
	}
	
	public function editAction()
	{
		$form = new Admin_ResourceForm();
		$request = $this->getRequest();
		//id of the requested resource
		$id = $request->id;
		$resource = new Resource();
		//gets the data of the requested resource
		$result = $resource->getResourceById($id);
		//sets the form with the fetched data
		$form = $form->setForm($result);
		$this->view->form = $form;
		
		if($this->getRequest()->isPost())
		{
			if($form->isValid($_POST))
			{
				$resourceConfig = new ResourceConfig();
				$resourceConfig->updateData($id,$_POST); 
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