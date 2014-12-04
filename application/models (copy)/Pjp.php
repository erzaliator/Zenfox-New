<?php
class Pjp extends BasePjp
{
	public function getPjpDetails()
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
						->from('Pjp');
						
		$result = $query->fetchArray();
		return $result;
	}

	public function getpjpbyId($PJPId)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
						->from('Pjp p')
						->where('p.id =?',$PJPId);
						
		$result = $query->fetchArray();
		return $result;
	}
	
	public function updatepjpdetails($PJPdata)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
						->update('Pjp p')
    					->set('p.pjp_name', '?', $PJPdata["Name"])
    					->set('p.description', '?', $PJPdata["Description"])
    					->set('p.currency', '?', $PJPdata["Currency"])
    					->set('p.bbs_enabled', '?', $PJPdata["BbsEnabled"])
    					->set('p.bbs_pjp', '?', $PJPdata["BbsPjp"])
    					->set('p.real_pjp', '?', $PJPdata["RealPjp"])
    					->set('p.random_number', '?', $PJPdata["RandomNumber"])
    					->set('p.seed', '?', $PJPdata["Seed"])
    					->set('p.min_amount_bbs', '?', $PJPdata["minBetBbs"])
    					->set('p.min_amount_real', '?', $PJPdata["minBetReal"])
    					->set('p.max_amount_bbs', '?', $PJPdata["maxBetBbs"])
    					->set('p.max_amount_real', '?', $PJPdata["maxBetReal"])
    					->set('p.reset_close', '?', $PJPdata["ResetClose"])
    					->set('p.closed', '?', $PJPdata["Closed"])
    					->set('p.allowed_frontends', '?', $PJPdata["AllowedFrontends"])
    					->where('p.id = ?', $PJPdata["Id"]);
						
		try
		{
			$result = $query->execute();
		}
    	catch(Exception $e)
    	{
    		return false;
    	}			
		
		return true;
	}
	
	public function insertpjpdetails($PJPdata)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		
		$this->pjp_name = $PJPdata["Name"];
		$this->description = $PJPdata["Description"];
		$this->currency = $PJPdata["Currency"];
		$this->bbs_enabled = $PJPdata["BbsEnabled"];
		$this->bbs_pjp = $PJPdata["BbsPjp"];
		$this->real_pjp = $PJPdata["RealPjp"];
		$this->random_number = $PJPdata["RandomNumber"];
		$this->seed = $PJPdata["Seed"];
		$this->min_amount_bbs = $PJPdata["minBetBbs"];
		$this->min_amount_real = $PJPdata["minBetReal"];
		$this->max_amount_bbs = $PJPdata["maxBetBbs"];
		$this->max_amount_real = $PJPdata["maxBetReal"];
		$this->reset_close = $PJPdata["ResetClose"];
		$this->closed = $PJPdata["Closed"];
		$this->allowed_frontends = $PJPdata["AllowedFrontends"];
    					
		
						
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
	

	
	public function getJackpot($pjpIds)
	{
		$connection = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($connection);
		
		$query = Zenfox_Query::create()
					->from('Pjp p')
					->select('max(bbs_pjp+real_pjp) as jackpot')
					->whereIn('p.id', $pjpIds);
		
		try
		{
			$result = $query->fetchArray();
		}
		catch(Exception $e)
		{
			Zenfox_Debug::dump($e, 'exception');
		}
		return $result[0]['jackpot'];
	}

}