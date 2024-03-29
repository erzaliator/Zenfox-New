<?php

/**
 * BasePrivilege
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $resource_id
 * @property string $resource_name
 * @property enum $resource_type
 * @property integer $role_id
 * @property string $role_name
 * @property enum $role_type
 * @property string $mode
 * @property Resource $Resource
 * @property Role $Role
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6401 2009-09-24 16:12:04Z guilhermeblanco $
 */
abstract class BasePrivilege extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('privileges');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => '4',
             ));
        $this->hasColumn('resource_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('resource_name', 'string', 255, array(
             'type' => 'string',
             'fixed' => 1,
             'length' => '255',
             ));
        $this->hasColumn('resource_type', 'enum', null, array(
             'type' => 'enum',
             'values' => 
             array(
              0 => 'REQUEST',
              1 => 'GAME',
             ),
             ));
        $this->hasColumn('role_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('role_name', 'string', 255, array(
             'type' => 'string',
             'fixed' => 1,
             'length' => '255',
             ));
        $this->hasColumn('role_type', 'enum', null, array(
             'type' => 'enum',
             'values' => 
             array(
              0 => 'VISITOR',
              1 => 'PLAYER',
              2 => 'AFFILIATE',
              3 => 'CSR',
             ),
             ));
        $this->hasColumn('mode', 'string', 255, array(
             'type' => 'string',
             'fixed' => 1,
             'length' => '255',
             ));

        $this->option('type', 'MyISAM');
    }

    public function setUp()
    {
        parent::setUp();
    $this->hasOne('Resource', array(
             'local' => 'resource_id',
             'foreign' => 'id'));

        $this->hasOne('Role', array(
             'local' => 'role_id',
             'foreign' => 'id'));
    }
}