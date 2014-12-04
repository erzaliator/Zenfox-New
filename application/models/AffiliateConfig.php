<?php
class AffiliateConfig extends Doctrine_Record
{
    protected $_unconfirmAccount;
    protected $_translate;
    protected $_error = false;

    public function __construct()
    {
        $this->_unconfirmAccount = new AccountUnconfirm();
        $this->_translate = Zend_Registry::get('Zend_Translate');
    }
	public function registerAffiliate($data)
	{
	 	$_error = false;

        if(!isset($data))
        {
             throw new Zenfox_Exception("Affiliate not defined");
        }
        else
        {
        	$affiliate = new Affiliate();
        	if($this->validateLogin($data['alias']))
            {
                $affiliate->alias = $data['alias'];
            }
            else
            {
            	$this->getErrorStack()->add('login', 'Invalid login');
                $_error = true;
            }
        	if($this->validatePassword($data['password'], $data['confirmPassword']))
            {
               $affiliate->passwd = $data['password'];
            }
            else
            {
                $this->getErrorStack()->add('password', 'Invalid password');
                $_error = true;
            }
            
        	if($this->validateEmail($data['email']))
            {
            	$affiliate->email = $data['email'];
            }
            else
            {
                $this->getErrorStack()->add('email', 'Invalid Email');
                $_error = true;
            }        
            $affiliate->firstname = $data['firstName'];
            $affiliate->lastname = $data['lastName'];
            $affiliate->company = $data['company'];
            $affiliate->address = $data['address'];
            $affiliate->city = $data['city'];
            $affiliate->state = $data['state'];
            $affiliate->country = $data['country'];
            $affiliate->zip = $data['zip'];
            $affiliate->phone = $data['phone'];
            $affiliate->payment_type = $data['paymentType'];
            $masterId = $data['masterId'];
            if($data['masterId'])
            {
            	$refererAlias = $data['masterId'];
            	$csrIds = new CsrIds();
            	$masterId = $csrIds->getAffiliateId($refererAlias);
            }
            $affiliate->master_id = $masterId;
            $today = new Zend_Date();
			$dateTime = explode('T',$today->get(Zend_Date::W3C));
            $date = $dateTime[0];
            $time = $dateTime[1];
            $time = explode('+',$time);
            $time = $time[0];
            $datetime = $date.' '.$time;
            //echo $datetime;
            $affiliate->created = $datetime;
            $affiliateFrontendId = Zend_Registry::getInstance()->get('frontendId');
            $affiliate->enabled = isset($data['enabled'])?$data['enabled']:'ENABLED';
            $affiliate->language = $data['lang'];
            $affiliate->affiliate_frontend_id = $affiliateFrontendId;

		/*
		 * Getting affiliate base currency from affiliate_frontend
		 */

            $query = Zenfox_Query::create()
            			->from('AffiliateFrontend a')
            			->where('a.id = ?', $affiliateFrontendId);
            			
            $result = $query->fetchArray();

	    $affiliate->affiliate_base_currency = isset($result[0]['default_currency'])?$result[0]['default_currency']:'USD';
           
            if($_error)
            {
            	$translate = Zend_Registry::get('Zend_Translate');
            	$userErrors = $this->getErrorStack();
            	foreach($userErrors as $errorCodes) {
    			$error = $translate->translate($errorCodes[0]);
            	}
                //FIXME:: Should the caller retrieve errorStack() or should we return it?
                return array(false,$error);
            }
            $affiliate->save();
            return array(true,null);
        }
	}
	public function confirmAffiliate($data)
	{
		$_error = false;
        $affiliate = new Affiliate();

        $affiliate->alias = $data['alias'];
        $affiliate->passwd = $data['password'];
        $affiliate->email = $data['email'];
        $affiliate->firstname = $data['firstName'];
        $affiliate->lastname = $data['lastName'];
        $affiliate->company = $data['company'];
        $affiliate->address = $data['address'];
        $affiliate->city = $data['city'];
        $affiliate->state = $data['state'];
        $affiliate->country = $data['country'];
        $affiliate->zip = $data['pin'];
        $affiliate->phone = $data['phone'];
        $affiliate->payment_type = $data['paymentType'];
        $refererAlias = $data['masterId'];
        $csrIds = new CsrIds();
        $masterId = $csrIds->getAffiliateId($refererAlias);
        $affiliate->master_id = $masterId;
        $today = new Zend_Date();
		$dateTime = explode('T',$today->get(Zend_Date::W3C));
        $date = $dateTime[0];
        $time = $dateTime[1];
        $time = explode('+',$time);
        $time = $time[0];
        $datetime = $date.' '.$time;
        $affiliate->created = $datetime;
        $affiliateFrontendId = Zend_Registry::getInstance()->get('frontendId');
        $affiliate->language = $data['lang'];
        $affiliate->affiliate_frontend_id = $affiliateFrontendId;
          
	   /*
	    * Getting affiliate base currency from affiliate_frontend
	    */

       $query = Zenfox_Query::create()
			   ->from('AffiliateFrontend a')
			   ->where('a.id = ?', $affiliateFrontendId);
			   
       $result = $query->fetchArray();

       $affiliate->affiliate_base_currency = isset($result[0]['default_currency'])?$result[0]['default_currency']:'USD';
       
        if($_error)
        {
          	$translate = Zend_Registry::get('Zend_Translate');
           	$userErrors = $this->getErrorStack();
           	foreach($userErrors as $errorCodes) {
   			$error = $translate->translate($errorCodes[0]);
           	}
                //FIXME:: Should the caller retrieve errorStack() or should we return it?
            return array(false,$error);
        }
        $affiliate->save();
		if($this->updateAccountUnconfirm($data['code']))
		{
            return array(true, $data['id']);
        }
	}
	public function registerUnconfirm($affiliate)
    {
    	$today = new Zend_Date();
        $currentTime = $today->get(Zend_Date::W3C);
        $expiryTime = date ("Y-m-d H:i:s", strtotime("$currentTime, +15 DAYS"));
        $code = md5($affiliate['email'] . $currentTime);
        
    	if(!isset($affiliate))
        {
            throw new Zenfox_Exception($this->_translate->translate("Affiliate data undefined"));
        }
        else
        {
            if($this->validateUnconfirmLogin($affiliate['alias']))
            {
                $this->_unconfirmAccount['login'] = $affiliate['alias'];
            }
            else
            {
                //unset($this->_myAccount['login']);
                $this->_unconfirmAccount['login'] = NULL;
                $this->getErrorStack()->add('login', $this->_translate->translate('Invalid login'));
                //throw new Zenfox_Exception($this->_translate->translate('Invalid login'));
                $this->_error = true;
            }

            if($this->validatePassword($affiliate['password'], $affiliate['confirmPassword']))
            {
                $this->_unconfirmAccount['password'] = $affiliate['password'];
            }
            else
            {
                //unset($this->_myAcctDetails['password']);
                $this->_unconfirmAccount['password'] = NULL;
                $this->getErrorStack()->add('password', $this->_translate->translate('Invalid password'));
                //throw new Zenfox_Exception($this->_translate->translate('Invalid password'));
                $this->_error = true;
            }

            if($this->validateUnconfirmEmail($affiliate['email']))
            {
            	$this->_unconfirmAccount['email'] = $affiliate['email'];
            }
            else
            {
                //unset($this->_myAcctDetails['email']);
                $this->_unconfirmAccount['email'] = NULL;
                $this->getErrorStack()->add('email', $this->_translate->translate('Invalid Email'));
                //throw new Zenfox_Exception($this->_translate->translate('Invalid Email'));
                $this->_error = true;
            }
        
        	if($this->_error)
            {
            	$userErrors = $this->getErrorStack();
            	foreach($userErrors as $errorCodes) {
    			$error = $errorCodes[0];
            	}
                //FIXME:: Should the caller retrieve errorStack() or should we return it?
                return array(false,$error);
            }
            
	    	$this->_unconfirmAccount['first_name'] = $affiliate['firstName'];
	        $this->_unconfirmAccount['last_name'] = $affiliate['lastName'];
	        $this->_unconfirmAccount['address'] = $affiliate['address'];
	        $this->_unconfirmAccount['city'] = $affiliate['city'];
	        $this->_unconfirmAccount['state'] = $affiliate['state'];
	        $this->_unconfirmAccount['country'] = $affiliate['country'];
	        $this->_unconfirmAccount['pin'] = $affiliate['zip'];
	        $this->_unconfirmAccount['phone'] = $affiliate['phone'];
	        $this->_unconfirmAccount['code'] = $code;
	        $this->_unconfirmAccount['expiry_time'] = $expiryTime;
	        $this->_unconfirmAccount['frontend_id'] = Zend_Registry::getInstance()->get('frontendId');
	        $this->_unconfirmAccount['role_type'] = 'AFFILIATE';
	        $this->_unconfirmAccount['created'] = $currentTime;
	        $this->_unconfirmAccount['affiliate_data'] = $affiliate['company'] . ',' . $affiliate['paymentType'] .
	                                                     ',' . $affiliate['lang'] . ',' . $affiliate['masterId'];
	        
	        try
	        {
	        	$this->_unconfirmAccount->save();
	        }
	        catch(Exception $e)
	        {
	        	return false;
	        }
	        return array(true, $code);
        }
    }
    
	public function updateAccountUnconfirm($code)
    {
    	$query = Zenfox_Query::create()
    					->update('AccountUnconfirm a')
    					->set('a.confirmation', '?', 'YES')
    					->where('a.code = ?', $code);
    					
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
	
 	public function validateLogin($login)
    {
        if (is_string($login))
        {
            //Check if login exists
            $affiliate_id = $this->getAffiliateIdFromLogin($login);
            if(!isset($affiliate_id))
            {
                return true;
            }
            else
            {
                $errorStack = $this->getErrorStack();
                $errorStack->add('login', 'Login Name `' . $login . '` has already been taken');
            }
        }
        else
        {
            $errorStack = $this->getErrorStack();
            $errorStack->add('login', 'Invalid loginname.');
        }
        return false;
    }
    
	public function validateUnconfirmLogin($login)
    {
    	$errorStack = $this->getErrorStack();
        if (is_string($login))
        {
        	$conn = Zenfox_Partition::getInstance()->getMasterConnection();
	        Doctrine_Manager::getInstance()->setCurrentConnection($conn);
            //Check if login exists
            $query = Zenfox_Query::create()
            			->from('AccountUnconfirm a')
            			->where('a.login = ?', $login)
            			->andWhere('a.role_type = ?', 'AFFILIATE');
            			
            $result = $query->fetchArray();

            if(!isset($result[0]['player_id']))
            {
                return true;
            }
            else
            {
                //$errorStack = $this->getErrorStack();
                
                //throw new Zenfox_Exception($this->_translate->translate('Login Name `') . $login . $this->_translate->translate('` has already been taken'));
                $errorStack = $this->getErrorStack();
                $errorStack->add('login', $this->_translate->translate("Login Name '" . $login . "' has already been taken"));
                //throw new Zenfox_Exception($this->_translate->translate('Login Name `') . $login . $this->_translate->translate('` has already been taken'));
            }
        }
        else
        {
        	//$errorStack = $this->getErrorStack();
            $errorStack->add('login', $this->_translate->translate('Invalid loginname.'));
            //throw new Zenfox_Exception($this->_translate->translate('Invalid loginname.'));
            $errorStack = $this->getErrorStack();
            $errorStack->add('login', $this->_translate->translate('Invalid loginname.'));
            //throw new Zenfox_Exception($this->_translate->translate('Invalid loginname.'));
        }
        return false;
    }
    
	public function validateUnconfirmEmail($email)
    {
    	$errorStack = $this->getErrorStack();
        if (is_string($email))
        {
        	$conn = Zenfox_Partition::getInstance()->getMasterConnection();
	        Doctrine_Manager::getInstance()->setCurrentConnection($conn);

	        //Check if email exists
            $query = Zenfox_Query::create()
            			->from('AccountUnconfirm a')
            			->where('a.email = ?', $email)
            			->andWhere('a.role_type = ?', 'AFFILIATE');
            			
            $result = $query->fetchArray();

            if(!isset($result[0]['player_id']))
            {
                return true;
            }
            else
            {
                //$errorStack = $this->getErrorStack();
                
                //throw new Zenfox_Exception($this->_translate->translate('Login Name `') . $login . $this->_translate->translate('` has already been taken'));
                $errorStack = $this->getErrorStack();
                $errorStack->add('email', $this->_translate->translate("Email already exists"));
                //throw new Zenfox_Exception($this->_translate->translate('Login Name `') . $login . $this->_translate->translate('` has already been taken'));
            }
        }
        else
        {
        	//$errorStack = $this->getErrorStack();
            $errorStack->add('email', $this->_translate->translate('Invalid Email.'));
            //throw new Zenfox_Exception($this->_translate->translate('Invalid loginname.'));
            $errorStack = $this->getErrorStack();
            $errorStack->add('email', $this->_translate->translate('Invalid Email.'));
            //throw new Zenfox_Exception($this->_translate->translate('Invalid loginname.'));
        }
        return false;
    }
    
	public function validatePassword($password, $confirmPassword)
    {
        if (is_string($password))
        {
        	if($password==$confirmPassword)
        	{
        		return true;
        	}
            else
            {
            	$errorStack = $this->getErrorStack();
            	$errorStack->add('password', 'Password and Confirm Password fields do not match.');
            }
        }
        else
        {
            $errorStack = $this->getErrorStack();
            $errorStack->add('password', 'Invalid password.');
        }
    }
	
	
 	public function validateEmail($email)
    {
        if (is_string($email))
        {
            $affiliate_id = $this->getAffiliateIdFromEmail($email);

            //Email exists
            if(!isset($affiliate_id))
            {
                return true;
            }
            else
            {
                $errorStack = $this->getErrorStack();
                $errorStack->add('email', 'Email already exists');
            }
        }
        else
        {
            $errorStack = $this->getErrorStack();
            $errorStack->add('email', 'Invalid email.');
        }
        return false;
    }
	
	public function getAffiliateIdFromEmail($email)
    {
        //No connection switching required as Account id bound to master
        $affiliateTable = Doctrine::getTable('Affiliate');
        $account = $affiliateTable->findOneByEmail($email);

        return $account['affiliate_id'];
    }

    public function getAffiliateIdFromLogin($login)
    {
        //No connection switching required as Account id bound to master
        $affiliateTable = Doctrine::getTable('Affiliate');
        $account = $affiliateTable->findOneByAlias($login);

        return $account['affiliate_id'];
    }
    
	public function authenticate ($login, $password)
    {
    	$accountDetail = array();
    	$affiliate_id = $this->getAccountIdFromLogin($login);
    	if($affiliate_id)
    	{
    		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
	        Doctrine_Manager::getInstance()->setCurrentConnection($conn);
	        //$accountDetailTable = Doctrine::getTable('AccountDetail');

	    	$query = Zenfox_Query::create()
	    			->from ('Affiliate a')
	    			->where	(
	    				'a.alias = ? and a.passwd = ?', 
	    				array($login, $password)
	    				);
	    			
	    	$accountDetails = $query->fetchArray();
	    	
	    	//print_r($accountDetails); exit();
	    	
	    	$authMessages = array();
	
	    	if(count($accountDetails) == 1)
	    	{
	    		$authResult = Zend_Auth_Result::SUCCESS;
	    	}
	    	else
	    	{
	    		$authResult = Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID;
	    		$translate = Zend_Registry::get('Zend_Translate');
	    		$authMessages[] = $translate->translate('Login Failed! The username and password you entered did not match.');
	    	}
    	}
    	else
    	{
    		$authResult = Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID;
    		$translate = Zend_Registry::get('Zend_Translate');
    		$authMessages[] = $translate->translate('Login Failed! The username or password you entered did not match.');
    	}

    	return array(new Zend_Auth_Result($authResult, $affiliate_id, $authMessages), $accountDetails );
    }
    
	public function getAccountIdFromLogin($login)
    {
    	$conn = Zenfox_Partition::getInstance()->getMasterConnection();
	    Doctrine_Manager::getInstance()->setCurrentConnection($conn);
        //No connection switching required as Account id bound to master
        $affiliateTable = Doctrine::getTable('Affiliate');
        $account = $affiliateTable->findOneByAlias($login);

        return $account['affiliate_id'];
    }
    
    public function updateProfile($id,$data)
    {
    	$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
		
		$affiliateTable = Doctrine::getTable('Affiliate');
        $affiliate = $affiliateTable->findOneByAffiliate_id($id);
        
        $affiliate->firstname = $data['firstName'];
        $affiliate->lastname = $data['lastName'];
        $affiliate->company = $data['company'];
        $affiliate->address = $data['address'];
        $affiliate->city = $data['city'];
        $affiliate->state = $data['state'];
        $affiliate->country = $data['country'];
        $affiliate->zip = $data['zip'];
        $affiliate->phone = $data['phone'];
        $affiliate->payment_type = $data['paymentType'];         
        $affiliate->master_id = $data['masterId'];
        $affiliate->enabled = $data['enabled'];
        $affiliate->language = $data['lang'];
        
        $affiliate->save();
    }
    
    public function updatePassword($id,$data)
    {
    	$conn = Zenfox_Partition::getInstance()->getMasterConnection();
		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
    	$_error = false;
    	$password = $this->getPasswordFromId($id);
    	if($password == $data['previousPassword'])
    	{
    		if($this->validatePassword($data['newPassword'],$data['confirmPassword']))
    		{
    			$affiliateTable = Doctrine::getTable('Affiliate');
        		$affiliate = $affiliateTable->findOneByAffiliate_id($id);
        		$affiliate->passwd = $data['newPassword'];
    		}
    		else
    		{
    			$_error = true;
    		}
    	}
    	else
    	{
    		$_error = true;
    		$errorStack = $this->getErrorStack();
            $errorStack->add('password', 'Invalid Password');
    	}
    	
    	if($_error)
        {
         	$translate = Zend_Registry::get('Zend_Translate');
            $userErrors = $this->getErrorStack();
            foreach($userErrors as $errorCodes) 
            {
    			$error = $translate->translate($errorCodes[0]);
            }
                //FIXME:: Should the caller retrieve errorStack() or should we return it?
            return array(false,$error);
        }
        $affiliate->save();
        return array(true,null);
    }
    
    public function getPasswordFromId($id)
    {
    	$affiliateTable = Doctrine::getTable('Affiliate');
        $account = $affiliateTable->findOneByAffiliate_id($id);

        return $account['passwd'];
    }
    
    
}
