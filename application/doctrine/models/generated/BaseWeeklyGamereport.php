<?php

/**
 * BaseWeeklyGamereport
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $machine_id
 * @property string $report_type
 * @property integer $fronted_id
 * @property string $data_type
 * @property string $value
 * @property string $start_time
 * @property string $end_time
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6401 2009-09-24 16:12:04Z guilhermeblanco $
 */
abstract class BaseWeeklyGamereport extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('weekly_gamereport');
        $this->hasColumn('machine_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'unsigned' => 0,
             'primary' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('report_type', 'string', 20, array(
             'type' => 'string',
             'length' => 20,
             'fixed' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('fronted_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'unsigned' => 0,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('data_type', 'string', 10, array(
             'type' => 'string',
             'length' => 10,
             'fixed' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('value', 'string', 8000, array(
             'type' => 'string',
             'length' => 8000,
             'fixed' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('start_time', 'string', 100, array(
             'type' => 'string',
             'length' => 100,
             'fixed' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('end_time', 'string', 100, array(
             'type' => 'string',
             'length' => 100,
             'fixed' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
    }

}