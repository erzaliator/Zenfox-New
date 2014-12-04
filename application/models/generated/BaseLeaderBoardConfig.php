<?php

/**
 * BaseLeaderBoardConfig
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $leader_board_id
 * @property string $title
 * @property string $description
 * @property enum $game_type
 * @property string $flavour
 * @property enum $amount_type
 * @property enum $status
 * @property timestamp $start_time
 * @property timestamp $end_time
 * @property string $frontend_id
 * @property string $variable_data
 * @property timestamp $last_calculated_time
 * @property integer $no_of_teams
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7691 2011-02-04 15:43:29Z jwage $
 */
abstract class BaseLeaderBoardConfig extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('leader_board_config');
        $this->hasColumn('leader_board_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'fixed' => false,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('title', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             'fixed' => true,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('description', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             'fixed' => true,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('game_type', 'enum', 8, array(
             'type' => 'enum',
             'length' => 8,
             'fixed' => false,
             'unsigned' => false,
             'values' => 
             array(
              0 => 'RUMMY',
              1 => 'BINGO',
              2 => 'SLOTS',
              3 => 'ROULETTE',
              4 => 'KENO',
             ),
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('flavour', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             'fixed' => true,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('amount_type', 'enum', 5, array(
             'type' => 'enum',
             'length' => 5,
             'fixed' => false,
             'unsigned' => false,
             'values' => 
             array(
              0 => 'REAL',
              1 => 'BONUS',
              2 => 'BOTH',
              3 => 'FREE',
              4 => 'ALL',
             ),
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('status', 'enum', 9, array(
             'type' => 'enum',
             'length' => 9,
             'fixed' => false,
             'unsigned' => false,
             'values' => 
             array(
              0 => 'CREATED',
              1 => 'STARTED',
              2 => 'COMPLETED',
              3 => 'CANCELED',
             ),
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('start_time', 'timestamp', null, array(
             'type' => 'timestamp',
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('end_time', 'timestamp', null, array(
             'type' => 'timestamp',
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('frontend_id', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             'fixed' => true,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('variable_data', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             'fixed' => true,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('last_calculated_time', 'timestamp', null, array(
             'type' => 'timestamp',
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('no_of_teams', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        
    }
}