<?php


class Admin_TrackerPlayersForm extends Zend_Form
{
	public $frontendlist;
	public function getform()
	{
		 
		$this->setName('TrackerPlayers');
		$this->setAttrib('id', 'AnalyticsForms');
		
		
		$affiliatetrackerobj = new AffiliateTracker();
		$trackers = $affiliatetrackerobj->getAlltAffiliateTrackers();
		
		
		$trackerid = $this->createElement('select', 'trackerid');
			$trackerid->addMultiOptions(array('-1' => 'Select One'));
			$trackerid->setLabel('Select Tracker');
			foreach($trackers as $index => $trackerData)
			{
				
				$trackerid->addMultiOptions(array(
								$trackerData['tracker_id'] => $trackerData['tracker_name'],
								));
			}
		 
		
		                   	
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

		$this->addElements(array( $trackerid,  $StartDate, $EndDate, $submit));
		return $this;

	}
	
}

