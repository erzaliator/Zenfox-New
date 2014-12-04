<?php

/*
 * @date : 1 July, 2010
 */


class Admin_CreditBonusForm extends Zend_Form 
{
	public function init() 
	{
		$creditBonus = $this->createElement('text','credit_bonus');
		$creditBonus->setLabel($this->getView()->translate('Credit Bonus : '))					
					->addValidator('float')
					->addValidator('GreaterThan', true , array('0'));
					
		$creditBonusDue = $this->createElement('text','credit_bonus_due');
		$creditBonusDue->setLabel($this->getView()->translate('Credit Bonus Dude : '))					
					->addValidator('float')
					->addValidator('GreaterThan', true , array('0'));
					
		$creditFreeMoney = $this->createElement('text','credit_free_money');
		$creditFreeMoney->setLabel($this->getView()->translate('Credit Free Money : '))					
					->addValidator('float')
					->addValidator('GreaterThan', true , array('0'));
		
		$creditDeposit = $this->createElement('text', 'credit_winnings');
		$creditDeposit->setLabel($this->getView()->translate('Credit Real : '))
					->addValidator('float')
					->addValidator('GreaterThan', true , array('0'));
		
		$loyaltyPoints = $this->createElement('text', 'loyaltyPoints');
		$loyaltyPoints->setLabel($this->getView()->translate('Add Loyalty Points : '))
					->addValidator('float')
					->addValidator('GreaterThan', true , array('0'));
					
		$notes = $this->createElement('textarea','notes');
		$notes->setLabel($this->getView()->translate('Notes : '));

		$submit = $this->createElement('submit','submit');
		$submit->setLabel($this->getView()->translate('Submit Request'));
				

		//Should add drop down for user to choose currency
		/*
		 * Frontend table allowed currencies.
		 */
		$this->addElements(array(
				$creditBonus,
				$creditBonusDue,
				$creditFreeMoney,
				$creditDeposit,
				$loyaltyPoints,
				$notes,
				$submit));		            			        				
	}
}
