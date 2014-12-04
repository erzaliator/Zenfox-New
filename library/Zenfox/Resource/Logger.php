<?php
/**
 * This file contains Zenfox_Resource_Logger class which extends
 * Zend_Application_Resource_ResourceAbstract.
 * This creates an instance of Zenfox_Resource_Logger and returns it to the App's Bootstrap
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
 * This class extends Zend_Application_Resource_ResourceAbstract.
 * This creates an instance of Zenfox_Resource_Logger and returns
 * it to the App's Bootstrap
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


class Zenfox_Resource_Logger extends Zend_Application_Resource_ResourceAbstract
{
    const DEFAULT_REGISTRY_KEY = 'Logger';
    protected $logger;

    public function init()
    {
        return $this->getLogger();
    }

    public function getLogger()
    {
        $options = $this->getOptions();
        $this->logger = new Zenfox_Logger($options);
        return $this->logger;
    }
}