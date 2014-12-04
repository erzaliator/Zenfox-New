<?php
/**
 * This file contains Zenfox_Resource_Datetime class which extends
 * Zend_Application_Resource_ResourceAbstract. This class is used to
 * initialize date time and time related issues in the Bootstrap.
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
 * This class is used to initialize date time and time related issues in
 * the Bootstrap.
 *
 * Long description for class (if any)...
 *
 * @category   Zenfox
 * @package    Zenfox_Resource
 * @subpackage -
 * @copyright  2009 Yaswanth Narvaneni
 * @since      Class available since v 0.1
 */
class Zenfox_Resource_Timezone extends Zend_Application_Resource_ResourceAbstract
{
    public function init()
    {
        $options = $this->getOptions();
        date_default_timezone_set($options['defaultTimeZone']);
        Zend_Registry::getInstance()->set('serverTimeZone', $options['defaultTimeZone']);
        Zend_Registry::getInstance()->set('userTimeZone', $options['defaultTimeZone']);
    }
}