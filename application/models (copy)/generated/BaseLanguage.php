<?php

/**
 * BaseLanguage
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $language
 * @property string $locale
 * @property Doctrine_Collection $account_details
 * @property Doctrine_Collection $country_languages
 * @property Doctrine_Collection $affiliates
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6401 2009-09-24 16:12:04Z guilhermeblanco $
 */
abstract class BaseLanguage extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('language');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'length' => '4',
             ));
        $this->hasColumn('language', 'string', 45, array(
             'type' => 'string',
             'fixed' => 1,
             'length' => '45',
             ));
        $this->hasColumn('locale', 'string', 7, array(
             'type' => 'string',
             'unique' => true,
             'fixed' => 1,
             'length' => '7',
             ));

        $this->option('type', 'MyISAM');
    }

    public function setUp()
    {
        parent::setUp();
    $this->hasMany('AccountDetail as account_details', array(
             'local' => 'locale',
             'foreign' => 'language'));

        $this->hasMany('CountryLanguage as country_languages', array(
             'local' => 'locale',
             'foreign' => 'locale'));

        $this->hasMany('Affiliate as affiliates', array(
             'local' => 'locale',
             'foreign' => 'language'));
    }
}