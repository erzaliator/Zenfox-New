<?php

/**
 * KycDocuments
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7691 2011-02-04 15:43:29Z jwage $
 */
class KycDocuments extends BaseKycDocuments
{
	public function insertdoc($playerid,$kycid,$path)
	{
		$conns = Zenfox_Partition::getInstance()->getConnections($playerid);
		$partition  = Doctrine_Manager::getInstance()->setCurrentConnection($conns);
			
			
		$this->player_id = $playerid;
		$this->kyc_id = $kycid;
		$this->document_path = $path;
			
		$this->save($partition);
	
	}
	
	public function deletedocs($playerid)
	{
		$conns = Zenfox_Partition::getInstance()->getConnections($playerid);
		$partition  = Doctrine_Manager::getInstance()->setCurrentConnection($conns);
	
		$query = Zenfox_Query::create()
		->delete('KycDocuments  k')
		->where('k.player_id  =?',$playerid);
	
		$query->execute();
	
	}
	
	
	public function getdocnumber($playerid,$kycid)
	{
		$conns = Zenfox_Partition::getInstance()->getConnections($playerid);
		$partition  = Doctrine_Manager::getInstance()->setCurrentConnection($conns);
	
		$query = Zenfox_Query::create()
		->select('max(k.document_id)')
		->from('KycDocuments  k')
		->where('k.player_id  =?',$playerid)
		->andwhere('k.kyc_id =?', $kycid);
	
		$result = $query->fetchArray();
		$max = $result[0]["max"];

		return ++$max;
	
	}
	
	public function getdocpaths($playerid, $kycid)
	{
		$conns = Zenfox_Partition::getInstance()->getConnections($playerid);
		$partition  = Doctrine_Manager::getInstance()->setCurrentConnection($conns);
		
		$query = Zenfox_Query::create()
		->from('KycDocuments  k')
		->where('k.player_id  =?',$playerid)
		->andwhere('k.kyc_id =?', $kycid);
		
		$result = $query->fetchArray();
		
		return $result;
	}
	
	
	
}