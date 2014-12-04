<?php
/**
 * This file contains Zenfox_Controller_Plugin_FrontendSelector class which extends
 * Zend_Controller_Plugin_Abstract. This is where the frontends are seperated.
 *
 * Long description for file (if any)...
 *
 * LICENSE:
 *
 * @category   Zenfox
 * @package    Zenfox_Plugin
 * @subpackage -
 * @copyright  2009 Yaswanth Narvaneni
 * @license    License Link
 * @version    $Id:$
 * @since      File available since v 0.1
*/

/**
 * This class extends Zend_Controller_Plugin_Abstract to give more flexibility to
 * controllers
 *
 * Long description for class (if any)...
 *
 * @category   Zenfox
 * @package    Zenfox_Plugin
 * @subpackage -
 * @copyright  2009 Yaswanth Narvaneni
 * @since      Class available since v 0.1
 */

class Zenfox_Controller_Plugin_FrontendSelector extends Zend_Controller_Plugin_Abstract
{
	private $_frontendId = '1';
	private $_site = 'zenfox.tld';
	private $_enabledModules ='player';
	private $_defaultModule = 'player';
	private $_defaultSiteCode = 'zfx';
	private $_autoLogin = 'false';
	private $_companyShortName = 'Logic Dice';
	private $_companyName = 'Logic Dice';
	private $_webConfig = ''; 
	
	public function __construct()
	{
		$this->_site = $_SERVER['HTTP_HOST'];
		$this->_serverName = $_SERVER['SERVER_NAME'];
		
		$registry = Zend_Registry::getInstance();
		
		if(!$registry->isRegistered('frontendConfig'))
		{
			//FIXME:: Wirte an elegant way to get fronendFile
			$frontendFile = APPLICATION_PATH . '/configs/frontendConfig.json';
			$fh = fopen($frontendFile, 'r');
        	$frontendJson = fread($fh, filesize($frontendFile));
        	fclose($fh);
			//print $frontendJson;
        	$frontendConfig = Zend_Json::decode($frontendJson);
        	$registry->set('frontendConfig', $frontendConfig);
		}
		else
		{
			$frontendConfig = $registry->get('frontendConfig');
		}
		
		//TODO:: Check if given frontend exists in the given list or throw an exception
		if(!isset($frontendConfig['frontends'][$this->_site]['frontendId']))
		{
			throw new Zenfox_Controller_Plugin_Exception('Config Error:: Frontend not found');
		}
		else
		{
			$this->_frontendId = isset($frontendConfig['frontends'][$this->_site]['frontendId'])?$frontendConfig['frontends'][$this->_site]['frontendId']:"1";
			$this->_enabledModules = isset($frontendConfig['frontends'][$this->_site]['enabledModules'])?$frontendConfig['frontends'][$this->_site]['enabledModules']:$this->_enabledModules;
			$this->_defaultModule = isset($frontendConfig['frontends'][$this->_site]['defaultModule'])?$frontendConfig['frontends'][$this->_site]['defaultModule']:$this->_defaultModule;
			$this->_siteCode = isset($frontendConfig['frontends'][$this->_site]['site_code'])?$frontendConfig['frontends'][$this->_site]['site_code']:$this->_defaultSiteCode;
			$this->_siteName = $frontendConfig['frontends'][$this->_site]['site_name'];
			$this->_autoLogin = isset($frontendConfig['frontends'][$this->_site]['autoLogin'])?$frontendConfig['frontends'][$this->_site]['autoLogin']:'false';
			$this->_companyName = isset($frontendConfig['frontends'][$this->_site]['companyName'])?$frontendConfig['frontends'][$this->_site]['companyName']:null;			
			$this->_companyShortName = isset($frontendConfig['frontends'][$this->_site]['companyShortName'])?$frontendConfig['frontends'][$this->_site]['companyShortName']:$this->_companyName;
			
			$this->_companyAddress = isset($frontendConfig['frontends'][$this->_site]['companyAddress'])?$frontendConfig['frontends'][$this->_site]['companyAddress']:null;
            $this->_frontendName = isset($frontendConfig['frontends'][$this->_site]['frontendName'])?$frontendConfig['frontends'][$this->_site]['frontendName']:null;
            $this->_frontendShortName = isset($frontendConfig['frontends'][$this->_site]['frontendShortName'])?$frontendConfig['frontends'][$this->_site]['frontendShortName']:null;
            $this->_frontendCurrency = isset($frontendConfig['frontends'][$this->_site]['frontendCurrency'])?$frontendConfig['frontends'][$this->_site]['frontendCurrency']:null;
            $this->_frontendMinDeposit = isset($frontendConfig['frontends'][$this->_site]['frontendMinDeposit'])?$frontendConfig['frontends'][$this->_site]['frontendMinDeposit']:null;
            $this->_softwareCompanyName = isset($frontendConfig['frontends'][$this->_site]['softwareCompanyName'])?$frontendConfig['frontends'][$this->_site]['softwareCompanyName']:null;
            $this->_softwareCompanyShortName = isset($frontendConfig['frontends'][$this->_site]['softwareCompanyShortName'])?$frontendConfig['frontends'][$this->_site]['softwareCompanyShortName']:null;
            $this->_operationsCompanyName = isset($frontendConfig['frontends'][$this->_site]['operationsCompanyName'])?$frontendConfig['frontends'][$this->_site]['operationsCompanyName']:null;
            $this->_operationsCompanyShortName = isset($frontendConfig['frontends'][$this->_site]['operationsCompanyShortName'])?$frontendConfig['frontends'][$this->_site]['operationsCompanyShortName']:null;
            $this->_operationsCompanyJurisdiction = isset($frontendConfig['frontends'][$this->_site]['operationsCompanyJurisdiction'])?$frontendConfig['frontends'][$this->_site]['operationsCompanyJurisdiction']:null;
            $this->_licensingJurisdiction = isset($frontendConfig['frontends'][$this->_site]['licensingJurisdiction'])?$frontendConfig['frontends'][$this->_site]['licensingJurisdiction']:null;
            $this->_supportEmailId = isset($frontendConfig['frontends'][$this->_site]['supportEmailId'])?$frontendConfig['frontends'][$this->_site]['supportEmailId']:null;
            $this->_advertisingSiteName = isset($frontendConfig['frontends'][$this->_site]['advertisingSiteName'])?$frontendConfig['frontends'][$this->_site]['advertisingSiteName']:null;
            $this->_processingDay = isset($frontendConfig['frontends'][$this->_site]['processingDay'])?$frontendConfig['frontends'][$this->_site]['processingDay']:"Thursday";
            $this->_processingPreviousDay = isset($frontendConfig['frontends'][$this->_site]['processingPreviousDay'])?$frontendConfig['frontends'][$this->_site]['processingPreviousDay']:"Wednesday";
            $this->UploadDocumentPath = isset($frontendConfig['frontends'][$this->_site]['UploadDocumentPath'])?$frontendConfig['frontends'][$this->_site]['UploadDocumentPath']:null;
			$this->UploadTemplateFile = isset($frontendConfig['frontends'][$this->_site]['UploadTemplateFile'])?$frontendConfig['frontends'][$this->_site]['UploadTemplateFile']:null;
			$this->smarty = isset($frontendConfig['frontends'][$this->_site]['smarty'])?$frontendConfig['frontends'][$this->_site]['smarty']:null;
			
			Zend_Registry::getInstance()->set('defaultModule', $this->_defaultModule);
			Zend_Registry::getInstance()->set('frontendId', $this->_frontendId);
			Zend_Registry::getInstance()->set('siteCode', $this->_siteCode);
			Zend_Registry::getInstance()->set('siteName', $this->_siteName);
			Zend_Registry::getInstance()->set('autoLogin', $this->_autoLogin);
			Zend_Registry::getInstance()->set('companyShortName', $this->_companyShortName);
			Zend_Registry::getInstance()->set('companyName', $this->_companyName);
			
			Zend_Registry::getInstance()->set('companyAddress', $this->_companyAddress);
            Zend_Registry::getInstance()->set('frontendName', $this->_frontendName);
            Zend_Registry::getInstance()->set('frontendShortName', $this->_frontendShortName);
            Zend_Registry::getInstance()->set('frontendCurrency', $this->_frontendCurrency);
            Zend_Registry::getInstance()->set('frontendMinDeposit', $this->_frontendMinDeposit);
            Zend_Registry::getInstance()->set('softwareCompanyName', $this->_softwareCompanyName);
            Zend_Registry::getInstance()->set('softwareCompanyShortName', $this->_softwareCompanyShortName);
            Zend_Registry::getInstance()->set('operationsCompanyName', $this->_operationsCompanyName);
            Zend_Registry::getInstance()->set('operationsCompanyShortName', $this->_operationsCompanyShortName);
            Zend_Registry::getInstance()->set('operationsCompanyJurisdiction', $this->_operationsCompanyJurisdiction);
            Zend_Registry::getInstance()->set('licensingJurisdiction', $this->_licensingJurisdiction);
            Zend_Registry::getInstance()->set('supportEmailId', $this->_supportEmailId);
            Zend_Registry::getInstance()->set('advertisingSiteName', $this->_advertisingSiteName);
            Zend_Registry::getInstance()->set('processingDay', $this->_processingDay);
            Zend_Registry::getInstance()->set('processingPreviousDay', $this->_processingPreviousDay);
            Zend_Registry::getInstance()->set('UploadDocumentPath', $this->UploadDocumentPath);
            Zend_Registry::getInstance()->set('UploadTemplateFile', $this->UploadTemplateFile);
            Zend_Registry::getInstance()->set('smarty', $this->smarty);
			
			/*
			 * Load Web Config
			 */
			$this->_webConfig = $this->loadWebConfig();
			Zend_Registry::getInstance()->set('webConfig', $this->_webConfig);
		}
	}
	
	public function loadWebConfig()
	{
		//Set default site code.
		// Add the / to the site code, this way it becomes a standar
		$siteCode = Zend_Registry::isRegistered('siteCode')?Zend_Registry::get('siteCode') .'/':'zfx/';
		
    	$webConfigFile = APPLICATION_PATH . '/site_configs/' . $siteCode . 'webConfig.json';
    	
		$fh = fopen($webConfigFile, 'r');
        $webConfigJson = fread($fh, filesize($webConfigFile));
        fclose($fh);
        $webConfig = Zend_Json::decode($webConfigJson);
        
        /*
         * Setting defaults for variables in webConfig
         * TODO: Better change this to site code. But zenfox.tld seems to be hard coded in lot of places
         */
        $webConfig['viewDir'] = isset($webConfig['viewDir'])?$webConfig['viewDir']:"zenfox.tld/";
        
		return $webConfig;
	}
	
    public function routeStartup(Zend_Controller_Request_Abstract $request)
    {

/*        $baseUri = $request->getBaseUri();
        print $baseUri;
*/
            //$view = Zend_Layout::getMvcInstance()->getView();

    }

    public function dispatchLoopStartup(Zend_Controller_Request_Abstract $request)
    {
//    	print('module - ' . $request->getModuleName());
//    	exit();
        $module_dir = Zend_Controller_Front::getInstance()->getModuleDirectory();
        $view = Zend_Layout::getMvcInstance()->getView();
        /*
         * View scripts are in application/modules/[module name]/views/[frontendurl]
         */

        /*
         * Don't get it from Zend_Registry. Get it from the request.
         * If requested for /affiliate on player website.
         * Zend_Registry will return player;
         * $request will return affiliate.
         */
        $currentModule = $request->getModuleName();
        
        //FIXME:: Should this not be in Acl??
        if(!in_array($currentModule,$this->_enabledModules))
        {
        	//FIXME:: How better can we handle this?
        	throw new Zenfox_Exception ('Illegal Module');
        }
        /*
         * TODO::
         * 1. Check the URI
         * 2. Query the DB or MC for frontend_id
         * 3. Set default frontend_id in Zend_Registry
         */
        switch ($currentModule)
        {
            case 'player':
                    $view->addBasePath($module_dir .  '/views');
                    $view->setScriptPath($module_dir . '/views/' . $this->_webConfig['viewDir']);
                    break;
            case 'affiliate':
            		$this->moduleInitAffiliate();
            		//TODO:: Extend this to support frontends (copy above line)
                    //$view->setScriptPath($module_dir . '/views/scripts');
                    $view->addBasePath($module_dir .  '/views');
                    $view->setScriptPath($module_dir . '/views/' . $this->_webConfig['viewDir']);
                    break;
            case 'admin':
            		//TODO:: Extend this to support frontends (copy above line)
                    $view->setScriptPath($module_dir . '/views/scripts');
                    break;
            case 'partner':
            		$view->setScriptPath($module_dir . '/views/' . $this->_webConfig['viewDir']);
            		break;
        }
    }
    
    private function moduleInitAffiliate()
    {
    	/*
    	 * Initialize Piwik_Resource
    	 */
    }
}
