<?php
class Admin_QuickRegistrationForm extends Zend_Form
{
	public function init()
	{
		//TODO implement it further
		$login = $this->createElement('text','login');
		$login->setLabel($this->getView()->translate('Username *'))
         	->setRequired(true)
         	->addValidator(new Zenfox_Validate_UsernameValidator);
				
				
		$password = $this->createElement('password','password');
		$password->setLabel($this->getView()->translate('Password *'))
				->setRequired(true)
				->addValidator('stringLength', false, array(6,20));
				
		$confirmPassword = $this->createElement('password','confirmPassword');
		$confirmPassword->setLabel($this->getView()->translate('Confirm Password *'))
						->setRequired(true)
						->addValidator('stringLength', false, array(6,20));
				
		$email = $this->createElement('text','email');
		$email->setLabel($this->getView()->translate('EmailID *'))
				->setRequired(true)
				->addValidator('EmailAddress');
			
		$submit = $this->createElement('submit','submit');
		$submit->setLabel($this->getView()->translate('Submit *'))
				->setIgnore(true);
				
		$this->addElements(array(
				$login,
				$password,
				$confirmPassword,
				$email,
				$submit
			)
		);
	}
}