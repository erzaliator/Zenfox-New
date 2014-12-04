<?php
class Admin_SearchCommentsForm extends Zend_Form
{
	public function init()
	{
		$pageAddress = $this->createElement('text', 'page_address');
		$pageAddress->setLabel('Page Address(e.g player-index-index)');
		
		$userName = $this->createElement('text', 'user_name');
		$userName->setLabel('User Name');
		
		$topic = $this->createElement('select', 'topic');
		$topic->setLabel($this->getView()->translate('Select a topic'))
				->addMultiOptions(array(
							'' => '',
							'game' => 'Game',
							'look' => 'Page Look',
				));
		
		$enabled = $this->createElement('select', 'enabled');
		$enabled->setLabel('Status')
				->addMultiOptions(array(
							'' => '',
							'ENABLED' => 'Enabled',
							'DISABLED' => 'Disabled',
				));
		$date = new Zend_Date();
		$today = $date->get('YYYY-MM-dd');
		
		$from_date = new ZendX_JQuery_Form_Element_DatePicker('from_date');
		$from_date->setLabel($this->getView()->translate('From Date*'))
				->setRequired(true)
				->setJQueryParam('dateFormat', 'yy-mm-dd')
				->setValue($today);
				
		$from_time = new Zenfox_JQuery_Form_Element_TimePicker('from_time');
		$from_time->setLabel($this->getView()->translate('Time*'));
		
        $to_date = new ZendX_JQuery_Form_Element_DatePicker('to_date');
		$to_date->setLabel($this->getView()->translate('To Date*'))
				->setRequired(true)
				->setJQueryParam('dateFormat', 'yy-mm-dd')
				->setValue($today);
		
		$to_time = new Zenfox_JQuery_Form_Element_TimePicker('to_time');
        $to_time->setLabel($this->getView()->translate('Time*'));
		
		$page = $this->createElement('select', 'page');
		$page->setLabel($this->getView()->translate('Result per page'))
			->addMultiOptions(array(
				'10' => $this->getView()->translate('10'),
				'20' => $this->getView()->translate('20'),
				'30' => $this->getView()->translate('30'),
				'40' => $this->getView()->translate('40'),
				'50' => $this->getView()->translate('50')));
		
		$submit = $this->createElement('submit', 'submit');
		$submit->setLabel('Submit')
				->setIgnore(true);
				
		$this->addElements(array(
					$pageAddress,
					$userName,
					$topic,
					$enabled,
					$from_date,
					$from_time,
					$to_date,
					$to_time,
					$page,
					$submit,
				));
	}
}