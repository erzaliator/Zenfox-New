<?php


class Player_FlowbackForm extends Zend_Form 
{
	public function init() 
	{
		$amount = $this->createElement('text','amount');
		$amount->setLabel($this->getView()->translate('Enter the amount to flowback : '))
					->setRequired(true)
					->addValidator('float'); 

		$submit = $this->createElement('submit','flowback');
		$submit->setLabel($this->getView()->translate('Request Flowback'));

		//Should add drop down for user to choose currency
		/*
		 * Frontend table allowed currencies.
		 */
		$this->addElements(array(
			$amount,$submit));
		            	
		$this->setAttrib('id', 'player-flowback-form');       
		$decorator = new Zenfox_DecoratorForm(); 
		$amount->setDecorators($decorator->openingUlTagDecorator);
		$submit->setDecorators($decorator->closingUlButtonTagDecorator);
		
	}
}