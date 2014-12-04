<?php
class Admin_JournalDataForm extends Zend_Form
{
	public function getform()
	{
		
		
		$value = new Zend_Form_Element_Textarea('value');
		$value->setLabel('enter note')
		->setAttribs(array('style', 'width: 10px;'));
		
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel('enter');
		
		$this->addElements(array( $value,
				$submit));
		
		return $this;
	}
}