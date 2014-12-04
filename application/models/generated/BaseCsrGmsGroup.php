<?php

/**
 * BaseCsrGmsGroup
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $csr_id
 * @property integer $gms_group_id
 * @property Csr $Csr
 * @property GmsGroup $GmsGroup
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6401 2009-09-24 16:12:04Z guilhermeblanco $
 */
abstract class BaseCsrGmsGroup extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('csr_gms_group');
        $this->hasColumn('csr_id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'length' => '4',
             ));
        $this->hasColumn('gms_group_id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'length' => '4',
             ));

        $this->option('type', 'MyISAM');
    }

    public function setUp()
    {
        parent::setUp();
    $this->hasOne('Csr', array(
             'local' => 'csr_id',
             'foreign' => 'id'));

        $this->hasOne('GmsGroup', array(
             'local' => 'gms_group_id',
             'foreign' => 'id'));
    }
}