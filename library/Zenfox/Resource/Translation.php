<?php
/**
 * This file contains Zenfox_Resource_Translation class which extends
 * Zend_Application_Resource_ResourceAbstract.
 * This creates an instance of Zenfox_Resource_Translation and returns to the Bootstrap
 * The default language for the entire app is set here
 *
 * Long description for file (if any)...
 *
 * LICENSE:
 *
 * @category   Zenfox
 * @package    Zenfox_Resource
 * @subpackage -
 * @copyright  2009 Yaswanth Narvaneni
 * @license    License Link
 * @since      File available since v 0.1
*/

/**
 * This class extends Zend_Application_Resource_ResourceAbstract.
 * This creates an instance of Zenfox_Resource_Translation  and returns
 * it to the App's Bootstrap
 *
 *
 * Long description for class (if any)...
 *
 * @category   Zenfox
 * @package    Zenfox_Resource
 * @subpackage -
 * @copyright  2009 Yaswanth Narvaneni
 * @since      Class available since v 0.1
 */

class Zenfox_Resource_Translation extends Zend_Application_Resource_ResourceAbstract
{
    const DEFAULT_REGISTRY_KEY = 'Translation';
    public function init()
    {
         /*
         * FIXME:: Move this Router ReWrite out of here!
         */
        $registry = Zend_Registry::getInstance();
        $zfc = Zend_Controller_Front::getInstance();

        $router = $zfc->getRouter();
        $router = $this->setRouterPath($router);
        $zfc->setRouter($router);

        $translate = new Zend_Translate('gettext', APPLICATION_PATH . '/../languages',null,
          array('scan' => Zend_Translate::LOCALE_FILENAME));


        $registry->set('Zend_Translate', $translate);

        return $translate;
    }

    public function setRouterPath($router)
    {
    	$link = $_SERVER['HTTP_HOST'];
    	$requestUrl = $_SERVER["REQUEST_URI"];
    	
    	$explodeLink = explode('.', $link);
    	if(($explodeLink[0] == 'admin') || ($explodeLink[0] == 'affiliate') || (($explodeLink[0] == 'partner')))
    	{
    		$module = $explodeLink[0];
    	}
    	else
    	{
    		$module = 'player';
    	}
    	//$controller = substr($requestUrl, 1, strlen($module));
    	$explodeRequest = explode('/', $requestUrl);
        $controller = $explodeRequest[1];
        // add language to default route
       /*$route = new Zend_Controller_Router_Route(
                        ':lang/:controller/:action/*',
                        array('controller'=>'index',
                              'action' => 'index',
                              'module'=> $module,
                              'lang'=>$locale));
        */

    	/*
    	 * Step 1: Regular expression for language to take en or en_GB ([a-z]_[A-Z])
    	 * 			([a-z]{2}|[a-z]{2}_[A-Z]{2})
    	 */
    	
    	if(strlen(strstr($requestUrl, '/rummy/')) > 0)
    	{
	        $locale = substr($requestUrl, 1, 5);
	        if(strpos($locale, '_'))
	        {
	        	$controller = $explodeRequest[3];
	        	$localeObj = new Locale();
	        	$locale = $localeObj->setLocale(substr($requestUrl, 1, 5));
	        	$route = new Zend_Controller_Router_Route(
	                        ':lang/:seo/:@controller/:@action/*',
	                        array('controller'=>'index',
	                              'action' => 'index',
	                              'module'=> $module,
	                        	  'seo' => 'rummy',
	                              'lang'=>$locale), array('lang'=>'([a-z]{2}|[a-z]{2}_[A-Z]{2})'));
	            
	            $router->addRoute('rummy_language', $route);
	        }
	        else
	        {
	        	$controller = $explodeRequest[2];
	        	$route = new Zend_Controller_Router_Route(
	                        ':seo/:@controller/:@action/*',
	                        array('controller'=>'index',
	                              'action' => 'index',
	                              'module'=> $module,
	                        	  'seo' => 'rummy'));
	            
	            $router->addRoute('rummy', $route);
	        }
    	}
    	else
        {
        	$localeObj = new Locale();
	        $locale = $localeObj->setLocale(substr($requestUrl, 1, 5));
	        	
	        //Previous Code
	        $route = new Zend_Controller_Router_Route(
	                        ':lang/:@controller/:@action/*',
	                        array('controller'=>'index',
	                              'action' => 'index',
	                              'module'=> $module,
	                              'lang'=>$locale), array('lang'=>'([a-z]{2}|[a-z]{2}_[A-Z]{2})'));
	        
	        /* $route = new Zend_Controller_Router_Route(
	        	            ':@controller/:@action/*',
	        				array('controller'=>'index',
	        	                  'action' => 'index',
	        	                  'module'=> $module)); */
	                        
	        $router->addRoute('language', $route);
        }
    	if(($module == substr($controller, 0, strlen($module))) || (($module == 'admin') && ($controller == 'player')) || (($module == 'player') && ($controller == 'admin')) || (($module == 'player') && ($controller == 'affiliate')) || (($module == 'partner') && ($controller == 'player')))
    	{
    		$adminRoute = new Zend_Controller_Router_Route(
                        ':@controller/:@action/*',
                        array('controller'=>'index',
                              'action' => 'index',
                              'module'=> $module));
        	$router->addRoute('adminRoute', $adminRoute);
    	}
        
        
    	/*if(($module == substr($controller, 0, strlen($module))) || (($module == 'admin') && ($controller == 'player')) || (($module == 'player') && ($controller == 'admin')))
    	{
    		$adminRoute = new Zend_Controller_Router_Route(
                        ':@controller/:@action/*',
                        array('controller'=>'index',
                              'action' => 'index',
                              'module'=> $module));
        	$router->addRoute('adminRoute', $adminRoute);
    	}
        else
        {
        	$localeObj = new Locale();
	        $locale = $localeObj->setLocale(substr($requestUrl, 1, 5));
	        	
	        $route = new Zend_Controller_Router_Route(
	                        ':lang/:@controller/:@action/*',
	                        array('controller'=>'index',
	                              'action' => 'index',
	                              'module'=> $module,
	                              'lang'=>$locale), array('lang'=>'([a-z]{2}|[a-z]{2}_[A-Z]{2})'));
	                        
	        $router->addRoute('language', $route);
        }*/
    	
//    	$route = new Zend_Controller_Router_Route(
//                        ':lang/:@controller/:@action/*',
//                        array('controller'=>'index',
//                              'action' => 'index',
//                              'module'=> $module,
//                              'lang'=>$locale), array('lang'=>'([a-z]{2}|[a-z]{2}_[A-Z]{2})'));
//                        
//            $router->addRoute('language', $route);
        /*
        $defaultRoute = new Zend_Controller_Router_Route(
        				'/:controller/:action/*',
        				array('controller'=>'index',
                              'action' => 'index',
                              'module'=> 'player'));
        $router->addRoute('default', $defaultRoute);*/
		//$router->setGlobalParam('lang', 'en_GB');
        

        return $router;
    }
}
