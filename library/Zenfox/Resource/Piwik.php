<?php
/**
 * This file contains Zenfox_Resource_Datetime class which extends
 * Zend_Application_Resource_ResourceAbstract. This class is used to
 * initialize date time and time related issues in the Bootstrap.
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
 * This class is used to initialize date time and time related issues in
 * the Bootstrap.
 *
 * Long description for class (if any)...
 *
 * @category   Zenfox
 * @package    Zenfox_Resource
 * @subpackage -
 * @copyright  2009 Yaswanth Narvaneni
 * @since      Class available since v 0.1
 */
class Zenfox_Resource_Piwik extends Zend_Application_Resource_ResourceAbstract
{
    public function init()
    {
        $options = $this->getOptions();
        Zend_Registry::getInstance()->set('piwikEnabled', false);
//        date_default_timezone_set($options['defaultTimeZone']);
//        Zend_Registry::getInstance()->set('serverTimeZone', $options['defaultTimeZone']);
//        Zend_Registry::getInstance()->set('userTimeZone', $options['defaultTimeZone']);
		//Zend_Registry::getInstance()->set('piwikEnabled', true);
		if($options['enabled'] == "true")
		{
//			echo "here";
//			exit();
			define('PIWIK_INCLUDE_PATH', APPLICATION_PATH . '/../public/piwik');
			define('PIWIK_ENABLE_DISPATCH', false);
			define('PIWIK_ENABLE_ERROR_HANDLER', false);
			define('PIWIK_ENABLE_SESSION_START', false);
			
			require_once PIWIK_INCLUDE_PATH . "/index.php";
			try{
				Piwik_FrontController::getInstance()->init();
			}
			catch(Exception $e)
			{
				print "exception occured";
				exit();
			}
			//@ini_set('display_errors', 1);
			if(APPLICATION_ENV == 'development')
			{		
				@ini_set('display_errors', 1);
			}
			else
			{
				@ini_set('display_errors', 0);
			}
			require_once PIWIK_INCLUDE_PATH . '/PiwikTracker.php';
			PiwikTracker::$URL = 'http://zenfox.tld/piwik/';
			Zend_Registry::getInstance()->set('piwikEnabled', true);
		}
    }
}