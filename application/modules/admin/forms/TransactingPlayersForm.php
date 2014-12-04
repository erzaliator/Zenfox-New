<?php


class Admin_TransactingPlayerForm extends Zend_Form
{
	public $frontendlist;
	public $affiliatelist;
	public $trackerlist;
	public function getform($options = null)
	{
		 
		$this->setName('TransactingPlayer');
		$this->setAttrib('id','AnalyticsForms');
		
		
		
		$authSession = new Zend_Auth_Storage_Session();
				$sessionData = $authSession->read();
				$csrId = $sessionData['id'];
				$csrfrontendids = $sessionData['frontend_ids'];
				
				$frontendobject = new Frontend();
				$frontends = $frontendobject->getFrontendById($csrfrontendids);
				$length = count($frontends);
				$index = 0;
				while($index < $length )
				{
					$newfrontendlist[$frontends[$index]['id']] = $frontends[$index]['name'];
					$index++;
				}
				
		$frontends = new Zend_Form_Element_Select('frontendid');
		$frontends->setLabel('Select frontend')
					->setAttrib('id','frontend')
					->setMultiOptions($newfrontendlist);
					
		if((count($this->frontendlist)) == (count($newfrontendlist)))
		{
			$networkorfrontend = new Zend_Form_Element_Radio('networkorfrontend');
			$networkorfrontend->setLabel('Gender:')
						->addMultiOptions(array(
							'Network' => 'Network',
							'Frontend' => 'Frontend',
								'Affiliate' => 'Affiliate',
								'Tracker' =>'Tracker'
								))
						->setRequired(true)
						->setAttrib('onClick', 'AnalyticsForms()')
						->setValue("Network")
						->setSeparator('');
		}
		else 
		{
			$networkorfrontend = new Zend_Form_Element_Radio('networkorfrontend');
			$networkorfrontend->setLabel('Gender:')
						->addMultiOptions(array(
							'Frontend' => 'Frontend'
							))
						->setRequired(true)
						->setAttrib('onClick', 'AnalyticsFrontendForms()')
						->setSeparator('');
		}
					
					
					
		$affiliate = new Zend_Form_Element_Select('affiliateid');
		$affiliate->setLabel('Select affiliate')
		->setAttrib('id','affiliate')
		->setMultiOptions($this->affiliatelist);
		
		$tracker = new Zend_Form_Element_Select('trackerid');
		$tracker->setLabel('Select tracker')
		->setAttrib('id','tracker')
		->setMultiOptions($this->trackerlist);
		
		
		$reporttypetime = new Zend_Form_Element_Select('report_type_time');
		$reporttypetime->setLabel('Report Type(time)')
							->setMultiOptions(array('EOD'=>'EOD','EOW'=>'EOW', 'EOM'=>'EOM'))
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

		$this->addElements(array( $networkorfrontend, $frontends,$affiliate,$tracker, $reporttypetime,
				$StartDate, $EndDate, $submit));
		
		return $this;

	}
	public function setvalue($frontend,$affiliate,$tracker)
	{
		$this->frontendlist=$frontend;
		$this->affiliatelist = $affiliate;
		$this->trackerlist = $tracker;
	}
}


