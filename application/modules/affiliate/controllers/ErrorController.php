<?php
class Affiliate_ErrorController extends Zenfox_Controller_Action
{
    public function init()
    {
        //FIXME:: This has to be called all the time. There should be a way to fix it.
        parent::init();
    }
    public function indexAction()
    {
    	//$this->_redirect('error/error');
    }
    public function errorAction()
    {
        $errors = $this->_getParam('error_handler');
        //Zenfox_Debug::dump($errors, 'These are the errors', true, false);
        //$this->_redirect('auth/login');
        //Zenfox_Debug::dump($errors->exception->getCode(), "Error Code");
        
        if($errors->exception->getCode())
        {
	        switch ($errors->exception->getCode()) {
	            /*case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
	            	//$this->_forward('pageNotFound');
	            	$this->pageNotFoundAction();
	                break;
	            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
	                // 404 error -- controller or action not found
	                //$this->_forward('pageNotFound');
	                $this->pageNotFoundAction();
	                break;
	            case Zenfox_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACCESS:
	                //$this->_forward('noAccess');
	                $this->noAccessAction();            	            	
	            	break;
	            case Zenfox_Controller_Plugin_ErrorHandler::EXCEPTION_NOT_FOUND:
	            	//$this->_forward('pageNotFound');
	            	$this->pageNotFoundAction();
	            	break;
	            case Zenfox_Controller_Plugin_ErrorHandler::EXCEPTION_INTERNAL_ERROR:
	            	//$this->_forward('internalError');
	            	$this->internalErrorAction();
	            	break;
	            default:
	                // application error
	                //$this->_forward('genericError');
	                $this->genericErrorAction();
	                break;*/
	        	
	        	case 404:
	            	//$this->_forward('pageNotFound');
	            	$this->pageNotFoundAction();
	                break;
	            case 401:
	                //$this->_forward('noAccess');
	                $this->noAccessAction();            	            	
	            	break;
	            case 403:
	            	//$this->_forward('pageNotFound');
	            	$this->noAccessAction();
	            	break;
	            case 503:
	            	//$this->_forward('internalError');
	            	$this->internalErrorAction();
	            	break;
	            default:
	                // application error
	                //$this->_forward('genericError');
	                $this->genericErrorAction();
	                break;
	        }
	        
        }
        
        

        $this->view->exception = $errors->exception;
		$this->view->request   = $errors->request;
		
		$this->getResponse()->clearBody();
		
		$this->getRequest()->setParam('error_handler', null);
	}
	
	public function outAction()
	{
		
	}
	
	public function pageNotFoundAction()
	{
		//Zenfox_Debug::dump('', "In Page Not Found Action");
		$this->getResponse()->setHttpResponseCode(404);
        //$this->view->message = $this->view->translate('Page not found');
        $this->_helper->FlashMessenger(array('error' => $this->view->translate("I can not find the page you are looking for.<br> Why don't you start from our <a href=\"/game/index\">games page</a>?")));
        
        //$this->getRequest()->setControllerName('index');
        //$this->getRequest()->setActionName('index');
	}
	
	public function noAccessAction()
	{
		//Zenfox_Debug::dump('', "In No Access Action");
		$this->getResponse()->setHttpResponseCode(401);
        //$this->view->message = $this->view->translate('Access Denied!!!');
        $this->_helper->FlashMessenger(array('error' => $this->view->translate("Hmm, you seem to entering an unauthorized zone.<br> Why don't you <a href=\"/game/index\">login</a> and try? ")));
        
        //$this->getRequest()->setControllerName('index');
        //$this->getRequest()->setActionName('index');
	}
	
	public function internalErrorAction()
	{
		//Zenfox_Debug::dump('', "In Internal Error Action");
        $this->getResponse()->setHttpResponseCode(500);
        //$this->view->message = $this->view->translate('Intenal Application Error!');
        $this->_helper->FlashMessenger(array('error' => $this->view->translate("Oops, this looks like a minor technical glitch from our side, we are working on it.<br> Mean while, why don't you enjoy our <a href=\"/game/index\">games</a>?")));

        //$this->getRequest()->setControllerName('index');
        //$this->getRequest()->setActionName('index');
	}
	
	public function genericErrorAction()
	{
		//Zenfox_Debug::dump('', "In Generic Error Action");
		$this->getResponse()->setHttpResponseCode(500);
        //$this->view->message = $this->view->translate('Internal Application Error');
        $this->_helper->FlashMessenger(array('error' => $this->view->translate("Err, something is wrong, we are working on it.<br> Mean while, why don't you enjoy our <a href=\"/game/index\">games</a>?")));
        
        //$this->getRequest()->setControllerName('index');
        //$this->getRequest()->setActionName('index');
	}
}
