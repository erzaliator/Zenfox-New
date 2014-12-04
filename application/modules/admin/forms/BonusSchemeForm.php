<?php
class Admin_BonusSchemeForm extends Zend_Form
{
	public function getForm()
	{
		$schemeForm = new Zend_Form_SubForm();
		Zend_Dojo::enableForm($schemeForm);
		
		$schemeId = $schemeForm->createElement('hidden', 'schemeId');
		$schemeForm->addElement($schemeId);
		
		$name = $schemeForm->createElement('text', 'name');
		$name->setLabel('Name');
		$schemeForm->addElement($name);
		
		$schemeForm->addElement(
	    			'SimpleTextarea',
	    			'description',
	    			array(
	      					'label' => $this->getView()->translate('Description'),
	    					'style' => 'width: 30em; height: 10em;'
	    				)
					);
					
		$noOfParts = $schemeForm->createElement('text', 'noOfParts');
		$noOfParts->setLabel('Number of Levels');
		$schemeForm->addElement($noOfParts);
		$schemeForm->setAttrib('id', 'admin-bonus-scheme-form');
		
		return $schemeForm;
	}
	
	public function setForm($form, $data)
	{
		$form->schemeId->setValue($data['schemeId']);
		$form->name->setValue($data['name']);
		$form->description->setValue($data['description']);
		$form->noOfParts->setValue($data['noOfParts']);
		
		return $form;
	}
}