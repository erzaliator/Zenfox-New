<?php
class RouletteConfig extends Doctrine_Record
{
	public function __construct()
	{
		parent::__construct();
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
	}	
	/*
	 * This function updates the machine data for selected machine id.
	 */
	public function updateMachineData($id, $data)
	{
		//print($conn);
		//TODO check the connection before updating
		//Zenfox_Debug::dump($data, 'machineData', true, true);
		$roulette = new Roulette();
		$oldGameFlavour = $roulette->getGameFlavour($id);
		$newGameFlavour = $roulette->getGameFlavour($data['machineId']);
		if($oldGameFlavour != $newGameFlavour)
		{
			$pjp = new PjpMachine();
			$allPjpDetails = $pjp->getMachineData($id, $oldGameFlavour);
			$pjpMachine = new PjpConfig();
			foreach($allPjpDetails as $pjpData)
			{
				$pjpMachine->updateGameFlavour($newGameFlavour, $pjpData['id']);
			}		
		}
		
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$denoms = $data['denominations'];
		$denomString = '';
		foreach($denoms as $denom)
		{
			if($denomString == '')
			{
				$denomString = $denomString.$denom;
			}
			else
			{
				$denomString = $denomString.','.$denom;
			}
		}
		$query = Zenfox_Query::create()
						->update('RunningRoulette r')
						->set('r.machine_name', '?', $data['machineName'])
						->set('r.description', '?', $data['description'])
						->set('r.denominations', '?', $denomString)
						->set('r.default_denomination', '?', $data['defaultDenomination'])
						->set('r.max_bet', '?', $data['maxBet'])
						->set('r.max_bet_string', '?', $data['maxBetString'])
						->set('r.enabled', '?', $data['enabled'])
						->set('r.machine_id', '?', $data['machineId'])
						->set('r.pjp_enabled', '?', $data['pjpEnabled'])
						->set('r.amount_type', '?', $data['amountType'])
						->set('r.game_flavour', '?', $newGameFlavour)
						->where('r.id = ? ', $id);
						
		try
		{
			$query->execute();
		}
		catch(Exception $e)
		{
			print('Unable to update Running Roulette data') . $e;
			exit();
		}
		return $newGameFlavour;
	}
	
	/*
	 * Insert new machine data in table
	 */
	public function insertMachineData($data)
	{
		//Zenfox_Debug::dump($data, 'machineData', true, true);
		$roulette = new Roulette();
		$gameFlavour = $roulette->getGameFlavour($data['machineId']);
		
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$denoms = $data['denominations'];
		$denomString = '';
		foreach($denoms as $denom)
		{
			if($denomString == '')
			{
				$denomString = $denomString.$denom;
			}
			else
			{
				$denomString = $denomString.','.$denom;
			}
		}
		
		$runningRoulette = new RunningRoulette();
		$runningRoulette->machine_name = $data['machineName'];
		$runningRoulette->game_flavour = $gameFlavour;
		$runningRoulette->denominations = $denomString;
		$runningRoulette->default_denomination = $data['defaultDenomination'];
		$runningRoulette->description = $data['description'];
		$runningRoulette->max_bet = $data['maxBet'];
		$runningRoulette->max_bet_string = $data['maxBetString'];
		$runningRoulette->enabled = $data['enabled'];
		$runningRoulette->machine_id = $data['machineId'];
		$runningRoulette->pjp_enabled = $data['pjpEnabled'];
		$runningRoulette->amount_type = $data['amountType'];

		try
		{
			$runningRoulette->save();
		}
		catch(Exception $e)
		{
			print('Unable to save Running Roulette data') . $e;
			exit();
		}
		$runningRoulette = new RunningRoulette();
		$runningRouletteData = $runningRoulette->getLatestMachineData();
		return $runningRouletteData;
	}
}