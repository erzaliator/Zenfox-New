<?php

class Admin_MenuGenerationForm extends Zend_Form
{
	public function init()
	{
		
	}
	
	public function setupForm($linkArray , $menuArray)
	{
		$name = $this->createElement('text','name')
						->setLabel($this->getView()->translate('Name'));
						
		$desc = $this->createElement('textarea','desc')
						->setLabel($this->getView()->translate('Description'));
						
		$type = $this->createElement('radio','type')
					->setLabel($this->getView()->translate('Select Type'))
					->addMultiOption('Link','Link')
					->addMultiOption('Menu','Menu');
		
		$addr = $this->createElement('text','address')
						->setLabel($this->getView()->translate('Specify Address if Link'));
						
		$links = $this->createElement('multiCheckbox', 'links');
        $links->setLabel($this->getView()->translate('Select links if Menu'));
        foreach($linkArray as $link)
        {
        	$links->addMultiOption($link['id'], $this->getView()->translate($link['description']));
        }
        
		$menus = $this->createElement('multiCheckbox', 'menus');
        $menus->setLabel($this->getView()->translate('Select Parent Menu :'));
        foreach($menuArray as $menu)
        {
        	$menus->addMultiOption($menu['id'], $this->getView()->translate($menu['name']));
        }
        
        $visible = $this->createElement('radio','visible')
					->setLabel($this->getView()->translate('Visible/Invisible'))
					->addMultiOption('VISIBLE',$this->getView()->translate('Visible'))
					->addMultiOption('INVISIBLE',$this->getView()->translate('Invisible'));
					
		$submit = $this->createElement('submit','create');
		$submit->setLabel($this->getView()->translate('create'));

		$this->addElements(
		array($name,$desc,$type,$addr,$links,$menus,$visible,$submit));
		
		return $this;
	}	
}