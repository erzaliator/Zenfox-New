<?php
/**
 * This file contains Bootstrap class which extends Zend_Application_Bootstrap_Bootstrap
 * This is where the bootstrapping of the app is done.
 *
 * Long description for file (if any)...
 *
 * LICENSE:
 *
 * @category
 * @package
 * @subpackage -
 * @copyright  2009 Yaswanth Narvaneni
 * @license    License Link
 * @since      File available since v 0.1
*/

/**
 * This class extends Zend_Application_Bootstrap_Bootstrap
 *
 * Long description for class (if any)...
 *
 * @category
 * @package
 * @subpackage -
 * @copyright  2009 Yaswanth Narvaneni
 * @since      Class available since v 0.1
 */

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	private $_acl = null;
	private $_roleName;
    protected function _initAppAutoload()
    {
    	//print "SESSION DATA::: " . $_SESSION['myCounter'];
    	//$_SESSION['myCounter'] = 0;
        $autoloader = new Zend_Application_Module_Autoloader(array(
            'namespace' => '',
            'basePath'  => dirname(__FILE__),
            //'basePath'  => APPLICATION_PATH . "/modules",
        ));
        
        /*
         * If it's false, then if inside the preDispatch an exception is thrown, 
         * it's possible that your security is compromised: the exception will be 
         * caught by the frontController, and the dispatch will continue, 
         * executing potentially dangerous code.
         */
        
        $frontController = Zend_Controller_Front::getInstance();
        $frontController->throwExceptions(false);
        
        $frontController->registerPlugin(new Zend_Controller_Plugin_ErrorHandler, 1000);
        //$frontController->unregisterPlugin($frontController->getPlugin('Zend_Controller_Plugin_ErrorHanlder'));
        //$frontController->registerPlugin(new Zenfox_Controller_Plugin_ErrorHandler, 1100);

        $this->getApplication()->getAutoloader()->registerNamespace('Doctrine')
                               ->pushAutoloader(array('Doctrine', 'autoload'));

        //TODO:: Move this to Resource_Defaults.php
//        $options = $this->getOptions('defaults');
//        $time_zone = isset($options['defaults']['timeZone'])?$options['defaults']['timeZone']:"Europe/London";
        //date_default_timezone_set($time_zone);
  //      print "<pre>";
        return $autoloader;
    }

    protected function _initModules()
    {
        //TODO:: Depending on the request initialized modules
        //FIXME:: Can't this be achieved through Zend_Controller_Router?

        $frontController = Zend_Controller_Front::getInstance();
        //$frontController->registerPlugin( new Zenfox_Controller_Plugin_ErrorHandler());
        $frontController->registerPlugin(new Zenfox_Controller_Plugin_FrontendSelector(),1);
        //$frontController->registerPlugin(new Zenfox_Controller_Plugin_Header(), 450);

        //Registering facebook plugin     
        //XXX: Update:: Not needed??
        //TODO:: Add a Zenfox_Controller_Plugin_ModuleSelector() which will select the default module.
    }

    protected function _initPlugins()
    {
    	 $frontController = Zend_Controller_Front::getInstance();
         $roleName = Zend_Auth::getInstance()->hasIdentity();
         $this->_roleName = 'visitor';
         if($roleName)
         {
         	$session = new Zend_Auth_Storage_Session();
		 	$store = $session->read();
         	$id = $store['id'];
         	$roleName = $store['roleName'];
         	$this->_roleName = $roleName;
         	//Zenfox_Debug::dump($roleName, "Role Name:: ", true, true);
	        if($roleName == 'visitor')
	        {
	            /*
	             * This won't happen
	             */
	        }
	        elseif($roleName == 'player')
	        {
	            /*
	             * TODO:: Attach player specific plugins here
	             */
	        	$userTimeZone = $store['authDetails'][0]['timezone'];
				Zend_Registry::getInstance()->set('userTimeZone', $userTimeZone);
				$frontController->registerPlugin(new Zenfox_Controller_Plugin_UpdateSession());
				
	        }
	        elseif($roleName == 'affiliate')
	        {
	            /*
	             * TODO:: Attach affiliate specific plugins here
	             */
	        }
	        elseif($roleName == 'admin')
	        {
	            /*
	             * TODO:: Attach admin specific plugins here
	             */
	        }
         }
         else
         {
			$frontController->registerPlugin(new Zenfox_Controller_Plugin_RefererTracker(),100);
         	$roleName = 'visitor';
            //This has to be set so that error doesn't come up when initiating Zenfox_Controller_Plugin_Acl
            $id = null;
         }
         
         //TODO uncomment it for facebook
        $frontController = Zend_Controller_Front::getInstance();
//        $frontController->registerPlugin(new Zenfox_Controller_Plugin_Facebook(),250);
//        $frontController->registerPlugin(new Zenfox_Controller_Plugin_FacebookAuth(),150);
         
        //$frontController = Zend_Controller_Front::getInstance();
        //$frontController->registerPlugin(new ViewRoutePlugin());
        //$frontController->registerPlugin(new Zenfox_Controller_Plugin_FrontendSelector());
//        $frontController->registerPlugin(new CheckIP());
		/*
		 * Registering ACL Plugin
		 */
		//print json_encode($frontController);
		/*
		$this->_acl = new Zenfox_Acl();
		$zenfoxAclPlugin = new Zenfox_Controller_Plugin_Acl($this->_acl, $id, $roleName);
		*/

        //Zenfox_Debug::dump ($roleName, "Role ::" );

        
        $zenfoxAclPlugin = new Zenfox_Controller_Plugin_Acl($roleName);
		$frontController->registerPlugin($zenfoxAclPlugin,200);
		//$frontController->registerPlugin( new Zenfox_Controller_Plugin_ErrorHandler(), 400);
		if($roleName == 'player')
		{
			//$userTimeZone = $store['authDetails'][0]['timezone'];
			//Zend_Registry::getInstance()->set('userTimeZone', $userTimeZone);
			/*$timeZonePlugin = new Zenfox_Controller_Plugin_TimeZone();
			$frontController->registerPlugin($timeZonePlugin, 250);*/
			/*$serverTimeZone = date_default_timezone_get();
			$userTimeZone = $store['authDetails'][0]['timezone'];
			Zend_Registry::getInstance()->set('userTimeZone', $userTimeZone);
			if($serverTimeZone != $userTimeZone)
			{
				$timeZonePlugin = new Zenfox_Controller_Plugin_TimeZone();
				$frontController->registerPlugin($timeZonePlugin, 250);
			}*/
		}

        /*
         * Registring Translator Plugin (To retrieve language from Route)
         */

		$frontController->registerPlugin(new Zenfox_Controller_Plugin_Translate());
		$frontController->registerPlugin(new Zenfox_Controller_Plugin_WebAnalytics(), 1200);
		$frontController->registerPlugin(new Zenfox_Controller_Plugin_CommonContent(), 600);
    }
    
    protected function _initViewHelpers()
    {
    	$isSmarty = Zend_Registry::get('smarty');
  		$siteCode = Zend_Registry::get('siteCode');
    	if($isSmarty)
    	{
    		$filePath = APPLICATION_PATH . '/site_configs/' . $siteCode . '/smarty_conf.json';
    		$fh = fopen($filePath, 'r');
    		$fileData = fread($fh, filesize($filePath));
    		$smartyConfig = Zend_Json::decode($fileData);
    		
    		$smartyConfig['template_dir'] = APPLICATION_PATH . $smartyConfig['template_dir']; 
    		$smartyConfig['compile_dir'] = APPLICATION_PATH . $smartyConfig['compile_dir'];
    		$smartyConfig['cache_dir'] = APPLICATION_PATH . $smartyConfig['cache_dir'];
    		
    		$view = new Zenfox_View_Smarty($smartyConfig);
    		// setup viewRenderer with suffix and view
    		$viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer');
    		$viewRenderer->setViewSuffix('tpl');
    		$viewRenderer->setView($view);
    		 
    		// ensure we have layout bootstraped
    		$this->bootstrap('layout');
    		// set the tpl suffix to layout also
    		$layout = Zend_Layout::getMvcInstance();
    		$layout->setViewSuffix('tpl');
    		$layout->getView()->addHelperPath("Noumenal/View/Helper","Noumenal_View_Helper");
    		 
    		return $view;
    	}
    	else
    	{
    		$this->bootstrap('layout');
    		$layout = $this->getResource('layout');
    		 
    		$view = $layout->getView();
    		$view->addHelperPath("Zenfox/View/Helper", "Zenfox_View_Helper");
    		$view->addHelperPath("ZendX/JQuery/View/Helper", "ZendX_JQuery_View_Helper");
    		$view->addHelperPath("Zenfox/JQuery/View/Helper", "Zenfox_JQuery_View_Helper");
    		$view->addHelperPath("Noumenal/View/Helper","Noumenal_View_Helper");
    		$view->addHelperPath("Zenfox/View/Helper", "Zenfox_View_Helper_Jsonmenu");
    		
    		//Add common js file according to module
    		switch($this->_roleName)
    		{
    			case 'visitor':
    				$view->jQuery()->setLocalPath("/js/jquery_zenfox.js");
    				break;
    			case 'player':
    				$view->jQuery()->setLocalPath("/js/jquery_zenfox.js");
    				break;
    			case 'affiliate':
    				$view->jQuery()->setLocalPath("/js/jquery_affiliate.js");
    				break;
    		}
    		 
    		$viewRenderer = new Zend_Controller_Action_Helper_ViewRenderer();
    		$viewRenderer->setView($view);
    		Zend_Controller_Action_HelperBroker::addHelper($viewRenderer);
    		
    		$context = new Zend_Controller_Action_Helper_ContextSwitch();
    		Zend_Controller_Action_HelperBroker::addHelper($context);
    	}
		
/*		$view->narvaneni = "I am narvaneni!";
		
		$fp = fopen("/tmp/yaswanth", "a");
		fprintf($fp, "This is narvaneni\n");
		fclose($fp);*/
    }
    
    protected function _initMenu()
    {    	
    	$frontController = Zend_Controller_Front::getInstance();
		$zenfoxMenuPlugin = new Zenfox_Controller_Plugin_Menu();
		$frontController->registerPlugin($zenfoxMenuPlugin, 350);
    }
    /*protected function _initPiwik()
    {
    	/*$frontController = Zend_Controller_Front::getInstance();
    	$piwikPlugin = new Zenfox_Controller_Plugin_Piwik();*/
    	//$frontController->registerPlugin($piwikPlugin, 1000);
    //}    
/*    protected function _initFacebook()
    {
    	$identity = Zend_Auth::getInstance()->hasIdentity();
        if(!$identity)
        {
        	$front = Zend_Controller_Front::getInstance();
        	$baseUrl = $front->getRequest()->getModuleName();
        	print_r($baseUrl);
        	$url = $_SERVER["PHP_SELF"];
        	//$url = $_GET('auth');
			$breakUrl = explode('/', $url);
			$test = $breakUrl[2];
			print($url);
//			if($test == 'facebook')
//			{
//				$facebook = Zend_Controller_Front::getInstance();
//				$facebook->registerPlugin(new Zenfox_Controller_Plugin_Facebook(),2);
//			}
        }
    }*/
    
    /*
    protected function _initLogger()
    {
    	//$writer = new Zend_Log_Writer_Firebug();
    	//$writer = new Zend_Log_Writer_Syslog();
    	$writer = new Zend_Log_Writer_Stream("/tmp/rummy.tld.log.html");
		$logger = new Zend_Log($writer);
 
		Zend_Registry::getInstance()->set('Zenfox_Logger', $logger);
		// Use this in your model, view and controller files
		//$logger->log('This is a log message!', Zend_Log::INFO);
    	
    }
    */
}
