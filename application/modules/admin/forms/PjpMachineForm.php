<?php
/**
 * This class is used to set and create new pjp form
 * @author Nikhil Gupta
 * @date January 2, 2010
 */
class Admin_PjpMachineForm extends Zend_Form
{
	public function init()
	{
		
	}
	
	/*
	 * This function sets the pjp data in pjp form
	 */
	
	/*
	 * This function creates a new pjp form without setting up the values
	 */
	public function getForm()
	{
		$pjpMachine = new Zend_Form_SubForm();
		Zend_Dojo::enableForm($pjpMachine);
		
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
		
		$percentReal = $pjpMachine->createElement('text', 'percentReal');
		$percentReal->setLabel($pjpMachine->getView()->translate('Real Percentage'))
					->setRequired(true);
					
		$percentBbs = $pjpMachine->createElement('text', 'percentBbs');
		$percentBbs->setLabel($pjpMachine->getView()->translate('Bonus Percentage'))
					->setRequired(true);
					
		$minBetReal = $pjpMachine->createElement('text', 'minBetReal');
		$minBetReal->setLabel($pjpMachine->getView()->translate('Minimum Real Bet'))
					->addValidator('Digits')
					->setRequired(true);
					
		$minBetBbs = $pjpMachine->createElement('text', 'minBetBbs');
		$minBetBbs->setLabel($pjpMachine->getView()->translate('Minimum Bonus Bet'))
					->addValidator('Digits')
					->setRequired(true);
					
		$maxBetReal = $pjpMachine->createElement('text', 'maxBetReal');
		$maxBetReal->setLabel($pjpMachine->getView()->translate('Maximum Real Bet'))
					->addValidator('Digits')
					->setRequired(true);
					
		$maxBetBbs = $pjpMachine->createElement('text', 'maxBetBbs');
		$maxBetBbs->setLabel($pjpMachine->getView()->translate('Maximum Bonus Bet'))
					->addValidator('Digits')
					->setRequired(true);
				
		$submit = $pjpMachine->createElement('submit', 'submit');
	    $submit->setLabel($pjpMachine->getView()->translate('Submit'))
	       		->setIgnore(true);
		//Zenfox_Debug::dump($submit->getValue(), 'submit');
				
		$pjpMachine->addElements(array(
						//$pjpId,
						//$gameFlavour,
						//$gameId,
						$percentReal,
						$percentBbs,
						$minBetReal,
						$minBetBbs,
						$maxBetReal,
						$maxBetBbs,
						$submit));
						
		$pjpMachine->setAttrib('id', 'admin-pjp-machine-form');
						
		return $pjpMachine;
	}
	
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