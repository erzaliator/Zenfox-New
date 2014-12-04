<?php

//class IndexController extends Zend_Controller_Action
//require_once('Zenfox/BridgeController.php');
class Affiliate_IndexController extends Zenfox_Controller_Action
{

    public function init()
    {
        //FIXME:: This has to be called all the time. There should be a way to fix it.
        parent::init();

        /* Initialize action controller here */
        //$this->view->message = $this->view->translate("This is the affiliate website");
        //$this->_helper->FlashMessenger(array('notice' => $this->view->translate("This is the affiliate website")));
        $frontController = Zend_Controller_Front::getInstance();
		$zenfoxRefererTrackerPlugin = new Zenfox_Controller_Plugin_RefererTracker();
		$frontController->registerPlugin($zenfoxRefererTrackerPlugin,500);
    }

    public function indexAction()
    {
    	Zend_Layout::getMvcInstance()->setLayout('layout_front');
    	$frontendId = Zend_Registry::get('frontendId');
    	
    	$affiliateFrontend = new AffiliateFrontend();
    	$affiliateFrontendData = $affiliateFrontend->getAffiliateFrontendById($frontendId);
    	$schemeId = $affiliateFrontendData['default_affiliate_scheme_id'];
    	
    	$schemeDef = new AffiliateSchemeDef();
    	$schemeDefData = $schemeDef->getAffiliateSchemeDef($schemeId);
    	
    	$affiliateScheme = new AffiliateScheme();
		$schemeName = $affiliateScheme->getSchemeName($schemeId);
    	    	
    	$this->view->contents = $schemeDefData;
    	$this->view->schemeName = $schemeName;
        // action body
    }

}

