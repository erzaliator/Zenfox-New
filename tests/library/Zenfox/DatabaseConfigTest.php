<?php
/**
 * This file contains tests for Zenfox_DatabaseConfig
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
require_once("Zenfox/DatabaseConfig.php");
/**
 * This class Tests the Zenfox_DatabaseConfig.
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
 */



class Zenfox_DatabaseConfigTest extends Zend_Test_PHPUnit_ControllerTestCase
{
    protected $_dbConfigFile = null;
    protected $_dbConfig = null;

    public function setUp()
    {
        //FIXME:: Do we need to take this from application.ini?
        $this->_dbConfigFile = APPLICATION_PATH . "/configs/dbConfig.json";
        $this->_dbConfig = new Zenfox_DatabaseConfig($this->_dbConfigFile);
    }
    public function tearDown()
    {
        unset($this->_dbConfig);
        unset($this->_dbConfigFile);
    }

    public function testGetsDbConfigHasKey()
    {
        //Test if keyword server exists
        $this->assertArrayHasKey('server', $this->_dbConfig->getDbConfig());
    }

    public function testDbConfigInRegistry()
    {
        $registryDbConfig = Zend_Registry::get('dbConfig');
        $this->assertEquals($registryDbConfig, $this->_dbConfig->getDbConfig());
    }

    public function testMasterServerExists()
    {
        $this->assertEquals('master', $this->_dbConfig->getMasterConnection()->getName());
    }

    public function testPartitionServerExists()
    {
        $this->assertEquals('partition 1', $this->_dbConfig->getPartitionConnection(0)->getName());
    }

}
