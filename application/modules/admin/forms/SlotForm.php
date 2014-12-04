<?php
class Admin_SlotForm extends Zend_Form_SubForm
{
	public function getForm()
	{
		$slotForm = new Zend_Form_SubForm();
		Zend_Dojo::enableForm($slotForm);
		
		$slot = new Slot();
		$machineDetails = $slot->getAllSlotsDetails();
		$machineId = $slotForm->createElement('select', 'machineId');
		$machineId->setLabel($slotForm->getView()->translate('Select Slot Machine *'))
				->addValidator('Digits');
		foreach($machineDetails as $machine)
		{
			$machineId->addMultiOption($machine['machine_id'], $machine['machine_name']);
		}
		$slotForm->addElement($machineId);
		
		/*$machineId = $this->createElement('hidden', 'machineId');
		$machineId->setValue($machine_id);*/
		
		$machineName = $slotForm->createElement('text', 'machineName');
		$machineName->setLabel($slotForm->getView()->translate('Running Slot Machine Name *'))
					->setRequired(true);
		
		$slotForm->addElement($machineName);
		
		$slotForm->addElement(
					'SimpleTextarea',
					'description',
					array(
						'label' => $slotForm->getView()->translate('Description'),
						'style' => 'width: 30em; height: 5em;'));
		$denominations = $slotForm->createElement('multiCheckbox', 'denomination');
		$denominations->setLabel($slotForm->getView()->translate('Denominations '))
					   ->setRequired(true)
					   ->addMultiOption('0.5','0.5')
					   ->addMultiOption('1','1')
					   ->addMultiOption('2.5','2.5')
					   ->addMultiOption('5','5')
					   ->addMultiOption('10','10');
		
		$defaultDenomination = $slotForm->createElement('text', 'defaultDenomination');
		$defaultDenomination->setLabel($slotForm->getView()->translate('Default Denomination '))
							->setRequired(true);
					
		$amountType = $slotForm->createElement('radio', 'amountType');
        $amountType->setLabel($slotForm->getView()->translate('Amount Type'))
        			->addMultiOption('REAL', $slotForm->getView()->translate('Real'))
        			->addMultiOption('BONUS', $slotForm->getView()->translate('Bonus'))
        			->addMultiOption('BOTH', $slotForm->getView()->translate('Both'));
        			
        $feature = $slotForm->createElement('radio', 'feature');
        $feature->setLabel('Feature Enabled')
        		->addMultiOption('ENABLED', 'Enabled')
        		->addMultiOption('DISABLED', 'Disabled');
        		
        $bonusSpins = $slotForm->createElement('checkbox', 'bonusSpins');
        $bonusSpins->setLabel('Bonus Spins Enabled')
        			->setCheckedValue('ENABLED')
					->setUncheckedValue('DISABLED');
        			
        //TODO get currencies from currency table					
        $defaultCurrency = $slotForm->createElement('select', 'defaultCurrency');
        $defaultCurrency->setLabel('Default Currency')
        				->addMultiOptions(array(
        								'EUR' => 'UK Euro',
        								'USD' => 'US Dollor',
        								'INR' => 'Rupees'));
        				
        $pjpEnabled = $slotForm->createElement('checkbox', 'pjpEnabled');
		$pjpEnabled->setLabel($slotForm->getView()->translate('Pjp Enabled'))
					->setCheckedValue('ENABLED')
					->setUncheckedValue('DISABLED');
        			
		$maxBet = $slotForm->createElement('text', 'maxBet');
		$maxBet->setLabel('Maximum Bet *')
				->addValidator('Digits')
				->setRequired(true);
				
		$machineType = $slotForm->createElement('text', 'machineType');
		$machineType->setLabel('Machine Type *')
					->addValidator('Digits')
					->setRequired(true);
	
        $maxBetLines = $slotForm->createElement('text', 'maxBetLines');
        $maxBetLines->setLabel('Maximum Bet Lines *')
                    ->setRequired(true);

		$maxCoins = $slotForm->createElement('text', 'maxCoins');
        $maxCoins->setLabel('Maximum Coins *')
                 ->setRequired(true);
        
		$minBetLines = $slotForm->createElement('text', 'minBetLines');
        $minBetLines->setLabel('Minimum Bet Lines *')
                    ->setRequired(true);
        
		$minCoins = $slotForm->createElement('text', 'minCoins');
        $minCoins->setLabel('Minimum Coins *')
                 ->setRequired(true);
        
        $enabled = $slotForm->createElement('checkbox', 'enabled');
		$enabled->setLabel($slotForm->getView()->translate('Machine Enabled'))
					->setCheckedValue('ENABLED')
					->setUncheckedValue('DISABLED');
		$allowedPjps = $slotForm->createElement('multiCheckbox', 'allowedPjps');
        $allowedPjps->setLabel('Allowed Pjps');
        
        $pjp = new Pjp();
        $pjpItems = $pjp->getPjpDetails();
        
        foreach($pjpItems as $pjpItem)
        {
        	$allowedPjps->addMultiOption($pjpItem['id'],$pjpItem['pjp_name']);
        }
        		
        $slotForm->addElements(array(
        			$amountType,
        			$feature,
        			$bonusSpins,
        			$denominations,
        			$defaultDenomination,
        			$defaultCurrency,
        			$enabled,
        			$pjpEnabled,
        			$allowedPjps,
        			$maxBet,
        			$machineType,
        			$minBetLines,
        			$maxBetLines,
        			$minCoins,
        			$maxCoins
        			));
		$slotForm->setAttrib('id', 'admin-slot-form');
        return $slotForm;
	}
	
	public function setForm($form, $slotData)
	{
		$form->machineId->setValue($slotData['machineId']);
		$form->machineName->setValue($slotData['machineName']);
		$form->description->setValue($slotData['description']);
		$form->denomination->setValue($slotData['denomination']);
		$form->defaultDenomination->setValue($slotData['defaultDenomination']);
		$form->amountType->setValue($slotData['amountType']);
		$form->feature->setValue($slotData['feature']);
		$form->bonusSpins->setValue($slotData['bonusSpins']);
		$form->defaultCurrency->setValue($slotData['defaultCurrency']);
		$form->pjpEnabled->setValue($slotData['pjpEnabled']);
		$form->maxBet->setValue($slotData['maxBet']);
		$form->machineType->setValue($slotData['machineType']);
		$form->maxBetLines->setValue($slotData['maxBetLines']);
		$form->maxCoins->setValue($slotData['maxCoins']);
		$form->minBetLines->setValue($slotData['minBetLines']);
		$form->minCoins->setValue($slotData['minCoins']);
		$form->enabled->setValue($slotData['enabled']);
		$form->allowedPjps->setValue($slotData['allowedPjps']);
		
		return $form;
	}
}