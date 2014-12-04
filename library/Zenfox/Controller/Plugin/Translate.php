<?php
/*******************************************************************
 * Name: Zenfox_Controller_Plugin_Translate
 * Description: Sets the Translator according to the language
 * specified in the Route
 *
 ******************************************************************/
/**
 * This class extends Zend_Controller_Plugin_Abstract.
 * This creates an instance of Zend_Translate from Route and 
 * and sets it in Registry
 *
 *
 * Long description for class (if any)...
 *
 * @category   Zenfox
 * @package    Zenfox_Controller_Plugin
 * @subpackage -
 * @copyright  2010 Yaswanth Narvaneni
 */


class Zenfox_Controller_Plugin_Translate extends Zend_Controller_Plugin_Abstract
{
    public function __construct()
    {
    }

    public function init()
    {
        parent::init();
    }
    
    /*public function routeStartup(Zend_Controller_Request_Abstract $request)
    {
    	$request->setRequestUri($request->getRequestUri());
    	$request->setParam('lang', 'en_GB');
    }*/

    public function routeShutdown (Zend_Controller_Request_Abstract $request)
    {
    	$authSession = new Zend_Auth_Storage_Session();
	    $storedData = $authSession->read();
    	$session = new Zend_Session_Namespace('language');
    	//$session->unsetAll();
        //$options = $this->getOptions();
        if($session->language)
        {
        	$locale = $session->language;
        }
        else
        {
	    	if((is_array($storedData)) && (array_key_exists('authDetails', $storedData)))
	    	{
	    		$userLanguage = $storedData['authDetails'][0]['language'];
	    	}
	    	if(isset($userLanguage))
	    	{
	    		$locale = $userLanguage;
	    		$session->language = $locale;
	    	}
	    	else
	    	{
	    		$frontendId = Zend_Registry::getInstance()->get('frontendId');
	    		$frontend = new Frontend();
	    		$frontendData = $frontend->getFrontendById($frontendId);
	    		if(isset($frontendData['languages']))
	    		{
	    			$locale = $frontendData['languages'];
	    		}
		    	else
		        {
		        	//$locale = isset($options['defaultLanguage'])?$options['defaultLanguage']:'en_GB';
                    $locale = 'en_GB';
		        }
	    	}
	    	//$session->language = $locale;
        }
        //TODO:: Make user specific changes here.


        $locale = $request->getParam('lang')?$request->getParam('lang'):$locale;

        $localeObj = new Locale();
        $locale = $localeObj->setLocale($locale);
        
        $zl = new Zend_Locale();
        $zl->setLocale($locale);
        $registry = Zend_Registry::getInstance();
        $registry->set('Zend_Locale', $zl);
        
        $session->language = $locale;
    	if($storedData)
	    {	
	    	//$storedData['oldValue'] = $storedData['newValue'];
	    	$storedData['oldValue'] = isset($storedData['newValue'])?$storedData['newValue']:$locale;
	    	$storedData['newValue'] = $locale;
	    	$authSession->write($storedData);
	    }
        //Zenfox_Debug::dump($storedData, 'data');
        /*$currency = new Zend_Currency();
        $oldCurrency = $currency->getShortName();
		$newCurrency = $currency->getShortName('', $locale);*/
        //print('locale - ' . $zl);
        /*if($zl == 'root')
        { 
        	$locale = Zend_Registry::get('Zend_Locale');
//        	$controller = $request->getParam('lang');
//        	$action = $request->getControllerName();
//        	$request->setControllerName($controller);
//        	$request->setActionName($action);
//        	$request->setParam('lang', $locale);
        	$zl->setLocale($locale);
        }*/

        //$locale = $registry->get('Zend_Locale');
        //$translate = new Zend_Translate('gettext', '../languages',$locale,
        //  array('scan' => Zend_Translate::LOCALE_FILENAME));
        $translate = new Zend_Translate('gettext', APPLICATION_PATH . '/../languages',null,
          array('scan' => Zend_Translate::LOCALE_FILENAME));
	$session->language = $locale;

//	Zend_Session::start();
//	$currSess = new Zend_Session_Namespace('cur');
//	Zenfox_Debug::dump($currSess->value, 'value');
//	$currSess->value = $locale;
//	Zenfox_Debug::dump($currSess->value, 'value');
	//Zenfox_Debug::dump($currSess->value, 'value');
	/*Zenfox_Debug::dump($currSess->value, 'value');
	if($currSess->value)
	{
		foreach($currSess->value as $index => $currValue)
		{
			if($index == 1)
			{
				$data[$index - 1] = $currValue;
				$data[$index] = $locale;
			}
		}
	}
	$currSess->value = $data;*/
	/*if((Zend_Registry::isRegistered('oldCurrency')) || (Zend_Registry::isRegistered('newCurrency')))
	{
		echo "here";exit();
		$oldCurrency = Zend_Registry::get('oldCurrency');
		$newCurrency = Zend_Registry::get('newCurrency');
		$oldCurrency = $newCurrency;
	}
	Zend_Registry::set('oldCurrency', $oldCurrency);
	Zend_Registry::set('newCurrency', $locale);*/
	/*$temp = Zend_Registry::get('temp');
	Zend_Registry::set('temp', $temp++);
	print('temp-' . $temp);*/
	//$currencySession->unlockAll();
	//$currencySession->myValue?$currencySession->myValue++:$currencySession->myValue=0;
	//print "Value:: " . $currencySession->myValue;
	//Zenfox_Debug::dump($currencySession, 'session');
	//print('newValue - ' . $currencySession->oldValue);
	$currencySession = new Zend_Session_Namespace('currency');
	$currencySession->oldValue = $currencySession->newValue;
	$currencySession->newValue = $locale;
	
	
	//$storedData['currency']['oldValue'] = $storedData['currency']['newValue'];
	//$storedData['currency']['newValue'] = $locale;
	
	/*print "myNewValue 1:: " . $storedData['currency']['newValue'];
	print "myOldValue 1:: " . $storedData['currency']['oldValue'];*/
	
	//$authSession->write($storedData);
	
	//print "Locked" . $currencySession->isLocked();
        //print_r ($translate->getAdapterInfo());
		$registry = Zend_Registry::getInstance();
        $registry->set('Zend_Translate', $translate);

    }

}

