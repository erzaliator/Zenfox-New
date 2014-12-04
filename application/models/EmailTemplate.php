<?php


/**
 * EmailTemplate
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6401 2009-09-24 16:12:04Z guilhermeblanco $
 */
class EmailTemplate extends BaseEmailTemplate
{
	public function getTemplateInformation($templateId)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
	
		$query = Zenfox_Query::create()
		->from('EmailTemplate e')
		->where('e.id = ?', $templateId);
	
		$result = $query->fetchArray();
		return array(
				'templateName' => $result[0]['name'],
				'category' => $result[0]['category'],
				'subject' => $result[0]['subject'],
				'msgBody' => $result[0]['body'],
		);
	}
	
	public function getTemplateData($templateName, $category)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$frontendId = Zend_Registry::get('frontendId');
	
		$query = Zenfox_Query::create()
					->from('EmailTemplate e')
					->where('e.name = ?', $templateName)
					->andWhere('e.category = ?', $category)
					->andWhere('e.frontend_id = ?', $frontendId);
			
		try
		{
			$result = $query->fetchArray();
		}
		catch(Exception $e)
		{
			return false;
		}
		return array(
				'subject' => $result[0]['subject'],
				'msgBody' => $result[0]['body'],
				'templateId' => $result[0]['id']
		);
	}
	
	public function adminList($csrId)
	{
		//print 'Here';exit();
		
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		
		
		$query = Zenfox_Query::create()
							->select('e.id, e.name, e.category, e.frontend_id, e.subject')
							->from('EmailTemplate as e');
							
		
		try 
		{
			$array = $query->fetchArray();
		}					
		catch(Exception $e)
		{
			return false;	
		}
		
// 		print_r($array);
// 		exit();
		return $array;
							
	}
	
	public function adminGetDetails($id)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()							
							->from('EmailTemplate as e')
							->where('e.id = ?',$id);
							
		
		try 
		{
			$array = $query->fetchArray();
		}					
		catch(Exception $e)
		{
			return false;	
		}
		
		//print_r($array);
		//exit();
		return $array;
		
	}
	
	public function addTemplate($name, $category, $frontendid, $subject, $body ,$domain)
	{
		
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		 Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		
		$this->name = $name;
		$this->category = $category;
		$this->frontend_id = $frontendid;
		$this->subject = $subject;
		$this->body = $body;
		$this->domain = $domain;
		
		try
		{
			$this->save();
		}
		
		catch(Exception $e)
		{
			return false;
		}
		
		return true;
							 
		
	}
	
	public function getlastdata($name, $category, $frontendid, $subject, $body, $domain)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
	
		$query = Zenfox_Query::create()
		->from('EmailTemplate t')
		->Where('t.name =?' , $name)
		->andWhere('t.category =?' , $category)
		->andWhere('t.frontend_id =?' , $frontendid)
		->andWhere('t.subject =?' , $subject)
		->andWhere('t.body =?' , $body)
		->andWhere('t.domain =?' , $domain);
			
		$result = $query->fetchArray();
		return $result[0];
	}

	
	public function deleteTemplates(array $idArray)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		$partition = Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		$query = Zenfox_Query::create()
					->delete('EmailTemplate')
					->whereIn('id',$idArray);
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
	
	public function fetchTemplates( $id)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		$partition = Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
					->from('EmailTemplate e')
					->where('e.id =?',$id);
		try 
		{
			$array = $query->fetchArray();
		}
		catch(Exception $e)
		{
			return false;
		}
		return $array;
		
	}
	
	public function editTemplate($dataArray,$id)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		$partition = Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
							->update('EmailTemplate e')
							->set('e.name','?',$dataArray['name'])
							->set('e.category','?',$dataArray['category'])
							->set('e.frontend_id','?',$dataArray['frontend_id'])
							->set('e.subject','?',$dataArray['subject'])
							->set('e.body','?',$dataArray['body'])
							->set('e.domain','?',$dataArray['domain'])
							->where('e.id = ?',$id);
				
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
	
	public function gettemplate()
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
	
		$query = Zenfox_Query::create()
		->from('EmailTemplate');
			
		$result = $query->fetchArray();
		return $result;
	}
	
	
}