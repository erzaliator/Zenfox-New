<?php

/**
 * BaseTicket
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $ticket_status
 * @property integer $ticket_type_id
 * @property integer $user_id
 * @property enum $user_type
 * @property integer $csr_id
 * @property integer $csr_owner
 * @property enum $start_by
 * @property integer $started_id
 * @property enum $closed_by
 * @property integer $closed_id
 * @property timestamp $start_date
 * @property timestamp $close_date
 * @property integer $frontend_id
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6401 2009-09-24 16:12:04Z guilhermeblanco $
 */
abstract class BaseTicket extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('ticket');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'unsigned' => 0,
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('ticket_status', 'enum', 9, array(
             'type' => 'enum',
             'length' => 9,
             'fixed' => false,
             'values' => 
             array(
              0 => 'OPEN',
              1 => 'CLOSE',
              2 => 'PENDING',
              3 => 'FORWARDED',
              4 => 'DISPATCH'
             ),
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('ticket_type_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'unsigned' => 0,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('user_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'unsigned' => 0,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('user_type', 'enum', 9, array(
             'type' => 'enum',
             'length' => 9,
             'fixed' => false,
             'values' => 
             array(
              0 => 'AFFILIATE',
              1 => 'PLAYER',
              2 => 'VISITOR',
             ),
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('csr_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'unsigned' => 0,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('csr_owner', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'unsigned' => 0,
             'primary' => false,
             'default' => '0',
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('start_by', 'enum', 9, array(
             'type' => 'enum',
             'length' => 9,
             'fixed' => false,
             'values' => 
             array(
              0 => 'AFFILIATE',
              1 => 'PLAYER',
              2 => 'CSR',
              3 => 'VISITOR',
             ),
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('started_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'unsigned' => 0,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('closed_by', 'enum', 9, array(
             'type' => 'enum',
             'length' => 9,
             'fixed' => false,
             'values' => 
             array(
              0 => 'AFFILIATE',
              1 => 'PLAYER',
              2 => 'CSR',
             ),
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('closed_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'unsigned' => 0,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('start_date', 'timestamp', null, array(
             'type' => 'timestamp',
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('close_date', 'timestamp', null, array(
             'type' => 'timestamp',
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('frontend_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'unsigned' => 0,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('subject', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             'fixed' => true,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
    }
    
    public function setUp()
    {
    	$this->hasOne('TicketData', array(
    			'local' => 'id',
    			'foreign' => 'ticket_id'));

    	$this->hasOne('Forwarded', array(
    			'local' => 'id',
    			'foreign' => 'ticket_id'));
    }

}