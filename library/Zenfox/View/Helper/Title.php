<?php
class Zenfox_View_Helper_Title extends Zend_View_Helper_Abstract
{
	/**
	 * @var Zend_View_Instance
	 */
	public $view;

	/**
	 * Set view object
	 *
	 * @param  Zend_View_Interface $view
	 * @return Zend_View_Helper_Form
	 */
	public function setView(Zend_View_Interface $view)
	{
		$this->view = $view;
	}
	
	public function title()
	{
		$siteCode = Zend_Registry::getInstance()->get('siteCode');
		$fileName = APPLICATION_PATH . "/site_configs/" . $siteCode . "/titles.json";
		$fh = fopen($fileName, "r");
		$titlesJson = fread($fh, filesize(($fileName)));
		fclose($fh);
		
		try
		{
			$titlesArray = Zend_Json::decode($titlesJson);
				
			$frontend = Zend_Controller_Front::getInstance();
			
			$params = $frontend->getRequest()->getParams();
			$paramString = "";
			foreach($params as $name => $value)
			{
				if($name != 'controller' && $name != 'action' && $name != 'module')
				{
					$paramString .= $name . ":" . $value . "|";
				}
			}
			
			$controller = $frontend->getRequest()->getControllerName();
			$action = $frontend->getRequest()->getActionName();
				
			$currentPage = $controller . '-' . $action;
			$pageFound = false;
			foreach($titlesArray as $pageAddress => $title)
			{
				if($pageAddress == $currentPage)
				{
					$pageFound = true;
					?>
						<title><?=$title['title'] . "|" . $paramString ?></title>
						<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
						<meta name = "keywords" content = "Play Game Of Rummy Online, 13 Cards Indian Classic Rummy-Play Now & Win Cash Prizes, Free Rummy Game Online" />
						<meta name = "description" content ="<?=$title['title'] ?>" />
					<?php
				}
			}
			if(!$pageFound)
			{
				$frontendName = Zend_Registry::get('frontendName');
				if($frontendName == 'bingocrush.co.uk')
				{
					?>
						<title>Play Free Online Bingo, Slots, Roulette, Keno at Bingocrush.co.uk | Free Casino Games Online</title>
					<?php 
				}
				else
				{
					?>
						<title>Online Rummy</title>
					<?php
				}
			}
		}
		catch(Exception $e)
		{
		}
	}
}