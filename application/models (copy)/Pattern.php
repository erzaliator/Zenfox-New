<?php
class Pattern extends BasePattern
{
	public function getAllPatternsData()
	{
		$conn = Zenfox_Partition::getInstance()->getCommonConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
						->from('Pattern');
						
		$result = $query->fetchArray();
		return $result;
	}
	
	public function getPatternData($patternId)
	{
		$conn = Zenfox_Partition::getInstance()->getCommonConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$result = Doctrine::getTable('Pattern')->findOneById($patternId);
		return $result;
	}
}