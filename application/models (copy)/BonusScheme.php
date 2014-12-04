<?php
class BonusScheme extends BaseBonusScheme
{
	public function getSchemeId()
	{
		$conn = Zenfox_Partition::getInstance()->getCommonConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
					->from('BonusScheme b')
					->select('b.scheme_id')
					->orderBy('b.scheme_id DESC')
					->limit(1);
					
		$result = $query->fetchArray();
//		Zenfox_Debug::dump($result, 'result', true, true);
		return $result[0]['scheme_id'];
	}
	public function getAllSchemeData()
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
						->from('BonusScheme b');
						
		$result = $query->fetchArray();
		return $result;
	}
	public function getSchemeData($schemeId)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		//FIXME check it. Some time shows the error
		$result = Doctrine::getTable('BonusScheme')->findOneBySchemeId($schemeId);
		return array(
				'schemeId' => $schemeId,
				'name' => $result['name'],
				'description' => $result['description']);
	}
}