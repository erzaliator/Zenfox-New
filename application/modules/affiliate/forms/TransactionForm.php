<?php
class Affiliate_TransactionForm extends Zend_Form
{
	public function getForm($affiliateTrackers = NULL)
	{
		if($affiliateTrackers)
		{
			$trackers = $this->createElement('select', 'tracker');
			$trackers->setLabel('Select Tracker');
			$trackers->addMultiOption('-1', 'Select');
			foreach($affiliateTrackers as $affiliateTracker)
			{
				$trackers->addMultiOption($affiliateTracker['tracker_id'], $affiliateTracker['tracker_name']);
			}
			$this->addElement($trackers);
		}
		$date = new Zend_Date();
		$today = $date->get('YYYY-MM-dd');
		
		$fromDate = new ZendX_JQuery_Form_Element_DatePicker('fromDate');
		$fromDate->setLabel('From Date *');
		$fromDate->setJQueryParam('dateFormat', 'yy-mm-dd')
				->setValue($today);
		
		$fromTime = new Zenfox_JQuery_Form_Element_TimePicker('fromTime');
		$fromTime->setLabel('Time *');
		
		$toDate = new ZendX_JQuery_Form_Element_DatePicker('toDate');
		$toDate->setLabel('To Date *');
		$toDate->setJQueryParam('dateFormat', 'yy-mm-dd')
			->setValue($today);
		
		$toTime = new Zenfox_JQuery_Form_Element_TimePicker('toTime');
		$toTime->setLabel('Time *');
				
		$items = $this->createElement('select', 'items');
		$items->setLabel('Items per page');
				
		/* for($i=1;$i<=20;$i++)
		{
			$items->addMultiOption($i,$i);
		} */
		//setting default number of items per page
		$items->addMultiOptions(array(
					'10' => '10',
					'20' => '20',
					'30' => '30',
					'40' => '40',
					'50' => '50'
				));
		//$items->setValue('20');
				
		$submit = $this->createElement('submit','submit');
		$submit->setLabel($this->getView()->translate('Submit'))
				->setIgnore(true);
				
		   		
		$this->addElements(array(
					$fromDate,
					$fromTime,
					$toDate,
					$toTime,
					$items,
					$submit
				));
				
		$this->setMethod('post');
		
		/*$fromDate->setDecorators(array(

  

                   'ViewHelper',

                   'Description',

                   'Errors',

                   array(array('data'=>'HtmlTag'), array('tag' => 'td', 'width' => 150)),

                   array('Label', array('tag' => 'tr')),

                   array(array('row'=>'HtmlTag'),array('tag'=>'tr','openOnly'=>true))

  

           ));
 
           $toDate->setDecorators(array(

                   'ViewHelper',

                   'Description',

                   'Errors',

                   array(array('data'=>'HtmlTag'), array('tag' => 'td', 'width' => 150)),

                   array('Label', array('tag' => 'tr')),

                   array(array('row'=>'HtmlTag'),array('tag'=>'tr','closeOnly'=>true))

           ));*/
		
		$today = new Zend_Date();
		$datetime = $today->get(Zend_Date::W3C);
		$arr = explode('T',$datetime);
			$date = $arr[0];
		$this->toDate->setValue($date);
		
		return $this;
	}
}