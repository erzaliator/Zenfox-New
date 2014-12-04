<?php
/**
 * This class sets and creates new roulette configuration form
 * @author by Nikhil Gupta
 * @date January 2, 2010
 */
class Admin_RouletteconfigForm extends Zend_Form_SubForm
{
	public function init()
	{
		
	}
	
	/*
	 * Set the roulette data in roulette configuration form
	 */
	public function setRouletteForm($rouletteData)
	{
		Zend_Dojo::enableForm($this);
		
		$id = $this->createElement('hidden', 'id');
		$id->setValue($rouletteData['runningRouletteId']);
//			->setLabel($this->getView()->translate('ID'))
//			->addValidator(new Zenfox_Validate_ModifyValidator($rouletteData['runningRouletteId']));
		$this->addElement($id);
		
		$machineName = $this->createElement('text', 'machineName');
		$machineName->setLabel($this->getView()->translate('Running Roulette Machine Name *'))
					->setValue($rouletteData['machineName'])
					->setRequired(true);
		$this->addElement($machineName);
		
		$this->addElement(
					'SimpleTextarea',
					'description',
					array(
						'label' => $this->getView()->translate('Description'),
						'value' => $rouletteData['description'],
						'style' => 'width: 30em; height: 5em;'));
					
		$maxBet = $this->createElement('text', 'maxBet');
		$maxBet->setLabel($this->getView()->translate('Maximum Bet'))
				->setValue($rouletteData['maxBet']);
				
		$maxBetString = $this->createElement('text', 'maxBetString');
		$maxBetString->setLabel($this->getView()->translate('Maximum Bet String'))
					->setValue($rouletteData['maxBetString']);
		
		$enabled = $this->createElement('checkbox', 'enabled');
		$enabled->setLabel($this->getView()->translate('Enabled'))
				->setValue($rouletteData['enabled'])
				->setCheckedValue('ENABLED')
				->setUncheckedValue('DISABLED');
		if($rouletteData['enabled'] == 'ENABLED')
		{
			$enabled->setValue('ENABLED');
		};
				
		$roulette = new Roulette();
		$machineDetails = $roulette->getMachineDetails();
		$machineId = $this->createElement('select', 'machineId');
		$machineId->setLabel($this->getView()->translate('Roulette Machine Name'))
				->setValue($rouletteData['machineId'])
				->addValidator('Digits');
		foreach($machineDetails as $machine)
		{
			$machineId->addMultiOption($machine['machine_id'], $machine['machine_name']);
		}
		
		$pjpEnabled = $this->createElement('checkbox', 'pjpEnabled');
		$pjpEnabled->setLabel($this->getView()->translate('Pjp Enabled'))
					->setCheckedValue('ENABLED')
					->setUncheckedValue('DISABLED');
		if($rouletteData['pjpEnabled'] == 'ENABLED')
		{
			$pjpEnabled->setValue('ENABLED');
		}
				
        $amountType = $this->createElement('radio', 'amountType');
        $amountType->setLabel($this->getView()->translate('Amount Type'))
        			->addMultiOption('REAL', $this->getView()->translate('Real'))
        			->addMultiOption('BONUS', $this->getView()->translate('Bonus'))
        			->addMultiOption('BOTH', $this->getView()->translate('Both'))
        			->setValue($rouletteData['amountType']);
        			
        $submit = $this->createElement('submit', 'submit');
        $submit->setLabel($this->getView()->translate('Submit'))
        		->setIgnore(true);
        			
        $this->addElements(array(
        			$maxBet,
        			$maxBetString,
        			$enabled,
        			$machineId,
        			$pjpEnabled,
        			$amountType,
        			$submit));
        			
        $this->setAttrib('id', 'admin-rouletteconfig-form');
	}
	
	/*
	 * Get new roulette configuration form
	 */
	public function getRouletteForm()
	{
		Zend_Dojo::enableForm($this);
		
		$machineName = $this->createElement('text', 'machineName');
		$machineName->setLabel($this->getView()->translate('Running Roulette Machine Name *'))
					->setRequired(true);
		
		/*$flavour = new Flavour();
		$flavourData = $flavour->getFlavourData();
		$gameFlavour = $this->createElement('select', 'gameFlavour');
		$gameFlavour->setLabel($this->getView()->translate('Game Flavour'));
		foreach($flavourData as $flavour)
		{
			$gameFlavour->addMultiOption($flavour['game_flavour'], $flavour['game_flavour']);
		}*/
		
		$this->addElements(array(
					$machineName));
					//$gameFlavour));
		
		$this->addElement(
					'SimpleTextarea',
					'description',
					array(
						'label' => $this->getView()->translate('Description'),
						'style' => 'width: 30em; height: 5em;'));
					
		$maxBet = $this->createElement('text', 'maxBet');
		$maxBet->setLabel($this->getView()->translate('Maximum Bet'));
				
		$maxBetString = $this->createElement('text', 'maxBetString');
		$maxBetString->setLabel($this->getView()->translate('Maximum Bet String'));
		
		$enabled = $this->createElement('checkbox', 'enabled');
		$enabled->setLabel($this->getView()->translate('Enabled'))
				->setCheckedValue('ENABLED')
				->setUncheckedValue('DISABLED');
		
		$roulette = new Roulette();
		$machineDetails = $roulette->getMachineDetails();
		$machineId = $this->createElement('select', 'machineId');
		$machineId->setLabel($this->getView()->translate('Roulette Machine Name'))
				->addValidator('Digits');
		foreach($machineDetails as $machine)
		{
			$machineId->addMultiOption($machine['machine_id'], $machine['machine_name']);
		}
				
		$pjpEnabled = $this->createElement('checkbox', 'pjpEnabled');
		$pjpEnabled->setLabel($this->getView()->translate('Pjp Enabled'))
					->setCheckedValue('ENABLED')
					->setUncheckedValue('DISABLED');
		
        $amountType = $this->createElement('radio', 'amountType');
        $amountType->setLabel($this->getView()->translate('Amount Type'))
        			->addMultiOption('REAL', $this->getView()->translate('Real'))
        			->addMultiOption('BONUS', $this->getView()->translate('Bonus'))
        			->addMultiOption('BOTH', $this->getView()->translate('Both'));
        			
        $submit = $this->createElement('submit', 'submit');
        $submit->setLabel($this->getView()->translate('Submit'))
        		->setIgnore(true);
        			
        $this->addElements(array(
        			$maxBet,
        			$maxBetString,
        			$enabled,
        			$machineId,
        			$pjpEnabled,
        			$amountType,
        			$submit
        			));
        			
        $this->setAttrib('id', 'admin-rouletteconfig-form');
	}
}