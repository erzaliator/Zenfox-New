<?php
class Admin_SystemReportForm extends Zend_Form
{
	public function init()
	{
		$systemTag = new SystemTag();
		$allTags = $systemTag->getAllTags();
		
		$tagName = $this->createElement('multiCheckbox', 'tagName');
		$tagName->setLabel('Tag');
		foreach($allTags as $tag)
		{
			$tagName->addMultiOption($tag['tag'], $tag['tag']);
		}
		
		$reportType = $this->createElement('select', 'reportType');
		$reportType->setLabel('Report Type');
		$reportType->addMultiOptions(array(
								'EOH' => 'Hourly',
								'EOD' => 'Daily',
								'EOW' => 'Weekly',
								'EOM' => 'Monthly',
					));

		$date = new Zend_Date();
		$today = $date->get('YYYY-MM-dd');
		
		$fromDate = new ZendX_JQuery_Form_Element_DatePicker('fromDate');
		$fromDate->setLabel($this->getView()->translate('From Date'))
				->setRequired(true)
				->setJQueryParam('dateFormat', 'yy-mm-dd')
				->setValue($today);
				
		$fromTime = new Zenfox_JQuery_Form_Element_TimePicker('fromTime');
		$fromTime->setLabel($this->getView()->translate('Time'));
		
        $toDate = new ZendX_JQuery_Form_Element_DatePicker('toDate');
		$toDate->setLabel($this->getView()->translate('To Date'))
				->setRequired(true)
				->setJQueryParam('dateFormat', 'yy-mm-dd')
				->setValue($today);
		
		$toTime = new Zenfox_JQuery_Form_Element_TimePicker('toTime');
        $toTime->setLabel($this->getView()->translate('Time'));
		
		$page = $this->createElement('select', 'page');
		$page->setLabel($this->getView()->translate('Result per page'))
			->addMultiOptions(array(
				'1' => $this->getView()->translate('1'),
				'2' => $this->getView()->translate('2'),
				'3' => $this->getView()->translate('3'),
				'4' => $this->getView()->translate('4'),
				'5' => $this->getView()->translate('5')));
		
		$submit = $this->createElement('submit', 'submit');
		$submit->setLabel('Submit')
				->setIgnore(true);
				
		$this->addElements(array(
					$tagName,
					$reportType,
					$fromDate,
					$fromTime,
					$toDate,
					$toTime,
					$page,
					$submit,
					));
	}
}