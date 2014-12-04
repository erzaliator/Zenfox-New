<?php

/**
 * BaseKeno
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $machine_id
 * @property string $machine_name
 * @property string $game_flavour
 * @property enum $feature_round
 * @property enum $bonus_spins
 * @property integer $max_coins
 * @property integer $max_nums
 * @property integer $min_coins
 * @property integer $min_nums
 * @property integer $machine_type
 * @property enum $pjp
 * @property string $description
 * @property string $config_file
 * @property string $swf_file
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6401 2009-09-24 16:12:04Z guilhermeblanco $
 */
abstract class BaseKeno extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('keno');
        $this->hasColumn('machine_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'unsigned' => 0,
             'primary' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('machine_name', 'string', 45, array(
             'type' => 'string',
             'length' => 45,
             'fixed' => true,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('game_flavour', 'string', 45, array(
             'type' => 'string',
             'length' => 45,
             'fixed' => true,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('feature_round', 'enum', 8, array(
             'type' => 'enum',
             'length' => 8,
             'fixed' => false,
             'values' => 
             array(
              0 => 'ENABLED',
              1 => 'DISABLED',
             ),
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('bonus_spins', 'enum', 8, array(
             'type' => 'enum',
             'length' => 8,
             'fixed' => false,
             'values' => 
             array(
              0 => 'ENABLED',
              1 => 'DISABLED',
             ),
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('max_coins', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'unsigned' => 0,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('max_nums', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'unsigned' => 0,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('min_coins', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'unsigned' => 0,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('min_nums', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'unsigned' => 0,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('machine_type', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'unsigned' => 0,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('pjp', 'enum', 8, array(
             'type' => 'enum',
             'length' => 8,
             'fixed' => false,
             'values' => 
             array(
              0 => 'ENABLED',
              1 => 'DISABLED',
             ),
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('description', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             'fixed' => true,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('config_file', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             'fixed' => true,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('swf_file', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             'fixed' => true,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
    }

}