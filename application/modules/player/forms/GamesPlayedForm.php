<?php

class Player_GamesPlayedForm extends Zend_Form
{
	public function getform()
	{
		$date = new Zend_Date();
		$today = $date->get('YYYY-MM-dd');
		
		$from_date = new ZendX_JQuery_Form_Element_DatePicker('from_date');
		$from_date->setLabel($this->getView()->translate('From Date'))
				->setRequired(true)
				->setJQueryParam('dateFormat', 'yy-mm-dd')
				->setJQueryParam('changeMonth',true)
				->setJQueryParam('changeYear',true)
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
    			->setJQueryParam('yearRange','2000:' . (Zend_Date::now()->get(Zend_Date::YEAR)))
				->setValue($today)
				->setAttrib('class', 'text');
		
		$to_time = new Zenfox_JQuery_Form_Element_TimePicker('to_time');
        $to_time->setLabel($this->getView()->translate('Time'))
        		->setRequired(true)
        		->setAttrib('class', 'text');
        
        $flavour = $this->createElement('multiCheckbox', 'flavour');
        $flavour->setLabel($this->getView()->translate('Game Flavour'))
        ->addMultiOption('BestOfThreeRummy', $this->getView()->translate('BESTOFTHREE'))
        ->addMultiOption('Indian_Rummy', $this->getView()->translate('SYNDICATE'))
        ->addMultiOption('MPPRummy', $this->getView()->translate('STAKE'))
        ->addMultiOption('TournamentRummy', $this->getView()->translate('TOURNAMENT'))
        ->setValue(array('BestOfThreeRummy', 'Indian_Rummy', 'MPPRummy', 'TournamentRummy'))
        ->setSeparator('');
        
        $Counttype = $this->createElement('radio', 'counttype');
        $Counttype->setLabel($this->getView()->translate('Count Type'))
        ->addMultiOption('game', $this->getView()->translate('GAMES COUNT'))
        ->addMultiOption('Session', $this->getView()->translate('SESSIONS COUNT'))
        ->setValue(array('game'))
        ->setSeparator('');
			
		$submit = $this->createElement('submit', 'submit');
		$submit->setLabel($this->getView()->translate('Submit'))
				->setIgnore(true);
			
		$this->addElements(array(
				$from_date,
				$from_time,
				$to_date,
				$to_time,$flavour,$Counttype,
				$submit));
				
		$this->setAttrib('id', 'player-gamesplayed-form');
		$this->setMethod('post');
		
		$decorator = new Zenfox_DecoratorForm();
		$from_date->setDecorators($decorator->openingJqueryUlTagDecorator);
		$from_time->setDecorators($decorator->openingJqueryUlTagDecorator);
		$to_date->setDecorators($decorator->openingJqueryUlTagDecorator);
		$to_time->setDecorators($decorator->openingJqueryUlTagDecorator);
		$flavour->setDecorators($decorator->checkBoxDecorator);
		$Counttype->setDecorators($decorator->checkBoxDecorator);
		$submit->setDecorators($decorator->changeUlButtonTagDecorator);
		
		return $this;
		
	}
}