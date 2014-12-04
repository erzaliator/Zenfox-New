<?php
class EmailLogs extends BaseEmailLogs
{
	public function insertEmails($emailList, $playerId)
	{
		if($this->getEmailAddresses($playerId))
		{
			$this->updateEmailList($playerId, $emailList);
			return true;
		}
		
		$date = new Zend_Date();
		$currentTime = $date->get(Zend_Date::W3C);
		
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$emailLogs = new EmailLogs();
		$emailLogs->user_id = $playerId;
		$emailLogs->user_type = 'PLAYER';
		$emailLogs->email_list = $emailList;
		$emailLogs->last_updated = $currentTime;
		$emailLogs->status = 'UNPROCESSED';
		$emailLogs->message = 'Sent Emails';
		
		try
		{
			$emailLogs->save();
		}
		catch(Exception $e)
		{
			print($e);
			exit();
		}
		return true;
	}
	
	public function getEmailAddresses($playerId)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
					->from('EmailLogs el')
					->where('el.user_id = ?', $playerId);
					
		try
		{
			$result = $query->fetchArray();
		}
		catch(Exception $e)
		{
			print($e);
			exit();
		}
		return $result;
	}
	
	public function updateEmailList($playerId, $emailList)
	{
		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);

		$date = new Zend_Date();
		$currentTime = $date->get(Zend_Date::W3C);
		
		$query = Zenfox_Query::create()
					->update('EmailLogs el')
					->set('el.email_list', '?', $emailList)
					->set('el.last_updated', '?', $currentTime)
					->where('el.user_id = ?', $playerId);
					
		try
		{
			$query->execute();
		}
		catch(Exception $e)
		{
			print($e);
			exit();
		}
		return true;
	}
}