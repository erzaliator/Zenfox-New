<?php
class Admin_RouletteForm extends Zend_Form_SubForm
{
	public function getForm()
	{
		$rouletteForm = new Zend_Form_SubForm();
		Zend_Dojo::enableForm($rouletteForm);
		
		$roulette = new Roulette();
		$machineDetails = $roulette->getMachineDetails();
		$machineId = $rouletteForm->createElement('select', 'machineId');
		$machineId->setLabel($this->getView()->translate('Roulette Machine Name'))
				->addValidator('Digits');
		foreach($machineDetails as $machine)
		{
			$machineId->addMultiOption($machine['machine_id'], $machine['machine_name']);
		}
		$rouletteForm->addElement($machineId);
		
		$machineName = $rouletteForm->createElement('text', 'machineName');
		$machineName->setLabel($this->getView()->translate('Running Roulette Machine Name *'))
					->setRequired(true);
		
		$rouletteForm->addElement($machineName);
		
		$rouletteForm->addElement(
					'SimpleTextarea',
					'description',
					array(
						'label' => $this->getView()->translate('Description'),
						'style' => 'width: 30em; height: 5em;'));
		$denominations = $rouletteForm->createElement('multiCheckbox', 'denominations');
		$denominations->setLabel($rouletteForm->getView()->translate('Denominations *'))
					   ->setRequired(true)
					   ->addMultiOption('0.5','0.5')
					   ->addMultiOption('1','1')
					   ->addMultiOption('2.5','2.5')
					   ->addMultiOption('5','5')
					   ->addMultiOption('10','10');
		
		$defaultDenomination = $rouletteForm->createElement('text', 'defaultDenomination');
		$defaultDenomination->setLabel($rouletteForm->getView()->translate('Default Denomination *'))
							->setRequired(true);
					
		$maxBet = $rouletteForm->createElement('text', 'maxBet');
		$maxBet->setLabel($this->getView()->translate('Maximum Bet *'))
			   ->setRequired(true);
				
		$maxBetString = $rouletteForm->createElement('text', 'maxBetString');
		$maxBetString->setLabel($this->getView()->translate('Maximum Bet String *'))
					  ->setRequired(true);
					  
		$enabled = $rouletteForm->createElement('checkbox', 'enabled');
		$enabled->setLabel($this->getView()->translate('Machine Enabled'))
				->setCheckedValue('ENABLED')
				->setUncheckedValue('DISABLED');
		
		
	    /*$pjp =new Pjp();
		$pjpData = $pjp->getPjpDetails();
		$i=1;
		foreach ($pjpData as $pjpDetail){
	     $this->addElement(
					'checkbox', 'pjpId_'.$i,
					array(
						'label' => $this->getView()->translate('pjpId_'.$i. ' ' .$pjpDetail[description]),
						'style' => 'width: 30em; height: 5em;',
					    'value' => ''));
		 $i++;
		}*/
				
		/*$pjpEnabled = $this->createElement('checkbox', 'pjpEnabled');
		$pjpEnabled->setLabel($this->getView()->translate('Pjp Enabled'))
					->setCheckedValue('ENABLED')
					->setUncheckedValue('DISABLED');
		*/
		
        $amountType = $rouletteForm->createElement('radio', 'amountType');
        $amountType->setLabel($this->getView()->translate('Amount Type *'))
        			->addMultiOption('REAL', $this->getView()->translate('Real'))
        			->addMultiOption('BONUS', $this->getView()->translate('Bonus'))
        			->addMultiOption('BOTH', $this->getView()->translate('Both'))
        			->setRequired(true);
        			
        $pjpEnabled = $rouletteForm->createElement('checkbox', 'pjpEnabled');
		$pjpEnabled->setLabel($this->getView()->translate('Pjp Enabled'))
					->setCheckedValue('ENABLED')
					->setUncheckedValue('DISABLED');
		$allowedPjps = $rouletteForm->createElement('multiCheckbox', 'allowedPjps');
        $allowedPjps->setLabel('Allowed Pjps');
        
        $pjp = new Pjp();
        $pjpItems = $pjp->getPjpDetails();
        
        foreach($pjpItems as $pjpItem)
        {
        	$allowedPjps->addMultiOption($pjpItem['id'],$pjpItem['pjp_name']);
        }
        $rouletteForm->addElements(array(
                    $denominations,
                    $defaultDenomination,
        			$maxBet,
        			$maxBetString,
        			$enabled,
        			$pjpEnabled,
        			$allowedPjps,
        			$amountType
        			));
        			
        $rouletteForm->setAttrib('id', 'admin-rouletteconfig-form');
        return $rouletteForm;
	}
	
	public function setForm($form, $rouletteData)
	{
		
		$form->machineName->setValue($rouletteData['machineName']);
		$form->description->setValue($rouletteData['description']);
		$form->denominations->setValue($rouletteData['denominations']);
		$form->defaultDenomination->setValue($rouletteData['defaultDenomination']);
		$form->amountType->setValue($rouletteData['amountType']);
		$form->maxBet->setValue($rouletteData['maxBet']);
		$form->maxBetString->setValue($rouletteData['maxBetString']);
		$form->enabled->setValue($rouletteData['enabled']);
		$form->machineId->setValue($rouletteData['machineId']);
		$form->pjpEnabled->setValue($rouletteData['pjpEnabled']);
		$form->allowedPjps->setValue($rouletteData['allowedPjps']);
		
		return $form;
	}
}