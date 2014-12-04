<?php

/**
 * BaseCampaignList
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $group_id
 * @property integer $frontend_id
 * @property integer $template_id
 * @property enum $status
 * @property string $message
 * @property timestamp $email_req_time
 * @property timestamp $email_sent_time
 * @property string $campaign_name
 * @property integer $priority
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6401 2009-09-24 16:12:04Z guilhermeblanco $
 */
abstract class BaseCampaignList extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('campaign_list');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'unsigned' => 0,
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('group_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'unsigned' => 0,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('frontend_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'unsigned' => 0,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('template_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'unsigned' => 0,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('status', 'enum', 11, array(
             'type' => 'enum',
             'length' => 11,
             'fixed' => false,
             'values' => 
             array(
              0 => 'PROCESSED',
              1 => 'UNPROCESSED',
             ),
             'primary' => false,
             'default' => 'UNPROCESSED',
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('message', 'string', null, array(
             'type' => 'string',
             'fixed' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('email_req_time', 'timestamp', null, array(
             'type' => 'timestamp',
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('email_sent_time', 'timestamp', null, array(
             'type' => 'timestamp',
             'primary' => false,
             'default' => '0000-00-00 00:00:00',
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('campaign_name', 'string', 50, array(
             'type' => 'string',
             'length' => 50,
             'fixed' => true,
             'primary' => false,
             'default' => '',
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('priority', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'unsigned' => 0,
             'primary' => false,
             'default' => '5',
             'notnull' => true,
             'autoincrement' => false,
             ));
    }

}