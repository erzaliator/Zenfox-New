<?php

class Admin_GroupGenerationForm extends Zend_Form
{
	public function init()
	{
		
	}
	
	public function setupForm($csrArray,$menuArray)
	{					
		$name = $this->createElement('text','name')
						->setLabel($this->getView()->translate('Name : '));
						
		$desc = $this->createElement('textarea','desc')
						->setLabel($this->getView()->translate('Description : '));
						
		$csrs = $this->createElement('multiCheckbox', 'csrs');
        $csrs->setLabel($this->getView()->translate('Select Csrs : '));
        foreach($csrArray as $csr)
        {
        	$csrs->addMultiOption($csr['id'], $this->getView()->translate($csr['name']));
        }
        
		$menus = $this->createElement('multiCheckbox', 'menus');
        $menus->setLabel($this->getView()->translate('Select Menus : '));
        foreach($menuArray as $menu)
        {
        	$menus->addMultiOption($menu['id'], $this->getView()->translate($menu['name']));
        }			
		$submit = $this->createElement('submit','create');
		$submit->setLabel($this->getView()->translate('create'));

		$this->addElements(
		array($name,$desc,$csrs,$menus,$submit));
		
		return $this;
	}	
}