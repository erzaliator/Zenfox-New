<?php
/**
 * This file contains Zenfox_Resource_Database class which extends
 * Zend_Application_Resource_ResourceAbstract. This class is used to
 * add Database config to the Bootstrap. Everything that is related to
 * database config and initial setup is written here.
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

/**
 * This class extends Zend_Application_Resource_ResourceAbstract.
 * This class is used to add Database config to the Bootstrap.
 * Everything that is related to database config and initial setup is written here.
 *
 * Long description for class (if any)...
 *
 * @category   Zenfox
 * @package    Zenfox_Resource
 * @subpackage -
 * @copyright  2009 Yaswanth Narvaneni
 * @since      Class available since v 0.1
 */

class Zenfox_Resource_Database extends Zend_Application_Resource_ResourceAbstract
{
    const DEFAULT_REGISTRY_KEY = 'Database';
    public function init()
    {
        $options = $this->getOptions();
        return $this->initConnections($options['serverConfigFile']);
    }

    protected function initConnections($serverConfigFile)
    {
        //Setup the db config

        $dbConfig = new Zenfox_DatabaseConfig($serverConfigFile);

        $master = $dbConfig->getMasterConnection();
        //Add event listener to all connections
        //FIXME: Send PDO Objects instead of Doctrine_Connection_Mysql??
        $listener = new Zenfox_ConnectionListener(
                        $dbConfig->getMasterConnection()->getName(),//->getDbh(),
                        //FIXME: This has to be converted to accept an array
                        $dbConfig->getPartitionConnection(0)->getName()//->getDbh()
                        );

        $manager = Doctrine_Manager::getInstance();
        $manager->addListener($listener);

        return $dbConfig->getDbConfig();
    }
}