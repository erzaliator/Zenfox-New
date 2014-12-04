<?php

/**
 * BaseRunningSlot
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $machine_id
 * @property string $game_flavour
 * @property enum $amount_type
 * @property boolean $feature_enabled
 * @property boolean $bonus_spins_enabled
 * @property string $denomination
 * @property integer $default_denomination
 * @property string $default_currency
 * @property boolean $pjp_enabled
 * @property float $max_bet
 * @property integer $machine_type
 * @property integer $max_betlines
 * @property integer $max_coins
 * @property integer $min_betlines
 * @property integer $min_coins
 * @property boolean $enabled
 * @property integer $created_by
 * @property timestamp $created_time
 * @property integer $last_updated_by
 * @property timestamp $last_updated_time
 * @property Slot $Slot
 * @property Currency $Currency
 * @property Csr $Csr
 * @property Doctrine_Collection $machines_pjps
 * @property Doctrine_Collection $pjp_machines
 * @property Doctrine_Collection $gamelog_sessions
 * @property Doctrine_Collection $game_gamegroups
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6401 2009-09-24 16:12:04Z guilhermeblanco $
 */
abstract class BaseRunningSlot extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('running_slots');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'length' => '4',
        	 'autoincrement' => true,
             ));
        $this->hasColumn('machine_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('game_flavour', 'string', 45, array(
             'type' => 'string',
             'fixed' => 1,
             'length' => '45',
             ));
        $this->hasColumn('amount_type', 'enum', null, array(
             'type' => 'enum',
             'values' => 
             array(
              0 => 'REAL',
              1 => 'BONUS',
              2 => 'BOTH',
             ),
             ));
        $this->hasColumn('feature_enabled', 'enum', null, array(
             'type' => 'enum',
             'values' => 
             array(
              0 => 'ENABLED',
              1 => 'DISABLED',
             ),
             ));
        $this->hasColumn('bonus_spins_enabled', 'enum', null, array(
             'type' => 'enum',
             'values' => 
             array(
              0 => 'ENABLED',
              1 => 'DISABLED',
             ),
             ));
        $this->hasColumn('denominations', 'string', 255, array(
             'type' => 'string',
             'fixed' => 1,
             'length' => '255',
             ));
        $this->hasColumn('default_denomination', 'float', 4, array(
             'type' => 'float',
             'length' => '4',
             ));
        $this->hasColumn('default_currency', 'string', 3, array(
             'type' => 'string',
             'fixed' => 1,
             'length' => '3',
             ));
        $this->hasColumn('pjp_enabled', 'enum', null, array(
             'type' => 'enum',
             'values' => 
             array(
              0 => 'ENABLED',
              1 => 'DISABLED',
             ),
             ));
        $this->hasColumn('max_bet', 'float', null, array(
             'type' => 'float',
             ));
        $this->hasColumn('machine_type', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('max_betlines', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('max_coins', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('min_betlines', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('min_coins', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('enabled', 'enum', null, array(
             'type' => 'enum',
             'values' => 
             array(
              0 => 'ENABLED',
              1 => 'DISABLED',
             ),
             ));
        $this->hasColumn('created_by', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('created_time', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
        $this->hasColumn('last_updated_by', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('last_updated_time', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
        $this->hasColumn('description', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('machine_name', 'string', 45, array(
             'type' => 'string',
             'length' => '45',
             ));

        $this->option('type', 'MyISAM');
    }

    public function setUp()
    {
        parent::setUp();
    $this->hasOne('Slot', array(
             'local' => 'game_flavour',
             'foreign' => 'game_flavour'));

        $this->hasOne('Currency', array(
             'local' => 'default_currency',
             'foreign' => 'currency_code'));

        $this->hasOne('Csr', array(
             'local' => 'last_updated_by',
             'foreign' => 'id'));

        $this->hasMany('MachinesPjp as machines_pjps', array(
             'local' => 'id',
             'foreign' => 'running_machine_id'));

        $this->hasMany('PjpMachine as pjp_machines', array(
             'local' => 'id',
             'foreign' => 'game_id'));

        $this->hasMany('GamelogSession as gamelog_sessions', array(
             'local' => 'id',
             'foreign' => 'machine_id'));

        $this->hasMany('GameGamegroup as game_gamegroups', array(
             'local' => 'id',
             'foreign' => 'running_machine_id'));
        
        $this->hasMany('GamelogSlot as gamelog_slots', array(
             'local' => 'id',
             'foreign' => 'machine_id'));
    }
}