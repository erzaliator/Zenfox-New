<?php

/**
 * BaseForwarded
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $ticket_id
 * @property integer $forwarded_by
 * @property integer $forwarded_to
 * @property timestamp $forwarded_time
 * @property string $forwarded_note
 * @property integer $user_id
 * @property enum $user_type
 * @property Csr $Csr
 * @property Ticket $Ticket
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6401 2009-09-24 16:12:04Z guilhermeblanco $
 */
abstract class BaseForwarded extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('forwarded');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => '4',
             ));
        $this->hasColumn('ticket_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('forwarded_by', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('forwarded_to', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('forwarded_time', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
        $this->hasColumn('forwarded_note', 'string', 255, array(
             'type' => 'string',
             'fixed' => 1,
             'length' => '255',
             ));
        $this->hasColumn('user_id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'length' => '4',
             ));
        $this->hasColumn('user_type', 'enum', null, array(
             'type' => 'enum',
             'values' => 
             array(
              0 => 'AFFILIATE',
              1 => 'PLAYER',
              2 => 'VISITOR',
             ),
             'primary' => true,
             ));


        $this->index('user', array(
             'fields' => 
             array(
              0 => 'user_id',
              1 => 'user_type',
             ),
             ));
        $this->index('forwarded_by_index', array(
             'fields' => 
             array(
              0 => 'forwarded_by',
             ),
             ));
        $this->index('forwarded_to_index', array(
             'fields' => 
             array(
              0 => 'forwarded_to',
             ),
             ));
        $this->option('type', 'MyISAM');
    }

    public function setUp()
    {
        parent::setUp();
    $this->hasOne('Csr', array(
             'local' => 'forwarded_to',
             'foreign' => 'id'));

        $this->hasOne('Ticket', array(
             'local' => 'user_type',
             'foreign' => 'user_type'));
    }
}