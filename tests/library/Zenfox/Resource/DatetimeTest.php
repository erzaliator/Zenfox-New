<?php
/**
 * This file contains test cases for Zenfox_Resource_Datetime class which extends
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

require_once ('TestHelper.php');
require_once ('Zenfox/Resource/Datetime.php');

/**
 * This class test Zenfox_Resource_Datetime.
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
 * @group      Libraries
 * @group      Initialization
 *
 */

class Zenfox_Resource_DatetimeTest extends Zend_Test_PHPUnit_ControllerTestCase
{
    private $_datetime;

    public function setUp()
    {
    }

    public function tearDown()
    {
        unset($this->_datetime);
    }
    public function testIsTimeActive()
    {
        $this->_datetime = new Zenfox_Resource_Datetime();
        //This should initialize default timezone and timeservers
        $dateObj = $this->_datetime->init();
        //Compare PHP native and Zend_Date times
        //FIXME:: This could be an issue.
        $this->assertGreaterThanOrEqual(time(), $dateObj->get());
    }
}
