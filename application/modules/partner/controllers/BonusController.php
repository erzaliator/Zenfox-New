<?php

require_once dirname(__FILE__) . '/../forms/BonusForm.php';
class Partner_BonusController extends Zend_Controller_Action
{
	public function init()
	{
		parent::init();
	}
	
	public function viewAction()
	{
		$bonusLevel = new BonusLevel();
		$allLevelsData = $bonusLevel->getAllLevelsData(3);
		$levels = array();
		
		foreach($allLevelsData as $index => $levelData)
		{
			$levels[$index]['Id'] = $levelData['levelId'];
			$levels[$index]['Name'] = $levelData['levelName'];
			$levels[$index]['(Min/Max) Points'] = $levelData['minPoints'] . '/' . $levelData['maxPoints'];
			$levels[$index]['Bonus(%)'] = $levelData['bonusPercent'];
			$levels[$index]['Fixed Bonus'] = $levelData['fixedBonus'];
			$levels[$index]['Min Deposit'] = $levelData['minDeposit'];
			$levels[$index]['Min Total Deposit'] = $levelData['minTotalDeposit'];
			$levels[$index]['Reward Times'] = $levelData['rewardTimes'];
			$levels[$index]['Fixed Real'] = $levelData['fixedReal'];
		}
		$this->view->allLevelsData = $levels;
	}
	
	public function editAction()
	{
		$bonusForm = new Partner_BonusForm();
		
		$levelId = $this->getRequest()->levelId;
		
		$bonusLevel = new BonusLevel();
		$bonusLevelData = $bonusLevel->getLevelData($levelId, 3);
		
		if($this->getRequest()->isPost())
		{
			if($bonusForm->isValid($_POST))
			{
				$formValues = $bonusForm->getValues();
				$formValues['levelId'] = $levelId;
				
				$bonusConfiguration = new BonusConfiguration();
				$updateLevelData = $bonusConfiguration->updateLevelData($formValues, 3);
				if($updateLevelData)
				{
					$this->view->bonusForm = "Bonus scheme is updated successfully";
				}
				else
				{
					$this->view->bonusForm = "Some problem while updating";
				}
			}
		}
		else if($bonusLevelData)
		{
			$bonusForm->getElement('levelName')->setValue($bonusLevelData[0]['level_name']);
			$bonusForm->getElement('minPoints')->setValue($bonusLevelData[0]['min_points']);
			$bonusForm->getElement('maxPoints')->setValue($bonusLevelData[0]['max_points']);
			$bonusForm->getElement('bonusPercent')->setValue($bonusLevelData[0]['bonus_percentage']);
			$bonusForm->getElement('fixedBonus')->setValue($bonusLevelData[0]['fixed_bonus']);
			$bonusForm->getElement('minDeposit')->setValue($bonusLevelData[0]['min_deposit']);
			$bonusForm->getElement('minTotalDeposit')->setValue($bonusLevelData[0]['min_total_deposit']);
			$bonusForm->getElement('rewardTimes')->setValue($bonusLevelData[0]['reward_times']);
			$bonusForm->getElement('fixedReal')->setValue($bonusLevelData[0]['fixed_real']);
			$bonusForm->getElement('description')->setValue($bonusLevelData[0]['description']);
			$this->view->bonusForm = $bonusForm;
		}
		else
		{
			$this->view->bonusForm = "Sorry! There is no scheme with this id. Please check id again.";
		}
	}
}