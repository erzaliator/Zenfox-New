<?php
//require_once dirname(__FILE__) . '/../../../forms/GameGroupsForm.php';
require_once dirname(__FILE__) . '/../forms/LoyaltyForm.php';
class Admin_BonusLevelForm extends Zend_Form
{
	public function getForm()
	{
		$levelForm = new Zend_Form_SubForm();
		Zend_Dojo::enableForm($levelForm);
		
		$levelId = $levelForm->createElement('hidden', 'levelId');
		
		$levelName = $levelForm->createElement('text', 'levelName');
		$levelName->setLabel('Level Name');
		
		$minPoints = $levelForm->createElement('text', 'minPoints');
		$minPoints->setLabel('Minimum Points');
		
		$maxPoints = $levelForm->createElement('text', 'maxPoints');
		$maxPoints->setLabel('Maximum Points');
		
		$bonusPercent = $levelForm->createElement('text', 'bonusPercent');
		$bonusPercent->setLabel('Bonus Percentage');
		
		$fixedBonus = $levelForm->createElement('text', 'fixedBonus');
		$fixedBonus->setLabel('Fixed Bonus');
		
		$minDeposit = $levelForm->createElement('text', 'minDeposit');
		$minDeposit->setLabel('Minimum Deposit');
		
		$minTotalDeposit = $levelForm->createElement('text', 'minTotalDeposit');
		$minTotalDeposit->setLabel('Minimum Total Deposit');
		
		$rewardTimes = $levelForm->createElement('text', 'rewardTimes');
		$rewardTimes->setLabel('Reward Times');
		
		$fixedReal = $levelForm->createElement('text', 'fixedReal');
		$fixedReal->setLabel('Fixed Real');
		
		$levelForm->addElements(array(
						$levelId,
						$levelName,
						$minPoints,
						$maxPoints,
						$bonusPercent,
						$fixedBonus,
						$minDeposit,
						$minTotalDeposit,
						$rewardTimes,
						$fixedReal));
						
		$levelForm->addElement(
						'SimpleTextarea',
						'description',
						array(
							'label' => 'Description',
							'style' => 'width: 30em; height: 10em;'
						)
					);
		
		$gameGroup = new Gamegroup();
		$groupDetails = $gameGroup->getAllGroupDetails();		
		$loyaltyForm = new Admin_LoyaltyForm();
		foreach($groupDetails as $groups)
		{
			$getLoyaltyForm = $loyaltyForm->getForm($groups['name'], $groups['id']);
			$levelForm->addSubForm($getLoyaltyForm, 'loyaltyForm_' . $groups['id']);
		}
		$levelForm->setAttrib('id', 'admin-bonus-level-form');
		return $levelForm;
	}
	
	public function setForm($form, $data)
	{
		if($data['levelName'])
		{
			$form->levelId->setValue($data['levelId']);
			$form->levelName->setValue($data['levelName']);
			$form->minPoints->setValue($data['minPoints']);
			$form->maxPoints->setValue($data['maxPoints']);
			$form->bonusPercent->setValue($data['bonusPercent']);
			$form->fixedBonus->setValue($data['fixedBonus']);
			$form->minDeposit->setValue($data['minDeposit']);
			$form->minTotalDeposit->setValue($data['minTotalDeposit']);
			$form->rewardTimes->setValue($data['rewardTimes']);
			$form->fixedReal->setValue($data['fixedReal']);
			$form->description->setValue($data['description']);
		}
		$loyaltyForm = new Admin_LoyaltyForm();
		foreach($data as $key => $value)
		{
			if(substr($key, 0, 11) == 'loyaltyForm')
			{
				$setLoyaltyform = $loyaltyForm->setForm($form->getSubForm($key), $value);
				$form->addSubForm($setLoyaltyform, $key);
			}
		}
		return $form;
	}
	
	public function getBonusLevelForm($levelData)
	{
		Zend_Dojo::enableForm($this);
		
		$levelId = $this->createElement('hidden', 'levelId');
		$levelId->setValue($levelData['level_id']);
		
		$levelName = $this->createElement('text', 'levelName');
		$levelName->setLabel('Level Name')
				->setValue($levelData['level_name']);
		
		$minPoints = $this->createElement('text', 'minPoints');
		$minPoints->setLabel('Minimum Points')
				->setValue($levelData['min_points']);
		
		$maxPoints = $this->createElement('text', 'maxPoints');
		$maxPoints->setLabel('Maximum Points')
				->setValue($levelData['max_points']);
		
		$bonusPercent = $this->createElement('text', 'bonusPercent');
		$bonusPercent->setLabel('Bonus Percentage')
				->setValue($levelData['bonus_percentage']);
		
		$fixedBonus = $this->createElement('text', 'fixedBonus');
		$fixedBonus->setLabel('Fixed Bonus')
				->setValue($levelData['fixed_bonus']);
		
		$minDeposit = $this->createElement('text', 'minDeposit');
		$minDeposit->setLabel('Minimum Deposit')
				->setValue($levelData['min_deposit']);
		
		$minTotalDeposit = $this->createElement('text', 'minTotalDeposit');
		$minTotalDeposit->setLabel('Minimum Total Deposit')
					->setValue($levelData['min_total_deposit']);
		
		$rewardTimes = $this->createElement('text', 'rewardTimes');
		$rewardTimes->setLabel('Reward Times')
				->setValue($levelData['reward_times']);
		
		$fixedReal = $this->createElement('text', 'fixedReal');
		$fixedReal->setLabel('Fixed Real')
				->setValue($levelData['fixed_real']);
		
		$this->addElements(array(
				$levelId,
				$levelName,
				$minPoints,
				$maxPoints,
				$bonusPercent,
				$fixedBonus,
				$minDeposit,
				$minTotalDeposit,
				$rewardTimes,
				$fixedReal));
		
		$this->addElement(
					'SimpleTextarea',
					'description',
					array(
						'label' => 'Description',
						'style' => 'width: 30em; height: 10em;',
						'value' => $levelData['description']
					)
				);
		$submit = $this->createElement('submit', 'submit');
		$submit->setLabel('Submit');
		$this->addElement($submit);
		
		return $this;
	}
}