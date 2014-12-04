<?php
class Zenfox_Controller_Plugin_UpdateSession extends Zend_Controller_Plugin_Abstract
{
	public function preDispatch(Zend_Controller_Request_Abstract $request)
	{
		$session = new Zenfox_Auth_Storage_Session();
		$storedData = $session->read();
		$playerId = $storedData['id'];
		
		$phpsessid = Zend_Session::getId();
		$encodedId = base64_encode($playerId.$phpsessid);
		
		setcookie('logData',$encodedId,time() + (3600 * 6),'/','.'.$_SERVER['HTTP_HOST']);
		
		$conn = Zenfox_Partition::getInstance()->getConnections($playerId);
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
					->from('AccountDetail a')
					->where('a.player_id = ?', $playerId);
		$accountDetails = $query->fetchArray();

		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$query = Zenfox_Query::create()
                     ->from('Account a')
                     ->where('a.player_id = ? ', $playerId); 
        try
        {
        	$accountInfo = $query->fetchArray();
        }
        catch(Exception $e)
        {
        }
        
        $accountDetails[0] = array_merge($accountDetails[0], $accountInfo[0]);
//Zenfox_Debug::dump($accountDetails, 'details');

		$storedData['authDetails'] = $accountDetails;
		//$storedData['cash'] = $storedData['cash']?$storedData['cash']:$storedData['authDetails'][0]['cash'];
		//$storedData['bonus'] = $storedData['bonus']?$storedData['bonus']:($storedData['authDetails'][0]['bonus_bank'] + $storedData['authDetails'][0]['bonus_winnings']);
		$session->write($storedData);
		$session->setExpiryTime(3600*5);
	}
}
