<?php
class Admin_CreatetournamentForm extends Zend_Form
{
	public $configidlist;
	public function getform()
	{
		$tournamenttype = new Zend_Form_Element_Text('type');
		$tournamenttype->setLabel('Tournament Type')
						->setRequired(true);
		
		$tournamentname = new Zend_Form_Element_Text('name');
		$tournamentname->setLabel('Tournament Name')
						->setRequired(true);
		
		$date = new Zend_Date();
		$today = $date->get('YYYY-MM-dd');
		
		$startDate = new ZendX_JQuery_Form_Element_DatePicker('startdate');
		$startDate->setLabel($this->getView()->translate(' Start Date'))
		->setRequired(true)
		->setJQueryParam('dateFormat', 'yy-mm-dd')
		->setValue($today);
		
		$StartTime = new Zenfox_JQuery_Form_Element_TimePicker('starttime');
		$StartTime->setLabel($this->getView()->translate(' Start Time'))
					->setJQueryParam('TimeFormat', 'h:m:s');
		
		 $configid = new Zend_Form_Element_Select('config_id');
        $configid->setLabel('Config Id')
        			->setMultiOptions($this->configidlist)
        			->setRequired(true);
		
		$description = new Zend_Form_Element_Text('description');
		$description->setLabel('Description')
					->setRequired(true);
		
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel('create Tournament');
		
		
		$this->addElements(array( $tournamentname,
				$startDate,$StartTime,$configid,$tournamenttype, $description, $submit));
		return $this;
		
		
	}
	
	public function setvalue($values)
	{
		$this->configidlist=$values;
	}
}