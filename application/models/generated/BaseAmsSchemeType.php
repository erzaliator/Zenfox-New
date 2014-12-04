<?php

/**
 * BaseAmsSchemeType
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $scheme_type
 * @property string $scheme_name
 * @property string $scheme_description
 * @property string $criteria
 * @property string $crediting_factor
 * @property Doctrine_Collection $account_details
 * @property Doctrine_Collection $affiliate_scheme_deves
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6401 2009-09-24 16:12:04Z guilhermeblanco $
 */
abstract class BaseAmsSchemeType extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('ams_scheme_types');
        $this->hasColumn('scheme_type', 'string', 10, array(
             'type' => 'string',
             'primary' => true,
             'fixed' => 1,
             'length' => '10',
             ));
        $this->hasColumn('scheme_name', 'string', 50, array(
             'type' => 'string',
             'fixed' => 1,
             'length' => '50',
             ));
        $this->hasColumn('scheme_description', 'string', 255, array(
             'type' => 'string',
             'fixed' => 1,
             'length' => '255',
             ));
        $this->hasColumn('criteria', 'string', 15, array(
             'type' => 'string',
             'fixed' => 1,
             'length' => '15',
             ));
        $this->hasColumn('crediting_factor', 'string', 30, array(
             'type' => 'string',
             'fixed' => 1,
             'length' => '30',
             ));

        $this->option('type', 'MyISAM');
    }

    public function setUp()
    {
        parent::setUp();
    $this->hasMany('AccountDetail as account_details', array(
             'local' => 'scheme_type',
             'foreign' => 'affiliate_scheme_type'));

        $this->hasMany('AffiliateSchemeDef as affiliate_scheme_deves', array(
             'local' => 'scheme_type',
             'foreign' => 'scheme_type'));
    }
}