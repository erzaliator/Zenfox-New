<?php
/**
 * This file contains Zenfox_Query class which extends
 * Doctrine_Query.This is where the connection pooling and swapping
 * will happen for every Query.
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
 * This class extends Doctrine_Query
 * The class gets the partitionKey (Player_id or 0, -1) depending on which
 * a partition is selected and swapped.
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

class Zenfox_Query extends Doctrine_Query
{
	public function setConnection($connection)
    {
    	$_conn = Doctrine_Manager::getInstance()->getConnection($connection);
    }
}

/*
 *  OLD CODE:: Refer to it while extending
 */

/*class Zenfox_Query extends Doctrine_Query
{

    private $_connections = array();
    private $_connNames = array();
    private $_doctrineQueries = array();

    public function __construct($partitionKey)
    {
        if(!isset($partitionKey))
        {
            throw new Zenfox_Query_Exception("Partition Key not set");
        }
        else
        {
            $partition = new Zenfox_Partition();
            $this->_connNames = $partition->getConnections($partitionKey);

            foreach ($this->_connNames as $connName)
            {
                //Get the connection from connection name
                $conn = Doctrine_Manager::getInstance()->getConnection($connName);
                $this->_connections[]  = $conn;

                //Create a query on the connection
                $dQuery = Doctrine_Query::create($conn);
                $this->_doctrineQueries[] = $dbQuery;

            }
        }
    }

    public function execute()
    {

    }
*/
/*
    public static function create($partitionKey)
    {
        return new Zenfox_Query($partitionKey);
/*        if(!isset($partitionKey))
        {
            throw new Zenfox_Query_Exception("Partition Key not set");
        }
        else
        {
            $partition = new Zenfox_Partition();

            try
            {
                $connNames = $partition->getConnections($partitionKey);
                // Since php doesn't support late static binding in 5.2 we need to override
                // this method to instantiate a new Zenfox_Query instead of Doctrine_Query
                $conn = Doctrine_Manager::getInstance()->getConnection($connName);
                return new Zenfox_Query($partitionKey);
            }
            catch (Zenfox_Partition_Exception $e)
            {
                throw new Zenfox_Exception("Unable to get connection on given partitionKey". $partitionKey . $e);
            }

        }*/
  /*  }

    public function preQuery()
    {
        //print_r();
        $this->_conn = $this->getConnection();
        // If this is a select query then set connection to one of the slaves
        /*if ($this->getType() == Doctrine_Query::SELECT) {
            $this->_conn = Doctrine_Manager::getInstance()->getConnection('slave_' . rand(1, 4));
        // All other queries are writes so they need to go to the master
        } else {
            $this->_conn = Doctrine_Manager::getInstance()->getConnection('master');
        }*/
    /*}
}*/
