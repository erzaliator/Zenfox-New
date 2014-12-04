<?php
class PjpConfig extends Doctrine_Record
{
	public function __construct()
	{
		parent::__construct();
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
	}
	/*
	 * This function edits pjp data for selected pjp machines id
	 */
	public function updatePjpDetail($data, $id)
	{
		//print('pjp id - ' . $id);
		//Zenfox_Debug::dump($data, 'pjpData', true, true);
		
		$query = Zenfox_Query::create()
					->update('PjpMachine pm')
					->set('pm.percent_real', '?', $data['percentReal'])
					->set('pm.percent_bbs', '?', $data['percentBbs'])
					->set('pm.min_bet_real', '?', $data['minBetReal'])
					->set('pm.min_bet_bbs', '?', $data['minBetBbs'])
					->set('pm.max_bet_real', '?', $data['maxBetReal'])
					->set('pm.max_bet_bbs', '?', $data['maxBetBbs'])
					->where('pm.pjp_id = ? and pm.game_id = ? and pm.game_flavour = ?', array($id, $data['gameId'], $data['gameFlavour']));
					
		try
		{
			$query->execute();
		}
		catch(Exception $e)
		{
			print('Unable to save PjpMachine data') . $e;
			exit();
		}
		return true;
	}
	
	/*
	 * Inserts new pjp data in table
	 */
	public function insertPjpDetail($data)
	{
		if($data['pjpId'] && $data['gameId'])
		{
			//TODO check is it slot or roulette.
			$session = new Zend_Session_Namespace('runningMachine');
			if($session->value == 'roulette')
			{
				$runningRoulette = new RunningRoulette();
				$runningRouletteData = $runningRoulette->getMachineData($data['gameId']);
				$gameFlavour = $runningRouletteData['gameFlavour'];
			}
			elseif($session->value == 'slots')
			{
				$runningSlot = new RunningSlot();
				$runningSlotData = $runningSlot->getMachineData($data['gameId']);
				$gameFlavour = $runningSlotData['gameFlavour'];
			}
			elseif($session->value == 'keno')
			{
				$runningKeno = new RunningKeno();
				$runningKenoData = $runningKeno->getMachineData($data['gameId']);
				$gameFlavour = $runningKenoData['gameFlavour'];
			}
			
			$session->unsetAll();

			$conn = Zenfox_Partition::getInstance()->getMasterConnection();
			Doctrine_Manager::getInstance()->setCurrentConnection($conn);
			$pjp = new PjpMachine();
			$pjp->pjp_id = $data['pjpId'];
			$pjp->game_flavour = $data['gameFlavour'];
			$pjp->game_id = $data['gameId'];
			$pjp->percent_real = $data['percentReal'];
			$pjp->percent_bbs = $data['percentBbs'];
			$pjp->min_bet_real = $data['minBetReal'];
			$pjp->min_bet_bbs = $data['minBetBbs'];
			$pjp->max_bet_real = $data['maxBetReal'];
			$pjp->max_bet_bbs = $data['maxBetBbs'];
			
			try
			{
				$pjp->save();
			}
			catch(Exception $e)
			{
				print('Unable to update PjpMachine data');
				exit();
			}
		}
		return true;
	}
	/*public function getPjpDetails($id)
	{
		$query = Zenfox_Query::create()
		                ->from('Pjp p')
		                ->where('p.id = ?', $id);
		try
		{
			$result = $query->fetchArray();
		}
		catch(Exception $e)
		{
			print('Unable to get the PJP details') . $e;
		}
		return $result;
	}*/
	public function updateGameFlavour($gameFlavour, $pjpMachineId)
	{
		$query = Zenfox_Query::create()
						->update('PjpMachine pm')
						->set('pm.game_flavour', '?', $gameFlavour)
						->where('pm.id = ?', $pjpMachineId);
						
		try
		{
			$query->execute();
		}
		catch(Exception $e)
		{
			print('Unable to update the game flavour') . $e;
			exit();
		}
		return true;
	}
}