<?php

class Partner_BonusForm extends Zend_Form
{
	public function init()
	{
		Zend_Dojo::enableForm($this);
				
		$levelName = $this->createElement('text', 'levelName');
		$levelName->setLabel('Level Name');
		
		$minPoints = $this->createElement('text', 'minPoints');
		$minPoints->setLabel('Minimum Points');
		
		$maxPoints = $this->createElement('text', 'maxPoints');
		$maxPoints->setLabel('Maximum Points');
		
		$bonusPercent = $this->createElement('text', 'bonusPercent');
		$bonusPercent->setLabel('Bonus Percentage');
		
		$fixedBonus = $this->createElement('text', 'fixedBonus');
		$fixedBonus->setLabel('Fixed Bonus');
		
		$minDeposit = $this->createElement('text', 'minDeposit');
		$minDeposit->setLabel('Minimum Deposit');
		
		$minTotalDeposit = $this->createElement('text', 'minTotalDeposit');
		$minTotalDeposit->setLabel('Minimum Total Deposit');
		
		$rewardTimes = $this->createElement('text', 'rewardTimes');
		$rewardTimes->setLabel('Reward Times');
		
		$fixedReal = $this->createElement('text', 'fixedReal');
		$fixedReal->setLabel('Fixed Real');
		
		$this->addElements(array(
					$levelName,
					$minPoints,
					$maxPoints,
					$bonusPercent,
					$fixedBonus,
					$minDeposit,
					$minTotalDeposit,
					$rewardTimes,
					$fixedReal
			));
		
		$this->addElement(
				'SimpleTextarea',
				'description',
				array(
					'label' => 'Description',
					'style' => 'width: 30em; height: 10em;'
				)
			);
		
		$submit = $this->createElement('submit', 'submit');
		$submit->setLabel('Submit');
		
		$this->addElement($submit);
	}
}