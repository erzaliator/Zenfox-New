<?php

class Admin_LinkConfirmationForm extends Zend_Form
{
	
	public function getform2()
	{
		$detail = array(  'player_id'=>'player_id', 'login'=>'login','email'=>'email');
		$playerentry = new Zend_Form_Element_Radio('playerentry');
		$playerentry->setLabel('entrytype')
					->setSeparator('     ')
					->setMultiOptions($detail);
					//->setRequired(true);
		
		$value = new Zend_Form_Element_Text('value');
		$value->setLabel('value');
		//->setRequired(true);
		
		
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel('Get code');
		
		$this->addElements(array($playerentry, $value,
				 $submit));
		
		return $this;
	}
	
}