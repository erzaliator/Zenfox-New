<?php

/*
 * This is not used!
 */

class Zenfox_Controller_Plugin_ErrorHandler extends Zend_Controller_Plugin_ErrorHandler //Zend_Controller_Plugin_Abstract
{
	const EXCEPTION_NO_ACCESS = 'EXCEPTION_NO_ACCESS';
	const EXCEPTION_INTERNAL_ERROR = 'EXCEPTION_INTERNAL_ERROR';
	const EXCEPTION_NO_CONTROLLER = 'EXCEPTION_NO_CONTROLLER';
	const EXCEPTION_NO_ACTION = 'EXCEPTION_NO_ACTION';
	const EXCEPTION_NOT_FOUND = 'EXCEPTION_NOT_FOUND';
	
    public function routeShutdown(Zend_Controller_Request_Abstract $request)
    {
        $frontController = Zend_Controller_Front::getInstance();

        //If the ErrorHandler plugin is not registered, bail out
        if( !($frontController->getPlugin('Zend_Controller_Plugin_ErrorHandler') instanceOf Zend_Controller_Plugin_ErrorHandler) )
            return;

        $error = $frontController->getPlugin('Zend_Controller_Plugin_ErrorHandler');

        //Generate a test request to use to determine if the error controller in our module exists
        $testRequest = new Zend_Controller_Request_HTTP();
        $testRequest->setModuleName($request->getModuleName())
                    ->setControllerName($error->getErrorHandlerController())
                    ->setActionName($error->getErrorHandlerAction());

        //Does the controller even exist?
        if( $frontController->getDispatcher()->isDispatchable($testRequest) )
        {
            $error = new Zend_Controller_Plugin_ErrorHandler();
           // $error->setErrorHandlerModule('player');
        }
    }
    
   /* public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
    	//Zenfox_Debug::dump($request, 'request');
    	$response = $this->getResponse();
    	$exceptions = $response->getException();
        $exception = $exceptions[0];
        $exceptionType = get_class($exception);
        if($exceptionType == 'Zenfox_Exception')
        {
        	//Zenfox_Debug::dump($exception, 'exception');
        	$error = new ArrayObject(array(), ArrayObject::ARRAY_AS_PROPS);
        	$error->exception = $exception;
        	$error->type = self::EXCEPTION_NO_ACCESS;
        	$error->request = clone $request;
        	$request->setParam('error_handler', $error);
        }
    }*/
    
    
   /* public function dispatchLoopStartup(Zend_Controller_Request_Abstract $request)
    {
    	$response = $this->getResponse();
    	$exceptions = $response->getException();
        $exception = $exceptions[0];
        $exceptionType = get_class($exception);
        if($exceptionType == 'Zenfox_Exception')
        {
        	//Zenfox_Debug::dump($exception, 'exception');
        	$error = new ArrayObject(array(), ArrayObject::ARRAY_AS_PROPS);
        	$error->exception = $exception;
        	$error->type = self::EXCEPTION_NO_ACCESS;
        	$error->request = clone $request;
        	$request->setParam('error_handler', $error);
        }
    }*/
    

    
    public function postDispatch(Zend_Controller_Request_Abstract $request)
    {
    	/*
    	$response = $this->getResponse();
        $exceptions = $response->getException();
        $exception = $exceptions[0];
        $exceptionType = get_class($exception);
        if($exceptionType == 'Zenfox_Exception')
        {
            //Zenfox_Debug::dump($exception, 'exception');
            $error = new ArrayObject(array(), ArrayObject::ARRAY_AS_PROPS);
            $error->exception = $exception;
            $error->type = self::EXCEPTION_NO_ACCESS;
            $error->request = clone $request;
            $request->setParam('error_handler', $error);
        }
    	*/
    	/*
    	if( ($this->getRequest()->getActionName() == 'error') && ($this->getRequest()->getControllerName() == 'error')) 
    	{
    		
    		Zend_Controller_Front::getInstance()->throwExceptions(true);
    		Zenfox_Debug::dump(null, "Returning my ass off with:: ". $this->getRequest()->getActionName() . " and " . $this->getRequest()->getControllerName);
    		return;
		}
		*/
    	if($this->_isInsideErrorHandlerLoop)
    	{
    		//Zenfox_Debug::dump(null, "Returning my ass off with:: ". $this->getRequest()->getActionName() . " and " . $this->getRequest()->getControllerName);
    		Zend_Controller_Front::getInstance()->throwExceptions(true);
    		return;
    	}
    	
    	$response = $this->getResponse();
    	$exceptions = $response->getException();

    	if(is_array($exceptions)  && !empty($exceptions))
    	{
	        $exception = $exceptions[0];
	        $exceptionType = get_class($exception);
	        Zenfox_Debug::dump($exception->getCode(), 'exceptionCode');
	        
	        if($exceptionType == 'Zenfox_Exception')
	        {
	        	$error = new ArrayObject(array(), ArrayObject::ARRAY_AS_PROPS);
	        	$error->exception = $exception;
	        	$error->type = self::EXCEPTION_INTERNAL_ERROR;
	        	$error->request = clone $request;
	        	$request->setParam('error_handler', $error);
	        }
	        if($exceptionType == 'Zenfox_Acl_Exception' || $exceptionType == 'Zend_Acl_Exception')
	        {
		       	//Zenfox_Debug::dump($exception->getCode(), 'exceptionCode');
	        	$error = new ArrayObject(array(), ArrayObject::ARRAY_AS_PROPS);
	        	$error->exception = $exception;
	        	switch ($exception->getCode())
	        	{
	        		case 500:
	        			$error->type = self::EXCEPTION_INTERNAL_ERROR;
	        			break;
	        		case 403:
	        			$error->type = self::EXCEPTION_NO_ACCESS;
	        			break;
	        		case 404:
	        			$error->type = self::EXCEPTION_NOT_FOUND;
	        			break;
	        		default:
	        			$error->type = self::EXCEPTION_INTERNAL_ERROR;
	        			break;
	        	}
	        	
	        	$error->request = clone $request;
	        	$request->setParam('error_handler', $error);
	        }
    	}
    	
    }
}

