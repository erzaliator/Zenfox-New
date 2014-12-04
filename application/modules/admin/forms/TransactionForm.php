<?php
class Admin_TransactionForm extends Zend_Form
{
	public function getForm($playerData)
	{
		$id = $this->createElement('text','player_id')
				->setLabel($this->getView()->translate('Player Id'));
				
		/*foreach($playerData as $player)
		{
			$id->addMultiOption($player['playerId'], $player['email']);
		}*/
						
		$fromDate = new ZendX_JQuery_Form_Element_DatePicker('fromDate');
		$fromDate->setLabel('From Date');
		$fromDate->setJQueryParam('dateFormat', 'yy-mm-dd');
		
		$fromTime = new Zenfox_JQuery_Form_Element_TimePicker('fromTime');
		$fromTime->setLabel('Time');
		
		$toDate = new ZendX_JQuery_Form_Element_DatePicker('toDate');
		$toDate->setLabel('To Date');
		$toDate->setJQueryParam('dateFormat', 'yy-mm-dd');
		
		$toTime = new Zenfox_JQuery_Form_Element_TimePicker('toTime');
		$toTime->setLabel('Time');
		
		/*$transType = $this->createElement('select', 'transType');
		$transType->setLabel('Transaction Type *');
		$transType->addMultiOption('ALL','ALL');
		$transType->addMultiOption('DEPOSIT','DEPOSIT');
		$transType->addMultiOption('WITHDRAW','WITHDRAW');*/
		
		$transType = $this->createElement('multiCheckbox', 'transType');
        $transType->setLabel($this->getView()->translate('Transaction Type'))
        				->addMultiOption('CREDIT_DEPOSITS', $this->getView()->translate('Credited Deposit'))
        				->addMultiOption('AWARD_WINNINGS', $this->getView()->translate('Winning Award'))
        				->addMultiOption('PLACE_WAGER', $this->getView()->translate('Place Wager'))
        				->addMultiOption('WITHDRAWAL_REQUEST', $this->getView()->translate('Withdrawal Request'))
        				->addMultiOption('WITHDRAWAL_FLOWBACK', $this->getView()->translate('Withdrawal Flowback'))
        				->addMultiOption('WITHDRAWAL_ACCEPT', $this->getView()->translate('Accepted Withdrawal'))
        				->addMultiOption('WITHDRAWAL_REJECT', $this->getView()->translate('Rejected Withdrawal'))
        				->addMultiOption('CONVERT_BONUS_REAL', $this->getView()->translate('Converted Bonus to Real'))
        				->addMultiOption('CREDIT_BONUS', $this->getView()->translate('Credited Bonus'))
        				->addMultiOption('CREDIT_BUDDY_BONUS', $this->getView()->translate('Credited Buddy Bonus'))
        				->addMultiOption('ADJUST_BANK', $this->getView()->translate('Adjust Bank'))
        				->addMultiOption('ADJUST_WINNINGS', $this->getView()->translate('Adjust Winning'))
        				->addMultiOption('ADJUST_BONUS_WINNINGS', $this->getView()->translate('Adjust Bonus Winning'))
        				->addMultiOption('ADJUST_BONUS_BANK', $this->getView()->translate('Adjust Bonus Bank'))
        				->addMultiOption('LOCK_FUNDS', $this->getView()->translate('Locked Funds'))
        				->addMultiOption('UNLOCK_FUNDS', $this->getView()->translate('Unlocked Funds'))
        				->addMultiOption('PLACE_WAGER_LOCK', $this->getView()->translate('Place Wager Lock'))
        				->addMultiOption('AWARD_WINNINGS_LOCK', $this->getView()->translate('Award Winning Lock'));
        				
        $status = $this->createElement('multiCheckbox', 'status');
        $status->setLabel('Status')
        	->addMultiOption('PROCESSED', $this->getView()->translate('Processed'))
        	->addMultiOption('STARTED', $this->getView()->translate('Started'))
        	->addMultiOption('ERROR', $this->getView()->translate('Error'))
        	->addMultiOption('UNPROCESSED', $this->getView()->translate('Un Processed'));
				
		$items = $this->createElement('select', 'items');
		$items->setLabel('Items per page');
				
		for($i=1;$i<=20;$i++)
		{
			$items->addMultiOption($i,$i);
		}
		//setting default number of items per page
		$items->setValue('20');
				
		$submit = $this->createElement('submit','submit');
		$submit->setLabel($this->getView()->translate('Submit'))
				->setIgnore(true);
				
		   		
		$this->addElements(array(
					$id,
					$fromDate,
					$fromTime,
					$toDate,
					$toTime,
					$transType,
					$status,
					$items,
					$submit
				));
				
		$this->setMethod('post');
		
		$today = new Zend_Date();
		$datetime = $today->get(Zend_Date::W3C);
		$arr = explode('T',$datetime);
			$date = $arr[0];
		$this->toDate->setValue($date);
		
		return $this;
	}
	
	public function getPlayerWithdrawalForm()
	{
		$playerId = $this->createElement('text', 'playerId');
		$playerId->setLabel('Player Id*')
				->setRequired(true);
		
		$amount = $this->createElement('text', 'amount');
		$amount->setLabel('Amount*')
			->setRequired(true);
		
		$submit = $this->createElement('submit', 'submit');
		$submit->setLabel('Submit')
			->setIgnore(true);
		
		$this->addElements(array(
				$playerId,
				$amount,
				$submit
			));
		
		return $this;
	}
}