<?php

/**
 * BaseNewsletter
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $newsletter_id
 * @property string $email
 * @property integer $frontend_id
 * @property enum $subscribed
 * @property timestamp $subscription_date
 * @property timestamp $last_updated
 * @property string $extra_data
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6401 2009-09-24 16:12:04Z guilhermeblanco $
 */
abstract class BaseNewsletter extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('newsletter');
        $this->hasColumn('newsletter_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'unsigned' => 0,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('email', 'string', 45, array(
             'type' => 'string',
             'length' => 45,
             'fixed' => false,
             'primary' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('frontend_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'unsigned' => 0,
             'primary' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('subscribed', 'enum', 5, array(
             'type' => 'enum',
             'length' => 5,
             'fixed' => false,
             'values' => 
             array(
              0 => 'TRUE',
              1 => 'FALSE',
             ),
             'primary' => false,
             'default' => 'TRUE',
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('subscription_date', 'timestamp', null, array(
             'type' => 'timestamp',
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('last_updated', 'timestamp', null, array(
             'type' => 'timestamp',
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('extra_data', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             'fixed' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
    }

}