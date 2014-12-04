<?php
class Admin_SchemeSearchForm extends Zend_Form
{
	public function init()	
	{
		
	}
	public function setupForm($schemeTypes)
	{
		$searchField = $this->createElement('radio', 'searchField');
		$searchField->setLabel('Select Field')
					->addMultiOptions(array(
							'id' => 'Scheme Id',
							'name' => 'Scheme Name',							
					))
					->setValue('id');	
		$scheme = $this->createElement('radio', 'schemeType');
		$scheme->setLabel('Select Scheme Type');
		foreach($schemeTypes as $type)
		{
			$scheme->addMultiOptions(array(
							$type['scheme_type'] => $type['scheme_type'],														
					));
		}
		$scheme->setValue($schemeTypes[0]['scheme_type']);
					
		$searchString = $this->createElement('text', 'searchString');
		$searchString->setLabel('Enter String ');
						
		$match = $this->createElement('checkbox', 'match');
		$match->setLabel('Match String');
			
		$submit = $this->createElement('submit', 'submit');
		$submit->setLabel('Submit');				
				
		$this->addElements(array(
						$searchField,
						$scheme,
						$searchString,
						$match,																		
						$submit));
						
		return $this;
										
	}
}
