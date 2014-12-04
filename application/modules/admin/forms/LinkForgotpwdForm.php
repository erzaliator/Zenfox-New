<?php
class Admin_LinkForgotpwdForm extends Zend_Form
{
	public function getform()
	{
	
	$detail = array(  'user_id'=>'user_id', 'email'=>'email');
		$playerentry = new Zend_Form_Element_Radio('playerentry');
		$playerentry->setLabel('entryfield')
					->setSeparator('     ')
					->setMultiOptions($detail)
					->setRequired(true);
		
		$user_type = new Zend_Form_Element_Select('user_type');
		$user_type->setLabel('user type')
		->setMultiOptions(array( 'PLAYER'=>'player','AFFILIATE'=>'affiliate'));
		
		$value = new Zend_Form_Element_Text('value');
		$value->setLabel('value')
		//->addValidator('EmailAddress')
		->setRequired(true);
		
		
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel('Get code');
		
		$this->addElements(array($playerentry, $user_type,$value,
				 $submit));
		
		return $this;
	}
	
	
}