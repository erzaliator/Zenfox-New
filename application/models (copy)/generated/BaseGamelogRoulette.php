<?php

/**
 * BaseGamelogRoulette
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $log_id
 * @property integer $session_id
 * @property integer $player_id
 * @property integer $machine_id
 * @property integer $running_machine_id
 * @property string $game_flavour
 * @property clob $bet_string
 * @property float $bet_amount
 * @property integer $win_number
 * @property string $win_string
 * @property float $win_amount
 * @property timestamp $datetime
 * @property enum $amount_type
 * @property enum $pjp_winstatus
 * @property integer $pjp_id
 * @property integer $pjp_rng
 * @property float $pjp_win_amount
 * @property string $wagered_currency
 * @property integer $frontend_id
 * @property Account $Account
 * @property RunningRoulette $RunningRoulette
 * @property GamelogSession $GamelogSession
 * @property Currency $Currency
 * @property Pjp $Pjp
 * @property Frontend $Frontend
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6401 2009-09-24 16:12:04Z guilhermeblanco $
 */
abstract class BaseGamelogRoulette extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('gamelog_roulette');
        $this->hasColumn('log_id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => '4',
             ));
        $this->hasColumn('session_id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'length' => '4',
             ));
        $this->hasColumn('player_id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'length' => '4',
             ));
        $this->hasColumn('machine_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('running_machine_id', 'integer', 4, array(
             'type' => 'integer',
             'notnull' => true,
             'length' => '4',
             ));
        $this->hasColumn('game_flavour', 'string', 45, array(
             'type' => 'string',
             'notnull' => true,
             'fixed' => 1,
             'length' => '45',
             ));
        $this->hasColumn('bet_string', 'clob', 65535, array(
             'type' => 'clob',
             'length' => '65535',
             ));
        $this->hasColumn('bet_amount', 'float', null, array(
             'type' => 'float',
             ));
        $this->hasColumn('win_number', 'integer', 4, array(
             'type' => 'integer',
             'notnull' => true,
             'length' => '4',
             ));
        $this->hasColumn('win_string', 'string', 255, array(
             'type' => 'string',
             'fixed' => 1,
             'length' => '255',
             ));
        $this->hasColumn('win_amount', 'float', null, array(
             'type' => 'float',
             ));
        $this->hasColumn('datetime', 'timestamp', null, array(
             'type' => 'timestamp',
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
        $this->hasColumn('pjp_winstatus', 'enum', null, array(
             'type' => 'enum',
             'values' => 
             array(
              0 => 'WIN',
              1 => 'NOWIN',
             ),
             'default' => 'NOWIN',
             ));
        $this->hasColumn('pjp_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('pjp_rng', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('pjp_win_amount', 'float', null, array(
             'type' => 'float',
             ));
        $this->hasColumn('wagered_currency', 'string', 3, array(
             'type' => 'string',
             'fixed' => 1,
             'length' => '3',
             ));
        $this->hasColumn('frontend_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));

        $this->option('type', 'MyISAM');
    }

    public function setUp()
    {
        parent::setUp();
    $this->hasOne('Account', array(
             'local' => 'player_id',
             'foreign' => 'player_id'));

        $this->hasOne('RunningRoulette', array(
             'local' => 'machine_id',
             'foreign' => 'id'));

        $this->hasOne('GamelogSession', array(
             'local' => 'player_id',
             'foreign' => 'player_id'));

        $this->hasOne('Currency', array(
             'local' => 'wagered_currency',
             'foreign' => 'currency_code'));

        $this->hasOne('Pjp', array(
             'local' => 'pjp_id',
             'foreign' => 'id'));

        $this->hasOne('Frontend', array(
             'local' => 'frontend_id',
             'foreign' => 'id'));
    }
}