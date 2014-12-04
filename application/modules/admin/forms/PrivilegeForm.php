<?php
class Admin_PrivilegeForm extends Zend_Form
{
	public function getForm()
	{
		$resourceId = $this->createElement('select','resourceId');
		$resourceId->setLabel('Select Resource *')
				->setRequired(true);
				
		$resourceInstance = new Resource();
		//getting all the resources
		$resources = $resourceInstance->getResources();
		
		foreach($resources as $resource)
		{
			$resourceId->addMultiOption($resource['id'],$resource['name']);
		}
				
		
		$roleId = $this->createElement('select','roleId');
		$roleId->setLabel('Select Role *')
				->setRequired(true);
				
		$roleInstance = new Role();
		//getting all the roles
		$roles = $roleInstance->getRoles();
		
		foreach($roles as $role)
		{
			$roleId->addMultiOption($role['id'],$role['name']);
		}
				
		$mode = $this->createElement('select','mode');
		$mode->setLabel('Select mode *')
				->setRequired(true)
				->addMultiOption('allow','allow')
				->addMultiOption('deny','deny');
				
		$submit = $this->createElement('submit', 'submit');
        $submit->setLabel($this->getView()->translate('Submit'))
        		->setIgnore(true);
        		
        $this->addElements(array
						(
							$roleId,
							$resourceId,
							$mode,
							$submit)
						);
						
		$this->setMethod('post');
		
		$this->setAttrib('id', 'admin-privilege-form');
        
        return $this;
	}
	
	public function setForm($data)
	{
		$form = $this->getForm();
		
		$form->resourceId->setValue($data['resourceId']);
		$form->roleId->setValue($data['roleId']);
		$form->mode->setValue($data['mode']);
		
		return $form;
	}
}
	