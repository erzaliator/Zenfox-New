<?php
/**
 * This file contains Zenfox_Resource_Currency class which extends
 * Zend_Application_Resource_ResourceAbstract. This class is used to
 * add a resource object to the Bootstrap. Everything that is related to
 * Currency is extended here.
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
 * This class is used to add a resource object to the Bootstrap.
 * Everything that is related to Currency is extended here.
 *
 * Long description for class (if any)...
 *
 * @category   Zenfox
 * @package    Zenfox_Resource
 * @subpackage -
 * @copyright  2009 Yaswanth Narvaneni
 * @since      Class available since v 0.1
 */
class Zenfox_Resource_Currency extends Zend_Application_Resource_ResourceAbstract
{
    const DEFAULT_REGISTRY_KEY = 'Currency';
    private $_currentLocale;

    public function init()
    {
        /*
         * TODO:: Get the User's default currency and sites default currecy
         * and set it here.
        */

        $options = $this->getOptions();

        /*
         * Note that Zend_Currency only accepts locales which include a region.
         * This means that all given locale which only include the language
         * will throw an exception. For example the locale 'en' will throw an
         * exception whereas the locale 'en_US' will return 'USD' as currency.
         */

        $locale = isset($options['defaultCurrency'])?$options['defaultCurrency']:'en_GB';
        $this->_currentLocale = $locale;
        $currency = new Zend_Currency($locale);

        //TODO:: This has to be improved according to user settings;

        return $currency;
    }

    public function getCurrentLocale()
    {
        return $this->_currentLocale;
    }
}