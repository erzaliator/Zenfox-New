<?php
/**
 * This file contains Zenfox_Resource_Moduleselector class which extends
 * Zend_Application_Resource_ResourceAbstract. This is where the modules are decided are seperated.
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
 * This class extends Zend_Application_Resource_ResourceAbstract to give more flexibility
 * in choosing modules
 *
 * Long description for class (if any)...
 *
 * @category   Zenfox
 * @package    Zenfox_Plugin
 * @subpackage -
 * @copyright  2009 Yaswanth Narvaneni
 * @since      Class available since v 0.1
 */

/*
 * TODO:: Move this from Zenfox_Resource to Zenfox_Controller_Plugin.
 * 
 */

class Zenfox_Resource_Moduleselector extends Zend_Application_Resource_ResourceAbstract
{
    const DEFAULT_REGISTRY_KEY = 'Moduleselector';
    private $_currentModule = '';
    public function init()
    {
    	
    	/*
    	 * To set the default module according to the link
    	 */
     //   $options = $this->getOptions();
     //   $defaultModule = isset($options['defaultModule'])?$options['defaultModule']:'player';
        /*
         * Done
         * TODO:: Make a hashmap to decide which module to be selected
         * depending on the URL.
         * E.g: affiliate.sitename.com should point to /affiliate module
         * The default module finding will be done anyways i.e., sitename.com/affiliate
         * will set default module in Zend_Registry as player. But at the same time
         * $request (refer frontendselectr) will return currentModule as 'affiliate'
         *
         * So affiliate.sitename.com, someaffiliates.com, sitename.com/affiliate
         * will all point to affiliate module.
         */
   //     $this->_currentModule = $defaultModule;
   		$this->_currentModule = Zend_Registry::getInstance()->get('defaultModule');
        $frontController = Zend_Controller_Front::getInstance();
        $frontController->setDefaultModule($this->_currentModule);

        $registry = Zend_Registry::getInstance();
        $registry->set('defaultModule', $this->_currentModule);
        //print_r($registry->get('doctrine_config'));

        return $this->_currentModule;
    }
}

