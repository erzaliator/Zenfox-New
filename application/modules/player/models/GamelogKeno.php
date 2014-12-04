<?php
class GamelogKeno extends BaseGamelogKeno
{
	public function getKenologDetails($logId, $sessionId, $playerId)
	{
		$conn = Zenfox_Partition::getInstance()->getConnections($playerId);
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
						->from('GamelogKeno gk')
						->where('gk.log_id = ?', $logId)
						->andWhere('gk.session_id = ?', $sessionId)
						->andWhere('gk.player_id = ?', $playerId);
						
		try
		{
			$data = $query->fetchArray();
		}
		catch(Exception $e)
		{
			return false;
		}
		if($data)
		{
			foreach($data as $result)
			{
				return array(
					'logId' => $result['log_id'],
					'sessionId' => $result['session_id'],
					'playerId' => $result['player_id'],
					'machineId' => $result['machine_id'],
					'frontendId' => $result['frontend_id'],
					'betAmount' => $result['bet_amount'],
					'generatedNumbers' => $result['generated_numbers'],
					'selectedNumbers' => $result['selected_numbers'],
					'winString' => $result['win_string'],
					'winAmount' => $result['win_amount'],
					'datetime' => $result['datetime'],
					'amountType' => $result['amount_type'],
					'pjpWinstatus' => $result['pjp_winstatus'],
					'pjpId' => $result['pjp_id'],
					'pjpRng' => $result['pjp_rng'],
					'pjpWinAmount' => $result['pjp_win_amount'],
					'wageredCurrency' => $result['wagered_currency'],
					'runningMachineId' => $result['running_machine_id'],
					'gameFlavour' => $result['game_flavour'],
					'spinType' => $result['spin_type']);
			}
		}
		return NULL;
	}
}