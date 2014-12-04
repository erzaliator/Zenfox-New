<?php
/**
 * This class implements the form to change the password
 * @author Nikhil Gupta
 * @date January 4, 2010
 */
class Player_ChangePasswordForm extends Zend_Form
{
	public function init()
	{
		$currentPassword = $this->createElement('password', 'currentPassword');
		$currentPassword->setLabel($this->getView()->translate('Current Password *'))
					->setRequired(true)
					->setAttrib('class', 'text');
					//->addValidator('stringLength', false, array(6,20,'messages' => array('stringLengthTooShort' => $this->getView()->translate("Too Short"), 'stringLengthTooLong' => $this->getView()->translate("Too Long"))));
					
		$newPassword = $this->createElement('password', 'newPassword');
		$newPassword->setLabel($this->getView()->translate('New Password *'))
					->setRequired(true)
					->addValidator('stringLength', false, array(6,50,'messages' => array('stringLengthTooShort' => $this->getView()->translate("Password too short, make sure your password is atleast 6 characters long"), 'stringLengthTooLong' => $this->getView()->translate("Password too long. Password cannot be longer than 50 characters"))))
					->setAttrib('class', 'text');
					
		$confirmPassword = $this->createElement('password', 'confirmPassword');
		$confirmPassword->setLabel($this->getView()->translate('Confirm Password *'))
					->setRequired(true)
					->addValidator('stringLength', false, array(6,50,'messages' => array('stringLengthTooShort' => $this->getView()->translate("Password too short, make sure your password is atleast 6 characters long"), 'stringLengthTooLong' => $this->getView()->translate("Password too long. Password cannot be longer than 50 characters"))))
					->setAttrib('class', 'text');
					
		$submit = $this->createElement('submit', 'submit');
		$submit->setLabel($this->getView()->translate('Submit'))
				->setIgnore(true);
				
		$this->addElements(array(
					$currentPassword,
					$newPassword,
					$confirmPassword,
					$submit));
					
		$this->setAttrib('id', 'player-change-password-form');
		
		$decorator = new Zenfox_DecoratorForm();
		$currentPassword->setDecorators($decorator->openingUlTagDecorator);
		$newPassword->setDecorators($decorator->changeUlTagDecorator);
		$confirmPassword->setDecorators($decorator->changeUlTagDecorator);
		$submit->setDecorators($decorator->closingUlButtonTagDecorator);
	}
}