<?php
class Player_DateSelectionForm extends Zend_Form
{
	public function init()
	{
		$frontend = Zend_Controller_Front::getInstance();
		$controllerName = $frontend->getRequest()->getControllerName();
		if($controllerName == 'gamelog')
		{
			$type = $this->createElement('radio', 'type');
			$type->setLabel('Select Game')
				->addMultiOptions(array(
					'bingo' => 'Bingo',
					'slot' => 'Slots',
					'roulette' => 'Roulette',
					'keno' => 'Keno'))
				->setValue('keno')
				->setAttrib('id', 'gamelog-type')
				->setOptions(array('onclick' => 'submitGamelog()'));
			$this->addElement($type);
		}
		$date = new Zend_Date();
		$today = $date->get('YYYY-MM-dd');
		
		$from_date = new ZendX_JQuery_Form_Element_DatePicker('from_date');
		$from_date->setLabel($this->getView()->translate('From Date'))
				->setRequired(true)
				->setJQueryParam('dateFormat', 'yy-mm-dd')
				->setJQueryParam('changeMonth',true)
				->setJQueryParam('changeYear',true)
				//TODO:: Replace 18 with frontend specific age limit :-)
				->setJQueryParam('yearRange','2000:' . (Zend_Date::now()->get(Zend_Date::YEAR)))
				->setValue($today)
				->setAttrib('class', 'text');
				
		$from_time = new Zenfox_JQuery_Form_Element_TimePicker('from_time');
		$from_time->setLabel($this->getView()->translate('Time'))
				->setValue("00:00")
				->setRequired(true)
				->setAttrib('class', 'text');
		
        $to_date = new ZendX_JQuery_Form_Element_DatePicker('to_date');
		$to_date->setLabel($this->getView()->translate('To Date'))
				->setRequired(true)
				->setJQueryParam('dateFormat', 'yy-mm-dd')
				->setJQueryParam('changeMonth',true)
				->setJQueryParam('changeYear',true)
				//TODO:: Replace 18 with frontend specific age limit :-)
				->setJQueryParam('yearRange','2000:' . (Zend_Date::now()->get(Zend_Date::YEAR)))
				->setValue($today)
				->setAttrib('class', 'text');
		
		$to_time = new Zenfox_JQuery_Form_Element_TimePicker('to_time');
        $to_time->setLabel($this->getView()->translate('Time'))
        		->setRequired(true)
        		->setAttrib('class', 'text');
		
		$page = $this->createElement('select', 'page');
		$page->setLabel($this->getView()->translate('Result per page'))
			->addMultiOptions(array(
				'10' => $this->getView()->translate('10'),
				'20' => $this->getView()->translate('20'),
				'30' => $this->getView()->translate('30'),
				'40' => $this->getView()->translate('40'),
				'50' => $this->getView()->translate('50')));
			
		$submit = $this->createElement('submit', 'submit');
		$submit->setLabel($this->getView()->translate('Submit'))
				->setIgnore(true);
			
		$this->addElements(array(
				$from_date,
				$from_time,
				$to_date,
				$to_time,
				$page,
				$submit));
				
		$this->setAttrib('id', 'player-date-selection-form');
		$this->setAttrib('name', 'player-date-form');
		
		$decorator = new Zenfox_DecoratorForm();
		$from_date->setDecorators($decorator->openingJqueryUlTagDecorator);
		$from_time->setDecorators($decorator->formJQueryElements);
		$to_date->setDecorators($decorator->formJQueryElements);
		$to_time->setDecorators($decorator->formJQueryElements);
		$page->setDecorators($decorator->changeUlTagDecorator);
		$submit->setDecorators($decorator->closingUlButtonTagDecorator);
	}
}