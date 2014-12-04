<?php

/**
 * CsrGmsGroup
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6401 2009-09-24 16:12:04Z guilhermeblanco $
 */
class CsrGmsGroup extends BaseCsrGmsGroup implements Zend_Acl_Role_Interface
{
	public function getRoleId()
	{
		//FIXME:: Ideally this should be <roleType>-<name>
		return $this->gms_group_id;
	}
	public function getFrontendList($csrId, $getId = null)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		$partition = Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
							->from('CsrGmsGroup c')
							->where('c.csr_id = ?',$csrId);
		try 
		{
			$array = $query->fetchArray();
		}						
		catch(Exception $e)
		{
			return false;	
		}
		
		if(count($array) == 0)
		{
			return false;
		}
		
		foreach($array as $record)
		{
			$groupList[] = $record['gms_group_id'];
		}
		
		
		$query = Zenfox_Query::create()
							->select('DISTINCT (g.frontend_id) as frontend_id')
							->from('GmsGroupFrontend g')
							->whereIn('g.gms_group_id',$groupList);

		try 
		{
			$array = $query->fetchArray();
			
		}
		catch(Exception $e)
		{
			return false;
		}				
					
		if(count($array) == 0)
		{
			return false;
		}
		
		foreach($array as $record)
		{
			$frontIdList[] = $record['frontend_id'];
		}
		
		if($getId) {
			return $frontIdList;
		}
		
		$query = Zenfox_Query::create()
							->select('f.name, f.id')
							->from('Frontend f')
							->whereIn('f.id',$frontIdList);
							
		try 
		{
			$array = $query->fetchArray();
			
		}
		
		catch(Exception $e)
		{
			return false;
		}

		
		if(count($array)>0)
		{
			foreach($array as $record)
			{
				$frontendList[] = $record['name'];
			}
			
			$array = $frontendList;
		
		}

		//print_r($array);
		//exit();
		return $array;
									
	}

	public function addCsrGroup($groupId,$csrId)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		$partition = Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$this->csr_id = $csrId;
		$this->gms_group_id = $groupId;
		try
		{
			$result = $this->save($partition);
		}
		catch(Exception $e)
		{
			Zenfox_Debug::dump($e, 'exception', true, true);
		}
		return $result;
		
	}
	
	public function getGroups($id)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		$partition = Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
				->from('CsrGmsGroup g')
				->where('g.csr_id = ?' , $id);
		
		$result = $query->fetchArray();
		
		$groupArray = array();
		if($result)
		{
			foreach($result as $group)
			{
				$groupArray[] = $group['gms_group_id'];
			}
		}
		if( $groupArray )
		{
			$query = Zenfox_Query::create()
					->from('GmsGroup g')
					->whereIn('g.id',$groupArray);
		
			$result = $query->fetchArray();		
			return $result;
		}
	}
	
	public function getCsrs($id)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		$partition = Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
				->from('CsrGmsGroup g')
				->where('g.gms_group_id = ?' , $id);
		
		$result = $query->fetchArray();
		
		$csrArray = array();
		if($result)
		{
			foreach($result as $csr)
			{
				$csrArray[] = $csr['csr_id'];
			}
		}
		if( $csrArray )
		{
			$query = Zenfox_Query::create()
					->from('Csr c')
					->whereIn('c.id',$csrArray);
		
			$result = $query->fetchArray();		
			return $result;
		}
	}
	
	public function deleteCsrGroup($csrId,$groupId)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		$partition = Doctrine_Manager::getInstance()->setCurrentConnection($conn);
			
		$query = Zenfox_Query::create()
					->delete('CsrGmsGroup g')
					->where('g.csr_id = ?',$csrId)
					->andWhere('g.gms_group_id = ?' , $groupId);
		
		try
		{
			$ans = $query->execute();
		}
		catch(Exception $e)
		{
			Zenfox_Debug::dump($e, 'exception', true, true);
		}
		
	}
	
	public function getGmsGroupsId($csrId)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
					->from('CsrGmsGroup g')
					->where('g.csr_id = ?', $csrId);
					
		$result = $query->fetchArray();
		return $result;
	}
	
	public function getParents()
	{
		$parents = array();
		//echo $this->csr_id;
		
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
					->from('CsrGmsGroup cg')
					->where('cg.csr_id = ?', $this->csr_id);
					
		$result = $query->fetchArray();
		foreach($result as $csrGmsData)
		{
			$gmsGroup = new GmsGroup();
			$gmsGroupInfo = $gmsGroup->getInfo($csrGmsData['gms_group_id']);
			$gmsGroupName = $gmsGroupInfo[0]['name'];
			$gmsGroupsName[] = $gmsGroupName;
		}
		return $gmsGroupsName;
	}
	
}
