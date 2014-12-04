<?php

class Admin_EditLinkForm extends Zend_Form
{
	public function init()
	{
		
	}
	
	public function setupForm($data,$preMenus,$otherMenus)
	{
		$name = $this->createElement('text','name')
						->setLabel($this->getView()->translate('Name'))
						->setValue($this->getView()->translate($data['name']));
						
		$desc = $this->createElement('textarea','desc')
						->setLabel($this->getView()->translate('Description'))
						->setValue($this->getView()->translate($data['description']));
						        
		$add = $this->createElement('text','address')
						->setLabel($this->getView()->translate('Address'))
						->setValue($this->getView()->translate($data['address']));
						
		$addedmenus = $this->createElement('multiCheckbox', 'addedmenus');
        $addedmenus->setLabel($this->getView()->translate('Select Associated Menus :'));
        if($preMenus)
        {
        	foreach($preMenus as $menu)
        	{	
        		$addedmenus->addMultiOption($menu['id'], $this->getView()->translate($menu['name']))
        				->setValue(true);
        	}
        }
        $menus = $this->createElement('multiCheckbox', 'menus');
		foreach($otherMenus as $menu)
        {
        	$menus->addMultiOption($menu['id'], $this->getView()->translate($menu['name']));
        }
						
						
						
        $visible = $this->createElement('radio','visible')
					->setLabel($this->getView()->translate('Visible/Invisible'))
					->addMultiOption('VISIBLE',$this->getView()->translate('Visible'))
					->addMultiOption('INVISIBLE',$this->getView()->translate('Invisible'))
					->setValue($data['visible']);
					
		$enabled = $this->createElement('radio','enabled')
					->setLabel($this->getView()->translate('Enabled/Disabled'))
					->addMultiOption('ENABLED',$this->getView()->translate('Enabled'))
					->addMultiOption('DISABLED',$this->getView()->translate('Disabled'))
					->setValue($data['enabled']);
					
		$submit = $this->createElement('submit','edit');
		$submit->setLabel($this->getView()->translate('Edit'));

		$this->addElements(
		array($name,$desc,$add,$addedmenus,$menus,$visible,$enabled,$submit));
		
		return $this;
        
	}
}