<?php
class Admin_LoginForm extends Zend_Form
{
	public function init()
	{
		$userName = $this->createElement('text','userName');
		$userName->setLabel($this->getView()->translate('Username *'))
				->setRequired(true);
				
		$password = $this->createElement('password','password');
		$password->setLabel($this->getView()->translate('Password *'))
				->setRequired(true);
				
		$submit = $this->createElement('submit','submit');
		$submit->setLabel($this->getView()->translate('Log In'))
				->setIgnore(true);
				
		$this->addElements(array(
				$userName,
				$password,
				$submit
			)
		);
		
		$this->setAttrib('id', 'admin-login-form');
	}
}