<?php

/**
 * BaseMachinesPjp
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $pjp_id
 * @property integer $running_machine_id
 * @property boolean $enabled
 * @property RunningSlot $RunningSlot
 * @property Pjp $Pjp
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6401 2009-09-24 16:12:04Z guilhermeblanco $
 */
abstract class BaseMachinesPjp extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('machines_pjp');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => '4',
             ));
        $this->hasColumn('pjp_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('running_machine_id', 'integer', 4, array(
             'type' => 'integer',
             'notnull' => true,
             'length' => '4',
             ));
        $this->hasColumn('enabled', 'boolean', null, array(
             'type' => 'boolean',
             ));

        $this->option('type', 'MyISAM');
    }

    public function setUp()
    {
        parent::setUp();
    $this->hasOne('RunningSlot', array(
             'local' => 'running_machine_id',
             'foreign' => 'id'));

        $this->hasOne('Pjp', array(
             'local' => 'pjp_id',
             'foreign' => 'id'));
    }
}