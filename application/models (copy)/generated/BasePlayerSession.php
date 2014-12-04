<?php

/**
 * BasePlayerSession
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $player_id
 * @property string $login
 * @property string $ip_address
 * @property timestamp $login_time
 * @property timestamp $last_activity
 * @property timestamp $session_expiry
 * @property string $phpsessid
 * @property integer $frontend_id
 * @property integer $player_frontend_id
 * @property AccountDetail $AccountDetail
 * @property Frontend $Frontend
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6401 2009-09-24 16:12:04Z guilhermeblanco $
 */
abstract class BasePlayerSession extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('player_sessions');
        $this->hasColumn('player_id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'length' => '4',
             ));
        $this->hasColumn('login', 'string', 50, array(
             'type' => 'string',
             'fixed' => 1,
             'length' => '50',
             ));
        $this->hasColumn('ip_address', 'string', 45, array(
             'type' => 'string',
             'fixed' => 1,
             'length' => '45',
             ));
        $this->hasColumn('login_time', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
        $this->hasColumn('last_activity', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
        $this->hasColumn('session_expiry', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
        $this->hasColumn('phpsessid', 'string', 255, array(
             'type' => 'string',
             'fixed' => 1,
             'length' => '255',
             ));
        $this->hasColumn('frontend_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('player_frontend_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));

        $this->option('type', 'MEMORY');
    }

    public function setUp()
    {
        parent::setUp();
    $this->hasOne('AccountDetail', array(
             'local' => 'player_frontend_id',
             'foreign' => 'frontend_id'));

        $this->hasOne('Frontend', array(
             'local' => 'frontend_id',
             'foreign' => 'id'));
    }
}