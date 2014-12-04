<?php

/**
 * BaseBonusScheme
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $scheme_id
 * @property string $name
 * @property string $description
 * @property Doctrine_Collection $account_details
 * @property Doctrine_Collection $frontends
 * @property Doctrine_Collection $AuditReport
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6401 2009-09-24 16:12:04Z guilhermeblanco $
 */
abstract class BaseBonusScheme extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('bonus_schemes');
        $this->hasColumn('scheme_id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => '4',
             ));
        $this->hasColumn('name', 'string', 45, array(
             'type' => 'string',
             'fixed' => 1,
             'length' => '45',
             ));
        $this->hasColumn('description', 'string', 255, array(
             'type' => 'string',
             'fixed' => 1,
             'length' => '255',
             ));

        $this->option('type', 'MyISAM');
    }

    public function setUp()
    {
        parent::setUp();
    $this->hasMany('AccountDetail as account_details', array(
             'local' => 'scheme_id',
             'foreign' => 'bonus_scheme_id'));

        $this->hasMany('Frontend as frontends', array(
             'local' => 'scheme_id',
             'foreign' => 'default_bonus_scheme_id'));

        $this->hasMany('AuditReport', array(
             'local' => 'id',
             'foreign' => 'bonus_scheme_id'));
    }
}