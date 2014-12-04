<?php
class RoomsSessionConfig
{
	public function __construct()
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
	}
	
	public function insertData($data)
	{
		$roomsSession = new RoomsSession();
		$roomsSession->room_id = $data['bingoRoomId'];
		$roomsSession->session_id = $data['sessionId'];
		$roomsSession->duration = 60;
		$roomsSession->sequence = $data['sequence'];
		$roomsSession->day = $data['day'];
		
		try
		{
			$roomsSession->save();
		}
		catch(Exception $e)
		{
			return false;
		}
		return true;
	}
	
	public function updateData($data)
	{
		$query = Zenfox_Query::create()
					->update('RoomsSession rs')
					->set('rs.session_id', '?', $data['sessionId'])
					->where('rs.room_id = ?', $data['bingoRoomId'])
					->andWhere('rs.sequence = ?', $data['sequence'])
					->andWhere('rs.day = ?', $data['day']);
					
		try
		{
			$update = $query->execute();
		}
		catch(Exception $e)
		{
			return false;
		}
		if(!$update)
		{
			$insert = $this->insertData($data);
		}
		return $insert;
	}
}