<?php
class Affiliate_ChangePasswordForm extends Zend_Form
{
	public function getForm()
	{
		$password = $this->createElement('password','previousPassword');
		$password->setLabel($this->getView()->translate('Your Current Password *'))
				->setRequired(true);
				
		$newPassword = $this->createElement('password','newPassword');
		$newPassword->setLabel($this->getView()->translate('Enter New Password *'))
				->setRequired(true)
				->addValidator('stringLength', false, array(6,20));
				
		$confirmPassword = $this->createElement('password','confirmPassword');
		$confirmPassword->setLabel($this->getView()->translate('Re-enter New Password *'))
						->setRequired(true)
						->addValidator('stringLength', false, array(6,20));
						
		$submit = $this->createElement('submit','submit');
		$submit->setLabel($this->getView()->translate('Submit'))
				->setIgnore(true);
				
		$this->addElements(array(
					$password,
					$newPassword,
					$confirmPassword,
					$submit));
					
		$this->setMethod('post');
		
		return $this;
	}
}