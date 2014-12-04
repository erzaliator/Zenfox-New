<?php
/**
 * This file contains tests for Zenfox_Resource_Currency class which extends
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

require_once ('TestHelper.php');
require_once ('Zenfox/Resource/Currency.php');

/**
 * This class test Zenfox_Resource_Currency.
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
 * @group      Libraries
 * @group      Initialization
 */

class Zenfox_Resource_CurrencyTest extends Zend_Test_PHPUnit_ControllerTestCase
{
    private $_currency;

    public function setUp()
    {
    }

    public function tearDown()
    {
        unset($this->_currency);
    }

    public function testIsCurrencySet()
    {
        $this->_currency = new Zenfox_Resource_Currency();
        $this->_currency->init();
        $currentLocale = $this->_currency->getCurrentLocale();
        $this->assertTrue(isset($currentLocale));
    }
}
