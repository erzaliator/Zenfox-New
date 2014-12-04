<?php
/**
 * This file contains Zenfox_Logger class
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
 * This is the Zenfox Logger class. This is the class that has to be used
 * if anything about the app has to be logged.
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


class Zenfox_Logger
{
/*
 *
 *
 *   EMERG   = 0;  // Emergency: system is unusable
 *   ALERT   = 1;  // Alert: action must be taken immediately
 *   CRIT    = 2;  // Critical: critical conditions
 *   ERR     = 3;  // Error: error conditions
 *   WARN    = 4;  // Warning: warning conditions
 *   NOTICE  = 5;  // Notice: normal but significant condition
 *   INFO    = 6;  // Informational: informational messages
 *   DEBUG   = 7;  // Debug: debug messages
*/
    //const DEFAULT_REGISTRY_KEY = 'Logger';
    private $_dbwriter;
    private $_msgwriter;
    private $_dblogger;
    private $_msglogger;
    private $dblog;
    private $msglog;

    public function __construct($options)
    {
        //TODO:: Find a way to set it to /dev/null or PHP equivalent. But still throw an error.
        $this->msglog = isset($options['msglog']) ? $options['msglog'] : '/tmp/zenfox.log';
        $this->dblog = isset($options['dblog']) ? $options['dblog'] : '/tmp/zenfox.log';

        if(!isset($this->_dbwriter))
        {
            try
            {
                $this->_dbwriter = new Zend_Log_Writer_Stream($this->dblog);
            }
            catch (Zend_Log_Exception $e)
            {
                require_once 'Zenfox/Resource/Exception.php';
                throw new Zenfox_Resource_Exception(
                    "Logger Exception. Possible could not open dblog. Cannot log without this. " . $e
                );
            }
        }
        $this->_dblogger = new Zend_Log($this->_dbwriter);

        if(!isset($this->_msgwriter))
        {
            try
            {
                $this->_msgwriter = new Zend_Log_Writer_Stream($this->msglog);
            }
            catch (Zend_Log_Exception $e)
            {
                require_once 'Zenfox/Resource/Exception.php';
                throw new Zenfox_Resource_Exception(
                    "Logger Exception. Possible could not open msglog. Cannot log without this " . $e
                );
            }
        }
        $this->_msglogger = new Zend_Log($this->_msgwriter);

        return $this;
    }

    public function logMessages($message, $fileName = "Unknown", $className = "Unknown Class")
    {
        $logger =& $this->_msglogger;
        $lstring = "Message from class (" . $className . ") in file (" . $fileName . "): ";
        $lstring .= $message;
        $logger->info($lstring);
    }

    public function logDBErrors(Doctrine_Record &$record, $fileName = "Unknown", Doctrine_Exception $e)
    {
        $logger =& $this->_dblogger;
        $errorStack = $record->getErrorStack();
        $className = $record->getTable()->getClassnameToReturn();
        $returnArray = array();

        $ds = "DB Error (file: $fileName)(class: $className)" . PHP_EOL;
        $ds .= "Doctrine Exception: " . $e->getTraceAsString() . PHP_EOL;
        foreach($errorStack as $field => $messages)
        {
            $returnArray[$field] = array();
            $ds .= "Error with field ($field) ";
            foreach($messages as $msg)
            {
                $ds .= "failed with message ($msg) " . PHP_EOL;
                switch($msg)
                {
                    case 'notnull':
                        $returnArray[$field][] = "Field cannot be null";
                        break;
                    case 'unique':
                        $returnArray[$field][] = "Duplicate entry";
                        break;
                }
            }
        }
        $ds .= "LOG END for $fileName" . PHP_EOL;
        $logger->err($ds);
        return $returnArray;
    }
}