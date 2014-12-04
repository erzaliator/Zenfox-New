<?php

class Admin_TransactionSummaryForm extends Zend_Form
{
	
	public function getform($options = null)
	{
			
		$this->setName('TransactionSummary');

		
		$reporttypetime = new Zend_Form_Element_Select('report_type_time');
		$reporttypetime->setLabel('Report Type(time)')
		->setMultiOptions(array( 'EOD'=>'EOD','EOW'=>'EOW', 'EOM'=>'EOM'))
		->setRequired(true)
		->addValidator('NotEmpty');
			


		$StartDate =new ZendX_JQuery_Form_Element_DatePicker('startdate',
				array('jQueryParams' => array('dateFormat' => 'yy-mm-dd')));
		$StartDate->setLabel('Start Date')
		->setRequired(true);
			
		
			
		$EndDate =new ZendX_JQuery_Form_Element_DatePicker('enddate',
				array('jQueryParams' => array('dateFormat' => 'yy-mm-dd')));
		$EndDate->setLabel('End Date')
		->setRequired(true);
			
		
		

		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel('Get Health');

		$this->addElements(array(  $reporttypetime,$StartDate, $EndDate, $submit));
		return $this;

	}
	
}