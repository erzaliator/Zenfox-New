<?php
class Player_PaymentOptionForm extends Zend_Form
{
	public function init()
	{
		$paymentType = $this->createElement('select', 'paymentType');
		$paymentType->setLabel('Select a payment type')
					->addMultioptions(array(
						'CREDIT' => 'Credit',
						'DEBIT' => 'Debit',
						'NETBANKING' => 'Net Banking'));
					
		$submit = $this->createElement('submit', 'submit');
		$submit->setLabel('Submit');
		
		$this->addElements(array(
				$paymentType,
				$submit
			));
		
		$this->setAttrib('id', 'player-paymentoption-form');
		$this->setAction('/transaction/process');
	}
}