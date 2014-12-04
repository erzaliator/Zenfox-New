<?php


class Admin_SimpleMailForm extends Zend_Form
{
	public $frontendlist;
	public $templatelist;
	
	public function getform()
	{
		 
		$this->setName('Campaign');
		
		$playerids = new Zend_Form_Element_Text('playerids');
		$playerids->setLabel("Player ID's")
					->setRequired(true);
	
		$usertype = new Zend_Form_Element_Select('usertype');
		$usertype->setLabel('User Type')
		->setMultiOptions(array( 'PLAYER'=>'PLAYER','AFFILIATE'=>'AFFILIATE','GROUP'=>'GROUP', 'CSR'=>'CSR','ADMIN'=>'ADMIN'))
		->setRequired(true)
		->setvalue('PLAYER')
		->addValidator('NotEmpty');
		
		$frontends = new Zend_Form_Element_Select('frontend_id');
		$frontends->setLabel('Select frontend')
					->setMultiOptions($this->frontendlist)
					->setRequired(true);
		
		$templates = new Zend_Form_Element_Select('template_id');
		$templates->setLabel('Select template')
		->setMultiOptions($this->templatelist)
		->setRequired(true);
		
		$subject = $this->createElement('text', 'subject');
		$subject->setLabel('Subject');
		
		$message = new Zend_Form_Element_Textarea('message');
		$message->setlabel('Enter Message')
				 ->setAttrib('rows','5')
                    ->setAttrib('cols','10');
		
		
		$priority = new Zend_Form_Element_Select('Priority');
		$priority->setLabel('Select Priority(default priority 7)')
							->setMultiOptions(array( '5'=>'5','6'=>'6','7'=>'7', '8'=>'8','9'=>'9'))
							->setRequired(true)
							->setvalue('7')
		                   	->addValidator('NotEmpty');
		
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel('Send Mail');

		$this->addElements(array( $playerids,$usertype,$frontends, $templates, $subject,
				$message, $priority, $submit));
		
		return $this;

	}
	public function setfrontend($values)
	{
		
		$this->frontendlist=$values;
		
	}
	
	public function settemplate($values)
	{
		$this->templatelist=$values;
	}
}

