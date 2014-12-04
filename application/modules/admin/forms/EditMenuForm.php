<?php

class Admin_EditMenuForm extends Zend_Form
{
	public function init()
	{
		
	}
	
	public function setupForm($data,$preLinks,$otherLinks,$preParents,$otherMenus)
	{
		$name = $this->createElement('text','name')
						->setLabel($this->getView()->translate('Name'))
						->setValue($this->getView()->translate($data['name']));
						
		$desc = $this->createElement('textarea','desc')
						->setLabel($this->getView()->translate('Description'))
						->setValue($this->getView()->translate($data['description']));
						
		$addedlinks = $this->createElement('multiCheckbox', 'addedlinks');
        $addedlinks->setLabel($this->getView()->translate('Select links :'));
        if($preLinks)
        {
        	foreach($preLinks as $link)
        	{	
        		$addedlinks->addMultiOption($link['id'], $this->getView()->translate($link['description']))
        				->setValue(true);
        	}
        }
        $links = $this->createElement('multiCheckbox', 'links');
		foreach($otherLinks as $link)
        {
        	$links->addMultiOption($link['id'], $this->getView()->translate($link['description']));
        }
        
		$addedmenus = $this->createElement('multiCheckbox', 'addedmenus');
        $addedmenus->setLabel($this->getView()->translate('Select Parent Menus :'));
        if($preParents)
        {
        	foreach($preParents as $menu)
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
					
		$submit = $this->createElement('submit','create');
		$submit->setLabel($this->getView()->translate('Edit'));

		$this->addElements(
		array($name,$desc,$addedmenus,$menus,$addedlinks,$links,$visible,$enabled,$submit));
		
		return $this;
        
	}
}