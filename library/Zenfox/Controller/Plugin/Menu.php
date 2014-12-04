<?php
/**
 * 
 * @author ny
 * TODO:: This has to be completely removed to come up with a proper Menu_Acl and Acl Object
 */

class Zenfox_Controller_Plugin_Menu extends Zend_Controller_Plugin_Abstract
{
	/*
	 * TODO:: Make this postDispatch. But postDispatch doesn't work.
	 */
	public function preDispatch(Zend_Controller_Request_Abstract $request)
	{	
		try
		{				
			$frontendController = Zend_Controller_Front::getInstance();
			$moduleName = $frontendController->getRequest()->getModuleName();
			$controllerName = $frontendController->getRequest()->getControllerName();
			$actionName = $frontendController->getRequest()->getActionName();
			//print "Module Name:: $moduleName";
			if(($moduleName != 'admin'))
			{
				//$view = Zend_Layout::getMvcInstance()->getView();
				//$view = $frontendController->getParam('bootstrap')->getResource('view'); // -- Not working
				$viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer');
				/*if (null === $viewRenderer->view) {
				    $viewRenderer->initView();
				}*/
				$view = $viewRenderer->view;
	            //Added for navigation translation
	            $view->navigation()->setTranslator(Zend_Registry::get('Zend_Translate'));
		
				$menu = new Menu($moduleName);
				//Decide on the role and current request in the Menu class
				$navigation = $menu->getNavigation();
				//$acl = $menu->getAcl();
				
				
				if(Zend_Controller_Front::getInstance()->hasPlugin('Zenfox_Controller_Plugin_Acl'))
				{
					$aclPlugin = Zend_Controller_Front::getInstance()->getPlugin('Zenfox_Controller_Plugin_Acl');
					$acl = $aclPlugin->getAcl();
					$currentRole = $aclPlugin->getCurrentRole();
					//print "Getting from ACL Plugin" . $currentRole;
				}
				else
				{
					Zenfox_Debug::dump(null, "Acl is null");
					$acl = null;
					$currentRole = 'visitor';
				}
				
				$frontendId = Zend_Registry::getInstance()->get('frontendId');
				$frontendName = Zend_Registry::getInstance()->get('frontendName');
				
				//Zenfox_Debug::dump($currentRole, "Current Role");
				$view->navigation($navigation)->setAcl($acl)->setRole($currentRole);
				if($frontendId == 1 && $frontendName == 'taashtime.com')
				{
					if(($moduleName == 'player') && ($currentRole == 'visitor') && ($actionName != 'game'))
					{
						Zend_Layout::startMvc(array(
						//'layoutPath' => APPLICATION_PATH . '/modules/player/views/rummy.tld',
								            'layout' => 'inner-page'
						));
					}
				}
				else
				{
					
				}
				//Zenfox_Debug::dump($view->navigation()->getContainer(), "Init Container");
				//Zenfox_Debug::dump(serialize($acl), "ACL:: ");
				//print spl_object_hash($view);
			}
			//print "Peak Memory:: " . memory_get_peak_usage(true);
			
			else
			{
				//OLD CODE
				//START CODE
				//Zenfox_Debug::dump($request->getActionName(), "Request Action Name", true, true);
				$contextSwitch = Zend_Controller_Action_HelperBroker::getStaticHelper('ContextSwitch');
		        $contextSwitch->addActionContext($request->getActionName(), 'json');
		        $contextSwitch->initContext();
				$view = Zend_Layout::getMvcInstance()->getView();
				$menu = new AdminMenu('admin');
				$navigation = $menu->getNavigation();
				//$acl = $menu->getAcl();
				//$currentRole = $menu->getCurrentRole();
				$aclPlugin = Zend_Controller_Front::getInstance()->getPlugin('Zenfox_Controller_Plugin_Acl');
				$acl = $aclPlugin->getAcl();
				$currentRole = $aclPlugin->getCurrentRole();
				$view->navigation($navigation)->setAcl($acl)->setRole($currentRole);
				//END CODE
				/*$view = Zend_Layout::getMvcInstance()->getView();
				$menu = new Menu($moduleName);
				$navigation = $menu->getNavigation();
				$aclPlugin = Zend_Controller_Front::getInstance()->getPlugin('Zenfox_Controller_Plugin_Acl');
				$acl = $aclPlugin->getAcl();
				$currentRole = $aclPlugin->getCurrentRole();
				$view->navigation($navigation)->setAcl($acl)->setRole($currentRole);*/
			}
		}
		catch (Exception $e)
		{
			//Zenfox_Debug::dump($e, "In Menu Plugin");
			// Repoint the request to the default error handler
            $request->setControllerName('error');
            $request->setActionName('error');

            // Set up the error handler
            $error = new Zend_Controller_Plugin_ErrorHandler();
            $error->type = Zend_Controller_Plugin_ErrorHandler::EXCEPTION_OTHER;
            $error->request = clone($request);
            $error->exception = $e;
            $request->setParam('error_handler', $error);
		}
	}
	
	/*
	 * OLD CODE
	 */
	
	/*
	private $_module = null;
	private $_roleName = null;
	
	public function __construct($moduleName, $roleName)
	{
		$this->_module = $moduleName;
		$this->_roleName = $roleName;
	}
	*/
	/*
	public function postDispatch(Zend_Controller_Request_Abstract $request)
	{
		//FIXME:: Start layout if not started 
		//$this->bootstrap('layout');
    	//$layout = $this->getResource('layout');
    	$view = Zend_Layout::getMvcInstance()->getView();
		//FIXME:: This navigation is only for player
    	$config = new Zend_Config_Xml(APPLICATION_PATH . '/configs/navigation.xml', 'nav');
    			
		$aclPlugin = Zend_Controller_Front::getInstance()->getPlugin('Zenfox_Controller_Plugin_Acl');
		$acl = $aclPlugin->getAcl();
		
		$roleName = Zend_Auth::getInstance()->hasIdentity();
		if($roleName == 'player')
		{
			//Get Resources for player and visitor or any other resource thats in the menu
			$acl = $this->addResourcesByRoleName($acl, array('player', 'visitor'));
		}
		else if($roleName == 'csr')
		{
			//Get Resources for player, visitor and csr
			$acl = $this->addResourcesByRoleName($acl, array('csr', 'visitor'));
		}
		else
		{
			//Get Resources for player, visitor
			$acl = $this->addResourcesByRoleName($acl, array('player', 'visitor'));
		}
		//TODO:: Update the acl with all the resources needed for the current module
		
		$navigation = new Zend_Navigation($config);
    	$view->navigation($navigation)->setAcl($acl);
	}
	
	public function addResourcesByRoleName(Zend_Acl $acl, $roleNames)
	{
		foreach ($roleNames as $roleName)
		{
			$role = Doctrine::getTable('Role')->findOneByName($roleName);
			$roleResources = $role->getResourcesByRoleName($role->getRoleId());
			foreach ($roleResources as $r)
			{
				if(!$acl->has($r))
				{
					print $r->getResourceId() . "<br>";
					$acl->add($r);
				}
			}
		}
		
		return $acl;
	}
	
	public function addPrivilegesByRoleName(Zend_Acl $acl, $roleName)
	{
		$role = Doctrine::getTable('Role')->findOneByName($roleName);
		$roleResources = $role->getResourcesByRoleName($role->getRoleId());
	}
	*/
}