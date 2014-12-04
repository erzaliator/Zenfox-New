<?php
/**
 * This file contains Zenfox_Controller_Plugin_ModuleSelector class which extends
 * Zend_Controller_Plugin_Abstract. This is where the modules are decided are seperated.
 *
 * Long description for file (if any)...
 *
 * LICENSE:
 *
 * @category   Zenfox
 * @package    Zenfox_Plugin
 * @subpackage -
 * @copyright  2009 Yaswanth Narvaneni
 * @license    License Link
 * @version    $Id:$
 * @since      File available since v 0.1
*/

/**
 * This class extends Zend_Controller_Plugin_Abstract to give more flexibility
 *
 * Long description for class (if any)...
 *
 * @category   Zenfox
 * @package    Zenfox_Plugin
 * @subpackage -
 * @copyright  2009 Yaswanth Narvaneni
 * @since      Class available since v 0.1
 */

/*class Zenfox_Controller_Plugin_ModuleSelector extends Zend_Controller_Plugin_Abstract
{
    public function routeStartup(Zend_Controller_Request_Abstract $request)
    {
        /*
         * TODO::
         * 1. Check the URI
         * 2. Query the DB or MC for module??
         * 3. Set default module
         */
/*        $baseUri = $request->getBaseUri();
        print $baseUri;
*/
/*        $frontController = Zend_Controller_Front::getInstance();
        $frontController->setDefaultModule('player');
    }
}*/

class Zenfox_Resource_Moduleselector extends Zend_Application_Resource_ResourceAbstract
{
    const DEFAULT_REGISTRY_KEY = 'Moduleselector';
    private $_currentModule = '';
    public function init()
    {
        $options = $this->getOptions();
        $defaultModule = isset($options['defaultModule'])?$options['defaultModule']:'player';
        $frontController = Zend_Controller_Front::getInstance();
        $frontController->setDefaultModule($defaultModule);
    }
}

