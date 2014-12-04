<?php

/**
 * BaseCountry
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $country
 * @property string $country_code
 * @property integer $numcode
 * @property Doctrine_Collection $account
 * @property Doctrine_Collection $country_languages
 * @property Doctrine_Collection $country_currencies
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6401 2009-09-24 16:12:04Z guilhermeblanco $
 */
abstract class BaseCountry extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('country');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'length' => '4',
             ));
        $this->hasColumn('country', 'string', 100, array(
             'type' => 'string',
             'fixed' => 1,
             'length' => '100',
             ));
        $this->hasColumn('country_code', 'string', 2, array(
             'type' => 'string',
             'unique' => true,
             'fixed' => 1,
             'length' => '2',
             ));
        $this->hasColumn('numcode', 'integer', 4, array(
             'type' => 'integer',
             'unique' => true,
             'length' => '4',
             ));

        $this->option('type', 'MyISAM');
    }

    public function setUp()
    {
        parent::setUp();
    $this->hasMany('Account as account', array(
             'local' => 'country_code',
             'foreign' => 'country'));

        $this->hasMany('CountryLanguage as country_languages', array(
             'local' => 'country_code',
             'foreign' => 'country_code'));

        $this->hasMany('CountryCurrency as country_currencies', array(
             'local' => 'country_code',
             'foreign' => 'country_code'));
    }
}