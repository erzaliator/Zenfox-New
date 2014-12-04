<?php
/**
 * This file contains tests for Zenfox_Controller_Exception class which extends
 * Zenfox_Exception
 *
 * Long description for file (if any)...
 *
 * LICENSE:
 *
 * @category   Zenfox
 * @package    Zenfox_Controller
 * @subpackage -
 * @copyright  2009 Yaswanth Narvaneni
 * @license    License Link
 * @version    $Id:$
 * @since      File available since v 0.1
*/

require_once('TestHelper.php');
require_once('Zenfox/Controller/Exception.php');

/**
 * This class tests Zenfox_Controller_Exception
 *
 * Long description for class (if any)...
 *
 * @category   Zenfox
 * @package    Zenf_Controller
 * @subpackage -
 * @copyright  2009 Yaswanth Narvaneni
 * @since      Class available since v 0.1
 * @group      Controllers
 */

class Zenfox_Controller_ExceptionTest extends Zend_Test_PHPUnit_ControllerTestCase
{
    public function setUp()
    {

    }
    public function tearDown()
    {

    }

    public function testIsOfTypeZenfoxException()
    {
        $this->assertType('Zenfox_Exception', new Zenfox_Controller_Exception());
    }
}
