<?php
class Affiliate_LoginForm extends Zend_Form
{
	public function getForm()
	{
		$alias = $this->createElement('text','alias');
		$alias->setLabel($this->getView()->translate('Alias *'))
         	->setRequired(true);
         	
        $password = $this->createElement('password','password');
		$password->setLabel($this->getView()->translate('Password *'))
				->setRequired(true);
				
		$submit = $this->createElement('submit','submit');
		$submit->setLabel($this->getView()->translate('Submit'))
				->setIgnore(true);
				
		$this->addElements(array(
					$alias,
					$password,
					$submit));
					
		$this->setMethod('post');
		
		return $this;
	}
}