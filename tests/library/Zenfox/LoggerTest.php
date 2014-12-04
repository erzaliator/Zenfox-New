<?php
/**
 * This file contains tests for Zenfox_Logger class
 * TODO:: Need to write tests for logDbErrors
 * Need to write tests for suppressing any exceptions
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
require_once ("Zenfox/Logger.php");

/**
 * These are the tests for Zenfox Logger class.
 * TODO:: This needs to extend Zend_Test_PHPUnit_DatabaseTestCase
 * to check dbLogger()
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


class Zenfox_LoggerTest extends Zend_Test_PHPUnit_ControllerTestCase
//class Zenfox_LoggerTest extends Zend_Test_PHPUnit_DatabaseTestCase
{
    protected $_logger;

    public function setUp()
    {
        //FIXME:: Do we need to take this from application.ini?
        $options['dblog'] = APPLICATION_PATH . "/logs/database-test.log";
        $options['msglog'] = APPLICATION_PATH . "/logs/app-test.log";
        $this->_logger = new Zenfox_Logger($options);
    }
    public function tearDown()
    {
        unset($this->_logger);
    }

    public function testToDo()
    {
        print "\nTODO:: Write tests for Zenfox_LoggerTest:: logDBErrors";
    }

    public function testLogDbErrors()
    {
/*        $doctrineTable = $this->_getCleanMock('Doctrine_Table');
        $doctrineTable->expects($this->any())
                      ->method('getClassnameToReturn')
                      ->will($this->returnValue('Test_Table'));
        print "Here" . $doctrineTable->getName();
        $doctrineRecord = $this->_getCleanMock('Doctrine_Record');
        $doctrineRecord->setTable($doctrineTable);
        print $doctrineRecord->getTable()->getName();

        //$doctrineTable = $this->getMock('Doctrine_Table');

        $doctrineManager = $this->_getCleanMock('Doctrine_Manager');
        $doctrineConnection = $this->_getCleanMock('Doctrine_Connection');
        $doctrineTable = $this->getMock('Doctrine_Table',
                                              array('getClassnameToReturn',
                                                    'getName',
                                                    'getTableName'
                                              ),
                                              array($doctrineManager, $doctrineConnection)
                                              );
        // Configure the stub.
        $doctrineTable->expects($this->any())
                         ->method('getClassnameToReturn')
                         ->will($this->returnValue('Test_Doctrine_Record'));
        $doctrineTable->expects($this->any())
                         ->method('getTableName')
                         ->will($this->returnValue('Test_Doctrine_Table_TableName'));
        $doctrineTable->expects($this->any())
                         ->method('getName')
                         ->will($this->returnValue('Doctrine_Record_TestClass'));

        $doctrineRecord = $this->getMock('Doctrine_Record');
        $doctrineRecord ->expects($this->any())
                        ->method('getTable')
                        ->will($this->returnValue($doctrineTable));

        $this->_logger->logDBErrors($doctrineRecord,
                                        $_SERVER['SCRIPT_FILENAME'],
                                        new Doctrine_Exception()
                                    );*/
    }

    public function testLogMessages()
    {
        //TODO:: Confirm that string has been written
        $this->_logger->logMessages("Testing Log Messages",$_SERVER['SCRIPT_FILENAME'], get_class($this));
    }


    protected function _getCleanMock($className)
    {
        $class = new ReflectionClass($className);
        $methods = $class->getMethods();
        $stubMethods = array();
        foreach ($methods as $method)
        {
            if ($method->isPublic() || ($method->isProtected()
                && $method->isAbstract()))
                {
                    $stubMethods[] = $method->getName();
                }
        }
        $mocked = $this->getMock(
            $className,
            $stubMethods,
            array(),
            $className . '_LoggerTestMock_' . uniqid(),
            false
        );
        return $mocked;
    }
}