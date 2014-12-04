<?php
/**
 * This class is used to set and create new pjp form
 * @author Nikhil Gupta
 * @date January 2, 2010
 */
class Admin_PjpForm extends Zend_Form_SubForm
{
	/*
	 * This function sets the pjp data in pjp form
	 */
	public function setPjpForm($pjpData)
	{
		if($pjpData)
		{
			Zend_Dojo::enableForm($this);

			$checkBox = $this->createElement('checkbox', 'checkBox');
			$checkBox->setValue(true);
			
			$pjpId = $this->createElement('text', 'pjpId');
			$pjpId->setLabel($this->getView()->translate('Pjp Id'))
					->setValue($pjpData['pjp_id'])
					->addValidator(new Zenfox_Validate_ModifyValidator($pjpData['pjp_id']));
			
			$flavour = new Flavour();
			$flavourData = $flavour->getFlavourData();
			$gameFlavour = $this->createElement('text', 'gameFlavour');
			$gameFlavour->setLabel($this->getView()->translate('Game Flavour'))
						->setValue($pjpData['game_flavour'])
						->addValidator(new Zenfox_Validate_ModifyValidator($pjpData['game_flavour']));
			/*foreach($flavourData as $flavour)
			{
				$gameFlavour->addMultiOption($flavour['game_flavour'], $flavour['game_flavour']);
			}*/
			
			$gameId = $this->createElement('hidden', 'gameId');
			$gameId->setValue($pjpData['game_id']);
//					->setLabel($this->getView()->translate('Game Id'))
//					
//					->addValidator(new Zenfox_Validate_ModifyValidator($pjpData['game_id']));
	
			$percentReal = $this->createElement('text', 'percentReal');
			$percentReal->setLabel($this->getView()->translate('Real Percentage'))
						->setValue($pjpData['percent_real']);
					
			$percentBbs = $this->createElement('text', 'percentBbs');
			$percentBbs->setLabel($this->getView()->translate('Bonus Percentage'))
						->setValue($pjpData['percent_bbs']);
					
			$minBetReal = $this->createElement('text', 'minBetReal');
			$minBetReal->setLabel($this->getView()->translate('Minimum Real Bet'))
						->setValue($pjpData['min_bet_real'])
						->addValidator('Digits');
					
			$minBetBbs = $this->createElement('text', 'minBetBbs');
			$minBetBbs->setLabel($this->getView()->translate('Minimum Bonus Bet'))
						->setValue($pjpData['min_bet_bbs'])
						->addValidator('Digits');
					
			$maxBetReal = $this->createElement('text', 'maxBetReal');
			$maxBetReal->setLabel($this->getView()->translate('Maximum Real Bet'))
						->setValue($pjpData['max_bet_real'])
						->addValidator('Digits');
					
			$maxBetBbs = $this->createElement('text', 'maxBetBbs');
			$maxBetBbs->setLabel($this->getView()->translate('Maximum Bonus Bet'))
						->setValue($pjpData['max_bet_bbs'])
						->addValidator('Digits');
						
			$submit = $this->createElement('submit', 'submit');
	        $submit->setLabel($this->getView()->translate('Submit'))
	        		->setIgnore(true);
			//Zenfox_Debug::dump($submit->getValue(), 'submit');
				
			$this->addElements(array(
							$gameId,
							$checkBox,
							$pjpId,
							$gameFlavour,
							$percentReal,
							$percentBbs,
							$minBetReal,
							$minBetBbs,
							$maxBetReal,
							$maxBetBbs,
							$submit));
							
			$this->setAttrib('id', 'admin-pjp-form');
		}
	}
	
	/*
	 * This function creates a new pjp form without setting up the values
	 */
	public function getPjpForm($id)
	{
		Zend_Dojo::enableForm($this);
		$checkBox = $this->createElement('checkbox', 'checkBox');
		
		$pjpId = $this->createElement('text', 'pjpId');
		$pjpId->setLabel($this->getView()->translate('Pjp Id'))
				->setValue($id)
				->addValidator(new Zenfox_Validate_ModifyValidator($id));
		
		/*$flavour = new Flavour();
		$flavourData = $flavour->getFlavourData();
		$gameFlavour = $this->createElement('select', 'gameFlavour');
		$gameFlavour->setLabel($this->getView()->translate('Game Flavour'));
		foreach($flavourData as $flavour)
		{
			$gameFlavour->addMultiOption($flavour['game_flavour'], $flavour['game_flavour']);
		}*/
		
		/*$gameId = $this->createElement('text', 'gameId');
		$gameId->setLabel($this->getView()->translate('Game Id'))
				->addValidator('Digits');*/
		
		$percentReal = $this->createElement('text', 'percentReal');
		$percentReal->setLabel($this->getView()->translate('Real Percentage'));
					
		$percentBbs = $this->createElement('text', 'percentBbs');
		$percentBbs->setLabel($this->getView()->translate('Bonus Percentage'));
					
		$minBetReal = $this->createElement('text', 'minBetReal');
		$minBetReal->setLabel($this->getView()->translate('Minimum Real Bet'))
					->addValidator('Digits');
					
		$minBetBbs = $this->createElement('text', 'minBetBbs');
		$minBetBbs->setLabel($this->getView()->translate('Minimum Bonus Bet'))
					->addValidator('Digits');
					
		$maxBetReal = $this->createElement('text', 'maxBetReal');
		$maxBetReal->setLabel($this->getView()->translate('Maximum Real Bet'))
					->addValidator('Digits');
					
		$maxBetBbs = $this->createElement('text', 'maxBetBbs');
		$maxBetBbs->setLabel($this->getView()->translate('Maximum Bonus Bet'))
					->addValidator('Digits');
				
		$submit = $this->createElement('submit', 'submit');
	    $submit->setLabel($this->getView()->translate('Submit'))
	       		->setIgnore(true);
		//Zenfox_Debug::dump($submit->getValue(), 'submit');
				
		$this->addElements(array(
						$checkBox,
						$pjpId,
						//$gameFlavour,
						//$gameId,
						$percentReal,
						$percentBbs,
						$minBetReal,
						$minBetBbs,
						$maxBetReal,
						$maxBetBbs,
						//$submit
						));
						
		$this->setAttrib('id', 'admin-pjp-form');
		return $this;
	}
	
	public function getForm()
	{
		$pjpForm = new Zend_Form_SubForm();
		Zend_Dojo::enableForm($pjpForm);
		/*$pjpId = $pjpMachine->createElement('text', 'pjpId');
		$pjpId->setLabel($pjpMachine->getView()->translate('Pjp Id'))
				->addValidator('Digits');
		
		$flavour = new Flavour();
		$flavourData = $flavour->getFlavourData();
		$gameFlavour = $pjpMachine->createElement('select', 'gameFlavour');
		$gameFlavour->setLabel($pjpMachine->getView()->translate('Game Flavour'));
		foreach($flavourData as $flavour)
		{
			$gameFlavour->addMultiOption($flavour['game_flavour'], $flavour['game_flavour']);
		}
		
		$gameId = $pjpMachine->createElement('text', 'gameId');
		$gameId->setLabel($pjpMachine->getView()->translate('Game Id'))
				->addValidator('Digits');*/
		
		$percentReal = $pjpForm->createElement('text', 'percentReal');
		$percentReal->setLabel($pjpForm->getView()->translate('Real Percentage'))
					->setRequired(true);
					
		$percentBbs = $pjpForm->createElement('text', 'percentBbs');
		$percentBbs->setLabel($pjpForm->getView()->translate('Bonus Percentage'))
					->setRequired(true);
					
		$minBetReal = $pjpForm->createElement('text', 'minBetReal');
		$minBetReal->setLabel($pjpForm->getView()->translate('Minimum Real Bet'))
					->addValidator('Digits')
					->setRequired(true);
					
		$minBetBbs = $pjpForm->createElement('text', 'minBetBbs');
		$minBetBbs->setLabel($pjpForm->getView()->translate('Minimum Bonus Bet'))
					->addValidator('Digits')
					->setRequired(true);
					
		$maxBetReal = $pjpForm->createElement('text', 'maxBetReal');
		$maxBetReal->setLabel($pjpForm->getView()->translate('Maximum Real Bet'))
					->addValidator('Digits')
					->setRequired(true);
					
		$maxBetBbs = $pjpForm->createElement('text', 'maxBetBbs');
		$maxBetBbs->setLabel($pjpForm->getView()->translate('Maximum Bonus Bet'))
					->addValidator('Digits')
					->setRequired(true);
				
				
		$pjpForm->addElements(array(
						//$pjpId,
						//$gameFlavour,
						//$gameId,
						$percentReal,
						$percentBbs,
						$minBetReal,
						$minBetBbs,
						$maxBetReal,
						$maxBetBbs));
						
		$pjpForm->setAttrib('id', 'admin-pjp-machine-form');
						
		return $pjpForm;
	}
	
	/*public function setForm($pjpData)
	{
		if($pjpData)
		{
			$pjpForm = new Zend_Form_SubForm();
			Zend_Dojo::enableForm($pjpForm);

			$percentReal = $pjpForm->createElement('text', 'percentReal');
			$percentReal->setLabel($this->getView()->translate('Real Percentage'))
						->setValue($pjpData['percent_real']);
					
			$percentBbs = $pjpForm->createElement('text', 'percentBbs');
			$percentBbs->setLabel($this->getView()->translate('Bonus Percentage'))
						->setValue($pjpData['percent_bbs']);
					
			$minBetReal = $pjpForm->createElement('text', 'minBetReal');
			$minBetReal->setLabel($this->getView()->translate('Minimum Real Bet'))
						->setValue($pjpData['min_bet_real'])
						->addValidator('Digits');
					
			$minBetBbs = $pjpForm->createElement('text', 'minBetBbs');
			$minBetBbs->setLabel($this->getView()->translate('Minimum Bonus Bet'))
						->setValue($pjpData['min_bet_bbs'])
						->addValidator('Digits');
					
			$maxBetReal = $pjpForm->createElement('text', 'maxBetReal');
			$maxBetReal->setLabel($this->getView()->translate('Maximum Real Bet'))
						->setValue($pjpData['max_bet_real'])
						->addValidator('Digits');
					
			$maxBetBbs = $pjpForm->createElement('text', 'maxBetBbs');
			$maxBetBbs->setLabel($this->getView()->translate('Maximum Bonus Bet'))
						->setValue($pjpData['max_bet_bbs'])
						->addValidator('Digits');
						
				
			$pjpForm->addElements(array(
							$percentReal,
							$percentBbs,
							$minBetReal,
							$minBetBbs,
							$maxBetReal,
							$maxBetBbs));
							
			$pjpForm->setAttrib('id', 'admin-pjp-form');
			return $pjpForm;
		}
	}*/
	
	public function setForm($form, $data)
	{
		//$form->pjpId->setValue($data['pjpId']);
		//$form->gameFlavour->setValue($data['gameFlavour']);
		//$form->gameId->setValue($data['gameId']);
		$form->percentReal->setValue($data['percentReal']);
		$form->percentBbs->setValue($data['percentBbs']);
		$form->minBetReal->setValue($data['minBetReal']);
		$form->minBetBbs->setValue($data['minBetBbs']);
		$form->maxBetReal->setValue($data['maxBetReal']);
		$form->maxBetBbs->setValue($data['maxBetBbs']);
		
		return $form;
	}
}