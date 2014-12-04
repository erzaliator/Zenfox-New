<?php
class Zenfox_Controller_Plugin_WebAnalytics extends Zend_Controller_Plugin_Abstract {
	public function postDispatch() 
	{
		$siteCode = Zend_Registry::getInstance ()->get ( 'siteCode' );
		$view = Zend_Layout::getMvcInstance()->getView();
		$view->addHelperPath ("Zenfox/View/Helper", "Zenfox_View_Helper");
	
		if (file_exists ( APPLICATION_PATH . '/site_configs/' . $siteCode . '/googleAnalytics.json' )) 
		{
			$analytics = $this->googleAnalytics($siteCode);
			$trackerId = $analytics->getTrackerId();
	
			//$view->googleAnalytics($trackerId);

			//Zend_Layout::getMvcInstance()->setView($view);
		}
		/*if(Zend_Registry::get('piwikEnabled'))
		{
			echo $view->piwiktracker();
		}*/
		$viewRenderer = new Zend_Controller_Action_Helper_ViewRenderer();
		$viewRenderer->setView($view);
		Zend_Controller_Action_HelperBroker::addHelper($viewRenderer);
	}
	
	public function googleAnalytics($siteCode) {
		
		$siteConfigFile = APPLICATION_PATH . '/site_configs/' . $siteCode . '/googleAnalytics.json';
		$fh = fopen ( $siteConfigFile, 'r' );
		$siteJson = fread ( $fh, filesize ( $siteConfigFile ) );
		fclose ( $fh );
		//print $frontendJson;
		$siteConfig = Zend_Json::decode ( $siteJson );
		
		$accountId = $siteConfig ['accountId'];
		$trackerId = $siteConfig ['trackerId'];
		
		$params = array ('ga' => $accountId, 'trackerId' => $trackerId );
		try 
		{
			$analytics = new Zenfox_WebAnalytics_GoogleAnalytics ( $params );
		} 
		catch ( Exception $e ) 
		{
			echo $e->getMessage ();
		}
		
		return $analytics;
	}
}