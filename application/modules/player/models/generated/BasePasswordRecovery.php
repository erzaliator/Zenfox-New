<?php

/**
 * BasePasswordRecovery
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $user_id
 * @property enum $user_type
 * @property string $code
 * @property string $email
 * @property timestamp $expiry_time
 * @property timestamp $created
 * @property enum $status
 * @property integer $frontend_id
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6401 2009-09-24 16:12:04Z guilhermeblanco $
 */
abstract class BasePasswordRecovery extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('password_recovery');
        $this->hasColumn('user_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'unsigned' => 0,
             'primary' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('user_type', 'enum', 9, array(
             'type' => 'enum',
             'length' => 9,
             'fixed' => false,
             'values' => 
             array(
              0 => 'PLAYER',
              1 => 'AFFILIATE',
              2 => 'CSR',
             ),
             'primary' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('code', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             'fixed' => true,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('email', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             'fixed' => true,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('expiry_time', 'timestamp', null, array(
             'type' => 'timestamp',
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('created', 'timestamp', null, array(
             'type' => 'timestamp',
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('status', 'enum', 11, array(
             'type' => 'enum',
             'length' => 11,
             'fixed' => false,
             'values' => 
             array(
              0 => 'PROCESSED',
              1 => 'UNPROCESSED',
              2 => 'PENDING',
             ),
             'primary' => false,
             'default' => 'UNPROCESSED',
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('frontend_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'unsigned' => 0,
             'primary' => true,
             'autoincrement' => false,
             ));
    }

}