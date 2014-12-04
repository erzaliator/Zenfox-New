<?php

class Admin_WithdrawalProcessingForm extends Zend_Form
{
	public function getForm($cardDetails)
	{
		$type = $this->createElement('radio','type')
					->setLabel($this->getView()->translate('Accept/Reject'))
					->addMultiOption('accept','Accept')
					->addMultiOption('reject','Reject');
		
		$card = $this->createElement('radio','cardId')
					->setLabel($this->getView()->translate('Choose Card '));
		
		foreach($cardDetails as $cardData)
		{
			$card->addMultiOption($cardData['id'], '************' . substr($cardData['card_no'], strlen($cardData['card_no']) - 4) . ' ' . $cardData['card_subtype']);
		}

		$amount = $this->createElement('text','amount')
						->setLabel($this->getView()->translate('Amount to be Accepted/Rejected'));
						//->addValidator('float');
		$notes = $this->createElement('text','notes')
						->setLabel($this->getView()->translate('Notes'));
										
		$submit = $this->createElement('submit','withdraw');
		$submit->setLabel($this->getView()->translate('Submit'));

		$this->addElements(
		array($type,$card,$amount,$notes,$submit));
		
		return $this;
	}
}
