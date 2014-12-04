<?php

class Admin_HealthForm extends Zend_Form
{
	public $systemtaglist,$playertaglist,$trackertaglist;
	public function getform($options = null) 
    { 
       
        $this->setName('HealthForm');
       
		$authSession = new Zend_Auth_Storage_Session();
		$sessionData = $authSession->read();
		$csrId = $sessionData['id'];
		$csrfrontendids = $sessionData['frontend_ids'];
			
		$frontendobject = new Frontend();
		$frontends = $frontendobject->getFrontends();
		if((count($frontends)) == (count($csrfrontendids)))
		{
			
			$health = new Zend_Form_Element_Radio('health');
			$health->setLabel('Select Health *')
						->addMultiOptions(array(
							'SystemHealth' => 'SystemHealth',
							'PlayerHealth' => 'PlayerHealth',
							'TrackerHealth' => 'TrackerHealth'
							))
						->setRequired(true)
						->setAttrib('id','health')
						->setAttrib('onClick', 'HealthForms()')
						->setSeparator('');
		}
		else
		{
			$health = new Zend_Form_Element_Radio('health');
			$health->setLabel('Select Health *')
						->addMultiOptions(array(
							'PlayerHealth' => 'PlayerHealth'
							))
						->setRequired(true)
						->setAttrib('id','health')
						->setAttrib('onClick', 'PlayerHealthForms()')
						->setSeparator('');
		}
        
        $systemtag = new Zend_Form_Element_Select('systemtag');
        $systemtag->setLabel('Select System Tag')
              ->setMultiOptions($this->systemtaglist)
              ->setRequired(true);
              
        $playertag = new Zend_Form_Element_Select('playertag');
        $playertag->setLabel('Select Player Tag')
              ->setMultiOptions($this->playertaglist)
              ->setRequired(true);
              
        $trackertag = new Zend_Form_Element_Select('trackertag');
        $trackertag->setLabel('Select Tracker Tag')
              ->setMultiOptions($this->trackertaglist)
              ->setRequired(true);
        
        $reporttype = new Zend_Form_Element_Select('report_type');
        $reporttype->setLabel('Report Type')
        			->setMultiOptions(array('EOH'=>'EOH', 'EOD'=>'EOD','EOW'=>'EOW', 'EOM'=>'EOM'))
        			->setRequired(true);
 
        
        $StartDate =new ZendX_JQuery_Form_Element_DatePicker('startdate',
        		array('jQueryParams' => array('dateFormat' => 'yy-mm-dd')));
        $StartDate->setLabel('Start Date')
        ->setRequired(true);
        
        $StartTime = new Zenfox_JQuery_Form_Element_TimePicker('starttime');
        $StartTime->setLabel($this->getView()->translate(' Start Time'))
        			->setJQueryParam('TimeFormat', 'h:m:s');
        
        $EndDate =new ZendX_JQuery_Form_Element_DatePicker('enddate',
        		array('jQueryParams' => array('dateFormat' => 'yy-mm-dd')));
       	 $EndDate->setLabel('End Date')
       			 ->setRequired(true);
        
        $EndTime = new Zenfox_JQuery_Form_Element_TimePicker('endtime');
        $EndTime->setLabel($this->getView()->translate(' End Time'))
       			 ->setJQueryParam('TimeFormat', 'h:m:s');
        
        $items = new Zend_Form_Element_Select('items');
        $items->setLabel('Items per Page')
        ->setMultiOptions(array('10'=>'10', '20'=>'20','30'=>'30', '40'=>'40', '50'=>'50'))
        ->setRequired(true);
        
   
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setLabel('Get Health')
        	->setAttrib('onClick', 'HealthsubmitForms(event)');
        	
        $this->addElements(array($health,$systemtag, $playertag,$trackertag,$reporttype, $StartDate,
		       $StartTime,$EndDate,$EndTime,$items,  $submit));
        return $this;
        
    } 
	public function setSystemvalue($sysvalues)
	{
		$this->systemtaglist=$sysvalues;
	}
	public function setPlayervalue($plyvalues)
	{
		$this->playertaglist=$plyvalues;
	}
	public function setTrackervalue($trkvalues)
	{
		$this->trackertaglist=$trkvalues;
	}
}

