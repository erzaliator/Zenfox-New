<?php
class Player_ConnFacebookUserForm extends Zend_Form
{
	public function init()
	{
		$name = $this->createElement('text', 'name');
		$name->setLabel('Username')
			->setRequired(true)
			->setAttrib('class', 'text');
		$password = $this->createElement('password', 'password');
		$password->setLabel('Password')
				->setRequired(true)
				->setAttrib('class', 'text');
		$submit = $this->createElement('submit','submit');
		$submit->setLabel('Submit')
			->setIgnore(true);
		$this->addElements(array(
					$name, 
					$password, 
					$submit
				));
		$this->setAttrib('id', 'player-facebookconnect-form');
		
		$decorator = new Zenfox_DecoratorForm();
		$name->setDecorators($decorator->openingUlTagDecorator);
		$password->setDecorators($decorator->changeUlTagDecorator);
		$submit->setDecorators($decorator->closingUlButtonTagDecorator);
	}
}