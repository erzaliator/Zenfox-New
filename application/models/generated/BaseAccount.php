<?php

/**
 * BaseAccount
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 *
 * @property integer $player_id
 * @property string $login
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $sex
 * @property date $dateofbirth
 * @property string $address
 * @property string $city
 * @property string $state
 * @property string $country
 * @property string $pin
 * @property string $phone
 * @property string $question
 * @property string $hint
 * @property string $answer
 * @property integer $newsletter
 * @property integer $promotions
 * @property integer $black_list
 * @property Country $Country
 * @property Doctrine_Collection $account_detail
 * @property Doctrine_Collection $no_payments
 * @property Doctrine_Collection $journals
 * @property Doctrine_Collection $gamelog_roulettes
 * @property integer $frontend_id
 *
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6401 2009-09-24 16:12:04Z guilhermeblanco $
 */

Doctrine_Manager::getInstance()->bindComponent('Account', 'master');
//abstract class BaseAccount extends Zenfox_Record
abstract class BaseAccount extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('account');
        $this->hasColumn('player_id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => '4',
             ));
        $this->hasColumn('login', 'string', 50, array(
             'type' => 'string',
             'notnull' => true,
             'fixed' => 1,
             'length' => '50',
             ));
        $this->hasColumn('first_name', 'string', 50, array(
             'type' => 'string',
             'notnull' => true,
             'fixed' => 1,
             'length' => '50',
             ));
        $this->hasColumn('last_name', 'string', 50, array(
             'type' => 'string',
             'notnull' => true,
             'fixed' => 1,
             'length' => '50',
             ));
        $this->hasColumn('email', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'fixed' => 1,
             'length' => '255',
             ));
        $this->hasColumn('sex', 'string', 1, array(
             'type' => 'string',
             'notnull' => true,
             'fixed' => 1,
             'length' => '1',
             ));
        $this->hasColumn('dateofbirth', 'date', null, array(
             'type' => 'date',
             'notnull' => true,
             ));
        $this->hasColumn('address', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'fixed' => 1,
             'length' => '255',
             ));
        $this->hasColumn('city', 'string', 50, array(
             'type' => 'string',
             'notnull' => true,
             'fixed' => 1,
             'length' => '50',
             ));
        $this->hasColumn('state', 'string', 50, array(
             'type' => 'string',
             'notnull' => true,
             'fixed' => 1,
             'length' => '50',
             ));
        $this->hasColumn('country', 'string', 2, array(
             'type' => 'string',
             'notnull' => true,
             'fixed' => 1,
             'length' => '2',
             ));
        $this->hasColumn('pin', 'string', 10, array(
             'type' => 'string',
             'notnull' => true,
             'fixed' => 1,
             'length' => '10',
             ));
        $this->hasColumn('phone', 'string', 20, array(
             'type' => 'string',
             'notnull' => true,
             'fixed' => 1,
             'length' => '20',
             ));
        $this->hasColumn('question', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'fixed' => 1,
             'length' => '255',
             ));
        $this->hasColumn('hint', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'fixed' => 1,
             'length' => '255',
             ));
        $this->hasColumn('answer', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'fixed' => 1,
             'length' => '255',
             ));
        $this->hasColumn('newsletter', 'integer', 1, array(
             'type' => 'integer',
             'notnull' => true,
             'default' => '1',
             'length' => '1',
             ));
        $this->hasColumn('promotions', 'integer', 1, array(
             'type' => 'integer',
             'notnull' => true,
             'default' => '1',
             'length' => '1',
             ));
        $this->hasColumn('black_list', 'integer', 1, array(
             'type' => 'integer',
             'notnull' => true,
             'length' => '1',
             ));
        
        $this->hasColumn('frontend_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'unsigned' => 0,
             'primary' => true,
             'autoincrement' => false,
        	));

        $this->option('charset', 'utf8');
        $this->option('type', 'MyISAM');
    }

    public function setUp()
    {
        parent::setUp();
    $this->hasOne('Country', array(
             'local' => 'country',
             'foreign' => 'country_code'));

        $this->hasMany('AccountDetail as account_detail', array(
             'local' => 'player_id',
             'foreign' => 'player_id'));

        $this->hasMany('NoPayment as no_payments', array(
             'local' => 'player_id',
             'foreign' => 'player_id'));

        $this->hasMany('Journal as journals', array(
             'local' => 'player_id',
             'foreign' => 'player_id'));

        $this->hasMany('GamelogRoulette as gamelog_roulettes', array(
             'local' => 'player_id',
             'foreign' => 'player_id'));
    }
}