<?php
class VariablePot extends BaseVariablePot
{
	public function getData($gameId)
	{
		$conn = Zenfox_Partition::getInstance()->getCommonConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		//$result = Doctrine::getTable('VariablePot')->findByGameId($gameId);
		$query = Zenfox_Query::create()
					->from('VariablePot vp')
					->where('vp.game_id = ?', $gameId)
					->orderBy('vp.id');
					
		$result = $query->fetchArray();
		$varPotData = array();
		$i = 0;
		foreach($result as $data)
		{
			$varPotData[$i]['varPotId'] = $data['id'];
			$varPotData[$i]['gameId'] = $data['game_id'];
			$varPotData[$i]['partId'] = $data['part_id'];
			$varPotData[$i]['realReturn'] = $data['real_return'];
			$varPotData[$i]['bbsReturn'] = $data['bbs_return'];
			$varPotData[$i]['minPotReal'] = $data['min_pot_real'];
			$varPotData[$i]['minPotBbs'] = $data['min_pot_bbs'];
			$varPotData[$i]['maxPotReal'] = $data['max_pot_real'];
			$varPotData[$i]['maxPotBbs'] = $data['max_pot_bbs'];
			$i++;
		}
		return $varPotData;
	}
}
