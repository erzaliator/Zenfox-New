<?php
/**
 * This file contains Zenfox_Resource_Locale class which extends
 * Zend_Application_Resource_ResourceAbstract. This class is used to
 * add Doctrine resource to the Bootstrap. Everything that is related to
 * Doctrine initialization is written here.
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
 * This class is used to add Locale resource/info to the Bootstrap.
 * Everything that is related to Locale is written here.
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
class Zenfox_Resource_Locale extends Zend_Application_Resource_ResourceAbstract
{
    const DEFAULT_REGISTRY_KEY = 'Locale';
    public function init()
    {
        $options = $this->getOptions();
        //TODO:: Write a function to get locale here
        $options['defaultLocale'] = isset($options['defaultLocale'])?$options['defaultLocale']:'en_GB';
        $locale = new Zend_Locale($options['defaultLocale']);
        $registry = Zend_Registry::getInstance();
        $registry->set('Zend_Locale', $locale);
    }
}