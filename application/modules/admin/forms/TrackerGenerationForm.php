<?php

class Admin_TrackerGenerationForm extends Zend_Form
{
	public function init()
	{
		
	}
	
	public function setupForm($schemeArray,$frontendIdArray,$frontendNameArray)
	{		
		$type = $this->createElement('select', 'trackerType');
		$type->setLabel('Tracker Type');
		$type->addMultiOptions(array(
								'ONLINE'  => 'Online',
								'OFFLINE' => 'Offline'));	
		
		$name = $this->createElement('text', 'trackerName');
		$name->setLabel($this->getView()->translate('Name(required if Offline Tracker) '));
		
		$url = $this->createElement('text', 'url');
		$url->setLabel($this->getView()->translate('Url '));							
		
		$schemes = $this->createElement('select', 'scheme');
		$schemes->setLabel('Scheme');		
		foreach($schemeArray as $scheme)
		{			
			$schemes->addMultiOption($scheme['id'] , $scheme['name']);
		}		
		$partner = $this->createElement('multiCheckbox', 'partner');
		$partner->setLabel('Partner');		
		$index=0;
		foreach($frontendIdArray as $frontend)
		{			
			$partner->addMultiOption($frontend , $frontendNameArray[$index]);
			$index++;			
		}
			
		$submit = $this->createElement('submit', 'submit');
		$submit->setLabel('Submit');				
				
		$this->addElements(array(
						$type,
						$name,
						$url,
						$partner,
						$schemes,												
						$submit));
		
		return $this;
		
	}
}