<?php
class Admin_BankdetailssearchForm extends Zend_Form
{
	public function getform()
	{
		$searchField = $this->createElement('radio', 'searchField');
		$searchField->setLabel('Select Field')
					->addMultiOptions(array(
							'player_id' => 'Player Id',
							'account_number' => 'Bank Account Number',
							'name' => 'First Name',
							'name_of_bank' => 'Bank Name',
							'ifsc_code' => 'IFSC Code'
					       ))				        
					->setValue('player_id')
					->setSeparator('');
					
		
		$searchString = $this->createElement('text', 'searchString');
		$searchString->setLabel('Enter Value ');
					//->setRequired(true);
				
		$items = $this->createElement('select', 'items');
		$items->setLabel('Items per page')
			->addMultiOptions(array(
						'10' => '10',
						'20' => '20',
						'30' => '30'));
				
		$submit = $this->createElement('submit', 'submit');
		$submit->setLabel('Get Bank Details')
				->setIgnore(true);
				
		$this->addElements(array(
						$searchField,
						$searchString,
						$items,
						$submit));
		$this->setAttrib('id', 'admin-Bankdetailssearching-form');
		
		return $this;
	}
}