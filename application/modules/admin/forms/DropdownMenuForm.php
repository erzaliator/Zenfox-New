<?php
class Admin_DropdownMenuForm extends Zend_Form
{
	public function init()
	{
		$date = new Zend_Date();
		$today = $date->get('YYYY-MM-dd');
		
		$ticket_status = $this->createElement('select', 'ticket_status');
		$ticket_status->setLabel($this->getView()->translate('Status'))
					->addMultiOptions(array(
							'OPEN'      => $this->getView()->translate('Open'),
							'CLOSE'     => $this->getView()->translate('Close'),
							'PENDING'   => $this->getView()->translate('Pending'),
							'FORWARDED' => $this->getView()->translate('Forwarded'),
							'DISPATCH'  => $this->getView()->translate('Dispatch')));
					
		$start_date = new ZendX_JQuery_Form_Element_DatePicker('start_date');
		$start_date->setLabel($this->getView()->translate('From Date'))
				->setRequired(true)
				->setJQueryParam('dateFormat', 'yy-mm-dd')
				->setValue($today);
		
		$from_time = new Zenfox_JQuery_Form_Element_TimePicker('from_time');
        $from_time->setLabel($this->getView()->translate('Time'))
				->setRequired(true);
		
		$end_date = new ZendX_JQuery_Form_Element_DatePicker('end_date');
		$end_date->setLabel($this->getView()->translate('To Date'))
				->setRequired(true)
				->setJQueryParam('dateFormat', 'yy-mm-dd')
				->setValue($today);
		
		$to_time = new Zenfox_JQuery_Form_Element_TimePicker('to_time');
        $to_time->setLabel($this->getView()->translate('Time'))
        		->setRequired(true);
        			
        $items_per_page = $this->createElement('select', 'items_per_page');
        $items_per_page->setLabel($this->getView()->translate('Results Per Page'))
        			->addMultiOptions(array(
        					'10' => $this->getView()->translate('10'),
        					'20' => $this->getView()->translate('20'),
        					'30' => $this->getView()->translate('30'),
        					'40' => $this->getView()->translate('40'),
        					'50' => $this->getView()->translate('50')));
		
		$view = $this->createElement('submit', 'view');
		$view->setLabel($this->getView()->translate('View Tickets'));
		
		$this->addElements(array(
					$start_date,
					$from_time,
					$end_date,
					$to_time,
					$ticket_status,
					$items_per_page,
					$view));
					
		$today = new Zend_Date();
		$datetime = $today->get(Zend_Date::W3C);
		$arr = explode('T',$datetime);
			$date = $arr[0];
		$this->end_date->setValue($date);
		$this->setAttrib('id', 'admin-dropdown-menu-form');
	}
}