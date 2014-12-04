<?php

class Admin_UserBalanceForm extends Zend_Form
{
	public function init()
	{
		
	}
	
	public function setupForm($data)
	{//Zenfox_Debug::dump($this->getView()->translate($data['bank']), 'timezone', true, true);
		$bank = $this->createElement('text','bank');
		$bank->setLabel($this->getView()->translate('Bank : '))
						->setValue($this->getView()->translate($data['bank']));
						//->addValidator('float')
						/*->addValidator('GreaterThan', true , array('0'))*/;
		
	 /*   $gender = new Zend_Form_Element_Radio(‘gender’);
		
		$gender	->setLabel('Gender:')
				->addMultiOptions(array(
										'male' => 'Male',
										'female' => 'Female'
										))
				->setSeparator(”);*/
						
		$win = $this->createElement('text','winnings');
		$win->setLabel($this->getView()->translate('Bank Winnings: '))
						->setValue($this->getView()->translate($data['winnings']));
						//->addValidator('float')
						/*->addValidator('GreaterThan', true , array('0'))*/;
						
		$bonus = $this->createElement('text','bonus');
		$bonus->setLabel($this->getView()->translate(' Bonus Bank : '))
						->setValue($this->getView()->translate($data['bonus_bank']));
						//->addValidator('float')
						/*->addValidator('GreaterThan', true , array('0'))*/;
					
		$bonuswin = $this->createElement('text','bonusWinnings');
		$bonuswin->setLabel($this->getView()->translate('Bonus Winnings : '))
						->setValue($this->getView()->translate($data['bonus_winnings']));
						//->addValidator('float')
						/*->addValidator('GreaterThan', true , array('0'))*/;
		
		$notes = $this->createElement('textarea','notes');
		$notes->setLabel($this->getView()->translate('Notes : '));
						
		$submit = $this->createElement('submit','submit');
		$submit->setLabel($this->getView()->translate('Save'));
						
		$this->addElements(
		array($bank,$win,$bonus,$bonuswin,$notes,$submit));
		
		return $this;
	}
}