<?php
class Admin_AffiliateSearchForm extends Zend_Form
{
	public function init()
	{
		$searchField = $this->createElement('radio', 'searchField');
		$searchField->setLabel('Select Field')
					->addMultiOptions(array(
							'alias' => 'Alias',
							'affiliate_id' => 'Account Id',
							'firstname' => 'First Name',
							'lastname' => 'Last name',
							'email' => 'Email',
							'company' => 'Company',
							'tracker_name' => 'Tracker Name',
					))
					->setValue('alias');
					
		$searchString = $this->createElement('text', 'searchString');
		$searchString->setLabel('Enter String ');
		
		$items = $this->createElement('select', 'items');
		$items->setLabel('Items per page')
			->addMultiOptions(array(
						'10' => '10',
						'20' => '20',
						'30' => '30'));
		
		$match = $this->createElement('checkbox', 'match');
		$match->setLabel('Match String');
		
		$order = $this->createElement('radio', 'order');
		$order->addMultiOptions(array(
							'ASC' => 'Ascending Order',
							'DESC' => 'Descending Order'						
					))
					->setValue('ASC');
			
		$submit = $this->createElement('submit', 'submit');
		$submit->setLabel('Submit');				
				
		$this->addElements(array(
						$searchField,
						$searchString,
						$match,
						$order,
						$items,						
						$submit));
										
	}
}
