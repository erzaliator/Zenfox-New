<?php
/**
 * This file contains tests for Zenfox_Controller_Plugin_FrontendSelector
 *
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
 *
*/

require_once ('TestHelper.php');
require_once("Zenfox/Controller/Plugin/FrontendSelector.php");
/**
 * This file contains tests for Zenfox_Controller_Plugin_FrontendSelector
 *
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
 * @group      Plugins
 */

class Zenfox_Controller_Plugin_FrontendSelectorTest extends PHPUnit_Framework_TestCase
{
    private $_frontendController;
    /**
     * Prepares the environment before running a test.
     */
    protected function setUp ()
    {
        /*
         * TODO:: Create a Request Object and send it to Zenfox_Controller_Plugin
         */
        $httpRequest = new Zend_Controller_Request_Http();
        $httpRequest->setBaseUrl('http://127.0.0.1');
        $this->_frontendController = new Zenfox_Controller_Plugin_FrontendSelector();
        $this->_frontendController->preDispatch($httpRequest);
        parent::setUp();
        // TODO Auto-generated Zenfox_Controller_Plugin_FrontendControlTest::setUp()
    }
    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown ()
    {
        // TODO Auto-generated Zenfox_Controller_Plugin_FrontendControlTest::tearDown()
        parent::tearDown();
    }
    /**
     * Constructs the test case.
     */
    public function __construct ()
    {    // TODO Auto-generated constructor
    }

    public function testToDo()
    {
        print "\nTODO:: Tests need to be written in Zenfox_Controller_Plugin_FrontendSelector";
    }

    public function testDefaultFrontendSetInZendRegistry()
    {
        $frontend = Zend_Registry::get('frontend');
        $this->assertArrayHasKey('url', $frontend);
        $this->assertArrayHasKey('id', $frontend);
    }
}