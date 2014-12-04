<?php
/**
 * This file contains the test environment bootstrap.
 * Typically a copy of public/index.php
 *
 *
 * Long description for file (if any)...
 *
 * LICENSE:
 *
 * @subpackage -
 * @copyright  2009 Yaswanth Narvaneni
 * @license    License Link
 * @since      File available since v 0.1
*/

// Copy of index.php -- Start
// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'development'));

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


// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);

Zend_Session::$_unitTestEnabled = true;
Zend_Session::start();
$application->bootstrap();
