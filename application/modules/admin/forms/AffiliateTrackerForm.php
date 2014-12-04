<?php
class Admin_AffiliateTrackerForm extends Zend_Form
{
	public function getForm()
	{
		$trackerType = $this->createElement('select','trackerType');
		$trackerType->setLabel($this->getView()->translate('Tracker Type *'))
					->setRequired(true);
					
		$trackerType->addMultiOption('ONLINE','ONLINE');
		$trackerType->addMultiOption('OFFLINE','OFFLINE');
		
		$trackerName = $this->createElement('text','trackerName');
		$trackerName->setLabel($this->getView()->translate('Tracker Name *'))
				->setRequired(true);
				
		$schemeId = $this->createElement('select','schemeId');
		$schemeId->setLabel($this->getView()->translate('Affiliate Scheme *'))
					->setRequired(true);
					
		$affiliateScheme = new AffiliateScheme();
		$affiliateSchemes = $affiliateScheme->getAffiliateSchemes();
		foreach($affiliateSchemes as $affiliateScheme)
		{
			$schemeId->addMultiOption($affiliateScheme['id'],$affiliateScheme['name']);
		}
				
		$submit = $this->createElement('submit','submit');
		$submit->setLabel($this->getView()->translate('Submit'))
				->setIgnore(true);
				
		$this->addElements(array(
					$trackerType,
					$trackerName,
					$schemeId,
					$submit
				));
				
		$this->setMethod('post');
		
		return $this;
					
	}
	
	public function setForm($data)
	{
		$form = $this->getForm();
		$form->trackerType->setValue($data['tracker_type']);
		$form->trackerName->setValue($data['tracker_name']);
		$form->schemeId->setValue($data['scheme_id']);
		
		return $form;
	}
}
