<?php

/**
 * BaseGamificationBadges
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $client_id
 * @property integer $app_id
 * @property integer $badge_id
 * @property string $title
 * @property string $url
 * @property string $body
 * @property string $gamification_variable
 * @property integer $max_value
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6401 2009-09-24 16:12:04Z guilhermeblanco $
 */
abstract class BaseGamificationBadges extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('gamification_badges');
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
        $this->hasColumn('badge_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'unsigned' => 0,
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('title', 'string', 25, array(
             'type' => 'string',
             'length' => 25,
             'fixed' => true,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('url', 'string', 100, array(
             'type' => 'string',
             'length' => 100,
             'fixed' => true,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('body', 'string', 250, array(
             'type' => 'string',
             'length' => 250,
             'fixed' => true,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('gamification_variable', 'string', 50, array(
             'type' => 'string',
             'length' => 50,
             'fixed' => true,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('max_value', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'unsigned' => 0,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
    }

}