<?php
class Admin_AmsSchemeTypesForm extends Zend_Form
{
	public function getForm()
	{
		$schemeType = $this->createElement('text','schemeType');
		$schemeType->setLabel('Scheme Type *')
				->setRequired(true);
				
		$schemeName = $this->createElement('text','schemeName');
		$schemeName->setLabel('Scheme Name *')
				->setRequired(true);
				
		$this->addElements(array($schemeType,$schemeName));
				
		$this->addElement(
					'text',
					'schemeDescription',
					array(
						'label' => $this->getView()->translate('Scheme Description'),
						'style' => 'width: 30em; height: 5em;'));
					
		$criteria = $this->createElement('text','criteria');
		$criteria->setLabel('criteria *')
				->setRequired(true);
				
		$creditingFactor = $this->createElement('text','creditingFactor');
		$creditingFactor->setLabel('Crediting Factor *')
				->setRequired(true);
				
		$submit = $this->createElement('submit', 'submit');
        $submit->setLabel($this->getView()->translate('Submit'))
        		->setIgnore(true);
        		
        $this->addElements(array($criteria, $creditingFactor, $submit));
        		
        $this->setMethod('post');
        
        return $this;
	}
	
	public function setForm($data)
	{
		$form = $this->getForm();
		$form->schemeType->setValue($data['schemeType']);
		$form->schemeName->setValue($data['schemeName']);
		$form->schemeDescription->setValue($data['schemeDescription']);
		$form->criteria->setValue($data['criteria']);
		$form->creditingFactor->setValue($data['creditingFactor']);
		
		return $form;
	}
}