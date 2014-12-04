<?php

class Admin_EditTagForm extends Zend_Form
{
	public function init()
	{
		
	}
	
	public function setForm($query)
	{
		$q = $this->createElement('textarea','query',array('required' => 'true'))
						->setValue($query)
						->setLabel($this->getView()->translate('Edit Corresponding Query :  $'));
						
		$submit = $this->createElement('submit','submit');
		$submit->setLabel($this->getView()->translate('Submit'));
		
		//$update = $this->createElement('submit','update');
		//$update->setLabel($this->getView()->translate('Update'));
		
		$this->addElements(
		array($q,$submit));
		
		return $this;
	}
}