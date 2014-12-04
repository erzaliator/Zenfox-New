<?php

class Partner_LoginForm extends Zend_Form
{
	public function init()
	{
		$alias = $this->createElement('text', 'alias');
		$alias->setLabel('Alias*')
			->setRequired(true);
		
		$password = $this->createElement('password', 'password');
		$password->setLabel('Password*')
				->setRequired(true);
		
		$submit = $this->createElement('submit', 'submit');
		$submit->setLabel('Submit')
			->setIgnore(true);
		
		$this->addElements(array(
				$alias,
				$password,
				$submit
			));
	}
}