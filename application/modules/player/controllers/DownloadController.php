<?php
class Player_DownloadController extends Zenfox_Controller_Action
{
	public function indexAction()
	{
		$webConfig = Zend_Registry::getInstance()->isRegistered('webConfig')?Zend_Registry::getInstance()->get('webConfig'):'';
		//$this->view->cdnImageServer = $webConfig['cdnImageServer'];
		$this->view->cdnImageServer = "http://taashtime.com";
		$downloadFileName = "TaashTime.air";
		if(strpos($_SERVER['HTTP_USER_AGENT'], 'Window'))
		{
			$downloadFileName = "TaashTime.exe";
		}
		$this->view->fileName = $downloadFileName;
	}
	
	public function mobileAction()
	{
		$webConfig = Zend_Registry::getInstance()->isRegistered('webConfig')?Zend_Registry::getInstance()->get('webConfig'):'';
		//$this->view->cdnImageServer = $webConfig['cdnImageServer'];
		$this->view->cdnImageServer = "http://taashtime.com";
		
		$this->view->fileName = "TaashTime.apk";
	}
}