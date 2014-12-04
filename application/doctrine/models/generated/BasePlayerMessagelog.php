<?php

/**
 * BasePlayerMessagelog
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $player_id
 * @property integer $client_id
 * @property integer $app_id
 * @property integer $message_id
 * @property enum $message_type
 * @property string $message
 * @property timestamp $generated_time
 * @property enum $processed
 * @property timestamp $processed_time
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6401 2009-09-24 16:12:04Z guilhermeblanco $
 */
abstract class BasePlayerMessagelog extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('player_messagelog');
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
        $this->hasColumn('message_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'unsigned' => 0,
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('message_type', 'enum', 19, array(
             'type' => 'enum',
             'length' => 19,
             'fixed' => false,
             'values' => 
             array(
              0 => 'LEVEL_PROGRESSION',
              1 => 'COUPON_AWARDED',
              2 => 'BADGE_AWARDED',
              3 => 'TEMP',
              4 => 'XP_INCREMENT',
              5 => 'COUNTDOWN_STARTED',
              6 => 'APPOINTMENT_STARTED',
             ),
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('message', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             'fixed' => true,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('generated_time', 'timestamp', null, array(
             'type' => 'timestamp',
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('processed', 'enum', 11, array(
             'type' => 'enum',
             'length' => 11,
             'fixed' => false,
             'values' => 
             array(
              0 => 'PROCESSED',
              1 => 'UNPROCESSED',
             ),
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('processed_time', 'timestamp', null, array(
             'type' => 'timestamp',
             'primary' => false,
             'default' => '0000-00-00 00:00:00',
             'notnull' => true,
             'autoincrement' => false,
             ));
    }

}