<?php

class Partner_AnalyticsForm extends Zend_Form
{
	public function init()
	{
		$frontends = $this->createElement('select', 'frontendId');
		$frontends->setLabel('Select Frontend');
		
		$reportType = $this->createElement('select', 'reportType');
		$reportType->setLabel('Report Type')
					->setMultiOptions(array('EOD'=>'EOD (End Of Day)','EOW'=>'EOW (End Of Week)', 'EOM'=>'EOM (End Of Month)'));
		
		$date = new Zend_Date();
		$today = $date->get('YYYY-MM-dd');
		
		$from_date = new ZendX_JQuery_Form_Element_DatePicker('from_date');
		$from_date->setLabel($this->getView()->translate('From Date'))
					->setRequired(true)
					->setJQueryParams(
                                        array(
                                                'dateFormat' => 'yy-mm-dd',
                                                'changeMonth' => true,
                                                'changeYear' => true))

					->setValue($today);
		
		$to_date = new ZendX_JQuery_Form_Element_DatePicker('to_date');
		$to_date->setLabel($this->getView()->translate('To Date'))
				->setRequired(true)
				->setJQueryParams(
                                        array(
                                                'dateFormat' => 'yy-mm-dd',
                                                'changeMonth' => true,
                                                'changeYear' => true))

				->setValue($today);
		
		$submit = $this->createElement('submit', 'submitButton');
		$submit->setLabel($this->getView()->translate('Submit'))
				->setIgnore(true);
		
		$this->addElements(array(
				$frontends,
				$reportType,
				$from_date,
				$to_date,
				$submit
			));
	}
}
