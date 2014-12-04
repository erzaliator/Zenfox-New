<?php

/**
 * PlayerSessions
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6401 2009-09-24 16:12:04Z guilhermeblanco $
 */
class PlayerSessions extends BasePlayerSessions
{
	public function getAllSessions()
	{
		$connections = Zenfox_Partition::getInstance()->getConnections(-1);
		$allSessions = array();
		
		$date = new Zend_Date();
		$currentTime = $date->get(Zend_Date::W3C);
		$currentTime = str_replace('T', ' ', $currentTime);
		
		foreach($connections as $conn)
		{
			Doctrine_Manager::getInstance()->setCurrentConnection($conn);
			
			$query = Zenfox_Query::create()
						->from('PlayerSessions ps')
						->where('ps.session_expiry >= ?', $currentTime);
			
			try
			{
				$result = $query->fetchArray();
			}
			catch(Exception $e)
			{
				Zenfox_Debug::dump($e, 'exception', true, true);
			}
			if($result)
			{
				foreach($result as $sessionData)
				{
					$allSessions[] = $sessionData;
				}
			}
		}
		return $allSessions;
	}
	
	public function getfrontendwisesessions()
	{
		
		$connections = Zenfox_Partition::getInstance()->getConnections(-1);
		$allSessions = array();
		
		 $today = new Zend_Date();
		$dateTime = explode('T',$today->get(Zend_Date::W3C));
        $date = $dateTime[0];
        $time = $dateTime[1];
        $time = explode('+',$time);
        $time = $time[0];
        $datetime = $date.' '.$time;

		$frontendobject = new Frontend();
		$frontends = $frontendobject->getFrontends();
		$length = count($frontends);
		$index = 0;
		
		while($index < $length )
		{
			$newfrontendlist[$frontends[$index]['id']] = $frontends[$index]['name'];
			$index++;
		}
		
		foreach($connections as $conn)
		{
			Doctrine_Manager::getInstance()->setCurrentConnection($conn);
			
			$query = Zenfox_Query::create()
						->select('count(ps.player_id) as playercount , ps.frontend_id')
						->from('PlayerSessions ps')
						->where('ps.session_expiry >= ?',$datetime)
						->groupBy('ps.frontend_id');
			
			try
			{
				$result = $query->fetchArray();
			}
			catch(Exception $e)
			{
				echo $e;
				Zenfox_Debug::dump($e, 'exception', true, true);
			}
			if($result)
			{
				foreach($result as $sessionData)
				{
					$allSessions[] = $sessionData;
				}
			}
		}
		
		
		//Zenfox_Debug::dump($allSessions);
		$length = count($allSessions);
		$index = 0;
		$playerlist = array();
		
		while($index< $length)
		{
			$playerlist[$allSessions[$index]["frontend_id"]]["Frontend Name"] = $newfrontendlist[$allSessions[$index]["frontend_id"]];
			$playerlist[$allSessions[$index]["frontend_id"]]["Players Count"] += $allSessions[$index]["playercount"];
		   
			$index++;
		}
		
		return $playerlist;
	}
	
	public function getfrontendsessions($frontendId)
	{
		$connections = Zenfox_Partition::getInstance()->getConnections(-1);
		$frontendSessions = array();
		
		$today = new Zend_Date();
		$dateTime = explode('T',$today->get(Zend_Date::W3C));
        $date = $dateTime[0];
        $time = $dateTime[1];
        $time = explode('+',$time);
        $time = $time[0];
        $datetime = $date.' '.$time;
        
		foreach($connections as $conn)
		{
			Doctrine_Manager::getInstance()->setCurrentConnection($conn);
			
			$query = Zenfox_Query::create()
						->from('PlayerSessions ps')
						->where('ps.frontend_id =?',$frontendId)
						->andWhere('ps.session_expiry >= ?',$datetime);
			
			try
			{
				$result = $query->fetchArray();
			}
			catch(Exception $e)
			{
				Zenfox_Debug::dump($e, 'exception', true, true);
			}
			if($result)
			{
				foreach($result as $sessionData)
				{
					$frontendSessions[] = $sessionData;
				}
			}
		}
		
		$frontendobject = new Frontend();
		$frontends = $frontendobject->getFrontends();
		$length = count($frontends);
		$index = 0;
		
		while($index < $length )
		{
			$newfrontendlist[$frontends[$index]['id']] = $frontends[$index]['name'];
			$index++;
		}
		
		$length = count($frontendSessions);
		$index = 0;
		$playerlist = array();
		
		while($index< $length)
		{
		   $playerlist[$index]["Player Id"] = $frontendSessions[$index]["player_id"];
		   $playerlist[$index]["Login Name"] = $frontendSessions[$index]["login"];
		   $playerlist[$index]["Login Time"] = $frontendSessions[$index]["login_time"];
		   $playerlist[$index]["Last Activity"] = $frontendSessions[$index]["last_activity"];
		   $playerlist[$index]["Session Expiry"] = $frontendSessions[$index]["session_expiry"];
		   $playerlist[$index]["IP Address"] = $frontendSessions[$index]["ip_address"];
		   $playerlist[$index]["Frontend Name"] = $newfrontendlist[$frontendSessions[$index]["frontend_id"]];
		   $playerlist[$index]["Player Frontend Name"] = $newfrontendlist[$frontendSessions[$index]["player_frontend_id"]];
			$index++;
		}
		return $playerlist;
	}
}