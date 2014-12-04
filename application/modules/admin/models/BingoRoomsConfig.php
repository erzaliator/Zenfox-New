<?php
class BingoRoomsConfig
{
	public function __construct()
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
	}
	
	public function insertData($data)
	{
		$bingoRoom = new BingoRoom();
		$bingoRoom->name = $data['name'];
		$bingoRoom->description = $data['description'];
		$bingoRoom->allowed_game_flavours = $data['gameFlavours'];
		$bingoRoom->currency = $data['roomCurrency'];
		$bingoRoom->enabled = $data['enabled'];
		
		try
		{
			$bingoRoom->save();
		}
		catch(Exception $e)
		{
			return false;
		}
		
		$bingoRoomId = $bingoRoom->getLatestInsertData();
		return $bingoRoomId;
	}
	
	public function updateData($data)
	{
		$query = Zenfox_Query::create()
					->update('BingoRoom br')
					->set('br.name', '?', $data['name'])
					->set('br.description', '?', $data['description'])
					->set('br.allowed_game_flavours', '?', $data['gameFlavours'])
					->set('br.currency', '?', $data['roomCurrency'])
					->set('br.enabled', '?', $data['enabled'])
					->where('br.id = ?', $data['bingoRoomId']);
					
		try
		{
			$query->execute();
		}
		catch(Exception $e)
		{
			return false;
		}
		return true;
	}
}