<?php
class Admin_UserForm extends Zend_Form
{
	public function init()
	{
		$searchField = $this->createElement('radio', 'searchField');
		$searchField->setLabel('Select Field')
					->addMultiOptions(array(
							'login' => 'Login Name',
							'player_id' => 'Player Id',
							'email' => 'Email Id',
							'first_name' => 'First Name',
					        /*'password' => 'Password',
							'registration' => 'Registrations',
							'depositor' => 'Depositors'*/))				        
					->setValue('login')
					->setSeparator('');
					
		/*$fromDate = new ZendX_JQuery_Form_Element_DatePicker('start_date');
		$fromDate->setLabel('From Date');
		$fromDate->setJQueryParam('dateFormat', 'yy-mm-dd');
		
		$fromTime = new Zenfox_JQuery_Form_Element_TimePicker('from_time');
		$fromTime->setLabel('Time');
		
		$toDate = new ZendX_JQuery_Form_Element_DatePicker('end_date');
		$toDate->setLabel('To Date');
		$toDate->setJQueryParam('dateFormat', 'yy-mm-dd');
		
		$toTime = new Zenfox_JQuery_Form_Element_TimePicker('to_time');
		$toTime->setLabel('Time');*/
					
		$searchString = $this->createElement('text', 'searchString');
		$searchString->setLabel('Enter String ');
					//->setRequired(true);
		
		/*$match = $this->createElement('checkbox', 'match');
		$match->setLabel('Match String')
			->setValue(true);*/
		
		$accountType = $this->createElement('radio', 'accountType');
		$accountType->setLabel('Select Account Type')
					->addMultiOptions(array(
							'confirmed' => 'Confirmed Accounts',
							'unconfirmed' => 'Unconfirmed Accounts'))												        
					->setValue('confirmed');
		
		$items = $this->createElement('select', 'items');
		$items->setLabel('Items per page')
			->addMultiOptions(array(
						'10' => '10',
						'20' => '20',
						'30' => '30'));
				
		$submit = $this->createElement('submit', 'submit');
		$submit->setLabel('Submit')
				->setIgnore(true);
				
		$this->addElements(array(
						$searchField,
						/*$fromDate,
						$fromTime,
						$toDate,
						$toTime,*/
						$searchString,
						/*$match,*/
						$accountType,
						$items,
						$submit));
		$this->setAttrib('id', 'admin-user-form');
	}
}