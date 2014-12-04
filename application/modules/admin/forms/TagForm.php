<?php

class Admin_TagForm extends Zend_Form
{
	public function init()
	{
		$tagname = $this->createElement('text','name',array('required' => 'true'))
						->setLabel($this->getView()->translate('Enter Tag Name :  $'));
		$query = $this->createElement('textarea','query')
						->setLabel($this->getView()->translate('Enter Corresponding Query :  $'));
		$submit = $this->createElement('submit','submit');
		$submit->setLabel($this->getView()->translate('Submit'));
		
		//$update = $this->createElement('submit','update');
		//$update->setLabel($this->getView()->translate('Update'));
		
		$this->addElements(
		array($tagname,$query,$submit));
	}
}


