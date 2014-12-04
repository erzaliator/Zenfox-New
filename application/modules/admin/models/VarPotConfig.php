<?php
class VarPotConfig extends Doctrine_Record
{
	public function __construct()
	{
		parent::__construct();
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
	}
	public function insertData($data)
	{
		$gameId = $data['gameId'];
		
		if(!$gameId)
		{
			$bingo = new BingoGame();
			$latestInsertedData = $bingo->getLatestInsData();
			$gameId = $latestInsertedData[0]['id'];
		}
		
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		//Zenfox_Debug::dump($data, 'vardata');
		
		$varPotpayment = new BingoVariablePotPayment();
		$varPotpayment->game_id = $gameId;
		$varPotpayment->part_id = $data['partId']-1;
		$varPotpayment->real_pot_fraction = $data['realReturn'];
		$varPotpayment->bbs_pot_fraction = $data['bbsReturn'];
		$varPotpayment->ntogo = 0;//$data['ntogo']; //zero for now as ntogo's are not configured
		
		try
		{
			$varPotpayment->save();
		}
		catch(Exception $e)
		{
			print('Unable to save VariablePotPayment data') . $e;
			exit();
		}

		return true;
	}
	
	public function updateData($data)
	{		
		
			$query = Zenfox_Query::create()
						->update('BingoVariablePotPayment vpp')
						->set('vpp.real_pot_fraction', '?', $data['realReturn'])
						->set('vpp.bbs_pot_fraction', '?', $data['bbsReturn'])
						->where('vpp.game_id = ?', $data['gameId'])
						->andwhere('vpp.part_id = ?', $data['partId']);
						
		try
		{
			$query->execute();
		}
		catch(Exception $e)
		{
			print('Unable to update VariablePotPayment data') . $e;
			exit();
		}
		
		return true;
	}
}
