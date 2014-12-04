<?php
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
		
		$query = Zenfox_Query::create()
					->from('EmailTemplate e')
					->where('e.name = ?', $templateName)
					->andWhere('e.category = ?', $category);
					
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
	
	public function adminList()
	{
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
		
		//print_r($array);
		//exit();
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
	
	public function addTemplate($dataArray)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		$partition = Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$this->id = $dataArray['id'];
		$this->name = $dataArray['name'];
		$this->category = $dataArray['category'];
		$this->frontend_id = $dataArray['frontend_id'];
		$this->subject = $dataArray['subject'];
		$this->body = $dataArray['body'];
		
		
		try
		{
			$this->save($partition);
		}
		
		catch(Exception $e)
		{
			return false;
		}
		
		return true;
							 
		
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
	
	public function fetchTemplates(array $idArray)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		$partition = Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		$query = Zenfox_Query::create()
					->from('EmailTemplate')
					->whereIn('id',$idArray);
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
	
	public function editTemplate($dataArray)
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
							->where('e.id = ?',$dataArray['id']);
				
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
