<?php
class FixedPot extends BaseFixedPot
{
	public function getData($gameId)
	{
		$conn = Zenfox_Partition::getInstance()->getCommonConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		//$result = Doctrine::getTable('FixedPot')->findByGameId($gameId)->orderBy('part_id');
		$query = Zenfox_Query::create()
					->from('FixedPot fp')
					->where('fp.game_id = ?', $gameId)
					->orderBy('fp.id');
					
		$result = $query->fetchArray();
		$fixedPotData = array();
		$i = 0;
		foreach($result as $data)
		{
			$fixedPotData[$i]['fixedPotId'] = $data['id'];
			$fixedPotData[$i]['gameId'] = $data['game_id'];
			$fixedPotData[$i]['partId'] = $data['part_id'];
			$fixedPotData[$i]['callNumber']= $data['call_number'];
			$fixedPotData[$i]['realAmount']= $data['real_amount'];
			$fixedPotData[$i]['bbsAmount'] = $data['bbs_amount'];
			$i++;
		}
		return $fixedPotData;
	}
}