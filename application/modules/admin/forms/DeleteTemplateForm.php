<?php
class Admin_DeleteTemplateForm extends Zend_Form
{
	public function init()
	{
		$submit = $this->createElement('submit','delete_template');
		$submit->setLabel($this->getView()->translate('Confirm Delete'));
		
		$hidden = $this->createElement('hidden','isSubmit');
		$hidden->setValue('1')
				->addValidator('NotEmpty');
		
		$this->addElements(
		array($submit,$hidden));
	}
}