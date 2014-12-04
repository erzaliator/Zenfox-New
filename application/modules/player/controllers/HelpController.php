<?php
require_once ('facebook-php-sdk/src/facebook.php');
class Player_HelpController extends Zenfox_Controller_Action
{
	private $_help;
	private $_helpData;
	public function init()
	{
		//Zend_Layout::getMvcInstance()->disableLayout();
		$this->_help = new Help();
		$this->_helpData = $this->_help->getCompleteData();
	}
	public function indexAction()
	{
		//Zenfox_Debug::dump($this->_helpData, 'data', true, true);
		$front = Zend_Controller_Front::getInstance()->getRequest();
		$module = $front->getModuleName();
		$controller = $front->getControllerName();
		$action = $front->getActionName();
		$pageAddress = $module . '-' . $controller . '-' . $action;
		$helpContent = $this->_help->getDatabyPage($pageAddress);
		$this->view->helpContent = $helpContent;
		$this->view->data = $this->_helpData;
		$this->view->noIndex = false;
		if(($controller == 'help') && ($action == 'index'))
		{
			$this->view->noIndex = true;
		}
	}
	
	public function displayAction()
	{
		$id = $this->getRequest()->id;
		$temp = $this->getRequest()->temp;
		$helpContent = $this->_help->getDataById($id);
		$this->view->showLinks = $temp;
		$this->view->helpContent = $helpContent;
		$this->view->data = $this->_helpData;
		$this->view->helpTableId = $id;
	}
	
	public function howtoplayAction()
	{
		
		$siteCode = Zend_Registry::get('siteCode');
		$facebookFile = APPLICATION_PATH . '/site_configs/' . $siteCode . '/facebook.json';
		$fh = fopen($facebookFile, 'r');
		$facebookKeyJson = fread($fh, filesize($facebookFile));
		fclose($fh);
		$this->_facebookConfig = Zend_Json::decode($facebookKeyJson);
		
		$this->_appName = $this->_facebookConfig['application']['appName'];
		$this->_appId = $this->_facebookConfig['application']['appId'];
		$this->_appApikey = $this->_facebookConfig['application']['apiKey'];
		$this->_appSecret = $this->_facebookConfig['application']['secret'];
		
		$this->_facebook = new Facebook(array(
							  'appId'  => $this->_appId,
							  'secret' => $this->_appSecret,
							  'cookie' => true,
		));
			
		//$this->_facebookSession = $this->_facebook->getSession();
		$this->_facebookUserId = $this->_facebook->getUser();
		Zenfox_Debug::dump($this->_facebookUserId, uid);
		$this->_accessToken = $this->_facebook->getAccessToken();
		
		$isFan = file_get_contents("https://api.facebook.com/method/pages.isFan?format=json&uid=" . $this->_facebookUserId ."&access_token=" . $this->_accessToken . "&page_id=626757937368522");
		echo "https://api.facebook.com/method/pages.isFan?format=json&uid=" . $this->_facebookUserId ."&access_token=" . $this->_accessToken . "&page_id=626757937368522";
		Zenfox_Debug::dump($isFan, 'fan');
		
		//Zend_Layout::getMvcInstance()->disableLayout();
		$page = $this->getRequest()->page;
		$this->view->confirm = false;
		if(isset($page))
		{
			$this->view->confirm = true;
		}
	}
}