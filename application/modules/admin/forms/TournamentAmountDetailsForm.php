<?php

class Admin_TournamentAmountDetailsForm extends Zend_Form
{
	public function getform()
	{

		$startDate = new ZendX_JQuery_Form_Element_DatePicker('startdate');
		$startDate->setLabel($this->getView()->translate(' Start Date'))
		->setRequired(true)
		->setJQueryParam('dateFormat', 'yy-mm-dd')
		->setValue($today);

		$endDate = new ZendX_JQuery_Form_Element_DatePicker('enddate');
		$endDate->setLabel($this->getView()->translate('End Date'))
		->setRequired(true)
		->setJQueryParam('dateFormat', 'yy-mm-dd')
		->setValue($today);
		
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel('enter');

		$this->addElements(array( $startDate,$endDate,
				$submit));

		return $this;
	}
}