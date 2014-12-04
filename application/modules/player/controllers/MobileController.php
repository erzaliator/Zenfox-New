<?php

class Player_MobileController extends Zend_Controller_Action
{
	public function init()
	{
		parent::init();
		
		$contextSwitch = $this->_helper->getHelper('contextSwitch');
		$contextSwitch->addActionContext('login', 'json')
						->addActionContext('bonus', 'json')
						->initContext();
	}
	
	public function loginAction()
	{
		//$frontendId = Zend_Registry::get('frontendId');
		$frontendId = 2;
		Zend_Registry::set('frontendId', $frontendId);
		$email = $this->getRequest()->email;
		if($email)
		{
			$mobile = new Mobile();
			$authData = $mobile->authenticateUser($email, $frontendId);
			$this->view->success = $authData;
		}
		else
		{
			$this->view->success = "Provide an email address";
		}
	}
	
	public function getsfsloginAction()
	{
		
	}
	
	public function bonusAction()
	{
		$authSession = new Zenfox_Auth_Storage_Session();
		$sessionData = $authSession->read();
		
		$playerId = $sessionData['id'];
		$loyaltyPoints = $sessionData['authDetails'][0]['total_loyalty_points'];
		$schemeId = $sessionData['authDetails'][0]['bonus_scheme_id'];
		
		$bonusLevel = new BonusLevel();
		$currentLevel = $bonusLevel->getLevelIdByPoints($loyaltyPoints, $playerId, $schemeId);
		$levelId = $currentLevel['id'];
		
		$gameGroupId = 2;
		
		$mobileBonus = new MobileBonus();
		$bonusData = $mobileBonus->getBonusByLevel($levelId, $gameGroupId);
		
		$player = new Player();
		$noOfBuddies = $player->getNoOfBuddies($playerId);
		
		$maxBuddyBonus = $bonusData['max_buddy_bonus'];
		$totalBuddyBonus = $noOfBuddies * $bonusData['buddy_bonus'];
		$buddyBonus = $totalBuddyBonus;
		
		if($totalBuddyBonus > $maxBuddyBonus)
		{
			$buddyBonus = $maxBuddyBonus;
		}
		
		$maxTotalBonus = $bonusData['max_bonus'];
		$totalBonus = $bonusData['base_bonus'] + $buddyBonus + $bonusData['level_multiplier'] * $bonusData['base_bonus'];
		if($totalBonus > $maxTotalBonus)
		{
			$totalBonus = $maxTotalBonus;
		}
		
		$response['baseBonus'] = $bonusData['base_bonus'];
		$response['level'] = $levelId;
		$response['levelBonusMultiplier'] = $bonusData['level_multiplier'];
		$response['numberOfFriends'] = $noOfBuddies;
		$response['friendBonusMultiplier'] = $bonusData['buddy_bonus'];
		$response['totalBonus'] = $totalBonus;
		
 		$transactionObj = new Transaction();
 		$creditBonus = $transactionObj->credit('BONUS', $playerId, $totalBonus, $sessionData['authDetails'][0]['base_currency'], '', '', '', "Daily Bonus for mobile slots");

		$this->view->response = $response;
	}
}