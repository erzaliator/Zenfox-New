<?php

/**
 * BingoRunningRoom
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6401 2009-09-24 16:12:04Z guilhermeblanco $
 */
class BingoRunningRoom extends BaseBingoRunningRoom
{
	public function getAllRunningRooms()
	{
		$connection = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($connection);

		$query = Zenfox_Query::create()
				->from('BingoRunningRoom b')
				->orderBy('b.room_id asc');

		try
		{
			$result = $query->fetchArray();
		}
		catch(Exception $e)
		{
			//Zenfox_Debug::dump($e, 'Exception');
		}
		$bingoData = array();
		$index = 0;
		if($result)
		{
			$bingoPjp = new BingoPjp();
			$pjp = new Pjp();
			foreach($result as $runningRoomData)
			{
				/*$bingoData[$index]['room_id'] = $runningRoomData['room_id'];
				$bingoData[$index]['room_name'] = $runningRoomData['room_name'];
				$bingoData[$index]['game_type'] = $runningRoomData['game_flavour'];
				$bingoData[$index]['players'] = $runningRoomData['total_players'];
				$bingoData[$index]['price'] = round($runningRoomData['card_price'], 2);
				$bingoData[$index]['pool_price'] = round($runningRoomData['real_pot'] + $runningRoomData['bbs_pot'], 2);
				$pjpIds = $bingoPjp->getPjpByGameId($runningRoomData['game_id']);
				$jackPot = $pjp->getJackpot($pjpIds);
				$bingoData[$index]['jackpot'] = round($jackPot, 2);
				$bingoData[$index]['session_id'] = $runningRoomData['session_id'];
				$bingoData[$index]['currency'] = $runningRoomData['currency'];
				$index++;*/
				if($runningRoomData['room_id'])
				{
					$bingoData[$index]['game_id'] = $runningRoomData['room_id'];
					$bingoData[$index]['room_name'] = $runningRoomData['room_name'];
					$bingoData[$index]['game_type'] = $runningRoomData['game_flavour'];
					$bingoData[$index]['players'] = $runningRoomData['total_players'];
					$bingoData[$index]['price'] = round($runningRoomData['card_price'], 2);
					$bingoData[$index]['pool_price'] = round($runningRoomData['real_pot'] + $runningRoomData['bbs_pot'], 2);
					$pjpIds = $bingoPjp->getPjpByGameId($runningRoomData['game_id']);
					$jackPot = $pjp->getJackpot($pjpIds);
					$bingoData[$index]['jackpot'] = round($jackPot, 2);
					$bingoData[$index]['session_id'] = $runningRoomData['session_id'];
					$bingoData[$index]['currency'] = $runningRoomData['currency'];
					$bingoData[$index]['amount_type'] = $runningRoomData['amount_type'];
					$bingoData[$index]['flavour'] = $runningRoomData['game_flavour'];
					$index++;
				}
			}
		}
		return $bingoData;
	}
	
	public function getRunningRoomData($RoomId)
	{
		$connection = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($connection);

		$query = Zenfox_Query::create()
				->from('BingoRunningRoom brr')
				->where('brr.room_id =?' , $RoomId);

		try
		{
			$result = $query->fetchArray();
		}
		catch(Exception $e)
		{
			//Zenfox_Debug::dump($e, 'Exception');
		}
		return $result;
	}
	
	public function getroomIdfromsfsroomId($sfsroomId)
	{
		$connection = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($connection);

		$query = Zenfox_Query::create()
				->select('brr.sfs_room_id')
				->from('BingoRunningRoom brr')
				->where('brr.sfs_room_id =?' , $sfsroomId);

		try
		{
			$result = $query->fetchArray();
		}
		catch(Exception $e)
		{
			//Zenfox_Debug::dump($e, 'Exception');
		}
		return $result[0]["room_id"];
	}
	
	public function getprebaughtplayersfromsfsroomId($sfsroomId)
	{
		$connection = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($connection);

		$query = Zenfox_Query::create()
				->select('brr.prebuy_list')
				->from('BingoRunningRoom brr')
				->where('brr.sfs_room_id =?' , $sfsroomId);

		try
		{
			$result = $query->fetchArray();
		}
		catch(Exception $e)
		{
			//Zenfox_Debug::dump($e, 'Exception');
		}
		
		$players = explode("[",$result[0]["prebuy_list"]);
		$players = explode("]",$players[1]);
		$players = explode(",",$players[0]);
		return $players;
	}
}