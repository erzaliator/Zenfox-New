<?php
class EmailLog extends BaseEmailLog
{
	public function getMailLogData()
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
						->from('EmailLog ml')
						->where('ml.status = ?', 'UNPROCESSED');
						
		$result = $query->fetchArray();
		
		return $result;
	}
}