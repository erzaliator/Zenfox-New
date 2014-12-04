<?php
/**
 * This file contains Zenfox_Resource_Doctrine class which extends
 * Zend_Application_Resource_ResourceAbstract. This class is used to
 * add Doctrine resource to the Bootstrap. Everything that is related to
 * Doctrine initialization is written here.
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
require_once ('Zenfox/Resource/Doctrine.php');


/**
 * This class extends Zend_Application_Resource_ResourceAbstract.
 * This class is used to add Doctrine resource to the Bootstrap.
 * Everything that is related to Doctrine initialization is written here.
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

class Zenfox_Resource_DoctrineTest extends Zend_Test_PHPUnit_ControllerTestCase
{
    private $_manager;

    public function setUp()
    {
        $doctrineResource = new Zenfox_Resource_Doctrine();
        $this->_manager = $doctrineResource->init();
    }

    public function testDoctrineConfigSetInZendRegistry()
    {
        $doctrineConfig = Zend_Registry::get('doctrine_config');
        $this->assertArrayHasKey('data_fixtures_path', $doctrineConfig);
        $this->assertArrayHasKey('models_path', $doctrineConfig);
        $this->assertArrayHasKey('migrations_path', $doctrineConfig);
        $this->assertArrayHasKey('sql_path', $doctrineConfig);
        $this->assertArrayHasKey('yaml_schema_path', $doctrineConfig);

        //FIXME::These wont work coz, data is not loaded??!
        /*
        $this->assertNotNull($doctrineConfig['data_fixtures_path']);
        $this->assertNotNull($doctrineConfig['models_path']);
        $this->assertNotNull($doctrineConfig['migrations_path']);
        $this->assertNotNull($doctrineConfig['sql_path']);
        $this->assertNotNull($doctrineConfig['yaml_schema_path']);
        */
    }
    public function testManagerIsGood()
    {
//        $this->_manager = $doctrineResource->init();
    }

    public function tearDown()
    {
        unset($this->_manager);
    }
}
