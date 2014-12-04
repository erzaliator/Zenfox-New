<?php

/**
 * BaseEmailLog
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $list_id
 * @property integer $template_id
 * @property enum $language
 * @property string $args
 * @property integer $frontend_id
 * @property enum $status
 * @property enum $error
 * @property string $notes
 * @property emailList $list
 * @property frontend $frontend
 * @property emailTemplate $template
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6401 2009-09-24 16:12:04Z guilhermeblanco $
 */
abstract class BaseEmailLog extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('email_log');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'length' => '4',
             ));
        $this->hasColumn('list_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('template_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('language', 'enum', null, array(
             'type' => 'enum',
             'values' => 
             array(
              0 => 'PHP',
              1 => 'PYTHON',
              2 => 'JAVA',
             ),
             ));
        $this->hasColumn('args', 'string', 255, array(
             'type' => 'string',
             'fixed' => 1,
             'length' => '255',
             ));
        $this->hasColumn('frontend_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('status', 'enum', null, array(
             'type' => 'enum',
             'values' => 
             array(
              0 => 'PROCESSED',
              1 => 'UNPROCESSED',
             ),
             'default' => 'UNPROCESSED',
             ));
        $this->hasColumn('error', 'enum', null, array(
             'type' => 'enum',
             'values' => 
             array(
              0 => 'ERROR',
              1 => 'NO_ERROR',
             ),
             ));
        $this->hasColumn('notes', 'string', 255, array(
             'type' => 'string',
             'fixed' => 1,
             'length' => '255',
             ));


        $this->index('fk_list_id', array(
             'fields' => 
             array(
              0 => 'list_id',
             ),
             ));
        $this->index('fk_frontend_id', array(
             'fields' => 
             array(
              0 => 'frontend_id',
             ),
             ));
        $this->index('fk_template_id', array(
             'fields' => 
             array(
              0 => 'template_id',
             ),
             ));
        $this->option('collate', 'latin1_swedish_ci');
        $this->option('charset', 'latin1');
        $this->option('type', 'InnoDB');
    }

    public function setUp()
    {
        parent::setUp();
    $this->hasOne('emailList as list', array(
             'local' => 'list_id',
             'foreign' => 'id'));

        $this->hasOne('frontend', array(
             'local' => 'frontend_id',
             'foreign' => 'id'));

        $this->hasOne('emailTemplate as template', array(
             'local' => 'template_id',
             'foreign' => 'id'));
    }
}
