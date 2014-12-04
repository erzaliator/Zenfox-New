<?php
/**
 * This file contains tests for Zenfox_Resource_Exception class which extends
 * Zenfox_Exception.
 *
 * Zenfox_Resource related exception class
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

require_once('TestHelper.php');
require_once("Zenfox/Resource/Exception.php");
/**
 * Test class for Zenfox_Resource_Exception
 *
 * Long description for class (if any)...
 *
 * @category   Zenfox
 * @package    Zenfox_Resource
 * @subpackage -
 * @copyright  2009 Yaswanth Narvaneni
 * @since      Class available since v 0.1
 * @group      Libraries
 */
class Zenfox_Resource_ExceptionTest extends Zend_Test_PHPUnit_ControllerTestCase
{
    public function setUp()
    {

    }

    public function tearDown()
    {

    }

    public function testExceptionType()
    {
        $this->assertType('Zenfox_Exception', new Zenfox_Resource_Exception);
    }

}
