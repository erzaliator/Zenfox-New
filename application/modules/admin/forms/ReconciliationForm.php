<?php

class Admin_ReconciliationForm extends Zend_Form
{
	public function init()
	{
		
	}
	
	public function setupForm($playerData, $playerId)
	{
		$id = $this->createElement('text','player_id')
				->setLabel($this->getView()->translate('Player Id'));
				
		/*foreach($playerData as $player)
		{
			$id->addMultiOption($player['playerId'], $player['email']);
		}*/
		if($playerId)
		{
			$id->setValue($playerId);
		}
		$date = new Zend_Date();
		$today = $date->get('YYYY-MM-dd');
		
		$from_date = new ZendX_JQuery_Form_Element_DatePicker('from_date');
		$from_date->setLabel($this->getView()->translate('From Date'))
				->setRequired(true)
				->setJQueryParam('dateFormat', 'yy-mm-dd')
				->setValue($today);
				
		$from_time = new Zenfox_JQuery_Form_Element_TimePicker('from_time');
		$from_time->setLabel($this->getView()->translate('Time'))
				->setRequired(true);
		
        $to_date = new ZendX_JQuery_Form_Element_DatePicker('to_date');
		$to_date->setLabel($this->getView()->translate('To Date'))
				->setRequired(true)
				->setJQueryParam('dateFormat', 'yy-mm-dd')
				->setValue($today);
		
		$to_time = new Zenfox_JQuery_Form_Element_TimePicker('to_time');
        $to_time->setLabel($this->getView()->translate('Time'))
        		->setRequired(true);
		
        $amount_type = $this->createElement('multiCheckbox', 'amount_type');
        $amount_type->setLabel($this->getView()->translate('Amount Type'))
        			->addMultiOption('REAL', $this->getView()->translate('Real'))
        			->addMultiOption('BONUS', $this->getView()->translate('Bonus'))
        			->addMultiOption('BOTH', $this->getView()->translate('Both'))
        			->setValue(array('REAL', 'BONUS', 'BOTH'));
        			
        $transaction_type = $this->createElement('multiCheckbox', 'transaction_type');
        $transaction_type->setLabel($this->getView()->translate('Transaction Type'))
        				->addMultiOption('AWARD_WINNINGS', $this->getView()->translate('Winning'))
        				->addMultiOption('CREDIT_DEPOSITS', $this->getView()->translate('Deposits'))
        				->addMultiOption('PLACE_WAGER', $this->getView()->translate('Wager'))
        				->addMultiOption('CREDIT_BONUS', $this->getView()->translate('Bonus Credit'))
        				->addMultiOption('WITHDRAWAL_REQUEST', $this->getView()->translate('Withdrawals Request'))
        				->addMultiOption('WITHDRAWAL_FLOWBACK', $this->getView()->translate('Withdrawals Flowback'))
        				->addMultiOption('WITHDRAWAL_ACCEPT', $this->getView()->translate('Withdrawals Accept'))
        				->addMultiOption('WITHDRAWAL_REJECT', $this->getView()->translate('Withdrawals Rejected'))
        				->addMultiOption('ADJUST_BANK', $this->getView()->translate('Adjust Bank'))
        				->addMultiOption('ADJUST_WINNINGS', $this->getView()->translate('Adjust Winnings'))
        				->addMultiOption('ADJUST_BONUS_WINNINGS', $this->getView()->translate('Adjust Bonus Winnings'))
        				->addMultiOption('ADJUST_BONUS_BANK', $this->getView()->translate('Adjust Bonus Bank'))
        				->addMultiOption('ADJUST_ACCOUNT_BALANCE', $this->getView()->translate('Adjust Account Balance'))
        				->addMultiOption('CREDIT_BONUS_DUE', $this->getView()->translate('Credit Bonus Due'))
				        ->addMultiOption('LOCK_FUNDS', $this->getView()->translate('Lock Funds'))
				        ->addMultiOption('UNLOCK_FUNDS', $this->getView()->translate('Unlock Funds'))
				        ->addMultiOption('PLACE_WAGER_LOCK', $this->getView()->translate('Place Wager Lock'))
				        ->addMultiOption('AWARD_WINNINGS_LOCK', $this->getView()->translate('Award Winnings Lock'))
        				->setValue(array(
        						'AWARD_WINNINGS',
        						'CREDIT_DEPOSITS',
        						'PLACE_WAGER',
        						'CREDIT_BONUS',
        						'WITHDRAWAL_REQUEST',
        						'WITHDRAWAL_FLOWBACK',
        						'WITHDRAWAL_ACCEPT',
        						'WITHDRAWAL_REJECT',
        						'ADJUST_BANK',
        						'ADJUST_WINNINGS',
        						'ADJUST_BONUS_WINNINGS',
        						'ADJUST_BONUS_BANK',
        						'ADJUST_ACCOUNT_BALANCE',
        						'CREDIT_BONUS_DUE',
        						'LOCK_FUNDS',
        						'UNLOCK_FUNDS',
        						'PLACE_WAGER_LOCK',
        						'AWARD_WINNINGS_LOCK'
        						
        				));
        	
		$page = $this->createElement('select', 'page');
		$page->setLabel($this->getView()->translate('Result per page'))
			->addMultiOptions(array(
				'10' => $this->getView()->translate('10'),
				'20' => $this->getView()->translate('20'),
				'30' => $this->getView()->translate('30'),
				'40' => $this->getView()->translate('40'),
				'50' => $this->getView()->translate('50')));
			
		$submit = $this->createElement('submit', 'submit');
		$submit->setLabel($this->getView()->translate('Submit'))
				->setIgnore(true);
			
		$this->addElements(array(
				$id,
				$from_date,
				$from_time,
				$to_date,
				$to_time,
				$amount_type,
				$transaction_type,
				$page,
				$submit));
				
		$this->setAttrib('id', 'player-reconcilaion-form');
		return $this;
	}
}