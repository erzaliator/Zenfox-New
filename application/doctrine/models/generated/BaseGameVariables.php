<?php

/**
 * BaseGameVariables
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $var_id
 * @property string $variable_name
 * @property string $variable_value
 * @property string $variable_type
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6401 2009-09-24 16:12:04Z guilhermeblanco $
 */
abstract class BaseGameVariables extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('game_variables');
        $this->hasColumn('var_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'unsigned' => 0,
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('variable_name', 'string', 45, array(
             'type' => 'string',
             'length' => 45,
             'fixed' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('variable_value', 'string', 5000, array(
             'type' => 'string',
             'length' => 5000,
             'fixed' => false,
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
    }

}