<?php

/**
 * BingoSessionGame
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6401 2009-09-24 16:12:04Z guilhermeblanco $
 */
class BingoSessionGame extends BaseBingoSessionGame
{
	public function getSessionGamesList($bingoSessionId)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
						->from('BingoSessionGame bs')
						->where('bs.session_id = ?', $bingoSessionId)
						->orderBy('bs.sequence');
						
		try
		{
			$result = $query->fetchArray();
		}
		catch(Exception $e)
		{
			return false;
		}
		return $result;
	}
	
	public function updatebingogames($bingoSessionId,$sessiongames)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
					->delete('BingoSessionGame bsg')
					->where('bsg.session_id = ?', $bingoSessionId);
					
		try
		{
			$query->execute();
		}
		catch(Exception $e)
		{
			return false;
		}
		
		$gamescount = count($sessiongames)/2;
		$index =1;
		
		while($index <= $gamescount)
		{
			if(($sessiongames["checked".$index] == 1 ) && ($sessiongames["Sequencenumber".$index] != -1))
			{
				$sessiongameobj[$index] = new BingoSessionGame();
				
				$sessiongameobj[$index]->session_id = $bingoSessionId;
				$sessiongameobj[$index]->game_id = $sessiongames["Sequencenumber".$index];
				$sessiongameobj[$index]->sequence = $index;
					
				try
				{
					$sessiongameobj[$index]->save();
				}
				catch(Exception $e)
				{
					return false;
				}
			}
			$index++;
		}
		
		return true;
	}
}