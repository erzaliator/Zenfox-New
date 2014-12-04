<?php

/**
 * BaseTableConfig
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $game_flavour
 * @property integer $table_config_id
 * @property integer $min_players
 * @property integer $max_players
 * @property integer $max_spectators
 * @property enum $amount_type
 * @property string $currency
 * @property float $min_bet
 * @property float $max_bet
 * @property string $config
 * @property string $allowed_frontend_ids
 * @property string $config_file
 * @property string $swf_file
 * @property string $ext_file
 * @property integer $min_active_rooms
 * @property integer $increment_rooms
 * @property integer $max_rooms
 * @property integer $create_rooms
 * @property string $npc_config
 * @property string $game_rules
 * @property string $game_type
 * @property string $table_name
 * @property string $table_description
 * @property enum $status
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6401 2009-09-24 16:12:04Z guilhermeblanco $
 */
abstract class BaseTableConfig extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('table_config');
        $this->hasColumn('game_flavour', 'string', 45, array(
             'type' => 'string',
             'length' => 45,
             'fixed' => true,
             'primary' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('table_config_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'unsigned' => 0,
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('min_players', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'unsigned' => 0,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('max_players', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'unsigned' => 0,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('max_spectators', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'unsigned' => 0,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('amount_type', 'enum', 5, array(
             'type' => 'enum',
             'length' => 5,
             'fixed' => false,
             'values' => 
             array(
              0 => 'REAL',
              1 => 'BONUS',
              2 => 'BOTH',
              3 => 'FREE',
              4 => 'BOTHREAL',
             ),
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('currency', 'string', 3, array(
             'type' => 'string',
             'length' => 3,
             'fixed' => true,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('min_bet', 'float', null, array(
             'type' => 'float',
             'unsigned' => 0,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('max_bet', 'float', null, array(
             'type' => 'float',
             'unsigned' => 0,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('config', 'string', 10000, array(
             'type' => 'string',
             'length' => 10000,
             'fixed' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('allowed_frontend_ids', 'string', 1000, array(
             'type' => 'string',
             'length' => 1000,
             'fixed' => false,
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
        $this->hasColumn('ext_file', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             'fixed' => true,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('min_active_rooms', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'unsigned' => 0,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('increment_rooms', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'unsigned' => 0,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('max_rooms', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'unsigned' => 0,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('create_rooms', 'integer', 1, array(
             'type' => 'integer',
             'length' => 1,
             'unsigned' => 0,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('npc_config', 'string', 2000, array(
             'type' => 'string',
             'length' => 2000,
             'fixed' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('game_rules', 'string', 5000, array(
             'type' => 'string',
             'length' => 5000,
             'fixed' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('game_type', 'string', 100, array(
             'type' => 'string',
             'length' => 100,
             'fixed' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('table_name', 'string', 45, array(
             'type' => 'string',
             'length' => 45,
             'fixed' => true,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('table_description', 'string', 500, array(
             'type' => 'string',
             'length' => 500,
             'fixed' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('status', 'enum', 8, array(
             'type' => 'enum',
             'length' => 8,
             'fixed' => false,
             'values' => 
             array(
              0 => 'ENABLED',
              1 => 'DISABLED',
             ),
             'primary' => false,
             'default' => 'ENABLED',
             'notnull' => false,
             'autoincrement' => false,
             ));
    }

}