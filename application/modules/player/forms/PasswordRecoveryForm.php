<?php
class Player_PasswordRecoveryForm extends Zend_Form
{
	public function init()
	{
		
	}
	
	public function provideInformation()
	{
		$login = $this->createElement('text', 'login');
		$login->setLabel($this->getView()->translate('Enter your username OR email address *'))
				->setRequired(true)
				->setAttrib('class', 'text');
		
		/*$message = $this->createElement('hidden', 'message');
		$message->setLabel('OR');
		
		$email = $this->createElement('text', 'email');
		$email->setLabel('Enter Primary Email Address');*/
		
		$submit = $this->createElement('submit', 'submit');
		$submit->setLabel($this->getView()->translate('Submit'))
				->setIgnore(true);
		
		$this->addElements(array(
					$login,
//					$message,
//					$email,
					$submit,
					));

		$this->setAttrib('id', 'player-passwordinfo-form');
		
		$decorator = new Zenfox_DecoratorForm();
		$login->setDecorators($decorator->openingUlTagDecorator);
		$submit->setDecorators($decorator->closingUlButtonTagDecorator);
		
		return $this;
	}
	
	public function resetPassword()
	{
		$password = $this->createElement('password', 'password');
		$password->setLabel($this->getView()->translate('New Password *'))
				->setRequired(true)
				->addValidator('stringLength', false, array(6,20,'messages' => array('stringLengthTooShort' => $this->getView()->translate("Password too short, make sure your password is atleast 6 characters long"), 'stringLengthTooLong' => $this->getView()->translate("Password too long. Password cannot be longer than 50 characters"))))
				->setAttrib('class', 'text');
				
		$confirmPassword = $this->createElement('password', 'confirmPassword');
		$confirmPassword->setLabel($this->getView()->translate('Confirm Password *'))
					->setRequired(true)
					->addValidator('stringLength', false, array(6,20,'messages' => array('stringLengthTooShort' => $this->getView()->translate("Password too short, make sure your password is atleast 6 characters long"), 'stringLengthTooLong' => $this->getView()->translate("Password too long. Password cannot be longer than 50 characters"))))
					->setAttrib('class', 'text');
					
		$submit = $this->createElement('submit', 'submit');
		$submit->setLabel($this->getView()->translate('Submit'))
				->setIgnore(true);
				
		$this->addElements(array(
					$password,
					$confirmPassword,
					$submit,
				));
				
		$this->setAttrib('id', 'player-passwordreset-form');
		
		$decorator = new Zenfox_DecoratorForm();
		$password->setDecorators($decorator->openingUlTagDecorator);
		$confirmPassword->setDecorators($decorator->changeUlTagDecorator);
		$submit->setDecorators($decorator->closingUlButtonTagDecorator);
		
		return $this;
	}
}