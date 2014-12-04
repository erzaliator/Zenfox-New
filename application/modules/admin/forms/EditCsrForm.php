<?php

class Admin_EditCsrForm extends Zend_Form
{
	public function init()
	{
		
	}
	
	public function setupForm($data,$preGroups,$otherGroups)
	{
		
		$alias = $this->createElement('text','alias')
						->setLabel($this->getView()->translate('Alias'))
						->setValue($this->getView()->translate($data['alias']));
						
		$name = $this->createElement('text','name')
						->setLabel($this->getView()->translate('Name'))
						->setValue($this->getView()->translate($data['name']));
						        
		$passwd = $this->createElement('password','passwd')
						->setLabel($this->getView()->translate('Previous Password : '))
						->setValue($data['passwd']);
						
		//$newpasswd = $this->createElement('password','newpasswd',array( 'required' => 'true'))
			//			->setLabel($this->getView()->translate('New Password : '));
						
		$addedgroups = $this->createElement('multiCheckbox', 'addedgroups');
        $addedgroups->setLabel($this->getView()->translate('Select Associated Groups :'));
        if($preGroups)
        {
        	foreach($preGroups as $group)
        	{	
        		$addedgroups->addMultiOption($group['id'], $this->getView()->translate($group['name']))
        				->setValue(true);
        	}
        }
        
        $groups = $this->createElement('multiCheckbox', 'groups');
		foreach($otherGroups as $group)
        {
        	$groups->addMultiOption($group['id'], $this->getView()->translate($group['name']));
        }												        
					
		$enabled = $this->createElement('radio','enabled')
					->setLabel($this->getView()->translate('Enabled/Disabled'))
					->addMultiOption('ENABLED',$this->getView()->translate('Enabled'))
					->addMultiOption('DISABLED',$this->getView()->translate('Disabled'))
					->setValue($data['enabled']);
					
		$submit = $this->createElement('submit','save');
		$submit->setLabel($this->getView()->translate('Save'));

		$this->addElements(array(
					$alias,
					$name,
					//$passwd,
					$addedgroups,
					$groups,
					$enabled,
					$submit
			));
		
		return $this;
        
	}
}