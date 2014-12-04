<?php


class Admin_CampaignForm extends Zend_Form
{
	public $frontendlist;
	public $templatelist;
	public $grouplist;
	
	public function getform()
	{
		 
		$this->setName('Campaign');
	
		$frontends = new Zend_Form_Element_Select('frontend_id');
		$frontends->setLabel('Select frontend')
					->setMultiOptions($this->frontendlist)
					->setRequired(true);
		
		$templates = new Zend_Form_Element_Select('template_id');
		$templates->setLabel('Select template')
		->setMultiOptions($this->templatelist)
		->setvalue('7')
		->setRequired(true);
		
		$groups = new Zend_Form_Element_Select('group_id');
		$groups->setLabel('Select group')
		->setMultiOptions($this->grouplist)
		->setRequired(true);
		
		
		$message = new Zend_Form_Element_Textarea('message');
		$message->setlabel('Enter Message')
				 ->setAttrib('rows','5')
                    ->setAttrib('cols','10');
                    
        $campaignName = new Zend_Form_Element_Text('campaign_name');
		$campaignName->setlabel('Campaign Name');
		
		$type = new Zend_Form_Element_Select('type');
		$type->setLabel('Type *')
					->setMultiOptions(array( 'ONCE'=>'ONCE','Daily'=>'Daily','WEEKLY'=>'WEEKLY', 'MONTHLY'=>'MONTHLY'))
					->setRequired(true)
					->setvalue('ONCE')
		            ->addValidator('NotEmpty');
		
		$priority = new Zend_Form_Element_Select('Priority');
		$priority->setLabel('Select Priority( 0 to 4 )')
							->setMultiOptions(array( '0'=>'0','1'=>'1','2'=>'2', '3'=>'3','4'=>'4'))
							->setRequired(true)
							->setvalue('2')
		                   	->addValidator('NotEmpty');

		$date = new Zend_Date();
		$today = $date->get('YYYY-MM-dd');
		
		$requestdate = new ZendX_JQuery_Form_Element_DatePicker('request_date');
		$requestdate->setLabel($this->getView()->translate('Request Date'))
				->setRequired(true)
				->setJQueryParam('dateFormat', 'yy-mm-dd')
				->setValue($today);
				
		$requesttime = new Zenfox_JQuery_Form_Element_TimePicker('request_time');
		$requesttime->setLabel($this->getView()->translate('Request Time'))
					->setvalue('23:50');
		
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel('Start Campaign');

		$this->addElements(array( $frontends, $templates, $type,$groups,
				$message,$campaignName, $priority,$requestdate,$requesttime, $submit));
		
		return $this;

	}
	public function setfrontend($values)
	{
		
		$this->frontendlist=$values;
		
	}
	public function setgroup($values)
	{
		$this->grouplist = $values;
		
	}
	public function settemplate($values)
	{
		$this->templatelist=$values;
	}
}

