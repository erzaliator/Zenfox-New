<?php

/**
 * systemTag
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6401 2009-09-24 16:12:04Z guilhermeblanco $
 */
class SystemTag extends BaseSystemTag
{
	public function getSystemTags()
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
						->select('DISTINCT s.tag as tagname')
						->from('SystemTag s')
						->where('s.tag not like "player%"')
						->andwhere('s.tag not like "tracker%"');
								
		$result = $query->fetchArray();
		return $result;
	}
	
	public function getPlayerTags()
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
	
		$query = Zenfox_Query::create()
		->select('DISTINCT s.tag as tagname')
		->from('SystemTag s')
		->where('s.tag like "player%"');
	
		$result = $query->fetchArray();
		return $result;
		
	}
	
	public function getTrackerTags()
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
	
		$query = Zenfox_Query::create()
		->select('DISTINCT s.tag as tagname')
		->from('SystemTag s')
		->where('s.tag like "tracker%"');
	
		$result = $query->fetchArray();
		return $result;
	}
}