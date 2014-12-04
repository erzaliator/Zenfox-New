<?php
class Admin_AddExistingProofsForm extends Zend_Form
{
	public function getform()
	{
		$decorator = new Zenfox_DecoratorForm();
		
		$playerid = new Zend_Form_Element_Text('playerid');
		$playerid->setLabel('Player ID');
		
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel('INSERT PROOFS');

		$this->addElements(array($playerid, $submit));
		
		$playerid->setDecorators($decorator->openingUlTagDecorator);
		$submit->setDecorators($decorator->closingUlButtonTagDecorator);
		
		return $this;
	}
}