<?php
class Admin_CheckIdsForm extends Zend_Form
{
	public function getform()
	{
		$decorator = new Zenfox_DecoratorForm();
		
		$doc_no = new Zend_Form_Element_Text('document_number');
		$doc_no->setLabel('Document Number *')
				->setRequired(true);
		
		
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel('INSERT PROOFS');

		$this->addElements(array($doc_no, $submit));
		
		$doc_no->setDecorators($decorator->openingUlTagDecorator);
		
		$submit->setDecorators($decorator->closingUlButtonTagDecorator);
		
		return $this;
	}
}