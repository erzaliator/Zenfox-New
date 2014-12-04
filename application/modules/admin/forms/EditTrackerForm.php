<?php
class Admin_EditTrackerForm extends Zend_Form
{
	public function setupForm($tracker,$details)
	{
		$trackerType = $this->createElement('select','trackerType');
		$trackerType->setLabel($this->getView()->translate('Tracker Type *'))
					->setValue($tracker['tracker_type'])
					->setRequired(true);				
					
		$trackerType->addMultiOption('ONLINE','ONLINE');
		$trackerType->addMultiOption('OFFLINE','OFFLINE');
		
		$this->addElement($trackerType);
		
		$trackerName = $this->createElement('text','trackerName');
		$trackerName->setLabel($this->getView()->translate('Tracker Name *'))
				->setValue($tracker['tracker_name'])
				->setRequired(true);
		$this->addElement($trackerName);		
		
				
		$schemeId = $this->createElement('select','schemeId');
		$schemeId->setLabel($this->getView()->translate('Affiliate Scheme *'))
					->setValue($tracker['scheme_id'])
					->setRequired(true);		
					
		$affiliateScheme = new AffiliateScheme();
		$affiliateSchemes = $affiliateScheme->getAffiliateSchemes();
		foreach($affiliateSchemes as $affiliateScheme)
		{
			$schemeId->addMultiOption($affiliateScheme['id'],$affiliateScheme['name']);
		}
		$this->addElement($schemeId);
		
		foreach($details as $detail)
		{
			$element = $this->createElement('text' , $detail['variable_name']);
			$element->setLabel($this->getView()->translate($detail['variable_name']))
					->setValue($detail['variable_value']);
					
			$this->addElement($element);
		}		
		$submit = $this->createElement('submit','submit');
		$submit->setLabel($this->getView()->translate('Submit'))
				->setIgnore(true);								
		$this->addElement($submit);
		
		return $this;
		
					
	}	
}
