<?php
/*
function microtime_float()
{
    list($utime, $time) = explode(" ", microtime());
    return ((float)$utime + (float)$time);
}

$script_start = microtime_float();
*/

define('APPLICATION_ENV', 'development');

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'development')); 
//define('APPLICATION_ENV', 'production');
//Set Defaults
date_default_timezone_set('Europe/London');

// Ensure library/ is on include_path
// No need to include Zenfox as its in /library!
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    realpath(APPLICATION_PATH. '/../library/zendframework'),
    realpath(APPLICATION_PATH. '/../library/doctrine'),
    realpath(APPLICATION_PATH. '/models'),
    realpath(APPLICATION_PATH. '/models/generated'),
    get_include_path(),
)));


/** Zend_Application **/
require_once 'Zend/Application.php';
require_once 'Zend/Loader/Autoloader.php';
$autoloader = Zend_Loader_Autoloader::getInstance();
$autoloader->registerNamespace('Zenfox');

/*
 * PIWIK Variables
 */
/*
define('PIWIK_INCLUDE_PATH', realpath(dirname(__FILE__) . '../piwik');
define('PIWIK_ENABLE_DISPATCH', false);
define('PIWIK_ENABLE_ERROR_HANDLER', false);
define('PIWIK_ENABLE_SESSION_START', false);


//Including Piwik
require_once PIWIK_INCLUDE_PATH . "/index.php";
Piwik_FrontController::getInstance()->init();
*/
// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);

try
{
	$bootstrap = $application->bootstrap();
	
   	$front   = Zend_Controller_Front::getInstance();
        $default = $front->getDefaultModule();
        if (null === $front->getControllerDirectory($default)) {
            throw new Zend_Application_Bootstrap_Exception(
                'No default controller directory registered with front controller'
            );
        }

     $front->setParam('bootstrap', $bootstrap);
     $front->returnResponse(true);
     
     $response = $front->dispatch();
     
     if($response->isException())
     {
     		$exceptions = $response->getException();
     		
     		//Zenfox_Debug::dump($exceptions, "Dumping Exceptions", true, true);
     }

    $response->sendHeaders();
    $response->outputBody();
}
catch (Exception $e)
{

	if(APPLICATION_ENV == 'development')
	{
		Zenfox_Debug::dump(get_class($e), "Class:: ");
		Zenfox_Debug::dump($e->getMessage(), "Exception");
	}
	
	$controller = $front->getRequest()->getControllerName();
	$action = $front->getRequest()->getActionName();
	$pageAddress = $controller . '-' . $action;
	if($pageAddress != 'auth-level')
	{
		?>
	  <style type="text/css">
	    div.dialog {
	      width: 25em;
	      padding: 0 4em;
	      margin: 4em auto 0 auto;
	      border: 1px solid #ccc;
	      border-right-color: #999;
	      border-bottom-color: #999;
	    }
	  </style>
	  <div class="dialog"> 
	    <h1>We're sorry, but something went wrong.</h1> 
	    <p>We've been notified about this issue and we'll take a look at it shortly.</p> 
	  </div> 
		<?php
	}
}

//$script_end = microtime_float();
//echo "Script executed in ".bcsub($script_end, $script_start, 4)." seconds. Trace File:: " . xdebug_get_tracefile_name();
            
