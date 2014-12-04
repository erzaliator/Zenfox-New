<?php
class RunningKenoConfig extends Doctrine_Record
{
	public function insertData($data)
	{
		//$this->storeData($runningKeno,$data);
		$conn = Zenfox_Partition::getInstance()->getConnections(0);
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		//echo 'in insertkeno******';
		$runningKeno = new RunningKeno();
		
		$this->storeData($runningKeno,$data);
	}
	
	/**
	 * This method updates the Running Keno by Id
	 * @param $id
	 * @return unknown_type
	 */
	
	public function updateRunningKeno($id,$data)
	{
		$conn = Zenfox_Partition::getInstance()->getConnections(0);
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$runningKeno = Doctrine::getTable('RunningKeno')->findOneById($id);
		$this->storeData($runningKeno,$data);
	}
	
	public function storeData($runningKeno,$data)
	{
		
		
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
		
		$runningKeno->machine_name = $data['machineName'];
		$runningKeno->game_flavour = $data['gameFlavour'];
		$runningKeno->description = $data['description'];
		$runningKeno->denominations = $denomString;
		$runningKeno->default_denomination = $data['defaultDenomination'];
		$runningKeno->min_bet = $data['minBet'];
		$runningKeno->min_nums = $data['minNums'];
		$runningKeno->max_bet = $data['maxBet'];
		$runningKeno->max_nums = $data['maxNums'];
		$runningKeno->enabled = $data['enabled'];
		$runningKeno->machine_id = $data['machineId'];
		$runningKeno->pjp_enabled = $data['pjpEnabled'];
		$runningKeno->amount_type = $data['amountType'];
		$runningKeno->max_coins = $data['maxCoins'];
		$runningKeno->min_coins = $data['minCoins'];
		
		$runningKeno->save();
	}
}
