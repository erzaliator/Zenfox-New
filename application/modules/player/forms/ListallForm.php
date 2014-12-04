<?php

class Player_ReconciliationForm extends Zend_Form
{
	public function init()
	{
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
        			
        $transaction_status = $this->createElement('multiCheckbox', 'transaction_status');
        $transaction_status->setLabel($this->getView()->translate('Transaction Status'))
        				->addMultiOption('PROCESSED', $this->getView()->translate('Processed'))
        				->addMultiOption('NOT_PROCESSED', $this->getView()->translate('Un-Processed'))
        				->addMultiOption('PARTIALLY_PROCESSED', $this->getView()->translate('Partially Processed'));
        				
        	
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
				$from_date,
				$from_time,
				$to_date,
				$to_time,
				$transaction_status,
				$page,
				$submit));
				
		$this->setAttrib('id', 'player-listall-form');
		
		$decorator = new Zenfox_DecoratorForm();
		$from_date->setDecorators($decorator->openingJqueryUlTagDecorator);
		$from_time->setDecorators($decorator->formJQueryElements);
		$to_date->setDecorators($decorator->formJQueryElements);
		$to_time->setDecorators($decorator->formJQueryElements);
		$transaction_status->setDecorators($decorator->changeUlTagDecorator);
		$page->setDecorators($decorator->changeUlTagDecorator);
		$submit->setDecorators($decorator->closingUlButtonTagDecorator);
	}
}
