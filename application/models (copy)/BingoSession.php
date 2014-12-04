<?php

/**
 * bingoSession
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6401 2009-09-24 16:12:04Z guilhermeblanco $
 */
class BingoSession extends BaseBingoSession
{
	public function getLatestInsertData()
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
					->from('BingoSession b')
					->orderBy('b.id DESC')
					->limit(1);
					
		try
		{
			$result = $query->fetchArray();
		}
		catch(Exception $e)
		{
			return false;
		}
		return $result[0]['id'];
	}
	
	public function getAllSessions()
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
					->from('BingoSession');
					
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
	
	public function getSessionData($bingoSessionId)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
						->from('BingoSession bs')
						->where('bs.id = ?', $bingoSessionId);
						
		try
		{
			$result = $query->fetchArray();
		}
		catch(Exception $e)
		{
			return false;
		}
		return array(
			'id' => $result[0]['id'],
			'name' => $result[0]['name'],
			'description' => $result[0]['description']);
	}
	
	public function updatebingosession($sessiondata)
	{
		
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
					->update('BingoSession bs')
					->set('bs.name', '?',$sessiondata["name"])
					->set('bs.description', '?',$sessiondata["description"])
					->where('bs.id =?',$sessiondata["id"]);
					
					
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
	
	public function insertbingosession($sessiondata)
	{
		
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
	
		
		$sessionsobj = new BingoSession();
		
		$sessionsobj->description = $sessiondata["description"];
		$sessionsobj->name = $sessiondata["name"];
		
			
		try
		{
			$sessionsobj->save();
		}
		catch(Exception $e)
		{
			echo $e;
			Zenfox_Debug::dump($result);exit;
			return false;
		}
		return true;
	}
	
}