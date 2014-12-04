<?php
class Admin_LoginBonusForm extends Zend_Form
{
	public function getform($formData = NULL)
	{
		$status = $this->createElement('select', 'status');
				$status->setLabel('Status')
				->addMultiOptions(array(
						'ENABLED' => 'ENABLED',
						'DISABLED' => 'DISABLED'
				));
		
		if($formData->status)
		{
			$status->setValue($formData->status);
		}
		$this->addElement($status);
		
		/*
		$frontendobj = new Frontend();
		$allfrontends = $frontendobj->getFrontends();
		
		$frontends = $this->createElement('radio', 'frontend_id');
				$frontends->setLabel('Frontends');
	 	foreach($allfrontends as $frontenddata)
        {
        	 $frontends->addMultiOption($frontenddata["id"],$frontenddata["name"]);
        }
        
		if($formData->frontend_id)
		{
			$frontends->setValue($formData->frontend_id);
		}
		
		$this->addElement($frontends);
		*/
		
		$bonustype = $this->createElement('select', 'bonustype');
				$bonustype->setLabel('Bonus Type')
				->addMultiOptions(array(
						'BONUS' => 'BONUS',
						'REAL' => 'REAL'
				));
				
		if($formData->bonustype)
		{
			$bonustype->setValue($formData->bonustype);
		}
		$this->addElement($bonustype);
		
		$amount = $this->createElement('text','amount');
				$amount->setLabel($this->getView()->translate('Amount'));
				
		if($formData->amount)
		{
			$amount->setValue($formData->amount);
		}
		$this->addElement($amount);
		
			
     	/*$no_of_days = $this->createElement('text','no_of_days');
				$no_of_days->setLabel($this->getView()->translate('no of Days'));
				
		if($formData->no_of_days)
		{
			$no_of_days->setValue($formData->no_of_days);
		}
		$this->addElement($no_of_days);
				
		$from_date =new ZendX_JQuery_Form_Element_DatePicker('from_date',
		 		array('jQueryParams' => array('dateFormat' => 'yy-mm-dd')));
		 $from_date->setLabel('Start Date')
		 ->setRequired(true);
				
		if($formData->from_date)
		{
			$from_date->setValue($formData->from_date);
		}
		
		$this->addElements(array(
        		$from_date,
        	));
		*/
		$note = $this->createElement('textarea','note');
				$note->setLabel($this->getView()->translate('note'));
				
		if($formData->note)
		{
			$note->setValue($formData->note);
		}
		$this->addElement($note);
        
		$submit = $this->createElement('submit','submit');
				$submit->setLabel($this->getView()->translate('Submit'));
		$this->addElement($submit);
		
		return $this;
        
	}
}