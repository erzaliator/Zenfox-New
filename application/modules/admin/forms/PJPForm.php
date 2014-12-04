<?php
/**
 * This class is used to set and create new pjp form
 * @author Nikhil Gupta
 * @date January 2, 2010
 */
class Admin_PJPForm extends Zend_Form
{

	public function getForm($data)
	{
		
				
		$pjpName = $this->createElement('text', 'Name');
		$pjpName->setLabel($this->getView()->translate('Pjp Name'))
				->setValue($data["pjp_name"]);
		
		$description = $this->createElement('textarea', 'Description');
		$description->setLabel($this->getView()->translate('Description'))
				->setValue($data["description"]);
				
		$currency = $this->createElement('text', 'Currency');
		$currency->setLabel($this->getView()->translate('Currency'))
				->setValue($data["currency"]);
				
		$bbs_enabled = $this->createElement('select', 'BbsEnabled');
		$bbs_enabled->setLabel($this->getView()->translate('BBS Enabled'))
					->addMultiOptions(array(
						'ENABLED' => 'ENABLED',
						'DISABLED' => 'DISABLED'))
				->setValue($data["bbs_enabled"]);
				
		$bbs_pjp = $this->createElement('text', 'BbsPjp');
		$bbs_pjp->setLabel($this->getView()->translate('BBS PJP'))
					->setValue($data["bbs_pjp"]);
					
		$real_pjp = $this->createElement('text', 'RealPjp');
		$real_pjp->setLabel($this->getView()->translate('Real PJP'))
					->setValue($data["real_pjp"]);
					
		$random_number = $this->createElement('text', 'RandomNumber');
		$random_number->setLabel($this->getView()->translate('Random Number'))
					->setValue($data["random_number"]);
					
		$seed = $this->createElement('text', 'Seed');
		$seed->setLabel($this->getView()->translate('Seed'))
					->setValue($data["seed"]);
					
	
		$minBetReal = $this->createElement('text', 'minBetReal');
		$minBetReal->setLabel($this->getView()->translate('Minimum Real Bet'))
					->setValue($data["min_amount_real"])
					->addValidator('Digits');
					
		$minBetBbs = $this->createElement('text', 'minBetBbs');
		$minBetBbs->setLabel($this->getView()->translate('Minimum Bonus Bet'))
					->setValue($data["min_amount_bbs"])
					->addValidator('Digits');
					
		$maxBetReal = $this->createElement('text', 'maxBetReal');
		$maxBetReal->setLabel($this->getView()->translate('Maximum Real Bet'))
					->setValue($data["max_amount_real"])
					->addValidator('Digits');
					
		$maxBetBbs = $this->createElement('text', 'maxBetBbs');
		$maxBetBbs->setLabel($this->getView()->translate('Maximum Bonus Bet'))
					->setValue($data["max_amount_bbs"])
					->addValidator('Digits');
				
		$reset_close = $this->createElement('select', 'ResetClose');
		$reset_close->setLabel($this->getView()->translate('Reset/Close'))
					->addMultiOptions(array(
						'RESET' => 'RESET',
						'CLOSE' => 'CLOSE'))
				->setValue($data["reset_close"]);			
					
					
		$closed = $this->createElement('select', 'Closed');
		$closed->setLabel($this->getView()->translate('Closed'))
					->addMultiOptions(array(
						'CLOSE' => 'CLOSE',
						'OPEN' => 'OPEN'))
				->setValue($data["closed"]);			

				
		$allowed_frontends = $this->createElement('text', 'AllowedFrontends');
		$allowed_frontends->setLabel($this->getView()->translate('Allowed Frontends'))
					->setValue($data["allowed_frontends"]);
				
		$submit = $this->createElement('submit', 'submit');
	    $submit->setLabel($this->getView()->translate('Submit'));
		//Zenfox_Debug::dump($submit->getValue(), 'submit');
				
		$this->addElements(array(
						$pjpName,$description,$currency,$bbs_enabled,$bbs_pjp,$real_pjp,$seed,$random_number,
						$minBetReal,
						$minBetBbs,
						$maxBetReal,
						$maxBetBbs,$reset_close,$closed,$allowed_frontends,
						$submit
						));
						
		$this->setAttrib('id', 'admin-PJP-form');
		return $this;
	}
	
	
}