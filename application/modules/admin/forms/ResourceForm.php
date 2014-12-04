<?php
class Admin_ResourceForm extends Zend_Form
{
	public function getForm()
	{
		$name = $this->createElement('text','name');
		$name->setLabel('Resource Name *')
				->setRequired(true);
				
		$resourceType = $this->createElement('select','resourceType');
		$resourceType->setLabel('Resource Type *')
				->setRequired(true)
				->addMultiOption('REQUEST','REQUEST')
				->addMultiOption('GAME','GAME');
				
		$parentId = $this->createElement('select','parentId');
		$parentId->setLabel('Parent *')
				->setRequired(true);
				
		$resourceInstance = new Resource();
		
		$resources = $resourceInstance->getResources();
		
		foreach($resources as $resource)
		{
			$parentId->addMultiOption($resource['id'],$resource['name']);
		}
				
		$this->addElements(array
						(
							$name,
							$resourceType,
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
        $this->setAttrib('id', 'admin-resource-form');
        return $this;
	}
	
	public function setForm($data)
	{
		$form = $this->getForm();
		$form->name->setValue($data['name']);
		$form->resourceType->setValue($data['resourceType']);
		$form->parentId->setValue($data['parentId']);
		$form->description->setValue($data['description']);
		
		return $form;
	}
}
