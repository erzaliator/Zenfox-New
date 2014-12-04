<?php
class Language extends BaseLanguage
{
	public function getLanguages()
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
						->from('Language');
						
		try
		{
			$result = $query->fetchArray();
		}
		catch(Exception $e)
		{
			
		}
		return $result;
	}
}