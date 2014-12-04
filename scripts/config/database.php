<?php
$db = array();
// Create dsn from the info above
/*$db['default']['dsn'] = 'mysql' .
                        '://' . 'root' .
                        ':' . 'msandbox' .
                        '@' . '127.0.0.1:3307' .
                        '/' . 'zenfox';
*/
//Local Database

$db['default']['dsn'] = 'mysql' .
                        '://' . 'root' .
                        ':' . 'kaveri' .
                        '@' . 'localhost' .
                        '/' . 'gamification';


// Require Doctrine.php
require_once(realpath(dirname(__FILE__) . '/../../library') . DIRECTORY_SEPARATOR . 'doctrine/Doctrine.php');

// Set the autoloader
spl_autoload_register(array('Doctrine', 'autoload'));

$manager = Doctrine_Manager::getInstance();
$manager->setAttribute(Doctrine::ATTR_MODEL_LOADING, Doctrine::MODEL_LOADING_CONSERVATIVE);

// Load the Doctrine connection
Doctrine_Manager::connection($db['default']['dsn'], 'zenfox');

// Load the models for the autoloader
Doctrine::loadModels(realpath(dirname(__FILE__) . '/../../application') . DIRECTORY_SEPARATOR . 'models'); 
