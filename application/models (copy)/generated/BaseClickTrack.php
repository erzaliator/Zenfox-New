<?php

/**
 * BaseClickTrack
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $tracker_id
 * @property timestamp $hit_datetime
 * @property date $hit_date
 * @property string $ip_address
 * @property string $platform
 * @property string $user_agent
 * @property timestamp $next_datetime
 * @property integer $click_count
 * @property integer $frontend_id
 * @property string $param1
 * @property string $param2
 * @property AffiliateTracker $AffiliateTracker
 * @property Frontend $Frontend
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6401 2009-09-24 16:12:04Z guilhermeblanco $
 */
abstract class BaseClickTrack extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('click_track');
        $this->hasColumn('tracker_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             'primary' => true,
             ));
        $this->hasColumn('hit_datetime', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
        $this->hasColumn('hit_date', 'date', null, array(
             'type' => 'date',
             'primary' => true,
             ));
        $this->hasColumn('ip_address', 'string', 45, array(
             'type' => 'string',
             'primary' => true,
             'fixed' => 1,
             'length' => '45',
             ));
        $this->hasColumn('platform', 'string', 45, array(
             'type' => 'string',
             'fixed' => 1,
             'length' => '45',
             ));
        $this->hasColumn('user_agent', 'string', 45, array(
             'type' => 'string',
             'fixed' => 1,
             'length' => '45',
             ));
        $this->hasColumn('next_datetime', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
        $this->hasColumn('click_count', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('frontend_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             'primary' => true,
             ));
        $this->hasColumn('param1', 'string', 45, array(
             'type' => 'string',
             'fixed' => 1,
             'length' => '45',
             ));
        $this->hasColumn('param2', 'string', 45, array(
             'type' => 'string',
             'fixed' => 1,
             'length' => '45',
             ));


        $this->index('tracker_id', array(
             'fields' => 
             array(
             ),
             ));
        $this->option('type', 'MyISAM');
    }

    public function setUp()
    {
        parent::setUp();
    $this->hasOne('AffiliateTracker', array(
             'local' => 'tracker_id',
             'foreign' => 'tracker_id'));

        $this->hasOne('Frontend', array(
             'local' => 'frontend_id',
             'foreign' => 'id'));
    }
}
