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

require_once ('TestHelper.php');
require_once('Zenfox/Resource/Logger.php');

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
 * @group      Libraries
 * @group      Initialization
 */

class Zenfox_Resource_LoggerTest extends Zend_Test_PHPUnit_ControllerTestCase
{
    private $_logger;

    public function setUp()
    {
        $loggerResource = new Zenfox_Resource_Logger;
        $this->_logger = $loggerResource->init();
    }

    public function testLoggerIsSet()
    {
        $this->assertTrue(isset($this->_logger));
    }

    public function tearDown()
    {
        unset($this->_logger);
    }


}