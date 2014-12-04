<?php
class RunningMachine extends Doctrine_Record 
{
	function saveMachineData($nameSpace, $subForms) 
	{
		try 
		{
			$session = new Zend_Session_Namespace ( $nameSpace );
			foreach ( $subForms as $subForm ) 
			{
				$data = $session->subFormData [$subForm];
				if ($subForm == 'form1') 
				{
					$data ['gameFlavour'] = $session->gameFlavour;
					if ($session->currAction == 'create') 
					{
						if($session->value == 'roulette')
						{
							$rouletteConfig = new RouletteConfig ();
						    $rouletteConfig->insertMachineData ( $data );
						}
						else if( $session->value == 'slots' )
						{
							$slotConfig = new SlotConfig();
							$slotConfig->insertMachineData($data);
						}
						else if( $session->value == 'keno' )
						{
							$kenoConfig = new RunningKenoConfig();
							$kenoConfig->insertData($data);
						}
						
					}
					
					if ($session->currAction == 'edit') 
					{
						if($session->value == 'roulette')
						{
							$rouletteConfig = new RouletteConfig ();
						    $rouletteConfig->updateMachineData ( $session->runningMachineId, $data );
						}
						else if( $session->value == 'slots' )
						{
							$slotConfig = new SlotConfig();
							$slotConfig->updateMachineData( $session->runningMachineId, $data );
						}
						else if( $session->value == 'keno' )
						{
							$kenoConfig = new RunningKenoConfig();
							$kenoConfig->updateRunningKeno( $session->runningMachineId, $data );
						}
					}
				} 
				else 
				{
					$data ['pjpId'] = $session->pjpIds [$subForm];
					$data ['gameFlavour'] = $session->gameFlavour;
					
					if ($session->currAction == 'create') 
					{
						if($session->value == 'roulette')
						{
							$roulette = new RunningRoulette();
					    	$rouletteData = $roulette->getLatestMachineData();
					    	$data['gameId'] = $rouletteData['runningRouletteId'];
						}
						else if( $session->value == 'slots' )
						{
							$slot = new RunningSlot();
					    	$slotData = $slot->getLatestMachineData();
					    	$data['gameId'] = $slotData['runningSlotId'];
						}
						else if( $session->value == 'keno' )
						{
							$keno = new RunningKeno();
					    	$kenoData = $keno->getLatestMachineData();
					    	$data['gameId'] = $kenoData['runningKenoId'];
						}
						$pjpConfig = new PjpConfig();
					   	$pjpConfig->insertPjpDetail($data); 
						
					}
					
					if ($session->currAction == 'edit') 
					{
						$data['gameId'] = $session->runningMachineId;
						$pjpConfig = new PjpConfig();
	    				$pjpConfig->updatePjpDetail($data, $data['pjpId']);
					}
				}
			}
			return 'Your data is Saved';
		}
		catch (Exception $e)
		{
			print('Unable to Save data') . $e;
			return false;
		}
		
	}
}