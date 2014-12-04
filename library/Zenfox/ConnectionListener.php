<?php
/**
 * This file contains Zenfox_ConnectionListener class which extends
 * Doctrine_Connection and implements Doctrine_EventListener_Interface.
 * This is where the connection pooling and swapping should happen.
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
 * This class extends Doctrine_Connection and implements Doctrine_EventListener_Interface.
 * The swapping is done before and after querying. This works perfectly fine
 * for 2 databases (Master/Slave setup).
 *
 * TODO:: This has to be extended to work for our setup.
 * Setup:
 * 1. One Master Server or a Cluster that works as a single box
 * 2. Multiple Paritioned Server. Paritioned by Key.
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


class Zenfox_ConnectionListener extends Doctrine_Connection
  implements Doctrine_EventListener_Interface
{
    protected
    $master = null,
    $partition = null;

    public function __construct($master, $partition)
    {
        $this->master = $master;
        $this->partition = $partition;
    }

    public function preQuery(Doctrine_Event $event)
    {
        //print "Tables";
        //print $event->getInvoker()->getTables();
         $this->forceDbh($event->getInvoker(), 'master');
    }

    public function postQuery(Doctrine_Event $event)
    {
        $this->restoreDbh($event->getInvoker());
    }

    public function prePrepare(Doctrine_Event $event)
    {
        $use = 0 === strpos(trim(strtolower($event->getQuery())), 'select') ?
          'partition' : 'master';

        $this->forceDbh($event->getInvoker(), $use);
    }

    public function postStmtExecute(Doctrine_Event $event)
    {
        $this->restoreDbh($event->getInvoker()->getConnection());
    }

    public function preExec(Doctrine_Event $event)
    {
        $this->forceDbh($event->getInvoker(), 'master');
    }

    public function postExec(Doctrine_Event $event)
    {
        $this->restoreDbh($event->getInvoker());
    }

    // protected

    protected function forceDbh($conn, $type)
    {
        $conn = Doctrine_Manager::getInstance();
        $connName = $conn->getCurrentConnection()->getName();
        if ($this->$type !== $connName)
        {
            $conn->options['previousConn'] = $connName;
            $conn->setCurrentConnection($this->$type);

        }


    }

    protected function restoreDbh($conn)
    {
        $conn = Doctrine_Manager::getInstance();
        if (isset($conn->options['previousConn']))
        {
            $conn->setCurrentConnection($conn->options['previousConn']);
            unset($conn->options['previousConn']);
        }
    }

    // the remaining methods required by Doctrine_EventListener_Interface

    public function preTransactionCommit(Doctrine_Event $event) { }
    public function postTransactionCommit(Doctrine_Event $event) { }
    public function preTransactionRollback(Doctrine_Event $event) { }
    public function postTransactionRollback(Doctrine_Event $event) { }
    public function preTransactionBegin(Doctrine_Event $event) { }
    public function postTransactionBegin(Doctrine_Event $event) { }
    public function postConnect(Doctrine_Event $event) { }
    public function preConnect(Doctrine_Event $event) { }
    public function postPrepare(Doctrine_Event $event) { }
    public function preStmtExecute(Doctrine_Event $event) { }
    public function preError(Doctrine_Event $event) { }
    public function postError(Doctrine_Event $event) { }
    public function preFetch(Doctrine_Event $event) { }
    public function postFetch(Doctrine_Event $event) { }
    public function preFetchAll(Doctrine_Event $event) { }
    public function postFetchAll(Doctrine_Event $event) { }
}