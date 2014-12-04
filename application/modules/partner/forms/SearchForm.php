<?php

class Partner_SearchForm extends Zend_Form
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
					))
					->setValue('login')
					->setSeparator('');
			
		$searchString = $this->createElement('text', 'searchString');
		$searchString->setLabel('Enter String ');
	
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
				$searchString,
				$accountType,
				$items,
				$submit
			));
	}
}