<?php
class Admin_RoleForm extends Zend_Form
{
	public function getForm()
	{
		$name = $this->createElement('text','name');
		$name->setLabel('Role Name *')
				->setRequired(true);
				
		$roleType = $this->createElement('select','roleType');
		$roleType->setLabel('Role Type *')
				->setRequired(true)
				->addMultiOption('VISITOR','VISITOR')
				->addMultiOption('PLAYER','PLAYER')
				->addMultiOption('AFFILIATE','AFFILIATE')
				->addMultiOption('CSR','CSR');
				
		$parentId = $this->createElement('select','parentId');
		$parentId->setLabel('Parent *')
				->setRequired(true);
				
		$roleInstance = new Role();
		
		$roles = $roleInstance->getRoles();
		
		foreach($roles as $role)
		{
			$parentId->addMultiOption($role['id'],$role['name']);
		}
				
		$this->addElements(array
						(
							$name,
							$roleType,
							$parentId)
						);
				
		$this->addElement(
					'text',
					'description',
					array(
						'label' => $this->getView()->translate('Description *'),
						'style' => 'width: 30em; height: 5em;'));
					
		$submit = $this->createElement('submit', 'submit');
        $submit->setLabel($this->getView()->translate('Submit'))
        		->setIgnore(true);
        		
        $this->addElement($submit);
        
        $this->setMethod('post');
        $this->setAttrib('id', 'admin-role-form');
        return $this;
	}
	
	public function setForm($data)
	{
		$form = $this->getForm();
		$form->name->setValue($data['name']);
		$form->roleType->setValue($data['roleType']);
		$form->parentId->setValue($data['parentId']);
		$form->description->setValue($data['description']);
		
		return $form;
	}
}
