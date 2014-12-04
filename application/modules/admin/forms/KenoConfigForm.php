<?php
/**
 * This class sets and creates new roulette configuration form
 * @author by Nikhil Gupta
 * @date January 2, 2010
 */
class Admin_KenoConfigForm extends Zend_Form_SubForm
{
	public function init()
	{
		
	}
	
	/*
	 * Set the roulette data in roulette configuration form
	 */
	public function setKenoForm($kenoData)
	{
		Zend_Dojo::enableForm($this);
		
		$id = $this->createElement('text', 'id');
		$id->setLabel($this->getView()->translate('ID'))
			->setValue($kenoData['runningKenoId'])
			->addValidator(new Zenfox_Validate_ModifyValidator($kenoData['runningKenoId']));
		
		$machineName = $this->createElement('text', 'machineName');
		$machineName->setLabel($this->getView()->translate('Machine Name'))
					->setValue($kenoData['machineName']);
		
		$flavour = new Flavour();
		$flavourData = $flavour->getFlavourData();
		$gameFlavour = $this->createElement('select', 'gameFlavour');
		$gameFlavour->setLabel($this->getView()->translate('Game Flavour'));
		foreach($flavourData as $flavour)
		{
			$gameFlavour->addMultiOption($flavour['game_flavour'], $flavour['game_flavour']);
		}
		$gameFlavour->setValue($kenoData['flavour']);
		
		/*$this->addElement(
					'SimpleTextarea',
					'description',
					array(
						'label' => $this->getView()->translate('Description'),
						'value' => $kenoData['description'],
						'style' => 'width: 30em; height: 5em;'));*/
					
		$description = $this->addElement('SimpleTextarea','description');
		$description->setLabel($this->getView()->translate('Description'));
		$description->setStyle('width: 30em; height: 5em;');
		$description->setValue($kenoData['description']);
		
		$denominations = $this->createElement('text', 'denominations');
		$denominations->setLabel($this->getView()->translate('Denominations'));
		$denominations->setValue($kenoData['denominations']);
		
		$defaultDenomination = $this->createElement('text', 'defaultDenomination');
		$defaultDenomination->setLabel($this->getView()->translate('Default Denomination'));
		$defaultDenomination->setValue($kenoData['defaultDenomination']);
					
		$maxBet = $this->createElement('text', 'maxBet');
		$maxBet->setLabel($this->getView()->translate('Maximum Bet'))
				->setValue($kenoData['maxBet']);
				
		$minBet = $this->createElement('text', 'minBet');
		$minBet->setLabel($this->getView()->translate('Minimum Bet'))
				->setValue($kenoData['minBet']);
				
		$minNums = $this->createElement('text', 'minNums');
		$minNums->setLabel($this->getView()->translate('Minimum Nums'))
				->setValue($kenoData['minNums']);
				
		$maxNums = $this->createElement('text', 'maxNums');
		$maxNums->setLabel($this->getView()->translate('Maximum Nums'))
				->setValue($kenoData['maxNums']);
				
		$enabled = $this->createElement('checkbox', 'enabled');
		$enabled->setLabel($this->getView()->translate('Enabled'))
				->setValue($kenoData['enabled']);
				
		$keno = new Keno();
		$machineDetails = $keno->getMachineDetails();
		$machineId = $this->createElement('select', 'machineId');
		$machineId->setLabel($this->getView()->translate('Machine Id'))
				->setValue($kenoData['machineId'])
				->addValidator('Digits');
		foreach($machineDetails as $machine)
		{
			$machineId->addMultiOption($machine['machine_id'], $machine['machine_id']);
		}
				
		$pjpEnabled = $this->createElement('checkbox', 'pjpEnabled');
		$pjpEnabled->setLabel($this->getView()->translate('Pjp Enabled'))
					->setValue($kenoData['pjpEnabled']);
		
		
        $amountType = $this->createElement('radio', 'amountType');
        $amountType->setLabel($this->getView()->translate('Amount Type'))
        			->addMultiOption('REAL', $this->getView()->translate('Real'))
        			->addMultiOption('BONUS', $this->getView()->translate('Bonus'))
        			->addMultiOption('BOTH', $this->getView()->translate('Both'))
        			->setValue($kenoData['amountType']);
        			
        $submit = $this->createElement('submit', 'submit');
        $submit->setLabel($this->getView()->translate('Submit'))
        		->setIgnore(true);
        			
        $this->addElements(array(
        			$id,
        			$machineName,
        			$flavour,
        			$description,
        			$denominations,
        			$defaultDenomination,
        			$amountType,
        			$minBet,
        			$minNums,
        			$maxBet,
        			$maxNums,
        			$enabled,
        			$machineId,
        			$pjpEnabled,
        			$submit));
        			
        return $this;
	}
	
	/*
	 * Get new roulette configuration form
	 */
	public function getKenoForm()
	{
		Zend_Dojo::enableForm($this);
		
		$machineName = $this->createElement('text', 'machineName');
		$machineName->setLabel($this->getView()->translate('Machine Name'));
		
		$flavour = new Flavour();
		$flavourData = $flavour->getFlavourData();
		$gameFlavour = $this->createElement('select', 'gameFlavour');
		$gameFlavour->setLabel($this->getView()->translate('Game Flavour'));
		foreach($flavourData as $flavour)
		{
			$gameFlavour->addMultiOption($flavour['game_flavour'], $flavour['game_flavour']);
		}
		
		$this->addElements(array(
					$machineName,
					$gameFlavour));
		
		/*$this->addElement(
					'SimpleTextarea',
					'description',
					array(
						'label' => $this->getView()->translate('Description'),
						'style' => 'width: 30em; height: 5em;'));*/
					
		$description = $this->addElement('SimpleTextarea','description');
		$description->setLabel($this->getView()->translate('Description'));
		$description->setStyle('width: 30em; height: 5em;');
		
		$denominations = $this->createElement('text', 'denominations');
		$denominations->setLabel($this->getView()->translate('Denominations'));
		
		$defaultDenomination = $this->createElement('text', 'defaultDenomination');
		$defaultDenomination->setLabel($this->getView()->translate('Default Denomination'));
					
		$minBet = $this->createElement('text', 'minBet');
		$minBet->setLabel($this->getView()->translate('Minimum Bet'));
		
		$minNums = $this->createElement('text', 'minNums');
		$minNums->setLabel($this->getView()->translate('Minimum Nums'));
		$minNums->addValidator('Digits');
		
		$maxBet = $this->createElement('text', 'maxBet');
		$maxBet->setLabel($this->getView()->translate('Maximum Bet'));
		
		$maxNums = $this->createElement('text', 'maxNums');
		$maxNums->setLabel($this->getView()->translate('Maximum Nums'));
		$maxNums->addValidator('Digits');
		
		$enabled = $this->createElement('checkbox', 'enabled');
		$enabled->setLabel($this->getView()->translate('Enabled'));
		
		$keno = new Keno();
		$machineDetails = $keno->getMachineDetails();
		$machineId = $this->createElement('select', 'machineId');
		$machineId->setLabel($this->getView()->translate('Machine Id'))
				->addValidator('Digits');
		foreach($machineDetails as $machine)
		{
			$machineId->addMultiOption($machine['machine_id'], $machine['machine_id']);
		}
				
		$pjpEnabled = $this->createElement('checkbox', 'pjpEnabled');
		$pjpEnabled->setLabel($this->getView()->translate('Pjp Enabled'));
		
		
        $amountType = $this->createElement('radio', 'amountType');
        $amountType->setLabel($this->getView()->translate('Amount Type'))
        			->addMultiOption('REAL', $this->getView()->translate('Real'))
        			->addMultiOption('BONUS', $this->getView()->translate('Bonus'))
        			->addMultiOption('BOTH', $this->getView()->translate('Both'));
        			
        $submit = $this->createElement('submit', 'submit');
        $submit->setLabel($this->getView()->translate('Submit'))
        		->setIgnore(true);
        			
        $this->addElements(array(
        			$machineName,
					$gameFlavour,
					$description,
					$denominations,
					$defaultDenomination,
					$amountType,
					$minBet,
					$minNums,
        			$maxBet,
        			$maxNums,
        			$enabled,
        			$machineId,
        			$pjpEnabled,
        			$submit));
        			
        return $this;
	}
}