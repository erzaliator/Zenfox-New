<?php
class Admin_DeleteSingleTemplateForm extends Zend_Form
{
	public function init()
	{
	}
	
	public function setValue($dataArray)
	{
		$submit = $this->createElement('submit','delete_template');
		$submit->setLabel($this->getView()->translate('Delete Template'));
		
		$id = $this->createElement('hidden','id');
		$id->setValue($dataArray['id']);
				
		$this->addElements(
		array($submit,$id));
	}
}