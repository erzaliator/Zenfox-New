<?php

/*
 * @date : 18 May, 2010
 */


class Player_WithdrawalForm extends Zend_Form 
{
	public function init() 
	{
		$amount = $this->createElement('text','amount');
		$amount->setLabel($this->getView()->translate('Enter the amount to withdraw : '))
					->setRequired(true)
					//->addValidator('float')
					->addValidator('greaterThan', false, array(39, 'messages' => array('notGreaterThan' => 'Amount is less than 40'))); 

		$submit = $this->createElement('submit','withdraw');
		$submit->setLabel($this->getView()->translate('Request Withdrawal'));

		//Should add drop down for user to choose currency
		/*
		 * Frontend table allowed currencies.
		 */
		$this->addElements(array(
			$amount,$submit));
		            	
		$this->setAttrib('id', 'player-withdrawal-form');        
		
		$decorator = new Zenfox_DecoratorForm(); 
		$amount->setDecorators($decorator->openingUlTagDecorator);
		$submit->setDecorators($decorator->closingUlButtonTagDecorator);
		
		$this->setAction('/withdrawal/request/');
		
	}
}
