<?php
class FixedPotConfig extends Doctrine_Record
{
	public function __construct()
	{
		parent::__construct();
		
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
		//Zenfox_Debug::dump($data, 'fixeddata');
		$length = count($data)-2;
		$index = 1;
		while($index <= $length)
		{
			$real = "RealAmount".$index;
			$bbs = "BbsAmount".$index;
			
			$fixedPotPayment = new BingoFixedPotPayment();
			$fixedPotPayment->game_id = $gameId;
			$fixedPotPayment->part_id = $data['partId'];
			$fixedPotPayment->call_number = $data[$index];
			$fixedPotPayment->real_amount = $data[$real];
			$fixedPotPayment->bbs_amount = $data[$bbs];
		
			try
			{
				$fixedPotPayment->save();
			}
			catch(Exception $e)
			{
				print('Unable to save FixedPotPayment data') . $e;
				exit();
			}
		
			$index++;
		}
		
		
		
		return true;
	}
	
	public function updateData($data)
	{	
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$length = count($data)-2;
		$index = 1;
		while($index <= $length)
		{
			$real = "RealAmount".$index;
			$bbs = "BbsAmount".$index;
			
			$query = Zenfox_Query::create()
					->update('BingoFixedPotPayment fpp')
					->set('fpp.part_id', '?', $data['partId'])
					->set('fpp.call_number', '?', $data[$index])
					->set('fpp.real_amount', '?', $data[$real])
					->set('fpp.bbs_amount', '?', $data[$bbs])
					->where('fpp.id = ?', $data['fixedPotId']);
					
			try
			{
				$query->execute();
			}
			catch(Exception $e)
			{
				print('Unable to update FixedPotPayment data') . $e;
				exit();
			}
			$index++;
		}
			
	
		return true;
	}
}
