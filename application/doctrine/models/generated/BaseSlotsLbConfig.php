<?php

/**
 * BaseSlotsLbConfig
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $leader_board_id
 * @property string $title
 * @property string $game_type
 * @property string $flavour
 * @property enum $amount_type
 * @property enum $status
 * @property timestamp $start_time
 * @property timestamp $end_time
 * @property string $frontend_id
 * @property timestamp $last_calculated_time
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6401 2009-09-24 16:12:04Z guilhermeblanco $
 */
abstract class BaseSlotsLbConfig extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('slots_lb_config');
        $this->hasColumn('leader_board_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'unsigned' => 0,
             'primary' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('title', 'string', 100, array(
             'type' => 'string',
             'length' => 100,
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
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('flavour', 'string', 8000, array(
             'type' => 'string',
             'length' => 8000,
             'fixed' => false,
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
             ),
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('status', 'enum', 9, array(
             'type' => 'enum',
             'length' => 9,
             'fixed' => false,
             'values' => 
             array(
              0 => 'STARTED',
              1 => 'CREATED',
              2 => 'COMPLETED',
             ),
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('start_time', 'timestamp', null, array(
             'type' => 'timestamp',
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('end_time', 'timestamp', null, array(
             'type' => 'timestamp',
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('frontend_id', 'string', 100, array(
             'type' => 'string',
             'length' => 100,
             'fixed' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('last_calculated_time', 'timestamp', null, array(
             'type' => 'timestamp',
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
    }

}