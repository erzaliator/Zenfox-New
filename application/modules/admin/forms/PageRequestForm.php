<?php

 class Admin_PageRequestForm extends Zend_Form
 {
 	public function init()
 	{
 		$page = $this->createElement('select', 'page');
		$page->setLabel($this->getView()->translate('Results per page'))
			->addMultiOptions(array(
				'10' => $this->getView()->translate('10'),
				'20' => $this->getView()->translate('20'),
				'30' => $this->getView()->translate('30'),
				'40' => $this->getView()->translate('40'),
				'50' => $this->getView()->translate('50')));
			
		$submit = $this->createElement('submit', 'submit');
		$submit->setLabel($this->getView()->translate('Submit'))
				->setIgnore(true);
				
		$this->addElements(array($page,$submit));
 	}
 }  