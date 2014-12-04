<?php

/**
 * AccountDetail
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6401 2009-09-24 16:12:04Z guilhermeblanco $
 */
class AccountDetail extends BaseAccountDetail
{
	public function getBuddy($playerId)
	{ 
		$connName = Zenfox_Partition::getInstance()->getConnections($playerId);
		$partition = Doctrine_Manager::getInstance()->setCurrentConnection($connName);
		//echo Doctrine_Manager::getInstance()->getCurrentConnection()->getName();
	
		
		$query = Zenfox_Query::create()
						->from('AccountDetail ad')
						->where('ad.buddy_id = ? ', $playerId);
						
		$data = $query->fetchArray();
		
			print_r($data);
			return $data;
		
	}
	
 	public function getData($playerId)
      {
      		
               $conn = Zenfox_Partition::getInstance()->getConnections($playerId);
               Doctrine_Manager::getInstance()->setCurrentConnection($conn);


               $query = Zenfox_Query::create()
               ->from('AccountDetail ad')
               ->where('ad.player_id = ?', $playerId);

               try
               {
                       $result = $query->fetchArray();
                       

               }
               catch(Exception $e)
               {
               
                       return false;
               }
               if($result)
               {
               		
                       return array(
                                       'balance'=> $result[0]['balance']
                       );
               }
               return NULL;

       }
       
       public function getDetails($playerId)
       {
       
       	$conn = Zenfox_Partition::getInstance()->getConnections($playerId);
       	Doctrine_Manager::getInstance()->setCurrentConnection($conn);
       
       
       	$query = Zenfox_Query::create()
       	->from('AccountDetail ad')
       	->where('ad.player_id = ?', $playerId);
       
       	try
       	{
       		$result = $query->fetchArray();
       		 
       
       	}
       	catch(Exception $e)
       	{
       		 
       		return false;
       	}
   
       	return $result[0];
       
       }
}