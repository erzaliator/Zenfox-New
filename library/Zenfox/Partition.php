<?php
/**
 * This file contains Zenfox_Parition class, which returns connection object
 * on giving partitionKey as input
 *
 * Long description for file (if any)...
 *
 * LICENSE:
 *
 * @category   Zenfox
 * @package    Zenfox
 * @subpackage -
 * @copyright  2009 Yaswanth Narvaneni
 * @license    License Link
 * @since      File available since v 0.1
*/

/**
 * This class returns connection object on ParitionKey.
 *
 *
 * Long description for class (if any)...
 *
 * @category   Zenfox
 * @package    Zenfox
 * @subpackage -
 * @copyright  2009 Yaswanth Narvaneni
 * @since      Class available since v 0.1
 */

//TODO:: Make this Singleton

class Zenfox_Partition
{
    //Assume that there is atleast one server
    private $_totalServers = 1;
    private $_partitions = array(0);
    private $_master = array(0);

    /**
     * constructor
     *
     * this is private constructor (use getInstance to get an instance of this class)
     */
    private function __construct()
    {
        $dbConfig = Zend_Registry::get('dbConfig');
        $this->_totalServers = count($dbConfig['server']);
        $this->_partitions = $dbConfig['serverTypes']['partition'];
        $this->_master = $dbConfig['serverTypes']['master'];
    }

    /**
     * Returns an instance of this class
     * (this class uses the singleton pattern)
     *
     * @return Zenfox_Partition
     */
    public static function getInstance()
    {
        static $instance;
        if ( ! isset($instance)) {
            $instance = new self();
        }
        return $instance;
    }


    /**
     * This is the function which returns the connection by taking partitionKey as input
     *
     * @param  string $partitionKey
     * @return mixed  $conns (array or tuple)
     */

    public function getConnections($partitionKey)
    {
        if(!isset($partitionKey))
        {
            throw new Zenfox_Partition_Exception("Partition Key not set");
        }
        else
        {
            $partitionIds = $this->_getPartitionIds($partitionKey);

            $dbConfig = Zend_Registry::get("dbConfig");

            if(is_array($partitionIds))
            {
                //This is the list of connections for that partition key
                $conns = array();

			/**
			 * FIXME:: Below code repeats itself for single and multiple partitions.
			 * Change it hint::make _getPartitionIds return array instead of mixed
			 */
                foreach ($partitionIds as $partitionId)
                {
                    if ($partitionId == 0)
                    {
                        $conns[] = $dbConfig["server"][$dbConfig["serverTypes"]["master"][0]]["conn"]->getName();
                    }
                    if($partitionId > 0)
                    {
                    	$conns[] = $dbConfig["server"][$dbConfig["serverTypes"]["partition"][$partitionId-1]]["conn"]->getName();
                    }
                }

            }

            else
            {
                    if ($partitionIds == 0)
                    {
                        $conns = $dbConfig["server"][$dbConfig["serverTypes"]["master"][0]]["conn"]->getName();
                    }
                    if($partitionIds > 0)
                    {
                        $conns = $dbConfig["server"][$dbConfig["serverTypes"]["partition"][$partitionIds-1]]["conn"]->getName();
                    }
            }
            return $conns;
        }
    }

    /**
     * IMPORTANT:: This is the partitioning function. This is what has to be changed
     * This is the partition function which returns the connection Id
     *
     * @param  string $partitionKey
     * @return array
     */


    private function _getPartitionIds($partitionKey)
    {
        $dbConfig = Zend_Registry::get("dbConfig");
        //print '<pre>'; print_r($dbConfig);exit();

        if($partitionKey > 0)
        {
            //Return the specified partition
            return ($partitionKey%count($this->_partitions)+1);
        }
        elseif($partitionKey == 0)
        {
            //Return the non-partitioned connection
            return 0;
        }
        elseif($partitionKey == -1)
        {
            return $this->_partitions;
        }
    }
    
    /*
     * This function will return the connection for stored user id in session.
     * Returns random slave partition if user id not stored
     */
    public function getCommonConnection()
    {
    	$session = new Zenfox_Auth_Storage_Session();
    	$store = $session->read();
    	$userType = $store['roleName'];
    	$userId = $store['id'];
    	if(($userType == 'csr') || (!$userId))
    	{
       		$userId = rand(1, count($this->_partitions));
    	}
    	$currentConnection = $this->getConnections($userId);
    	return $currentConnection;
    }
    
    public function getMasterConnection()
    {
    	//FIXME change it for multiple masters, use $this->_master
    	$masterConnection = $this->getConnections(0);
    	return $masterConnection;
    }
}