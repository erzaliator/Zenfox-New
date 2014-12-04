<?php
class BingoGame extends BaseBingoGame
{
	public function getAllData()
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
					->from('BingoGame');
					
		$result = $query->fetchArray();
		return $result;
	}
	
	public function getData($bingoGameId)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		//$result = Doctrine::getTable('BingoGame')->findOneById($bingoGameId);
		
		$query = Zenfox_Query::create()
					->from('BingoGame b')
					->Where('b.id =?', $bingoGameId);
					
		$data = $query->fetchArray();
		//FIXME do it for pattern name
		$result = $data[0];
		
		$result["buy_time"] = $result['buy_time']/1000;
		$result["call_delay"] = $result['call_delay']/1000;
		
		return array(
				'bingoGameId' => $result['id'],
				'name' => $result['name'],
				'description' => $result['description'],
				'gameFlavour' => $result['game_flavour'],
				'gameType' => $result['game_type'],
				'amountType' => $result['amount_type'],
				'potType' => $result['pot_type'],
				'patternId' => $result['pattern_id'],
				'noOfParts' => $result['no_of_parts'],
				'cardPrice' => $result['card_price'],
				'minCards' => $result['min_cards'],
				'maxCards' => $result['max_cards'],
				'freeRatio' => $result['free_ratio'],
				'buyTime' => $result['buy_time'],
				'callDelay' => $result['call_delay'],
				'pjpEnabled' => $result['pjp_enabled'],
				'preBuyEnabled' => $result['prebuy_enabled'],
				'realReturn' => $result['real_return'],
				'bbsReturn' => $result['bbs_return'],
				'minPotReal' => $result['min_variable_pot_real'],
				'minPotBbs' => $result['min_variable_pot_bbs'],
				'maxPotReal' => $result['max_variable_pot_real'],
				'maxPotBbs' => $result['max_variable_pot_bbs']);
	}
	
	public function getLatestInsData()
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
					->from('BingoGame b')
					->orderBy('b.id DESC')
					->limit(1);
					
		$result = $query->fetchArray();
		//Zenfox_Debug::dump($result, 'result', true, true);
		return $result;
	}
}
