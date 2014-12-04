<?php
/**
 * This class implements Player session. Store, update and delete the player
 * session data.  
 * @author nikhil
 *
 */
class PlayerSession extends Doctrine_Record
{
    private $_playerId;
    private $_playerSession;
   
    public function __construct($playerId = NULL)
    {
        $this->_playerId = $playerId;
        $this->_playerSession = new PlayerSessions();
    }
    //Store the session data in database
    public function storeInformation()
    {
    	//Get the player IP address
        $clientIpAddress = Zend_Controller_Front::getInstance()->getRequest()->getClientIp();
        $today = new Zend_Date();
        $lastActivity = $today->get(Zend_Date::W3C);
        $sessionExpiry = date ("Y-m-d H:i:s", strtotime("$lastActivity, +5 HOUR"));

        $sessionData = $this->getSessionData();
        //Check if user data is already database
        if(count($sessionData) == 1)
        {
        	//Update the data in database
            $query = Zenfox_Query::create()
                        ->update('PlayerSessions s')
                        ->set('s.frontend_id', '?', Zend_Registry::getInstance()->get('frontendId'))
                        ->set('s.login_time', '?', $today->get(Zend_Date::W3C))
                        ->set('s.last_activity', '?', $lastActivity)
                        ->set('s.session_expiry', '?', $sessionExpiry)
                        ->set('s.phpsessid', '?', Zend_Session::getId())
                        ->set('s.ip_address', '?', $clientIpAddress)
                        ->where('s.player_id = ? ', $this->_playerId);
	
            try
            {
            	$query->execute();
            }
            catch(Exception $e)
            {
            	return false;
            }
        }
        else
        {
            $session = new Zenfox_Auth_Storage_Session();
            $store = $session->read();
            $playerFrontendId = $store['authDetails'][0]['frontend_id'];
            $login = $store['authDetails'][0]['login'];
         
            $this->_playerSession['player_id'] = $this->_playerId;
            $this->_playerSession['login'] = $login;
            $this->_playerSession['login_time'] = $today->get(Zend_Date::W3C);
            $this->_playerSession['frontend_id'] = Zend_Registry::getInstance()->get('frontendId');
            $this->_playerSession['player_frontend_id'] = $playerFrontendId;
            $this->_playerSession['phpsessid'] = Zend_Session::getId();
            $this->_playerSession['last_activity'] = $lastActivity;
            $this->_playerSession['session_expiry'] = $sessionExpiry;
            $this->_playerSession['ip_address'] = $clientIpAddress;
            
            $connName = Zenfox_Partition::getInstance()->getConnections($this->_playerId);
            $partition = Doctrine_Manager::getInstance()->getConnection($connName);
            try
            {
            	$this->_playerSession->save($partition);
            }
            catch(Exception $e)
            {
            	return false;
            }
        }
        $sessionData = $this->getSessionData();
        $session = new Zend_Session_Namespace('playerSession');
        $session->store = $sessionData;
       
        //If Zend_Registry exists only then save it otherwise ignore it
        if(Zend_Registry::getInstance()->isRegistered('Cache'))
        {
            $cache = Zend_Registry::getInstance()->get('Cache');
            $key = 'playerSession_' . $login;
            $json = Zend_Json::encode($sessionData);
            $cache->save($json, $key);
            /*//TODO throw exception
            Zend_Cache::throwException('The cache does not exist.');*/
        }
        $this->updateLastLogin();
        return true;
        /*$key = 'nikhil';
        if(!($cache->test($key)))
        {
            echo "not set";
            exit();
            //$cache->save($json, $key);
        }
        if($cache->test($key))
        {
            echo "key is set";
            exit();
          
        }
        else
        {
            echo "hi";
            exit();
        }*/
    }
    
    public function updateLastLogin()
    {
    	$conn = Zenfox_Partition::getInstance()->getConnections($this->_playerId);
    	Doctrine_Manager::getInstance()->setCurrentConnection($conn);
    	
    	$today = new Zend_Date();
    	$currentTime = $today->get(Zend_Date::W3C);
    	$query = Zenfox_Query::create()
    					->set('a.last_login', '?', $currentTime)
    					->update('AccountDetail a')
    					->where('a.player_id = ?', $this->_playerId);
    					
    	try
    	{
    		$query->execute();
    	}
    	catch(Exception $e)
    	{
    		return false;
    	}
    }
    
    //Delete the session data from database once the user is logged out
    public function deleteSession($playerId = NULL)
    {
        //$role = explode('-', $store['id']);
        if(!$playerId)
        {
        	$session = new Zend_Auth_Storage_Session();
        	$store = $session->read();
        	
        	$playerId = $store['id'];
        	$login = $store['authDetails'][0]['login'];
        	$key = 'playerSession_' . $login;
        	
        	//FIXME check it works
        	if(Zend_Registry::getInstance()->isRegistered('Cache'))
        	{
        		$cache = Zend_Registry::getInstance()->get('Cache');
        		$cache->remove($key);
        	}
        	//$cache->clean(Zend_Cache::CLEANING_MODE_ALL);
        	/*if($cache->test($key))
        	 {
        	print_r($cache->getIds());
        	echo "hi";
        	}
        	//FIXME change it for tags
        	$cache->clean(Zend_Cache::CLEANING_MODE_ALL);
        	if($cache->test($key))
        	{
        	print_r($cache->getIds());
        	echo "hello";
        	}*/
        	//exit();
        	/*$cache->clean(
        	Zend_Cache::CLEANING_MODE_MATCHING_TAG,
        	array('tagA', 'tagB', 'tagC'));*/
        	$session->clear();
        }

        $connName = Zenfox_Partition::getInstance()->getConnections($playerId);
        Doctrine_Manager::getInstance()->setCurrentConnection($connName);
        $query = Zenfox_Query::create()
                ->delete('PlayerSessions s')
                ->where('s.player_id = ? ', $playerId);
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
    //Update the session data on any activity
    public function updateSession()
    {
        $today = new Zend_Date();
        $lastActivity = $today->get(Zend_Date::W3C);
        $sessionExpiry = date ("Y-m-d H:i:s", strtotime("$lastActivity, +5 HOUR"));
        
        $sessionData = $this->getSessionData();
        if(count($sessionData) == 1)
        {
            //TODO implement it for last_activity, ip_address, session_expiry, phpsessionid
            $query = Zenfox_Query::create()
                        ->update('PlayerSessions s')
                        ->set('s.last_activity', '?', $lastActivity)
                        ->set('s.session_expiry', '?', $sessionExpiry)
                        ->where('s.player_id = ? ', $this->_playerId);
	        try
	        {
	        	$query->execute();
	        }
	        catch(Exception $e)
	        {
	        	return false;
	        }
        }
        
        $sessionData = $this->getSessionData();
        if(!$sessionData)
        {
        	return NULL;
        }
        $session = new Zend_Session_Namespace('playerSession');
        $session->store = $sessionData;
        //If Zend_Registry exist then update the cache data
    	if(Zend_Registry::getInstance()->isRegistered('Cache'))
        {
            $cache = Zend_Registry::getInstance()->get('Cache');
            $key = 'playerSession_' . $sessionData[0]['login'];
            $json = Zend_Json::encode($sessionData);
            $cache->save($json, $key);
            /*//TODO throw exception
            Zend_Cache::throwException('The cache does not exist.');*/
        }
      
        $session = new Zend_Auth_Storage_Session();
        $store = $session->read();
        $query = Zenfox_Query::create()
                    ->from('AccountDetail a')
                    ->where('a.player_id = ? ', $this->_playerId);
                  
        try
        {
        	$accountDetails = $query->fetchArray();
        }
        catch(Exception $e)
        {
        	return false;
        }
        if($accountDetails)
        {
        	return array(
				'roleName' => $store['roleName'],
	        	'id' => $store['id'],
				'authDetails' => $accountDetails);
        }
        return NULL;
        //Restore the session value when password is changed
       
    }
    
    public function getSessionData()
    {
    	$connName = Zenfox_Partition::getInstance()->getConnections($this->_playerId);
        Doctrine_Manager::getInstance()->setCurrentConnection($connName);
		//Check if user data is already in the table
        $query = Zenfox_Query::create()
                        ->from('PlayerSessions s')
                        ->where('s.player_id = ? ', $this->_playerId);
                       
        try
        {
        	$result = $query->fetchArray();
        }
        catch(Exception $e)
        {
        	
        }
        if($result)
        {
        	return $result;
        }
        return NULL;
    }
	
	
    
	public function getAllPlayerSessions($offset, $itemsPerPage)
	{
		$query = "Zenfox_Query::create()
    					->from('PlayerSessions s')";
		
		$adapter = new Zenfox_Paginator_Adapter_DoctrineQuery($query, -1);
		$paginatorSession = new Zend_Session_Namespace('paginationCount');
		$paginatorSession->value = false;
    	$paginator =  new Zend_Paginator($adapter);
    	$paginator->setItemCountPerPage($itemsPerPage);
		$paginator->setPageRange(2);
		$paginator->setCurrentPageNumber($offset);
		$paginatorSession->unsetAll();
		return $paginator;
	}
}
