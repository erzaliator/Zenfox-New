<?php

/**
 * BaseRoulette
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $machine_id
 * @property string $machine_name
 * @property string $game_flavour
 * @property enum $feature_round
 * @property enum $bonus_spins
 * @property integer $max_coins
 * @property integer $max_points
 * @property integer $min_coins
 * @property integer $min_points
 * @property enum $pjp
 * @property string $config_file
 * @property string $swf_file
 * @property Flavour $Flavour
 * @property Doctrine_Collection $running_roulettes
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6401 2009-09-24 16:12:04Z guilhermeblanco $
 */
abstract class BaseRoulette extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('roulette');
        $this->hasColumn('machine_id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'length' => '4',
             ));
        $this->hasColumn('machine_name', 'string', 45, array(
             'type' => 'string',
             'fixed' => 1,
             'length' => '45',
             ));
        $this->hasColumn('game_flavour', 'string', 45, array(
             'type' => 'string',
             'notnull' => true,
             'fixed' => 1,
             'length' => '45',
             ));
        $this->hasColumn('feature_round', 'enum', null, array(
             'type' => 'enum',
             'values' => 
             array(
              0 => 'ENABLED',
              1 => 'DISABLED',
             ),
             'default' => 'DISABLED',
             ));
        $this->hasColumn('bonus_spins', 'enum', null, array(
             'type' => 'enum',
             'values' => 
             array(
              0 => 'ENABLED',
              1 => 'DISABLED',
             ),
             'default' => 'DISABLED',
             ));
        $this->hasColumn('max_coins', 'integer', 2, array(
             'type' => 'integer',
             'length' => '2',
             ));
        $this->hasColumn('max_points', 'integer', 2, array(
             'type' => 'integer',
             'length' => '2',
             ));
        $this->hasColumn('min_coins', 'integer', 2, array(
             'type' => 'integer',
             'default' => '1',
             'length' => '2',
             ));
        $this->hasColumn('min_points', 'integer', 2, array(
             'type' => 'integer',
             'default' => '1',
             'length' => '2',
             ));
        $this->hasColumn('pjp', 'enum', null, array(
             'type' => 'enum',
             'values' => 
             array(
              0 => 'ENABLED',
              1 => 'DISABLED',
             ),
             'default' => 'DISABLED',
             ));
        $this->hasColumn('config_file', 'string', 255, array(
             'type' => 'string',
             'fixed' => 1,
             'length' => '255',
             ));
        $this->hasColumn('swf_file', 'string', 255, array(
             'type' => 'string',
             'fixed' => 1,
             'length' => '255',
             ));
        $this->hasColumn('description', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));

        $this->option('type', 'MyISAM');
    }

    public function setUp()
    {
        parent::setUp();
    $this->hasOne('Flavour', array(
             'local' => 'game_flavour',
             'foreign' => 'game_flavour'));

        $this->hasMany('RunningRoulette as running_roulettes', array(
             'local' => 'machine_id',
             'foreign' => 'machine_id'));
    }
}