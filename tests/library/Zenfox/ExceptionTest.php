<?php
/**
 * This file contains tests for the base Exception Class for Project Zenfox
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
require_once("Zenfox/Exception.php");

/**
 * This the test for the base Exception class for Project Zenfox.
 *
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

class Zenfox_ExceptionTest extends Zend_Test_PHPUnit_ControllerTestCase
{
    public function setUp()
    {

    }

    public function tearDown()
    {

    }

    public function testExceptionType()
    {
        $this->assertType('Exception', new Zenfox_Exception);
    }

}