<?php

class Admin_TrackerSearchForm extends Zend_Form
{
	public function init()
	{
		$searchField = $this->createElement('radio', 'searchField');
		$searchField->setLabel('Select Field')
					->addMultiOptions(array(							
							'tracker_id' => 'Link Id',
							'tracker_name' => 'Link Name',
					))
					->setValue('tracker_id');
		
		$searchString = $this->createElement('text', 'searchString');
		$searchString->setLabel('Search String ');
		
		$match = $this->createElement('checkbox', 'match');
		$match->setLabel('Match String');
		
		$order = $this->createElement('radio', 'order');
		$order->addMultiOptions(array(
							'ASC' => 'Ascending Order',
							'DESC' => 'Descending Order'						
					))
					->setValue('ASC');
					
		$items = $this->createElement('select', 'items');
		$items->setLabel('Items per page')
			->addMultiOptions(array(
						'10' => '10',
						'20' => '20',
						'30' => '30'));
				
		$submit = $this->createElement('submit','submit');
		$submit->setLabel($this->getView()->translate('Submit'));
				
				
		$this->addElements(array(
				$searchField,
				$searchString,
				$match,
				$order,
				$items,
				$submit
			));		
	}
}