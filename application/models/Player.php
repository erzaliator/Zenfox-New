<?php

class Player extends Doctrine_Record
{
    protected $_myAccount;
    protected $_myAcctDetails;
    protected $_unconfirmAccount;
    protected $_translate;
    protected $_error = false;

    public function __construct()
    {
/*        $account['login'] = "yaswanth";// . rand(1,1000000);
        $account['password'] = "iiit123";

        $player_id = $this->getAccountIdFromLogin($account['login']);
*/
    	$masterConnection = Zenfox_Partition::getInstance()->getMasterConnection();
    	Doctrine_Manager::getInstance()->setCurrentConnection($masterConnection);
    	
        $this->_myAccount = new Account();
        $this->_unconfirmAccount = new AccountUnconfirm();
        
        $this->_myAcctDetails = new AccountDetail();
        $this->_translate = Zend_Registry::get('Zend_Translate');
/*
        $this->_myAccount['login'] = $account['login'];
        $this->_myAcctDetails['password'] = $account['password'];*/
    }
    /**
     * This function just Authenticates the user.
     * By authentication, it just checks if the user is exactly who he says he is
     * Blocking the user depending on frontend or language or anything else has to be handled in ACLs
     * @param	string	login
     * @param	string	password
     * @return	Zend_Auth_Result	
     */
    
    public function authenticate ($login, $password)
    {
    	$accountDetail = array();
    	
    	$accountData = $this->_checkRegistration($login);
    	
    	$authMessages = array();
    	$player_id = "";
    	$accountDetails = array();
    	if($accountData)
    	{
    		$accountType = $accountData['type'];
    		if($accountType == 'confirm')
    		{
    			$player_id = $accountData['player_id'];
    			$conn = Zenfox_Partition::getInstance()->getConnections($player_id);
    			Doctrine_Manager::getInstance()->setCurrentConnection($conn);
    			//$accountDetailTable = Doctrine::getTable('AccountDetail');
    			$md5OfPassword = md5($password);
    			try
    			{

				/*
				 * XXX: Important: Having the '(' in the or statement when comparing login and email is a MUST
				 * 	Not having this would make it an or between login and password!
				 */
    				$frontendId = $accountData['frontend_id'];
    				
    				$query = Zenfox_Query::create()
		    				->from ('AccountDetail a')
		    				->where	('(a.login = ? or a.email = ?) and a.password = ?', array($login, $login, $md5OfPassword))
    						->andWhere('a.frontend_id = ?', $frontendId);
    				$accountDetails = $query->fetchArray();
    			}
    			catch(Exception $e)
    			{
    				
    			}
    			
    			if(count($accountDetails) == 1 && $accountDetails[0]['status'] == "ENABLED")
    			{
    				$authResult = Zend_Auth_Result::SUCCESS;
    				$urlRecords = new UrlRecords();
    				$urlRecords->addRecords($accountDetails[0]['player_id']);
    			}
    			elseif($accountDetails[0]['status'] == "DISABLED")
    			{
    				$authResult = Zend_Auth_Result::FAILURE_IDENTITY_AMBIGUOUS;
    				$authMessages[] = $this->_translate->translate('Your account has been disabled. Please contact support for further information!');
    			}
    			else
    			{
    				$authResult = Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID;
    				$authMessages[] = $this->_translate->translate('Login Failed! The username or password, you entered, did not match.');
    			}
    		}
    		else
    		{
			$link = '<a href = "/auth/reconfirm/code/' . $accountData['playerData']['code'] .'">Send It!</a>';
    			$authResult = Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID;
   			$authMessages[] = $this->_translate->translate('Login Failed! You have not confirmed your account yet. Please confirm it first then try to login. <br>I would like to confirm it now! ' . $link);
    		}
    	}
    	else
    	{
    		$authResult = Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID;
    		$authMessages[] = $this->_translate->translate('You are not registered yet. Please register first.');
    	}
    	return array(new Zend_Auth_Result($authResult, $player_id, $authMessages), $accountDetails );
    }
    
    private function _checkRegistration($unameEmail)
    {
    	$frontendId = Zend_Registry::get('frontendId');
    	
    	$frontend = new Frontend();
    	$frontendData = $frontend->getFrontendById($frontendId);
    	
    	$allowedFrontendIds = explode(',', $frontendData[0]['allowed_frontend_ids']);
    	
    	$connections = Zenfox_Partition::getInstance()->getConnections(-1);
    	foreach($connections as $connection)
    	{
    		Doctrine_Manager::getInstance()->setCurrentConnection($connection);
    		 
    		foreach($allowedFrontendIds as $allowedFrontend)
    		{
    			$query = Zenfox_Query::create()
			    			->from('AccountDetail a')
			    			->where('a.login = ? or a.email = ?', array($unameEmail, $unameEmail))
						->andWhere('a.email != ?', 'yantra@mailinator.com')
			    			->andWhere('a.frontend_id = ?', $allowedFrontend);
    			 
    			try
    			{
    				$result = $query->fetchArray();
    			}
    			catch(Exception $e)
    			{
    				//Zenfox_Debug::dump($e, 'exceptions', true, true);
    			}
    			 
    			if($result)
    			{
    				break;
    			}
    		}
    		if($result)
    		{
    			break;
    		}
    	}
    	
    	/* $query = Zenfox_Query::create()
    				->from('Account a')
    				->where('a.login = ? or a.email = ?', array($unameEmail, $unameEmail))
    				->andWhere('a.frontend_id = ?', $frontendId);
    	
    	
    	$result = $query->fetchArray(); */
    	
    	if(!$result)
    	{
    		$masterConnection = Zenfox_Partition::getInstance()->getMasterConnection();
    		Doctrine_Manager::getInstance()->setCurrentConnection($masterConnection);
    		
    		$query = Zenfox_Query::create()
			    		->from('AccountUnconfirm a')
			    		->where('a.login = ? or a.email = ?', array($unameEmail, $unameEmail))
    					->andWhereIn('a.frontend_id', $allowedFrontendIds);
    		 
    		$result = $query->fetchArray();
    		if($result)
    		{
    			return array(
    				'type' => 'unconfirm',
    		    	'playerData' => $result[0]
    			);
    		}
    		return NULL;
    	}
    	return array(
    	  	'type' => 'confirm',
    	  	'player_id' => $result[0]['player_id'],
    	  	'frontend_id' => $result[0]['frontend_id']
    	);
    }

    /**
     * This is the function where a player account is created.
     * A player object (array) is passed to the function.
     * Minimum required fields in the array
     * 'login'
     * 'password'
     * 'email'
     *
     * The file also seperates out the details that have to go to account
     * and accountdetail
     *
     * Returns boolesn
     * true if successful
     *
     * false with errorStack if failed
     *
     * @param  array  $player
     * @return mixed  boolean,errorStack (if any)
     */

    public function registerPlayer($player)
    {
    	//Zenfox_Debug::dump($player, 'data', true, true);
        //$_error = false;

        if(!isset($player))
        {
            throw new Zenfox_Exception($this->_translate->translate("Player data undefined"));
        }
        else
        {
            if($this->validateLogin($player['login']))
            {
                $this->_myAccount['login'] = $player['login'];
                $this->_myAcctDetails['login'] = $player['login'];
            }
            else
            {
                //unset($this->_myAccount['login']);
                $this->_myAccount['login'] = NULL;
               	//unset($this->_myAcctDetails['login']);
                $this->_myAcctDetails['login'] = NULL;
                $this->getErrorStack()->add('login', $this->_translate->translate('Invalid login'));
                //throw new Zenfox_Exception($this->_translate->translate('Invalid login'));
                $this->_error = true;
            }

            /*if($this->validatePassword($player['password'], $player['confirmPassword']))
            {
                $this->_myAcctDetails['password'] = $player['password'];
            }
            else
            {
                //unset($this->_myAcctDetails['password']);
                $this->_myAcctDetails['password'] = NULL;
                $this->getErrorStack()->add('password', $this->_translate->translate('Invalid password'));
                //throw new Zenfox_Exception($this->_translate->translate('Invalid password'));
                $this->_error = true;
            }*/

            if($this->validateEmail($player['email']))
            {
            	$this->_myAccount['email'] = $player['email'];
                $this->_myAcctDetails['email'] = $player['email'];
            }
            else
            {
                //unset($this->_myAcctDetails['email']);
                $this->_myAcctDetails['email'] = NULL;
                $this->getErrorStack()->add('email', $this->_translate->translate('Invalid Email'));
                //throw new Zenfox_Exception($this->_translate->translate('Invalid Email'));
                $this->_error = true;
            }}
            
    		$frontend = new Frontend();
    		$frontendData = $frontend->getFrontendById($player['frontendId']);
    		
    		$affiliateTracker = new AffiliateTracker();
    		$trackerData = $affiliateTracker->getAffiliateTracker($player['trackerId']);

			$today = new Zend_Date();
			$date = explode('T',$today->get(Zend_Date::W3C));
			$created = $date[0] . " " . $date[1];

    		//Zenfox_Debug::dump($frontendData, 'data', true, true);
    	    $this->_myAccount['login'] = $player['login'];
            $this->_myAccount['email'] = $player['email'];
            $this->_myAccount['first_name'] = $player['firstName'];
            $this->_myAccount['last_name'] = $player['lastName'];
            $this->_myAccount['sex'] = $player['sex'];
            $this->_myAccount['dateofbirth'] = $player['dateOfBirth'];
            $this->_myAccount['address'] = $player['address'];
            $this->_myAccount['city'] = $player['city'];
            $this->_myAccount['state'] = $player['state'];
            $this->_myAccount['country'] = $player['country'];
            $this->_myAccount['pin'] = $player['pin'];
            $this->_myAccount['phone'] = $player['phone'];
           /* $this->_myAccount['question'] = $player['securityQuestion'];
            $this->_myAccount['hint'] = $player['hint'];*/
            $this->_myAccount['frontend_id'] = $player['frontendId'];
            $this->_myAccount['newsletter'] = $player['newsletter'];
			$this->_myAccount['promotions'] = $player['promotions'];
			$this->_myAccount['frontend_id'] = $player['frontendId'];
            
            $this->_myAcctDetails['login'] = $player['login'];
            $this->_myAcctDetails['password'] = $player['password'];
            $this->_myAcctDetails['email'] = $player['email'];
            $this->_myAcctDetails['frontend_id'] = $player['frontendId'];
            $this->_myAcctDetails['bank'] = 0;
            $this->_myAcctDetails['winnings'] = 0;
            $this->_myAcctDetails['bonus_bank'] = 0;
            $this->_myAcctDetails['bonus_winnings'] = 0;
            $this->_myAcctDetails['cash'] = 0;
            $this->_myAcctDetails['balance'] = 0;
            $this->_myAcctDetails['tracker_id'] = $player['trackerId'];
			$this->_myAcctDetails['buddy_id'] = $player['buddyId'];
            $this->_myAcctDetails['base_currency'] = $frontendData[0]['default_currency'];
			$this->_myAcctDetails['language'] = $frontendData[0]['languages'];
            $this->_myAcctDetails['bonusable'] = $player['bonusAble'];
            $this->_myAcctDetails['created'] = $created;
            $this->_myAcctDetails['last_login'] = $created;
	    $this->_myAcctDetails['bonus_scheme_id'] = $frontendData[0]['default_bonus_scheme_id'];
	    $this->_myAcctDetails['noof_deposits'] = 0;
	    $this->_myAcctDetails['total_loyalty_points'] = 1000;
	    $this->_myAcctDetails['loyalty_points_left'] = 1000;

            //After all the validation is done. Save
            if($this->_error)
            {
            	$userErrors = $this->getErrorStack();
            	foreach($userErrors as $errorCodes) {
    			$error = $errorCodes[0];
            	}
                //FIXME:: Should the caller retrieve errorStack() or should we return it?
                return array(false,$error);
            }
            
            if($this->save())
            {
            	if($this->updateAccountUnconfirm($player['code']))
            	{
            		return array(true);
            	}
            }
            return array(false,'Some problem has been occured while creating the account. Please contact to our support.');
    }
    
    public function registerUnconfirm($player, $completeRegistration = NULL)
    {
    	$today = new Zend_Date();
        $currentTime = $today->get(Zend_Date::W3C);
        $expiryTime = date ("Y-m-d H:i:s", strtotime("$currentTime, +15 DAYS"));
        $code = md5($player['email'] . $currentTime);
        if(strpos($player['email'], 'mailinator.com') || strpos($player['email'], 'disposableinbox.com') || strpos($player['email'], 'sharklasers.com') || strpos($player['email'], 'guerillamailblock.com') || strpos($player['email'], 'fakeinbox.com') || strpos($player['email'], 'hushmail.com'))
        {
        	$this->getErrorStack()->add('email', $this->_translate->translate('Invalid Email'));
        	$this->_error = true;
        }
        
    	if(!isset($player))
        {
            throw new Zenfox_Exception($this->_translate->translate("Player data undefined"));
        }
        else
        {
            if($this->validateUnconfirmLogin($player['login']))
            {
                $this->_unconfirmAccount['login'] = $player['login'];
            }
            else
            {
                //unset($this->_myAccount['login']);
                $this->_unconfirmAccount['login'] = NULL;
                $this->getErrorStack()->add('login', $this->_translate->translate('Invalid login'));
                //throw new Zenfox_Exception($this->_translate->translate('Invalid login'));
                $this->_error = true;
            }
            
            $frontendId = Zend_Registry::get('frontendId');

            if($frontendId < 7 && $this->validatePassword($player['password'], $player['confirmPassword']))
            {
                $this->_unconfirmAccount['password'] = md5($player['password']);
            }
            else if($frontendId < 7)
            {
                //unset($this->_myAcctDetails['password']);
                $this->_unconfirmAccount['password'] = NULL;
                $this->getErrorStack()->add('password', $this->_translate->translate('Invalid password'));
                //throw new Zenfox_Exception($this->_translate->translate('Invalid password'));
                $this->_error = true;
            }

            if($this->validateUnconfirmEmail($player['email']))
            {
            	$this->_unconfirmAccount['email'] = $player['email'];
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
            
            if($frontendId >= 7)
            {
            	$this->_unconfirmAccount['password'] = md5($player['password']);
            	$this->_unconfirmAccount['phone'] = $player['confirmPassword'];
            }
			$this->_unconfirmAccount['code'] = $code;
			$this->_unconfirmAccount['expiry_time'] = $expiryTime;
			$this->_unconfirmAccount['frontend_id'] = Zend_Registry::getInstance()->get('frontendId');
			$this->_unconfirmAccount['tracker_id'] = $player['trackerId'];
			$this->_unconfirmAccount['buddy_id'] = $player['buddyId'];
			$this->_unconfirmAccount['created'] = $currentTime;

	    	if($completeRegistration)
	    	{
	    		$this->_unconfirmAccount['first_name'] = $player['first_name'];
		        $this->_unconfirmAccount['last_name'] = $player['last_name'];
		        $this->_unconfirmAccount['sex'] = $player['sex'];
		        $this->_unconfirmAccount['dateofbirth'] = $player['dateofbirth'];
		        $this->_unconfirmAccount['address'] = $player['address'];
		        $this->_unconfirmAccount['city'] = $player['city'];
		        $this->_unconfirmAccount['state'] = $player['state'];
		        $this->_unconfirmAccount['country'] = $player['country'];
		        $this->_unconfirmAccount['pin'] = $player['pin'];
		        $this->_unconfirmAccount['phone'] = $player['phone'];
		        /*$this->_unconfirmAccount['question'] = $player['question'];
		        $this->_unconfirmAccount['hint'] = $player['hint'];
		        $this->_unconfirmAccount['answer'] = $player['answer'];*/
		        $this->_unconfirmAccount['newsletter'] = $player['newsletter'];
	    	}
	        
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
    
    public function validateUnconfirmLogin($login)
    {
    	$frontendId = Zend_Registry::getInstance()->get('frontendId');
    	
    	$errorStack = $this->getErrorStack();
        if (is_string($login))
        {
            //Check if login exists
            $query = Zenfox_Query::create()
            			->from('AccountUnconfirm a')
            			->where('a.login = ?', $login)
            			->andWhere('a.frontend_id = ?', $frontendId);
            			
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
        	$frontendId = Zend_Registry::getInstance()->get('frontendId');
            //Check if login exists
            $query = Zenfox_Query::create()
            			->from('AccountUnconfirm a')
            			->where('a.email = ?', $email)
            			->andWhere('a.frontend_id = ?', $frontendId);
            			
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

    /**
     * This function validates login
     * TODO:: Expand this function
     * @param  string $login
     * @return boolean
     */
    public function validateLogin($login)
    {
    	$errorStack = $this->getErrorStack();
        if (is_string($login))
        {
            //Check if login exists
            $player_id = $this->getAccountIdFromLogin($login);
            
            if(!$player_id)
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

    /**
     * This function validates login
     * TODO:: Expand this function
     * @param  string $password
     * @return boolean
     */
    public function validatePassword($password, $confirmPassword)
    {
    	$errorStack = $this->getErrorStack();
        if (is_string($password))
        {
        	if($password==$confirmPassword)
        	{
        		return true;
        	}
            else
            {
            	//$errorStack = $this->getErrorStack();
            	$errorStack->add('password', $this->_translate->translate('Password and Confirm Password fields do not match.'));
            	//throw new Zenfox_Exception($this->_translate->translate('Password and Confirm Password fields do not match.'));
            }
        }
        else
        {
            //$errorStack = $this->getErrorStack();
            $errorStack->add('password', $this->_translate->translate('Invalid password.'));
            //throw new Zenfox_Exception($this->_translate->translate('Invalid password.'));
        }
    }

    /**
     * This function validates email
     * If email EXISTS, returns FALSE
     * If it does NOT EXISTS returns TRUE
     * TODO:: Expand this function
     * @param  string $email
     * @return boolean
     */
    public function validateEmail($email)
    {
    	$errorStack = $this->getErrorStack();
        if (is_string($email))
        {
            $player_id = $this->getAccountIdFromEmail($email);

            //Email exists
            if(!$player_id)
            {
                return true;
            }
            else
            {
                //$errorStack = $this->getErrorStack();
                $errorStack->add('email', $this->_translate->translate('Email already exists'));
                //throw new Zenfox_Exception($this->_translate->translate('Email already exists'));
            }
        }
        else
        {
            //$errorStack = $this->getErrorStack();
            $errorStack->add('email', $this->_translate->translate('Invalid email.'));
            //throw new Zenfox_Exception($this->_translate->translate('Invalid email.'));
        }
        return false;
    }

    public function getAccountIdFromEmail($email)
    {
        //No connection switching required as Account id bound to master
        /*$accountTable = Doctrine::getTable('AccountUnconfirm');
    	$accountData = $accountTable->findOneByEmail($email);
        foreach($accountData as $key => $value)
        {
        	if($key == 'player_id')
        	{
        		$account['player_id'] = $value;
        	}
        }
        if(isset($account['player_id']))
        {
        	return $account['player_id'];
        }*/
    	
    	
        /* $accountTable = Doctrine::getTable('Account');
//        $accountTable = Doctrine::getTable('Account');
        $account = $accountTable->findOneByEmail($email); */
    	
    	$frontendId = Zend_Registry::get('frontendId');
    
    	$conn = Zenfox_Partition::getInstance()->getMasterConnection();
    	Doctrine_Manager::getInstance()->setCurrentConnection($conn);
    	
    	$query = Zenfox_Query::create()
			    	->from('Account a')
			    	->where('a.email = ?', $email)
			    	->andWhere('a.frontend_id = ?', $frontendId);
    			
    	try
    	{
    		$result = $query->fetchArray();
    	}
    	catch(Exception $e)
    	{
    		//Zenfox_Debug::dump($e, 'exceptions', true, true);
    	}
    			
    	if($result)
    	{
    		$account = $result[0];
    		return true;
    	}
    	return NULL;
    }

    public function getAccountIdFromLogin($login, $forgotPassword = false)
    {
        //No connection switching required as Account id bound to master
    	/*$accountTable = Doctrine::getTable('AccountUnconfirm');
        $accountData = $accountTable->findOneByLogin($login);
        foreach($accountData as $key => $value)
        {
        	if($key == 'player_id')
        	{
        		$account['player_id'] = $value;
        	}
        }
        
        if(isset($account['player_id']))
        {
        	return $account['player_id'];
        }*/
    	
    	
        /* $accountTable = Doctrine::getTable('Account');
//        $accountTable = Doctrine::getTable('Account');
        $account = $accountTable->findOneByLogin($login); */
    	
    	$account = NULL;
    	$frontendId = Zend_Registry::get('frontendId');
    	 
    	$conn = Zenfox_Partition::getInstance()->getMasterConnection();
    	Doctrine_Manager::getInstance()->setCurrentConnection($conn);
    	
    	if($forgotPassword)
    	{	    	 
	    	$frontend = new Frontend();
	    	$frontendData = $frontend->getFrontendById($frontendId);
	    	 
	    	$allowedFrontendIds = explode(',', $frontendData[0]['allowed_frontend_ids']);
	    	
	    	foreach($allowedFrontendIds as $frontendId)
	    	{
	    		$query = Zenfox_Query::create()
	    					->from('Account a')
	    					->where('a.login = ?', $login)
	    					->andWhere('a.frontend_id = ?', $frontendId);
	    		
	    		try
	    		{
	    			$accountData = $query->fetchArray();
	    		}
	    		catch(Exception $e)
	    		{
	    			
	    		}
	    		if($accountData)
	    		{
    				return $accountData[0];
	    		}
	    	}
    	}
    	else
    	{
    		$query = Zenfox_Query::create()
			    		->from('Account a')
			    		->where('a.login = ?', $login)
			    		->andWhere('a.frontend_id = ?', $frontendId);
    		 
    		try
    		{
    			$result = $query->fetchArray();
    		}
    		catch(Exception $e)
    		{
    			//Zenfox_Debug::dump($e, 'exceptions', true, true);
    		}
    		 
    		if($result)
    		{
    			$account = $result[0];
    			return $account;
    		}
    	}
    	
    	return NULL;
    	
    	//Previous Code Start
		/* if(!$account['player_id'])
        {
        	$conn = Zenfox_Partition::getInstance()->getMasterConnection();
        	Doctrine_Manager::getInstance()->setCurrentConnection($conn);
        	
        	$query = Zenfox_Query::create()
        				->from('AccountUnconfirm a')
        				->where('a.login = ?', $login)
        				->andWhere('a.frontend_id = ?', $frontendId);
        	
        	$result = $query->fetchArray();
        	if($result)
        	{
        		return array(
        		        'type' => 'unconfirm',
				'playerData' => $result[0]
        		);
        	}
        	else
        	{
        		return NULL;
        	}
        }

        return array(
        	'type' => 'confirm',
        	'player_id' => $account['player_id']
        ); */
    	//END
    	

        //return $account['player_id'];
    }

    /**
     *
     * @params  string $login
     * @return  mixed  false or email (string)
     */

    public function getEmailFromLogin($login)
    {
		$accountData = $this->getAccountIdFromLogin($login);
    	/* if($accountData['type'] == 'confirm')
    	{
    		$player_id = $accountData['player_id'];
    	} */
        if(isset($accountData))
        {
        	$player_id = $accountData['player_id'];
        	
            $conn = Zenfox_Partition::getInstance()->getConnections($player_id);
            Doctrine_Manager::getInstance()->setCurrentConnection($conn);
            $accountDetailTable = Doctrine::getTable('AccountDetail');
            //FIXME:: Should this be on player_id or login?
            $accountDetail = $accountDetailTable->findOneByPlayerId($player_id);

            return $accountDetail['email'];
        }
        else
        {
            return false;
        }
    }
    
    private function _getPlayerIdByDetail()
    {
    	$conn = Zenfox_Partition::getInstance()->getMasterConnection();
    	Doctrine_Manager::getInstance()->setCurrentConnection($conn);
    	
    	$frontendId = Zend_Registry::get('frontendId');
    	
    	$query = Zenfox_Query::create()
    				->from('Account a')
    				->where('a.login = ?', $this->_myAccount['login'])
    				->andWhere('a.email = ?', $this->_myAccount['email'])
    				->andWhere('a.frontend_id = ?', $frontendId);
    	
    	try
    	{
    		$result = $query->fetchArray();
    	}
    	catch(Exception $e)
    	{
    		
    	}
    	
    	$this->_myAccount['player_id'] = $result[0]['player_id'];
    }

    /**
     * This functions saves the data to account and account_details
     * It first saves account and then account_details
     * @param Doctrine_Connection $conn <--FIXME:: Is this needed?
     * @return void
     */
    public function save(Doctrine_Connection $conn = null)
    {
        try
        {
            //This doesn't need connection switching as its bound to 'master'
            $this->_myAccount->save();
        }
        catch (Exception $e)
        {
        	return false;
//        	print '<pre>';
//            print $this->_translate->translate('Unable to save Account with Exception') . $e;
//            exit();
        }
        
        $this->_getPlayerIdByDetail();

        //If the player_id is not the same then
        if($this->_myAcctDetails['player_id'] != $this->_myAccount['player_id'])
        {
         //   print 'Setting player_id to ' . $this->_myAccount['player_id'];
            $this->_myAcctDetails['player_id'] = $this->_myAccount['player_id'];
        }
        try
        {
            $connName = Zenfox_Partition::getInstance()
                        ->getConnections($this->_myAccount['player_id']);
            $partition = Doctrine_Manager::getInstance()->getConnection($connName);
        }
        catch (Zenfox_Partition_Exception $e)
        {
            print $this->_translate->translate('Unable to get partition connection with partition Key::') . $this->_myAccount['player_id'];
        }
        try
        {
            $this->_myAcctDetails->save($partition);
        }
        catch (Exception $e)
        {
        	return false;
//            print '<pre>';
//            print $this->_translate->translate('Unable to save Account Details with exception') . $e;
//            print $this->_translate->translate('Account Details::');
            //print_r($this->_myAcctDetails->toArray(true));
        }
        return true;
    }

    //TODO:: This has to be moved
  /*  public function getPlayers()
    {
        try
        {
            print $this->_translate->translate("STarting");
            $accountTable = Doctrine::getTable('Account');

            print $this->_translate->translate("Ending!!");
        }
        catch (Exception $e)
        {
        	print '<pre>';
            print $this->_translate->translate("Exception ") . $e;
        }

        foreach ($accountTable->findAll() as $player)
        {
            $player = $player->toArray();

            $conn = Zenfox_Partition::getInstance()->getConnections($player['player_id']);
            Doctrine_Manager::getInstance()->setCurrentConnection($conn);

            $accountDetails = Zenfox_Query::create()
                            ->select('a.login', 'a.balance')
                            ->from('accountDetail a')
                            ->whereIn('a.player_id', $player['player_id'])
                            ->execute()
                            ->toArray(true);

            $playerDetails[$player['player_id']]['login'] = $player['login'];
            $playerDetails[$player['player_id']]['balance'] = $accountDetails[$player['player_id']]['balance'];
        }
        return $playerDetails;
    }*/
    
    public function editProfile($data, $playerId)
    {
    	$connName = Zenfox_Partition::getInstance()->getMasterConnection();
    	Doctrine_Manager::getInstance()->setCurrentConnection($connName);
    	
    	/*$str = '';
		foreach($data as $key => $index)
		{
			print($index);
			echo '<br>';
			if($key != 'changepwd')
				$str = $str . "->set('a." . $key . "', '?', \"$index\")";
		}
    	$query = "Zenfox_Query::create()->update('Account a')" . $str . "->where('a.player_id = ?', $playerId);"
    	//Zenfox_Debug::dump($query->getSql(), 'query');
    	eval("\$query=" . $query);*/
    	//exit();

	$query = Zenfox_Query::create()
    				->update('Account a');
    	foreach($data as $field => $fieldVal)
    	{
    		if($field == 'temp')
    		{
    			continue;
    		}
		if($field != "password")
		{
			$query = $query->set('a.' . $field, '?', $fieldVal);
		}
    	}
    	$query = $query->where('a.player_id = ? ', $playerId);

    	/*$query = Zenfox_Query::create()
    				->update('Account a')
    				->set('a.first_name', '?', $data['first_name'])
    				->set('a.last_name', '?', $data['last_name'])
    				->set('a.sex', '?', $data['sex'])
    				->set('a.dateofbirth', '?', $data['dateofbirth'])
    				->set('a.address', '?', $data['address'])
    				->set('a.city', '?', $data['city'])
    				->set('a.state', '?', $data['state'])
    				->set('a.country', '?', $data['country'])
    				->set('a.pin', '?', $data['pin'])
    				->set('a.phone', '?', $data['phone'])
    				->set('a.question', '?', $data['question'])
    				->set('a.hint', '?', $data['hint'])
    				->set('a.answer', '?', $data['answer'])
    				->set('a.newsletter', '?', $data['newsletter'])
    				->where('a.player_id = ? ', $playerId);*/
    				
    	try
    	{
    		$query->execute();
    	}
    	catch(Exception $e)
    	{
    		//print $this->_translate->translate('Unable to update the profile');
    		return false;
    	}
    	return true;
    }
    
    public function getPlayerData($playerId)
    {
    	$connName = Zenfox_Partition::getInstance()->getConnections(0);
    	Doctrine_Manager::getInstance()->setCurrentConnection($connName);
    	
    	try
    	{
    		$result = Doctrine::getTable('Account')->findOneByPlayerId($playerId);
    	}
    	catch(Exception $e)
    	{
    		return false;
    	}
    	if($result)
    	{
    		return array(
    			'playerId' => $result['player_id'],
    			'login' => $result['login'],
    			'firstName' => $result['first_name'],
    			'lastName' => $result['last_name'],
    			'email' => $result['email'],
    			'sex' => $result['sex'],
    			'dateOfBirth' => $result['dateofbirth'],
    			'address' => $result['address'],
    			'city' => $result['city'],
    			'state' => $result['state'],
    			'country' => $result['country'],
    			'pin' => $result['pin'],
    			'phone' => $result['phone'],
    			'newsletter' => $result['newsletter'],
    			'frontendId' => $result['frontend_id']);
    			/* 'securityQuestion' => $result['question'],
    			'hint' => $result['hint'],
    			'securityAnswer' => $result['answer'],
    			'newsletter' => $result['newsletter'],
    			'promotions' => $result['promotions'],
    			'blackList' => $result['black_list']); */
    	}
    	return NULL;
    }
    
  /*  public function getPassword($playerId)
    {
    	$connName = Zenfox_Partition::getInstance()->getConnections($playerId);
    	Doctrine_Manager::getInstance()->setCurrentConnection($connName);
    	
    	$result = Doctrine::getTable('AccountDetail')->findOneByPlayerId($playerId);
    	return $result['password'];
    }*/
    
    public function changePassword($password, $playerId)
    {
    	$connName = Zenfox_Partition::getInstance()->getConnections($playerId);
    	Doctrine_Manager::getInstance()->setCurrentConnection($connName);
    	
    	$query = Zenfox_Query::create()
    				->update('AccountDetail a')
    				->set('a.password', '?', $password)
    				->where('a.player_id = ?', $playerId);
    				
    	try
    	{
    		$query->execute();
    	}
    	catch(Exception $e)
    	{
    		//print $this->_translate->translate('Unable to change the password');
    		return false;
    	}
    	return true;
    }
    
    /** This function get the player id for particular login name, used for facebook
     * 
     * @param $login
     * @return playerId
     */
	public function getPlayerId($login)
    {
    	$frontendId = Zend_Registry::get('frontendId');
    	
        $connections = Zenfox_Partition::getInstance()->getConnections(-1);
        foreach($connections as $connection)
        {
        	Doctrine_Manager::getInstance()->setCurrentConnection($connection);
        	
        	$query = Zenfox_Query::create()
        				->from('AccountDetail a')
        				->where('a.login = ?', $login)
        				->andWhere('a.frontend_id = ?', $frontendId);
        	
        	try
        	{
        		$result = $query->fetchArray();
        	}
        	catch(Exception $e)
        	{
        		$filePath = '/home/zenfox/backup_player/error_logs.txt';
        		$fh = fopen($filePath, 'a');
        		fwrite($fh, "GETTING PLAYER ID->" . $e);
        		fclose($fh);
        		return false;
        	}
        	if($result)
        	{
        		break;
        	}
        }

        /* try
        {
        	$query = Zenfox_Query::create()
        				->from('Account a')
        				->where('a.login = ?', $login);
        	
        	$result = $query->fetchArray();
        	//$result = Doctrine::getTable('Account')->findOneByLogin($login);
        }
        catch(Exception $e)
        {
			$filePath = '/home/zenfox/backup_player/error_logs.txt';
            $fh = fopen($filePath, 'a');
            fwrite($fh, "GETTING PLAYER ID->" . $e);
            fclose($fh);
        	return false;
        } */
        return $result[0]['player_id'];
    }
    /** This function get all details of account for particular player id
     * @param $playerId
     * @return array
     */
    public function getAccountDetails($playerId)
    {
     	$connName = Zenfox_Partition::getInstance()->getConnections($playerId);
        Doctrine_Manager::getInstance()->setCurrentConnection($connName);

        $query = Zenfox_Query::create()
                        ->from('AccountDetail a')
                        ->where('a.player_id = ?', $playerId);

        try
        {
        	$result = $query->fetchArray();
        }
        catch(Exception $e)
        {
        	$filePath = '/home/zenfox/backup_player/error_logs.txt';
        	$fh = fopen($filePath, 'a');
        	fwrite($fh, "GETTING ACCOUNT DETAILS->" . $e);
        	fclose($fh);
        	return false;
        }
    //    Zenfox_Debug::dump($result, 'paginator', true, true);
        return $result;
    }
    
    public function getAllPlayers($searchingField, $whereCon, $offset = NULL, $itemsPerPage = NULL, $session = NULL, $searchString = NULL, $frontendids = NULL, $accountType = "confirmed")
    {
    	//$frontendids = implode(",", $frontendids);
    	if(!$searchString)
    	{
    		if($accountType == "unconfirmed")
    		{
    			$query = "Zenfox_Query::create()
    					->from('AccountUnconfirm a')
    					->WhereIn('a.frontend_id', array($frontendids))";
    		}
    		else
    		{
    				$query = "Zenfox_Query::create()
    					->from('AccountDetail a')
    					->WhereIn('a.frontend_id', array($frontendids))";
    		}
    		
    		
    	}
    	elseif(!$whereCon)
    	{
    		$query = "Zenfox_Query::create()
    					->from('AccountDetail a')
    					->WhereIn('a.frontend_id', array($frontendids))
    					->andwhere('a.$searchingField LIKE ?', '%$searchString%')";
    		
    		if($accountType == "unconfirmed")
    		{
    			$query = "Zenfox_Query::create()
    					->from('AccountUnconfirm a')
    					->WhereIn('a.frontend_id', array($frontendids))
    					->andwhere('a.$searchingField = ?', '$searchString')";
    		}
    	}
    	elseif($whereCon)
    	{
    		$query = "Zenfox_Query::create()
    					->from('AccountDetail a')
    					->WhereIn('a.frontend_id', array($frontendids))
    					->andwhere('a.$searchingField = ?', '$searchString')";
    	}
    	
    	
    	if(!$offset && !$itemsPerPage)
    	{
    		$allPlayers = array();
    		$playerIds = array();
    		$query = $query . ";";
			$str = "";
			$index = 0;
    		if($accountType == "unconfirmed")
    		{
    			$connections = Zenfox_Partition::getInstance()->getConnections(0);
    		}
    		else
    		{
    			$connections = Zenfox_Partition::getInstance()->getConnections(-1);
    		}
			
			foreach($connections as $conn)
			{
				Doctrine_Manager::getInstance()->setCurrentConnection($conn);
				eval ( "\$str=" . $query );
				try
				{
					$players = $str->fetchArray();
				}
				catch(Exception $e)
				{
					Zenfox_Debug::dump($e, 'exception', true, true);
				}
				if($players)
				{
					foreach($players as $playerData)
					{
						if(!in_array($playerData['player_id'], $playerIds))
						{
							$playerIds[] = $playerData['player_id'];
							$allPlayers[$index]['Player Id'] = $playerData['player_id'];
							$allPlayers[$index]['Login Name'] = $playerData['login'];
							$allPlayers[$index]['User Name'] = $this->getUserName($playerData['player_id']);
							$allPlayers[$index]['Email'] = $playerData['email'];
							$index++;
						}
					}
				}
			}
			return $allPlayers;
    	}
    	
    	if($accountType == "unconfirmed")
    	{
    		$adapter = new Zenfox_Paginator_Adapter_DoctrineQuery($query, 0, $session);
    	}
    	else
    	{
    		$adapter = new Zenfox_Paginator_Adapter_DoctrineQuery($query, -1, $session);
    	}
    	
    	$paginatorSession = new Zend_Session_Namespace('paginationCount');
		$paginatorSession->value = false;
    	$paginator =  new Zend_Paginator($adapter);
		$paginator->setItemCountPerPage($itemsPerPage);
		$paginator->setPageRange(2);
		$paginator->setCurrentPageNumber($offset);
		if(!$paginator->getTotalItemCount())
		{
			return false;
		}
		$playerData = array();
		$index = 0;
		foreach($paginator as $logs)
		{
			$playerData[$index]['Player Id'] = $logs['player_id'];
			$playerData[$index]['Login Name'] = $logs['login'];
			$playerData[$index]['User Name'] = $this->getUserName($logs['player_id']);
			$playerData[$index]['Email'] = $logs['email'];
			$index++;
		}
		$paginatorSession->unsetAll();
		return array($paginator, $playerData);
    }
   
    public function getAllPlayersId($searchingField, $searchingString)
    {
    	$i = 0;
    	$connections = Zenfox_Partition::getInstance()->getConnections(-1);
    	foreach($connections as $conn)
    	{
    		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
    		$query = Zenfox_Query::create()
    					->select('a.player_id')
    					->from('AccountDetail a')
    					->where("a.$searchingField = ?", $searchingString);
    					
    		$result = $query->fetchArray();
    		foreach($result as $playerData)
    		{
    			$playersId[$i] = $playerData['player_id'];
    			$i++; 
    		}
    	}
    	return $playersId;
    }
    
    public function getUserName($playerId)
    {
    	$conn = Zenfox_Partition::getInstance()->getMasterConnection();
    	Doctrine_Manager::getInstance()->setCurrentConnection($conn);
    	
    	$query = Zenfox_Query::create()
    					->from('Account a')
    					->where('a.player_id = ?', $playerId);
    					
    	$result = $query->fetchArray();
    	$name = $result[0]['login'];
    	if($result[0]['first_name'])
    	{
    		$name = $result[0]['first_name'];
    	}
    	return $name;
    }
    
	public function getEmail($playerId)
    {
    	$conn = Zenfox_Partition::getInstance()->getConnections($playerId);
    	Doctrine_Manager::getInstance()->setCurrentConnection($conn);
    	
    	$query = Zenfox_Query::create()
    					->select('a.email')
    					->from('AccountDetail a')
    					->where('a.player_id = ?', $playerId);
    					
    	$result = $query->fetchArray();
    	return $result[0]['email'];
    }
	
	public function updateLastLogin($playerId)
    {
    	$conn = Zenfox_Partition::getInstance()->getConnections($playerId);
    	Doctrine_Manager::getInstance()->setCurrentConnection($conn);
    	
    	$today = new Zend_Date();
		$date = explode('T',$today->get(Zend_Date::W3C));
		$loginTime = $date[0] . " " . $date[1];
    	
    	$query = Zenfox_Query::create()
    				->update('AccountDetail a')
    				->set('a.last_login', '?', $loginTime)
    				->where('a.player_id = ?', $playerId);
    				
    	try
    	{
    		$query->execute();
    	}
    	catch(Exception $e)
    	{
    		$filePath = '/home/zenfox/backup_player/error_logs.txt';
                $fh = fopen($filePath, 'a');
                fwrite($fh, "UPDATING LAST LOGIN IN PLAYER->" . $e);
                fclose($fh);
    	}
    }
    
    public function checkAccountIdFromEmail($email)
    {
    	$frontendId = Zend_Registry::get('frontendId');
    	 
    	$frontend = new Frontend();
    	$frontendData = $frontend->getFrontendById($frontendId);
    	 
    	$allowedFrontendIds = explode(',', $frontendData[0]['allowed_frontend_ids']);
    	
    	$connection = Zenfox_Partition::getInstance()->getMasterConnection();
    	Doctrine_Manager::getInstance()->setCurrentConnection($connection);
    	
    	foreach($allowedFrontendIds as $frontendId)
    	{
    		$query = Zenfox_Query::create()
    					->from('Account a')
    					->where('a.email = ?', $email)
    					->andWhere('a.frontend_id = ?', $frontendId);
    		
    		try
    		{
    			$accountData = $query->fetchArray();
    		}
    		catch(Exception $e)
    		{
    			
    		}
    		if($accountData)
    		{
    			break;
    		}
    	}
    	/* $conn = Zenfox_Partition::getInstance()->getMasterConnection();
    	Doctrine_Manager::getInstance()->setCurrentConnection($conn);
    	$query = Zenfox_Query::create()
    				->select('a.player_id, a.login')
    				->from('Account a')
    				->where('a.email = ?', $email);
    				
    	$accountData = $query->fetchArray(); */
    	foreach($accountData as $playerData)
    	{
    		$playerId = $playerData['player_id'];
    		$login = $playerData['login'];
    		
    		$conn = Zenfox_Partition::getInstance()->getConnections($playerId);
	    	Doctrine_Manager::getInstance()->setCurrentConnection($conn);
	    	$query = Zenfox_Query::create()
	    				->select('ad.password')
	    				->from('AccountDetail ad')
	    				->where('ad.player_id = ?', $playerId);
	    				
	    	$accountDetailData = $query->fetchArray();
	    	$password = md5($login);
	    	foreach($accountDetailData as $playerDetails)
	    	{
	    		$actualPassword = $playerDetails['password'];
	    		if($actualPassword != $password)
	    		{
	    			return $playerId;
	    		}
	    	}
    	}
/*    	$playerId = $accountData[0]['player_id'];
    	$login = $accountData[0]['login'];
    				
    	$actualPassword = $accountDetailData[0]['password'];
        $accountTable = Doctrine::getTable('Account');
        $account = $accountTable->findOneByEmail($email);

        return $account['player_id'];*/
    }
    
    public function updateFacebookData($playerId, $data)
    {
    	//Zenfox_Debug::dump($data, 'data');
    	$connName = Zenfox_Partition::getInstance()->getMasterConnection();
    	Doctrine_Manager::getInstance()->setCurrentConnection($connName);
    	
    	$query = Zenfox_Query::create()
    				->update('Account a')
    				->set('a.first_name', '?', $data['firstName'])
    				->set('a.last_name', '?', $data['lastName']);
    				//->set('a.sex', '?', $data['sex'])
    				//->set('a.dateofbirth', '?', $data['dateOfBirth'])
    	if($data['email'])
    	{
    		$query = $query->set('a.email', '?', $data['email']);
    	}
    	$query = $query->where('a.player_id = ? ', $playerId);
    	
    	try
    	{
    		$query->execute();
    	}
    	catch(Exception $e)
    	{
    		//Zenfox_Debug::dump($e, 'error', true, true);
    		return false;
    	}
    	
    	$connName = Zenfox_Partition::getInstance()->getConnections($playerId);
    	Doctrine_Manager::getInstance()->setCurrentConnection($connName);
    	
    	$query = Zenfox_Query::create()
    				->update('AccountDetail a');
    	if($data['email'])
    	{
    		$query = $query->set('a.email', '?', $data['email']);
    		$query = $query->where('a.player_id = ? ', $playerId);
    		
    		try
    		{
    			$query->execute();
    		}
    		catch(Exception $e)
    		{
    			//Zenfox_Debug::dump($e, 'error');
    			return false;
    		}
    	}
    	return true;
    }   

	public function getUnconfirmPlayers($offset = NULL, $itemsPerPage = NULL, $session = NULL, $fromDate = NULL, $toDate = NULL, $frontendId = NULL, $trackerId = NULL)
    {
    	if($fromDate)
    	{
    		if($toDate)
    		{
    			$query = "Zenfox_Query::create()
    							->from('AccountUnconfirm a')
    							->where('a.created between ? and ?', array('$fromDate', '$toDate'))
    							->andWhere('a.email not like ?', '%@mailinator%')
    							->andWhere('a.email not like ?', '%proxymail.facebook.com%')
    							->andWhere('a.confirmation = ?','NO')";
    		}
    		else
    		{
    			$query = "Zenfox_Query::create()
    							->from('AccountUnconfirm a')
    							->where('a.created >= ?', '$fromDate')
    							->andWhere('a.email not like ?', '%@mailinator%')
    							->andWhere('a.email not like ?', '%proxymail.facebook.com%')
    							->andWhere('a.confirmation = ?','NO')";
    		}
    	}
    	else
    	{
    		$query = "Zenfox_Query::create()
    	    				->from('AccountUnconfirm a')
    	    				->andWhere('a.email not like ?', '%@mailinator%')
    	    				->andWhere('a.email not like ?', '%proxymail.facebook.com%')
    	    				->andWhere('a.confirmation = ?','NO')";
    	}
    	if($frontendId)
    	{
    		$query .= "->andWhere('a.frontend_id = ?', '$frontendId')";
    	}
    	if($trackerId)
    	{
		if($trackerId == -1)
                {
                      $trackerId = 0;
                }

    		$query .= "->andWhere('a.tracker_id = ?', $trackerId)";
    	}
    	$playerData = array();
    	if(!$offset && !$itemsPerPage)
    	{
    		$query = $query . ";";
    		$str = "";
    		$connection = Zenfox_Partition::getInstance()->getMasterConnection();
    		$index = count($playerData);
    		Doctrine_Manager::getInstance()->setCurrentConnection($connection);
    		eval ( "\$str=" . $query );
    		try
    		{
    			$registrations = $str->fetchArray();
    		}
    		catch(Exception $e)
    		{
    			Zenfox_Debug::dump($e, 'exception', true, true);
    		}
    		if($registrations)
    		{
    			$playerData = $this->_generatePlayerDataArray($playerData, $index, $registrations, true, true);
    		}
    		return $playerData;
    	}
    	else
    	{
    		$adapter = new Zenfox_Paginator_Adapter_DoctrineQuery($query, 0, $session);
    		$paginatorSession = new Zend_Session_Namespace('paginationCount');
    		$paginatorSession->value = false;
    		$paginator =  new Zend_Paginator($adapter);
    		$paginator->setItemCountPerPage($itemsPerPage);
    		$paginator->setPageRange(2);
    		$paginator->setCurrentPageNumber($offset);
    		if(!$paginator->getTotalItemCount())
    		{
    			return false;
    		}
    		$index = count($playerData);
    	
    		$playerData = $this->_generatePlayerDataArray($playerData, $index, $paginator, false, true);
    		$paginatorSession->unsetAll();
    		return array($paginator, $playerData);
    	}
    }
    
	public function getAllRegistrations($offset = NULL, $itemsPerPage = NULL, $session = NULL, $fromDate = NULL, $toDate = NULL, $frontendids = NULL, $trackerId = NULL)
    {
    	if($fromDate)
		{
			if($toDate)
			{
				$query = "Zenfox_Query::create()
								->from('AccountDetail a')
								->where('a.created between ? and ?', array('$fromDate', '$toDate'))
								->andWhere('a.email not like ?', '%@mailinator%')
								->andWhere('a.email not like ?', '%proxymail.facebook.com%')";
			}
			else
			{
				$query = "Zenfox_Query::create()
							->from('AccountDetail a')
							->where('a.created >= ?', '$fromDate')
							->andWhere('a.email not like ?', '%@mailinator%')
							->andWhere('a.email not like ?', '%proxymail.facebook.com%')";
			}
		}
		else
		{
			$query = "Zenfox_Query::create()
    					->from('AccountDetail a')
    					->andWhere('a.email not like ?', '%@mailinator%')
    					->andWhere('a.email not like ?', '%proxymail.facebook.com%')";
		}
		
		if($frontendids)
		{
			$query .= "->andWhereIn('a.frontend_id', array($frontendids))";
		}
		if($trackerId)
		{
			if($trackerId == -1)
			{
				$trackerId = 0;
			}
			$query .= "->andWhere('a.tracker_id = ?', $trackerId)";
		}
    	$playerData = array();
		if(!$offset && !$itemsPerPage)
		{
			$query = $query . ";";
			$str = "";
			$connections = Zenfox_Partition::getInstance()->getConnections(-1);
			foreach($connections as $conn)
			{
				$index = count($playerData);
				Doctrine_Manager::getInstance()->setCurrentConnection($conn);
				eval ( "\$str=" . $query );
				try
				{
					$registrations = $str->fetchArray();
				}
				catch(Exception $e)
				{
					Zenfox_Debug::dump($e, 'exception', true, true);
				}
				if($registrations)
				{
					$playerData = $this->_generatePlayerDataArray($playerData, $index, $registrations, true);
				}
			}
			return $playerData;
		}
		else
		{
			$adapter = new Zenfox_Paginator_Adapter_DoctrineQuery($query, -1, $session);
	    	$paginatorSession = new Zend_Session_Namespace('paginationCount');
			$paginatorSession->value = false;
	    	$paginator =  new Zend_Paginator($adapter);
			$paginator->setItemCountPerPage($itemsPerPage);
			$paginator->setPageRange(2);
			$paginator->setCurrentPageNumber($offset);
			if(!$paginator->getTotalItemCount())
			{
				return false;
			}
			$index = count($playerData);
			/*foreach($paginator as $logs)
			{
				if(strpos($logs['email'], 'proxymail.facebook.com'))
				{
					continue;
				}
				$playerJoinDate = $logs['created'];
				$joinDate = date ("Y-m-d H:i:s", strtotime("$playerJoinDate, + 4 HOUR 30 MINUTE"));
				
				$lastLogin = $logs['last_login'];
				$playerLastLogin = date ("Y-m-d H:i:s", strtotime("$lastLogin, + 4 HOUR 30 MINUTE"));
				
				$playerData[$index]['Player Id'] = $logs['player_id'];
				$playerData[$index]['User Name'] = $logs['login'];
				$playerData[$index]['Player Name'] = $this->getUserName($logs['player_id']);
				//$playerData[$index]['Email'] = $logs['email'];
				$playerData[$index]['Join Date'] = $joinDate;
				$playerData[$index]['Last Login'] = $playerLastLogin;
				$playerData[$index]['Last Wagered'] = $logs['last_wagered'];
				$playerData[$index]['Last Deposit'] = $logs['last_deposit'];
				$playerData[$index]['Last Withdrawal'] = $logs['last_withdrawal'];
				$playerData[$index]['Total Deposits'] = $logs['total_deposits'];
				$index++;
			}*/
	
			$playerData = $this->_generatePlayerDataArray($playerData, $index, $paginator);
			$paginatorSession->unsetAll();
			return array($paginator, $playerData);
		}
    }
    
    private function _generatePlayerDataArray($playerData, $index, $registrations, $download = false, $accountUnconfirmed = false)
    {
	//$accountVariable = new AccountVariable();
    	//$varName = 'freeMoney';

    	$affiliateTracker = new AffiliateTracker();
    	foreach($registrations as $registrationData)
		{
			if(strpos($registrationData['email'], 'proxymail.facebook.com'))
			{
				continue;
			}
			$joinDate = $registrationData['created'];
			//$joinDate = date ("Y-m-d H:i:s", strtotime("$playerJoinDate, + 4 HOUR 30 MINUTE"));
		
			if(isset($registrationData['last_login']))
			{	
				$playerLastLogin = $registrationData['last_login'];
				//$playerLastLogin = date ("Y-m-d H:i:s", strtotime("$lastLogin, + 4 HOUR 30 MINUTE"));
			}

			$trackerName = 'Default Tracker';
			if($registrationData['tracker_id'])
			{
				$trackerName = $affiliateTracker->getTrackerNameFromId($registrationData['tracker_id']);
			}
			
			$playerData[$index]['Player Id'] = $registrationData['player_id'];
			$playerData[$index]['Login Name'] = $registrationData['login'];
			if(!$accountUnconfirmed)
			{
				//$variableData = $accountVariable->getData($registrationData['player_id'], $varName);
				//$freeMoney = $variableData['varValue'];
				$playerData[$index]['Player Name'] = $this->getUserName($registrationData['player_id']);
				$playerData[$index]['Email'] = $registrationData['email'];
				$playerData[$index]['Last Login'] = $playerLastLogin;
				$playerData[$index]['Last Wagered'] = $registrationData['last_wagered'];
				$playerData[$index]['Last Deposit'] = $registrationData['last_deposit'];
				$playerData[$index]['Last Withdrawal'] = $registrationData['last_withdrawal'];
				$playerData[$index]['Total Deposits'] = $registrationData['total_deposits'];
				$playerData[$index]['Balance'] = $registrationData['balance'];
				//$playerData[$index]['Taash Coins'] = round($freeMoney,2);
			}
			else
			{
				/*$firstName = $registrationData['first_name'] ? $registrationData['first_name'] : $registrationData['login'];
				$playerData[$index]['Player Name'] = $firstName;*/
				
				$unconfirmobj = new AccountUnconfirm();
				$accountdetails = $unconfirmobj->getAccountDetail($playerData[$index]['Player Id']);
				
				$frontendobj = new Frontend();
				$frontend = $frontendobj->getFrontendById($accountdetails[0]['frontend_id']);
				
				$playerData[$index]['Code'] = $frontend[0]["url"]."/auth/confirm/code/" . $registrationData['code'];
				
				$form = '<form action="/report/registration/code/' . $registrationData['code'] . '" method = "POST"><input type="submit" name="Resend" value="Resend"></form>';
				$playerData[$index]['Resend'] = $form;
			}
			$playerData[$index]['Tracker'] = $trackerName;
			$playerData[$index]['Join Date'] = $joinDate;
			if($download)
			{
				$playerData[$index]['Email'] = $registrationData['email'];
			}
			$index++;
		}
		return $playerData;
    }
    
	public function getAllDepositors($offset = NULL, $itemsPerPage = NULL, $session, $fromDate = NULL, $toDate = NULL, $frontendIds = NULL)
    {
    	if($fromDate)
    	{
    		if($toDate)
    		{
    			$query = "Zenfox_Query::create()
						->from('AuditReport r')
						->where('r.trans_start_time BETWEEN ? AND ?', array('$fromDate', '$toDate'))
						
						->andWhere('r.transaction_type = ?', 'CREDIT_DEPOSITS')";
    		}
    		else
    		{
    			$query = "Zenfox_Query::create()
						->from('AuditReport r')
						->where('r.trans_start_time >= ?', '$fromDate'))
						->andWhere('r.transaction_type = ?', 'CREDIT_DEPOSITS')";
    		}
    	}
    	else
    	{
    		$query = "Zenfox_Query::create()
					->from('AuditReport r')
					->where('r.transaction_type = ?', 'CREDIT_DEPOSITS')";
    	}
    	if($frontendIds)
    	{
    		$query .= "->andWhereIn('r.frontend_id', array($frontendIds))";
    	}
    	$auditData = array();
		if(!$offset && !$itemsPerPage)
		{$trackerId = implode(",", $trackerId);
			$query = $query . "->andWhereIn('a.tracker_id', array($trackerId))";
			$query = $query . ";";
			$str = "";
			$connections = Zenfox_Partition::getInstance()->getConnections(-1);
			foreach($connections as $conn)
			{
				$index = count($auditData);
				Doctrine_Manager::getInstance()->setCurrentConnection($conn);
				eval ( "\$str=" . $query );
				try
				{
					$depositors = $str->fetchArray();
				}
				catch(Exception $e)
				{
					Zenfox_Debug::dump($e, 'exception', true, true);
				}
				if($depositors)
				{
					$auditData = $this->_generateDepositorDataArray($auditData, $index, $depositors);
				}
			}
			return $auditData;
		}
		else
		{
			$adapter = new Zenfox_Paginator_Adapter_DoctrineQuery($query, -1, $session);
	    	$paginatorSession = new Zend_Session_Namespace('paginationCount');
			$paginatorSession->value = false;
	    	$paginator =  new Zend_Paginator($adapter);
			$paginator->setItemCountPerPage($itemsPerPage);
			$paginator->setPageRange(2);
			$paginator->setCurrentPageNumber($offset);
			$auditData = array();
			if(!$paginator->getTotalItemCount())
			{
				return false;
			}
			$index = count($auditData);
	
			$auditData = $this->_generateDepositorDataArray($auditData, $index, $paginator);
			$paginatorSession->unsetAll();
			return array($paginator, $auditData);
		}
    }
    
    private function _generateDepositorDataArray($auditData, $index, $depositors)
    {
    	foreach($depositors as $depositorData)
		{
			$playerTransRecord = new PlayerTransactionRecord();
			$playerTransData = $playerTransRecord->getTransactionData($depositorData['player_id'], $depositorData['merchant_trans_id']);
			$transactionType = $playerTransData['transactionType'];
			//$playerData = $this->getPlayerData($depositorData['player_id']);
			$playerData = $this->getAccountDetails($depositorData['player_id']);
			if(strpos($playerData['email'], 'proxymail.facebook.com'))
			{
				continue;
			}
			/*$playerJoinDate = $depositorData['created'];
			$joinDate = date ("Y-m-d H:i:s", strtotime("$playerJoinDate, + 4 HOUR 30 MINUTE"));*/

			//$lastLogin = $playerData['last_login'];
			$playerLastLogin = $playerData[0]['last_login'];
			//$playerLastLogin = date ("Y-m-d H:i:s", strtotime("$lastLogin, + 4 HOUR 30 MINUTE"));
		
			//$auditData[$index]['Audit Id'] = $depositorData['audit_id'];
			$auditData[$index]['Player Id'] = $depositorData['player_id'];
			$auditData[$index]['Login Name'] = $playerData[0]['login'];
			$auditData[$index]['Player Name'] = $this->getUserName($depositorData['player_id']);
			$auditData[$index]['Last Login'] = $playerLastLogin;
			$auditData[$index]['Amount'] = $depositorData['amount'];
			//$auditData[$index]['Email'] = $playerData['email'];
			$auditData[$index]['Balance'] = $depositorData['bb_balance'] + $depositorData['cash_balance'];
			$auditData[$index]['Status'] = $depositorData['processed'];
			$auditData[$index]['Transaction Type'] = $transactionType;
			$auditData[$index]['Date/Time'] = $depositorData['trans_start_time'];
			$index++;
		}
		return $auditData;
    }

    
    public function getAllAccounts()
    {
    	$conn = Zenfox_Partition::getInstance()->getMasterConnection();
    	Doctrine_Manager::getInstance()->setCurrentConnection($conn);
    	
    	$query = Zenfox_Query::create()
    					->from('Account');
    					
    	$result = $query->fetchArray();
    	$index = 0;
    	$playerData = array();
    	foreach($result as $accountDetails)
    	{
    		if(strpos($accountDetails['email'],'@') && !strpos($accountDetails['email'], 'mailinator.com') && !strpos($accountDetails['email'], 'proxymail.facebook.com'))
    		{
    			$playerData[$index]['playerId'] = $accountDetails['player_id'];
    			$playerData[$index]['login'] = $accountDetails['login'];
    			$playerData[$index]['email'] = $accountDetails['email'];
    		}
    		$index++;
    	}
    	
    	return $playerData;
    }

    public function getLoginName($playerId)
    {
    	$conn = Zenfox_Partition::getInstance()->getConnections($playerId);
    	Doctrine_Manager::getInstance()->setCurrentConnection($conn);
    	
    	$query = Zenfox_Query::create()
    				->select('a.login')
    				->from('Account a')
    				->where('a.player_id = ?', $playerId);
    	$result = $query->fetchArray();
    	return $result[0]['login'];
    }

    public function updateSchemeId($playerId, $schemeId)
    {
    	$conn = Zenfox_Partition::getInstance()->getConnections($playerId);
    	Doctrine_Manager::getInstance()->setCurrentConnection($conn);
    	
    	$query = Zenfox_Query::create()
    				->update('AccountDetail a')
    				->set('a.bonus_scheme_id', '?', $schemeId)
    				->where('a.player_id = ?', $playerId);
    	
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

    public function getTrackerRegistration($trackerId, $fromDate = NULL, $toDate = NULL, $offset = NULL, $itemsPerPage = NULL, $session = NULL)
    {
    	if($fromDate)
		{
			if($toDate)
			{
				$query = "Zenfox_Query::create()
								->from('AccountDetail a')
								->where('a.created between ? and ?', array('$fromDate', '$toDate'))";
			}
			else
			{
				$query = "Zenfox_Query::create()
							->from('AccountDetail a')
							->where('a.created >= ?', '$fromDate')";
			}
		}
		else
		{
			$query = "Zenfox_Query::create()
    					->from('AccountDetail a')";
		}
		if(is_array($trackerId))
		{
			$trackerId = implode(",", $trackerId);
			$query = $query . "->andWhereIn('a.tracker_id', array($trackerId))";
		}
		else
		{
			$query = $query . "->andWhere('a.tracker_id = ?', '$trackerId')";
		}
		$playerData = array();
		
		if(!$offset && !$itemsPerPage)
		{
			$query = $query . ";";
			$str = "";
			$connections = Zenfox_Partition::getInstance()->getConnections(-1);
			foreach($connections as $conn)
			{
				$index = count($playerData);
				Doctrine_Manager::getInstance()->setCurrentConnection($conn);
				eval ( "\$str=" . $query );
				try
				{
					$registrations = $str->fetchArray();
				}
				catch(Exception $e)
				{
					//Zenfox_Debug::dump($e, 'exception', true, true);
				}
				if($registrations)
				{
					$playerData = $this->_generateTrackerPlayerDataArray($trackerId, $playerData, $index, $registrations, true);
				}
			}
			return $playerData;
		}
		else
		{
			$adapter = new Zenfox_Paginator_Adapter_DoctrineQuery($query, -1, $session);
			$paginatorSession = new Zend_Session_Namespace('paginationCount');
			$paginatorSession->value = false;
			$paginator =  new Zend_Paginator($adapter);
			$paginator->setItemCountPerPage($itemsPerPage);
			$paginator->setPageRange(2);
			$paginator->setCurrentPageNumber($offset);
			if(!$paginator->getTotalItemCount())
			{
				return false;
			}
			$index = count($playerData);
			
			$playerData = $this->_generateTrackerPlayerDataArray($trackerId, $playerData, $index, $paginator);
			$paginatorSession->unsetAll();
			return array($paginator, $playerData);
		}
    }
    
    private function _generateTrackerPlayerDataArray($trackerId, $playerData, $index, $registrations, $download = false)
    {
    	$accountVariable = new AccountVariable();
    	foreach($registrations as $registrationData)
    	{
    		$accountVariableData = $accountVariable->getData($registrationData['player_id'], 'CV_AFF-ID');
    		$playerJoinDate = $registrationData['created'];
    		$joinDate = date ("Y-m-d H:i:s", strtotime("$playerJoinDate, + 4 HOUR 30 MINUTE"));
    			
    		$lastLogin = $registrationData['last_login'];
    		$playerLastLogin = date ("Y-m-d H:i:s", strtotime("$lastLogin, + 4 HOUR 30 MINUTE"));
    			
    		$playerData[$index]['Player-Id'] = $registrationData['player_id'];
    		$playerData[$index]['Tracker-Id'] = $registrationData['tracker_id'];
    		$playerData[$index]['Aff-Id'] = $accountVariableData['varValue'];
    		// $playerData[$index]['Login Name'] = $registrationData['login'];
    		$playerData[$index]['Player Name'] = $this->getUserName($registrationData['player_id']);
    		$playerData[$index]['Email'] = $registrationData['email']; 
    		$playerData[$index]['Registered Date']= $this->getunconfirmedcreatetime($registrationData['player_id']);
    		$playerData[$index]['Join Date'] = $joinDate;
     		$playerData[$index]['Last Login'] = $playerLastLogin;
    		$playerData[$index]['Last Wagered'] = $registrationData['last_wagered'];
    		$playerData[$index]['Last Deposit'] = $registrationData['last_deposit'];
    		$playerData[$index]['Last Withdrawal'] = $registrationData['last_withdrawal'];
    		$playerData[$index]['Total Deposits'] = $registrationData['total_deposits'];
     		$playerData[$index]['Balance'] = $registrationData['balance'];
    		/* if($download)
    		{
    			$playerData[$index]['Email'] = $registrationData['email'];
    		} */
    		$index++;
    	}
    	return $playerData;
    }

    public function updateFrontendId($playerId, $frontendId)
    {
    	$connection = Zenfox_Partition::getInstance()->getConnections($playerId);
    	Doctrine_Manager::getInstance()->setCurrentConnection($connection);
    	
    	$query = Zenfox_Query::create()
    				->update('AccountDetail a')
    				->set('a.frontend_id', '?', $frontendId)
    				->where('a.player_id = ?', $playerId);
    	$query->execute();
    }

    public function getPlayerName($playerId)
    {
    	$conn = Zenfox_Partition::getInstance()->getConnections($playerId);
    	Doctrine_Manager::getInstance()->setCurrentConnection($conn);
    	
    	$query = Zenfox_Query::create()
    				->select('a.login')
    				->from('AccountDetail a')
    				->where('a.player_id = ?', $playerId);
    	
    	$result = $query->fetchArray();
    	$name = $result[0]['login'];
    	
    	return $name;
    }
    
    public function changeStatus($playerId, $status)
    {
    	$conn = Zenfox_Partition::getInstance()->getConnections($playerId);
    	Doctrine_Manager::getInstance()->setCurrentConnection($conn);
    	
    	$query = Zenfox_Query::create()
    				->update('AccountDetail a')
    				->set('a.status', '?', $status)
    				->where('a.player_id = ?', $playerId);
    	
    	try
    	{
    		$query->execute();
    	}
    	catch(Exception $e)
    	{
    		return "Some problem has been accoured";
    	}
    }
    
    public function getNoOfBuddies($playerId)
    {
    	$connections = Zenfox_Partition::getInstance()->getConnections(-1);
    	$noOfBuddies = 0;
    	foreach($connections as $connection)
    	{
    		Doctrine_Manager::getInstance()->setCurrentConnection($connection);
    		$query = Zenfox_Query::create()
    					->select('count(*)')
    					->from('AccountDetail a')
    					->where('a.buddy_id = ?', $playerId);
    		
    		try
    		{
    			$result = $query->fetchArray();
    		}
    		catch(Exception $e)
    		{
    			
    		}
    		if($result)
    		{
    			$noOfBuddies += $result[0]['count'];
    		}
    	}
    	return $noOfBuddies;
    }
    
    public function getPlayersByFirstName($firstName, $accountType, $offset, $itemsPerPage, $csrfrontendids)
    {
    	$frontendids = implode(",", $csrfrontendids);
    	
    	if($accountType == "unconfirmed")
    	{
    		$query = "Zenfox_Query::create()
    					->from('AccountUnconfirm a')
    					->WhereIn('a.frontend_id', array($frontendids))";
    	}
    	else
    	{
    		if(!$firstName)
    		{
    			$query = "Zenfox_Query::create()
    	    		->from('Account a')";
    		}
    		else 
    		{
    			$query = "Zenfox_Query::create()
    	    		->from('Account a')
    	    		->andwhere('a.first_name LIKE ?', '$firstName%')";
    		}
    		
    	}
    	
    	$adapter = new Zenfox_Paginator_Adapter_DoctrineQuery($query, 0);
    	$paginatorSession = new Zend_Session_Namespace('paginationCount');
    	$paginatorSession->value = false;
    	$paginator =  new Zend_Paginator($adapter);
    	$paginator->setItemCountPerPage($itemsPerPage);
    	$paginator->setPageRange(2);
    	$paginator->setCurrentPageNumber($offset);
    	
    	if(!$paginator->getTotalItemCount())
    	{
    		return false;
    	}
    	$playerData = array();
		$index = 0;
		foreach($paginator as $logs)
		{
			$playerfrontendid = $this->getfrontendidofplayer($logs['player_id'],$accountType);
					
			if (in_array($playerfrontendid,$csrfrontendids))
 			{
				$playerData[$index]['Player Id'] = $logs['player_id'];
				$playerData[$index]['Login Name'] = $logs['login'];
				$playerData[$index]['User Name'] = $logs['first_name'];
				$playerData[$index]['Email'] = $logs['email']; 	
 			}
				
			$index++;
		}
		$paginatorSession->unsetAll();
		return array($paginator, $playerData);
    }
    
    public function getfrontendidofplayer($playerId,$accountType = "confirmed")
    {
    	if($accountType == "unconfirmed")
    	{
    		$conn = Zenfox_Partition::getInstance()->getMasterConnection();
    		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
    	
    		$query = Zenfox_Query::create()
    				->select('a.frontend_id')
    				->from('AccountUnconfirm a')
    				->where('a.player_id = ?', $playerId);
    	}
    	else
    	{
    		$conn = Zenfox_Partition::getInstance()->getConnections($playerId);
    		Doctrine_Manager::getInstance()->setCurrentConnection($conn);
    	
    		$query = Zenfox_Query::create()
    				->select('a.frontend_id')
    				->from('AccountDetail a')
    				->where('a.player_id = ?', $playerId);
    	}
    	
    	
    	$result = $query->fetchArray();
    	$frontendid = $result[0]['frontend_id'];
    	
    	return $frontendid;
    }
    
    public function getPlayerIdByRawQuery($loginName)
    {
    	$frontendId = Zend_Registry::get('frontendId');
    	$connections = Zenfox_Partition::getInstance()->getConnections(-1);
    	
    	foreach($connections as $connection)
    	{
    		Doctrine_Manager::getInstance()->setCurrentConnection($connection);
    		 
    		$rawQuery = "select player_id from account_details where login = '" . $loginName . "' and frontend_id = " . $frontendId;
    		 
    		try
    		{
    			$currentConnection = Doctrine_Manager::getInstance()->getCurrentConnection();
    			$executeQuery = $currentConnection->execute($rawQuery);
    			$executeQuery->setFetchMode(Doctrine::HYDRATE_RECORD);
    			$accountData = $executeQuery->fetchAll();
    		}
    		catch(Exception $e)
    		{
    			//Zenfox_Debug::dump($e, 'exception', true, true);
    			return false;
    		}
    		if($accountData)
    		{
    			return $accountData[0]['player_id'];
    		}
    	}
    	/* $connection = Zenfox_Partition::getInstance()->getMasterConnection();
    	Doctrine_Manager::getInstance()->setCurrentConnection($connection);
    	
    	$rawQuery = "select player_id from account where login = '" . $loginName . "'";
    	
    	try
    	{
    		$currentConnection = Doctrine_Manager::getInstance()->getCurrentConnection();
    		$executeQuery = $currentConnection->execute($rawQuery);
    		$executeQuery->setFetchMode(Doctrine::HYDRATE_RECORD);
    		$accountData = $executeQuery->fetchAll();
    	}
    	catch(Exception $e)
    	{
    		//Zenfox_Debug::dump($e, 'exception', true, true);
    		return false;
    	}
    	return $accountData[0]['player_id']; */
    }
    
	 public function unsubscribeemail($playerId)
    {
    	$conn = Zenfox_Partition::getInstance()->getMasterConnection();
    	Doctrine_Manager::getInstance()->setCurrentConnection($conn);
    	
    	$query = Zenfox_Query::create()
    					->update('Account a')
    					->set('a.promotions', '?' ,0)
    					->where('a.player_id = ?',$playerId);
    					
    			    					
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
    
    public function getunconfirmedcreatetime($playerId)
    {
    	$conn = Zenfox_Partition::getInstance()->getMasterConnection();
    	Doctrine_Manager::getInstance()->setCurrentConnection($conn);
    	
    	
    	$query = Zenfox_Query::create()
    				->select('a.created')
    				->from('AccountUnconfirm a')
    				->where('a.player_id = ?', $playerId);
    		
    				$result = $query->fetchArray();
    	$registedtime = $result[0]['created'];
    	
    	return $registedtime;		
    				
    }
    
    public function getRecentJoiners($offset, $itemsPerPage, $session)
    {
    	$query = "Zenfox_Query::create()
    				->from('AccountDetail a')
    				->leftJoin('a.AccountVariable av')
    				->where('av.variable_name = ?', 'profile_image')
    				->andWhere('a.email not like ?', '%@mailinator%')
    				->andWhere('a.email not like ?', '%proxymail.facebook.com%')
    				->orderBy('a.player_id desc')";
    	
    	$adapter = new Zenfox_Paginator_Adapter_DoctrineQuery($query, -1, $session);
    	$paginatorSession = new Zend_Session_Namespace('paginationCount');
    	$paginatorSession->value = false;
    	$paginator =  new Zend_Paginator($adapter);
    	$paginator->setItemCountPerPage($itemsPerPage);
    	$paginator->setPageRange(5);
    	$paginator->setCurrentPageNumber($offset);
    	if(!$paginator->getTotalItemCount())
    	{
    		return false;
    	}
    	
    	$accountData = array();
    	$index = 0;
    	
    	foreach($paginator as $paginatorData)
    	{
    		$accountData[$index]['id'] = $paginatorData['player_id'];
    		$accountData[$index]['Name'] = $paginatorData['login'];
    		$index++;
    	}
    	
    	$paginatorSession->unsetAll();
    	return array($paginator, $accountData);
    }
    
    public function getLoyaltyPoints($playerId)
    {
    	$conn = Zenfox_Partition::getInstance()->getConnections($playerId);
    	Doctrine_Manager::getInstance()->setCurrentConnection($conn);
    	
    	$query = Zenfox_Query::create()
    				->select('a.total_loyalty_points, a.loyalty_points_left')
    				->from('AccountDetail a')
    				->where('a.player_id = ?', $playerId);
    	
    	try
    	{
    		$result = $query->fetchArray();
    	}
    	catch(Exception $e)
    	{
    		return NULL;
    		//Zenfox_Debug::dump($e, 'exception', true, true);
    	}
    	if($result)
    	{
    		return array(
    			'totalLoyaltyPoints' => $result[0]['total_loyalty_points'],
    			'loyaltyPointsLeft' => $result[0]['loyalty_points_left']
    		);
    	}
    	return NULL;
    }
    
    public function updateLoyaltyPoints($playerId, $totalLoyaltyPoints, $loyaltyPointsLeft)
    {
    	$conn = Zenfox_Partition::getInstance()->getConnections($playerId);
    	Doctrine_Manager::getInstance()->setCurrentConnection($conn);
    	
    	$query = Zenfox_Query::create()
    				->update('AccountDetail a')
    				->set('a.total_loyalty_points', '?', $totalLoyaltyPoints)
    				->set('a.loyalty_points_left', '?', $loyaltyPointsLeft)
    				->where('a.player_id = ?', $playerId);
    	
    	try
    	{
    		$query->execute();
    	}
    	catch(Exception $e)
    	{
    		//Zenfox_Debug::dump($e, 'exception', true, true);
    	}
    }
    
    public function getUnconfirmLoginName($playerId)
    {
    	$conn = Zenfox_Partition::getInstance()->getMasterConnection();
    	Doctrine_Manager::getInstance()->setCurrentConnection($conn);
    	
    	$query = Zenfox_Query::create()
    				->from('AccountUnconfirm au')
    				->where('au.player_id = ?', $playerId);
    	
    	try
    	{
    		$result = $query->fetchArray();
    	}
    	catch(Exception $e)
    	{
    		
    	}
    	$loginName = "";
    	if($result)
    	{
    		$loginName = $result[0]['login'];
    	}
    	return $loginName;
    }
    
	public function getdepositedplayerIds($starttime)
    {
    	
    	$partition = 0;
    	$connections = Zenfox_Partition::getInstance()->getConnections(-1);
    	foreach($connections as $connection)
    	{
    		Doctrine_Manager::getInstance()->setCurrentConnection($connection);
    		$query = Zenfox_Query::create()
    					->select('distinct(a.player_id) as PLAYERID')
    					->from('AccountDetail a')
    					->andWhere('a.last_deposit >= ?', $starttime);
    		
    		try
    		{
    			$partition++;
    			$result[$partition] = $query->fetchArray();
    			
    		}
    		catch(Exception $e)
    		{
    			echo $e;
    		}
    		
    		$count = count($result[$partition]);
    		$index = 0;
    		
    		while($index < $count)
    		{
    			//Zenfox_Debug::dump($result[$partition]);
    			$playerIds[] = $result[$partition][$index]["PLAYERID"];
    			$index++;
    		}
    		
    		
    		//Zenfox_Debug::dump($playerIds);//exit;
    		
    	}
    	//return array_merge($result[0],$result[1]);
    	return $playerIds;
    }
    
    public function getPlayersByBirthday($birthday)
    {
    	$conn = Zenfox_Partition::getInstance()->getMasterConnection();
    	Doctrine_Manager::getInstance()->setCurrentConnection($conn);
    	
    	$query = Zenfox_Query::create()
    				->from('Account a')
    				->where('a.dateofbirth like ?', $birthday);
    	
    	try
    	{
    		$result = $query->fetchArray();
    	}
    	catch(Exception $e)
    	{
    		//Zenfox_Debug::dump($e, 'exception', true, true);
    		return false;
    	}
    	if($result)
    	{
    		$finalData = array();
    		$index = 0;
    		foreach($result as $playerData)
    		{
    			$finalData[$index]['Player Id'] = $playerData['player_id'];
    			$finalData[$index]['Login Name'] = $playerData['login'];
			$finalData[$index]['Email'] = $playerData['email'];
    			$finalData[$index]['Date Of Birth'] = $playerData['dateofbirth'];
    			$index++;
    		}
    		return $finalData;
    	}
    	return NULL;
    }
    
    public function updateAccountDetails($data, $playerId)
    {
    	$conn = Zenfox_Partition::getInstance()->getConnections($playerId);
    	Doctrine_Manager::getInstance()->setCurrentConnection($conn);
    	
    	$query = Zenfox_Query::create()
    				->update('AccountDetail a');
    	foreach($data as $field => $fieldVal)
    	{
    		if($field == 'temp')
    		{
    			continue;
    		}
    		$query = $query->set('a.' . $field, '?', $fieldVal);
    	}
    	$query = $query->where('a.player_id = ? ', $playerId);
    	
    	try
    	{
    		$query->execute();
    	}
    	catch(Exception $e)
    	{
		return false;
    		//Zenfox_Debug::dump($e, 'e', true, true);
    	}
	return true;
    }
}
