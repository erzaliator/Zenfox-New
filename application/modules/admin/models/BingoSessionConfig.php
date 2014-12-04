<?php
class BingoSessionConfig
{
	public function __construct()
	{
		//parent::__construct();
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
	}
	
	public function insertData($data)
	{
		$bingoSession = new BingoSession();
		$bingoSession->name = $data['name'];
		$bingoSession->description = $data['description'];
		try
		{
			$bingoSession->save();
		}
		catch(Exception $e)
		{
			return false;
		}
		$bingoSessionId = $bingoSession->getLatestInsertData();
		return $bingoSessionId;
	}
	
	public function updateData($data)
	{
		$query = Zenfox_Query::create()
					->update('BingoSession bs')
					->set('bs.description', '?', $data['description'])
					->where('bs.id = ?', $data['id']);
					
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