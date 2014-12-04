<?php

class Zenfox_Controller_Plugin_Acl extends Zend_Controller_Plugin_Abstract
{
	private $_acl = null;
	private $_id;
	private $_roleName;
	private $_csrId;
	//const EXCEPTION_NO_ACCESS = 'EXCEPTION_NO_ACCESS';
	public function __construct($roleName)
	{
		//$this->_acl = $acl;
		$this->_acl = null;
		//$this->_id = $id;
		//$this->_roleName = $roleName;
		//Zenfox_Debug::dump($roleName, "Init ACL Role Name::");
		/*$role = explode('-', $this->_id);
        $this->_roleName = $role[0];
        $this->_csrId = $csrId;*/
	}
	//Calling from facebook plugin
	public function setRoleName($roleName)
	{
		//print "Setting Role Name:: $roleName - " . date("H:i:s");
		$this->_roleName = $roleName;
	}
	
	public function setId($userId)
	{
		$this->_id = $userId;
	}
	
	public function preDispatch(Zend_Controller_Request_Abstract $request) 
	{
		$controller = $request->getControllerName();
		$action = $request->getActionName();
		$requestUrl = $_SERVER['REQUEST_URI'];
		if(($controller != 'error' && $action != 'error') && ($controller != 'favicon.ico') && (!strpos($requestUrl, 'json')) && ($controller != 'cache.appcache'))
		{
			//$requestUrl = $_SERVER['REQUEST_URI'];
			setcookie('redirectUrl',$requestUrl,time() + (86400 * 30),'/','.'.$_SERVER['HTTP_HOST']);
			//setcookie('login-action',$action,time() + (86400 * 30),'/','.'.$_SERVER['HTTP_HOST']);
		}
		
		/*-------------------- ip verification-----------------*/
		$module = $request->getModuleName();
		if($module == 'admin')
		{
			$clientIpAddress = Zend_Controller_Front::getInstance()->getRequest()->getClientIp();
			if(false)//$clientIpAddress != '127.0.0.1')
			{
				echo 'Not a valid User';
				exit();
			}
			
		}
		/*-------------------- ip verification-----------------*/
		try
		{
			//print('In Acl Predispatch' . $request->getControllerName());
			$identity = Zend_Auth::getInstance()->hasIdentity();
	        //if(($identity) && ($this->_roleName == 'player'))
	        //Zenfox_Debug::dump($identity, "Zenfox Auth Session:: ",true,false);
	        if($identity)
	        {
	        	$session = new Zenfox_Auth_Storage_Session();
		 		$store = $session->read();
		 		
		 		$this->_id = isset($store['id'])?$store['id']:null;

		 		/*
		 		 * FIXME:: Set module specific roleNames
		 		 */
		 		$roleName = isset($store['roleName'])?$store['roleName']:'visitor';
	            
	            $this->setRoleName($roleName);
	            
	         	
		        if($roleName == 'visitor')
		        {
		        	//$this->setRoleName('partner');
		        }
		        elseif($roleName == 'player')
		        {
		        	$this->_handlePlayerSession();
		        }
		        elseif($roleName == 'affiliate')
		        {
		        	/*
		        	 * Handle affiliate session
		        	 */
		        	$this->_handleAffiliateSession();
		        }
		        elseif($roleName == 'admin')
		        {
		        	/*
		        	 * Handle admin session
		        	 */
		        	$this->_handleAdminSession();
		        }
	        	
		        elseif($roleName == 'csr')
		        {
		        	/*
		        	 * Handle admin session
		        	 */
		        	//$this->_handleCsrSession($request);
		        	$roleName == 'csr';
		        	
		        	//
		        }
		        elseif($roleName == 'partner')
		        {
		        	
		        }
		        
	        }
	        else
	        {
	        	$roleName = 'visitor';
	        	/*if($module == 'admin')
	        	{
	        		$roleName = 'csr';
	        	}*/
	        	$this->setRoleName($roleName);
	        }
	        //Zenfox_Debug::dump($identity, "Identity");
	        $validate = $this->_accessValid($request , $roleName);
	        //Zenfox_Debug::dump($validate, 'valid', true, true);
			//$validate = true;
	        //Zenfox_Debug::dump($this->_requestToString($request), "Route:: " );
	        //Zenfox_Debug::dump($validate, "ACL Validation:: ", true, false);
	        if(($validate == true) && (!is_array($validate)))
	        {
	        	//Zenfox_Debug::Dump($request->getParams(), "Params:: ");
	        	return;
	        }
			elseif($validate == false)
			{	
	        	throw new Zenfox_Acl_Exception("Access Denied", 401);
	        	//throw new Zenfox_Acl_Exception("Access Denied", Zenfox_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACCESS);
	        	//$this->_redirectNoAuth($request);
			}
			elseif (is_array($validate))
			{
				//Zenfox_Debug::dump($validate, "Validate Data::", true, true);
				throw new Zend_Acl_Exception($validate[0], $validate[1]);
			}
			//Zenfox_Debug::dump($this->_requestToString($request), "Route:: ");
			//Zenfox_Debug::dump($validate, "Validate");	
			throw new Zenfox_Exception('Internal Server Error', 500);
			//throw new Zenfox_Exception('Internal Server Error', Zenfox_Controller_Plugin_ErrorHandler::EXCEPTION_INTERNAL_ERROR);
			//$this->_redirectNoAuth($request);
		}
		catch (Exception $e)
		{
			if($request->format == 'json')
			{
				echo "Exception"; exit();
			}
			else
			{
				/* $encodedId = $_COOKIE['logData'];
				if($encodedId)
				{
					$phpsessid = Zend_Session::getId();
					$decodedId = base64_decode($encodedId);
					$strpos = strpos($decodedId, $phpsessid);
					$playerId = substr($decodedId, 0, $strpos);
					
					$player = new PlayerSession();
					$player->deleteSession($playerId);
					setcookie('logData',$encodedId,time(),'/','.'.$_SERVER['HTTP_HOST']);
				} */
				// Repoint the request to the default error handler
				$request->setControllerName('error');
				$request->setActionName('error');
				
				// Set up the error handler
				$error = new Zend_Controller_Plugin_ErrorHandler();
				$error->type = Zend_Controller_Plugin_ErrorHandler::EXCEPTION_OTHER;
				//$error->type = get_class($e);
				$error->request = clone($request);
				$error->exception = $e;
				$request->setParam('error_handler', $error);
			}
		}
	}
	
	private function _handlePlayerSession()
	{
		$session = new Zend_Session_Namespace('playerSession');
		/*if($lastActivity > $expiryTime)
		{
			$this->_roleName = 'visitor';
			$player = new PlayerSession($this->_id);
			$player->deleteSession();
			
			Zenfox_Debug::dump("Deleted Session");
			//throw new Zenfox_Exception('Session Expired', 404);
		}*/
		if($session)
		{
			$expiryTime = $session->store[0]['session_expiry'];
        	$today = new Zend_Date();
			$date = explode('T',$today->get(Zend_Date::W3C));
			$lastActivity = $date[0] . " " . $date[1];
			
			//Zenfox_Debug::dump($session->store, "Namespace Player Session");
				
			
			$player = new PlayerSession($this->_id);
			if(!$player->updateSession())
			{
				$this->setRoleName('visitor');
				//$player = new PlayerSession($this->_id);
				$player->deleteSession();
				//Zenfox_Debug::dump("Deleted Player Session");
			}
		}
		
        //Zenfox_Debug::dump($session->store, "Player Session Store");
         //$role = explode('-', $this->_id);
         //$roleId = $this->_id;
         $connName = Zenfox_Partition::getInstance()->getConnections($this->_id);
        Doctrine_Manager::getInstance()->setCurrentConnection($connName);
         $sessionId = Zend_Session::getId();
         $playerSession = Doctrine::getTable('PlayerSessions')->findOneByPlayerId($this->_id);
         if($playerSession['phpsessid'] != $sessionId)
         {
         	//Zenfox_Debug::dump($playerSession, "Player Session");
         	//Zenfox_Debug::dump($player, "Player Object Session");
         	$this->setRoleName('visitor');
         	$sess = new Zend_Auth_Storage_Session();
			$sess->clear();
         }
	}
	
	private function _handleAffiliateSession()
	{
		//Zenfox_Debug::dump(null, "Handling Affiliate Session");
	}
	
	private function _handleAdminSession()
	{
		//Zenfox_Debug::dump(null, "Handling Admin Session");
	}
	
	private function _handleCsrSession($request)
	{
		//Zenfox_Debug::dump($request->getControllerName(), "Handling Admin Session");
		
	}
	
 	protected function _redirectNoAuth(Zend_Controller_Request_Abstract $request)
    {
        $redir = Zend_Controller_Action_HelperBroker::getStaticHelper(
            'Redirector');
 
        $redirParams = array('controller' => 'auth', 'action' => 'login');
        $redir->setGotoRoute($redirParams,'default' , true);
        $redir->redirectAndExit();
    }
	
	private function _requestToString(Zend_Controller_Request_Abstract $request)
	{
		$resourceA[0] = $request->getModuleName();
		$resourceA[1] = $request->getControllerName();
		$resourceA[2] = $request->getActionName();
		
		return implode('-', $resourceA);
	}
	
	public function _buildResourceFromRequest(Zend_Controller_Request_Abstract $request)
	{
		$resourceA[0] = $request->getModuleName();
		$resourceA[1] = $request->getControllerName();
		$resourceA[2] = $request->getActionName();

		$resourceName = implode('-', $resourceA);
		/*
		 * TODO::
		 * Check for resourceObj till we find one
		 * First with modele-controller-action
		 * then with module-controller
		 * then with module
		 */

		return $resourceName;
	}
	
	public function _accessValid(Zend_Controller_Request_Abstract $request , $roleName = NULL)
	{
		
		
	    //TODO:: Get the user's role from Zend_Auth or Zend_Session
 /*   	$roleName = (Zend_Auth::getInstance()->hasIdentity())
				? 'player'
          		: 'visitor';
        
         $session = new Zend_Auth_Storage_Session();
		 $store = $session->read();
         $role_name = $store['role'];
   //      print($role_name);
         
/*        $session = new Zend_Auth_Storage_Session();
        print_r ($session->read());*/
		//print($roleName);
        //Get role from roleName

		/*
		 * Build the ACL
		 */
		//
		$moduleName = $request->getModuleName();
		if($moduleName == 'admin')
		{
			$this->_acl = $this->createAdminAcl();
			
		}
		elseif($moduleName == 'partner')
		{
			//return true;
			$this->_acl = $this->createPartnerAcl();
		}
		else 
		{
			$this->_acl = $this->createPlayerAcl();
		}
		$resource = $this->_buildResourceFromRequest($request);

//		/Zenfox_Debug::dump($this->_roleName,'resource',true,true);
		//print('resource - ' . $resource->name);
        if(empty($resource))
        {
        	//FIXME:: Is this correct??
        	//We just care about resources where access is allowed
        	//return true;
        	//Zenfox_Debug::dump(null, "Emptry Resource!");
        	//return array("Page not found", Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ROUTE);
        	return array("Page not found", 404);
        }

        /*
        Zenfox_Debug::dump ($resource, "Resource :: " );
        Zenfox_Debug::dump ($this->_id, "Role ::" );
        Zenfox_Debug::dump($this->_acl->isAllowed($this->_id, $resource), "ACL outcome");
        
        */
        
      //  $role = Doctrine::getTable('Role')->findOneByName($this->_roleName);
      //  print($role['description']);
          		


        //This builds the resource from request.
        //XXX: Later we can extend this to add models as resources 		
//        print('role - ' . $acl->hasRole($this->roleName));
//        print('resource - ' . $acl->has($resource));
//        print('allowed - ' . $acl->isAllowed($this->_roleName, $resource));
//        exit();

        //Create Acl for the request resource. This is done through createResourceAcl
        //Resource here is a string, this has to be used queried from the DB to get the actual resource
     //   $acl = $aclFactory->createResourceAcl($resource, $role);
        //FIXME:: $role, $resource, are strings, but they have to be Zend_Acl_R* instances 
        if($roleName == 'csr')
        {
        	if(!$this->_acl->hasRole($this->_roleName))
	     	{
	     		//Zenfox_Debug::dump ($this->_roleName, "Role Not FOUND:: " );
	     		//return array("Access Denied", Zenfox_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACCESS);
	     		return array("Access Denied", 401);
	     	}
	     	if(!$this->_acl->has($resource))
	     	{
	     		//Zenfox_Debug::dump ($resource->name, "Resource Not FOUND:: " );
	     		//return array("Not found", Zenfox_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ROUTE);
	     		return array("Not found", 404);
	     	}
	     	if($this->_acl->hasRole($this->_roleName) && $this->_acl->has($resource)
	        	&& $this->_acl->isAllowed($this->_roleName, $resource))
	        {
	        	return true;
	        }
	        //return array("Access Denied", Zenfox_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACCESS);
	        return array("Access Denied", 401);
        	//OLD CODE
        	//Start Code
        	/*$identity = Zend_Auth::getInstance()->hasIdentity();
        	if(!$identity)
        	{
        		return true;
        	}
         	if(!$this->_acl->hasRole($this->_id))
	     	{
	     	//	Zenfox_Debug::dump ($this->_id, "Role Not FOUND:: " );
	     		//return array("Access Denied", Zenfox_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACCESS);
	     		return array("Access Denied", 401);
	     	}
	     	if(!$this->_acl->has($resource))
	     	{
	     		//Zenfox_Debug::dump ($resource, "Resource Not FOUND:: ", true, true );
	     		//return array("Not found", Zenfox_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ROUTE);
	     		return array("Not found", 404);
	     	}
	     	if($this->_acl->hasRole($this->_id) && $this->_acl->has($resource)
	        	&& $this->_acl->isAllowed($this->_id, $resource))
	        {
	      //  	echo 'success';
	        	return true;
	        }
	       // echo 'fail';
	        
	        
	        return array("Access Denied", 401);*/
	        //END CODE
        
        }
        
        else
        {
        	if(!$this->_acl->hasRole($this->_roleName))
	     	{
	     		//Zenfox_Debug::dump ($this->_roleName, "Role Not FOUND:: " );
	     		//return array("Access Denied", Zenfox_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACCESS);
	     		return array("Access Denied", 401);
	     	}
	     	if(!$this->_acl->has($resource))
	     	{
	     		//Zenfox_Debug::dump ($resource->name, "Resource Not FOUND:: " );
	     		//return array("Not found", Zenfox_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ROUTE);
	     		return array("Not found", 404);
	     	}
        	if($this->_acl->hasRole($this->_roleName) && $this->_acl->has($resource)
	     			&& $this->_acl->isAllowed($this->_roleName, $resource))
	     	{
	     		return true;
	     	}
	        //return array("Access Denied", Zenfox_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACCESS);
	        return array("Access Denied", 401);
        }
	}
	
	private function createPlayerAcl()
	{
		$aclFactory = new Zenfox_Acl_Factory();

		/*
		 * File Based ACL. If this fails then fall back to database ACL.
		 */

		$aclObjFile = APPLICATION_PATH . "/configs/acl.obj";
		if(file_exists($aclObjFile))
		{
			$aclFp = fopen($aclObjFile, "r");
			$acl = unserialize(fread($aclFp, filesize($aclObjFile)));
		}
		else
		{
			try{
			//$acl = $aclFactory->createResourceAcl($this->_id, $this->_roleName);
     		$acl = $aclFactory->createResourceAcl($this->_roleName);
			}
			catch(Exception $e)
			{
				//Zenfox_Debug::dump($e, "Exception", true, true);
			}
			
			/*
			 * Write the Database ACL to the file
			 */
	
			
	     	$fp = fopen("/tmp/acl.obj", "w");
	     	
	     	fprintf($fp, serialize($acl));
	     	fclose($fp);
	
			Zenfox_Debug::dump(null, "Written to Disk", true, true);
			
		}
     	

     	//Zend_Registry::getInstance()->set('zenfox-acl', $acl);
     	//Zend_Registry::getInstance()->set('zenfox-currentrole', $this->_roleName);
     	
     	return $acl;
	}
	
	
	
	private function createAdminAcl()
	{
		//NIKHIL CODE
		//START HERE
		$aclObjFile = APPLICATION_PATH . "/configs/adminAcl.obj";
		if(file_exists($aclObjFile))
		{
			$aclFp = fopen($aclObjFile, "r");
			$acl = unserialize(fread($aclFp, filesize($aclObjFile)));
		}
		else
		{
			$acl = new Zenfox_Acl();
			
			$conn = Zenfox_Partition::getInstance()->getMasterConnection();
			Doctrine_Manager::getInstance()->setCurrentConnection($conn);
			
			/**
			 * Add all resources to ACL
			 */
			$allResources = Doctrine::getTable('GmsMenu')->findAll(Doctrine::HYDRATE_RECORD);
			foreach ($allResources as $resource)
			{
				if(!$acl->has($resource))
				{
					$acl->add($resource);
				}
			}
			
			/**
			 * Add all roles to ACL
			 */
			$query = Zenfox_Query::create()
					->from('GmsGroup');
			
			$gmsGroups = $query->fetchArray();
			foreach($gmsGroups as $group)
			{
				$allGroups[] = $group['name'];
				$acl->addRole($group['name']);
			}
			//$words = array('red', 'blue', 'green', 'yellow');
			$num = count($allGroups);
			
			//The total number of possible combinations
			$total = pow(2, $num);
			$allCombo = array();
			$mainIndex = 0;
			//Loop through each possible combination
			for ($i = 0; $i < $total; $i++) {
				//$str = "";
				$index = 0;
				//For each combination check if each bit is set
				for ($j = 0; $j < $total; $j++) {
					//Is bit $j set in $i?
					if (pow(2, $j) & $i)
					{
						$allCombo[$mainIndex][$index] = $allGroups[$j];
						$index++;
						//$str .= $allGroups[$j] . '-';
					}
				}
				//echo $str;
				$mainIndex++;
				//echo '<br />';
			}
			
			/**
			 * Add all possible combination of roles to ACL
			 */
			foreach($allCombo as $combo)
			{
				$comboStr = implode("-", $combo);
				if($acl->hasRole($comboStr))
				{
					continue;
				}
				$acl->addRole($comboStr, $combo);
			}
			/* $acl->addRole('visitor');
			
			$acl->allow('visitor', 'admin-auth-login');
			$acl->allow('visitor', 'admin-index-index'); */
			
			/**
			 * Give permissions to Role
			 */
			
			$query = Zenfox_Query::create()
						->from('GmsGroupGmsMenu');
			 
			$result = $query->fetchArray();
			$gmsMenu = new GmsMenu();
			foreach($result as $gmsMenuLinkData)
			{
				$resourceAddress = $gmsMenu->getMenuById($gmsMenuLinkData['gms_menu_id']);
				if($gmsMenuLinkData['mode'] == 'allow')
				{
					$query = Zenfox_Query::create()
								->from('GmsGroup gg')
								->where('gg.id = ?', $gmsMenuLinkData['gms_group_id']);
					 
					$gmsGroupData = $query->fetchArray();
					if(!$acl->isAllowed($gmsGroupData[0]['name'], $resourceAddress))
					{
						$acl->allow($gmsGroupData[0]['name'], $resourceAddress);
					}
				}
			}
			/* $roles = Doctrine::getTable('CsrGmsGroup')->findAll();
			$csrsId = array();
	        foreach ($roles as $role)
	        {
	        	if(!in_array($role['csr_id'], $csrsId))
	        	{
	        		$csrsId[] = $role['csr_id'];
	        		$parents = $role->getParents();
	        		$csr = new Csr();
		        	$csrInfo = $csr->getInfo($role['csr_id']);
		        	$csrName = $csrInfo[0]['alias'];
		        	//Zenfox_Debug::dump($csrName, 'csr');
		        	//Zenfox_Debug::dump($parents, 'parent');
		        	foreach($parents as $parent)
					{
						if($acl->hasRole($parent))
						{
							continue;
						}
						$acl->addRole($parent);
					}
					$acl->addRole($csrName, $parents);
	        	}
	         }
		         $acl->allow('visitor', 'admin-auth-login');
	        	 $acl->allow('visitor', 'admin-index-index');
		         $query = Zenfox_Query::create()
	         			->from('GmsGroupGmsMenu');
	         			
		         $result = $query->fetchArray();
		         $gmsMenu = new GmsMenu();
	        	 foreach($result as $gmsMenuLinkData)
		         {
		         	$resourceAddress = $gmsMenu->getMenuById($gmsMenuLinkData['gms_menu_id']);
	        	 	if($gmsMenuLinkData['mode'] == 'allow')
	         		{
		         		$query = Zenfox_Query::create()
	         					->from('GmsGroup gg')
	         					->where('gg.id = ?', $gmsMenuLinkData['gms_group_id']);
	         					
		         		$gmsGroupData = $query->fetchArray();
	         		
	        	 		$acl->allow($gmsGroupData[0]['name'], $resourceAddress);
	         		}
		         } */
	         
		    $fp = fopen("/tmp/adminAcl.obj", "w");
			fprintf($fp, serialize($acl));
			fclose($fp);
			Zenfox_Debug::dump(null, "Written to Disk", true, true); 
		}
		
         
        /* 	*/
		/*
		$acl->addRole('visitor');
		$acl->add('admin-auth-login');
		$acl->allow('visitor', 'admin-auth-login');
		return $acl;*/
		//END HERE
		
		
		//OLD CODE
		//START CODE
	/*try{
		$acl = new Zend_Acl();
		$csrGmsGrp = new CsrGmsGroup();
		$gmsGrpGmsMenu = new GmsGroupGmsMenu();
		$gmsMenu =  new GmsMenu();
		}
		catch (Exception $e) {echo $e; exit();}*/
		//END CODE
		/*	
		
		$connName = Zenfox_Partition::getInstance()->getMasterConnection();
        Doctrine_Manager::getInstance()->setCurrentConnection($connName);
		//$con = Doctrine_Manager::getInstance()->getCurrentConnection()->getName();
		$queryAllCsr = Zenfox_Query::create()->from('Csr c');
		$csr = $queryAllCsr->fetchArray();
		
		$queryAllResources = Zenfox_Query::create()->from('GmsMenu gm');
		$resources = $queryAllResources->fetchArray();
		$index = 0;
		
		foreach($csr as $key=>$value)
		{
			$acl->addRole(new Zend_Acl_Role($csr[$key]['id']));
			
			if($index == 0)
			{
				foreach($resources as $key1=>$value1)
				{
					$acl->addResource(new Zend_Acl_Resource($resources[$key1]['address']));
					
					//echo 	$resources[$key1]['name'].'<br>';
					
						
				}
			}
			$index = 1;	
			
			$gmsGrpData = $csrGmsGrp->getGroups($csr[$key]['id']);
			if($gmsGrpData)
			{
				foreach($gmsGrpData as $key2=>$value2)
				{
						
					$gmsGrpGmsMenuData = $gmsGrpGmsMenu->getMenus($gmsGrpData[$key2]['id']);
				
						foreach($gmsGrpGmsMenuData as $key3=>$value3)
						{
							
							$gmsMenuData = $gmsMenu->getInfo($gmsGrpGmsMenuData[$key3]['id']);
						
							$acl->allow($csr[$key]['id'], $gmsMenuData[0]['address']);
							
							$chk = $acl->isAllowed($csr[$key]['id'],$gmsMenuData[0]['address'])?'allowed':'not allowed';
							
							echo 'Csr id '.$csr[$key]['id'].' '.$chk.' to resource id '.$gmsMenuData[0]['name'];
					
						}
				
													 	
				}
			}
		}*/
		
		/*$aclObjFile = APPLICATION_PATH . "/configs/adminAcl.obj";
		if(file_exists($aclObjFile))
		{
			$aclFp = fopen($aclObjFile, "r");
			$acl = unserialize(fread($aclFp, filesize($aclObjFile)));
		}
		else
		{
			//ADDED CODE
			//START CODE
			$aclFactory = new Zenfox_Acl_Factory();
			
			try{
			//$acl = $aclFactory->createResourceAcl($this->_id, $this->_roleName);
     		$acl = $aclFactory->createResourceAcl($this->_roleName);
			}
			catch(Exception $e)
			{
				//Zenfox_Debug::dump($e, "Exception", true, true);
			}
			//END CODE
			
	     	$fp = fopen("/tmp/acl3.obj", "w");
	     	
	     	fprintf($fp, serialize($acl));
	     	fclose($fp);
	     	Zenfox_Debug::dump(null, "Written to Disk", true, true);	
		}*/
	
	   // Zenfox_Debug::dump('stp' , 'csr', true, true);
		return $acl;
	
	}
	
	private function createPartnerAcl()
	{	
		$siteCode = Zend_Registry::getInstance()->get('siteCode');
		
		$aclObjFile = null;//APPLICATION_PATH . "/site_configs/" . $siteCode . "/partner_acl.obj";
		if(file_exists($aclObjFile))
		{
			$aclFp = fopen($aclObjFile, "r");
			$acl = unserialize(fread($aclFp, filesize($aclObjFile)));
		}
		else
		{
			try{
				//$acl = $aclFactory->createResourceAcl($this->_id, $this->_roleName);
				$aclFactory = new Zenfox_Acl_Factory();
				$acl = $aclFactory->createPartnerAcl();
			}
			catch(Exception $e)
			{
				Zenfox_Debug::dump($e, "Exception", true, true);
			}
				
			/*
			 * Write the Database ACL to the file
			*/
		
				
			$fp = fopen("/tmp/partner_acl.obj", "w");
			 
			fprintf($fp, serialize($acl));
			fclose($fp);
		
			Zenfox_Debug::dump(null, "Written to Disk", true, true);
				
		}
		return $acl;
	}
	
	public function getAcl()
	{
		return $this->_acl;
	}
	
	public function getCurrentRole()
	{
		return $this->_roleName;
	}
}
