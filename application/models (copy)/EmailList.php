<?php
class EmailList extends BaseEmailList
{
	public function getListData($listId)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
					->from('EmailList l')
					->where('l.id = ?', $listId);

		$result = $query->fetchArray();
		
		return array(
			'name' => $result[0]['name'],
			'function' => $result[0]['function'],
		);
	}
}