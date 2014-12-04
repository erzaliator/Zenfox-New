<?php
class Admin_AffiliateFrontendForm extends Zend_Form
{
	public function getForm()
	{
		$name = $this->createElement('text','name');
		$name->setLabel('Affiliate Frontend Name *')
				->setRequired(true)
				->addValidator('Alnum');
				
		$this->addElement($name);

		$this->addElement(
					'text',
					'description',
					array(
						'label' => $this->getView()->translate('Description *'),
						'style' => 'width: 30em; height: 5em;'));
					
		$affiliateAllowedFrontendIds = $this->createElement('multiCheckbox', 'affiliateAllowedFrontendIds');
        $affiliateAllowedFrontendIds->setLabel('Allowed Affiliate Frontends *')
        							->setRequired(true);
        
        $affiliateFrontend = new AffiliateFrontend();
        
        $affFrontends = $affiliateFrontend->getAffiliateFrontends();
        
		foreach($affFrontends as $aFrontend)
		{
			$affiliateAllowedFrontendIds->addMultiOption($aFrontend['id'],$aFrontend['name']);
		}
        
        $allowedFrontendIds = $this->createElement('multiCheckbox', 'allowedFrontendIds');
        $allowedFrontendIds->setLabel('Allowed Frontends *')
        					->setRequired(true);
        
		$frntend = new Frontend();
		$frntends = $frntend->getFrontends();
		
		foreach($frntends as $frend)
		{
			$allowedFrontendIds->addMultiOption($frend['id'],$frend['name']);
		}
        
        $defaultAffiliateSchemeId = $this->createElement('select', 'defaultAffiliateSchemeId');
		$defaultAffiliateSchemeId->setLabel($this->getView()->translate('Default Affiliate Scheme *'))
					->setRequired(true);
					
		$affScheme = new AffiliateScheme();
		$affSchemes = $affScheme->getAffiliateSchemes();
		
		foreach($affSchemes as $aScheme)
		{
			$defaultAffiliateSchemeId->addMultiOption($aScheme['id'],$aScheme['name']);
		}
					
		$submit = $this->createElement('submit', 'submit');
        $submit->setLabel($this->getView()->translate('Submit'))
        		->setIgnore(true);
					
		$this->addElements(array(
							$affiliateAllowedFrontendIds,
							$allowedFrontendIds,
							$defaultAffiliateSchemeId,
							$submit
								));
								
		$this->setMethod('post');
		
		$this->setAttrib('id', 'admin-affiliate-frontend-form');
								
		return $this;
        
        
	}
	
	public function setForm($data)
	{
		$form = $this->getForm();
		
		$frntendIds = $this->getKeys($data['allowed_frontend_ids']);
		$affFrntendIds = $this->getKeys($data['affiliate_allowed_frontend_ids']);
		$form->name->setValue($data['name']);
		$form->description->setValue($data['description']);
		$form->allowedFrontendIds->setValue($frntendIds);
		$form->affiliateAllowedFrontendIds->setValue($affFrntendIds);
		$form->defaultAffiliateSchemeId->setValue($data['default_affiliate_scheme_id']);
		
		return $form;
	}
	
	public function getKeys($keysString)
	{
		$keys = explode(",",$keysString);
		return $keys;
	}
	
}