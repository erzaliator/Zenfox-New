<?php
class Zenfox_Controller_Plugin_WebAnalytics extends Zend_Controller_Plugin_Abstract
{
	public function postDispatch()
    {
    	$siteCode = Zend_Registry::getInstance()->get('siteCode');
    	if(file_exists(APPLICATION_PATH.'/site_configs/'.$siteCode.'/googleAnalytics.json'))
		{
			$this->googleAnalytics($siteCode);
		}
		
    	$view = Zend_Layout::getMvcInstance()->getView();
    	
    	if(file_exists(APPLICATION_PATH.'/site_configs/'.$siteCode.'/googleAnalytics.json'))
		{
			$view->addHelperPath("Zenfox/View/Helper", "Zenfox_View_Helper");
    		$view->googleAnalytics();
		}
		$viewRenderer = new Zend_Controller_Action_Helper_ViewRenderer();
		$viewRenderer->setView($view);
		Zend_Controller_Action_HelperBroker::addHelper($viewRenderer);
    }
    
	public function googleAnalytics($siteCode)
    {
    	
    	$siteConfigFile = APPLICATION_PATH.'/site_configs/'.$siteCode.'/googleAnalytics.json';
		$fh = fopen($siteConfigFile, 'r');
        $siteJson = fread($fh, filesize($siteConfigFile));
        fclose($fh);
		//print $frontendJson;
        $siteConfig = Zend_Json::decode($siteJson);
        
        $username = $siteConfig['username'];
        $password = $siteConfig['password'];
        
        $params = array(
		    'username' => $username,
		    'password' => $password,
        	'ga' => 15410173
			);
		try{
			$analytics = new Zenfox_WebAnalytics_GoogleAnalytics($params);
			$dataFeed = $analytics->getDataFeed();
			$accountFeed = $analytics->getAccountFeed();
		}
		catch(Exception $e)
		{
			echo $e->getMessage();
		}
        
		//echo $dataFeed.' '.$accountFeed;
        //echo 'in web analytics plugin';
    }
}