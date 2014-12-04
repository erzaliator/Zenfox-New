<?php

class Player_ReconciliationForm extends Zend_Form
{
	public function init()
	{
		/* $date = new Zend_Date();
		$today = $date->get('YYYY-MM-dd');
		
		$from_date = new ZendX_JQuery_Form_Element_DatePicker('from_date');
		$from_date->setLabel($this->getView()->translate('From Date'))
				->setRequired(true)
				->setJQueryParam('dateFormat', 'yy-mm-dd')
				->setJQueryParam('changeMonth',true)
				->setJQueryParam('changeYear',true)
				//TODO:: Replace 18 with frontend specific age limit :-)
				->setJQueryParam('yearRange','2000:' . (Zend_Date::now()->get(Zend_Date::YEAR)))
				->setValue($today)
				->setAttrib('class', 'text');
				
		$from_time = new Zenfox_JQuery_Form_Element_TimePicker('from_time');
		$from_time->setLabel($this->getView()->translate('Time'))
				->setValue("00:00")
				->setRequired(true)
				->setAttrib('class', 'text');
		
        $to_date = new ZendX_JQuery_Form_Element_DatePicker('to_date');
		$to_date->setLabel($this->getView()->translate('To Date'))
				->setRequired(true)
				->setJQueryParam('dateFormat', 'yy-mm-dd')
				->setJQueryParam('changeMonth',true)
				->setJQueryParam('changeYear',true)
				//TODO:: Replace 18 with frontend specific age limit :-)
				->setJQueryParam('yearRange','2000:' . (Zend_Date::now()->get(Zend_Date::YEAR)))
				->setValue($today)
				->setAttrib('class', 'text');
		
		$to_time = new Zenfox_JQuery_Form_Element_TimePicker('to_time');
        $to_time->setLabel($this->getView()->translate('Time'))
        		->setRequired(true)
        		->setAttrib('class', 'text'); */
		
        /*$amount_type = $this->createElement('multiCheckbox', 'amount_type');
        $amount_type->setLabel($this->getView()->translate('Amount Type'))
        			->addMultiOption('REAL', $this->getView()->translate('Real'))
        			->addMultiOption('BONUS', $this->getView()->translate('Bonus'))
        			->addMultiOption('BOTH', $this->getView()->translate('Both'))
        			->setValue(array('REAL', 'BONUS', 'BOTH'));*/
        			
        /* $transaction_type = $this->createElement('multiCheckbox', 'transaction_type');
        $transaction_type->setLabel($this->getView()->translate('Transaction Type'))
        				->addMultiOption('AWARD_WINNINGS', $this->getView()->translate('Winning'))
        				->addMultiOption('CREDIT_DEPOSITS', $this->getView()->translate('Deposits'))
        				->addMultiOption('PLACE_WAGER', $this->getView()->translate('Entry Fees'))
        				->addMultiOption('CREDIT_BONUS', $this->getView()->translate('Bonus Credit'))
        				->addMultiOption('WITHDRAWAL_FLOWBACK', $this->getView()->translate('Withdrawal Flowback'))
        				->addMultiOption('WITHDRAWAL_REQUEST', $this->getView()->translate('Withdrawal Request'))
        				->setValue(array('AWARD_WINNINGS', 'CREDIT_DEPOSITS', 'PLACE_WAGER', 'CREDIT_BONUS', 'WITHDRAWAL_FLOWBACK', 'WITHDRAWAL_REQUEST'))
        				->setSeparator('');*/
        	
		$page = $this->createElement('select', 'page');
		$page->setLabel($this->getView()->translate('Result per page'))
			->addMultiOptions(array(
				'10' => $this->getView()->translate('10'),
				'20' => $this->getView()->translate('20'),
				'30' => $this->getView()->translate('30'),
				'40' => $this->getView()->translate('40'),
				'50' => $this->getView()->translate('50'))); 
		
		$range = $this->createElement('select', 'reportType');
		$range->setLabel('Select Report Type')
			->addMultiOptions(array(
					'WEEKLY' => 'Last One Week Report',
					'MONTHLY' => 'Last One Month Report'
			));
			
		$submit = $this->createElement('submit', 'submit');
		$submit->setLabel($this->getView()->translate('Submit'))
				->setIgnore(true);
			
		$this->addElements(array(
				/* $from_date,
				$from_time,
				$to_date,
				$to_time,
				//$amount_type,
				$transaction_type,*/
				$range,
				$page,
				$submit));
				
		$this->setAttrib('id', 'player-reconcilaion-form');
		$this->setAction('/reconciliation');
		$decorator = new Zenfox_DecoratorForm();
		/* $from_date->setDecorators($decorator->openingJqueryUlTagDecorator);
		$from_time->setDecorators($decorator->formJQueryElements);
		$to_date->setDecorators($decorator->formJQueryElements);
		$to_time->setDecorators($decorator->formJQueryElements);
		//$amount_type->setDecorators($decorator->checkBoxDecorator);
		$transaction_type->setDecorators($decorator->checkBoxDecorator); */
		$range->setDecorators($decorator->openingUlTagDecorator);
		$page->setDecorators($decorator->changeUlTagDecorator);
		$submit->setDecorators($decorator->closingUlButtonTagDecorator);
		
	}
}