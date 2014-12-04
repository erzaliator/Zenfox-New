<?php
class Admin_AffiliateSchemeForm extends Zend_Form
{
	public function setupForm($schemeArray)
	{		
		
		$name = $this->createElement('text','name');
		$name->setLabel('Affiliate Scheme Name *')
			 ->setRequired(true);
				
		$desc = $this->createElement('text','description');
		$desc->setLabel('Description');

		$note = $this->createElement('text','note');
		$note->setLabel('Note');
		
		$schemes = $this->createElement('select', 'scheme');
		$schemes->setLabel('Select Scheme Type');
		foreach($schemeArray as $scheme)
		{
			$schemes->addMultiOptions(array(
						$scheme['scheme_type'] => $scheme['scheme_type']));						
		}
		
		$submit = $this->createElement('submit', 'submit');
        $submit->setLabel($this->getView()->translate('Create'));        		
        		
        $this->addElements(array(
        		$name,
        		$desc,
        		$note,
        		$schemes,
        		$submit));        		        
        
        return $this;
	}
}