<?php

class Admin_SlotConfigForm extends Zend_Form_SubForm
{
	public function setSlotForm($slotData)
	{		
		$id = $this->createElement('hidden', 'id');
		$id->setValue($slotData['runningSlotsId']);
		
		$slot = new Slot();
		$allSlotsDetails = $slot->getAllSlotsDetails();
		$machineId =$this->createElement('select', 'machineId');
		$machineId->setLabel('Slot Machine Name')
				->setValue($slotData['machineId']);
		foreach($allSlotsDetails as $slotDetail)
		{
			$machineId->addMultiOption($slotDetail['machine_id'], $slotDetail['machine_name']);
		}
		
		/*$flavour = new Flavour();
		$flavourData = $flavour->getFlavourData();
		$gameFlavour = $this->createElement('select', 'gameFlavour');
		$gameFlavour->setLabel('Game Flavour')
					->setValue($slotData['game_flavour']);
		foreach($flavourData as $flavour)
		{
			$gameFlavour->addMultiOption($flavour['game_flavour'], $flavour['game_flavour']);
		}*/
		
		$amountType = $this->createElement('radio', 'amountType');
        $amountType->setLabel($this->getView()->translate('Amount Type'))
        			->addMultiOption('REAL', $this->getView()->translate('Real'))
        			->addMultiOption('BONUS', $this->getView()->translate('Bonus'))
        			->addMultiOption('BOTH', $this->getView()->translate('Both'))
        			->setValue($slotData['amountType']);
        			
        $feature = $this->createElement('radio', 'feature');
        $feature->setLabel('Feature Enabled')
        		->addMultiOption('ENABLED', 'Enabled')
        		->addMultiOption('DISABLED', 'Disabled')
        		->setValue($slotData['featureEnabled']);
        		
		$bonusSpins = $this->createElement('checkbox', 'bonusSpins');
		$bonusSpins->setLabel($this->getView()->translate('Bonus Spins Enabled'))
					->setCheckedValue('ENABLED')
					->setUncheckedValue('DISABLED');
		if($slotData['bonusSpinsEnabled'] == 'ENABLED')
		{
			$bonusSpins->setValue('ENABLED');
		}
        			
        $denominationFactors = explode(',', $slotData['denomination']);
        $denomination = $this->createElement('multiCheckbox', 'denomination');
        $denomination->setLabel('Denomination')
        			->addMultiOptions(array(
        						'1' => '1',
        						'2' => '2',
        						'5' => '5'))
        			->setValue($denominationFactors);

        $defaultDenomination = $this->createElement('radio', 'defaultDenomination');
        $defaultDenomination->setLabel('Default Denomination')
        					->addMultiOptions(array(
        								'1' => '1',
        								'5' => '5'))
        					->setValue($slotData['defaultDenomination']);

        //TODO get currencies from currency table					
        $defaultCurrency = $this->createElement('select', 'defaultCurrency');
        $defaultCurrency->setLabel('Default Currency')
        				->addMultiOptions(array(
        								'US' => 'US',
        								'UK' => 'UK',
        								'IN' => 'India'))
        				->setValue($slotData['defaultCurrency']);
        				
		$pjpEnabled = $this->createElement('checkbox', 'pjpEnabled');
		$pjpEnabled->setLabel($this->getView()->translate('Pjp Enabled'))
					->setCheckedValue('ENABLED')
					->setUncheckedValue('DISABLED');
		if($slotData['pjpEnabled'] == 'ENABLED')
		{
			$pjpEnabled->setValue('ENABLED');
		}
        			
		$maxBet = $this->createElement('text', 'maxBet');
		$maxBet->setLabel('Maximum Bet')
				->addValidator('Digits')
				->setValue($slotData['maxBet']);
				
		$machineType = $this->createElement('text', 'machineType');
		$machineType->setLabel('Machine Type')
					->addValidator('Digits')
					->setValue($slotData['machineType']);
	
        $slot = new Slot();
        $slotDetail = $slot->getSlotDetails($slotData['machineId']);
        $maxBetLines = $this->createElement('select', 'maxBetLines');
        $maxBetLines->setLabel('Maximum Bet Lines')
        			->setValue($slotData['maxBetlines']);
        for($i = $slotDetail['min_lines']; $i <= $slotDetail['max_lines']; $i++)
        {
        	$maxBetLines->addMultiOption($i, $i);
        }

		$maxCoins = $this->createElement('select', 'maxCoins');
        $maxCoins->setLabel('Maximum Coins')
        			->setValue($slotData['maxCoins']);
        for($i = $slotDetail['min_coins']; $i <= $slotDetail['max_coins']; $i++)
        {
        	$maxCoins->addMultiOption($i, $i);
        }
        
		$minBetLines = $this->createElement('select', 'minBetLines');
        $minBetLines->setLabel('Minimum Bet Lines')
        			->setValue($slotData['minBetlines']);
        for($i = $slotDetail['min_lines']; $i <= $slotDetail['max_lines']; $i++)
        {
        	$minBetLines->addMultiOption($i, $i);
        }
        
		$minCoins = $this->createElement('select', 'minCoins');
        $minCoins->setLabel('Minimum Coins')
        			->setValue($slotData['minCoins']);
        for($i = $slotDetail['min_coins']; $i <= $slotDetail['max_coins']; $i++)
        {
        	$minCoins->addMultiOption($i, $i);
        }
        
		$enabled = $this->createElement('checkbox', 'enabled');
		$enabled->setLabel($this->getView()->translate('Enabled'))
					->setCheckedValue('ENABLED')
					->setUncheckedValue('DISABLED');
		if($slotData['enabled'] == 'ENABLED')
		{
			$enabled->setValue('ENABLED');
		}
        		
        $createdBy = $this->createElement('text', 'createdBy');
        $createdBy->setLabel('Created By')
        		->setValue($slotData['createdBy'])
        		->addValidator(new Zenfox_Validate_ModifyValidator($slotData['createdBy']));
        
		$createdTime = $this->createElement('text', 'createdTime');
		$createdTime->setLabel('Created Time')
					->setValue($slotData['createdTime'])
					->addValidator(new Zenfox_Validate_ModifyValidator($slotData['createdTime']));

		$lastUpdatedBy = $this->createElement('text', 'lastUpdatedBy');
        $lastUpdatedBy->setLabel('Last Updated By')
        		->setValue($slotData['lastUpdatedBy'])
        		->addValidator(new Zenfox_Validate_ModifyValidator($slotData['lastUpdatedBy'])); 
        		
        $lastUpdatedTime = $this->createElement('text', 'lastUpdatedTime');
		$lastUpdatedTime->setLabel('Last Updated Time')
					->setValue($slotData['lastUpdatedTime'])
					->addValidator(new Zenfox_Validate_ModifyValidator($slotData['lastUpdatedTime']));
        		
        $submit = $this->createElement('submit', 'submit');
        $submit->setLabel($this->getView()->translate('Submit'))
        		->setIgnore(true);
        			
        $this->addElements(array(
        			$id,
        			$machineId,
  //      			$gameFlavour,
        			$amountType,
        			$feature,
        			$bonusSpins,
        			$denomination,
        			$defaultDenomination,
        			$defaultCurrency,
        			$pjpEnabled,
        			$maxBet,
        			$machineType,
        			$maxBetLines,
        			$maxCoins,
        			$minBetLines,
        			$minCoins,
        			$enabled,
        			$createdBy,
        			$createdTime,
        			$lastUpdatedBy,
        			$lastUpdatedTime,
        			$submit));
        			
      	$this->setAttrib('id', 'admin-slot-config-form');
	}
	
	public function getSlotForm($machine_id)
	{
		Zend_Dojo::enableForm($this);
		
		$machineId = $this->createElement('hidden', 'machineId');
		$machineId->setValue($machine_id);
//				->setLabel('Slot Machine Name')
//				->addValidator(new Zenfox_Validate_ModifyValidator($machine_id));
		/*$flavour = new Flavour();
		$flavourData = $flavour->getFlavourData();
		$gameFlavour = $this->createElement('select', 'gameFlavour');
		$gameFlavour->setLabel($this->getView()->translate('Game Flavour'));
		foreach($flavourData as $flavour)
		{
			$gameFlavour->addMultiOption($flavour['game_flavour'], $flavour['game_flavour']);
		}*/
		
		$machineName = $this->createElement('text', 'machineName');
		$machineName->setLabel($this->getView()->translate('Running Slot Machine Name *'))
					->setRequired(true);
		
		$this->addElements(array(
					$machineName));
					//$gameFlavour));
		
		$this->addElement(
					'SimpleTextarea',
					'description',
					array(
						'label' => $this->getView()->translate('Description'),
						'style' => 'width: 30em; height: 5em;'));
		
		
		$amountType = $this->createElement('radio', 'amountType');
        $amountType->setLabel($this->getView()->translate('Amount Type'))
        			->addMultiOption('REAL', $this->getView()->translate('Real'))
        			->addMultiOption('BONUS', $this->getView()->translate('Bonus'))
        			->addMultiOption('BOTH', $this->getView()->translate('Both'));
        			
        $feature = $this->createElement('radio', 'feature');
        $feature->setLabel('Feature Enabled')
        		->addMultiOption('ENABLED', 'Enabled')
        		->addMultiOption('DISABLED', 'Disabled');
        		
        $bonusSpins = $this->createElement('checkbox', 'bonusSpins');
        $bonusSpins->setLabel('Bonus Spins Enabled')
        			->setCheckedValue('ENABLED')
					->setUncheckedValue('DISABLED');
        			
        $denomination = $this->createElement('multiCheckbox', 'denomination');
        $denomination->setLabel('Denomination')
        			->addMultiOptions(array(
        						'1' => '1',
        						'2' => '2',
        						'5' => '5'));

        $defaultDenomination = $this->createElement('radio', 'defaultDenomination');
        $defaultDenomination->setLabel('Default Denomination')
        					->addMultiOptions(array(
        								'1' => '1',
        								'5' => '5'));

        //TODO get currencies from currency table					
        $defaultCurrency = $this->createElement('select', 'defaultCurrency');
        $defaultCurrency->setLabel('Default Currency')
        				->addMultiOptions(array(
        								'US' => 'US',
        								'UK' => 'UK',
        								'IN' => 'Rupees'));
        				
        $pjpEnabled = $this->createElement('checkbox', 'pjpEnabled');
		$pjpEnabled->setLabel($this->getView()->translate('Pjp Enabled'))
					->setCheckedValue('ENABLED')
					->setUncheckedValue('DISABLED');
        			
		$maxBet = $this->createElement('text', 'maxBet');
		$maxBet->setLabel('Maximum Bet')
				->addValidator('Digits');
				
		$machineType = $this->createElement('text', 'machineType');
		$machineType->setLabel('Machine Type')
					->addValidator('Digits');
	
        $slot = new Slot();
        $slotDetail = $slot->getSlotDetails($machine_id);
        $maxBetLines = $this->createElement('select', 'maxBetLines');
        $maxBetLines->setLabel('Maximum Bet Lines');
        for($i = $slotDetail['min_lines']; $i <= $slotDetail['max_lines']; $i++)
        {
        	$maxBetLines->addMultiOption($i, $i);
        }

		$maxCoins = $this->createElement('select', 'maxCoins');
        $maxCoins->setLabel('Maximum Coins');
        for($i = $slotDetail['min_coins']; $i <= $slotDetail['max_coins']; $i++)
        {
        	$maxCoins->addMultiOption($i, $i);
        }
        
		$minBetLines = $this->createElement('select', 'minBetLines');
        $minBetLines->setLabel('Minimum Bet Lines');
        for($i = $slotDetail['min_lines']; $i <= $slotDetail['max_lines']; $i++)
        {
        	$minBetLines->addMultiOption($i, $i);
        }
        
		$minCoins = $this->createElement('select', 'minCoins');
        $minCoins->setLabel('Minimum Coins');
        for($i = $slotDetail['min_coins']; $i <= $slotDetail['max_coins']; $i++)
        {
        	$minCoins->addMultiOption($i, $i);
        }
        
        $enabled = $this->createElement('checkbox', 'enabled');
		$enabled->setLabel($this->getView()->translate('Enabled'))
					->setCheckedValue('ENABLED')
					->setUncheckedValue('DISABLED');
        		
        $submit = $this->createElement('submit', 'submit');
        $submit->setLabel($this->getView()->translate('Submit'))
        		->setIgnore(true);
        			
        $this->addElements(array(
        			$machineId,
//        			$gameFlavour,
        			$amountType,
        			$feature,
        			$bonusSpins,
        			$denomination,
        			$defaultDenomination,
        			$defaultCurrency,
        			$pjpEnabled,
        			$maxBet,
        			$machineType,
        			$maxBetLines,
        			$maxCoins,
        			$minBetLines,
        			$minCoins,
        			$enabled,
        			$submit));
		$this->setAttrib('id', 'adminSlotConfig');
	}
}