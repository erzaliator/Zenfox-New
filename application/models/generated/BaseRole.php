<?php

/**
 * BaseRole
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $name
 * @property enum $role_type
 * @property integer $parent_id
 * @property string $description
 * @property Role $Role
 * @property Doctrine_Collection $roles
 * @property Doctrine_Collection $privileges
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6401 2009-09-24 16:12:04Z guilhermeblanco $
 */
abstract class BaseRole extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('roles');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => '4',
             ));
        $this->hasColumn('name', 'string', 255, array(
             'type' => 'string',
             'unique' => true,
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
        $this->hasColumn('parent_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('description', 'string', 255, array(
             'type' => 'string',
             'fixed' => 1,
             'length' => '255',
             ));

        $this->option('type', 'MyISAM');
    }

    public function setUp()
    {
        parent::setUp();
    $this->hasOne('Role', array(
             'local' => 'parent_id',
             'foreign' => 'id'));

        $this->hasMany('Role as roles', array(
             'local' => 'id',
             'foreign' => 'parent_id'));

        $this->hasMany('Privilege as privileges', array(
             'local' => 'id',
             'foreign' => 'role_id'));
    }
}