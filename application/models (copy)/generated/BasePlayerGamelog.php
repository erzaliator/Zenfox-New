<?php

/**
 * BasePlayerGamelog
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $player_id
 * @property string $game_flavour
 * @property integer $session_id
 * @property integer $game_id
 * @property string $currency
 * @property float $real_bet
 * @property float $bonus_bet
 * @property float $real_winnings
 * @property float $bonus_winnings
 * @property timestamp $start_time
 * @property enum $result
 * @property integer $rank
 * @property integer $frontend_id
 * @property float $free_bet
 * @property float $free_winnings
 * @property enum $amount_type
 * @property integer $tournament_id
 * @property integer $tier_id
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7691 2011-02-04 15:43:29Z jwage $
 */
abstract class BasePlayerGamelog extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('player_gamelog');
        $this->hasColumn('player_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'fixed' => false,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('game_flavour', 'string', 45, array(
             'type' => 'string',
             'length' => 45,
             'fixed' => true,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('session_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'fixed' => false,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('game_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'fixed' => false,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('currency', 'string', 3, array(
             'type' => 'string',
             'length' => 3,
             'fixed' => true,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('real_bet', 'float', null, array(
             'type' => 'float',
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('bonus_bet', 'float', null, array(
             'type' => 'float',
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('real_winnings', 'float', null, array(
             'type' => 'float',
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('bonus_winnings', 'float', null, array(
             'type' => 'float',
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('start_time', 'timestamp', null, array(
             'type' => 'timestamp',
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('result', 'enum', 8, array(
             'type' => 'enum',
             'length' => 8,
             'fixed' => false,
             'unsigned' => false,
             'values' => 
             array(
              0 => 'Winner',
              1 => 'Lost',
              2 => 'None',
              3 => 'Inactive',
              4 => 'Quit',
              5 => 'Timeout',
             ),
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('rank', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('frontend_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('free_bet', 'float', null, array(
             'type' => 'float',
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('free_winnings', 'float', null, array(
             'type' => 'float',
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('amount_type', 'enum', 8, array(
             'type' => 'enum',
             'length' => 8,
             'fixed' => false,
             'unsigned' => false,
             'values' => 
             array(
              0 => 'REAL',
              1 => 'BONUS',
              2 => 'FREE',
              3 => 'BOTH',
              4 => 'BOTHREAL',
             ),
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('tournament_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'default' => '0',
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('tier_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'default' => '0',
             'notnull' => true,
             'autoincrement' => false,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        
    }
}