<?php
class Zenfox_View_Helper_Metatags extends Zend_View_Helper_Abstract
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
	
	public function metatags()
	{
		$siteCode = Zend_Registry::getInstance()->get('siteCode');
		$fileName = APPLICATION_PATH . "/site_configs/" . $siteCode . "/metaTags.json";
		$fh = fopen($fileName, "r");
		$metaTagsJson = fread($fh, filesize(($fileName)));
		fclose($fh);
		try
		{
			$metaTagsArray = Zend_Json::decode($metaTagsJson);
			
			$frontend = Zend_Controller_Front::getInstance();
			$controller = $frontend->getRequest()->getControllerName();
			$action = $frontend->getRequest()->getActionName();
			
			$currentPage = $controller . '-' . $action;
			foreach($metaTagsArray as $pageAddress => $metaTags)
			{
				if($pageAddress == $currentPage)
				{
					foreach($metaTags as $name => $content)
					{
						?>
									<meta name = "<?php echo $name; ?>" content = "<?php echo $content; ?>" />
								<?php
							}
						}
					}
		}
		catch(Exception $e)
		{
		}
	}
}