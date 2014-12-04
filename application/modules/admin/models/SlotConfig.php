<?php
class SlotConfig extends Doctrine_Record
{
	public function __construct()
	{
		parent::__construct();
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
	}
	public function updateMachineData($runningSlotsId, $data)
	{
		print_r($data);
		exit();
		//print($runningSlotsId);
		//Zenfox_Debug::dump($data, 'data', true, true);
		$slot = new Slot();
		$runningSlot = new RunningSlot();
		$oldGameFlavour = $runningSlot->getSlotsGameFlavour($runningSlotsId);
		$newGameFlavour = $slot->getGameFlavour($data['machineId']);
//		print('old - ' . $oldGameFlavour);
//		print('new - ' . $newGameFlavour);
		if($oldGameFlavour != $newGameFlavour)
		{
			$pjp = new PjpMachine();
			$allPjpDetails = $pjp->getMachineData($runningSlotsId, $oldGameFlavour);
			$pjpMachine = new PjpConfig();
			foreach($allPjpDetails as $pjpData)
			{
				$pjpMachine->updateGameFlavour($newGameFlavour, $pjpData['id']);
			}			
		}
		$denomination = implode(',', $data['denomination']);
		$session = new Zenfox_Auth_Storage_Session();
		$store = $session->read();
		$csrId = $store['id'];
		$today = new Zend_Date();
		$currentTime = $today->get(Zend_Date::W3C);
		
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
					->update('RunningSlot r')
					->set('r.machine_id', '?', $data['machineId'])
					->set('r.game_flavour', '?', $newGameFlavour)
					->set('r.amount_type', '?', $data['amountType'])
					->set('r.feature_enabled', '?', $data['feature'])
					->set('r.bonus_spins_enabled', '?', $data['bonusSpins'])
					->set('r.denominations', '?', $denomination)
					->set('r.default_denomination', '?', $data['defaultDenomination'])
					->set('r.default_currency', '?', $data['defaultCurrency'])
					->set('r.pjp_enabled', '?', $data['pjpEnabled'])
					->set('r.max_bet', '?', $data['maxBet'])
					->set('r.machine_type', '?', $data['machineType'])
					->set('r.max_betlines', '?', $data['maxBetLines'])
					->set('r.max_coins', '?', $data['maxCoins'])
					->set('r.min_betlines', '?', $data['minBetLines'])
					->set('r.min_coins', '?', $data['minCoins'])
					->set('r.enabled', '?', $data['enabled'])
					->set('r.last_updated_by', '?', $csrId)
					->set('r.last_updated_time', '?', $currentTime)
					->where('r.id = ?', $runningSlotsId);
					
		try
		{
			$query->execute();
		}
		catch(Exception $e)
		{
			print('Unable to update Running Slot data') . $e;
			exit();
		}
		
		return $newGameFlavour;
	}
	
	public function insertMachineData($data)
	{
		//Zenfox_Debug::dump($data, 'slotData');
		
		$slot = new Slot();
		$gameFlavour = $slot->getGameFlavour($data['machineId']);
		
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$runningSlot = new RunningSlot();
		$denomination = implode(',', $data['denomination']);
		$session = new Zenfox_Auth_Storage_Session();
		$store = $session->read();
		$userId = $store['id'];
		$today = new Zend_Date();
		$currentTime = $today->get(Zend_Date::W3C);		
		$runningSlot->machine_id = $data['machineId'];
		$runningSlot->game_flavour = $gameFlavour;
		$runningSlot->amount_type = $data['amountType'];
		$runningSlot->feature_enabled = $data['feature'];
		$runningSlot->bonus_spins_enabled = $data['bonusSpins'];
		$runningSlot->denominations = $denomination;
		$runningSlot->default_denomination = $data['defaultDenomination'];
		$runningSlot->default_currency = $data['defaultCurrency'];
		$runningSlot->pjp_enabled = $data['pjpEnabled'];
		$runningSlot->max_bet = $data['maxBet'];
		$runningSlot->machine_type = $data['machineType'];
		$runningSlot->max_betlines = $data['maxBetLines'];
		$runningSlot->max_coins = $data['maxCoins'];
		$runningSlot->min_betlines = $data['minBetLines'];
		$runningSlot->min_coins = $data['minCoins'];
		$runningSlot->enabled = $data['enabled'];
		$runningSlot->created_by = $userId;
		$runningSlot->created_time = $currentTime;
		$runningSlot->last_updated_by = $userId;
		$runningSlot->last_updated_time = $currentTime;
		$runningSlot->machine_name = $data['machineName'];
		$runningSlot->description = $data['description'];

		try
		{
			$runningSlot->save();
		}
		catch(Exception $e)
		{
			print('Unable to save Running Slot data') . $e;
			exit();
		}
		$runningSlot = new RunningSlot();
		$latestInsData = $runningSlot->getLatestMachineData();
		return $latestInsData;
	}
}