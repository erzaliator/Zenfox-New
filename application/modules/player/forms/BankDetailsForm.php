<?php
class Player_bankdetailsForm extends Zend_Form_SubForm
{
	public function getform()
	{
		$decorator = new Zenfox_DecoratorForm();
		
		$bankdetails = new Zend_Form_SubForm();
		

		$NAME = $bankdetails->createElement('text','name as on bank');
				$NAME->setLabel($this->getView()->translate('NAME(As on Bank Account) * '))
				->addValidator('NotEmpty', true, array('messages' => 'Value required'))
				->addValidator(new Zenfox_Validate_CharactercheckValidator)
				->setRequired(true);
		
				$Bank = $bankdetails->createElement('text','bank');
				$Bank->setLabel($this->getView()->translate('BANK NAME * '))
				->addValidator('NotEmpty', true, array('messages' => 'Value required'))
				->addValidator(new Zenfox_Validate_CharactercheckValidator)
				->setRequired(true);
		
				$BankAccountNo = $bankdetails->createElement('text','BankAccountNumber');
				$BankAccountNo->setLabel($this->getView()->translate('Bank Account Number * '))
				->addValidator('NotEmpty', true, array('messages' => 'Value required'))
				->addValidator(new Zenfox_Validate_CharactercheckValidator)
				->setRequired(true);
		
				$BankAccountNoRe = $bankdetails->createElement('text','BankAccountNumberRe');
				$BankAccountNoRe->setLabel($this->getView()->translate('Re-type Bank Account Number * '))
				->addValidator('NotEmpty', true, array('messages' => 'Value required'))
				->addValidator(new Zenfox_Validate_CharactercheckValidator)
				->setRequired(true);
		
				$Branch = $bankdetails->createElement('text','Branch');
				$Branch->setLabel($this->getView()->translate('Branch * '))
				->addValidator('NotEmpty', true, array('messages' => 'Value required'))
				->addValidator(new Zenfox_Validate_CharactercheckValidator)
				->setRequired(true);
		
				$IFSCCode = $bankdetails->createElement('text','ifsccode');
				$IFSCCode->setLabel($this->getView()->translate('IFSC Code * '))
				->addValidator('NotEmpty', true, array('messages' => 'Value required'))
				->addValidator(new Zenfox_Validate_CharactercheckValidator)
				->setRequired(true);
		
		
		
		$bankdetails->addElements(array($NAME,$Bank,$BankAccountNo,$BankAccountNoRe,$Branch,$IFSCCode));

				$NAME->setDecorators($decorator->openingUlTagDecorator);
				$IFSCCode->setDecorators($decorator->closingUlTagDecorator);
				$Branch->setDecorators($decorator->changeUlTagDecorator);
				$BankAccountNoRe->setDecorators($decorator->changeUlTagDecorator);
				$BankAccountNo->setDecorators($decorator->changeUlTagDecorator);
 				$Bank->setDecorators($decorator->changeUlTagDecorator);





		return $bankdetails;
	}
}