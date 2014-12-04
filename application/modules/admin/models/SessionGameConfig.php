<?php
class SessionGameConfig
{
	public function __construct()
	{
		//parent::__construct();
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
	}
	public function insertData($data)
	{
		$sessionGame = new SessionGame();
		$sessionGame->session_id = $data['sessionId'];
		$sessionGame->game_id = $data['gameId'];
		$sessionGame->sequence = $data['sequence'];
		try
		{
			$sessionGame->save();
		}
		catch(Exception $e)
		{
			return false;
		}
		return true;
	}
	
	public function deleteData($sessionId, $gameId)
	{
		$query = Zenfox_Query::create()
						->delete('SessionGame sg')
						->where('sg.session_id = ?', $sessionId)
						->andWhere('sg.game_id = ?', $gameId);
						
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
	
	public function updateData($data)
	{
		$query = Zenfox_Query::create()
						->update('SessionGame sg')
						->set('sg.sequence', '?', $data['sequence'])
						->where('sg.session_id = ?', $data['session_id'])
						->andWhere('sg.game_id = ?', $data['game_id']);
				
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