<?php
/**
 * This class sets and creates new roulette configuration form
 * @author by Nikhil Gupta
 * @date January 2, 2010
 */
class Admin_KenoForm extends Zend_Form
{
	/*
	 * Set the roulette data in roulette configuration form
	 */
	
	public function getForm()
	{
		//Zend_Dojo::enableForm($this);
		
		$keno = new Zend_Form_SubForm();
		Zend_Dojo::enableForm($keno);
		
		$keno1 = new Keno();
		$machineDetails = $keno1->getMachineDetails();
		
		$machineId = $keno->createElement('select', 'machineId');
		$machineId->setLabel($keno->getView()->translate('Select Keno Machine *'))
				->setRequired(true);
		foreach($machineDetails as $machine)
		{
			$machineId->addMultiOption($machine['machine_id'], $machine['machine_name']);
		}
		
		$machineName = $keno->createElement('text', 'machineName');
		$machineName->setLabel($keno->getView()->translate('Running Machine Name *'))
					->setRequired(true);
		
		/*$flavour = new Flavour();
		$flavourData = $flavour->getFlavourData();*/
		$gameFlavour = $keno->createElement('text', 'gameFlavour');
		$gameFlavour->setLabel($keno->getView()->translate('Game Flavour'))
					->setRequired(true);
		/*foreach($flavourData as $flavour)
		{
			$gameFlavour->addMultiOption($flavour['game_flavour'], $flavour['game_flavour']);
		}*/
		
		$keno->addElements(array($machineId,
					$machineName));
		
		$keno->addElement(
					'SimpleTextarea',
					'description',
					array(
						'label' => $keno->getView()->translate('Description *'),
						'style' => 'width: 30em; height: 5em;'));
					
		/*$description = $this->createElement('SimpleTextarea','description');
		$description->setLabel($this->getView()->translate('Description'));
		$description->setStyle('width: 30em; height: 5em;');*/
		
		$denominations = $keno->createElement('multiCheckbox', 'denominations');
		$denominations->setLabel($keno->getView()->translate('Denominations *'))
					   ->setRequired(true)
					   ->addMultiOption('1','1')
					   ->addMultiOption('2','2')
					   ->addMultiOption('4','4')
					   ->addMultiOption('3','3')
					   ->addMultiOption('5','5');
		
		$defaultDenomination = $keno->createElement('text', 'defaultDenomination');
		$defaultDenomination->setLabel($keno->getView()->translate('Default Denomination *'))
							->setRequired(true);
					
		$minBet = $keno->createElement('text', 'minBet');
		$minBet->setLabel($keno->getView()->translate('Min Bet *'))
				->setRequired(true);
		
		$minNums = $keno->createElement('text', 'minNums');
		$minNums->setLabel($keno->getView()->translate('Min Nums *'));
		$minNums->addValidator('Digits')
				->setRequired(true);
		
		$maxBet = $keno->createElement('text', 'maxBet');
		$maxBet->setLabel($keno->getView()->translate('Max Bet *'))
				->setRequired(true);
		
		$maxNums = $keno->createElement('text', 'maxNums');
		$maxNums->setLabel($keno->getView()->translate('Max Nums *'));
		$maxNums->addValidator('Digits')
				->setRequired(true);
				
		$minCoins = $keno->createElement('text', 'minCoins');
		$minCoins->setLabel($keno->getView()->translate('Min Coins *'))
				 ->addValidator('Digits')
				->setRequired(true);
				
		$maxCoins = $keno->createElement('text', 'maxCoins');
		$maxCoins->setLabel($keno->getView()->translate('Max Coins *'))
				 ->addValidator('Digits')
				->setRequired(true);
		
		
		$enabled = $keno->createElement('select', 'enabled');
		$enabled->setLabel($keno->getView()->translate('Machine Enabled'))
				->setRequired(true)
				->addMultiOption('ENABLED','ENABLED')
				->addMultiOption('DISABLED','DISABLED');
				
		$pjpEnabled = $keno->createElement('select', 'pjpEnabled');
		$pjpEnabled->setLabel($keno->getView()->translate('Pjp Enabled'))
					->setRequired(true)
					->addMultiOption('ENABLED','ENABLED')
					->addMultiOption('DISABLED','DISABLED');
		
		
        $amountType = $keno->createElement('radio', 'amountType');
        $amountType->setLabel($keno->getView()->translate('Amount Type *'))
        			->addMultiOption('REAL', $keno->getView()->translate('Real'))
        			->addMultiOption('BONUS', $keno->getView()->translate('Bonus'))
        			->addMultiOption('BOTH', $keno->getView()->translate('Both'))
        			->setRequired(true);
        			
        $allowedPjps = $keno->createElement('multiCheckbox', 'allowedPjps');
        $allowedPjps->setLabel('Allowed Pjps *');
        
        $pjp = new Pjp();
        $pjpItems = $pjp->getPjpDetails();
        
        foreach($pjpItems as $pjpItem)
        {
        	$allowedPjps->addMultiOption($pjpItem['id'],$pjpItem['pjp_name']);
        }
        			
       /* $submit = $keno->createElement('submit', 'submit');
        $submit->setLabel($keno->getView()->translate('Submit'))
        		->setIgnore(true);*/
        			
        $keno->addElements(array(
					//$gameFlavour,
					$denominations,
					$defaultDenomination,
					$amountType,
					$minBet,
					$minNums,
        			$maxBet,
        			$maxNums,
        			$minCoins,
        			$maxCoins,
        			$enabled,
        			$pjpEnabled,
        			$allowedPjps,
        			));
        			
        $keno->setMethod('post');
        
        $keno->setAttrib('id', 'admin-keno-form');
        			
        return $keno;
	}
	
	/*public function setForm($kenoData)
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
		
					
		$description = $this->createElement('SimpleTextarea','description');
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
	}*/
	
	public function setForm($form, $kenoData)
	{
		if(is_string($kenoData['denominations']))
		{
			$denoms = explode(",",$kenoData['denominations']);
		}
		else
		{
			$denoms = $kenoData['denominations'];
		}
		$form->machineName->setValue($kenoData['machineName']);
		//$form->gameFlavour->setValue($kenoData['gameFlavour']);	
		$form->description->setValue($kenoData['description']);
		$form->denominations->setValue($denoms);
		$form->defaultDenomination->setValue($kenoData['defaultDenomination']);
		$form->amountType->setValue($kenoData['amountType']);
		$form->minBet->setValue($kenoData['minBet']);
		$form->minNums->setValue($kenoData['minNums']);
		$form->maxBet->setValue($kenoData['maxBet']);
		$form->maxNums->setValue($kenoData['maxNums']);
		$form->enabled->setValue($kenoData['enabled']);
		$form->machineId->setValue($kenoData['machineId']);
		$form->pjpEnabled->setValue($kenoData['pjpEnabled']);
		$form->allowedPjps->setValue($kenoData['allowedPjps']);
		$form->minCoins->setValue($kenoData['minCoins']);
		$form->maxCoins->setValue($kenoData['maxCoins']);
		
		return $form;
	}
	
	/*public function addPjpElement($keno)
	{
		$allowedPjps = $keno->createElement('multiCheckbox', 'allowedPjps');
        $allowedPjps->setLabel('Allowed Pjps');
        
        $pjp = new Pjp();
        $pjpItems = $pjp->getAllPjps();
        
        foreach($pjpItems as $pjpItem)
        {
        	$allowedPjps->addMultiOption($pjpItem['id'],$pjpItem['pjp_name']);
        }
        $keno->addElement($allowedPjps);
        return $keno;
	}*/
	
}