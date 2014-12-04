<?php
class CsrIds extends Doctrine_Record
{
	public function __construct()
	{
		parent::__construct();
		$connName = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($connName);
	}
	
	public function getIds()
	{
//		$connName = Zenfox_Partition::getInstance()->getConnections(0);
//		Doctrine_Manager::getInstance()->setCurrentConnection($connName);
	
		$query = Zenfox_Query::create()
					->select('c.id, c.alias')
					->from('Csr c');

		$result = $query->fetchArray();
		return $result;
	}
	
	public function getCsrName($csrId)
	{
//		$connName = Zenfox_Partition::getInstance()->getConnections(0);
//		Doctrine_Manager::getInstance()->setCurrentConnection($connName);
		
		$result = Doctrine::getTable('Csr')->findOneById($csrId);
		return $result['name'];
	}
	
	public function getPlayerLogin($playerId)
	{
//		$connName = Zenfox_Partition::getInstance()->getConnections(0);
//		Doctrine_Manager::getInstance()->setCurrentConnection($connName);
		
		$result = Doctrine::getTable('Account')->findOneByPlayerId($playerId);
		return $result['login'];
	}
	
	public function getUserId($login)
	{
//		$connName = Zenfox_Partition::getInstance()->getConnections(0);
//		Doctrine_Manager::getInstance()->setCurrentConnection($connName);
		
		$result = Doctrine::getTable('Account')->findOneByLogin($login);
		return $result['player_id'];
	}
	
	public function getAffiliateId($alias)
	{
		$result = Doctrine::getTable('Affiliate')->findOneByAlias($alias);
		return $result['affiliate_id'];
	}
	
	public function getAffiliateAlias($affiliateId)
	{
		$result = Doctrine::getTable('Affiliate')->findOneByAffiliate_id($affiliateId);
		return $result['alias'];
	}
	
	public function getForwardedCsrName($time, $userId)
	{
		$csrId = $this->getCsrId($time, $userId);
		
		$connName = Zenfox_Partition::getInstance()->getConnections(0);
		Doctrine_Manager::getInstance()->setCurrentConnection($connName);
		
		$result = Doctrine::getTable('Csr')->findOneById($csrId);
		return $result['alias'];
	}
	
	public function getCsrId($time, $userId)
	{
		$conn = Zenfox_Partition::getInstance()->getConnections($userId);
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$result = Doctrine::getTable('Forwarded')->findOneByForwardedTime($time);
		return $result['forwarded_to'];
	}
}