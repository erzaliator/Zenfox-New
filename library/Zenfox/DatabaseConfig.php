<?php
/**
 * This file contains Zenfox_DatabaseConfig
 * This file reads the database config and puts it in Zend_Registry
 * TODO:: This has to be refactored and divided to
 * 1. Also read memcache server details
 * 2. To save connnection data to memcache along with Zend_Registry
 * 3. Extend Zend_Registry to work with Memcache
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
*/

/**
 * This class reads the database config and puts it in Zend_Registry.
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
 */


class Zenfox_DatabaseConfig
{
    protected $dbConfig;
    protected $_dbConfigFile;

    public function __construct($dbConfigFile, array $dbConfig = null)
    {
/*        if (!Zend_Registry::isRegistered("db_config"))
        {
            //return $this->_initConnections($bootstrap);
            return $this->_initConnections($bootstrap);
        }
        else
        {
            //return $this->getDbConfig();
            print "HERE";
        }*/
        $this->_dbConfigFile = $dbConfigFile;
        return $this->_initConnections($dbConfigFile);
    }

    public function getDbConfig()
    {
        if (Zend_Registry::isRegistered("dbConfig"))
        {
            return Zend_Registry::get("dbConfig");
        }
        return false;
    }

    protected function _initConnections($dbConfigFile = null)
    {
        $dbConfigFile = isset($dbConfigFile)?$dbConfigFile:$this->_dbConfigFile;
        //Loading Server Details
        $fh = fopen($dbConfigFile, 'r');
        $serverJson = fread($fh, filesize($dbConfigFile));
        fclose($fh);

        //FIXME:: Write a much elegant code for dsn building
        $dbConfig = Zend_Json::decode($serverJson);
        //Returns the list of servers and dsn
        $dbConfig = $this->buildDsn($dbConfig);

        //Connect to all the DBs in the list
        foreach ($dbConfig["server"] as $id=>$serverDetails)
        {
            $dbConfig["server"][$id]["conn"] = Doctrine_Manager::connection(
                        $serverDetails["dsn"],
                        $serverDetails["name"]
                        );
            $dbConfig["server"][$id]["conn"]
                ->setAttribute(Doctrine::ATTR_USE_NATIVE_ENUM, true);
            //Zenfox_Debug::dump($dbConfig["server"][$id]["conn"], "DB=> ", true, true);
/*            print $server_details["dsn"]
                . " -> "
                . $db_config["server"][$id]["conn"]->getName()."<br>";
*/
        }

        Zend_Registry::set('dbConfig', $dbConfig);
        $this->dbConfig = $dbConfig;
        return $this->dbConfig;

    }

    public function getMasterConnection()
    {
        $dbConfig = Zend_Registry::get("dbConfig");

        $dbConfig["server"][$dbConfig["serverTypes"]["master"][0]]["conn"] || $this->_initConnections();

        $dbConfig = Zend_Registry::get("dbConfig");

        return $dbConfig["server"][$dbConfig["serverTypes"]["master"][0]]["conn"];
    }

    //Retruns partition connection depending on the partition_id
    public function getPartitionConnection($partitionId = -1)
    {
        $dbConfig = Zend_Registry::get("dbConfig");

        if ($partitionId == -1)
        {
            //TODO: Return all connections
            $partitionConns = array();
            foreach ($dbConfig["server"] as $id => $server)
            {
                if(in_array($id, $dbConfig["serverTypes"]["partition"]))
                {
                    $partitionConns [] = $server["conn"];
                }
            }
            return $partitionConns;
        }
/*        //This returns master connection
        if ($partitionId == 0)
        {
            return $this->getMasterConnection();
        }
*/
        if ($partitionId >= 0)
        {
            if (!isset($dbConfig["server"][$dbConfig["serverTypes"]["partition"][$partitionId]]["conn"]))
            {
                $this->_initConnections();
                $dbConfig = Zend_Registry::get("dbConfig");
            }
            //print get_class($db_config["server"][$db_config["serverTypes"]["partition"][$partition_id-1]]["conn"]);
            return $dbConfig["server"][$dbConfig["serverTypes"]["partition"][$partitionId]]["conn"];
        }
    }

    protected function buildDsn($serverConfig)
    {
        //Build DSN
        foreach ($serverConfig["server"] as $serverId => $dbServer)
        {
            $serverConfig["server"][$serverId]["dsn"] = $dbServer["dbtype"]
                 . "://"
                 . $dbServer["login"]
                 . ":"
                 . $dbServer["password"]
                 . "@"
                 . $dbServer["ip"]
                 . ":"
                 . $dbServer["port"]
                 . "/"
                 . $dbServer["dbname"];
        }

        return $serverConfig;
    }
}
