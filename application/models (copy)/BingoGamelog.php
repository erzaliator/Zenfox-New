<?php

/**
 * BingoGamelog
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6401 2009-09-24 16:12:04Z guilhermeblanco $
 */
class BingoGamelog extends BaseBingoGamelog
{
	public function getgamelogids($starttime , $endtime, $roomId,$allowedgameids)
	{
		$conns = Zenfox_Partition::getInstance()->getConnections(-1);
		
		foreach($conns as $conn)
		{
			Doctrine_Manager::getInstance()->setCurrentConnection($conn);
	
			$query = Zenfox_Query::create()
				->select('bg.gamelog_id')
				->from('BingoGamelog bg')
				->where('bg.start_time >= ?',$starttime)
				->andWhere('bg.start_time <=?',$endtime)
				->andWhere('bg.room_id  = ?',$roomId)
				->andWhereIn('bg.game_id',$allowedgameids);
				
			$result[] = $query->fetchArray();	
			//Zenfox_Debug::dump($allowedgamesnames);exit;
		}
		
		if($result)
		{
			return array_merge($result[0], $result[1]);
		}
		
		return false;
	}
	
	public function getGamelogById($gamelogId, $playerId)
	{
		$conn = Zenfox_Partition::getInstance()->getConnections($playerId);
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
					->from('BingoGamelog bg')
					->where('bg.gamelog_id = ?', $gamelogId);
		
		try
		{
			$result = $query->fetchArray();
		}
		catch(Exception $e)
		{
			Zenfox_Debug::dump($e, 'exception', true, true);
		}
		Zenfox_Debug::dump($result, 'result');
	}
}