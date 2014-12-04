<?php

class Admin_EditGroupForm extends Zend_Form
{
	public function init()
	{
		
	}
	
	public function setupForm($data,$preCsrs,$otherCsrs,$preMenus,$otherMenus)
	{
		$name = $this->createElement('text','name')
						->setLabel($this->getView()->translate('Name'))
						->setValue($this->getView()->translate($data['name']));
						
		$desc = $this->createElement('textarea','desc')
						->setLabel($this->getView()->translate('Description'))
						->setValue($this->getView()->translate($data['description']));
						
		$addedcsrs = $this->createElement('multiCheckbox', 'addedcsrs');
        $addedcsrs->setLabel($this->getView()->translate('Select Csrs :'));
        if($preCsrs)
        {
        	foreach($preCsrs as $csr)
        	{	
        		$addedcsrs->addMultiOption($csr['id'], $this->getView()->translate($csr['alias']))
        				->setValue(true);
        	}
        }
        $csrs = $this->createElement('multiCheckbox', 'csrs');
		foreach($otherCsrs as $csr)
        {
        	$csrs->addMultiOption($csr['id'], $this->getView()->translate($csr['name']));
        }
        
		$addedmenus = $this->createElement('multiCheckbox', 'addedmenus');
        $addedmenus->setLabel($this->getView()->translate('Select Parent Menus :'));
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
        			
		$submit = $this->createElement('submit','create');
		$submit->setLabel($this->getView()->translate('Edit'));

		$this->addElements(
		array($name,$desc,$addedcsrs,$csrs,$addedmenus,$menus,$submit));
		
		return $this;
        
	}
}