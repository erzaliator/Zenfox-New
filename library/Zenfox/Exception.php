<?php
/**
 * This file contains the base Exception Class for Project Zenfox
 *
 * Long description for file (if any)...
 *
 * LICENSE:
 *
 * @category   Zenfox
 * @package    Zenfox_Resource
 * @subpackage -
 * @copyright  2009 Yaswanth Narvaneni
 * @license    License Link
 * @since      File available since v 0.1
*/

/**
 * This the base Exception class for Project Zenfox. All Zenfox related
 * Exceptions has to extend this class.
 *
 *
 * Long description for class (if any)...
 *
 * @category   Zenfox
 * @package    Zenfox_Resource
 * @subpackage -
 * @copyright  2009 Yaswanth Narvaneni
 * @since      Class available since v 0.1
 */

require_once( APPLICATION_PATH ."/modules/player/controllers/ErrorController.php");

class Zenfox_Exception extends Zend_Exception
{
//	const EXCEPTION_NO_ACCESS = 'EXCEPTION_NO_ACCESS';
	private $_message;
	public function __construct($message = '', $code = 0, Exception $previous = null)
	{
		
		//print('message - ' . $message);
		parent::__construct($message, $code, $previous);
		$this->_message = $message;
		
		$frontController = Zend_Controller_Front::getInstance();
		/*if(!$frontController->hasPlugin("Zenfox_Controller_Plugin_ErrorHandler"))
		{
			$frontController->registerPlugin( new Zenfox_Controller_Plugin_ErrorHandler(), 400);
		}*/
		
		/*$controller = Zend_Controller_Front::getInstance();
			//$controller->getPlugin('Zenfox_Controller_Plugin_ErrorHandler');
			$request = $controller->getRequest();
			$response = $controller->getResponse();
			if($response->isException())
			{
				print("Hello");
			}
			$error = new ArrayObject(array(), ArrayObject::ARRAY_AS_PROPS);
			//Zenfox_Debug::dump($response->getException(), 'ex');
        	$error->exception = $response->getException();
        	$error->type = self::EXCEPTION_NO_ACCESS;
        	//print($error->type);
        	//Zenfox_Debug::dump($request->getParams(), 'request');
        	$error->request = clone $request;
        	//Zenfox_Debug::dump($error->request, 'request');
        	$request->setParam('error_handler', $error);*/

			//$request->setParam('error_handler', $this->_message);

/*			$request->setControllerName('error');
			$request->setActionName('error');
//			$errorController = new Player_ErrorController($request,$response);
//			$errorController->dispatch('errorAction');
/*		$controller = Zend_Controller_Front::getInstance();
//		$controller->getPlugin('Zenfox_Controller_Plugin_ErrorHandler');
		$request = $controller->getRequest();
		$response = $controller->getResponse();
    	$exceptions = $response->getException();
        $exception = $exceptions[0];
        Zenfox_Debug::dump($exception, 'exception');
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
		$request->setParam('error_handler', $this->_message);
//		$request->setControllerName('error');
//		$request->setActionName('error');
		$errorController = new Player_ErrorController($request,$response);
		$errorController->dispatch('indexAction');*/
	}
	
	public function __call($method, array $args)
	{
		
	}
	
	public function __toString()
	{
		
		
			/*$controller = Zend_Controller_Front::getInstance();
			$controller->getPlugin('Zenfox_Controller_Plugin_ErrorHandler');
			$request = $controller->getRequest();
			$response = $controller->getResponse();
			$error = new ArrayObject(array(), ArrayObject::ARRAY_AS_PROPS);
        	//$error->exception = $this->_message;
        	$error->type = self::EXCEPTION_NO_ACCESS;
        	//Zenfox_Debug::dump($request->getParams(), 'request');
        	$error->request = clone $request;
        	//Zenfox_Debug::dump($error->request, 'request');
        	$request->setParam('error_handler', $error);
//			$request->setParam('error_handler', $this->_message);
//			$request->setControllerName('error');
//			$request->setActionName('error');
			$errorController = new Player_ErrorController($request,$response);
			$errorController->dispatch('errorAction');*/
		
		
		return $this->_message;
	}
	
	protected function _getPrevious()
    {
        return $this->_previous;
    }
}
