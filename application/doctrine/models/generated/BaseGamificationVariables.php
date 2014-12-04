<?php

/**
 * BaseGamificationVariables
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $player_id
 * @property integer $client_id
 * @property integer $app_id
 * @property integer $var_id
 * @property string $variable_name
 * @property float $variable_value
 * @property string $variable_type
 * @property timestamp $last_modified
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6401 2009-09-24 16:12:04Z guilhermeblanco $
 */
abstract class BaseGamificationVariables extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('gamification_variables');
        $this->hasColumn('player_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'unsigned' => 0,
             'primary' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('client_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'unsigned' => 0,
             'primary' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('app_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'unsigned' => 0,
             'primary' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('var_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'unsigned' => 0,
             'primary' => false,
             'default' => '0',
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('variable_name', 'string', 45, array(
             'type' => 'string',
             'length' => 45,
             'fixed' => true,
             'primary' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('variable_value', 'float', null, array(
             'type' => 'float',
             'unsigned' => 0,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('variable_type', 'string', 45, array(
             'type' => 'string',
             'length' => 45,
             'fixed' => true,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('last_modified', 'timestamp', null, array(
             'type' => 'timestamp',
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
    }

}