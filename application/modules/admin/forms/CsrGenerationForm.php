<?php

class Admin_CsrGenerationForm extends Zend_Form
{
	public function init()
	{
		
	}
	
	public function setupForm($groupArray)
	{
		$alias = $this->createElement('text','alias')
						->setLabel($this->getView()->translate('Alias : '));
		
		$passwd = $this->createElement('password','passwd')
						->setLabel($this->getView()->translate('Password : '));
						
		$name = $this->createElement('text','name')
						->setLabel($this->getView()->translate('Name : '));
						
		$groups = $this->createElement('multiCheckbox', 'groups');
        $groups->setLabel($this->getView()->translate('Select Groups'));
        foreach($groupArray as $group)
        {
        	$groups->addMultiOption($group['id'], $this->getView()->translate($group['name']));
        }
        
        $enabled = $this->createElement('radio','enabled')
					->setLabel($this->getView()->translate('Enabled/Disabled'))
					->addMultiOption('ENABLED',$this->getView()->translate('Enabled'))
					->addMultiOption('DISABLED',$this->getView()->translate('Disabled'));
					
		$submit = $this->createElement('submit','create');
		$submit->setLabel($this->getView()->translate('create'));

		$this->addElements(
		array($alias,$passwd,$name,$groups,$enabled,$submit));
		
		return $this;
	}	
}